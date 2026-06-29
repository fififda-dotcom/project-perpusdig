<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'kode_buku',
        'judul',
        'penulis',
        'penerbit',
        'tahun',
        'stok',
        'rak_id',
        'foto',
        'nomor_panggil',
        'nomor_klasifikasi',
        'isbn',
        'dimensi_buku',
        'departemen',
        'cover',
        'jenis_koleksi',
        'file_pdf',
        'jumlah_halaman',
        'sinopsis',
        'edisi',
        'bahasa',
        'tempat_terbit',
        'deskripsi_fisik',
        'catatan',
        'dibaca_count'
    ];
}