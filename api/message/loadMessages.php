<?php

use Rooms\Room as Rooms;
require 'room.php';

$rooms = new Rooms();
$roomId = strip_tags($_REQUEST['roomId']);
$rooms->loadMessages($roomId);

?>