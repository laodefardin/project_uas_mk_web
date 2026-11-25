<?php
require_once __DIR__ . '/../../config/helper.php';
require_once __DIR__ . '/../../config/session.php';
$aset = rtrim(BASE_URL, '/') . '/assets';
$pesanError = $_GET['error'] ?? '';
$pesanSukses = '';

if (($_GET['pesan'] ?? '') === 'akun_buat'){
    $pesanSukses = "Akun berhasil dibuat. Silakan masuk.";
}
if (($_GET['pesan'] ?? '') === 'keluar'){
    $pesanSukses = "Anda telah keluar dari aplikasi.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIAKAD Kampusku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&family=Instrument+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e($aset); ?>/css/app.css?v=<?= filemtime(__DIR__ . '/../../assets/css/app.css'); ?>">
</head>
<body>
    <div class="auth">
        <div class="auth-form">
            <div class="auth-top">
                <a class="brand" href="<?= e(url('index')); ?>"><?= tandaMerek(); ?>SIAKAD <span>Kampusku</span></a>
                <a class="auth-back" href="<?= e(url('index')); ?>"><i class="bi bi-arrow-left"></i>Beranda</a>
            </div>

            <div class="auth-card">
                <h1 class="auth-title rise">Masuk</h1>
                <p class="auth-sub rise rise-1">Kelola data mahasiswa PTI FKIP Unsulbar</p>

                <?php if ($pesanSukses !== ""): ?>
                <div class="alert alert-success" role="alert">
                    <?= e($pesanSukses); ?>
                </div>
                <?php endif; ?>

                <?php if ($pesanError !== ""): ?>
                <div class="alert alert-danger" role="alert">
                    <?= e($pesanError); ?>
                </div>
                <?php endif; ?>

                <form action="<?= e(url('prosesLogin')); ?>" method="POST" class="rise rise-2">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken(); ?>">
                    <div>
                        <label class="form-label" for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" autocomplete="username" required autofocus>
                    </div>
                    <div>
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form>

                <p class="auth-alt">Belum punya akun? <a href="<?= e(url('register')); ?>">Buat akun</a></p>
            </div>

            <div class="auth-foot">PTI FKIP Universitas Sulawesi Barat</div>
        </div>

        <div class="auth-art" role="img" aria-label="Sandeq, perahu layar tradisional Mandar, berlayar di laut tenang saat pagi"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
