<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<style>
h1 {
    font-size: 32px;
    margin-top: 0px !important; 
    margin-bottom: 20px !important;
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

.foto-buku{
width:70px;
height:90px;
object-fit:cover;
border-radius:10px;
}

.btn-pinjam{
background:#E69C62;
color:white;
padding:10px 20px;
border-radius:12px;
text-decoration:none;
font-weight:bold;
}
</style>

<h1>Katalog Buku PawLib</h1>

<form action="/katalog" method="get" style="margin-bottom:25px;">

<input type="text"
name="keyword"
placeholder="Cari judul atau penulis..."
value="<?= $keyword ?? '' ?>"
style="padding:12px;width:320px;border-radius:12px;border:1px solid #ddd;">

<button type="submit"
style="padding:12px 20px;background:#E69C62;color:white;border:none;border-radius:12px;cursor:pointer;">

🔍 Cari

</button>

<a href="/katalog"
style="padding:12px 20px;background:#999;color:white;text-decoration:none;border-radius:12px;margin-left:10px;">

Reset

</a>

</form>

<table>

<tr>
<th></th>
<th>Judul Buku</th>
<th>Penulis</th>
<th>Penerbit</th>
<th>Tahun</th>
<th>Stok</th>
<th>Aksi</th>
</tr>

<?php foreach($buku as $b): ?>

<tr>

<td>
<?php if(!empty($b['foto'])): ?>
<img src="/uploads/<?= $b['foto']; ?>" class="foto-buku">
<?php else: ?>
📖
<?php endif; ?>
</td>

<td><?= $b['judul']; ?></td>
<td><?= $b['penulis']; ?></td>
<td><?= $b['penerbit']; ?></td>
<td><?= $b['tahun']; ?></td>
<td><?= $b['stok']; ?></td>

<td>
<a href="/peminjaman/tambah/<?= $b['id'] ?>" class="btn-pinjam">
Pinjam 
</a>
</td>

</tr>

<?php endforeach; ?>

<?php if($b['stok']>0): ?>

<?php else: ?>

<button disabled>
Stok Habis
</button>

<?php endif; ?>

</table>

<?= $this->include('layout/footer'); ?>