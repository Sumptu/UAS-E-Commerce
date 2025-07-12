<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold">Daftar Paket</h6>
        <a href="<?php echo BASE_URL; ?>/admin/addPaket" class="btn btn-primary btn-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah Paket
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Paket</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th>Jumlah Foto</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['pakets'])) : ?>
                        <?php foreach ($data['pakets'] as $paket) : ?>
                            <tr>
                                <td><?php echo $paket->id; ?></td>
                                <td><?php echo $paket->nama_paket; ?></td>
                                <td>Rp <?php echo number_format($paket->harga, 0, ',', '.'); ?></td>
                                <td><?php echo $paket->durasi; ?> jam</td>
                                <td><?php echo $paket->jumlah_foto; ?></td>
                                <td>
                                    <span class="badge <?php echo ($paket->is_active) ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo ($paket->is_active) ? 'Aktif' : 'Tidak Aktif'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/admin/editPaket/<?php echo $paket->id; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/admin/togglePaket/<?php echo $paket->id; ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-toggle-on"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/admin/deletePaket/<?php echo $paket->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus paket ini?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data paket</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div> 