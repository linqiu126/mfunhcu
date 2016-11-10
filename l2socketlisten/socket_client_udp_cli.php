<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 16-11-10
 * Time: 15:17
 */
include "socket_client_udp.class.php";

$DevCode = $argv[1];
//$respCmd = $argv[2];
$client = new socket_client_udp($DevCode);

$client->sendto();
