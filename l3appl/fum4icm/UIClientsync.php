<?php

    $client = new swoole_client(SWOOLE_SOCK_TCP);
    if (!$client->connect('127.0.0.1', 9502, -1))
    {
        exit("connect failed. Error: {$client->errCode}\n");
    }
    $DevCode = $_GET['DevCode'];
    $respCmd = $_GET['respCmd'];
    $arr = array ($DevCode,$respCmd);
    $client->send(json_encode($arr));
    //sleep(1);　//如果swoole server主程序的log中出现swFactoryProcess_finish error 1004，增加sleep解决
    //echo $client->recv();
    $client->close();

?>