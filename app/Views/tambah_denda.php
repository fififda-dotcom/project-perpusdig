<?= $this->include('layout/header'); ?>
<?= $this->include('layout/sidebar'); ?>

<h1>Tambah Denda</h1>

<form action="/denda/simpan" method="post">

<input type="text" name="nama" placeholder="Nama">
<input type="text" name="peminjaman_id" placeholder="ID Peminjaman">
<input type="text" name="buku_id" placeholder="ID Buku">
<input type="number" name="jumlah_hari_telat" placeholder="Hari Telat">

<button type="submit">Simpan</button>

</form>

<?= $this->include('layout/footer'); ?>