<?php
$judul_halaman = "Edit Data Mahasiswa - PTI Unsulbar";
require_once __DIR__ . '/../layout/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
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
                <form action="<?= url('update'); ?>" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">NIM</label>
                            <input type="text" name="nim" class="form-control bg-light" value="<?= htmlspecialchars($mahasiswa['nim']) ?>" readonly>
                            <div class="form-text small">NIM tidak dapat diubah</div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-medium small">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap Mahasiswa" value="<?= htmlspecialchars($mahasiswa['nama']) ?>" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium small">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Contoh: Majene / Polewali" value="<?= htmlspecialchars($mahasiswa['tempat_lahir']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium small">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($mahasiswa['tanggal_lahir']) ?>" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-5">
                            <label class="form-label fw-medium small">Fakultas</label>
                            <input type="text" name="fakultas" class="form-control" placeholder="Contoh: FKIP" value="<?= htmlspecialchars($mahasiswa['fakultas']) ?>" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-medium small">Program Studi</label>
                            <select name="jurusan" class="form-select" required>
                                <option value="">-- Pilih Program Studi --</option>
                                <option value="pti" <?= ($mahasiswa['jurusan'] === 'pti') ? 'selected' : ''?>>Pendidikan Teknologi Informasi</option>
                                <option value="ipa" <?= ($mahasiswa['jurusan'] === 'ipa') ? 'selected' : ''?>>Pendidikan Ilmu Pengetahuan Alam</option>
                                <option value="biologi" <?= ($mahasiswa['jurusan'] === 'biologi') ? 'selected' : ''?>>Pendidikan Biologi</option>
                                <option value="fisika" <?= ($mahasiswa['jurusan'] === 'fisika') ? 'selected' : ''?>>Pendidikan Fisika</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-medium small">IPK</label>
                            <input type="number" name="ipk" class="form-control" placeholder="3.75" step="0.01" min="0" max="4" value="<?= htmlspecialchars($mahasiswa['ipk']) ?>" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <a href="<?= url('index'); ?>" class="btn btn-outline-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
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
