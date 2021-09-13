<?php
use Carbon\Carbon;
include  'fetchLogins.php';
include  '../vendor/autoload.php';
// include getcwd().'/api/wallet/wallet.php';
// after payement is done now assigning levels and cashing them into wallets 
// check if user is signed up directly form company link 
class Reefer extends GetUserLogs
{
	function __construct($c = 'ReeferInc')
	{
		$this->comp = strtolower($c);
	}
	public function HelapointLevel($level,$amount,$name,$reefereename){
		switch ($level) {
			case '0':
				// code... save the code as 
				echo 'Company';
				$this->addReferee($name,$reefereename,$level,$amount);

				break;
			case 'super':
				echo 'super';
			break;
			case '1':
				// code...
				echo 'level 1';
				break;
			case '2':
				// code...
				echo 'level 2';
				break;
			case '3':
				// code...
				echo 'level 3';
				break;
			default:
				// code...
				break;
		}
	}

	public function addReferee($username,$reefere,$referee_level,$Cost){
		//SETTING PDO ERROR EXCEPTION
        $timeNow = Carbon::now(new DateTimeZone('Africa/Nairobi'));
        $strTime = strtotime($timeNow);

		$query = 'INSERT INTO reefer_history VALUES(null,:username,:referee_name,:referee_level,:Cost,:date_Refered)';
		
		$referee = $this->conn()->prepare($query);
		$referee->bindParam(':username',$username);
	    $referee->bindParam(':referee_name',$reefere);
	    $referee->bindParam(':referee_level',$referee_level);
	    $referee->bindParam(':Cost',$Cost);
	    $referee->bindParam(':date_Refered',$strTime);

	    if($referee->execute()){

	    	return true;

	    }else{

	    	return false;

	    }

	}
	// record transaction for all ttransaction done 
	public function RecordTransaction($username,$transactionType,$transactionName,$Cost,$status){
		//SETTING PDO ERROR EXCEPTION
		$fullData = $this->getData($username);
		$userId = $fullData['userId'];
        $timeNow = Carbon::now(new DateTimeZone('Africa/Nairobi'));
        $strTime = strtotime($timeNow);

		$query = 'INSERT INTO transaction_history VALUES(null,:userId,:transaction_type,:transaction_name,:transaction_amount,:transaction_status,:date_transacted)';
		
		$referee = $this->conn()->prepare($query);
		$referee->bindParam(':userId',$userId);
	    $referee->bindParam(':transaction_type',$transactionType);
	    $referee->bindParam(':transaction_name',$transactionName);
	    $referee->bindParam(':transaction_amount',$Cost);
	    $referee->bindParam(':transaction_status',$status);
	    $referee->bindParam(':date_transacted',$strTime);

	    if($referee->execute()){

	    	return true;

	    }else{

	    	return false;

	    }

	}

	public function checkReferee($username){
		$slt = "SELECT * FROM reefer_history WHERE username=:username ";
		$referee = $this->conn()->prepare($slt);
		$referee->bindParam(':username',$username);
	    $j = [];
	    if($referee->execute()){

	    	if($newData = $referee->fetch(PDO::FETCH_ASSOC)){
	    		// code...

	    		 $j[]=[

	                "refer_id"=>$newData["refer_id"],
	                "username"=>$newData["username"],
	                "referee"=> $newData["referee_name"],
	                "referee_level"=>$newData["referee_level"],
	                "Cost"=>$newData['Cost']

	            ];

	    	}else{
	    		$j[]=[
	                "username"=>'0',
	                "email"=>'0',
	                "userId"=>'0'
	            ];
	    	}
	        
	    }else{
	    	$j[]=[
                "username"=>'0',
                "email"=>'0',
                "userId"=>'0'
            ];
	    }
	    return($j[0]);
	}

