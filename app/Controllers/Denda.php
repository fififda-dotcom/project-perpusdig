<?php

namespace App\Controllers;

class Denda extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $data['denda'] = $db->query("
            SELECT
                peminjaman.*,
                anggota.nama,
                buku.judul
            FROM peminjaman
            JOIN anggota
                ON anggota.id = peminjaman.anggota_id
            JOIN buku
                ON buku.id = peminjaman.buku_id
            WHERE status = 'Dipinjam'
            AND tanggal_kembali < CURDATE()
        ")->getResultArray();

        return view('denda', $data);
    }
}