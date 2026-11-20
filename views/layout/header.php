<?php
require_once __DIR__ . '/../../config/helper.php';
require_once __DIR__ . '/../../config/session.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul_halaman ?? 'SIAKAD - PTI Unsulbar' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background-color: #f4f6f9; color: #212529; }
        .navbar-brand { font-weight: 700; letter-spacing: -0.02em; }
        .card { border-radius: 10px; border: 1px solid #e5e7eb; }
        .card-header { border-radius: 10px 10px 0 0 !important; border-bottom: 1px solid #e5e7eb; }
        .btn { border-radius: 6px; font-weight: 500; }
        .table th { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; color: #64748b; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 0.75rem; }
        .table td { font-size: 0.86rem; vertical-align: middle; padding: 0.75rem 0.75rem; border-bottom: 1px solid #f1f5f9; }
        .table tr:last-child td { border-bottom: none; }
        .badge { font-weight: 500; border-radius: 5px; }
        .form-control, .form-select { border-radius: 6px; font-size: 0.86rem; border-color: #cbd5e1; }
        .form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.12); }
        .pagination .page-link { border-radius: 5px !important; margin: 0 2px; font-size: 0.82rem; }
        .alert { border-radius: 8px; font-size: 0.86rem; }
        .avatar-sm { width: 34px; height: 34px; object-fit: cover; border-radius: 50%; }
        .avatar-placeholder { width: 34px; height: 34px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: #e2e8f0; color: #475569; font-size: 0.78rem; font-weight: 600; }
        .btn-group-sm > .btn { padding: 0.25rem 0.45rem; font-size: 0.8rem; }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top py-2">
        <div class="container">
            <a class="navbar-brand text-primary d-flex align-items-center py-1" href="<?php echo url('index'); ?>">
                <i class="bi bi-mortarboard-fill me-2 fs-4"></i>
                <span class="fs-5 fw-bold">SIAKAD<span class="text-secondary fw-normal fs-6 ms-1">KAMPUSKU</span></span>
            </a>

            <?php if (sudahLogin()): ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-medium small" href="<?= url('index'); ?>">
                            <i class="bi bi-people me-1"></i>Data Mahasiswa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted small" href="<?= url('cetakLaporan'); ?>" target="_blank">
                            <i class="bi bi-printer me-1"></i>Cetak Laporan
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border dropdown-toggle d-flex align-items-center gap-2 py-1 px-2" type="button" data-bs-toggle="dropdown">
                            <div class="avatar-placeholder" style="width: 24px; height: 24px; font-size: 0.68rem;">
                                <?= strtoupper(substr($_SESSION['nama'] ?? 'A', 0, 1)) ?>
                            </div>
                            <span class="fw-medium small"><?= htmlspecialchars($_SESSION['nama'] ?? 'Admin', ENT_QUOTES, 'UTF-8'); ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2" style="font-size: 0.85rem;">
                            <li class="px-3 py-1">
                                <div class="fw-semibold text-dark"><?= htmlspecialchars($_SESSION['nama'] ?? 'Admin', ENT_QUOTES, 'UTF-8'); ?></div>
                                <div class="text-muted small">@<?= htmlspecialchars($_SESSION['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
                            </li>
                            <li><hr class="dropdown-divider my-2"></li>
                            <li>
                                <a class="dropdown-item py-2" href="<?= url('profil'); ?>">
                                    <i class="bi bi-key me-2 text-primary"></i>Ganti Password
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-2"></li>
                            <li>
                                <a class="dropdown-item py-2 text-danger" href="<?= url('logout'); ?>" onclick="return confirm('Keluar dari aplikasi?')">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container py-4 flex-grow-1">
