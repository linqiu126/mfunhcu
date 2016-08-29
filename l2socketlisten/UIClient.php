<?php
    $client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
    $client->on("connect", function($cli) {
      	//$cli->send("hello world\n");
	$DevCode = $_GET['DevCode'];
	$respCmd = $_GET['respCmd'];
        $arr = array ($DevCode,$respCmd);
        $cli->send(json_encode($arr));
  	//$cli->send("shutdown");
  	//$cli->send("task");
    });
    $client->on("receive", function($cli, $data){
      echo "UI Receive: $data\n";
    });
    $client->on("error", function($cli){
      echo "UI connect fail\n";
    });
    $client->on("close", function($cli){
      echo "UI close\n";
    });
    $client->connect('127.0.0.1', 9502, 0.5);
?>
