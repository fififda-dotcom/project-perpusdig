<?php

namespace App\Controllers;

use App\Models\AnggotaModel;

class Anggota extends BaseController
{
    public function index()
    {
        $model = new AnggotaModel();
        
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $model->groupStart()
                  ->like('nama', $keyword)
                  ->orLike('kode_anggota', $keyword)
                  ->orLike('nomor', $keyword)
                  ->groupEnd();
        }

        $data['keyword'] = $keyword;
        $data['anggota'] = $model->paginate(8, 'anggota');
        $data['pager'] = $model->pager;

        return view('anggota', $data);
    }

    public function detail($id = null)
    {
        $model = new AnggotaModel();
        $anggota = $model->find($id);

        if (!$anggota) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Anggota dengan ID $id tidak ditemukan.");
        }

        $db = \Config\Database::connect();
        
        $totalPinjam = 0;
        $sedangDipinjam = 0;
        $sudahKembali = 0;
        $riwayat = [];

        if ($db->tableExists('peminjaman')) {
            $builder = $db->table('peminjaman')
                          ->select('peminjaman.*, buku.judul')
                          ->join('buku', 'buku.id = peminjaman.buku_id', 'left');
            
            $fields = $db->getFieldNames('peminjaman');
            $hasCondition = false;
            
            if (in_array('anggota_id', $fields)) {
                $builder->where('peminjaman.anggota_id', $id);
                $hasCondition = true;
            }
            if (in_array('id_anggota', $fields)) {
                if ($hasCondition) {
                    $builder->orWhere('peminjaman.id_anggota', $id);
                } else {
                    $builder->where('peminjaman.id_anggota', $id);
                    $hasCondition = true;
                }
            }
            if (in_array('nama', $fields)) {
                if ($hasCondition) {
                    $builder->orWhere('peminjaman.nama', $anggota['nama']);
                } else {
                    $builder->where('peminjaman.nama', $anggota['nama']);
                    $hasCondition = true;
                }
            }

            if ($hasCondition) {
                $riwayat = $builder->orderBy('peminjaman.id', 'DESC')->get()->getResultArray();
            }
            
            $totalPinjam = count($riwayat);
            foreach ($riwayat as $r) {
                $status = strtolower($r['status'] ?? '');
                if ($status == 'dipinjam' || $status == 'belum kembali' || empty($r['tanggal_kembali'])) {
                    $sedangDipinjam++;
                } else {
                    $sudahKembali++;
                }
            }
        }

        $data = [
            'title'           => 'Detail Anggota: ' . $anggota['nama'] . ' - PawLib 🐾',
            'anggota'         => $anggota,
            'total_pinjam'    => $totalPinjam,
            'sedang_dipinjam' => $sedangDipinjam,
            'sudah_kembali'   => $sudahKembali,
            'riwayat'         => $riwayat
        ];

        return view('detail_anggota', $data);
    }

    public function tambah()
    {
        return view('tambah_anggota');
    }

    public function simpan()
    {
        $model = new AnggotaModel();
        $last = $model->orderBy('id', 'DESC')->first();

        if ($last && !empty($last['kode_anggota'])) {
            $nomor = (int) substr($last['kode_anggota'], 3) + 1;
        } else {
            $nomor = 1;
        }

        $kode = 'AGT' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
        $foto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/uploads/profile/', $namaFoto);
        }

        $model->save([
            'kode_anggota' => $kode,
            'nama'         => $this->request->getPost('nama'),
            'nomor'        => $this->request->getPost('nomor'),
            'gmail'        => $this->request->getPost('gmail'),
            'username'     => $this->request->getPost('username') ?: null,
            'password'     => $this->request->getPost('password') ?: null,
            'foto'         => $namaFoto
        ]);

        return redirect()->to('/anggota')->with('success','Anggota baru berhasil bergabung!');
    }

    public function edit($id)
    {
        $model = new AnggotaModel();
        $data['anggota'] = $model->find($id);

        return view('edit_anggota', $data);
    }

    public function update($id)
    {
        $model = new AnggotaModel();
        $anggota = $model->find($id);

        $updateData = [
            'nama'     => $this->request->getPost('nama'),
            'nomor'    => $this->request->getPost('nomor'),
            'gmail'    => $this->request->getPost('gmail'),
            'username' => $this->request->getPost('username') ?: null,
            'password' => $this->request->getPost('password') ?: null
        ];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/uploads/profile/', $namaFoto);
      
            $oldFoto = $anggota['foto'] ?? '';
            if (!empty($oldFoto) && file_exists(ROOTPATH . 'public/uploads/profile/' . $oldFoto)) {
                @unlink(ROOTPATH . 'public/uploads/profile/' . $oldFoto);
            }

            $updateData['foto'] = $namaFoto;
        }

        $model->update($id, $updateData);

        return redirect()->to('/anggota')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $model = new AnggotaModel();
        $anggota = $model->find($id);

        $foto = $anggota['foto'] ?? '';
        if (!empty($foto) && file_exists(ROOTPATH . 'public/uploads/profile/' . $foto)) {
            @unlink(ROOTPATH . 'public/uploads/profile/' . $foto);
        }

        $model->delete($id);

        return redirect()->to('/anggota')->with('success', 'Anggota berhasil dihapus.');
    }
}