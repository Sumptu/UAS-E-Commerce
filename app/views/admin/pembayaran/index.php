<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold">Daftar Pembayaran</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Pemesanan ID</th>
                        <th>Pelanggan</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['pembayaran'])) : ?>
                        <?php foreach ($data['pembayaran'] as $payment) : ?>
                            <tr>
                                <td><?php echo $payment->id; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($payment->tanggal_pembayaran)); ?></td>
                                <td><?php echo $payment->pemesanan_id; ?></td>
                                <td><?php echo $payment->nama_pelanggan; ?></td>
                                <td>Rp <?php echo number_format($payment->jumlah, 0, ',', '.'); ?></td>
                                <td><?php echo $payment->metode_pembayaran; ?></td>
                                <td>
                                    <?php
                                    $badge_class = 'bg-secondary';
                                    switch ($payment->status) {
                                        case 'pending':
                                            $badge_class = 'bg-warning';
                                            break;
                                        case 'verified':
                                            $badge_class = 'bg-success';
                                            break;
                                        case 'rejected':
                                            $badge_class = 'bg-danger';
                                            break;
                                    }
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?>">
                                        <?php echo ucfirst($payment->status); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/admin/viewPembayaran/<?php echo $payment->id; ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/admin/deletePembayaran/<?php echo $payment->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus pembayaran ini?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data pembayaran</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div> 