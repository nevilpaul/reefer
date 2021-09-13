<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");

$main_pager = 'fetchLogins.php';
require_once($main_pager);

class imageUpload extends GetUserLogs
{
	
	function __construct($username,$originalImge,$cropedImage)
	{
		# code...
		$this->username = $username;
		$this->originalImge = $originalImge;
		$this->cropedImage = $cropedImage;
	}
	public function baseToImage($basename){
		list($data,$base64Image) = explode(";base64,",$image);
    	return $Convert = base64_decode($base64Image);
	}
	public function Original(){
		
		$image = $this->originalImge;

		list($data,$base64Image) = explode(";base64,",$image);
    	$Convert = base64_decode($base64Image);
		// directory for image upload
		$DI = DIRECTORY_SEPARATOR;
		$directory = str_replace("Api".DIRECTORY_SEPARATOR."createaccount", '', __DIR__)."public".$DI."imageUpload".$DI."avartar".$DI;
	    $time = time();
	    $randomImageName = md5($time);
	    $image = $directory.$randomImageName.uniqid().".png";

	    // $origal_image = file_put_contents($image,$Convert);
	    $direct = __DIR__.DIRECTORY_SEPARATOR."public".$DI."imageUpload".$DI."avartar".$DI;;
		$direct = str_replace("Api".DIRECTORY_SEPARATOR."createaccount".DIRECTORY_SEPARATOR, '', $direct);
		# code...
		list($dirsep,$originalImageLink) = explode( $direct,$image);
	    return $ori = [
	    	"origal_image"=>$image,
	    	"image_name"=>$originalImageLink,
	    	"convert"=>$Convert
	    ];
	    // move_uploaded_file($origal_image);
	}
	public function CropedImg(){
		$image = $this->cropedImage;

		list($data,$base64Image) = explode(";base64,",$image);
    	$Convert = base64_decode($base64Image);
		// directory for image upload
		$DI = DIRECTORY_SEPARATOR;
		$directory = str_replace("Api".DIRECTORY_SEPARATOR."createaccount", '', __DIR__)."public".$DI."imageUpload".$DI."avartar".$DI."profile".$DI;
		// directory separator
		
		//image directery upload.
		//."assets".$DI."imageUpload".$DI."avartar".$DI;
		 //generate image name
	    $time = time();
	    $randomImageName = md5($time);
	    $image = $directory.$randomImageName.uniqid().".png";
	    // $cropped_image = file_put_contents($image,$Convert);
	    $direct = __DIR__.DIRECTORY_SEPARATOR."public".$DI."imageUpload".$DI."avartar".$DI."profile".$DI;
		$direct = str_replace("Api".DIRECTORY_SEPARATOR."createaccount".DIRECTORY_SEPARATOR, '', $direct);

		# code...
		list($dirsep,$originalImageLink) = explode($direct,$image);
		$ori = [
	    	"origal_image"=>$image,
	    	"image_name"=>$originalImageLink,
	    	"convert"=>$Convert
	    ];
	    return $ori;
	}
	public function upload(){
		$userdata = $this->getData($this->username);
		$userId = $userdata['Applxe_id'];
		$timestamp = $this->timeStampdata();
		$message = [];
		$original = $this->Original();
		$crop = $this->CropedImg();
		// images

		$originalIm = $original['origal_image'];
		$cropIm = $crop['origal_image'];
		// images link
		$originalI = "/imageUpload/avartar/".$original['image_name'];
		$cropI = "/imageUpload/avartar/profile/".$crop['image_name'];
		// cover to convert
		$convert_original = $original['convert'];
		$convert_crop = $crop['convert'];
		
		if(!empty($this->username) and !empty($this->originalImge) and !empty($this->cropedImage)){
			$insert = "INSERT INTO avarter(user_id,username,image_no_crop,cropped_image,date_uploaded)VALUES('$userId','$this->username','$originalI','$cropI','$timestamp')";
			$query = $this->conn()->exec($insert);
			if($query){
				$origal_image = file_put_contents($originalIm,$convert_original);
				$cropped_image = file_put_contents($cropIm,$convert_crop);
				move_uploaded_file($origal_image);
				move_uploaded_file($cropped_image);
				$message = [
					"message"=>'Applxe message image uploaded successfuly',
					"error"=>0
				];
			}else{
				$message = [
					"message"=>'Applxe error please try uploading the image again',
					"error"=>1
				];
			}
		}else{
			$message = [
				"message"=>'Applxe error please try uploading the image again later',
				"error"=>1
			];
		}
		echo json_encode($message);
		// $this->Original();
		// $this->CropedImg();
	}
}
$username = $_POST['username'];
$originalImge =  $_POST['original'];
$cropedImage =  $_POST['croped'];
$imageUpload = new imageUpload($username,$originalImge,$cropedImage);
$imageUpload->upload();