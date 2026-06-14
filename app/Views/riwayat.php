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
border-collapse:collapse;
box-shadow:0 8px 18px rgba(0,0,0,.06);
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

.status{
padding:8px 14px;
border-radius:10px;
font-weight:bold;
}

.pinjam{
background:#FFF3CD;
color:#856404;
}

.kembali{
background:#D4EDDA;
color:#155724;
}

</style>

<h1>Riwayat Peminjaman </h1>

<table>

<tr>
<th>ID</th>
<th>Nama</th>
<th>Buku</th>
<th>Tanggal Pinjam</th>
<th>Batas Kembali</th>
<th>Tanggal Dikembalikan</th>
<th>Status</th>
</tr>

<?php foreach($riwayat as $r): ?>

<tr>

<td><?= $r['id'] ?></td>

<td><?= $r['nama'] ?></td>

<td><?= $r['judul'] ?></td>

<td><?= $r['tanggal_pinjam'] ?></td>

<td><?= $r['tanggal_kembali'] ?></td>

<td><?= $r['tanggal_dikembalikan'] ?></td>

<td>

<?php if($r['status']=="Dipinjam"): ?>

<span class="status pinjam">
Dipinjam
</span>

<?php else: ?>

<span class="status kembali">
Dikembalikan
</span>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</table>

<?= $this->include('layout/footer'); ?>