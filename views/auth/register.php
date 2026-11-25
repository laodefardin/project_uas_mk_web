<?php
require_once __DIR__ . '/../../config/helper.php';
require_once __DIR__ . '/../../config/session.php';
$aset = rtrim(BASE_URL, '/') . '/assets';
$pesanError = $_GET['error'] ?? "";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun - SIAKAD Kampusku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&family=Instrument+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e($aset); ?>/css/app.css">
</head>
<body>
    <div class="auth">
        <div class="auth-form">
            <div class="auth-top">
                <a class="brand" href="<?= e(url('index')); ?>"><?= tandaMerek(); ?>SIAKAD <span>Kampusku</span></a>
                <a class="auth-back" href="<?= e(url('index')); ?>"><i class="bi bi-arrow-left"></i>Beranda</a>
            </div>

            <div class="auth-card">
                <h1 class="auth-title rise">Buat akun</h1>
                <p class="auth-sub rise rise-1">Akun baru masuk sebagai operator</p>

                <?php if ($pesanError !== ""): ?>
                <div class="alert alert-danger" role="alert">
                    <?= e($pesanError); ?>
                </div>
                <?php endif; ?>

                <form action="<?= e(url('simpanRegister')); ?>" method="POST" class="rise rise-2">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                    <div>
                        <label class="form-label" for="nama">Nama lengkap</label>
                        <input type="text" id="nama" name="nama" class="form-control" autocomplete="name" required autofocus>
                    </div>
                    <div>
                        <label class="form-label" for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" autocomplete="username" required>
                        <div class="form-text">Minimal 4 karakter, tanpa spasi</div>
                    </div>
                    <div>
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" autocomplete="new-password" required>
                        <div class="form-text">Minimal 8 karakter</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Buat akun</button>
                </form>

                <p class="auth-alt">Sudah punya akun? <a href="<?= e(url('login')); ?>">Masuk</a></p>
            </div>

            <div class="auth-foot">PTI FKIP Universitas Sulawesi Barat</div>
        </div>

        <div class="auth-art" role="img" aria-label="Sandeq, perahu layar tradisional Mandar, berlayar di laut tenang saat pagi"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
