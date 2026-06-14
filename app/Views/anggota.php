<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<style>

h1 {
    font-size: 32px;
    color: #2E2118;
    margin-top: 10px !important; 
    margin-bottom: 20px !important;
}

.content {
    padding-top: 15px !important;
    min-height: auto !important; 
}
table{
width:100%;
background:white;
border-radius:20px;
overflow:hidden;
box-shadow:0 8px 18px rgba(0,0,0,0.06);
border-collapse:collapse;
}

th,td{
padding:18px;
text-align:left;
}

th{
background:#FBE7D4;
}

tr{
border-bottom:1px solid #eee;
}

.btn-tambah{
display:inline-block;
background:#E69C62;
color:white;
padding:14px 24px;
border-radius:18px;
text-decoration:none;
font-weight:bold;
margin-bottom:20px;
}

.btn-edit{
background:#4A90E2;
color:white;
padding:10px 16px;
border-radius:12px;
text-decoration:none;
}

.btn-hapus{
background:#E74C3C;
color:white;
padding:10px 16px;
border-radius:12px;
text-decoration:none;
margin-left:8px;
}
</style>

<h1>Anggota PawLib 🐾</h1>

<a href="/anggota/tambah" class="btn-tambah">+ Tambah Anggota</a>

<table>
<tr>
<th>Kode</th>
<th>ID</th>
<th>Nama</th>
<th>No. HP</th>
<th>Alamat Gmail</th>
<th>Aksi</th>
</tr>

<?php foreach($anggota as $a): ?>
<tr>
<td><?= $a['kode_anggota'] ?></td>
<td><?= $a['id'] ?></td>
<td><?= $a['nama'] ?></td>
<td><?= $a['nomor'] ?></td>
<td><?= $a['gmail'] ?></td>
<td>
<a href="/anggota/edit/<?= $a['id'] ?>" class="btn-edit">Edit</a>

<a href="/anggota/hapus/<?= $a['id'] ?>" 
class="btn-hapus"
onclick="return confirm('🐾 Anggota ini akan keluar dari PawLib. Tetap hapus?')">
Hapus
</a>

</td>
</tr>
<?php endforeach; ?>

</table>

<?= $this->include('layout/footer'); ?>