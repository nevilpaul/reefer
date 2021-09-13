<?php
use ApplxeJwt\Jwtoken as jt;
use Carbon\Carbon;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");
include 'import.php';
include '../createaccount/reefer.php';

class Payforaffiliate extends Reefer{
    public function payforaffiliate($payerId,$payeeName,$amount){
        $message=[];
        if(!empty($payerId) && isset($payerId)){
            $timeNow = Carbon::now(new DateTimeZone('Africa/Nairobi'));
            $strTime = strtotime($timeNow);
            $payerBalance=$this->fetchWalletBalance($payerId);
            $Balance = $payerBalance['balance'];
            if($Balance >=$amount AND $amount == 500){
                $boolen = $this->checknotverified($payeeName);
                if($boolen){
                    $referusername =$this->getUsernamebyId($payerId)['username'];
                    $updatedbalance = $this->culculate('remove',$Balance,$amount);
                    $updated = $this->updateWallet($payerId,$updatedbalance,$strTime);
                    if($updated['errorCode'] == 200){
                        $saveTransaction = $this->addHelaReefer($referusername,$payeeName,500);

                        if($saveTransaction['errorCode'] == 200){
                            $addTopay_for_client = $this->addTopay_for_client($payerId,$payeeName,$amount);
                            if($addTopay_for_client['errorCode'] == 200){
                                $verifyUser = $this->verifyUser($payeeName);
                                if($verifyUser['errorCode'] == 200){
                                    // deduct wallet from wallet Balance 
                                    $message=[
                                        'error'=>200,
                                        'message'=>'you have successfuly payed for '.$payeeName
                                    ];
                                }else{
                                    $message=[
                                        'error'=>201,
                                        'message'=>'user not verified'
                                    ];
                                }
                            }else{
                                $message=[
                                    'error'=>201,
                                    'message'=>'Transaction not successfull'
                                ];
                            }
                        }else{
                            $message=[
                                'error'=>201,
                                'message'=>'Transaction not successfull'
                            ];
                        }
                        
                    }else{
                        $message=[
                            'error'=>201,
                            'message'=>'error while updating wallet'
                        ];
                    }
                }else{
                    $message=[
                        'error'=>2011,
                        'message'=>'Transaction not successfull'
                    ];
                }
            }else{
                $message=[
                    'error'=>2012,
                    'message'=>'Transaction not successfull'
                ];
            }
        }
        echo json_encode($message);
        
    }
    
}
$username = $_REQUEST['username'];
$userId = $_REQUEST['userId'];
$amount = $_REQUEST['amount'];
$username = strtolower($username);
$username = strip_tags($username);
$userId  = strip_tags($userId );
$amount  = strip_tags($amount );
$Pay = new Payforaffiliate();
$Pay->payforaffiliate($userId,$username,$amount)

?>