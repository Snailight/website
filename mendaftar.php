<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('<h1>Probhibited</h1>');
}

require('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$lembaran = json_decode(file_get_contents("php://input"), true);
$nama = $lembaran["nickname"];
$telp = $lembaran["telp"];
$password = $lembaran["password"];
$jenis = $lembaran["jenis"];
$tempat = $lembaran["tempat"];
$tanggal = $lembaran["tanggal"];
$agama = $lembaran["agama"];
$kewarganegaraan = $lembaran["kewarganegaraan"];

$keterangan = [
    'urutan' => 0, 
    'username' => $nama, 
    'password' => $password, 
    'telp' => $telp, 
    'limit' => 10, 
    'jabatan' => 'warga', 
    'kekuatan' => [
        'tangga' => 'pemula', 
        'level' => 1, 
        'kodam' => null
    ], 
    'lifetime' => [
        'bergabung' => time(), 
        'senior' => false
    ], 
    'peringatan' => 0, 
    'terlarang' => false
];

$status = "success";

use MongoDB\Driver\ServerApi;

$pass = $_SERVER['MONGODB_PASS'];
$uri = "mongodb+srv://Reckordp:$pass@keteranganumumga.pjt8q.mongodb.net/?appName=KeteranganUmumGA";

// Set the version of the Stable API on the client
$apiVersion = new ServerApi(ServerApi::V1);

// Create a new client and connect to the server
$client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);

try {
    $pangkalan = $client->selectDatabase('Snailight');
    $batas = $pangkalan->selectCollection('batas');
    $query = [ 'label' => 'pengguna' ];
    $penunjuk = $batas->findOne($query);
    $kini = $penunjuk->kini;

    $koleksi = $pangkalan->selectCollection('pengguna');
    $sama = $koleksi->aggregate([ [ '$match' => [ 'username' => $nama ] ] ]);
    if (count(iterator_to_array($sama)) < 1) {
        $penunjuk->kini++;
        $batas->findOneAndUpdate($query, [ '$set' => $penunjuk ]);
        $keterangan['urutan'] = $kini;
        $koleksi->insertOne($keterangan);
    } else {
        $status = 'exist';
    }
} catch (Exception $e) {
    printf($e->getMessage() . "\n");
    $status = 'failed';
}

$ketr = array( "status" => $status );
echo(json_encode($ketr));
?>