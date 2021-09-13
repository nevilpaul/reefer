<?php
use ApplxeJwt\Jwtoken as jt;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");

$main_pager = 'conn.php';
require ($main_pager);
include('AuthO/define.php');
include('AuthO/token.php');
class CredentialsCheck extends Conn{

  public function decrype ($token){

    if(!empty($token)){
      $newToken = jt::getDec($token,publicKey);
      // $tokenO = $newToken->token;
      // print_r($newToken);
      $this->getData($newToken);
    }else{
      $message = [
        'error'=>0,
        'message'=>'invalid token'
      ];
      echo json_encode($message);
    }
  }
  public function getData ($token){
    $query = "SELECT * FROM create_account WHERE random_user_id='$token' LIMIT 1";
    $res = $this->connect()->prepare($query);
    $res->execute();
    $message =[];
    $fetch_very = $res->fetch(PDO::FETCH_ASSOC);
    $message = [
      'token'=>$fetch_very['random_user_id'],
      'firstname'=>$fetch_very['firstname'],
      'lastname'=>$fetch_very['lastname'],
      'username'=>$fetch_very['ax_username'],
      'email'=>$fetch_very['ax_email'],
      'phone'=>$fetch_very['phone'],
      'acccountComplete'=>$fetch_very['ax_create_account_complete'],
      'Date_created'=>date('d M, Y, H:i A',$fetch_very['Date_created']),
    ];
    echo json_encode($message);
  }

}
$token = $_GET['token'];
$token = strip_tags($token);
$CredentialsCheck =new CredentialsCheck();
$CredentialsCheck->decrype($token)
?>
