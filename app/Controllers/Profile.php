<?php

namespace App\Controllers;

use App\Models\AnggotaModel;

class Profile extends BaseController
{
    /**
     * Menampilkan halaman Profil Anggota + Statistik Denda
     */
        public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $role = session()->get('role');
        $anggotaModel = new AnggotaModel();

        $anggota = null;
        $totalPinjam = 0;
        $sedangDipinjam = 0;
        $sudahKembali = 0;
        $totalDenda = 0;
        $totalBuku = 0;
        $totalAnggota = 0;

        if ($role == 'anggota') {
            $anggotaId = session()->get('anggota_id');
            $anggota = $anggotaModel->find($anggotaId);
            
            $db = \Config\Database::connect();
            
            if ($db->tableExists('peminjaman')) {
                // Deteksi kolom dinamis
                $fields = $db->getFieldNames('peminjaman');
                $builder = $db->table('peminjaman');
                
                $hasCondition = false;
                if (in_array('anggota_id', $fields)) {
                    $builder->where('anggota_id', $anggotaId);
                    $hasCondition = true;
                }
                if (in_array('id_anggota', $fields)) {
                    if ($hasCondition) {
                        $builder->orWhere('id_anggota', $anggotaId);
                    } else {
                        $builder->where('id_anggota', $anggotaId);
                        $hasCondition = true;
                    }
                }
                if (in_array('nama', $fields)) {
                    if ($hasCondition) {
                        $builder->orWhere('nama', $anggota['nama'] ?? '');
                    } else {
                        $builder->where('nama', $anggota['nama'] ?? '');
                        $hasCondition = true;
                    }
                }
                
                if (!$hasCondition) {
                    $builder->where('1=0');
                }
                
                $transaksi = $builder->get()->getResultArray();
                
                // Hitung statistik peminjaman dan denda
                $totalPinjam = count($transaksi);
                foreach ($transaksi as $t) {
                    $status = strtolower($t['status'] ?? '');
                    if ($status == 'dipinjam' || $status == 'belum kembali' || empty($t['tanggal_kembali'])) {
                        $sedangDipinjam++;
                    } else {
                        $sudahKembali++;
                    }

                    // Hitung denda tercatat & denda berjalan secara dinamis
                    $tanggalKembali = !empty($t['tanggal_kembali']) ? strtotime($t['tanggal_kembali']) : 0;
                    $today = strtotime(date('Y-m-d'));

                    if ($status == 'dipinjam' && $tanggalKembali > 0 && $today > $tanggalKembali) {
                        $selisihDetik = $today - $tanggalKembali;
                        $selisihHari = floor($selisihDetik / (60 * 60 * 24));
                        $totalDenda += ($selisihHari * 1000);
                    } else {
                        $dendaRecord = isset($t['denda']) ? $t['denda'] : (isset($t['nominal_denda']) ? $t['nominal_denda'] : 0);
                        $totalDenda += (int)$dendaRecord;
                    }
                }
            }

            // Ambil data progress membaca ebook yang sedang aktif
            $progressMembaca = [];
            if ($db->tableExists('membaca_progress') && $db->tableExists('buku')) {
                $progressMembaca = $db->table('membaca_progress')
                                      ->select('membaca_progress.*, buku.judul, buku.foto, buku.cover, buku.penulis, buku.jenis_koleksi, (SELECT judul_bab FROM ebook_bab WHERE ebook_bab.buku_id = membaca_progress.buku_id AND ebook_bab.nomor_bab = membaca_progress.nomor_bab LIMIT 1) as judul_bab')
                                      ->join('buku', 'buku.id = membaca_progress.buku_id')
                                      ->where('membaca_progress.anggota_id', $anggotaId)
                                      ->orderBy('membaca_progress.updated_at', 'DESC')
                                      ->get()
                                      ->getResultArray();
            }
        } else {
            // Jika login sebagai admin, tampilkan profil admin dummy/simulasi
            $anggota = [
                'nama' => 'Administrator PawLib',
                'username' => 'admin',
                'gmail' => 'admin@pawlib.com',
                'nomor' => '0812-3456-7890',
                'tanggal_bergabung' => '2026-01-01',
                'foto' => ''
            ];
            
            // Statistik global perpustakaan untuk admin
            $db = \Config\Database::connect();
            $totalBuku = $db->tableExists('buku') ? $db->table('buku')->countAll() : 0;
            $totalAnggota = $db->tableExists('anggota') ? $db->table('anggota')->countAll() : 0;

            if ($db->tableExists('peminjaman')) {
                $sedangDipinjam = $db->table('peminjaman')->where('status', 'Dipinjam')->countAllResults();
                
                // Hitung denda global (termasuk denda berjalan)
                $allPinjam = $db->table('peminjaman')->get()->getResultArray();
                foreach ($allPinjam as $t) {
                    $status = strtolower($t['status'] ?? '');
                    $tanggalKembali = !empty($t['tanggal_kembali']) ? strtotime($t['tanggal_kembali']) : 0;
                    $today = strtotime(date('Y-m-d'));

                    if ($status == 'dipinjam' && $tanggalKembali > 0 && $today > $tanggalKembali) {
                        $selisihDetik = $today - $tanggalKembali;
                        $selisihHari = floor($selisihDetik / (60 * 60 * 24));
                        $totalDenda += ($selisihHari * 1000);
                    } else {
                        $totalDenda += (int)($t['denda'] ?? 0);
                    }
                }
            }
        }

