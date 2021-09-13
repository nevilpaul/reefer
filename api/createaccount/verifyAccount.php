<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");
$main_pager = __DIR__ . DIRECTORY_SEPARATOR . ('fetchLogins.php');
require_once($main_pager);

/**
 * 
 */
class Verify extends GetUserLogs
{
	
	function __construct($username,$codeCheck)
	{
		# code...
		$this->username = $username;
		$this->codeCheck = $codeCheck;
	}
	public function very(){
		if (!empty($this->username) and !empty($this->codeCheck)) {
			# code...
			$timestamp = $this->timeStampdata();
			$this->conn()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "SELECT * FROM account_verification WHERE username='$this->username' and verification_code='$this->codeCheck' limit 1";
        	$res = $this->conn()->prepare($query);
        	$res->execute();
        	$newData = $res->fetch(PDO::FETCH_ASSOC);
        	if($newData['verification_code'] == $this->codeCheck){
        		$query = "UPDATE account_verification SET verified=1,date_varified='$timestamp' WHERE username='$this->username'";
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
        	}else{
        		echo 'Not verified';
        	}
		} else {
			# code...
			echo "please enter the verification code $this->username and $this->codeCheck";
		}
		
	}
}
$username = $_POST['username'];
$codeCheck = $_POST['code'];
$codeChecker = new Verify($username,$codeCheck);

$codeChecker->very();
?>