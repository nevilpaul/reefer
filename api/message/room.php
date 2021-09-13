<?php
namespace Rooms;

use Twilio\TwiML\Voice\Echo_;

// error_reporting(0);
session_start();
chdir('.');
$sep = DIRECTORY_SEPARATOR;
$dir = getcwd().$sep.'connector'.$sep.'connector.php';
//check if dir exist on a link.

if(strpos($dir,'message') !== false){

    $dir = str_replace('\message','',$dir);
}else{
    $dir = $dir;
}
require $dir;


class Room extends \Connector
{
    private $userId;
    private $roomname;
    private $Roomstatus;
    private $Datecreated;
    private $Dateupdated;
    private $roomEncryptname;
    protected $dbconnect;

    function setuserId($userId){$this->userId = $userId;}
    function setRoomname($roomname){$this->roomname = $roomname;}
    function setRoomstatus($Roomstatus){$this->Roomstatus = $Roomstatus;}
    function setDatecreated($Datecreated){$this->Datecreated = $Datecreated;}
    function setDateupdated($Dateupdated){$this->Dateupdated = $Dateupdated;}
    function setRoomEncryptname($roomEncryptname){$this->roomEncryptname = $roomEncryptname;}

    // get values
    function getuserId(){return $this->userId;}
    function getRoomname(){return $this->roomname;}
    function getRoomstatus(){return $this->Roomstatus;}
    function getDatecreated(){return $this->Datecreated;}
    function getDateupdated(){return $this->Dateupdated;}
    function getRoomEncryptname(){return $this->roomEncryptname;}

    public function __construct()
    {

        $this->dbconnect = $this->conn();

    }
    // main function to create a room
    public function CreateRoom(){
        $roomData = $this->dbconnect->prepare('INSERT INTO rooms VALUES (null,:roomName,:admin_id,:roomStatus,:roomEncryptname,:dateupdated,:datecreated)');
        $roomData->bindParam(':roomName',$this->roomname);
        $roomData->bindParam(':admin_id',$this->userId);
        $roomData->bindParam(':roomStatus',$this->Roomstatus);
        $roomData->bindParam(':roomEncryptname',$this->roomEncryptname);
        $roomData->bindParam(':dateupdated',$this->Datecreated);
        $roomData->bindParam(':datecreated',$this->Dateupdated);
        $message =[];
        // echo $this->userId.' '.$this->roomname.' '.$this->Roomstatus.' '.$this->roomEncryptname.' '.$this->Datecreated.' '.$this->Dateupdated;
        if($roomData->execute()){
            $message = [
                'action'=>'error',
                'message'=>'Room added ',
            ];

            return $message;
        }else{
            $message = [
                'action'=>'error',
                'message'=>'Room not added ',
            ];

            return $message;
        }
    }
    // update rooms status and date updates
    public function UpdateRoom(){
        $roomUpdate = $this->dbconnect->prepare("UPDATE rooms SET :roomStatus,:dateupdated WHERE :roomname === {$this->roomname}");
        $roomUpdate->bindParam(':roomStatus',$this->Roomstatus);
        $roomUpdate->bindParam(':roomStatus',$this->Dateupdated);

        try {
            //code...
            if($roomUpdate->execute()){
                $message = [
                    'action'=>'error',
                    'message'=>'Room updated',
                ];
                return $message;
            }
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }

    }

    public function checkRoomExists($room){
        $alert =[];
        $roomData = $this->dbconnect->prepare("SELECT * FROM rooms WHERE roomname='$room'"  );
        $roomData->execute();
        $fetch_very = $roomData->fetch(\PDO::FETCH_ASSOC);
        //code...

        $fetch_very['roomName'] ??='default value';

        if($room === $fetch_very['roomName'] ){
            return true;
        }
        else{
            return false;
        }

    }


