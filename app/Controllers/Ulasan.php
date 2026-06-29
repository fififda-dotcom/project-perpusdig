<?php

namespace App\Controllers;

use App\Models\RatingBukuModel;
use App\Models\UlasanBukuModel;
use App\Models\PeminjamanModel;

class Ulasan extends BaseController
{
    // Simpan Rating & Ulasan (Menggunakan satu endpoint/method gabungan demi kemudahan)
    public function simpan()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $anggotaId = session()->get('anggota_id');
        $peminjamanId = $this->request->getPost('peminjaman_id');
        $ratingVal = (int) $this->request->getPost('rating');
        $ulasanVal = trim((string) $this->request->getPost('ulasan'));

        // 1. Verifikasi data peminjaman
        $pinjamModel = new PeminjamanModel();
        $pinjam = $pinjamModel->where('id', $peminjamanId)
                              ->where('anggota_id', $anggotaId)
                              ->where('status', 'Selesai')
                              ->first();

        if (!$pinjam) {
            return redirect()->back()->with('error', 'Transaksi tidak sah atau belum disetujui admin.');
        }

        $bukuId = $pinjam['buku_id'];

        // 2. Simpan atau Update Rating
        $ratingModel = new RatingBukuModel();
        $existingRating = $ratingModel->where('peminjaman_id', $peminjamanId)->first();
        
        if ($existingRating) {
            $ratingModel->update($existingRating['id'], [
                'rating' => $ratingVal
            ]);
        } else {
            $ratingModel->save([
                'buku_id' => $bukuId,
                'anggota_id' => $anggotaId,
                'peminjaman_id' => $peminjamanId,
                'rating' => $ratingVal
            ]);
        }

        // 3. Simpan atau Update Ulasan (jika ada ulasan yang ditulis)
        $ulasanModel = new UlasanBukuModel();
        $existingUlasan = $ulasanModel->where('peminjaman_id', $peminjamanId)->first();

        if (!empty($ulasanVal)) {
            // Validasi batas karakter ulasan (20 - 1000)
            $len = strlen($ulasanVal);
            if ($len < 20 || $len > 1000) {
                return redirect()->back()->with('error', 'Ulasan harus memiliki panjang antara 20 dan 1000 karakter.');
            }

            if ($existingUlasan) {
                $ulasanModel->update($existingUlasan['id'], [
                    'ulasan' => $ulasanVal
                ]);
                session()->setFlashdata('success', '🐾 Ulasanmu berhasil diperbarui.');
            } else {
                $ulasanModel->save([
                    'buku_id' => $bukuId,
                    'anggota_id' => $anggotaId,
                    'peminjaman_id' => $peminjamanId,
                    'ulasan' => $ulasanVal
                ]);
                session()->setFlashdata('success', '💬 Terima kasih telah berbagi pengalaman membaca di PawLib!');
            }
        } else {
            // Jika dikirim kosong, dan ulasan sebelumnya ada, maka biarkan atau hapus sesuai keinginan
            // Secara default: jika hanya menyimpan rating
            session()->setFlashdata('success', '⭐ Terima kasih! Jejak paw-mu berhasil ditambahkan ke buku ini.');
        }

