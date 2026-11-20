<?php
function getKoneksi(){
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "kampusku";

    $koneksi = mysqli_connect($host, $user, $pass, $db);

    if(!$koneksi) {
        die("Koneksi ke database gagal: " . mysqli_connect_error());
    }
    return $koneksi;
}