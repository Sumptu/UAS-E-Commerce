<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mb-4">Riwayat Pembayaran</h1>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pembayaran Saya</h6>
                </div>
                <div class="card-body">
                    <?php if(empty($data['pembayaran'])) : ?>
                        <div class="text-center py-5">
                            <i class="fas fa-money-bill-wave fa-3x text-gray-300 mb-3"></i>
                            <p class="mb-0">Anda belum memiliki riwayat pembayaran.</p>
                            <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-primary mt-3">Kembali ke Dashboard</a>
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
                                        <th>Jumlah Dibayar</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Metode</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($data['pembayaran'] as $pembayaran) : ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $pembayaran->nama_paket; ?></td>
                                            <td><?php echo date('d F Y', strtotime($pembayaran->tanggal_acara)); ?></td>
                                            <td>Rp <?php echo number_format($pembayaran->total_harga, 0, ',', '.'); ?></td>
                                            <td>Rp <?php echo number_format($pembayaran->jumlah, 0, ',', '.'); ?></td>
                                            <td><?php echo date('d F Y', strtotime($pembayaran->tanggal_pembayaran)); ?></td>
                                            <td><?php echo ucfirst($pembayaran->metode_pembayaran); ?></td>
                                            <td>
                                                <?php if($pembayaran->status == 'pending') : ?>
                                                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                                <?php elseif($pembayaran->status == 'verified') : ?>
                                                    <span class="badge bg-success">Terverifikasi</span>
                                                <?php elseif($pembayaran->status == 'rejected') : ?>
                                                    <span class="badge bg-danger">Ditolak</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo BASE_URL; ?>/dashboard/detail/<?php echo $pembayaran->pemesanan_id; ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 