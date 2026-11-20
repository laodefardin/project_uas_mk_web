<?php
require_once __DIR__ . '/../config/database.php';

class MahasiswaModel {
    private $db;

    public function __construct(){
        $this->db = getKoneksi();
    }

    public function getAll(){
        $query = "SELECT * FROM mahasiswa ORDER by nim ASC";
        $result = mysqli_query($this->db, $query);

        $daftar = [];
        while ($baris = mysqli_fetch_assoc($result)){
            $daftar[] = $baris;
        }
        return $daftar;
    }

    public function tambah($data){
        $nim            = $data['nim'];
        $nama           = $data['nama'];
        $tempat_lahir   = $data['tempat_lahir'];
        $tanggal_lahir  = $data['tanggal_lahir'];
        $fakultas       = $data['fakultas'];
        $jurusan        = $data['jurusan'];
        $ipk            = (float) $data['ipk'];

        $query = "INSERT INTO mahasiswa
                (nim, nama, tempat_lahir, tanggal_lahir, fakultas, jurusan, ipk) VALUES
              (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->db, $query);
        
        mysqli_stmt_bind_param(
            $stmt, "ssssssd",
            $nim,
            $nama,
            $tempat_lahir,
            $tanggal_lahir,
            $fakultas,
            $jurusan,
            $ipk
        );

        return mysqli_stmt_execute($stmt); 
    }

    public function getByNim($nim){
        // $nimBersih = mysqli_real_escape_string($this->db, $nim);
        $query = "SELECT * FROM mahasiswa WHERE nim = ? ";
        $stmt = mysqli_prepare($this->db, $query);

        if (!$stmt){
            return null;
        }

        mysqli_stmt_bind_param($stmt, "s", $nim);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);
        return $data;
    }

    public function ubah($nim, $data){
        $nama           = $data['nama'];
        $tempat_lahir   = $data['tempat_lahir'];
        $tanggal_lahir  = $data['tanggal_lahir'];
        $fakultas       = $data['fakultas'];
        $jurusan        = $data['jurusan'];
        $ipk            = (float) $data['ipk'];
        
        $query = "UPDATE mahasiswa SET
                    nama = ?,
                    tempat_lahir = ?,
                    tanggal_lahir = ?,
                    fakultas = ?,
                    jurusan = ?,
                    ipk = ? 
                    WHERE nim = ?";
        
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param(
            $stmt,
            "sssssds",
            $nama,
            $tempat_lahir,
            $tanggal_lahir,
            $fakultas,
            $jurusan,
            $ipk,
            $nim
        );
            return mysqli_stmt_execute($stmt);
    }

    public function hapus($nim){
        $query = "DELETE FROM mahasiswa WHERE nim = ? ";


        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "s", $nim);

        return mysqli_stmt_execute($stmt);
    }

    public function search($keyword = '', $jurusan = '') {
        $params = [];
        $types = '';
        $where = [];

        if (!empty($keyword)) {
            $where[] = "(nama LIKE ? OR nim LIKE ?)";
            $like = '%' . $keyword . '%';
            $params[] = $like;
            $params[] = $like;
            $types .= 'ss';
        }

        if (!empty($jurusan)) {
            $where[] = "jurusan = ?";
            $params[] = $jurusan;
            $types .= 's';
        }

        $query = "SELECT * FROM mahasiswa";
        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
        $query .= " ORDER BY nim ASC";

        if (empty($params)) {
            return $this->getAll();
        }

        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $daftar = [];
        while ($baris = mysqli_fetch_assoc($result)) {
            $daftar[] = $baris;
        }
        mysqli_stmt_close($stmt);
        return $daftar;
    }

    public function countAll($keyword = '', $jurusan = '') {
        $params = [];
        $types = '';
        $where = [];

        if (!empty($keyword)) {
            $where[] = "(nama LIKE ? OR nim LIKE ?)";
            $like = '%' . $keyword . '%';
            $params[] = $like;
            $params[] = $like;
            $types .= 'ss';
        }

        if (!empty($jurusan)) {
            $where[] = "jurusan = ?";
            $params[] = $jurusan;
            $types .= 's';
        }

        $query = "SELECT COUNT(*) as total FROM mahasiswa";
        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }

        if (empty($params)) {
            $result = mysqli_query($this->db, $query);
            $row = mysqli_fetch_assoc($result);
            return (int)$row['total'];
        }

        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return (int)$row['total'];
    }

    public function getPage($page = 1, $perPage = 10, $keyword = '', $jurusan = '') {
        $offset = ($page - 1) * $perPage;
        $params = [];
        $types = '';
        $where = [];

        if (!empty($keyword)) {
            $where[] = "(nama LIKE ? OR nim LIKE ?)";
            $like = '%' . $keyword . '%';
            $params[] = $like;
            $params[] = $like;
            $types .= 'ss';
        }

        if (!empty($jurusan)) {
            $where[] = "jurusan = ?";
            $params[] = $jurusan;
            $types .= 's';
        }

        $query = "SELECT * FROM mahasiswa";
        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
        $query .= " ORDER BY nim ASC LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;
        $types .= 'ii';

        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $daftar = [];
        while ($baris = mysqli_fetch_assoc($result)) {
            $daftar[] = $baris;
        }
        mysqli_stmt_close($stmt);
        return $daftar;
    }
}