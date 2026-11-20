<?php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/helper.php';

class AuthController{
    private $model;

    public function __construct(){
        $this->model = new UserModel();
    }

    public function register(){
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function simpanRegister(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header("Location: index.php?act=register");
            exit;
        }

        verifyCsrfToken($_POST['csrf_token'] ?? '');

        $nama   = trim($_POST['nama'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $error = "";

        if(strlen($nama) < 3){
            $error .= "Nama minimal 3 Karakter ";
        }

        if(strlen($username) < 4){
            $error .= " Username minimal 4 karakter ";
        }

        if(strlen($password) < 8){
            $error .= " Password minimal 8 karakter ";
        }

        if($this->model->getByUsername($username)){
            $error .= "Username sudah dipakai, pilih yang lain ";
        }

        if($error !== ""){
            header("Location: index.php?act=register&error=" . urlencode($error));
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $berhasil = $this->model->tambahAkun($nama, $username, $hash);

        if($berhasil) {
            header("Location: index.php?act=login&pesan=akun_buat");
            exit;
        }

        header("Location: index.php?act=register&error=" . urlencode("Gagal menyimpan Akun"));
    }

    public function login(){
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function prosesLogin(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header("Location: index.php?act=login");
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if($username === "" || $password === ""){
            header("Location: index.php?act=login&error=" . urlencode("Username dan Password wajib diisi"));
            exit;
        }

        $akun = $this->model->cekLogin($username, $password);

        if (!$akun){
            header("Location: " . url('login', ['error' => 'Username atau password salah.']));
            exit;
        }

        simpanLogin($akun);

         header("Location: " . url('index'));
        exit;
    }

    public function logout(){
        hapusLogin();
        header("Location: " . url('login', ['pesan' => 'keluar']));
        exit;
    }
}