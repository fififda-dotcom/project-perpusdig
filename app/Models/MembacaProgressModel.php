<?php

namespace App\Models;

use CodeIgniter\Model;

class MembacaProgressModel extends Model
{
    protected $table            = 'membaca_progress';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['anggota_id', 'buku_id', 'nomor_bab', 'scroll_position', 'progress_persen', 'updated_at'];
    protected $useTimestamps    = false;
}
