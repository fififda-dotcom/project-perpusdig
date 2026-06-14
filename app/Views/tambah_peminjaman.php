<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<style>
    
h1 {
    font-size: 32px;
    margin-top: 0px !important; 
    margin-bottom: 20px !important;
}

.form-box{
background:white;
padding:30px;
border-radius:20px;
box-shadow:0 8px 18px rgba(0,0,0,0.06);
max-width:700px;
}

.form-group{
margin-bottom:20px;
}

label{
display:block;
font-weight:bold;
margin-bottom:8px;
}

input, select{
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:12px;
box-sizing:border-box;
}

.btn-simpan{
background:#E69C62;
color:white;
padding:12px 24px;
border:none;
border-radius:12px;
font-weight:bold;
cursor:pointer;
}

</style>

<h1>📚 Form Peminjaman</h1>

<?php if(session()->getFlashdata('error')): ?>

<div style="
background:#ffe5e5;
color:#c0392b;
padding:15px;
border-radius:12px;
margin-bottom:20px;">

<?= session()->getFlashdata('error') ?>

</div>

<?php endif; ?>

<div class="form-box">

<form action="/peminjaman/simpan" method="post">

<input type="hidden" name="buku_id" value="<?= $buku['id'] ?>">

<div class="form-group">
<label>Buku</label>
<input type="text" value="<?= $buku['judul'] ?>" readonly>
</div>

<div class="form-group">
<label>Nama Peminjam</label>
<input type="text" name="nama" required placeholder="Masukkan nama sesuai data anggota">
</div>

<div class="form-group">
<label>Tanggal Pinjam</label>
<input type="date" name="tanggal_pinjam" required>
</div>

<button type="submit" class="btn-simpan">
Pinjam Buku
</button>

</form>

</div>

<?= $this->include('layout/footer'); ?>

