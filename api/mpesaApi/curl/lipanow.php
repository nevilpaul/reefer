<?php
use Carbon\Carbon;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");
require 'config.php';
require '../vendor/autoload.php';
$curl = new Config();
$token = $curl->DecodedToken();
$phone =$_REQUEST['phone'];
$amount =$_REQUEST['amount'];
$countryCode = 2547;
$charge = 1;

if(!empty($phone) AND !empty($amount) AND $amount == 1){
  $checkCode = substr("$phone", 0,4);
  if($countryCode == $checkCode and $charge == $amount){
    $timeNow = Carbon::now(new DateTimeZone('Africa/Nairobi'))->toDateTimeString();
    $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer '.$token,
        'Content-Type: application/json'
    ]);

    curl_setopt($ch, CURLOPT_POST, 1);
    // date_default_timezone_set('Afica/Nairobi');

    $newdate = date("YmdHis");
    $BusinessShortCode =174379;
    $password ='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
    $passcode = base64_encode($BusinessShortCode.$password.$newdate);
    $curl_data = [
      "BusinessShortCode"=>$BusinessShortCode,
      "Password"=> $passcode,
      "Timestamp"=>$newdate,
      "TransactionType"=>"CustomerPayBillOnline",
      "Amount"=>$charge,
      "PartyA"=>$phone,
      "PartyB"=>$BusinessShortCode,
      "PhoneNumber"=>$phone,
      "CallBackURL"=>"https://helapoint.xyz/api/mpesaApi/curl/liparesponse.php",
      "AccountReference"=>"ReeferInc",
      "TransactionDesc"=>"Payment of X"
    ];
    $curlData=json_encode($curl_data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
  }else{
    echo 'Please check number you are using or amount is 500';
  }
}else{

}

?>
