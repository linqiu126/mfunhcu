<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 16-9-14
 * Time: 上午11:17
 */
include "socket_client_sync.class.php";

$DevCode = $argv[1];
$respCmd = $argv[2];
$client = new socket_client_sync($DevCode, $respCmd);

$client->connect();

