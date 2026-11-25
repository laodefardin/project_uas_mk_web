<?php
require_once __DIR__ . '/../models/MahasiswaModel.php';

class MahasiswaController {
    private $model;

    public function __construct() {
        $this->model = new MahasiswaModel();
    }

    public function index() {
        $perPage   = 10;
        $page      = max(1, (int)($_GET['page'] ?? 1));
        $keyword   = trim($_GET['q'] ?? '');
        $jurusan   = trim($_GET['jurusan'] ?? '');
        $status    = trim($_GET['status'] ?? '');
        $angkatan  = trim($_GET['angkatan'] ?? '');

        $stats        = $this->model->getStats();
        $angkatanList = $this->model->getAngkatanList();

        $total        = $this->model->countAll($keyword, $jurusan, $status, $angkatan);
        $totalHalaman = max(1, (int)ceil($total / $perPage));
        $page         = min($page, $totalHalaman);
        $daftar_mahasiswa = $this->model->getPage($page, $perPage, $keyword, $jurusan, $status, $angkatan);

        require_once __DIR__ . '/../views/mahasiswa/index.php';
    }

    public function tambah() {
        require_once __DIR__ . '/../views/mahasiswa/tambah.php';
    }

    public function simpan() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verifyCsrfToken($_POST['csrf_token'] ?? '');

            $nim           = trim($_POST['nim'] ?? '');
            $nama          = trim($_POST['nama'] ?? '');
            $tempat_lahir  = trim($_POST['tempat_lahir'] ?? '');
            $tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
            $fakultas      = trim($_POST['fakultas'] ?? '');
            $jurusan       = trim($_POST['jurusan'] ?? '');
            $angkatan      = (int)($_POST['angkatan'] ?? 0);
            $email         = trim($_POST['email'] ?? '');
            $ipk           = $_POST['ipk'] ?? '';

            if (!preg_match('/^\d{8}$/', $nim)) {
                setPesan('gagal', 'NIM harus tepat 8 digit angka.');
                header("Location: " . url('tambah'));
                exit;
            }

            if ($this->model->getByNim($nim)) {
                setPesan('gagal', 'Mahasiswa dengan NIM ' . $nim . ' sudah terdaftar.');
                header("Location: " . url('tambah'));
                exit;
            }

            if ($nama === '' || $tempat_lahir === '' || $tanggal_lahir === '' || $fakultas === '' || $jurusan === '') {
                setPesan('gagal', 'Semua kolom bertanda wajib (*) harus diisi.');
                header("Location: " . url('tambah'));
                exit;
            }

            if ($angkatan < 2000 || $angkatan > 2100) {
                setPesan('gagal', 'Tahun angkatan tidak valid.');
                header("Location: " . url('tambah'));
                exit;
            }