    // add any user to a particular room..
    public function addUserRoom($roomName){

        $fetchRoomDetail = $this->dbconnect->prepare("SELECT * FROM rooms WHERE roomname='$roomName'");
        $fetchRoomDetail->execute();
        if(!empty($fetch_very = $fetchRoomDetail->fetch(\PDO::FETCH_ASSOC))){
          $roomId = $fetch_very['roomId'];
          $roomname = $fetch_very['roomName'];
          $roomEncryptname = $fetch_very['roomEncryptname'];
          $previllage = 0;
          if(!empty($roomId) and !empty($roomname) and !empty($roomEncryptname)){
              $roomDatas = $this->dbconnect->prepare('INSERT INTO room_member VALUES (null,:room_joined,:userId,:joinstatus,:previllage,:roomName,:roomEncryptname,:date_connected)');
              $roomDatas->bindParam(':room_joined',$roomId);
              $roomDatas->bindParam(':userId',$this->userId);
              $roomDatas->bindParam(':joinstatus',$this->Roomstatus);
              $roomDatas->bindParam(':previllage',$previllage);
              $roomDatas->bindParam(':roomName',$roomname);
              $roomDatas->bindParam(':roomEncryptname',$roomEncryptname);
              $roomDatas->bindParam(':date_connected',$this->Datecreated);

              if($roomDatas->execute()){
                  return true;
              }else{
                  return false;
              }

          }
        }else{
          return false;
        }
    }
    // check user exists in a join_member table
    public function checkJoin_member($id,$roomName){

        $roomData = $this->dbconnect->prepare("SELECT * FROM room_member WHERE userId='$id' AND roomName='$roomName'");
        $roomData->execute();
        $fetch_very = $roomData->fetch(\PDO::FETCH_ASSOC);
        $roompresent = $fetch_very['roomName'] ??='default value';

        if($roompresent === 'default value'){
            return false;
        }else{
            return true;
        }

    }

    // check if user exists in a room before creating and adding 1
    public function checkAdminExistsinRoom($ID,$roomName){
        $roomData = $this->dbconnect->prepare("SELECT * FROM rooms");
        $roomData->execute();
        $fetch_very = $roomData->fetch(\PDO::FETCH_ASSOC);
        //code...
        $roompresent = $fetch_very['roomName'] ??='default value';
        $userId = $fetch_very['userId'] ??='default value';

        if($roomName == $roompresent AND $ID == $userId){
            return true;
        }else{
            return false;
        }
    }
    public function getRooms($userIdd){
        $roomData = $this->dbconnect->prepare("SELECT * FROM room_member WHERE userId='$userIdd' ");
        $roomData->execute();

        $rooms=[];
        while($fetch_very = $roomData->fetch(\PDO::FETCH_ASSOC)){
            $roomId = $fetch_very['room_joined'] ??='default value';
            $roompresent = $fetch_very['roomName'] ??='default value';
            // echo 'here';
            if(!empty($roomId) AND $roomId != 'default value'){

                $values = $this->getOthermember($roomId,$userIdd);
                $message = $this->fetchLastMessage($roomId);
                $messageCount = $this->countNewMessages($roomId,$userIdd);
                if($message['messages'] == "null" AND $message['readStatus']=="null" AND $message['date_sent']=="null"){
                    $message['messages'] = "";
                    $message['readStatus'] = "";
                    $message['date_sent'] = "";
                }else{
                    $message['messages'] = substr($message['messages'],0,70)."...";
                }
                $rooms[] =[
                    "message_id"=>$message['message_id'],
                    "username"=>$values['username'],
                    "roomID"=>$values['room_joined'],
                    "avarter"=>$values['cropped_image'],
                    "roomName"=>$values['roomName'],
                    "roomEncryptname"=>$values['roomEncryptname'],
                    "image_no_crop"=>$values['image_no_crop'],

                    "lastConverse"=>$message['messages'],
                    "readStatus"=>$message['read_int'],
                    "timeSent"=>$message['date_sent'],
                    'notRead'=>$messageCount

                ];
            }else if($roomId != 'default value'){
                $rooms[]=[
                    "error"=>'401',
                    "message"=>'You dont have an active room'
                ];
            }

        }


        return $rooms;

    }
    public function usortData(){
        return -1;
    }
    public function getOthermember($roomId,$userIds){
        $roomData = $this->dbconnect->prepare("SELECT * FROM room_member WHERE room_joined='$roomId' AND userId!='$userIds'");
        $roomData->execute();
        $fetch_very = $roomData->fetch(\PDO::FETCH_ASSOC);
        $otherId =  $fetch_very['userId'];

        // $query = $this->dbconnect->prepare("SELECT * FROM create_account INNER JOIN continue_add ON create_account.ax_id=continue_add.ax_id WHERE create_account.ax_id='$otherId'");
        $query = $this->dbconnect->prepare("SELECT * FROM avarter INNER JOIN room_member ON avarter.user_id=room_member.userId WHERE avarter.user_id='$otherId'");
        $query->execute();
        $fetch_verys = $query->fetch(\PDO::FETCH_ASSOC);
        return $fetch_verys;

    }
    public function loadMessages($roomID){
        $roomData = $this->dbconnect->prepare("SELECT * FROM messages  WHERE roomId='$roomID' ");
        $roomData->execute();
        $allDATA = [];
        while($fetch_very = $roomData->fetch(\PDO::FETCH_ASSOC)){
            $userID=$fetch_very['userId'];

            $roomdata = $this->dbconnect->prepare("SELECT * FROM avarter  WHERE user_id='$userID'");
            $roomdata->execute();
            $fetch_verys = $roomdata->fetch(\PDO::FETCH_ASSOC);
            $allDATA []= [
                'userID'=>$fetch_very['userId'],
                'username'=>$fetch_verys['username'],
                'message_id'=>$fetch_very['message_id'],
                'message'=>$fetch_very['messages'],
                'avarter'=>$fetch_verys['cropped_image'],
                'image'=>$fetch_verys['image_no_crop'],
                'date_sent'=>$fetch_very['date_sent'],
            ];
        }
        echo json_encode($allDATA);
    }

