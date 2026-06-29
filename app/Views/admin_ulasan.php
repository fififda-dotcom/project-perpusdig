<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
.paw-container {
    font-family: 'Quicksand', sans-serif;
    color: #4a3c31;
    padding-bottom: 60px;
}
.paw-card {
    background: white;
    padding: 30px;
    border-radius: 24px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.04);
    border: 2px solid #f2e7dd;
    margin-bottom: 25px;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 25px;
}
.stat-card {
    background: white;
    border: 2px solid #f2e7dd;
    border-radius: 20px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 12px rgba(74, 60, 49, 0.02);
}
.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}
.stat-info h4 {
    margin: 0;
    font-size: 0.9rem;
    color: #8c7b70;
    font-weight: 700;
}
.stat-info h2 {
    margin: 5px 0 0 0;
    font-size: 1.8rem;
    font-weight: 800;
    color: #4a3c31;
}
.btn-delete-ulasan {
    background: #fdf2f2;
    border: 1px solid #fde8e8;
    color: #e74c3c;
    padding: 8px 12px;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: bold;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}
.btn-delete-ulasan:hover {
    background: #e74c3c;
    color: white !important;
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
    font-weight: 600;
    font-size: 0.9rem;
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
</style>

<div class="paw-container">
    <div class="paw-card">
        <h3 class="font-weight-bold mb-2"><i class="fas fa-comments" style="color: #E69C62;"></i> Moderasi Rating & Ulasan</h3>
        <p class="text-muted mb-0">Kelola dan pantau ulasan serta penilaian buku yang diposting oleh para anggota perpustakaan PawLib.</p>
    </div>

    <!-- Statistik Widgets -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #fff9e6; color: #f1c40f;">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-info">
                <h4>Total Rating</h4>
                <h2><?= $totalRating ?></h2>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #eafaf1; color: #2ecc71;">
                <i class="far fa-comment-dots"></i>
            </div>
            <div class="stat-info">
                <h4>Total Ulasan</h4>
                <h2><?= $totalUlasan ?></h2>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fdf0e6; color: #e69c62;">
                <i class="fas fa-star-half-alt"></i>
            </div>
            <div class="stat-info">
                <h4>Rata-rata Rating</h4>
                <h2><?= $avgRatingSeluruh ?> / 5.0</h2>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div style="background: #e2f9e1; color: #1e6b26; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: bold; border: 1px solid rgba(30,107,38,0.15);">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: bold; border: 1px solid rgba(198,40,40,0.15);">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Tabel Daftar Ulasan -->
    <div style="overflow-x: auto; margin-bottom: 30px;">
        <table>
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th width="150">Buku</th>
                    <th width="150">Anggota</th>
                    <th width="120">Rating</th>
                    <th>Ulasan</th>
                    <th width="120">Tanggal</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ulasanList)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #8c7b70;">
                            <i class="fas fa-comment-slash" style="font-size: 2.5rem; color: #ebd5c5; display: block; margin-bottom: 10px;"></i>
                            <strong>Belum ada rating atau ulasan yang diposting oleh anggota.</strong>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($ulasanList as $ul): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong style="color: #4a3c31;"><?= esc($ul['judul_buku']) ?></strong>
                            </td>
                            <td><?= esc($ul['nama_anggota']) ?></td>
                            <td>
                                <div style="color: #F1C40F; font-size: 0.9rem;">
                                    <?= str_repeat('★', $ul['rating'] ?? 5) . str_repeat('☆', 5 - ($ul['rating'] ?? 5)) ?>
                                </div>
                            </td>
                            <td>
                                <?php if (empty($ul['ulasan'])): ?>
                                    <span class="text-muted" style="font-style: italic; color: #a89a8e;">(Tidak ada ulasan tertulis)</span>
                                <?php else: ?>
                                    <p style="margin: 0; line-height: 1.4; color: #5a4b3f; font-size: 0.85rem; max-width: 400px; text-align: justify; white-space: pre-wrap;">
                                        "<?= esc($ul['ulasan']) ?>"
                                    </p>
                                <?php endif; ?>
                            </td>
                            <td style="font-size: 0.8rem; color: #8c7b70;">
                                <?= date('d M Y', strtotime($ul['created_at'])) ?>
                            </td>
                            <td>
                                <a href="/admin/ulasan/hapus/<?= $ul['id'] ?>" class="btn-delete-ulasan" onclick="return confirm('Apakah Anda yakin ingin menghapus rating dan ulasan ini?\n\nTindakan ini tidak dapat dibatalkan.')">
                                    <i class="far fa-trash-can"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('layout/footer'); ?>
