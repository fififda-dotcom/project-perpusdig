<?php

namespace App\Models;

use CodeIgniter\Model;

class EbookBabModel extends Model
{
    protected $table            = 'ebook_bab';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['buku_id', 'nomor_bab', 'judul_bab', 'isi_bab', 'created_at', 'updated_at'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