	public function checkRefereeLevel($username,$level){
		$slt = "SELECT * FROM reefer_history WHERE username=:username AND referee_level=:referee_level";
		$referee = $this->conn()->prepare($slt);
		$referee->bindParam(':username',$username);
		$referee->bindParam(':referee_level',$level);
	    $j = [];
	    if($referee->execute()){

	    	if($newData = $referee->fetch(PDO::FETCH_ASSOC)){
	    		// code...
	    		 $j[]=[
	                "username"=>$newData["username"],
	                "referee"=> $newData["referee_name"],
	                "referee_level"=>$newData["referee_level"],
	                "Cost"=>$newData['Cost']
	            ];

	    	}else{
	    		$j[]=[
	                "username"=>'0',
	                "email"=>'0',
	                "userId"=>'0'
	            ];
	    	}
	        
	    }else{
	    	$j[]=[
                "username"=>'0',
                "email"=>'0',
                "userId"=>'0'
            ];
	    }
	    return($j[0]);
	}

	public function saveCompanyLink($Reefer,$name,$totalcost){

		$message =[];
		if($this->addReferee($name,$Reefer,'super',$totalcost)){
			$refereeId = $this->GetData($Reefer)['userId'];
			if($this->addPrivatewallet($refereeId,$totalcost)){

				if($this->RecordTransaction($Reefer,'Affiliate',$name.'_hela_refer',$totalcost,'success')){
					$message = ["errorCode"=>200,'error'=>'Company bonus added'];
				}else{
					$message = ["errorCode"=>201,'error'=>'Company bonus added but transaction not recorded'];
				}
				
			}
			
		}else{
			$message = ["errorCode"=>201,'error'=>'Company bonus not added'];
		}
		return $message;

	}

