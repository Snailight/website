<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  die('<h1>Probhibited</h1>');
}

require($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

function push_liquiditas() {
  $userId = $_COOKIE['userId'];
  exec("./nampan push $userId liquiditas");
}

function push_kekayaan() {
  $userId = $_COOKIE['userId'];
  exec("./nampan push $userId kekayaan");
}

$jalur = null;
$memulaimap = [
  'wallet' => (function() { push_liquiditas(); }),
  'harta' => (function() { push_kekayaan(); })
];
$lembaran = json_decode(file_get_contents("php://input"), true);
switch ($lembaran['jalan']) {
  case 'memulai':
    $jalur = $memulaimap[$lembaran['sasaran']];
    break;
  
  default:
    # code...
    break;
}

try {
  if($jalur != null) $jalur();
} catch (Exception $e) {
  printf("%s\n", $e->getMessage());
  die(json_encode([ 'status' => 'failed' ]));
}

$ketr = array( "status" => 'success' );
echo(json_encode($ketr));
?>