            if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                setPesan('gagal', 'Format email tidak valid.');
                header("Location: " . url('tambah'));
                exit;
            }

            if (!is_numeric($ipk) || (float)$ipk < 0 || (float)$ipk > 4) {
                setPesan('gagal', 'IPK harus berupa angka antara 0.00 hingga 4.00.');
                header("Location: " . url('tambah'));
                exit;
            }

            // Upload foto jika ada
            $fotoNama = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
                $uploadRes = $this->prosesUploadFoto($_FILES['foto'], $nim);
                if ($uploadRes['error']) {
                    setPesan('gagal', $uploadRes['pesan']);
                    header("Location: " . url('tambah'));
                    exit;
                }
                $fotoNama = $uploadRes['nama_file'];
            }

            $hasil = $this->model->tambah($_POST, $fotoNama);

            if ($hasil) {
                setPesan('sukses', "Data Mahasiswa {$nama} berhasil ditambahkan.");
                header("Location: " . url('index'));
                exit;
            } else {
                if ($fotoNama !== null) {
                    $newPath = __DIR__ . '/../uploads/' . $fotoNama;
                    if (file_exists($newPath) && is_file($newPath)) {
                        @unlink($newPath);
                    }
                }
                setPesan('gagal', 'Data mahasiswa gagal disimpan. Periksa kembali isian Anda.');
                header("Location: " . url('tambah'));
                exit;
            }
        }
        header("Location: " . url('index'));
        exit;
    }

    public function edit() {
        $nim = $_GET['nim'] ?? '';
        $mahasiswa = $this->model->getByNim($nim);

        if (!$mahasiswa) {
            setPesan('gagal', 'Data mahasiswa tidak ditemukan.');
            header("Location: " . url('index'));
            exit;
        }

        require_once __DIR__ . '/../views/mahasiswa/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verifyCsrfToken($_POST['csrf_token'] ?? '');

            $nim           = trim($_POST['nim'] ?? '');
            $nama          = trim($_POST['nama'] ?? '');
            $tempat_lahir  = trim($_POST['tempat_lahir'] ?? '');
            $tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
            $fakultas      = trim($_POST['fakultas'] ?? '');
            $jurusan       = trim($_POST['jurusan'] ?? '');
            $angkatan      = (int)($_POST['angkatan'] ?? 0);
            $email         = trim($_POST['email'] ?? '');
            $ipk           = $_POST['ipk'] ?? '';

            $mahasiswaLama = $this->model->getByNim($nim);
            if (!$mahasiswaLama) {
                setPesan('gagal', 'Data mahasiswa tidak ditemukan.');
                header("Location: " . url('index'));
                exit;
            }

            if ($nama === '' || $tempat_lahir === '' || $tanggal_lahir === '' || $fakultas === '' || $jurusan === '') {
                setPesan('gagal', 'Semua kolom bertanda wajib (*) harus diisi.');
                header("Location: " . url('edit', ['nim' => $nim]));
                exit;
            }

            if ($angkatan < 2000 || $angkatan > 2100) {
                setPesan('gagal', 'Tahun angkatan tidak valid.');
                header("Location: " . url('edit', ['nim' => $nim]));
                exit;
            }

            if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                setPesan('gagal', 'Format email tidak valid.');
                header("Location: " . url('edit', ['nim' => $nim]));
                exit;
            }

            if (!is_numeric($ipk) || (float)$ipk < 0 || (float)$ipk > 4) {
                setPesan('gagal', 'IPK harus berupa angka antara 0.00 hingga 4.00.');
                header("Location: " . url('edit', ['nim' => $nim]));
                exit;
            }

            // Cek apakah ada upload foto baru
            $fotoNama = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
                $uploadRes = $this->prosesUploadFoto($_FILES['foto'], $nim);
                if ($uploadRes['error']) {
                    setPesan('gagal', $uploadRes['pesan']);
                    header("Location: " . url('edit', ['nim' => $nim]));
                    exit;
                }
                $fotoNama = $uploadRes['nama_file'];
            }

            $hasil = $this->model->ubah($nim, $_POST, $fotoNama);

            if ($hasil) {
                // Hapus foto lama hanya setelah pembaruan database berhasil
                if ($fotoNama !== null && !empty($mahasiswaLama['foto'])) {
                    $oldPath = __DIR__ . '/../uploads/' . $mahasiswaLama['foto'];
                    if (file_exists($oldPath) && is_file($oldPath)) {
                        @unlink($oldPath);
                    }
                }
                setPesan('sukses', "Data Mahasiswa {$nama} berhasil diperbarui.");
            } else {
                if ($fotoNama !== null) {
                    $newPath = __DIR__ . '/../uploads/' . $fotoNama;
                    if (file_exists($newPath) && is_file($newPath)) {
                        @unlink($newPath);
                    }
                }
                setPesan('gagal', 'Gagal memperbarui data mahasiswa.');
            }
            header("Location: " . url('index'));
            exit;
        }
        header("Location: " . url('index'));
        exit;
    }

    public function hapus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . url('index'));
            exit;
        }

        verifyCsrfToken($_POST['csrf_token'] ?? '');
        $nim = trim($_POST['nim'] ?? $_GET['nim'] ?? '');

        if ($nim !== '') {
            if ($this->model->hapus($nim)) {
                setPesan('sukses', 'Data Mahasiswa berhasil dihapus.');
            } else {
                setPesan('gagal', 'Data Mahasiswa gagal dihapus.');
            }
        }
        header("Location: " . url('index'));
        exit;
    }

    public function exportCsv() {
        $keyword  = trim($_GET['q'] ?? '');
        $jurusan  = trim($_GET['jurusan'] ?? '');
        $status   = trim($_GET['status'] ?? '');
        $angkatan = trim($_GET['angkatan'] ?? '');

        $total = $this->model->countAll($keyword, $jurusan, $status, $angkatan);
        $data  = $this->model->getPage(1, max(1, $total), $keyword, $jurusan, $status, $angkatan);

        $filename = "data_mahasiswa_siakad_" . date('Ymd_His') . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        // UTF-8 BOM untuk Microsoft Excel
        fputs($output, "\xEF\xBB\xBF");

        // Header kolom
        fputcsv($output, ['No', 'NIM', 'Nama Lengkap', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Fakultas', 'Program Studi', 'Angkatan', 'Status', 'Email', 'No HP', 'IPK']);

        $no = 1;
        foreach ($data as $mhs) {
            fputcsv($output, [
                $no++,
                "'" . $mhs['nim'], // apostrof agar Excel membaca sebagai teks tanpa memotong angka 0 di depan
                $mhs['nama'],
                $mhs['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan',
                $mhs['tempat_lahir'],
                $mhs['tanggal_lahir'],
                $mhs['fakultas'],
                $mhs['jurusan'],
                $mhs['angkatan'],
                $mhs['status'],
                $mhs['email'] ?? '',
                $mhs['no_hp'] ?? '',
                number_format((float)$mhs['ipk'], 2)
            ]);
        }

        fclose($output);
        exit;
    }

    public function cetakLaporan() {
        $keyword  = trim($_GET['q'] ?? '');
        $jurusan  = trim($_GET['jurusan'] ?? '');
        $status   = trim($_GET['status'] ?? '');
        $angkatan = trim($_GET['angkatan'] ?? '');

        $total = $this->model->countAll($keyword, $jurusan, $status, $angkatan);
        $daftar_mahasiswa = $this->model->getPage(1, max(1, $total), $keyword, $jurusan, $status, $angkatan);
        $stats = $this->model->getStats($keyword, $jurusan, $status, $angkatan);

        require_once __DIR__ . '/../views/mahasiswa/cetak_laporan.php';
    }

    public function cetakKtm() {
        $nim = $_GET['nim'] ?? '';
        $mhs = $this->model->getByNim($nim);

        if (!$mhs) {
            setPesan('gagal', 'Mahasiswa tidak ditemukan untuk cetak KTM.');
            header("Location: " . url('index'));
            exit;
        }

        require_once __DIR__ . '/../views/mahasiswa/cetak_ktm.php';
    }

    private function prosesUploadFoto($file, $nim) {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
        $allowedExts  = ['jpg', 'jpeg', 'png', 'webp'];
        $maxSize      = 2 * 1024 * 1024; // 2MB

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            if (in_array($file['error'], [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
                return ['error' => true, 'pesan' => 'Ukuran foto maksimal 2 MB.'];
            }
            return ['error' => true, 'pesan' => 'Gagal mengunggah foto. Silakan coba lagi.'];
        }

        if ($file['size'] > $maxSize) {
            return ['error' => true, 'pesan' => 'Ukuran foto maksimal 2 MB.'];
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExts)) {
            return ['error' => true, 'pesan' => 'Format file foto harus JPG, PNG, atau WEBP.'];
        }

        // Verifikasi MIME type asli
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowedMimes)) {
            return ['error' => true, 'pesan' => 'Tipe konten file tidak valid. Unggah file gambar yang sah.'];
        }

        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $cleanNim  = preg_replace('/[^a-zA-Z0-9]/', '', $nim);
        $namaFileBaru = 'mhs_' . $cleanNim . '_' . time() . '.' . $ext;
        $destPath     = $uploadDir . $namaFileBaru;

        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            return ['error' => false, 'nama_file' => $namaFileBaru];
        }

        return ['error' => true, 'pesan' => 'Gagal mengunggah foto ke server.'];
    }
}
