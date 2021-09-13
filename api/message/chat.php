<?php
namespace Mychat;
use Rooms\Room;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require 'room.php';

class Chat implements MessageComponentInterface{
    
    protected $clients;
    private $subscriptions;
    private $users;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->subscriptions = [];
        $this->users = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $this->users[$conn->resourceId] = $conn;
        
    }

    public function onMessage(ConnectionInterface $conn, $msg)
    {
        $data = json_decode($msg);
        switch ($data->command){
            case 'subscribe':
                $this->subscriptions[$conn->resourceId] = $data->channel;
                echo "You Joined Room '".$this->subscriptions[$conn->resourceId]."'";

                break;

            case 'message':
                if (isset($this->subscriptions[$conn->resourceId])) {
                    $target = $this->subscriptions[$conn->resourceId];//target is the channel
                    $rooms = new Room();
                    $roomId = htmlentities($_REQUEST['roomId']);
                    $userId = htmlentities($_REQUEST['userId']);
                    $message = htmlentities($_REQUEST['message']);
                    
                    $rooms->loadMessages($roomId,$userId,$message);
                    // echo json_encode($msg);
                    foreach ($this->subscriptions as $id=>$channel) {
                        if ($channel == $target && $id != $conn->resourceId) {

                            $this->users[$id]->send($data->message);

                        }
                    }
                }

        }
        
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        unset($this->users[$conn->resourceId]);
        unset($this->subscriptions[$conn->resourceId]);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
?>