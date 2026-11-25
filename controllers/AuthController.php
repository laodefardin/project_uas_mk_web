<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/helper.php';

class AuthController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function register() {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function simpanRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . url('register'));
            exit;
        }

        verifyCsrfToken($_POST['csrf_token'] ?? '');

        $nama     = trim($_POST['nama'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $error = "";

        if (strlen($nama) < 3) {
            $error .= "Nama minimal 3 Karakter. ";
        }

        if (strlen($username) < 4) {
            $error .= "Username minimal 4 karakter. ";
        }

        if (strlen($password) < 8) {
            $error .= "Password minimal 8 karakter. ";
        }

        if ($this->model->getByUsername($username)) {
            $error .= "Username sudah dipakai, pilih yang lain. ";
        }

        if ($error !== "") {
            header("Location: " . url('register', ['error' => $error]));
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $berhasil = $this->model->tambahAkun($nama, $username, $hash);

        if ($berhasil) {
            header("Location: " . url('login', ['pesan' => 'akun_buat']));
            exit;
        }

        header("Location: " . url('register', ['error' => 'Gagal menyimpan akun baru.']));
        exit;
    }

    public function landing() {
        require_once __DIR__ . '/../views/landing/index.php';
    }

    public function login() {
        if (sudahLogin()) {
            header("Location: " . url('index'));
            exit;
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function prosesLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . url('login'));
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === "" || $password === "") {
            header("Location: " . url('login', ['error' => 'Username dan Password wajib diisi.']));
            exit;
        }

        $akun = $this->model->cekLogin($username, $password);

        if (!$akun) {
            header("Location: " . url('login', ['error' => 'Username atau password salah.']));
            exit;
        }

        simpanLogin($akun);
        header("Location: " . url('index'));
        exit;
    }

    public function logout() {
        hapusLogin();
        header("Location: " . url('login', ['pesan' => 'keluar']));
        exit;
    }

    public function profil() {
        wajibLogin();
        $user = $this->model->getById($_SESSION['id']);
        require_once __DIR__ . '/../views/auth/profil.php';
    }

    public function updatePassword() {
        wajibLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . url('profil'));
            exit;
        }

        verifyCsrfToken($_POST['csrf_token'] ?? '');

        $passwordLama = $_POST['password_lama'] ?? '';
        $passwordBaru = $_POST['password_baru'] ?? '';
        $konfirmasi   = $_POST['konfirmasi_password'] ?? '';

        $user = $this->model->getById($_SESSION['id']);
        if (!$user) {
            setPesan('gagal', 'Akun tidak ditemukan.');
            header("Location: " . url('profil'));
            exit;
        }

        if (!password_verify($passwordLama, $user['password'])) {
            setPesan('gagal', 'Password saat ini (lama) tidak sesuai.');
            header("Location: " . url('profil'));
            exit;
        }

        if (strlen($passwordBaru) < 8) {
            setPesan('gagal', 'Password baru minimal 8 karakter.');
            header("Location: " . url('profil'));
            exit;
        }

        if ($passwordBaru !== $konfirmasi) {
            setPesan('gagal', 'Konfirmasi password baru tidak cocok.');
            header("Location: " . url('profil'));
            exit;
        }

        $hashBaru = password_hash($passwordBaru, PASSWORD_DEFAULT);
        if ($this->model->updatePassword($_SESSION['id'], $hashBaru)) {
            setPesan('sukses', 'Password berhasil diperbarui.');
        } else {
            setPesan('gagal', 'Gagal memperbarui password.');
        }

        header("Location: " . url('profil'));
        exit;
    }
}
