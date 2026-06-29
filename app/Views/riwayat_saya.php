<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<!-- Impor Google Font Quicksand agar selaras dengan tema kucing yang bulat dan hangat -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Impor Font Awesome untuk ikon-ikon cantik -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
/* CSS Utama bertema Cozy Cat & Riwayat Page */
.paw-container {
    font-family: 'Quicksand', sans-serif;
    color: #4a3c31;
    padding-bottom: 60px;
}

h1 {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 32px;
    color: #4a3c31;
    margin-top: 0px !important; 
    margin-bottom: 20px !important;
}

/* Card Riwayat Utama */
.paw-riwayat-card {
    background: white;
    padding: 35px;
    border-radius: 24px;
    box-shadow: 0 8px 20px rgba(74, 60, 49, 0.05);
    border: 2px solid #f2e7dd;
    margin-bottom: 30px;
}

/* Style Riwayat Peminjaman (Tabel Modern) */
.paw-riwayat-table-wrapper {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    border: 2px solid #f2e7dd;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
}

.paw-riwayat-table {
    width: 100%;
    border-collapse: collapse;
}

.paw-riwayat-table th {
    background-color: #FBE7D4;
    color: #4a3c31;
    font-weight: 700;
    padding: 15px;
    text-align: left;
    font-size: 0.95rem;
}

.paw-riwayat-table td {
    padding: 15px;
    border-bottom: 1px solid #f2e7dd;
    color: #4a3c31;
    font-weight: 600;
    font-size: 0.9rem;
}

.paw-riwayat-table tr:last-child td {
    border-bottom: none;
}

