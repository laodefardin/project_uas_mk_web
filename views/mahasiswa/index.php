<?php
$judul_halaman = "Daftar Mahasiswa - SIAKAD PTI Unsulbar";
require_once __DIR__ . '/../layout/header.php';

$pesan = ambilPesan();
?>

<?php if ($pesan !== null): ?>
<div class="alert alert-<?= $pesan['tipe'] === 'sukses' ? 'success' : 'danger'; ?> mb-4 alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
    <i class="bi <?= $pesan['tipe'] === 'sukses' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'; ?> fs-5 me-2"></i>
    <div><?= htmlspecialchars($pesan['isi'], ENT_QUOTES, 'UTF-8'); ?></div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- 1. DASHBOARD METRIC BAR (CLEAN & MINIMALIST) -->
<div class="card shadow-sm border-0 mb-4 bg-white">
    <div class="card-body p-0">
        <div class="row g-0 text-center">
            <div class="col-6 col-md-3 py-3 px-3 border-end">
                <span class="text-muted small fw-medium">Total Mahasiswa</span>
                <h3 class="mb-0 fw-bold mt-1 text-dark"><?= $stats['total'] ?? 0; ?></h3>
                <small class="text-muted text-nowrap">Mahasiswa terdaftar</small>
            </div>
            <div class="col-6 col-md-3 py-3 px-3 border-end">
                <span class="text-muted small fw-medium">Rata-rata IPK</span>
                <h3 class="mb-0 fw-bold mt-1 text-primary"><?= $stats['avg_ipk'] ?? '0.00'; ?></h3>
                <small class="text-muted text-nowrap">Skala maksimum 4.00</small>
            </div>
            <div class="col-6 col-md-3 py-3 px-3 border-end">
                <span class="text-muted small fw-medium">Mahasiswa Aktif</span>
                <h3 class="mb-0 fw-bold mt-1 text-success"><?= $stats['aktif'] ?? 0; ?></h3>
                <small class="text-muted text-nowrap">Status aktif kuliah</small>
            </div>
            <div class="col-6 col-md-3 py-3 px-3">
                <span class="text-muted small fw-medium">Predikat Cumlaude</span>
                <h3 class="mb-0 fw-bold mt-1 text-dark"><?= $stats['cumlaude'] ?? 0; ?></h3>
                <small class="text-success text-nowrap fw-medium"><i class="bi bi-star-fill me-1"></i>IPK &ge; 3.50</small>
            </div>
        </div>
    </div>
</div>

