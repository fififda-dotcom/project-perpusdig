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
    background: white;
    padding: 30px;
    border-radius: 24px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.04);
    border: 2px solid #f2e7dd;
    margin-bottom: 25px;
}

table {
    width: 100%;
    background: white;
    border-collapse: collapse;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 18px rgba(0,0,0,0.04);
    border: 2px solid #f2e7dd;
}

th, td {
    padding: 16px 18px;
    text-align: left;
    font-family: 'Quicksand', sans-serif;
    font-weight: 600;
    font-size: 0.95rem;
}

th {
    background: #FBE7D4;
    color: #4a3c31;
    font-weight: 700;
}

tr {
    border-bottom: 1px solid #f2e7dd;
    transition: background-color 0.2s;
}

tr:last-child {
    border-bottom: none;
}

tr:hover {
    background-color: #fffbf9;
}

input:focus {
    outline: none;
    border-color: #E69C62 !important;
    box-shadow: 0 0 0 4px rgba(230, 156, 98, 0.15);
}

.badge-telat {
    background-color: #ffe5e5;
    color: #c0392b;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: bold;
    border: 1px solid rgba(192, 57, 43, 0.1);
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.85rem;
}

.denda-text {
    font-weight: 700;
    color: #c0392b;
    font-size: 1rem;
}

.table-container {
    width: 100%;
    overflow-x: auto;
}
</style>

<div class="paw-container">
    <!-- Title Card Header -->
    <div class="paw-title-card">
        <h1 style="margin: 0; font-weight: 700; color: #2E2118; font-size: 28px;">Pengawasan Denda Keterlambatan 💸</h1>
        <p style="margin: 5px 0 0 0; color: #8c7b70; font-size: 0.9rem; font-weight: 600;">Monitor denda keterlambatan pengembalian buku fisik perpustakaan PawLib.</p>
    </div>

    <!-- Search bar -->
    <div style="background: white; padding: 20px; border-radius: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); border: 2px solid #f2e7dd; margin-bottom: 25px;">
        <form action="/denda" method="get" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <div style="flex-grow: 1; min-width: 250px; position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #8c7b70; opacity: 0.7;"></i>
                <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama anggota atau judul buku..." style="width: 100%; padding: 12px 15px 12px 42px; border: 2px solid #ebd5c5; border-radius: 14px; font-family: 'Quicksand', sans-serif; font-weight: 600; font-size: 0.95rem; box-sizing: border-box; color: #4a3c31; transition: all 0.3s ease;">
            </div>
            <button type="submit" style="background: #E69C62; color: white; padding: 12px 24px; border: none; border-radius: 14px; font-family: 'Quicksand', sans-serif; font-weight: bold; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 10px rgba(230,156,98,0.2); transition: all 0.2s; font-size: 0.95rem;">
                Cari
            </button>
            <?php if (!empty($keyword)): ?>
                <a href="/denda" style="background: #f0e2d3; color: #4a3c31; padding: 12px 24px; border-radius: 14px; font-family: 'Quicksand', sans-serif; font-weight: bold; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; font-size: 0.95rem;">
                    Reset
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Batas Kembali</th>
                    <th>Keterlambatan</th>
                    <th>Denda Berjalan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($denda)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 35px; color: #8c7b70;">
                            Tidak ada data keterlambatan denda aktif saat ini.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($denda as $d): ?>
                        <?php
                            $hari = floor((strtotime(date('Y-m-d')) - strtotime($d['tanggal_kembali'])) / 86400);
                            if ($hari < 0) {
                                $hari = 0;
                            }
                            $total = $hari * 2000;
                        ?>
                        <tr>
                            <td><strong><?= esc($d['nama']) ?></strong></td>
                            <td><?= esc($d['judul']) ?></td>
                            <td><?= date('d M Y', strtotime($d['tanggal_kembali'])) ?></td>
                            <td>
                                <span class="badge-telat">
                                    <i class="fas fa-clock"></i> <?= $hari ?> Hari
                                </span>
                            </td>
                            <td>
                                <span class="denda-text">Rp <?= number_format($total, 0, ',', '.') ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('layout/footer'); ?>