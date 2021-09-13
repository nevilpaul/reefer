<?php


/**
 *
 */
class Config
{
  private $ConsumerKey = 'a6mC6pQknfeNzOfpA40DCMryKe6G3rus';
  private $ConsumerSecret = 'iUma4Cpy6bifNAvC';
  public $headers = ["Content-Type:application/json;charset=utf8"];
  public $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

  function __construct()
  {
    // code...
    $this->curl = curl_init();
  }

  public function Curl(){

    curl_setopt($this->curl, CURLOPT_URL, $this->url);
    curl_setopt($this->curl, CURLOPT_URL, $this->url);
    curl_setopt($this->curl, CURLOPT_HTTPHEADER,$this->headers);
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->curl, CURLOPT_HEADER,false);
    // send credentials to get access token
    curl_setopt($this->curl, CURLOPT_USERPWD, $this->ConsumerKey.':'.$this->ConsumerSecret);
    curl_setopt($this->curl,CURLOPT_SSL_VERIFYPEER,false);
    return $result = curl_exec($this->curl);
  }
  public function DecodedToken(){
    $token = $this->Curl();
    $result = json_decode($token);
    return $result->access_token ;
    curl_close($this->curl);
  }
}

?>
