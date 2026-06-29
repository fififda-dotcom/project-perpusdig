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
}
.paw-alert-success {
    background-color: #e2f9e1;
    color: #1e6b26;
    border: 2px solid #c2ecc0;
}

/* Settings Form Card */
.settings-card {
    background: white;
    border: 2px solid #f2e7dd;
    border-radius: 24px;
    padding: 30px;
    box-shadow: 0 8px 18px rgba(74, 60, 49, 0.03);
    max-width: 600px;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    font-weight: 700;
    color: #2E2118;
    margin-bottom: 8px;
    font-size: 1rem;
}

.form-help {
    font-size: 0.85rem;
    color: #8c7b70;
    margin-top: 4px;
}

.checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 10px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    cursor: pointer;
    font-size: 0.95rem;
}

.checkbox-input {
    width: 18px;
    height: 18px;
    accent-color: #E69C62;
    cursor: pointer;
}

.text-input {
    width: 100%;
    padding: 12px 18px;
    border-radius: 15px;
    border: 2px solid #ebd5c5;
    font-family: 'Quicksand', sans-serif;
    font-weight: 600;
    color: #4a3c31;
    background-color: #ffffff;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.text-input:focus {
    outline: none;
    border-color: #E69C62;
    box-shadow: 0 0 0 4px rgba(230, 156, 98, 0.15);
}

.btn-save {
    background: #E69C62;
    color: white;
    padding: 12px 28px;
    border: none;
    border-radius: 15px;
    cursor: pointer;
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    transition: all 0.2s ease;
    box-shadow: 0 4px 10px rgba(230, 156, 98, 0.2);
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-save:hover {
    background: #c8814a;
    transform: translateY(-1px);
}
</style>

<div class="paw-container">
    <!-- Title Card -->
    <div class="paw-title-card">
        <h1><i class="fas fa-cog"></i> Pengaturan Filter Berita RSS</h1>
    </div>

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="paw-alert paw-alert-success">
            <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="settings-card">
        <form action="/admin/simpan_pengaturan_berita" method="post">
            <?= csrf_field() ?>
            
            <!-- Group 1: Aktifkan Portal Berita -->
            <div class="form-group">
                <label class="form-label">Portal Berita Aktif</label>
                <span class="form-help">Pilih portal berita online mana saja yang ingin ditampilkan di dashboard anggota.</span>
                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="hidden" name="cnn_enabled" value="0">
                        <input type="checkbox" name="cnn_enabled" value="1" class="checkbox-input" <?= $settings['cnn_enabled'] ? 'checked' : '' ?>>
                        <span>🌐 CNN Indonesia (Nasional)</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="hidden" name="cnbc_enabled" value="0">
                        <input type="checkbox" name="cnbc_enabled" value="1" class="checkbox-input" <?= $settings['cnbc_enabled'] ? 'checked' : '' ?>>
                        <span>🌐 CNBC Indonesia (News)</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="hidden" name="detik_enabled" value="0">
                        <input type="checkbox" name="detik_enabled" value="1" class="checkbox-input" <?= (isset($settings['detik_enabled']) ? $settings['detik_enabled'] : true) ? 'checked' : '' ?>>
                        <span>🌐 Detikcom (News)</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="hidden" name="antara_enabled" value="0">
                        <input type="checkbox" name="antara_enabled" value="1" class="checkbox-input" <?= (isset($settings['antara_enabled']) ? $settings['antara_enabled'] : true) ? 'checked' : '' ?>>
                        <span>🌐 Antara News (Top News)</span>
                    </label>
                </div>
            </div>

            <!-- Group 2: Filter Kata Kunci -->
            <div class="form-group">
                <label class="form-label" for="news_keyword">Saring Berdasarkan Kata Kunci</label>
                <input type="text" id="news_keyword" name="news_keyword" class="text-input" placeholder="Contoh: presiden, korupsi, IKN..." value="<?= esc($settings['news_keyword']) ?>">
                <span class="form-help">Hanya berita dengan judul atau konten yang mengandung kata kunci di atas yang akan ditampilkan. Kosongkan untuk menampilkan semua berita.</span>
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Simpan Pengaturan
            </button>
        </form>
    </div>
</div>

<?= $this->include('layout/footer'); ?>
