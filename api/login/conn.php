<?php
class Conn
{   
    protected function connect(){
        try{
            // $conn = new PDO("mysql:host=54.36.164.223;dbname=footersx_reefer","footersx","h82Le;GtDb7N2.");
            $conn = new PDO("mysql:host=localhost;dbname=reefer","root","");
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return  $conn;
        }catch(PDOEXCEPTION $Error){
            return $Error->getMessage();
        }
    }
}

?>