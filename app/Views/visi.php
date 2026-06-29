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

/* Hero Section Visi */
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

/* Card Visi Modern */
.paw-vision-card {
    background: white;
    border: 2px solid #ebd5c5;
    border-radius: 28px;
    padding: 45px 50px;
    box-shadow: 0 10px 30px rgba(74, 60, 49, 0.04);
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.paw-vision-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(230, 156, 98, 0.1);
}
.paw-vision-quote-icon {
    font-size: 40px;
    color: #FBE7D4;
    margin-bottom: 20px;
}
.paw-vision-text {
    font-size: 1.35rem;
    font-weight: 700;
    line-height: 1.7;
    color: #4a3c31;
    margin: 0 0 30px 0;
    position: relative;
    z-index: 2;
}
.paw-vision-card-footer {
    display: flex;
    justify-content: flex-end;
    border-top: 2px dashed #f2e7dd;
    padding-top: 25px;
}
.paw-tag {
    background: #FFF5EB;
    color: #E69C62;
    border: 1px solid #ebd5c5;
    padding: 8px 18px;
    border-radius: 30px;
    font-size: 0.9rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

@media (max-width: 576px) {
    .paw-hero-section {
        padding: 30px 20px;
    }
    .paw-hero-content h1 {
        font-size: 28px;
    }
    .paw-vision-card {
        padding: 30px 25px;
    }
    .paw-vision-text {
        font-size: 1.15rem;
    }
}
</style>

<div class="paw-container">
    <!-- Hero Section -->
    <div class="paw-hero-section">
        <div class="paw-hero-content">
            <div class="paw-hero-icon-wrapper">
                <i class="fas fa-bullseye"></i>
            </div>
            <h1>Visi PawLib</h1>
            <p>Tujuan utama dan komitmen masa depan perpustakaan digital kami</p>
        </div>
        <div class="paw-hero-paw-decor">🐾</div>
    </div>

    <!-- Vision Card -->
    <div class="paw-vision-card">
        <div class="paw-vision-quote-icon">
            <i class="fas fa-quote-left"></i>
        </div>
        <p class="paw-vision-text">
            "Menjadi perpustakaan digital yang modern, inovatif, dan mudah diakses oleh seluruh pengguna untuk mendukung peningkatan literasi melalui pemanfaatan teknologi informasi."
        </p>
        <div class="paw-vision-card-footer">
            <span class="paw-tag">
                <i class="fas fa-cat"></i> PawLib Perpustakaan Digital
            </span>
        </div>
    </div>
</div>

<?= $this->include('layout/footer'); ?>