	public function saveUserLink($Reefer,$name,$totalcost){
		// assign some bits to the reefere
		$company = "";
		$initialAmount = $totalcost;
		$superBit = $totalcost-200;
		$level_1_company = 200;
		$level_1_user = 100;
		$level_2_company = 100;
		$level_2_user = 50;
		$level_3_comp = 50;
		$message =[];
		// $refereeId = $this->GetData($Reefer)['userId'];
		try {
			if($superBit == 300 AND $totalcost == 500){
				// check the super for reefer to give them some bits
				if($this->addReferee($name,$Reefer,'super',$superBit)){
					// now check  the super for ther referee if its ReeferInc getd 200 and if its aa user they get 100
					$superFirstId = $this->GetData($Reefer)['userId'];
					if($this->addPrivatewallet($superFirstId,$superBit)){

						if($this->RecordTransaction($Reefer,'Affiliate',$name.'_hela_refer',$superBit,'success')){
							$message = [
								'errorCode'=>200,
								'message'=>'affiliate bonus added'
							];
						}else{
							$message = [
								'errorCode'=>201,
								'message'=>'affiliate bonus added but transaction not recorded'
							];
						}
						
					}
					// add to super wallet 

					$refereeSuper = $this->checkRefereeLevel($Reefer,'super');
					$reSuper = $refereeSuper['referee'];

					if($refereeSuper['referee'] == 'reeferinc'){
						// save the company bit to 200 and lebeled as  level 1 for the company 
						if($this->addReferee($name,'reeferinc','level 1',$level_1_company)){

							$compId = $this->GetData('reeferinc')['userId'];

							if($this->addPrivatewallet($compId,$level_1_company)){

								if($this->RecordTransaction($compId,'Affiliate',$name.'_hela_refer',$level_1_company,'success')){
									$message = [
										'errorCode'=>200,
										'message'=>'Company bonus added'
									];
								}else{
									$message = [
										'errorCode'=>201,
										'message'=>'Company bonus added but transaction not recorded'
									];
								}
								
							}

						}else{
							$message =[
				 				'errorCoded'=>201,
				 				'message'=>'Super and Company bonus added'
				 			];
						}
						
					}else{
						// now check the super of the referee
						if($this->addReferee($name,$reSuper,'level 1',$level_1_user)){

							$reSuperId = $this->GetData($reSuper)['userId'];
							if($this->addPrivatewallet($reSuperId,$level_1_user)){

								if($this->RecordTransaction($reSuper,'Affiliate',$name.'_hela_refer',$level_1_user,'success')){
									
									$message = [
										'errorCode'=>200,
										'message'=>'affiliate bonus added'
									];

								}else{

									$message = [
										'errorCode'=>201,
										'message'=>'affiliate bonus added but transaction not recorded'
									];

								}
								
							}

							$reresuper = $this->checkRefereeLevel($reSuper,'super');
							if($reresuper['referee'] == 'reeferinc'){

								if($this->addReferee($name,'reeferinc','level 2',$level_2_company)){

									$compId = $this->GetData('reeferinc')['userId'];
									if($this->addPrivatewallet($compId,$level_2_company)){

										if($this->RecordTransaction($compId,'Affiliate',$name.'_hela_refer',$level_2_company,'success')){
											
											$message = [
												'errorCode'=>200,
												'message'=>'affiliate bonus added'
											];

										}else{

											$message = [
												'errorCode'=>201,
												'message'=>'affiliate bonus added but transaction not recorded'
											];

										}
										
									}
									
								}else{
									$message =[
					 					'errorCode'=>201,
					 					'message'=>'super, level 1 and level 2 bonus not added'
					 				];
								}
								//save the 100 to the previous referee and company  as level 1 for the user and level 2 for the company

							}else{
								// give the 100 to the previous referee as level_1_user then check their referee give the 50 as level_2_user  and remaining 50 to the company as level 3 
								$level2refer = $reresuper['referee'];
								
								if($this->addReferee($name,$level2refer,'level 2',$level_2_user)){

								 	$level2referId = $this->GetData($level2refer)['userId'];
							
									if($this->addPrivatewallet($level2referId,$level_2_user)){

										if($this->RecordTransaction($level2refer,'Affiliate',$name.'_hela_refer',$level_2_user,'success')){
											$message = [
												'errorCode'=>200,
												'message'=>'affiliate bonus added'
											];
										}else{
											$message = [
												'errorCode'=>201,
												'message'=>'affiliate bonus added but transaction not recorded'
											];
										}
										
									}

							 		if($this->addReferee($name,'reeferinc','level 3',$level_3_comp)){

										$compFirstId = $this->GetData('reeferinc')['userId'];
										if($this->addPrivatewallet($compFirstId,$level_3_comp)){
					
											if($this->RecordTransaction($compFirstId,'Affiliate',$name.'_hela_refer',$level_3_comp,'success')){
												$message = [
													'errorCode'=>200,
													'message'=>'affiliate bonus added'
												];
											}else{
												$message = [
													'errorCode'=>201,
													'message'=>'affiliate bonus added but transaction not recorded'
												];
											}
											
										}

							 		}else{
							 			$message =[
						 					'errorCode'=>201,
						 					'message'=>'super, level 1, level 2  and level 3 bonus not added'
						 				];
							 		}	

								}else{
									$message =[
						 				'errorCode'=>201,
						 				'message'=>'super, level 1 and level 2 bonus not added'
						 			];
								}
							}
						}else{

						}
					}

				}

			}
		} catch (Exception $e) {
			$message = [
				'errorCode'=>201,
				'error'=>$e->getMessage()
			];
		}
		return $message;
		

	}

	public function addHelaReefer($Reefer,$name,$totalcost){

		$company = strtolower('ReeferInc');
		$message =[];
		$Reefers = $this->checkReferee($name);
		if($Reefer == $company){
			
			if(strlen($Reefers['username'])  > 4 ){

				$message = [
					'errorCode'=>201,
					'message'=>'user exists'
				];

			}else{

				$message = $this->saveCompanyLink($Reefer,$name,$totalcost);

			}

		}else{
			if(strlen($Reefers['username'])  > 4 ){
				$message = [
					'errorCode'=>201,
					'message'=>'user exists'
				];

			}else{
				return $this->saveUserLink($Reefer,$name,$totalcost);
			}
		}

		return $message;

	}

