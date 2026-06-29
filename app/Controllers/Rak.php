<?php

namespace App\Controllers;

use App\Models\RakModel;
use App\Models\BukuModel;

class Rak extends BaseController
{
    // Halaman daftar kelola rak DDC (Khusus Admin)
    public function index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak! Anda bukan administrator.');
        }

        $db = \Config\Database::connect();
        
        // Query untuk mengambil list rak DDC beserta jumlah buku di setiap rak secara dinamis
        $builder = $db->table('rak')
                      ->select('rak.*, COUNT(buku.id) as jumlah_buku')
                      ->join('buku', 'buku.rak_id = rak.id', 'left')
                      ->groupBy('rak.id')
                      ->orderBy('rak.kode_ddc', 'ASC');

        $data = [
            'title' => 'Kelola Rak DDC - PawLib Admin 🐾',
            'rak'   => $builder->get()->getResultArray()
        ];

        return view('rak', $data);
    }

    // Detail Klasifikasi DDC (Melihat seluruh buku di dalam klasifikasi tertentu)
    public function detail($id = null)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak! Anda bukan administrator.');
        }

        $rakModel = new RakModel();
        $bukuModel = new BukuModel();

        $rak = $rakModel->find($id);

        if (!$rak) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Klasifikasi DDC dengan ID $id tidak ditemukan.");
        }

        // Ambil semua buku yang berada pada rak/klasifikasi DDC ini
        $buku = $bukuModel->where('rak_id', $id)->orderBy('id', 'DESC')->findAll();

        $data = [
            'title'      => 'Koleksi Rak ' . $rak['kode_ddc'] . ' - PawLib 🐾',
            'rak'        => $rak,
            'buku'       => $buku,
            'total_buku' => count($buku)
        ];

        return view('detail_rak', $data);
    }
}