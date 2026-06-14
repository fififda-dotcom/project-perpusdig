<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;

class Peminjaman extends BaseController
{
    public function index()
    {
        $model = new PeminjamanModel();

        $data['peminjaman'] = $model->findAll();

        return view('peminjaman', $data);
    }

    public function tambah($id)
    {
        $bukuModel = new \App\Models\BukuModel();

        $data = [
            'buku' => $bukuModel->find($id)
        ];

        return view('tambah_peminjaman', $data);
    }

    public function simpan()
    {
        $model = new PeminjamanModel();
        $db = \Config\Database::connect();

        $nama = $this->request->getPost('nama');
        $tanggalPinjam = $this->request->getPost('tanggal_pinjam');

        $anggota = $db->table('anggota')
        ->where('nama', $nama)
        ->get()
        ->getRowArray();

        if (!$anggota) {
            return redirect()->back()->withInput()->with(
                'error',
                'Nama tidak terdaftar sebagai anggota PawLib.'
            );
        }

        $model->save([
            'anggota_id' => $anggota['id'],
            'nama' => $nama,
            'buku_id' => $this->request->getPost('buku_id'),
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => date(
                'Y-m-d',
                strtotime($tanggalPinjam . ' +7 days')
            ),
            'status' => 'Dipinjam'
        ]);

        $db->table('buku')
            ->set('stok', 'stok-1', false)
            ->where('id', $this->request->getPost('buku_id'))
            ->update();

        return redirect()->to('/peminjaman');
    }

    public function kembalikan($id)
    {
        $db = \Config\Database::connect();

        $pinjam = $db->table('peminjaman')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        $db->table('peminjaman')
            ->where('id', $id)
            ->update([
                'status' => 'Dikembalikan',
                'tanggal_dikembalikan' => date('Y-m-d')
            ]);

        $db->table('buku')
            ->set('stok', 'stok+1', false)
            ->where('id', $pinjam['buku_id'])
            ->update();

        return redirect()->to('/pengembalian');
    }

    public function hapus($id)
{
    $model = new \App\Models\PeminjamanModel();

    $pinjam = $model->find($id);

    if ($pinjam) {

        $db = \Config\Database::connect();

        $db->table('buku')
            ->set('stok', 'stok+1', false)
            ->where('id', $pinjam['buku_id'])
            ->update();

        $model->delete($id);
    }

    return redirect()->to('/peminjaman');
}

public function detail($id)
{
    $db = \Config\Database::connect();

    $data['pinjam'] = $db->query("
        SELECT
            peminjaman.*,
            anggota.nama,
            buku.judul

        FROM peminjaman

        JOIN anggota
        ON anggota.id = peminjaman.anggota_id

        JOIN buku
        ON buku.id = peminjaman.buku_id

        WHERE peminjaman.id = $id
    ")->getRowArray();

    return view('detail_peminjaman', $data);
}
}

