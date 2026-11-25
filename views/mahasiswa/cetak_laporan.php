<?php
require_once __DIR__ . '/../../config/helper.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Mahasiswa - SIAKAD PTI Unsulbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --card: #ffffff;
            --raised: #f1efeb;
            --hair: rgba(31, 27, 22, 0.09);
            --line: rgba(31, 27, 22, 0.16);
            --ink: #1f1b16;
            --ink-2: #5e554a;
            --accent: #0f6b66;
            --accent-hover: #0b5753;
            --ease: cubic-bezier(0.22, 1, 0.36, 1);
            --bs-primary: #0f6b66;
            --bs-primary-rgb: 15, 107, 102;
        }
        body { font-family: 'Inter', sans-serif; background: #fff; color: #212529; font-size: 11pt; }
        .no-print.bg-light { background-color: #f6f5f2 !important; border-color: var(--hair) !important; border-radius: 12px !important; }
        .btn {
            --bs-btn-border-radius: 10px;
            --bs-btn-font-weight: 500;
            line-height: 20px;
            transition-property: background-color, border-color, color, transform;
            transition-duration: 160ms;
            transition-timing-function: var(--ease);
        }
        .btn:active { transform: scale(0.98); }
        .btn-sm { --bs-btn-padding-y: 5px; --bs-btn-padding-x: 12px; --bs-btn-font-size: 14px; --bs-btn-border-radius: 10px; }
        .btn-primary {
            --bs-btn-bg: var(--accent);
            --bs-btn-border-color: var(--accent);
            --bs-btn-hover-bg: var(--accent-hover);
            --bs-btn-hover-border-color: var(--accent-hover);
            --bs-btn-active-bg: var(--accent-hover);
            --bs-btn-active-border-color: var(--accent-hover);
            --bs-btn-disabled-bg: var(--accent);
            --bs-btn-disabled-border-color: var(--accent);
        }
        .btn-outline-secondary {
            --bs-btn-color: var(--ink);
            --bs-btn-bg: var(--card);
            --bs-btn-border-color: var(--line);
            --bs-btn-hover-color: var(--ink);
            --bs-btn-hover-bg: var(--raised);
            --bs-btn-hover-border-color: var(--line);
            --bs-btn-active-color: var(--ink);
            --bs-btn-active-bg: var(--raised);
            --bs-btn-active-border-color: var(--line);
        }
        .kop-surat { border-bottom: 3px double #000; padding-bottom: 12px; margin-bottom: 24px; text-align: center; }
        .kop-surat h4 { margin: 0; font-weight: 700; font-size: 14pt; text-transform: uppercase; letter-spacing: 0.5px; }
        .kop-surat h5 { margin: 2px 0; font-weight: 600; font-size: 12pt; text-transform: uppercase; }
        .kop-surat p { margin: 0; font-size: 9pt; color: #555; }
        .table-laporan { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table-laporan th, .table-laporan td { border: 1px solid #333; padding: 6px 8px; font-size: 9.5pt; }
        .table-laporan th { background-color: #f2f2f2 !important; text-align: center; font-weight: 600; }
        .tanda-tangan { margin-top: 40px; float: right; width: 280px; text-align: center; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
            @page { size: A4 landscape; margin: 15mm 15mm 15mm 15mm; }
        }
    </style>
</head>
<body class="p-4">

    <!-- Action Bar (Hanya tampil di layar monitor, hilang saat dicetak) -->
    <div class="no-print d-flex justify-content-between align-items-center mb-4 p-3 bg-light border rounded">
        <div>
            <h6 class="mb-0 fw-semibold"><i class="bi bi-printer me-2 text-primary"></i>Mode Cetak Dokumen Laporan</h6>
            <small class="text-muted">Gunakan opsi cetak landscape A4 untuk hasil optimal.</small>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= url('index'); ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Aplikasi
            </a>
            <button onclick="window.print()" class="btn btn-sm btn-primary">
                <i class="bi bi-printer-fill me-1"></i>Cetak Sekarang (Print)
            </button>
        </div>
    </div>

    <!-- KOP SURAT RESMI KAMPUS -->
    <div class="kop-surat">
        <h4>Kementerian Pendidikan Tinggi, Sains, dan Teknologi</h4>
        <h5>Universitas Sulawesi Barat</h5>
        <h5>Fakultas Keguruan dan Ilmu Pendidikan &middot; Program Studi Pendidikan Teknologi Informasi</h5>
        <p>Jl. Prof. Dr. Baharuddin Lopa, S.H., Talumung, Majene, Sulawesi Barat 91412 | Website: unsulbar.ac.id</p>
    </div>

    <div class="text-center mb-4">
        <h5 class="fw-bold mb-1 text-uppercase text-decoration-underline">LAPORAN DATA MAHASISWA TERDAFTAR</h5>
        <p class="small text-muted mb-0">Dicetak pada tanggal: <?= date('d F Y, H:i'); ?> WITA</p>
    </div>

    <!-- Ringkasan Statistik Laporan -->
    <div class="row g-2 mb-3 text-center" style="font-size: 9pt;">
        <div class="col-3">
            <div class="p-2 border rounded bg-light">
                <strong>Total Mahasiswa:</strong> <?= count($daftar_mahasiswa); ?> orang
            </div>
        </div>
        <div class="col-3">
            <div class="p-2 border rounded bg-light">
                <strong>Rata-rata IPK:</strong> <?= $stats['avg_ipk'] ?? '0.00'; ?>
            </div>
        </div>
        <div class="col-3">
            <div class="p-2 border rounded bg-light">
                <strong>Mahasiswa Aktif:</strong> <?= $stats['aktif'] ?? 0; ?> orang
            </div>
        </div>
        <div class="col-3">
            <div class="p-2 border rounded bg-light">
                <strong>Predikat Cumlaude:</strong> <?= $stats['cumlaude'] ?? 0; ?> orang
            </div>
        </div>
    </div>

    <!-- Tabel Data Mahasiswa -->
    <table class="table-laporan">
        <thead>
            <tr>
                <th style="width: 35px;">No</th>
                <th style="width: 85px;">NIM</th>
                <th>Nama Lengkap</th>
                <th style="width: 35px;">L/P</th>
                <th>Tempat, Tanggal Lahir</th>
                <th>Program Studi</th>
                <th style="width: 65px;">Angkatan</th>
                <th style="width: 65px;">Status</th>
                <th style="width: 55px;">IPK</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($daftar_mahasiswa)): ?>
            <tr>
                <td colspan="9" class="text-center py-3">Tidak ada data mahasiswa.</td>
            </tr>
            <?php else: ?>
            <?php $no = 1; foreach ($daftar_mahasiswa as $m): ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center font-monospace"><strong><?= e($m['nim']); ?></strong></td>
                <td><?= e($m['nama']); ?></td>
                <td class="text-center"><?= e($m['jenis_kelamin'] ?? 'L'); ?></td>
                <td><?= e($m['tempat_lahir']); ?>, <?= date('d/m/Y', strtotime($m['tanggal_lahir'])); ?></td>
                <td><?= e(strtoupper($m['jurusan'])); ?></td>
                <td class="text-center"><?= e($m['angkatan'] ?? 2024); ?></td>
                <td class="text-center"><?= e($m['status'] ?? 'Aktif'); ?></td>
                <td class="text-center font-monospace"><strong><?= number_format((float)$m['ipk'], 2); ?></strong></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div class="tanda-tangan">
        <p class="mb-1">Majene, <?= date('d F Y'); ?></p>
        <p class="mb-5">Ketua Program Studi PTI,</p>
        <p class="fw-bold mb-0 text-decoration-underline">( _________________________ )</p>
        <p class="small text-muted">NIP. ........................................</p>
    </div>

</body>
</html>
