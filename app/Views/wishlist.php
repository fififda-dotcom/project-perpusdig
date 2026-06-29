<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<!-- Impor Google Font Quicksand agar selaras dengan tema kucing yang bulat dan hangat -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Impor Font Awesome untuk ikon-ikon cantik -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* CSS Utama bertema Cozy Cat & Minimalis */
.paw-container {
    font-family: 'Quicksand', sans-serif;
    color: #4a3c31;
}

/* Premium Minimalist Title Card Style */
.paw-title-card {
    background: #ffffff;
    border: 2px solid #ebd5c5;
    border-radius: 20px;
    padding: 20px 30px;
    box-shadow: 0 6px 18px rgba(74, 60, 49, 0.03);
    margin-bottom: 30px;
    display: inline-flex;
    align-items: center;
    gap: 12px;
}
.paw-title-card h1 {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 26px;
    color: #2E2118;
    margin: 0 !important;
}
.paw-title-card h1 i {
    color: #E69C62;
    margin-right: 8px;
}

/* Alert Styling */
.paw-alert {
    padding: 15px 20px;
    border-radius: 16px;
    font-weight: 700;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: 'Quicksand', sans-serif;
    animation: slideDown 0.3s ease-out;
}
.paw-alert-success {
    background-color: #e2f9e1;
    color: #1e6b26;
    border: 2px solid #c2ecc0;
}
.paw-alert-error {
    background-color: #ffebee;
    color: #c62828;
    border: 2px solid #ffcdd2;
}
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Kustomisasi Input Pencarian */
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
    color: white;
    text-decoration: none;
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

