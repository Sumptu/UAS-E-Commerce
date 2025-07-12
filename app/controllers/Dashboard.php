<?php
class Dashboard extends Controller {
    private $userModel;
    private $paketModel;
    private $pemesananModel;
    private $pembayaranModel;
    
    public function __construct() {
        // Protect routes, must be logged in
        if(!$this->isLoggedIn()) {
            $this->redirect('users/login');
        }
        
        // Redirect admin to admin panel
        if($this->isAdmin()) {
            $this->redirect('admin');
        }
        
        // Load models
        $this->userModel = $this->model('User');
        $this->paketModel = $this->model('Paket');
        $this->pemesananModel = $this->model('Pemesanan');
        $this->pembayaranModel = $this->model('Pembayaran');
    }
    
    // Dashboard index
    public function index() {
        if(!$this->isLoggedIn()) {
            $this->redirect('users/login');
        }
        
        // Ambil data pemesanan user yang aktif (pending dan confirmed)
        $activeOrders = $this->pemesananModel->getActiveOrdersByUser($_SESSION['user_id']);
        
        $data = [
            'title' => 'Dashboard | ' . APP_NAME,
            'is_dashboard' => true,
            'pemesanan' => $activeOrders
        ];
        
        $this->view('templates/user/header', $data);
        $this->view('dashboard/index', $data);
        $this->view('templates/user/footer');
    }
    
    // Create new pemesanan
    public function pesan() {
        // Get all active pakets
        $pakets = $this->paketModel->getActivePakets();
        
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Get paket data
            $paket = $this->paketModel->getPaketById($_POST['paket_id']);
            
            // Init data
            $data = [
                'title' => 'Pesan Paket | ' . APP_NAME,
                'pakets' => $pakets,
                'user_id' => $_SESSION['user_id'],
                'paket_id' => trim($_POST['paket_id']),
                'tanggal_pemesanan' => date('Y-m-d'),
                'tanggal_acara' => trim($_POST['tanggal_acara']),
                'lokasi_acara' => trim($_POST['lokasi_acara']),
                'nama_kontak' => trim($_POST['nama_kontak']),
                'nomor_telepon' => trim($_POST['nomor_telepon']),
                'catatan' => trim($_POST['catatan']),
                'total_harga' => $paket->harga, // Use paket price from database
                'status' => 'pending',
                'paket_id_err' => '',
                'tanggal_acara_err' => '',
                'lokasi_acara_err' => '',
                'nama_kontak_err' => '',
                'nomor_telepon_err' => ''
            ];
            
            // Validate paket_id
            if(empty($data['paket_id'])) {
                $data['paket_id_err'] = 'Silakan pilih paket';
            }
            
            // Validate tanggal_acara
            if(empty($data['tanggal_acara'])) {
                $data['tanggal_acara_err'] = 'Silakan masukkan tanggal acara';
            } elseif(strtotime($data['tanggal_acara']) < strtotime(date('Y-m-d'))) {
                $data['tanggal_acara_err'] = 'Tanggal acara tidak boleh di masa lalu';
            } else {
                // Cek apakah tanggal sudah di-booking
                $existingBooking = $this->pemesananModel->checkTanggalTersedia($data['tanggal_acara']);
                if ($existingBooking) {
                    $data['tanggal_acara_err'] = 'Maaf, tanggal tersebut sudah di-booking. Silakan pilih tanggal lain.';
                }
            }
            
            // Validate lokasi_acara
            if(empty($data['lokasi_acara'])) {
                $data['lokasi_acara_err'] = 'Silakan masukkan lokasi acara';
            }
            
            // Validate nama_kontak
            if(empty($data['nama_kontak'])) {
                $data['nama_kontak_err'] = 'Silakan masukkan nama kontak';
            }
            
            // Validate nomor_telepon
            if(empty($data['nomor_telepon'])) {
                $data['nomor_telepon_err'] = 'Silakan masukkan nomor telepon';
            } elseif(!preg_match('/^[0-9]{10,15}$/', $data['nomor_telepon'])) {
                $data['nomor_telepon_err'] = 'Nomor telepon harus berupa angka (10-15 digit)';
            }
            
            // Make sure errors are empty
            if(empty($data['paket_id_err']) && empty($data['tanggal_acara_err']) && 
               empty($data['lokasi_acara_err']) && empty($data['nama_kontak_err']) && 
               empty($data['nomor_telepon_err'])) {
                // Validated
                
                // Add pemesanan
                $pemesananId = $this->pemesananModel->addPemesanan($data);
                
                if($pemesananId) {
                    // Set flash message
                    $this->setFlash('success', 'Pemesanan berhasil dibuat. Silakan lakukan pembayaran.');
                    $this->redirect('dashboard/pembayaran/' . $pemesananId);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('templates/user/header', $data);
                $this->view('dashboard/pesan', $data);
                $this->view('templates/user/footer');
            }
        } else {
            // Init data
            $data = [
                'title' => 'Pesan Paket | ' . APP_NAME,
                'is_dashboard' => true,
                'pakets' => $pakets,
                'paket_id' => '',
                'tanggal_acara' => '',
                'lokasi_acara' => '',
                'nama_kontak' => '',
                'nomor_telepon' => '',
                'catatan' => '',
                'paket_id_err' => '',
                'tanggal_acara_err' => '',
                'lokasi_acara_err' => '',
                'nama_kontak_err' => '',
                'nomor_telepon_err' => ''
            ];
            
            // Load view
            $this->view('templates/user/header', $data);
            $this->view('dashboard/pesan', $data);
            $this->view('templates/user/footer');
        }
    }
    
