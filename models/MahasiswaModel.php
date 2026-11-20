<?php
require_once __DIR__ . '/../config/database.php';

class MahasiswaModel {
    private $db;

    public function __construct() {
        $this->db = getKoneksi();
    }

    public function getAll() {
        $query = "SELECT * FROM mahasiswa ORDER BY nim ASC";
        $result = mysqli_query($this->db, $query);

        $daftar = [];
        if ($result) {
            while ($baris = mysqli_fetch_assoc($result)) {
                $daftar[] = $baris;
            }
        }
        return $daftar;
    }

    public function getStats() {
        $stats = [
            'total' => 0,
            'avg_ipk' => 0.00,
            'aktif' => 0,
            'cumlaude' => 0,
            'prodi' => []
        ];

        // Total, Rata-rata IPK, Mahasiswa Aktif, Cumlaude
        $query = "SELECT 
                    COUNT(*) as total, 
                    COALESCE(AVG(ipk), 0) as avg_ipk,
                    SUM(CASE WHEN status = 'Aktif' THEN 1 ELSE 0 END) as aktif,
                    SUM(CASE WHEN ipk >= 3.50 THEN 1 ELSE 0 END) as cumlaude
                  FROM mahasiswa";
        $result = mysqli_query($this->db, $query);
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $stats['total'] = (int)$row['total'];
            $stats['avg_ipk'] = number_format((float)$row['avg_ipk'], 2);
            $stats['aktif'] = (int)$row['aktif'];
            $stats['cumlaude'] = (int)$row['cumlaude'];
        }

        // Sebaran per Jurusan / Prodi
        $qProdi = "SELECT jurusan, COUNT(*) as jumlah FROM mahasiswa GROUP BY jurusan";
        $resProdi = mysqli_query($this->db, $qProdi);
        if ($resProdi) {
            while ($rowP = mysqli_fetch_assoc($resProdi)) {
                $stats['prodi'][$rowP['jurusan']] = (int)$rowP['jumlah'];
            }
        }

