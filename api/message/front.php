<?php
use Rooms\Room as Rooms;
use Twilio\TwiML\Video\Room;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");
include "room.php";
$userId = $_REQUEST['userId'];
$roomId = $_REQUEST['roomId'];

$room = new Rooms();

echo($room->countNewMessages($roomId,$userId)) ;

?>
