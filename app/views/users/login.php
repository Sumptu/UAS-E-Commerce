<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2 class="text-center mb-4">Masuk</h2>
                <p class="text-center">Silakan masuk untuk mengakses akun Anda.</p>
                <form action="<?php echo BASE_URL; ?>/users/login" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>">
                        <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
                    </div>    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <input type="submit" value="Masuk" class="btn btn-primary btn-block w-100">
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="<?php echo BASE_URL; ?>/users/forgotPassword">Lupa Password?</a>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <p>Belum memiliki akun? <a href="<?php echo BASE_URL; ?>/users/register">Daftar</a></p>
                </div>
            </div>
        </div>
    </div>
</div> 