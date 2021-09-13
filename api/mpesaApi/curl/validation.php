<?php
header('Content-Type:application/json');

$response = "{
  'resCODE':0,
  'resDESC':'Confirmation success'
}";
$result = file_get_contents('php://input');

$loger = 'MpesaValidationResponse.txt';
$f = fopen($loger,'a');
$write = fwrite($f,$result);
fclose($f);
echo $response;
?>
