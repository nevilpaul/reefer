<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");
include 'import.php';
Import('index.php');

class Dashboard extends Account{  
    // get total Transaction Cash Refferals earnings and save them in an object
    public function TopstatsObjects($token){
        $decData = $this->decrype($token);
        $userID = $decData['token'];
        $username = $decData['username'];
        $verify = $this->verifyBeforeFetch($userID,$username);
        if($verify){
            // return user transaction total amount
            // Number of Refferals
            $allReferals = $this->fetchAllreferals($userID);
            // Active accounts
            $ActiveReferCount =  $this->ActiveReferals($userID);
            //Total Transaction
            $totalTransaction = $this->getTotaltransaction($userID);
            // Cash Refferals
            $amountEarnedRefer = $this->getReferedTotal($username);
            // wallet amount and expected earning
            $wallet = $this->getWalletData($userID);

            $message = [

                'allReferals'=>$allReferals,
                'activeRefer'=>$ActiveReferCount,
                'ReeferEarnings'=>$amountEarnedRefer,
                'totalTransaction'=>$totalTransaction,
                'wallet'=>$wallet 
                
            ];
            echo json_encode($message);
        }
        
    }
}
$token = $_GET['token'];
$token = strip_tags($token);
$Dashboard =new Dashboard();
$Dashboard->TopstatsObjects($token);

?>