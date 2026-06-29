<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<!-- Impor Google Font Quicksand agar selaras dengan tema kucing yang bulat dan hangat -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Impor Font Awesome untuk ikon-ikon cantik -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
    display: flex;
    flex-direction: column;
    gap: 5px;
    width: 100%;
    box-sizing: border-box;
}

.paw-title-card-header {
    display: flex;
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

.paw-subtitle {
    font-size: 1rem;
    color: #8c7b70;
    margin: 0;
    font-weight: 600;
}

/* Action Header */
.action-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
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

.total-badge {
    background-color: #f7ede2;
    color: #b58d63;
    padding: 8px 16px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.95rem;
}

/* Table styling */
.table-container {
    width: 100%;
    overflow-x: auto;
    background: white;
    border-radius: 20px;
    border: 2px solid #f2e7dd;
    box-shadow: 0 8px 18px rgba(74, 60, 49, 0.04);
    margin-bottom: 40px;
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
    background: #FBE7D4;
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

/* Book Cover Column */
.book-cover-cell {
    display: flex;
    align-items: center;
    gap: 15px;
}

.book-cover-thumb {
    width: 45px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #ebd5c5;
    background-color: #fffaf5;
}

.book-title-info {
    display: flex;
    flex-direction: column;
}

.book-title {
    font-weight: 700;
    color: #2E2118;
    font-size: 0.95rem;
}

.book-author {
    font-size: 0.8rem;
    color: #8c7b70;
    font-weight: 600;
}

.book-code-badge {
    background-color: #fff8ee;
    color: #c8814a;
    border: 1px solid #ebd5c5;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.5px;
}

/* Aksi Buttons */
.aksi-group {
    display: flex;
    gap: 8px;
}

.btn-action-view {
    background: #eaf2fc;
    color: #4A90E2;
    padding: 8px 14px;
    border-radius: 10px;
    text-decoration: none !important;
    font-size: 0.8rem;
    font-weight: 700;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-action-view:hover {
    background: #4A90E2;
    color: white !important;
}

.btn-action-edit {
    background: #fff5ec;
    color: #E69C62;
    padding: 8px 14px;
    border-radius: 10px;
    text-decoration: none !important;
    font-size: 0.8rem;
    font-weight: 700;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-action-edit:hover {
    background: #E69C62;
    color: white !important;
}

/* Empty State */
.empty-state-card {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 20px;
    border: 2px solid #f2e7dd;
    box-shadow: 0 8px 18px rgba(74, 60, 49, 0.03);
    margin-bottom: 40px;
}

.empty-state-icon {
    font-size: 3.5rem;
    color: #c0b3a7;
    margin-bottom: 15px;
}

.empty-state-card h3 {
    font-size: 1.3rem;
    color: #2E2118;
    margin-bottom: 8px;
    font-weight: 700;
}

.empty-state-card p {
    color: #8c7b70;
    margin-bottom: 0;
    font-weight: 600;
}
</style>

<div class="paw-container">
    <!-- Action Header -->
    <div class="action-header">
        <a href="/rak" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Kelola Rak
        </a>
        <span class="total-badge">
            <i class="fas fa-book-reader mr-1"></i> Total Koleksi: <b><?= $total_buku ?></b> buku
        </span>
    </div>

    <!-- Premium Minimalist Title Card -->
    <div class="paw-title-card">
        <div class="paw-title-card-header">
            <h1><i class="fas fa-layer-group"></i> Klasifikasi DDC: <?= esc($rak['kode_ddc']) ?></h1>
        </div>
        <p class="paw-subtitle">Nama Rak: <b><?= esc($rak['nama_rak']) ?></b></p>
    </div>

    <!-- Daftar Buku dalam Klasifikasi -->
    <?php if (empty($buku)) : ?>
        <div class="empty-state-card">
            <div class="empty-state-icon">😿</div>
            <h3>Belum ada buku di rak ini.</h3>
            <p>Silakan tambahkan atau pindahkan buku ke klasifikasi <b><?= esc($rak['kode_ddc']) ?> - <?= esc($rak['nama_rak']) ?></b>.</p>
        </div>
    <?php else : ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 35%;">Judul & Penulis</th>
                        <th style="width: 15%;">Kode Buku</th>
                        <th style="width: 15%;">Stok</th>
                        <th style="width: 20%;">Penerbit & Tahun</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($buku as $b) : ?>
                        <?php 
                            $coverField = !empty($b['cover']) ? $b['cover'] : (!empty($b['foto']) ? $b['foto'] : '');
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
                        <tr>
                            <!-- Judul & Penulis Cell dengan Thumbnail -->
                            <td>
                                <div class="book-cover-cell">
                                    <?php if ($coverPath == '/images/default_cover.svg'): ?>
                                        <svg class="book-cover-thumb" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400">
                                          <rect width="100%" height="100%" fill="#fff5ec"/>
                                          <g transform="translate(150, 200) scale(1)">
                                            <path d="M -20 10 C -20 -5, -10 -15, 0 -15 C 10 -15, 20 -5, 20 10 C 20 20, 10 25, 0 25 C -10 25, -20 20, -20 10 Z" fill="#E69C62" opacity="0.6"/>
                                          </g>
                                        </svg>
                                    <?php else: ?>
                                        <img src="<?= $coverPath ?>" alt="Cover" class="book-cover-thumb">
                                    <?php endif; ?>
                                    <div class="book-title-info">
                                        <span class="book-title"><?= esc($b['judul']) ?></span>
                                        <span class="book-author">Oleh: <?= esc($b['penulis']) ?></span>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Kode Buku -->
                            <td>
                                <span class="book-code-badge"><?= esc($b['kode_buku'] ?? 'BK' . str_pad($b['id'], 3, '0', STR_PAD_LEFT)) ?></span>
                            </td>
                            
                            <!-- Stok -->
                            <td>
                                <strong><?= esc($b['stok']) ?></strong> Koleksi
                            </td>
                            
                            <!-- Penerbit & Tahun -->
                            <td style="font-size: 0.85rem; color: #756456; font-weight: 600;">
                                <?= esc($b['penerbit']) ?> (<?= esc($b['tahun']) ?>)
                            </td>
                            
                            <!-- Tombol Aksi -->
                            <td>
                                <div class="aksi-group">
                                    <a href="/katalog/detail/<?= $b['id'] ?>" class="btn-action-view" title="Detail Buku">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="/buku/edit/<?= $b['id'] ?>?ref=rak_detail&rak_id=<?= $rak['id'] ?>" class="btn-action-edit" title="Edit Buku">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->include('layout/footer'); ?>