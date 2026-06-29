<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<!-- Impor Google Font Quicksand agar selaras dengan tema kucing yang bulat dan hangat -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Impor Font Awesome untuk ikon-ikon cantik -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
.paw-container {
    font-family: 'Quicksand', sans-serif;
    color: #4a3c31;
}

.paw-title-card {
    background: white;
    padding: 30px;
    border-radius: 24px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.04);
    border: 2px solid #f2e7dd;
    margin-bottom: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.btn-tambah {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #E69C62;
    color: white !important;
    padding: 12px 22px;
    border-radius: 14px;
    text-decoration: none !important;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(230, 156, 98, 0.2);
    transition: all 0.2s ease;
}

.btn-tambah:hover {
    background: #c8814a;
    transform: translateY(-1px);
}

table {
    width: 100%;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 18px rgba(0,0,0,0.04);
    border-collapse: collapse;
    border: 2px solid #f2e7dd;
}

th, td {
    padding: 16px 18px;
    text-align: left;
    font-family: 'Quicksand', sans-serif;
    font-weight: 600;
    font-size: 0.95rem;
}

th {
    background: #FBE7D4;
    color: #4a3c31;
    font-weight: 700;
}

tr {
    border-bottom: 1px solid #f2e7dd;
    transition: background-color 0.2s;
}

tr:last-child {
    border-bottom: none;
}

tr:hover {
    background-color: #fffbf9;
}

.badge-status {
    padding: 5px 12px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.status-telat {
    background-color: #ffebee;
    color: #c62828;
    border: 1px solid rgba(198, 40, 40, 0.15);
}

.status-kembali {
    background-color: #eafaf1;
    color: #2ecc71;
    border: 1px solid rgba(46, 204, 113, 0.15);
}

.status-pinjam {
    background-color: #fffde7;
    color: #f39c12;
    border: 1px solid rgba(243, 156, 18, 0.15);
}

.status-diajukan {
    background-color: #e3f2fd;
    color: #1e88e5;
    border: 1px solid rgba(30, 136, 229, 0.15);
}

.btn-lihat {
    background: #f0e2d3;
    color: #4a3c31 !important;
    padding: 8px 14px;
    border-radius: 10px;
    text-decoration: none !important;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.85rem;
    transition: all 0.2s;
}

.btn-lihat:hover {
    background: #e0d0bf;
}

.btn-hapus-action {
    background: #ffe5e5;
    color: #c0392b !important;
    padding: 8px 14px;
    border-radius: 10px;
    text-decoration: none !important;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.85rem;
    transition: all 0.2s;
    border: 1px solid rgba(192, 57, 43, 0.1);
    margin-left: 6px;
}

.btn-hapus-action:hover {
    background: #ffd3d3;
}

input:focus {
    outline: none;
    border-color: #E69C62 !important;
    box-shadow: 0 0 0 4px rgba(230, 156, 98, 0.15);
}
</style>

<div class="paw-container">
    <!-- Header Banner Card -->
    <div class="paw-title-card">
        <div style="margin: 0;">
            <h1 style="margin: 0; font-weight: 700; color: #2E2118; font-size: 28px;">Peminjaman Buku Fisik 📖</h1>
            <p style="margin: 5px 0 0 0; color: #8c7b70; font-size: 0.9rem; font-weight: 600;">Kelola rekam jejak peminjaman printed book perpustakaan PawLib.</p>
        </div>
        <a href="/peminjaman/tambah" class="btn-tambah">
            <i class="fas fa-plus"></i> Tambah Peminjaman
        </a>
    </div>

    <!-- Search Filter Row -->
    <div style="background: white; padding: 20px; border-radius: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); border: 2px solid #f2e7dd; margin-bottom: 25px;">
        <form action="/peminjaman" method="get" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <div style="flex-grow: 1; min-width: 250px; position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #8c7b70; opacity: 0.7;"></i>
                <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama anggota, judul buku, atau status..." style="width: 100%; padding: 12px 15px 12px 42px; border: 2px solid #ebd5c5; border-radius: 14px; font-family: 'Quicksand', sans-serif; font-weight: 600; font-size: 0.95rem; box-sizing: border-box; color: #4a3c31; transition: all 0.3s ease;">
            </div>
            <button type="submit" style="background: #E69C62; color: white; padding: 12px 24px; border: none; border-radius: 14px; font-family: 'Quicksand', sans-serif; font-weight: bold; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 10px rgba(230,156,98,0.2); transition: all 0.2s; font-size: 0.95rem;">
                Cari
            </button>
            <?php if (!empty($keyword)): ?>
                <a href="/peminjaman" style="background: #f0e2d3; color: #4a3c31; padding: 12px 24px; border-radius: 14px; font-family: 'Quicksand', sans-serif; font-weight: bold; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; font-size: 0.95rem;">
                    Reset
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th width="50">ID</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($peminjaman)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 35px; color: #8c7b70;">
                            Belum ada data transaksi peminjaman.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($peminjaman as $p): ?>
                        <?php 
                            $status = strtolower($p['status'] ?? '');
                            $today = strtotime(date('Y-m-d'));
                            $tanggalKembali = strtotime($p['tanggal_kembali'] ?? '');
                            $isOverdue = ($status === 'dipinjam' && $today > $tanggalKembali);
                        ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td><strong><?= esc($p['nama_anggota'] ?? 'ID: ' . $p['anggota_id']) ?></strong></td>
                            <td><?= esc($p['judul_buku'] ?? 'ID: ' . $p['buku_id']) ?></td>
                            <td><?= isset($p['tanggal_pinjam']) ? date('d M Y', strtotime($p['tanggal_pinjam'])) : '-' ?></td>
                            <td><?= isset($p['tanggal_kembali']) ? date('d M Y', strtotime($p['tanggal_kembali'])) : '-' ?></td>
                            <td>
                                <?php if ($status === 'dikembalikan'): ?>
                                    <span class="badge-status status-kembali">
                                        <i class="fas fa-check-circle"></i> Dikembalikan
                                    </span>
                                <?php elseif ($status === 'diajukan'): ?>
                                    <span class="badge-status status-diajukan">
                                        <i class="fas fa-clock"></i> Diajukan
                                    </span>
                                <?php elseif ($isOverdue): ?>
                                    <span class="badge-status status-telat">
                                        <i class="fas fa-exclamation-triangle"></i> Terlambat
                                    </span>
                                <?php else: ?>
                                    <span class="badge-status status-pinjam">
                                        <i class="fas fa-hourglass-half"></i> Dipinjam
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px; align-items: center; white-space: nowrap;">
                                    <a href="/peminjaman/detail/<?= $p['id'] ?>" class="btn-lihat">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="/peminjaman/hapus/<?= $p['id'] ?>" class="btn-hapus-action" style="margin-left: 0;" onclick="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('layout/footer'); ?>