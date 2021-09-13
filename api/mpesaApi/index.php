<?php

$stringsearch = 'pc video games 2016';
$url = "https://www.amazon.com/s/field-keywords=$stringsearch";
$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
echo $result;
curl_close($curl);
?>