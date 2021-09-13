<?php
use ApplxeJwt\Jwtoken as jt;
include('define.php');
include('token.php');
$token = array(
  'name' => 'nevilpaul',
  'phone' => '0701682858',
  'Email' => 'nevilpaul2@gmail.com'
);
$newToken = jt::getEnc($token,privateKey);
echo $newToken.'<br><br>';
echo json_encode(jt::getDec($newToken,publicKey));
?>
