<?php
/**
 *
 */
class appTime
{
	public function timeConversion(){
        $user_ip = getenv('REMOTE_ADDR');
        //GpaymentET pugin url
        $geoplugin = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?$user_ip"));
        // echo $geoplugin['geoplugin_countryName'].' '.$geoplugin['geoplugin_countryCode'] .'<br>';

        $date = getdate();
				$time = $geoplugin['geoplugin_countryName'];
				$time;
        // switch ($geoplugin['geoplugin_countryName']) {
        //     case 'kenya':
        //         # code...
        //         date_default_timezone_set("Africa/Nairobi");
        //         $date = getdate();
        //         return $date;
        //     break;
				//
        //     default:
        //         # code...
        //             return $date;
        //         break;
        // }
	}
    public function timeStampdata(){
        return $this->timeConversion()['0'];
    }
}


?>
