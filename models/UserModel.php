<?php
require_once __DIR__ . '/../config/database.php';

class UserModel{
    private $db;

    public function __construct(){
        $this->db = getKoneksi();
    }

    public function tambahAkun($nama, $username, $hashPassword){
        $query = "INSERT INTO admin (nama, username, password)
                    VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($this->db, $query);
        if (!$stmt){
            return false;
        }

        mysqli_stmt_bind_param($stmt, "sss", $nama, $username, $hashPassword);
        $hasil = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $hashPassword;
    }

    public function getByUsername($username){
        $query = "SELECT * FROM admin WHERE username = ? LIMIT 1";

        $stmt = mysqli_prepare($this->db, $query);

        if(!$stmt){
            return null;
        }

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);
        return $data;
    }

    public function cekLogin($username, $password){
        $akun = $this->getByUsername($username);

        if (!$akun){
            return null;
        }

        if (!password_verify($password, $akun['password'])){
            return null;
        }

        return $akun;
    }
}