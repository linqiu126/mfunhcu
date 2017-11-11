<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 16-9-14
 * Time: 上午11:17
 */
include "socket_client_sync.class.php";

$socketId = $argv[1];
$devCode = $argv[2];
$respCmd = $argv[3];
$client = new socket_client_sync($socketId, $devCode, $respCmd);

$client->connect();

