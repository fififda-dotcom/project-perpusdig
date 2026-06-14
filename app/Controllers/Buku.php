<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Buku extends BaseController
{
    public function index()
{
    $model = new \App\Models\BukuModel();

    $keyword = $this->request->getGet('keyword');

    if ($keyword) {
        $model->groupStart()
              ->like('judul', $keyword)
              ->orLike('penulis', $keyword)
              ->groupEnd();
    }

    $data['keyword'] = $keyword;
    $data['buku'] = $model->findAll();

    return view('buku', $data);
}

    public function tambah()
    {
        return view('tambah_buku');
    }

    public function simpan()
    {
        $model = new BukuModel();

        $last = $model->orderBy('id', 'DESC')->first();

        if ($last && !empty($last['kode_buku'])) {
            $nomor = (int) substr($last['kode_buku'], 2) + 1;
        } else {
            $nomor = 1;
        }

        $kode = 'BK' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

        $cover = $this->request->getFile('cover');

        $namaCover = null;

        if ($cover->isValid() && !$cover->hasMoved()) {

            $namaCover = $cover->getRandomName();

            $cover->move(ROOTPATH . 'public/uploads/cover', $namaCover);

        }

        $model->save([
            'kode_buku' => $kode,
            'judul' => $this->request->getPost('judul'),
            'penulis' => $this->request->getPost('penulis'),
            'penerbit' => $this->request->getPost('penerbit'),
            'tahun' => $this->request->getPost('tahun'),
            'stok' => $this->request->getPost('stok'),
            'rak_id' => 1,
            'cover' => $namaCover
        ]);

        return redirect()->to('/buku')
            ->with('success', 'Buku baru berhasil masuk ke rak PawLib!');
    }

    public function edit($id)
{
    $model = new BukuModel();

    $data['buku'] = $model->find($id);

    return view('edit_buku', $data);
}

public function update($id)
{
    $model = new BukuModel();

    $model->update($id, [
        'judul' => $this->request->getPost('judul'),
        'penulis' => $this->request->getPost('penulis'),
        'penerbit' => $this->request->getPost('penerbit'),
        'tahun' => $this->request->getPost('tahun'),
        'stok' => $this->request->getPost('stok')
    ]);

    return redirect()->to('/buku');
}

public function hapus($id)
{
    $model = new \App\Models\BukuModel();

    $model->delete($id);

    return redirect()->to('/buku')
        ->with('success', '🐾 Buku telah meninggalkan rak PawLib.');
}

}