<?php
$judul_halaman = "Tambah Mahasiswa Baru - PTI Unsulbar";
require_once __DIR__ . '/../layout/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <h5 class="m-0 text-primary fw-semibold">
                    <i class="bi bi-person-plus-fill me-2"></i>Tambah Mahasiswa Baru
                </h5>
                <a href="<?= url('index'); ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body p-4">
                <form action="<?= url('simpan'); ?>" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">NIM (8 Digit Angka)</label>
                            <input type="text" name="nim" class="form-control" placeholder="Contoh: 20141238" maxlength="8" pattern="\d{8}" required autofocus>
                            <div class="form-text small">Tepat 8 digit angka</div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-medium small">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap Mahasiswa" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium small">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Contoh: Majene / Polewali" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium small">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-5">
                            <label class="form-label fw-medium small">Fakultas</label>
                            <input type="text" name="fakultas" class="form-control" placeholder="Contoh: FKIP" value="FKIP" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-medium small">Program Studi</label>
                            <select name="jurusan" class="form-select" required>
                                <option value="">-- Pilih Program Studi --</option>
                                <option value="pti">Pendidikan Teknologi Informasi</option>
                                <option value="ipa">Pendidikan Ilmu Pengetahuan Alam</option>
                                <option value="biologi">Pendidikan Biologi</option>
                                <option value="fisika">Pendidikan Fisika</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-medium small">IPK</label>
                            <input type="number" name="ipk" class="form-control" placeholder="3.75" step="0.01" min="0" max="4" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <a href="<?= url('index'); ?>" class="btn btn-outline-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i>Simpan Data Mahasiswa
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
