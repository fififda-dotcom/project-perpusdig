<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<!-- Impor Google Font Quicksand agar selaras dengan tema kucing yang bulat dan hangat -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Impor Font Awesome untuk ikon-ikon cantik -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<!-- Impor Quill WYSIWYG Editor stylesheet & script -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<!-- Impor JSZip untuk dekompresi EPUB -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<style>
.paw-container {
    font-family: 'Quicksand', sans-serif;
    color: #4a3c31;
    max-width: 900px;
    margin: 0 auto;
}

h1 {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 32px;
    color: #2E2118;
    margin-top: 10px !important; 
    margin-bottom: 5px !important;
}

.paw-subtitle {
    font-size: 1.05rem;
    color: #8c7b70;
    margin-bottom: 30px;
}

.form-box {
    background: white;
    padding: 40px;
    border-radius: 24px;
    box-shadow: 0 8px 25px rgba(74, 60, 49, 0.05);
    border: 2px solid #f2e7dd;
}

.form-section-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #E69C62;
    margin-top: 25px;
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 2px dashed #f2e7dd;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-section-title:first-of-type {
    margin-top: 0;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 10px;
}

.form-group label {
    font-size: 0.9rem;
    font-weight: 700;
    color: #4a3c31;
    margin-bottom: 8px;
}

