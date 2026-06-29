<?php
$db = \Config\Database::connect();
$favoritIds = [];
$wishlistIds = [];
if (session()->get('role') == 'anggota') {
    $anggotaId = session()->get('anggota_id');
    $favoritList = $db->table('favorit')->where('anggota_id', $anggotaId)->get()->getResultArray();
    $favoritIds = array_column($favoritList, 'buku_id');
    
    $wishlistList = $db->table('wishlist')->where('anggota_id', $anggotaId)->get()->getResultArray();
    $wishlistIds = array_column($wishlistList, 'buku_id');
}
?>

<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<!-- Impor Google Font Quicksand agar selaras dengan tema kucing yang bulat dan hangat -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Impor Font Awesome untuk ikon-ikon cantik -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
    padding: 35px;
    border-radius: 24px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.06);
    border: 2px solid #f2e7dd;
    margin-bottom: 30px;
}

.search-input {
    padding: 12px 18px;
    width: 320px;
    border-radius: 15px;
    border: 2px solid #ebd5c5;
    font-family: 'Quicksand', sans-serif;
    font-weight: 600;
    color: #4a3c31;
    background-color: #ffffff;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.search-input:focus {
    outline: none;
    border-color: #E69C62;
    box-shadow: 0 0 0 4px rgba(230, 156, 98, 0.15);
}

.btn-search {
    padding: 12px 22px;
    background: #E69C62;
    color: white;
    border: none;
    border-radius: 15px;
    cursor: pointer;
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    transition: all 0.2s ease;
    box-shadow: 0 4px 10px rgba(230, 156, 98, 0.2);
}

.btn-search:hover {
    background: #c8814a;
    transform: translateY(-1px);
}

.btn-reset {
    padding: 12px 22px;
    background: #c0b3a7;
    color: white;
    text-decoration: none;
    border-radius: 15px;
    margin-left: 10px;
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    display: inline-block;
    transition: all 0.2s ease;
}

.btn-reset:hover {
    background: #a89a8e;
    color: white;
    text-decoration: none;
}

/* Layout Kiri (Gambar & Call Number) & Kanan (Info Lengkap) */
.paw-detail-layout {
    display: flex;
    flex-wrap: wrap;
    gap: 35px;
}

.paw-detail-left {
    flex: 1 1 250px;
    max-width: 280px;
    text-align: center;
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
    height: 360px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}

.paw-detail-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Label Nomor Panggil Perpustakaan */
.paw-call-number-box {
    background: #FFF9F3;
    border: 2px dashed #E69C62;
    padding: 12px;
    border-radius: 14px;
    font-family: monospace;
    font-size: 1rem;
    font-weight: bold;
    color: #4a3c31;
    display: inline-block;
    width: 100%;
    box-sizing: border-box;
}

.paw-call-number-label {
    font-size: 0.65rem;
    font-family: 'Quicksand', sans-serif;
    color: #8c7b70;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 3px;
    display: block;
}

/* Metadata List (Grid 2 Kolom untuk Info Buku) */
.paw-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 12px;
    margin-bottom: 25px;
}

.paw-meta-item {
    display: flex;
    padding: 12px 15px;
    background-color: #fffcf9;
    border-radius: 12px;
    border: 1px solid #f9efe6;
}

.paw-meta-label {
    font-weight: bold;
    color: #8c7b70;
    width: 40%;
    min-width: 110px;
    font-size: 0.85rem;
}

.paw-meta-value {
    font-weight: 600;
    color: #4a3c31;
    font-size: 0.9rem;
}

/* Badge Status */
.badge-status {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
    margin-bottom: 25px;
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

/* ========================================== */
/* RELATED BOOKS (BUKU SERUPA) SECTION STYLES */
/* ========================================== */
.paw-related-section {
    margin-top: 40px;
    border-top: 2px dashed #f2e7dd;
    padding-top: 35px;
}

.paw-related-title {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 24px;
    color: #2E2118;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.paw-related-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    margin-bottom: 40px;
}

@media (max-width: 992px) {
    .paw-related-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .paw-related-grid {
        grid-template-columns: 1fr;
    }
}

/* Kustomisasi Card Buku */
.paw-card {
    background: #ffffff;
    border: 2px solid #f2e7dd;
    border-radius: 20px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 8px 18px rgba(74, 60, 49, 0.04);
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    position: relative;
    height: 100%;
}

.paw-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 30px rgba(230, 156, 98, 0.12);
    border-color: #E69C62;
}

/* Image Wrapper dengan Aspek Rasio Buku */
.paw-card-img-wrapper {
    position: relative;
    width: 100%;
    height: 260px;
    background-color: #fffaf5;
    border-bottom: 2px solid #f2e7dd;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.paw-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.paw-card:hover .paw-card-img {
    transform: scale(1.05);
}

/* Tombol Favorit floating di atas Cover */
.paw-favorite-btn {
    position: absolute;
    top: 12px;
    left: 12px;
    z-index: 2;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(74, 60, 49, 0.1);
    color: #c0b3a7;
    text-decoration: none !important;
    transition: all 0.2s ease;
    border: 2px solid #f2e7dd;
    cursor: pointer;
}
.paw-favorite-btn:hover {
    transform: scale(1.1);
    color: #E74C3C;
}
.paw-favorite-btn.favorited {
    color: #E74C3C;
    background: #fff5f5;
    border-color: #ffcdd2;
}

