<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");
header("Content-type:application/json");
$main_pager = __DIR__ . DIRECTORY_SEPARATOR . ('fetchLogins.php');
require_once($main_pager);
class VerifyUser extends GetUserLogs
{
	
	function __construct($username)
	{
		$this->username = $username;
	}
	public function userEmail(){
		$data = $this->GetData($this->username);
		echo json_encode($data);
	}
}
$username = strip_tags($_POST['userName']);
$verifyUser = new VerifyUser($username);
$verifyUser->userEmail();