    // Pemesanan details
    public function detail($id) {
        // Get pemesanan data
        $pemesanan = $this->pemesananModel->getPemesananById($id);
        
        // Check if the pemesanan belongs to the logged in user
        if($pemesanan->user_id != $_SESSION['user_id']) {
            $this->setFlash('danger', 'Anda tidak memiliki akses ke pemesanan ini');
            $this->redirect('dashboard');
        }
        
        // Get pembayaran for this pemesanan
        $pembayaran = $this->pembayaranModel->getPembayaranByPemesanan($id);
        
        $data = [
            'title' => 'Detail Pemesanan | ' . APP_NAME,
            'is_dashboard' => true,
            'pemesanan' => $pemesanan,
            'pembayaran' => $pembayaran
        ];
        
        $this->view('templates/user/header', $data);
        $this->view('dashboard/detail', $data);
        $this->view('templates/user/footer');
    }
    
    // Add pembayaran for pemesanan
    public function pembayaran($id = null) {
        // If no ID provided, redirect to dashboard
        if($id === null) {
            $this->setFlash('danger', 'ID pemesanan tidak valid');
            $this->redirect('dashboard');
            return;
        }
        
        // Get pemesanan data
        $pemesanan = $this->pemesananModel->getPemesananById($id);
        
        // Check if the pemesanan belongs to the logged in user
        if($pemesanan->user_id != $_SESSION['user_id']) {
            $this->setFlash('danger', 'Anda tidak memiliki akses ke pemesanan ini');
            $this->redirect('dashboard');
        }
        
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            
            // Handle file upload for bukti pembayaran
            $buktiPembayaran = '';
            if(!empty($_FILES['bukti_pembayaran']['name'])) {
                // Define upload directory
                $uploadDir = '../public/uploads/bukti_pembayaran/';
                
                // Create directory if not exists
                if(!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                // Generate unique filename
                $fileExt = pathinfo($_FILES['bukti_pembayaran']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid() . '.' . $fileExt;
                $uploadPath = $uploadDir . $fileName;
                
                // Upload file
                if(move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $uploadPath)) {
                    $buktiPembayaran = $fileName;
                } else {
                    $buktiPembayaran = '';
                }
            }
            
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'title' => 'Pembayaran | ' . APP_NAME,
                'pemesanan' => $pemesanan,
                'pemesanan_id' => $id,
                'jumlah' => trim($_POST['jumlah']),
                'metode_pembayaran' => trim($_POST['metode_pembayaran']),
                'tanggal_pembayaran' => date('Y-m-d'),
                'bukti_pembayaran' => $buktiPembayaran,
                'status' => 'pending',
                'jumlah_err' => '',
                'metode_pembayaran_err' => '',
                'bukti_pembayaran_err' => '',
                'is_dashboard' => true
            ];
            
            // Validate jumlah
            if(empty($data['jumlah'])) {
                $data['jumlah_err'] = 'Silakan masukkan jumlah pembayaran';
            } elseif(!is_numeric($data['jumlah'])) {
                $data['jumlah_err'] = 'Jumlah harus berupa angka';
            } elseif((float)$data['jumlah'] < (float)$pemesanan->total_harga) {
                $data['jumlah_err'] = 'Jumlah pembayaran harus sama dengan atau lebih dari total harga';
            }
            
            // Validate metode_pembayaran
            if(empty($data['metode_pembayaran'])) {
                $data['metode_pembayaran_err'] = 'Silakan pilih metode pembayaran';
            }
            
            // Validate bukti_pembayaran
            if(empty($data['bukti_pembayaran'])) {
                $data['bukti_pembayaran_err'] = 'Silakan unggah bukti pembayaran';
            }
            
            // Make sure errors are empty
            if(empty($data['jumlah_err']) && empty($data['metode_pembayaran_err']) && empty($data['bukti_pembayaran_err'])) {
                // Validated
                
                // Add pembayaran
                if($this->pembayaranModel->addPembayaran($data)) {
                    // Set flash message
                    $this->setFlash('success', 'Pembayaran berhasil dilakukan. Silakan tunggu verifikasi dari admin.');
                    $this->redirect('dashboard/detail/' . $id);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('templates/user/header', $data);
                $this->view('dashboard/pembayaran', $data);
                $this->view('templates/user/footer');
            }
        } else {
            // Init data
            $data = [
                'title' => 'Pembayaran | ' . APP_NAME,
                'pemesanan' => $pemesanan,
                'jumlah' => $pemesanan->total_harga,
                'metode_pembayaran' => '',
                'bukti_pembayaran' => '',
                'jumlah_err' => '',
                'metode_pembayaran_err' => '',
                'bukti_pembayaran_err' => '',
                'is_dashboard' => true
            ];
            
            // Load view
            $this->view('templates/user/header', $data);
            $this->view('dashboard/pembayaran', $data);
            $this->view('templates/user/footer');
        }
    }
    
