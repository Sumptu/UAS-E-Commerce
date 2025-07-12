<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="jumbotron text-center">
                <h1 class="display-4">Selamat Datang di <?= APP_NAME ?></h1>
                <p class="lead">Abadikan momen berharga Anda bersama kami</p>
                <hr class="my-4">
                <p>Kami menyediakan layanan fotografi profesional untuk berbagai kebutuhan</p>
                <a class="btn btn-primary btn-lg" href="#paket-section" role="button">Lihat Paket</a>
            </div>
        </div>
    </div>
</div>

<!-- Paket Section -->
<section class="paket-section py-5 bg-light" id="paket-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Paket Layanan Kami</h2>
            <p class="lead">Pilih paket sesuai kebutuhan Anda</p>
        </div>
        
        <div class="row">
            <?php if (!empty($data['pakets'])): ?>
                <?php foreach ($data['pakets'] as $paket): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?= $paket->nama_paket ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">Rp <?= number_format($paket->harga, 0, ',', '.') ?></h6>
                                <p class="card-text"><?= $paket->deskripsi ?></p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item">Durasi: <?= $paket->durasi ?> jam</li>
                                    <li class="list-group-item">Jumlah Foto: <?= $paket->jumlah_foto ?></li>
                                </ul>
                                <a href="<?= BASE_URL ?>/app/public/dashboard/pesan/<?= $paket->id ?>" class="btn btn-primary">Pesan Sekarang</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <h4>Belum ada paket tersedia</h4>
                        <p>Silakan hubungi admin untuk informasi lebih lanjut.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="#paket-section" class="btn btn-outline-primary">Lihat Semua Paket</a>
        </div>
    </div>
</section>

<!-- Kontak Section -->
<section class="kontak-section py-5 bg-light" id="kontak-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Hubungi Kami</h2>
            <p class="lead">Jangan ragu untuk menghubungi kami</p>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Kontak</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Jl. Contoh No. 123, Kota, Indonesia</li>
                            <li class="mb-2"><i class="fas fa-phone me-2"></i> +62 812 3456 7890</li>
                            <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@fotostudio.com</li>
                            <li class="mb-2"><i class="fas fa-clock me-2"></i> Senin - Sabtu, 09:00 - 17:00</li>
                        </ul>
                        <div class="mt-4">
                            <a href="#" class="me-2"><i class="fab fa-facebook fa-2x"></i></a>
                            <a href="#" class="me-2"><i class="fab fa-instagram fa-2x"></i></a>
                            <a href="#" class="me-2"><i class="fab fa-twitter fa-2x"></i></a>
                            <a href="#" class="me-2"><i class="fab fa-youtube fa-2x"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Kirim Pesan</h5>
                        <form>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" placeholder="Masukkan nama Anda">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Masukkan email Anda">
                            </div>
                            <div class="mb-3">
                                <label for="pesan" class="form-label">Pesan</label>
                                <textarea class="form-control" id="pesan" rows="4" placeholder="Masukkan pesan Anda"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 