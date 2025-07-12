<?php
require_once '../config/database.php';

class PortofolioModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Ambil semua portofolio
    public function getAllPortofolio() {
        $this->db->query('SELECT * FROM portofolio ORDER BY created_at DESC');
        return $this->db->resultSet();
    }
    
    // Ambil portofolio berdasarkan kategori
    public function getPortofolioByKategori($kategori) {
        $this->db->query('SELECT * FROM portofolio WHERE kategori = :kategori ORDER BY created_at DESC');
        $this->db->bind(':kategori', $kategori);
        return $this->db->resultSet();
    }
    
    // Ambil portofolio berdasarkan ID
    public function getPortofolioById($id) {
        $this->db->query('SELECT * FROM portofolio WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Tambah portofolio baru
    public function addPortofolio($data) {
        $this->db->query('INSERT INTO portofolio (judul, deskripsi, foto, tanggal, kategori) VALUES (:judul, :deskripsi, :foto, :tanggal, :kategori)');
        
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':foto', $data['foto']);
        $this->db->bind(':tanggal', $data['tanggal']);
        $this->db->bind(':kategori', $data['kategori']);
        
        return $this->db->execute();
    }
    
    // Update portofolio
    public function updatePortofolio($data) {
        $this->db->query('UPDATE portofolio SET judul = :judul, deskripsi = :deskripsi, foto = :foto, tanggal = :tanggal, kategori = :kategori WHERE id = :id');
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':foto', $data['foto']);
        $this->db->bind(':tanggal', $data['tanggal']);
        $this->db->bind(':kategori', $data['kategori']);
        
        return $this->db->execute();
    }
    
    // Hapus portofolio
    public function deletePortofolio($id) {
        $this->db->query('DELETE FROM portofolio WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Ambil jumlah portofolio
    public function getPortofolioCount() {
        $this->db->query('SELECT COUNT(*) as total FROM portofolio');
        $result = $this->db->single();
        return $result->total;
    }
    
    // Ambil portofolio untuk halaman utama (limit 6)
    public function getPortofolioForHome() {
        $this->db->query('SELECT * FROM portofolio ORDER BY created_at DESC LIMIT 6');
        return $this->db->resultSet();
    }
} 