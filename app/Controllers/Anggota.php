<?php

namespace App\Controllers;

use App\Models\AnggotaModel;

class Anggota extends BaseController
{
    public function index()
    {
        $model = new AnggotaModel();

        $data['anggota'] = $model->findAll();

        return view('anggota', $data);
    }

    public function tambah()
    {
        return view('tambah_anggota');
    }

    public function simpan()
{
    $model = new AnggotaModel();

    $last = $model->orderBy('id', 'DESC')->first();

    if ($last) {
        $nomor = (int) substr($last['kode_anggota'], 3) + 1;
    } else {
        $nomor = 1;
    }

    $kode = 'AGT' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

    $model->save([
        'kode_anggota' => $kode,
        'nama' => $this->request->getPost('nama'),
        'nomor' => $this->request->getPost('nomor'),
        'gmail' => $this->request->getPost('gmail')
    ]);

    return redirect()->to('/anggota')
        ->with('success','Anggota baru berhasil bergabung dengan keluarga PawLib!');
}

   public function edit($id)
{
    $model = new \App\Models\AnggotaModel();

    $data['anggota'] = $model->find($id);

    return view('edit_anggota', $data);
}

public function update($id)
{
    $model = new AnggotaModel();

    $model->update($id, [
        'nama' => $this->request->getPost('nama'),
        'nomor' => $this->request->getPost('nomor'),
        'gmail' => $this->request->getPost('gmail')
    ]);

    return redirect()->to('/anggota');
}

    public function hapus($id)
    {
        $model = new AnggotaModel();

        $model->delete($id);

        return redirect()->to('/anggota');
    }
}