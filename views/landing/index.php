<?php
require_once __DIR__ . '/../../config/helper.php';

$aset = rtrim(BASE_URL, '/') . '/assets';

// Data contoh untuk pratinjau. Bukan data dari database.
$contoh = [
    ['nim' => '24010001', 'nama' => 'Nurhaliza Amir',        'status' => 'Aktif', 'ipk' => '3.78'],
    ['nim' => '24010002', 'nama' => 'Muhammad Akbar Rasyid', 'status' => 'Aktif', 'ipk' => '3.52'],
    ['nim' => '23010014', 'nama' => 'Andi Sitti Aisyah',     'status' => 'Aktif', 'ipk' => '3.61'],
    ['nim' => '23010027', 'nama' => 'Rahmat Hidayat',        'status' => 'Cuti',  'ipk' => '3.05'],
    ['nim' => '22010009', 'nama' => 'Dewi Sartika Latif',    'status' => 'Aktif', 'ipk' => '3.44'],
    ['nim' => '21010003', 'nama' => 'Fadlan Mubarak',        'status' => 'Lulus', 'ipk' => '3.69'],
];

function inisial($nama) {
    $kata = preg_split('/\s+/', trim($nama));
    return strtoupper(substr($kata[0], 0, 1) . substr(end($kata), 0, 1));
}

// Garis kode batang sederhana dari digit NIM
function garisNim($nim) {
    $x = 0;
    $out = '';
    foreach (str_split('9' . $nim . '1') as $d) {
        $n = (int)$d;
        $lebar = 1 + ($n % 3);
        $out .= '<rect x="' . $x . '" y="0" width="' . $lebar . '" height="28"/>';
        $x += $lebar + 1 + (($n + 1) % 2);
    }
    return [$out, $x];
}
[$garis, $lebarGaris] = garisNim('24010001');

$tanda = '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">'
       . '<path d="M10.5 2 16 13.5H10.5V2Z" fill="currentColor"/>'
       . '<path d="M9 5 4.5 13.5H9V5Z" fill="currentColor" opacity=".55"/>'
       . '<path d="M3 16h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD Kampusku - Data mahasiswa PTI FKIP Unsulbar</title>
    <meta name="description" content="SIAKAD Kampusku menyimpan biodata, status dan IPK mahasiswa PTI FKIP Unsulbar, lalu mencetak KTM dan laporan resminya.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&family=Instrument+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= e($aset); ?>/css/landing.css">
</head>
<body>

<header class="nav" id="nav">
    <div class="wrap nav-inner">
        <a class="brand" href="<?= e(url('index')); ?>" aria-label="SIAKAD Kampusku, beranda">
            <?= $tanda; ?>SIAKAD <span>Kampusku</span>
        </a>
        <button class="nav-toggle" id="navToggle" type="button" aria-expanded="false" aria-controls="nav" aria-label="Buka menu">
            <i class="bi bi-list"></i>
        </button>
        <nav class="nav-links" aria-label="Navigasi utama">
            <a href="#fitur">Fitur</a>
            <a href="#cetak">Cetak</a>
        </nav>
        <div class="nav-actions">
            <a class="nav-login" href="<?= e(url('login')); ?>">Masuk</a>
            <a class="btn btn-primary btn-sm" href="<?= e(url('register')); ?>">Buat akun</a>
        </div>
    </div>
</header>

