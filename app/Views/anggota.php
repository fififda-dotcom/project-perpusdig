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
    padding-bottom: 40px;
}

.paw-header-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 25px;
}

h1 {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 32px;
    color: #2E2118;
    margin: 0 !important;
    display: flex;
    align-items: center;
    gap: 12px;
}

/* Statistics Grid */
.paw-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 35px;
}

.paw-stat-card {
    background: white;
    border-radius: 24px;
    padding: 22px 26px;
    border: 2px solid #f2e7dd;
    box-shadow: 0 8px 20px rgba(74, 60, 49, 0.03);
    display: flex;
    align-items: center;
    gap: 18px;
    transition: all 0.3s ease;
}

.paw-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(74, 60, 49, 0.07);
    border-color: #E69C62;
}

.paw-stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.icon-members { background: #FFF5EC; color: #E69C62; }
.icon-active-borrowers { background: #E6F4EA; color: #137333; }

.paw-stat-info {
    display: flex;
    flex-direction: column;
}

.paw-stat-value {
    font-size: 1.9rem;
    font-weight: 700;
    color: #2E2118;
    line-height: 1.2;
}

.paw-stat-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #8c7b70;
}

/* Button Tambah */
.btn-tambah {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #E69C62;
    color: white !important;
    padding: 13px 24px;
    border-radius: 16px;
    text-decoration: none;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(230, 156, 98, 0.2);
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    font-size: 0.95rem;
}

.btn-tambah:hover {
    background: #c8814a;
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(230, 156, 98, 0.3);
}

/* Kustomisasi Pencarian */
.search-input-buku {
    padding: 12px 18px;
    padding-left: 42px;
    width: 280px;
    border: 2px solid #ebd5c5;
    border-radius: 16px;
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
    border-radius: 16px;
    cursor: pointer;
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    transition: all 0.2s ease;
    box-shadow: 0 4px 10px rgba(230, 156, 98, 0.15);
}

.btn-cari-buku:hover {
    background: #c8814a;
}

.btn-reset-buku {
    padding: 12px 22px;
    background: #c0b3a7;
    color: white !important;
    text-decoration: none;
    border-radius: 16px;
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    display: inline-block;
    transition: all 0.2s ease;
}

.btn-reset-buku:hover {
    background: #a89a8e;
    text-decoration: none;
}

/* Modern Table */
.table-container {
    width: 100%;
    overflow-x: auto;
    margin-bottom: 25px;
    background: white;
    border-radius: 24px;
    border: 2px solid #f2e7dd;
    box-shadow: 0 8px 24px rgba(74, 60, 49, 0.04);
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 18px 22px;
    text-align: left;
    vertical-align: middle;
}

th {
    background: #FBE7D4;
    color: #4a3c31;
    font-weight: 700;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #f2e7dd;
}

tr {
    border-bottom: 1px solid #f2e7dd;
    transition: background-color 0.2s;
}

tr:hover {
    background-color: #FFFDF9;
}

tr:last-child {
    border-bottom: none;
}

/* Avatars */
.member-profile-cell {
    display: flex;
    align-items: center;
    gap: 14px;
}

.member-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    border: 2px solid #fff;
    box-shadow: 0 4px 10px rgba(74, 60, 49, 0.08);
    text-transform: uppercase;
    overflow: hidden;
    flex-shrink: 0;
}

.member-name-info {
    display: flex;
    flex-direction: column;
}

.member-name {
    font-weight: 700;
    color: #2E2118;
    font-size: 1rem;
    text-transform: capitalize;
}

.member-code {
    font-size: 0.75rem;
    color: #8c7b70;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.member-id-badge {
    background-color: #fff5ec;
    color: #c8814a;
    padding: 6px 12px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.8rem;
    border: 1px solid #ebd5c5;
}

/* Action Buttons */
.aksi-column {
    display: flex;
    gap: 8px;
    align-items: center;
    justify-content: center;
}