        return $stats;
    }

    public function getAngkatanList() {
        $query = "SELECT DISTINCT angkatan FROM mahasiswa WHERE angkatan IS NOT NULL AND angkatan > 0 ORDER BY angkatan DESC";
        $res = mysqli_query($this->db, $query);
        $list = [];
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $list[] = (int)$row['angkatan'];
            }
        }
        return $list;
    }

    private function buildWhereClause($keyword = '', $jurusan = '', $status = '', $angkatan = '') {
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
            $where[] = "(jurusan = ? OR jurusan LIKE ?)";
            $params[] = $jurusan;
            $params[] = '%' . $jurusan . '%';
            $types .= 'ss';
        }

        if (!empty($status)) {
            $where[] = "status = ?";
            $params[] = $status;
            $types .= 's';
        }

        if (!empty($angkatan)) {
            $where[] = "angkatan = ?";
            $params[] = (int)$angkatan;
            $types .= 'i';
        }

        return [
            'clause' => !empty($where) ? " WHERE " . implode(" AND ", $where) : "",
            'params' => $params,
            'types'  => $types
        ];
    }

    public function countAll($keyword = '', $jurusan = '', $status = '', $angkatan = '') {
        $filter = $this->buildWhereClause($keyword, $jurusan, $status, $angkatan);
        $query = "SELECT COUNT(*) as total FROM mahasiswa" . $filter['clause'];

        if (empty($filter['params'])) {
            $result = mysqli_query($this->db, $query);
            $row = mysqli_fetch_assoc($result);
            return (int)($row['total'] ?? 0);
        }

        $stmt = mysqli_prepare($this->db, $query);
        if (!$stmt) {
            return 0;
        }

        mysqli_stmt_bind_param($stmt, $filter['types'], ...$filter['params']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        return (int)($row['total'] ?? 0);
    }

    public function getPage($page = 1, $perPage = 10, $keyword = '', $jurusan = '', $status = '', $angkatan = '') {
        $offset = ($page - 1) * $perPage;
        $filter = $this->buildWhereClause($keyword, $jurusan, $status, $angkatan);

        $query = "SELECT * FROM mahasiswa" . $filter['clause'] . " ORDER BY nim ASC LIMIT ? OFFSET ?";
        $params = $filter['params'];
        $types = $filter['types'] . 'ii';
        $params[] = $perPage;
        $params[] = $offset;

        $stmt = mysqli_prepare($this->db, $query);
        if (!$stmt) {
            return [];
        }

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

    public function getByNim($nim) {
        $query = "SELECT * FROM mahasiswa WHERE nim = ? LIMIT 1";
        $stmt = mysqli_prepare($this->db, $query);

        if (!$stmt) {
            return null;
        }

        mysqli_stmt_bind_param($stmt, "s", $nim);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);
        return $data;
    }

    public function tambah($data, $fotoNama = null) {
        $nim            = trim($data['nim']);
        $nama           = trim($data['nama']);
        $jenis_kelamin  = in_array($data['jenis_kelamin'] ?? 'L', ['L', 'P']) ? $data['jenis_kelamin'] : 'L';
        $tempat_lahir   = trim($data['tempat_lahir']);
        $tanggal_lahir  = $data['tanggal_lahir'];
        $fakultas       = trim($data['fakultas']);
        $jurusan        = trim($data['jurusan']);
        $angkatan       = (int)($data['angkatan'] ?? date('Y'));
        $status         = in_array($data['status'] ?? 'Aktif', ['Aktif', 'Cuti', 'Lulus', 'DO']) ? $data['status'] : 'Aktif';
        $email          = trim($data['email'] ?? '');
        $no_hp          = trim($data['no_hp'] ?? '');
        $ipk            = (float)$data['ipk'];

        $query = "INSERT INTO mahasiswa 
                  (nim, nama, jenis_kelamin, tempat_lahir, tanggal_lahir, fakultas, jurusan, angkatan, status, email, no_hp, foto, ipk) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->db, $query);
        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param(
            $stmt, "sssssssissssd",
            $nim,
            $nama,
            $jenis_kelamin,
            $tempat_lahir,
            $tanggal_lahir,
            $fakultas,
            $jurusan,
            $angkatan,
            $status,
            $email,
            $no_hp,
            $fotoNama,
            $ipk
        );

        $hasil = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $hasil;
    }

    public function ubah($nim, $data, $fotoNama = null) {
        $nama           = trim($data['nama']);
        $jenis_kelamin  = in_array($data['jenis_kelamin'] ?? 'L', ['L', 'P']) ? $data['jenis_kelamin'] : 'L';
        $tempat_lahir   = trim($data['tempat_lahir']);
        $tanggal_lahir  = $data['tanggal_lahir'];
        $fakultas       = trim($data['fakultas']);
        $jurusan        = trim($data['jurusan']);
        $angkatan       = (int)($data['angkatan'] ?? date('Y'));
        $status         = in_array($data['status'] ?? 'Aktif', ['Aktif', 'Cuti', 'Lulus', 'DO']) ? $data['status'] : 'Aktif';
        $email          = trim($data['email'] ?? '');
        $no_hp          = trim($data['no_hp'] ?? '');
        $ipk            = (float)$data['ipk'];

        if ($fotoNama !== null) {
            $query = "UPDATE mahasiswa SET 
                        nama = ?, 
                        jenis_kelamin = ?, 
                        tempat_lahir = ?, 
                        tanggal_lahir = ?, 
                        fakultas = ?, 
                        jurusan = ?, 
                        angkatan = ?, 
                        status = ?, 
                        email = ?, 
                        no_hp = ?, 
                        foto = ?, 
                        ipk = ? 
                      WHERE nim = ?";

            $stmt = mysqli_prepare($this->db, $query);
            if (!$stmt) {
                return false;
            }

            mysqli_stmt_bind_param(
                $stmt, "ssssssissssds",
                $nama,
                $jenis_kelamin,
                $tempat_lahir,
                $tanggal_lahir,
                $fakultas,
                $jurusan,
                $angkatan,
                $status,
                $email,
                $no_hp,
                $fotoNama,
                $ipk,
                $nim
            );
        } else {
            $query = "UPDATE mahasiswa SET 
                        nama = ?, 
                        jenis_kelamin = ?, 
                        tempat_lahir = ?, 
                        tanggal_lahir = ?, 
                        fakultas = ?, 
                        jurusan = ?, 
                        angkatan = ?, 
                        status = ?, 
                        email = ?, 
                        no_hp = ?, 
                        ipk = ? 
                      WHERE nim = ?";

            $stmt = mysqli_prepare($this->db, $query);
            if (!$stmt) {
                return false;
            }

            mysqli_stmt_bind_param(
                $stmt, "ssssssisssds",
                $nama,
                $jenis_kelamin,
                $tempat_lahir,
                $tanggal_lahir,
                $fakultas,
                $jurusan,
                $angkatan,
                $status,
                $email,
                $no_hp,
                $ipk,
                $nim
            );
        }

        $hasil = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $hasil;
    }

    public function hapus($nim) {
        // Ambil data untuk hapus foto jika ada
        $mhs = $this->getByNim($nim);
        if ($mhs && !empty($mhs['foto'])) {
            $fotoPath = __DIR__ . '/../uploads/' . $mhs['foto'];
            if (file_exists($fotoPath) && is_file($fotoPath)) {
                @unlink($fotoPath);
            }
        }

        $query = "DELETE FROM mahasiswa WHERE nim = ?";
        $stmt = mysqli_prepare($this->db, $query);
        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param($stmt, "s", $nim);
        $hasil = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $hasil;
    }
}
