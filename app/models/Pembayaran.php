<?php
class Pembayaran {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Get all pembayaran
    public function getPembayaran() {
        $this->db->query('SELECT pb.*, p.user_id, u.nama_lengkap as nama_pelanggan, pk.nama_paket 
                        FROM pembayaran pb 
                        JOIN pemesanan p ON pb.pemesanan_id = p.id 
                        JOIN users u ON p.user_id = u.id 
                        JOIN paket pk ON p.paket_id = pk.id 
                        ORDER BY pb.tanggal_pembayaran DESC');
        
        return $this->db->resultSet();
    }
    
    // Get pembayaran by ID
    public function getPembayaranById($id) {
        $this->db->query('SELECT p.*, pm.tanggal_pemesanan, pm.total_harga, u.nama_lengkap as nama_pelanggan, u.email, u.telepon  
                        FROM pembayaran p 
                        JOIN pemesanan pm ON p.pemesanan_id = pm.id
                        JOIN users u ON pm.user_id = u.id
                        WHERE p.id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
    
    // Get pembayaran by pemesanan ID
    public function getPembayaranByPemesanan($pemesananId) {
        $this->db->query('SELECT * FROM pembayaran WHERE pemesanan_id = :pemesanan_id');
        $this->db->bind(':pemesanan_id', $pemesananId);
        
        return $this->db->resultSet();
    }
    
    // Add pembayaran
    public function addPembayaran($data) {
        $this->db->query('INSERT INTO pembayaran (pemesanan_id, jumlah, metode_pembayaran, tanggal_pembayaran, bukti_pembayaran, status) 
                        VALUES(:pemesanan_id, :jumlah, :metode_pembayaran, :tanggal_pembayaran, :bukti_pembayaran, :status)');
        
        // Bind values
        $this->db->bind(':pemesanan_id', $data['pemesanan_id']);
        $this->db->bind(':jumlah', $data['jumlah']);
        $this->db->bind(':metode_pembayaran', $data['metode_pembayaran']);
        $this->db->bind(':tanggal_pembayaran', $data['tanggal_pembayaran']);
        $this->db->bind(':bukti_pembayaran', $data['bukti_pembayaran']);
        $this->db->bind(':status', $data['status'] ?? 'pending');
        
        // Execute
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
    
    // Update pembayaran
    public function updatePembayaran($data) {
        $this->db->query('UPDATE pembayaran SET 
                       jumlah = :jumlah, 
                       metode_pembayaran = :metode_pembayaran, 
                       tanggal_pembayaran = :tanggal_pembayaran, 
                       bukti_pembayaran = :bukti_pembayaran, 
                       status = :status 
                       WHERE id = :id');
        
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':jumlah', $data['jumlah']);
        $this->db->bind(':metode_pembayaran', $data['metode_pembayaran']);
        $this->db->bind(':tanggal_pembayaran', $data['tanggal_pembayaran']);
        $this->db->bind(':bukti_pembayaran', $data['bukti_pembayaran']);
        $this->db->bind(':status', $data['status']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Update status pembayaran
    public function updateStatus($id, $status) {
        $this->db->query('UPDATE pembayaran SET status = :status WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Delete pembayaran
    public function deletePembayaran($id) {
        $this->db->query('DELETE FROM pembayaran WHERE id = :id');
        $this->db->bind(':id', $id);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get pembayaran by date range
    public function getPembayaranByDate($startDate, $endDate) {
        $this->db->query('SELECT pb.*, p.user_id, u.nama_lengkap as nama_pelanggan, pk.nama_paket 
                        FROM pembayaran pb 
                        JOIN pemesanan p ON pb.pemesanan_id = p.id 
                        JOIN users u ON p.user_id = u.id 
                        JOIN paket pk ON p.paket_id = pk.id 
                        WHERE pb.tanggal_pembayaran BETWEEN :start_date AND :end_date 
                        ORDER BY pb.tanggal_pembayaran DESC');
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        
        return $this->db->resultSet();
    }
    
    // Get pembayaran with verified status
    public function getVerifiedPembayaran() {
        $this->db->query('SELECT pb.*, p.user_id, u.nama_lengkap as nama_pelanggan, pk.nama_paket 
                        FROM pembayaran pb 
                        JOIN pemesanan p ON pb.pemesanan_id = p.id 
                        JOIN users u ON p.user_id = u.id 
                        JOIN paket pk ON p.paket_id = pk.id 
                        WHERE pb.status = "verified" 
                        ORDER BY pb.tanggal_pembayaran DESC');
        
        return $this->db->resultSet();
    }
    
    // Get pembayaran by user ID
    public function getPembayaranByUser($userId) {
        $this->db->query('SELECT pb.*, p.tanggal_acara, p.total_harga, pk.nama_paket 
                        FROM pembayaran pb 
                        JOIN pemesanan p ON pb.pemesanan_id = p.id 
                        JOIN paket pk ON p.paket_id = pk.id 
                        WHERE p.user_id = :user_id 
                        ORDER BY pb.tanggal_pembayaran DESC');
        $this->db->bind(':user_id', $userId);
        
        return $this->db->resultSet();
    }
} 