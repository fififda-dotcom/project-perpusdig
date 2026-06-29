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
    margin-bottom: 25px;
}

h1 {
    font-family: 'Quicksand', sans-serif;
    font-size: 32px;
    color: #2E2118;
    margin: 0 !important;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 12px;
}

/* CSS Tabs bertema Cozy Cat */
.paw-tabs-container {
    display: inline-flex;
    background: #FFFDF9;
    border-radius: 20px;
    padding: 6px;
    border: 2px solid #f2e7dd;
    gap: 8px;
    margin-bottom: 30px;
}

.paw-tab-btn {
    background: transparent;
    border: none;
    padding: 12px 24px;
    font-family: 'Quicksand', sans-serif;
    font-size: 0.95rem;
    font-weight: 700;
    color: #8c7b70;
    cursor: pointer;
    border-radius: 14px;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    gap: 10px;
}

.paw-tab-btn:hover {
    color: #E69C62;
    background: #FFFBF7;
}

.paw-tab-btn.active {
    background: #E69C62;
    color: white;
    box-shadow: 0 4px 12px rgba(230, 156, 98, 0.2);
}

.paw-tab-badge {
    font-size: 0.75rem;
    padding: 2px 8px;
    border-radius: 20px;
    font-weight: 700;
}

.paw-tab-btn.active .paw-tab-badge {
    background: white;
    color: #E69C62;
}

.paw-tab-btn:not(.active) .paw-tab-badge {
    background: #FFF5EC;
    color: #E69C62;
    border: 1px solid rgba(230, 156, 98, 0.15);
}

.paw-tab-panel {
    display: none;
    animation: fadeIn 0.3s ease-in-out;
}

.paw-tab-panel.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Modern Table */
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

/* Action Buttons */
.btn-kembali {
    background: #E69C62;
    color: white !important;
    padding: 10px 18px;
    border-radius: 12px;
    text-decoration: none !important;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    box-shadow: 0 4px 10px rgba(230, 156, 98, 0.15);
    border: none;
    cursor: pointer;
    font-size: 0.85rem;
}

.btn-kembali:hover {
    background: #c8814a;
    transform: translateY(-1px);
    box-shadow: 0 6px 14px rgba(230, 156, 98, 0.25);
}

.btn-verifikasi {
    background: #2ecc71;
    color: white !important;
    padding: 10px 18px;
    border-radius: 12px;
    text-decoration: none !important;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    box-shadow: 0 4px 10px rgba(46, 204, 113, 0.15);
    border: none;
    cursor: pointer;
    font-size: 0.85rem;
}

.btn-verifikasi:hover {
    background: #27ae60;
    transform: translateY(-1px);
    box-shadow: 0 6px 14px rgba(46, 204, 113, 0.25);
}

