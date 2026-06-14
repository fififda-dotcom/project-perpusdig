<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<div class="hero-box">
    <h1>Welcome to PawLib 🐾</h1>
    <p>Temukan buku favoritmu dan nikmati pengalaman membaca yang hangat bersama PawLib</p>
</div>

<style>
.hero-box{
background:linear-gradient(135deg,#F8F2E8,#FBE7D4);
padding:45px;
border-radius:28px;
box-shadow:0 10px 24px rgba(0,0,0,0.06);
margin-bottom:50px;
position:relative;
overflow:hidden;
}

.hero-box::after{
content:"🐾";
position:absolute;
right:35px;
top:20px;
font-size:70px;
opacity:.15;
}

.hero-box h1{
font-size:58px;
margin:0;
color:#2E2118;
font-weight:bold;
}

.hero-box p{
font-size:18px;
color:#756456;
margin-top:14px;
}


.cards{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:28px;
margin-top:30px;
}

.book{
background:#fff;
padding:28px;
border-radius:24px;
box-shadow:0 8px 18px rgba(0,0,0,0.06);
text-align:center;
transition:0.3s;
}

.book:hover{
transform:translateY(-8px);
}

.cover{
font-size:70px;
margin-bottom:15px;
}

.title{
font-size:18px;
font-weight:bold;
line-height:1.3;
margin-bottom:10px;
}

.author{
font-size:15px;
color:#777;
margin-bottom:18px;
}

.btn{
background:#E69C62;
color:white;
padding:14px 34px;
border:none;
border-radius:30px;
font-size:17px;
font-weight:bold;
cursor:pointer;
}
</style>

<h2>📚 Recommended Books</h2>

<div class="cards">

<?php foreach($rekomendasi as $b): ?>

<div class="book">

<div class="cover">📚🐾</div>

<div class="title">
<?= $b['judul'] ?>
</div>

<div class="author">
<?= $b['penulis'] ?>
</div>

<a href="/katalog" class="btn" style="display:inline-block;text-decoration:none;">
🐾 Explore
</a>

</div>

<?php endforeach; ?>


</div>

<h2 style="margin-top:50px;">📊 Library Stats</h2>

<div class="cards">

<div class="book">
<div class="cover">📚</div>
<div class="title"><?= $totalBuku ?></div>
<div class="author">Total Koleksi</div>
</div>

<div class="book">
<div class="cover">👥</div>
<div class="title"><?= $totalAnggota ?></div>
<div class="author">Anggota PawLib</div>
</div>

<div class="book">
<div class="cover">📖</div>
<div class="title"><?= $totalDipinjam ?></div>
<div class="author">Sedang Dipinjam</div>
</div>

</div>

<?= $this->include('layout/footer'); ?>