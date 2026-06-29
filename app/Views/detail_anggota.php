<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<!-- Impor Google Font Quicksand agar selaras dengan tema kucing yang bulat dan hangat -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Impor Font Awesome untuk ikon-ikon cantik -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<?php
    // Tanggal bergabung fallback aman jika tidak ditemukan di DB
    $tanggalBergabung = !empty($anggota['created_at']) ? date('d F Y', strtotime($anggota['created_at'])) : (!empty($anggota['tanggal_bergabung']) ? date('d F Y', strtotime($anggota['tanggal_bergabung'])) : '1 Juni 2026');
    
    // Validasi Foto profil
    $fotoField = !empty($anggota['foto']) ? $anggota['foto'] : '';
    $hasFoto = false;
    $fotoPath = '';
    if (!empty($fotoField)) {
        if (file_exists(FCPATH . 'uploads/profile/' . $fotoField)) {
            $fotoPath = '/uploads/profile/' . $fotoField;
            $hasFoto = true;
        } elseif (file_exists(FCPATH . 'uploads/' . $fotoField)) {
            $fotoPath = '/uploads/' . $fotoField;
            $hasFoto = true;
        }
    }
?>

<style>
/* CSS Utama bertema Cozy Cat & Minimalis */
.paw-container {
    font-family: 'Quicksand', sans-serif;
    color: #4a3c31;
}

/* Header & Tombol Kembali */
.header-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    flex-wrap: wrap;
    gap: 15px;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f0e2d3;
    color: #4a3c31 !important;
    padding: 12px 20px;
    border-radius: 12px;
    text-decoration: none !important;
    font-weight: 700;
    transition: all 0.2s;
    font-size: 0.9rem;
}

.btn-back:hover {
    background: #e0d0bf;
}

.btn-edit-member {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #4A90E2; /* Biru admin */
    color: white !important;
    padding: 12px 22px;
    border-radius: 12px;
    text-decoration: none !important;
    font-weight: 700;
    transition: all 0.2s;
    font-size: 0.9rem;
    box-shadow: 0 4px 10px rgba(74, 144, 226, 0.2);
}

.btn-edit-member:hover {
    background: #357ABD;
    transform: translateY(-1px);
}

/* Card Profil Utama */
.paw-profile-card {
    background: white;
    padding: 35px;
    border-radius: 24px;
    box-shadow: 0 8px 24px rgba(74, 60, 49, 0.04);
    border: 2px solid #f2e7dd;
    margin-bottom: 30px;
    display: flex;
    gap: 35px;
    align-items: center;
    flex-wrap: wrap;
}

.profile-avatar-wrapper {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    background-color: #FBE7D4;
    color: #E69C62;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    font-weight: 700;
    border: 4px solid #FBE7D4;
    box-shadow: 0 6px 15px rgba(230, 156, 98, 0.12);
    overflow: hidden;
    flex-shrink: 0;
    text-transform: uppercase;
}

.profile-avatar-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-info {
    flex: 1 1 300px;
}

.profile-name {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2E2118;
    margin: 0 0 6px 0;
    text-transform: capitalize;
}

.profile-code-badge {
    background-color: #FBE7D4;
    color: #E69C62;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    display: inline-block;
    margin-bottom: 15px;
}

.profile-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px 25px;
}

.profile-detail-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.95rem;
    color: #756456;
    font-weight: 600;
}

.profile-detail-item i {
    color: #E69C62;
    width: 16px;
    text-align: center;
}

/* Statistik Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 35px;
}

.stat-card {
    background: white;
    border: 2px solid #f2e7dd;
    border-radius: 20px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 4px 12px rgba(74, 60, 49, 0.02);
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-icon-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.icon-purple {
    background-color: #f3effc;
    color: #8E44AD;
}

.icon-blue {
    background-color: #eaf2fc;
    color: #4A90E2;
}

.icon-green {
    background-color: #e2f9e1;
    color: #1e6b26;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-num {
    font-size: 1.6rem;
    font-weight: 700;
    color: #2E2118;
    line-height: 1.2;
}

.stat-label {
    font-size: 0.85rem;
    color: #8c7b70;
    font-weight: 600;
}

/* Tabel Transaksi Modern */
.section-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2E2118;
    margin-top: 10px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.table-container {
    width: 100%;
    overflow-x: auto;
    background: white;
    border-radius: 20px;
    border: 2px solid #f2e7dd;
    box-shadow: 0 8px 18px rgba(74, 60, 49, 0.03);
    margin-bottom: 30px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 16px 20px;
    text-align: left;
    vertical-align: middle;
}

th {
    background: #FAF6F0;
    color: #4a3c31;
    font-weight: 700;
    font-size: 0.95rem;
    border-bottom: 2px solid #f2e7dd;
}

tr {
    border-bottom: 1px solid #f2e7dd;
    transition: background-color 0.2s;
}

tr:hover {
    background-color: #fffdfb;
}

tr:last-child {
    border-bottom: none;
}

