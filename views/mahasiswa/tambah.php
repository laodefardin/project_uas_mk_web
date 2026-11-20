<?php
$judul_halaman = "Tambah Mahasiswa Baru - SIAKAD";
require_once __DIR__ . '/../layout/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-9">
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
                <form action="<?= url('simpan'); ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">

                    <!-- Bagian Foto Profil Mahasiswa dengan Live Preview -->
                    <div class="d-flex align-items-center gap-4 mb-4 p-3 bg-light rounded-3 border">
                        <div class="position-relative">
                            <img id="previewFoto" src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='90' height='115' viewBox='0 0 90 115'><rect width='90' height='115' fill='%23f1f5f9'/><circle cx='45' cy='42' r='18' fill='%23cbd5e1'/><path d='M20 95c0-18 12-28 25-28s25 10 25 28z' fill='%23cbd5e1'/></svg>" alt="Preview Foto" 
                                 class="rounded border bg-white shadow-sm" style="width: 90px; height: 115px; object-fit: cover;">
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label fw-semibold small mb-1">
                                <i class="bi bi-camera me-1 text-primary"></i>Foto Profil Mahasiswa (Opsional)
                            </label>
                            <input type="file" name="foto" id="inputFoto" class="form-control form-control-sm" accept="image/jpeg,image/png,image/webp">
                            <div class="form-text small">Format JPG, PNG, atau WEBP. Ukuran maksimal 2 MB.</div>
                        </div>
                    </div>

                    <h6 class="fw-semibold text-secondary mb-3 small text-uppercase" style="letter-spacing: 0.5px;">1. Identitas Pokok</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">NIM (8 Digit Angka) <span class="text-danger">*</span></label>
                            <input type="text" name="nim" class="form-control" placeholder="Contoh: 24010001" maxlength="8" pattern="\d{8}" required autofocus>
                            <div class="form-text small">Tepat 8 digit angka</div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-medium small">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap Mahasiswa" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-medium small">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-medium small">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Contoh: Majene / Polewali" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium small">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" class="form-control" required>
                        </div>
                    </div>

                    <h6 class="fw-semibold text-secondary mb-3 small text-uppercase" style="letter-spacing: 0.5px;">2. Program & Status Akademik</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">Fakultas <span class="text-danger">*</span></label>
                            <input type="text" name="fakultas" class="form-control" value="FKIP" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">Program Studi <span class="text-danger">*</span></label>
                            <select name="jurusan" class="form-select" required>
                                <option value="">-- Pilih Program Studi --</option>
                                <option value="Pendidikan Teknologi Informasi" selected>Pendidikan Teknologi Informasi</option>
                                <option value="Pendidikan Ilmu Pengetahuan Alam">Pendidikan Ilmu Pengetahuan Alam</option>
                                <option value="Pendidikan Biologi">Pendidikan Biologi</option>
                                <option value="Pendidikan Fisika">Pendidikan Fisika</option>
                                <option value="Pendidikan Matematika">Pendidikan Matematika</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-medium small">Angkatan</label>
                            <input type="number" name="angkatan" class="form-control" value="<?= date('Y'); ?>" min="2015" max="2035" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-medium small">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Aktif" selected>Aktif</option>
                                <option value="Cuti">Cuti</option>
                                <option value="Lulus">Lulus</option>
                                <option value="DO">DO</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-medium small">IPK Kumulatif <span class="text-danger">*</span></label>
                            <input type="number" name="ipk" class="form-control" placeholder="Contoh: 3.75" step="0.01" min="0" max="4" required>
                            <div class="form-text small">Rentang 0.00 s/d 4.00</div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-medium small">Email Mahasiswa</label>
                            <input type="email" name="email" class="form-control" placeholder="mahasiswa@unsulbar.ac.id">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">No. WhatsApp / HP</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= url('index'); ?>" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i>Simpan Data Mahasiswa
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
