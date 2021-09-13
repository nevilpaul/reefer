<?php
header("Access-Control-Allow-Origin:*");
header("Content-type:application/json");
error_reporting();
$main_pager = 'fetchLogins.php';
require_once($main_pager);
 /**
  * get username if exists in the database 
  */
 class Checkuseremail extends GetUserLogs
 {
 	function __construct($email)
 	{
 		$this->email = $email;
 	}
 	public function userStatus(){
         $data = $this->GetEmail($this->email);
         
         $error=[];
        try {
         	if(isset($this->email) && !empty($this->email)){

                if ($this->email !== strtolower($data["email"])) {
                  $error = [
                        "success" => 1,
                        "message" =>"Email does not exist ".strtolower($data["email"])
                    ];
                    throw new Exception(json_encode($error), 1);
                }else{
                	$error = [
                        "success" => 0,
                        "message" => "user email exists please try another email"
                    ];
                    throw new Exception(json_encode($error), 1);
                }
             }else{
                $error = [
                    "error_type"=>404,
                    "message"=>"the field can never be empty"
                ];
                throw new Exception(json_encode($error), 1);
            }
 			
 		} catch (Exception $e) {
 			echo($e->getMessage());
 		}
 	}
 }
$email = $_POST['email'];
$email= strtolower($email);
$email = strip_tags($email);

$userExist = new Checkuseremail($email);
$userExist->userStatus();
?>