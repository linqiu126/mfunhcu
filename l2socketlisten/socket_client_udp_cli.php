<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 16-11-10
 * Time: 15:17
 */
include "socket_client_udp.class.php";

$client = new socket_client_udp();

$client->sendto();
