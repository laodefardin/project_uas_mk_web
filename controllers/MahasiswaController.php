<?php
require_once __DIR__ . '/../models/MahasiswaModel.php';

class MahasiswaController {
    private $model;

    public function __construct(){
        $this->model = new MahasiswaModel();
    }

    public function index(){
        $daftar_mahasiswa = $this->model->getAll();

        require_once __DIR__ . '/../views/mahasiswa/index.php';
    }

    public function tambah(){
        require_once __DIR__ . '/../views/mahasiswa/tambah.php';
    }

    public function simpan(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
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
            $nim = $_POST['nim'];
            $this->model->ubah($nim, $_POST);

            setPesan('sukses', 'Data Berhasil Di ubah');
            header("Location: index.php?act=index");
            exit;
        }
    }

    public function hapus(){
        $nim = $_GET['nim'] ?? '';

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