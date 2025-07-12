<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Filter Laporan</h6>
    </div>
    <div class="card-body">
        <form action="<?php echo BASE_URL; ?>/admin/laporan" method="GET" class="mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $data['startDate']; ?>">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $data['endDate']; ?>">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Laporan Pemesanan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered data-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Paket</th>
                                <th>Status</th>
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
                                        <td>
                                            <span class="badge <?php echo ($order->status == 'completed') ? 'bg-success' : (($order->status == 'confirmed') ? 'bg-info' : (($order->status == 'pending') ? 'bg-warning' : 'bg-danger')); ?>">
                                                <?php echo ucfirst($order->status); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data pemesanan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Laporan Pembayaran</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered data-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Pemesanan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['pembayaran'])) : ?>
                                <?php foreach ($data['pembayaran'] as $payment) : ?>
                                    <tr>
                                        <td><?php echo $payment->id; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($payment->tanggal_pembayaran)); ?></td>
                                        <td><?php echo $payment->pemesanan_id; ?></td>
                                        <td>Rp <?php echo number_format($payment->jumlah, 0, ',', '.'); ?></td>
                                        <td>
                                            <span class="badge <?php echo ($payment->status == 'verified') ? 'bg-success' : (($payment->status == 'pending') ? 'bg-warning' : 'bg-danger'); ?>">
                                                <?php echo ucfirst($payment->status); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data pembayaran</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Ringkasan</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card border-left-primary">
                    <div class="card-body py-3">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Pemesanan</div>
                        <div class="h4 mb-0 fw-bold"><?php echo count($data['pemesanan']); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-left-success">
                    <div class="card-body py-3">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">Total Pembayaran</div>
                        <div class="h4 mb-0 fw-bold">
                            <?php
                            $totalPayment = 0;
                            if (!empty($data['pembayaran'])) {
                                foreach ($data['pembayaran'] as $payment) {
                                    if ($payment->status == 'verified') {
                                        $totalPayment += $payment->jumlah;
                                    }
                                }
                            }
                            echo 'Rp ' . number_format($totalPayment, 0, ',', '.');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-left-info">
                    <div class="card-body py-3">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">Pemesanan Selesai</div>
                        <div class="h4 mb-0 fw-bold">
                            <?php
                            $completedOrders = 0;
                            if (!empty($data['pemesanan'])) {
                                foreach ($data['pemesanan'] as $order) {
                                    if ($order->status == 'completed') {
                                        $completedOrders++;
                                    }
                                }
                            }
                            echo $completedOrders;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 