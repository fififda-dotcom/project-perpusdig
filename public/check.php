<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
$db = mysqli_connect('localhost', 'root', '', 'db_pawlib');
if (!$db) {
    die('Connection failed: ' . mysqli_connect_error());
}
$result = mysqli_query($db, 'SELECT id, judul FROM buku');
$books = [];
while ($row = mysqli_fetch_assoc($result)) {
    $books[] = $row;
}
echo "Total Books: " . count($books) . "\n";
print_r($books);
