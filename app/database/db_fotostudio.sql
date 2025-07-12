-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS db_fotostudio;

-- Gunakan database
USE db_fotostudio;

-- Tabel users untuk admin dan pelanggan
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telepon VARCHAR(15),
    alamat TEXT,
    role ENUM('admin', 'pelanggan') NOT NULL DEFAULT 'pelanggan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabel paket layanan
CREATE TABLE IF NOT EXISTS paket (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama_paket VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    harga DECIMAL(10,2) NOT NULL,
    durasi VARCHAR(50),
    jumlah_foto INT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabel portofolio
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

-- Tabel pemesanan
CREATE TABLE IF NOT EXISTS pemesanan (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    paket_id INT(11) NOT NULL,
    tanggal_pemesanan DATE NOT NULL,
    tanggal_acara DATE NOT NULL,
    lokasi_acara TEXT,
    catatan TEXT,
    total_harga DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (paket_id) REFERENCES paket(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabel pembayaran
CREATE TABLE IF NOT EXISTS pembayaran (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    pemesanan_id INT(11) NOT NULL,
    jumlah DECIMAL(10,2) NOT NULL,
    metode_pembayaran VARCHAR(50) NOT NULL,
    tanggal_pembayaran DATE NOT NULL,
    bukti_pembayaran VARCHAR(255),
    status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pemesanan_id) REFERENCES pemesanan(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabel galeri hasil foto
CREATE TABLE IF NOT EXISTS galeri (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    pemesanan_id INT(11) NOT NULL,
    judul VARCHAR(100),
    foto VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pemesanan_id) REFERENCES pemesanan(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Insert data admin default
INSERT INTO users (username, password, nama_lengkap, email, telepon, alamat, role) 
VALUES ('admin', '$2y$10$9zQFgUoYwxCpHxKQieB.UeKfKaXWFtU9egS8SYboRQBFEwEDVkj/S', 'Administrator', 'admin@fotostudio.com', '08123456789', 'Jl. Studio Foto No. 1', 'admin');

-- Insert data paket default
INSERT INTO paket (nama_paket, deskripsi, harga, durasi, jumlah_foto) VALUES
('Basic Prewedding', 'Paket prewedding dasar di studio', 1500000, '2 jam', 10),
('Standard Prewedding', 'Paket prewedding di studio dan outdoor', 3000000, '4 jam', 20),
('Premium Prewedding', 'Paket prewedding full day di lokasi pilihan', 5000000, '8 jam', 50); 