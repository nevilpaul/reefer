<?php
use ApplxeJwt\Jwtoken as jt;
include '../connector/connector.php';
Import('../login/AuthO/define.php');
Import('../login/AuthO/token.php');
class Account extends Connector 
{
    public function decrype ($token){

        if(!empty($token)){
          $newToken = jt::getDec($token,publicKey);
          // $tokenO = $newToken->token;
          // print_r($newToken);
          return $this->getData($newToken);
        }else{
          $message = [
            'error'=>0,
            'message'=>'invalid token'
          ];
          return json_encode($message);
        }
    }
    public function getData ($token){
        $query = "SELECT * FROM create_account WHERE random_user_id='$token' LIMIT 1";
        $res = $this->conn()->prepare($query);
        $res->execute();
        $message =[];
        $fetch_very = $res->fetch(PDO::FETCH_ASSOC);
        $message = [
        'token'=>$fetch_very['random_user_id'],
        'firstname'=>$fetch_very['firstname'],
        'lastname'=>$fetch_very['lastname'],
        'username'=>$fetch_very['ax_username'],
        'email'=>$fetch_very['ax_email'],
        'phone'=>$fetch_very['phone'],
        'acccountComplete'=>$fetch_very['ax_create_account_complete'],
        'Date_created'=>date('d M, Y, H:i A',$fetch_very['Date_created']),
        ];
        return($message);
    }
    public function verifyBeforeFetch($reeferId,$reeferName){
        $query = 'SELECT * FROM create_account WHERE random_user_id=:reeferId LIMIT 1';
        $res = $this->conn()->prepare($query);
        $res->bindParam(':reeferId',$reeferId);

        if($res->execute()){
            if($resData = $res->fetch(PDO::FETCH_ASSOC)){
                if($resData['ax_username'] == $reeferName){
                    return 'true';
                }else{
                    return 'false';
                }
            }
        }
    }
    public function fetchAllreferals($referId){
        $query = 'SELECT COUNT(*) FROM create_account WHERE referee=:referId';
        $res = $this->conn()->prepare($query);
        $res->bindParam(':referId',$referId);
        if($res->execute()){
            return $res->fetchColumn();
        }
    }
    public function ActiveReferals($referId){
        $verified = 2;
        $query = 'SELECT COUNT(*) FROM create_account WHERE referee=:referId AND ax_create_account_complete=:numbers ';
        $res = $this->conn()->prepare($query);
        $res->bindParam(':referId',$referId);
        $res->bindParam(':numbers',$verified);
        if($res->execute()){
            return $res->fetchColumn();
        }
    }

    public function getLevelOneRefereal($referName){
        $super = 'super';
        $query = 'SELECT COUNT(*) FROM reefer_history WHERE referee_name=:refername AND referee_level=:super';
        $res = $this->conn()->prepare($query);
        $res->bindParam(':refername',$referName);
        $res->bindParam(':super',$super);
        if($res->execute()){
             return $res->fetchColumn();
        }
    }

    public function getReferedTotal($referName){
        $super = 'super';
        $query = 'SELECT SUM(cost) AS TotalEarning FROM reefer_history WHERE referee_name=:refername AND referee_level=:super';
        $res = $this->conn()->prepare($query);
        $res->bindParam(':refername',$referName);
        $res->bindParam(':super',$super);
        if($res->execute()){
             if($totalCost = $res->fetch(PDO::FETCH_ASSOC)){
                 return number_format($totalCost['TotalEarning']);
             }
        }
    }
    
    public function getTotaltransaction($userId){

        $query = 'SELECT SUM(transaction_amount) AS TotalEarning FROM transaction_history WHERE userId=:userId';
        $res = $this->conn()->prepare($query);
        $res->bindParam(':userId',$userId);

        if($res->execute()){
             if($totalCost = $res->fetch(PDO::FETCH_ASSOC)){
                 return number_format($totalCost['TotalEarning']);
             }
        }

    }
    
