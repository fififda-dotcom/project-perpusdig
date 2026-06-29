<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<!-- Impor Google Font Quicksand agar selaras dengan tema kucing yang bulat dan hangat -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Impor Font Awesome untuk ikon-ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
/* CSS Utama bertema Cozy Cat & Minimalis */
.paw-container {
    font-family: 'Quicksand', sans-serif;
    color: #4a3c31;
    max-width: 800px;
    margin: 0 auto;
}

h1 {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 32px;
    color: #2E2118;
    margin-top: 3px !important; 
    margin-bottom: 5px !important;
}

.paw-subtitle {
    font-size: 1.05rem;
    color: #8c7b70;
    margin-bottom: 25px;
}

.form-box {
    background: white;
    padding: 35px;
    border-radius: 24px;
    box-shadow: 0 8px 25px rgba(74, 60, 49, 0.05);
    border: 2px solid #f2e7dd;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
}

.form-group label {
    font-size: 0.95rem;
    font-weight: 700;
    color: #4a3c31;
    margin-bottom: 8px;
}

.form-group label i {
    color: #E69C62;
    margin-right: 5px;
}

.form-group input {
    padding: 14px 18px;
    border: 2px solid #ebd5c5;
    border-radius: 12px;
    font-family: 'Quicksand', sans-serif;
    font-size: 0.95rem;
    font-weight: 600;
    color: #4a3c31;
    background-color: #ffffff;
    transition: all 0.3s ease;
    width: 100%;
    box-sizing: border-box;
}

.form-group input:focus {
    outline: none;
    border-color: #E69C62;
    box-shadow: 0 0 0 4px rgba(230, 156, 98, 0.15);
}

.avatar-preview-box {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-top: 10px;
    padding: 12px;
    border-radius: 12px;
    background-color: #FAF6F0;
    border: 1px solid #ebd5c5;
}

.avatar-preview-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 4px 8px rgba(230, 156, 98, 0.1);
}

.avatar-monogram {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background-color: #FBE7D4;
    color: #E69C62;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    border: 2px solid #fff;
    box-shadow: 0 4px 8px rgba(230, 156, 98, 0.1);
}

.form-actions {
    margin-top: 30px;
    display: flex;
    gap: 15px;
    justify-content: flex-end;
}

.btn-submit {
    background: #E69C62; /* Oranye khas PawLib */
    color: white !important;
    padding: 14px 28px;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-family: 'Quicksand', sans-serif;
    font-size: 0.95rem;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(230, 156, 98, 0.2);
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-submit:hover {
    background: #c8814a;
    transform: translateY(-1px);
}

.btn-cancel {
    background: #f0e2d3;
    color: #4a3c31 !important;
    padding: 14px 28px;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-family: 'Quicksand', sans-serif;
    font-size: 0.95rem;
    text-decoration: none !important;
    text-align: center;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-cancel:hover {
    background: #e0d0bf;
}
</style>

<div class="paw-container">
    <h1><i class="fas fa-user-edit" style="color: #E69C62;"></i> Edit Anggota</h1>
    <p class="paw-subtitle">Perbarui data profil anggota <b><?= esc($anggota['nama']) ?></b> (<?= esc($anggota['kode_anggota']) ?>)</p>

    <div class="form-box">
        <form action="/anggota/update/<?= $anggota['id'] ?>" method="post" enctype="multipart/form-data">
            
            <div class="form-grid">
                <!-- Input Nama -->
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" value="<?= esc($anggota['nama']) ?>" required placeholder="Masukkan nama lengkap">
                </div>

                <!-- Input No HP -->
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Nomor HP / WA <span class="text-danger">*</span></label>
                    <input type="text" name="nomor" value="<?= esc($anggota['nomor']) ?>" required placeholder="Masukkan nomor handphone">
                </div>

                <!-- Input Email -->
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Alamat Gmail <span class="text-danger">*</span></label>
                    <input type="email" name="gmail" value="<?= esc($anggota['gmail']) ?>" required placeholder="Masukkan alamat gmail">
                </div>

                <!-- Input Username -->
                <div class="form-group">
                    <label><i class="fas fa-user-tag"></i> Username</label>
                    <input type="text" name="username" value="<?= esc($anggota['username'] ?? '') ?>" placeholder="Masukkan username untuk login">
                </div>
                <!-- Input Password -->
                <div class="form-group">
                    <label><i class="fas fa-key"></i> Password</label>
                    <input type="password" name="password" value="<?= esc($anggota['password'] ?? '') ?>" placeholder="Masukkan password untuk login">
                </div>
                <!-- Input Foto Profil (Avatar) -->
                <div class="form-group">
                    <label><i class="fas fa-image"></i> Foto Profil (Avatar)</label>
                    <input type="file" name="foto" accept="image/*" style="padding: 10px;">
                    
                    <?php 
                        $fotoField = !empty($anggota['foto']) ? $anggota['foto'] : '';
                        $hasFoto = false;
                        if(!empty($fotoField) && file_exists(ROOTPATH . 'public/uploads/profile/' . $fotoField)) {
                            $hasFoto = true;
                            $fotoPath = base_url('uploads/profile/' . $fotoField);
                        }
                    ?>
                    
                    <div class="avatar-preview-box">
                        <?php if ($hasFoto): ?>
                            <img src="<?= $fotoPath ?>" class="avatar-preview-img" alt="Avatar">
                            <span style="font-size: 0.85rem; color: #8c7b70;">Foto saat ini: <?= esc($fotoField) ?></span>
                        <?php else: ?>
                            <div class="avatar-monogram">
                                <?= strtoupper(substr($anggota['nama'], 0, 1)) ?>
                            </div>
                            <span style="font-size: 0.85rem; color: #8c7b70;">Belum mengunggah foto profil</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="form-actions">
                <a href="/anggota" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn-submit" onclick="return confirm('Simpan perubahan data anggota?')">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->include('layout/footer'); ?>