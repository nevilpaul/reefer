<?php
// error_reporting(0);
use Rooms\Room as Rooms;

require 'room.php';

$inc = rand(time(),time()*4);

$roomRand = password_hash($inc,PASSWORD_DEFAULT);
$roomName = $_REQUEST['roomName'];
$userId = $_REQUEST['userId'];
// echo $roomRand;
$rooms = new Rooms;
$rooms->setRoomname($roomName);
$rooms->setuserId($userId);
$rooms->setRoomstatus(1);
$rooms->setRoomEncryptname($roomRand);
$rooms->setDatecreated(1589840091);
$rooms->setDateupdated(1589840091);
$message =[];

    //code...
    if($rooms->checkRoomExists('retails') === true){
        $message = [
            'action'=>'401',
            'message'=>'Room exits',
        ];
    }else{

        if($rooms->CreateRoom()){

          if($rooms->addUserRoom($roomName)){
            $message = [
                'action'=>'202',
                'message'=>'Room created successfully and admin added',
            ];
            
          }else{
            $message = [
                'action'=>'401',
                'message'=>'Room not created successfully',
            ];
          }


        }else{

            $message = [
                'action'=>'error',
                'message'=>'Room not created since it exits',
            ];

        }
    }

$roomMessage = json_encode($message);

echo $roomMessage;
?>
