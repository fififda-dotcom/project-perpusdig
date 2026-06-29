<?php
$db = mysqli_connect('localhost', 'root', '', 'db_pawlib');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error() . "\n");
}

$result = mysqli_query($db, "SELECT * FROM buku WHERE id = 45");
$book = mysqli_fetch_assoc($result);

echo "Book 45 details:\n";
print_r($book);
?>
