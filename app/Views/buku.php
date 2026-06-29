<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<?php
    // Fallback defensive jika controller belum dilewati variabel statistik
    $totalJudul = $totalJudul ?? count($buku);
    $totalStok = $totalStok ?? 0;
    $totalEbook = $totalEbook ?? 0;
    if ($totalStok == 0 && $totalEbook == 0) {
        foreach ($buku as $b) {
            if (($b['jenis_koleksi'] ?? 'fisik') === 'ebook') {
                $totalEbook++;
            } else {
                $totalStok += (int)($b['stok'] ?? 0);
            }
        }
    }
?>

<style>
/* CSS Utama bertema Cozy Cat & Minimalis */
.paw-container {
    font-family: 'Quicksand', sans-serif;
    color: #4a3c31;
}

h1 {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 32px;
    color: #2E2118;
    margin-top: 5px !important; 
    margin-bottom: 15px !important;
}

.paw-subtitle {
    font-size: 1.05rem;
    color: #8c7b70;
    margin-bottom: 25px;
}

/* Premium Minimalist Title Card Style */
.paw-title-card {
    background: #ffffff;
    border: 2px solid #ebd5c5;
    border-radius: 20px;
    padding: 20px 30px;
    box-shadow: 0 6px 18px rgba(74, 60, 49, 0.03);
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    box-sizing: border-box;
    flex-wrap: wrap;
    gap: 15px;
}
.paw-title-card h1 {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 26px;
    color: #2E2118;
    margin: 0 !important;
    display: flex;
    align-items: center;
    gap: 10px;
}
.paw-title-card h1 i {
    color: #E69C62;
}

/* Button Tambah */
.btn-tambah {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #E69C62;
    color: white !important;
    padding: 14px 24px;
    border-radius: 15px;
    text-decoration: none;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(230, 156, 98, 0.25);
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-tambah:hover {
    background: #c8814a;
    text-decoration: none;
    transform: translateY(-1px);
}

/* Kustomisasi Pencarian */
.search-input-buku {
    padding: 12px 18px;
    width: 300px;
    border: 2px solid #ebd5c5;
    border-radius: 15px;
    font-family: 'Quicksand', sans-serif;
    font-weight: 600;
    color: #4a3c31;
    background-color: #ffffff;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.search-input-buku:focus {
    outline: none;
    border-color: #E69C62;
    box-shadow: 0 0 0 4px rgba(230, 156, 98, 0.15);
}

.btn-cari-buku {
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

.btn-cari-buku:hover {
    background: #c8814a;
}

.btn-reset-buku {
    padding: 12px 22px;
    background: #c0b3a7;
    color: white;
    text-decoration: none;
    border-radius: 15px;
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    display: inline-block;
    transition: all 0.2s ease;
}

.btn-reset-buku:hover {
    background: #a89a8e;
    color: white;
    text-decoration: none;
}

/* Grid layout untuk Card Buku Admin */
.admin-paw-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

/* Card Buku Admin - Pembeda: Border top khusus & KELOLA badge */
.admin-paw-card {
    background: #ffffff;
    border: 2px solid #f2e7dd;
    border-top: 5px solid #4A90E2; /* Sentuhan border biru admin */
    border-radius: 20px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 8px 18px rgba(74, 60, 49, 0.04);
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    position: relative;
    height: 100%;
}

.admin-paw-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 30px rgba(74, 144, 226, 0.15);
    border-color: #4A90E2;
}

.paw-card-img-wrapper {
    position: relative;
    width: 100%;
    height: 250px;
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

.admin-paw-card:hover .paw-card-img {
    transform: scale(1.05);
}

/* Badges */
.admin-badge-mode {
    position: absolute;
    top: 12px;
    left: 12px;
    z-index: 2;
    font-size: 0.65rem;
    font-weight: 800;
    padding: 4px 10px;
    border-radius: 20px;
    background: #4A90E2;
    color: white;
    box-shadow: 0 4px 8px rgba(74, 144, 226, 0.25);
    text-transform: uppercase;
}

.paw-status-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 2;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}

.badge-stok {
    background-color: #e2f9e1;
    color: #1e6b26;
    border: 1px solid rgba(30, 107, 38, 0.15);
}

.badge-habis {
    background-color: #ffebee;
    color: #c62828;
    border: 1px solid rgba(198, 40, 40, 0.15);
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
    margin-bottom: 10px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.paw-book-meta span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* Footer Card (Tombol Aksi) */
.paw-card-footer {
    padding: 0 15px 15px 15px;
    display: flex;
    gap: 8px;
    margin-top: auto;
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

.btn-action-edit {
    background: #eaf2fc;
    color: #4A90E2;
}

.btn-action-edit:hover {
    background: #4A90E2;
    color: white !important;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(74, 144, 226, 0.25);
}

.btn-action-hapus {
    background: #fdf0ee;
    color: #E74C3C;
}

.btn-action-hapus:hover {
    background: #E74C3C;
    color: white !important;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(231, 76, 60, 0.25);
}

.default-cover-svg {
    width: 100%;
    height: 100%;
}

/* Styling Pagination (Baru) */
.paw-pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 30px;
    margin-bottom: 50px;
}

.paw-pagination-container ul {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 8px;
    background: white;
    padding: 10px 16px;
    border-radius: 50px;
    box-shadow: 0 6px 15px rgba(74, 60, 49, 0.05);
    border: 2px solid #f2e7dd;
}

.paw-pagination-container li {
    display: inline;
}

.paw-pagination-container li a,
.paw-pagination-container li span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 10px;
    border-radius: 50%;
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 0.95rem;
    text-decoration: none;
    transition: all 0.2s ease;
}

.paw-pagination-container li a {
    color: #8c7b70;
    background-color: transparent;
}

.paw-pagination-container li a:hover {
    background-color: #eaf2fc;
    color: #4A90E2;
    text-decoration: none;
}

.admin-pagination li.active span,
.admin-pagination li.active a {
    background-color: #4A90E2;
    color: white !important;
    box-shadow: 0 4px 10px rgba(74, 144, 226, 0.3);
}

/* Cozy Cat Toast Alert */
#paw-toast {
    position: fixed;
    bottom: -100px;
    right: 20px;
    background-color: #e2f9e1;
    color: #1e6b26;
    border: 2px solid #c2ecc0;
    padding: 16px 28px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(74, 60, 49, 0.1);
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 0.95rem;
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    opacity: 0;
    transform: translateY(20px);
}
#paw-toast.show {
    bottom: 20px;
    opacity: 1;
    transform: translateY(0);
}
</style>

