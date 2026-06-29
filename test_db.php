<?php
$conn = @new mysqli('127.0.0.1', 'root', '', 'db_pawlib');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n");
}

$tables = ['anggota', 'buku', 'rak', 'denda', 'peminjaman'];

foreach ($tables as $table) {
    echo "Testing table '$table': ";
    $res = $conn->query("SELECT COUNT(*) as count FROM `$table`");
    if ($res) {
        $row = $res->fetch_assoc();
        echo "SUCCESS - Count: " . $row['count'] . "\n";
    } else {
        echo "FAIL - Error: " . $conn->error . "\n";
    }
}

$conn->close();
