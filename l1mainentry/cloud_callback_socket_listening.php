<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/7/4
 * Time: 9:22
 */
include_once "../l1comvm/vmlayer.php";

// SOCKET LISTENING的入口
// 目前主要用作FTP数据的传输，以及形成单独稳定可靠的数据连接
// 需要挂载在Linux/SWOOLE服务上，通过配置VPS的运行环境达成

class classL1MainEntrySocketListenServer
{
    private $swoole_socket_serv;

    public function __construct() {
        //创建一个swoole server资源对象, 127.0.0.1表示监听本机，0.0.0.0表示监听所有地址
        $this->swoole_socket_serv = new swoole_server("0.0.0.0", MFUN_SWOOLE_SOCKET_STDXML_TCP_HCUPORT);

        //swoole_server->set函数用于设置swoole_server运行时的各项参数
        $this->swoole_socket_serv->set(array(
            'worker_num' => 4,  //设置启动的worker进程数量。swoole采用固定worker进程的模式。PHP代码中是全异步非阻塞，worker_num配置为CPU核数的1-4倍即可
            'max_conn' => 10000, //设置Server最大允许维持多少个tcp连接。超过此数量后，新进入的连接将被拒绝。
            'daemonize' => false, //加入此参数后，执行php server.php将转入后台作为守护进程运行
            'reactor_num' => 2, //通过此参数来调节poll线程的数量，以充分利用多核,reactor_num和writer_num默认设置为CPU核数
            //'daemonize' => true,
            //'log_file' => '/home/qiulin/swoole_server.log', //指定swoole错误日志文件,爱启云环境使用
            //'daemonize' => true,
            //'log_file' => '/home/hitpony/swoole_server.log', //指定swoole错误日志文件, vmware环境使用
            'heartbeat_idle_time' => 600, //TCP连接的最大闲置时间，单位s , 如果某fd最后一次发包距离现在的时间超过heartbeat_idle_time会把这个连接关闭,heartbeat_idle_time必须大于或等于heartbeat_check_interval
            'heartbeat_check_interval' => 60,  //每隔多少秒检测一次，单位秒，Swoole会轮询所有TCP连接，将超过心跳时间的连接关闭掉
            'max_request' => 2000,  //此参数表示worker进程在处理完n次请求后结束运行
            //"open_length_check" => true,
            //"package_max_length" => 8192,
            //"package_body_offset" => 0,
            //'open_eof_check'=> true,
            //'package_eof' => chr(35),
            'package_max_length' => 2048,
            'dispatch_mode' => 2,  //1平均分配，2按FD取摸固定分配，3抢占式分配，默认为取模(dispatch=2)
            'debug_mode'=> 1,
            'task_worker_num' => 1
        ));
        //Socket server公共处理函数，Manager/Task/Worker
        //worker
        $this->swoole_socket_serv->on('WorkerStart', array($this, 'swoole_socket_serv_onWorkerStart'));
        $this->swoole_socket_serv->on('WorkerStop', array($this, 'swoole_socket_serv_onWorkerStop'));
        //task_worker for mysql function
        $this->swoole_socket_serv->on('Task', array($this, 'swoole_socket_serv_onTask'));
        $this->swoole_socket_serv->on('Finish', array($this, 'swoole_socket_serv_onFinish'));
        //manager
        $this->swoole_socket_serv->on('ManagerStart', array($this, 'swoole_socket_serv_onManagerStart'));

        //具体port处理函数
        //stdxml_tcp_hcuport for HCU TCP
        $this->swoole_socket_serv->on('Start', array($this, 'stdxml_tcp_hcuport_onStart'));  //启动server，监听所有TCP/UDP端口
        $this->swoole_socket_serv->on('Connect', array($this, 'stdxml_tcp_hcuport_onConnect'));
        $this->swoole_socket_serv->on('Receive', array($this, 'stdxml_tcp_hcuport_onReceive'));
        $this->swoole_socket_serv->on('Close', array($this, 'stdxml_tcp_hcuport_onClose'));


        //stdxml_tcp_uiport opened for UI Command
        $stdxml_tcp_uiport = $this->swoole_socket_serv->listen("0.0.0.0", MFUN_SWOOLE_SOCKET_STDXML_TCP_UIPORT, SWOOLE_SOCK_TCP);
        $stdxml_tcp_uiport->on('connect', array($this, 'stdxml_tcp_uiport_onConnect'));
        $stdxml_tcp_uiport->on('receive', array($this, 'stdxml_tcp_uiport_onReceive'));
        $stdxml_tcp_uiport->on('close', array($this, 'stdxml_tcp_uiport_onClose'));

        //huitpxml_tcp_port, CCL HUITP TCP port
        $huitpxml_tcp_cclport = $this->swoole_socket_serv->listen("0.0.0.0", MFUN_SWOOLE_SOCKET_HUITPXML_TCP, SWOOLE_SOCK_TCP);
        $huitpxml_tcp_cclport->on('Connect', array($this, 'huitpxml_tcp_cclport_onConnect'));
        $huitpxml_tcp_cclport->on('Receive', array($this, 'huitpxml_tcp_cclport_onReceive'));
        $huitpxml_tcp_cclport->on('Close', array($this, 'huitpxml_tcp_cclport_onClose'));

        //创建CCL HTTP swoole server
        //$this->swoole_http_serv = new swoole_http_server("0.0.0.0", MFUN_SWOOLE_SOCKET_HUITPXML_HTTP);
        //$this->swoole_http_serv->on('Request', array($this, 'swoole_http_serv_onRequest'));
        //$this->swoole_http_serv->start();

        //CCL图片传输端口
        $huitpxml_tcp_picport = $this->swoole_socket_serv->listen("0.0.0.0", MFUN_SWOOLE_SOCKET_DATA_STREAM_TCP, SWOOLE_SOCK_TCP);
        $huitpxml_tcp_picport->set(array(
            'open_length_check' => true,        //开启包长检查
            'package_length_type' => 'N',       //长度字段的类型，固定包头中用一个4字节（N）或2字节（n）表示包体长度，
            'package_length_offset' => 20,      //第N个字节是包长度的值
            'package_body_offset' => 24,        //第几个字节开始计算长度
            'package_max_length' => 200000)    //协议最大长
        );

        $huitpxml_tcp_picport->on('Connect', array($this, 'huitpxml_tcp_picport_onConnect'));
        $huitpxml_tcp_picport->on('Receive', array($this, 'huitpxml_tcp_picport_onReceive'));
        $huitpxml_tcp_picport->on('Close', array($this, 'huitpxml_tcp_picport_onClose'));

        $this->swoole_socket_serv->start();

        return;
    }

