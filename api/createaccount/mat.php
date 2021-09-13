<?php

header("Access-Control-Allow-Origin:*");
header("Content-type:application/json");
error_reporting();
$main_pager = __DIR__ . DIRECTORY_SEPARATOR . ('fetchLogins.php');
$newUri = str_replace("\connector","", $main_pager);

require_once($newUri);

$action = new GetUserLogs();
$randomId = strip_tags($_REQUEST['token']);
echo $action->getUserId($randomId);
?>