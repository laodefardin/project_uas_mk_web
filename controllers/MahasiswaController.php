<?php
require_once __DIR__ . '/../models/MahasiswaModel.php';

class MahasiswaController {
    private $model;

    public function __construct(){
        $this->model = new MahasiswaModel();
    }

    public function index(){
        $perPage = 10;
        $page = max(1, (int)($_GET['page'] ?? 1));
        $keyword = trim($_GET['q'] ?? '');
        $jurusan = trim($_GET['jurusan'] ?? '');

        $total = $this->model->countAll($keyword, $jurusan);
        $totalHalaman = max(1, (int)ceil($total / $perPage));
        $page = min($page, $totalHalaman);
        $daftar_mahasiswa = $this->model->getPage($page, $perPage, $keyword, $jurusan);

        require_once __DIR__ . '/../views/mahasiswa/index.php';
    }

    public function tambah(){
        require_once __DIR__ . '/../views/mahasiswa/tambah.php';
    }

    public function simpan(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            verifyCsrfToken($_POST['csrf_token'] ?? '');

            $nim = trim($_POST['nim'] ?? '');
            $ipk = $_POST['ipk'] ?? '';
            if (!preg_match('/^\d{8}$/', $nim)) {
                setPesan('gagal', 'NIM harus tepat 8 digit angka.');
                header("Location: " . url('tambah')); exit;
            }
            if (!is_numeric($ipk) || (float)$ipk < 0 || (float)$ipk > 4) {
                setPesan('gagal', 'IPK harus berupa angka antara 0.00 hingga 4.00.');
                header("Location: " . url('tambah')); exit;
            }

            $hasil = $this->model->tambah($_POST);

            if($hasil) {
                setPesan('sukses', 'Data Mahasiswa Berhasil ditambahkan');
                header("Location: index.php?act=index");
                exit;
            } else {
                setPesan('gagal', 'Data mahasiswa gagal disimpan, Periksa kembali isian anda');
                header("Location: index.php?act=tambah");
                exit;
            }
        }
        header("Location: index.php");
        exit;
    }

    public function edit(){
        $nim = $_GET['nim'] ?? '';
        $mahasiswa = $this->model->getByNim($nim);

        if (!$mahasiswa){
            header("Location: index.php?pesan=data_tidak_ditemukan");
            exit;
        }

        require_once __DIR__ . '/../views/mahasiswa/edit.php';
    }

    public function update(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            verifyCsrfToken($_POST['csrf_token'] ?? '');

            $nim = trim($_POST['nim'] ?? '');
            $ipk = $_POST['ipk'] ?? '';
            if (!preg_match('/^\d{8}$/', $nim)) {
                setPesan('gagal', 'NIM harus tepat 8 digit angka.');
                header("Location: " . url('edit', ['nim' => $nim])); exit;
            }
            if (!is_numeric($ipk) || (float)$ipk < 0 || (float)$ipk > 4) {
                setPesan('gagal', 'IPK harus berupa angka antara 0.00 hingga 4.00.');
                header("Location: " . url('edit', ['nim' => $nim])); exit;
            }

            $this->model->ubah($nim, $_POST);

            setPesan('sukses', 'Data Berhasil Di ubah');
            header("Location: index.php?act=index");
            exit;
        }
    }

    public function hapus(){
        $nim = $_POST['nim'] ?? $_GET['nim'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verifyCsrfToken($_POST['csrf_token'] ?? '');
        }

        if(!empty($nim)){
            
        if($this->model->hapus($nim)) {
             setPesan('sukses', 'Data Berhasil di Hapus');
        }else{
             setPesan('gagal', 'Data Gagal di Hapus');
        }  
            header("Location: index.php?act=index");
            exit;
        }
        header("Location: index.php");
        exit;
    }
}