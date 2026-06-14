<?php

namespace App\Models;

use CodeIgniter\Model;

class DendaModel extends Model
{
    protected $table = 'denda';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'peminjaman_id',
        'nama',
        'buku_id',
        'jumlah_hari_telat',
        'total_denda',
        'status'
    ];
}