<div class="paw-container">
    <!-- Premium Minimalist Title Card -->
    <div class="paw-title-card">
        <h1><i class="fas fa-folder-open" style="color: #E69C62;"></i> Koleksi Buku PawLib</h1>
        
        <!-- Bar Statistik Admin (Minimalist Banner Stats) -->
        <div id="admin-stats-container" style="display: flex; gap: 15px; align-items: center; font-size: 0.95rem; font-weight: 700; color: #8c7b70; flex-wrap: wrap;">
            <span><i class="fas fa-book" style="color: #4A90E2; margin-right: 4px;"></i> <strong><?= $totalJudul ?></strong> Judul</span>
            <span style="color: #ebd5c5;">|</span>
            <span><i class="fas fa-boxes" style="color: #E69C62; margin-right: 4px;"></i> <strong><?= $totalStok ?></strong> Buku Fisik</span>
            <span style="color: #ebd5c5;">|</span>
            <span><i class="fas fa-mobile-alt" style="color: #2ECC71; margin-right: 4px;"></i> <strong><?= $totalEbook ?></strong> E-Book</span>
        </div>
    </div>

    <!-- Toolbar: Tambah Buku & Form Pencarian -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;flex-wrap:wrap;gap:15px;">
        <a href="/buku/tambah" class="btn-tambah">
            <i class="fas fa-plus"></i> Tambah Buku Baru
        </a>

        <form action="/buku" method="get" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
            <input type="text"
                   name="keyword"
                   class="search-input-buku"
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

            <select id="filter_type_select" class="search-input-buku" style="width: 190px;">
                <option value="" <?= $active_filter_type === '' ? 'selected' : '' ?>>🔍 Filter Berdasarkan</option>
                <option value="bahasa" <?= $active_filter_type === 'bahasa' ? 'selected' : '' ?>>🌐 Bahasa</option>
                <option value="jenis_koleksi" <?= $active_filter_type === 'jenis_koleksi' ? 'selected' : '' ?>>📚 Jenis Koleksi</option>
                <option value="ddc" <?= $active_filter_type === 'ddc' ? 'selected' : '' ?>>📂 Klasifikasi DDC</option>
            </select>

            <!-- Dropdown Bahasa -->
            <select name="bahasa" id="filter_bahasa_select" class="search-input-buku" style="<?= $active_filter_type === 'bahasa' ? 'display: inline-block;' : 'display: none;' ?> width: 180px;" <?= $active_filter_type === 'bahasa' ? '' : 'disabled' ?>>
                <option value="">Pilih Bahasa</option>
                <?php foreach ($bahasaList as $lang): ?>
                    <option value="<?= esc($lang) ?>" <?= (isset($bahasa_filter) && $bahasa_filter === $lang) ? 'selected' : '' ?>>🌐 <?= esc($lang) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Dropdown Jenis Koleksi -->
            <select name="jenis_koleksi" id="filter_jenis_select" class="search-input-buku" style="<?= $active_filter_type === 'jenis_koleksi' ? 'display: inline-block;' : 'display: none;' ?> width: 180px;" <?= $active_filter_type === 'jenis_koleksi' ? '' : 'disabled' ?>>
                <option value="">Pilih Jenis Koleksi</option>
                <option value="fisik" <?= (isset($jenis_koleksi_filter) && $jenis_koleksi_filter === 'fisik') ? 'selected' : '' ?>>📚 Buku Fisik</option>
                <option value="ebook" <?= (isset($jenis_koleksi_filter) && $jenis_koleksi_filter === 'ebook') ? 'selected' : '' ?>>📱 E-Book</option>
            </select>

            <!-- Dropdown DDC -->
            <select name="ddc" id="filter_ddc_select" class="search-input-buku" style="<?= $active_filter_type === 'ddc' ? 'display: inline-block;' : 'display: none;' ?> width: 220px;" <?= $active_filter_type === 'ddc' ? '' : 'disabled' ?>>
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

            <button type="submit" class="btn-cari-buku">
                🔍 Cari
            </button>

            <a href="/buku" class="btn-reset-buku">
                Reset
            </a>
        </form>
    </div>

    <!-- Grid Card Admin -->
    <div class="admin-paw-grid">
        <?php foreach($buku as $b): ?>
            <?php 
                $stok = (int)$b['stok'];
                
                // Menentukan path cover buku
                $coverField = !empty($b['foto']) ? $b['foto'] : (!empty($b['cover']) ? $b['cover'] : '');
                
                $coverPath = '/images/default_cover.svg'; // Fallback awal
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
            <div class="admin-paw-card">
                <!-- Cover Image & Status Badge -->
                <div class="paw-card-img-wrapper">
                    <!-- Badge KELOLA di Kiri Atas (Pembeda Utama 2) -->
                    <span class="admin-badge-mode">
                        <i class="fas fa-cog"></i> Kelola
                    </span>

                    <!-- Badge Kategori / Stok di Kanan Atas -->
                    <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook'): ?>
                        <span class="paw-status-badge" style="background-color: #ffe8d6; color: #a0522d; border: 1px solid rgba(160, 82, 45, 0.15);">
                            <i class="fas fa-mobile-alt mr-1"></i> E-Book
                        </span>
                    <?php elseif ($stok > 0): ?>
                        <span class="paw-status-badge badge-stok" style="background-color: #e2f9e1; color: #1e6b26; border: 1px solid rgba(30, 107, 38, 0.15);">
                            <i class="fas fa-book mr-1"></i> Buku Fisik (<?= $stok ?>)
                        </span>
                    <?php else: ?>
                        <span class="paw-status-badge badge-habis">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Habis
                        </span>
                    <?php endif; ?>
                    
                    <?php if ($coverPath == '/images/default_cover.svg'): ?>
                        <!-- Menggunakan SVG Inline sebagai cover default lucu -->
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

                <!-- Informasi Buku -->
                <div class="paw-card-body">
                    <span class="paw-book-code"><?= esc($b['kode_buku'] ?? 'BK' . str_pad($b['id'], 3, '0', STR_PAD_LEFT)) ?></span>
                    
                    <!-- Badge Klasifikasi DDC -->
                    <?php 
                        $db = \Config\Database::connect();
                        $rak = $db->table('rak')->where('id', $b['rak_id'])->get()->getRowArray();
                    ?>
                    <?php if ($rak): ?>
                        <span class="paw-ddc-badge" title="Klasifikasi DDC">
                            <i class="fas fa-tag"></i> DDC <?= esc($rak['kode_ddc']) ?>: <?= esc($rak['nama_rak']) ?>
                        </span>
                    <?php endif; ?>

                    <h5 class="paw-book-title" title="<?= esc($b['judul']); ?>"><?= esc($b['judul']); ?></h5>
                    <p class="paw-book-author">Oleh: <?= esc($b['penulis']); ?></p>
                    <div class="paw-book-meta">
                        <span><i class="far fa-building"></i> <?= esc($b['penerbit']); ?></span>
                        <span><i class="far fa-calendar-alt"></i> Tahun: <?= esc($b['tahun']); ?></span>
                        <span style="font-size: 0.75rem; color: #a89a8e; margin-top: 5px;">ID Buku: <?= esc($b['id']); ?></span>
                    </div>
                </div>

                <!-- Tombol Aksi (Edit & Hapus) (Pembeda Utama 3) -->
                <div class="paw-card-footer">
                    <a href="/buku/edit/<?= $b['id'] ?>?page=<?= isset($_GET['page_buku']) ? esc($_GET['page_buku']) : 1 ?>" class="btn-action btn-action-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    
                    <a href="/buku/hapus/<?= $b['id'] ?>?page=<?= isset($_GET['page_buku']) ? esc($_GET['page_buku']) : 1 ?>" 
                       class="btn-action btn-action-hapus"
                       onclick="return confirm('Buku ini akan meninggalkan rak hangat PawLib. Tetap hapus?')">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Paginasi di bagian bawah (Baru) -->
    <?php if (isset($pager)): ?>
        <div class="paw-pagination-container admin-pagination">
            <?= $pager->links('buku', 'default_full') ?>
        </div>
    <?php endif; ?>
