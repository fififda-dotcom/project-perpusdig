<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<!-- Impor Google Font Quicksand agar selaras dengan tema kucing yang bulat dan hangat -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Impor Font Awesome untuk ikon-ikon cantik -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
/* CSS Utama bertema Cozy Cat & Profile Page */
.paw-container {
    font-family: 'Quicksand', sans-serif;
    color: #4a3c31;
}

h1 {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 32px;
    color: #4a3c31;
    margin-top: 0px !important; 
    margin-bottom: 20px !important;
}

/* Card Profil Utama */
.paw-profile-card {
    background: white;
    padding: 35px;
    border-radius: 24px;
    box-shadow: 0 8px 20px rgba(74, 60, 49, 0.05);
    border: 2px solid #f2e7dd;
    margin-bottom: 30px;
}

/* Layout Profil (Foto di kiri, Data di kanan pada desktop) */
.paw-profile-layout {
    display: flex;
    flex-wrap: wrap;
    gap: 35px;
    align-items: flex-start;
}

.paw-profile-left {
    flex: 1 1 200px;
    max-width: 240px;
    text-align: center;
}

.paw-profile-right {
    flex: 2 1 350px;
}

/* Foto Profil Lingkaran */
.paw-avatar-wrapper {
    position: relative;
    width: 180px;
    height: 180px;
    margin: 0 auto 20px auto;
    border-radius: 50%;
    border: 5px solid #FBE7D4;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(230, 156, 98, 0.15);
    background-color: #fff9f5;
    display: flex;
    justify-content: center;
    align-items: center;
}

.paw-avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.paw-role-badge {
    background-color: #E69C62;
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.85rem;
    display: inline-block;
    box-shadow: 0 4px 10px rgba(230, 156, 98, 0.2);
}

/* Data List Detail */
.paw-info-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #4a3c31;
    margin-bottom: 5px;
}

.paw-info-subtitle {
    font-size: 1rem;
    color: #E69C62;
    font-weight: 700;
    letter-spacing: 0.5px;
    margin-bottom: 25px;
}

.paw-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 15px;
    margin-bottom: 30px;
}

.paw-info-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 15px;
    background-color: #fffcf9;
    border-radius: 12px;
    border: 1px solid #f9efe6;
}

.paw-info-icon {
    font-size: 1.25rem;
    color: #E69C62;
    width: 25px;
    text-align: center;
}

.paw-info-text {
    display: flex;
    flex-direction: column;
}

.paw-info-label {
    font-size: 0.75rem;
    color: #8c7b70;
    font-weight: 700;
    text-transform: uppercase;
}

.paw-info-value {
    font-size: 0.95rem;
    font-weight: 600;
    color: #4a3c31;
}

/* Grid Statistik Aktivitas Membaca */
.paw-stats-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #4a3c31;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.paw-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    margin-top: 10px;
}

.paw-stat-card {
    padding: 20px;
    border-radius: 18px;
    border: 2px solid transparent;
    text-align: center;
    transition: transform 0.2s ease;
}

.paw-stat-card:hover {
    transform: translateY(-4px);
}

