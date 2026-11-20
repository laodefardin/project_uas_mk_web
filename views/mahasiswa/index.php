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

<!-- 1. DASHBOARD STATISTIK AKADEMIK (STAT CARDS) -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow-sm p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium text-uppercase">Total Mahasiswa</span>
                    <h3 class="mb-0 fw-bold mt-1 text-dark"><?= $stats['total'] ?? 0; ?></h3>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="small text-muted mt-2">
                <i class="bi bi-check2 me-1 text-success"></i>Terdaftar di sistem
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow-sm p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium text-uppercase">Rata-rata IPK</span>
                    <h3 class="mb-0 fw-bold mt-1 text-dark"><?= $stats['avg_ipk'] ?? '0.00'; ?></h3>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-award-fill"></i>
                </div>
            </div>
            <div class="small text-muted mt-2">
                <i class="bi bi-graph-up me-1 text-primary"></i>Skala 4.00
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow-sm p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium text-uppercase">Mahasiswa Aktif</span>
                    <h3 class="mb-0 fw-bold mt-1 text-dark"><?= $stats['aktif'] ?? 0; ?></h3>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
            </div>
            <div class="small text-muted mt-2">
                <i class="bi bi-person-check me-1 text-success"></i>Status aktif kuliah
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow-sm p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium text-uppercase">Predikat Cumlaude</span>
                    <h3 class="mb-0 fw-bold mt-1 text-dark"><?= $stats['cumlaude'] ?? 0; ?></h3>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-star-fill"></i>
                </div>
            </div>
            <div class="small text-muted mt-2">
                <i class="bi bi-lightning-charge me-1 text-info"></i>IPK &ge; 3.50
            </div>
        </div>
    </div>
</div>

