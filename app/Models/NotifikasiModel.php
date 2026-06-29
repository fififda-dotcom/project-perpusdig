<?php

namespace App\Models;

use CodeIgniter\Model;

class NotifikasiModel extends Model
{
    protected $table      = 'notifikasi';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'role',
        'judul',
        'pesan',
        'link',
        'status',
        'created_at'
    ];

    protected $useTimestamps = false;
}
