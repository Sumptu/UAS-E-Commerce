<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Tambah Paket</h6>
    </div>
    <div class="card-body">
        <form action="<?php echo BASE_URL; ?>/admin/addPaket" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="nama_paket" class="form-label">Nama Paket</label>
                <input type="text" class="form-control <?php echo (!empty($data['nama_paket_err'])) ? 'is-invalid' : ''; ?>" id="nama_paket" name="nama_paket" value="<?php echo $data['nama_paket']; ?>" required>
                <div class="invalid-feedback">
                    <?php echo $data['nama_paket_err']; ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo $data['deskripsi']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="text" class="form-control currency-input <?php echo (!empty($data['harga_err'])) ? 'is-invalid' : ''; ?>" id="harga" name="harga" value="<?php echo $data['harga']; ?>" required>
                <div class="invalid-feedback">
                    <?php echo $data['harga_err']; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="durasi" class="form-label">Durasi (Jam)</label>
                        <input type="number" class="form-control" id="durasi" name="durasi" value="<?php echo $data['durasi']; ?>" min="1" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jumlah_foto" class="form-label">Jumlah Foto</label>
                        <input type="number" class="form-control" id="jumlah_foto" name="jumlah_foto" value="<?php echo $data['jumlah_foto']; ?>" min="1" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="is_active" class="form-label">Status</label>
                <select class="form-select" id="is_active" name="is_active">
                    <option value="1" <?php echo ($data['is_active']) ? 'selected' : ''; ?>>Aktif</option>
                    <option value="0" <?php echo (!$data['is_active']) ? 'selected' : ''; ?>>Tidak Aktif</option>
                </select>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?php echo BASE_URL; ?>/admin/pakets" class="btn btn-secondary me-md-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div> 