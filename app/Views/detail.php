<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<!-- Impor Google Font Quicksand agar selaras dengan tema kucing yang bulat dan hangat -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Impor Font Awesome untuk ikon-ikon cantik -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* CSS Utama bertema Cozy Cat & Detail Page */
.paw-container {
    font-family: 'Quicksand', sans-serif;
    color: #4a3c31;
}

h1.paw-detail-title {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 30px;
    color: #4a3c31;
    margin-top: 0px !important; 
    margin-bottom: 8px !important;
}

.paw-detail-author {
    font-size: 1.15rem;
    color: #E69C62;
    font-weight: 600;
    margin-bottom: 20px;
}

/* Kotak Detail Utama */
.paw-detail-box {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.06);
    border: 2px solid #f2e7dd;
    margin-bottom: 30px;
}

/* Layout Kiri (Gambar) & Kanan (Info) */
.paw-detail-layout {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
}

.paw-detail-left {
    flex: 1 1 250px;
    max-width: 300px;
}

.paw-detail-right {
    flex: 2 1 350px;
}

/* Wrapper Cover Buku Besar */
.paw-detail-img-wrapper {
    background-color: #fffaf5;
    border: 2px solid #f2e7dd;
    border-radius: 18px;
    box-shadow: 0 6px 15px rgba(74, 60, 49, 0.05);
    overflow: hidden;
    height: 380px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.paw-detail-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Metadata List */
.paw-meta-list {
    margin-bottom: 20px;
}

.paw-meta-item {
    display: flex;
    padding: 12px 15px;
    background-color: #fffcf9;
    border-radius: 12px;
    margin-bottom: 8px;
    border: 1px solid #f9efe6;
}

.paw-meta-label {
    font-weight: bold;
    color: #8c7b70;
    width: 30%;
    min-width: 110px;
}

.paw-meta-value {
    font-weight: 600;
    color: #4a3c31;
}

/* Badge Status */
.badge-status {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
    margin-bottom: 20px;
}

.badge-tersedia {
    background-color: #e2f9e1;
    color: #1e6b26;
    border: 1px solid rgba(30, 107, 38, 0.15);
}

.badge-habis {
    background-color: #ffebee;
    color: #c62828;
    border: 1px solid rgba(198, 40, 40, 0.15);
}

/* Kotak Sinopsis */
.paw-synopsis-box {
    background-color: #fffaf5;
    border-left: 4px solid #E69C62;
    border-radius: 4px 15px 15px 4px;
    padding: 20px;
    margin-top: 20px;
    margin-bottom: 25px;
}

.paw-synopsis-title {
    font-weight: 700;
    font-size: 1.05rem;
    color: #4a3c31;
    margin-bottom: 8px;
}

.paw-synopsis-text {
    font-size: 0.95rem;
    line-height: 1.6;
    color: #4a3c31;
    text-align: justify;
    margin-bottom: 0;
}

/* Button Styling */
.btn-action-back {
    padding: 10px 20px;
    background: #c0b3a7;
    color: white !important;
    text-decoration: none;
    border-radius: 12px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    font-family: 'Quicksand', sans-serif;
    transition: all 0.2s ease;
}

.btn-action-back:hover {
    background: #a89a8e;
    text-decoration: none;
}

.btn-pinjam-detail {
    background: #E69C62;
    color: white !important;
    padding: 14px 28px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: bold;
    font-family: 'Quicksand', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(230, 156, 98, 0.25);
    transition: all 0.2s ease;
}

.btn-pinjam-detail:hover:not(.disabled) {
    background: #c8814a;
    transform: translateY(-1px);
    text-decoration: none;
}

.btn-pinjam-detail.disabled {
    background: #ebdcd0;
    color: #a69b90 !important;
    cursor: not-allowed;
    box-shadow: none;
}
</style>

<div class="paw-container">
    <!-- Tombol Kembali -->
    <a href="/katalog" class="btn-action-back">
        <i class="fas fa-chevron-left"></i> Kembali ke Katalog
    </a>

    <!-- Kotak Detail -->
    <div class="paw-detail-box">
        <?php 
            $stok = (int)$buku['stok'];
            
            // Logika Cover Gambar
            $coverField = !empty($buku['foto']) ? $buku['foto'] : (!empty($buku['cover']) ? $buku['cover'] : '');
            $coverPath = '/images/default_cover.svg'; // Fallback
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

        <div class="paw-detail-layout">
            <!-- Sisi Kiri (Cover Buku) -->
            <div class="paw-detail-left">
                <div class="paw-detail-img-wrapper">
                    <?php if ($coverPath == '/images/default_cover.svg'): ?>
                        <svg style="width: 100%; height: 100%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400">
                          <rect width="100%" height="100%" fill="#fff5ec"/>
                          <g transform="translate(150, 200) scale(1.5)">
                            <path d="M -20 10 C -20 -5, -10 -15, 0 -15 C 10 -15, 20 -5, 20 10 C 20 20, 10 25, 0 25 C -10 25, -20 20, -20 10 Z" fill="#E69C62" opacity="0.6"/>
                            <circle cx="-20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                            <circle cx="-7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                            <circle cx="7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                            <circle cx="20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                          </g>
                        </svg>
                    <?php else: ?>
                        <img src="<?= $coverPath ?>" alt="<?= esc($buku['judul']); ?>" class="paw-detail-img">
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sisi Kanan (Informasi Lengkap) -->
            <div class="paw-detail-right">
                <h1 class="paw-detail-title"><?= esc($buku['judul']); ?></h1>
                <p class="paw-detail-author">Oleh: <?= esc($buku['penulis']); ?></p>

                <!-- Status Ketersediaan Badge -->
                <?php if ($stok > 0): ?>
                    <span class="badge-status badge-tersedia">
                        <i class="fas fa-check-circle mr-1"></i> Tersedia (Stok: <?= $stok ?>)
                    </span>
                <?php else: ?>
                    <span class="badge-status badge-habis">
                        <i class="fas fa-times-circle mr-1"></i> Habis Dipinjam
                    </span>
                <?php endif; ?>

                <!-- Metadata List -->
                <div class="paw-meta-list">
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Kode Buku</div>
                        <div class="paw-meta-value"><?= esc($buku['kode_buku'] ?? 'BK' . str_pad($buku['id'], 3, '0', STR_PAD_LEFT)) ?></div>
                    </div>
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Penerbit</div>
                        <div class="paw-meta-value"><?= esc($buku['penerbit']); ?></div>
                    </div>
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Tahun Terbit</div>
                        <div class="paw-meta-value"><?= esc($buku['tahun']); ?></div>
                    </div>
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Lokasi Rak</div>
                        <div class="paw-meta-value"><?= esc($buku['rak'] ?? 'Rak Umum') ?></div>
                    </div>
                </div>

                <!-- Sinopsis -->
                <div class="paw-synopsis-box">
                    <div class="paw-synopsis-title"><i class="fas fa-quote-left mr-2" style="color: #E69C62;"></i> Sinopsis</div>
                    <p class="paw-synopsis-text">
                        <?= !empty($buku['sinopsis']) ? nl2br(esc($buku['sinopsis'])) : 'Sinopsis buku ini belum ditambahkan oleh pustakawan PawLib. Silakan hubungi admin perpustakaan untuk info lebih lanjut.' ?>
                    </p>
                </div>

                <!-- Tombol Action Pinjam -->
                <div class="mt-4">
                    <?php if ($stok > 0): ?>
                        <a href="/peminjaman/tambah/<?= $buku['id'] ?>" class="btn-pinjam-detail">
                            <i class="fas fa-paw"></i> Pinjam Buku Ini
                        </a>
                    <?php else: ?>
                        <a href="#" class="btn-pinjam-detail disabled" onclick="return false;">
                            <i class="fas fa-ban"></i> Stok Habis Dipinjam
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/footer'); ?>