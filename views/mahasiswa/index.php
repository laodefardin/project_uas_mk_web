<?php
$judul_halaman = "Data Mahasiswa - SIAKAD Kampusku";
require_once __DIR__ . '/../layout/header.php';

$pesan = ambilPesan();

$fotoUrl  = rtrim(BASE_URL, '/') . '/uploads/';
$totalMhs = (int)($stats['total'] ?? 0);
$aktifMhs = (int)($stats['aktif'] ?? 0);
$persenAktif = $totalMhs > 0 ? round($aktifMhs / $totalMhs * 100) : 0;

$sebaranProdi = $stats['prodi'] ?? [];
arsort($sebaranProdi);
$maksProdi = $sebaranProdi ? max($sebaranProdi) : 0;

function inisialNama($nama) {
    $kata = preg_split('/\s+/', trim((string)$nama));
    $dua = substr($kata[0] ?? '', 0, 1) . (count($kata) > 1 ? substr(end($kata), 0, 1) : '');
    return strtoupper($dua);
}
function kelasStatus($st) {
    return 'is-' . strtolower(preg_replace('/[^a-zA-Z]/', '', (string)$st));
}
?>

<?php if ($pesan !== null): ?>
<div class="alert alert-<?= $pesan['tipe'] === 'sukses' ? 'success' : 'danger'; ?> alert-dismissible fade show mb-4" role="alert">
    <?= e($pesan['isi']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
</div>
<?php endif; ?>

<div class="page-head rise">
    <div>
        <h1 class="page-title">Data Mahasiswa</h1>
        <p class="page-sub">Kelola informasi akademik dan data pribadi mahasiswa</p>
    </div>
    <div class="page-actions">
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-download me-2"></i>Ekspor / Cetak
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="<?= e(url('exportCsv', $_GET)); ?>">
                        <i class="bi bi-filetype-csv me-2 text-muted"></i>Unduh data (CSV)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="<?= e(url('cetakLaporan', $_GET)); ?>" target="_blank" rel="noopener">
                        <i class="bi bi-printer me-2 text-muted"></i>Cetak laporan resmi
                    </a>
                </li>
            </ul>
        </div>
        <a href="<?= e(url('tambah')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Tambah mahasiswa
        </a>
    </div>
</div>

<!-- Ringkasan -->
<section class="kpis rise rise-1" aria-label="Ringkasan">
    <div class="kpi">
        <div class="kpi-label">Total mahasiswa</div>
        <div class="kpi-figure"><?= $totalMhs; ?></div>
        <div class="kpi-meta">Seluruh angkatan</div>
    </div>
    <div class="kpi">
        <div class="kpi-label">Rata-rata IPK</div>
        <div class="kpi-figure is-accent"><?= e($stats['avg_ipk'] ?? '0.00'); ?></div>
        <div class="kpi-meta">Skala maksimum 4.00</div>
    </div>
    <div class="kpi">
        <div class="kpi-label">Mahasiswa aktif</div>
        <div class="kpi-figure"><?= $aktifMhs; ?></div>
        <div class="kpi-meta"><?= $persenAktif; ?>% dari total</div>
    </div>
    <div class="kpi">
        <div class="kpi-label">Cumlaude</div>
        <div class="kpi-figure"><?= (int)($stats['cumlaude'] ?? 0); ?></div>
        <div class="kpi-meta">IPK 3.50 ke atas</div>
    </div>
</section>

<div class="dash rise rise-2">
    <!-- Daftar mahasiswa -->
    <section class="panel" aria-label="Daftar mahasiswa">
        <form class="toolbar" method="GET" action="<?= e(url('index')); ?>">
            <div class="search">
                <i class="bi bi-search"></i>
                <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari nama atau NIM" aria-label="Cari nama atau NIM" value="<?= e($_GET['q'] ?? '') ?>">
            </div>

            <select name="jurusan" class="form-select form-select-sm" aria-label="Program studi">
                <option value="">Semua prodi</option>
                <?php
                $jurusanList = [
                    'Pendidikan Teknologi Informasi',
                    'Pendidikan Ilmu Pengetahuan Alam',
                    'Pendidikan Biologi',
                    'Pendidikan Fisika',
                    'Pendidikan Matematika'
                ];
                $selectedJurusan = $_GET['jurusan'] ?? '';
                foreach ($jurusanList as $p):
                ?>
                <option value="<?= e($p); ?>" <?= ($selectedJurusan === $p) ? 'selected' : ''; ?>><?= e($p); ?></option>
                <?php endforeach; ?>
            </select>

            <select name="status" class="form-select form-select-sm" aria-label="Status">
                <option value="">Semua status</option>
                <?php
                $statusList = ['Aktif', 'Cuti', 'Lulus', 'DO'];
                $selectedStatus = $_GET['status'] ?? '';
                foreach ($statusList as $st):
                ?>
                <option value="<?= e($st); ?>" <?= ($selectedStatus === $st) ? 'selected' : ''; ?>><?= e($st); ?></option>
                <?php endforeach; ?>
            </select>

            <select name="angkatan" class="form-select form-select-sm" aria-label="Angkatan">
                <option value="">Semua angkatan</option>
                <?php
                $selectedAngkatan = (int)($_GET['angkatan'] ?? 0);
                foreach ($angkatanList as $ang):
                ?>
                <option value="<?= (int)$ang; ?>" <?= ($selectedAngkatan === $ang) ? 'selected' : ''; ?>><?= (int)$ang; ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn btn-sm btn-primary">Terapkan</button>
            <a href="<?= e(url('index')); ?>" class="btn btn-sm btn-outline-secondary" title="Reset filter" aria-label="Reset filter">
                <i class="bi bi-arrow-counterclockwise"></i>
            </a>
        </form>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>NIM</th>
                        <th class="col-hide-sm">Program studi</th>
                        <th>Status</th>
                        <th class="col-end">IPK</th>
                        <th class="col-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftar_mahasiswa)): ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty">
                                <?php if ($totalMhs === 0): ?>
                                <p>Belum ada data mahasiswa</p>
                                <a href="<?= e(url('tambah')); ?>" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah mahasiswa pertama</a>
                                <?php else: ?>
                                <p>Tidak ada data yang cocok dengan pencarian atau filter</p>
                                <a href="<?= e(url('index')); ?>" class="btn btn-sm btn-outline-secondary">Reset filter</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($daftar_mahasiswa as $mhs):
                        $cleanNim = preg_replace('/[^a-zA-Z0-9]/', '', $mhs['nim']);
                        $st  = $mhs['status'] ?? 'Aktif';
                        $ipk = (float)$mhs['ipk'];
                        $adaFoto = !empty($mhs['foto']) && file_exists(__DIR__ . '/../../uploads/' . $mhs['foto']);
                    ?>
                    <tr>
                        <td>
                            <div class="person">
                                <?php if ($adaFoto): ?>
                                    <img src="<?= e($fotoUrl . $mhs['foto']); ?>" alt="Foto <?= e($mhs['nama']); ?>" class="avatar">
                                <?php else: ?>
                                    <span class="avatar"><?= e(inisialNama($mhs['nama'])); ?></span>
                                <?php endif; ?>
                                <div>
                                    <b><?= e($mhs['nama']); ?></b>
                                    <div class="meta"><?= ($mhs['jenis_kelamin'] ?? 'L') === 'L' ? 'L' : 'P'; ?> · <?= e($mhs['tempat_lahir']); ?>, <?= date('d M Y', strtotime($mhs['tanggal_lahir'])); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="col-nim"><?= e($mhs['nim']); ?></td>
                        <td class="col-hide-sm">
                            <div><?= e($mhs['jurusan']); ?></div>
                            <div class="meta">Angkatan <?= e($mhs['angkatan'] ?? 2024); ?> · <?= e($mhs['fakultas']); ?></div>
                        </td>
                        <td><span class="status <?= e(kelasStatus($st)); ?>"><?= e($st); ?></span></td>
                        <td class="col-end ipk"><?= number_format($ipk, 2); ?></td>
                        <td class="col-end">
                            <div class="row-actions">
                                <button type="button" class="icon-btn" data-bs-toggle="modal" data-bs-target="#modalDetail<?= e($cleanNim); ?>" title="Lihat profil" aria-label="Lihat profil <?= e($mhs['nama']); ?>">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <a href="<?= e(url('edit', ['nim' => $mhs['nim']])); ?>" class="icon-btn" title="Edit data" aria-label="Edit <?= e($mhs['nama']); ?>">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?= e(url('hapus', ['nim' => $mhs['nim']])); ?>" method="POST" onsubmit="return confirm('Hapus data mahasiswa <?= e($mhs['nama']); ?>?')" class="d-inline m-0">
                                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken(); ?>">
                                    <input type="hidden" name="nim" value="<?= e($mhs['nim']); ?>">
                                    <button type="submit" class="icon-btn is-danger" title="Hapus data" aria-label="Hapus <?= e($mhs['nama']); ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="panel-foot">
            <span class="num">Menampilkan <?= count($daftar_mahasiswa); ?> dari <?= (int)$total; ?> data</span>
            <?php if ($totalHalaman > 1): ?>
            <nav aria-label="Navigasi halaman">
                <ul class="pagination mb-0">
                    <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?<?= e(http_build_query(array_merge($_GET, ['page' => $page - 1]))); ?>" aria-label="Sebelumnya"><i class="bi bi-chevron-left"></i></a>
                    </li>
                    <?php endif; ?>

                    <?php for ($i = max(1, $page - 2); $i <= min($totalHalaman, $page + 2); $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?<?= e(http_build_query(array_merge($_GET, ['page' => $i]))); ?>"><?= $i; ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalHalaman): ?>
                    <li class="page-item">
                        <a class="page-link" href="?<?= e(http_build_query(array_merge($_GET, ['page' => $page + 1]))); ?>" aria-label="Berikutnya"><i class="bi bi-chevron-right"></i></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </section>

    <!-- Sebaran program studi -->
    <aside class="panel" aria-label="Sebaran program studi">
        <div class="panel-head">
            <h2>Sebaran program studi</h2>
            <p>Jumlah mahasiswa per prodi</p>
        </div>
        <?php if (empty($sebaranProdi)): ?>
        <div class="rank-empty">Belum ada data</div>
        <?php else: ?>
        <div class="rank">
            <?php $urut = 0; foreach ($sebaranProdi as $namaProdi => $jumlah): ?>
            <div class="rank-row <?= $urut === 0 ? 'is-top' : ''; ?>">
                <div class="rank-top"><span><?= e($namaProdi); ?></span><span><?= (int)$jumlah; ?></span></div>
                <div class="rank-bar"><i style="width: <?= $maksProdi > 0 ? round($jumlah / $maksProdi * 100) : 0; ?>%"></i></div>
            </div>
            <?php $urut++; endforeach; ?>
        </div>
        <?php endif; ?>
    </aside>
</div>

<!-- Detail mahasiswa (modal di luar tabel) -->
<?php if (!empty($daftar_mahasiswa)): ?>
<?php foreach ($daftar_mahasiswa as $mhs):
    $cleanNim = preg_replace('/[^a-zA-Z0-9]/', '', $mhs['nim']);
    $ipk = (float)$mhs['ipk'];
    $st  = $mhs['status'] ?? 'Aktif';
    $adaFoto = !empty($mhs['foto']) && file_exists(__DIR__ . '/../../uploads/' . $mhs['foto']);
?>
<div class="modal fade" id="modalDetail<?= e($cleanNim); ?>" tabindex="-1" aria-labelledby="judulDetail<?= e($cleanNim); ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-6 fw-medium" id="judulDetail<?= e($cleanNim); ?>">Profil mahasiswa</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4">
                <div class="detail-head">
                    <?php if ($adaFoto): ?>
                        <img src="<?= e($fotoUrl . $mhs['foto']); ?>" alt="Foto <?= e($mhs['nama']); ?>" class="photo">
                    <?php else: ?>
                        <span class="avatar"><?= e(inisialNama($mhs['nama'])); ?></span>
                    <?php endif; ?>
                    <div>
                        <h3 class="detail-name"><?= e($mhs['nama']); ?></h3>
                        <div class="meta num">NIM <?= e($mhs['nim']); ?> · Angkatan <?= e($mhs['angkatan'] ?? 2024); ?></div>
                    </div>
                </div>

                <dl class="detail-list">
                    <dt>Jenis kelamin</dt>
                    <dd><?= ($mhs['jenis_kelamin'] ?? 'L') === 'L' ? 'Laki-laki' : 'Perempuan'; ?></dd>
                    <dt>Tempat, tanggal lahir</dt>
                    <dd><?= e($mhs['tempat_lahir']); ?>, <?= date('d F Y', strtotime($mhs['tanggal_lahir'])); ?></dd>
                    <dt>Program studi</dt>
                    <dd><?= e($mhs['jurusan']); ?></dd>
                    <dt>Fakultas</dt>
                    <dd><?= e($mhs['fakultas']); ?></dd>
                    <dt>Status kuliah</dt>
                    <dd><span class="status <?= e(kelasStatus($st)); ?>"><?= e($st); ?></span></dd>
                    <dt>IPK kumulatif</dt>
                    <dd><?= number_format($ipk, 2); ?><?= $ipk >= 3.50 ? ' <span class="text-muted">· Cumlaude</span>' : ''; ?></dd>
                    <dt>Email</dt>
                    <dd><?= !empty($mhs['email']) ? '<a href="mailto:' . e($mhs['email']) . '">' . e($mhs['email']) . '</a>' : '<span class="text-muted">Belum diisi</span>'; ?></dd>
                    <dt>WhatsApp</dt>
                    <dd><?= !empty($mhs['no_hp']) ? '<a href="https://wa.me/' . preg_replace('/[^0-9]/', '', $mhs['no_hp']) . '" target="_blank" rel="noopener">' . e($mhs['no_hp']) . '</a>' : '<span class="text-muted">Belum diisi</span>'; ?></dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="<?= e(url('cetakKtm', ['nim' => $mhs['nim']])); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-primary">
                    <i class="bi bi-person-vcard me-2"></i>Cetak KTM
                </a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
