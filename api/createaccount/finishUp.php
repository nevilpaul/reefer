<?php
error_reporting(1);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");
$main_pager = __DIR__ . DIRECTORY_SEPARATOR . ('fetchLogins.php');
require_once($main_pager);

/**
 * s
 */
class imageUpload extends GetUserLogs
{
	
	function __construct($name)
	{
		# code...
		$this->name = $name;
	}
	function DisplayFinal(){
		$user = $this->GetData($this->name);
		$username = $user['username'];
		$idUser = $user['Applxe_id'];
		$dpData = [];
		$query = "SELECT * FROM avarter WHERE user_id='$idUser' ORDER BY avartar_id DESC LIMIT 1";
        $res = $this->conn()->prepare($query);
        $res->execute();
        if($newData = $res->fetch(PDO::FETCH_ASSOC)){
        	$dpData = [
        		'avartar_id'=>$newData['avartar_id'],
        		'user_id'=>$newData['user_id'],
        		'username'=>$newData['username'],
        		'image_no_crop'=>$newData['image_no_crop'],
        		'cropped_image'=>$newData['cropped_image'],
        		'date_uploaded'=>$newData['date_uploaded']
        	];
        }else{
        	$dpData = [
        		"error"=>"please create an acount"
        	];
        }
        echo json_encode($dpData);

	}
}
$name = ucfirst($_GET['userName']);
$uploader = new imageUpload($name);
$uploader->DisplayFinal();
?>