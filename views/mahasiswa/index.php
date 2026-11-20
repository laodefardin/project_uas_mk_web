<?php
$judul_halaman = "Daftar Mahasiswa - PTI Unsulbar";
require_once __DIR__ . '/../layout/header.php';
?>

<?php
$pesan = ambilPesan();
if($pesan !== null):
?>
  <div class="alert alert-<?php echo $pesan['tipe'] === 'sukses' ? 'success' : 'danger';?> mt-4" role="alert"> <?php echo htmlspecialchars($pesan['isi'], ENT_QUOTES, 'UTF-8'); ?> </div>
<?php endif; ?>


<div class="card shadow-sm border-0 mt-2">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <h5 class="m-0 text-primary">Data Mahasiswa Terdaftar</h5>
        <a href="<?php echo url('tambah'); ?>" class="btn btn-sm btn-primary">+ Tambah Mahasiswa</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-primary text-nowrap">
                    <tr>
                        <th>NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Tempat, Lahir</th>
                        <th>Fakultas / Prodi</th>
                        <th>IPK</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftar_mahasiswa)): ?>
                    <tr>
                        <td>Belum ada data mahasiswa yang tersimpan</td>
                    </tr>
                    <?php else : ?>
                    <?php foreach ($daftar_mahasiswa as $mhs): ?>
                    <tr>
                        <td><?= e($mhs['nim']); ?></td>
                        <td><?= e($mhs['nama']); ?></td>
                        <td><?= e($mhs['tempat_lahir']); ?>,
                            <?= e($mhs['tanggal_lahir']); ?></td>
                        <td><?= e($mhs['fakultas']); ?></td>
                        <td>
                            <span class="badge text-bg-success px-2 py-1 text-white">
                                <?= number_format($mhs['ipk'], 2); ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?php echo url('edit', ['nim' => $mhs['nim']]); ?>"
                                class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?php echo url('hapus', ['nim' => $mhs['nim']]); ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
require_once __DIR__ . '/../layout/footer.php';
?>