.foto-buku-riwayat {
    width: 50px;
    height: 70px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.badge-riwayat-status {
    padding: 5px 12px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 700;
    display: inline-block;
    text-transform: uppercase;
}

.status-dipinjam {
    background-color: #fdf8e2;
    color: #d35400;
    border: 1px solid rgba(211, 84, 0, 0.15);
}

.status-kembali {
    background-color: #eafaf1;
    color: #2ecc71;
    border: 1px solid rgba(46, 204, 113, 0.15);
}

/* Button Custom Styles */
.btn-action-back {
    padding: 10px 20px;
    background: #c0b3a7;
    color: white !important;
    text-decoration: none;
    border-radius: 12px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    font-family: 'Quicksand', sans-serif;
    transition: all 0.2s ease;
}

.btn-action-back:hover {
    background: #a89a8e;
    text-decoration: none;
}

/* Kustomisasi Input Pencarian */
.search-input {
    padding: 12px 18px;
    width: 320px;
    border-radius: 15px;
    border: 2px solid #ebd5c5;
    font-family: 'Quicksand', sans-serif;
    font-weight: 600;
    color: #4a3c31;
    background-color: #ffffff;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.search-input:focus {
    outline: none;
    border-color: #E69C62;
    box-shadow: 0 0 0 4px rgba(230, 156, 98, 0.15);
}

.btn-search {
    padding: 12px 22px;
    background: #E69C62;
    color: white;
    border: none;
    border-radius: 15px;
    cursor: pointer;
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    transition: all 0.2s ease;
    box-shadow: 0 4px 10px rgba(230, 156, 98, 0.2);
}

.btn-search:hover {
    background: #c8814a;
    transform: translateY(-1px);
}

.btn-reset {
    padding: 12px 22px;
    background: #c0b3a7;
    color: white !important;
    text-decoration: none;
    border-radius: 15px;
    margin-left: 10px;
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    display: inline-block;
    transition: all 0.2s ease;
}

.btn-reset:hover {
    background: #a89a8e;
    color: white !important;
    text-decoration: none;
}
</style>

<div class="paw-container">
    <!-- Tombol Kembali ke Profil -->
    <a href="/profile" class="btn-action-back">
        <i class="fas fa-chevron-left"></i> Kembali ke Profil Saya
    </a>

    <?php if (session()->getFlashdata('success')): ?>
        <div style="background: #e2f9e1; color: #1e6b26; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: bold; border: 1px solid rgba(30,107,38,0.15); font-family: 'Quicksand', sans-serif;">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: bold; border: 1px solid rgba(198,40,40,0.15); font-family: 'Quicksand', sans-serif;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Card Utama -->
    <div class="paw-riwayat-card">
        <h3 class="font-weight-bold mb-2"><i class="fas fa-history" style="color: #E69C62;"></i> Riwayat Peminjaman Buku Saya</h3>
        <p class="text-muted mb-4">Daftar lengkap rekam jejak buku yang sedang dan telah Anda pinjam di PawLib digital library.</p>

        <!-- Form Pencarian -->
        <div style="margin-bottom: 25px;">
            <form action="/profile/riwayat" method="get" style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
                <input type="text"
                    name="keyword"
                    class="search-input"
                    placeholder="Cari judul, penulis, atau status..."
                    value="<?= esc($keyword ?? '') ?>"
                    style="width: 280px;">
                <button type="submit" class="btn-search">
                    Cari
                </button>
                <?php if (!empty($keyword)): ?>
                    <a href="/profile/riwayat" class="btn-reset" style="margin-left:0;">
                        Reset
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <?php if (empty($riwayat)): ?>
            <?php if (!empty($keyword)): ?>
                <div class="text-center py-5">
                    <span style="font-size: 3.5rem;">🔎</span>
                    <h4 class="font-weight-bold mt-3" style="color: #4a3c31;">Hasil Tidak Ditemukan</h4>
                    <p class="text-muted mb-0">Tidak ada riwayat peminjaman yang cocok dengan kata kunci "<strong><?= esc($keyword) ?></strong>".</p>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <span style="font-size: 3.5rem;">📖</span>
                    <h4 class="font-weight-bold mt-3" style="color: #4a3c31;">Belum Ada Riwayat</h4>
                    <p class="text-muted mb-0">Anda belum pernah melakukan transaksi peminjaman buku.</p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="paw-riwayat-table-wrapper">
                <table class="paw-riwayat-table">
                    <thead>
                        <tr>
                            <th width="80">Buku</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Kembali</th>
                            <th>Status</th>
                            <th>Denda</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayat as $r): ?>
                            <?php 
                                $coverPath = 'images/default_cover.svg';
                                if (!empty($r['foto'])) {
                                    if (file_exists(FCPATH . 'uploads/' . $r['foto'])) {
                                        $coverPath = 'uploads/' . $r['foto'];
                                    }
                                }
                                
                                $status = strtolower($r['status'] ?? '');
                                $isDiajukan = ($status == 'diajukan');
                                $isDipinjam = ($status == 'dipinjam' || $status == 'belum kembali' || empty($r['tanggal_kembali']));
                                
                                // Kalkulasi nominal denda secara aman
                                $dendaNominal = 0;
                                if (isset($r['denda'])) {
                                    $dendaNominal = (int)$r['denda'];
                                } elseif (isset($r['nominal_denda'])) {
                                    $dendaNominal = (int)$r['nominal_denda'];
                                }
                            ?>
                            <tr>
                                <td>
                                    <img src="<?= base_url($coverPath) ?>" alt="Cover" class="foto-buku-riwayat">
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #4a3c31;"><?= esc($r['judul'] ?? 'Buku Tanpa Judul') ?></div>
                                    <small class="text-muted">ID Peminjaman: #<?= $r['id'] ?></small>
                                </td>
                                <td>
                                    <?= isset($r['tanggal_pinjam']) ? date('d M Y', strtotime($r['tanggal_pinjam'])) : '-' ?>
                                </td>
                                <td>
                                    <?= isset($r['tanggal_kembali']) && !empty($r['tanggal_kembali']) ? date('d M Y', strtotime($r['tanggal_kembali'])) : '-' ?>
                                </td>
                                <td>
                                    <?php if ($isDiajukan): ?>
                                        <span class="badge-riwayat-status" style="background-color: #e3f2fd; color: #1e88e5; border: 1px solid rgba(30, 136, 229, 0.15);">
                                            <i class="fas fa-clock mr-1"></i> Diajukan
                                        </span>
                                    <?php elseif ($isDipinjam): ?>
                                        <span class="badge-riwayat-status status-dipinjam">
                                            <i class="fas fa-hourglass-half mr-1"></i> Dipinjam
                                        </span>
                                    <?php elseif ($status == 'selesai' || $status == 'dikembalikan'): ?>
                                        <span class="badge-riwayat-status status-kembali">
                                            <i class="fas fa-check-circle mr-1"></i> Selesai
                                        </span>
                                    <?php else: ?>
                                        <span class="badge-riwayat-status status-kembali">
                                            <i class="fas fa-check-circle mr-1"></i> Kembali
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- Menampilkan nominal denda -->
                                    <?php if ($dendaNominal > 0): ?>
                                        <span style="color: #c0392b; font-weight: 700;">
                                            Rp <?= number_format($dendaNominal, 0, ',', '.') ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="color: #bdc3c7; font-weight: 500;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($isDiajukan): ?>
                                        <span class="badge-riwayat-status" style="background-color: #f5f5f5; color: #757575; border: 1px solid rgba(117,117,117,0.15); text-transform: none; display: flex; align-items: center; gap: 4px; font-weight: 600;">
                                            <i class="fas fa-spinner fa-spin"></i> Menunggu Verifikasi
                                        </span>
                                    <?php elseif ($isDipinjam): ?>
                                        <a href="/peminjaman/ajukan/<?= $r['id'] ?>" class="btn-riwayat-action" style="
                                            background: #E69C62;
                                            color: white !important;
                                            padding: 8px 14px;
                                            border-radius: 10px;
                                            text-decoration: none;
                                            font-size: 0.8rem;
                                            font-weight: bold;
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 6px;
                                            transition: all 0.2s ease;
                                            box-shadow: 0 2px 6px rgba(230, 156, 98, 0.2);
                                        " onclick="return confirm('Apakah Anda yakin ingin mengajukan pengembalian untuk buku ini?\n\nSetelah mengajukan, mohon segera serahkan buku fisik ke petugas perpustakaan.')">
                                            <i class="fas fa-undo"></i> Ajukan Kembali
                                        </a>
                                    <?php else: ?>
                                        <?php if (isset($r['rating']) && $r['rating'] > 0): ?>
                                            <div style="margin-bottom: 5px;">
                                                <div style="color: #F1C40F; font-size: 0.95rem;">
                                                    <?= str_repeat('★', $r['rating']) . str_repeat('☆', 5 - $r['rating']) ?>
                                                </div>
                                            </div>
                                            <button onclick="openRatingModal(<?= $r['id'] ?>, '<?= esc($r['judul'], 'js') ?>', <?= $r['rating'] ?>, '<?= esc($r['ulasan'] ?? '', 'js') ?>')" style="
                                                background: #fdf8e2;
                                                border: 1px solid #ebd5c5;
                                                color: #d35400;
                                                padding: 6px 12px;
                                                border-radius: 8px;
                                                font-size: 0.75rem;
                                                font-weight: bold;
                                                cursor: pointer;
                                                display: inline-flex;
                                                align-items: center;
                                                gap: 4px;
                                                transition: all 0.2s ease;
                                            ">
                                                <i class="far fa-edit"></i> Edit Ulasan
                                            </button>
                                        <?php else: ?>
                                            <button onclick="openRatingModal(<?= $r['id'] ?>, '<?= esc($r['judul'], 'js') ?>', 0, '')" style="
                                                background: #eafaf1;
                                                border: 1px solid rgba(46, 204, 113, 0.2);
                                                color: #2ecc71;
                                                padding: 8px 14px;
                                                border-radius: 10px;
                                                font-size: 0.8rem;
                                                font-weight: bold;
                                                cursor: pointer;
                                                display: inline-flex;
                                                align-items: center;
                                                gap: 6px;
                                                transition: all 0.2s ease;
                                                box-shadow: 0 2px 6px rgba(46, 204, 113, 0.1);
                                            ">
                                                <i class="fas fa-star" style="color: #F1C40F;"></i> Tulis Ulasan
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- MODAL RATING & ULASAN -->
<div id="paw_rating_modal" style="
    display: none; 
    position: fixed; 
    z-index: 9999; 
    left: 0; 
    top: 0; 
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(46, 33, 24, 0.4); 
    backdrop-filter: blur(4px);
    align-items: center; 
    justify-content: center;
