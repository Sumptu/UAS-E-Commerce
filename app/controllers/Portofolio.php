<?php
require_once '../lib/Controller.php';
class Portofolio extends Controller {
    private $portofolioModel;
    
    public function __construct() {
        $this->portofolioModel = $this->model('PortofolioModel');
    }
    
    // Halaman utama portofolio (untuk user)
    public function index() {
        try {
            $portofolio = $this->portofolioModel->getAllPortofolio();
            $data = [
                'title' => 'Portofolio | ' . APP_NAME,
                'portofolio' => $portofolio
            ];
            
            // Load template berdasarkan role user
            if(isset($_SESSION['user_id'])) {
                if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                    $this->view('templates/admin/header', $data);
                    $this->view('portofolio/index', $data);
                    $this->view('templates/admin/footer');
                } else {
                    $this->view('templates/user/header', $data);
                    $this->view('portofolio/index', $data);
                    $this->view('templates/user/footer');
                }
            } else {
                // Load template untuk user yang belum login
                $this->view('templates/header', $data);
                $this->view('portofolio/index', $data);
                $this->view('templates/footer');
            }
        } catch (PDOException $e) {
            // Jika tabel portofolio belum ada, tampilkan halaman kosong
            $data = [
                'title' => 'Portofolio | ' . APP_NAME,
                'portofolio' => [],
                'error' => 'Portofolio belum tersedia. Silakan coba lagi nanti.'
            ];
            
            // Load template berdasarkan role user
            if(isset($_SESSION['user_id'])) {
                if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                    $this->view('templates/admin/header', $data);
                    $this->view('portofolio/index', $data);
                    $this->view('templates/admin/footer');
                } else {
                    $this->view('templates/user/header', $data);
                    $this->view('portofolio/index', $data);
                    $this->view('templates/user/footer');
                }
            } else {
                // Load template untuk user yang belum login
                $this->view('templates/header', $data);
                $this->view('portofolio/index', $data);
                $this->view('templates/footer');
            }
        }
    }
    
    // Halaman admin untuk mengelola portofolio
    public function admin() {
        // Cek apakah user adalah admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: ' . BASE_URL . '/app/public/users/login');
            exit;
        }
        
        try {
            $portofolio = $this->portofolioModel->getAllPortofolio();
            $data = [
                'title' => 'Kelola Portofolio',
                'portofolio' => $portofolio
            ];
            $this->view('admin/portofolio/index', $data);
        } catch (PDOException $e) {
            $data = [
                'title' => 'Kelola Portofolio',
                'portofolio' => [],
                'error' => 'Tabel portofolio belum tersedia. Silakan jalankan script pembuatan tabel terlebih dahulu.'
            ];
            $this->view('admin/portofolio/index', $data);
        }
    }
    
    // Tambah portofolio baru
    public function add() {
        // Cek apakah user adalah admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: ' . BASE_URL . '/app/public/users/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Proses form
            $data = [
                'judul' => trim($_POST['judul']),
                'deskripsi' => trim($_POST['deskripsi']),
                'foto' => '',
                'tanggal' => trim($_POST['tanggal']),
                'kategori' => trim($_POST['kategori']),
                'judul_err' => '',
                'deskripsi_err' => '',
                'foto_err' => '',
                'tanggal_err' => '',
                'kategori_err' => ''
            ];
            
            // Validasi input
            if (empty($data['judul'])) {
                $data['judul_err'] = 'Judul tidak boleh kosong';
            }
            
            if (empty($data['deskripsi'])) {
                $data['deskripsi_err'] = 'Deskripsi tidak boleh kosong';
            }
            
            if (empty($data['tanggal'])) {
                $data['tanggal_err'] = 'Tanggal tidak boleh kosong';
            }
            
            if (empty($data['kategori'])) {
                $data['kategori_err'] = 'Kategori tidak boleh kosong';
            }
            
            // Upload foto
            if (!empty($_FILES['foto']['name'])) {
                $upload_dir = '../uploads/portofolio/';
                $file_ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
                $file_name = uniqid() . '.' . $file_ext;
                $target_file = $upload_dir . $file_name;
                
                // Cek ekstensi file
                $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($file_ext, $allowed_ext)) {
                    $data['foto_err'] = 'Format file tidak didukung';
                }
                
                // Cek ukuran file (max 2MB)
                if ($_FILES['foto']['size'] > 2097152) {
                    $data['foto_err'] = 'Ukuran file terlalu besar (max 2MB)';
                }
                
                // Upload file jika tidak ada error
                if (empty($data['foto_err'])) {
                    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                        $data['foto'] = $file_name;
                    } else {
                        $data['foto_err'] = 'Gagal mengupload file';
                    }
                }
            } else {
                $data['foto_err'] = 'Foto tidak boleh kosong';
            }
            
            // Cek apakah ada error
            if (empty($data['judul_err']) && empty($data['deskripsi_err']) && empty($data['foto_err']) && empty($data['tanggal_err']) && empty($data['kategori_err'])) {
                // Simpan ke database
                if ($this->portofolioModel->addPortofolio($data)) {
                    $this->setFlash('success', 'Portofolio berhasil ditambahkan');
                    $this->redirect('app/public/admin/portofolio');
                } else {
                    die('Terjadi kesalahan');
                }
            } else {
                // Load view dengan error
                $this->view('admin/portofolio/add', $data);
            }
        } else {
            // Tampilkan form
            $data = [
                'title' => 'Tambah Portofolio',
                'judul' => '',
                'deskripsi' => '',
                'foto' => '',
                'tanggal' => date('Y-m-d'),
                'kategori' => 'prewedding',
                'judul_err' => '',
                'deskripsi_err' => '',
                'foto_err' => '',
                'tanggal_err' => '',
                'kategori_err' => ''
            ];
            
            $this->view('admin/portofolio/add', $data);
        }
    }
    
    // Edit portofolio
    public function edit($id) {
        // Cek apakah user adalah admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: ' . BASE_URL . '/app/public/users/login');
            exit;
        }
        
        // Ambil data portofolio
        $portofolio = $this->portofolioModel->getPortofolioById($id);
        
        // Cek apakah portofolio ada
        if (!$portofolio) {
            die('Portofolio tidak ditemukan');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Proses form
            $data = [
                'id' => $id,
                'judul' => trim($_POST['judul']),
                'deskripsi' => trim($_POST['deskripsi']),
                'foto' => $portofolio->foto, // Default ke foto yang sudah ada
                'tanggal' => trim($_POST['tanggal']),
                'kategori' => trim($_POST['kategori']),
                'judul_err' => '',
                'deskripsi_err' => '',
                'foto_err' => '',
                'tanggal_err' => '',
                'kategori_err' => ''
            ];
            
            // Validasi input
            if (empty($data['judul'])) {
                $data['judul_err'] = 'Judul tidak boleh kosong';
            }
            
            if (empty($data['deskripsi'])) {
                $data['deskripsi_err'] = 'Deskripsi tidak boleh kosong';
            }
            
            if (empty($data['tanggal'])) {
                $data['tanggal_err'] = 'Tanggal tidak boleh kosong';
            }
            
            if (empty($data['kategori'])) {
                $data['kategori_err'] = 'Kategori tidak boleh kosong';
            }
            
            // Upload foto baru jika ada
            if (!empty($_FILES['foto']['name'])) {
                $upload_dir = '../uploads/portofolio/';
                $file_ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
                $file_name = uniqid() . '.' . $file_ext;
                $target_file = $upload_dir . $file_name;
                
                // Cek ekstensi file
                $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($file_ext, $allowed_ext)) {
                    $data['foto_err'] = 'Format file tidak didukung';
                }
                
                // Cek ukuran file (max 2MB)
                if ($_FILES['foto']['size'] > 2097152) {
                    $data['foto_err'] = 'Ukuran file terlalu besar (max 2MB)';
                }
                
                // Upload file jika tidak ada error
                if (empty($data['foto_err'])) {
                    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                        // Hapus foto lama jika berhasil upload foto baru
                        if (file_exists($upload_dir . $portofolio->foto)) {
                            unlink($upload_dir . $portofolio->foto);
                        }
                        $data['foto'] = $file_name;
                    } else {
                        $data['foto_err'] = 'Gagal mengupload file';
                    }
                }
            }
            
            // Cek apakah ada error
            if (empty($data['judul_err']) && empty($data['deskripsi_err']) && empty($data['foto_err']) && empty($data['tanggal_err']) && empty($data['kategori_err'])) {
                // Update ke database
                if ($this->portofolioModel->updatePortofolio($data)) {
                    $this->setFlash('success', 'Portofolio berhasil diupdate');
                    $this->redirect('app/public/admin/portofolio');
                } else {
                    die('Terjadi kesalahan');
                }
            } else {
                // Load view dengan error
                $this->view('admin/portofolio/edit', $data);
            }
        } else {
            // Tampilkan form
            $data = [
                'title' => 'Edit Portofolio',
                'id' => $portofolio->id,
                'judul' => $portofolio->judul,
                'deskripsi' => $portofolio->deskripsi,
                'foto' => $portofolio->foto,
                'tanggal' => $portofolio->tanggal,
                'kategori' => $portofolio->kategori,
                'judul_err' => '',
                'deskripsi_err' => '',
                'foto_err' => '',
                'tanggal_err' => '',
                'kategori_err' => ''
            ];
            
            $this->view('admin/portofolio/edit', $data);
        }
    }
    
    // Hapus portofolio
    public function delete($id) {
        // Cek apakah user adalah admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: ' . BASE_URL . '/app/public/users/login');
            exit;
        }
        
        // Ambil data portofolio
        $portofolio = $this->portofolioModel->getPortofolioById($id);
        
        // Cek apakah portofolio ada
        if (!$portofolio) {
            die('Portofolio tidak ditemukan');
        }
        
        // Hapus portofolio
        if ($this->portofolioModel->deletePortofolio($id)) {
            // Hapus file foto jika ada
            $upload_dir = '../uploads/portofolio/';
            if (file_exists($upload_dir . $portofolio->foto)) {
                unlink($upload_dir . $portofolio->foto);
            }
            
            $this->setFlash('success', 'Portofolio berhasil dihapus');
            $this->redirect('app/public/admin/portofolio');
        } else {
            die('Terjadi kesalahan');
        }
    }
} 