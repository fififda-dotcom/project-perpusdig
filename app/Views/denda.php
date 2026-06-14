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
border-collapse:collapse;
border-radius:20px;
overflow:hidden;
box-shadow:0 8px 18px rgba(0,0,0,0.06);
}

th,td{
padding:15px;
text-align:left;
}

th{
background:#FBE7D4;
}

tr{
border-bottom:1px solid #eee;
}

</style>

<h1>Data Denda</h1>

<table>

<tr>

<th>Nama</th>
<th>Judul Buku</th>
<th>Tanggal Kembali</th>
<th>Terlambat</th>
<th>Total Denda</th>

</tr>

<?php foreach($denda as $d): ?>

<?php

$hari = floor(
(strtotime(date('Y-m-d')) - strtotime($d['tanggal_kembali'])) / 86400
);

if($hari < 0){
    $hari = 0;
}

$total = $hari * 2000;

?>

<tr>

<td><?= $d['nama'] ?></td>

<td><?= $d['judul'] ?></td>

<td><?= $d['tanggal_kembali'] ?></td>

<td><?= $hari ?> Hari</td>

<td>Rp <?= number_format($total,0,',','.') ?></td>

</tr>

<?php endforeach; ?>

</table>

<?= $this->include('layout/footer'); ?>