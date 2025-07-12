<?php
class Users extends Controller {
    private $userModel;
    private $pemesananModel;
    
    public function __construct() {
        $this->userModel = $this->model('User');
        $this->pemesananModel = $this->model('Pemesanan');
    }
    
    // Register user
    public function register() {
        // Check if logged in
        if($this->isLoggedIn()) {
            $this->redirect('');
        }
        
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'title' => 'Daftar | ' . APP_NAME,
                'username' => trim($_POST['username']),
                'nama' => trim($_POST['nama']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'role' => 'user',
                'username_err' => '',
                'nama_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Validate username
            if(empty($data['username'])) {
                $data['username_err'] = 'Masukkan username';
            } elseif($this->userModel->findUserByUsername($data['username'])) {
                $data['username_err'] = 'Username sudah digunakan';
            }
            
            // Validate nama
            if(empty($data['nama'])) {
                $data['nama_err'] = 'Masukkan nama lengkap';
            }
            
            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Masukkan email';
            } elseif($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email sudah terdaftar';
            }
            
            // Validate password
            if(empty($data['password'])) {
                $data['password_err'] = 'Masukkan password';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Password minimal 6 karakter';
            }
            
            // Validate confirm password
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Konfirmasi password';
            } else {
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Password tidak cocok';
                }
            }
            
            // Make sure errors are empty
            if(empty($data['username_err']) && empty($data['nama_err']) && empty($data['email_err']) && 
               empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Validated
                
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                
                // Register user
                if($this->userModel->register($data)) {
                    // Set flash message
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Pendaftaran berhasil, silakan login'
                    ];
                    $this->redirect('users/login');
                } else {
                    die('Ada yang salah');
                }
            } else {
                // Load view with errors
                $this->view('templates/auth_header', $data);
                $this->view('users/register', $data);
                $this->view('templates/auth_footer');
            }
        } else {
            $data = [
                'title' => 'Daftar | ' . APP_NAME,
                'username' => '',
                'nama' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'nama_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            $this->view('templates/auth_header', $data);
            $this->view('users/register', $data);
            $this->view('templates/auth_footer');
        }
    }
    
    // Login user
    public function login() {
        // Check if logged in
        if($this->isLoggedIn()) {
            $this->redirect('');
        }
        
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'title' => 'Masuk | ' . APP_NAME,
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'username_err' => '',
                'password_err' => ''
            ];
            
            // Validate username
            if(empty($data['username'])) {
                $data['username_err'] = 'Masukkan username';
            }
            
            // Validate password
            if(empty($data['password'])) {
                $data['password_err'] = 'Masukkan password';
            }
            
            // Check for user/username
            if($this->userModel->findUserByUsername($data['username'])) {
                // User found
            } else {
                // User not found
                $data['username_err'] = 'User tidak ditemukan';
            }
            
            // Make sure errors are empty
            if(empty($data['username_err']) && empty($data['password_err'])) {
                // Validated
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                
                if($loggedInUser) {
                    // Create session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password salah';
                    $this->view('templates/auth_header', $data);
                    $this->view('users/login', $data);
                    $this->view('templates/auth_footer');
                }
            } else {
                // Load view with errors
                $this->view('templates/auth_header', $data);
                $this->view('users/login', $data);
                $this->view('templates/auth_footer');
            }
        } else {
            // Init data
            $data = [
                'title' => 'Masuk | ' . APP_NAME,
                'username' => '',
                'password' => '',
                'username_err' => '',
                'password_err' => ''
            ];
            
            // Load view
            $this->view('templates/auth_header', $data);
            $this->view('users/login', $data);
            $this->view('templates/auth_footer');
        }
    }
    
    // Create session for logged in user
    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['nama'] = $user->nama;
        $_SESSION['email'] = $user->email;
        $_SESSION['user_role'] = $user->role;
        
        // Redirect to appropriate page based on role
        if($user->role == 'admin') {
            $this->redirect('admin');
        } else {
            $this->redirect('dashboard');
        }
    }
    
    // Logout user
    public function logout() {
        // Hapus semua data session
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['nama']);
        unset($_SESSION['email']);
        unset($_SESSION['user_role']);
        // Juga hapus format lama jika ada
        unset($_SESSION['user_username']);
        unset($_SESSION['user_nama']);
        unset($_SESSION['user_email']);
        unset($_SESSION['role']);

        session_destroy();
        
        $this->redirect('users/login');
    }
    
    // Profile page
    public function profile() {
        if(!$this->isLoggedIn()) {
            $this->redirect('users/login');
        }
        
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'id' => $_SESSION['user_id'],
                'nama' => trim($_POST['nama']),
                'email' => trim($_POST['email']),
                'current_password' => trim($_POST['current_password']),
                'new_password' => trim($_POST['new_password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'nama_err' => '',
                'email_err' => '',
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Validate name
            if(empty($data['nama'])) {
                $data['nama_err'] = 'Masukkan nama';
            }
            
            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Masukkan email';
            } else {
                // Check email
                if($this->userModel->findUserByEmail($data['email']) && $data['email'] != $_SESSION['email']) {
                    $data['email_err'] = 'Email sudah terdaftar';
                }
            }
            
            // Validate password if trying to change
            if(!empty($data['new_password'])) {
                if(empty($data['current_password'])) {
                    $data['current_password_err'] = 'Masukkan password saat ini';
                } else {
                    // Check current password
                    if(!$this->userModel->checkPassword($data['id'], $data['current_password'])) {
                        $data['current_password_err'] = 'Password saat ini salah';
                    }
                }
                
                if(strlen($data['new_password']) < 6) {
                    $data['new_password_err'] = 'Password minimal 6 karakter';
                }
                
                if(empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Konfirmasi password';
                } else {
                    if($data['new_password'] != $data['confirm_password']) {
                        $data['confirm_password_err'] = 'Password tidak cocok';
                    }
                }
            }
            
            // Make sure errors are empty
            if(empty($data['nama_err']) && empty($data['email_err']) && empty($data['current_password_err']) && empty($data['new_password_err']) && empty($data['confirm_password_err'])) {
                // Validated
                
                // Hash new password if provided
                if(!empty($data['new_password'])) {
                    $data['password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);
                }
                
                // Update user
                if($this->userModel->updateUser($data)) {
                    // Update session
                    $_SESSION['nama'] = $data['nama'];
                    $_SESSION['email'] = $data['email'];
                    
                    // Set flash message
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Profil berhasil diperbarui!'
                    ];
                    $this->redirect('users/profile');
                } else {
                    die('Ada yang salah');
                }
            } else {
                // Load view with errors
                $this->view('templates/user/header', $data);
                $this->view('users/profile', $data);
                $this->view('templates/user/footer');
            }
        } else {
            // Get user data
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            
            // Get user pemesanan if pemesanan model exists
            $pemesanan = [];
            if($this->model('Pemesanan')) {
                $pemesananModel = $this->model('Pemesanan');
                $pemesanan = $pemesananModel->getPemesananByUser($_SESSION['user_id']);
            }
            
            // Init data
            $data = [
                'title' => 'Profil | ' . APP_NAME,
                'nama' => $user->nama,
                'email' => $user->email,
                'pemesanan' => $pemesanan,
                'nama_err' => '',
                'email_err' => '',
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Load view
            $this->view('templates/user/header', $data);
            $this->view('users/profile', $data);
            $this->view('templates/user/footer');
        }
    }
    
    // Edit profile
    public function edit() {
        // Check if logged in
        if(!$this->isLoggedIn()) {
            $this->redirect('users/login');
        }
        
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'title' => 'Edit Profil | ' . APP_NAME,
                'id' => $_SESSION['user_id'],
                'username' => trim($_POST['username']),
                'nama' => trim($_POST['nama']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'username_err' => '',
                'nama_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Validate username
            if(empty($data['username'])) {
                $data['username_err'] = 'Masukkan username';
            }
            
            // Validate nama
            if(empty($data['nama'])) {
                $data['nama_err'] = 'Masukkan nama lengkap';
            }
            
            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Masukkan email';
            }
            
            // Validate password (only if not empty)
            if(!empty($data['password'])) {
                if(strlen($data['password']) < 6) {
                    $data['password_err'] = 'Password minimal 6 karakter';
                }
                
                // Validate confirm password
                if(empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Konfirmasi password';
                } else {
                    if($data['password'] != $data['confirm_password']) {
                        $data['confirm_password_err'] = 'Password tidak cocok';
                    }
                }
                
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                // Remove password from data array if empty
                unset($data['password']);
            }
            
            // Make sure errors are empty
            if(empty($data['username_err']) && empty($data['nama_err']) && empty($data['email_err']) && 
               empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Validated
                
                // Update user
                if($this->userModel->updateUser($data)) {
                    // Update session variables
                    $_SESSION['username'] = $data['username'];
                    $_SESSION['nama'] = $data['nama'];
                    $_SESSION['email'] = $data['email'];
                    
                    // Set flash message
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Profil berhasil diperbarui'
                    ];
                    $this->redirect('users/profile');
                } else {
                    die('Ada yang salah');
                }
            } else {
                // Load view with errors
                $this->view('templates/user/header', $data);
                $this->view('users/edit', $data);
                $this->view('templates/user/footer');
            }
        } else {
            // Get user data
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            
            // Init data
            $data = [
                'title' => 'Edit Profil | ' . APP_NAME,
                'id' => $user->id,
                'username' => $user->username,
                'nama' => $user->nama,
                'email' => $user->email,
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'nama_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Load view
            $this->view('templates/user/header', $data);
            $this->view('users/edit', $data);
            $this->view('templates/user/footer');
        }
    }

    public function forgotPassword() {
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'title' => 'Lupa Password | ' . APP_NAME,
                'email' => trim($_POST['email']),
                'email_err' => ''
            ];
            
            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Masukkan email';
            } else {
                // Check email
                if(!$this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email tidak ditemukan';
                }
            }
            
            // Make sure errors are empty
            if(empty($data['email_err'])) {
                // Validated
                // Generate reset token
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                // Save token to database
                if($this->userModel->saveResetToken($data['email'], $token, $expires)) {
                    // Send reset email
                    $resetLink = BASE_URL . '/users/resetPassword/' . $token;
                    $to = $data['email'];
                    $subject = 'Reset Password - ' . APP_NAME;
                    $message = "Klik link berikut untuk reset password Anda: " . $resetLink;
                    $headers = "From: noreply@" . $_SERVER['HTTP_HOST'];
                    
                    mail($to, $subject, $message, $headers);
                    
                    // Set flash message
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Link reset password telah dikirim ke email Anda.'
                    ];
                    $this->redirect('users/login');
                } else {
                    die('Ada yang salah');
                }
            } else {
                // Load view with errors
                $this->view('templates/auth_header', $data);
                $this->view('users/forgotPassword', $data);
                $this->view('templates/auth_footer');
            }
        } else {
            // Init data
            $data = [
                'title' => 'Lupa Password | ' . APP_NAME,
                'email' => '',
                'email_err' => ''
            ];
            
            // Load view
            $this->view('templates/auth_header', $data);
            $this->view('users/forgotPassword', $data);
            $this->view('templates/auth_footer');
        }
    }

    public function resetPassword($token = null) {
        if($token) {
            // Check if token is valid
            $user = $this->userModel->getUserByResetToken($token);
            
            if($user) {
                // Check if token is expired
                if(strtotime($user->reset_expires) > time()) {
                    // Check for POST
                    if($_SERVER['REQUEST_METHOD'] == 'POST') {
                        // Process form
                        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                        
                        $data = [
                            'title' => 'Reset Password | ' . APP_NAME,
                            'password' => trim($_POST['password']),
                            'confirm_password' => trim($_POST['confirm_password']),
                            'password_err' => '',
                            'confirm_password_err' => ''
                        ];
                        
                        // Validate password
                        if(empty($data['password'])) {
                            $data['password_err'] = 'Masukkan password baru';
                        } elseif(strlen($data['password']) < 6) {
                            $data['password_err'] = 'Password minimal 6 karakter';
                        }
                        
                        // Validate confirm password
                        if(empty($data['confirm_password'])) {
                            $data['confirm_password_err'] = 'Konfirmasi password';
                        } else {
                            if($data['password'] != $data['confirm_password']) {
                                $data['confirm_password_err'] = 'Password tidak cocok';
                            }
                        }
                        
                        // Make sure errors are empty
                        if(empty($data['password_err']) && empty($data['confirm_password_err'])) {
                            // Validated
                            
                            // Hash password
                            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                            
                            // Update password
                            if($this->userModel->updatePassword($user->id, $data['password'])) {
                                // Set flash message
                                $_SESSION['flash'] = [
                                    'type' => 'success',
                                    'message' => 'Password berhasil direset! Silakan login.'
                                ];
                                $this->redirect('users/login');
                            } else {
                                die('Ada yang salah');
                            }
                        } else {
                            // Load view with errors
                            $this->view('templates/auth_header', $data);
                            $this->view('users/resetPassword', $data);
                            $this->view('templates/auth_footer');
                        }
                    } else {
                        // Init data
                        $data = [
                            'title' => 'Reset Password | ' . APP_NAME,
                            'password' => '',
                            'confirm_password' => '',
                            'password_err' => '',
                            'confirm_password_err' => ''
                        ];
                        
                        // Load view
                        $this->view('templates/auth_header', $data);
                        $this->view('users/resetPassword', $data);
                        $this->view('templates/auth_footer');
                    }
                } else {
                    // Token expired
                    $_SESSION['flash'] = [
                        'type' => 'danger',
                        'message' => 'Link reset password sudah kadaluarsa.'
                    ];
                    $this->redirect('users/forgotPassword');
                }
            } else {
                // Invalid token
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Link reset password tidak valid.'
                ];
                $this->redirect('users/forgotPassword');
            }
        } else {
            $this->redirect('users/forgotPassword');
        }
    }
} 