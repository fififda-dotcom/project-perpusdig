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
    transition: all 0.2s ease;
}
.btn-action-back:hover {
    background: #a89a8e;
}
.paw-card {
    background: white;
    padding: 35px;
    border-radius: 24px;
    box-shadow: 0 8px 20px rgba(74, 60, 49, 0.05);
    border: 2px solid #f2e7dd;
    margin-bottom: 30px;
}
.star-btn.hovered, .star-btn.selected {
    color: #F1C40F !important;
}
.star-btn.selected {
    font-weight: 900 !important;
}
.paw-ulasan-row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -10px;
    margin-left: -10px;
}
.paw-ulasan-col {
    flex: 0 0 50%;
    max-width: 50%;
    padding: 0 10px;
    margin-bottom: 20px;
    box-sizing: border-box;
}
@media (max-width: 768px) {
    .paw-ulasan-col {
        flex: 0 0 100%;
        max-width: 100%;
    }
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
    <a href="/profile" class="btn-action-back">
        <i class="fas fa-chevron-left"></i> Kembali ke Profil Saya
    </a>

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

    <div class="paw-card">
        <h3 class="font-weight-bold mb-2"><i class="far fa-edit" style="color: #E69C62;"></i> 📝 Ulasan Saya</h3>
        <p class="text-muted mb-4">Kelola semua rating dan ulasan buku perpustakaan yang pernah Anda tulis di PawLib.</p>

        <!-- Form Pencarian -->
        <div style="margin-bottom: 25px;">
            <form action="/profile/ulasan" method="get" style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
                <input type="text"
                    name="keyword"
                    class="search-input"
                    placeholder="Cari judul, penulis, atau ulasan..."
                    value="<?= esc($keyword ?? '') ?>"
                    style="width: 280px;">
                <button type="submit" class="btn-search">
                    Cari
                </button>
                <?php if (!empty($keyword)): ?>
                    <a href="/profile/ulasan" class="btn-reset" style="margin-left:0;">
                        Reset
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <?php if (empty($ulasanSaya)): ?>
            <?php if (!empty($keyword)): ?>
                <div class="text-center py-5">
                    <span style="font-size: 3.5rem;">🔎</span>
                    <h4 class="font-weight-bold mt-3">Hasil Tidak Ditemukan</h4>
                    <p class="text-muted">Tidak ada ulasan atau rating yang cocok dengan kata kunci "<strong><?= esc($keyword) ?></strong>".</p>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <span style="font-size: 3.5rem;">💬</span>
                    <h4 class="font-weight-bold mt-3">Belum Menulis Ulasan</h4>
                    <p class="text-muted">Anda belum pernah memberikan ulasan atau rating untuk buku apa pun.</p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="paw-ulasan-row">
                <?php foreach ($ulasanSaya as $us): ?>
                    <?php 
                        $coverField = !empty($us['cover']) ? $us['cover'] : (!empty($us['foto']) ? $us['foto'] : '');
                        $coverPath = 'images/default_cover.svg';
                        if (!empty($coverField)) {
                            if (file_exists(FCPATH . 'uploads/' . $coverField)) {
                                $coverPath = 'uploads/' . $coverField;
                            } elseif (file_exists(FCPATH . 'uploads/cover/' . $coverField)) {
                                $coverPath = 'uploads/cover/' . $coverField;
                            } else {
                                $coverPath = 'uploads/' . $coverField;
                            }
                        }
                    ?>
                    <div class="paw-ulasan-col">
                        <div style="background: #fffdfb; border: 2px solid #f2e7dd; padding: 20px; border-radius: 20px; display: flex; gap: 15px; align-items: flex-start; height: 100%; box-sizing: border-box;">
                            <img src="<?= base_url($coverPath) ?>" style="width: 55px; height: 75px; object-fit: cover; border-radius: 8px; border: 1px solid #ebd5c5;" alt="Cover">
                            <div style="flex: 1; display: flex; flex-direction: column; height: 100%;">
                                <strong style="color: #4a3c31; font-size: 0.95rem; margin-bottom: 3px; display: block; max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= esc($us['judul']) ?></strong>
                                
                                <div style="color: #F1C40F; font-size: 0.8rem; margin-bottom: 6px;">
                                    <?= str_repeat('★', $us['rating'] ?? 5) . str_repeat('☆', 5 - ($us['rating'] ?? 5)) ?>
                                </div>
                                
                                <p style="margin: 0 0 12px 0; font-size: 0.85rem; color: #8c7b70; line-height: 1.4; text-align: justify; flex-grow: 1; font-style: <?= empty($us['ulasan']) ? 'italic' : 'normal' ?>;">
                                    <?= !empty($us['ulasan']) ? '"' . esc($us['ulasan']) . '"' : '(Tanpa ulasan teks)' ?>
                                </p>
                                
                                <div style="display: flex; gap: 10px; margin-top: auto; border-top: 1px dashed #f2e7dd; padding-top: 10px;">
                                    <button onclick="openEditModal(<?= $us['peminjaman_id'] ?>, '<?= esc($us['judul'], 'js') ?>', <?= $us['rating'] ?>, '<?= esc($us['ulasan'] ?? '', 'js') ?>')" style="
                                        background: transparent;
                                        border: none;
                                        color: #4a90e2;
                                        font-weight: 700;
                                        font-size: 0.8rem;
                                        cursor: pointer;
                                        padding: 0;
                                    "><i class="far fa-edit"></i> Edit</button>
                                    
                                    <?php if (!empty($us['ulasan_id'])): ?>
                                        <a href="/ulasan/hapus/<?= $us['ulasan_id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')" style="
                                            color: #e74c3c;
                                            font-weight: 700;
                                            font-size: 0.8rem;
                                            text-decoration: none;
                                            margin-left: auto;
                                        "><i class="far fa-trash-can"></i> Hapus</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- MODAL EDIT ULASAN -->
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
    <div style="
        background: white; 
        padding: 30px; 
        border-radius: 24px; 
        max-width: 500px; 
        width: 90%; 
        border: 2px solid #f2e7dd; 
        box-shadow: 0 10px 30px rgba(74, 60, 49, 0.15);
        animation: modalPop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.15);
    ">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-weight: bold; color: #4a3c31; margin: 0;"><i class="fas fa-paw" style="color: #E69C62;"></i> Ubah Ulasan</h3>
            <span onclick="closeEditModal()" style="font-size: 24px; font-weight: bold; cursor: pointer; color: #a89a8e;">&times;</span>
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
                <button type="button" onclick="closeEditModal()" class="btn-action-back" style="margin: 0; padding: 10px 18px; background: #e5dcd3; color: #4a3c31 !important;">Batal</button>
                <button type="submit" id="btn_submit_review" style="
                    background: #E69C62; 
                    color: white; 
                    border: none; 
                    padding: 10px 20px; 
                    border-radius: 12px; 
                    font-weight: bold; 
                    cursor: pointer;
                ">Perbarui Ulasan</button>
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

function openEditModal(peminjamanId, bookTitle, currentRating, currentUlasan) {
    document.getElementById('modal_peminjaman_id').value = peminjamanId;
    document.getElementById('modal_book_title').innerText = bookTitle;
    ratingInput.value = currentRating;
    ulasanText.value = currentUlasan;
    
    highlightStars(currentRating);
    validateUlasan();
    
    modal.style.display = 'flex';
}

function closeEditModal() {
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
        btnSubmit.disabled = false;
        btnSubmit.style.opacity = '1';
        btnSubmit.style.cursor = 'pointer';
    }
}
</script>

<?= $this->include('layout/footer'); ?>