</div>

<!-- Dynamic Cozy-Cat Toast Container -->
<div id="paw-toast"><i class="fas fa-paw"></i> <span id="paw-toast-message"></span></div>

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

    // Intercept book deletion with AJAX
    document.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.btn-action-hapus');
        if (deleteBtn) {
            e.preventDefault();
            if (confirm('Buku ini akan meninggalkan rak hangat PawLib. Tetap hapus?')) {
                const deleteUrl = deleteBtn.getAttribute('href');
                
                // Dim the card to give visual feedback
                const card = deleteBtn.closest('.admin-paw-card');
                if (card) {
                    card.style.opacity = '0.5';
                    card.style.pointerEvents = 'none';
                }
                
                fetch(deleteUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the current page dynamically via AJAX
                        reloadBookGrid();
                    } else {
                        alert('Gagal menghapus buku: ' + (data.message || 'Terjadi kesalahan'));
                        if (card) {
                            card.style.opacity = '1';
                            card.style.pointerEvents = 'auto';
                        }
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan koneksi saat menghapus buku.');
                    if (card) {
                        card.style.opacity = '1';
                        card.style.pointerEvents = 'auto';
                    }
                });
            }
        }
    });

    // Helper to reload the book list dynamically
    function reloadBookGrid(targetUrl = window.location.href) {
        fetch(targetUrl)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Count remaining cards on the page
                const cards = doc.querySelectorAll('.admin-paw-grid .admin-paw-card');
                
                // Get page parameter from targetUrl
                const urlObj = new URL(targetUrl, window.location.origin);
                let currentPage = parseInt(urlObj.searchParams.get('page_buku')) || 1;
                
                // If page is empty and we are not on page 1, load the previous page
                if (cards.length === 0 && currentPage > 1) {
                    currentPage--;
                    urlObj.searchParams.set('page_buku', currentPage);
                    
                    // Replace state and fetch again
                    window.history.replaceState(null, '', urlObj.toString());
                    reloadBookGrid(urlObj.toString());
                    return;
                }
                
                // Update Stats Overview
                const stats = document.getElementById('admin-stats-container');
                const newStats = doc.getElementById('admin-stats-container');
                if (stats && newStats) {
                    stats.innerHTML = newStats.innerHTML;
                }
                
                // Update Book Grid
                const grid = document.querySelector('.admin-paw-grid');
                const newGrid = doc.querySelector('.admin-paw-grid');
                if (grid && newGrid) {
                    grid.innerHTML = newGrid.innerHTML;
                }
                
                // Update Pagination
                const pagination = document.querySelector('.admin-pagination');
                const newPagination = doc.querySelector('.admin-pagination');
                if (pagination) {
                    if (newPagination) {
                        pagination.innerHTML = newPagination.innerHTML;
                        pagination.style.display = 'flex';
                    } else {
                        pagination.style.display = 'none';
                    }
                }
                
                // Update URL in the address bar without reloading
                window.history.replaceState(null, '', targetUrl);
                
                // Trigger toast notification
                showToast('Buku telah berhasil dihapus dari sistem PawLib.');
            })
            .catch(err => {
                console.error('Error reloading book grid:', err);
            });
    }

    // Function to trigger a Cozy-Cat sliding toast notification
    function showToast(message) {
        const toast = document.getElementById('paw-toast');
        const toastMessage = document.getElementById('paw-toast-message');
        if (toast && toastMessage) {
            toastMessage.textContent = message;
            toast.classList.add('show');
            
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }
    }
});
</script>

<?= $this->include('layout/footer'); ?>