    /****************************************Swoole Socket server公共处理函数*******************************************/
    public function swoole_socket_serv_onWorkerStart($swoole_socket_serv, $worker_id)
    {
        global $argv;
        if($worker_id >= $swoole_socket_serv->setting['worker_num']) {
            echo date('Y/m/d H:i:s', time())." ";
            swoole_set_process_name("php {$argv[0]}: task_worker");
        } else {
            echo date('Y/m/d H:i:s', time())." ";
            swoole_set_process_name("php {$argv[0]}: worker");
        }
        echo "swoole_socket_serv_onWorkerStart: MasterPid={$swoole_socket_serv->master_pid}|Manager_pid={$swoole_socket_serv->manager_pid}|WorkerId=$worker_id\n";
        //$serv->addtimer(500); //500ms
    }

    public function swoole_socket_serv_onWorkerStop($swoole_socket_serv, $worker_id)
    {
        echo date('Y/m/d H:i:s', time())." ";
        echo "swoole_socket_serv_onWorkerStop: [$worker_id]|pid=".posix_getpid().".\n";
    }

    public function swoole_socket_serv_onTask($swoole_socket_serv, $task_id, $from_id, $sql)
    {
        static $link = null;
        if ($link == null) {
            $link = mysqli_connect("127.0.0.1", "TestUser", "123456", "bxxhl1l2l3");
            if (!$link) {
                $link = null;
                $swoole_socket_serv->finish("ER:" . mysqli_error($link));
                return;
            }
        } else {
            //try to resolve mysql has gone away problem
            //if(!mysql_ping($link)){
            //mysql_close($link); //注意：一定要先执行数据库关闭，这是关键
            //$link->close();
            $link = mysqli_connect("127.0.0.1", "TestUser", "123456", "bxxhl1l2l3");
            if (!$link) {
                $link = null;
                $swoole_socket_serv->finish("ER:" . mysqli_error($link));
                return;
            }
        }

        $result = $link->query($sql);//mysqli_result return resultset if the command is SELECT, SHOW, DESCRIBE, EXPLAIN, others will be TRUE instead
        if (!$result) {
            $swoole_socket_serv->finish("ER:" . mysqli_error($link));
            return;
        }
        $command = substr($sql, 0, 6);
        //echo "command is ".$command.PHP_EOL;
        switch ($command){
            case "UPDATE":
                $swoole_socket_serv->finish("OK:".$link->affected_rows);
                $link->close();
                break;
            case "SELECT":
                $i=0;
                if($result->num_rows>0){                                               //判断结果集中行的数目是否大于0
                    while($row =$result->fetch_array() ){
                        $data[$i]=$row;
                        $i++;
                    }
                }
                $result->free();
                $swoole_socket_serv->finish("OK:" . serialize($data));
                $link->close();
                break;
        }
        return;
    }

