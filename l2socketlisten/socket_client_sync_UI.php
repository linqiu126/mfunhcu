<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 16-9-14
 * Time: 下午1:11
 */
include "socket_client_sync.class.php";

$DevCode = "HCU_SH_0301";
$respCmd = "1234567890";
$client = new socket_client_sync($DevCode, $respCmd);

$client->connect();