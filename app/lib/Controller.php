<?php
/**
 * Base Controller
 * Loads models and views
 */
class Controller {
    // Load model
    public function model($model) {
        // Require model file
        require_once __DIR__ . '/../models/' . $model . '.php';
        
        // Instantiate model
        return new $model();
    }
    
    // Load view
    public function view($view, $data = []) {
        // Check for view file
        if(file_exists(__DIR__ . '/../views/' . $view . '.php')) {
            require_once __DIR__ . '/../views/' . $view . '.php';
        } else {
            // View does not exist
            die('View tidak ditemukan: ' . $view);
        }
    }
    
    // Redirect to another page
    public function redirect($page) {
        header('location: ' . BASE_URL . '/' . $page);
    }
    
    // Check if user is logged in
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    // Check if user is admin
    public function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
    
    // Flash message helper
    public function setFlash($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }
    
    // Get flash message
    public function getFlash() {
        if(isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
} 