<?php
use Ratchet\Server\IoServer;
use Mychat\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$dirsep = DIRECTORY_SEPARATOR;
chdir('.');
$dir = getcwd().$dirsep.'autoload.php';
$dir = str_replace('bin',"",$dir);
require ($dir);
chdir('../');
$dire = getcwd().$dirsep.'message'.$dirsep.'chat.php';
$dire = str_replace('\vendor',"",$dire);
require ($dire);
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),8080
);
$server->run();
?>