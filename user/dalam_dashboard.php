<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snailight</title>
    <link rel="stylesheet" href="/assets/vendor/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/vendor/bootstrap-icons/bootstrap-icons.min.css">
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
$lapangan = pengguna_kekayaan($userId);
$fisik = $lapangan->kesehatan;
$harta = $lapangan->barang;
$alatt = $lapangan->peralatan;
?>
          <div class="card-footer text-body-secondary">
            <div class="card mt-1 mb-1">
              <div class="card-header">
                Kesehatan
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">&#128151; <?php echo(strval($fisik->nyawa)); ?></li>
                <li class="list-group-item">&#10024; <?php echo(strval($fisik->exp)); ?></li>
              </ul>
            </div>
            <div class="card mt-1 mb-1">
              <div class="card-header">
                Harta
              </div>
              <ul class="list-group list-group-flush">
<?php
$keymap = [
  'potion' => '&#129380;', 
  'aqua' => '&#127862;', 
  'gold' => '&#129689;', 
  'diamond' => '&#128142;', 
  'batu' => '&#129704;', 
  'kayu' => '&#129717;', 
  'string' => '&#128376;', 
  'iron' => '&#9939;', 
  'sampah' => '&#128465;'
];
foreach($harta as $k => $v) {
  if(array_key_exists($k, $keymap)) {
echo('<li class="list-group-item">'. $keymap[$k] .' '. $k .' '. (($v<0)?('&#8734'):(strval($v))) .'</li>');
  }
}
?>
              </ul>
            </div>
            <div class="card mt-1 mb-1">
              <div class="card-header">
                Peralatan
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">&#128481; <?php echo($alatt->pedang); ?></li>
                <li class="list-group-item">&#129404; <?php echo($alatt->armor); ?></li>
                <li class="list-group-item">&#129406; <?php echo($alatt->sepatu); ?></li>
              </ul>
            </div>
<?php } ?>
      </div>
    </div>
  </div>
  <div class="card m-4">
    <div class="card-header">
      Akun
    </div>
    <div class="card-body">
      <h5 class="card-title">Logout</h5>
      <a href="#" id="akun-logout" class="btn btn-danger">Setuju</a>
    </div>
  </div>
  <script src="/assets/js/dashboard.js"></script>
</body>
</html>