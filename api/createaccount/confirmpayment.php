<?php

include 'reefer.php';

class AddFriend {
    public function Verify($number){

        $messages = [];
        $reefer = new Reefer();
        $verifiedUser = $reefer->checkIfverified($number);
        
        if($verifiedUser == false){

            $message = $reefer->getVerify($number);
            $errorCode = $message['error'];
            if($errorCode == 200){
                $error = $reefer->updateVerification($number)['error'];
                if($error == 200){
                    $messages=[
                        'errorCode'=>200,
                        'message'=>'referal successfully'
                    ];
                }
                
            }else{
                $messages=[
                    'errorCode'=>201,
                    'message'=>'an error occured'
                ];
            }
            

        }else{
            $messages=[
                'errorCode'=>201,
                'message'=>'an error occured user is already verified'
            ];
        }
        echo json_encode($messages);
        

    }
}
$phone = strtolower($_REQUEST['phone']);
$phone = strip_tags($phone);
$userMpesaHistory = new AddFriend();
$userMpesaHistory->Verify($phone);

?>