<main>
    <section class="hero" aria-labelledby="judul">
        <div class="hero-scene" role="img" aria-label="Sandeq, perahu layar tradisional Mandar, berlayar di laut tenang saat pagi"></div>

        <div class="wrap hero-copy">
            <div class="hero-copy-inner">
                <h1 id="judul" class="rise">Data mahasiswa yang tertata, dari NIM sampai KTM</h1>
                <p class="hero-sub rise rise-1">SIAKAD Kampusku menyimpan biodata, status dan IPK mahasiswa PTI FKIP Unsulbar, lalu mencetak KTM dan laporan resminya</p>
                <div class="hero-actions rise rise-2">
                    <a class="btn btn-primary" href="<?= e(url('login')); ?>">Masuk ke SIAKAD</a>
                    <a class="btn btn-quiet" href="#fitur">Lihat fitur</a>
                </div>
            </div>
        </div>

        <div class="wrap hero-preview">
            <div class="window rise rise-4" aria-label="Contoh tampilan halaman Data Mahasiswa" role="img">
                <div class="window-bar">
                    <div class="window-dots"><i></i><i></i><i></i></div>
                    <span class="window-title">Data contoh</span>
                </div>
                <div class="app-nav">
                    <span class="brand"><?= $tanda; ?>SIAKAD <span>Kampusku</span></span>
                    <span class="is-here">Data Mahasiswa</span>
                    <a>Cetak Laporan</a>
                    <span class="app-user"><span class="avatar">A</span>Administrator</span>
                </div>
                <div class="app-body">
                    <div class="app-head">
                        <h2 class="app-title">Data Mahasiswa</h2>
                        <span class="app-meta num">Menampilkan 6 dari 128 data</span>
                    </div>

                    <div class="stats">
                        <div class="stat">
                            <div class="stat-label">Total mahasiswa</div>
                            <div class="stat-figure">128</div>
                        </div>
                        <div class="stat">
                            <div class="stat-label">Rata-rata IPK</div>
                            <div class="stat-figure is-accent">3.42</div>
                        </div>
                        <div class="stat">
                            <div class="stat-label">Mahasiswa aktif</div>
                            <div class="stat-figure">117</div>
                        </div>
                        <div class="stat">
                            <div class="stat-label">Cumlaude (IPK 3.50 ke atas)</div>
                            <div class="stat-figure">41</div>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th class="col-nim-head">NIM</th>
                                <th>Nama mahasiswa</th>
                                <th class="col-prodi">Program studi</th>
                                <th>Status</th>
                                <th class="col-end">IPK</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($contoh as $m): ?>
                            <tr>
                                <td class="col-nim col-nim-head"><?= e($m['nim']); ?></td>
                                <td><span class="person"><span class="avatar"><?= e(inisial($m['nama'])); ?></span><?= e($m['nama']); ?></span></td>
                                <td class="col-prodi">Pendidikan Teknologi Informasi</td>
                                <td><span class="status is-<?= e(strtolower($m['status'])); ?>"><?= e($m['status']); ?></span></td>
                                <td class="col-end"><?= e($m['ipk']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section class="section wrap" id="fitur" aria-labelledby="judul-fitur">
        <div class="split">
            <div class="split-sticky">
                <h2 class="h2" id="judul-fitur">Dari biodata sampai berkas cetak</h2>
                <p class="lead">Satu daftar mahasiswa yang bisa dicari, disaring dan dicetak, tanpa lembar kerja terpisah</p>
            </div>
            <div class="rows">
                <div class="row">
                    <i class="bi bi-person-vcard"></i>
                    <div>
                        <h3>Biodata per mahasiswa</h3>
                        <p>NIM, nama, tempat dan tanggal lahir, fakultas, program studi, angkatan, email, nomor HP dan foto tersimpan dalam satu data.</p>
                    </div>
                </div>
                <div class="row">
                    <i class="bi bi-graph-up"></i>
                    <div>
                        <h3>Status dan IPK</h3>
                        <p>Status Aktif, Cuti, Lulus atau DO, dengan ringkasan total mahasiswa, rata-rata IPK, jumlah mahasiswa aktif dan cumlaude.</p>
                    </div>
                </div>
                <div class="row">
                    <i class="bi bi-search"></i>
                    <div>
                        <h3>Cari dan saring</h3>
                        <p>Cari lewat kolom pencarian, lalu saring menurut program studi, status dan angkatan. Daftar tampil 10 data per halaman.</p>
                    </div>
                </div>
                <div class="row">
                    <i class="bi bi-shield-lock"></i>
                    <div>
                        <h3>Akses dengan akun</h3>
                        <p>Data hanya terbuka setelah masuk. Kata sandi disimpan ter-hash dan setiap formulir memakai token CSRF.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section wrap" id="cetak" aria-labelledby="judul-cetak">
        <div class="print-grid">
            <div class="stage">
                <div class="ktm" role="img" aria-label="Contoh Kartu Tanda Mahasiswa dengan foto, NIM, nama dan program studi">
                    <div class="ktm-top">
                        <div>
                            <b>Universitas Sulawesi Barat</b>
                            <span>Kartu Tanda Mahasiswa · SIAKAD Kampusku</span>
                        </div>
                        <?= $tanda; ?>
                    </div>
                    <div class="ktm-body">
                        <div class="ktm-photo">NA</div>
                        <dl>
                            <dt>NIM</dt><dd>24010001</dd>
                            <dt>Nama</dt><dd>Nurhaliza Amir</dd>
                            <dt>Prodi</dt><dd>Pendidikan Teknologi Informasi</dd>
                            <dt>Fakultas</dt><dd>FKIP</dd>
                            <dt>Angkatan</dt><dd>2024</dd>
                        </dl>
                    </div>
                    <div class="ktm-foot">
                        <span class="status">Aktif</span>
                        <svg class="ktm-bars" width="<?= (int)$lebarGaris; ?>" height="28" viewBox="0 0 <?= (int)$lebarGaris; ?> 28" fill="currentColor" aria-hidden="true"><?= $garis; ?></svg>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="h2" id="judul-cetak">Cetak langsung dari browser</h2>
                <p class="lead">Data yang sudah tersimpan keluar sebagai berkas yang siap dipakai</p>
                <div class="rows outputs">
                    <div class="row">
                        <i class="bi bi-person-badge"></i>
                        <div>
                            <h3>KTM digital</h3>
                            <p>Kartu per mahasiswa lengkap dengan foto, NIM dan program studi.</p>
                        </div>
                    </div>
                    <div class="row">
                        <i class="bi bi-printer"></i>
                        <div>
                            <h3>Laporan resmi kampus</h3>
                            <p>Rekap data mahasiswa dalam format laporan yang siap dicetak.</p>
                        </div>
                    </div>
                    <div class="row">
                        <i class="bi bi-filetype-csv"></i>
                        <div>
                            <h3>Export CSV</h3>
                            <p>Unduh seluruh data untuk diolah di aplikasi lembar kerja.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="wrap" aria-labelledby="judul-masuk">
        <div class="closing">
            <div>
                <h2 class="h2" id="judul-masuk">Masuk dan kelola data mahasiswa</h2>
                <p>Gunakan akun admin atau operator. Belum punya akun, daftar dulu.</p>
            </div>
            <div class="closing-actions">
                <a class="btn btn-light" href="<?= e(url('login')); ?>">Masuk ke SIAKAD</a>
                <a class="btn btn-ghost" href="<?= e(url('register')); ?>">Buat akun</a>
            </div>
        </div>
    </section>
</main>

<footer class="wrap footer">
    <span>SIAKAD Kampusku · PTI FKIP Universitas Sulawesi Barat</span>
    <nav class="footer-links" aria-label="Tautan kaki">
        <a href="<?= e(url('login')); ?>">Masuk</a>
        <a href="<?= e(url('register')); ?>">Buat akun</a>
    </nav>
</footer>

<script>
    (function () {
        var nav = document.getElementById('nav');
        var tombol = document.getElementById('navToggle');
        tombol.addEventListener('click', function () {
            var buka = nav.classList.toggle('is-open');
            tombol.setAttribute('aria-expanded', buka ? 'true' : 'false');
            tombol.querySelector('i').className = buka ? 'bi bi-x-lg' : 'bi bi-list';
        });
        nav.addEventListener('click', function (e) {
            if (e.target.closest('a') && nav.classList.contains('is-open')) tombol.click();
        });
    })();
</script>
</body>
</html>