.btn-action-detail {
    background: #fff5ec;
    color: #E69C62 !important;
    border: 1px solid rgba(230, 156, 98, 0.2);
}

.btn-action-detail:hover {
    background: #E69C62;
    color: white !important;
    box-shadow: 0 4px 10px rgba(230, 156, 98, 0.2);
}

.btn-action-edit {
    background: #eaf2fc;
    color: #4A90E2 !important;
    border: 1px solid rgba(74, 144, 226, 0.2);
}

.btn-action-edit:hover {
    background: #4A90E2;
    color: white !important;
    box-shadow: 0 4px 10px rgba(74, 144, 226, 0.2);
}

.btn-action-hapus {
    background: #fdf0ee;
    color: #E74C3C !important;
    border: 1px solid rgba(231, 76, 60, 0.2);
}

.btn-action-hapus:hover {
    background: #E74C3C;
    color: white !important;
    box-shadow: 0 4px 10px rgba(231, 76, 60, 0.2);
}

.btn-action-detail,
.btn-action-edit,
.btn-action-hapus {
    padding: 8px 14px;
    border-radius: 12px;
    text-decoration: none !important;
    font-size: 0.8rem;
    font-weight: 700;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
}

/* Contact Links */
.contact-link {
    color: #5a4b3f;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
    font-size: 0.9rem;
}

.contact-link:hover {
    color: #E69C62;
}

/* Styling Pagination */
.paw-pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 15px;
    margin-bottom: 45px;
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
    background-color: #FFF5EC;
    color: #E69C62;
}

.admin-pagination li.active span,
.admin-pagination li.active a {
    background-color: #E69C62;
    color: white !important;
    box-shadow: 0 4px 10px rgba(230, 156, 98, 0.3);
}
</style>

<?php 
    // Hitung statistik database untuk anggota secara real-time
    $db = \Config\Database::connect();
    $totalAnggota = $db->table('anggota')->countAllResults();
    $activeBorrowers = $db->table('peminjaman')
                          ->whereIn('status', ['Dipinjam', 'Diajukan'])
                          ->groupBy('anggota_id')
                          ->countAllResults();
                          
    // Palet warna pastel untuk inisial nama jika foto kosong
    $avatarColors = [
        ['bg' => '#FFF5EC', 'text' => '#E69C62'],
        ['bg' => '#E8F0FE', 'text' => '#1A73E8'],
        ['bg' => '#E6F4EA', 'text' => '#137333'],
        ['bg' => '#FCE8E6', 'text' => '#C5221F'],
        ['bg' => '#FEF7E0', 'text' => '#B06000'],
        ['bg' => '#F3E8FD', 'text' => '#9333EA']
    ];
?>