/* Tombol Wishlist floating di atas Cover */
.paw-wishlist-btn {
    position: absolute;
    top: 12px;
    left: 56px;
    z-index: 2;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(74, 60, 49, 0.1);
    color: #c0b3a7;
    text-decoration: none !important;
    transition: all 0.2s ease;
    border: 2px solid #f2e7dd;
    cursor: pointer;
}
.paw-wishlist-btn:hover {
    transform: scale(1.1);
    color: #F1C40F;
}
.paw-wishlist-btn.saved {
    color: #F1C40F;
    background: #fffdf0;
    border-color: #fceea7;
}

/* Status Badge di atas Cover */
.paw-status-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 2;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    text-transform: uppercase;
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

/* Card Body */
.paw-card-body {
    padding: 15px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.paw-book-code {
    font-size: 0.7rem;
    font-weight: 700;
    color: #E69C62;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
    display: block;
}

.paw-ddc-badge {
    background-color: #fff8ee;
    color: #c8814a;
    border: 1px solid #ebd5c5;
    padding: 3px 10px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 8px;
    width: fit-content;
}

.paw-book-title {
    font-size: 1.05rem;
    font-weight: 700;
    line-height: 1.3;
    color: #4a3c31;
    margin-bottom: 4px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    height: 2.6rem; 
}

.paw-book-author {
    font-size: 0.85rem;
    color: #8c7b70;
    font-weight: 500;
    margin-bottom: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.paw-book-meta {
    font-size: 0.8rem;
    color: #a89a8e;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
}

/* Footer Card (Tombol Aksi) */
.paw-card-footer {
    padding: 0 15px 15px 15px;
    display: flex;
    gap: 8px;
    margin-top: auto;
}

.paw-card-footer-stacked {
    padding: 0 15px 15px 15px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: auto;
}

.paw-card-actions-row {
    display: flex;
    gap: 8px;
    width: 100%;
}

.btn-action {
    flex: 1;
    padding: 10px 12px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 700;
    text-decoration: none;
    text-align: center;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-family: 'Quicksand', sans-serif;
    transition: all 0.2s ease;
}

.btn-action-detail {
    background: #f0e2d3;
    color: #4a3c31;
}

.btn-action-detail:hover {
    background: #e0d0bf;
    color: #4a3c31;
    text-decoration: none;
}

.btn-action-pinjam {
    background: #E69C62;
    color: white;
    box-shadow: 0 4px 10px rgba(230, 156, 98, 0.15);
}

.btn-action-pinjam:hover:not(:disabled) {
    background: #c8814a;
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.btn-action-pinjam:disabled {
    background: #ebdcd0;
    color: #a69b90;
    cursor: not-allowed;
    box-shadow: none;
}

.btn-action-hapus {
    background: #fff5f5;
    color: #E74C3C;
    border: 1px dashed #ffcdd2;
}

.btn-action-hapus:hover {
    background: #ffebee;
    color: #c62828;
    text-decoration: none;
}

/* Style default SVG cover jika file cover tidak ada */
.default-cover-svg {
    width: 100%;
    height: 100%;
}
</style>

<div class="paw-container">
    <!-- Tombol Kembali -->
    <a href="/katalog?page_katalog=<?= isset($_GET['page']) ? esc($_GET['page']) : 1 ?>" class="btn-action-back" style="margin-bottom: 10px;">
        <i class="fas fa-chevron-left"></i> Kembali ke Katalog
    </a>

    <!-- Form Pencarian -->
    <form action="/katalog" method="get" style="margin-bottom:25px; display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
        <input type="text"
            name="keyword"
            class="search-input"
            placeholder="Cari judul atau penulis..."
            value="<?= $keyword ?? '' ?>"
            style="width: 200px;">
            
        <?php
        $active_filter_type = '';
        if (!empty($bahasa_filter)) {
            $active_filter_type = 'bahasa';
        } elseif (!empty($jenis_koleksi_filter)) {
            $active_filter_type = 'jenis_koleksi';
        } elseif (!empty($ddc_filter)) {
            $active_filter_type = 'ddc';
        }
        ?>

        <select id="filter_type_select" class="search-input" style="width: 190px;">
            <option value="" <?= $active_filter_type === '' ? 'selected' : '' ?>>🔍 Filter Berdasarkan</option>
            <option value="bahasa" <?= $active_filter_type === 'bahasa' ? 'selected' : '' ?>>🌐 Bahasa</option>
            <option value="jenis_koleksi" <?= $active_filter_type === 'jenis_koleksi' ? 'selected' : '' ?>>📚 Jenis Koleksi</option>
            <option value="ddc" <?= $active_filter_type === 'ddc' ? 'selected' : '' ?>>📂 Klasifikasi DDC</option>
        </select>

        <!-- Dropdown Bahasa -->
        <select name="bahasa" id="filter_bahasa_select" class="search-input" style="<?= $active_filter_type === 'bahasa' ? 'display: inline-block;' : 'display: none;' ?> width: 180px;" <?= $active_filter_type === 'bahasa' ? '' : 'disabled' ?>>
            <option value="">Pilih Bahasa</option>
            <?php foreach ($bahasaList as $lang): ?>
                <option value="<?= esc($lang) ?>" <?= (isset($bahasa_filter) && $bahasa_filter === $lang) ? 'selected' : '' ?>>🌐 <?= esc($lang) ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Dropdown Jenis Koleksi -->
        <select name="jenis_koleksi" id="filter_jenis_select" class="search-input" style="<?= $active_filter_type === 'jenis_koleksi' ? 'display: inline-block;' : 'display: none;' ?> width: 180px;" <?= $active_filter_type === 'jenis_koleksi' ? '' : 'disabled' ?>>
            <option value="">Pilih Jenis Koleksi</option>
            <option value="fisik" <?= (isset($jenis_koleksi_filter) && $jenis_koleksi_filter === 'fisik') ? 'selected' : '' ?>>📚 Buku Fisik</option>
            <option value="ebook" <?= (isset($jenis_koleksi_filter) && $jenis_koleksi_filter === 'ebook') ? 'selected' : '' ?>>📱 E-Book</option>
        </select>

        <!-- Dropdown DDC -->
        <select name="ddc" id="filter_ddc_select" class="search-input" style="<?= $active_filter_type === 'ddc' ? 'display: inline-block;' : 'display: none;' ?> width: 220px;" <?= $active_filter_type === 'ddc' ? '' : 'disabled' ?>>
            <option value="">Pilih Klasifikasi DDC</option>
            <?php 
                $db = \Config\Database::connect();
                $rakList = $db->table('rak')->orderBy('kode_ddc', 'ASC')->get()->getResultArray();
                foreach($rakList as $r):
            ?>
                <option value="<?= $r['id'] ?>" <?= (isset($ddc_filter) && $ddc_filter == $r['id']) ? 'selected' : '' ?>>
                    📂 <?= esc($r['kode_ddc']) ?> - <?= esc($r['nama_rak']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn-search">
            🔍 Cari
        </button>

        <a href="/katalog" class="btn-reset" style="margin-left:0;">
            Reset
        </a>
    </form>

    <!-- Kotak Detail Buku -->
    <div class="paw-detail-box">
        <?php 
            $stok = (int)$buku['stok'];
            
            // Logika Cover Gambar (Mengecek field cover atau foto di database Anda)
            $coverField = !empty($buku['cover']) ? $buku['cover'] : (!empty($buku['foto']) ? $buku['foto'] : '');
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
            <!-- Sisi Kiri (Cover Buku & Nomor Panggil) -->
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

                <!-- Nomor Panggil (Call Number) -->
                <div class="paw-call-number-box" title="Nomor Panggil Buku di Rak">
                    <span class="paw-call-number-label">Nomor Panggil</span>
                    <i class="fas fa-bookmark text-warning mr-1"></i> <?= esc($buku['nomor_panggil'] ?? '-') ?>
                </div>
            </div>

            <!-- Sisi Kanan (Informasi Lengkap Spesifik dari Database Anda) -->
            <div class="paw-detail-right">
                <h1 class="paw-detail-title"><?= esc($buku['judul']); ?></h1>
                <p class="paw-detail-author">Oleh: <?= esc($buku['penulis']); ?></p>
                
                <!-- Inline Rata-rata Rating -->
                <?php if ($totalRating > 0): ?>
                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 20px; font-weight: 700; font-size: 1rem; color: #4a3c31;">
                        <span style="color: #F1C40F; font-size: 1.2rem;">★</span>
                        <span><?= $ratingRataRata ?> / 5.0</span>
                        <span class="text-muted" style="font-size: 0.85rem; font-weight: 500;">(<?= $totalRating ?> rating)</span>
                    </div>
                <?php else: ?>
                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 20px; font-size: 0.85rem; color: #8c7b70; font-weight: 600;">
                        <span style="color: #ccc; font-size: 1.2rem;">☆</span>
                        <span>Belum ada rating & ulasan</span>
                    </div>
                <?php endif; ?>

                <!-- Status Ketersediaan Badge -->
                <?php if (isset($buku['jenis_koleksi']) && $buku['jenis_koleksi'] === 'ebook'): ?>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 25px; flex-wrap: wrap;">
                        <span class="badge-status" style="background-color: #ffe8d6; color: #a0522d; border: 1px solid rgba(160, 82, 45, 0.15); font-weight: 700; padding: 5px 12px; border-radius: 20px; margin-bottom: 0;">
                            <i class="fas fa-mobile-alt mr-1"></i> E-Book
                        </span>
                        <span style="font-size: 0.85rem; color: #8c7b70; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fas fa-eye" style="color: #e07a5f;"></i> Dibaca sebanyak <?= esc($buku['dibaca_count'] ?? 0) ?> kali
                        </span>
                    </div>
                <?php elseif ($stok > 0): ?>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 25px; flex-wrap: wrap;">
                        <span class="badge-status badge-tersedia" style="margin-bottom: 0;">
                            <i class="fas fa-check-circle mr-1"></i> Tersedia (Stok: <?= $stok ?>)
                        </span>
                        <span style="font-size: 0.85rem; color: #8c7b70; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fas fa-book-reader" style="color: #e07a5f;"></i> Dibaca sebanyak <?= esc($buku['dibaca_count'] ?? 0) ?> kali
                        </span>
                    </div>
                <?php else: ?>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 25px; flex-wrap: wrap;">
                        <span class="badge-status badge-habis" style="margin-bottom: 0;">
                            <i class="fas fa-times-circle mr-1"></i> Habis Dipinjam
                        </span>
                        <span style="font-size: 0.85rem; color: #8c7b70; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fas fa-book-reader" style="color: #e07a5f;"></i> Dibaca sebanyak <?= esc($buku['dibaca_count'] ?? 0) ?> kali
                        </span>
                    </div>
                <?php endif; ?>

                <!-- Grid Informasi Detil Buku -->
                <div class="paw-meta-grid">
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Kode Buku</div>
                        <div class="paw-meta-value"><?= esc($buku['kode_buku'] ?? '-') ?></div>
                    </div>
                    
                    <!-- Klasifikasi DDC & Nama Rak Terintegrasi (Baru) -->
                    <?php 
                        $db = \Config\Database::connect();
                        $rak = $db->table('rak')->where('id', $buku['rak_id'])->get()->getRowArray();
                    ?>
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Klasifikasi DDC</div>
                        <div class="paw-meta-value"><?= $rak ? esc($rak['kode_ddc']) : '-' ?></div>
                    </div>
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Nama Rak</div>
                        <div class="paw-meta-value"><?= $rak ? esc($rak['nama_rak']) : 'Umum' ?></div>
                    </div>
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Nomor Klasifikasi</div>
                        <div class="paw-meta-value"><?= esc($buku['nomor_klasifikasi'] ?? '-') ?></div>
                    </div>

                    <div class="paw-meta-item">
                        <div class="paw-meta-label">ISBN</div>
                        <div class="paw-meta-value"><?= esc($buku['isbn'] ?? '-') ?></div>
                    </div>
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Penerbit</div>
                        <div class="paw-meta-value"><?= esc($buku['penerbit'] ?? '-') ?></div>
                    </div>
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Tahun Terbit</div>
                        <div class="paw-meta-value"><?= esc($buku['tahun'] ?? '-') ?></div>
                    </div>
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Departemen</div>
                        <div class="paw-meta-value"><?= esc($buku['departemen'] ?? '-') ?></div>
                    </div>
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Dimensi Buku</div>
                        <div class="paw-meta-value"><?= esc($buku['dimensi_buku'] ?? '-') ?></div>
                    </div>
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Edisi</div>
                        <div class="paw-meta-value"><?= esc($buku['edisi'] ?? '-') ?></div>
                    </div>
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Bahasa</div>
                        <div class="paw-meta-value"><?= esc($buku['bahasa'] ?? '-') ?></div>
                    </div>
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Tempat Terbit</div>
                        <div class="paw-meta-value"><?= esc($buku['tempat_terbit'] ?? '-') ?></div>
                    </div>
                    <div class="paw-meta-item">
                        <div class="paw-meta-label">Deskripsi Fisik</div>
                        <div class="paw-meta-value"><?= esc($buku['deskripsi_fisik'] ?? '-') ?></div>
                    </div>
                    <?php if (isset($buku['jenis_koleksi']) && $buku['jenis_koleksi'] === 'ebook'): ?>
                        <div class="paw-meta-item">
                            <div class="paw-meta-label">Jumlah Halaman</div>
                            <div class="paw-meta-value"><?= esc($buku['jumlah_halaman'] ?? '-') ?> Halaman</div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Tombol Action Pinjam / Baca -->
                <div class="mt-4">
                    <?php if (isset($buku['jenis_koleksi']) && $buku['jenis_koleksi'] === 'ebook'): ?>
                        <div style="display: inline-flex; flex-direction: column; align-items: flex-start;">
                            <a href="/ebook/baca/<?= $buku['id'] ?>" class="btn-pinjam-detail" style="background: #e07a5f; box-shadow: 0 4px 12px rgba(224, 122, 95, 0.3); text-decoration: none;">
                                <i class="fas fa-book-open"></i> Baca Sekarang
                            </a>
                            <?php if (session()->get('role') == 'anggota' && $myProgress): ?>
                                <div style="margin-top: 10px; font-size: 0.85rem; color: #E69C62; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                                    <span>Progres: <?= $myProgress['progress_persen'] ?>%</span>
                                    <div style="width: 80px; background: #f5ece5; height: 6px; border-radius: 3px; overflow: hidden; display: inline-block;">
                                        <div style="background: #E69C62; width: <?= $myProgress['progress_persen'] ?>%; height: 100%; border-radius: 3px;"></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($stok > 0): ?>
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



    <!-- Sinopsis Buku Section (Jika ada sinopsis) -->
    <?php if (!empty($buku['sinopsis'])): ?>
    <div class="paw-detail-box" style="margin-top: -10px; margin-bottom: 20px;">
        <h3 style="font-family: 'Quicksand', sans-serif; font-weight: 700; font-size: 1.35rem; color: #4a3c31; margin-top: 0; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-align-left" style="color: #E69C62;"></i> Sinopsis Buku
        </h3>
        <p style="font-size: 0.95rem; line-height: 1.8; color: #5a4b3f; text-align: justify; white-space: pre-wrap; margin: 0; font-weight: 500;">
            <?= esc($buku['sinopsis']) ?>
        </p>
    </div>
    <?php endif; ?>

    <!-- Catatan Tambahan Section (Jika ada catatan) -->
    <?php if (!empty($buku['catatan'])): ?>
    <div class="paw-detail-box" style="margin-bottom: 30px;">
        <h3 style="font-family: 'Quicksand', sans-serif; font-weight: 700; font-size: 1.35rem; color: #4a3c31; margin-top: 0; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-sticky-note" style="color: #E69C62;"></i> Catatan Bibliografi / Tambahan
        </h3>
        <p style="font-size: 0.95rem; line-height: 1.8; color: #5a4b3f; text-align: justify; white-space: pre-wrap; margin: 0; font-weight: 500;">
            <?= esc($buku['catatan']) ?>
        </p>
    </div>
    <?php endif; ?>

    <!-- ========================================== -->
    <!-- SECTION RATING & ULASAN                   -->
    <!-- ========================================== -->
    <div class="paw-detail-box" style="margin-bottom: 30px;">
        <style>
        .paw-rating-stat-col {
            margin-bottom: 25px; 
            border-right: 2px dashed #f2e7dd; 
            padding-right: 25px;
        }
        .paw-rating-list-col {
            padding-left: 25px;
        }
        .paw-ulasan-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .paw-ulasan-scroll::-webkit-scrollbar-thumb {
            background: #E69C62;
            border-radius: 4px;
        }
        .paw-ulasan-scroll::-webkit-scrollbar-track {
            background: #fdf8e2;
            border-radius: 4px;
        }
        @media (max-width: 768px) {
            .paw-rating-stat-col {
                border-right: none !important;
                border-bottom: 2px dashed #f2e7dd;
                padding-right: 0 !important;
                padding-bottom: 25px;
                margin-bottom: 25px;
            }
            .paw-rating-list-col {
                padding-left: 0 !important;
            }
        }
        </style>
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px; flex-wrap: wrap;">
            <h3 style="font-family: 'Quicksand', sans-serif; font-weight: 700; font-size: 1.35rem; color: #4a3c31; margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-comments" style="color: #E69C62;"></i> Rating & Ulasan Pembaca
            </h3>
            <?php if (isset($buku['jenis_koleksi']) && $buku['jenis_koleksi'] === 'ebook' && session()->get('role') == 'anggota'): ?>
                <button onclick="openEbookRatingModal()" class="btn-pinjam-detail" style="background: #ffffff; color: #E69C62 !important; border: 2px solid #E69C62; box-shadow: none; padding: 8px 16px; font-size: 0.9rem; margin: 0;">
                    <i class="far fa-star"></i> <?= $existingEbookRating ? 'Ubah Rating & Ulasan' : 'Tulis Rating & Ulasan' ?>
                </button>
            <?php endif; ?>
        </div>

        <div class="row">
            <!-- Statistik Bintang & Ringkasan -->
            <div class="col-md-4 paw-rating-stat-col">
                <div style="text-align: center; padding: 15px 0;">
                    <h2 style="font-size: 4rem; font-weight: 800; color: #4a3c31; margin: 0; line-height: 1;"><?= $ratingRataRata ?></h2>
                    <div style="color: #F1C40F; font-size: 1.4rem; margin: 10px 0 5px 0;">
                        <?php 
                        $floorRating = floor((float)$ratingRataRata);
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $floorRating) {
                                echo '★';
                            } else {
                                echo '☆';
                            }
                        }
                        ?>
                    </div>
                    <p style="color: #8c7b70; font-size: 0.9rem; font-weight: 600; margin: 0;">
                        Berdasarkan <?= $totalRating ?> Rating
                    </p>
                </div>

                <!-- Progress Bars Distribusi -->
                <div style="margin-top: 20px;">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <?php 
                        $count = $distribusiRating[$i] ?? 0;
                        $pct = $totalRating > 0 ? ($count / $totalRating) * 100 : 0;
                        ?>
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px; font-size: 0.85rem; font-weight: 600; color: #5a4b3f;">
                            <span style="width: 70px; text-align: right; white-space: nowrap;"><?= $i ?> Bintang</span>
                            <div style="flex: 1; background: #f5ece5; height: 8px; border-radius: 4px; overflow: hidden;">
                                <div style="background: #E69C62; width: <?= $pct ?>%; height: 100%; border-radius: 4px;"></div>
                            </div>
                            <span style="width: 25px; text-align: left; color: #8c7b70;"><?= $count ?></span>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- List Ulasan Pembaca -->
            <div class="col-md-8 paw-rating-list-col">
                <!-- Header Ulasan & Sortir -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px dashed #f2e7dd; padding-bottom: 15px;">
                    <h4 style="font-weight: 700; color: #4a3c31; margin: 0; font-size: 1.1rem;">Daftar Ulasan (<?= count($ulasanList) ?>)</h4>
                    
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: #8c7b70;">
                        <span>Urutkan:</span>
                        <a href="?sort_ulasan=terbaru" style="text-decoration: none; color: <?= $sort_ulasan === 'terbaru' ? '#E69C62' : '#8c7b70' ?>; border-bottom: 2px solid <?= $sort_ulasan === 'terbaru' ? '#E69C62' : 'transparent' ?>; padding-bottom: 2px; transition: all 0.2s ease;">Terbaru</a>
                        <span style="color: #ebd5c5;">|</span>
                        <a href="?sort_ulasan=tertinggi" style="text-decoration: none; color: <?= $sort_ulasan === 'tertinggi' ? '#E69C62' : '#8c7b70' ?>; border-bottom: 2px solid <?= $sort_ulasan === 'tertinggi' ? '#E69C62' : 'transparent' ?>; padding-bottom: 2px; transition: all 0.2s ease;">Rating Tertinggi</a>
                    </div>
                </div>

                <!-- List Ulasan -->
                <div class="paw-ulasan-scroll" style="max-height: 380px; overflow-y: auto; padding-right: 10px;">
                    <?php if (empty($ulasanList)): ?>
                        <div style="text-align: center; padding: 40px 0; color: #8c7b70;">
                            <span style="font-size: 2.5rem; display: block; margin-bottom: 10px;">💬</span>
                            <p style="font-weight: 700; margin: 0;">Belum ada ulasan untuk buku ini.</p>
                            <p style="font-size: 0.85rem; margin: 5px 0 0 0;">Jadilah yang pertama menulis ulasan setelah meminjam!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($ulasanList as $ul): ?>
                            <div style="background: #fffdfc; border: 1px solid #ebd5c5; border-radius: 16px; padding: 18px; margin-bottom: 15px; position: relative; box-shadow: 0 2px 8px rgba(74,60,49,0.02);">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                    <div>
                                        <strong style="color: #4a3c31; font-size: 0.95rem; display: block;"><?= esc($ul['nama_anggota']) ?></strong>
                                        <div style="color: #F1C40F; font-size: 0.8rem; margin-top: 2px;">
                                            <?= str_repeat('★', $ul['rating'] ?? 5) . str_repeat('☆', 5 - ($ul['rating'] ?? 5)) ?>
                                        </div>
                                    </div>
                                    <span style="font-size: 0.75rem; color: #a89a8e; font-weight: 600;"><?= date('d M Y', strtotime($ul['created_at'])) ?></span>
                                </div>
                                <p style="margin: 0; font-size: 0.9rem; color: #5a4b3f; line-height: 1.5; text-align: justify; white-space: pre-wrap;">
                                    "<?= esc($ul['ulasan']) ?>"
                                </p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SECTION BUKU SERUPA                       -->
    <!-- ========================================== -->
    <div class="paw-related-section">
        <h2 class="paw-related-title"><i class="fas fa-book text-warning" style="color: #E69C62;"></i> Buku Serupa</h2>
        
        <?php if (empty($bukuSerupa)): ?>
            <!-- Tampilan Jika Buku Serupa Kosong -->
            <div class="paw-related-empty-card">
                <div style="font-size: 45px; color: #ebd5c5; margin-bottom: 15px;"><i class="fas fa-book-open"></i></div>
                <p style="font-weight: 700; font-size: 1.1rem; color: #4a3c31; margin-bottom: 5px;">Belum ada rekomendasi buku serupa pada klasifikasi ini.</p>
                <p style="font-size: 0.95rem; color: #8c7b70; margin-bottom: 20px;">Yuk jelajahi katalog untuk menemukan koleksi lainnya!</p>
                <a href="/katalog" class="btn-pinjam-detail" style="box-shadow: none; padding: 10px 24px;">
                    <i class="fas fa-compass"></i> Jelajahi Katalog
                </a>
            </div>
        <?php else: ?>
            <!-- Grid Card Buku Serupa -->
            <div class="paw-related-grid">
                <?php foreach($bukuSerupa as $b): ?>
                            <?php 
                                $db = \Config\Database::connect();
                                $rak = null;
                                if (!empty($b['rak_id'])) {
                                    $rak = $db->table('rak')->where('id', $b['rak_id'])->get()->getRowArray();
                                }
                                
                                // Fetch Rating Info
                                $ratingInfo = $db->table('rating_buku')
                                                 ->select('COUNT(id) as total_rating, AVG(rating) as rata_rata')
                                                 ->where('buku_id', $b['id'])
                                                 ->get()
                                                 ->getRowArray();
                                $totalRating = (int)($ratingInfo['total_rating'] ?? 0);
                                $ratingRataRata = $totalRating > 0 ? number_format((float)$ratingInfo['rata_rata'], 1, '.', '') : '0';

                                // Path cover
                                $coverField = !empty($b['foto']) ? $b['foto'] : (!empty($b['cover']) ? $b['cover'] : '');
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
                                $stok = (int)$b['stok'];
                            ?>
                            <div class="paw-card">
                                <div class="paw-card-img-wrapper">
                                    <!-- Tombol Favorit (Tampil Hanya untuk Anggota yang Login) -->
                                    <?php if (session()->get('role') == 'anggota'): ?>
                                        <a href="/favorit/toggle/<?= $b['id'] ?>" class="paw-favorite-btn <?= in_array($b['id'], $favoritIds) ? 'favorited' : '' ?>" title="Favorit">
                                            <i class="fas fa-heart"></i>
                                        </a>
                                        
                                        <?php if (in_array($b['id'], $wishlistIds)): ?>
                                            <a href="javascript:void(0);" class="paw-wishlist-btn saved" title="Tersimpan di Wishlist" style="cursor: default;">
                                                <i class="fas fa-star"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="/wishlist/tambah/<?= $b['id'] ?>" class="paw-wishlist-btn" title="Tambah ke Wishlist">
                                                <i class="fas fa-star"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook'): ?>
                                        <span class="paw-status-badge" style="background-color: #ffe8d6; color: #a0522d; border: 1px solid rgba(160, 82, 45, 0.15);">
                                            <i class="fas fa-mobile-alt mr-1"></i> E-Book
                                        </span>
                                    <?php elseif ($stok > 0): ?>
                                        <span class="paw-status-badge badge-tersedia">
                                            <i class="fas fa-book mr-1"></i> Buku Fisik (<?= $stok ?>)
                                        </span>
                                    <?php else: ?>
                                        <span class="paw-status-badge badge-habis">
                                            <i class="fas fa-times-circle mr-1"></i> Habis
                                        </span>
                                    <?php endif; ?>
                                    
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
                                          <text x="150" y="290" font-family="'Quicksand', sans-serif" font-size="11" fill="#c0b3a7" text-anchor="middle" font-weight="600">No Cover</text>
                                        </svg>
                                    <?php else: ?>
                                        <img src="<?= $coverPath ?>" alt="<?= esc($b['judul']); ?>" class="paw-card-img">
                                    <?php endif; ?>
                                </div>
                                <div class="paw-card-body">
                                    <span class="paw-book-code"><?= esc($b['kode_buku'] ?? 'BK' . str_pad($b['id'], 3, '0', STR_PAD_LEFT)) ?></span>
                                    
                                    <!-- Badge Klasifikasi DDC -->
                                    <?php if ($rak): ?>
                                        <span class="paw-ddc-badge" title="Klasifikasi DDC">
                                            <i class="fas fa-tag"></i> DDC <?= esc($rak['kode_ddc']) ?>: <?= esc($rak['nama_rak']) ?>
                                        </span>
                                    <?php endif; ?>

                                    <h5 class="paw-book-title" title="<?= esc($b['judul']); ?>"><?= esc($b['judul']); ?></h5>
                                    <p class="paw-book-author">Oleh: <?= esc($b['penulis']); ?></p>
                                    <div class="paw-book-meta">
                                        <span><i class="far fa-building mr-1"></i> <?= esc($b['penerbit']); ?></span>
                                        <span><i class="far fa-calendar-alt mr-1"></i> <?= esc($b['tahun']); ?></span>
                                    </div>
                                    <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook' && !empty($b['jumlah_halaman'])): ?>
                                        <div style="font-size: 0.8rem; color: #a0522d; margin-top: -10px; margin-bottom: 10px; font-weight: 700;">
                                            <i class="fas fa-file-alt mr-1"></i> <?= esc($b['jumlah_halaman']); ?> Halaman
                                        </div>
                                    <?php endif; ?>

                                    <!-- Rating & Statistik Row -->
                                    <div style="display: flex; align-items: center; gap: 10px; font-size: 0.8rem; font-weight: 700; color: #8c7b70; margin-bottom: 12px; border-top: 1px dashed #f2e7dd; padding-top: 10px; margin-top: auto;">
                                        <span style="display: flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-star" style="color: #F1C40F;"></i> 
                                            <?= $ratingRataRata ?>/5.0 (<?= $totalRating ?>)
                                        </span>
                                        <span style="color: #ebd5c5;">|</span>
                                        <span style="display: flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-eye" style="color: #e07a5f;"></i> 
                                            <?= esc($b['dibaca_count'] ?? 0) ?> Kali
                                        </span>
                                    </div>
                                </div>
                                <div class="paw-card-footer">
                                    <a href="/katalog/detail/<?= $b['id'] ?>" class="btn-action btn-action-detail">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </a>
                                    <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook'): ?>
                                        <a href="/ebook/baca/<?= $b['id'] ?>" class="btn-action btn-action-pinjam" style="background: #e07a5f; box-shadow: 0 4px 10px rgba(224, 122, 95, 0.15);">
                                            <i class="fas fa-book-open"></i> Baca Sekarang
                                        </a>
                                    <?php elseif ($stok > 0): ?>
                                        <a href="/peminjaman/tambah/<?= $b['id'] ?>" class="btn-action btn-action-pinjam">
                                            <i class="fas fa-paw"></i> Pinjam
                                        </a>
                                    <?php else: ?>
                                        <button class="btn-action btn-action-pinjam" disabled>
                                            <i class="fas fa-paw"></i> Habis
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
<?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dynamic Filter Category Toggle
    function initFilterController() {
        const typeSelect = document.getElementById('filter_type_select');
        if (!typeSelect) return;

        const bahasaSelect = document.getElementById('filter_bahasa_select');
        const jenisSelect = document.getElementById('filter_jenis_select');
        const ddcSelect = document.getElementById('filter_ddc_select');

        function updateFilterDropdowns() {
            const selectedType = typeSelect.value;

            // Hide and disable all first
            if (bahasaSelect) { bahasaSelect.style.display = 'none'; bahasaSelect.disabled = true; }
            if (jenisSelect) { jenisSelect.style.display = 'none'; jenisSelect.disabled = true; }
            if (ddcSelect) { ddcSelect.style.display = 'none'; ddcSelect.disabled = true; }

            // Show and enable the selected one
            if (selectedType === 'bahasa' && bahasaSelect) {
                bahasaSelect.style.display = 'inline-block';
                bahasaSelect.disabled = false;
            } else if (selectedType === 'jenis_koleksi' && jenisSelect) {
                jenisSelect.style.display = 'inline-block';
                jenisSelect.disabled = false;
            } else if (selectedType === 'ddc' && ddcSelect) {
                ddcSelect.style.display = 'inline-block';
                ddcSelect.disabled = false;
            }
        }

        typeSelect.addEventListener('change', function() {
            // Reset values on type change
            if (bahasaSelect) bahasaSelect.value = '';
            if (jenisSelect) jenisSelect.value = '';
            if (ddcSelect) ddcSelect.value = '';
            updateFilterDropdowns();
        });

        // Initialize state on load
        updateFilterDropdowns();
    }
    initFilterController();
});
</script>

