<?php
$pesanError = $_GET['error'] ?? '';
$pesanSukses = "";

if (($_GET['pesan'] ?? '') === 'akun_buat'){
    $pesanSukses = "Akun Berhasil dibuat. Silahkan Masuk";
}

if (($_GET['pesan'] ?? '') === 'keluar'){
    $pesanSukses = "Anda Telah keluar dari aplikasi";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sistem Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container" style="max-width: 420px; margin-top: 80px;">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-1">Masuk Aplikasi</h4>
                <p class="text-muted small mb-4">Sistem Data Mahasiswa - Prodi PTI FKIP Unsulbar</p>

                <form action="<?php echo url('prosesLogin'); ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required autofocus>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Masuk</button>
                </form>
            </div>
        </div>

        <?php if ($pesanSukses !== ""): ?>
        <div class="alert alert-success mt-4">
            <?php echo htmlspecialchars($pesanSukses, ENT_QUOTES, 'UTF-8');?>
        </div>
        <?php endif; ?>

        <?php if ($pesanError !== ""): ?>
        <div class="alert alert-danger mt-4">
            <?php echo htmlspecialchars($pesanError, ENT_QUOTES, 'UTF-8');?>
        </div>
        <?php endif; ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>