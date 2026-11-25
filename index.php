<?php

spl_autoload_register(function($class) {
    $paths = [
        __DIR__ . '/controllers/' . $class . '.php',
        __DIR__ . '/models/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/config/helper.php';

$controller = new MahasiswaController();
$auth       = new AuthController();

$aksi = $_GET['act'] ?? 'index';

switch ($aksi) {

    // Halaman publik tanpa login
    case 'login':
        $auth->login();
        break;

    case 'prosesLogin':
        $auth->prosesLogin();
        break;

    case 'register':
        $auth->register();
        break;
    
    case 'simpanRegister':
        $auth->simpanRegister();
        break;
    
    case 'logout':
        $auth->logout();
        break;

    // Halaman yang wajib login
    case 'profil':
        wajibLogin();
        $auth->profil();
        break;

    case 'updatePassword':
        wajibLogin();
        $auth->updatePassword();
        break;

    case 'exportCsv':
        wajibLogin();
        $controller->exportCsv();
        break;

    case 'cetakLaporan':
        wajibLogin();
        $controller->cetakLaporan();
        break;

    case 'cetakKtm':
        wajibLogin();
        $controller->cetakKtm();
        break;

    case 'hapus':
        wajibLogin();
        $controller->hapus();
        break;

    case 'edit':
        wajibLogin();
        $controller->edit();
        break;

    case 'update':
        wajibLogin();
        $controller->update();
        break;

    case 'tambah':
        wajibLogin();
        $controller->tambah();
        break;

    case 'simpan':
        wajibLogin();
        $controller->simpan();
        break;

    case 'index':
    default:
        // Pengunjung yang belum login melihat landing page
        if (!sudahLogin()) {
            $auth->landing();
            break;
        }
        $controller->index();
        break;
}
