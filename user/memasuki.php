<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  die('<h1>Probhibited</h1>');
}

require($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$lembaran = json_decode(file_get_contents("php://input"), true);
$formasi = $lembaran['formasi'];
$user_id = $lembaran['id'];
$user_ps = $lembaran['pwd'];

$status = 'success';
$resp_user_id = null;

$pass = $_SERVER['MONGODB_PASS'];
$uri = "mongodb+srv://Reckordp:$pass@keteranganumumga.pjt8q.mongodb.net/?appName=KeteranganUmumGA";

// Set the version of the Stable API on the client
$apiVersion = new MongoDB\Driver\ServerApi(MongoDB\Driver\ServerApi::V1);

// Create a new client and connect to the server
$client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);

try {
  $pangkalan = $client->selectDatabase('Snailight');
  $koleksi = $pangkalan->selectCollection('pengguna');
  $query = null;
  if ($formasi === 'telp') {
    $query = [ 'telp' => $user_id ];
  } else if ($formasi === 'nickname') {
    $query = [ 'username' => $user_id ];
  } else {
    die(json_encode(['status' => 'notfound']));
  }
  $pengguna = $koleksi->findOne($query, [ 'projection' => [ 'urutan' => 1, 'password' => 1 ] ]);
  if ($pengguna === null) {
    $status = 'id';
  } else if ($pengguna['password'] !== $user_ps) {
    $status = 'pwd';
  } else {
    $resp_user_id = $pengguna['urutan'];
  }
} catch (Exception $e) {
  printf($e->getMessage() . "\n");
  $status = 'failed';
}

$ketr = array( "status" => $status, "userId" => $resp_user_id );
echo(json_encode($ketr));
?>