<?php

namespace App\Controllers;

class Pengembalian extends BaseController
{
    public function index()
    {
        $db=\Config\Database::connect();

        $data['pengembalian']=$db->query("
        SELECT
        peminjaman.*,
        anggota.nama,
        buku.judul

        FROM peminjaman

        JOIN anggota
        ON anggota.id=peminjaman.anggota_id

        JOIN buku
        ON buku.id=peminjaman.buku_id

        WHERE status='Dipinjam'
        ")->getResultArray();

        return view('pengembalian',$data);
    }
}