<?php

header("Access-Control-Allow-Origin:*");
header("Content-type:application/json");
$main_pager = 'fetchLogins.php';
require_once($main_pager);

 /**
  * get username if exists in the database 
  */
 class Checkusername extends GetUserLogs
 {
 	function __construct($name)
 	{
 		$this->name = strtolower($name);
 	}
 	public function userStatus(){
         $data = $this->GetUsername($this->name);
         $error=[];
	 		try {
         			if(isset($this->name) && !empty($this->name)){
                if ($this->name !== strtolower($data["username"])) {
                  $error = [
                        "success" => 1,
                        "message" =>"username does not exist ".strtolower($data["username"])
                    ];
                    throw new Exception(json_encode($error), 1);
                }else{
                	$error = [
                        "success" => 0,
                        "message" => "username exists please try another username"
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
$name = $_POST['username'];
$name= strtolower($name);
$userExist = new Checkusername($name);
$userExist->userStatus();
?>