    // Cancel pemesanan
    public function cancel($id) {
        // Get pemesanan data
        $pemesanan = $this->pemesananModel->getPemesananById($id);
        
        // Check if the pemesanan belongs to the logged in user
        if($pemesanan->user_id != $_SESSION['user_id']) {
            $this->setFlash('danger', 'Anda tidak memiliki akses ke pemesanan ini');
            $this->redirect('dashboard');
        }
        
        // Check if pemesanan is still in pending status
        if($pemesanan->status != 'pending') {
            $this->setFlash('danger', 'Hanya pemesanan dengan status pending yang dapat dibatalkan');
            $this->redirect('dashboard/detail/' . $id);
        }
        
        // Update status to cancelled
        if($this->pemesananModel->updateStatus($id, 'cancelled')) {
            $this->setFlash('success', 'Pemesanan berhasil dibatalkan');
        } else {
            $this->setFlash('danger', 'Gagal membatalkan pemesanan');
        }
        
        $this->redirect('dashboard');
    }
    
    // Menampilkan pemesanan pengguna
    public function pemesanan() {
        if(!$this->isLoggedIn()) {
            $this->redirect('users/login');
        }
        
        // Ambil data riwayat pemesanan selesai/batal saja
        $pemesananHistory = $this->pemesananModel->getOrderHistoryByUser($_SESSION['user_id']);
        
        $data = [
            'title' => 'Riwayat Pemesanan | ' . APP_NAME,
            'is_dashboard' => true,
            'pemesanan' => $pemesananHistory
        ];
        
        $this->view('templates/user/header', $data);
        $this->view('dashboard/index', $data);
        $this->view('templates/user/footer');
    }

    public function orders() {
        if(!$this->isLoggedIn()) {
            $this->redirect('users/login');
        }
        
        $data = [
            'title' => 'Pesanan Saya | ' . APP_NAME,
            'is_dashboard' => true
        ];
        
        $this->view('templates/user/header', $data);
        $this->view('dashboard/orders', $data);
        $this->view('templates/user/footer');
    }

    public function payments() {
        if(!$this->isLoggedIn()) {
            $this->redirect('users/login');
        }
        
        // Ambil data pembayaran user
        $pembayaran = $this->pembayaranModel->getPembayaranByUser($_SESSION['user_id']);
        
        $data = [
            'title' => 'Pembayaran Saya | ' . APP_NAME,
            'is_dashboard' => true,
            'pembayaran' => $pembayaran
        ];
        
        $this->view('templates/user/header', $data);
        $this->view('dashboard/payments', $data);
        $this->view('templates/user/footer');
    }

    public function settings() {
        if(!$this->isLoggedIn()) {
            $this->redirect('users/login');
        }
        
        $data = [
            'title' => 'Pengaturan | ' . APP_NAME,
            'is_dashboard' => true
        ];
        
        $this->view('templates/user/header', $data);
        $this->view('dashboard/settings', $data);
        $this->view('templates/user/footer');
    }
    
    // Check date availability via AJAX
    public function checkTanggalTersedia() {
        // For AJAX requests only
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['error' => 'Metode akses tidak diizinkan']);
            return;
        }
        
        // Get data
        $data = json_decode(file_get_contents('php://input'));
        $tanggal = isset($data->tanggal) ? $data->tanggal : '';
        
        if (empty($tanggal)) {
            echo json_encode(['error' => 'Tanggal tidak boleh kosong']);
            return;
        }
        
        // Check if tanggal is already booked
        $isBooked = $this->pemesananModel->checkTanggalTersedia($tanggal);
        
        echo json_encode([
            'available' => !$isBooked,
            'message' => $isBooked ? 'Tanggal tersebut sudah dibooking' : 'Tanggal tersedia'
        ]);
    }
    
    // Get paket detail via AJAX
    public function getPaketDetail($id) {
        // For AJAX requests
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            header('Content-Type: application/json');
        }
        
        // Validate ID
        if (empty($id) || !is_numeric($id)) {
            echo json_encode(['error' => 'ID paket tidak valid']);
            return;
        }
        
        // Get paket data
        $paket = $this->paketModel->getPaketById($id);
        
        if (!$paket) {
            echo json_encode(['error' => 'Paket tidak ditemukan']);
            return;
        }
        
        // Return paket data as JSON
        echo json_encode($paket);
    }
} 