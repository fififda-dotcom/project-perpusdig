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
    padding-bottom: 40px;
}

.paw-header-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
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
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 35px;
}

.paw-stat-card {
    background: white;
    border-radius: 24px;
    padding: 20px 24px;
    border: 2px solid #f2e7dd;
    box-shadow: 0 8px 20px rgba(74, 60, 49, 0.03);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all 0.3s ease;
}

.paw-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(74, 60, 49, 0.07);
    border-color: #E69C62;
}

.paw-stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}

.icon-total { background: #FFF5EC; color: #E69C62; }
.icon-active { background: #FEF7E0; color: #B06000; }
.icon-overdue { background: #FCE8E6; color: #C5221F; }
.icon-completed { background: #E6F4EA; color: #137333; }

.paw-stat-info {
    display: flex;
    flex-direction: column;
}

.paw-stat-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2E2118;
    line-height: 1.2;
}

.paw-stat-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #8c7b70;
}

/* Modern Table Container */
.table-container {
    width: 100%;
    overflow-x: auto;
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
    padding: 18px 24px;
    text-align: left;
    vertical-align: middle;
    font-size: 0.95rem;
}

th {
    background: #FBE7D4;
    color: #4a3c31;
    font-weight: 700;
    border-bottom: 2px solid #f2e7dd;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
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

/* Badge Status */
.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 700;
}

.status-pinjam {
    background-color: #FEF7E0;
    color: #B06000;
    border: 1px solid rgba(176, 96, 0, 0.15);
}

.status-kembali {
    background-color: #E6F4EA;
    color: #137333;
    border: 1px solid rgba(19, 115, 51, 0.15);
}

.status-diajukan {
    background-color: #E8F0FE;
    color: #1A73E8;
    border: 1px solid rgba(26, 115, 232, 0.15);
}

.status-telat {
    background-color: #FCE8E6;
    color: #C5221F;
    border: 1px solid rgba(197, 34, 31, 0.15);
}
</style>

<?php 
    // Hitung statistik peminjaman secara dinamis dari array riwayat
    $totalLoans = count($riwayat);
    $activeLoans = 0;
    $overdueLoans = 0;
    $completedLoans = 0;
    $today = strtotime(date('Y-m-d'));
    
    foreach ($riwayat as $r) {
        $statusLower = strtolower($r['status'] ?? '');
        $tanggalKembali = strtotime($r['tanggal_kembali'] ?? '');
        
        if ($statusLower === 'selesai' || $statusLower === 'dikembalikan') {
            $completedLoans++;
        } elseif ($statusLower === 'dipinjam') {
            $activeLoans++;
            if ($today > $tanggalKembali) {
                $overdueLoans++;
            }
        } elseif ($statusLower === 'diajukan') {
            $activeLoans++; // Anggap aktif jika sedang dalam proses kembali
        }
    }
?>

<div class="paw-container">
    <div class="paw-header-section">
        <h1><i class="fas fa-history" style="color: #E69C62;"></i> Riwayat Peminjaman Buku</h1>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="paw-stats-grid">
        <div class="paw-stat-card">
            <div class="paw-stat-icon icon-total">
                <i class="fas fa-receipt"></i>
            </div>
            <div class="paw-stat-info">
                <span class="paw-stat-value"><?= $totalLoans ?></span>
                <span class="paw-stat-label">Total Transaksi</span>
            </div>
        </div>
        
        <div class="paw-stat-card">
            <div class="paw-stat-icon icon-active">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="paw-stat-info">
                <span class="paw-stat-value"><?= $activeLoans ?></span>
                <span class="paw-stat-label">Sedang Dipinjam</span>
            </div>
        </div>
        
        <div class="paw-stat-card">
            <div class="paw-stat-icon icon-overdue">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="paw-stat-info">
                <span class="paw-stat-value"><?= $overdueLoans ?></span>
                <span class="paw-stat-label">Terlambat</span>
            </div>
        </div>
        
        <div class="paw-stat-card">
            <div class="paw-stat-icon icon-completed">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="paw-stat-info">
                <span class="paw-stat-value"><?= $completedLoans ?></span>
                <span class="paw-stat-label">Sudah Kembali</span>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th width="80">ID</th>
                    <th width="180">Nama Peminjam</th>
                    <th>Informasi Buku</th>
                    <th width="180">Tanggal Pinjam</th>
                    <th width="180">Batas Kembali</th>
                    <th width="200">Tanggal Dikembalikan</th>
                    <th width="160">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($riwayat)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #8c7b70;">
                            <i class="fas fa-file-alt" style="font-size: 2.5rem; color: #ebd5c5; display: block; margin-bottom: 10px;"></i>
                            <strong>Belum ada riwayat peminjaman buku.</strong>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($riwayat as $r): ?>
                        <?php 
                            $statusLower = strtolower($r['status'] ?? '');
                            $todayTime = strtotime(date('Y-m-d'));
                            $tanggalKembaliTime = strtotime($r['tanggal_kembali'] ?? '');
                            $isOverdue = ($statusLower === 'dipinjam' && $todayTime > $tanggalKembaliTime);
                            
                            // Mendapatkan path cover buku
                            $coverField = !empty($r['foto']) ? $r['foto'] : (!empty($r['cover']) ? $r['cover'] : '');
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
                        <tr>
                            <td>
                                <span style="background-color: #fff5ec; color: #c8814a; padding: 6px 12px; border-radius: 10px; font-weight: 700; font-size: 0.8rem; border: 1px solid #ebd5c5;">
                                    #<?= $r['id'] ?>
                                </span>
                            </td>
                            <td>
                                <strong style="color: #2E2118; font-size: 0.95rem;"><?= esc($r['nama']) ?></strong>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 14px;">
                                    <div style="width: 38px; height: 52px; border-radius: 8px; overflow: hidden; border: 2px solid #f2e7dd; box-shadow: 0 4px 8px rgba(74, 60, 49, 0.05); flex-shrink: 0; background: #fffbf7; display: flex; align-items: center; justify-content: center;">
                                        <?php if ($coverPath === '/images/default_cover.svg'): ?>
                                            <i class="fas fa-book" style="color: #ebd5c5; font-size: 1.2rem;"></i>
                                        <?php else: ?>
                                            <img src="<?= $coverPath ?>" alt="Cover" style="width: 100%; height: 100%; object-fit: cover;">
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: #4a3c31; line-height: 1.35;"><?= esc($r['judul']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size: 0.9rem; font-weight: 600; color: #5a4b3f;">
                                <i class="far fa-calendar-alt" style="color: #c8814a; margin-right: 8px;"></i><?= date('d M Y', strtotime($r['tanggal_pinjam'])) ?>
                            </td>
                            <td style="font-size: 0.9rem; font-weight: 600; color: #5a4b3f;">
                                <i class="far fa-calendar-times" style="color: #e74c3c; margin-right: 8px;"></i><?= date('d M Y', strtotime($r['tanggal_kembali'])) ?>
                            </td>
                            <td style="font-size: 0.9rem; font-weight: 600; color: #5a4b3f;">
                                <?php if (!empty($r['tanggal_dikembalikan']) && $r['tanggal_dikembalikan'] !== '0000-00-00'): ?>
                                    <i class="far fa-calendar-check" style="color: #2ecc71; margin-right: 8px;"></i><?= date('d M Y', strtotime($r['tanggal_dikembalikan'])) ?>
                                <?php else: ?>
                                    <span style="color: #a89a8e; font-style: italic; font-weight: 500;">Belum dikembalikan</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($statusLower === 'diajukan'): ?>
                                    <span class="badge-status status-diajukan">
                                        <i class="fas fa-clock"></i> Diajukan
                                    </span>
                                <?php elseif ($isOverdue): ?>
                                    <span class="badge-status status-telat">
                                        <i class="fas fa-exclamation-triangle"></i> Terlambat
                                    </span>
                                <?php elseif ($statusLower === 'dipinjam'): ?>
                                    <span class="badge-status status-pinjam">
                                        <i class="fas fa-history"></i> Dipinjam
                                    </span>
                                <?php else: ?>
                                    <span class="badge-status status-kembali">
                                        <i class="fas fa-check-circle"></i> Selesai
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