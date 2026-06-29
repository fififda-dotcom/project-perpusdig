<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Buku extends BaseController
{
    public function index()
    {
        $model = new BukuModel();
        
        // Capture GET parameters for filtering
        $keyword = $this->request->getGet('keyword');
        $bahasa = $this->request->getGet('bahasa');
        $jenisKoleksi = $this->request->getGet('jenis_koleksi');
        $ddc = $this->request->getGet('ddc');

        // Menghitung statistik keseluruhan buku (berdasarkan pencarian jika ada)
        $statsModel = new BukuModel();
        if ($keyword) {
            $statsModel->groupStart()
                       ->like('judul', $keyword)
                       ->orLike('penulis', $keyword)
                       ->groupEnd();
        }
        if ($bahasa) {
            $statsModel->where('bahasa', $bahasa);
        }
        if ($jenisKoleksi) {
            $statsModel->where('jenis_koleksi', $jenisKoleksi);
        }
        if ($ddc) {
            $statsModel->where('rak_id', $ddc);
        }
        $allBuku = $statsModel->findAll();
        
        $totalJudul = count($allBuku);
        $totalStok = 0;
        $totalEbook = 0;
        foreach ($allBuku as $b) {
            if (($b['jenis_koleksi'] ?? 'fisik') === 'ebook') {
                $totalEbook++;
            } else {
                $totalStok += (int)($b['stok'] ?? 0);
            }
        }

        // Paginasi query utama (6 buku per halaman)
        if ($keyword) {
            $model->groupStart()
                  ->like('judul', $keyword)
                  ->orLike('penulis', $keyword)
                  ->groupEnd();
        }
        if ($bahasa) {
            $model->where('bahasa', $bahasa);
        }
        if ($jenisKoleksi) {
            $model->where('jenis_koleksi', $jenisKoleksi);
        }
        if ($ddc) {
            $model->where('rak_id', $ddc);
        }

        $data['keyword'] = $keyword;
        $data['bahasa_filter'] = $bahasa;
        $data['jenis_koleksi_filter'] = $jenisKoleksi;
        $data['ddc_filter'] = $ddc;
        
        $data['buku'] = $model->paginate(6, 'buku');
        $data['pager'] = $model->pager;

        // Fetch distinct languages from the database combined with standard fallbacks
        $standardLanguages = ['Indonesia', 'Inggris', 'Arab', 'Mandarin', 'Jepang', 'Korea', 'Jerman', 'Prancis'];
        $db = \Config\Database::connect();
        $dbLanguages = $db->table('buku')
                          ->select('bahasa')
                          ->where('bahasa IS NOT NULL')
                          ->where("bahasa != ''")
                          ->distinct()
                          ->get()
                          ->getResultArray();
        
        $languages = $standardLanguages;
        foreach ($dbLanguages as $row) {
            $lang = trim($row['bahasa']);
            if ($lang !== '' && !in_array($lang, $languages)) {
                $languages[] = $lang;
            }
        }
        sort($languages);
        $data['bahasaList'] = $languages;

        // Kirim data statistik utuh ke View
        $data['totalJudul'] = $totalJudul;
        $data['totalStok'] = $totalStok;
        $data['totalEbook'] = $totalEbook;

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

        if ($cover && $cover->isValid() && !$cover->hasMoved()) {
            $namaCover = $cover->getRandomName();
            $cover->move(ROOTPATH . 'public/uploads/cover', $namaCover);
        }

        $jenisKoleksi = $this->request->getPost('jenis_koleksi') ?? 'fisik';
        $filePdfName = null;

        if ($jenisKoleksi === 'ebook') {
            $pdfFile = $this->request->getFile('file_pdf');
            if ($pdfFile && $pdfFile->isValid() && !$pdfFile->hasMoved()) {
                $filePdfName = $pdfFile->getRandomName();
                if (!is_dir(ROOTPATH . 'public/uploads/ebooks')) {
                    mkdir(ROOTPATH . 'public/uploads/ebooks', 0777, true);
                }
                $pdfFile->move(ROOTPATH . 'public/uploads/ebooks', $filePdfName);
            }
        }

        $model->save([
            'kode_buku'         => $kode,
            'judul'             => $this->request->getPost('judul'),
            'penulis'           => $this->request->getPost('penulis'),
            'penerbit'          => $this->request->getPost('penerbit'),
            'tahun'             => $this->request->getPost('tahun'),
            'stok'              => ($jenisKoleksi === 'ebook') ? 9999 : ($this->request->getPost('stok') ?? 1),
            'rak_id'            => $this->request->getPost('rak_id') ?? 1,
            'nomor_panggil'     => $this->request->getPost('nomor_panggil'),
            'nomor_klasifikasi' => $this->request->getPost('nomor_klasifikasi'),
            'isbn'              => $this->request->getPost('isbn'),
            'dimensi_buku'      => $this->request->getPost('dimensi_buku'),
            'departemen'        => $this->request->getPost('departemen'),
            'cover'             => $namaCover,
            'foto'              => $namaCover,
            'jenis_koleksi'     => $jenisKoleksi,
            'file_pdf'          => $filePdfName,
            'jumlah_halaman'    => $this->request->getPost('jumlah_halaman') ?? 0,
            'sinopsis'          => $this->request->getPost('sinopsis'),
            'edisi'             => $this->request->getPost('edisi'),
            'bahasa'            => $this->request->getPost('bahasa'),
            'tempat_terbit'     => $this->request->getPost('tempat_terbit'),
            'deskripsi_fisik'   => $this->request->getPost('deskripsi_fisik'),
            'catatan'           => $this->request->getPost('catatan'),
        ]);

        $bukuId = $model->getInsertID();

        if ($jenisKoleksi === 'ebook') {
            $chaptersJson = $this->request->getPost('chapters');
            if (!empty($chaptersJson)) {
                $chapters = json_decode($chaptersJson, true);
                if (is_array($chapters)) {
                    $babModel = new \App\Models\EbookBabModel();
                    foreach ($chapters as $index => $chap) {
                        $babModel->save([
                            'buku_id'   => $bukuId,
                            'nomor_bab' => $chap['nomor_bab'] ?? ($index + 1),
                            'judul_bab' => $chap['judul_bab'] ?? ('Bab ' . ($index + 1)),
                            'isi_bab'   => $chap['isi_bab'] ?? ''
                        ]);
                    }
                }
            }
        }

        return redirect()->to('/buku')
            ->with('success', 'Buku baru berhasil masuk ke rak PawLib!');
    }

    public function edit($id)
    {
        $model = new BukuModel();
        $data['buku'] = $model->find($id);

        $babModel = new \App\Models\EbookBabModel();
        $data['existingChapters'] = $babModel->where('buku_id', $id)->orderBy('nomor_bab', 'ASC')->findAll();

        return view('edit_buku', $data);
    }

    public function update($id)
    {
        $model = new BukuModel();
        $buku = $model->find($id);

        $jenisKoleksi = $this->request->getPost('jenis_koleksi') ?? 'fisik';

        $updateData = [
            'judul'             => $this->request->getPost('judul'),
            'penulis'           => $this->request->getPost('penulis'),
            'penerbit'          => $this->request->getPost('penerbit'),
            'tahun'             => $this->request->getPost('tahun'),
            'stok'              => ($jenisKoleksi === 'ebook') ? 9999 : ($this->request->getPost('stok') ?? 1),
            'rak_id'            => $this->request->getPost('rak_id') ?? 1,
            'nomor_panggil'     => $this->request->getPost('nomor_panggil'),
            'nomor_klasifikasi' => $this->request->getPost('nomor_klasifikasi'),
            'isbn'              => $this->request->getPost('isbn'),
            'dimensi_buku'      => $this->request->getPost('dimensi_buku'),
            'departemen'        => $this->request->getPost('departemen'),
            'jenis_koleksi'     => $jenisKoleksi,
            'jumlah_halaman'    => $this->request->getPost('jumlah_halaman') ?? 0,
            'sinopsis'          => $this->request->getPost('sinopsis'),
            'edisi'             => $this->request->getPost('edisi'),
            'bahasa'            => $this->request->getPost('bahasa'),
            'tempat_terbit'     => $this->request->getPost('tempat_terbit'),
            'deskripsi_fisik'   => $this->request->getPost('deskripsi_fisik'),
            'catatan'           => $this->request->getPost('catatan'),
        ];

        $cover = $this->request->getFile('cover');
        if ($cover && $cover->isValid() && !$cover->hasMoved()) {
            $namaCover = $cover->getRandomName();
            $cover->move(ROOTPATH . 'public/uploads/cover', $namaCover);
            
            $oldCover = $buku['cover'] ?? '';
            if (!empty($oldCover) && file_exists(ROOTPATH . 'public/uploads/cover/' . $oldCover)) {
                @unlink(ROOTPATH . 'public/uploads/cover/' . $oldCover);
            }
            $oldFoto = $buku['foto'] ?? '';
            if (!empty($oldFoto) && file_exists(ROOTPATH . 'public/uploads/' . $oldFoto)) {
                @unlink(ROOTPATH . 'public/uploads/' . $oldFoto);
            }

            $updateData['cover'] = $namaCover;
            $updateData['foto'] = $namaCover;
        }

        // Upload berkas PDF untuk Ebook
        if ($jenisKoleksi === 'ebook') {
            $pdfFile = $this->request->getFile('file_pdf');
            if ($pdfFile && $pdfFile->isValid() && !$pdfFile->hasMoved()) {
                $filePdfName = $pdfFile->getRandomName();
                if (!is_dir(ROOTPATH . 'public/uploads/ebooks')) {
                    mkdir(ROOTPATH . 'public/uploads/ebooks', 0777, true);
                }
                $pdfFile->move(ROOTPATH . 'public/uploads/ebooks', $filePdfName);

                $oldPdf = $buku['file_pdf'] ?? '';
                if (!empty($oldPdf) && file_exists(ROOTPATH . 'public/uploads/ebooks/' . $oldPdf)) {
                    @unlink(ROOTPATH . 'public/uploads/ebooks/' . $oldPdf);
                }
                $updateData['file_pdf'] = $filePdfName;
            }

            // Simpan perubahan bab Ebook jika dikirimkan
            $chaptersJson = $this->request->getPost('chapters');
            if ($chaptersJson !== null) {
                $chapters = json_decode($chaptersJson, true);
                if (is_array($chapters)) {
                    $babModel = new \App\Models\EbookBabModel();
                    $babModel->where('buku_id', $id)->delete();
                    foreach ($chapters as $index => $chap) {
                        $babModel->save([
                            'buku_id'   => $id,
                            'nomor_bab' => $chap['nomor_bab'] ?? ($index + 1),
                            'judul_bab' => $chap['judul_bab'] ?? ('Bab ' . ($index + 1)),
                            'isi_bab'   => $chap['isi_bab'] ?? ''
                        ]);
                    }
                }
            }
        }

        $model->update($id, $updateData);

        // Redirect kembali ke halaman asal (atau detail rak jika referer dari sana)
        $ref = $this->request->getPost('ref') ?? $this->request->getGet('ref');
        if ($ref === 'rak_detail') {
            $rakId = $this->request->getPost('rak_id') ?? $this->request->getGet('rak_id');
            return redirect()->to('/rak/detail/' . $rakId)->with('success', 'Data buku berhasil diperbarui!');
        } else {
            $page = $this->request->getPost('page') ?? $this->request->getGet('page') ?? 1;
            return redirect()->to('/buku?page_buku=' . $page)->with('success', 'Data buku berhasil diperbarui!');
        }
    }

    public function hapus($id)
    {
        $model = new BukuModel();
        $buku = $model->find($id);

        if ($buku) {
            $cover = $buku['cover'] ?? '';
            if (!empty($cover) && file_exists(ROOTPATH . 'public/uploads/cover/' . $cover)) {
                @unlink(ROOTPATH . 'public/uploads/cover/' . $cover);
            }
            $foto = $buku['foto'] ?? '';
            if (!empty($foto) && file_exists(ROOTPATH . 'public/uploads/' . $foto)) {
                @unlink(ROOTPATH . 'public/uploads/' . $foto);
            }
            $pdf = $buku['file_pdf'] ?? '';
            if (!empty($pdf) && file_exists(ROOTPATH . 'public/uploads/ebooks/' . $pdf)) {
                @unlink(ROOTPATH . 'public/uploads/ebooks/' . $pdf);
            }

            $model->delete($id);
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Buku telah berhasil dihapus dari sistem PawLib.'
            ]);
        }

        // Redirect kembali ke halaman buku yang sesuai saat ini
        $page = $this->request->getGet('page') ?? 1;
        return redirect()->to('/buku?page_buku=' . $page)->with('success', 'Buku telah berhasil dihapus dari sistem PawLib.');
    }
}