<?php
header('Content-Type:application/json');

$callbackJSONData =file_get_contents('php://input');
$file =json_decode($callbackJSONData);
if(property_exists($file,'Body')){
  $merchantRequestID = $file->Body->stkCallback->MerchantRequestID;
  $checkoutRequestID = $file->Body->stkCallback->CheckoutRequestID;
  $ResultCode = $file->Body->stkCallback->ResultCode;
  $ResultDesc = $file->Body->stkCallback->ResultDesc;
  // amount
  $amount = $file->Body->stkCallback->CallbackMetadata->Item[0]->Value;
  $mpesaReceiptNumber = $file->Body->stkCallback->CallbackMetadata->Item[1]->Value;

  // $balance = $file->Body->stkCallback->CallbackMetadata->Item[2]->Value;
  $transactionDate = $file->Body->stkCallback->CallbackMetadata->Item[3]->Value;
  $phoneNumber = $file->Body->stkCallback->CallbackMetadata->Item[4]->Value;
  
  if($ResultCode === 0 ){
    $result=[
        "merchantRequestID"=>$merchantRequestID,
        "checkoutRequestID"=>$checkoutRequestID,
        "resultCode"=>$ResultCode,
        "resultDesc"=>$ResultDesc,
        "amount"=>$amount,
        "mpesaReceiptNumber"=>$mpesaReceiptNumber,
        // "balance"=>$balance,
        "transactionDate"=>$transactionDate,
        "phoneNumber"=>$phoneNumber
    ];

    $result = json_encode($callbackData);
    $loger = 'LipaMpesaResponse.txt';
    $f = fopen($loger,'a');
    $write = fwrite($f,$result);
    
  }
  fclose($f);
}


// $result = json_encode($result);


?>
