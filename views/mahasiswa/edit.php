<?php
$judul_halaman = "Edit Data Mahasiswa - SIAKAD";
require_once __DIR__ . '/../layout/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <h5 class="m-0 text-primary fw-semibold">
                    <i class="bi bi-pencil-square me-2"></i>Edit Data Mahasiswa
                </h5>
                <a href="<?= url('index'); ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body p-4">
                <form action="<?= url('update'); ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">

                    <!-- Bagian Foto Profil Mahasiswa dengan Live Preview -->
                    <div class="d-flex align-items-center gap-4 mb-4 p-3 bg-light rounded-3 border">
                        <div class="position-relative">
                            <?php 
                            $fotoSrc = (!empty($mahasiswa['foto']) && file_exists(__DIR__ . '/../../uploads/' . $mahasiswa['foto']))
                                ? '/pertemuan12/uploads/' . htmlspecialchars($mahasiswa['foto'], ENT_QUOTES, 'UTF-8')
                                : 'https://via.placeholder.com/100x125?text=Foto';
                            ?>
                            <img id="previewFoto" src="<?= $fotoSrc; ?>" alt="Foto Mahasiswa" 
                                 class="rounded border bg-white shadow-sm" style="width: 90px; height: 115px; object-fit: cover;">
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label fw-semibold small mb-1">
                                <i class="bi bi-camera me-1 text-primary"></i>Ubah Foto Mahasiswa (Opsional)
                            </label>
                            <input type="file" name="foto" id="inputFoto" class="form-control form-control-sm" accept="image/jpeg,image/png,image/webp">
                            <div class="form-text small">Biarkan kosong jika tidak ingin mengganti foto. Format: JPG, PNG, WEBP (Max 2MB).</div>
                        </div>
                    </div>

                    <h6 class="fw-semibold text-secondary mb-3 small text-uppercase" style="letter-spacing: 0.5px;">1. Identitas Pokok</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">NIM</label>
                            <input type="text" name="nim" class="form-control bg-light" value="<?= htmlspecialchars($mahasiswa['nim']) ?>" readonly>
                            <div class="form-text small">NIM adalah kunci unik, tidak dapat diedit.</div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-medium small">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($mahasiswa['nama']) ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-medium small">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L" <?= ($mahasiswa['jenis_kelamin'] ?? 'L') === 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="P" <?= ($mahasiswa['jenis_kelamin'] ?? '') === 'P' ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-medium small">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" class="form-control" value="<?= htmlspecialchars($mahasiswa['tempat_lahir']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium small">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($mahasiswa['tanggal_lahir']) ?>" class="form-control" required>
                        </div>
                    </div>

                    <h6 class="fw-semibold text-secondary mb-3 small text-uppercase" style="letter-spacing: 0.5px;">2. Program & Status Akademik</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">Fakultas <span class="text-danger">*</span></label>
                            <input type="text" name="fakultas" class="form-control" value="<?= htmlspecialchars($mahasiswa['fakultas']) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">Program Studi <span class="text-danger">*</span></label>
                            <select name="jurusan" class="form-select" required>
                                <?php
                                $prodiList = [
                                    'Pendidikan Teknologi Informasi',
                                    'Pendidikan Ilmu Pengetahuan Alam',
                                    'Pendidikan Biologi',
                                    'Pendidikan Fisika',
                                    'Pendidikan Matematika'
                                ];
                                $currentProdi = $mahasiswa['jurusan'];
                                foreach ($prodiList as $p):
                                    $isSelected = ($currentProdi === $p || ($p === 'Pendidikan Teknologi Informasi' && strtolower($currentProdi) === 'pti') || ($p === 'Pendidikan Ilmu Pengetahuan Alam' && strtolower($currentProdi) === 'ipa'));
                                ?>
                                <option value="<?= $p; ?>" <?= $isSelected ? 'selected' : ''; ?>><?= $p; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-medium small">Angkatan</label>
                            <input type="number" name="angkatan" class="form-control" value="<?= htmlspecialchars($mahasiswa['angkatan'] ?? date('Y')) ?>" min="2015" max="2035" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-medium small">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Aktif" <?= ($mahasiswa['status'] ?? 'Aktif') === 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                                <option value="Cuti" <?= ($mahasiswa['status'] ?? '') === 'Cuti' ? 'selected' : ''; ?>>Cuti</option>
                                <option value="Lulus" <?= ($mahasiswa['status'] ?? '') === 'Lulus' ? 'selected' : ''; ?>>Lulus</option>
                                <option value="DO" <?= ($mahasiswa['status'] ?? '') === 'DO' ? 'selected' : ''; ?>>DO</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-medium small">IPK Kumulatif <span class="text-danger">*</span></label>
                            <input type="number" name="ipk" class="form-control" step="0.01" min="0" max="4" value="<?= htmlspecialchars($mahasiswa['ipk']) ?>" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-medium small">Email Mahasiswa</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($mahasiswa['email'] ?? '') ?>" placeholder="mahasiswa@unsulbar.ac.id">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">No. WhatsApp / HP</label>
                            <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($mahasiswa['no_hp'] ?? '') ?>" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= url('index'); ?>" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning px-4 text-dark fw-medium">
                            <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Live image preview
    document.getElementById('inputFoto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('previewFoto').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
