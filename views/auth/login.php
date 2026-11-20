<?php
require_once __DIR__ . '/../../config/helper.php';
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fb; }
        .login-card { border: none; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .btn { border-radius: 8px; font-weight: 500; }
        .form-control { border-radius: 8px; font-size: 0.9rem; }
        .brand-icon { width: 48px; height: 48px; background: #e8f0fe; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 400px; padding-top: 80px;">
        <div class="card login-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="brand-icon">
                        <i class="bi bi-mortarboard-fill text-primary fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-semibold">Masuk ke SIAKAD</h5>
                        <p class="text-muted small mb-0">PTI FKIP Unsulbar</p>
                    </div>
                </div>

                <?php if ($pesanSukses !== ""): ?>
                <div class="alert alert-success py-2 small" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    <?php echo htmlspecialchars($pesanSukses, ENT_QUOTES, 'UTF-8');?>
                </div>
                <?php endif; ?>

                <?php if ($pesanError !== ""): ?>
                <div class="alert alert-danger py-2 small" role="alert">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    <?php echo htmlspecialchars($pesanError, ENT_QUOTES, 'UTF-8');?>
                </div>
                <?php endif; ?>

                <form action="<?php echo url('prosesLogin'); ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-medium small">Username</label>
                        <input type="text" name="username" class="form-control" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium small">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </button>
                </form>

                <p class="text-center mt-3 mb-0 small text-muted">
                    Belum punya akun?
                    <a href="<?= url('register') ?>" class="text-primary text-decoration-none fw-medium">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
