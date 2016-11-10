<?php

/**
 * Created by PhpStorm.
 * User: QL
 * Date: 16-11-10
 * Time: 15:07
 */
class socket_client_udp
{
    private $client;
    private $DevCode;

    public function __construct($DevCode) {
        $this->client = new swoole_client(SWOOLE_SOCK_UDP, SWOOLE_SOCK_SYNC);
        $this->DevCode = $DevCode;
        //$this->respCmd = $respCmd;
    }

    public function sendto() {
        //$ip = "127.0.0.1";
        //$arr = array ($this->DevCode,$this->respCmd);
        //$this->client->sendto($ip, 9503, json_encode($arr));

        $this->client->connect('127.0.0.1', 9503);
        $this->client->send($this->DevCode);

        $data = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0304]]></FromUserName><CreateTime>1477323943</CreateTime><MsgType><![CDATA[hcu_heart_beat]]></MsgType><Content><![CDATA[FE00]]></Content><FuncFlag>0</FuncFlag></xml>
";
        $this->client->send($data);
    }
}