<!-- MODAL RATING EBOOK -->
<?php if (session()->get('role') == 'anggota'): ?>
<div id="paw_ebook_rating_modal" style="
    display: none; 
    position: fixed; 
    z-index: 9999; 
    left: 0; 
    top: 0; 
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(46, 33, 24, 0.4); 
    backdrop-filter: blur(4px);
    align-items: center; 
    justify-content: center;
">
    <div style="
        background: white; 
        padding: 30px; 
        border-radius: 24px; 
        max-width: 500px; 
        width: 90%; 
        border: 2px solid #f2e7dd; 
        box-shadow: 0 10px 30px rgba(74, 60, 49, 0.15);
        animation: modalPop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.15);
    ">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-weight: bold; color: #4a3c31; margin: 0;"><i class="fas fa-paw" style="color: #E69C62;"></i> Ulasan Ebook</h3>
            <span onclick="closeEbookRatingModal()" style="font-size: 24px; font-weight: bold; cursor: pointer; color: #a89a8e;">&times;</span>
        </div>
        
        <form action="/ulasan/simpan_ebook" method="POST" id="form_ebook_rating_submit">
            <input type="hidden" name="buku_id" value="<?= $buku['id'] ?>">
            
            <p style="font-size: 0.95rem; font-weight: 700; color: #4a3c31; margin-bottom: 5px;">Bagaimana pengalaman membaca ebook:</p>
            <p style="font-size: 1.05rem; font-weight: 700; color: #E69C62; margin-top: 0; margin-bottom: 20px;"><?= esc($buku['judul']) ?></p>
            
            <!-- Bintang Interaktif -->
            <div style="display: flex; gap: 8px; justify-content: center; font-size: 32px; color: #bdc3c7; margin-bottom: 25px;" id="ebook_star_container">
                <i class="far fa-star ebook-star-btn" data-value="1" style="cursor: pointer; transition: transform 0.2s ease;"></i>
                <i class="far fa-star ebook-star-btn" data-value="2" style="cursor: pointer; transition: transform 0.2s ease;"></i>
                <i class="far fa-star ebook-star-btn" data-value="3" style="cursor: pointer; transition: transform 0.2s ease;"></i>
                <i class="far fa-star ebook-star-btn" data-value="4" style="cursor: pointer; transition: transform 0.2s ease;"></i>
                <i class="far fa-star ebook-star-btn" data-value="5" style="cursor: pointer; transition: transform 0.2s ease;"></i>
            </div>
            <input type="hidden" name="rating" id="modal_ebook_rating_val" value="<?= $existingEbookRating['rating'] ?? '0' ?>">
            
            <div style="border-top: 2px dashed #f2e7dd; padding-top: 20px;">
                <label style="font-weight: 700; font-size: 0.9rem; color: #4a3c31; display: block; margin-bottom: 8px;"><i class="far fa-comment-dots"></i> 💬 Bagikan Pendapatmu</label>
                <textarea name="ulasan" id="modal_ebook_ulasan_text" rows="4" style="
                    width: 100%; 
                    padding: 12px; 
                    border-radius: 12px; 
                    border: 2px solid #ebd5c5; 
                    font-family: 'Quicksand', sans-serif;
                    font-size: 0.9rem; 
                    box-sizing: border-box;
                    resize: vertical;
                " placeholder="Tulis ulasan Anda di sini... (Minimal 20 karakter, maksimal 1000)"><?= esc($existingEbookUlasan['ulasan'] ?? '') ?></textarea>
                <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: #8c7b70; margin-top: 5px;">
                    <span id="ebook_char_warning" style="color: #e74c3c; display: none;">Minimal 20 karakter!</span>
                    <span style="margin-left: auto;" id="ebook_char_counter">0 / 1000</span>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
                <button type="button" onclick="closeEbookRatingModal()" class="btn-action-back" style="margin: 0; padding: 10px 18px; background: #e5dcd3; color: #4a3c31 !important;">Batal</button>
                <button type="submit" id="btn_submit_ebook_review" style="
                    background: #E69C62; 
                    color: white; 
                    border: none; 
                    padding: 10px 20px; 
                    border-radius: 12px; 
                    font-weight: bold; 
                    cursor: pointer;
                "><?= $existingEbookRating ? 'Perbarui Ulasan' : 'Simpan Ulasan' ?></button>
            </div>
        </form>
    </div>
