<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $session = session();
        $role = $session->get('role');

        $data['role'] = $role;

        if ($role === 'admin') {
            // --- DATA DASHBOARD ADMIN ---
            // 📚 Total Buku
            $data['totalBuku'] = $db->table('buku')->countAllResults();

            // 👥 Total Anggota
            $data['totalAnggota'] = $db->table('anggota')->countAllResults();

            // 📖 Buku Sedang Dipinjam
            $data['totalDipinjam'] = $db->table('peminjaman')
                ->where('status', 'Dipinjam')
                ->countAllResults();

            // 💰 Total Denda (Denda tercatat di tabel denda + denda berjalan dari peminjaman yang aktif)
            $totalDenda = 0;
            if ($db->tableExists('denda')) {
                $dendaFields = $db->getFieldNames('denda');
                $nominalField = '';
                if (in_array('total_denda', $dendaFields)) {
                    $nominalField = 'total_denda';
                } elseif (in_array('nominal', $dendaFields)) {
                    $nominalField = 'nominal';
                } elseif (in_array('denda', $dendaFields)) {
                    $nominalField = 'denda';
                } elseif (in_array('jumlah', $dendaFields)) {
                    $nominalField = 'jumlah';
                }

                if (!empty($nominalField)) {
                    $sumDenda = $db->table('denda')->selectSum($nominalField)->get()->getRowArray();
                    $totalDenda += (float)($sumDenda[$nominalField] ?? 0);
                }
            }

            // Tambahkan denda berjalan dari peminjaman aktif yang terlambat
            $dendaBerjalan = $db->query("
                SELECT SUM(DATEDIFF(CURDATE(), tanggal_kembali) * 2000) AS total
                FROM peminjaman
                WHERE status = 'Dipinjam'
                AND tanggal_kembali < CURDATE()
            ")->getRowArray();
            $totalDenda += (float)($dendaBerjalan['total'] ?? 0);

            $data['totalDenda'] = $totalDenda;

            // 🔥 Buku Paling Sering Dipinjam (Limit 5 dengan peminjaman terbanyak)
            $data['bukuTerpopuler'] = $db->table('peminjaman')
                ->select('buku.*, COUNT(peminjaman.id) as total_pinjam')
                ->join('buku', 'buku.id = peminjaman.buku_id')
                ->groupBy('peminjaman.buku_id')
                ->orderBy('total_pinjam', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();

            // 📈 Statistik Koleksi Berdasarkan DDC
            $data['ddcStats'] = $db->table('rak')
                ->select('rak.*, COUNT(buku.id) as jumlah_buku')
                ->join('buku', 'buku.rak_id = rak.id', 'left')
                ->groupBy('rak.id')
                ->orderBy('rak.kode_ddc', 'ASC')
                ->get()
                ->getResultArray();

            // 🆕 Buku Terbaru (Limit 5 buku terakhir ditambahkan)
            $data['bukuTerbaru'] = $db->table('buku')
                ->orderBy('id', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();

            // 🔄 Aktivitas Peminjaman Terbaru (Limit 5 aktivitas terakhir di perpustakaan)
            $data['aktivitasTerbaru'] = $db->table('peminjaman')
                ->select('peminjaman.*, anggota.nama as nama_anggota, buku.judul as judul_buku')
                ->join('anggota', 'anggota.id = peminjaman.anggota_id')
                ->join('buku', 'buku.id = peminjaman.buku_id')
                ->orderBy('peminjaman.id', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();

            // ⭐ Aktivitas Rating Terbaru
            $data['ratingTerbaru'] = $db->query("
                SELECT rating_buku.*, anggota.nama AS nama_anggota, buku.judul AS judul_buku
                FROM rating_buku
                JOIN anggota ON anggota.id = rating_buku.anggota_id
                JOIN buku ON buku.id = rating_buku.buku_id
                ORDER BY rating_buku.id DESC
                LIMIT 5
            ")->getResultArray();

            // 💬 Ulasan Terbaru
            $data['ulasanTerbaru'] = $db->query("
                SELECT ulasan_buku.*, anggota.nama AS nama_anggota, buku.judul AS judul_buku, rating_buku.rating
                FROM ulasan_buku
                JOIN anggota ON anggota.id = ulasan_buku.anggota_id
                JOIN buku ON buku.id = ulasan_buku.buku_id
                LEFT JOIN rating_buku ON (
                    (rating_buku.peminjaman_id = ulasan_buku.peminjaman_id)
                    OR
                    (ulasan_buku.peminjaman_id IS NULL AND rating_buku.peminjaman_id IS NULL AND rating_buku.buku_id = ulasan_buku.buku_id AND rating_buku.anggota_id = ulasan_buku.anggota_id)
                )
                ORDER BY ulasan_buku.id DESC
                LIMIT 5
            ")->getResultArray();

        } else {
            // --- DATA DASHBOARD ANGGOTA ---
            $anggotaId = $session->get('anggota_id');

            // 📚 Rekomendasi Buku (Ordered by average rating DESC, then by access frequency DESC)
            $data['rekomendasi'] = $db->table('buku')
                ->select('buku.*, COALESCE(AVG(rating_buku.rating), 0) as avg_rating')
                ->join('rating_buku', 'rating_buku.buku_id = buku.id', 'left')
                ->groupBy('buku.id')
                ->orderBy('avg_rating', 'DESC')
                ->orderBy('buku.dibaca_count', 'DESC')
                ->limit(4)
                ->get()
                ->getResultArray();

            // ✨ Koleksi Terbaru (Baru ditambahkan, limit 4)
            $data['koleksiTerbaru'] = $db->table('buku')
                ->orderBy('id', 'DESC')
                ->limit(4)
                ->get()
                ->getResultArray();

            // ❤️ Buku Favorit Saya (Maksimal 4 buku favorit pengguna)
            $data['favoritSaya'] = [];
            if ($anggotaId) {
                $data['favoritSaya'] = $db->table('favorit')
                    ->select('buku.*')
                    ->join('buku', 'buku.id = favorit.buku_id')
                    ->where('favorit.anggota_id', $anggotaId)
                    ->orderBy('favorit.id', 'DESC')
                    ->limit(4)
                    ->get()
                    ->getResultArray();
            }

            // 📖 Sedang Dipinjam
            $data['sedangDipinjam'] = [];
            if ($anggotaId) {
                $data['sedangDipinjam'] = $db->table('peminjaman')
                    ->select('peminjaman.*, buku.judul, buku.penulis, buku.cover, buku.foto')
                    ->join('buku', 'buku.id = peminjaman.buku_id')
                    ->where('peminjaman.anggota_id', $anggotaId)
                    ->where('peminjaman.status', 'Dipinjam')
                    ->orderBy('peminjaman.id', 'DESC')
                    ->get()
                    ->getResultArray();
            }
        }

        return view('home', $data);
    }

    public function visi()
    {
        $session = session();
        $data['role'] = $session->get('role');
        return view('visi', $data);
    }

    public function misi()
    {
        $session = session();
        $data['role'] = $session->get('role');
        return view('misi', $data);
    }
}