    public function swoole_socket_serv_onFinish($swoole_socket_serv, $data)
    {
        echo date('Y/m/d H:i:s', time())." ";
        echo "swoole_socket_serv_onFinish: Connect.PID=" . posix_getpid() . PHP_EOL;
    }

    public function swoole_socket_serv_onManagerStart($swoole_socket_serv) {
        global $argv;
        swoole_set_process_name("php {$argv[0]}: manager");
    }

    /********************************************STDXML TCP hcuport****************************************************/

    //具体port处理函数
    public function stdxml_tcp_hcuport_onStart($swoole_socket_serv) {
        global $argv;
        swoole_set_process_name("php {$argv[0]}: master");
        echo date('Y/m/d H:i:s', time())." ";
        echo "stdxml_tcp_hcuport_onStart: MasterPid={$swoole_socket_serv->master_pid}|Manager_pid={$swoole_socket_serv->manager_pid}\n";
         //$serv->addtimer(1000);
         //connect to mysql, reset all socketid to 0
        $mysqli = mysqli_connect("127.0.0.1", "TestUser", "123456", "bxxhl1l2l3");
        if (!$mysqli ) {
            echo date('Y/m/d H:i:s', time())." ";
            echo "[ERROR]stdxml_tcp_hcuport_onStart: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        $query="UPDATE t_l2sdk_iothcu_inventory  SET socketid = 0 WHERE (socketid != 0)"; //将Inventory表中的设备socketid初始化成0
        $result=$mysqli->query($query);
        if ($result == false){
            echo date('Y/m/d H:i:s', time())." ";
            echo "[ERROR]stdxml_tcp_hcuport_onStart: Update socketid to 0 failed!".PHP_EOL;
        }
        $mysqli->close();
    }

    public function stdxml_tcp_hcuport_onConnect($swoole_socket_serv, $fd, $from_id ) {
        echo date('Y/m/d H:i:s', time())." ";
        echo "stdxml_tcp_hcuport_onConnect: Client fd={$fd} connected.\n";
        //$swoole_socket_serv->send( $fd, "Hello {$fd}!" );
    }

    //STDXML hcuport入口函数，收到消息直接转发给HCU IOT模块并带上socketid，L1socket模块只负责消息收发，不进行任何消息解码工作
    public function stdxml_tcp_hcuport_onReceive( swoole_server $swoole_socket_serv, $fd, $from_id, $data ) {
        echo date('Y/m/d H:i:s', time())." ";
        echo "stdxml_tcp_hcuport_onReceive: Get Message From Client {$fd} : {$data}\n";

        $msg = array("socketid" => $fd, "data"=>$data);
        $obj = new classTaskL1vmCoreRouter();
        $obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_IOT_STDXML, MSG_ID_L2SDK_HCU_DATA_COMING, "MSG_ID_L2SDK_HCU_DATA_COMING", $data);
    }

    public function stdxml_tcp_hcuport_onClose( $swoole_socket_serv, $fd, $from_id ) {
        echo date('Y/m/d H:i:s', time())." ";
        echo "stdxml_tcp_hcuport_onClose: Client {$fd} closed connection.".PHP_EOL;
        //reset socketid in t_l2sdk_iothcu_inventory when connection closed.
        $query="UPDATE t_l2sdk_iothcu_inventory  SET socketid = 0 WHERE socketid = $fd"; 
        $result = $swoole_socket_serv->taskwait($query);
        if ($result == true) {
            list($status, $db_res) = explode(':', $result, 2);
            if ($status == 'OK') {
                echo date('Y/m/d H:i:s', time())." ";
                echo "stdxml_tcp_hcuport_onClose: socketid ".$fd." was set to 0. Affacted_rows : ".$db_res.PHP_EOL;
            } else {
                echo date('Y/m/d H:i:s', time())." ";
                echo "[ERROR]stdxml_tcp_hcuport_onClose: socketid: update socketid".$fd." to 0 failed.".PHP_EOL;
            }
            return;
        } else {
            echo date('Y/m/d H:i:s', time())." ";
            echo "[ERROR]stdxml_tcp_hcuport_onClose: socketid".$fd." not found in t_l2sdk_iothcu_inventory.".PHP_EOL;
        }
    }

