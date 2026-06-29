<?php

namespace App\Models;

use CodeIgniter\Model;

class UlasanBukuModel extends Model
{
    protected $table = 'ulasan_buku';
    protected $primaryKey = 'id';
    protected $allowedFields = ['buku_id', 'anggota_id', 'peminjaman_id', 'ulasan'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}