    // fetches the balance in a wallet
	public function getWalletData($varible){
		if($this->conn()){
			$query = "SELECT * FROM actua_wallet WHERE random_id=:random_id LIMIT 1";
			$wallet = $this->conn()->prepare($query);
			$wallet->bindParam(':random_id',$varible);
			if($wallet->execute()){
				if($dataFetch = $wallet->fetch(PDO::FETCH_ASSOC)){
                    return number_format($dataFetch['amount']);
				}else{
					return 0;
				}
			}else{
				return 0;
			}

		}
	}
    public function getTransactions($userId){
        if($this->conn()){
            $query = "SELECT ROW_NUMBER() OVER(ORDER BY transaction_id DESC) AS transId,transaction_type,transaction_name,transaction_amount,transaction_status,date_transacted FROM transaction_history WHERE userId=:random_id limit 0,5";
			$wallet = $this->conn()->prepare($query);
			$wallet->bindParam(':random_id',$userId);
            $dataResult = [];
            if($wallet->execute()){
				while($dataFetch = $wallet->fetch(PDO::FETCH_ASSOC)){
                    
                    $dataResult[] =[

                        'transId'=>$dataFetch['transId'],
                        'transaction_type'=>$dataFetch['transaction_type'],
                        'transaction_name'=>$dataFetch['transaction_name'],
                        'amount'=>number_format($dataFetch['transaction_amount']),
                        'transaction_status'=>$dataFetch['transaction_status'],
                        'date'=>date('d M, Y, H:i A',$dataFetch['date_transacted'])

                    ];

				}
			}else{
				return 0;
			}
            return $dataResult;
        }
    }
    public function HideNumber($phone){
        $getFirst5numbers = substr("$phone", 0,5);
        $lastLast5numbers = substr("$phone", 10,11);
        return $getFirst5numbers.'*****'.$lastLast5numbers;
    }
    public function recentReferals($userId){
        if($this->conn()){
            $query = "SELECT ROW_NUMBER() OVER(ORDER BY ax_id DESC) AS transId,ax_username,phone,referee,ax_create_account_complete,Date_created FROM create_account WHERE referee=:random_id limit 0,8";
			$referee = $this->conn()->prepare($query);
			$referee->bindParam(':random_id',$userId);
            $dataResult = [];
            if($referee->execute()){
				while($dataFetch = $referee->fetch(PDO::FETCH_ASSOC)){
                    $phone = $dataFetch['phone'];
                    $newPhone = $this->HideNumber($phone);
                    $dataResult[] =[
                        'transId'=>$dataFetch['transId'],
                        'username'=>$dataFetch['ax_username'],
                        'phone'=>$newPhone,
                        'verified'=>$dataFetch['ax_create_account_complete'],
                        'date'=>date('d M, Y, H:i A',$dataFetch['Date_created'])

                    ];

				}
			}else{
				return 0;
			}
            return $dataResult;
        }
    }
    public function getAllTransactions($userId){
        if($this->conn()){
            $query = "SELECT ROW_NUMBER() OVER(ORDER BY transaction_id DESC) AS transId,transaction_type,transaction_name,transaction_amount,transaction_status,date_transacted FROM transaction_history WHERE userId=:random_id";
			$wallet = $this->conn()->prepare($query);
			$wallet->bindParam(':random_id',$userId);
            $dataResult = [];
            if($wallet->execute()){
				while($dataFetch = $wallet->fetch(PDO::FETCH_ASSOC)){
                    
                    $dataResult[] =[

                        'transId'=>$dataFetch['transId'],
                        'transaction_type'=>$dataFetch['transaction_type'],
                        'transaction_name'=>$dataFetch['transaction_name'],
                        'amount'=>number_format($dataFetch['transaction_amount']),
                        'transaction_status'=>$dataFetch['transaction_status'],
                        'date'=>date('d M, Y, H:i A',$dataFetch['date_transacted'])
                        
                    ];

				}
			}else{
				return 0;
			}
            return $dataResult;
        }
    }
    public function getAllReferals($userId){
        if($this->conn()){
            $username = $this->getData($userId)['username'];
            $query = "SELECT ROW_NUMBER() OVER(ORDER BY refer_id DESC) AS referId,username,referee_level,cost,date_Refered FROM reefer_history WHERE referee_name=:username";
			$wallet = $this->conn()->prepare($query);
			$wallet->bindParam(':username',$username);
            $dataResult = [];
            if($wallet->execute()){
				while($dataFetch = $wallet->fetch(PDO::FETCH_ASSOC)){
                    $usernameReefer=$dataFetch['username'];
                    $query = 'SELECT * FROM create_account WHERE ax_username=:username';
                    $res = $this->conn()->prepare($query);
                    $res->bindParam(':username',$usernameReefer);
                    if($res->execute()){
                        $resData = $res->fetch(PDO::FETCH_ASSOC);
                        $dataResult[] =[
                            'referId'=>$dataFetch['referId'],
                            'firstname'=>$resData['firstname'],
                            'lastname'=>$resData['lastname'],
                            'username'=>$dataFetch['username'],
                            'referee_level'=>$dataFetch['referee_level'],
                            'amount'=>number_format($dataFetch['cost']),
                            'verified'=>$resData['ax_create_account_complete'],
                            'date'=>date('d M, Y, H:i A',$dataFetch['date_Refered'])  
                        ];
                    }
                    

				}
			}else{
				return 0;
			}
            return $dataResult;
        }
    }
    public function getTotallevelone($userId,$level){
        $username = $this->getData($userId)['username'];
        $query = 'SELECT SUM(Cost) AS TotalEarning FROM reefer_history WHERE referee_name=:username and referee_level=:levels';
        $res = $this->conn()->prepare($query);
        $res->bindParam(':username',$username);
        $res->bindParam(':levels',$level);
        if($res->execute()){
             if($totalCost = $res->fetch(PDO::FETCH_ASSOC)){
                 return number_format($totalCost['TotalEarning']);
             }
        }

    }

    
}

?>