	public function getVerify($number){

        $message =[];
        $isPayed = $this->verifyPayment($number);
        if($isPayed == true){

           $userData = $this->GetData($number);
           $payeeUsername = $userData['username'];
           $refereeId = $userData['referee'];
           $refereeData = $this->GetData($refereeId);
           $refereeUsername = $refereeData['username'];

		   $reefered = $this->addHelaReefer($refereeUsername,$payeeUsername,500);
		   $message = [
		   	'error'=>200,
		   	'reeferId'=>$refereeData['userId']
		   ];
           
        }else{
            $message = [
                
                'error'=>'301',
                'message'=>'Error while confirming your payment please contact us via call +254782428669 to confirm your payment in the systeme'
            ];
        }
        return $message;

    }
	// either to withdraw or to deposite
	public function culculate($type,$balance,$amount){
		switch ($type) {
			case 'add':
					$account = $balance + $amount;
					return $account;
				break;
			case 'remove':
					if($balance >= $amount){
						$account = $balance - $amount;
						return $account;
					}else{
						return false;
					}
					
				break;
			default:
					return $balance;
				break;
		}
	}
	// fetches the balance in a wallet checks if wallet user exists
	public function checkUserWalletExist($variable){
		if($this->conn()){
			$query = "SELECT * FROM actua_wallet WHERE random_id=:random_id";
			$wallet = $this->conn()->prepare($query);
			$wallet->bindParam(':random_id',$variable);
			$wallet->execute();
			if($dataFetch = $wallet->fetch(PDO::FETCH_ASSOC)){
				return true;
			}else{
				return false;	
			}
		}
	}

	// fetches the balance in a wallet
	public function fetchWalletBalance($varible){
		if($this->conn()){
			$query = "SELECT * FROM actua_wallet WHERE random_id=:random_id LIMIT 1";
			$wallet = $this->conn()->prepare($query);
			$wallet->bindParam(':random_id',$varible);
			
			$j=[];
			if($wallet->execute()){
				if($dataFetch = $wallet->fetch(PDO::FETCH_ASSOC)){
					$j=[
						'balance'=>$dataFetch['amount'],
					];
				}else{
					$j=[
						'balance'=>'0',
					];
				}
			}else{
				$j=[
					'balance'=>'0',
				];
			}
			
			return $j;
		}
	}

