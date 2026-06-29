<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\FavoritModel;

class Katalog extends BaseController
{
    // Halaman Utama Katalog (Card Layout + Pagination)
    public function index()
    {
        $model = new BukuModel();

        $keyword = $this->request->getGet('keyword');
        $ddc = $this->request->getGet('ddc');
        $jenisKoleksi = $this->request->getGet('jenis_koleksi');
        $bahasa = $this->request->getGet('bahasa');

        if ($keyword) {
            $model->groupStart()
                  ->like('judul', $keyword)
                  ->orLike('penulis', $keyword)
                  ->groupEnd();
        }

        if ($ddc) {
            $model->where('rak_id', $ddc);
        }

        if ($jenisKoleksi) {
            $model->where('jenis_koleksi', $jenisKoleksi);
        }

        if ($bahasa) {
            $model->where('bahasa', $bahasa);
        }

        $data['keyword'] = $keyword;
        $data['ddc_filter'] = $ddc;
        $data['jenis_koleksi_filter'] = $jenisKoleksi;
        $data['bahasa_filter'] = $bahasa;
        
        // Paginasi: 6 buku per halaman untuk grup 'katalog'
        $data['buku'] = $model->paginate(6, 'katalog');
        $data['pager'] = $model->pager;

        // Fetch distinct languages from database to populate the language select dropdown combined with standard fallbacks
        $standardLanguages = ['Indonesia', 'Inggris', 'Arab', 'Mandarin', 'Jepang', 'Korea', 'Jerman', 'Prancis'];
        $db = \Config\Database::connect();
        $dbLanguages = $db->table('buku')
                          ->select('bahasa')
                          ->where('bahasa IS NOT NULL')
                          ->where("bahasa != ''")
                          ->distinct()
                          ->get()
                          ->getResultArray();
        
        $languages = $standardLanguages;
        foreach ($dbLanguages as $row) {
            $lang = trim($row['bahasa']);
            if ($lang !== '' && !in_array($lang, $languages)) {
                $languages[] = $lang;
            }
        }
        sort($languages);
        $data['bahasaList'] = $languages;

        // Ambil list ID buku favorit & wishlist milik anggota jika sudah login
        $favoritIds = [];
        $wishlistIds = [];
        if (session()->get('role') == 'anggota') {
            $anggotaId = session()->get('anggota_id');
            
            $favoritModel = new FavoritModel();
            $favoritList = $favoritModel->where('anggota_id', $anggotaId)->findAll();
            $favoritIds = array_column($favoritList, 'buku_id');

            $wishlistModel = new \App\Models\WishlistModel();
            $wishlistList = $wishlistModel->where('anggota_id', $anggotaId)->findAll();
            $wishlistIds = array_column($wishlistList, 'buku_id');
        }
        $data['favoritIds'] = $favoritIds;
        $data['wishlistIds'] = $wishlistIds;

        return view('katalog', $data);
    }

    // Halaman Detail Buku
        public function detail($id = null)
    {
        $model = new BukuModel();
        $buku = $model->find($id);

        if (!$buku) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Buku dengan ID $id tidak ditemukan.");
        }

        $data['buku'] = $buku;

        // Ambil data Buku Serupa berdasarkan DDC / rak_id yang sama
        $data['bukuSerupa'] = $model->select('buku.*, rak.kode_ddc, rak.nama_rak')
                                    ->join('rak', 'rak.id = buku.rak_id', 'left')
                                    ->where('buku.rak_id', $buku['rak_id'])
                                    ->where('buku.id !=', $id)
                                    ->orderBy('CASE WHEN buku.stok > 0 THEN 1 ELSE 0 END', 'DESC', false)
                                    ->orderBy('buku.id', 'DESC')
                                    ->findAll(4);

        $db = \Config\Database::connect();

        $ratingInfo = $db->table('rating_buku')
                         ->select('COUNT(id) as total_rating, AVG(rating) as rata_rata')
                         ->where('buku_id', $id)
                         ->get()
                         ->getRowArray();

        $data['totalRating'] = (int) ($ratingInfo['total_rating'] ?? 0);
        $data['ratingRataRata'] = $data['totalRating'] > 0 ? number_format((float)$ratingInfo['rata_rata'], 1, '.', '') : '0';

        // 2. Distribusi Bintang (1 - 5) untuk Progress Bar
        $distribusi = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        $distQuery = $db->table('rating_buku')
                        ->select('rating, COUNT(id) as jumlah')
                        ->where('buku_id', $id)
                        ->groupBy('rating')
                        ->get()
                        ->getResultArray();

