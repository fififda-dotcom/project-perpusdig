<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>
<!-- Impor Google Font Quicksand agar selaras dengan tema kucing yang bulat dan hangat -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Impor Font Awesome untuk ikon-ikon cantik -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
/* CSS Utama bertema Cozy Cat & Visi Misi Page */
.paw-container {
    font-family: 'Quicksand', sans-serif;
    color: #4a3c31;
    max-width: 900px;
    margin: 0 auto;
    padding-bottom: 40px;
}
/* Hero Section Misi */
.paw-hero-section {
    background: linear-gradient(135deg, #FFF9F3 0%, #FBE7D4 100%);
    padding: 45px 40px;
    border-radius: 28px;
    border: 2px solid #ebd5c5;
    box-shadow: 0 8px 24px rgba(230, 156, 98, 0.08);
    position: relative;
    overflow: hidden;
    margin-bottom: 35px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.paw-hero-content {
    position: relative;
    z-index: 2;
}
.paw-hero-content h1 {
    font-size: 34px;
    font-weight: 700;
    color: #2E2118;
    margin: 15px 0 5px 0;
}
.paw-hero-content p {
    font-size: 1.1rem;
    color: #756456;
    margin: 0;
    font-weight: 600;
}
.paw-hero-icon-wrapper {
    background: #E69C62;
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    box-shadow: 0 6px 15px rgba(230, 156, 98, 0.3);
}
.paw-hero-paw-decor {
    position: absolute;
    right: 40px;
    bottom: -20px;
    font-size: 140px;
    opacity: 0.05;
    transform: rotate(-15deg);
    pointer-events: none;
}
/* List Misi Card */
.paw-mission-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.paw-mission-item {
    background: white;
    border: 2px solid #f2e7dd;
    border-radius: 24px;
    padding: 24px 30px;
    display: flex;
    align-items: center;
    gap: 24px;
    box-shadow: 0 6px 15px rgba(74, 60, 49, 0.03);
    position: relative;
    transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
}
.paw-mission-item:hover {
    transform: translateX(6px);
    border-color: #ebd5c5;
    box-shadow: 0 10px 25px rgba(230, 156, 98, 0.08);
}
.paw-mission-number {
    font-size: 1.6rem;
    font-weight: 800;
    color: #ebd5c5;
    font-family: 'Quicksand', sans-serif;
    min-width: 35px;
}
.paw-mission-icon-box {
    width: 54px;
    height: 54px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
}
.paw-mission-desc {
    font-size: 1.05rem;
    font-weight: 700;
    color: #4a3c31;
    line-height: 1.5;
}
@media (max-width: 576px) {
    .paw-hero-section {
        padding: 30px 20px;
    }
    .paw-hero-content h1 {
        font-size: 28px;
    }
    .paw-mission-item {
        padding: 20px;
        gap: 15px;
    }
    .paw-mission-number {
        display: none; /* Sembunyikan angka di layar kecil agar hemat ruang */
    }
    .paw-mission-desc {
        font-size: 0.95rem;
    }
}
</style>
<div class="paw-container">
    <!-- Hero Section -->
    <div class="paw-hero-section">
        <div class="paw-hero-content">
            <div class="paw-hero-icon-wrapper">
                <i class="fas fa-rocket"></i>
            </div>
            <h1> Misi PawLib</h1>
            <p>Langkah nyata kami dalam mewujudkan kualitas layanan perpustakaan terbaik</p>
        </div>
        <div class="paw-hero-paw-decor">🐾</div>
    </div>
    <!-- Mission List -->
    <div class="paw-mission-list">
        <!-- Misi 1 -->
        <div class="paw-mission-item">
            <div class="paw-mission-number">01</div>
            <div class="paw-mission-icon-box" style="background-color: #fff2e8; color: #E69C62;">
                <i class="fas fa-book"></i>
            </div>
            <div class="paw-mission-desc">
                Menyediakan layanan pencarian dan peminjaman buku yang cepat dan mudah.
            </div>
        </div>
        <!-- Misi 2 -->
        <div class="paw-mission-item">
            <div class="paw-mission-number">02</div>
            <div class="paw-mission-icon-box" style="background-color: #eaf2fc; color: #4A90E2;">
                <i class="fas fa-folder-open"></i>
            </div>
            <div class="paw-mission-desc">
                Mengelola koleksi perpustakaan berdasarkan klasifikasi Dewey Decimal Classification (DDC).
            </div>
        </div>
        <!-- Misi 3 -->
        <div class="paw-mission-item">
            <div class="paw-mission-number">03</div>
            <div class="paw-mission-icon-box" style="background-color: #eafcf0; color: #2ECC71;">
                <i class="fas fa-laptop-code"></i>
            </div>
            <div class="paw-mission-desc">
                Memanfaatkan teknologi informasi untuk meningkatkan kualitas layanan perpustakaan.
            </div>
        </div>
        <!-- Misi 4 -->
        <div class="paw-mission-item">
            <div class="paw-mission-number">04</div>
            <div class="paw-mission-icon-box" style="background-color: #f3effc; color: #8E44AD;">
                <i class="fas fa-seedling"></i>
            </div>
            <div class="paw-mission-desc">
                Meningkatkan minat baca dan budaya literasi melalui perpustakaan digital yang nyaman digunakan.
            </div>
        </div>
        <!-- Misi 5 -->
        <div class="paw-mission-item">
            <div class="paw-mission-number">05</div>
            <div class="paw-mission-icon-box" style="background-color: #fff0f0; color: #E74C3C;">
                <i class="fas fa-hands-helping"></i>
            </div>
            <div class="paw-mission-desc">
                Memberikan pelayanan yang efektif, efisien, dan berorientasi pada kebutuhan pengguna.
            </div>
        </div>
    </div>
</div>
<?= $this->include('layout/footer'); ?>