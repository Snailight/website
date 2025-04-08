<?php
$nickname = null;
$pangkalan = null;

if (isset($_COOKIE['userId'])) {
  require($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

  $dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
  $dotenv->load();

  $pass = $_SERVER['MONGODB_PASS'];
  $uri = "mongodb+srv://Reckordp:$pass@keteranganumumga.pjt8q.mongodb.net/?appName=KeteranganUmumGA";

  // Set the version of the Stable API on the client
  $apiVersion = new MongoDB\Driver\ServerApi(MongoDB\Driver\ServerApi::V1);

  // Create a new client and connect to the server
  $client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);

  try {
    $pangkalan = $client->selectDatabase('Snailight');
    $koleksi = $pangkalan->selectCollection('pengguna');
    $deret = $koleksi->find([ 'urutan' => intval($_COOKIE['userId']) ], [ 
        'projection' => [ 'username' => 1 ]
    ]);
    $petak = new IteratorIterator($deret);
    $petak->rewind();
    $kini = $petak->current();
    if($kini !== null) {
        $nickname = $kini['username'];
    }
  } catch (Exception $e) {
    die($e->getMessage() . "\n");
  }
} else {
  unset($nickname);
  include('_login.php');
  die();
}

if (!isset($nickname)) {
    die('Page Not Available');
} else if ($nickname === null) {
    die('User Not Available');
}

function dalam_koleksi($nama, $id) {
  global $pangkalan;
  if ($pangkalan === null) return null;
  try {
    $koleksi = $pangkalan->selectCollection($nama);
    $sama = $koleksi->aggregate([ [ '$match' => [ 'pengguna_id' => $id ] ] ]);
    return (count(iterator_to_array($sama)) > 0);
  } catch (Exception $e) {
    return false;
  }
}

function wallet_tersedia($userId) {
  return dalam_koleksi('liquiditas', $userId);
}

function inventory_tersedia($userId) {
  return dalam_koleksi('kekayaan', $userId);
}

function pengguna_money($userId) {
  global $pangkalan;
  if ($pangkalan === null) return 0;
  try {
    $koleksi = $pangkalan->selectCollection('liquiditas');
    $doc = $koleksi->findOne([ 'pengguna_id' => $userId ]);
    $money = $doc->money;
    return ($money<0)?('&#8734'):($money);
  } catch (Exception $e) {
    printf("%s\n", $e->getMessage());
  }
  return 0;
}

include('dalam_dashboard.php');
?>