</div>

<script>
const ebookModal = document.getElementById('paw_ebook_rating_modal');
const ebookRatingInput = document.getElementById('modal_ebook_rating_val');
const ebookUlasanText = document.getElementById('modal_ebook_ulasan_text');
const ebookBtnSubmit = document.getElementById('btn_submit_ebook_review');
const ebookCharWarning = document.getElementById('ebook_char_warning');
const ebookCharCounter = document.getElementById('ebook_char_counter');
const ebookStars = document.querySelectorAll('.ebook-star-btn');

function openEbookRatingModal() {
    const currentRating = parseInt(ebookRatingInput.value) || 0;
    highlightEbookStars(currentRating);
    validateEbookUlasan();
    ebookModal.style.display = 'flex';
}

function closeEbookRatingModal() {
    ebookModal.style.display = 'none';
}

function highlightEbookStars(val) {
    ebookStars.forEach(s => {
        const starVal = parseInt(s.getAttribute('data-value'));
        if (starVal <= val) {
            s.className = 'fas fa-star ebook-star-btn text-warning';
            s.style.color = '#F1C40F';
        } else {
            s.className = 'far fa-star ebook-star-btn';
            s.style.color = '#bdc3c7';
        }
    });
}

ebookStars.forEach(star => {
    star.addEventListener('mouseover', function() {
        const hoverVal = parseInt(this.getAttribute('data-value'));
        ebookStars.forEach(s => {
            const starVal = parseInt(s.getAttribute('data-value'));
            if (starVal <= hoverVal) {
                s.style.color = '#F1C40F';
            } else {
                s.style.color = '#bdc3c7';
            }
        });
    });
    
    star.addEventListener('mouseout', function() {
        const currentVal = parseInt(ebookRatingInput.value) || 0;
        highlightEbookStars(currentVal);
    });
    
    star.addEventListener('click', function() {
        const clickVal = parseInt(this.getAttribute('data-value'));
        ebookRatingInput.value = clickVal;
        highlightEbookStars(clickVal);
        validateEbookUlasan();
    });
});

ebookUlasanText.addEventListener('input', function() {
    validateEbookUlasan();
});

function validateEbookUlasan() {
    const text = ebookUlasanText.value.trim();
    const len = text.length;
    ebookCharCounter.innerText = `${len} / 1000`;
    
    if (len > 0) {
        if (len < 20 || len > 1000) {
            ebookCharWarning.style.display = 'inline';
            ebookBtnSubmit.disabled = true;
            ebookBtnSubmit.style.opacity = '0.5';
            ebookBtnSubmit.style.cursor = 'not-allowed';
        } else {
            ebookCharWarning.style.display = 'none';
            ebookBtnSubmit.disabled = false;
            ebookBtnSubmit.style.opacity = '1';
            ebookBtnSubmit.style.cursor = 'pointer';
        }
    } else {
        ebookCharWarning.style.display = 'none';
        ebookBtnSubmit.disabled = false;
        ebookBtnSubmit.style.opacity = '1';
        ebookBtnSubmit.style.cursor = 'pointer';
    }
}
</script>
<?php endif; ?>

<?= $this->include('layout/footer'); ?>