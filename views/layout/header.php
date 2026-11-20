<?php
require_once __DIR__ . '/../../config/helper.php';
require_once __DIR__ . '/../../config/session.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul_halaman ?? 'Sistem Informasi Akademik - PTI Unsulbar' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fb; }
        .navbar-brand { font-weight: 700; letter-spacing: -0.02em; }
        .card { border-radius: 12px; }
        .card-header { border-radius: 12px 12px 0 0 !important; }
        .btn { border-radius: 8px; font-weight: 500; }
        .table th { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #6c757d; border-bottom: 1px solid #e9ecef; }
        .table td { font-size: 0.875rem; vertical-align: middle; }
        .badge { font-weight: 500; border-radius: 6px; font-size: 0.75rem; }
        code { font-size: 0.8rem; color: #0d6efd; background: #f0f4ff; padding: 2px 6px; border-radius: 4px; }
        .form-control, .form-select { border-radius: 8px; font-size: 0.875rem; }
        .pagination .page-link { border-radius: 6px !important; margin: 0 2px; }
        .alert { border-radius: 10px; font-size: 0.875rem; }
        .avatar-sm { width: 36px; height: 36px; object-fit: cover; border-radius: 50%; }
        .avatar-placeholder { width: 36px; height: 36px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: #e9ecef; color: #6c757d; font-size: 0.8rem; font-weight: 600; }
        .stat-card { border: none; border-radius: 12px; transition: transform 0.15s ease-in-out; }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand text-primary d-flex align-items-center" href="<?php echo url('index'); ?>">
                <i class="bi bi-mortarboard-fill me-2 fs-4"></i>
                <span>SIAKAD<span class="text-secondary fw-normal fs-6 ms-1">KAMPUSKU</span></span>
            </a>

            <?php if (sudahLogin()): ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-medium" href="<?= url('index'); ?>">
                            <i class="bi bi-people me-1"></i>Data Mahasiswa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="<?= url('cetakLaporan'); ?>" target="_blank">
                            <i class="bi bi-printer me-1"></i>Cetak Laporan
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                            <div class="avatar-placeholder" style="width: 26px; height: 26px; font-size: 0.7rem;">
                                <?= strtoupper(substr($_SESSION['nama'] ?? 'A', 0, 1)) ?>
                            </div>
                            <span class="fw-medium small"><?= htmlspecialchars($_SESSION['nama'] ?? 'Admin', ENT_QUOTES, 'UTF-8'); ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <h6 class="dropdown-header small text-muted">
                                    Login sebagai: <?= htmlspecialchars($_SESSION['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                </h6>
                            </li>
                            <li>
                                <a class="dropdown-item small" href="<?= url('profil'); ?>">
                                    <i class="bi bi-key me-2 text-primary"></i>Ganti Password
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item small text-danger" href="<?= url('logout'); ?>" onclick="return confirm('Keluar dari aplikasi?')">
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

    <div class="container py-4 mb-5">
