<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'kode_anggota',
        'nama',
        'nomor',
        'gmail',
        'username',
        'password',
        'foto'
    ];
}