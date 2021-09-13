<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");
$main_pagers = __DIR__ . DIRECTORY_SEPARATOR . ('fetchLogins.php');
$mains = __DIR__ . DIRECTORY_SEPARATOR . ('sendemails.php');
require_once($mains);
require($main_pagers);
class Verification extends Connector
{

	function __construct($email)
	{
		$this->email = $email;
	}
	public function userEmail(){

		$data = new GetEmail($this->email);
    $username = $data['username'];
    $email = $data['email'];
    $userId = $data['randUser'];

    if($data['randUser'] != " " AND $data['randUser'] != ""){

      $encryp1 = 'WebapplxeIo3';
      $encryp2 = 'applxeIo254';
      $val = rand(0,time());
      $val = $encryp1.md5($val).$encryp2;
      $salt = strip_tags($val);
      $code = password_hash($salt, PASSWORD_DEFAULT);
      $link = "https://localhost:3000/resetpsw?code=$code";
      $sendmailer = new SendMail($username,$email,$link,$userId);
      $sendmailer->Sendmail();

    }


	}
}
$email = strip_tags($_REQUEST['email']);
$verifyUser = new Verification($email);
$verifyUser->userEmail();
?>
