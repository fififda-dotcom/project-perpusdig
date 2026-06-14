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
        'rak_id'
    ];
}