        return redirect()->back();
    }

    // Hapus Ulasan (Anggota sendiri atau Moderasi Admin)
    public function hapus($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $ulasanModel = new UlasanBukuModel();
        $ulasan = $ulasanModel->find($id);

        if (!$ulasan) {
            return redirect()->back()->with('error', 'Ulasan tidak ditemukan.');
        }

        $role = session()->get('role');
        $anggotaId = session()->get('anggota_id');

        // Proteksi: Harus admin atau pemilik ulasan tersebut
        if ($role !== 'admin' && $ulasan['anggota_id'] != $anggotaId) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak untuk menghapus ulasan ini.');
        }

        // Hapus ulasan
        $ulasanModel->delete($id);

        session()->setFlashdata('success', '😿 Ulasan berhasil dihapus.');
        return redirect()->back();
    }

    // Halaman Moderasi Admin
    public function admin_index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth');
        }

        $db = \Config\Database::connect();

        // 1. Total Rating
        $data['totalRating'] = $db->table('rating_buku')->countAllResults();

        // 2. Total Ulasan
        $data['totalUlasan'] = $db->table('ulasan_buku')->countAllResults();

        // 3. Rata-rata rating seluruh koleksi
        $avgRating = $db->table('rating_buku')->selectAvg('rating')->get()->getRowArray();
        $data['avgRatingSeluruh'] = number_format((float)($avgRating['rating'] ?? 0), 1, '.', '');

        // 4. Daftar Ulasan Lengkap Pengguna (dengan join anggota & buku)
        $data['ulasanList'] = $db->query("
            SELECT 
                rating_buku.id AS id,
                rating_buku.rating,
                rating_buku.created_at,
                ulasan_buku.ulasan,
                anggota.nama AS nama_anggota,
                buku.judul AS judul_buku
            FROM rating_buku
            JOIN anggota ON anggota.id = rating_buku.anggota_id
            JOIN buku ON buku.id = rating_buku.buku_id
            LEFT JOIN ulasan_buku ON (
                (ulasan_buku.peminjaman_id = rating_buku.peminjaman_id)
                OR
                (rating_buku.peminjaman_id IS NULL AND ulasan_buku.peminjaman_id IS NULL AND ulasan_buku.buku_id = rating_buku.buku_id AND ulasan_buku.anggota_id = rating_buku.anggota_id)
            )
            ORDER BY rating_buku.id DESC
        ")->getResultArray();

        $data['role'] = 'admin';

        return view('admin_ulasan', $data);
    }

    // Hapus Rating & Ulasan (Moderasi Admin)
    public function admin_hapus($ratingId)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth');
        }

        $ratingModel = new RatingBukuModel();
        $rating = $ratingModel->find($ratingId);

        if (!$rating) {
            return redirect()->back()->with('error', 'Rating tidak ditemukan.');
        }

        // Cari ulasan terkait (via peminjaman_id atau buku_id & anggota_id)
        $ulasanModel = new UlasanBukuModel();
        if (!empty($rating['peminjaman_id'])) {
            $ulasan = $ulasanModel->where('peminjaman_id', $rating['peminjaman_id'])->first();
        } else {
            $ulasan = $ulasanModel->where('buku_id', $rating['buku_id'])
                                 ->where('anggota_id', $rating['anggota_id'])
                                 ->where('peminjaman_id IS NULL')
                                 ->first();
        }

        // Hapus ulasan jika ada
        if ($ulasan) {
            $ulasanModel->delete($ulasan['id']);
        }

        // Hapus rating
        $ratingModel->delete($ratingId);

        session()->setFlashdata('success', '🐾 Rating & Ulasan berhasil dihapus.');
        return redirect()->back();
    }

    // Simpan Rating & Ulasan Ebook
    public function simpan_ebook()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $anggotaId = session()->get('anggota_id');
        $bukuId = $this->request->getPost('buku_id');
        $ratingVal = (int) $this->request->getPost('rating');
        $ulasanVal = trim((string) $this->request->getPost('ulasan'));

        if (!$bukuId || $ratingVal < 1 || $ratingVal > 5) {
            return redirect()->back()->with('error', 'Data ulasan tidak valid.');
        }

        $ratingModel = new RatingBukuModel();
        $existingRating = $ratingModel->where('buku_id', $bukuId)
                                     ->where('anggota_id', $anggotaId)
                                     ->where('peminjaman_id IS NULL')
                                     ->first();

        if ($existingRating) {
            $ratingModel->update($existingRating['id'], [
                'rating' => $ratingVal
            ]);
        } else {
            $ratingModel->save([
                'buku_id' => $bukuId,
                'anggota_id' => $anggotaId,
                'peminjaman_id' => null,
                'rating' => $ratingVal
            ]);
        }

        $ulasanModel = new UlasanBukuModel();
        $existingUlasan = $ulasanModel->where('buku_id', $bukuId)
                                     ->where('anggota_id', $anggotaId)
                                     ->where('peminjaman_id IS NULL')
                                     ->first();

        if (!empty($ulasanVal)) {
            // Validasi batas karakter ulasan (20 - 1000)
            $len = strlen($ulasanVal);
            if ($len < 20 || $len > 1000) {
                return redirect()->back()->with('error', 'Ulasan harus memiliki panjang antara 20 dan 1000 karakter.');
            }

            if ($existingUlasan) {
                $ulasanModel->update($existingUlasan['id'], [
                    'ulasan' => $ulasanVal
                ]);
                session()->setFlashdata('success', '🐾 Ulasan ebook-mu berhasil diperbarui.');
            } else {
                $ulasanModel->save([
                    'buku_id' => $bukuId,
                    'anggota_id' => $anggotaId,
                    'peminjaman_id' => null,
                    'ulasan' => $ulasanVal
                ]);
                session()->setFlashdata('success', '💬 Terima kasih telah berbagi pengalaman membaca ebook di PawLib!');
            }
        } else {
            // Jika dikirim kosong, dan ulasan sebelumnya ada, maka hapus ulasan teks lamanya
            if ($existingUlasan) {
                $ulasanModel->delete($existingUlasan['id']);
            }
            session()->setFlashdata('success', '⭐ Terima kasih! Jejak paw-mu berhasil ditambahkan ke ebook ini.');
        }

        return redirect()->back();
    }
}