.form-group input, .form-group select {
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

.form-group input:focus, .form-group select:focus {
    outline: none;
    border-color: #E69C62;
    box-shadow: 0 0 0 4px rgba(230, 156, 98, 0.15);
}

.form-actions {
    margin-top: 35px;
    display: flex;
    gap: 15px;
}

.btn-submit {
    background: #E69C62;
    color: white;
    padding: 15px 30px;
    border: none;
    border-radius: 15px;
    font-weight: 700;
    font-family: 'Quicksand', sans-serif;
    font-size: 1rem;
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
    color: white;
    text-decoration: none;
}

.btn-cancel {
    background: #f0e2d3;
    color: #4a3c31;
    padding: 15px 30px;
    border: none;
    border-radius: 15px;
    font-weight: 700;
    font-family: 'Quicksand', sans-serif;
    font-size: 1rem;
    text-decoration: none;
    text-align: center;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-cancel:hover {
    background: #e0d0bf;
    color: #4a3c31;
    text-decoration: none;
}

/* Chapter Card Editor */
.chapter-editor-card {
    background: #FFFBF7;
    border: 2px solid #ebd5c5;
    border-radius: 18px;
    padding: 20px;
    position: relative;
    box-shadow: 0 4px 10px rgba(0,0,0,0.01);
}
.chapter-editor-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}
.chapter-editor-header h4 {
    margin: 0;
    font-weight: 700;
    color: #4a3c31;
    display: flex;
    align-items: center;
    gap: 8px;
}
/* Quill Custom Style */
.ql-toolbar.ql-snow {
    border: none !important;
    border-bottom: 2px solid #ebd5c5 !important;
    background: #FFFDF9;
    font-family: 'Quicksand', sans-serif;
}
.ql-container.ql-snow {
    border: none !important;
    font-family: 'Quicksand', sans-serif;
    font-size: 1rem;
    color: #4a3c31;
}
.ql-editor {
    min-height: 350px;
    background: white;
}
/* Style for custom hr.page-break inside Quill editor */
.ql-editor hr.page-break {
    border: none !important;
    border-top: 2px dashed #E69C62 !important;
    height: 12px !important;
    margin: 24px 0 !important;
    position: relative !important;
    opacity: 1 !important;
    overflow: visible !important;
}
.ql-editor hr.page-break::after {
    content: "--- Pembatas Halaman ---" !important;
    position: absolute !important;
    top: -12px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    background: #ffffff !important;
    padding: 0 10px !important;
    font-size: 0.8rem !important;
    color: #E69C62 !important;
    font-weight: bold !important;
}
/* Chapter List Item in Sidebar */
.editor-chapter-card {
    background: white;
    border: 2px solid #ebd5c5;
    border-radius: 12px;
    padding: 12px 15px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}
.editor-chapter-card:hover {
    border-color: #E69C62;
    background-color: #fffcf9;
}
.editor-chapter-card.active {
    border-color: #E69C62;
    background-color: #fff8f2;
}
.editor-chapter-card .chap-info {
    flex-grow: 1;
    min-width: 0;
}
.editor-chapter-card .chap-index {
    font-size: 0.75rem;
    font-weight: 700;
    color: #8c7b70;
    margin-bottom: 2px;
    text-transform: uppercase;
}
.editor-chapter-card .chap-title {
    font-size: 0.9rem;
    font-weight: 700;
    color: #4a3c31;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.editor-chapter-card .btn-delete {
    color: #EF4444;
    cursor: pointer;
    padding: 4px;
    opacity: 0.7;
    transition: opacity 0.2s;
    background: none;
    border: none;
    font-size: 0.95rem;
}
.editor-chapter-card .btn-delete:hover {
    opacity: 1;
    transform: scale(1.1);
}
</style>

<div class="paw-container">
    <h1><i class="fas fa-plus-circle" style="color: #E69C62;"></i> Tambah Buku Baru</h1>
    <p class="paw-subtitle">Registrasikan data buku baru ke dalam rak perpustakaan PawLib 🐾</p>

    <div class="form-box">
        <form action="/buku/simpan" method="post" enctype="multipart/form-data">
            
            <!-- Bagian 1: Informasi Utama -->
            <div class="form-section-title">
                <i class="fas fa-info-circle"></i> Informasi Utama Buku
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Judul Buku <span class="text-danger">*</span></label>
                    <input type="text" name="judul" placeholder="Contoh: Pemrograman Web Kucing" required>
                </div>
                
                <div class="form-group">
                    <label>Nama Penulis <span class="text-danger">*</span></label>
                    <input type="text" name="penulis" placeholder="Contoh: Dr. Meow" required>
                </div>
                
                <div class="form-group">
                    <label>Nama Penerbit <span class="text-danger">*</span></label>
                    <input type="text" name="penerbit" placeholder="Contoh: Penerbit PawPress" required>
                </div>
                
                <div class="form-group">
                    <label>Tahun Terbit <span class="text-danger">*</span></label>
                    <input type="number" name="tahun" placeholder="Contoh: 2026" required>
                </div>

                <div class="form-group">
                    <label>Jenis Koleksi <span class="text-danger">*</span></label>
                    <select name="jenis_koleksi" id="jenis_koleksi" required>
                        <option value="fisik">Buku Fisik</option>
                        <option value="ebook">E-Book</option>
                    </select>
                </div>
            </div>

            <!-- Bagian 2: Klasifikasi & Detail -->
            <div class="form-section-title">
                <i class="fas fa-tags"></i> Klasifikasi & Detail Fisik
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Nomor Panggil</label>
                    <input type="text" name="nomor_panggil" placeholder="Contoh: 813.4 MEW p">
                </div>
                
                <div class="form-group">
                    <label>Nomor Klasifikasi</label>
                    <input type="text" name="nomor_klasifikasi" placeholder="Contoh: 813.4">
                </div>
                
                <div class="form-group">
                    <label>ISBN</label>
                    <input type="text" name="isbn" placeholder="Contoh: 978-602-1234-56-7">
                </div>
                
                <div class="form-group">
                    <label>Dimensi Buku</label>
                    <input type="text" name="dimensi_buku" placeholder="Contoh: 15 x 23 cm">
                </div>
                
                <div class="form-group">
                    <label>Departemen / Kategori</label>
                    <input type="text" name="departemen" placeholder="Contoh: Fiksi, Komputer, Jurnal">
                </div>
                
                <div class="form-group">
                    <label>Edisi Buku</label>
                    <input type="text" name="edisi" placeholder="Contoh: Edisi Pertama, Cetakan Ke-2">
                </div>
                
                <div class="form-group">
                    <label>Bahasa</label>
                    <select name="bahasa" id="bahasa_select" onchange="toggleCustomLanguageInput(this, 'custom_bahasa_container', 'custom_bahasa_input')">
                        <option value="Indonesia" selected>Indonesia</option>
                        <option value="Inggris">Inggris</option>
                        <option value="Arab">Arab</option>
                        <option value="Mandarin">Mandarin</option>
                        <option value="Jepang">Jepang</option>
                        <option value="Korea">Korea</option>
                        <option value="Jerman">Jerman</option>
                        <option value="Prancis">Prancis</option>
                        <option value="Lainnya">Lainnya...</option>
                    </select>
                    <div id="custom_bahasa_container" style="display: none; margin-top: 10px;">
                        <input type="text" id="custom_bahasa_input" oninput="handleCustomLanguageInput(this, 'bahasa_select')" placeholder="Masukkan bahasa lain (misal: Spanyol)" style="padding: 10px 14px; border: 2px solid #ebd5c5; border-radius: 10px; font-size: 0.95rem; font-weight: 600; color: #4a3c31; background-color: #ffffff; width: 100%; box-sizing: border-box;">
                    </div>
                </div>

                <div class="form-group">
                    <label>Tempat Terbit / Kota</label>
                    <input type="text" name="tempat_terbit" placeholder="Contoh: Jakarta, Bandung">
                </div>

                <div class="form-group">
                    <label>Deskripsi Fisik (Ilustrasi, dll.)</label>
                    <input type="text" name="deskripsi_fisik" placeholder="Contoh: ilus. , il.">
                </div>
            </div>

            <!-- Bagian 3: Sinopsis & Catatan Buku -->
            <div class="form-section-title">
                <i class="fas fa-align-left"></i> Sinopsis & Catatan Buku
            </div>
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label>Sinopsis / Deskripsi Singkat</label>
                <textarea name="sinopsis" style="padding: 14px 18px; border: 2px solid #ebd5c5; border-radius: 12px; font-family: 'Quicksand', sans-serif; font-size: 0.95rem; font-weight: 600; color: #4a3c31; background-color: #ffffff; transition: all 0.3s ease; width: 100%; box-sizing: border-box; min-height: 100px; resize: vertical;" placeholder="Tulis sinopsis atau deskripsi buku di sini..."></textarea>
            </div>

            <div class="form-group" style="margin-bottom: 25px;">
                <label>Catatan Tambahan (Notes Area)</label>
                <textarea name="catatan" style="padding: 14px 18px; border: 2px solid #ebd5c5; border-radius: 12px; font-family: 'Quicksand', sans-serif; font-size: 0.95rem; font-weight: 600; color: #4a3c31; background-color: #ffffff; transition: all 0.3s ease; width: 100%; box-sizing: border-box; min-height: 80px; resize: vertical;" placeholder="Tulis catatan bibliografi atau keterangan tambahan di sini..."></textarea>
            </div>

            <!-- Bagian 4: Inventori & Lokasi -->
            <div class="form-section-title">
                <i class="fas fa-boxes"></i> Inventori & Lokasi Rak
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Jumlah Stok <span class="text-danger">*</span></label>
                    <input type="number" name="stok" placeholder="Contoh: 15" required>
                </div>
                
                <div class="form-group">
                    <label>Klasifikasi DDC <span class="text-danger">*</span></label>
                    <select name="rak_id" required>
                        <option value="">-- Pilih Klasifikasi DDC --</option>
                        <?php 
                            $db = \Config\Database::connect();
                            $rakList = $db->table('rak')->orderBy('kode_ddc', 'ASC')->get()->getResultArray();
                            foreach($rakList as $r):
                        ?>
                            <option value="<?= $r['id'] ?>"><?= esc($r['kode_ddc']) ?> - <?= esc($r['nama_rak']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Bagian E-Book Khusus (Hanya muncul jika Ebook dipilih) -->
            <div id="section_ebook" style="display: none;">
                <div class="form-section-title">
                    <i class="fas fa-file-pdf"></i> Konten Digital E-Book
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Upload File E-Book (PDF atau EPUB) <span class="text-danger">*</span></label>
                        <input type="file" name="file_pdf" id="file_pdf" accept="application/pdf, application/epub+zip" style="padding: 10px;">
                    </div>
                    <div class="form-group">
                        <label>Jumlah Halaman E-Book</label>
                        <input type="number" name="jumlah_halaman" id="jumlah_halaman" placeholder="Contoh: 150" value="0">
                    </div>
                    <div class="form-group">
                        <label>Metode Pembagian Bab/TOC <span class="text-danger">*</span></label>
                        <select id="pdf_split_method" style="padding: 14px 18px; border: 2px solid #ebd5c5; border-radius: 12px; font-weight: bold; font-family: 'Quicksand', sans-serif;">
                            <option value="auto" selected>🛡️ Deteksi Bab Otomatis (Rekomendasi)</option>
                            <option value="single">📚 Gabung Semua (Satu Bab Utama)</option>
                            <option value="page">📄 Pecah Per Halaman PDF</option>
                        </select>
                    </div>
                </div>
                
                <div style="margin-top: 15px; background: #fffcf9; padding: 20px; border-radius: 18px; border: 2px dashed #ebd5c5;">
                    <label style="display: flex; align-items: center; gap: 10px; font-weight: bold; cursor: pointer;">
                        <input type="checkbox" name="mode_baca" id="mode_baca" value="1" checked style="width: 20px; height: 20px; margin: 0;">
                        <span>Aktifkan Mode Baca PawLib (Konversi ke Ebook Reader)</span>
                    </label>
                    <p style="font-size: 0.85rem; color: #8c7b70; margin: 5px 0 0 30px;">
                        PDF akan otomatis diekstrak menjadi teks HTML agar pengguna mendapat pengalaman membaca digital yang nyaman (Wattpad/Kindle style) langsung di perpustakaan digital PawLib.
                    </p>
                </div>

                <!-- Kontainer Editor Halaman -->
                <div id="chapters_editor_container" style="margin-top: 25px; margin-bottom: 25px;">
                    <div class="form-section-title">
                        <i class="fas fa-edit"></i> Preview & Editor E-Book Dashboard
                    </div>
                    
                    <!-- Loading PDF Spinner -->
                    <div id="pdf_loading" style="display: none; text-align: center; padding: 30px; background: white; border-radius: 18px; border: 2px dashed #ebd5c5; margin-bottom: 20px;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 35px; color: #E69C62; margin-bottom: 12px;"></i>
                        <h4 style="margin: 0; color: #4a3c31; font-weight: bold;">Mengekstrak teks PDF...</h4>
                        <p style="font-size: 0.85rem; color: #8c7b70; margin-top: 5px;" id="pdf_loading_text">Menunggu antrean halaman...</p>
                    </div>

                    <!-- Info Ekstraksi PDF -->
                    <div id="pdf_info_badge" style="display: none; padding: 15px 20px; background: #e2f9e1; border: 2px solid #c2ecc0; border-radius: 16px; margin-bottom: 20px; font-weight: 700; color: #1e6b26;">
                        <i class="fas fa-check-circle"></i> Berhasil mengekstrak teks PDF. Silakan periksa daftar bab di panel bawah.
                    </div>

                    <!-- Ebook Dashboard Editor Layout -->
                    <div id="dashboard_editor_box" style="display: none; grid-template-columns: 280px 1fr; gap: 20px; margin-top: 15px;">
                        <!-- Left Panel: Chapter List (TOC) -->
                        <div style="background: #FFFDF7; border: 2px solid #ebd5c5; border-radius: 18px; padding: 20px; display: flex; flex-direction: column; gap: 15px; box-sizing: border-box;">
                            <div style="font-weight: 700; color: #4a3c31; font-size: 0.95rem; border-bottom: 2px dashed #ebd5c5; padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-list-ol" style="color: #E69C62;"></i> Daftar Isi & Bab (TOC)
                            </div>
                            <div id="editor_chapters_list" style="max-height: 380px; overflow-y: auto; display: flex; flex-direction: column; gap: 10px; padding-right: 5px;">
                                <!-- Chapter items will be rendered here dynamically -->
                            </div>
                            <button type="button" id="btn_add_chapter" class="btn-cancel" style="width: 100%; padding: 12px; font-size: 0.85rem; border-radius: 12px; justify-content: center; margin-top: 5px; cursor: pointer; border: 2px solid #ebd5c5;">
                                <i class="fas fa-plus"></i> Tambah Bab Baru
                            </button>
                        </div>
                        
                        <!-- Right Panel: WYSIWYG Editor -->
                        <div id="editor_main_panel" style="background: #FFFDF7; border: 2px solid #ebd5c5; border-radius: 18px; padding: 20px; display: flex; flex-direction: column; gap: 15px; min-width: 0; box-sizing: border-box;">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                                <div style="display: flex; align-items: center; gap: 8px; flex-grow: 1; min-width: 200px;">
                                    <span style="font-weight: bold; font-size: 0.9rem; color: #4a3c31; white-space: nowrap;">Judul Bab/Bagian:</span>
                                    <input type="text" id="active_chapter_title_input" style="padding: 10px 14px; border-radius: 10px; border: 2px solid #ebd5c5; font-size: 0.9rem; width: 100%; box-sizing: border-box; font-family: 'Quicksand', sans-serif; font-weight: 700; color: #4a3c31;" placeholder="Contoh: Bab I: Pendahuluan">
                                </div>
                                <button type="button" id="btn_insert_page_break" class="btn-cancel" style="padding: 10px 14px; font-size: 0.85rem; border-radius: 10px; border: 2px solid #E69C62; color: #E69C62; background: transparent; cursor: pointer; font-weight: bold; display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-columns"></i> Sisipkan Pembatas Halaman
                                </button>
                            </div>
                            
                            <!-- Quill Editor Container -->
                            <div style="border-radius: 12px; overflow: hidden; border: 2px solid #ebd5c5; background: white;">
                                <div id="quill_toolbar"></div>
                                <div id="quill_editor" style="height: 350px;"></div>
                            </div>
                            <p style="font-size: 0.8rem; color: #8c7b70; margin: 0;">
                                <i class="fas fa-info-circle"></i> Gunakan "Sisipkan Pembatas Halaman" di atas untuk membagi konten bab menjadi halaman-halaman membaca terpisah.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Hidden field to store serialized chapters JSON -->
                    <input type="hidden" name="chapters" id="chapters_payload" value="">
                </div>
            </div>

            <!-- Bagian 5: Gambar Sampul Buku -->
            <div class="form-section-title">
                <i class="fas fa-image"></i> Gambar Sampul Buku
            </div>
            
            <div class="form-group">
                <label>File Cover (PNG, JPG, atau JPEG)</label>
                <input type="file" name="cover" accept="image/*" style="padding: 10px;">
            </div>

            <!-- Tombol Submit & Batal -->
            <div class="form-actions">
                <button type="submit" class="btn-submit" onclick="return confirm('Buku baru siap masuk ke rak PawLib. Simpan sekarang?')">
                    <i class="fas fa-save"></i> Simpan Buku
                </button>
                <a href="/buku" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
            
        </form>
    </div>
</div>

<!-- Impor PDF.js untuk ekstraksi PDF client-side -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

<script>
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

let chapters = [];
let activeChapterIndex = -1;
let quill = null;

// Initialize Quill Editor
function initQuill() {
    if (quill) return;
    
    // Add custom toolbar
    quill = new Quill('#quill_editor', {
        theme: 'snow',
        modules: {
            toolbar: {
                container: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }], // outdent/indent
                    ['clean']
                ]
            }
        }
    });

    // Listen for text changes to sync content in real-time
    quill.on('text-change', function() {
        if (activeChapterIndex >= 0 && activeChapterIndex < chapters.length) {
            chapters[activeChapterIndex].isi_bab = quill.root.innerHTML;
            serializeChapters();
        }
    });
}