/* Status Badges */
.status-badge {
    font-size: 0.75rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.badge-dipinjam {
    background-color: #fff2e8;
    color: #E69C62;
    border: 1px solid rgba(230, 156, 98, 0.15);
}

.badge-dikembalikan {
    background-color: #e2f9e1;
    color: #1e6b26;
    border: 1px solid rgba(30, 107, 38, 0.15);
}

.empty-state {
    text-align: center;
    padding: 40px !important;
    color: #8c7b70;
    font-weight: 600;
}
</style>

<div class="paw-container">
    <!-- Header Actions -->
    <div class="header-actions">
        <a href="/anggota" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Anggota
        </a>
        <a href="/anggota/edit/<?= $anggota['id'] ?>" class="btn-edit-member">
            <i class="fas fa-edit"></i> Edit Anggota
        </a>
    </div>

    <!-- Halaman Detail: Identitas Anggota -->
    <div class="paw-profile-card">
        <div class="profile-avatar-wrapper">
            <?php if ($hasFoto): ?>
                <img src="<?= $fotoPath ?>" alt="<?= esc($anggota['nama']) ?>">
            <?php else: ?>
                <?= strtoupper(substr($anggota['nama'], 0, 1)) ?>
            <?php endif; ?>
        </div>
        <div class="profile-info">
            <h2 class="profile-name"><?= esc($anggota['nama']) ?></h2>
            <span class="profile-code-badge"><?= esc($anggota['kode_anggota'] ?? '-') ?></span>
            
            <div class="profile-details-grid">
                <div class="profile-detail-item">
                    <i class="far fa-envelope"></i>
                    <span><?= esc($anggota['gmail']) ?></span>
                </div>
                <div class="profile-detail-item">
                    <i class="fas fa-phone-alt"></i>
                    <span><?= esc($anggota['nomor']) ?></span>
                </div>
                <div class="profile-detail-item">
                    <i class="far fa-calendar-alt"></i>
                    <span>Bergabung: <?= $tanggalBergabung ?></span>
                </div>
                <div class="profile-detail-item">
                    <i class="fas fa-id-badge"></i>
                    <span>ID Sistem: <?= esc($anggota['id']) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Halaman Detail: Statistik Aktivitas -->
    <h3 class="section-title"><i class="fas fa-chart-pie" style="color: #E69C62;"></i> Statistik Aktivitas</h3>
    <div class="stats-grid">
        <!-- Total Buku Pernah Dipinjam -->
        <div class="stat-card">
            <div class="stat-icon-wrapper icon-purple">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-info">
                <span class="stat-num"><?= $total_pinjam ?></span>
                <span class="stat-label">Total Pernah Dipinjam</span>
            </div>
        </div>

        <!-- Buku Sedang Dipinjam -->
        <div class="stat-card">
            <div class="stat-icon-wrapper icon-blue">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-info">
                <span class="stat-num"><?= $sedang_dipinjam ?></span>
                <span class="stat-label">Sedang Dipinjam</span>
            </div>
        </div>

        <!-- Buku Sudah Kembali -->
        <div class="stat-card">
            <div class="stat-icon-wrapper icon-green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <span class="stat-num"><?= $sudah_kembali ?></span>
                <span class="stat-label">Sudah Dikembalikan</span>
            </div>
        </div>
    </div>

    <!-- Halaman Detail: Riwayat Peminjaman -->
    <h3 class="section-title"><i class="fas fa-history" style="color: #E69C62;"></i> Riwayat Aktivitas Peminjaman</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Kode Pinjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($riwayat)): ?>
                    <tr>
                        <td colspan="5" class="empty-state">
                            <i class="fas fa-info-circle mr-1" style="font-size: 1.2rem;"></i> Anggota ini belum pernah melakukan peminjaman buku.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($riwayat as $r): ?>
                        <?php
                            $status = strtolower($r['status'] ?? '');
                            $isDipinjam = ($status == 'dipinjam' || $status == 'belum kembali' || empty($r['tanggal_kembali']));
                        ?>
                        <tr>
                            <td><strong><?= esc($r['kode_peminjaman'] ?? ($r['kode_pinjam'] ?? 'TR' . str_pad($r['id'], 3, '0', STR_PAD_LEFT))) ?></strong></td>
                            <td style="color: #2E2118; font-weight: 700;"><?= esc($r['judul'] ?? 'Buku Tidak Diketahui') ?></td>
                            <td><?= !empty($r['tanggal_pinjam']) ? date('d M Y', strtotime($r['tanggal_pinjam'])) : '-' ?></td>
                            <td><?= !empty($r['tanggal_kembali']) ? date('d M Y', strtotime($r['tanggal_kembali'])) : '-' ?></td>
                            <td>
                                <?php if ($isDipinjam): ?>
                                    <span class="status-badge badge-dipinjam">
                                        <i class="fas fa-hourglass-half"></i> Sedang Dipinjam
                                    </span>
                                <?php else: ?>
                                    <span class="status-badge badge-dikembalikan">
                                        <i class="fas fa-check-circle"></i> Dikembalikan
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('layout/footer'); ?>