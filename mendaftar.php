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

// $keterangan = [
//     'urutan' => 0, 
//     'username' => $nama, 
//     'password' => $password, 
//     'telp' => $telp, 
//     'limit' => 10, 
//     'jabatan' => 'warga', 
//     'kekuatan' => [
//         'tangga' => 'pemula', 
//         'level' => 1, 
//         'kodam' => null
//     ], 
//     'lifetime' => [
//         'bergabung' => time(), 
//         'senior' => false
//     ], 
//     'peringatan' => 0, 
//     'terlarang' => false
// ];

$chc = pack("Ia32a32", 25, $nama, $password);
$req = pack("ILLa256a256a32IIILlCIC", 
  9, 1, 1, $nama, $password, 
  $telp, 10, 3, 1, 1, 
  time(), 0, 0, 0);
$jwb = null;

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_connect($sock, $_SERVER['CORE_ADDRESS'], $_SERVER['CORE_PORT']);
socket_send($sock, $chc, 68, 0);
if(socket_recv($sock, $jwb, 36, 0) > 16) {
  socket_close($sock);
  http_response_code(503);
  die(json_encode(array( "status" => "failed" )));
}
socket_close($sock);
$resp = unpack("Ijenis", $jwb);
if($resp['jenis'] == 4) {
  $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
  socket_connect($sock, $_SERVER['CORE_ADDRESS'], $_SERVER['CORE_PORT']);
  socket_send($sock, $req, 608, 0);
  socket_recv($sock, $jwb, 16, 0);
  socket_close($sock);
} else if($resp['jenis'] == 11) {
  die(json_encode(array( "status" => "exist" )));
} else {
  http_response_code(503);
  die(json_encode(array( "status" => "failed" )));
}
$hasil = unpack("Qjenis/Qstatus", $jwb);
$fp = fopen("haduh.txt", "w");
fprintf($fp, "%s\n", $jwb);
fclose($fp);
if($hasil['status'] == 0) {
  die(json_encode(array( "status" => "failed" )));
}

echo(json_encode(array( "status" => "success" )))
?>