        foreach ($distQuery as $row) {
            $distribusi[(int)$row['rating']] = (int)$row['jumlah'];
        }
        $data['distribusiRating'] = $distribusi;

        // 3. Ulasan Pembaca dengan Opsi Pengurutan (Default: Terbaru)
        $sortBy = $this->request->getGet('sort_ulasan') ?? 'terbaru';
        $orderSql = "ORDER BY ulasan_buku.created_at DESC"; // Default: Terbaru
        
        if ($sortBy === 'tertinggi') {
            $orderSql = "ORDER BY rating_buku.rating DESC, ulasan_buku.created_at DESC";
        }

        $data['ulasanList'] = $db->query("
            SELECT ulasan_buku.*, anggota.nama AS nama_anggota, rating_buku.rating
            FROM ulasan_buku
            JOIN anggota ON anggota.id = ulasan_buku.anggota_id
            LEFT JOIN rating_buku ON (
                rating_buku.peminjaman_id = ulasan_buku.peminjaman_id 
                OR (rating_buku.peminjaman_id IS NULL AND ulasan_buku.peminjaman_id IS NULL AND rating_buku.buku_id = ulasan_buku.buku_id AND rating_buku.anggota_id = ulasan_buku.anggota_id)
            )
            WHERE ulasan_buku.buku_id = ?
            $orderSql
        ", [$id])->getResultArray();
        
        $data['sort_ulasan'] = $sortBy;

        $ebookStats = [
            'total_readers' => 0,
            'completed_readers' => 0,
            'avg_progress' => 0
        ];
        if (($buku['jenis_koleksi'] ?? '') === 'ebook') {
            $stats = $db->table('membaca_progress')
                        ->select('COUNT(id) as total, SUM(CASE WHEN progress_persen = 100 THEN 1 ELSE 0 END) as completed, AVG(progress_persen) as avg_prog')
                        ->where('buku_id', $id)
                        ->get()
                        ->getRowArray();
            
            $ebookStats['total_readers'] = (int)($stats['total'] ?? 0);
            $ebookStats['completed_readers'] = (int)($stats['completed'] ?? 0);
            $ebookStats['avg_progress'] = $ebookStats['total_readers'] > 0 ? number_format((float)$stats['avg_prog'], 1, '.', '') : '0';
        }
        $data['ebookStats'] = $ebookStats;

        // Check if member has already rated or read this ebook
        $existingEbookRating = null;
        $existingEbookUlasan = null;
        $myProgress = null;
        if (session()->get('role') == 'anggota') {
            $anggotaId = session()->get('anggota_id');
            $existingEbookRating = $db->table('rating_buku')
                                      ->where('buku_id', $id)
                                      ->where('anggota_id', $anggotaId)
                                      ->where('peminjaman_id IS NULL')
                                      ->get()
                                      ->getRowArray();
            $existingEbookUlasan = $db->table('ulasan_buku')
                                      ->where('buku_id', $id)
                                      ->where('anggota_id', $anggotaId)
                                      ->where('peminjaman_id IS NULL')
                                      ->get()
                                      ->getRowArray();
            $myProgress = $db->table('membaca_progress')
                             ->where('buku_id', $id)
                             ->where('anggota_id', $anggotaId)
                             ->get()
                             ->getRowArray();
        }
        $data['existingEbookRating'] = $existingEbookRating;
        $data['existingEbookUlasan'] = $existingEbookUlasan;
        $data['myProgress'] = $myProgress;

        // Fetch distinct languages for the search bar dropdown
        $standardLanguages = ['Indonesia', 'Inggris', 'Arab', 'Mandarin', 'Jepang', 'Korea', 'Jerman', 'Prancis'];
        $dbLanguages = $db->table('buku')
                          ->select('bahasa')
                          ->where('bahasa IS NOT NULL')
                          ->where("bahasa != ''")
                          ->distinct()
                          ->get()
                          ->getResultArray();
        
        $languages = $standardLanguages;
        foreach ($dbLanguages as $row) {
            $lang = trim($row['bahasa']);
            if ($lang !== '' && !in_array($lang, $languages)) {
                $languages[] = $lang;
            }
        }
        sort($languages);
        $data['bahasaList'] = $languages;

        return view('detail_buku', $data);
    }
}