<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-lg mb-5">
                <div class="card-header bg-primary text-white">
                    <h4 class="m-0">Detail Pemesanan #<?php echo $data['pemesanan']->id; ?></h4>
                </div>
                <div class="card-body">
                    <!-- Status pemesanan -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Status Pemesanan</h5>
                        <div class="d-flex align-items-center">
                            <?php
                            $badge_class = 'bg-secondary';
                            switch ($data['pemesanan']->status) {
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
                            <span class="badge <?php echo $badge_class; ?> fs-6 px-3 py-2">
                                <?php echo ucfirst($data['pemesanan']->status); ?>
                            </span>
                            
                            <?php if($data['pemesanan']->status == 'pending'): ?>
                                <div class="ms-3">
                                    <a href="<?php echo BASE_URL; ?>/dashboard/pembayaran/<?php echo $data['pemesanan']->id; ?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-money-bill-wave me-1"></i> Bayar Sekarang
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/dashboard/cancel/<?php echo $data['pemesanan']->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?');">
                                        <i class="fas fa-times me-1"></i> Batalkan
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Informasi pemesanan -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Informasi Pemesanan</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Tanggal Pemesanan:</strong> <?php echo date('d/m/Y', strtotime($data['pemesanan']->tanggal_pemesanan)); ?></p>
                                <p><strong>Paket:</strong> <?php echo $data['pemesanan']->nama_paket; ?></p>
                                <p><strong>Total Harga:</strong> Rp <?php echo number_format($data['pemesanan']->total_harga, 0, ',', '.'); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tanggal Acara:</strong> <?php echo date('d/m/Y', strtotime($data['pemesanan']->tanggal_acara)); ?></p>
                                <p><strong>Lokasi Acara:</strong> <?php echo $data['pemesanan']->lokasi_acara; ?></p>
                            </div>
                        </div>
                        
                        <!-- Informasi kontak -->
                        <div class="mt-3 p-3 bg-light rounded">
                            <h6 class="border-bottom pb-2 mb-3">Informasi Kontak</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Nama Kontak:</strong> <?php echo $data['pemesanan']->nama_kontak ?? $data['pemesanan']->nama_pelanggan; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Nomor Telepon:</strong> <?php echo $data['pemesanan']->nomor_telepon ?? $data['pemesanan']->telepon; ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <?php if(!empty($data['pemesanan']->catatan)): ?>
                        <p class="mt-3"><strong>Catatan:</strong> <?php echo $data['pemesanan']->catatan; ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Informasi pembayaran -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Informasi Pembayaran</h5>
                        <?php if(!empty($data['pembayaran'])): ?>
                            <?php foreach($data['pembayaran'] as $pembayaran): ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>ID Pembayaran:</strong> #<?php echo $pembayaran->id; ?></p>
                                                <p class="mb-1"><strong>Tanggal Pembayaran:</strong> <?php echo date('d/m/Y', strtotime($pembayaran->tanggal_pembayaran)); ?></p>
                                                <p class="mb-1"><strong>Jumlah:</strong> Rp <?php echo number_format($pembayaran->jumlah, 0, ',', '.'); ?></p>
                                                <p class="mb-1"><strong>Metode:</strong> <?php echo str_replace('_', ' ', ucwords($pembayaran->metode_pembayaran)); ?></p>
                                                <p class="mb-1">
                                                    <strong>Status:</strong> 
                                                    <span class="badge <?php echo ($pembayaran->status == 'verified') ? 'bg-success' : (($pembayaran->status == 'pending') ? 'bg-warning' : 'bg-danger'); ?>">
                                                        <?php echo ucfirst($pembayaran->status); ?>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <?php if(!empty($pembayaran->bukti_pembayaran)): ?>
                                                    <p class="mb-1"><strong>Bukti Pembayaran:</strong></p>
                                                    <img src="<?php echo BASE_URL; ?>/app/public/uploads/bukti_pembayaran/<?php echo $pembayaran->bukti_pembayaran; ?>" class="img-fluid img-thumbnail" alt="Bukti Pembayaran" style="max-height: 150px;">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                Belum ada pembayaran untuk pemesanan ini.
                                <?php if($data['pemesanan']->status == 'pending'): ?>
                                    <a href="<?php echo BASE_URL; ?>/dashboard/pembayaran/<?php echo $data['pemesanan']->id; ?>" class="alert-link">Lakukan pembayaran sekarang</a>.
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> 