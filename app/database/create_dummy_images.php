<?php
// Script untuk membuat gambar dummy sederhana untuk portofolio

// Direktori untuk menyimpan gambar
$uploadDir = '../public/uploads/portofolio/';

// Pastikan direktori ada
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
    echo "Direktori $uploadDir berhasil dibuat.<br>";
}

// Daftar gambar yang akan dibuat
$images = [
    'prewedding1.jpg',
    'wedding1.jpg',
    'engagement1.jpg',
    'family1.jpg',
    'prewedding2.jpg',
    'wedding2.jpg'
];

// Buat gambar dummy
foreach ($images as $image) {
    $content = "Ini adalah gambar dummy untuk $image";
    file_put_contents($uploadDir . $image, $content);
    echo "File $image berhasil dibuat.<br>";
}

echo "Semua gambar dummy berhasil dibuat.";
?> 