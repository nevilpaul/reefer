<?php
/**
 * 
 */
class Conn 
{
	
	protected function conn(){
        try{
            $conn = new PDO("mysql:host=localhost;dbname=reefer","root","");
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
            return  $conn;

        }catch(PDOEXCEPTION $Error){
            return $Error->getMessage();
        }
    }
}
?>