    public function saveMessage($roomId,$userId,$message){

        $messageTime = strtotime('now');
        $zero = 0;
        $roomDatas = $this->dbconnect->prepare('INSERT INTO messages VALUES (null,:userId,:roomId,:messages,:read_int,:date_read,:delete_int,:deleted_date,:edited,:edit_date,:date_sent)');

        $roomDatas->bindParam(':userId',$userId);
        $roomDatas->bindParam(':roomId',$roomId);
        $roomDatas->bindParam(':messages',$message);
        $roomDatas->bindParam(':read_int',$zero);
        $roomDatas->bindParam(':date_read',$zero);
        $roomDatas->bindParam(':delete_int',$zero);
        $roomDatas->bindParam(':deleted_date',$zero);
        $roomDatas->bindParam(':edited',$zero);
        $roomDatas->bindParam(':edit_date',$zero);
        $roomDatas->bindParam(':date_sent',$messageTime);

        if($roomDatas->execute()){
            return true;
        }else{
            return false;
        }

    }
    public function UserId($token){
        $token = strip_tags($token);
        $roomData = $this->dbconnect->prepare("SELECT ax_id FROM create_Account WHERE random_user_id='$token' limit 1");
        $roomData->execute();
        if($fetch = $roomData->fetch(\PDO::FETCH_ASSOC)){
            return $fetch['ax_id'];
        }else{
            return false;
        }
    }
    public function fetchLastMessage($roomId){
        // fetching messages of the last conversation
        $roomData = $this->dbconnect->prepare("SELECT * FROM messages WHERE roomId='$roomId' AND delete_int=0 ORDER BY message_id  DESC LIMIT 1");
        $roomData->execute();

        $fetch_very = $roomData->fetch(\PDO::FETCH_ASSOC);

        return $fetch_very;
    }
    public function countNewMessages($roomId,$userId){
        $messageCount = $this->dbconnect->prepare("SELECT * FROM `messages` WHERE userId !='$userId' AND read_int=0 AND roomId = '$roomId'");
        $messageCount->execute();
        // $fetch_count = $messageCount->fetch(\PDO::FETCH_ASSOC);
        return $messageCount->rowCount();
    }

}

?>
