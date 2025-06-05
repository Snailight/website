<?php
$nyawa = null;
$money = null;
$nickname = null;

if (isset($_COOKIE['userId'])) {
  require($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

  $dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
  $dotenv->load();

  $user_id = intval($_COOKIE['userId']);
  $hasil = null;
  if(exec("./nampan kekayaan $user_id nyawa", $hasil)) {
    $nyawa = intval($hasil[0]);
  }
  $hasil = null;
  if(exec("./nampan liquiditas $user_id money", $hasil)) {
    $money = intval($hasil[0]);
  }
  $hasil = null;
  if(exec("./nampan pengguna $user_id nickname", $hasil)) {
    $nickname = $hasil[0];
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

function pengguna_money() {
  global $money;
  return ($money<0)?('&#8734'):(strval($money));
}

function pengguna_kekayaan($user_id) {
  global $nyawa;
  if ($nyawa === null) return null;
  $deret = [
    'kesehatan' => [
      'nyawa' => $nyawa, 
      'exp' => null, 
    ], 
    'barang' => [
      'potion' => null, 
      'aqua' => null, 
      'gold' => null, 
      'diamond' => null, 
      'batu' => null, 
      'kayu' => null, 
      'string' => null, 
      'iron' => null, 
      'sampah' => null
    ], 
    'peralatan' => [
      'pedang' => null, 
      'armor' => null, 
      'sepatu' => null
    ]
  ];

  foreach ($deret['barang'] as $kunci => $nilai) {
    $hasil = null;
    if(exec("./nampan kekayaan $user_id $kunci", $hasil) !== false) {
      $deret['barang'][$kunci] = intval($hasil[0]);
    }
  }
  return $deret;
}

function pasar_dagang() {
  // $curl = curl_init($_SERVER['CORE_ADDRESS'] . '/market');
  // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  // curl_setopt($curl, CURLOPT_HEADER, false);
  // $ketr = curl_exec($curl);
  // if (!$ketr) {
  //   error_log(curl_error($curl));
  //   $ketr = '{}';
  // }
  // curl_close($curl);
  // return(json_decode($ketr));
  return [];
}

include('dalam_dashboard.php');
?>