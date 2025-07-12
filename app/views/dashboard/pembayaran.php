<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-lg mb-5">
                <div class="card-header bg-primary text-white">
                    <h4 class="m-0">Form Pembayaran</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <h5 class="alert-heading">Informasi Pemesanan</h5>
                        <p class="mb-0"><strong>Paket:</strong> <?php echo $data['pemesanan']->nama_paket; ?></p>
                        <p class="mb-0"><strong>Tanggal Acara:</strong> <?php echo date('d F Y', strtotime($data['pemesanan']->tanggal_acara)); ?></p>
                        <p class="mb-0"><strong>Lokasi:</strong> <?php echo $data['pemesanan']->lokasi_acara; ?></p>
                        <p><strong>Total Harga:</strong> Rp <?php echo number_format($data['pemesanan']->total_harga, 0, ',', '.'); ?></p>
                    </div>
                
                    <form action="<?php echo BASE_URL; ?>/dashboard/pembayaran/<?php echo $data['pemesanan']->id; ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Pembayaran</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="jumlah" id="jumlah" class="form-control <?php echo (!empty($data['jumlah_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['jumlah']; ?>">
                                <span class="invalid-feedback"><?php echo $data['jumlah_err']; ?></span>
                            </div>
                            <small class="text-muted">Jumlah harus sama dengan atau lebih dari total harga</small>
                        </div>
                        
                        <div class="mb-4">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-control <?php echo (!empty($data['metode_pembayaran_err'])) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                <option value="transfer_bank" <?php echo ($data['metode_pembayaran'] == 'transfer_bank') ? 'selected' : ''; ?>>Transfer Bank</option>
                                <option value="e-wallet" <?php echo ($data['metode_pembayaran'] == 'e-wallet') ? 'selected' : ''; ?>>E-Wallet (OVO, GoPay, DANA)</option>
                                <option value="kartu_kredit" <?php echo ($data['metode_pembayaran'] == 'kartu_kredit') ? 'selected' : ''; ?>>Kartu Kredit</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $data['metode_pembayaran_err']; ?></span>
                        </div>
                        
                        <div class="mb-4">
                            <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
                            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control <?php echo (!empty($data['bukti_pembayaran_err'])) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $data['bukti_pembayaran_err']; ?></span>
                            <small class="text-muted">Upload foto/screenshot bukti pembayaran Anda (JPG, PNG, PDF, max 2MB)</small>
                        </div>
                        
                        <div class="border rounded p-3 mb-4 bg-light">
                            <h5 class="mb-3">Informasi Rekening</h5>
                            <p class="mb-2"><strong>Bank BCA</strong><br>No. Rekening: 1234567890<br>Atas Nama: PT Foto Studio Prewedding</p>
                            <p class="mb-0"><strong>Bank Mandiri</strong><br>No. Rekening: 0987654321<br>Atas Nama: PT Foto Studio Prewedding</p>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Kirim Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 