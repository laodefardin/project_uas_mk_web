<?php
require_once __DIR__ . '/../../config/helper.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title><?= $judul_halaman ?? 'Sistem Informasi Kampusku - PTI Unsulbar' ?> </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">
    <nav class="navbar md:navbar-expand bg-primary" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo url('index'); ?>">SIAKAD KAMPUSKU</a>
            <?php if(sudahLogin()):?>
            <div class="d-flex align-items-center ms-auto">
                <span class="navbar-text text-white me-3">
                    Masuk sebagai <?php echo htmlspecialchars($_SESSION['nama'], ENT_QUOTES, 'UTF-8');?>
                </span>
                <a href="<?php echo url('logout'); ?>" class="btn btn-outline-light btn-sm"
                    onclick="return confirm('Keluar dari Aplikasi?')"> Keluar</a>
                <?php endif;?>
            </div>
        </div>
    </nav>

    <div class="container mb-5">