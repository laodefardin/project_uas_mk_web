<?php
require_once __DIR__ . '/../../config/helper.php';
require_once __DIR__ . '/../../config/session.php';

$aset      = rtrim(BASE_URL, '/') . '/assets';
$actAktif  = $_GET['act'] ?? 'index';
$menuAktif = match ($actAktif) {
    'tambah', 'simpan' => 'tambah',
    'profil', 'updatePassword' => 'profil',
    default => 'data',
};
$namaUser = $_SESSION['nama'] ?? 'Admin';
$inisial  = strtoupper(substr($namaUser, 0, 1));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul_halaman ?? 'SIAKAD - PTI Unsulbar' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&family=Instrument+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e($aset); ?>/css/app.css?v=<?= filemtime(__DIR__ . '/../../assets/css/app.css'); ?>">
</head>

<body>
    <div class="topbar">
        <a class="brand" href="<?= e(url('index')); ?>"><?= tandaMerek(); ?>SIAKAD <span>Kampusku</span></a>
        <button type="button" id="sideToggle" aria-label="Buka menu" aria-controls="side" aria-expanded="false"><i class="bi bi-list"></i></button>
    </div>
    <div class="scrim" id="scrim"></div>

    <div class="shell">
        <aside class="side" id="side">
            <a class="brand" href="<?= e(url('index')); ?>"><?= tandaMerek(); ?>SIAKAD <span>Kampusku</span></a>

            <div class="side-label">Menu</div>
            <nav class="side-nav" aria-label="Menu utama">
                <a href="<?= e(url('index')); ?>" class="<?= $menuAktif === 'data' ? 'is-active' : ''; ?>">
                    <i class="bi bi-people"></i>Data Mahasiswa
                </a>
                <a href="<?= e(url('tambah')); ?>" class="<?= $menuAktif === 'tambah' ? 'is-active' : ''; ?>">
                    <i class="bi bi-person-plus"></i>Tambah Mahasiswa
                </a>
                <a href="<?= e(url('cetakLaporan')); ?>" target="_blank" rel="noopener">
                    <i class="bi bi-printer"></i>Cetak Laporan
                </a>
            </nav>

            <div class="side-label">Akun</div>
            <nav class="side-nav" aria-label="Menu akun">
                <a href="<?= e(url('profil')); ?>" class="<?= $menuAktif === 'profil' ? 'is-active' : ''; ?>">
                    <i class="bi bi-key"></i>Ganti Password
                </a>
            </nav>

            <div class="side-foot">
                <div class="me">
                    <span class="avatar"><?= e($inisial); ?></span>
                    <div>
                        <b><?= e($namaUser); ?></b>
                        <small>@<?= e($_SESSION['username'] ?? ''); ?></small>
                    </div>
                </div>
                <nav class="side-nav" aria-label="Keluar">
                    <a class="out" href="<?= e(url('logout')); ?>" onclick="return confirm('Keluar dari aplikasi?')">
                        <i class="bi bi-box-arrow-right"></i>Keluar
                    </a>
                </nav>
            </div>
        </aside>

        <main class="main">
            <div class="main-inner">
