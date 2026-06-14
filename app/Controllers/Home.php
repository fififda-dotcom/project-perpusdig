<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $data['totalBuku'] = $db->table('buku')->countAllResults();

        $data['totalAnggota'] = $db->table('anggota')->countAllResults();

        $data['totalDipinjam'] = $db->table('peminjaman')
            ->where('status', 'Dipinjam')
            ->countAllResults();
        
        $data['rekomendasi'] = $db->table('buku')
            ->limit(4)
            ->get()
            ->getResultArray();

        return view('home', $data);
    }
}