<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Book Reader: <?= esc($buku['judul']) ?> - PawLib 🐾</title>
    <!-- Impor Google Font Quicksand -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            /* Warna Dasar Cozy Cat */
            --primary: #E69C62;
            --primary-hover: #c8814a;
            --bg-body: #FAF5F0;
            --text-color: #4a3c31;
            --border-color: #ebd5c5;
        }

        /* Styles untuk Tema Membaca */
        body.theme-white {
            background-color: #ffffff;
            color: #2E2118;
            --bg-nav: #FAF5F0;
            --bg-sidebar: #fcfbf9;
            --border-reader: #e3dec9;
        }
        body.theme-sepia {
            background-color: #f4ecd8;
            color: #5b4636;
            --bg-nav: #e4dcc4;
            --bg-sidebar: #eae0c8;
            --border-reader: #dfd4b7;
        }
        body.theme-cream {
            background-color: #faf6eb;
            color: #4f3a2b;
            --bg-nav: #ebdcb9;
            --bg-sidebar: #f3e6ca;
            --border-reader: #e5d5b1;
        }
        body.theme-dark {
            background-color: #1a1a1a;
            color: #e0e0e0;
            --bg-nav: #2d2d2d;
            --bg-sidebar: #262626;
            --border-reader: #444444;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Header / Navigasi Pembaca */
        .reader-header {
            height: 65px;
            background-color: var(--bg-nav);
            border-bottom: 2px solid var(--border-reader, var(--border-color));
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 100;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(230, 156, 98, 0.1);
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            background-color: var(--primary);
            color: white;
            transform: translateX(-2px);
        }

        .book-info {
            max-width: 250px;
        }

        .book-title {
            font-size: 0.95rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .book-author {
            font-size: 0.75rem;
            opacity: 0.8;
            font-weight: 500;
        }

        .header-center {
            flex-grow: 1;
            max-width: 400px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            margin: 0 15px;
        }

        .chapter-indicator {
            font-size: 0.9rem;
            font-weight: 700;
        }

        .progress-bar-container {
            width: 100%;
            height: 6px;
            background-color: rgba(0, 0, 0, 0.08);
            border-radius: 3px;
            overflow: hidden;
            position: relative;
        }
        body.theme-dark .progress-bar-container {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .progress-bar-fill {
            height: 100%;
            width: 0%;
            background-color: var(--primary);
            border-radius: 3px;
            transition: width 0.3s ease;
        }

        .progress-text {
            font-size: 0.75rem;
            font-weight: 700;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Layout Utama Pembaca */
        .reader-main {
            flex-grow: 1;
            display: flex;
            position: relative;
            overflow: hidden;
        }

        /* Sidebar Daftar Bab & Pencarian */
        .reader-sidebar {
            width: 320px;
            background-color: var(--bg-sidebar);
            border-right: 2px solid var(--border-reader, var(--border-color));
            display: flex;
            flex-direction: column;
            position: absolute;
            top: 0;
            left: -320px;
            bottom: 0;
            z-index: 90;
            transition: left 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.05);
        }

        .reader-sidebar.open {
            left: 0;
        }

        .sidebar-tabs {
            display: flex;
            border-bottom: 2px solid var(--border-reader, var(--border-color));
        }

        .tab-btn {
            flex: 1;
            padding: 15px;
            background: none;
            border: none;
            color: inherit;
            font-family: inherit;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            text-align: center;
            opacity: 0.7;
            transition: all 0.2s ease;
        }

        .tab-btn.active {
            opacity: 1;
            border-bottom: 3px solid var(--primary);
            color: var(--primary);
        }

        .tab-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 15px;
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Daftar Bab di Sidebar */
        .chapter-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .chapter-item {
            padding: 12px 15px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chapter-item:hover {
            background-color: rgba(230, 156, 98, 0.1);
            color: var(--primary);
        }

        .chapter-item.active {
            background-color: var(--primary);
            color: white !important;
        }

        .chapter-item i {
            font-size: 0.8rem;
            opacity: 0.6;
        }

        /* Fitur Pencarian di Sidebar */
        .search-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            height: 100%;
        }

        .search-box {
            display: flex;
            gap: 8px;
        }

        .search-input {
            flex-grow: 1;
            padding: 10px 14px;
            border-radius: 10px;
            border: 2px solid var(--border-reader, var(--border-color));
            background: transparent;
            color: inherit;
            font-family: inherit;
            font-weight: 600;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .btn-search-go {
            padding: 0 15px;
            border-radius: 10px;
            background-color: var(--primary);
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 700;
        }

        .btn-search-go:hover {
            background-color: var(--primary-hover);
        }

        .search-results {
            flex-grow: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 10px;
        }

        .result-item {
            padding: 12px;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.02);
            border: 1px solid var(--border-reader, var(--border-color));
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }
        body.theme-dark .result-item {
            background-color: rgba(255, 255, 255, 0.02);
        }

        .result-item:hover {
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        .result-chapter {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 4px;
            display: block;
        }

        .result-snippet {
            line-height: 1.4;
            opacity: 0.9;
        }

        .result-snippet mark {
            background-color: #ffd166;
            color: #2E2118;
            padding: 0 2px;
            font-weight: 700;
            border-radius: 3px;
        }

        /* Container Membaca Teks */
        .reader-body {
            flex-grow: 1;
            overflow-y: auto;
            scroll-behavior: smooth;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }

        .reader-text-container {
            max-width: 720px;
            width: 100%;
            line-height: 1.75;
            position: relative;
            padding-bottom: 100px;
        }

        /* Tampilan Bab Kosong / Selamat Datang */
        .welcome-screen {
            text-align: center;
            padding: 80px 20px;
        }

        .welcome-icon {
            font-size: 4rem;
            color: var(--primary);
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .welcome-title {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome-text {
            opacity: 0.8;
            font-size: 1rem;
            max-width: 450px;
            margin: 0 auto 30px auto;
        }

        /* Kontrol Ukuran Font Dinamis */
        .size-sangat-kecil { font-size: 0.85rem; }
        .size-kecil { font-size: 0.95rem; }
        .size-sedang { font-size: 1.1rem; }
        .size-besar { font-size: 1.3rem; }
        .size-sangat-besar { font-size: 1.5rem; }

        /* Toolbar Kontrol Mengambang (Settings & Actions) */
        .control-btn {
            background: none;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: inherit;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            position: relative;
        }

        .control-btn:hover {
            background-color: rgba(230, 156, 98, 0.15);
            color: var(--primary);
        }

        /* Dropdown Settings Menu */
        .settings-dropdown {
            position: absolute;
            top: 60px;
            right: 20px;
            background-color: var(--bg-sidebar);
            border: 2px solid var(--border-reader, var(--border-color));
            border-radius: 16px;
            padding: 20px;
            width: 280px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 110;
            animation: fadeIn 0.2s ease;
        }

        .settings-dropdown.show {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .settings-group {
            margin-bottom: 15px;
        }

        .settings-group:last-child {
            margin-bottom: 0;
        }

        .settings-label {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            opacity: 0.7;
        }

        /* Pilihan Tema Warna */
        .theme-selector {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        .theme-opt {
            padding: 8px 5px;
            border-radius: 8px;
            border: 2px solid transparent;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 700;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease;
        }

        .theme-opt.opt-white { background-color: #ffffff; color: #2E2118; border-color: #ebd5c5; }
        .theme-opt.opt-sepia { background-color: #f4ecd8; color: #5b4636; }
        .theme-opt.opt-cream { background-color: #faf6eb; color: #4f3a2b; }
        .theme-opt.opt-dark { background-color: #1a1a1a; color: #e0e0e0; }

        .theme-opt.active {
            border-color: var(--primary) !important;
            transform: scale(1.05);
        }

        /* Pilihan Ukuran Font */
        .font-selector {
            display: flex;
            border: 2px solid var(--border-reader, var(--border-color));
            border-radius: 10px;
            overflow: hidden;
        }

        .font-opt {
            flex: 1;
            padding: 8px;
            border: none;
            background: transparent;
            color: inherit;
            font-weight: 700;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .font-opt:not(:last-child) {
            border-right: 1px solid var(--border-reader, var(--border-color));
        }

        .font-opt.active {
            background-color: var(--primary);
            color: white;
        }

        /* Overlay gelap saat sidebar aktif */
        .sidebar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 80;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        /* Modal Dialog Box Lanjutkan Membaca */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 200;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-box {
            background-color: var(--bg-sidebar);
            border: 2px solid var(--border-reader, var(--border-color));
            border-radius: 24px;
            padding: 30px;
            width: 90%;
            max-width: 440px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            transform: scale(0.9);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .modal-overlay.show .modal-box {
            transform: scale(1);
        }

        .modal-icon {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .modal-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: inherit;
        }

        .modal-text {
            font-size: 0.95rem;
            opacity: 0.85;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .modal-buttons {
            display: flex;
            gap: 12px;
        }

        .btn-modal {
            flex: 1;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            font-family: inherit;
            transition: all 0.2s ease;
        }

        .btn-modal-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-modal-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-modal-secondary {
            background-color: rgba(0, 0, 0, 0.05);
            color: inherit;
        }
        body.theme-dark .btn-modal-secondary {
            background-color: rgba(255, 255, 255, 0.08);
        }

        .btn-modal-secondary:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }
        body.theme-dark .btn-modal-secondary:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        /* Bookmark visual style */
        .control-btn.bookmarked {
            color: #E74C3C;
        }
        
        .control-btn.bookmarked:hover {
            background-color: rgba(231, 76, 60, 0.1);
        }

        /* Tombol Pindah Halaman/Bab Cepat (Kaki Reader) */
        .reader-nav-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 50px;
            padding-top: 25px;
            border-top: 2px dashed var(--border-reader, var(--border-color));
        }

        .btn-nav-chapter {
            padding: 12px 20px;
            border-radius: 12px;
            border: 2px solid var(--border-reader, var(--border-color));
            background: transparent;
            color: inherit;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-nav-chapter:hover:not(:disabled) {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-1px);
        }

        .btn-nav-chapter:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
    </style>
</head>
<body class="theme-sepia">

    <!-- Header Pembaca -->
    <header class="reader-header">
        <div class="header-left">
            <a href="/katalog/detail/<?= $buku['id'] ?>" class="btn-back" title="Kembali ke Detail Buku">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="book-info">
                <div class="book-title"><?= esc($buku['judul']) ?></div>
                <div class="book-author">Oleh: <?= esc($buku['penulis']) ?></div>
            </div>
        </div>

        <div class="header-center">
            <div class="chapter-indicator" id="current-chapter-title">Memuat Buku...</div>
            <div class="progress-bar-container">
                <div class="progress-bar-fill" id="progress-fill"></div>
            </div>
            <div class="progress-text" id="progress-text">Progress Halaman: - / - (0%)</div>
        </div>

        <div class="header-right">
            <!-- Tombol Sidebar Halaman -->
            <button class="control-btn" id="btn-toggle-sidebar" title="Daftar Halaman & Cari Kata">
                <i class="fas fa-bars"></i>
            </button>
            <!-- Tombol Bookmark -->
            <button class="control-btn" id="btn-toggle-bookmark" title="Bookmark Halaman Ini">
                <i class="far fa-bookmark"></i>
            </button>
            <!-- Tombol Pengaturan Aa -->
            <button class="control-btn" id="btn-toggle-settings" title="Pengaturan Tampilan">
                <i class="fas fa-font"></i>
            </button>
        </div>
    </header>

    <!-- Dropdown Pengaturan -->
    <div class="settings-dropdown" id="settings-menu">
        <!-- Tema Pembaca -->
        <div class="settings-group">
            <div class="settings-label">Tema Membaca</div>
            <div class="theme-selector">
                <div class="theme-opt opt-white" data-theme="white">
                    <span>☀️</span><span>Putih</span>
                </div>
                <div class="theme-opt opt-sepia active" data-theme="sepia">
                    <span>📜</span><span>Sepia</span>
                </div>
                <div class="theme-opt opt-cream" data-theme="cream">
                    <span>🟫</span><span>Cream</span>
                </div>
                <div class="theme-opt opt-dark" data-theme="dark">
                    <span>🌙</span><span>Gelap</span>
                </div>
            </div>
        </div>

        <!-- Ukuran Font -->
        <div class="settings-group">
            <div class="settings-label">Ukuran Huruf</div>
            <div class="font-selector">
                <button class="font-opt" data-size="sangat-kecil">XS</button>
                <button class="font-opt" data-size="kecil">S</button>
                <button class="font-opt active" data-size="sedang">M</button>
                <button class="font-opt" data-size="besar">L</button>
                <button class="font-opt" data-size="sangat-besar">XL</button>
            </div>
        </div>
    </div>

    <!-- Layout Utama Pembaca -->
    <div class="reader-main">
        <!-- Overlay Sidebar -->
        <div class="sidebar-overlay" id="sidebar-mask"></div>

        <!-- Sidebar Laci -->
        <aside class="reader-sidebar" id="sidebar">
            <div class="sidebar-tabs">
                <button class="tab-btn active" data-tab="tab-toc"><i class="fas fa-list mr-1"></i> Halaman</button>
                <button class="tab-btn" data-tab="tab-search"><i class="fas fa-search mr-1"></i> Cari Kata</button>
            </div>

            <!-- Tab Daftar Halaman -->
            <div class="tab-content active" id="tab-toc">
                <ul class="chapter-list">
                    <?php if (empty($daftarBab)): ?>
                        <li class="welcome-text" style="text-align: center; padding: 20px; font-weight: 700;">Belum ada halaman tersedia untuk ebook ini.</li>
                    <?php else: ?>
                        <?php foreach($daftarBab as $bab): ?>
                            <li class="chapter-item" data-id="<?= $bab['id'] ?>" data-no="<?= $bab['nomor_bab'] ?>" data-title="<?= esc($bab['judul_bab']) ?>">
                                <span><?= esc($bab['judul_bab']) ?></span>
                                <i class="fas fa-chevron-right"></i>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Tab Pencarian Kata -->
            <div class="tab-content" id="tab-search">
                <div class="search-container">
                    <div class="search-box">
                        <input type="text" class="search-input" id="inp-search-word" placeholder="Cari kata/kalimat...">
                        <button class="btn-search-go" id="btn-search-trigger">Cari</button>
                    </div>
                    <div class="search-results" id="search-output">
                        <p style="text-align: center; opacity: 0.6; padding-top: 20px; font-size: 0.85rem;">Masukkan kata kunci pencarian di atas.</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Area Pembaca Teks -->
        <main class="reader-body" id="reader-body-container">
            <div class="reader-text-container" id="reader-text-content">
                <!-- Tampilan Selamat Datang Awal -->
                <div class="welcome-screen">
                    <div class="welcome-icon">📖</div>
                    <h2 class="welcome-title">Selamat Membaca!</h2>
                    <p class="welcome-text">Silakan pilih halaman di daftar isi samping atau lanjutkan membaca halaman terakhir untuk menyelami konten ebook.</p>
                    <button class="btn-modal btn-modal-primary" id="btn-quick-start" style="display:inline-block; width:auto; padding: 12px 30px;">
                        Buka Halaman Pertama
                    </button>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Dialog Dialog Box Lanjutkan Membaca -->
    <div class="modal-overlay" id="resume-modal">
        <div class="modal-box">
            <div class="modal-icon">🐾</div>
            <h3 class="modal-title">Lanjutkan Membaca?</h3>
            <p class="modal-text" id="resume-modal-text">Kami mendeteksi kamu terakhir membaca sampai Halaman 1. Mau dilanjutkan dari posisi terakhir?</p>
            <div class="modal-buttons">
                <button class="btn-modal btn-modal-secondary" id="btn-resume-no">Mulai dari Awal</button>
                <button class="btn-modal btn-modal-primary" id="btn-resume-yes">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>

    <script>
        // Data Buku & Halaman Terikat PHP
        const bukuId = <?= $buku['id'] ?>;
        const pagesData = {};
        
        <?php foreach($daftarBab as $bab): ?>
        pagesData[<?= $bab['nomor_bab'] ?>] = {
            id: <?= $bab['id'] ?>,
            judul: <?= json_encode($bab['judul_bab']) ?>,
            isi: <?= json_encode($bab['isi_bab']) ?>
        };
        <?php endforeach; ?>

        // Client-side paginated global pages
        let globalPages = [];
        let totalGlobalPages = 0;

        // Data Progress Awal
        let savedProgress = null;
        <?php if ($progress): ?>
        savedProgress = {
            nomorHalaman: <?= (int)$progress['nomor_bab'] ?>,
            scrollPosition: <?= (float)$progress['scroll_position'] ?>,
            progressPersen: <?= (int)$progress['progress_persen'] ?>
        };
        <?php endif; ?>

        // State Pembaca
        let currentGlobalPage = null;
        let currentSize = localStorage.getItem('paw_font_size') || 'sedang';
        let currentTheme = localStorage.getItem('paw_theme') || 'sepia';
        let bookmarkedPages = JSON.parse(localStorage.getItem(`paw_bookmarks_pages_${bukuId}`) || '[]');

        // Element DOM
        const bodyEl = document.body;
        const textContainer = document.getElementById('reader-text-content');
        const bodyContainer = document.getElementById('reader-body-container');
        const chapterTitleHeader = document.getElementById('current-chapter-title');
        const progressFill = document.getElementById('progress-fill');
        const progressText = document.getElementById('progress-text');
        
        // Modal Lanjutkan Membaca DOM
        const resumeModal = document.getElementById('resume-modal');
        const resumeModalText = document.getElementById('resume-modal-text');

        // Client-side pagination logic
        function paginateChapters() {
            globalPages = [];
            
            const chapterNumbers = Object.keys(pagesData).map(Number).sort((a, b) => a - b);
            
            chapterNumbers.forEach(chapNum => {
                const chap = pagesData[chapNum];
                const rawContent = chap.isi || '';
                
                // Split by `<hr class="page-break" ...>`
                const parts = rawContent.split(/<hr[^>]*class=["']page-break["'][^>]*>/gi);
                
                parts.forEach((partContent, index) => {
                    const subPageNum = index + 1;
                    let content = partContent.trim();
                    
                    // Create clean page title
                    const pageTitle = subPageNum === 1 ? chap.judul : `${chap.judul} (Halaman ${subPageNum})`;
                    
                    globalPages.push({
                        chapterId: chap.id,
                        chapterNum: chapNum,
                        chapterTitle: chap.judul,
                        subPageNum: subPageNum,
                        title: pageTitle,
                        content: content
                    });
                });
            });
            totalGlobalPages = globalPages.length;
        }

        // Pemuatan Pilihan Setelan (Tampilan & Font)
        function applySettings() {
            // Apply Theme
            bodyEl.className = '';
            bodyEl.classList.add(`theme-${currentTheme}`);
            document.querySelectorAll('.theme-opt').forEach(opt => {
                opt.classList.toggle('active', opt.dataset.theme === currentTheme);
            });

            // Apply Size
            textContainer.className = 'reader-text-container';
            textContainer.classList.add(`size-${currentSize}`);
            document.querySelectorAll('.font-opt').forEach(opt => {
                opt.classList.toggle('active', opt.dataset.size === currentSize);
            });
        }

        // Tampilkan Isi Halaman yang dipilih
        function loadGlobalPage(globalPageNum, scrollOffset = 0) {
            if (globalPageNum < 1 || globalPageNum > totalGlobalPages) return;

            currentGlobalPage = globalPageNum;
            const pageData = globalPages[globalPageNum - 1];

            // Render isi halaman
            let navHtml = `
                <div class="reader-nav-footer">
                    <button class="btn-nav-chapter" id="btn-prev-page" ${globalPageNum <= 1 ? 'disabled' : ''}>
                        <i class="fas fa-chevron-left"></i> Halaman Sebelumnya
                    </button>
                    <span style="font-weight:700; font-size:0.9rem;">Halaman ${globalPageNum} / ${totalGlobalPages}</span>
                    <button class="btn-nav-chapter" id="btn-next-page" ${globalPageNum >= totalGlobalPages ? 'disabled' : ''}>
                        Halaman Selanjutnya <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            `;

            textContainer.innerHTML = `
                <h1 style="font-size: 2.2rem; margin-bottom: 25px; border-bottom: 2px dashed var(--border-reader, var(--border-color)); padding-bottom: 15px;">${escHtml(pageData.chapterTitle)}</h1>
                <div class="chapter-html-content">${pageData.content}</div>
                ${navHtml}
            `;

            chapterTitleHeader.innerText = pageData.chapterTitle;

            // Highlight active chapter in sidebar TOC list
            document.querySelectorAll('.chapter-item').forEach(item => {
                item.classList.toggle('active', parseInt(item.dataset.no) === pageData.chapterNum);
            });

            // Apply settings class to new content
            applySettings();

            // Set bookmark button state
            const bookmarkIcon = document.querySelector('#btn-toggle-bookmark i');
            const isBookmarked = bookmarkedPages.includes(globalPageNum);
            document.getElementById('btn-toggle-bookmark').classList.toggle('bookmarked', isBookmarked);
            if (isBookmarked) {
                bookmarkIcon.className = 'fas fa-bookmark';
            } else {
                bookmarkIcon.className = 'far fa-bookmark';
            }

            // Scroll to the instructed position
            bodyContainer.scrollTop = 0;
            if (scrollOffset > 0) {
                setTimeout(() => {
                    const scrollMax = bodyContainer.scrollHeight - bodyContainer.clientHeight;
                    bodyContainer.scrollTop = scrollMax * scrollOffset;
                    updateProgressBar();
                }, 100);
            } else {
                updateProgressBar();
            }

            // Simpan progress ke server
            saveProgressToServer();
        }

        // Hitung baris Progress
        function updateProgressBar() {
            if (!currentGlobalPage || totalGlobalPages === 0) return;

            const scrollTop = bodyContainer.scrollTop;
            const scrollHeight = bodyContainer.scrollHeight - bodyContainer.clientHeight;
            let percent = 0;

            if (scrollHeight > 0) {
                const scrollRatio = scrollTop / scrollHeight;
                const baseProgress = ((currentGlobalPage - 1) / totalGlobalPages) * 100;
                const scrollProgress = (1 / totalGlobalPages) * scrollRatio * 100;
                percent = Math.min(100, Math.round(baseProgress + scrollProgress));
            } else {
                percent = Math.round((currentGlobalPage / totalGlobalPages) * 100);
            }

            progressFill.style.width = `${percent}%`;
            progressText.innerText = `Progress Halaman: ${currentGlobalPage} / ${totalGlobalPages} (${percent}%)`;
        }

        // Save progress ke database melalui AJAX
        function saveProgressToServer() {
            if (!currentGlobalPage || totalGlobalPages === 0) return;

            const pageData = globalPages[currentGlobalPage - 1];
            const scrollTop = bodyContainer.scrollTop;
            const scrollHeight = bodyContainer.scrollHeight - bodyContainer.clientHeight;
            const scrollRatio = scrollHeight > 0 ? (scrollTop / scrollHeight) : 0;
            
            // Hitung persentase progress membaca total
            const baseProgress = ((currentGlobalPage - 1) / totalGlobalPages) * 100;
            const scrollProgress = (1 / totalGlobalPages) * scrollRatio * 100;
            const percent = Math.min(100, Math.round(baseProgress + scrollProgress));

            // nomor_bab = pageData.chapterNum
            // scroll_position = (subPageNum - 1) + scrollRatio
            const subPageIndex = pageData.subPageNum - 1;
            const dbScrollPos = subPageIndex + scrollRatio;

            const formData = new FormData();
            formData.append('buku_id', bukuId);
            formData.append('nomor_bab', pageData.chapterNum);
            formData.append('scroll_position', dbScrollPos);
            formData.append('progress_persen', percent);

            fetch('/ebook/update-progress', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                // Berhasil disimpan ke server
            })
            .catch(err => console.error('Gagal menyimpan progress:', err));
        }

        // Event listener scroll untuk progress bar
        let scrollTimeout;
        bodyContainer.addEventListener('scroll', () => {
            updateProgressBar();
            
            // Debounce saving progress to server
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(saveProgressToServer, 1000);
        });

        // Tab Switching di Sidebar
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

                btn.classList.add('active');
                document.getElementById(btn.dataset.tab).classList.add('active');
            });
        });

        // Toggle Sidebar
        const btnToggleSidebar = document.getElementById('btn-toggle-sidebar');
        const sidebar = document.getElementById('sidebar');
        const sidebarMask = document.getElementById('sidebar-mask');

        function toggleSidebar(show) {
            sidebar.classList.toggle('open', show);
            sidebarMask.classList.toggle('show', show);
        }

        btnToggleSidebar.addEventListener('click', () => {
            const isOpened = sidebar.classList.contains('open');
            toggleSidebar(!isOpened);
        });

        sidebarMask.addEventListener('click', () => {
            toggleSidebar(false);
        });

        // Toggle settings dropdown
        const btnToggleSettings = document.getElementById('btn-toggle-settings');
        const settingsMenu = document.getElementById('settings-menu');

        btnToggleSettings.addEventListener('click', (e) => {
            e.stopPropagation();
            settingsMenu.classList.toggle('show');
        });

        document.addEventListener('click', (e) => {
            if (!settingsMenu.contains(e.target) && e.target !== btnToggleSettings) {
                settingsMenu.classList.remove('show');
            }
        });

        // Settings Selector (font size & theme)
        document.querySelectorAll('.theme-opt').forEach(opt => {
            opt.addEventListener('click', () => {
                currentTheme = opt.dataset.theme;
                localStorage.setItem('paw_theme', currentTheme);
                applySettings();
            });
        });

        document.querySelectorAll('.font-opt').forEach(opt => {
            opt.addEventListener('click', () => {
                currentSize = opt.dataset.size;
                localStorage.setItem('paw_font_size', currentSize);
                applySettings();
            });
        });

        // Bookmark Trigger
        const btnToggleBookmark = document.getElementById('btn-toggle-bookmark');
        btnToggleBookmark.addEventListener('click', () => {
            if (!currentGlobalPage) return;

            const idx = bookmarkedPages.indexOf(currentGlobalPage);
            const bookmarkIcon = btnToggleBookmark.querySelector('i');

            if (idx > -1) {
                bookmarkedPages.splice(idx, 1);
                btnToggleBookmark.classList.remove('bookmarked');
                bookmarkIcon.className = 'far fa-bookmark';
            } else {
                bookmarkedPages.push(currentGlobalPage);
                btnToggleBookmark.classList.add('bookmarked');
                bookmarkIcon.className = 'fas fa-bookmark';
            }
            localStorage.setItem(`paw_bookmarks_pages_${bukuId}`, JSON.stringify(bookmarkedPages));
        });

        // Pilih halaman langsung dari sidebar TOC
        document.querySelectorAll('.chapter-item').forEach(item => {
            item.addEventListener('click', () => {
                const chapNo = parseInt(item.dataset.no);
                // Find first global page index for this chapter
                const targetPageIndex = globalPages.findIndex(p => p.chapterNum === chapNo);
                if (targetPageIndex !== -1) {
                    loadGlobalPage(targetPageIndex + 1);
                }
                toggleSidebar(false);
            });
        });

        // Quick start button
        document.getElementById('btn-quick-start').addEventListener('click', () => {
            loadGlobalPage(1);
        });

        // Delegasi Klik Tombol Sebelumnya / Selanjutnya (karena dinonaktifkan / dirender ulang)
        document.addEventListener('click', (e) => {
            if (e.target.closest('#btn-prev-page')) {
                if (currentGlobalPage > 1) {
                    loadGlobalPage(currentGlobalPage - 1);
                }
            } else if (e.target.closest('#btn-next-page')) {
                if (currentGlobalPage < totalGlobalPages) {
                    loadGlobalPage(currentGlobalPage + 1);
                }
            }
        });

        // Fitur Pencarian Kata / AJAX inside Book
        const inpSearchWord = document.getElementById('inp-search-word');
        const btnSearchTrigger = document.getElementById('btn-search-trigger');
        const searchOutput = document.getElementById('search-output');

        function executeWordSearch() {
            const kw = inpSearchWord.value.trim();
            if (!kw) return;

            searchOutput.innerHTML = `<p style="text-align: center; padding-top: 20px;"><i class="fas fa-spinner fa-spin mr-1"></i> Mencari kata...</p>`;

            fetch(`/ebook/cari-kata?buku_id=${bukuId}&keyword=${encodeURIComponent(kw)}`)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    searchOutput.innerHTML = `<p style="text-align: center; opacity: 0.6; padding-top: 20px; font-size: 0.85rem;">Kata kunci "${escHtml(kw)}" tidak ditemukan dalam buku.</p>`;
                    return;
                }

                searchOutput.innerHTML = '';
                data.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'result-item';
                    div.innerHTML = `
                        <span class="result-chapter">${escHtml(item.judul_bab)}</span>
                        <div class="result-snippet">${item.snippet}</div>
                    `;
                    div.addEventListener('click', () => {
                        // Find target global page that contains the keyword in the target chapter
                        const kwLower = kw.toLowerCase();
                        let targetPageIndex = globalPages.findIndex(p => p.chapterNum === item.nomor_bab && p.content.toLowerCase().includes(kwLower));
                        if (targetPageIndex === -1) {
                            targetPageIndex = globalPages.findIndex(p => p.chapterNum === item.nomor_bab);
                        }

                        if (targetPageIndex !== -1) {
                            loadGlobalPage(targetPageIndex + 1);
                        }
                        toggleSidebar(false);

                        // Highlight kata kunci yang terpilih di halaman membaca utama
                        setTimeout(() => {
                            const readerContentEl = document.querySelector('.chapter-html-content');
                            if (readerContentEl) {
                                // Pencarian regex case-insensitive untuk menghighlight semua kecocokan di reader
                                const escapedKw = kw.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                                const regex = new RegExp(`(${escapedKw})`, 'gi');
                                
                                // Hanya highlight text node agar tidak merusak tag HTML
                                highlightTextNodes(readerContentEl, regex);

                                // Scroll ke highlight pertama
                                const firstMark = readerContentEl.querySelector('mark.search-highlight');
                                if (firstMark) {
                                    firstMark.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                }
                            }
                        }, 250);
                    });
                    searchOutput.appendChild(div);
                });
            })
            .catch(err => {
                console.error(err);
                searchOutput.innerHTML = `<p style="text-align: center; color: red; padding-top: 20px; font-size: 0.85rem;">Gagal melakukan pencarian.</p>`;
            });
        }

        btnSearchTrigger.addEventListener('click', executeWordSearch);
        inpSearchWord.addEventListener('keyup', (e) => {
            if (e.key === 'Enter') executeWordSearch();
        });

        // Helper untuk menghighlight text node saja
        function highlightTextNodes(element, regex) {
            const walk = document.createTreeWalker(element, NodeFilter.SHOW_TEXT, null, false);
            const textNodes = [];
            let node;
            while (node = walk.nextNode()) {
                textNodes.push(node);
            }

            textNodes.forEach(node => {
                const parent = node.parentNode;
                if (parent.tagName === 'SCRIPT' || parent.tagName === 'STYLE' || parent.tagName === 'MARK') return;

                const text = node.nodeValue;
                if (regex.test(text)) {
                    const span = document.createElement('span');
                    span.innerHTML = text.replace(regex, '<mark class="search-highlight" style="background-color: #ffe66d; font-weight:700; color:#2E2118; border-radius:3px; padding:0 3px;">$1</mark>');
                    parent.replaceChild(span, node);
                }
            });
        }

        // Helper Escaping
        function escHtml(str) {
            return str.replace(/&/g, '&amp;')
                      .replace(/</g, '&lt;')
                      .replace(/>/g, '&gt;')
                      .replace(/"/g, '&quot;')
                      .replace(/'/g, '&#039;');
        }

        // Inisialisasi Alur Lanjutkan Membaca (Resume Dialog)
        window.addEventListener('DOMContentLoaded', () => {
            paginateChapters();
            applySettings();

            if (savedProgress && savedProgress.nomorHalaman > 0) {
                // Decode subPageIndex and scrollRatio from savedProgress.scrollPosition
                let dbScrollPos = parseFloat(savedProgress.scrollPosition) || 0;
                let subPageIndex = Math.floor(dbScrollPos);
                let scrollRatio = dbScrollPos - subPageIndex;
                if (scrollRatio < 0) scrollRatio = 0;
                
                // Find global page index
                let targetGlobalPageIndex = globalPages.findIndex(p => p.chapterNum === savedProgress.nomorHalaman && p.subPageNum === (subPageIndex + 1));
                
                // Fallback to first page of the chapter
                if (targetGlobalPageIndex === -1) {
                    targetGlobalPageIndex = globalPages.findIndex(p => p.chapterNum === savedProgress.nomorHalaman);
                }

                if (targetGlobalPageIndex !== -1) {
                    const pageData = globalPages[targetGlobalPageIndex];
                    const chapJudul = pageData.title;
                    resumeModalText.innerHTML = `Kami mendeteksi kamu terakhir membaca sampai <strong>${escHtml(chapJudul)}</strong> (${savedProgress.progressPersen}% progress). Mau dilanjutkan dari posisi terakhir?`;
                    resumeModal.classList.add('show');

                    document.getElementById('btn-resume-yes').addEventListener('click', () => {
                        resumeModal.classList.remove('show');
                        loadGlobalPage(targetGlobalPageIndex + 1, scrollRatio);
                    });

                    document.getElementById('btn-resume-no').addEventListener('click', () => {
                        resumeModal.classList.remove('show');
                        loadGlobalPage(1); // Start from beginning
                    });
                } else {
                    if (globalPages.length > 0) {
                        loadGlobalPage(1);
                    }
                }
            } else {
                if (globalPages.length > 0) {
                    loadGlobalPage(1);
                }
            }
        });
    </script>
</body>
</html>
