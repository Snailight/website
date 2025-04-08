<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snailight</title>
    <link rel="stylesheet" href="/assets/vendor/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/vendor/bootstrap-icons/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
</head>
<body>
    <h1>Hai, <?php echo($nickname) ?>!</h1>
<?php
$userId = intval($_COOKIE['userId']);
$ketersediaan = [ wallet_tersedia($userId), inventory_tersedia($userId) ];
?>
    <div class="card m-4">
      <div class="card-header">
        Wallet
      </div>
      <div class="card-body">
        <h5 class="card-title">Liquiditas</h5>
        <p class="card-text">
          Wallet adalah tempat menyimpan money. 
<?php
if(!$ketersediaan[0]) {
echo('Buat Wallet untuk mendapatkan hingga 200 money di awal perjalananmu');
}
?>
        </p>
<?php
if(!$ketersediaan[0]) {
echo('<a href="#" id="buat-wallet" class="btn btn-primary">Buat Wallet</a>');
} else {
?>
        <div class="card-footer text-body-secondary">
<?php echo(strval(pengguna_money($userId))); ?>
        </div>
<?php } ?>
      </div>
    </div>
    <div class="card m-4">
      <div class="card-header">
        Inventory
      </div>
      <div class="card-body">
        <h5 class="card-title">Wealth</h5>
        <p class="card-text">
          Inventory adalah tempat barang yang berguna untuk keseharianmu. 
<?php
if(!$ketersediaan[1]) {
echo('Buat Inventory untuk memulai perjalananmu');
}
?>
        </p>
<?php
if(!$ketersediaan[1]) {
echo('<a href="#" id="buat-inventory" class="btn btn-primary">Buat Inventory</a>');
} else {
?>
          <div class="card-footer text-body-secondary">
          </div>
<?php } ?>
      </div>
    </div>
</body>
</html>