">
    <style>
    .star-btn.hovered, .star-btn.selected {
        color: #F1C40F !important;
    }
    .star-btn.selected {
        font-weight: 900 !important;
    }
    @keyframes modalPop {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    </style>
    <div style="
        background: white; 
        padding: 30px; 
        border-radius: 24px; 
        max-width: 500px; 
        width: 90%; 
        border: 2px solid #f2e7dd; 
        box-shadow: 0 10px 30px rgba(74, 60, 49, 0.15);
        animation: modalPop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.15);
        font-family: 'Quicksand', sans-serif;
    ">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-weight: bold; color: #4a3c31; margin: 0; font-family: 'Quicksand', sans-serif;" id="modal_header_title"><i class="fas fa-paw" style="color: #E69C62;"></i> Berikan Rating & Ulasan</h3>
            <span onclick="closeRatingModal()" style="font-size: 24px; font-weight: bold; cursor: pointer; color: #a89a8e;">&times;</span>
        </div>
        
        <form action="/ulasan/simpan" method="POST" id="form_rating_submit">
            <input type="hidden" name="peminjaman_id" id="modal_peminjaman_id">
            
            <p style="font-size: 0.95rem; font-weight: 700; color: #4a3c31; margin-bottom: 5px;">Bagaimana pengalaman membaca buku:</p>
            <p style="font-size: 1.05rem; font-weight: 700; color: #E69C62; margin-top: 0; margin-bottom: 20px;" id="modal_book_title"></p>
            
            <!-- Bintang Interaktif -->
            <div style="display: flex; gap: 8px; justify-content: center; font-size: 32px; color: #bdc3c7; margin-bottom: 25px;" id="star_container">
                <i class="far fa-star star-btn" data-value="1" style="cursor: pointer; transition: transform 0.2s ease;"></i>
                <i class="far fa-star star-btn" data-value="2" style="cursor: pointer; transition: transform 0.2s ease;"></i>
                <i class="far fa-star star-btn" data-value="3" style="cursor: pointer; transition: transform 0.2s ease;"></i>
                <i class="far fa-star star-btn" data-value="4" style="cursor: pointer; transition: transform 0.2s ease;"></i>
                <i class="far fa-star star-btn" data-value="5" style="cursor: pointer; transition: transform 0.2s ease;"></i>
            </div>
            <input type="hidden" name="rating" id="modal_rating_val" value="0">
            
            <div id="ulasan_section" style="border-top: 2px dashed #f2e7dd; padding-top: 20px;">
                <label style="font-weight: 700; font-size: 0.9rem; color: #4a3c31; display: block; margin-bottom: 8px;"><i class="far fa-comment-dots"></i> 💬 Bagikan Pendapatmu</label>
                <textarea name="ulasan" id="modal_ulasan_text" rows="4" style="
                    width: 100%; 
                    padding: 12px; 
                    border-radius: 12px; 
                    border: 2px solid #ebd5c5; 
                    font-family: 'Quicksand', sans-serif;
                    font-size: 0.9rem; 
                    box-sizing: border-box;
                    resize: vertical;
                " placeholder="Tulis ulasan Anda di sini... (Minimal 20 karakter, maksimal 1000)"></textarea>
                <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: #8c7b70; margin-top: 5px;">
                    <span id="char_warning" style="color: #e74c3c; display: none;">Minimal 20 karakter!</span>
                    <span style="margin-left: auto;" id="char_counter">0 / 1000</span>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
                <button type="button" onclick="closeRatingModal()" class="btn-action-back" style="margin: 0; padding: 10px 18px; background: #e5dcd3; color: #4a3c31 !important;">Batal</button>
                <button type="submit" id="btn_submit_review" style="
                    background: #E69C62; 
                    color: white; 
                    border: none; 
                    padding: 10px 20px; 
                    border-radius: 12px; 
                    font-weight: bold; 
                    cursor: pointer;
                ">Simpan Ulasan</button>
            </div>
        </form>
    </div>