/* Grid Layout: DISAMAKAN DENGAN FAVORIT (menggunakan auto-fill 250px) */
.paw-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 24px;
    margin-top: 25px;
    margin-bottom: 40px;
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
    <!-- Premium Minimalist Title Card -->
    <div class="paw-title-card">
        <h1><i class="fas fa-star" style="color: #F1C40F;"></i> Wishlist Buku Saya</h1>
    </div>

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="paw-alert paw-alert-success">
            <i class="fas fa-paw"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="paw-alert paw-alert-error">
            <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($wishlist) && empty($keyword) && empty($ddc_filter)): ?>
        <!-- EMPTY STATE UTAMA: Wishlist Kosong -->
        <div class="paw-empty-state" style="text-align: center; padding: 60px 40px; background: white; border: 2px dashed #ebd5c5; border-radius: 24px; margin-top: 30px; box-shadow: 0 8px 25px rgba(74, 60, 49, 0.04);">
            <div style="font-size: 4rem; margin-bottom: 20px;">⭐</div>
            <h3 style="font-family: 'Quicksand', sans-serif; font-weight: 700; color: #4a3c31; margin-bottom: 10px;">Wishlist-mu masih kosong.</h3>
            <p style="color: #8c7b70; font-weight: 600; font-size: 0.95rem; margin-bottom: 25px;">Simpan buku yang ingin kamu baca nanti agar lebih mudah ditemukan.</p>
            <a href="/katalog" class="btn-browse-catalog" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                📚 Jelajahi Katalog
            </a>
        </div>
    <?php else: ?>
        <!-- FORM PENCARIAN -->
        <div style="margin-bottom: 25px;">
            <label style="font-weight: 700; font-size: 1.05rem; display: block; margin-bottom: 8px; color: #4a3c31;">
            </label>
            <form action="/wishlist" method="get" style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
                <input type="text"
                    name="keyword"
                    class="search-input"
                    placeholder="Masukkan judul, penulis..."
                    value="<?= esc($keyword ?? '') ?>"
                    style="width: 200px;">

                <select name="jenis_koleksi" class="search-input" style="width: 180px;">
                    <option value="">Semua Koleksi</option>
                    <option value="fisik" <?= (isset($jenis_koleksi_filter) && $jenis_koleksi_filter === 'fisik') ? 'selected' : '' ?>>📚 Buku Fisik</option>
                    <option value="ebook" <?= (isset($jenis_koleksi_filter) && $jenis_koleksi_filter === 'ebook') ? 'selected' : '' ?>>📱 E-Book</option>
                </select>

                <select name="ddc" class="search-input" style="width: 220px;">
                    <option value="">Semua Klasifikasi DDC</option>
                    <?php 
                        $db = \Config\Database::connect();
                        $rakList = $db->table('rak')->orderBy('kode_ddc', 'ASC')->get()->getResultArray();
                        foreach($rakList as $r):
                    ?>
                        <option value="<?= $r['id'] ?>" <?= (isset($ddc_filter) && $ddc_filter == $r['id']) ? 'selected' : '' ?>>
                            <?= esc($r['kode_ddc']) ?> - <?= esc($r['nama_rak']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="btn-search">
                    Cari
                </button>

                <a href="/wishlist" class="btn-reset" style="margin-left:0;">
                    Reset
                </a>
            </form>
        </div>

        <?php if (empty($wishlist) && (!empty($keyword) || !empty($ddc_filter))): ?>
            <!-- SEARCH EMPTY STATE -->
            <div class="paw-empty-state" style="text-align: center; padding: 50px 30px; background: white; border: 2px dashed #ebd5c5; border-radius: 24px; margin-top: 30px; box-shadow: 0 8px 25px rgba(74, 60, 49, 0.04);">
                <div style="font-size: 4rem; margin-bottom: 20px;">🔎</div>
                <h3 style="font-family: 'Quicksand', sans-serif; font-weight: 700; color: #4a3c31; margin-bottom: 10px;">Buku yang kamu cari tidak ditemukan di wishlist.</h3>
                <p style="color: #8c7b70; font-weight: 600; font-size: 0.95rem; margin-bottom: 0;">Coba gunakan kata kunci lain atau tambahkan buku baru ke wishlist.</p>
            </div>
        <?php else: ?>
            <!-- GRID LAYOUT CARD MODERN WISHLIST -->
            <div class="paw-grid">
                <?php foreach($wishlist as $b): ?>
                    <?php 
                        $stok = (int)$b['stok'];
                        
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
                    ?>
                    <div class="paw-card">
                        <div class="paw-card-img-wrapper">
                            <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook'): ?>
                                <span class="paw-status-badge" style="background-color: #ffe8d6; color: #a0522d; border: 1px solid rgba(160, 82, 45, 0.15);">
                                    <i class="fas fa-mobile-alt mr-1"></i> E-Book
                                </span>
                            <?php elseif ($stok > 0): ?>
                                <span class="paw-status-badge badge-tersedia">
                                    <i class="fas fa-check-circle mr-1"></i> Tersedia (<?= $stok ?>)
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
                                  <text x="150" y="270" font-family='Quicksand', sans-serif" font-weight="bold" font-size="16" fill="#8c7b70" text-anchor="middle">PAWLIB</text>
                                  <text x="150" y="290" font-family='Quicksand', sans-serif" font-size="11" fill="#c0b3a7" text-anchor="middle" font-weight="600">No Cover</text>
                                </svg>
                            <?php else: ?>
                                <img src="<?= $coverPath ?>" alt="<?= esc($b['judul']); ?>" class="paw-card-img">
                            <?php endif; ?>
                        </div>
                        
                        <div class="paw-card-body">
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
                            ?>
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

                            <!-- Rating & Statistik Row (Dashed line separator) -->
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

                        <!-- Tombol Aksi Stacked (Detail & Pinjam di atas, Hapus di bawah) -->
                        <div class="paw-card-footer-stacked">
                            <div class="paw-card-actions-row">
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
                            <a href="/wishlist/hapus/<?= $b['wishlist_id'] ?>" class="btn-action btn-action-hapus" onclick="return confirm('Hapus buku ini dari wishlist?')">
                                <i class="fas fa-times"></i> Hapus dari Wishlist
                            </a>
                        </div>
                    </div>

<?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?= $this->include('layout/footer'); ?>