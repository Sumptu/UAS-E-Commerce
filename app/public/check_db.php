<?php
// Script untuk memeriksa tabel portofolio di database

// Load konfigurasi database
require_once '../config/config.php';
require_once '../config/database.php';

// Inisialisasi koneksi database
$db = new Database();

// Cek koneksi database
echo "<h2>Informasi Database</h2>";
echo "Host: " . DB_HOST . "<br>";
echo "Database: " . DB_NAME . "<br>";
echo "User: " . DB_USER . "<br><br>";

// Cek apakah tabel portofolio ada
$db->query("SHOW TABLES");
$tables = $db->resultSet();

echo "<h3>Daftar Tabel:</h3>";
echo "<ul>";
foreach ($tables as $table) {
    $tableName = reset($table); // Ambil nilai pertama dari objek
    echo "<li>$tableName</li>";
}
echo "</ul>";

// Cek struktur tabel portofolio
$db->query("SHOW TABLES LIKE 'portofolio'");
if ($db->rowCount() > 0) {
    echo "<h3>Struktur Tabel Portofolio:</h3>";
    $db->query("DESCRIBE portofolio");
    $columns = $db->resultSet();
    
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>" . $column->Field . "</td>";
        echo "<td>" . $column->Type . "</td>";
        echo "<td>" . $column->Null . "</td>";
        echo "<td>" . $column->Key . "</td>";
        echo "<td>" . $column->Default . "</td>";
        echo "<td>" . $column->Extra . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Cek data portofolio
    $db->query("SELECT COUNT(*) as count FROM portofolio");
    $result = $db->single();
    echo "<h3>Data Portofolio:</h3>";
    echo "Jumlah data: " . $result->count . "<br>";
    
    if ($result->count > 0) {
        $db->query("SELECT * FROM portofolio");
        $portofolios = $db->resultSet();
        
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Judul</th><th>Kategori</th><th>Foto</th><th>Tanggal</th></tr>";
        foreach ($portofolios as $portofolio) {
            echo "<tr>";
            echo "<td>" . $portofolio->id . "</td>";
            echo "<td>" . $portofolio->judul . "</td>";
            echo "<td>" . $portofolio->kategori . "</td>";
            echo "<td>" . $portofolio->foto . "</td>";
            echo "<td>" . $portofolio->tanggal . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "<h3>Tabel portofolio tidak ditemukan!</h3>";
}

// Cek direktori uploads
echo "<h3>Direktori Uploads:</h3>";
$uploadDir = '../uploads/portofolio/';
if (file_exists($uploadDir)) {
    echo "Direktori uploads/portofolio/ ada.<br>";
    $files = scandir($uploadDir);
    echo "Jumlah file: " . (count($files) - 2) . "<br>"; // Kurangi . dan ..
    
    echo "<ul>";
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "<li>$file</li>";
        }
    }
    echo "</ul>";
} else {
    echo "Direktori uploads/portofolio/ tidak ditemukan!<br>";
}
?> 