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
$routes->get('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');

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
$routes->get('/denda', 'Denda::index');
$routes->get('/denda/tambah', 'Denda::tambah');
$routes->post('/denda/simpan', 'Denda::simpan');
$routes->get('/denda/generate', 'Denda::generate');
$routes->get('/pengembalian', 'Pengembalian::index');
$routes->get('/pengembalian/kembalikan/(:num)', 'Peminjaman::kembalikan/$1');

$routes->get('/riwayat', 'Riwayat::index');
});