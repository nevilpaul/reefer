<?php

use Rooms\Room as Rooms;
require 'room.php';

$rooms = new Rooms();
$roomId = htmlentities($_REQUEST['roomId']);
$userId = htmlentities($_REQUEST['userId']);
$message = htmlentities($_REQUEST['message']);

$rooms->saveMessage($roomId,$userId,$message);

?>