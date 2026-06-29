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

h1 {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 32px;
    margin-top: 0px !important; 
    margin-bottom: 20px !important;
    color: #4a3c31;
}

.form-box {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.06);
    max-width: 700px;
    border: 2px solid #f2e7dd;
    box-sizing: border-box;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
    color: #4a3c31;
}

input, select {
    width: 100%;
    padding: 12px;
    border: 2px solid #ebd5c5;
    border-radius: 12px;
    box-sizing: border-box;
    font-family: 'Quicksand', sans-serif;
    font-weight: 600;
    color: #4a3c31;
    transition: all 0.3s ease;
}

input:focus, select:focus {
    outline: none;
    border-color: #E69C62;
    box-shadow: 0 0 0 4px rgba(230, 156, 98, 0.15);
}

input[readonly] {
    background-color: #faf5f0;
    border-color: #ebd5c5;
    color: #8c7b70;
    cursor: not-allowed;
}

/* Widget Preview Buku di Halaman Peminjaman */
.paw-loan-preview-card {
    background-color: #fff9f3;
    border: 2px dashed #E69C62;
    border-radius: 16px;
    padding: 15px;
    margin-bottom: 25px;
    display: flex;
    gap: 15px;
    align-items: center;
}

.paw-loan-preview-img-wrapper {
    width: 70px;
    height: 95px;
    border-radius: 10px;
    overflow: hidden;
    background-color: #fff0e0;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid #f2e7dd;
}

.paw-loan-preview-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.paw-loan-preview-info {
    flex-grow: 1;
}

.paw-loan-preview-code {
    font-size: 0.7rem;
    font-weight: 700;
    color: #E69C62;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    display: block;
}

.paw-loan-preview-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #4a3c31;
    margin: 2px 0;
}

.paw-loan-preview-author {
    font-size: 0.85rem;
    color: #8c7b70;
    margin: 0;
}

/* Button Styling */
.btn-actions-container {
    display: flex;
    gap: 12px;
    margin-top: 25px;
}

.btn-simpan {
    background: #E69C62;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 12px;
    font-weight: bold;
    cursor: pointer;
    font-family: 'Quicksand', sans-serif;
    font-size: 1rem;
    box-shadow: 0 4px 12px rgba(230, 156, 98, 0.2);
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-simpan:hover {
    background: #c8814a;
    transform: translateY(-1px);
}

.btn-detail-buku {
    background: #f0e2d3;
    color: #4a3c31;
    padding: 12px 24px;
    border: none;
    border-radius: 12px;
    font-weight: bold;
    text-decoration: none;
    text-align: center;
    font-family: 'Quicksand', sans-serif;
    font-size: 1rem;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-detail-buku:hover {
    background: #e0d0bf;
    color: #4a3c31;
    text-decoration: none;
}
</style>

<div class="paw-container">
    <h1>Form Peminjaman</h1>

    <?php if(session()->getFlashdata('error')): ?>
        <div style="
            background:#ffe5e5;
            color:#c0392b;
            padding:15px;
            border-radius:12px;
            margin-bottom:20px;
            font-family: 'Quicksand', sans-serif;
            font-weight: 600;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="form-box">
        <!-- WIDGET PREVIEW BUKU YANG SEDANG DIPINJAM -->
        <?php 
            $coverField = !empty($buku['foto']) ? $buku['foto'] : (!empty($buku['cover']) ? $buku['cover'] : '');
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
        <div class="paw-loan-preview-card">
            <div class="paw-loan-preview-img-wrapper">
                <?php if ($coverPath == '/images/default_cover.svg'): ?>
                    <svg style="width: 100%; height: 100%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400">
                      <rect width="100%" height="100%" fill="#fff5ec"/>
                      <g transform="translate(150, 200) scale(1.3)">
                        <path d="M -20 10 C -20 -5, -10 -15, 0 -15 C 10 -15, 20 -5, 20 10 C 20 20, 10 25, 0 25 C -10 25, -20 20, -20 10 Z" fill="#E69C62" opacity="0.6"/>
                        <circle cx="-20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                        <circle cx="-7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                        <circle cx="7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                        <circle cx="20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                      </g>
                    </svg>
                <?php else: ?>
                    <img src="<?= $coverPath ?>" alt="<?= esc($buku['judul']); ?>" class="paw-loan-preview-img">
                <?php endif; ?>
            </div>
            <div class="paw-loan-preview-info">
                <span class="paw-loan-preview-code"><?= esc($buku['kode_buku'] ?? 'BK' . str_pad($buku['id'], 3, '0', STR_PAD_LEFT)) ?></span>
                <h5 class="paw-loan-preview-title"><?= esc($buku['judul']); ?></h5>
                <p class="paw-loan-preview-author">Penulis: <?= esc($buku['penulis']); ?></p>
            </div>
        </div>

        <!-- FORM TRANSAKSI -->
        <form action="/peminjaman/simpan" method="post" onsubmit="return confirmBorrow(event)">
            <input type="hidden" name="buku_id" value="<?= $buku['id'] ?>">

            <div class="form-group">
                <label>Judul Buku</label>
                <input type="text" value="<?= $buku['judul'] ?>" readonly>
            </div>

            <div class="form-group">
                <label>Nama Peminjam</label>
                <input type="text" name="nama" 
                       value="<?= session()->get('role') == 'anggota' ? esc(session()->get('nama')) : '' ?>" 
                       <?= session()->get('role') == 'anggota' ? 'readonly' : '' ?> 
                       required placeholder="Masukkan nama sesuai data anggota">
            </div>

            <div class="form-group">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" value="<?= date('Y-m-d') ?>" required>
            </div>

            <!-- DUA TOMBOL DI BAWAH PREVIEW & FORM BUKU -->
            <div class="btn-actions-container">
                <button type="submit" class="btn-simpan">
                    <i class="fas fa-paw"></i> Pinjam Buku
                </button>
                <a href="/katalog/detail/<?= $buku['id'] ?>" class="btn-detail-buku">
                    <i class="fas fa-info-circle"></i> Detail Buku
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function confirmBorrow(event) {
    const judulBuku = "<?= esc($buku['judul']) ?>";
    return confirm("🐾 Purr-fect! Apakah Kamu yakin ingin meminjam buku \"" + judulBuku + "\"?\n\nPastikan data sudah benar dan jangan lupa kembalikan tepat waktu ya!");
}
</script>

<?= $this->include('layout/footer'); ?>