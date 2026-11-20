<?php
$pesanError = $_GET['error'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Sistem Data Mahasiswa</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container" style="max-width: 580px; margin-top: 60px">
        <div class="card">
            <div class="card-body py-4">
                <h4 class="mb-1">Daftar Akun Baru</h4>
                <p class="text-muted small mb-4">
                    Akun ini dipakai untuk masuk ke aplikasi data mahasiswa
                </p>

                <?php if ($pesanError !== ""):?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($pesanError, ENT_QUOTES, 'UTF-8'); ?>
                </div>                    
                <?php endif; ?>
            

                <form action="index.php?act=simpanRegister" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                        <div class="form-text">Minimal 4 Karakter, tanpa spasi</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                        <div class="form-text">Minimal 8 Karakter</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </form>
                <p class="text-center mt-3 mb-0 small">
                    Sudah punya akun?
                    <a href="index.php?act=login">Masuk disini</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>