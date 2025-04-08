<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snailight</title>
    <link rel="stylesheet" href="/assets/vendor/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/vendor/bootstrap-icons/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/_login.css">
</head>
<body>
    <div class="pengguna">
        <div class="text-center">
            <h3>Lorong Pengguna</h3>
        </div>
        <form action="/user/memasuki.php">
            <div class="d-none alert alert-danger" id="umum"></div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Nickname/Telp" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-submit mt-4">Kumpulkan</button>
            </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/md5.min.js"></script>
    <script src="/assets/js/_memasuki.js"></script>
</body>
</html>