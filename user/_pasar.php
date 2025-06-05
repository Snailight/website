<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  die('<h1>Probhibited</h1>');
}

if (!isset($_COOKIE['userId'])) {
  die('<h1>Not Authorized</h1>');
}

require($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$urutan = $_COOKIE['userId'];
$enccookie = md5('code: '. $urutan);
$curl = curl_init($_SERVER['CORE_ADDRESS'] . '/market/'. $urutan .'/beli?tempat=default');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Cookie: userId=". $enccookie ."; path=/"));
curl_setopt($curl, CURLOPT_POSTFIELDS, file_get_contents("php://input"));
$ketr = curl_exec($curl);
if (!$ketr) {
  error_log(curl_error($curl));
  $ketr = '{}';
}
curl_close($curl);
echo($ketr);
?>