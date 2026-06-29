<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\FavoritModel;

class Favorit extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'anggota') {
            return redirect()->to('/auth')->with('error', 'Silakan login sebagai anggota terlebih dahulu.');
        }

        $anggotaId = session()->get('anggota_id');
        $keyword = $this->request->getGet('keyword');
        $ddc = $this->request->getGet('ddc');
        $jenisKoleksi = $this->request->getGet('jenis_koleksi');

        $db = \Config\Database::connect();
        $builder = $db->table('favorit');
        $builder->select('favorit.id as favorit_id, buku.*, rak.kode_ddc, rak.nama_rak');
        $builder->join('buku', 'buku.id = favorit.buku_id');
        $builder->join('rak', 'rak.id = buku.rak_id', 'left');
        $builder->where('favorit.anggota_id', $anggotaId);

        // Cari buku favorit berdasarkan judul, penulis, atau kode buku
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

        $builder->orderBy('favorit.id', 'DESC');
        $favorit = $builder->get()->getResultArray();

        $data = [
            'title'                => 'Buku Favorit Saya - PawLib 🐾',
            'favorit'              => $favorit,
            'keyword'              => $keyword,
            'ddc_filter'           => $ddc,
            'jenis_koleksi_filter' => $jenisKoleksi
        ];

        return view('favorit', $data);
    }

    // Toggle status favorit (tambah jika belum ada, hapus jika sudah ada)
    public function toggle($bukuId = null)
    {
        if (session()->get('role') !== 'anggota') {
            return redirect()->to('/auth')->with('error', 'Silakan login sebagai anggota terlebih dahulu.');
        }

        $anggotaId = session()->get('anggota_id');
        $favoritModel = new FavoritModel();
        $bukuModel = new BukuModel();

        // Validasi ketersediaan buku
        if (!$bukuModel->find($bukuId)) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan.');
        }

        // Cek apakah buku sudah ada di daftar favorit
        $existing = $favoritModel->where('anggota_id', $anggotaId)
                                 ->where('buku_id', $bukuId)
                                 ->first();

        if ($existing) {
            // Hapus dari favorit jika sudah ada
            $favoritModel->delete($existing['id']);
            return redirect()->back()->with('success', '😿 Buku telah dihapus dari rak favoritmu.');
        } else {
            // Tambahkan ke favorit jika belum ada
            $favoritModel->save([
                'anggota_id' => $anggotaId,
                'buku_id'    => $bukuId
            ]);
            return redirect()->back()->with('success', '🐾 Buku berhasil disimpan di rak favoritmu!');
        }
    }

    // Menghapus item favorit langsung berdasarkan ID tabel favorit
    public function hapus($id = null)
    {
        if (session()->get('role') !== 'anggota') {
            return redirect()->to('/auth')->with('error', 'Silakan login sebagai anggota terlebih dahulu.');
        }

        $favoritModel = new FavoritModel();
        $fav = $favoritModel->find($id);
        
        if ($fav && $fav['anggota_id'] == session()->get('anggota_id')) {
            $favoritModel->delete($id);
            return redirect()->back()->with('success', '😿 Buku telah dihapus dari rak favoritmu.');
        }
        
        return redirect()->back()->with('error', 'Gagal menghapus buku dari favorit.');
    }
}