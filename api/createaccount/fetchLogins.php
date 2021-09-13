<?php
include '../connector/connector.php';
include '../vendor/autoload.php';

/**
 *
 */
class GetUserLogs extends Connector
{
  public function checkUserExist($variables){

      $this->conn()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "SELECT * FROM account_verification WHERE username='$variables' limit 1";
      $res = $this->conn()->prepare($query);
      $res->execute();
      $message = "";
      if($res->fetchColumn() > 0){
          $message = 1 ;
      }else{
          $message = $res;
      }
      return $message;

  }

	public function GetData($variables){
        $this->conn()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM create_Account WHERE ax_username='$variables' or random_user_id='$variables' or phone='$variables' limit 1";
        $res = $this->conn()->prepare($query);
        $res->execute();
        $j = [];
        if($newData = $res->fetch(PDO::FETCH_ASSOC)){
            $j[]=[


                "username"=>$newData["ax_username"],
                "email"=> $newData["ax_email"],
                "userId"=>$newData["random_user_id"],
                "referee"=>$newData['referee']
            ];
        }else{
            $j[]=[
                "username"=>'0',
                "email"=>'0',
                "userId"=>'0'
            ];
        }
        return $j[0];
    }
	public function GetUsername($variables){
        $this->conn()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM create_Account WHERE ax_username='$variables' limit 1";
        $res = $this->conn()->prepare($query);
        $res->execute();
        $j = [];
        $i=0;
        if($newData = $res->fetch(PDO::FETCH_ASSOC)){
            $j[]=[
            	"userId"=>$newData["ax_id"],
                "username"=>$newData["ax_username"],
                "email"=> $newData["ax_email"],
                "password"=> $newData["ax_password"],
                "confirmed"=> $newData["ax_create_account_complete"],
                "date_created"=> $newData["Date_created"]
            ];
            $i++;
            return $j[0];
        }else{
            $data = [
                "error"=>300,
                'username'=>''
            ];
            return $data;
        }

    }
    public function getVerifiedUser($variable){
    	$this->conn()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT ax_username FROM create_Account WHERE ax_username='$variable' limit 1";
        $res = $this->conn()->prepare($query);
        $res->execute();
        $count = $res->rowCount();
        $message = [];
        switch ($count) {
        	case '1':
        		# code...
        			$message = [
	        			"count"=>$count,
	        			"message" => "User present"
	        		];
        		break;
        	case '0':
        		# code...
        			$message = [
	        			"count"=>$count,
	        			"message" => "User Not Present"
	        		];
        		break;

        	default:
        		# code...
        			$message = [
	        			"server"=>'Hello please contact applxe support support@appleIo.com'
	        		];
        		break;
        }
        echo json_encode($message);
    }
    public function GetEmail($variable){
        $this->conn()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM create_Account WHERE ax_email='$variable' limit 1";
        $res = $this->conn()->prepare($query);
        $res->execute();
        $j = [];
        $i=0;

        if($newData = $res->fetch(PDO::FETCH_ASSOC)){
            $j[]=[
                "randUser"=> $newData["ax_id"],
                "username"=>$newData["ax_username"],
                "email"=> $newData["ax_email"],
                "confirmed"=> $newData["ax_create_account_complete"],
                "date_created"=> $newData["Date_created"]
            ];
            $i++;
            return $j[0];
        }else{
            $data = [
                "error"=>300,
                'email'=>''
            ];
            return $data;
        }

    }
    public function verifyPayment($variables){

        $this->conn()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM stkpayment WHERE phoneNumber='$variables' AND resultCode = 0 limit 1";
        $res = $this->conn()->prepare($query);
        $res->execute();
         $message = "";
        if($res->fetchColumn() > 0){
            $message = true ;
        }else{
            $message = false;
        }
        return $message;

    }
    public function updateVerification($username){
        $username = strip_tags($username);
        $message = [];
        $this->conn()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "UPDATE create_account SET ax_create_account_complete=2 WHERE ax_username=:username or random_user_id=:username or phone=:username";
        $res = $this->conn()->prepare($query);
        $res->bindParam(':username',$username);
        if($res->execute()){
            $message =[
                'error'=>200,
                'message'=>'user verified successfully'
            ];
        }else{
            $message =[
                'error'=>201,
                'message'=>'user not verified successfully'
            ];
        }
        return $message;
        
    }
    public function sendEmail($username,$emailAddress,$message){
      $email = new \SendGrid\Mail\Mail();
      $email->setFrom("webappcode@bitrix24.com", "ReeferInc");
      $email->setSubject("Reset Account Password | ReeferInc");
      $email->addTo("$emailAddress", "$username");
      $email->addContent("text/html", "<p>$message</p>");
      $sendgrid = new \SendGrid('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');
      try {
          $response = $sendgrid->send($email);
          if($response->statusCode()  == 202){
            return true;
          }else{
            return false;
          }

      } catch (Exception $e) {
          echo 'Caught exception: '. $e->getMessage() ."\n";
      }
    }


}

?>
