<?php
use Rooms\Room as Rooms;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-type:application/json");

require 'room.php';

$rooms = new Rooms();
$randomId = strip_tags($_REQUEST['token']);
$userId = $rooms->UserId($randomId);
$loadMsg = $rooms->getRooms($userId);
// echo json_encode($loadMsg);

// function cmp($a, $b)
// {
//     return (float) $a['message_id'] < (float)$b['message_id'];
// }
// @uasort($loadMsg, "cmp");


echo json_decode($loadMsg);
?>