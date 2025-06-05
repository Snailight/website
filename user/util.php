<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  die('<h1>Probhibited</h1>');
}

require($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$pass = $_SERVER['MONGODB_PASS'];
$uri = "mongodb+srv://Reckordp:$pass@keteranganumumga.pjt8q.mongodb.net/?appName=KeteranganUmumGA";

// Set the version of the Stable API on the client
$apiVersion = new MongoDB\Driver\ServerApi(MongoDB\Driver\ServerApi::V1);

// Create a new client and connect to the server
$client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);

function user_koleksi($nama) {
  global $client;
  $pangkalan = $client->selectDatabase('Snailight');
  $koleksi = $pangkalan->selectCollection($nama);
  return $koleksi;
}

// function user_belum($koleksi, $id) {
//   $sama = $koleksi->aggregate([
//     [ '$match' => [ 'pengguna_id' => $id ] ] 
//   ]);
//   return(count(iterator_to_array($sama)) < 1);
// }

function registerfun_a() {
  $koleksi = user_koleksi('liquiditas');
  // if (user_belum($koleksi, intval($_COOKIE['userId']))) {} else {}
  $koleksi->insertOne([
    'pengguna_id' => intval($_COOKIE['userId']), 
    'money' => 200
  ]);
}

function registerfun_b() {
  $koleksi = user_koleksi('kekayaan');
  // if (user_belum($koleksi, intval($_COOKIE['userId']))) {} else {}
  $koleksi->insertOne([
    'pengguna_id' => intval($_COOKIE['userId']), 
    'kesehatan' => [
      'nyawa' => 100, 
      'exp' => 0
    ], 
    'barang' => [
      'potion' => 10
    ], 
    'peralatan' => [
      'pedang' => 'Nothing', 
      'armor' => 'Nothing', 
      'sepatu' => 'Nothing'
    ]
  ]);
}

$jalur = null;
$memulaimap = [
  'wallet' => (function() { registerfun_a(); }),
  'harta' => (function() { registerfun_b(); })
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