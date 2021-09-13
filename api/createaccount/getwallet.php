<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");

include 'reefer.php';

class GetWallet extends Reefer {
	
	public function wallet($variable){
		$message = [];
		if($this->checkUserWalletExist($variable)){
			$value = $this->fetchWalletBalance($variable);
			if(strlen($value['balance']) > 0){
				$message = [
					'balance'=>number_format($value['balance'])
				];
			}else{
				$message = [
					'balance'=>0
				];
			}
			
		}
		echo json_encode($message);
		// echo $variable;
	}

}
$randomId = $_REQUEST['randomId'];
$randomId = strip_tags($randomId);
//get wallet balance
$getwallet = new GetWallet();
$getwallet->wallet($randomId);

?>