<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<style>

h1{
    font-size:32px;
    color:#2E2118;
    margin-top: 0px !important; 
    margin-bottom: 25px !important;
}

table{
    width:100%;
    background:white;
    border-radius:20px;
    overflow:hidden;
    border-collapse:collapse;
    box-shadow:0 8px 18px rgba(0,0,0,0.06);
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

.btn-kembali{
    background:#E69C62;
    color:white;
    padding:10px 18px;
    border-radius:12px;
    text-decoration:none;
    font-weight:bold;
}

.btn-kembali:hover{
    opacity:0.9;
}

.table-container{
    width:100%;
    overflow-x:auto;
}

</style>

<h1>Pengembalian Buku</h1>

<div class="table-container">

<table>

<tr>

<th>ID</th>
<th>Nama</th>
<th>Judul Buku</th>
<th>Tanggal Pinjam</th>
<th>Batas Kembali</th>
<th>Aksi</th>

</tr>

<?php foreach($pengembalian as $p): ?>

<tr>

<td><?= $p['id'] ?></td>

<td><?= $p['nama'] ?></td>

<td><?= $p['judul'] ?></td>

<td><?= $p['tanggal_pinjam'] ?></td>

<td><?= $p['tanggal_kembali'] ?></td>

<td>

<a
href="/pengembalian/kembalikan/<?= $p['id'] ?>"
class="btn-kembali"
onclick="return confirm('Yakin buku ini sudah dikembalikan?')">

Kembalikan

</a>

</td>

</tr>

<?php endforeach; ?>

</table>

</div>

<?= $this->include('layout/footer'); ?>