.stat-total {
    background-color: #fff3eb;
    border-color: #fce7da;
}
.stat-total .paw-stat-icon { color: #E69C62; }

.stat-pinjam {
    background-color: #fdf8e2;
    border-color: #faf0c2;
}
.stat-pinjam .paw-stat-icon { color: #f39c12; }

.stat-kembali {
    background-color: #eafaf1;
    border-color: #d4f5e3;
}
.stat-kembali .paw-stat-icon { color: #2ecc71; }

/* Styling Card Denda Baru */
.stat-denda {
    background-color: #f7f5f2;
    border-color: #e8e4e0;
}
.stat-denda .paw-stat-icon { color: #a89d90; }

.stat-denda-warning {
    background-color: #fff1f0;
    border-color: #ffd8d6;
}
.stat-denda-warning .paw-stat-icon { color: #e74c3c; }
.stat-denda-warning .paw-stat-count { color: #c0392b; }

.paw-stat-icon {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
}

.paw-stat-count {
    font-size: 1.8rem;
    font-weight: 700;
    color: #4a3c31;
    line-height: 1.2;
}

.paw-stat-label {
    font-size: 0.85rem;
    font-weight: 700;
    color: #8c7b70;
}

/* Button Custom Styles */
.btn-paw-edit {
    background: #E69C62;
    color: white !important;
    padding: 12px 24px;
    border: none;
    border-radius: 12px;
    font-weight: bold;
    font-family: 'Quicksand', sans-serif;
    font-size: 1rem;
    box-shadow: 0 4px 12px rgba(230, 156, 98, 0.25);
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.btn-paw-edit:hover {
    background: #c8814a;
    transform: translateY(-1px);
    text-decoration: none;
}

/* Custom Styles untuk Modal */
.paw-modal-content {
    border-radius: 24px;
    border: 2px solid #f2e7dd;
    font-family: 'Quicksand', sans-serif;
}

.paw-modal-header {
    background-color: #FFF9F3;
    border-bottom: 2px solid #f2e7dd;
    border-radius: 22px 22px 0 0;
    color: #4a3c31;
}

.paw-modal-title {
    font-weight: 700;
}

.paw-modal-footer {
    border-top: 1px solid #f2e7dd;
}
</style>

<div class="paw-container">
    <h1>Profil Pengguna</h1>

    <!-- Notifikasi Flashdata Sukses / Error -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm" style="border-radius: 12px; font-weight: 600; font-family: 'Quicksand', sans-serif; background-color: #eafaf1; color: #2ecc71; padding: 15px; margin-bottom: 20px;">
            🐾 <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 12px; font-weight: 600; font-family: 'Quicksand', sans-serif; background-color: #fdf0ee; color: #e74c3c; padding: 15px; margin-bottom: 20px;">
            ⚠️ <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Card Profil Utama -->
    <div class="paw-profile-card">
        <div class="paw-profile-layout">
            
            <!-- Kolom Kiri: Foto Profil & Role -->
            <div class="paw-profile-left">
                <div class="paw-avatar-wrapper">
                    <?php 
                        $fotoPath = '/images/default_avatar.svg'; // Placeholder default
                        if (!empty($anggota['foto'])) {
                            if (file_exists(FCPATH . 'uploads/profile/' . $anggota['foto'])) {
                                $fotoPath = '/uploads/profile/' . $anggota['foto'];
                            }
                        }
                    ?>
                    <?php if ($fotoPath == '/images/default_avatar.svg'): ?>
                        <svg class="paw-avatar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                          <circle cx="50" cy="50" r="50" fill="#FFF2E6"/>
                          <path d="M 30 65 Q 50 85 70 65 L 70 50 Q 75 40 65 42 Q 50 35 35 42 Q 25 40 30 50 Z" fill="#E69C62"/>
                          <polygon points="32,44 26,30 38,36" fill="#e68144"/>
                          <polygon points="68,44 74,30 62,36" fill="#e68144"/>
                          <circle cx="43" cy="50" r="3" fill="#4a3c31"/>
                          <circle cx="57" cy="50" r="3" fill="#4a3c31"/>
                          <polygon points="48,54 52,54 50,56" fill="#e74c3c"/>
                        </svg>
                    <?php else: ?>
                        <img src="<?= base_url($fotoPath) ?>" alt="Foto Profil" class="paw-avatar">
                    <?php endif; ?>
                </div>
                <div class="paw-role-badge">
                    <i class="fas fa-id-badge mr-1"></i> <?= strtoupper($role) ?>
                </div>
            </div>

            <!-- Kolom Kanan: Identitas Lengkap -->
            <div class="paw-profile-right">
                <h2 class="paw-info-title"><?= esc($anggota['nama']) ?></h2>
                <div class="paw-info-subtitle">🐾 <?= $role == 'admin' ? 'Akses Level: Administrator' : 'Member ID: ' . esc($anggota['kode_anggota'] ?? 'AGT' . str_pad($anggota['id'] ?? 1, 3, '0', STR_PAD_LEFT)) ?></div>
                
                <div class="paw-info-grid">
                    <!-- Username -->
                    <div class="paw-info-item">
                        <i class="fas fa-at paw-info-icon"></i>
                        <div class="paw-info-text">
                            <span class="paw-info-label">Username</span>
                            <span class="paw-info-value"><?= esc($anggota['username'] ?? 'belum diatur') ?></span>
                        </div>
                    </div>
                    
                    <!-- Email (Membaca kolom 'gmail' di database Anda) -->
                    <div class="paw-info-item">
                        <i class="fas fa-envelope paw-info-icon"></i>
                        <div class="paw-info-text">
                            <span class="paw-info-label">Email (Gmail)</span>
                            <span class="paw-info-value"><?= esc($anggota['gmail'] ?? 'belum diatur') ?></span>
                        </div>
                    </div>

                    <!-- Nomor HP (Membaca kolom 'nomor' di database Anda) -->
                    <div class="paw-info-item">
                        <i class="fas fa-phone paw-info-icon"></i>
                        <div class="paw-info-text">
                            <span class="paw-info-label">Nomor Telepon</span>
                            <span class="paw-info-value"><?= esc($anggota['nomor'] ?? '-') ?></span>
                        </div>
                    </div>

                    <!-- Keanggotaan / Level Akses -->
                    <div class="paw-info-item">
                        <i class="fas fa-user-shield paw-info-icon"></i>
                        <div class="paw-info-text">
                            <span class="paw-info-label">Level Akses</span>
                            <span class="paw-info-value"><?= $role == 'admin' ? 'Administrator Utama' : 'Anggota Aktif' ?></span>
                        </div>
                    </div>
                </div>

                <?php if ($role == 'anggota'): ?>
                    <!-- Tombol Edit Profil -->
                    <button type="button" class="btn-paw-edit" data-toggle="modal" data-target="#editProfilModal">
                        <i class="fas fa-user-edit"></i> Edit Profil Saya
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Section Statistik -->
    <div class="paw-profile-card">
        <?php if ($role == 'admin'): ?>
            <h3 class="paw-stats-title"><i class="fas fa-chart-pie" style="color: #E69C62;"></i> Statistik Global Perpustakaan</h3>
            <p class="text-muted mb-4">Ringkasan data operasional perpustakaan digital PawLib.</p>
            
            <div class="paw-stats-grid">
                <!-- Total Koleksi Buku -->
                <div class="paw-stat-card stat-total">
                    <i class="fas fa-book paw-stat-icon"></i>
                    <div class="paw-stat-count"><?= $total_buku ?></div>
                    <div class="paw-stat-label">Total Judul Buku</div>
                </div>
                
                <!-- Total Anggota Terdaftar -->
                <div class="paw-stat-card stat-kembali">
                    <i class="fas fa-users paw-stat-icon"></i>
                    <div class="paw-stat-count"><?= $total_anggota ?></div>
                    <div class="paw-stat-label">Anggota Terdaftar</div>
                </div>

                <!-- Sedang Dipinjam -->
                <div class="paw-stat-card stat-pinjam">
                    <i class="fas fa-hourglass-half paw-stat-icon"></i>
                    <div class="paw-stat-count"><?= $sedang_dipinjam ?></div>
                    <div class="paw-stat-label">Buku Sedang Dipinjam</div>
                </div>

                <!-- Total Denda Global -->
                <div class="paw-stat-card <?= $total_denda > 0 ? 'stat-denda-warning' : 'stat-denda' ?>">
                    <i class="fas fa-money-bill-wave paw-stat-icon"></i>
                    <div class="paw-stat-count">Rp <?= number_format($total_denda, 0, ',', '.') ?></div>
                    <div class="paw-stat-label">Akumulasi Denda Global</div>
                </div>
            </div>
        <?php else: ?>
            <h3 class="paw-stats-title"><i class="fas fa-chart-line" style="color: #E69C62;"></i> Statistik Aktivitas Membaca</h3>
            <p class="text-muted mb-4">Grafik rekapitulasi data peminjaman buku Anda di PawLib digital library.</p>
            
            <div class="paw-stats-grid">
                <!-- Total Buku Pernah Dipinjam -->
                <div class="paw-stat-card stat-total">
                    <i class="fas fa-book-reader paw-stat-icon"></i>
                    <div class="paw-stat-count"><?= $total_pinjam ?></div>
                    <div class="paw-stat-label">Total Buku Dipinjam</div>
                </div>
                
                <!-- Sedang Dipinjam -->
                <div class="paw-stat-card stat-pinjam">
                    <i class="fas fa-hourglass-half paw-stat-icon"></i>
                    <div class="paw-stat-count"><?= $sedang_dipinjam ?></div>
                    <div class="paw-stat-label">Sedang Dipinjam</div>
                </div>

                <!-- Sudah Dikembalikan -->
                <div class="paw-stat-card stat-kembali">
                    <i class="fas fa-check-double paw-stat-icon"></i>
                    <div class="paw-stat-count"><?= $sudah_kembali ?></div>
                    <div class="paw-stat-label">Sudah Dikembalikan</div>
                </div>

                <!-- Total Denda Saya -->
                <div class="paw-stat-card <?= $total_denda > 0 ? 'stat-denda-warning' : 'stat-denda' ?>">
                    <i class="fas fa-money-bill-wave paw-stat-icon"></i>
                    <div class="paw-stat-count">Rp <?= number_format($total_denda, 0, ',', '.') ?></div>
                    <div class="paw-stat-label">Total Denda Saya</div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($role == 'anggota'): ?>
        <!-- Section Ebook Sedang Dibaca -->
        <div class="paw-profile-card">
            <h3 class="paw-stats-title"><i class="fas fa-book-reader" style="color: #E69C62;"></i> Ebook yang Sedang Dibaca</h3>
            <p class="text-muted mb-4">Lanjutkan petualangan membacamu di perpustakaan digital PawLib.</p>
            
            <?php if (empty($progressMembaca)): ?>
                <div style="text-align: center; padding: 30px; border: 2px dashed #f2e7dd; border-radius: 20px; color: #8c7b70;">
                    <div style="font-size: 3rem; margin-bottom: 10px;">🐾</div>
                    <h5 style="font-weight: 700; color: #4a3c31; margin-bottom: 5px;">Belum ada bacaan aktif</h5>
                    <p style="font-size: 0.9rem;">Kamu belum membaca ebook apa pun. Yuk cari ebook seru di katalog!</p>
                    <a href="/katalog?jenis_koleksi=ebook" class="btn-paw-edit" style="display: inline-block; margin-top: 15px; text-decoration: none; font-size: 0.85rem; padding: 10px 20px;">
                        🔍 Cari E-Book
                    </a>
                </div>
            <?php else: ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                    <?php foreach($progressMembaca as $b): ?>
                        <?php 
                            $coverField = !empty($b['cover']) ? $b['cover'] : (!empty($b['foto']) ? $b['foto'] : '');
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
                        <div style="display: flex; gap: 15px; padding: 15px; background-color: #fffcf9; border: 2px solid #f9efe6; border-radius: 16px; align-items: center; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
                            <!-- Cover -->
                            <div style="width: 70px; height: 95px; border-radius: 8px; overflow: hidden; border: 1px solid #ebd5c5; flex-shrink: 0; background-color: #fffaf5;">
                                <?php if ($coverPath == '/images/default_cover.svg'): ?>
                                    <svg style="width:100%; height:100%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400">
                                      <rect width="100%" height="100%" fill="#fff5ec"/>
                                      <text x="150" y="220" font-family="sans-serif" font-size="28" fill="#8c7b70" text-anchor="middle" font-weight="bold">PAW</text>
                                    </svg>
                                <?php else: ?>
                                    <img src="<?= $coverPath ?>" alt="<?= esc($b['judul']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                            <!-- Detail -->
                            <div style="flex-grow: 1; min-width: 0; display: flex; flex-direction: column; gap: 5px;">
                                <h5 style="font-size: 0.95rem; font-weight: 700; color: #2E2118; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= esc($b['judul']) ?>"><?= esc($b['judul']) ?></h5>
                                <p style="font-size: 0.75rem; color: #8c7b70; margin: 0;">Oleh: <?= esc($b['penulis']) ?></p>
                                
                                <div style="font-size: 0.8rem; font-weight: 700; color: #a0522d; margin-top: 2px;">
                                    <i class="fas fa-bookmark text-warning"></i> <?= !empty($b['judul_bab']) ? esc($b['judul_bab']) : ('Halaman ' . $b['nomor_bab']) ?>
                                </div>
                                
                                <!-- Progress Bar -->
                                <div style="margin-top: 4px; display: flex; align-items: center; gap: 10px;">
                                    <div style="flex-grow: 1; height: 6px; background-color: #ebdcd0; border-radius: 3px; overflow: hidden;">
                                        <div style="height: 100%; width: <?= (int)$b['progress_persen'] ?>%; background-color: #E69C62; border-radius: 3px;"></div>
                                    </div>
                                    <span style="font-size: 0.75rem; font-weight: 700; color: #4a3c31; flex-shrink: 0;"><?= (int)$b['progress_persen'] ?>%</span>
                                </div>
                                
                                <a href="/ebook/baca/<?= $b['buku_id'] ?>" class="btn-paw-edit" style="width: 100%; padding: 6px 12px; font-size: 0.8rem; text-decoration: none; margin-top: 6px; text-align: center; border-radius: 8px; justify-content: center;">
                                    <i class="fas fa-play" style="font-size: 0.7rem; margin-right: 4px;"></i> Lanjutkan Membaca
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<!-- MODAL EDIT PROFIL -->
<?php if ($role == 'anggota'): ?>
<div class="modal fade" id="editProfilModal" tabindex="-1" role="dialog" aria-labelledby="editProfilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content paw-modal-content">
            
            <div class="modal-header paw-modal-header">
                <h5 class="modal-title paw-modal-title" id="editProfilModalLabel">✏️ Edit Profil Saya</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #4a3c31;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="/profile/update" method="post" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    
                    <!-- Input Nama -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" value="<?= esc($anggota['nama']) ?>" required style="border-radius: 12px; border: 2px solid #ebd5c5; padding: 10px;">
                    </div>
                    
                    <!-- Input Email (Mengubah kolom gmail) -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Email (Gmail)</label>
                        <input type="email" class="form-control" name="gmail" value="<?= esc($anggota['gmail'] ?? '') ?>" required style="border-radius: 12px; border: 2px solid #ebd5c5; padding: 10px;">
                    </div>

                    <!-- Input Nomor HP (Mengubah kolom nomor) -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Nomor HP</label>
                        <input type="text" class="form-control" name="nomor" value="<?= esc($anggota['nomor'] ?? '') ?>" required style="border-radius: 12px; border: 2px solid #ebd5c5; padding: 10px;">
                    </div>

                    <!-- Input Foto Profil -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Foto Profil (Opsional)</label>
                        <input type="file" class="form-control-file" name="foto_profil" accept="image/*" style="font-family: 'Quicksand', sans-serif;">
                        <small class="text-muted d-block mt-1">Format JPG/PNG, maksimal ukuran 2MB.</small>
                    </div>

                </div>
                
                <div class="modal-footer paw-modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 12px; font-weight: bold; background: #e0d0bf; border: none; color: #4a3c31; padding: 8px 18px;">Batal</button>
                    <button type="submit" class="btn-paw-edit" style="border-radius: 12px; font-weight: bold; border: none; padding: 8px 18px;">Simpan Perubahan</button>
                </div>
            </form>

        </div>
    </div>
</div>
<?php endif; ?>

<!-- Bootstrap 4 JS Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>