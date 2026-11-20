<?php
$judul_halaman = "Edit Data Mahasiswa Baru";

require_once __DIR__ . '/../layout/header.php';
?>


<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="m-0 fw-bold text-primary">Formulir Pendaftaran Mahasiswa</h5>
            </div>
            <div class="card-body">
                <form action="index.php?act=update" method="post">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="" class="form-label">Nim (8 Digit)</label>
                            <input type="text" name="nim" class="form-control" placeholder="Contoh: 20141238" maxlength="8" value="<?= htmlspecialchars($mahasiswa['nim']) ?>" readonly>
                        </div>
                         <div class="col-md-8">
                            <label for="" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap Mahasiswa" value="<?= htmlspecialchars($mahasiswa['nama']) ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="" class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Contoh: Majene/Polewali" value="<?= htmlspecialchars($mahasiswa['tempat_lahir']) ?>" required>
                        </div>
                         <div class="col-md-6">
                            <label for="" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($mahasiswa['tanggal_lahir']) ?>" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label for="" class="form-label">Fakultas</label>
                            <input type="text" name="fakultas" class="form-control" placeholder="Contoh: FKIP"  value="<?= htmlspecialchars($mahasiswa['fakultas']) ?>" required>
                        </div>
                         <div class="col-md-5">
                            <label for="" class="form-label">Program Studi</label>
                            <select name="jurusan" class="form-control" required>
                                <option value="">-- Pilih Program Studi -- </option>
                                <option value="pti" <?= ($mahasiswa['jurusan']) == 'pti' ? 'selected' : ''?> >Pendidikan Teknologi Informasi</option>
                                <option value="ipa" <?= ($mahasiswa['jurusan']) == 'ipa' ? 'selected' : ''?>>Pendidikan Ilmu Pengetahuan Alam</option>
                                <option value="biologi" <?= ($mahasiswa['jurusan']) == 'biologi' ? 'selected' : ''?> >Pendidikan Biologi</option>
                                <option value="fisika" <?= ($mahasiswa['jurusan']) == 'fisika' ? 'selected' : ''?> >Pendidikan Fisika</option>
                            </select>
                        </div>
                         <div class="col-md-2">
                            <label for="" class="form-label">IPK</label>
                            <input type="text" name="ipk" class="form-control" placeholder="Contoh: 3.75"  value="<?= htmlspecialchars($mahasiswa['ipk']) ?>" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between pt-2">
                        <a href="<?php echo url('index'); ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Update Data Mahasiswa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php
require_once __DIR__ . '/../layout/footer.php';
?>
