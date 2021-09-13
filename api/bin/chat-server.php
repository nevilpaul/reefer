<?php
use Ratchet\Server\IoServer;
use Mychat\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$dirsep = DIRECTORY_SEPARATOR;
chdir('../');
$dir = getcwd().$dirsep.'vendor'.$dirsep.'autoload.php';
require ($dir);

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),8080
);
$server->run();
?>