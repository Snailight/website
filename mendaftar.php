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
$idagama = 0x10;
if($agama == 'Islam') {
  $idagama = 0;
} else if($agama == 'Kristem' || $agama == 'Protestan') {
  $idagama = 1;
} else if($agama == 'Katolik') {
  $idagama = 2;
} else if($agama == 'Buddha') {
  $idagama = 3;
} else if($agama == 'Hindu') {
  $idagama = 4;
} else if($agama == 'Konghucu') {
  $idagama = 5;
}

$user_id = 1;
$sstatus = pack("IIQ", 1, 0, 0);
$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_connect($sock, $_SERVER['CORE_ADDRESS'], $_SERVER['CORE_PORT']);
socket_send($sock, $sstatus, 68, 0);
if(socket_recv($sock, $jwb, 36, 0) == 16) {
  socket_close($sock);
  $hasil = unpack("Ijenis/Ikosong/abio/aci/akyan/alquid/apguna", $jwb);
  $user_id += ord($hasil['pguna']);
} else {
  socket_close($sock);
  http_response_code(503);
  die(json_encode(array( "status" => "failed" )));
}

$chc = pack("IIa32a32", 25, 0, $nama, $password);
$req = pack("IIQQa256a256a32IIILlCIC", 
  9, 0, 1, $user_id, $nama, $password, 
  $telp, 10, 3, 1, 1, 
  time(), 0, 0, 0);
$req_bio = pack("IIQQa256Qa64QQQaa64", 
  5, 0, 1, $user_id, $nama, $jenis, $tempat, 
  strtotime($tanggal), $idagama, 0, 0, $kewarganegaraan);
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
$hasil = unpack("Ijenis/Ikosong/Qstatus", $jwb);
if($hasil['status'] == 0) {
  die(json_encode(array( "status" => "failed" )));
}

if($hasil['jenis'] == 6) {
  $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
  socket_connect($sock, $_SERVER['CORE_ADDRESS'], $_SERVER['CORE_PORT']);
  socket_send($sock, $req_bio, 440, 0);
  socket_recv($sock, $jwb, 16, 0);
  socket_close($sock);
}

$hasil = unpack("Ijenis/Ikosong/Qstatus", $jwb);
if($hasil['status'] == 0) {
  die(json_encode(array( "status" => "failed" )));
}
echo(json_encode(array( "status" => "success" )))
?>