<?php

function e($teks){
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

define('BASE_URL', '/pertemuan12');

// function url($act = 'index', $tambahan = []) {
//     $hasil = rtrim(BASE_URL, '/') . '/' . $act;

//     if (!empty($tambahan)) {
//         $hasil .= '?' . http_build_query($tambahan);
//     }

//     return $hasil;
// }

function url($act = 'index', $tambahan = []) {
    $dasar = rtrim(BASE_URL, '/');

    // Aksi edit dan hapus memakai bentuk /edit/24010001
    if (in_array($act, ['edit', 'hapus']) && isset($tambahan['nim'])) {
        return $dasar . '/' . $act . '/' . rawurlencode($tambahan['nim']);
    }

    $hasil = $dasar . '/' . $act;

    if (!empty($tambahan)) {
        $hasil .= '?' . http_build_query($tambahan);
    }

    return $hasil;
}
