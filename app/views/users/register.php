<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2 class="text-center mb-4">Daftar Akun</h2>
                <p class="text-center">Silakan isi form berikut untuk mendaftar.</p>
                <form action="<?php echo BASE_URL; ?>/users/register" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>">
                        <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control <?php echo (!empty($data['nama_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['nama']; ?>">
                        <span class="invalid-feedback"><?php echo $data['nama_err']; ?></span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col">
                            <input type="submit" value="Daftar" class="btn btn-primary btn-block w-100">
                        </div>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <p>Sudah memiliki akun? <a href="<?php echo BASE_URL; ?>/users/login">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div> 