        // Jika data profil anggota kosong
        if (!$anggota) {
            $anggota = [
                'nama' => session()->get('nama') ?? 'Anggota PawLib',
                'username' => session()->get('username') ?? 'member',
                'gmail' => 'member@pawlib.com',
                'nomor' => '-',
                'tanggal_bergabung' => date('Y-m-d'),
                'foto' => ''
            ];
        }

        $data = [
            'title'           => 'Profil Saya - PawLib 🐾',
            'anggota'         => $anggota,
            'role'            => $role,
            'total_pinjam'    => $totalPinjam,
            'sedang_dipinjam' => $sedangDipinjam,
            'sudah_kembali'   => $sudahKembali,
            'total_denda'     => $totalDenda,
            'total_buku'      => $totalBuku,
            'total_anggota'   => $totalAnggota,
            'progressMembaca' => $progressMembaca ?? []
        ];

        return view('profile', $data);
    }

    /**
     * Menampilkan Halaman Riwayat Peminjaman + Informasi Denda
     */
    public function riwayat()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $role = session()->get('role');
        if ($role != 'anggota') {
            return redirect()->to('/profile')->with('error', 'Hanya anggota yang memiliki riwayat peminjaman pribadi.');
        }

        $anggotaId = session()->get('anggota_id');
        $anggotaModel = new AnggotaModel();
        $anggota = $anggotaModel->find($anggotaId);

        $keyword = $this->request->getGet('keyword');

        $riwayat = [];
        $db = \Config\Database::connect();
        
        if ($db->tableExists('peminjaman')) {
            $fields = $db->getFieldNames('peminjaman');
            
            // Cek jika denda disimpan di tabel terpisah
            $hasDendaTable = $db->tableExists('denda');
            
            $builder = $db->table('peminjaman')
                          ->select('peminjaman.*, buku.judul, buku.foto, rating_buku.rating, ulasan_buku.ulasan, ulasan_buku.id as ulasan_id')
                          ->join('buku', 'buku.id = peminjaman.buku_id', 'left')
                          ->join('rating_buku', 'rating_buku.peminjaman_id = peminjaman.id', 'left')
                          ->join('ulasan_buku', 'ulasan_buku.peminjaman_id = peminjaman.id', 'left')
                          ->groupStart();
            
            $hasCondition = false;
            if (in_array('anggota_id', $fields)) {
                $builder->where('peminjaman.anggota_id', $anggotaId);
                $hasCondition = true;
            }
            if (in_array('id_anggota', $fields)) {
                if ($hasCondition) {
                    $builder->orWhere('peminjaman.id_anggota', $anggotaId);
                } else {
                    $builder->where('peminjaman.id_anggota', $anggotaId);
                    $hasCondition = true;
                }
            }
            if (in_array('nama', $fields)) {
                if ($hasCondition) {
                    $builder->orWhere('peminjaman.nama', $anggota['nama'] ?? '');
                } else {
                    $builder->where('peminjaman.nama', $anggota['nama'] ?? '');
                    $hasCondition = true;
                }
            }
            
            if (!$hasCondition) {
                $builder->where('1=0');
            }
            
            $builder->groupEnd();
            
            if (!empty($keyword)) {
                $builder->groupStart()
                        ->like('buku.judul', $keyword)
                        ->orLike('buku.penulis', $keyword)
                        ->orLike('peminjaman.status', $keyword)
                        ->groupEnd();
            }
            
            // Jika ada tabel denda terpisah, lakukan JOIN untuk menarik info nominal denda
            if ($hasDendaTable && !in_array('denda', $fields)) {
                $dendaFields = $db->getFieldNames('denda');
                $nominalField = in_array('nominal', $dendaFields) ? 'nominal' : (in_array('denda', $dendaFields) ? 'denda' : (in_array('jumlah', $dendaFields) ? 'jumlah' : ''));
                if (!empty($nominalField)) {
                    $builder->select('denda.' . $nominalField . ' as nominal_denda')
                            ->join('denda', 'denda.peminjaman_id = peminjaman.id', 'left');
                }
            }
            
            $riwayat = $builder->orderBy('peminjaman.id', 'DESC')
                               ->get()
                               ->getResultArray();

            // Hitung denda berjalan secara dinamis untuk buku yang belum dikembalikan di riwayat
            foreach ($riwayat as &$r) {
                $status = strtolower($r['status'] ?? '');
                $tanggalKembali = !empty($r['tanggal_kembali']) ? strtotime($r['tanggal_kembali']) : 0;
                $today = strtotime(date('Y-m-d'));

                if ($status == 'dipinjam' && $tanggalKembali > 0 && $today > $tanggalKembali) {
                    $selisihDetik = $today - $tanggalKembali;
                    $selisihHari = floor($selisihDetik / (60 * 60 * 24));
                    $r['denda'] = $selisihHari * 2000;
                }
            }
            unset($r);
        }

        $data = [
            'title'   => 'Riwayat Peminjaman Saya - PawLib 🐾',
            'riwayat' => $riwayat,
            'keyword' => $keyword
        ];

        return view('riwayat_saya', $data);
    }

    /**
     * Memproses update data profil
     */
        public function update()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $role = session()->get('role');
        if ($role != 'anggota') {
            return redirect()->to('/profile')->with('error', 'Hanya anggota yang dapat memperbarui profil.');
        }

        $anggotaId = session()->get('anggota_id');

        $nama = $this->request->getPost('nama');
        $gmail = $this->request->getPost('gmail');
        $nomor = $this->request->getPost('nomor');
        
        $updateData = [
            'nama'  => $nama,
            'gmail' => $gmail,
            'nomor' => $nomor
        ];

        $fileFoto = $this->request->getFile('foto_profil');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaBaru = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/profile/', $namaBaru);
            $updateData['foto'] = $namaBaru;
        }

        // UPDATE LANGSUNG LEWAT QUERY BUILDER (Menghindari batasan allowedFields Model)
        $db = \Config\Database::connect();
        $db->table('anggota')
           ->where('id', $anggotaId)
           ->update($updateData);

        // Update session agar perubahan langsung tampil global
        session()->set('nama', $nama);
        if (isset($updateData['foto'])) {
            session()->set('foto', $updateData['foto']);
        }

        return redirect()->to('/profile')->with('success', 'Profil Anda berhasil diperbarui! 🐾');
    }

    /**
     * Menampilkan Halaman Ulasan Saya (Khusus Anggota)
     */
    public function ulasan()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $role = session()->get('role');
        if ($role != 'anggota') {
            return redirect()->to('/profile')->with('error', 'Hanya anggota yang memiliki daftar ulasan pribadi.');
        }

        $anggotaId = session()->get('anggota_id');
        $anggotaModel = new \App\Models\AnggotaModel();
        $anggota = $anggotaModel->find($anggotaId);

        $keyword = $this->request->getGet('keyword');

        $db = \Config\Database::connect();
        
        $builder = $db->table('rating_buku')
                      ->select('rating_buku.*, buku.judul, buku.cover, buku.foto, ulasan_buku.ulasan, ulasan_buku.id as ulasan_id')
                      ->join('buku', 'buku.id = rating_buku.buku_id')
                      ->join('ulasan_buku', '(ulasan_buku.peminjaman_id = rating_buku.peminjaman_id OR (rating_buku.peminjaman_id IS NULL AND ulasan_buku.peminjaman_id IS NULL AND ulasan_buku.buku_id = rating_buku.buku_id AND ulasan_buku.anggota_id = rating_buku.anggota_id))', 'left')
                      ->where('rating_buku.anggota_id', $anggotaId);

        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('buku.judul', $keyword)
                    ->orLike('buku.penulis', $keyword)
                    ->orLike('ulasan_buku.ulasan', $keyword)
                    ->groupEnd();
        }

        $ulasanSaya = $builder->orderBy('rating_buku.id', 'DESC')->get()->getResultArray();

        $data = [
            'title'      => 'Ulasan Saya - PawLib 🐾',
            'anggota'    => $anggota,
            'ulasanSaya' => $ulasanSaya,
            'keyword'    => $keyword
        ];

        return view('ulasan_saya', $data);
    }
}