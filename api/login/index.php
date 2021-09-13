<?php
use ApplxeJwt\Jwtoken as jt;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");

$main_pager ='conn.php';
$header ='headers.php';
include($header);
require ($main_pager);
include('AuthO/define.php');
include('AuthO/token.php');
session_start();
class Login extends Conn{
    function __construct($username,$password){
        $this->username = $username;
        $this->password = $password;
    }

    public function verify(){
        try{
            $fetch = $this->connect()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM create_account WHERE phone='$this->username' or ax_email='$this->username'";
            $res = $this->connect()->prepare($query);
            $res->execute();
            $message =[];
            $fetch_very = $res->fetch(PDO::FETCH_ASSOC);
            $hash = $fetch_very['ax_password'];
            if($fetch_very['phone'] == $this->username or $fetch_very['ax_email'] == $this->username and password_verify($this->password, $hash) == true ){
                $ax_id = $fetch_very["ax_id"];
                $userAccount = '__UserApplxe';
                $accountType = '__GpApplxetype';

                setcookie($userAccount,$fetch_very['random_user_id'],time()+(86400 * 364),'/');

                // $query = "SELECT * FROM continue_add WHERE ax_id='$ax_id' LIMIT 1";
                // $result = $this->connect()->prepare($query);
                // $result->execute();

                // $fetch_var = $result->fetch(PDO::FETCH_ASSOC);
                $accType = 'user';

                // if($fetch_var['ax_id'] == $fetch_very['ax_id']){
                //     $message = [
                //         'error'=>"0",
                //         'token'=>$fetch_very['random_user_id']
                //     ];
                // }
                $_SESSION['accountType'] =  $accType;
                $_SESSION['token'] =  jt::getEnc($message,privateKey);
                $message = [
                'accountType'=>$accType,
                  'token'=> Jt::getEnc($fetch_very['random_user_id'],privateKey)
                ];
                
            }else{
                $message = [
                    'error'=>"1",
                    'message'=> "please enter the correct credentials or sign up, if you are not registered"
                ];
            }
            // echo json_encode($message);
            
            
            echo json_encode($message);
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
}

$encryp1 = 'WebapplxeIo3';
$encryp2 = 'applxeIo254';
$username = strtolower($_REQUEST['username']);
$password = $_REQUEST['password'];
$password = $encryp1.$_REQUEST['password'].$encryp2;

$login = new Login($username,$password);
$login->verify();
?>
