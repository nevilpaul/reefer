<?php
header("Access-Control-Allow-Origin:*");
header("Content-type:application/json");
$main_pager = __DIR__ . DIRECTORY_SEPARATOR . ('fetchLogins.php');
require_once($main_pager);
class VerifyUser extends GetUserLogs
{
	
	function __construct($username)
	{
		$this->username = $username;
	}
	public function userVerify(){
		$this->getVerifiedUser($this->username);
	}
}
$username = htmlentities($_POST['cookieUser']);
$verifyUser = new VerifyUser($username);
$verifyUser->userVerify();