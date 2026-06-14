<?php

namespace App\Controllers;

class Riwayat extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $data['riwayat'] = $db->query("
            SELECT
                peminjaman.*,
                anggota.nama,
                buku.judul
            FROM peminjaman
            JOIN anggota
            ON anggota.id = peminjaman.anggota_id
            JOIN buku
            ON buku.id = peminjaman.buku_id
            ORDER BY peminjaman.id DESC
        ")->getResultArray();

        return view('riwayat', $data);
    }
}