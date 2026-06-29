<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamannewModel extends Model
{
    protected $table      = 'peminjaman';       // nama tabel di database
    protected $primaryKey = 'id_peminjaman';    // kolom kunci utama

    // Daftar kolom yang boleh disimpan/diupdate
    // PENTING: kolom yang tidak ada di sini tidak akan tersimpan
    protected $allowedFields = [
        'kode_peminjaman',
        'id_member',
        'id_book',
        'tanggal_pinjam',
        'batas_kembali',
        'tanggal_dikembalikan',
        'durasi_pinjam',
        'status',
    ];

    protected $useTimestamps = true; // aktifkan created_at dan updated_at otomatis

    /**
     * Mengambil data peminjaman berdasarkan ID Member beserta informasi detail buku.
     *
     * @param mixed $id_member ID dari member/anggota perpustakaan
     * @return array List data peminjaman beserta detail buku
     */
    public function getByMember($id_member)
    {
        return $this->select('peminjaman.*, buku.judul, buku.cover, buku.foto')
                    ->join('buku', 'buku.id = peminjaman.id_book', 'left')
                    ->where('peminjaman.id_member', $id_member)
                    ->orderBy('peminjaman.id_peminjaman', 'DESC')
                    ->findAll();
    }
}
