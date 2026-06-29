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
    max-width: 900px;
}

.paw-card {
    background: white;
    padding: 35px;
    border-radius: 28px;
    box-shadow: 0 10px 25px rgba(230, 156, 98, 0.08);
    border: 2px solid #f2e7dd;
    margin-bottom: 25px;
}

.paw-layout {
    display: flex;
    flex-wrap: wrap;
    gap: 35px;
    align-items: flex-start;
}

.paw-left {
    flex: 1 1 240px;
    max-width: 260px;
    text-align: center;
}

.paw-right {
    flex: 2 1 350px;
}

/* Wrapper Cover Buku */
.paw-img-wrapper {
    background-color: #fffaf5;
    border: 2px solid #f2e7dd;
    border-radius: 20px;
    box-shadow: 0 6px 15px rgba(74, 60, 49, 0.05);
    overflow: hidden;
    height: 330px;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

.paw-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.default-cover-svg {
    width: 100%;
    height: 100%;
}

/* Metadata List */
.paw-meta-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-top: 15px;
    margin-bottom: 25px;
}

.paw-meta-item {
    display: flex;
    align-items: center;
    padding: 14px 18px;
    background-color: #fffcf9;
    border-radius: 16px;
    border: 1px solid #f9efe6;
    gap: 15px;
}

