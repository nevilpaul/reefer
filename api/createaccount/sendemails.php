<?php
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST');
// header('Access-Control-Allow-Credentials: true');
// header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
// header("Access-Control-Allow-Headers: X-Requested-With");
// header("Content-type:application/json");
$main_pager = __DIR__ . DIRECTORY_SEPARATOR . ('fetchLogins.php');
require_once($main_pager);

require '../vendor/autoload.php';

/**
 *
 */
class SendMail extends Connector
{

	function __construct($username,$email,$userId)
	{
		# code...
		$this->username = $username;
		$this->email = $email;
		$this->userId = $userId;
	}

	public function Sendmail(){
		if(!empty($this->username) and !empty($this->email) ){
			// date_default_timezone_set('African/Nairobi');
			$dateString = time()+1800;
			$dateExpire = date('h:i:s a',$dateString);
			$encryp1 = 'WebapplxeIo3';
      $encryp2 = 'applxeIo254';
      $val = rand(0,time());
      $val = $encryp1.md5($val).$encryp2;
      $salt = strip_tags($val);
      $code = password_hash($salt, PASSWORD_DEFAULT);
			$link = "https://localhost:3000/resetpsw?code=$code";

			$email = new \SendGrid\Mail\Mail();
			$email->setFrom("webappcode@bitrix24.com", "ReeferInc");
			$email->setSubject("Reset Account Password | ReeferInc");
			$email->addTo($this->email,$this->username);
			$email->addContent("
				<p>
					Dear $this->username.<br>
					Confirm your account to continue your journey! Remember your email address, you’ll need it to access Applxe.io. Your Verification code is : <span style='color:orangered;font-weight:bolder;font-size:20px;'>123</span>.
					<p>
						This expires after 30 minutes($dateExpire)
					</p>
					<p>
						Thank you.<br>
						applxe.io promote your self.
					</p>
				</p>
			");
			$email->addContent(
			    "text/html", "<strong>This allows your application to authenticate to our API and send mail. You can enable or disable additional permissions on the API keys page.</strong>"
			);
			$sendgrid = new \SendGrid('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');
			try {
			    $response = $sendgrid->send($email);
			    print $response->statusCode() . "\n";

			} catch (Exception $e) {
			    echo 'Caught exception: '. $e->getMessage() ."\n";
			}
			// $mail = new PHPMailer;
			// try {
			// 	//setting up a server\
			// 	// $mail->SMTPdebug = 2;
	    // 		if($mail->send()){
	    // 			$user = $this->checkUserExist($this->username);
		  //   		if($user == 0){
		  //   			$this->conn()->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	    //     		$query = "INSERT INTO account_verification(user_id,username,email_address,verification_code,verified,expire_date,date_varified)VALUES('$this->userId','$this->username','$this->email','$this->Verification','0','$dateString','$timestamp')";
			// 				$insert = $this->conn()->exec($query);
			// 				$success = [
      //           	'message' => 'Verification code has been sent, if you didnt get the code <span className="linker">click here</span>',
      //           	'error' => 0
      //       	];
      //       	$error = [
      //           	'message' => 'A problem occured please try again!',
      //           	'error' => 1
      //       	];
      //        		$message = ($insert == true) ? $success : $error;
      //       		echo json_encode($message);
      //        	}else {
			// 				$this->conn()->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      //   			$query = "UPDATE account_verification SET verification_code='$this->Verification', expire_date='$dateString',date_varified='$timestamp' WHERE user_id='$this->userId'";
			// 				$insert = $this->conn()->exec($query);
			// 				$success = [
			// 	            'message' => 'Success',
			// 	            'error' => 0
			// 	       ];
			//         $error = [
			//             'message' => 'A problem occured please try again!',
			//             'error' => 1
			//         ];
			// 	      $message = ($insert == true) ? $success : $error;
			// 	        echo json_encode($message);
	    //       }
	    // 		}else{
	    // 			echo "message not sent please try again";
	    // 		}
			// }catch (Exception $e) {
			// 	echo 'Message could not be sent. Mailer Error: ';
			// }

		}else{
			echo "No mail to be sent $this->username and email $this->email and the verification code is $this->Verification";
		}
	}
}
// $Verification = $_GET['Verification'];
// $email = $_GET['Email'];
// $username = $_GET['userName'];
// $userId = $_GET['_userID'];
$sendmailer = new SendMail('ReeferInc','nevilross2@gmail.com',2);
$sendmailer->Sendmail();
?>
