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

/* DIUBAH: Ditambah .form-box biar input di sidebar/navbar gak ikut berubah */
.form-box input{
width:100%;
padding:15px;
margin-bottom:18px;
border:1px solid #ddd;
border-radius:14px;
}

/* DIUBAH: Ditambah .form-box biar gak nabrak sama tombol garis 3 */
.form-box button{
background:#4A90E2;
color:white;
padding:14px 24px;
border:none;
border-radius:18px;
cursor:pointer;
}
</style>

<h1>Edit Buku</h1>

<div class="form-box">
<form action="/buku/update/<?= $buku['id'] ?>" method="post">

<input type="text" name="judul" value="<?= $buku['judul'] ?>" required>

<input type="text" name="penulis" value="<?= $buku['penulis'] ?>" required>

<input type="text" name="penerbit" value="<?= $buku['penerbit'] ?>" required>

<input type="number" name="tahun" value="<?= $buku['tahun'] ?>" required>

<input type="number" name="stok" value="<?= $buku['stok'] ?>" required>

<button type="submit"
onclick="return confirm('Rak PawLib siap diperbarui. Simpan perubahan?')">
Update Buku
</button>
</form>
</div>

<?= $this->include('layout/footer'); ?>