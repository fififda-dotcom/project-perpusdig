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
    <a href="/"><i class="fa fa-home"></i> Home</a>
    <a href="/katalog"><i class="fa fa-book-open"></i> Katalog Buku</a>
    <a href="/buku"><i class="fa fa-gear"></i> Kelola Buku</a>
    <a href="/anggota"><i class="fa fa-users"></i> Anggota</a>
    <a href="/peminjaman"><i class="fa fa-book-reader"></i> Peminjaman</a>
    <a href="/pengembalian"><i class="fas fa-arrow-rotate-left"></i></i> Pengembalian</a>
    <a href="/riwayat"><i class="fas fa-file-alt"></i></i> Riwayat</a>
    <a href="/denda"><i class="fa fa-money-bill-wave"></i> Denda</a>
    <a href="/admin"><i class="fa fa-user-shield"></i> Admin</a>
</div>