<!-- 2. DATA MAHASISWA & FILTER SECTION -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h5 class="m-0 text-primary fw-semibold d-flex align-items-center">
            <i class="bi bi-table me-2"></i>Data Mahasiswa Terdaftar
        </h5>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="<?= url('exportCsv', $_GET); ?>" class="btn btn-sm btn-outline-success">
                <i class="bi bi-file-earmark-excel me-1"></i>Export CSV
            </a>
            <a href="<?= url('cetakLaporan', $_GET); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-printer me-1"></i>Cetak Laporan
            </a>
            <a href="<?= url('tambah'); ?>" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Tambah Mahasiswa
            </a>
        </div>
    </div>

    <!-- Filter Multi-Kriteria -->
    <div class="card-body border-bottom bg-light bg-opacity-50 py-3">
        <form method="GET" action="<?= url('index'); ?>" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control" placeholder="Cari nama atau NIM..." value="<?= e($_GET['q'] ?? '') ?>">
                </div>
            </div>

            <div class="col-md-3">
                <select name="jurusan" class="form-select form-select-sm">
                    <option value="">-- Semua Program Studi --</option>
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

            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Semua Status --</option>
                    <?php
                    $statusList = ['Aktif', 'Cuti', 'Lulus', 'DO'];
                    $selectedStatus = $_GET['status'] ?? '';
                    foreach ($statusList as $st):
                    ?>
                    <option value="<?= $st; ?>" <?= ($selectedStatus === $st) ? 'selected' : ''; ?>><?= $st; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <select name="angkatan" class="form-select form-select-sm">
                    <option value="">-- Angkatan --</option>
                    <?php
                    $selectedAngkatan = (int)($_GET['angkatan'] ?? 0);
                    foreach ($angkatanList as $ang):
                    ?>
                    <option value="<?= $ang; ?>" <?= ($selectedAngkatan === $ang) ? 'selected' : ''; ?>><?= $ang; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-auto d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <a href="<?= url('index'); ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabel Data Mahasiswa -->
    <div class="card-body p-0">
        <div class="d-flex justify-content-between align-items-center px-3 py-2 bg-light border-bottom">
            <small class="text-muted">
                Menampilkan <strong><?= count($daftar_mahasiswa); ?></strong> dari <strong><?= $total; ?></strong> total mahasiswa
            </small>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-nowrap">
                    <tr>
                        <th class="ps-3" style="width: 45px;">#</th>
                        <th style="width: 55px;">Foto</th>
                        <th style="width: 100px;">NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi & Angkatan</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                        <th class="text-center" style="width: 80px;">IPK</th>
                        <th class="text-center" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftar_mahasiswa)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-2 d-block text-secondary opacity-50 mb-2"></i>
                            Tidak ada data mahasiswa yang cocok dengan kriteria pencarian.
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php
                    $no = (($page - 1) * $perPage) + 1;
                    foreach ($daftar_mahasiswa as $mhs):
                        $cleanNim = preg_replace('/[^a-zA-Z0-9]/', '', $mhs['nim']);
                    ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $no++; ?></td>
                        <td>
                            <?php if (!empty($mhs['foto']) && file_exists(__DIR__ . '/../../uploads/' . $mhs['foto'])): ?>
                                <img src="/pertemuan12/uploads/<?= e($mhs['foto']); ?>" alt="Foto" class="avatar-sm border shadow-sm">
                            <?php else: ?>
                                <div class="avatar-placeholder">
                                    <?= strtoupper(substr($mhs['nama'], 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><code><?= e($mhs['nim']); ?></code></td>
                        <td>
                            <div class="fw-semibold text-dark"><?= e($mhs['nama']); ?></div>
                            <small class="text-muted">
                                <?= ($mhs['jenis_kelamin'] ?? 'L') === 'L' ? '<span class="badge bg-light text-secondary border">L</span>' : '<span class="badge bg-light text-secondary border">P</span>'; ?>
                                <?= e($mhs['tempat_lahir']); ?>, <?= date('d M Y', strtotime($mhs['tanggal_lahir'])); ?>
                            </small>
                        </td>
                        <td>
                            <div><?= e($mhs['jurusan']); ?></div>
                            <small class="text-muted">Angkatan <?= e($mhs['angkatan'] ?? 2024); ?> &middot; <?= e($mhs['fakultas']); ?></small>
                        </td>
                        <td class="text-center">
                            <?php
                            $st = $mhs['status'] ?? 'Aktif';
                            $stClass = match($st) {
                                'Aktif' => 'success',
                                'Cuti'  => 'warning',
                                'Lulus' => 'info',
                                default => 'danger'
                            };
                            ?>
                            <span class="badge bg-<?= $stClass; ?> bg-opacity-10 text-<?= $stClass; ?> border border-<?= $stClass; ?> border-opacity-25 px-2 py-1">
                                <?= e($st); ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php
                            $ipk = (float)$mhs['ipk'];
                            $badgeClass = $ipk >= 3.5 ? 'success' : ($ipk >= 3.0 ? 'primary' : ($ipk >= 2.5 ? 'warning' : 'danger'));
                            ?>
                            <span class="badge bg-<?= $badgeClass; ?> px-2 py-1">
                                <?= number_format($ipk, 2); ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <!-- Tombol Detail / Profil Modal -->
                            <button type="button" class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $cleanNim; ?>" title="Lihat Profil">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                            <!-- Tombol Edit -->
                            <a href="<?= url('edit', ['nim' => $mhs['nim']]); ?>" class="btn btn-sm btn-outline-warning me-1" title="Edit Data">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <!-- Tombol Hapus (POST + CSRF) -->
                            <form action="<?= url('hapus'); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data <?= e($mhs['nama']); ?>?')" style="display:inline">
                                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken(); ?>">
                                <input type="hidden" name="nim" value="<?= e($mhs['nim']); ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Data">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- MODAL DETAIL BIODATA & PROFIL MAHASISWA -->
                    <div class="modal fade" id="modalDetail<?= $cleanNim; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header bg-primary text-white">
                                    <h6 class="modal-title fw-semibold">
                                        <i class="bi bi-person-badge me-2"></i>Biodata Mahasiswa
                                    </h6>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="text-center mb-4">
                                        <?php if (!empty($mhs['foto']) && file_exists(__DIR__ . '/../../uploads/' . $mhs['foto'])): ?>
                                            <img src="/pertemuan12/uploads/<?= e($mhs['foto']); ?>" alt="Foto" class="rounded-3 border shadow-sm mb-2" style="width: 100px; height: 125px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="avatar-placeholder mx-auto mb-2" style="width: 80px; height: 80px; font-size: 2rem;">
                                                <?= strtoupper(substr($mhs['nama'], 0, 1)); ?>
                                            </div>
                                        <?php endif; ?>
                                        <h5 class="fw-bold mb-0 text-dark"><?= e($mhs['nama']); ?></h5>
                                        <div class="text-muted small">NIM: <code><?= e($mhs['nim']); ?></code> &middot; Angkatan <?= e($mhs['angkatan'] ?? 2024); ?></div>
                                    </div>

                                    <table class="table table-sm table-borderless small mb-0">
                                        <tr>
                                            <td class="text-muted" style="width: 140px;">Jenis Kelamin</td>
                                            <td>: <?= ($mhs['jenis_kelamin'] ?? 'L') === 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Tempat, Tgl Lahir</td>
                                            <td>: <?= e($mhs['tempat_lahir']); ?>, <?= date('d F Y', strtotime($mhs['tanggal_lahir'])); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Fakultas</td>
                                            <td>: <?= e($mhs['fakultas']); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Program Studi</td>
                                            <td>: <strong><?= e($mhs['jurusan']); ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Status Kuliah</td>
                                            <td>: <span class="badge bg-<?= $stClass; ?>"><?= e($st); ?></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Indeks Prestasi (IPK)</td>
                                            <td>: <span class="badge bg-<?= $badgeClass; ?>"><?= number_format($ipk, 2); ?></span> <?= $ipk >= 3.50 ? '<span class="text-success fw-medium">(Cumlaude)</span>' : ''; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Email</td>
                                            <td>: <?= !empty($mhs['email']) ? '<a href="mailto:' . e($mhs['email']) . '">' . e($mhs['email']) . '</a>' : '<span class="text-muted">-</span>'; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">No. WhatsApp</td>
                                            <td>: <?= !empty($mhs['no_hp']) ? '<a href="https://wa.me/' . preg_replace('/[^0-9]/', '', $mhs['no_hp']) . '" target="_blank">' . e($mhs['no_hp']) . ' <i class="bi bi-whatsapp text-success"></i></a>' : '<span class="text-muted">-</span>'; ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-footer bg-light py-2">
                                    <a href="<?= url('cetakKtm', ['nim' => $mhs['nim']]); ?>" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="bi bi-person-vcard me-1"></i>Cetak KTM
                                    </a>
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. PAGINATION -->
    <?php if ($totalHalaman > 1): ?>
    <div class="card-footer bg-white py-3 d-flex justify-content-center">
        <nav aria-label="Navigasi Halaman">
            <ul class="pagination pagination-sm mb-0">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">
                        &laquo; Prev
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
                        Next &raquo;
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
