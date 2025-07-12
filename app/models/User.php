<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Register user
    public function register($data) {
        $this->db->query('INSERT INTO users (username, nama_lengkap, email, password, role) VALUES(:username, :nama, :email, :password, :role)');
        
        // Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':nama', $data['nama']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':role', $data['role'] ?? 'user');
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Login User
    public function login($username, $password) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);
        
        $row = $this->db->single();
        
        if($row) {
            $hashed_password = $row->password;
            if(password_verify($password, $hashed_password)) {
                // Set nama agar konsisten untuk digunakan di session
                $row->nama = $row->nama_lengkap;
                return $row;
            }
        }
        
        return false;
    }
    
    // Find user by ID
    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        
        $user = $this->db->single();
        
        // Set nama agar konsisten untuk digunakan di view
        if ($user) {
            $user->nama = $user->nama_lengkap;
        }
        
        return $user;
    }
    
    // Find user by username
    public function findUserByUsername($username) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);
        
        $this->db->execute();
        
        // Check if user exists
        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    // Find user by email
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        
        $this->db->execute();
        
        // Check if email exists
        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get all users
    public function getUsers() {
        $this->db->query('SELECT * FROM users ORDER BY created_at DESC');
        
        return $this->db->resultSet();
    }
    
    // Check password
    public function checkPassword($id, $password) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        
        $row = $this->db->single();
        
        if($row) {
            $hashed_password = $row->password;
            if(password_verify($password, $hashed_password)) {
                return true;
            }
        }
        
        return false;
    }
    
    // Update password
    public function updatePassword($id, $password) {
        $this->db->query('UPDATE users SET password = :password, reset_token = NULL, reset_expires = NULL WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':password', $password);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Save reset token
    public function saveResetToken($email, $token, $expires) {
        $this->db->query('UPDATE users SET reset_token = :token, reset_expires = :expires WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->bind(':token', $token);
        $this->db->bind(':expires', $expires);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get user by reset token
    public function getUserByResetToken($token) {
        $this->db->query('SELECT * FROM users WHERE reset_token = :token');
        $this->db->bind(':token', $token);
        
        return $this->db->single();
    }
    
    // Update user
    public function updateUser($data) {
        // Update query dengan menggunakan nama_lengkap
        if(isset($data['password'])) {
            $this->db->query('UPDATE users SET username = :username, nama_lengkap = :nama, email = :email, password = :password WHERE id = :id');
            $this->db->bind(':password', $data['password']);
        } else {
            $this->db->query('UPDATE users SET username = :username, nama_lengkap = :nama, email = :email WHERE id = :id');
        }
        
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':nama', $data['nama']);
        $this->db->bind(':email', $data['email']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Delete user
    public function deleteUser($id) {
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get user count
    public function getUserCount() {
        $this->db->query('SELECT COUNT(*) as total FROM users');
        $result = $this->db->single();
        return $result->total;
    }
} 