<div class="paw-container">
    <div class="paw-header-section">
        <h1><i class="fas fa-users" style="color: #E69C62;"></i> Anggota PawLib</h1>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="paw-stats-grid">
        <div class="paw-stat-card">
            <div class="paw-stat-icon icon-members">
                <i class="fas fa-users"></i>
            </div>
            <div class="paw-stat-info">
                <span class="paw-stat-value"><?= $totalAnggota ?></span>
                <span class="paw-stat-label">Total Anggota Terdaftar</span>
            </div>
        </div>
        
        <div class="paw-stat-card">
            <div class="paw-stat-icon icon-active-borrowers">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="paw-stat-info">
                <span class="paw-stat-value"><?= $activeBorrowers ?></span>
                <span class="paw-stat-label">Anggota Aktif Meminjam</span>
            </div>
        </div>
    </div>

    <!-- Toolbar: Tambah Anggota & Form Pencarian -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;flex-wrap:wrap;gap:20px;">
        <a href="/anggota/tambah" class="btn-tambah">
            <i class="fas fa-user-plus"></i> Tambah Anggota Baru
        </a>

        <form action="/anggota" method="get" style="display:flex;gap:10px;align-items:center;position:relative;">
            <div style="position:relative; display:flex; align-items:center;">
                <i class="fas fa-search" style="position:absolute; left:16px; color:#c0b3a7; font-size: 0.95rem;"></i>
                <input type="text"
                       name="keyword"
                       class="search-input-buku"
                       placeholder="Cari nama atau kode..."
                       value="<?= esc($keyword ?? '') ?>">
            </div>

            <button type="submit" class="btn-cari-buku">
                Cari
            </button>

            <a href="/anggota" class="btn-reset-buku">
                Reset
            </a>
        </form>
    </div>

    <!-- Container Tabel Modern -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 28%;">Nama Anggota</th>
                    <th style="width: 14%;">ID Sistem</th>
                    <th style="width: 20%;">Nomor HP</th>
                    <th style="width: 23%;">Alamat Email</th>
                    <th style="width: 15%; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($anggota)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #8c7b70;">
                            <i class="fas fa-users-slash" style="font-size: 2.5rem; color: #ebd5c5; display: block; margin-bottom: 10px;"></i>
                            <strong>Data anggota tidak ditemukan.</strong>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($anggota as $a): ?>
                        <?php 
                            // Tentukan warna avatar berdasarkan ID anggota
                            $colorIndex = $a['id'] % count($avatarColors);
                            $avBg = $avatarColors[$colorIndex]['bg'];
                            $avText = $avatarColors[$colorIndex]['text'];
                            
                            $photoPath = !empty($a['foto']) && file_exists(FCPATH . 'uploads/profile/' . $a['foto']) ? '/uploads/profile/' . $a['foto'] : '';
                        ?>
                        <tr>
                            <!-- Kolom Nama Terpadu dengan Avatar -->
                            <td>
                                <div class="member-profile-cell">
                                    <div class="member-avatar" style="background-color: <?= $avBg ?>; color: <?= $avText ?>;">
                                        <?php if (!empty($photoPath)): ?>
                                            <img src="<?= $photoPath ?>" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                        <?php else: ?>
                                            <?= strtoupper(substr($a['nama'], 0, 1)) ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="member-name-info">
                                        <span class="member-name"><?= esc($a['nama']) ?></span>
                                        <span class="member-code"><?= esc($a['kode_anggota'] ?? '-') ?></span>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Kolom ID -->
                            <td>
                                <span class="member-id-badge">#<?= esc($a['id']) ?></span>
                            </td>
                            
                            <!-- Kolom Nomor HP -->
                            <td>
                                <a href="tel:<?= esc($a['nomor']) ?>" class="contact-link">
                                    <i class="fas fa-phone-alt" style="font-size: 0.8rem; color: #c8814a; margin-right: 6px;"></i> 
                                    <?= esc($a['nomor']) ?>
                                </a>
                            </td>
                            
                            <!-- Kolom Email -->
                            <td>
                                <a href="mailto:<?= esc($a['gmail']) ?>" class="contact-link">
                                    <i class="far fa-envelope" style="font-size: 0.85rem; color: #c8814a; margin-right: 6px;"></i> 
                                    <?= esc($a['gmail']) ?>
                                </a>
                            </td>
                            <td>
                                <div class="aksi-column">
                                    <a href="/anggota/detail/<?= $a['id'] ?>" class="btn-action-detail" title="Detail Anggota">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </a>
                                    <a href="/anggota/edit/<?= $a['id'] ?>" class="btn-action-edit" title="Edit Anggota">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="/anggota/hapus/<?= $a['id'] ?>" 
                                       class="btn-action-hapus"
                                       onclick="return confirm('🐾 Anggota ini akan dikeluarkan dari PawLib. Tetap hapus?')"
                                       title="Hapus Anggota">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginasi di bagian bawah (Baru) -->
    <?php if (isset($pager)): ?>
        <div class="paw-pagination-container admin-pagination">
            <?= $pager->links('anggota', 'default_full') ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->include('layout/footer'); ?>