<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snailight</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap-icons/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/page.css">
</head>
<body>
    <div class="header">
        <div class="dtt">
            <img src="assets/img/logo.png" alt="Coorporation">
            <span>Snailight</span>
        </div>
        <div class="navigation">
            <span></span><span></span><span></span>
        </div>
        <div class="board">
            <a href="profile.php">Profile</a>
            <a href="tools.php">Tools</a>
            <a href="games.php">Games</a>
            <a href="contact.php">Contact</a>
        </div>
    </div>
<?php
    echo('<h1 class="judul">Snailight</h1>');
?>
    <div class="penjelasan">
        <div class="card">
            <i class="bi bi-quote" id="hiasan"></i>
            <div class="card-body">
                <p class="card-text">
                    Snailight merupakan organisasi yang bergerak di bidang 
                    teknologi, informasi, dan komunikasi. Berbagai projek
                    diterima Snailight untuk kebutuhan inovasi. Kebutuhan 
                    lainnya juga diterima oleh Snailight untuk menjadi aset
                    yang bernilai.
                </p>
            </div>
        </div>
        <img src="assets/img/1b.png" alt="penjelasan usaha ini">
    </div>
    <div class="pengguna mb-4">
        <form action="mendaftar.php">
            <div class="d-none alert alert-success" id="notifikasi">
                Akun berhasil didaftarkan. Ikuti 
                <a href="dashboard.php">rute</a> 
                untuk melanjutkan
            </div>
            <div class="d-none alert alert-danger" id="umum">
                Akun gagal didaftarkan. Pastikan semua kolom diisi
            </div>
            <div class="d-none alert alert-danger" id="terdapat">
                Akun gagal didaftarkan. Nickname sudah terpakai
            </div>
            <h3>Mendaftar sebagai pengguna</h3>
            <div class="form-group">
                <label for="nickname">Nickname</label>
                <input type="text" name="nickname" id="nickname" class="form-control" placeholder="Enter Text" required>
            </div>
            <div class="form-group">
                <label for="telp">Telp</label>
                <div class="input-group">
                    <span class="input-group-text" style="background: #e9ecef;">+62</span>
                    <input type="tel" name="telp" id="telp" class="form-control" placeholder="Enter Telp" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
            </div>
            <div class="form-group">
                <label class="d-block">Gender</label>
                <div class="form-check form-check-inline">
                    <input type="radio" name="jenis" id="pria" class="form-check-input" required>
                    <label for="pria" class="form-check-label">Laki Laki</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="jenis" id="wanita" class="form-check-input" required>
                    <label for="wanita" class="form-check-label">Perempuan</label>
                </div>
            </div>
            <div class="form-group">
                <label class="d-block">Tempat, Tanggal Lahir</label>
                <div class="input-group row">
                    <div class="col-4">
                        <input type="text" name="tempat" id="tempat" class="form-control col-2" placeholder="Enter Tempat Lahir" required>
                    </div>
                    <div class="col-8">
                        <input type="text" name="tanggal" id="tanggal" class="form-control col-6" placeholder="Enter Tanggal Lahir" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="agama">Agama</label>
                <input type="text" name="agama" id="agama" class="form-control" placeholder="Enter Agama" required>
            </div>
            <div class="form-group">
                <label for="kewarganegaraan">Kewarganegaraan</label>
                <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control" placeholder="Enter Kewarganegaraan" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-submit mt-4">Kumpulkan</button>
            </div>
        </form>
    </div>
    <img src="assets/img/1.png" alt="Bulan" style="width: 100%;">
    <script src="assets/vendor/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/md5.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>