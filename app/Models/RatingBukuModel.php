<?php

namespace App\Models;

use CodeIgniter\Model;

class RatingBukuModel extends Model
{
    protected $table = 'rating_buku';
    protected $primaryKey = 'id';
    protected $allowedFields = ['buku_id', 'anggota_id', 'peminjaman_id', 'rating'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}