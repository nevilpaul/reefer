<?php
use Carbon\Carbon;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");
require '../vendor/autoload.php';
include('conn.php');
class addTransactions extends Conn{
    function __construct(){
    	$this->conn = $this->conn();
    }

    public function InsertData($merchantRequestID,$checkoutRequestID,$resultDesc,$resultCode,$amount,$mpesaReceiptNumber,$balance,$transactionDate,$phoneNumber){
        //SETTING PDO ERROR EXCEPTION
        $timeNow = Carbon::now(new DateTimeZone('Africa/Nairobi'));
        $strTime = strtotime($timeNow);
        $message =[];
        $result=[
		      "merchantRequestID"=>$merchantRequestID,
		      "checkoutRequestID"=>$checkoutRequestID,
		      "resultDesc"=>$resultDesc,
		      "resultCode"=>$resultCode,
		      "amount"=>$amount,
		      "mpesaReceiptNumber"=>$mpesaReceiptNumber,
		      "balance"=>$balance,
		      "transactionDate"=>$transactionDate,
		      "phoneNumber"=>$phoneNumber
		  ];
		  echo json_encode($result);

        if(!empty($merchantRequestID)){

            $addUser = $this->conn->prepare('INSERT INTO stkpayment VALUES (null,:merchantRequestID,:checkoutRequestID,:resultCode,:resultDesc,:amount,:mpesaReceiptNumber,:transactionDate,:phoneNumber, :date_payed_system, :receipt_payed_number)');
            $addUser->bindParam(':merchantRequestID',$merchantRequestID);
            $addUser->bindParam(':checkoutRequestID',$checkoutRequestID);
            $addUser->bindParam(':resultCode',$resultCode);
            $addUser->bindParam(':resultDesc',$resultDesc);
            $addUser->bindParam(':amount',$amount);
            $addUser->bindParam(':mpesaReceiptNumber',$mpesaReceiptNumber);
            $addUser->bindParam(':transactionDate',$transactionDate);
            $addUser->bindParam(':phoneNumber',$phoneNumber);
            $addUser->bindParam(':date_payed_system',$strTime);
            $addUser->bindParam(':receipt_payed_number',$mpesaReceiptNumber);

            if($addUser->execute()){
	            $message = [
	                'action'=>'success',
	                'message'=>'Payment done',
	            ];

            }else{

                $message = [
                    'action'=>'error',
                    'message'=>'Try again or use registered safaricom phone number if you did register with the details',
                ];

            }

        }else{
            $message = [
                'action'=>'error',
                'message'=>'Some Items are empty',
            ];
        }
        echo json_encode($message);
	}
}

?>