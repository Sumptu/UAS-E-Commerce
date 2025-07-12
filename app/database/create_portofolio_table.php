<?php
// Script untuk membuat tabel portofolio dan mengisi data sampel

// Load konfigurasi database
require_once '../config/config.php';
require_once '../config/database.php';

// Inisialisasi koneksi database
$db = new Database();

// Pastikan tabel portofolio ada
$db->query("SHOW TABLES LIKE 'portofolio'");
$tableExists = $db->rowCount() > 0;

if (!$tableExists) {
    // Buat tabel jika belum ada
    $db->query("
        CREATE TABLE IF NOT EXISTS portofolio (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            judul VARCHAR(100) NOT NULL,
            deskripsi TEXT,
            foto VARCHAR(255) NOT NULL,
            tanggal DATE,
            kategori ENUM('prewedding', 'wedding', 'engagement', 'family', 'other') DEFAULT 'prewedding',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");
    $db->execute();
    echo "Tabel portofolio berhasil dibuat.<br>";
}

// Cek apakah portofolio sudah ada
$db->query("SELECT COUNT(*) as count FROM portofolio");
$result = $db->single();

if ($result->count > 0) {
    echo "Portofolio sudah ada di database. Jumlah: " . $result->count;
} else {
    // Buat direktori uploads jika belum ada
    $uploadDir = '../public/uploads/portofolio/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
        echo "Direktori uploads/portofolio berhasil dibuat.<br>";
    }
    
    // Fungsi untuk membuat gambar dengan teks
    function createImageWithText($width, $height, $text, $filename) {
        // Buat gambar baru
        $image = imagecreatetruecolor($width, $height);
        
        // Warna untuk background dan teks
        $bgColor = imagecolorallocate($image, rand(50, 200), rand(50, 200), rand(50, 200));
        $textColor = imagecolorallocate($image, 255, 255, 255);
        
        // Isi background
        imagefill($image, 0, 0, $bgColor);
        
        // Tambahkan teks
        $fontSize = 5;
        $textWidth = imagefontwidth($fontSize) * strlen($text);
        $textHeight = imagefontheight($fontSize);
        
        // Posisikan teks di tengah
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2;
        
        // Gambar teks
        imagestring($image, $fontSize, $x, $y, $text, $textColor);
        
        // Simpan gambar
        imagejpeg($image, $filename, 90);
        
        // Bebaskan memori
        imagedestroy($image);
        
        return true;
    }
    
    // Data sampel portofolio
    $sampleData = [
        [
            'judul' => 'Prewedding Andi & Sari',
            'deskripsi' => 'Sesi foto prewedding di Pantai Kuta Bali dengan konsep romantis',
            'foto' => 'prewedding1.jpg',
            'tanggal' => '2023-05-15',
            'kategori' => 'prewedding'
        ],
        [
            'judul' => 'Wedding Ceremony Budi & Lina',
            'deskripsi' => 'Dokumentasi pernikahan dengan adat Jawa di Yogyakarta',
            'foto' => 'wedding1.jpg',
            'tanggal' => '2023-06-20',
            'kategori' => 'wedding'
        ],
        [
            'judul' => 'Engagement Rudi & Diana',
            'deskripsi' => 'Acara pertunangan dengan tema garden party',
            'foto' => 'engagement1.jpg',
            'tanggal' => '2023-07-10',
            'kategori' => 'engagement'
        ],
        [
            'judul' => 'Family Photo Keluarga Hartono',
            'deskripsi' => 'Sesi foto keluarga dengan konsep kasual di studio',
            'foto' => 'family1.jpg',
            'tanggal' => '2023-08-05',
            'kategori' => 'family'
        ],
        [
            'judul' => 'Prewedding Deni & Ratna',
            'deskripsi' => 'Sesi foto prewedding di Gunung Bromo dengan konsep adventure',
            'foto' => 'prewedding2.jpg',
            'tanggal' => '2023-09-12',
            'kategori' => 'prewedding'
        ],
        [
            'judul' => 'Wedding Reception Agus & Maya',
            'deskripsi' => 'Dokumentasi resepsi pernikahan dengan tema modern minimalis',
            'foto' => 'wedding2.jpg',
            'tanggal' => '2023-10-25',
            'kategori' => 'wedding'
        ]
    ];
    
    // Buat gambar sampel
    foreach ($sampleData as $data) {
        $filename = $data['foto'];
        $fullPath = $uploadDir . $filename;
        
        if (createImageWithText(800, 600, $data['kategori'], $fullPath)) {
            echo "Berhasil membuat gambar: $filename<br>";
        } else {
            echo "Gagal membuat gambar: $filename<br>";
        }
    }
    
    // Tambahkan data ke database
    foreach ($sampleData as $data) {
        $db->query("INSERT INTO portofolio (judul, deskripsi, foto, tanggal, kategori) VALUES (:judul, :deskripsi, :foto, :tanggal, :kategori)");
        $db->bind(':judul', $data['judul']);
        $db->bind(':deskripsi', $data['deskripsi']);
        $db->bind(':foto', $data['foto']);
        $db->bind(':tanggal', $data['tanggal']);
        $db->bind(':kategori', $data['kategori']);
        $db->execute();
    }
    
    echo "<br>6 data portofolio sampel berhasil ditambahkan.";
}

echo "<br><br><a href='../public/admin/portofolio'>Kembali ke halaman portofolio</a>";
?> 