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
$resp = null;
$resp_user_id = null;

if(exec("./nampan login $user_id $user_ps", $resp)) {
  $resp_user_id = $resp[0];
  // settype($resp_user_id, 'int');
} else {
  $status = 'notfound';
}

$ketr = array( "status" => $status, "userId" => $resp_user_id );
echo(json_encode($ketr));
?>