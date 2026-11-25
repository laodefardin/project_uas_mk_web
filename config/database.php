<?php
function getKoneksi(){
    static $koneksi = null;
    if ($koneksi !== null) {
        return $koneksi;
    }

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "kampusku";

    $koneksi = mysqli_connect($host, $user, $pass, $db);

    if(!$koneksi) {
        die("Koneksi ke database gagal: " . mysqli_connect_error());
    }
    mysqli_set_charset($koneksi, 'utf8mb4');
    return $koneksi;
}