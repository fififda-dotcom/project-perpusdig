<?php
$conn = new mysqli('localhost', 'root', '', 'db_pawlib', 3306);
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// 1. Disable FK checks
$conn->query("SET FOREIGN_KEY_CHECKS = 0;");

// 2. Drop old rak table
$conn->query("DROP TABLE IF EXISTS `rak`;");

// 3. Create new ddc rak table
$createTableQuery = "CREATE TABLE `rak` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `kode_ddc` VARCHAR(10) NOT NULL UNIQUE,
  `nama_rak` VARCHAR(100) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($createTableQuery) === TRUE) {
    echo "Table 'rak' created successfully.\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// 4. Seed DDC categories
$seedQuery = "INSERT INTO `rak` (`kode_ddc`, `nama_rak`) VALUES
('000', 'Karya Umum, Komputer, Informasi'),
('100', 'Filsafat dan Psikologi'),
('200', 'Agama'),
('300', 'Ilmu Sosial'),
('400', 'Bahasa'),
('500', 'Ilmu Pengetahuan Alam'),
('600', 'Teknologi'),
('700', 'Seni dan Rekreasi'),
('800', 'Sastra'),
('900', 'Sejarah dan Geografi');";

if ($conn->query($seedQuery) === TRUE) {
    echo "DDC categories seeded successfully.\n";
} else {
    echo "Error seeding DDC: " . $conn->error . "\n";
}

// 5. Re-enable FK checks
$conn->query("SET FOREIGN_KEY_CHECKS = 1;");

echo "All database changes completed successfully!";
$conn->close();
?>
