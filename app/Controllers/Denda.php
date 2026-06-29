<?php

namespace App\Controllers;

class Denda extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $keyword = $this->request->getGet('keyword');

        $queryStr = "
            SELECT
                peminjaman.*,
                anggota.nama,
                buku.judul,
                DATEDIFF(CURDATE(), peminjaman.tanggal_kembali) * 2000 AS denda
            FROM peminjaman
            JOIN anggota
                ON anggota.id = peminjaman.anggota_id
            JOIN buku
                ON buku.id = peminjaman.buku_id
            WHERE status = 'Dipinjam'
            AND tanggal_kembali < CURDATE()
        ";

        $params = [];
        if (!empty($keyword)) {
            $queryStr .= " AND (anggota.nama LIKE ? OR buku.judul LIKE ?) ";
            $params[] = '%' . $keyword . '%';
            $params[] = '%' . $keyword . '%';
        }

        $queryStr .= " ORDER BY peminjaman.tanggal_kembali ASC ";

        $data['denda'] = $db->query($queryStr, $params)->getResultArray();
        $data['keyword'] = $keyword;

        return view('denda', $data);
    }
}