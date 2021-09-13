<?php
namespace ApplxeJwt;
$Dir = "../vendor/autoload.php" ;
require $Dir;
use \Firebase\JWT\JWT;
/**
 *encrypt userInformation
 */
class Jwtoken
{

  public static function getEnc($arrayData,$key ){
    $token = $arrayData;
    $retVal = "";
    try {
      $jwt = JWT::encode($token, $key, 'RS256');
      return print_r($jwt, true);
    } catch (Exception $e) {
      echo $e->getMessage();
    }

  }

  public static function getDec($arrayData,$key ){
    return $decoded = JWT::decode($arrayData, $key, array('RS256'));
    // $decoded_array = (array) $decoded;
    // echo "Decode:\n" . print_r($decoded_array, true) . "\n";
  }

}
?>
