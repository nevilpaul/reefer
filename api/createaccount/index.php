<?php
use Carbon\Carbon;
use ApplxeJwt\Jwtoken as jt;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");

include('fetchLogins.php');
include ('../vendor/autoload.php');
require('../login/AuthO/define.php');
include('../login/AuthO/token.php');

class CreateAccount extends GetUserLogs{
    function __construct($firstname,$lastname,$username,$referee,$email,$password,$completed,$random_user_id,$phone){
        
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->username = $username;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->referee = $referee;
        $this->completed = $completed;
        $this->random_user_id = $random_user_id;
        $this->dbconnect = $this->conn();
    }

    public function InsertData(){
        //SETTING PDO ERROR EXCEPTION
        $timeNow = Carbon::now(new DateTimeZone('Africa/Nairobi'));
        $strTime = strtotime($timeNow);
        $getId = $this->GetData($this->username);
        $refId = $this->GetData($this->referee);

        $idUser = $getId['userId'];
        $message =[];
        if($idUser == 0){
            $reeferId = $refId['userId'];

            $ax_create_account_complete = 0;

            if(strlen($reeferId) > 0){

                if(!empty($this->username) AND !empty($this->email) AND !empty($this->password) AND $this->completed == 0 AND !empty($this->random_user_id)){


                    $addUser = $this->dbconnect->prepare('INSERT INTO create_account VALUES (null,:firstname,:lastname,:random_user_id,:ax_username,:ax_email,:phone,:ax_password,:referee,:ax_create_account_complete,:Date_created)');

                    $addUser->bindParam(':firstname',$this->firstname);
                    $addUser->bindParam(':lastname',$this->lastname);
                    $addUser->bindParam(':random_user_id',$this->random_user_id);
                    $addUser->bindParam(':ax_username',$this->username);
                    $addUser->bindParam(':ax_email',$this->email);
                    $addUser->bindParam(':phone',$this->phone);
                    $addUser->bindParam(':ax_password',$this->password);
                    $addUser->bindParam(':referee',$reeferId);
                    $addUser->bindParam(':ax_create_account_complete',$this->completed);
                    $addUser->bindParam(':Date_created',$strTime);

                    if($addUser->execute()){
                        $token = Jt::getEnc($this->random_user_id,privateKey);
                        $message = [
                            'action'=>'success',
                            'message'=>'Account created',
                            'token'=>$token,
                            'phone'=>$this->phone
                        ];

                    }else{

                        $message = [
                            'action'=>'error',
                            'message'=>'Try again or use another email or phone number if you did register with the details',
                        ];

                    }

                }else{
                    $message = [
                        'action'=>'error',
                        'message'=>'Some Items are empty',
                        'username'=>$this->username,
                        'email'=>$this->email,
                        'password'=>$this->password,
                        'completed'=>$this->completed,
                        'random_user_id'=>$this->random_user_id,
                    ];
                }
            }else{
                $message = [
                    'action'=>'error',
                    'message'=>'Not a valid Referee',
                ];
            }
        }else{
            $message = [
                "error"=>'504',
                "email"=>'0',
                "userId"=>'0'
            ];
        }

        echo json_encode($message);
    }
}
$encryp1 = 'WebapplxeIo3';
$encryp2 = 'applxeIo254';


$firstname = strtolower($_REQUEST['firstname']);
$lastname = strtolower($_REQUEST['lastname']);
$username = strtolower($_REQUEST['username']);
$referee = strtolower($_REQUEST['referee']);
$email = strtolower($_REQUEST['email']);
$phone = strtolower($_REQUEST['phone']);
$password = $_REQUEST['password'];

$firstname = strip_tags($firstname);
$lastname = strip_tags($lastname);
$username = strip_tags($username);
$referee = strip_tags($referee);
$email = strip_tags($email);
$phone = strip_tags($phone);
$password = strip_tags($password);

$salt = $encryp1.$password.$encryp2;

$salt = strip_tags($salt);
$password = password_hash($salt, PASSWORD_DEFAULT);
$random = rand(2532,time()).time();
$random_user_id= md5($random);
$completed = 0;

$account = new CreateAccount($firstname,$lastname,$username,$referee,$email,$password,$completed,$random_user_id,$phone);
$account->InsertData();
?>