	// adds funds to the wallet and also check if actual wallet exits it updates a wallet instead of creating a new one;
	public function addPrivatewallet($random_id,$amount){
		$timeNow = Carbon::now(new DateTimeZone('Africa/Nairobi'));
        $strTime = strtotime($timeNow);
		$message = [];

		if($this->checkUserWalletExist($random_id)){
			$balance = $this->fetchWalletBalance($random_id)['balance'];
			$updateBalance = $this->culculate('add',$balance,$amount);
			$response = $this->updateWallet($random_id,$updateBalance,$strTime);
			if($response['errorCode'] == 200){
				return true;
			};
		}else{
			if($this->conn()){
				$wallet = $this->conn()->prepare('INSERT INTO actua_wallet VALUES (null,:random_id,:amount,:wallet_update_date,:walllet_date_created	)');

		        $wallet->bindParam(':random_id',$random_id);
		        $wallet->bindParam(':amount',$amount);
		        $wallet->bindParam(':wallet_update_date',$strTime);
		        $wallet->bindParam(':walllet_date_created',$strTime);
		        
		        if($wallet->execute()){
		        	$message[]=[
	                	"errorCode"=>'200',
	                	"message"=> '$amount was loaded successfullys'
	            	];
		        }else{
		        	$message[]=[
	                	"errorCode"=>'500',
	                	"message"=> 'Error Loading wallet'
	            	];
		        }
			}else{
				$message[]=[
	                	"errorCode"=>'500',
	                	"message"=> 'Error Loading wallet'
	            ];
			}
		}
		return $message;
		
	}
// updates the wallet
	public function updateWallet($random_id,$amount,$wallet_update_date){
		$message =[];
		if($this->conn()){
			$wallet = $this->conn()->prepare('UPDATE actua_wallet SET amount=:amount,wallet_update_date=:wallet_update_date WHERE random_id=:random_id');
			$wallet->bindParam(':random_id',$random_id);
		    $wallet->bindParam(':amount',$amount);
		    $wallet->bindParam(':wallet_update_date',$wallet_update_date);
		    if($wallet->execute()){
	        	$message[]=[
                	"errorCode"=>'200',
                	"message"=> $amount.' was updated successfully'
            	];
	        }else{
	        	$message[]=[
                	"errorCode"=>'500',
                	"message"=> 'Error updating wallet'
            	];
	        }
		}
		return $message[0];
	}
	public function checknotverified($username){
		if($this->conn()){
			$query = "SELECT * FROM create_account WHERE ax_username=:username AND ax_create_account_complete=0";
			$userVerified = $this->conn()->prepare($query);
			$userVerified->bindParam(':username',$username);
			$userVerified->execute();
			if($dataFetch = $userVerified->fetch(PDO::FETCH_ASSOC)){
				return true;
			}else{
				return false;	
			}
		}
	}
	public function getUsernamebyId($userid){
		$slt = "SELECT * FROM create_account WHERE random_user_id=:userid";
		$user = $this->conn()->prepare($slt);
		$user->bindParam(':userid',$userid);
	    $j = [];
	    if($user->execute()){

	    	if($newData = $user->fetch(PDO::FETCH_ASSOC)){
	    		// code...
	    		 $j[]=[
	                "username"=>$newData["ax_username"],
	            ];

	    	}else{
	    		$j[]=[
	                "username"=>'0',
	            ];
	    	}
	        
	    }else{
	    	$j[]=[
                "username"=>'0',
            ];
	    }
	    return($j[0]);
	}
	public function verifyUser($username){
		$message =[];
		if($this->conn()){
			$verify = $this->conn()->prepare('UPDATE create_account SET ax_create_account_complete=2 WHERE ax_username=:username');
			$verify->bindParam(':username',$username);
		    if($verify->execute()){
	        	$message[]=[
                	"errorCode"=>'200',
                	"message"=>'verification complete'
            	];
	        }else{
	        	$message[]=[
                	"errorCode"=>'500',
                	"message"=> 'verification not completet'
            	];
	        }
		}
		return $message[0];
	}
	public function addTopay_for_client($payerId,$payeeName,$amount){
		$message =[];
		if($this->conn()){
			$timeNow = Carbon::now(new DateTimeZone('Africa/Nairobi'));
        	$strTime = strtotime($timeNow);
			$addpayment = $this->conn()->prepare('INSERT INTO pay_for_client VALUES(null,:username,:payee_id,:amount,:datepayed)');
			$addpayment->bindParam(':username',$payeeName);
			$addpayment->bindParam(':payee_id',$payerId);
			$addpayment->bindParam(':amount',$amount);
			$addpayment->bindParam(':datepayed',$strTime);
		    if($addpayment->execute()){
				$this->RecordTransaction($payerId,'pay_for_client',$payeeName.'_paid_for_refer',500,'success');
	        	$message[]=[
                	"errorCode"=>200,
                	"message"=>'payment done'
            	];
	        }else{
	        	$message[]=[
                	"errorCode"=>500,
                	"message"=> 'payment not done'
            	];
	        }
		}
		return $message[0];
	}

	public function checkIfverified($phonenumber){

		if($this->conn()){
			$query = "SELECT * FROM create_account WHERE phone=:phone AND ax_create_account_complete=2";
			$userVerified = $this->conn()->prepare($query);
			$userVerified->bindParam(':phone',$phonenumber);
			$userVerified->execute();
			if($dataFetch = $userVerified->fetch(PDO::FETCH_ASSOC)){
				return true;
			}else{
				return false;	
			}
		}

	}
}
// $newReefer = new Reefer();
// $newReefer->addHelaReefer('leemoses','leahatieno',500);
?>