// Convert plain text paragraphs into Quill HTML
function convertToHTML(plainText) {
    let paragraphs = plainText.split(/\n\s*\n/);
    let html = paragraphs.map(p => {
        let trimmed = p.trim();
        if (trimmed.length === 0) return "";
        let escaped = trimmed
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;");
        return `<p style="text-align: justify; line-height: 1.8; margin-bottom: 1em;">${escaped}</p>`;
    }).join("");
    return html;
}

// Reconstruct paragraphs from PDF.js single-line wraps, keeping blank lines (\n\n)
function cleanPDFTextPlain(text) {
    let clean = text.replace(/\r\n/g, "\n").replace(/\r/g, "\n");
    // Normalize paragraph breaks
    clean = clean.replace(/\n\s*\n/g, "[P_BREAK]");
    // Replace single newlines with space
    clean = clean.replace(/\n/g, " ");
    // Clean up multiple spaces
    clean = clean.replace(/[ \t]+/g, " ");
    // Restore paragraph breaks
    clean = clean.replace(/\[P_BREAK\]/g, "\n\n");
    return clean.trim();
}

// Detect chapter title heuristic
function detectChapterTitle(pageText) {
    let lines = pageText.trim().split('\n');
    if (lines.length === 0) return null;
    
    for (let i = 0; i < Math.min(lines.length, 3); i++) {
        let line = lines[i].trim();
        if (line.length === 0) continue;
        
        if (/^(BAB|CHAPTER|Bab|Chapter)\s+(\d+|[IVXLCDM\d]+)/i.test(line)) {
            let title = line;
            if (i + 1 < lines.length && lines[i+1].trim().length > 0 && lines[i+1].trim().length < 60) {
                title += " - " + lines[i+1].trim();
            }
            return title;
        }
        if (/^(DAFTAR ISI|DAFTAR TABEL|PREFACE|PRAKATA|PENDAHULUAN|DAFTAR PUSTAKA|LAMPIRAN|KATA PENGANTAR|ABSTRAK|ABSTRACT|GLOSARIUM|GLOSSARY)/i.test(line)) {
            return line;
        }
    }
    return null;
}

