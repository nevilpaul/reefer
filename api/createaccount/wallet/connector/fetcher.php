<?php

$main_pager = ('connector.php');
require ($main_pager);

class Fetcher extends Connector 
{
    public function getData(){
        try{
            $fetch = $this->conn()->prepare("SELECT * FROM nav");
            $fetch->execute();

            $j=[];
            $i = 0;

            while($fetcher = $fetch->fetch(PDO::FETCH_ASSOC)){
                $j[] =[
                    "nav_id"=>$fetcher["nav_id"],
                    "name"=>$fetcher["name"],
                    "url"=>$fetcher["url"]
                ];
                $i++;

                
            }
            header("Access-Control-Allow-Origin:*");
            header("Content-type:application/json");

            echo json_encode($j);
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
}
?>