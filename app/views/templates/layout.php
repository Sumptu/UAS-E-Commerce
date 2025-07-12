<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title'] ?? APP_NAME; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/components.css">
    <?php if(isset($data['is_dashboard']) && $data['is_dashboard']): ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/dashboard.css">
    <?php endif; ?>
    <!-- Custom JavaScript -->
    <script src="<?php echo BASE_URL; ?>/public/js/utils.js" defer></script>
    <?php if(isset($data['is_dashboard']) && $data['is_dashboard']): ?>
    <script src="<?php echo BASE_URL; ?>/public/js/dashboard.js" defer></script>
    <?php endif; ?>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="z-index: 999999 !important; position: fixed !important; width: 100% !important; top: 0 !important;">
        <div class="container px-4">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                <i class="fas fa-camera"></i> <?php echo APP_NAME; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars text-light"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>"><i class="fas fa-home"></i> Beranda</a>
                    </li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/admin"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i> <?php echo $_SESSION['nama']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/users/profile"><i class="fas fa-id-card"></i> Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/users/logout"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/users/login"><i class="fas fa-sign-in-alt"></i> Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/users/register"><i class="fas fa-user-plus"></i> Daftar</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4" style="margin-top: 80px !important;">
        <div class="container">
            <?php if(isset($data['title'])): ?>
                <h1 class="mb-4"><?php echo $data['title']; ?></h1>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['flash'])): ?>
                <div class="alert alert-<?php echo $_SESSION['flash']['type']; ?> alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['flash']['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>
            
            <!-- Dynamic content akan dimuat di sini -->
            <?php echo $content ?? ''; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer py-4 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="mb-3">Tentang Kami</h5>
                    <p class="mb-0"><?php echo APP_NAME; ?> adalah layanan fotografi profesional yang menyediakan berbagai paket foto untuk acara Anda.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Kontak</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone"></i> +62 123 4567 890</li>
                        <li><i class="fas fa-envelope"></i> info@example.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> Jl. Contoh No. 123, Kota</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Ikuti Kami</h5>
                    <div class="social-links">
                        <a href="#" class="me-2"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Navbar Scroll Effect -->
    <script>
        // Pastikan navbar selalu berada di atas
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            navbar.style.zIndex = '999999';
            navbar.style.position = 'fixed';
            navbar.style.width = '100%';
            navbar.style.top = '0';
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        });
    </script>
</body>
</html> 