</div>

<script>
const modal = document.getElementById('paw_rating_modal');
const ratingInput = document.getElementById('modal_rating_val');
const ulasanText = document.getElementById('modal_ulasan_text');
const btnSubmit = document.getElementById('btn_submit_review');
const charWarning = document.getElementById('char_warning');
const charCounter = document.getElementById('char_counter');
const stars = document.querySelectorAll('.star-btn');
const headerTitle = document.getElementById('modal_header_title');

function openRatingModal(peminjamanId, bookTitle, currentRating, currentUlasan) {
    document.getElementById('modal_peminjaman_id').value = peminjamanId;
    document.getElementById('modal_book_title').innerText = bookTitle;
    ratingInput.value = currentRating;
    ulasanText.value = currentUlasan;
    
    if (currentRating > 0) {
        headerTitle.innerHTML = '<i class="fas fa-paw" style="color: #E69C62;"></i> Ubah Ulasan';
        btnSubmit.innerText = 'Perbarui Ulasan';
    } else {
        headerTitle.innerHTML = '<i class="fas fa-paw" style="color: #E69C62;"></i> Berikan Rating & Ulasan';
        btnSubmit.innerText = 'Simpan Ulasan';
    }
    
    highlightStars(currentRating);
    validateUlasan();
    
    modal.style.display = 'flex';
}

