<?php
// Pembayaran details
$pembayaran = $data['pembayaran'];
?>

<div class="row">
    <div class="col-lg-8">
        <!-- Detail Pembayaran Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold">Detail Pembayaran #<?php echo $pembayaran->id; ?></h6>
                <div>
                    <!-- Status badge -->
                    <span class="badge <?php echo ($pembayaran->status == 'verified') ? 'bg-success' : (($pembayaran->status == 'pending') ? 'bg-warning' : 'bg-danger'); ?> fs-6">
                        <?php echo ucfirst($pembayaran->status); ?>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2">Informasi Pembayaran</h5>
                        <p><strong>ID Pembayaran:</strong> #<?php echo $pembayaran->id; ?></p>
                        <p><strong>ID Pemesanan:</strong> <a href="<?php echo BASE_URL; ?>/admin/viewPemesanan/<?php echo $pembayaran->pemesanan_id; ?>">#<?php echo $pembayaran->pemesanan_id; ?></a></p>
                        <p><strong>Tanggal Pembayaran:</strong> <?php echo date('d/m/Y H:i', strtotime($pembayaran->tanggal_pembayaran)); ?></p>
                        <p><strong>Jumlah:</strong> Rp <?php echo number_format($pembayaran->jumlah, 0, ',', '.'); ?></p>
                        <p><strong>Metode Pembayaran:</strong> <?php echo $pembayaran->metode_pembayaran; ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2">Informasi Pelanggan</h5>
                        <p><strong>Nama:</strong> <?php echo $pembayaran->nama_pelanggan; ?></p>
                        <p><strong>Email:</strong> <?php echo $pembayaran->email; ?></p>
                        <p><strong>Telepon:</strong> <?php echo $pembayaran->telepon; ?></p>
                    </div>
                </div>

                <?php if(!empty($pembayaran->catatan)): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Catatan Pembayaran</h5>
                        <p><?php echo $pembayaran->catatan; ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Update status form -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Update Status Pembayaran</h5>
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
                            <div class="form-text mt-2">
                                <strong>Catatan:</strong> Jika status diubah menjadi "Verified", status pemesanan akan otomatis diubah menjadi "Confirmed".
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Bukti Pembayaran Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Bukti Pembayaran</h6>
            </div>
            <div class="card-body">
                <?php if(!empty($pembayaran->bukti_pembayaran)): ?>
                    <div class="text-center">
                        <img src="<?php echo BASE_URL; ?>/app/public/uploads/bukti_pembayaran/<?php echo $pembayaran->bukti_pembayaran; ?>" class="img-fluid img-thumbnail" alt="Bukti Pembayaran">
                        <div class="mt-3">
                            <a href="<?php echo BASE_URL; ?>/app/public/uploads/bukti_pembayaran/<?php echo $pembayaran->bukti_pembayaran; ?>" class="btn btn-info btn-sm" target="_blank">
                                <i class="fas fa-search-plus me-1"></i> Lihat Gambar Penuh
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        Belum ada bukti pembayaran yang diunggah.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tindakan Cepat -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Tindakan Cepat</h6>
            </div>
            <div class="card-body">
                <?php if($pembayaran->status == 'pending'): ?>
                <form action="<?php echo BASE_URL; ?>/admin/updatePembayaranStatus/<?php echo $pembayaran->id; ?>" method="post" class="d-grid gap-2 mb-2">
                    <input type="hidden" name="status" value="verified">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i> Verifikasi Pembayaran
                    </button>
                </form>
                <form action="<?php echo BASE_URL; ?>/admin/updatePembayaranStatus/<?php echo $pembayaran->id; ?>" method="post" class="d-grid gap-2">
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i> Tolak Pembayaran
                    </button>
                </form>
                <?php endif; ?>
                
                <div class="d-grid gap-2 mt-3">
                    <a href="<?php echo BASE_URL; ?>/admin/pembayaran" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Pembayaran
                    </a>
                    <a href="<?php echo BASE_URL; ?>/admin/viewPemesanan/<?php echo $pembayaran->pemesanan_id; ?>" class="btn btn-primary">
                        <i class="fas fa-eye me-1"></i> Lihat Detail Pemesanan
                    </a>
                    <a href="<?php echo BASE_URL; ?>/admin/deletePembayaran/<?php echo $pembayaran->id; ?>" class="btn btn-outline-danger" onclick="return confirm('Anda yakin ingin menghapus pembayaran ini?');">
                        <i class="fas fa-trash me-1"></i> Hapus Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> 