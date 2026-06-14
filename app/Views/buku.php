<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>

<style>

h1 {
    font-size: 32px;
    color: #2E2118;
    margin-top: 10px !important; 
    margin-bottom: 30px !important;
}

.content {
    padding-top: 15px !important;
    padding-bottom: 15px !important;
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
margin-bottom:25px;
}
.btn-edit{
background:#4A90E2;
color:white;
padding:10px 16px;
border-radius:12px;
text-decoration:none;
font-size:14px;
}
.btn-hapus{
background:#E74C3C;
color:white;
padding:10px 16px;
border-radius:12px;
text-decoration:none;
font-size:14px;
margin-left:8px;
}

.table-container {
    width: 100%;
    overflow-x: auto;
    margin-bottom: 30px;
}
td:last-child{
min-width:170px;
}

.aksi{
display:flex;
gap:8px;
justify-content:center;
}

th:last-child,
td:last-child{
text-align:center;
white-space:nowrap;
width:160px;
}

</style>

<h1>Koleksi Buku</h1>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:15px;">

    <a href="/buku/tambah" class="btn-tambah">+ Tambah Buku</a>

    <form action="/buku" method="get" style="display:flex;gap:10px;align-items:center;">

        <input
        type="text"
        name="keyword"
        placeholder="Cari judul atau penulis..."
        value="<?= $keyword ?? '' ?>"
        style="padding:12px;width:300px;border:1px solid #ddd;border-radius:10px;">

        <button
        type="submit"
        style="padding:12px 20px;background:#E69C62;color:white;border:none;border-radius:10px;cursor:pointer;">

        🔍 Cari

        </button>

        <a
        href="/buku"
        style="padding:12px 20px;background:#999;color:white;text-decoration:none;border-radius:10px;">

        Reset

        </a>

    </form>

</div>

<div class="table-container">
    <table>
    <tr>
    <th>Kode Buku</th>
    <th>ID</th>
    <th>Judul</th>
    <th>Penulis</th>
    <th>Penerbit</th>
    <th>Tahun</th>
    <th>Stok</th>
    <th>Aksi</th>
    </tr>

    <?php foreach($buku as $b): ?>
    <tr>
    <td><?= $b['kode_buku'] ?></td>
    <td><?= $b['id'] ?></td>
    <td><?= $b['judul'] ?></td>
    <td><?= $b['penulis'] ?></td>
    <td><?= $b['penerbit'] ?></td>
    <td><?= $b['tahun'] ?></td>
    <td><?= $b['stok'] ?></td>
    <td>
    <td>
<div class="aksi">

<a href="/buku/edit/<?= $b['id'] ?>" class="btn-edit">
Edit
</a>

<a href="/buku/hapus/<?= $b['id'] ?>"
class="btn-hapus"
onclick="return confirm('Buku ini akan meninggalkan rak hangat PawLib. Tetap hapus?')">
Hapus
</a>

</div>
</td>
    </a>
    </td>
    </tr>
    <?php endforeach; ?>

    </table>
</div>

<?= $this->include('layout/footer'); ?>