/* Status Badges */
.badge-riwayat-status {
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.status-telat {
    background-color: #FCE8E6;
    color: #C5221F;
    border: 1px solid rgba(197, 34, 31, 0.15);
}

.status-normal {
    background-color: #E6F4EA;
    color: #137333;
    border: 1px solid rgba(19, 115, 51, 0.15);
}

.status-diajukan {
    background-color: #E8F0FE;
    color: #1A73E8;
    border: 1px solid rgba(26, 115, 232, 0.15);
}

.denda-text {
    font-weight: 700;
    color: #C5221F;
    font-size: 0.95rem;
}

/* Empty State Card */
.paw-empty-state {
    text-align: center;
    padding: 50px 40px;
    background: white;
    border-radius: 24px;
    border: 2px solid #f2e7dd;
    box-shadow: 0 8px 24px rgba(74, 60, 49, 0.03);
    max-width: 500px;
    margin: 30px auto;
}
</style>

<div class="paw-container">
    <div class="paw-header-section">
        <h1><i class="fas fa-arrow-rotate-left" style="color: #E69C62;"></i> Pengembalian Buku Fisik</h1>
    </div>

    <!-- Alert status dengan visual PawLib -->
    <?php if (session()->getFlashdata('success')): ?>
        <div style="background: #e2f9e1; color: #1e6b26; padding: 15px 20px; border-radius: 16px; margin-bottom: 25px; font-weight: bold; border: 2px solid #c2ecc0; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div style="background: #ffebee; color: #c62828; padding: 15px 20px; border-radius: 16px; margin-bottom: 25px; font-weight: bold; border: 2px solid #ffcdd2; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- TABS NAVIGATION -->
    <div class="paw-tabs-container">
        <button class="paw-tab-btn active" onclick="switchTab(event, 'tab-aktif')">
            <i class="fas fa-book-reader"></i> Peminjaman Aktif 
            <span class="paw-tab-badge"><?= count($sedang_dipinjam) ?></span>
        </button>
        <button class="paw-tab-btn" onclick="switchTab(event, 'tab-pengajuan')">
            <i class="fas fa-file-invoice"></i> Pengajuan Pengembalian 
            <span class="paw-tab-badge"><?= count($pengajuan_kembali) ?></span>
        </button>
    </div>

    <!-- TAB PANEL 1: PEMINJAMAN AKTIF -->
    <div id="tab-aktif" class="paw-tab-panel active">
        <?php if (empty($sedang_dipinjam)): ?>
            <div class="paw-empty-state">
                <i class="fas fa-book-open" style="font-size: 3rem; color: #ebd5c5; display: block; margin-bottom: 15px;"></i>
                <h3 style="margin-bottom: 8px; color: #2E2118; font-weight: 700;">Semua Buku Fisik Aman!</h3>
                <p style="color: #8c7b70; margin: 0; font-size: 0.95rem;">Tidak ada transaksi peminjaman buku cetak yang sedang aktif saat ini. 🐾</p>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th width="80">ID</th>
                            <th width="180">Nama Anggota</th>
                            <th>Informasi Buku</th>
                            <th width="180">Tanggal Pinjam</th>
                            <th width="180">Batas Kembali</th>
                            <th width="240">Status / Keterlambatan</th>
                            <th width="150" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sedang_dipinjam as $p): ?>
                            <?php 
                                $today = strtotime(date('Y-m-d'));
                                $tanggalKembali = strtotime($p['tanggal_kembali']);
                                $telatDays = 0;
                                $denda = 0;
                                if ($today > $tanggalKembali) {
                                    $selisih = $today - $tanggalKembali;
                                    $telatDays = floor($selisih / (60 * 60 * 24));
                                    $denda = $telatDays * 2000;
                                }

                                // Mendapatkan path cover buku
                                $coverField = !empty($p['foto']) ? $p['foto'] : (!empty($p['cover']) ? $p['cover'] : '');
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
                                        #<?= $p['id'] ?>
                                    </span>
                                </td>
                                <td><strong style="color: #2E2118; font-size: 0.95rem;"><?= esc($p['nama']) ?></strong></td>
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
                                            <div style="font-weight: 700; color: #4a3c31; line-height: 1.35;"><?= esc($p['judul']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size: 0.9rem; font-weight: 600; color: #5a4b3f;">
                                    <i class="far fa-calendar-alt" style="color: #c8814a; margin-right: 8px;"></i><?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?>
                                </td>
                                <td style="font-size: 0.9rem; font-weight: 600; color: #5a4b3f;">
                                    <i class="far fa-calendar-times" style="color: #e74c3c; margin-right: 8px;"></i><?= date('d M Y', strtotime($p['tanggal_kembali'])) ?>
                                </td>
                                <td>
                                    <?php if ($telatDays > 0): ?>
                                        <span class="badge-riwayat-status status-telat">
                                            <i class="fas fa-exclamation-triangle"></i> Terlambat <?= $telatDays ?> hari (Rp <?= number_format($denda, 0, ',', '.') ?>)
                                        </span>
                                    <?php else: ?>
                                        <span class="badge-riwayat-status status-normal">
                                            <i class="fas fa-book-reader"></i> Aktif Dipinjam
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href="/pengembalian/kembalikan/<?= $p['id'] ?>" class="btn-kembali" onclick="return confirm('Apakah Anda yakin ingin memproses pengembalian buku ini?\n\nPastikan buku fisik sudah berada di meja sirkulasi perpustakaan.')">
                                        <i class="fas fa-undo"></i> Kembalikan
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- TAB PANEL 2: PENGAJUAN PENGEMBALIAN -->
    <div id="tab-pengajuan" class="paw-tab-panel">
        <?php if (empty($pengajuan_kembali)): ?>
            <div class="paw-empty-state">
                <i class="fas fa-face-smile-beam" style="font-size: 3rem; color: #ebd5c5; display: block; margin-bottom: 15px;"></i>
                <h3 style="margin-bottom: 8px; color: #2E2118; font-weight: 700;">Semua Bersih!</h3>
                <p style="color: #8c7b70; margin: 0; font-size: 0.95rem;">Tidak ada pengajuan pengembalian buku cetak yang menunggu verifikasi. 🐾</p>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th width="80">ID</th>
                            <th width="180">Nama Anggota</th>
                            <th>Informasi Buku</th>
                            <th width="180">Tanggal Pinjam</th>
                            <th width="180">Batas Kembali</th>
                            <th width="200">Estimasi Denda</th>
                            <th width="180" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pengajuan_kembali as $p): ?>
                            <?php 
                                $today = strtotime(date('Y-m-d'));
                                $tanggalKembali = strtotime($p['tanggal_kembali']);
                                $telatDays = 0;
                                $denda = 0;
                                if ($today > $tanggalKembali) {
                                    $selisih = $today - $tanggalKembali;
                                    $telatDays = floor($selisih / (60 * 60 * 24));
                                    $denda = $telatDays * 2000;
                                }

                                // Mendapatkan path cover buku
                                $coverField = !empty($p['foto']) ? $p['foto'] : (!empty($p['cover']) ? $p['cover'] : '');
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
                                        #<?= $p['id'] ?>
                                    </span>
                                </td>
                                <td><strong style="color: #2E2118; font-size: 0.95rem;"><?= esc($p['nama']) ?></strong></td>
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
                                            <div style="font-weight: 700; color: #4a3c31; line-height: 1.35;"><?= esc($p['judul']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size: 0.9rem; font-weight: 600; color: #5a4b3f;">
                                    <i class="far fa-calendar-alt" style="color: #c8814a; margin-right: 8px;"></i><?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?>
                                </td>
                                <td style="font-size: 0.9rem; font-weight: 600; color: #5a4b3f;">
                                    <i class="far fa-calendar-times" style="color: #e74c3c; margin-right: 8px;"></i><?= date('d M Y', strtotime($p['tanggal_kembali'])) ?>
                                </td>
                                <td>
                                    <?php if ($denda > 0): ?>
                                        <span class="denda-text">Rp <?= number_format($denda, 0, ',', '.') ?></span>
                                        <small style="display: block; color: #c62828; font-weight: 600; margin-top: 2px;"><i class="fas fa-clock"></i> Terlambat <?= $telatDays ?> hari</small>
                                    <?php else: ?>
                                        <span class="badge-riwayat-status status-normal">
                                            <i class="fas fa-shield-cat"></i> Bebas Denda
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href="/pengembalian/kembalikan/<?= $p['id'] ?>" class="btn-verifikasi" onclick="return confirm('Apakah Anda memverifikasi bahwa buku fisik \"<?= esc($p['judul']) ?>\" milik anggota \"<?= esc($p['nama']) ?>\" sudah dikembalikan dengan kondisi baik ke perpustakaan?\n\nProses ini akan menyelesaikan peminjaman.')">
                                        <i class="fas fa-check-circle"></i> Verifikasi Fisik
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function switchTab(event, tabId) {
    // Hide all panels
    const panels = document.querySelectorAll('.paw-tab-panel');
    panels.forEach(panel => panel.classList.remove('active'));

    // Deactivate all tab buttons
    const buttons = document.querySelectorAll('.paw-tab-btn');
    buttons.forEach(btn => btn.classList.remove('active'));

    // Show selected panel and activate selected button
    document.getElementById(tabId).classList.add('active');
    event.currentTarget.classList.add('active');
}
</script>

<?= $this->include('layout/footer'); ?>