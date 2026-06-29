<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

// Mock the global server/request variables for a POST update request
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
$_SERVER['REQUEST_URI'] = '/buku/update/34';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = FCPATH . 'index.php';
$_SERVER['HTTP_HOST'] = 'localhost:8080';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

$_POST = [
    'judul' => 'Mocked Book Title',
    'penulis' => 'Mocked Author',
    'jenis_koleksi' => 'fisik',
    'stok' => '1',
    'rak_id' => '1',
];

require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';

// Enable error reporting to CLI
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Run CodeIgniter
exit(CodeIgniter\Boot::bootWeb($paths));
