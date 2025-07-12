<?php
require_once '../config/config.php';
require_once '../config/database.php';

// Password yang ingin digunakan
$newPassword = 'admin123';

// Hash password
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Tampilkan password dan hash
echo "Password baru: $newPassword<br>";
echo "Hash: $hashedPassword<br>";

// Update di database
$db = new Database();
$db->query('UPDATE users SET password = :password WHERE username = :username');
$db->bind(':password', $hashedPassword);
$db->bind(':username', 'admin');

if($db->execute()) {
    echo "Password admin berhasil diupdate!";
} else {
    echo "Gagal update password!";
}
?> 