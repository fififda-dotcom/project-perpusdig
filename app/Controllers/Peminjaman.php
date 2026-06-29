<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;

class Peminjaman extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $keyword = $this->request->getGet('keyword');

        $queryStr = "
            SELECT
                peminjaman.*,
                anggota.nama AS nama_anggota,
                buku.judul AS judul_buku
            FROM peminjaman
            LEFT JOIN anggota ON anggota.id = peminjaman.anggota_id
            LEFT JOIN buku ON buku.id = peminjaman.buku_id
        ";

        $params = [];
        if (!empty($keyword)) {
            $queryStr .= " WHERE anggota.nama LIKE ? OR buku.judul LIKE ? OR peminjaman.status LIKE ? ";
            $params[] = '%' . $keyword . '%';
            $params[] = '%' . $keyword . '%';
            $params[] = '%' . $keyword . '%';
        }

        $queryStr .= " ORDER BY peminjaman.id DESC ";

        $data['peminjaman'] = $db->query($queryStr, $params)->getResultArray();
        $data['keyword'] = $keyword;

        return view('peminjaman', $data);
    }

    public function tambah($id)
    {
        $bukuModel = new \App\Models\BukuModel();

        $data = [
            'buku' => $bukuModel->find($id)
        ];

        return view('tambah_peminjaman', $data);
    }

    public function simpan()
    {
        $model = new PeminjamanModel();
        $db = \Config\Database::connect();

        $nama = $this->request->getPost('nama');
        $tanggalPinjam = $this->request->getPost('tanggal_pinjam');

        $anggota = $db->table('anggota')
            ->where('nama', $nama)
            ->get()
            ->getRowArray();

        if (!$anggota) {
            return redirect()->back()->withInput()->with(
                'error',
                'Nama tidak terdaftar sebagai anggota PawLib.'
            );
        }

        $model->save([
            'anggota_id' => $anggota['id'],
            'nama' => $nama,
            'buku_id' => $this->request->getPost('buku_id'),
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => date(
                'Y-m-d',
                strtotime($tanggalPinjam . ' +7 days')
            ),
            'status' => 'Dipinjam'
        ]);

        $db->table('buku')
            ->set('stok', 'stok-1', false)
            ->set('dibaca_count', 'dibaca_count + 1', false)
            ->where('id', $this->request->getPost('buku_id'))
            ->update();

        // Alihkan halaman berdasarkan role login pengguna
        if (session()->get('role') == 'anggota') {
            return redirect()->to('/profile/riwayat')->with('success', 'Buku berhasil dipinjam! 🐾');
        }

        return redirect()->to('/peminjaman');
    }

        public function kembalikan($id)
    {
        $db = \Config\Database::connect();

        $pinjam = $db->table('peminjaman')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$pinjam) {
            return redirect()->to('/pengembalian')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Hitung denda jika terlambat mengembalikan (Rp 2.000 per hari)
        $tanggalKembali = strtotime($pinjam['tanggal_kembali']);
        $tanggalDikembalikan = strtotime(date('Y-m-d'));
        
        $denda = 0;
        if ($tanggalDikembalikan > $tanggalKembali) {
            $selisihDetik = $tanggalDikembalikan - $tanggalKembali;
            $selisihHari = floor($selisihDetik / (60 * 60 * 24));
            $denda = $selisihHari * 2000;
        }

        $updateData = [
            'status' => 'Selesai',
            'tanggal_dikembalikan' => date('Y-m-d')
        ];
        // Deteksi secara dinamis apakah kolom denda ada di tabel peminjaman
        $peminjamanFields = $db->getFieldNames('peminjaman');
        if (in_array('denda', $peminjamanFields)) {
            $updateData['denda'] = $denda;
        }

        // Jalankan update tabel peminjaman
        $db->table('peminjaman')
            ->where('id', $id)
            ->update($updateData);

        // Jika denda > 0 dan ada tabel denda terpisah, masukkan data denda ke tabel denda
        if ($denda > 0 && $db->tableExists('denda')) {
            $dendaFields = $db->getFieldNames('denda');
            $nominalField = in_array('nominal', $dendaFields) ? 'nominal' : (in_array('denda', $dendaFields) ? 'denda' : (in_array('jumlah', $dendaFields) ? 'jumlah' : ''));
            
            if (!empty($nominalField)) {
                $db->table('denda')->insert([
                    'peminjaman_id' => $id,
                    $nominalField   => $denda
                ]);
            }
        }

        $db->table('buku')
            ->set('stok', 'stok+1', false)
            ->where('id', $pinjam['buku_id'])
            ->update();

        // Fetch book info for user notification
        $buku = $db->table('buku')
            ->where('id', $pinjam['buku_id'])
            ->get()
            ->getRowArray();

        // Insert notification for the user
        $db->table('notifikasi')->insert([
            'user_id' => $pinjam['anggota_id'],
            'role' => 'anggota',
            'judul' => 'Pengembalian Buku Berhasil',
            'pesan' => 'Pengembalian buku "' . ($buku['judul'] ?? 'Buku') . '" berhasil diverifikasi oleh Admin. ' . ($denda > 0 ? 'Denda keterlambatan: Rp ' . number_format($denda, 0, ',', '.') : 'Status: Lunas / Tanpa Denda.') . ' 🐾',
            'link' => '/profile/riwayat',
            'status' => 'belum_dibaca'
        ]);

        return redirect()->to('/pengembalian')->with('success', 'Buku berhasil dikembalikan dan diverifikasi! 🐾');
    }

    public function ajukan_pengembalian($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $role = session()->get('role');
        $anggotaId = session()->get('anggota_id');

        if ($role != 'anggota') {
            return redirect()->back()->with('error', 'Hanya anggota yang dapat mengajukan pengembalian.');
        }

        $db = \Config\Database::connect();
        $pinjam = $db->table('peminjaman')
            ->where('id', $id)
            ->where('anggota_id', $anggotaId)
            ->get()
            ->getRowArray();

        if (!$pinjam) {
            return redirect()->back()->with('error', 'Transaksi peminjaman tidak ditemukan.');
        }

        if ($pinjam['status'] == 'Diajukan') {
            return redirect()->back()->with('error', 'Buku ini sudah diajukan pengembaliannya sebelumnya.');
        }

        if ($pinjam['status'] == 'Dikembalikan') {
            return redirect()->back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        // Update status to Diajukan
        $db->table('peminjaman')
            ->where('id', $id)
            ->update(['status' => 'Diajukan']);

        // Fetch book info
        $buku = $db->table('buku')
            ->where('id', $pinjam['buku_id'])
            ->get()
            ->getRowArray();

        // Create Admin notification
        $db->table('notifikasi')->insert([
            'user_id' => null,
            'role' => 'admin',
            'judul' => 'Pengajuan Pengembalian Buku',
            'pesan' => 'Anggota "' . session()->get('nama') . '" mengajukan pengembalian untuk buku fisik "' . ($buku['judul'] ?? 'Buku') . '". Silakan verifikasi.',
            'link' => '/pengembalian',
            'status' => 'belum_dibaca'
        ]);

        return redirect()->to('/profile/riwayat')->with('success', 'Pengajuan pengembalian berhasil diajukan! Silakan serahkan buku fisik ke petugas perpustakaan. 🐾');
    }

    public function hapus($id)
    {
        $model = new \App\Models\PeminjamanModel();

        $pinjam = $model->find($id);

        if ($pinjam) {

            $db = \Config\Database::connect();

            $db->table('buku')
                ->set('stok', 'stok+1', false)
                ->where('id', $pinjam['buku_id'])
                ->update();

            $model->delete($id);
        }

        return redirect()->to('/peminjaman');
    }

    public function detail($id)
    {
        $db = \Config\Database::connect();

        $data['pinjam'] = $db->query("
            SELECT
                peminjaman.*,
                anggota.nama,
                buku.judul,
                buku.foto,
                buku.cover,
                buku.penulis
            FROM peminjaman
            JOIN anggota
                ON anggota.id = peminjaman.anggota_id
            JOIN buku
                ON buku.id = peminjaman.buku_id
            WHERE peminjaman.id = $id
        ")->getRowArray();

        return view('detail_peminjaman', $data);
    }
}