<?php

use Rooms\Room as Rooms;

require 'room.php';

$rooms = new Rooms;

$userId = $_REQUEST['userId'];
$roomName = $_REQUEST['roomName'];

$rooms->setRoomname($roomName);
$rooms->setuserId($userId);
$rooms->setRoomstatus(1);
$message = [];


if($rooms->checkJoin_member($userId,$roomName)){
    $message = [
        'Error'=>401,
        'message' =>'Error user exists in the room'
    ];
}else{
    
    if($rooms->addUserRoom($roomName)){
        $message = [
            'action'=>'202',
            'message'=>'joined room',
        ];
    }else{
        $message = [
            'action'=>'401',
            'message'=>'Not join room',
        ];
    }
}
echo json_encode($message);
?>