<!-- 2. DATA MAHASISWA & FILTER SECTION -->
<div class="card shadow-sm border-0 bg-white">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2 border-bottom">
        <div>
            <h5 class="m-0 fw-semibold text-dark">Data Mahasiswa</h5>
            <small class="text-muted">Kelola informasi akademik dan data pribadi mahasiswa</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- Dropdown Aksi Ekspor & Cetak yang Rapi -->
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-download me-1"></i>Ekspor / Cetak
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <a class="dropdown-item small" href="<?= url('exportCsv', $_GET); ?>">
                            <i class="bi bi-file-earmark-excel me-2 text-success"></i>Download Data (CSV/Excel)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item small" href="<?= url('cetakLaporan', $_GET); ?>" target="_blank">
                            <i class="bi bi-printer me-2 text-secondary"></i>Cetak Laporan Resmi (Print)
                        </a>
                    </li>
                </ul>
            </div>

            <a href="<?= url('tambah'); ?>" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Tambah Mahasiswa
            </a>
        </div>
    </div>

    <!-- Filter Bar Rapi & Seimbang -->
    <div class="card-body bg-light bg-opacity-50 py-3 border-bottom">
        <form method="GET" action="<?= url('index'); ?>">
            <div class="row g-2 align-items-center">
                <div class="col-lg-4 col-md-12">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control border-start-0" placeholder="Cari nama atau NIM..." value="<?= e($_GET['q'] ?? '') ?>">
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <select name="jurusan" class="form-select form-select-sm">
                        <option value="">-- Semua Prodi --</option>
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
                </div>

                <div class="col-lg-2 col-md-4 col-sm-6">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">-- Semua Status --</option>
                        <?php
                        $statusList = ['Aktif', 'Cuti', 'Lulus', 'DO'];
                        $selectedStatus = $_GET['status'] ?? '';
                        foreach ($statusList as $st):
                        ?>
                        <option value="<?= $st; ?>" <?= ($selectedStatus === $st) ? 'selected' : ''; ?>><?= e($st); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-lg-2 col-md-4 col-sm-6">
                    <select name="angkatan" class="form-select form-select-sm">
                        <option value="">-- Semua Angkatan --</option>
                        <?php
                        $selectedAngkatan = (int)($_GET['angkatan'] ?? 0);
                        foreach ($angkatanList as $ang):
                        ?>
                        <option value="<?= $ang; ?>" <?= ($selectedAngkatan === $ang) ? 'selected' : ''; ?>><?= $ang; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-lg-1 col-md-12 col-sm-6 d-flex gap-1">
                    <button type="submit" class="btn btn-sm btn-primary flex-fill" title="Terapkan Filter">
                        <i class="bi bi-funnel"></i>
                    </button>
                    <a href="<?= url('index'); ?>" class="btn btn-sm btn-outline-secondary flex-fill text-center" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Data Mahasiswa (Valid HTML, No stray divs) -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-nowrap">
                <tr>
                    <th class="ps-3" style="width: 40px;">#</th>
                    <th style="width: 50px;">Foto</th>
                    <th style="width: 100px;">NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Program Studi</th>
                    <th class="text-center" style="width: 80px;">Status</th>
                    <th class="text-center" style="width: 70px;">IPK</th>
                    <th class="text-center pe-3" style="width: 110px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftar_mahasiswa)): ?>
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-2 d-block text-secondary opacity-50 mb-2"></i>
                        Tidak ada data mahasiswa yang cocok dengan kriteria.
                    </td>
                </tr>
                <?php else: ?>
                <?php
                $no = (($page - 1) * $perPage) + 1;
                foreach ($daftar_mahasiswa as $mhs):
                    $cleanNim = preg_replace('/[^a-zA-Z0-9]/', '', $mhs['nim']);
                ?>
                <tr>
                    <td class="ps-3 text-muted small"><?= $no++; ?></td>
                    <td>
                        <?php if (!empty($mhs['foto']) && file_exists(__DIR__ . '/../../uploads/' . $mhs['foto'])): ?>
                            <img src="/pertemuan12/uploads/<?= e($mhs['foto']); ?>" alt="Foto" class="avatar-sm border">
                        <?php else: ?>
                            <div class="avatar-placeholder">
                                <?= strtoupper(substr($mhs['nama'], 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="font-monospace fw-semibold text-dark small"><?= e($mhs['nim']); ?></span>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark"><?= e($mhs['nama']); ?></div>
                        <div class="text-muted small" style="font-size: 0.78rem;">
                            <?= ($mhs['jenis_kelamin'] ?? 'L') === 'L' ? 'L' : 'P'; ?> &middot;
                            <?= e($mhs['tempat_lahir']); ?>, <?= date('d M Y', strtotime($mhs['tanggal_lahir'])); ?>
                        </div>
                    </td>
                    <td>
                        <div class="text-dark small fw-medium"><?= e($mhs['jurusan']); ?></div>
                        <div class="text-muted small" style="font-size: 0.78rem;">
                            Angkatan <?= e($mhs['angkatan'] ?? 2024); ?> &middot; <?= e($mhs['fakultas']); ?>
                        </div>
                    </td>
                    <td class="text-center">
                        <?php
                        $st = $mhs['status'] ?? 'Aktif';
                        $stBadge = match($st) {
                            'Aktif' => 'bg-success bg-opacity-10 text-success border-success border-opacity-25',
                            'Cuti'  => 'bg-warning bg-opacity-10 text-warning border-warning border-opacity-25',
                            'Lulus' => 'bg-info bg-opacity-10 text-info border-info border-opacity-25',
                            default => 'bg-danger bg-opacity-10 text-danger border-danger border-opacity-25'
                        };
                        ?>
                        <span class="badge border <?= $stBadge; ?> px-2 py-1" style="font-size: 0.75rem;">
                            <?= e($st); ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <?php
                        $ipk = (float)$mhs['ipk'];
                        $badgeColor = $ipk >= 3.5 ? 'bg-success' : ($ipk >= 3.0 ? 'bg-primary' : ($ipk >= 2.5 ? 'bg-warning text-dark' : 'bg-danger'));
                        ?>
                        <span class="badge <?= $badgeColor; ?> px-2 py-1" style="font-size: 0.75rem;">
                            <?= number_format($ipk, 2); ?>
                        </span>
                    </td>
                    <td class="text-center text-nowrap pe-3" style="min-width: 120px;">
                        <div class="d-inline-flex gap-1 align-items-center justify-content-center">
                            <button type="button" class="btn btn-sm btn-light border text-primary" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $cleanNim; ?>" title="Lihat Profil">
                                <i class="bi bi-eye"></i>
                            </button>
                            <a href="<?= url('edit', ['nim' => $mhs['nim']]); ?>" class="btn btn-sm btn-light border text-warning" title="Edit Data">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="<?= url('hapus', ['nim' => $mhs['nim']]); ?>" method="POST" onsubmit="return confirm('Hapus data mahasiswa <?= e($mhs['nama']); ?>?')" class="d-inline m-0">
                                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken(); ?>">
                                <input type="hidden" name="nim" value="<?= e($mhs['nim']); ?>">
                                <button type="submit" class="btn btn-sm btn-light border text-danger" title="Hapus Data">
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

    <!-- 3. PAGINATION & INFO -->
    <div class="card-footer bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2 border-top">
        <small class="text-muted">
            Menampilkan <strong><?= count($daftar_mahasiswa); ?></strong> dari <strong><?= $total; ?></strong> total data
        </small>
        <?php if ($totalHalaman > 1): ?>
        <nav aria-label="Navigasi Halaman">
            <ul class="pagination pagination-sm mb-0">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">
                        &laquo;
                    </a>
                </li>
                <?php endif; ?>

                <?php for ($i = max(1, $page - 2); $i <= min($totalHalaman, $page + 2); $i++): ?>
                <li class="page-item <?= $i === $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])); ?>">
                        <?= $i; ?>
                    </a>
                </li>
                <?php endfor; ?>

                <?php if ($page < $totalHalaman): ?>
                <li class="page-item">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">
                        &raquo;
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>

<!-- 4. MODALS (DILETAKKAN DI LUAR TABEL SECARA BENAR) -->
<?php if (!empty($daftar_mahasiswa)): ?>
<?php foreach ($daftar_mahasiswa as $mhs):
    $cleanNim = preg_replace('/[^a-zA-Z0-9]/', '', $mhs['nim']);
    $ipk = (float)$mhs['ipk'];
    $st = $mhs['status'] ?? 'Aktif';
?>
<div class="modal fade" id="modalDetail<?= $cleanNim; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h6 class="modal-title fw-semibold">
                    <i class="bi bi-person-badge me-2"></i>Profil Mahasiswa
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <?php if (!empty($mhs['foto']) && file_exists(__DIR__ . '/../../uploads/' . $mhs['foto'])): ?>
                        <img src="/pertemuan12/uploads/<?= e($mhs['foto']); ?>" alt="Foto" class="rounded border shadow-sm mb-2" style="width: 90px; height: 115px; object-fit: cover;">
                    <?php else: ?>
                        <div class="avatar-placeholder mx-auto mb-2" style="width: 72px; height: 72px; font-size: 1.75rem;">
                            <?= strtoupper(substr($mhs['nama'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                    <h5 class="fw-bold mb-0 text-dark"><?= e($mhs['nama']); ?></h5>
                    <div class="text-muted small">NIM: <span class="font-monospace fw-semibold"><?= e($mhs['nim']); ?></span> &middot; Angkatan <?= e($mhs['angkatan'] ?? 2024); ?></div>
                </div>

                <div class="bg-light p-3 rounded-3 mb-3">
                    <div class="row g-2 small">
                        <div class="col-5 text-muted">Jenis Kelamin</div>
                        <div class="col-7 fw-medium">: <?= ($mhs['jenis_kelamin'] ?? 'L') === 'L' ? 'Laki-laki' : 'Perempuan'; ?></div>

                        <div class="col-5 text-muted">Tempat, Tanggal Lahir</div>
                        <div class="col-7 fw-medium">: <?= e($mhs['tempat_lahir']); ?>, <?= date('d F Y', strtotime($mhs['tanggal_lahir'])); ?></div>

                        <div class="col-5 text-muted">Program Studi</div>
                        <div class="col-7 fw-medium">: <?= e($mhs['jurusan']); ?></div>

                        <div class="col-5 text-muted">Fakultas</div>
                        <div class="col-7 fw-medium">: <?= e($mhs['fakultas']); ?></div>

                        <div class="col-5 text-muted">Status Kuliah</div>
                        <div class="col-7 fw-medium">: <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25"><?= e($st); ?></span></div>

                        <div class="col-5 text-muted">IPK Kumulatif</div>
                        <div class="col-7 fw-medium">: <span class="badge bg-primary"><?= number_format($ipk, 2); ?></span> <?= $ipk >= 3.50 ? '<span class="text-success fw-medium small">(Cumlaude)</span>' : ''; ?></div>
                    </div>
                </div>

                <div class="small">
                    <div class="d-flex justify-content-between py-1 border-bottom">
                        <span class="text-muted"><i class="bi bi-envelope me-1"></i>Email</span>
                        <span><?= !empty($mhs['email']) ? '<a href="mailto:' . e($mhs['email']) . '" class="text-decoration-none">' . e($mhs['email']) . '</a>' : '<span class="text-muted">-</span>'; ?></span>
                    </div>
                    <div class="d-flex justify-content-between py-1">
                        <span class="text-muted"><i class="bi bi-whatsapp me-1 text-success"></i>WhatsApp</span>
                        <span><?= !empty($mhs['no_hp']) ? '<a href="https://wa.me/' . preg_replace('/[^0-9]/', '', $mhs['no_hp']) . '" target="_blank" class="text-decoration-none text-success fw-medium">' . e($mhs['no_hp']) . '</a>' : '<span class="text-muted">-</span>'; ?></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <a href="<?= url('cetakKtm', ['nim' => $mhs['nim']]); ?>" target="_blank" class="btn btn-sm btn-primary">
                    <i class="bi bi-person-vcard me-1"></i>Cetak Kartu Mahasiswa (KTM)
                </a>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
