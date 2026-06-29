<?php

namespace App\Controllers;

class Pengembalian extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Fetch active loans (printed books currently borrowed)
        $data['sedang_dipinjam'] = $db->query("
            SELECT peminjaman.*, anggota.nama, buku.judul, buku.foto, buku.cover 
            FROM peminjaman
            JOIN anggota ON anggota.id = peminjaman.anggota_id
            JOIN buku ON buku.id = peminjaman.buku_id
            WHERE peminjaman.status = 'Dipinjam'
            ORDER BY peminjaman.id DESC
        ")->getResultArray();

        // Fetch user return proposals awaiting verification
        $data['pengajuan_kembali'] = $db->query("
            SELECT peminjaman.*, anggota.nama, buku.judul, buku.foto, buku.cover 
            FROM peminjaman
            JOIN anggota ON anggota.id = peminjaman.anggota_id
            JOIN buku ON buku.id = peminjaman.buku_id
            WHERE peminjaman.status = 'Diajukan'
            ORDER BY peminjaman.id DESC
        ")->getResultArray();

        return view('pengembalian', $data);
    }
}