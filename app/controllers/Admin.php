<?php
class Admin extends Controller {
    private $userModel;
    private $paketModel;
    private $pemesananModel;
    private $pembayaranModel;
    
    public function __construct() {
        // Protect admin routes
        if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('users/login');
        }
        
        // Load models
        $this->userModel = $this->model('User');
        $this->paketModel = $this->model('Paket');
        $this->pemesananModel = $this->model('Pemesanan');
        $this->pembayaranModel = $this->model('Pembayaran');
    }
    
    // Admin dashboard
    public function index() {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        // Get counts for dashboard
        $paketCount = $this->paketModel->getPaketCount();
        $pemesananCount = $this->pemesananModel->getPemesananCount();
        $pendingCount = $this->pemesananModel->getPendingCount();
        $userCount = $this->userModel->getUserCount();
        
        $data = [
            'title' => 'Admin Dashboard | ' . APP_NAME,
            'is_dashboard' => true,
            'paketCount' => $paketCount,
            'pemesananCount' => $pemesananCount,
            'pendingCount' => $pendingCount,
            'userCount' => $userCount
        ];
        
        $this->view('templates/admin/header', $data);
        $this->view('admin/index', $data);
        $this->view('templates/admin/footer');
    }
    
    // Paket management
    public function pakets() {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        // Get all pakets
        $pakets = $this->paketModel->getPakets();
        
        $data = [
            'title' => 'Manajemen Paket | ' . APP_NAME,
            'is_dashboard' => true,
            'pakets' => $pakets
        ];
        
        $this->view('templates/admin/header', $data);
        $this->view('admin/pakets/index', $data);
        $this->view('templates/admin/footer');
    }
    
    // Add paket
    public function addPaket() {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Prepare harga by removing thousand separators
            $harga = str_replace('.', '', trim($_POST['harga']));
            
            // Init data
            $data = [
                'title' => 'Tambah Paket | ' . APP_NAME,
                'nama_paket' => trim($_POST['nama_paket']),
                'deskripsi' => trim($_POST['deskripsi']),
                'harga' => $harga,
                'durasi' => trim($_POST['durasi']),
                'jumlah_foto' => trim($_POST['jumlah_foto']),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'nama_paket_err' => '',
                'harga_err' => ''
            ];
            
            // Validate nama_paket
            if(empty($data['nama_paket'])) {
                $data['nama_paket_err'] = 'Silakan masukkan nama paket';
            }
            
            // Validate harga
            if(empty($data['harga'])) {
                $data['harga_err'] = 'Silakan masukkan harga paket';
            } elseif(!is_numeric($data['harga'])) {
                $data['harga_err'] = 'Harga harus berupa angka';
            }
            
            // Make sure errors are empty
            if(empty($data['nama_paket_err']) && empty($data['harga_err'])) {
                // Validated
                
                // Add paket
                if($this->paketModel->addPaket($data)) {
                    // Set flash message
                    $this->setFlash('success', 'Paket berhasil ditambahkan');
                    $this->redirect('admin/pakets');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('templates/admin/header', $data);
                $this->view('admin/pakets/add', $data);
                $this->view('templates/admin/footer');
            }
        } else {
            // Init data
            $data = [
                'title' => 'Tambah Paket | ' . APP_NAME,
                'nama_paket' => '',
                'deskripsi' => '',
                'harga' => '',
                'durasi' => '',
                'jumlah_foto' => '',
                'is_active' => 1,
                'nama_paket_err' => '',
                'harga_err' => ''
            ];
            
            // Load view
            $this->view('templates/admin/header', $data);
            $this->view('admin/pakets/add', $data);
            $this->view('templates/admin/footer');
        }
    }
    
    // Edit paket
    public function editPaket($id) {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Prepare harga by removing thousand separators
            $harga = str_replace('.', '', trim($_POST['harga']));
            
            // Init data
            $data = [
                'title' => 'Edit Paket | ' . APP_NAME,
                'id' => $id,
                'nama_paket' => trim($_POST['nama_paket']),
                'deskripsi' => trim($_POST['deskripsi']),
                'harga' => $harga,
                'durasi' => trim($_POST['durasi']),
                'jumlah_foto' => trim($_POST['jumlah_foto']),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'nama_paket_err' => '',
                'harga_err' => ''
            ];
            
            // Validate nama_paket
            if(empty($data['nama_paket'])) {
                $data['nama_paket_err'] = 'Silakan masukkan nama paket';
            }
            
            // Validate harga
            if(empty($data['harga'])) {
                $data['harga_err'] = 'Silakan masukkan harga paket';
            } elseif(!is_numeric($data['harga'])) {
                $data['harga_err'] = 'Harga harus berupa angka';
            }
            
            // Make sure errors are empty
            if(empty($data['nama_paket_err']) && empty($data['harga_err'])) {
                // Validated
                
                // Update paket
                if($this->paketModel->updatePaket($data)) {
                    // Set flash message
                    $this->setFlash('success', 'Paket berhasil diperbarui');
                    $this->redirect('admin/pakets');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('templates/admin/header', $data);
                $this->view('admin/pakets/edit', $data);
                $this->view('templates/admin/footer');
            }
        } else {
            // Get paket data
            $paket = $this->paketModel->getPaketById($id);
            
            // Init data
            $data = [
                'title' => 'Edit Paket | ' . APP_NAME,
                'id' => $paket->id,
                'nama_paket' => $paket->nama_paket,
                'deskripsi' => $paket->deskripsi,
                'harga' => $paket->harga,
                'durasi' => $paket->durasi,
                'jumlah_foto' => $paket->jumlah_foto,
                'is_active' => $paket->is_active,
                'nama_paket_err' => '',
                'harga_err' => ''
            ];
            
            // Load view
            $this->view('templates/admin/header', $data);
            $this->view('admin/pakets/edit', $data);
            $this->view('templates/admin/footer');
        }
    }
    
    // Delete paket
    public function deletePaket($id) {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        if($this->paketModel->deletePaket($id)) {
            // Set flash message
            $this->setFlash('success', 'Paket berhasil dihapus');
        } else {
            // Set flash message
            $this->setFlash('danger', 'Gagal menghapus paket');
        }
        $this->redirect('admin/pakets');
    }
    
    // Toggle paket active status
    public function togglePaket($id) {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        // Get paket data
        $paket = $this->paketModel->getPaketById($id);
        
        // Toggle status
        $newStatus = $paket->is_active ? 0 : 1;
        
        if($this->paketModel->toggleActive($id, $newStatus)) {
            // Set flash message
            $this->setFlash('success', 'Status paket berhasil diubah');
        } else {
            // Set flash message
            $this->setFlash('danger', 'Gagal mengubah status paket');
        }
        $this->redirect('admin/pakets');
    }
    
    // Pemesanan management
    public function pemesanan() {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        // Get all pemesanan
        $pemesanan = $this->pemesananModel->getPemesanan();
        
        $data = [
            'title' => 'Manajemen Pemesanan | ' . APP_NAME,
            'pemesanan' => $pemesanan
        ];
        
        $this->view('templates/admin/header', $data);
        $this->view('admin/pemesanan/index', $data);
        $this->view('templates/admin/footer');
    }
    
    // View pemesanan details
    public function viewPemesanan($id) {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        // Get pemesanan data
        $pemesanan = $this->pemesananModel->getPemesananById($id);
        
        // Get pembayaran for this pemesanan
        $pembayaranData = $this->pembayaranModel->getPembayaranByPemesanan($id);
        
        // Convert pembayaran data to object if it's the first element of array
        $pembayaran = null;
        if (!empty($pembayaranData)) {
            if (is_array($pembayaranData) && count($pembayaranData) > 0) {
                $pembayaran = $pembayaranData[0];
            } else {
                $pembayaran = $pembayaranData;
            }
        }
        
        $data = [
            'title' => 'Detail Pemesanan | ' . APP_NAME,
            'pemesanan' => $pemesanan,
            'pembayaran' => $pembayaran
        ];
        
        $this->view('templates/admin/header', $data);
        $this->view('admin/pemesanan/view', $data);
        $this->view('templates/admin/footer');
    }
    
    // Update pemesanan status
    public function updateStatus($id) {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get POST data
            $status = $_POST['status'];
            
            // Check current status
            $currentPemesanan = $this->pemesananModel->getPemesananById($id);
            
            // If status is already cancelled, don't allow updates
            if($currentPemesanan->status == 'cancelled' && $status != 'cancelled') {
                // Set flash message
                $this->setFlash('danger', 'Pemesanan yang sudah dibatalkan tidak dapat diubah statusnya');
                $this->redirect('admin/viewPemesanan/' . $id);
                return;
            }
            
            if($this->pemesananModel->updateStatus($id, $status)) {
                // Set flash message
                $this->setFlash('success', 'Status pemesanan berhasil diperbarui');
            } else {
                // Set flash message
                $this->setFlash('danger', 'Gagal memperbarui status pemesanan');
            }
            $this->redirect('admin/viewPemesanan/' . $id);
        } else {
            $this->redirect('admin/pemesanan');
        }
    }
    
    // Delete pemesanan
    public function deletePemesanan($id) {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        if($this->pemesananModel->deletePemesanan($id)) {
            // Set flash message
            $this->setFlash('success', 'Pemesanan berhasil dihapus');
        } else {
            // Set flash message
            $this->setFlash('danger', 'Gagal menghapus pemesanan');
        }
        $this->redirect('admin/pemesanan');
    }
    
    // Pembayaran management
    public function pembayaran() {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        // Get all pembayaran
        $pembayaran = $this->pembayaranModel->getPembayaran();
        
        $data = [
            'title' => 'Manajemen Pembayaran | ' . APP_NAME,
            'pembayaran' => $pembayaran
        ];
        
        $this->view('templates/admin/header', $data);
        $this->view('admin/pembayaran/index', $data);
        $this->view('templates/admin/footer');
    }
    
    // View pembayaran details
    public function viewPembayaran($id) {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        // Get pembayaran data
        $pembayaran = $this->pembayaranModel->getPembayaranById($id);
        
        $data = [
            'title' => 'Detail Pembayaran | ' . APP_NAME,
            'pembayaran' => $pembayaran
        ];
        
        $this->view('templates/admin/header', $data);
        $this->view('admin/pembayaran/view', $data);
        $this->view('templates/admin/footer');
    }
    
    // Update pembayaran status
    public function updatePembayaranStatus($id) {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get POST data
            $status = $_POST['status'];
            
            // Get pembayaran dan pemesanan data
            $pembayaran = $this->pembayaranModel->getPembayaranById($id);
            $pemesanan = $this->pemesananModel->getPemesananById($pembayaran->pemesanan_id);
            
            // If pemesanan is cancelled, don't allow payment verification
            if($pemesanan->status == 'cancelled' && $status == 'verified') {
                // Set flash message
                $this->setFlash('danger', 'Pembayaran untuk pemesanan yang sudah dibatalkan tidak dapat diverifikasi');
                $this->redirect('admin/viewPembayaran/' . $id);
                return;
            }
            
            if($this->pembayaranModel->updateStatus($id, $status)) {
                // If payment is verified, update pemesanan status to confirmed
                if($status == 'verified' && $pemesanan->status != 'cancelled') {
                    $this->pemesananModel->updateStatus($pembayaran->pemesanan_id, 'confirmed');
                }
                
                // Set flash message
                $this->setFlash('success', 'Status pembayaran berhasil diperbarui');
            } else {
                // Set flash message
                $this->setFlash('danger', 'Gagal memperbarui status pembayaran');
            }
            $this->redirect('admin/viewPembayaran/' . $id);
        } else {
            $this->redirect('admin/pembayaran');
        }
    }
    
    // Delete pembayaran
    public function deletePembayaran($id) {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        if($this->pembayaranModel->deletePembayaran($id)) {
            // Set flash message
            $this->setFlash('success', 'Pembayaran berhasil dihapus');
        } else {
            // Set flash message
            $this->setFlash('danger', 'Gagal menghapus pembayaran');
        }
        $this->redirect('admin/pembayaran');
    }
    
    // Laporan (Reports)
    public function laporan() {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        // Default dates
        $startDate = date('Y-m-01'); // First day of current month
        $endDate = date('Y-m-t'); // Last day of current month
        
        // Filter by date if submitted
        if(isset($_GET['start_date']) && isset($_GET['end_date'])) {
            $startDate = $_GET['start_date'];
            $endDate = $_GET['end_date'];
        }
        
        // Get pemesanan for period
        $pemesanan = $this->pemesananModel->getPemesananByDate($startDate, $endDate);
        
        // Get pembayaran for period
        $pembayaran = $this->pembayaranModel->getPembayaranByDate($startDate, $endDate);
        
        $data = [
            'title' => 'Laporan | ' . APP_NAME,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'pemesanan' => $pemesanan,
            'pembayaran' => $pembayaran
        ];
        
        $this->view('templates/admin/header', $data);
        $this->view('admin/laporan/index', $data);
        $this->view('templates/admin/footer');
    }

    public function users() {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        $data = [
            'title' => 'Manajemen User | ' . APP_NAME,
            'is_dashboard' => true
        ];
        
        $this->view('templates/admin/header', $data);
        $this->view('admin/users', $data);
        $this->view('templates/admin/footer');
    }

    public function packages() {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        $data = [
            'title' => 'Manajemen Paket | ' . APP_NAME,
            'is_dashboard' => true
        ];
        
        $this->view('templates/admin/header', $data);
        $this->view('admin/packages', $data);
        $this->view('templates/admin/footer');
    }

    public function orders() {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        $data = [
            'title' => 'Manajemen Pesanan | ' . APP_NAME,
            'is_dashboard' => true
        ];
        
        $this->view('templates/admin/header', $data);
        $this->view('admin/orders', $data);
        $this->view('templates/admin/footer');
    }

    public function payments() {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        $data = [
            'title' => 'Manajemen Pembayaran | ' . APP_NAME,
            'is_dashboard' => true
        ];
        
        $this->view('templates/admin/header', $data);
        $this->view('admin/payments', $data);
        $this->view('templates/admin/footer');
    }

    public function settings() {
        if(!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
        
        $data = [
            'title' => 'Pengaturan Admin | ' . APP_NAME,
            'is_dashboard' => true
        ];
        
        $this->view('templates/admin/header', $data);
        $this->view('admin/settings', $data);
        $this->view('templates/admin/footer');
    }
} 