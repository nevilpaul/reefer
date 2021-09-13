
<?php

  require 'config.php';
  $curl = new Config();
  $token = $curl->DecodedToken();
  // echo $token;
  $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token)); //setting custom header


  $curl_post_data = array(
   //Fill in the request parameters with valid values
   'ShortCode' => '600610',
   'ResponseType' => 'Confirmed',
   'ConfirmationURL' => 'https://footers.xyz/curl/confirmation.php',
   'ValidationURL' => 'https://footers.xyz/curl/validation.php'
  );

  $data_string = json_encode($curl_post_data);

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

  $curl_response = curl_exec($curl);
  print_r($curl_response);

  echo $curl_response;
 ?>
