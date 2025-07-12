<?php
class Home extends Controller {
    private $paketModel;
    
    public function __construct() {
        // Load models
        $this->paketModel = $this->model('Paket');
    }
    
    // Default method
    public function index() {
        $pakets = $this->paketModel->getActivePakets();
        
        $data = [
            'title' => 'Beranda | ' . APP_NAME,
            'pakets' => $pakets
        ];
        
        // Load template berdasarkan role user
        if(isset($_SESSION['user_id'])) {
            if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                // Untuk admin, gunakan layout admin
                $this->view('templates/admin/header', $data);
                $this->view('home/index', $data);
                $this->view('templates/admin/footer');
            } else {
                // Untuk user biasa yang sudah login
                $this->view('templates/user/header', $data);
                $this->view('home/index', $data);
                $this->view('templates/user/footer');
            }
        } else {
            // Untuk user yang belum login, gunakan layout.php
            $content = $this->renderView('home/index', $data);
            $data['content'] = $content;
            $this->view('templates/layout', $data);
        }
    }
    
    // Helper method untuk render view ke string
    private function renderView($view, $data = []) {
        ob_start();
        require_once __DIR__ . '/../views/' . $view . '.php';
        return ob_get_clean();
    }
} 