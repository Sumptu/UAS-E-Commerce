<!-- Admin Dashboard -->
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Paket Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Paket</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['paketCount'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-camera fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pemesanan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pemesanan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['pemesananCount'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Pemesanan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pemesanan Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['pendingCount'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Pengguna</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['userCount'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Quick Links -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Akses Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="<?= BASE_URL ?>/admin/pakets" class="btn btn-primary btn-block">
                                <i class="fas fa-camera mr-2"></i> Kelola Paket
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="<?= BASE_URL ?>/admin/pemesanan" class="btn btn-success btn-block">
                                <i class="fas fa-calendar mr-2"></i> Kelola Pemesanan
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="<?= BASE_URL ?>/admin/pembayaran" class="btn btn-warning btn-block">
                                <i class="fas fa-money-bill mr-2"></i> Kelola Pembayaran
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="<?= BASE_URL ?>/admin/laporan" class="btn btn-info btn-block">
                                <i class="fas fa-chart-bar mr-2"></i> Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Sistem</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Versi PHP:</strong> <?= phpversion() ?>
                    </div>
                    <div class="mb-3">
                        <strong>Server:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?>
                    </div>
                    <div class="mb-3">
                        <strong>Waktu Server:</strong> <?= date('Y-m-d H:i:s') ?>
                    </div>
                    <div>
                        <strong>Direktori:</strong> <?= __DIR__ ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 