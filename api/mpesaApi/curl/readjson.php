<?php
include('./db/db.php');
$file = '{"Body":{"stkCallback":{"MerchantRequestID":"102808-7925121-1","CheckoutRequestID":"ws_CO_260620212356310021","ResultCode":0,"ResultDesc":"The service request is processed successfully.","CallbackMetadata":{"Item":[{"Name":"Amount","Value":1},{"Name":"MpesaReceiptNumber","Value":"PFQ4M66492"},{"Name":"Balance"},{"Name":"TransactionDate","Value":20210626235653},{"Name":"PhoneNumber","Value":254701753461}]}}}}';
$file = json_decode($file);

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
    $addTransactions = new addTransactions();
    $InsertData = $addTransactions->InsertData($merchantRequestID,$checkoutRequestID,$ResultCode,$ResultDesc,$amount,$mpesaReceiptNumber,0,$transactionDate,$phoneNumber);
    $result = json_encode($result);
    // echo $result;
  }

}else{
  echo 'false';
}
// print ( $file);
?>
