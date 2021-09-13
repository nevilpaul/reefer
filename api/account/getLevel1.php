<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");
include 'import.php';
Import('index.php');
class Getlevel1total extends Account{
    public function getpaginationValue($token,$level){
        $decData = $this->decrype($token);
        $userID = $decData['token'];
        $username = $decData['username'];
        $verify = $this->verifyBeforeFetch($userID,$username);
        if($verify){
            $amount = $this->getTotallevelone($userID,$level);
            $message=[
                'data'=>$amount
            ];
        }else{
            $message =[
                "errorCode"=>200,
                'message'=>'error while fetching data'
            ];
        }
        echo json_encode($message);
    }
}
$token = $_REQUEST['token'];
$level = $_REQUEST['levels'];
$token = strip_tags($token);
$level = strtolower($level);
$level = strip_tags($level);
$new = new Getlevel1total();
$new->getpaginationValue($token,$level);
?>