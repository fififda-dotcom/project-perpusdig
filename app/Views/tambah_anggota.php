<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<style>

h1 {
    font-size: 32px;
    color: #2E2118;
    margin-top: 0px !important; 
    margin-bottom: 20px !important;
}

.form-box{
background:white;
padding:35px;
border-radius:24px;
box-shadow:0 8px 18px rgba(0,0,0,0.06);
width:550px;
}

.form-box input{
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

<h1>Tambah Anggota </h1>

<div class="form-box">
<form action="/anggota/simpan" method="post">

<input type="text" name="nama" placeholder="Masukkan nama lengkap" required>

<input type="text" name="nomor" placeholder="Masukkan nomor HP" required>

<input type="email" name="gmail" placeholder="Masukkan alamat gmail" required>

<button type="submit"
onclick="return confirm('Member baru siap bergabung ke PawLib. Simpan sekarang?')">
Tambah Anggota
</button>

</form>
</div>

<?= $this->include('layout/footer'); ?>