    //TCP UI Port
    public  function stdxml_tcp_uiport_onConnect($swoole_socket_serv, $fd)
    {
        echo date('Y/m/d H:i:s', time())." ";
        echo "Swoole worker stdxml_tcp_uiport: Client {$fd} connected. ".PHP_EOL;
    }

    public function stdxml_tcp_uiport_onReceive($swoole_socket_serv, $fd, $from_id, $data)
    {
        //$swoole_socket_serv->send($fd, $data);//临时增加，等协商好之后修改
        $arr = json_decode($data);
        $query="SELECT devcode,socketid from t_l2sdk_iothcu_inventory where devcode=\"$arr[0]\"";
        $result = $swoole_socket_serv->taskwait($query);
        if ($result !== false) {
            list($status, $db_res) = explode(':', $result, 2);
            if ($status == 'OK') {
                //数据库操作成功了，执行业务逻辑代码，这里就自动释放掉MySQL连接的占用
                //$swoole_socket_serv->send($fd, var_export(unserialize($db_res), true) .Y/m/d h:i:s a "\n");
                $devcode=unserialize($db_res)[0]['devcode']; //restore to array
                $socketid=unserialize($db_res)[0]['socketid'];
                echo date('Y/m/d H:i:s', time())." ";
                echo ("stdxml_tcp_uiport_onReceive: Device = {$devcode}, Command from UI = ").$arr[1].PHP_EOL;
                if ($socketid != 0){
                    $sendresult = $swoole_socket_serv->send($socketid, $arr[1]);
                    if ($sendresult){
                        echo date('Y/m/d H:i:s', time())." ";
                        echo ("stdxml_tcp_uiport_onReceive: Message delivered to {$devcode} success.").PHP_EOL;
                    } else {
                        echo date('Y/m/d H:i:s', time())." ";
                        echo ("[ERROR]stdxml_tcp_uiport_onReceive: Message delivery to {$devcode} failed.").PHP_EOL;
                    }
                } else {
                    echo date('Y/m/d H:i:s', time())." ";
                    echo ("[ERROR]stdxml_tcp_uiport_onReceive: sockid = 0, $devcode is offline.".PHP_EOL);
                }
                //$swoole_socket_serv->close($fd);
            } else {
                //$swoole_socket_serv->send($fd, $db_res);
                echo date('Y/m/d H:i:s', time())." ";
                echo ("[ERROR]stdxml_tcp_uiport_onReceive: query mysql failed.").PHP_EOL;
                //$swoole_socket_serv->close($fd);
            }
            return;
        } else {
            //$swoole_socket_serv->send($fd, "Error. Task timeout\n");
            echo date('Y/m/d H:i:s', time())." ";
            echo ("[ERROR]stdxml_tcp_uiport_onReceive: query mysql timeout.").PHP_EOL;
        }
        //$swoole_socket_serv->close($fd);
    }

    public function stdxml_tcp_uiport_onClose($swoole_socket_serv, $fd) {
        echo date('Y/m/d H:i:s', time())." ";
        echo "stdxml_tcp_uiport_onClose: Client {$fd} connection closed.".PHP_EOL;
    }


    /********************************************HUITP TCP CCL port****************************************************/

    public function huitpxml_tcp_cclport_onConnect($swoole_socket_serv, $fd, $from_id ) {
        echo date('Y/m/d H:i:s', time())." ";
        echo "huitpxml_tcp_cclport_onConnect: Client fd={$fd} connected.\n";
    }

