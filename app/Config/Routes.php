<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/buku', 'Buku::index');
$routes->get('/peminjaman', 'Peminjaman::index');
$routes->get('/pengembalian', 'Pengembalian::index');
$routes->get('/denda', 'Denda::index');
$routes->get('/admin', 'Admin::index');
$routes->get('/anggota', 'Anggota::index');
$routes->get('/rak', 'Rak::index');
$routes->get('/rak/detail/(:num)', 'Rak::detail/$1'); // ROUTE DETAIL RAK DDC BARU
$routes->get('/buku/tambah', 'Buku::tambah');
$routes->post('/buku/simpan', 'Buku::simpan');
$routes->get('/buku/hapus/(:num)', 'Buku::hapus/$1');
$routes->get('/buku/edit/(:num)', 'Buku::edit/$1');
$routes->post('/buku/update/(:num)', 'Buku::update/$1');
$routes->get('/anggota', 'Anggota::index');
$routes->get('/anggota/tambah', 'Anggota::tambah');
$routes->post('/anggota/simpan', 'Anggota::simpan');
$routes->get('/anggota/edit/(:num)', 'Anggota::edit/$1');
$routes->post('/anggota/update/(:num)', 'Anggota::update/$1');
$routes->get('/anggota/hapus/(:num)', 'Anggota::hapus/$1');
$routes->get('/anggota/detail/(:num)', 'Anggota::detail/$1'); // ROUTE DETAIL ANGGOTA BARU
$routes->get('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('auth/register', 'Auth::register');
$routes->post('auth/register_process', 'Auth::register_process');

$routes->group('', ['filter' => 'authFilter'], function($routes) {
    
    $routes->get('/', 'Home::index'); 
    $routes->presenter('buku');       
    $routes->presenter('anggota');    
    $routes->get('/peminjaman', 'Peminjaman::index');
    $routes->get('/peminjaman/tambah/(:num)', 'Peminjaman::tambah/$1');
    $routes->get('/peminjaman/tambah', 'Peminjaman::tambah');
    $routes->post('/peminjaman/simpan', 'Peminjaman::simpan');
    $routes->get('/peminjaman/hapus/(:num)', 'Peminjaman::hapus/$1');
    $routes->get('/peminjaman/detail/(:num)', 'Peminjaman::detail/$1');
    $routes->get('/katalog', 'Katalog::index');
    $routes->get('katalog/detail/(:any)', 'Katalog::detail/$1');
    
    $routes->get('/profile', 'Profile::index');
    $routes->post('/profile/update', 'Profile::update');
    $routes->get('/profile/riwayat', 'Profile::riwayat'); 
    $routes->get('/profile/ulasan', 'Profile::ulasan');

    // Rute Baru untuk Pengembalian & Notifikasi
    $routes->get('/peminjaman/ajukan/(:num)', 'Peminjaman::ajukan_pengembalian/$1');
    $routes->get('/notifikasi/baca/(:num)', 'Notifikasi::baca/$1');
    $routes->get('/notifikasi/baca_semua', 'Notifikasi::baca_semua');

    $routes->get('/denda', 'Denda::index');
    $routes->get('/denda/tambah', 'Denda::tambah');
    $routes->post('/denda/simpan', 'Denda::simpan');
    $routes->get('/denda/generate', 'Denda::generate');
    $routes->get('/pengembalian', 'Pengembalian::index');
    $routes->get('/pengembalian/kembalikan/(:num)', 'Peminjaman::kembalikan/$1');
    $routes->get('/riwayat', 'Riwayat::index');

    $routes->get('/favorit', 'Favorit::index');
    $routes->get('/favorit/toggle/(:num)', 'Favorit::toggle/$1');
    $routes->get('/favorit/hapus/(:num)', 'Favorit::hapus/$1');

    $routes->get('/wishlist', 'Wishlist::index');
    $routes->get('/wishlist/tambah/(:num)', 'Wishlist::tambah/$1');
    $routes->get('/wishlist/hapus/(:num)', 'Wishlist::hapus/$1');

    // Rute Visi & Misi PawLib
    $routes->get('/visi', 'Home::visi');
    $routes->get('/misi', 'Home::misi');

    // Rute Ebook Reader PawLib
    $routes->get('/ebook/baca/(:num)', 'Ebook::baca/$1');
    $routes->post('/ebook/update-progress', 'Ebook::updateProgress');
    $routes->get('/ebook/cari-kata', 'Ebook::cariKata');

    // Rute Pengaturan Berita RSS
    $routes->get('/admin/pengaturan_berita', 'Admin::pengaturan_berita');
    $routes->post('/admin/simpan_pengaturan_berita', 'Admin::simpan_pengaturan_berita');

    $routes->post('ulasan/simpan', 'Ulasan::simpan');
    $routes->post('ulasan/simpan_ebook', 'Ulasan::simpan_ebook');
    $routes->get('ulasan/hapus/(:num)', 'Ulasan::hapus/$1');
    $routes->get('admin/ulasan/hapus/(:num)', 'Ulasan::admin_hapus/$1');
    $routes->get('admin/ulasan', 'Ulasan::admin_index');
});