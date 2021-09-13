<?php
$main_pager = 'fetchLogins.php';
require_once($main_pager);

/**
 *
 */
class time extends GetUserLogs
{

	public function TimeZones(){
		$dateString = date_default_timezone_set('Africa/Nairobi');
		$time = time();
		echo date('h:i:sa',$time);
		$timeZones = timezone_identifiers_list();
		// while(list($key,$name) = each($timeZones)){
		// 	echo $key ." ".$name.'<br>';
		// }
		//

	}
}

$time = new time();
$time->TimeZones();
?>