// Toggle Ebook fields visibility
document.getElementById('jenis_koleksi').addEventListener('change', function() {
    const isEbook = this.value === 'ebook';
    document.getElementById('section_ebook').style.display = isEbook ? 'block' : 'none';
    
    // Toggle stok field
    const stokInput = document.getElementsByName('stok')[0];
    if (isEbook) {
        stokInput.value = 9999;
        stokInput.closest('.form-group').style.display = 'none';
        stokInput.removeAttribute('required');
        document.getElementById('file_pdf').setAttribute('required', 'required');
    } else {
        stokInput.value = '';
        stokInput.closest('.form-group').style.display = 'block';
        stokInput.setAttribute('required', 'required');
        document.getElementById('file_pdf').removeAttribute('required');
    }
});

document.getElementById('mode_baca').addEventListener('change', function() {
    const container = document.getElementById('chapters_editor_container');
    if (this.checked) {
        container.style.display = 'block';
        // Re-trigger parsing if a file is already selected
        const fileInput = document.getElementById('file_pdf');
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            if (file.name.toLowerCase().endsWith('.epub')) {
                parseEpubFile(file);
            } else if (file.name.toLowerCase().endsWith('.pdf')) {
                parsePdfFile(file);
            }
        }
    } else {
        container.style.display = 'none';
        document.getElementById('dashboard_editor_box').style.display = 'none';
        document.getElementById('pdf_info_badge').style.display = 'none';
        chapters = [];
        serializeChapters();
    }
});

// PDF & EPUB Parsing & Structured Text Extraction
document.getElementById('file_pdf').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (!file) return;

    const modeBacaCheckbox = document.getElementById('mode_baca');
    const isEpub = file.name.toLowerCase().endsWith('.epub');

    if (isEpub) {
        // EPUB always forces Mode Baca checked and disabled
        modeBacaCheckbox.checked = true;
        modeBacaCheckbox.disabled = true;
        document.getElementById('chapters_editor_container').style.display = 'block';
        parseEpubFile(file);
    } else if (file.name.toLowerCase().endsWith('.pdf')) {
        modeBacaCheckbox.disabled = false;
        if (modeBacaCheckbox.checked) {
            parsePdfFile(file);
        } else {
            document.getElementById('dashboard_editor_box').style.display = 'none';
            document.getElementById('pdf_info_badge').style.display = 'none';
            chapters = [];
            serializeChapters();
        }
    } else {
        alert('Format file tidak didukung. Harap upload PDF atau EPUB.');
        event.target.value = '';
    }
});

