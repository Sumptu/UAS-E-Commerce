<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold">Daftar Pemesanan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Nama Pelanggan</th>
                        <th>Paket</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['pemesanan'])) : ?>
                        <?php foreach ($data['pemesanan'] as $order) : ?>
                            <tr>
                                <td><?php echo $order->id; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($order->tanggal_pemesanan)); ?></td>
                                <td><?php echo $order->nama_pelanggan; ?></td>
                                <td><?php echo $order->nama_paket; ?></td>
                                <td>Rp <?php echo number_format($order->total_harga, 0, ',', '.'); ?></td>
                                <td>
                                    <?php
                                    $badge_class = 'bg-secondary';
                                    switch ($order->status) {
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
                                        <?php echo ucfirst($order->status); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/admin/viewPemesanan/<?php echo $order->id; ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/admin/deletePemesanan/<?php echo $order->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus pemesanan ini?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pemesanan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div> 