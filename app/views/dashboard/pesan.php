<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-lg mb-5">
                <div class="card-header bg-primary text-white">
                    <h4 class="m-0">Form Pemesanan Paket</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo BASE_URL; ?>/dashboard/pesan" method="post">
                        <div class="mb-3">
                            <label for="paket_id" class="form-label">Pilih Paket</label>
                            <select name="paket_id" id="paket_id" class="form-control <?php echo (!empty($data['paket_id_err'])) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih Paket --</option>
                                <?php foreach($data['pakets'] as $paket) : ?>
                                    <option value="<?php echo $paket->id; ?>" <?php echo ($data['paket_id'] == $paket->id) ? 'selected' : ''; ?>>
                                        <?php echo $paket->nama_paket; ?> - Rp <?php echo number_format($paket->harga, 0, ',', '.'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $data['paket_id_err']; ?></span>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_kontak" class="form-label">Nama Kontak</label>
                                    <input type="text" name="nama_kontak" id="nama_kontak" class="form-control <?php echo (!empty($data['nama_kontak_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['nama_kontak'] ?? $_SESSION['nama']; ?>" placeholder="Nama yang bisa dihubungi">
                                    <span class="invalid-feedback"><?php echo $data['nama_kontak_err'] ?? ''; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                    <input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control <?php echo (!empty($data['nomor_telepon_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['nomor_telepon'] ?? ''; ?>" placeholder="Nomor telepon yang bisa dihubungi">
                                    <span class="invalid-feedback"><?php echo $data['nomor_telepon_err'] ?? ''; ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tanggal_acara" class="form-label">Tanggal Acara</label>
                            <input type="date" name="tanggal_acara" id="tanggal_acara" class="form-control <?php echo (!empty($data['tanggal_acara_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['tanggal_acara']; ?>">
                            <span class="invalid-feedback"><?php echo $data['tanggal_acara_err']; ?></span>
                        </div>
                        
                        <div class="mb-3">
                            <label for="lokasi_acara" class="form-label">Lokasi Acara</label>
                            <input type="text" name="lokasi_acara" id="lokasi_acara" class="form-control <?php echo (!empty($data['lokasi_acara_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['lokasi_acara']; ?>" placeholder="Masukkan lokasi acara">
                            <span class="invalid-feedback"><?php echo $data['lokasi_acara_err']; ?></span>
                        </div>
                        
                        <div class="mb-4">
                            <label for="catatan" class="form-label">Catatan Tambahan</label>
                            <textarea name="catatan" id="catatan" class="form-control" rows="4" placeholder="Masukkan catatan atau permintaan khusus (opsional)"><?php echo $data['catatan']; ?></textarea>
                        </div>
                        
                        <div id="paket-detail" class="border rounded p-3 mb-4 bg-light d-none">
                            <h5 class="mb-3">Detail Paket</h5>
                            <div id="paket-info">
                                <!-- Detail paket akan dimuat di sini via JavaScript -->
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Pesan Sekarang</button>
                            <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paketSelect = document.getElementById('paket_id');
    const paketDetail = document.getElementById('paket-detail');
    const paketInfo = document.getElementById('paket-info');
    
    paketSelect.addEventListener('change', function() {
        const paketId = this.value;
        
        if (paketId) {
            // Tampilkan div detail paket
            paketDetail.classList.remove('d-none');
            
            // Ambil detail paket via AJAX
            fetch(`<?php echo BASE_URL; ?>/dashboard/getPaketDetail/${paketId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    paketInfo.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                } else {
                    paketInfo.innerHTML = `
                        <p class="mb-1"><strong>Nama Paket:</strong> ${data.nama_paket}</p>
                        <p class="mb-1"><strong>Deskripsi:</strong> ${data.deskripsi}</p>
                        <p class="mb-1"><strong>Durasi:</strong> ${data.durasi} jam</p>
                        <p class="mb-1"><strong>Jumlah Foto:</strong> ${data.jumlah_foto} foto</p>
                        <p class="mb-0"><strong>Harga:</strong> Rp ${numberFormat(data.harga)}</p>
                    `;
                }
            })
            .catch(error => {
                paketInfo.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan saat memuat detail paket.</div>`;
                console.error('Error:', error);
            });
        } else {
            paketDetail.classList.add('d-none');
        }
    });
    
    // Format angka ke format rupiah
    function numberFormat(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }
    
    // Cek ketersediaan tanggal
    const tanggalInput = document.getElementById('tanggal_acara');
    tanggalInput.addEventListener('change', function() {
        const tanggal = this.value;
        
        if (tanggal) {
            fetch(`<?php echo BASE_URL; ?>/dashboard/checkTanggalTersedia`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ tanggal: tanggal })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.available) {
                    this.classList.add('is-invalid');
                    this.nextElementSibling.textContent = data.message;
                } else {
                    this.classList.remove('is-invalid');
                    this.nextElementSibling.textContent = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
});
</script> 