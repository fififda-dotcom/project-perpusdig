<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer: <?= esc($buku['judul']) ?> - PawLib 🐾</title>
    <!-- Impor Google Font Quicksand -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --primary: #E69C62;
            --primary-hover: #c8814a;
            --bg-body: #FAF5F0;
            --text-color: #4a3c31;
            --border-color: #ebd5c5;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Quicksand', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-color);
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Header / Navigasi Pembaca */
        .reader-header {
            height: 65px;
            background-color: #FAF5F0;
            border-bottom: 2px solid #ebd5c5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 100;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
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
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            background-color: var(--primary);
            color: white;
            transform: translateX(-2px);
        }

        .book-info {
            max-width: 400px;
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

        /* Container PDF Frame */
        .viewer-container {
            flex-grow: 1;
            width: 100%;
            height: calc(100vh - 65px);
            border: none;
            background-color: #525659; /* Default browser PDF viewer background */
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>

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
        
        <div style="font-weight: 700; color: var(--primary); font-size: 1.05rem; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-file-pdf"></i> PDF Viewer
        </div>
    </header>

    <!-- Area Penampil PDF -->
    <div class="viewer-container">
        <iframe src="<?= base_url('uploads/ebooks/' . esc($buku['file_pdf'])) ?>#toolbar=1" type="application/pdf"></iframe>
    </div>

</body>
</html>
