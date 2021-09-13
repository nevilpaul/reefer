<?php

session_start();
header("Access-Control-Allow-Origin:*");
header("Content-type:application/json");
$main_pager = __DIR__ . DIRECTORY_SEPARATOR . ('fetchLogins.php');
require_once($main_pager);
/**
 * 
 */
class SubmitBasicData extends GetUserLogs
{
	function __construct($firstname,$lastname,$gender,$dateofbirth,$accounttype,$country,$username)
	{
		$this->firstname = strip_tags($firstname);
		$this->lastname = strip_tags($lastname);
		$this->username = strip_tags($username);
		$this->gender = strip_tags($gender);
		$this->dateofbirth = $dateofbirth;
		$this->accounttype = strip_tags($accounttype);
		$this->country = strip_tags($country);
	}
	public function basic(){
		$newDate = str_replace("/", "-", $this->dateofbirth);
		$newDate  = strtotime($newDate);
		// fetch and get userid of the cookie saved on server
		$userid = $this->GetUsername($this->username);
		$userid = $userid['userId'];
		$timestamp = $this->timeStampdata();
		if(!empty($this->firstname) and !empty($this->lastname ) and !empty($this->gender) and !empty($this->dateofbirth) and !empty($this->accounttype) and !empty($this->country) ){
			$this->conn()->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        	$query = "INSERT INTO continue_add(ax_id,Firstname,Lastname,gender,Birth_date,userType,Country,created_date)VALUES('$userid','$this->firstname','$this->lastname','$this->gender','$newDate','$this->accounttype','$this->country','$timestamp')";
			$insert = $this->conn()->exec($query);
                $success = [
                    'message' => 'Success',
                    'error' => 0
                ];
                $error = [
                    'message' => 'A problem occured please try again!',
                    'error' => 1
                ];
                $message = ($insert == true) ? $success : $error;

                header("Access-Control-Allow-Origin:*");
                header("Content-type:application/json");
                echo json_encode($message);

		}
	}
}
$firstname = ucfirst($_POST['firstname']); //$_POST['firstname'];
$lastname = ucfirst($_POST['lastname']); //$_POST['lastname'];
$gender = ucfirst($_POST['gender']); //$_POST['gender'];
$dateofbirth = $_POST['dateofbirth']; //$_POST['dateofbirth'];
$accounttype = $_POST['accounttype']; //$_POST['accounttype'];
$country = ucfirst($_POST['country']); //$_POST['country'];
$username = ucfirst($_POST['userName']); //$_POST['country'];
$SubmitBasicData = new SubmitBasicData($firstname,$lastname,$gender,$dateofbirth,$accounttype,$country,$username);
$SubmitBasicData->basic();
?>