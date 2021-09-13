<?php
header("Access-Control-Allow-Origin:*");
header("Content-type:application/json");
error_reporting(1);
$main_pager = __DIR__ . DIRECTORY_SEPARATOR . ('fetchLogins.php');
require_once($main_pager);
/**
 * 
 */
class phoneSubmit extends GetUserLogs
{
	
	function __construct($userCookie,$countryCode,$phone)
	{
		$this->userCookie = strip_tags($userCookie);
		$this->countryCode = strip_tags($countryCode);
		$this->phone = strip_tags($phone);
	}
	public function userphone(){
		$data =$this->GetUsername($this->userCookie);
		$userid = $data['userId'];
		$dateString = $this->timeStampdata();
		$conn = $this->conn();
		$this->conn()->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $query = "UPDATE continue_add SET country_code='$this->countryCode', phone='$this->phone',date_updated='$dateString' WHERE ax_id='$userid'";
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
        echo json_encode($message);
	}
}
$userCookie = strip_tags($_POST['userName']);
$countryCode = strip_tags($_POST['countryCode']);
$phone = strip_tags($_POST['phone']);
$phoneSubmit = new phoneSubmit($userCookie,$countryCode,$phone);
$name = $phoneSubmit->userphone();
?>