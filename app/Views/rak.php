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

/* Table Container & Table */
.table-container {
    width: 100%;
    overflow-x: auto;
    margin-bottom: 25px;
    background: white;
    border-radius: 20px;
    border: 2px solid #f2e7dd;
    box-shadow: 0 8px 18px rgba(74, 60, 49, 0.04);
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 18px 24px;
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

/* Badges & Buttons */
.ddc-code-badge {
    background-color: #fff8ee;
    color: #c8814a;
    border: 1px solid #ebd5c5;
    padding: 6px 14px;
    border-radius: 10px;
    font-family: monospace;
    font-size: 1rem;
    font-weight: 700;
}

.book-count-badge {
    background-color: #f7ede2;
    color: #b58d63;
    padding: 5px 12px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.9rem;
}

.btn-action-detail {
    background: #fff5ec;
    color: #E69C62;
    padding: 10px 20px;
    border-radius: 12px;
    text-decoration: none !important;
    font-size: 0.85rem;
    font-weight: 700;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: none;
    box-shadow: 0 2px 5px rgba(230, 156, 98, 0.05);
}

.btn-action-detail:hover {
    background: #E69C62;
    color: white !important;
    box-shadow: 0 4px 10px rgba(230, 156, 98, 0.25);
}
</style>

<div class="paw-container">
    <!-- Premium Minimalist Title Card -->
    <div class="paw-title-card">
        <h1><i class="fas fa-folder-open"></i> Kelola Rak DDC</h1>
    </div>

    <!-- Alert / Flash Message -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 shadow-sm" style="border-radius: 12px; font-weight: 600; font-family: 'Quicksand', sans-serif; background-color: #eafaf1; color: #2ecc71; padding: 15px; margin-bottom: 20px;">
            🐾 <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Table Kelola Rak DDC -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">Kode DDC</th>
                    <th style="width: 50%;">Nama Klasifikasi (Rak)</th>
                    <th style="width: 15%; text-align: center;">Jumlah Buku</th>
                    <th style="width: 15%; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rak as $r) : ?>
                    <tr>
                        <!-- Kode DDC -->
                        <td>
                            <span class="ddc-code-badge"><?= esc($r['kode_ddc']) ?></span>
                        </td>
                        
                        <!-- Nama Klasifikasi -->
                        <td>
                            <strong style="color: #2E2118; font-size: 1rem;"><?= esc($r['nama_rak']) ?></strong>
                        </td>
                        
                        <!-- Jumlah Buku -->
                        <td style="text-align: center;">
                            <span class="book-count-badge"> <?= esc($r['jumlah_buku']) ?> buku</span>
                        </td>
                        
                        <!-- Tombol Detail -->
                        <td style="text-align: center;">
                            <a href="/rak/detail/<?= $r['id'] ?>" class="btn-action-detail">
                                <i class="fas fa-search-plus"></i> Detail Koleksi
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('layout/footer'); ?>