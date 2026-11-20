<?php
$judul_halaman = "Daftar Mahasiswa - PTI Unsulbar";
require_once __DIR__ . '/../layout/header.php';
?>

<?php
$pesan = ambilPesan();
if($pesan !== null):
?>
  <div class="alert alert-<?php echo $pesan['tipe'] === 'sukses' ? 'success' : 'danger';?> mb-4 alert-dismissible fade show d-flex align-items-center" role="alert">
    <i class="bi <?php echo $pesan['tipe'] === 'sukses' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'; ?> fs-5 me-2"></i>
    <div><?php echo htmlspecialchars($pesan['isi'], ENT_QUOTES, 'UTF-8'); ?></div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h5 class="m-0 text-primary fw-semibold">
            <i class="bi bi-people-fill me-2"></i>Data Mahasiswa Terdaftar
        </h5>
        <a href="<?php echo url('tambah'); ?>" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Mahasiswa
        </a>
    </div>

    <div class="card-body border-bottom bg-light bg-opacity-50 py-3">
        <form method="GET" action="<?= url('index') ?>" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control"
                        placeholder="Cari nama atau NIM..."
                        value="<?= e($_GET['q'] ?? '') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <select name="jurusan" class="form-select form-select-sm">
                    <option value="">-- Semua Program Studi --</option>
                    <?php
                    $jurusanList = [
                        'pti' => 'Pendidikan Teknologi Informasi',
                        'ipa' => 'Pendidikan IPA',
                        'biologi' => 'Pendidikan Biologi',
                        'fisika' => 'Pendidikan Fisika'
                    ];
                    foreach($jurusanList as $val => $label):
                    ?>
                    <option value="<?= e($val) ?>" <?= (($_GET['jurusan'] ?? '') === $val) ? 'selected' : '' ?>>
                        <?= e($label) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary">
                    Cari
                </button>
                <a href="<?= url('index') ?>" class="btn btn-sm btn-outline-secondary">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        <div class="d-flex justify-content-between align-items-center px-3 py-2 bg-light border-bottom">
            <small class="text-muted">
                Menampilkan <strong><?= count($daftar_mahasiswa) ?></strong> dari <strong><?= $total ?></strong> total mahasiswa
            </small>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-nowrap">
                    <tr>
                        <th class="ps-3" style="width: 50px;">#</th>
                        <th>NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Tempat, Tgl Lahir</th>
                        <th>Fakultas / Prodi</th>
                        <th class="text-center" style="width: 90px;">IPK</th>
                        <th class="text-center" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftar_mahasiswa)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-2 d-block text-secondary opacity-50 mb-2"></i>
                            Tidak ada data mahasiswa yang ditemukan
                        </td>
                    </tr>
                    <?php else : ?>
                    <?php
                    $no = (($page - 1) * 10) + 1;
                    foreach ($daftar_mahasiswa as $mhs): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $no++ ?></td>
                        <td><code><?= e($mhs['nim']); ?></code></td>
                        <td class="fw-medium text-dark"><?= e($mhs['nama']); ?></td>
                        <td class="text-muted small">
                            <?= e($mhs['tempat_lahir']); ?>,
                            <?= date('d M Y', strtotime($mhs['tanggal_lahir'])); ?>
                        </td>
                        <td>
                            <div><?= e($mhs['fakultas']); ?></div>
                            <small class="text-muted"><?= e(strtoupper($mhs['jurusan'])); ?></small>
                        </td>
                        <td class="text-center">
                            <?php
                            $ipk = (float)$mhs['ipk'];
                            $badgeClass = $ipk >= 3.5 ? 'success' : ($ipk >= 3.0 ? 'primary' : ($ipk >= 2.5 ? 'warning' : 'danger'));
                            ?>
                            <span class="badge bg-<?= $badgeClass ?> px-2 py-1">
                                <?= number_format($ipk, 2); ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo url('edit', ['nim' => $mhs['nim']]); ?>"
                                class="btn btn-sm btn-outline-warning me-1" title="Edit Data">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="<?= url('hapus', ['nim' => $mhs['nim']]) ?>" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus data <?= e($mhs['nama']) ?>?')"
                                  style="display:inline">
                                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                                <input type="hidden" name="nim" value="<?= e($mhs['nim']) ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Data">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if ($totalHalaman > 1): ?>
    <div class="card-footer bg-white py-3 d-flex justify-content-center">
        <nav aria-label="Navigasi Halaman">
            <ul class="pagination pagination-sm mb-0">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">
                        &laquo; Prev
                    </a>
                </li>
                <?php endif; ?>

                <?php for ($i = max(1, $page - 2); $i <= min($totalHalaman, $page + 2); $i++): ?>
                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>

                <?php if ($page < $totalHalaman): ?>
                <li class="page-item">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">
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
