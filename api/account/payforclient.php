<?php
use ApplxeJwt\Jwtoken as jt;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");
include 'import.php';
include '../connector/connector.php';
Import('../login/AuthO/define.php');
Import('../login/AuthO/token.php');
class Payforclient extends Connector {
    public function pay($username){

    }

    public function SearchClient($username,$userId){
        $name = "%$username%";
        $query = 'SELECT  ROW_NUMBER() OVER(ORDER BY ax_id DESC) AS userId,ax_username FROM create_account WHERE ax_username LIKE :username and referee=:refereId and ax_create_account_complete=0';
        $res = $this->conn()->prepare($query);

        $res->bindParam(':username',$name);
        $res->bindParam(':refereId',$userId);
        $dataResult=[];
        if($res->execute()){

            while($dataFetch = $res->fetch(PDO::FETCH_ASSOC)){
                
                $dataResult[] =[
                    'userID'=>$dataFetch['userId'],
                    'username'=>$dataFetch['ax_username']

                ];

            }

        }else{

            $dataResult = [
                'error'=>200
            ];

        }
        echo json_encode($dataResult);
    }
}

$username = $_REQUEST['username'];
$userId = $_REQUEST['userId'];
$username = strtolower($username);
$username = strip_tags($username);
$userId  = strip_tags($userId );
$Dashboard =new Payforclient();
$Dashboard->SearchClient($username,$userId);
?>