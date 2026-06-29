<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table = 'wishlist'; // Tabel wishlist
    protected $primaryKey = 'id';
    protected $allowedFields = ['anggota_id', 'buku_id', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
}