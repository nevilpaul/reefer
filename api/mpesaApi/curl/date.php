<?php
require '../vendor/autoload.php';

use Carbon\Carbon;
$timeNow = Carbon::now(new DateTimeZone('Africa/Nairobi'))->toDateTimeString();
$newdate = date("YmdGis",strtotime($timeNow));
printf($newdate);

?>
