<?php
require_once __DIR__ . '/../config/database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = getKoneksi();
    }

    public function tambahAkun($nama, $username, $hashPassword, $hakAkses = 'operator') {
        $query = "INSERT INTO admin (nama, username, password, hak_akses) VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->db, $query);
        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param($stmt, "ssss", $nama, $username, $hashPassword, $hakAkses);
        $hasil = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $hasil;
    }

    public function getByUsername($username) {
        $query = "SELECT * FROM admin WHERE username = ? LIMIT 1";

        $stmt = mysqli_prepare($this->db, $query);
        if (!$stmt) {
            return null;
        }

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $data = $result ? mysqli_fetch_assoc($result) : null;

        mysqli_stmt_close($stmt);
        return $data;
    }

    public function getById($id) {
        $query = "SELECT * FROM admin WHERE id = ? LIMIT 1";

        $stmt = mysqli_prepare($this->db, $query);
        if (!$stmt) {
            return null;
        }

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $data = $result ? mysqli_fetch_assoc($result) : null;

        mysqli_stmt_close($stmt);
        return $data;
    }

    public function cekLogin($username, $password) {
        $akun = $this->getByUsername($username);

        if (!$akun) {
            return null;
        }

        if (!password_verify($password, $akun['password'])) {
            return null;
        }

        return $akun;
    }

    public function updatePassword($id, $hashPassword) {
        $query = "UPDATE admin SET password = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $query);
        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param($stmt, "si", $hashPassword, $id);
        $hasil = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $hasil;
    }
}
