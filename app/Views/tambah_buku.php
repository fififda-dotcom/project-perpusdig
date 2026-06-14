<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<style>
.form-box{
background:white;
padding:35px;
border-radius:24px;
box-shadow:0 8px 18px rgba(0,0,0,0.06);
width:550px;
}

input{
width:100%;
padding:15px;
margin-bottom:18px;
border:1px solid #ddd;
border-radius:14px;
font-size:16px;
}

.form-box button{
background:#E69C62;
color:white;
padding:14px 24px;
border:none;
border-radius:18px;
font-weight:bold;
cursor:pointer;
}
</style>

<h1>Tambah Buku</h1>

<div class="form-box">
<form action="/buku/simpan" method="post" enctype="multipart/form-data">

<input type="text" name="judul" placeholder="Judul Buku" required>
<input type="text" name="penulis" placeholder="Nama Penulis" required>
<input type="text" name="penerbit" placeholder="Nama Penerbit" required>
<input type="number" name="tahun" placeholder="Tahun Terbit" required>
<input type="number" name="stok" placeholder="Jumlah Stok" required>
<div class="form-group">
<label>Cover Buku</label>

<input
type="file"
name="cover"
accept="image/*">

</div>

<button type="submit"
onclick="return confirm('Buku baru siap masuk ke rak PawLib. Simpan sekarang?')">
Simpan Buku
</button>

</form>
</div>

<?= $this->include('layout/footer'); ?>