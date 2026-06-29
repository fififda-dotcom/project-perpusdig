<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\WishlistModel;

class Wishlist extends BaseController
{
    private function checkAccess()
    {
        if (session()->get('role') !== 'anggota') {
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->checkAccess()) {
            return redirect()->to('/')->with('error', 'Akses dibatasi hanya untuk anggota.');
        }

        $anggotaId = session()->get('anggota_id');
        $keyword = $this->request->getGet('keyword');
        $ddc = $this->request->getGet('ddc');
        $jenisKoleksi = $this->request->getGet('jenis_koleksi');

        $db = \Config\Database::connect();
        $builder = $db->table('wishlist');
        $builder->select('wishlist.id as wishlist_id, wishlist.created_at as wishlist_created_at, buku.*, rak.kode_ddc, rak.nama_rak');
        $builder->join('buku', 'buku.id = wishlist.buku_id');
        $builder->join('rak', 'rak.id = buku.rak_id', 'left');
        $builder->where('wishlist.anggota_id', $anggotaId);

        if ($keyword) {
            $builder->groupStart()
                    ->like('buku.judul', $keyword)
                    ->orLike('buku.penulis', $keyword)
                    ->orLike('buku.kode_buku', $keyword)
                    ->groupEnd();
        }

        // Filter berdasarkan DDC jika dipilih
        if ($ddc) {
            $builder->where('buku.rak_id', $ddc);
        }

        // Filter berdasarkan jenis koleksi jika dipilih
        if ($jenisKoleksi) {
            $builder->where('buku.jenis_koleksi', $jenisKoleksi);
        }

        $builder->orderBy('wishlist.created_at', 'DESC');
        
        $data['wishlist'] = $builder->get()->getResultArray();
        $data['keyword'] = $keyword;
        $data['ddc_filter'] = $ddc;
        $data['jenis_koleksi_filter'] = $jenisKoleksi;

        return view('wishlist', $data);
    }

    public function tambah($bukuId)
    {
        if (!$this->checkAccess()) {
            return redirect()->to('/')->with('error', 'Akses dibatasi hanya untuk anggota.');
        }

        $anggotaId = session()->get('anggota_id');

        $bukuModel = new BukuModel();
        $buku = $bukuModel->find($bukuId);
        if (!$buku) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan.');
        }

        $wishlistModel = new WishlistModel();
        $existing = $wishlistModel->where([
            'anggota_id' => $anggotaId,
            'buku_id' => $bukuId
        ])->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Buku sudah ada di wishlist-mu.');
        }

        $wishlistModel->save([
            'anggota_id' => $anggotaId,
            'buku_id' => $bukuId
        ]);

        return redirect()->back()->with('success', '🐾 Buku berhasil ditambahkan ke wishlist-mu!');
    }

    public function hapus($id)
    {
        if (!$this->checkAccess()) {
            return redirect()->to('/')->with('error', 'Akses dibatasi hanya untuk anggota.');
        }

        $anggotaId = session()->get('anggota_id');
        $wishlistModel = new WishlistModel();
        
        $wishlistItem = $wishlistModel->find($id);
        if (!$wishlistItem || $wishlistItem['anggota_id'] != $anggotaId) {
            return redirect()->back()->with('error', 'Data wishlist tidak ditemukan.');
        }

        $wishlistModel->delete($id);

        return redirect()->back()->with('success', '😿 Buku berhasil dihapus dari wishlist-mu.');
    }
}