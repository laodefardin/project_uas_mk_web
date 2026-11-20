<?php
$judul_halaman = "Pengaturan Akun & Profil - SIAKAD";
require_once __DIR__ . '/../layout/header.php';

$pesan = ambilPesan();
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <?php if ($pesan !== null): ?>
        <div class="alert alert-<?= $pesan['tipe'] === 'sukses' ? 'success' : 'danger'; ?> mb-4 alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi <?= $pesan['tipe'] === 'sukses' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'; ?> fs-5 me-2"></i>
            <div><?= htmlspecialchars($pesan['isi'], ENT_QUOTES, 'UTF-8'); ?></div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="m-0 text-primary fw-semibold">
                    <i class="bi bi-person-circle me-2"></i>Informasi Akun
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary" style="width: 56px; height: 56px; font-size: 1.75rem;">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-semibold"><?= htmlspecialchars($user['nama'] ?? $_SESSION['nama'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        <p class="text-muted small mb-0">Username: <code><?= htmlspecialchars($user['username'] ?? $_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></code></p>
                        <span class="badge bg-primary bg-opacity-10 text-primary mt-1">
                            <?= ucfirst(htmlspecialchars($user['hak_akses'] ?? 'Operator', ENT_QUOTES, 'UTF-8')); ?>
                        </span>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="fw-semibold mb-3">
                    <i class="bi bi-shield-lock me-1 text-primary"></i>Ganti Password
                </h6>

                <form action="<?= url('updatePassword'); ?>" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">

                    <div class="mb-3">
                        <label class="form-label fw-medium small">Password Saat Ini (Lama)</label>
                        <input type="password" name="password_lama" class="form-control" required placeholder="Masukkan password lama">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium small">Password Baru</label>
                        <input type="password" name="password_baru" class="form-control" minlength="8" required placeholder="Minimal 8 karakter">
                        <div class="form-text small">Gunakan kombinasi huruf dan angka minimal 8 karakter.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium small">Konfirmasi Password Baru</label>
                        <input type="password" name="konfirmasi_password" class="form-control" minlength="8" required placeholder="Ulangi password baru">
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= url('index'); ?>" class="btn btn-outline-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i>Simpan Password Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
