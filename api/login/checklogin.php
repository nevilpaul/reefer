<?php
error_reporting(0);
$main_pager ='conn.php';
$header ='headers.php';
include($header);
class checkLoggedIn{
  public function checkActivity(){
    $message = [];
    if(isset($_COOKIE['__UserApplxe'])){
      $cookie = $_COOKIE['__UserApplxe'];
      $message = [
        'loggedIn'=>1,
        'message'=>$cookie
      ];

    }else{
      $message = [
        'loggedIn'=>0,
        'message'=>$cookie
      ];
    }
    $message = json_encode($message);
    echo $message;
  }
  public function GetSimpledata(){
    echo '';
  }
}

$val = new checkLoggedIn();
$val->checkActivity();
?>
