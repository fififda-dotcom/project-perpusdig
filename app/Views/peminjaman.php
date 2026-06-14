<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<style>

h1 {
    font-size: 32px;
    color: #2E2118;
    margin-top: 0px !important; 
    margin-bottom: 25px !important;
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

.status-pinjam{
background:#FFF3CD;
color:#856404;
padding:8px 14px;
border-radius:12px;
font-size:14px;
font-weight:bold;
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

<h1>Peminjaman Buku 📖</h1>

<a href="/peminjaman/tambah" class="btn-tambah">
+ Tambah Peminjaman
</a>

<table>

<tr>
<th>ID</th>
<th>Anggota</th>
<th>Buku</th>
<th>Tanggal Pinjam</th>
<th>Tanggal Kembali</th>
<th>Status</th>
<th>Aksi</th>
</tr>

<?php foreach($peminjaman as $p): ?>

<tr>
<td><?= $p['id'] ?></td>
<td><?= $p['anggota_id'] ?></td>
<td><?= $p['buku_id'] ?></td>
<td><?= $p['tanggal_pinjam'] ?></td>
<td><?= $p['tanggal_kembali'] ?></td>

<td>
<span class="status-pinjam">
<?= $p['status'] ?>
</span>
</td>

<td>

<a href="/peminjaman/detail/<?= $p['id'] ?>" class="btn-edit">
Lihat
</a>

<a href="/peminjaman/hapus/<?= $p['id'] ?>"
class="btn-hapus"
onclick="return confirm('Yakin ingin menghapus data peminjaman ini?')">
Hapus
</a>

</td>
</tr>

<?php endforeach; ?>

</table>

<?= $this->include('layout/footer'); ?>