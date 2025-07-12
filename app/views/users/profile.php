<div class="container">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-lg mb-5">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="m-0">Profil Saya</h4>
                    <a href="<?php echo BASE_URL; ?>/users/edit" class="btn btn-light">
                        <i class="fas fa-edit me-1"></i> Edit Profil
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Informasi Akun</h5>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Username:</strong></p>
                                <p class="lead"><?php echo $_SESSION['username']; ?></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Nama Lengkap:</strong></p>
                                <p class="lead"><?php echo $_SESSION['nama']; ?></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Email:</strong></p>
                                <p class="lead"><?php echo $_SESSION['email']; ?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Informasi Tambahan</h5>
                            <div class="mb-3">
                                <p class="mb-1">
                                    <a href="<?php echo BASE_URL; ?>/users/edit" class="btn btn-primary">
                                        <i class="fas fa-edit me-1"></i> Edit Profil
                                    </a>
                                </p>
                                <p class="mb-1">
                                    <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-secondary">
                                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <h5 class="border-bottom pb-2 mb-3">Riwayat Pemesanan</h5>
                    <?php if(!empty($data['pemesanan'])): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Paket</th>
                                        <th>Tanggal Acara</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($data['pemesanan'] as $pemesanan): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $pemesanan->nama_paket; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($pemesanan->tanggal_acara)); ?></td>
                                            <td>Rp <?php echo number_format($pemesanan->total_harga, 0, ',', '.'); ?></td>
                                            <td>
                                                <?php
                                                $badge_class = 'bg-secondary';
                                                switch ($pemesanan->status) {
                                                    case 'pending':
                                                        $badge_class = 'bg-warning';
                                                        break;
                                                    case 'confirmed':
                                                        $badge_class = 'bg-info';
                                                        break;
                                                    case 'completed':
                                                        $badge_class = 'bg-success';
                                                        break;
                                                    case 'cancelled':
                                                        $badge_class = 'bg-danger';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge <?php echo $badge_class; ?>">
                                                    <?php echo ucfirst($pemesanan->status); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?php echo BASE_URL; ?>/dashboard/detail/<?php echo $pemesanan->id; ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if($pemesanan->status == 'pending'): ?>
                                                    <a href="<?php echo BASE_URL; ?>/dashboard/pembayaran/<?php echo $pemesanan->id; ?>" class="btn btn-success btn-sm">
                                                        <i class="fas fa-money-bill-wave"></i>
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>/dashboard/cancel/<?php echo $pemesanan->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?');">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Anda belum memiliki riwayat pemesanan. <a href="<?php echo BASE_URL; ?>/dashboard/pesan" class="alert-link">Pesan paket sekarang</a>.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 