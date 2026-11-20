<?php

function e($teks){
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

define('BASE_URL', '/pertemuan12');

function url($act = 'index', $tambahan = []) {
    $dasar = rtrim(BASE_URL, '/');

    // Aksi edit, hapus, dan cetakKtm memakai bentuk clean URL: /edit/24010001
    if (in_array($act, ['edit', 'hapus', 'cetakKtm']) && isset($tambahan['nim'])) {
        $nim = rawurlencode($tambahan['nim']);
        unset($tambahan['nim']);
        $hasil = $dasar . '/' . $act . '/' . $nim;
        if (!empty($tambahan)) {
            $hasil .= '?' . http_build_query($tambahan);
        }
        return $hasil;
    }

    $hasil = $dasar . '/' . $act;

    if (!empty($tambahan)) {
        $hasil .= '?' . http_build_query($tambahan);
    }

    return $hasil;
}
