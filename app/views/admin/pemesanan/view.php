<?php
// Pemesanan details
$pemesanan = $data['pemesanan'];
$pembayaran = $data['pembayaran'] ?? null;
?>

<div class="row">
    <div class="col-lg-8">
        <!-- Pemesanan details card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold">Detail Pemesanan #<?php echo $pemesanan->id; ?></h6>
                <div>
                    <!-- Status badge -->
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
                    <span class="badge <?php echo $badge_class; ?> fs-6">
                        <?php echo ucfirst($pemesanan->status); ?>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <!-- Pemesanan info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2">Informasi Pemesanan</h5>
                        <p><strong>Tanggal Pemesanan:</strong> <?php echo date('d/m/Y H:i', strtotime($pemesanan->tanggal_pemesanan)); ?></p>
                        <p><strong>Paket:</strong> <?php echo $pemesanan->nama_paket; ?></p>
                        <p><strong>Tanggal Acara:</strong> <?php echo date('d/m/Y', strtotime($pemesanan->tanggal_acara)); ?></p>
                        <p><strong>Lokasi Acara:</strong> <?php echo $pemesanan->lokasi_acara; ?></p>
                        <p><strong>Total Harga:</strong> Rp <?php echo number_format($pemesanan->total_harga, 0, ',', '.'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2">Informasi Pelanggan</h5>
                        <p><strong>Nama:</strong> <?php echo $pemesanan->nama_pelanggan; ?></p>
                        <p><strong>Email:</strong> <?php echo $pemesanan->email; ?></p>
                        <p><strong>Telepon:</strong> <?php echo $pemesanan->telepon; ?></p>
                    </div>
                </div>

                <!-- Detail paket -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Detail Paket</h5>
                        <p><strong>Durasi:</strong> <?php echo $pemesanan->durasi; ?> jam</p>
                        <p><strong>Jumlah Foto:</strong> <?php echo $pemesanan->jumlah_foto; ?> foto</p>
                        <p><strong>Deskripsi:</strong> <?php echo $pemesanan->deskripsi_paket; ?></p>
                    </div>
                </div>

                <!-- Catatan -->
                <?php if(!empty($pemesanan->catatan)): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Catatan Pemesanan</h5>
                        <p><?php echo $pemesanan->catatan; ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Update status form -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Update Status Pemesanan</h5>
                        <form action="<?php echo BASE_URL; ?>/admin/updateStatus/<?php echo $pemesanan->id; ?>" method="post" class="mt-3">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <select name="status" class="form-select">
                                        <option value="pending" <?php echo ($pemesanan->status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="confirmed" <?php echo ($pemesanan->status == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                        <option value="completed" <?php echo ($pemesanan->status == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                        <option value="cancelled" <?php echo ($pemesanan->status == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Pembayaran card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Informasi Pembayaran</h6>
            </div>
            <div class="card-body">
                <?php if($pembayaran): ?>
                    <!-- Payment info -->
                    <p><strong>ID Pembayaran:</strong> #<?php echo $pembayaran->id; ?></p>
                    <p><strong>Tanggal:</strong> <?php echo date('d/m/Y H:i', strtotime($pembayaran->tanggal_pembayaran)); ?></p>
                    <p><strong>Jumlah:</strong> Rp <?php echo number_format($pembayaran->jumlah, 0, ',', '.'); ?></p>
                    <p><strong>Metode:</strong> <?php echo $pembayaran->metode_pembayaran; ?></p>
                    <p>
                        <strong>Status:</strong> 
                        <span class="badge <?php echo ($pembayaran->status == 'verified') ? 'bg-success' : (($pembayaran->status == 'pending') ? 'bg-warning' : 'bg-danger'); ?>">
                            <?php echo ucfirst($pembayaran->status); ?>
                        </span>
                    </p>
                    
                    <?php if(!empty($pembayaran->bukti_pembayaran)): ?>
                        <div class="mt-3">
                            <p><strong>Bukti Pembayaran:</strong></p>
                            <img src="<?php echo BASE_URL; ?>/app/public/uploads/bukti_pembayaran/<?php echo $pembayaran->bukti_pembayaran; ?>" class="img-fluid img-thumbnail" alt="Bukti Pembayaran">
                        </div>
                    <?php endif; ?>
                    
                    <!-- Verifikasi pembayaran form -->
                    <div class="mt-4">
                        <h6 class="border-bottom pb-2">Update Status Pembayaran</h6>
                        <form action="<?php echo BASE_URL; ?>/admin/updatePembayaranStatus/<?php echo $pembayaran->id; ?>" method="post" class="mt-3">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <select name="status" class="form-select">
                                        <option value="pending" <?php echo ($pembayaran->status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="verified" <?php echo ($pembayaran->status == 'verified') ? 'selected' : ''; ?>>Verified</option>
                                        <option value="rejected" <?php echo ($pembayaran->status == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        Belum ada pembayaran untuk pemesanan ini.
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Action buttons -->
        <div class="d-grid gap-2">
            <a href="<?php echo BASE_URL; ?>/admin/pemesanan" class="btn btn-secondary">Kembali ke Daftar Pemesanan</a>
            <a href="<?php echo BASE_URL; ?>/admin/deletePemesanan/<?php echo $pemesanan->id; ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus pemesanan ini?');">Hapus Pemesanan</a>
        </div>
    </div>
</div> 