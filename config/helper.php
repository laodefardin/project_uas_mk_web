<?php

function e($teks){
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

if (!defined('BASE_URL')) {
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    define('BASE_URL', ($scriptDir === '/' || $scriptDir === '.') ? '' : rtrim($scriptDir, '/'));
}

function url($act = 'index', $tambahan = []) {
    $dasar = rtrim(BASE_URL, '/');
    unset($tambahan['act']);

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

// Tanda merek: layar sandeq sederhana satu warna, mengikuti warna teks sekitar (dipakai di halaman aplikasi)
function tandaMerek() {
    return '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">'
         . '<path d="M10.5 2 16 13.5H10.5V2Z" fill="currentColor"/>'
         . '<path d="M9 5 4.5 13.5H9V5Z" fill="currentColor" opacity=".55"/>'
         . '<path d="M3 16h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>';
}
