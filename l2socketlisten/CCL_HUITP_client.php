<?php
  $client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
  $client->on("connect", function($cli) {
    //$cli->send("hello world\n");
    //global $argv;
    //global $argc;
    //$cli->send($argv[1]);
    $data ="<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G514_FHYS_SH001]]></FromUserName><CreateTime>1485033669</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[4D90003400010001014D01002B01000000000000000000000000000000000000000000000000000000000000000000000000000000000000]]></Content><FuncFlag>0</FuncFlag></xml>";
    //heartbeat message
    //$data ="<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0301]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[44028100]]></Content><FuncFlag>0</FuncFlag></xml>";

    $cli->send($data);
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
  $client->connect('127.0.0.1', 9510, 0.5);
  
?>
