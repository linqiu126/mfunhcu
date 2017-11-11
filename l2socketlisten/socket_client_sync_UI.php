<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 16-9-14
 * Time: 下午1:11
 */
include "socket_client_sync.class.php";

$socketId = 1; //"HCU_SH_0302";
$devCode = "HCU_SH_0302";
$respCmd = "1234567890";
$client = new socket_client_sync($socketId, $devCode, $respCmd);

$client->connect();
