<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mb-4">Dashboard Pelanggan</h1>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pemesanan Saya</h6>
                    <a href="<?php echo BASE_URL; ?>/dashboard/pesan" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Pesan Baru
                    </a>
                </div>
                <div class="card-body">
                    <?php if(empty($data['pemesanan'])) : ?>
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-gray-300 mb-3"></i>
                            <p class="mb-0">Anda belum memiliki pemesanan.</p>
                            <a href="<?php echo BASE_URL; ?>/dashboard/pesan" class="btn btn-primary mt-3">Pesan Sekarang</a>
                        </div>
                    <?php else : ?>
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
                                    <?php $no = 1; foreach($data['pemesanan'] as $pemesanan) : ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $pemesanan->nama_paket; ?></td>
                                            <td><?php echo date('d F Y', strtotime($pemesanan->tanggal_acara)); ?></td>
                                            <td>Rp <?php echo number_format($pemesanan->total_harga, 0, ',', '.'); ?></td>
                                            <td>
                                                <?php if($pemesanan->status == 'pending') : ?>
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                <?php elseif($pemesanan->status == 'confirmed') : ?>
                                                    <span class="badge bg-success">Confirmed</span>
                                                <?php elseif($pemesanan->status == 'completed') : ?>
                                                    <span class="badge bg-primary">Completed</span>
                                                <?php elseif($pemesanan->status == 'cancelled') : ?>
                                                    <span class="badge bg-danger">Cancelled</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo BASE_URL; ?>/dashboard/detail/<?php echo $pemesanan->id; ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if($pemesanan->status == 'pending') : ?>
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
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Akun</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Username:</strong> <?php echo $_SESSION['username']; ?></p>
                            <p><strong>Nama:</strong> <?php echo $_SESSION['nama']; ?></p>
                            <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
                            <a href="<?php echo BASE_URL; ?>/users/profile" class="btn btn-primary btn-sm">Lihat Profil</a>
                            <a href="<?php echo BASE_URL; ?>/users/edit" class="btn btn-secondary btn-sm">Edit Profil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 