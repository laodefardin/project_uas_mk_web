<?php
if (session_status() === PHP_SESSION_NONE){
    session_start();
}

function simpanLogin($akun){
    session_regenerate_id(true);

    $_SESSION['id']    = $akun['id'];
    $_SESSION['username'] = $akun['username'];
    $_SESSION['nama'] = $akun['nama'];
    $_SESSION['hak_akses'] = $akun['hak_akses'];
}

function sudahLogin(){
    return isset($_SESSION['id']);
}

function hapusLogin(){
    $_SESSION = [];

    if(ini_get("session.use_cookies")){
        $parameter = session_get_cookie_params();

        setcookie(
            session_name(), 
            '',
            time() - 4200,
            $parameter['path'],
            $parameter['domain'],
            $parameter['secure'],
            $parameter['httponly']
        );
    }
    session_destroy();
}

function wajibLogin(){
    if (!sudahLogin()){
        header("Location: " . url('login', ['error' => 'Silakan masuk terlebih dahulu.']));
        exit;
    }
}

function setPesan($tipe, $isi){
    $_SESSION['pesan_tipe'] = $tipe;
    $_SESSION['pesan_isi'] = $isi;
}


function ambilPesan(){
    if(!isset($_SESSION['pesan_isi'])){
        return null;
    }
    $pesan = [
        'tipe' => $_SESSION['pesan_tipe'],
        'isi' => $_SESSION['pesan_isi']
    ];

    unset($_SESSION['pesan_tipe'], $_SESSION['pesan_isi']);

    return $pesan;
}