function parsePdfFile(file) {
    document.getElementById('pdf_loading').style.display = 'block';
    document.getElementById('dashboard_editor_box').style.display = 'none';
    document.getElementById('pdf_info_badge').style.display = 'none';
    chapters = [];

    const fileReader = new FileReader();
    fileReader.onload = function() {
        const typedarray = new Uint8Array(this.result);
        
        pdfjsLib.getDocument(typedarray).promise.then(function(pdf) {
            const totalPages = pdf.numPages;
            document.getElementById('jumlah_halaman').value = totalPages;
            
            let pagesText = [];
            let count = 0;

            function extractPage(pageNum) {
                document.getElementById('pdf_loading_text').innerText = `Mengekstrak teks halaman ${pageNum} dari ${totalPages}...`;
                
                pdf.getPage(pageNum).then(function(page) {
                    page.getTextContent().then(function(textContent) {
                        let items = textContent.items;
                        let pageText = "";
                        
                        if (items.length > 0) {
                            let lastY = null;
                            let lastX = null;
                            let minX = null;
                            
                            for (let i = 0; i < items.length; i++) {
                                let item = items[i];
                                let str = item.str;
                                
                                // Coordinates mapping
                                let x = item.transform[4];
                                let y = item.transform[5];
                                let height = item.transform[3]; // scaleY
                                
                                if (lastY !== null) {
                                    let deltaY = Math.abs(y - lastY);
                                    if (deltaY > 5) { // Vertical difference represents new line
                                        if (minX === null || x < minX) {
                                            minX = x;
                                        }
                                        
                                        let h = Math.abs(height) > 0 ? Math.abs(height) : 12;
                                        let isParagraph = false;
                                        
                                        // Heuristic 1: Vertical gap is larger than standard line spacing
                                        if (deltaY > h * 1.25 || deltaY > h + 3.5) {
                                            isParagraph = true;
                                        }
                                        // Heuristic 2: Indentation at the start of a line
                                        else if (minX !== null && x > minX + 12) {
                                            isParagraph = true;
                                        }
                                        // Heuristic 3: Sentence-ending punctuation on previous line and current line starting with capital
                                        else if (pageText.length > 0) {
                                            let lastChar = pageText.trim().slice(-1);
                                            let isSentenceEnd = /[.!?"”’)]/.test(lastChar);
                                            let startsWithCapital = /^[A-Z0-9]/.test(str.trim());
                                            if (isSentenceEnd && startsWithCapital) {
                                                isParagraph = true;
                                            }
                                        }
                                        
                                        if (isParagraph) {
                                            pageText += "\n\n";
                                        } else {
                                            pageText += "\n";
                                        }
                                    } else {
                                        // Horizontal spacer check
                                        if (lastX !== null && x > lastX + 8 && !pageText.endsWith(" ")) {
                                            pageText += " ";
                                        }
                                    }
                                } else {
                                    // First item on the page sets the initial minX
                                    minX = x;
                                }
                                
                                pageText += str;
                                lastY = y;
                                lastX = x + (item.width || 0);
                            }
                        }
                        
                        pagesText[pageNum - 1] = pageText;
                        count++;
                        
                        if (count === totalPages) {
                            processExtractedText(pagesText);
                        } else {
                            extractPage(pageNum + 1);
                        }
                    });
                });
            }
            
            extractPage(1);
            
        }).catch(function(error) {
            alert("Gagal membaca berkas PDF: " + error.message);
            document.getElementById('pdf_loading').style.display = 'none';
        });
    };
    fileReader.readAsArrayBuffer(file);
}

function parseEpubFile(file) {
    document.getElementById('pdf_loading').style.display = 'block';
    document.getElementById('pdf_loading_text').innerText = "Membuka file EPUB...";
    document.getElementById('dashboard_editor_box').style.display = 'none';
    document.getElementById('pdf_info_badge').style.display = 'none';
    chapters = [];

    const fileReader = new FileReader();
    fileReader.onload = function() {
        JSZip.loadAsync(this.result).then(function(zip) {
            // 1. Locate container.xml to find the Rootfile path (.opf file)
            const containerXmlFile = zip.file("META-INF/container.xml");
            if (!containerXmlFile) {
                throw new Error("File META-INF/container.xml tidak ditemukan di berkas EPUB.");
            }
            
            return containerXmlFile.async("string").then(function(containerXmlText) {
                const parser = new DOMParser();
                const containerDoc = parser.parseFromString(containerXmlText, "text/xml");
                const rootfile = containerDoc.querySelector("rootfile");
                if (!rootfile) {
                    throw new Error("rootfile tag tidak ditemukan di container.xml");
                }
                const opfPath = rootfile.getAttribute("full-path");
                
                // Get OPF directory path
                let opfDir = "";
                const slashIdx = opfPath.lastIndexOf('/');
                if (slashIdx !== -1) {
                    opfDir = opfPath.substring(0, slashIdx + 1);
                }
                
                const opfFile = zip.file(opfPath);
                if (!opfFile) {
                    throw new Error("File manifest OPF tidak ditemukan di path: " + opfPath);
                }
                
                return opfFile.async("string").then(function(opfXmlText) {
                    const opfDoc = parser.parseFromString(opfXmlText, "text/xml");
                    
                    // 2. Parse Manifest to map item ID to href
                    const manifestItems = {};
                    const items = opfDoc.querySelectorAll("manifest > item");
                    items.forEach(item => {
                        const id = item.getAttribute("id");
                        const href = item.getAttribute("href");
                        const mediaType = item.getAttribute("media-type");
                        manifestItems[id] = { href: href, mediaType: mediaType };
                    });
                    
                    // 3. Parse Spine to get reading order
                    const spineIdrefs = [];
                    const spineItems = opfDoc.querySelectorAll("spine > itemref");
                    spineItems.forEach(spineItem => {
                        const idref = spineItem.getAttribute("idref");
                        if (idref) spineIdrefs.push(idref);
                    });
                    
                    // 4. Resolve spine paths relative to OPF dir
                    const chapterFiles = [];
                    spineIdrefs.forEach(idref => {
                        const manifestItem = manifestItems[idref];
                        if (manifestItem && (
                            manifestItem.mediaType === "application/xhtml+xml" ||
                            manifestItem.mediaType === "text/html" ||
                            manifestItem.mediaType === "application/xml"
                        )) {
                            const fullPath = opfDir + manifestItem.href;
                            const cleanedPath = cleanRelativePath(fullPath);
                            chapterFiles.push({ id: idref, path: cleanedPath });
                        }
                    });

                    if (chapterFiles.length === 0) {
                        throw new Error("Tidak menemukan konten halaman XHTML/HTML di dalam EPUB.");
                    }

                    // 4b. Extract all images as Base64 promises
                    const imageFiles = [];
                    items.forEach(item => {
                        const href = item.getAttribute("href");
                        const mediaType = item.getAttribute("media-type");
                        if (mediaType && mediaType.startsWith("image/")) {
                            const fullPath = opfDir + href;
                            const cleanedPath = cleanRelativePath(fullPath);
                            imageFiles.push({ href: href, path: cleanedPath, mediaType: mediaType });
                        }
                    });

                    let imagePromises = imageFiles.map(imgFile => {
                        const fileInZip = zip.file(imgFile.path);
                        if (!fileInZip) {
                            let matchedFile = null;
                            zip.forEach((path, file) => {
                                if (path.toLowerCase() === imgFile.path.toLowerCase()) {
                                    matchedFile = file;
                                }
                            });
                            if (matchedFile) {
                                return matchedFile.async("base64").then(b64 => ({ path: imgFile.path, b64: b64, mediaType: imgFile.mediaType }));
                            }
                            return Promise.resolve(null);
                        }
                        return fileInZip.async("base64").then(b64 => ({ path: imgFile.path, b64: b64, mediaType: imgFile.mediaType }));
                    });

                    return Promise.all(imagePromises).then(function(loadedImages) {
                        const imageMap = {};
                        loadedImages.forEach(img => {
                            if (img) {
                                imageMap[img.path.toLowerCase()] = img;
                            }
                        });
                        
                        // 5. Read all chapter files asynchronously in order
                        let chapterReadPromises = chapterFiles.map(chapFile => {
                            const fileInZip = zip.file(chapFile.path);
                            if (!fileInZip) {
                                // Find with case-insensitivity fallback
                                let matchedFile = null;
                                zip.forEach((path, file) => {
                                    if (path.toLowerCase() === chapFile.path.toLowerCase()) {
                                        matchedFile = file;
                                    }
                                });
                                if (matchedFile) {
                                    return matchedFile.async("string").then(text => ({ id: chapFile.id, path: chapFile.path, text: text }));
                                }
                                return Promise.resolve({ id: chapFile.id, path: chapFile.path, text: "<p>[Halaman/Bab Kosong - File tidak ditemukan di ZIP]</p>" });
                            }
                            return fileInZip.async("string").then(text => ({ id: chapFile.id, path: chapFile.path, text: text }));
                        });
                        
                        return Promise.all(chapterReadPromises).then(function(readChapters) {
                            let estimatedPages = 0;
                            let chapCounter = 1;
                            
                            readChapters.forEach((chap, idx) => {
                                const rawHtml = chap.text;
                                const chapDoc = parser.parseFromString(rawHtml, "text/html");

                                // Resolve relative image paths to inline base64
                                const htmlDir = chap.path.substring(0, chap.path.lastIndexOf('/') + 1);
                                
                                const imgs = chapDoc.querySelectorAll("img");
                                imgs.forEach(img => {
                                    const src = img.getAttribute("src");
                                    if (src && !src.startsWith("http") && !src.startsWith("data:")) {
                                        const imgPath = cleanRelativePath(htmlDir + src);
                                        const imgData = imageMap[imgPath.toLowerCase()];
                                        if (imgData) {
                                            img.setAttribute("src", `data:${imgData.mediaType};base64,${imgData.b64}`);
                                        }
                                    }
                                });

                                const svgImages = chapDoc.querySelectorAll("image");
                                svgImages.forEach(svgImg => {
                                    let href = svgImg.getAttribute("xlink:href") || svgImg.getAttribute("href");
                                    if (href && !href.startsWith("http") && !href.startsWith("data:")) {
                                        const imgPath = cleanRelativePath(htmlDir + href);
                                        const imgData = imageMap[imgPath.toLowerCase()];
                                        if (imgData) {
                                            svgImg.setAttribute("xlink:href", `data:${imgData.mediaType};base64,${imgData.b64}`);
                                            svgImg.setAttribute("href", `data:${imgData.mediaType};base64,${imgData.b64}`);
                                        }
                                    }
                                });
                                
                                // Extract title
                                let title = "";
                                const titleTag = chapDoc.querySelector("title");
                                if (titleTag && titleTag.textContent.trim().length > 0) {
                                    title = titleTag.textContent.trim();
                                } else {
                                    const h1 = chapDoc.querySelector("h1, h2, h3, h4");
                                    if (h1 && h1.textContent.trim().length > 0) {
                                        title = h1.textContent.trim();
                                    } else {
                                        title = `Bab ${chapCounter}`;
                                    }
                                }
                                
                                // Extract body content or whole doc
                                const body = chapDoc.querySelector("body");
                                let bodyContent = body ? body.innerHTML : rawHtml;
                                
                                // Auto split long content into sub-pages using character limit (~1800 chars per page)
                                let paginatedContent = splitHtmlIntoPages(bodyContent, 1800);
                                
                                // Count page breaks to estimate total pages
                                const pageCount = (paginatedContent.split(/<hr[^>]*class=["']page-break["'][^>]*>/gi).length);
                                estimatedPages += pageCount;
                                
                                chapters.push({
                                    nomor_bab: chapCounter++,
                                    judul_bab: title,
                                    isi_bab: paginatedContent
                                });
                            });
                            
                            document.getElementById('jumlah_halaman').value = estimatedPages;
                            
                            document.getElementById('pdf_loading').style.display = 'none';
                            initQuill();
                            renderChaptersList();
                            if (chapters.length > 0) {
                                selectChapter(0);
                            }
                            document.getElementById('dashboard_editor_box').style.display = 'grid';
                            document.getElementById('pdf_info_badge').innerHTML = '<i class="fas fa-check-circle"></i> Berhasil mengekstrak teks & gambar EPUB. Silakan periksa daftar bab di panel bawah.';
                            document.getElementById('pdf_info_badge').style.display = 'block';
                            serializeChapters();
                        });
                    });
                });
            });
        }).catch(function(error) {
            alert("Gagal membaca berkas EPUB: " + error.message);
            document.getElementById('pdf_loading').style.display = 'none';
        });
    };
    fileReader.readAsArrayBuffer(file);
}

// Clean relative path segments (e.g. OEBPS/text/../../OEBPS/text/ch01.xhtml -> OEBPS/text/ch01.xhtml)
function cleanRelativePath(path) {
    let parts = path.split('/');
    let stack = [];
    for (let i = 0; i < parts.length; i++) {
        if (parts[i] === '.' || parts[i] === '') {
            continue;
        }
        if (parts[i] === '..') {
            if (stack.length > 0) stack.pop();
        } else {
            stack.push(parts[i]);
        }
    }
    return stack.join('/');
}

// Helper split XHTML content based on character length
// Helper to sanitize HTML content once per chapter for extreme performance speedups
function sanitizeHtmlFragment(html) {
    const temp = document.createElement('div');
    temp.innerHTML = html;
    
    const allowedTags = ['strong', 'b', 'em', 'i', 'u', 's', 'strike', 'span', 'a', 'img', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote', 'li', 'pre', 'table', 'tr', 'td', 'th', 'thead', 'tbody', 'ul', 'ol', 'div'];
    const allElements = temp.getElementsByTagName('*');
    
    for (let i = allElements.length - 1; i >= 0; i--) {
        const el = allElements[i];
        const tagName = el.tagName.toLowerCase();
        
        if (allowedTags.includes(tagName)) {
            const attrs = Array.from(el.attributes);
            attrs.forEach(attr => {
                if (tagName === 'a' && attr.name === 'href') {
                    // keep href
                } else if (tagName === 'img' && attr.name === 'src') {
                    // keep src
                    el.setAttribute('style', 'max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); display: block; margin: 15px auto;');
                } else if (['table', 'tr', 'td', 'th', 'tbody', 'thead'].includes(tagName)) {
                    if (attr.name !== 'colspan' && attr.name !== 'rowspan') {
                        el.removeAttribute(attr.name);
                    }
                } else {
                    el.removeAttribute(attr.name);
                }
            });
        } else {
            const parent = el.parentNode;
            if (parent) {
                while (el.firstChild) {
                    parent.insertBefore(el.firstChild, el);
                }
                parent.removeChild(el);
            }
        }
    }
    return temp.innerHTML;
}

// Helper split XHTML content based on character length
function splitHtmlIntoPages(bodyHtml, charLimit = 1800) {
    const sanitizedHtml = sanitizeHtmlFragment(bodyHtml);
    const temp = document.createElement('div');
    temp.innerHTML = sanitizedHtml;
    
    let flatElements = [];
    
    function traverse(node) {
        if (node.nodeType === Node.ELEMENT_NODE) {
            const tagName = node.tagName.toLowerCase();
            
            if (tagName === 'img') {
                let src = node.getAttribute('src') || '';
                flatElements.push({
                    tag: 'div',
                    html: `<img src="${src}" style="max-width: 100%; height: auto; display: block; margin: 15px auto; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);" />`
                });
            } else if (tagName === 'table') {
                flatElements.push({
                    tag: 'div',
                    html: `<div style="overflow-x: auto; width: 100%; margin: 20px 0;">${cleanTableHtml(node)}</div>`
                });
            } else if (['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote', 'li', 'pre'].includes(tagName)) {
                let inner = node.innerHTML;
                if (inner.trim().length > 0) {
                    flatElements.push({
                        tag: tagName,
                        html: inner
                    });
                }
            } else {
                for (let i = 0; i < node.childNodes.length; i++) {
                    traverse(node.childNodes[i]);
                }
            }
        } else if (node.nodeType === Node.TEXT_NODE) {
            const text = node.nodeValue.trim();
            if (text.length > 0) {
                flatElements.push({
                    tag: 'p',
                    html: escHtml(text)
                });
            }
        }
    }
    
    function cleanTableHtml(tableNode) {
        const clone = tableNode.cloneNode(true);
        clone.setAttribute('style', 'width: 100%; border-collapse: collapse; margin: 0; font-family: inherit; font-size: 0.95rem; border: 2px solid var(--border-reader, #ebd5c5); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.01);');
        
        const allCells = clone.querySelectorAll('td');
        allCells.forEach(cell => {
            const attrs = Array.from(cell.attributes);
            attrs.forEach(attr => {
                if (attr.name !== 'colspan' && attr.name !== 'rowspan') {
                    cell.removeAttribute(attr.name);
                }
            });
            cell.setAttribute('style', 'border: 1px solid var(--border-reader, #ebd5c5); padding: 12px; text-align: left;');
        });

        const allRows = clone.querySelectorAll('tr');
        allRows.forEach((row, rIdx) => {
            const attrs = Array.from(row.attributes);
            attrs.forEach(attr => row.removeAttribute(attr.name));
            if (rIdx % 2 === 1) {
                row.setAttribute('style', 'background-color: rgba(230, 156, 98, 0.02);');
            }
        });

        const allHeaders = clone.querySelectorAll('th');
        allHeaders.forEach(th => {
            const attrs = Array.from(th.attributes);
            attrs.forEach(attr => {
                if (attr.name !== 'colspan' && attr.name !== 'rowspan') {
                    th.removeAttribute(attr.name);
                }
            });
            th.setAttribute('style', 'border: 1px solid var(--border-reader, #ebd5c5); padding: 12px; text-align: left; font-weight: 700; background-color: rgba(230, 156, 98, 0.06);');
        });

        return clone.outerHTML;
    }
    
    traverse(temp);
    
    let outputHtml = '';
    let charCount = 0;
    
    flatElements.forEach((el, index) => {
        if (el.tag === 'div') {
            outputHtml += el.html;
        } else {
            outputHtml += `<${el.tag} style="text-align: justify; line-height: 1.8; margin-bottom: 1em;">${el.html}</${el.tag}>`;
        }
        
        const cleanText = el.html.replace(/<[^>]*>/g, '');
        charCount += cleanText.length;
        
        if (charCount >= charLimit && index < flatElements.length - 1) {
            outputHtml += '<hr class="page-break" />';
            charCount = 0;
        }
    });
    
    outputHtml = outputHtml.replace(/<hr class="page-break"\s*\/?>\s*$/, '');
    return outputHtml;
}

// Process Extracted Text according to user selected method
function processExtractedText(pagesText) {
    document.getElementById('pdf_loading_text').innerText = "Menyusun bab & konten...";
    const method = document.getElementById('pdf_split_method').value;
    chapters = [];

    if (method === 'single') {
        // Merge everything into a single chapter
        let fullHtml = "";
        for (let i = 0; i < pagesText.length; i++) {
            let clean = cleanPDFTextPlain(pagesText[i]);
            let pageHtml = convertToHTML(clean);
            if (i > 0) {
                fullHtml += `<hr class="page-break" data-page="${i+1}">`;
            }
            fullHtml += pageHtml;
        }
        chapters.push({
            nomor_bab: 1,
            judul_bab: "Buku Lengkap",
            isi_bab: fullHtml
        });
    } 
    else if (method === 'page') {
        // Split page-by-page
        for (let i = 0; i < pagesText.length; i++) {
            let clean = cleanPDFTextPlain(pagesText[i]);
            chapters.push({
                nomor_bab: i + 1,
                judul_bab: `Halaman ${i + 1}`,
                isi_bab: convertToHTML(clean)
            });
        }
    } 
    else {
        // Auto Chapter Detection (method === 'auto')
        let currentChapter = null;
        let chapCounter = 1;

        for (let i = 0; i < pagesText.length; i++) {
            let pageNum = i + 1;
            let rawContent = pagesText[i].trim();
            let cleanContent = cleanPDFTextPlain(rawContent);
            let pageHtml = convertToHTML(cleanContent);
            
            let detectedTitle = detectChapterTitle(rawContent);

            if (detectedTitle) {
                // If a chapter heading is found, start a new chapter
                if (currentChapter) {
                    chapters.push(currentChapter);
                }
                currentChapter = {
                    nomor_bab: chapCounter++,
                    judul_bab: detectedTitle,
                    isi_bab: pageHtml
                };
            } else {
                // No heading found
                if (!currentChapter) {
                    // Start default first chapter
                    currentChapter = {
                        nomor_bab: chapCounter++,
                        judul_bab: "Prakata / Bagian Awal",
                        isi_bab: pageHtml
                    };
                } else {
                    // Append page content to current chapter, with a page break marker
                    currentChapter.isi_bab += `<hr class="page-break" data-page="${pageNum}">${pageHtml}`;
                }
            }
        }
        if (currentChapter) {
            chapters.push(currentChapter);
        }
    }

    document.getElementById('pdf_loading').style.display = 'none';
    initQuill();
    renderChaptersList();
    if (chapters.length > 0) {
        selectChapter(0);
    }
    document.getElementById('dashboard_editor_box').style.display = 'grid';
    document.getElementById('pdf_info_badge').innerHTML = '<i class="fas fa-check-circle"></i> Berhasil mengekstrak teks PDF. Silakan periksa daftar bab di panel bawah.';
    document.getElementById('pdf_info_badge').style.display = 'block';
    serializeChapters();
}

// Render TOC list on Left Panel
function renderChaptersList() {
    const listContainer = document.getElementById('editor_chapters_list');
    listContainer.innerHTML = '';

    chapters.forEach((chap, idx) => {
        const card = document.createElement('div');
        card.className = `editor-chapter-card ${idx === activeChapterIndex ? 'active' : ''}`;
        card.innerHTML = `
            <div class="chap-info">
                <div class="chap-index">Bagian ${idx + 1}</div>
                <div class="chap-title">${escHtml(chap.judul_bab || 'Bab Tanpa Judul')}</div>
            </div>
            <button type="button" class="btn-delete" title="Hapus Bab"><i class="fas fa-trash"></i></button>
        `;

        // Load chapter content on click
        card.addEventListener('click', (e) => {
            if (e.target.closest('.btn-delete')) return; // handled separately
            selectChapter(idx);
        });

        // Delete chapter handler
        card.querySelector('.btn-delete').addEventListener('click', (e) => {
            e.stopPropagation();
            if (confirm(`Yakin ingin menghapus bab "${chap.judul_bab}"? Semua konten di dalam bab ini akan hilang.`)) {
                deleteChapter(idx);
            }
        });

        listContainer.appendChild(card);
    });
}

// Select a Chapter & load it in Quill Editor
function selectChapter(index) {
    // Save current active chapter content first
    if (activeChapterIndex >= 0 && activeChapterIndex < chapters.length && quill) {
        chapters[activeChapterIndex].isi_bab = quill.root.innerHTML;
        chapters[activeChapterIndex].judul_bab = document.getElementById('active_chapter_title_input').value.trim() || `Bab ${activeChapterIndex + 1}`;
    }

    activeChapterIndex = index;
    renderChaptersList();

    // Populate active chapter edit inputs
    const activeChap = chapters[index];
    document.getElementById('active_chapter_title_input').value = activeChap.judul_bab;
    
    // Load content into Quill editor
    if (quill) {
        quill.root.innerHTML = activeChap.isi_bab || '';
    }
}

// Add empty new chapter
document.getElementById('btn_add_chapter').addEventListener('click', () => {
    // Save active chapter first
    if (activeChapterIndex >= 0 && activeChapterIndex < chapters.length && quill) {
        chapters[activeChapterIndex].isi_bab = quill.root.innerHTML;
        chapters[activeChapterIndex].judul_bab = document.getElementById('active_chapter_title_input').value.trim() || `Bab ${activeChapterIndex + 1}`;
    }

    const newIdx = chapters.length;
    chapters.push({
        nomor_bab: newIdx + 1,
        judul_bab: `Bab Baru ${newIdx + 1}`,
        isi_bab: '<p>Tulis konten bab baru di sini...</p>'
    });

    activeChapterIndex = newIdx;
    renderChaptersList();
    selectChapter(newIdx);
    serializeChapters();
});

// Delete chapter
function deleteChapter(index) {
    chapters.splice(index, 1);
    
    // Recalculate nomor_bab
    chapters.forEach((chap, i) => {
        chap.nomor_bab = i + 1;
    });

    if (chapters.length === 0) {
        activeChapterIndex = -1;
        document.getElementById('active_chapter_title_input').value = '';
        if (quill) quill.root.innerHTML = '';
        document.getElementById('dashboard_editor_box').style.display = 'none';
    } else {
        // Adjust active index
        if (activeChapterIndex >= chapters.length) {
            activeChapterIndex = chapters.length - 1;
        }
        selectChapter(activeChapterIndex);
    }
    renderChaptersList();
    serializeChapters();
}

// Rename chapter title input handler
document.getElementById('active_chapter_title_input').addEventListener('input', function() {
    if (activeChapterIndex >= 0 && activeChapterIndex < chapters.length) {
        chapters[activeChapterIndex].judul_bab = this.value;
        
        // Live update the title in the left sidebar card
        const cards = document.querySelectorAll('.editor-chapter-card');
        if (cards[activeChapterIndex]) {
            cards[activeChapterIndex].querySelector('.chap-title').innerText = this.value || 'Bab Tanpa Judul';
        }
        serializeChapters();
    }
});

// Insert Page Break marker in Quill
document.getElementById('btn_insert_page_break').addEventListener('click', () => {
    if (!quill) return;
    
    const range = quill.getSelection();
    if (range) {
        // Insert custom hr element with page-break class
        quill.clipboard.dangerouslyPasteHTML(range.index, '<hr class="page-break" />');
        quill.setSelection(range.index + 1);
    } else {
        quill.clipboard.dangerouslyPasteHTML(quill.getLength(), '<hr class="page-break" />');
    }
});

// Serialize chapters to hidden input for submission
function serializeChapters() {
    // Map list for final form submit
    const serialized = chapters.map((chap, idx) => {
        return {
            nomor_bab: idx + 1,
            judul_bab: chap.judul_bab || `Bab ${idx + 1}`,
            isi_bab: chap.isi_bab || ''
        };
    });
    document.getElementById('chapters_payload').value = JSON.stringify(serialized);
}

// Submit validation
document.querySelector('form').addEventListener('submit', function(e) {
    if (document.getElementById('jenis_koleksi').value === 'ebook' && document.getElementById('mode_baca').checked) {
        // Save current active chapter
        if (activeChapterIndex >= 0 && activeChapterIndex < chapters.length && quill) {
            chapters[activeChapterIndex].isi_bab = quill.root.innerHTML;
            chapters[activeChapterIndex].judul_bab = document.getElementById('active_chapter_title_input').value.trim() || `Bab ${activeChapterIndex + 1}`;
        }
        serializeChapters();
        
        if (chapters.length === 0) {
            alert('Silakan upload PDF atau buat setidaknya satu bab terlebih dahulu.');
            e.preventDefault();
            return false;
        }
    }
});

// Escaping helper
function escHtml(str) {
    if (!str) return '';
    return str.replace(/&/g, '&amp;')
              .replace(/</g, '&lt;')
              .replace(/>/g, '&gt;')
              .replace(/"/g, '&quot;')
              .replace(/'/g, '&#039;');
}

// Helper functions for custom language dropdown
function toggleCustomLanguageInput(selectEl, containerId, inputId) {
    const container = document.getElementById(containerId);
    const input = document.getElementById(inputId);
    if (selectEl.value === 'Lainnya') {
        container.style.display = 'block';
        input.setAttribute('required', 'required');
        input.value = '';
        input.focus();
    } else {
        container.style.display = 'none';
        input.removeAttribute('required');
    }
}

function handleCustomLanguageInput(inputEl, selectId) {
    const select = document.getElementById(selectId);
    const options = select.options;
    // Find the 'Lainnya' option and set its value to input value
    for (let i = 0; i < options.length; i++) {
        if (options[i].text === 'Lainnya...') {
            options[i].value = inputEl.value;
        }
    }
}
</script>

<?= $this->include('layout/footer'); ?>