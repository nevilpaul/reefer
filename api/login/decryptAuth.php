<?php
use ApplxeJwt\Jwtoken as jt;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");
include('AuthO/define.php');
include('AuthO/token.php');

$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.IjJlODg1ZTgyMTQ1MDg2YWQzZjdiMzM1Y2ZlYmI5ZjQyIg.rmemz3vzGnfMXQ0H64xboAEKQs1ao5molfzdv-j9IJemxTImnJYtJs6csz3nxUX71ctbHzfbXbePo9DSGl33j1NrIRGDT5WECO3pkrglYQRyF0UAJjoEQFDqsCpT3ypGhtBPUW6w7yPb34vjXHl-oXwdFLMu6tQvLkQWKH0XhgyYeGzQsgBCoG_3zlFuAUtI3rjrZx0Tx7IZFTOdL47gIAAYC1qsfcediBx7aQ3bn0f9qyG-s-Sn7bih7Hr3QB-KWvvTrTpLsxHHYKdUZk8fjyID5B1biFhBj157tY62Km_cuPE-wBXku7qb6EBEQfGIWffocRUCxyhiH4KLH2E9qg';
$token = strip_tags($token);

if(!empty($token)){
  echo json_encode(jt::getDec($token,publicKey));
}else{

}
?>