function closeRatingModal() {
    modal.style.display = 'none';
}

function highlightStars(val) {
    stars.forEach(s => {
        const starVal = parseInt(s.getAttribute('data-value'));
        if (starVal <= val) {
            s.className = 'fas fa-star star-btn selected';
        } else {
            s.className = 'far fa-star star-btn';
        }
    });
}

stars.forEach(star => {
    star.addEventListener('mouseover', function() {
        const hoverVal = parseInt(this.getAttribute('data-value'));
        stars.forEach(s => {
            const starVal = parseInt(s.getAttribute('data-value'));
            if (starVal <= hoverVal) {
                s.classList.add('hovered');
            } else {
                s.classList.remove('hovered');
            }
        });
    });
    
    star.addEventListener('mouseout', function() {
        stars.forEach(s => s.classList.remove('hovered'));
    });
    
    star.addEventListener('click', function() {
        const clickVal = parseInt(this.getAttribute('data-value'));
        ratingInput.value = clickVal;
        highlightStars(clickVal);
        validateUlasan();
    });
});

ulasanText.addEventListener('input', function() {
    validateUlasan();
});

function validateUlasan() {
    const text = ulasanText.value.trim();
    const len = text.length;
    charCounter.innerText = `${len} / 1000`;
    
    if (len > 0) {
        if (len < 20 || len > 1000) {
            charWarning.style.display = 'inline';
            btnSubmit.disabled = true;
            btnSubmit.style.opacity = '0.5';
            btnSubmit.style.cursor = 'not-allowed';
        } else {
            charWarning.style.display = 'none';
            btnSubmit.disabled = false;
            btnSubmit.style.opacity = '1';
            btnSubmit.style.cursor = 'pointer';
        }
    } else {
        charWarning.style.display = 'none';
        if (parseInt(ratingInput.value) > 0) {
            btnSubmit.disabled = false;
            btnSubmit.style.opacity = '1';
            btnSubmit.style.cursor = 'pointer';
        } else {
            btnSubmit.disabled = true;
            btnSubmit.style.opacity = '0.5';
            btnSubmit.style.cursor = 'not-allowed';
        }
    }
}
</script>

<?= $this->include('layout/footer'); ?>