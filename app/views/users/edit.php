<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-lg mb-5">
                <div class="card-header bg-primary text-white">
                    <h4 class="m-0">Edit Profil</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo BASE_URL; ?>/users/edit" method="post" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?php echo $data['username']; ?>" required>
                            <div class="invalid-feedback">
                                <?php echo $data['username_err']; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control <?php echo (!empty($data['nama_err'])) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?php echo $data['nama']; ?>" required>
                            <div class="invalid-feedback">
                                <?php echo $data['nama_err']; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo $data['email']; ?>" required>
                            <div class="invalid-feedback">
                                <?php echo $data['email_err']; ?>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" id="password" name="password">
                            <div class="invalid-feedback">
                                <?php echo $data['password_err']; ?>
                            </div>
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                        </div>
                        
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" id="confirm_password" name="confirm_password">
                            <div class="invalid-feedback">
                                <?php echo $data['confirm_password_err']; ?>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?php echo BASE_URL; ?>/users/profile" class="btn btn-secondary me-md-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 