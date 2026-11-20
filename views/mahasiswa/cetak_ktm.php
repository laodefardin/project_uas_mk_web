<?php
require_once __DIR__ . '/../../config/helper.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KTM - <?= e($mhs['nama']); ?> (<?= e($mhs['nim']); ?>)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Libre+Barcode+39&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #eaedf2; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; }
        
        /* Ukuran Standar Kartu ID Card (CR80 ratio: 85.6mm x 54mm) */
        .ktm-card {
            width: 480px;
            height: 290px;
            background: linear-gradient(135deg, #0d47a1 0%, #1565c0 60%, #1976d2 100%);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            color: #fff;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .ktm-card::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            pointer-events: none;
        }

        .ktm-header {
            border-bottom: 2px solid rgba(255, 255, 255, 0.25);
            padding-bottom: 8px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .ktm-header h6 {
            margin: 0;
            font-size: 11pt;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .ktm-header small {
            font-size: 7.5pt;
            color: rgba(255, 255, 255, 0.85);
            letter-spacing: 0.3px;
        }

        .ktm-photo {
            width: 95px;
            height: 125px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #fff;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.25);
        }

        .ktm-photo-placeholder {
            width: 95px;
            height: 125px;
            border-radius: 8px;
            background: #f8f9fa;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            border: 2px solid #fff;
        }

        .ktm-info-table {
            font-size: 8.5pt;
            width: 100%;
        }

        .ktm-info-table td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .barcode-simulated {
            font-family: 'Courier New', monospace;
            letter-spacing: 4px;
            font-size: 10pt;
            background: rgba(255,255,255,0.15);
            padding: 3px 8px;
            border-radius: 4px;
            display: inline-block;
        }

        @media print {
            .no-print { display: none !important; }
            body { background: #fff; padding: 0; }
            .ktm-card { box-shadow: none; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    <!-- Tombol Aksi Layar -->
    <div class="no-print mb-4 d-flex gap-2">
        <a href="<?= url('index'); ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer-fill me-1"></i>Cetak KTM (Print)
        </button>
    </div>

    <!-- KARTU TANDA MAHASISWA -->
    <div class="ktm-card">
        <div class="ktm-header">
            <div>
                <h6>Universitas Sulawesi Barat</h6>
                <small>KARTU TANDA MAHASISWA &middot; SIAKAD KAMPUSKU</small>
            </div>
            <i class="bi bi-mortarboard-fill fs-3 text-warning"></i>
        </div>

        <div class="d-flex gap-3 align-items-center">
            <div>
                <?php if (!empty($mhs['foto']) && file_exists(__DIR__ . '/../../uploads/' . $mhs['foto'])): ?>
                    <img src="/pertemuan12/uploads/<?= e($mhs['foto']); ?>" alt="Foto Mahasiswa" class="ktm-photo">
                <?php else: ?>
                    <div class="ktm-photo-placeholder">
                        <i class="bi bi-person-fill"></i>
                    </div>
                <?php endif; ?>
            </div>

            <div class="flex-grow-1">
                <table class="ktm-info-table">
                    <tr>
                        <td style="width: 75px; color: rgba(255,255,255,0.75);">NIM</td>
                        <td>: <strong><?= e($mhs['nim']); ?></strong></td>
                    </tr>
                    <tr>
                        <td style="color: rgba(255,255,255,0.75);">Nama</td>
                        <td>: <strong><?= e($mhs['nama']); ?></strong></td>
                    </tr>
                    <tr>
                        <td style="color: rgba(255,255,255,0.75);">Prodi</td>
                        <td>: <?= e(strtoupper($mhs['jurusan'])); ?></td>
                    </tr>
                    <tr>
                        <td style="color: rgba(255,255,255,0.75);">Fakultas</td>
                        <td>: <?= e($mhs['fakultas']); ?></td>
                    </tr>
                    <tr>
                        <td style="color: rgba(255,255,255,0.75);">Angkatan</td>
                        <td>: <?= e($mhs['angkatan'] ?? 2024); ?> &middot; Status: <?= e($mhs['status'] ?? 'Aktif'); ?></td>
                    </tr>
                    <tr>
                        <td style="color: rgba(255,255,255,0.75);">TTL</td>
                        <td>: <?= e($mhs['tempat_lahir']); ?>, <?= date('d/m/Y', strtotime($mhs['tanggal_lahir'])); ?></td>
                    </tr>
                </table>

                <div class="mt-2 text-end">
                    <span class="barcode-simulated">*<?= e($mhs['nim']); ?>*</span>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
