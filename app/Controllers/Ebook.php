<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\EbookBabModel;
use App\Models\MembacaProgressModel;

class Ebook extends BaseController
{
    private function checkAccess()
    {
        if (session()->get('role') !== 'anggota') {
            return false;
        }
        return true;
    }

    public function baca($id = null)
    {
        if (!$this->checkAccess()) {
            return redirect()->to('/auth')->with('error', 'Silakan login sebagai anggota untuk membaca ebook.');
        }

        $bukuModel = new BukuModel();
        $buku = $bukuModel->find($id);

        if (!$buku || $buku['jenis_koleksi'] !== 'ebook') {
            return redirect()->to('/katalog')->with('error', 'Ebook tidak ditemukan atau format buku bukan digital.');
        }

        // Increment dibaca_count
        $db = \Config\Database::connect();
        $db->table('buku')
           ->where('id', $id)
           ->set('dibaca_count', 'dibaca_count + 1', false)
           ->update();

        $babModel = new EbookBabModel();
        $daftarBab = $babModel->where('buku_id', $id)->orderBy('nomor_bab', 'ASC')->findAll();

        $anggotaId = session()->get('anggota_id');
        $progressModel = new MembacaProgressModel();
        $progress = $progressModel->where('anggota_id', $anggotaId)->where('buku_id', $id)->first();

        $data = [
            'buku'      => $buku,
            'daftarBab' => $daftarBab,
            'progress'  => $progress
        ];

        if (empty($daftarBab)) {
            return view('pdf_reader', $data);
        }

        return view('reader', $data);
    }

    public function updateProgress()
    {
        if (!$this->checkAccess()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $anggotaId = session()->get('anggota_id');
        $bukuId = $this->request->getPost('buku_id');
        $nomorBab = $this->request->getPost('nomor_bab');
        $scrollPosition = $this->request->getPost('scroll_position');
        $progressPersen = $this->request->getPost('progress_persen');

        if (!$bukuId || $nomorBab === null) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid data'], 400);
        }

        $progressModel = new MembacaProgressModel();
        $existing = $progressModel->where('anggota_id', $anggotaId)->where('buku_id', $bukuId)->first();

        $dbData = [
            'anggota_id'      => $anggotaId,
            'buku_id'         => $bukuId,
            'nomor_bab'       => $nomorBab,
            'scroll_position' => $scrollPosition ?? 0.0,
            'progress_persen' => $progressPersen ?? 0,
            'updated_at'      => date('Y-m-d H:i:s')
        ];

        if ($existing) {
            $progressModel->update($existing['id'], $dbData);
        } else {
            $progressModel->insert($dbData);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Progress saved']);
    }

    public function cariKata()
    {
        if (!$this->checkAccess()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $bukuId = $this->request->getGet('buku_id');
        $keyword = $this->request->getGet('keyword');

        if (!$bukuId || !$keyword) {
            return $this->response->setJSON([]);
        }

        $babModel = new EbookBabModel();
        $matches = $babModel->where('buku_id', $bukuId)
                            ->like('isi_bab', $keyword)
                            ->orderBy('nomor_bab', 'ASC')
                            ->findAll();

        $results = [];
        foreach ($matches as $match) {
            $isiText = strip_tags($match['isi_bab']);
            $pos = stripos($isiText, $keyword);
            $start = max(0, $pos - 40);
            $length = strlen($keyword) + 80;
            $snippet = substr($isiText, $start, $length);
            if ($start > 0) {
                $snippet = '...' . $snippet;
            }
            if ($start + $length < strlen($isiText)) {
                $snippet = $snippet . '...';
            }

            $snippetEscaped = esc($snippet);
            $keywordEscaped = esc($keyword);
            $snippetHighlighted = preg_replace('/(' . preg_quote($keywordEscaped, '/') . ')/i', '<mark>$1</mark>', $snippetEscaped);

            $results[] = [
                'nomor_bab' => $match['nomor_bab'],
                'judul_bab' => $match['judul_bab'],
                'snippet'   => $snippetHighlighted
            ];
        }

        return $this->response->setJSON($results);
    }
}
