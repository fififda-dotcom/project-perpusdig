<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<div style="
background:white;
padding:30px;
border-radius:20px;
box-shadow:0 8px 18px rgba(0,0,0,.06);
max-width:700px;">

<h2>Detail Peminjaman</h2>

<p><b>Nama Peminjam :</b> <?= $pinjam['nama'] ?></p>

<p><b>Judul Buku :</b> <?= $pinjam['judul'] ?></p>

<p><b>Tanggal Pinjam :</b> <?= $pinjam['tanggal_pinjam'] ?></p>

<p><b>Batas Pengembalian :</b> <?= $pinjam['tanggal_kembali'] ?></p>

<p><b>Status :</b> <?= $pinjam['status'] ?></p>

<?php if(!empty($pinjam['tanggal_dikembalikan'])): ?>

<p><b>Tanggal Dikembalikan :</b> <?= $pinjam['tanggal_dikembalikan'] ?></p>

<?php endif; ?>

<a href="/peminjaman"
style="
display:inline-block;
margin-top:20px;
background:#E69C62;
color:white;
padding:12px 20px;
border-radius:10px;
text-decoration:none;">

Kembali

</a>

</div>

<?= $this->include('layout/footer'); ?>