    //HUITP cclport入口函数，收到消息直接转发给HUITP IOT模块并带上socketid，L1socket模块只负责消息收发，不进行任何消息解码工作
    public function huitpxml_tcp_cclport_onReceive( swoole_server $swoole_socket_serv, $fd, $from_id, $data ) {
        echo "\n".date('Y/m/d H:i:s', time())." ";
        echo "huitpxml_tcp_cclport_onReceive: Get Message From Client {$fd} : {$data}\n";

        $msg = array("socketid" => $fd, "data"=>$data);
        $obj = new classTaskL1vmCoreRouter();
        $obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_IOT_HUITP, MSG_ID_L2SDK_HUITP_DATA_COMING, "MSG_ID_L2SDK_HUITP_DATA_COMING", $msg);
    }

    public function huitpxml_tcp_cclport_onClose( $swoole_socket_serv, $fd, $from_id ) {
        echo date('Y/m/d H:i:s', time())." ";
        echo "huitpxml_tcp_cclport_onClose: Client {$fd} closed connection.".PHP_EOL;

        //reset socketid in t_l2sdk_iothcu_inventory when connection closed.
        $query="UPDATE t_l2sdk_iothcu_inventory  SET socketid = 0 WHERE socketid = $fd";
        $result = $swoole_socket_serv->taskwait($query);
        if ($result !== false) {
            list($status, $db_res) = explode(':', $result, 2);
            if ($status == 'OK') {
                echo date('Y/m/d H:i:s', time())." ";
                echo "huitpxml_tcp_cclport_onClose: Socketid ".$fd." is reseted to 0 in t_l2sdk_iothcu_inventory. Affacted_rows : ".$db_res.PHP_EOL;
            } else {
                echo date('Y/m/d H:i:s', time())." ";
                echo "[ERROR]huitpxml_tcp_cclport_onClose: Socketid".$fd." reset failed.".PHP_EOL;
            }
            return;
        } else {
            echo date('Y/m/d H:i:s', time())." ";
            echo "[ERROR]huitpxml_tcp_cclport_onClose: Socketid".$fd." not found in t_l2sdk_iothcu_inventory.".PHP_EOL;
        }
    }

    public function huitpxml_tcp_picport_onConnect($swoole_socket_serv, $fd, $from_id ) {
        echo date('Y/m/d H:i:s', time())." ";
        echo "huitpxml_tcp_picport_onConnect: Client fd={$fd} connected.\n";
        //$swoole_socket_serv->send( $fd, "Hello {$fd}!" );
    }

    public function huitpxml_tcp_picport_onReceive(swoole_server $swoole_socket_serv, $fd, $from_id, $data )
    {
        echo PHP_EOL.date('Y/m/d H:i:s', time())." ";
        echo "huitpxml_tcp_picport_onReceive: Get Message From Client {$fd} : {$data}\n";
        $msg = array("socketid" => $fd, "data"=>$data);
        $obj = new classTaskL1vmCoreRouter();
        $obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_SOCKET_LISTEN, MSG_ID_L2SOCKET_LISTEN_DATA_COMING, "MSG_ID_L2SOCKET_LISTEN_DATA_COMING", $msg);
    }

    public function huitpxml_tcp_picport_onClose( $swoole_socket_serv, $fd, $from_id ) {
        echo date('Y/m/d H:i:s', time())." ";
        echo "huitpxml_tcp_picport_onClose: Client {$fd} closed connection.".PHP_EOL;

        //reset socketid in t_l2sdk_iothcu_inventory when connection closed.
        $query="UPDATE t_l2sdk_iothcu_inventory  SET socketid = 0 WHERE socketid = $fd";
        $result = $swoole_socket_serv->taskwait($query);
        if ($result !== false) {
            list($status, $db_res) = explode(':', $result, 2);
            if ($status == 'OK') {
                echo date('Y/m/d H:i:s', time())." ";
                echo "huitpxml_tcp_picport_onClose: Socketid ".$fd." is reseted to 0 in t_l2sdk_iothcu_inventory. Affacted_rows : ".$db_res.PHP_EOL;
            } else {
                echo date('Y/m/d H:i:s', time())." ";
                echo "[ERROR]huitpxml_tcp_picport_onClose: Socketid".$fd." reset failed.".PHP_EOL;
            }
            return;
        } else {
            echo date('Y/m/d H:i:s', time())." ";
            echo "[ERROR]huitpxml_tcp_picport_onClose: Socketid".$fd." not found in t_l2sdk_iothcu_inventory.".PHP_EOL;
        }
    }




}//end of classL1MainEntrySocketListenServer

//该服务目前只能在AQ云下跑，其它的待开发完善
$server = new classL1MainEntrySocketListenServer();

?>
