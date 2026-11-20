<?php
require_once __DIR__ . '/../../config/helper.php';
require_once __DIR__ . '/../../config/session.php';
$pesanError = $_GET['error'] ?? "";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SIAKAD Kampusku</title>
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
    <div class="container" style="max-width: 480px; padding-top: 60px; padding-bottom: 40px;">
        <div class="card login-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="brand-icon">
                        <i class="bi bi-person-plus-fill text-primary fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-semibold">Daftar Akun Baru</h5>
                        <p class="text-muted small mb-0">SIAKAD - PTI FKIP Unsulbar</p>
                    </div>
                </div>

                <?php if ($pesanError !== ""):?>
                <div class="alert alert-danger py-2 small" role="alert">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    <?php echo htmlspecialchars($pesanError, ENT_QUOTES, 'UTF-8'); ?>
                </div>                    
                <?php endif; ?>

                <form action="<?= url('simpanRegister') ?>" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                    <div class="mb-3">
                        <label class="form-label fw-medium small">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama lengkap Anda" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Minimal 4 karakter" required>
                        <div class="form-text small">Minimal 4 karakter, tanpa spasi</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium small">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                        <div class="form-text small">Minimal 8 karakter</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-person-check me-2"></i>Daftar Sekarang
                    </button>
                </form>

                <p class="text-center mt-3 mb-0 small text-muted">
                    Sudah punya akun?
                    <a href="<?= url('login') ?>" class="text-primary text-decoration-none fw-medium">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
