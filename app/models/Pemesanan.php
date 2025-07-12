<?php
class Pemesanan {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Get all pemesanan
    public function getPemesanan() {
        $this->db->query('SELECT p.*, u.nama_lengkap as nama_pelanggan, pk.nama_paket 
                        FROM pemesanan p 
                        JOIN users u ON p.user_id = u.id 
                        JOIN paket pk ON p.paket_id = pk.id 
                        ORDER BY p.id ASC');
        
        return $this->db->resultSet();
    }
    
    // Get pemesanan by ID
    public function getPemesananById($id) {
        $this->db->query('SELECT p.*, u.nama_lengkap as nama_pelanggan, u.email, u.telepon, 
                        pk.nama_paket, pk.deskripsi as deskripsi_paket, pk.durasi, pk.jumlah_foto 
                        FROM pemesanan p 
                        JOIN users u ON p.user_id = u.id 
                        JOIN paket pk ON p.paket_id = pk.id 
                        WHERE p.id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
    
    // Get pemesanan by user ID
    public function getPemesananByUser($userId) {
        $this->db->query('SELECT p.*, pk.nama_paket 
                        FROM pemesanan p 
                        JOIN paket pk ON p.paket_id = pk.id 
                        WHERE p.user_id = :user_id 
                        ORDER BY p.tanggal_pemesanan DESC');
        $this->db->bind(':user_id', $userId);
        
        return $this->db->resultSet();
    }
    
    // Add pemesanan
    public function addPemesanan($data) {
        $this->db->query('INSERT INTO pemesanan (user_id, paket_id, tanggal_pemesanan, tanggal_acara, lokasi_acara, nama_kontak, nomor_telepon, catatan, total_harga, status) 
                        VALUES(:user_id, :paket_id, :tanggal_pemesanan, :tanggal_acara, :lokasi_acara, :nama_kontak, :nomor_telepon, :catatan, :total_harga, :status)');
        
        // Bind values
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':paket_id', $data['paket_id']);
        $this->db->bind(':tanggal_pemesanan', $data['tanggal_pemesanan']);
        $this->db->bind(':tanggal_acara', $data['tanggal_acara']);
        $this->db->bind(':lokasi_acara', $data['lokasi_acara']);
        $this->db->bind(':nama_kontak', $data['nama_kontak']);
        $this->db->bind(':nomor_telepon', $data['nomor_telepon']);
        $this->db->bind(':catatan', $data['catatan']);
        $this->db->bind(':total_harga', $data['total_harga']);
        $this->db->bind(':status', $data['status'] ?? 'pending');
        
        // Execute
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
    
    // Update pemesanan
    public function updatePemesanan($data) {
        $this->db->query('UPDATE pemesanan SET 
                       paket_id = :paket_id, 
                       tanggal_acara = :tanggal_acara, 
                       lokasi_acara = :lokasi_acara, 
                       nama_kontak = :nama_kontak,
                       nomor_telepon = :nomor_telepon,
                       catatan = :catatan, 
                       total_harga = :total_harga, 
                       status = :status 
                       WHERE id = :id');
        
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':paket_id', $data['paket_id']);
        $this->db->bind(':tanggal_acara', $data['tanggal_acara']);
        $this->db->bind(':lokasi_acara', $data['lokasi_acara']);
        $this->db->bind(':nama_kontak', $data['nama_kontak']);
        $this->db->bind(':nomor_telepon', $data['nomor_telepon']);
        $this->db->bind(':catatan', $data['catatan']);
        $this->db->bind(':total_harga', $data['total_harga']);
        $this->db->bind(':status', $data['status']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Update status pemesanan
    public function updateStatus($id, $status) {
        $this->db->query('UPDATE pemesanan SET status = :status WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Delete pemesanan
    public function deletePemesanan($id) {
        $this->db->query('DELETE FROM pemesanan WHERE id = :id');
        $this->db->bind(':id', $id);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get pemesanan count
    public function getPemesananCount() {
        $this->db->query('SELECT COUNT(*) as total FROM pemesanan');
        $result = $this->db->single();
        return $result->total;
    }
    
    // Get pending pemesanan count
    public function getPendingCount() {
        $this->db->query('SELECT COUNT(*) as total FROM pemesanan WHERE status = "pending"');
        $result = $this->db->single();
        return $result->total;
    }
    
    // Get pemesanan by date range
    public function getPemesananByDate($startDate, $endDate) {
        $this->db->query('SELECT p.*, u.nama_lengkap as nama_pelanggan, pk.nama_paket 
                        FROM pemesanan p 
                        JOIN users u ON p.user_id = u.id 
                        JOIN paket pk ON p.paket_id = pk.id 
                        WHERE p.tanggal_pemesanan BETWEEN :start_date AND :end_date 
                        ORDER BY p.tanggal_pemesanan DESC');
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        
        return $this->db->resultSet();
    }
    
    // Get active orders (pending and confirmed) for a user
    public function getActiveOrdersByUser($userId) {
        $this->db->query('SELECT p.*, pk.nama_paket 
                        FROM pemesanan p 
                        JOIN paket pk ON p.paket_id = pk.id 
                        WHERE p.user_id = :user_id AND p.status IN ("pending", "confirmed") 
                        ORDER BY p.tanggal_pemesanan DESC');
        $this->db->bind(':user_id', $userId);
        
        return $this->db->resultSet();
    }
    
    // Get order history (completed and cancelled) for a user
    public function getOrderHistoryByUser($userId) {
        $this->db->query('SELECT p.*, pk.nama_paket 
                        FROM pemesanan p 
                        JOIN paket pk ON p.paket_id = pk.id 
                        WHERE p.user_id = :user_id AND p.status IN ("completed", "cancelled") 
                        ORDER BY p.tanggal_pemesanan DESC');
        $this->db->bind(':user_id', $userId);
        
        return $this->db->resultSet();
    }
    
    // Check if tanggal is already booked
    public function checkTanggalTersedia($tanggal) {
        $this->db->query('SELECT COUNT(*) as total 
                        FROM pemesanan 
                        WHERE tanggal_acara = :tanggal 
                        AND status IN ("pending", "confirmed", "completed")');
        $this->db->bind(':tanggal', $tanggal);
        
        $result = $this->db->single();
        return ($result->total > 0);
    }
} 