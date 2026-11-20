<?php
require_once __DIR__ . '/../../config/helper.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul_halaman ?? 'Sistem Informasi Akademik - PTI Unsulbar' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .navbar-brand { font-weight: 600; letter-spacing: -0.02em; }
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
        .sidebar-accent { border-left: 3px solid #0d6efd; }
    </style>
</head>

<body class="bg-light d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand text-primary" href="<?php echo url('index'); ?>">
                <i class="bi bi-mortarboard-fill me-2"></i>SIAKAD
            </a>
            <?php if(sudahLogin()):?>
            <div class="d-flex align-items-center ms-auto gap-3">
                <span class="text-muted small">
                    <i class="bi bi-person-circle me-1"></i><?php echo htmlspecialchars($_SESSION['nama'], ENT_QUOTES, 'UTF-8');?>
                </span>
                <a href="<?php echo url('logout'); ?>" class="btn btn-sm btn-outline-danger"
                    onclick="return confirm('Keluar dari Aplikasi?')">
                    <i class="bi bi-box-arrow-right me-1"></i>Keluar
                </a>
            </div>
            <?php endif;?>
        </div>
    </nav>

    <div class="container py-4 mb-5">
