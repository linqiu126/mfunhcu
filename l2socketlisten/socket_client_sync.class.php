<?php

/**
 * Created by PhpStorm.
 * User: QL
 * Date: 16-11-10
 * Time: 13:35
 */
class socket_client_sync
{
    private $client;
    private $DevCode, $respCmd;

    public function __construct($DevCode, $respCmd) {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP);
        $this->DevCode = $DevCode;
        $this->respCmd = $respCmd;
    }

    public function connect() {
        if( !$this->client->connect("127.0.0.1", 9502 , 1) )
        {
            echo "Error: {$fp->errMsg}[{$fp->errCode}]\n";
        }

        /*$message = $this->client->recv();
        echo date('Y/m/d H:i:s', time())." ";
        echo "Get Message From Server:{$message}\n";*/

        $arr = array ($this->DevCode,$this->respCmd);
        $this->client->send(json_encode($arr));

        $message = $this->client->recv();
        echo date('Y/m/d H:i:s', time())." ";
        echo "Get Message From Server:{$message}\n";

    }
}