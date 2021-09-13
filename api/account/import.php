<?php
// error_reporting(0);
function Import($file){
    try {
        //code...
        require ($file);
    } catch (\Throwable $th) {
        //throw $th;
        $message =[
            'errorMessage'=>'File not found : '.$th->getMessage()
        ];
        print_r($message);
    }
}
?>