.paw-meta-icon {
    font-size: 1.4rem;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.paw-meta-content {
    display: flex;
    flex-direction: column;
    gap: 2px;
    flex-grow: 1;
}

.paw-meta-label {
    font-size: 0.75rem;
    font-weight: 700;
    color: #8c7b70;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.paw-meta-value {
    font-size: 0.95rem;
    font-weight: 700;
    color: #4a3c31;
}

/* Badge Status */
.badge-status {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
    width: fit-content;
    text-transform: uppercase;
    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
}

.badge-diajukan {
    background-color: #fff9e6;
    color: #d4ac0d;
    border: 1px solid rgba(212, 172, 13, 0.15);
}

.badge-disetujui, .badge-dipinjam {
    background-color: #eafaf1;
    color: #2ecc71;
    border: 1px solid rgba(46, 204, 113, 0.15);
}

.badge-selesai, .badge-dikembalikan {
    background-color: #eaf2fc;
    color: #4a90e2;
    border: 1px solid rgba(74, 144, 226, 0.15);
}

.badge-ditolak, .badge-terlambat {
    background-color: #fdf2f2;
    color: #e74c3c;
    border: 1px solid rgba(231, 76, 60, 0.15);
}

/* Buttons */
.btn-action-back {
    padding: 12px 24px;
    background: #c0b3a7;
    color: white !important;
    text-decoration: none !important;
    border-radius: 14px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'Quicksand', sans-serif;
    transition: all 0.2s ease;
    box-shadow: 0 4px 10px rgba(192, 179, 167, 0.2);
}

.btn-action-back:hover {
    background: #a89a8e;
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .paw-left {
        max-width: 100%;
        flex: 1 1 100%;
    }
    .paw-layout {
        gap: 20px;
    }
}
</style>

<div class="paw-container">
    
    <div class="paw-card">
        <h3 style="font-family: 'Quicksand', sans-serif; font-weight: 700; font-size: 1.4rem; color: #2E2118; margin-top: 0; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-paw" style="color: #E69C62;"></i> Detail Transaksi Peminjaman
        </h3>

        <div class="paw-layout">
            <!-- Sisi Kiri: Buku Cover & Penulis -->
            <div class="paw-left">
                <?php 
                    $coverField = !empty($pinjam['foto']) ? $pinjam['foto'] : (!empty($pinjam['cover']) ? $pinjam['cover'] : '');
                    $coverPath = '/images/default_cover.svg';
                    if (!empty($coverField)) {
                        if (file_exists(FCPATH . 'uploads/' . $coverField)) {
                            $coverPath = '/uploads/' . $coverField;
                        } elseif (file_exists(FCPATH . 'uploads/cover/' . $coverField)) {
                            $coverPath = '/uploads/cover/' . $coverField;
                        } else {
                            $coverPath = '/uploads/' . $coverField; 
                        }
                    }
                ?>
                <div class="paw-img-wrapper">
                    <?php if ($coverPath == '/images/default_cover.svg'): ?>
                        <svg class="default-cover-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400">
                          <rect width="100%" height="100%" fill="#fff5ec"/>
                          <rect x="10" y="10" width="280" height="380" fill="none" stroke="#f2e7dd" stroke-width="2" rx="10"/>
                          <g transform="translate(150, 180)">
                            <path d="M -20 10 C -20 -5, -10 -15, 0 -15 C 10 -15, 20 -5, 20 10 C 20 20, 10 25, 0 25 C -10 25, -20 20, -20 10 Z" fill="#E69C62" opacity="0.6"/>
                            <circle cx="-20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                            <circle cx="-7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                            <circle cx="7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                            <circle cx="20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                          </g>
                          <text x="150" y="270" font-family="'Quicksand', sans-serif" font-weight="bold" font-size="16" fill="#8c7b70" text-anchor="middle">PAWLIB</text>
                        </svg>
                    <?php else: ?>
                        <img src="<?= $coverPath ?>" alt="<?= esc($pinjam['judul']); ?>" class="paw-img">
                    <?php endif; ?>
                </div>
                
                <h4 style="margin: 15px 0 5px 0; font-size: 1.05rem; font-weight: 700; color: #4a3c31;"><?= esc($pinjam['judul']) ?></h4>
                <p style="margin: 0; font-size: 0.85rem; color: #8c7b70; font-weight: 600;">Oleh: <?= esc($pinjam['penulis'] ?? '-') ?></p>
            </div>

            <!-- Sisi Kanan: Metadata Transaksi -->
            <div class="paw-right">
                <div class="paw-meta-list">
                    <!-- Anggota Peminjam -->
                    <div class="paw-meta-item">
                        <div class="paw-meta-icon">
                            <i class="fas fa-user-circle" style="color: #4A90E2;"></i>
                        </div>
                        <div class="paw-meta-content">
                            <span class="paw-meta-label">Nama Peminjam</span>
                            <span class="paw-meta-value"><?= esc($pinjam['nama']) ?></span>
                        </div>
                    </div>

                    <!-- Tanggal Pinjam -->
                    <div class="paw-meta-item">
                        <div class="paw-meta-icon">
                            <i class="far fa-calendar-plus" style="color: #2ECC71;"></i>
                        </div>
                        <div class="paw-meta-content">
                            <span class="paw-meta-label">Tanggal Pinjam</span>
                            <span class="paw-meta-value"><?= date('d M Y', strtotime($pinjam['tanggal_pinjam'])) ?></span>
                        </div>
                    </div>

                    <!-- Batas Pengembalian -->
                    <div class="paw-meta-item">
                        <div class="paw-meta-icon">
                            <i class="far fa-calendar-check" style="color: #E74C3C;"></i>
                        </div>
                        <div class="paw-meta-content">
                            <span class="paw-meta-label">Batas Pengembalian</span>
                            <span class="paw-meta-value"><?= date('d M Y', strtotime($pinjam['tanggal_kembali'])) ?></span>
                        </div>
                    </div>

                    <!-- Tanggal Dikembalikan (Opsional) -->
                    <?php if (!empty($pinjam['tanggal_dikembalikan'])): ?>
                        <div class="paw-meta-item" style="background-color: #f4faf6; border-color: #d1ebd9;">
                            <div class="paw-meta-icon">
                                <i class="fas fa-calendar-check" style="color: #2ECC71;"></i>
                            </div>
                            <div class="paw-meta-content">
                                <span class="paw-meta-label">Tanggal Dikembalikan</span>
                                <span class="paw-meta-value" style="color: #1e6b26;">
                                    <?= date('d M Y', strtotime($pinjam['tanggal_dikembalikan'])) ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Status Peminjaman -->
                    <div class="paw-meta-item">
                        <div class="paw-meta-icon">
                            <i class="fas fa-circle-info" style="color: #E69C62;"></i>
                        </div>
                        <div class="paw-meta-content">
                            <span class="paw-meta-label">Status Transaksi</span>
                            <?php 
                                $statusLower = strtolower($pinjam['status'] ?? '');
                                $today = strtotime(date('Y-m-d'));
                                $tanggalKembali = strtotime($pinjam['tanggal_kembali'] ?? '');
                                $isOverdue = ($statusLower === 'dipinjam' && $today > $tanggalKembali);

                                if ($isOverdue) {
                                    $statusClass = 'badge-terlambat';
                                    $statusText = 'Terlambat Mengembalikan (Overdue)';
                                } else {
                                    $statusClass = 'badge-' . str_replace(' ', '', $statusLower);
                                    if ($statusLower === 'diajukan') {
                                        $statusText = 'Pengajuan Pengembalian (Menunggu Verifikasi)';
                                    } elseif ($statusLower === 'dipinjam') {
                                        $statusText = 'Sedang Aktif Dipinjam';
                                    } elseif ($statusLower === 'selesai' || $statusLower === 'dikembalikan') {
                                        $statusText = 'Selesai (Buku Dikembalikan)';
                                    } else {
                                        $statusText = esc($pinjam['status']);
                                    }
                                }
                            ?>
                            <span class="badge-status <?= $statusClass ?>">
                                <?= $statusText ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 30px; border-top: 2px dashed #f2e7dd; padding-top: 20px; display: flex; justify-content: flex-end;">
            <a href="/peminjaman" class="btn-action-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<?= $this->include('layout/footer'); ?>
