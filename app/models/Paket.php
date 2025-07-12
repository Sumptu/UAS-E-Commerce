<?php
class Paket {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Get all paket
    public function getPakets() {
        $this->db->query('SELECT * FROM paket ORDER BY id ASC');
        
        return $this->db->resultSet();
    }
    
    // Get active paket
    public function getActivePakets() {
        $this->db->query('SELECT * FROM paket WHERE is_active = true ORDER BY id ASC');
        
        return $this->db->resultSet();
    }
    
    // Get paket by ID
    public function getPaketById($id) {
        $this->db->query('SELECT * FROM paket WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
    
    // Add paket
    public function addPaket($data) {
        $this->db->query('INSERT INTO paket (nama_paket, deskripsi, harga, durasi, jumlah_foto, is_active) VALUES(:nama_paket, :deskripsi, :harga, :durasi, :jumlah_foto, :is_active)');
        
        // Bind values
        $this->db->bind(':nama_paket', $data['nama_paket']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':harga', $data['harga']);
        $this->db->bind(':durasi', $data['durasi']);
        $this->db->bind(':jumlah_foto', $data['jumlah_foto']);
        $this->db->bind(':is_active', $data['is_active'] ?? true);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Update paket
    public function updatePaket($data) {
        $this->db->query('UPDATE paket SET nama_paket = :nama_paket, deskripsi = :deskripsi, harga = :harga, durasi = :durasi, jumlah_foto = :jumlah_foto, is_active = :is_active WHERE id = :id');
        
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':nama_paket', $data['nama_paket']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':harga', $data['harga']);
        $this->db->bind(':durasi', $data['durasi']);
        $this->db->bind(':jumlah_foto', $data['jumlah_foto']);
        $this->db->bind(':is_active', $data['is_active'] ?? true);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Delete paket
    public function deletePaket($id) {
        $this->db->query('DELETE FROM paket WHERE id = :id');
        $this->db->bind(':id', $id);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Toggle active status
    public function toggleActive($id, $status) {
        $this->db->query('UPDATE paket SET is_active = :status WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get paket count
    public function getPaketCount() {
        $this->db->query('SELECT COUNT(*) as total FROM paket');
        $result = $this->db->single();
        return $result->total;
    }
} 