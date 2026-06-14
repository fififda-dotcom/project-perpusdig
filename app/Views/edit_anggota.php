<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<style>

h1{
    margin-top:0px;
    margin-bottom:20px;
}

.form-box{
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 8px 18px rgba(0,0,0,.08);
    width:600px;
    max-width:100%;
}

.form-group{
    margin-bottom:20px;
}

label{
    display:block;
    font-weight:bold;
    margin-bottom:8px;
}

input{
    width:100%;
    padding:14px;
    border:1px solid #ddd;
    border-radius:12px;
    font-size:16px;
}

input:focus{
    outline:none;
    border-color:#E69C62;
}

.btn{
    background:#E69C62;
    color:white;
    padding:13px 26px;
    border:none;
    border-radius:12px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
}

.btn:hover{
    opacity:.9;
}

</style>

<h1>Edit Anggota</h1>

<div class="form-box">

<form action="/anggota/update/<?= $anggota['id'] ?>" method="post">

<div class="form-group">
<label>Nama</label>
<input
type="text"
name="nama"
value="<?= $anggota['nama'] ?>"
required>
</div>

<div class="form-group">
<label>No. HP</label>
<input
type="text"
name="nomor"
value="<?= $anggota['nomor'] ?>"
required>
</div>

<div class="form-group">
<label>Alamat Gmail</label>
<input
type="email"
name="gmail"
value="<?= $anggota['gmail'] ?>"
required>
</div>

<button type="submit" class="btn">
Simpan Perubahan
</button>

</form>

</div>

<?= $this->include('layout/footer'); ?>
