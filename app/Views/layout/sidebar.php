<style>
.sidebar{
width:280px;
height:100vh;
position:fixed;
left:0;
top:0;
background:#f8f7f5;
padding:25px;
overflow-y:auto;
overflow-x:hidden;
}

.sidebar h2{
margin-bottom:35px;
color:#E69C62;
}

.sidebar a{
display:block;
padding:16px 18px;
margin-bottom:10px;
border-radius:18px;
text-decoration:none;
color:#444;
font-size:18px;
font-weight:600;
transition:.3s;
}

.sidebar a i{
width:30px;
margin-right:10px;
}

.sidebar a:hover{
background:#FBE7D4;
color:#E69C62;
}

/* Kustomisasi Dropdown Visi & Misi */
.dropdown-container {
    margin-bottom: 10px;
}
.dropdown-trigger {
    display: flex !important;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
}
.dropdown-arrow {
    font-size: 14px;
    transition: transform 0.3s ease;
    margin-left: auto;
}
.dropdown-menu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), padding 0.3s ease, margin 0.3s ease;
    background: #faf9f7;
    border-radius: 18px;
    margin-left: 10px;
    border: 0 solid #ebd5c5;
}
.dropdown-menu.show {
    max-height: 150px;
    border: 2px solid #ebd5c5;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 5px;
}
.dropdown-item {
    padding: 12px 14px !important;
    font-size: 16px !important;
    margin-bottom: 2px !important;
    margin-top: 2px !important;
    background: transparent !important;
    border-radius: 12px !important;
}
.dropdown-item:hover {
    background: #FBE7D4 !important;
    color: #E69C62 !important;
}
.dropdown-trigger.active .dropdown-arrow {
    transform: rotate(180deg);
}

.sidebar::-webkit-scrollbar{
width:6px;
}

.sidebar::-webkit-scrollbar-thumb{
background:#E69C62;
border-radius:20px;
}

.sidebar::-webkit-scrollbar-track{
background:transparent;
}
</style>

<div class="sidebar">
    <h2><i class="fa-solid fa-cat" style="color:#E69C62;"></i> PawLib</h2>
    
    <!-- Menu Utama -->
    <a href="/"><i class="fa fa-home"></i> Home</a>
    <a href="/katalog"><i class="fa fa-book-open"></i> Katalog Buku</a>
    
    <!-- Menu khusus Anggota -->
    <?php if (session()->get('role') == 'anggota') : ?>
        <a href="/favorit"><i class="fa fa-heart" style="color: #E74C3C;"></i> Buku Favorit </a>
        <a href="/wishlist"><i class="fa fa-star" style="color: #F1C40F;"></i> Wishlist </a>
    <?php endif; ?>

    <!-- Menu Dropdown Visi & Misi (Bisa Diakses Admin & Pengguna/Semua) -->
    <div class="dropdown-container">
        <a href="javascript:void(0);" class="dropdown-trigger">
            <span><i class="fa fa-scroll"></i> Visi & Misi</span>
            <i class="fas fa-chevron-down dropdown-arrow"></i>
        </a>
        <div class="dropdown-menu">
            <a href="/visi" class="dropdown-item"><i class="fas fa-bullseye" style="color: #E69C62;"></i> Visi</a>
            <a href="/misi" class="dropdown-item"><i class="fas fa-rocket" style="color: #E69C62;"></i> Misi</a>
        </div>
    </div>
    
    
    <!-- Menu kelola khusus Admin (Disembunyikan bagi Anggota biasa) -->
    <?php if (session()->get('role') == 'admin') : ?>
        <a href="/buku"><i class="fa fa-gear"></i> Kelola Buku</a>
        <a href="/rak"><i class="fa fa-folder-open"></i> Kelola Rak</a>
        <a href="/anggota"><i class="fa fa-users"></i> Anggota</a>
        <a href="/peminjaman"><i class="fa fa-book-reader"></i> Peminjaman</a>
        <a href="/pengembalian"><i class="fas fa-arrow-rotate-left"></i> Pengembalian</a>
        <a href="/riwayat"><i class="fas fa-file-alt"></i> Riwayat</a>
        <a href="/denda"><i class="fa fa-money-bill-wave"></i> Denda</a>
        <a href="/admin/ulasan"><i class="fas fa-comments"></i> Rating & Ulasan</a>
        <a href="/admin/pengaturan_berita"><i class="fa fa-cog"></i> Pengaturan Berita</a>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const trigger = document.querySelector('.dropdown-trigger');
    const menu = document.querySelector('.dropdown-menu');
    
    // Auto open if current URL matches child links
    const currentPath = window.location.pathname;
    if (currentPath === '/visi' || currentPath === '/misi') {
        trigger.classList.add('active');
        menu.classList.add('show');
    }

    trigger.addEventListener('click', function(e) {
        e.preventDefault();
        this.classList.toggle('active');
        menu.classList.toggle('show');
    });
});
</script>