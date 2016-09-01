<?php
  $client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
  $client->on("connect", function($cli) {
    	//$cli->send("hello world\n");
      global $argv;
      global $argc;
      $cli->send($argv[1]);
	//$cli->send("shutdown");
	//$cli->send("task");
  });
  $client->on("receive", function($cli, $data){
    echo "Receive: $data\n";
  });
  $client->on("error", function($cli){
    echo "connect fail\n";
  });
  $client->on("close", function($cli){
    echo "close\n";
  });
  $client->connect('127.0.0.1', 9501, 0.5);
  
?>
