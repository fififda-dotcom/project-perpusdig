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
    max-width: 800px;
    margin: 0 auto;
}

h1 {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 32px;
    color: #2E2118;
    margin-top: 0px !important; 
    margin-bottom: 25px !important;
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
    border-color: #E69C62; /* Oranye fokus PawLib */
    box-shadow: 0 0 0 4px rgba(230, 156, 98, 0.15);
}

.form-actions {
    margin-top: 30px;
    display: flex;
    gap: 15px;
    justify-content: flex-end;
}

.btn-submit {
    background: #E69C62; /* Oranye */
    color: white !important;
    padding: 14px 28px;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-family: 'Quicksand', sans-serif;
    font-size: 0.95rem;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(230, 156, 98, 0.25);
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
    <h1><i class="fas fa-user-plus" style="color: #E69C62;"></i> Tambah Anggota</h1>

    <div class="form-box">
        <form action="/anggota/simpan" method="post" enctype="multipart/form-data">
            
            <div class="form-grid">
                <!-- Input Nama -->
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" required placeholder="Masukkan nama lengkap">
                </div>

                <!-- Input No HP -->
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Nomor HP / WA <span class="text-danger">*</span></label>
                    <input type="text" name="nomor" required placeholder="Masukkan nomor handphone">
                </div>

                <!-- Input Email -->
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Alamat Gmail <span class="text-danger">*</span></label>
                    <input type="email" name="gmail" required placeholder="Masukkan alamat gmail">
                </div>

            <!-- Tombol Aksi -->
            <div class="form-actions">
                <a href="/anggota" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn-submit" onclick="return confirm('Daftarkan anggota baru?')">
                    <i class="fas fa-user-plus"></i> Tambah Anggota
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->include('layout/footer'); ?>