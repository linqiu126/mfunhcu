<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/7/4
 * Time: 9:22
 */
include_once "../l1comvm/vmlayer.php";

/**********************************************************************************************************************
这里加入一些关于swoole的介绍，方便参考使用

swoole支持的Socket类型
    SWOOLE_TCP/SWOOLE_SOCK_TCP tcp ipv4 socket
    SWOOLE_TCP6/SWOOLE_SOCK_TCP6 tcp ipv6 socket
    SWOOLE_UDP/SWOOLE_SOCK_UDP udp ipv4 socket
    SWOOLE_UDP6/SWOOLE_SOCK_UDP6 udp ipv6 socket
    SWOOLE_UNIX_DGRAM unix socket dgram
    SWOOLE_UNIX_STREAM unix socket stream

**********************************************************************************************************************/

// SOCKET LISTENING的入口
// 目前主要用作FTP数据的传输，以及形成单独稳定可靠的数据连接
// 需要挂载在Linux/SWOOLE服务上，通过配置VPS的运行环境达成
class classL1MainEntrySocketListenServer
{
    private $swoole_socket_serv;

    public function __construct() {
        //创建一个swoole server资源对象, 127.0.0.1表示监听本机，0.0.0.0表示监听所有地址
        $this->swoole_socket_serv = new swoole_server("0.0.0.0");

        //swoole_server->set函数用于设置swoole_server运行时的各项参数，端口相关专用参数在端口listen时set
        $this->swoole_socket_serv->set(array(
            'worker_num' => 4,  //设置启动的worker进程数量。开启的worker进程数越多，server负载能力越大，但是相应的server占有的内存也会更多,配置为CPU核数的1-4倍即可
            'max_request' => 10000,  //=2000,每个worker进程允许处理的最大任务数,每个worker进程在处理完max_request个请求后就会自动重启。设置该值的主要目的是为了防止worker进程处理大量请求后可能引起的内存溢出
            'max_conn' => 10000, //服务器允许维持的最大TCP连接数。超过此数量后，新进入的连接将被拒绝。
            'ipc_mode' => 1, //设置进程间的通信方式,1 => 使用unix socket通信/2 => 使用消息队列通信/3 => 使用消息队列通信，并设置为争抢模式
            'dispatch_mode' => 2,  //指定数据包分发策略,1 => 轮循模式，收到会轮循分配给每一个worker进程/2 => 固定模式，根据连接的文件描述符分配worker。这样可以保证同一个连接发来的数据只会被同一个worker处理/3 => 抢占模式，主进程会根据Worker的忙闲状态选择投递，只会投递给处于闲置状态的Worker
            'task_worker_num' => 4, //=1,服务器开启的task进程数,设置此参数后，服务器会开启异步task功能。可以使用task方法投递异步任务。必须要给swoole_server设置onTask/onFinish两个回调函数
            'task_max_request' => 10000, //每个task进程允许处理的最大任务数。
            'task_ipc_mode' => 2, //设置task进程与worker进程之间通信的方式。
            'daemonize' => 0, //设置程序进入后台作为守护进程运行。长时间运行的服务器端程序必须启用此项。如果不启用守护进程，当ssh终端退出后，程序将被终止运行。启用守护进程后，标准输入和输出会被重定向到 log_file，如果 log_file未设置，则所有输出会被丢弃。
            'log_file' => '/home/swoole_server.log', //指定swoole错误日志文件
            //'log_file' => '/home/hitpony/swoole_server.log', //指定swoole错误日志文件, vmware环境使用
            'heartbeat_check_interval' => 60,  //设置心跳检测间隔，每隔多久轮循一次，单位为秒。每次检测时遍历所有连接，如果某个连接在间隔时间内没有数据发送，则强制关闭连接（会有onClose回调）。
            'heartbeat_idle_time' => 600, //设置某个连接允许的最大闲置时间,如果某个连接在heartbeat_idle_time时间内没有数据发送，则强制关闭连接。
            'open_cpu_affinity' => true, //启用CPU亲和性设置, 在多核的硬件平台中，启用此特性会将swoole的reactor线程/worker进程绑定到固定的一个核上。可以避免进程/线程的运行时在多个核之间互相切换，提高CPU Cache的命中率。
            'reactor_num' => 2, //指定Reactor线程数,通过此参数来调节poll线程的数量，以充分利用多核,reactor_num和writer_num默认设置为CPU核数
            'package_max_length' => 2048,
            'debug_mode'=> 1
        ));

        //创建 HTTP swoole server
        //$this->swoole_http_serv = new swoole_http_server("0.0.0.0", MFUN_SWOOLE_SOCKET_HUITPXML_HTTP);
        //$this->swoole_http_serv->on('Request', array($this, 'swoole_http_serv_onRequest'));
        //$this->swoole_http_serv->start();

        /********************Socket server公共处理函数，Master进程/Manager进程/Worker进程/Task进程************************/
        //Master
        //进程回调函数 onStart/onShutdown/onMasterConnect/onMasterClose/onTimer
        $this->swoole_socket_serv->on('Start', array($this, 'swoole_socket_serv_onStart'));  //启动server，监听所有TCP/UDP端口
        //manager
        //进程回调函数 onManagerStart/onManagerStop
        $this->swoole_socket_serv->on('ManagerStart', array($this, 'swoole_socket_serv_onManagerStart'));
        //Worker
        //进程回调函数 onWorkerStart/onWorkerStop/onConnect/onClose/onReceive/onTimer/onFinish
        $this->swoole_socket_serv->on('WorkerStart', array($this, 'swoole_socket_serv_onWorkerStart'));
        $this->swoole_socket_serv->on('WorkerStop', array($this, 'swoole_socket_serv_onWorkerStop'));
        $this->swoole_socket_serv->on('Finish', array($this, 'swoole_socket_serv_onFinish'));
        //Task
        //进程回调函数 onTask/onWorkerStart
        $this->swoole_socket_serv->on('Task', array($this, 'swoole_socket_serv_onTask'));

        /****************************************具体port处理函数*******************************************************/
        //stdxml_tcp_hcuport 传送老的标准XML消息，TCP端口9501
        $stdxml_tcp_hcuport = $this->swoole_socket_serv->listen("0.0.0.0", MFUN_SWOOLE_SOCKET_STDXML_TCP_HCUPORT, SWOOLE_SOCK_TCP);
        $stdxml_tcp_hcuport->set(array(
            'open_tcp_nodelay' => true, //开启后TCP连接发送数据时会无关闭Nagle合并算法，立即发往客户端连接。在某些场景下，如http服务器，可以提升响应速度。
            'open_eof_check' => true, //打开eof检测功能。当数据包结尾是指定的package_eof 字符串时才会将数据包投递至Worker进程，否则会一直拼接数据包直到缓存溢出或超时才会终止。一旦出错，该连接会被判定为恶意连接，数据包会被丢弃并强制关闭连接。
            'package_eof ' => '</xml>') //设置EOF字符串, package_eof最大只允许传入8个字节的字符串
        );
        $stdxml_tcp_hcuport->on('Connect', array($this, 'stdxml_tcp_hcuport_onConnect'));
        $stdxml_tcp_hcuport->on('Receive', array($this, 'stdxml_tcp_hcuport_onReceive'));
        $stdxml_tcp_hcuport->on('Close', array($this, 'stdxml_tcp_hcuport_onClose'));


        //stdxml_tcp_uiport 来自UI界面或者上层发送给远端设备的消息，TCP端口9502
        $stdxml_tcp_uiport = $this->swoole_socket_serv->listen("0.0.0.0", MFUN_SWOOLE_SOCKET_STDXML_TCP_UIPORT, SWOOLE_SOCK_TCP);
        $stdxml_tcp_uiport->set(array(
            'open_tcp_nodelay' => true ) //开启后TCP连接发送数据时会无关闭Nagle合并算法，立即发往客户端连接。在某些场景下，如http服务器，可以提升响应速度。
        );
        $stdxml_tcp_uiport->on('Connect', array($this, 'stdxml_tcp_uiport_onConnect'));
        $stdxml_tcp_uiport->on('Receive', array($this, 'stdxml_tcp_uiport_onReceive'));
        $stdxml_tcp_uiport->on('Close', array($this, 'stdxml_tcp_uiport_onClose'));

        //huitpxml_tcp_port, 传送HUITP消息，TCP端口9511
        $huitpxml_tcp_hcuport = $this->swoole_socket_serv->listen("0.0.0.0", MFUN_SWOOLE_SOCKET_HUITPXML_TCP, SWOOLE_SOCK_TCP);
        $huitpxml_tcp_hcuport->set(array(
            'open_tcp_nodelay' => true, //开启后TCP连接发送数据时会无关闭Nagle合并算法，立即发往客户端连接。在某些场景下，如http服务器，可以提升响应速度。
            'open_eof_check' => true, //打开eof检测功能。当数据包结尾是指定的package_eof 字符串时才会将数据包投递至Worker进程，否则会一直拼接数据包直到缓存溢出或超时才会终止。一旦出错，该连接会被判定为恶意连接，数据包会被丢弃并强制关闭连接。
            'package_eof ' => '</xml>') //设置EOF字符串, package_eof最大只允许传入8个字节的字符串
        );
        $huitpxml_tcp_hcuport->on('Connect', array($this, 'huitpxml_tcp_hcuport_onConnect'));
        $huitpxml_tcp_hcuport->on('Receive', array($this, 'huitpxml_tcp_hcuport_onReceive'));
        $huitpxml_tcp_hcuport->on('Close', array($this, 'huitpxml_tcp_hcuport_onClose'));

        //CCL图片传输端口
        $huitpxml_tcp_picport = $this->swoole_socket_serv->listen("0.0.0.0", MFUN_SWOOLE_SOCKET_DATA_STREAM_TCP, SWOOLE_SOCK_TCP);
        $huitpxml_tcp_picport->set(array(
            'open_length_check' => true,        //开启包长检查
            'package_length_type' => 'N',       //长度字段的类型，固定包头中用一个4字节（N）或2字节（n）表示包体长度，
            'package_length_offset' => HUITP_IEID_UNI_CCL_GEN_PIC_ID_LEN_MAX,      //第N个字节是包长度的值
            'package_body_offset' => HUITP_IEID_UNI_CCL_GEN_PIC_ID_LEN_MAX + 4,        //第几个字节开始计算长度
            'package_max_length' => SWOOLE_SOCKET_PACKAGE_MAX_LENGTH)    //协议最大长
        );

        $huitpxml_tcp_picport->on('Connect', array($this, 'huitpxml_tcp_picport_onConnect'));
        $huitpxml_tcp_picport->on('Receive', array($this, 'huitpxml_tcp_picport_onReceive'));
        $huitpxml_tcp_picport->on('Close', array($this, 'huitpxml_tcp_picport_onClose'));

        $this->swoole_socket_serv->start();

        return;
    }

    /****************************************Swoole Socket server公共处理函数*******************************************/
    public function swoole_socket_serv_onStart($swoole_socket_serv) {
        global $argv;
        swoole_set_process_name("php {$argv[0]}: master");
        echo date('Y/m/d H:i:s', time())." ";
        echo "swoole_socket_serv_onStart: Master_Pid = {$swoole_socket_serv->master_pid}\n";
        //$swoole_socket_serv->addtimer(1000);

        //connect to mysql, reset all socketid to 0
        $mysqli = mysqli_connect(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3);
        if (!$mysqli) {
            echo date('Y/m/d H:i:s', time())." ";
            echo "[ERROR]swoole_socket_serv_onStart: Unable to connect to MySQL. ";
            echo "ErrCode = " . mysqli_connect_errno() . PHP_EOL;
            exit;
        }
        //将Inventory表中的设备socketid初始化成0
        $query="UPDATE t_l2sdk_iothcu_inventory  SET socketid = 0 WHERE (socketid != 0)";
        $result=$mysqli->query($query);
        if ($result == false){
            echo date('Y/m/d H:i:s', time())." ";
            echo "[ERROR]swoole_socket_serv_onStart: Update socketid to 0 failed!".PHP_EOL;
        }
        $mysqli->close();
    }

    public function swoole_socket_serv_onManagerStart($swoole_socket_serv) {
        global $argv;
        swoole_set_process_name("php {$argv[0]}: manager");
        echo date('Y/m/d H:i:s', time())." ";
        echo "swoole_socket_serv_onManagerStart: Manager_pid = {$swoole_socket_serv->manager_pid}".PHP_EOL;
    }

    public function swoole_socket_serv_onWorkerStart($swoole_socket_serv, $worker_id)
    {
        global $argv;
        if($worker_id >= $swoole_socket_serv->setting['worker_num'])
            swoole_set_process_name("php {$argv[0]}: task_worker");
        else
            swoole_set_process_name("php {$argv[0]}: worker");

        echo date('Y/m/d H:i:s', time())." ";
        echo "swoole_socket_serv_onWorkerStart: worker_num={$swoole_socket_serv->setting['worker_num']} | worker_pid={$swoole_socket_serv->worker_pid} | worker_id=$worker_id".PHP_EOL;
        //$serv->addtimer(500); //500ms
    }

    public function swoole_socket_serv_onWorkerStop($swoole_socket_serv, $worker_id)
    {
        echo date('Y/m/d H:i:s', time())." ";
        echo "swoole_socket_serv_onWorkerStop: [$worker_id] | worker_pid=".posix_getpid().PHP_EOL;
    }

    public function swoole_socket_serv_onFinish($swoole_socket_serv, $task_id, $data)
    {
        echo date('Y/m/d H:i:s', time())." ";
        echo "swoole_socket_serv_onFinish: task_id={$task_id} | task_data_resp={$data}".PHP_EOL;
    }

    public function swoole_socket_serv_onTask($swoole_socket_serv, $task_id, $src_worker_id, $data)
    {
        echo date('Y/m/d H:i:s', time())." ";
        echo "swoole_socket_serv_onFinish: task_id={$task_id} | src_worker_id={$src_worker_id} | task_data_req={$data}".PHP_EOL;
    }


    /********************************************STDXML TCP hcuport****************************************************/

    //具体port处理函数
    public function stdxml_tcp_hcuport_onConnect($swoole_socket_serv, $fd, $from_id ) {
        echo date('Y/m/d H:i:s', time())." ";
        echo "stdxml_tcp_hcuport_onConnect: Client [{$fd}] connected, from_reactor_id=$from_id".PHP_EOL;
        //$swoole_socket_serv->send( $fd, "Hello {$fd}!" );
    }

    //STDXML hcuport入口函数，收到消息直接转发给HCU IOT模块并带上socketid，L1socket模块只负责消息收发，不进行任何消息解码工作
    public function stdxml_tcp_hcuport_onReceive($swoole_socket_serv, $fd, $reactor_id, $data) {
        echo PHP_EOL.date('Y/m/d H:i:s', time())." ";
        echo "stdxml_tcp_hcuport_onReceive: From Client [{$fd}] : {$data}".PHP_EOL;

        $msg = array("socketid" => $fd, "data"=>$data);
        $obj = new classTaskL1vmCoreRouter();
        $obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_IOT_STDXML, MSG_ID_L2SDK_HCU_DATA_COMING, "MSG_ID_L2SDK_HCU_DATA_COMING", $msg);
    }

    public function stdxml_tcp_hcuport_onClose($swoole_socket_serv, $fd, $reactor_id) {
        echo date('Y/m/d H:i:s', time())." ";
        echo "stdxml_tcp_hcuport_onClose: Client [{$fd}] closed connection.".PHP_EOL;
        //reset socketid in t_l2sdk_iothcu_inventory when connection closed.
        $query="UPDATE t_l2sdk_iothcu_inventory  SET socketid = 0 WHERE socketid = $fd"; 
        $result = $swoole_socket_serv->taskwait($query);
        if ($result == true) {
            list($status, $db_res) = explode(':', $result, 2);
            if ($status == 'OK') {
                echo date('Y/m/d H:i:s', time())." ";
                echo "stdxml_tcp_hcuport_onClose: socketid [{$fd}] was set to 0. Affacted_rows : {$db_res}".PHP_EOL;
            } else {
                echo date('Y/m/d H:i:s', time())." ";
                echo "[ERROR]stdxml_tcp_hcuport_onClose: socketid [{$fd}] set to 0 failed.".PHP_EOL;
            }
            return;
        } else {
            echo date('Y/m/d H:i:s', time())." ";
            echo "[ERROR]stdxml_tcp_hcuport_onClose: socketid [{$fd}] not found".PHP_EOL;
        }
    }

    /********************************************STDXML TCP uiport****************************************************/

    public  function stdxml_tcp_uiport_onConnect($swoole_socket_serv, $fd, $from_id)
    {
        echo date('Y/m/d H:i:s', time())." ";
        echo "stdxml_tcp_uiport_onConnect: Client [{$fd}] connected, from_reactor_id=$from_id".PHP_EOL;
    }

    public function stdxml_tcp_uiport_onReceive($swoole_socket_serv, $fd, $reactor_id, $data)
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
                echo PHP_EOL.date('Y/m/d H:i:s', time())." ";
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
                    echo ("[ERROR]stdxml_tcp_uiport_onReceive: sockid = 0, {$devcode} is offline.".PHP_EOL);
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

    public function stdxml_tcp_uiport_onClose($swoole_socket_serv, $fd, $reactor_id)
    {
        echo date('Y/m/d H:i:s', time())." ";
        echo "stdxml_tcp_uiport_onClose: Client [{$fd}] connection closed.".PHP_EOL;
    }


    /********************************************HUITP TCP hcuport****************************************************/

    public function huitpxml_tcp_hcuport_onConnect($swoole_socket_serv, $fd, $from_id) {
        echo date('Y/m/d H:i:s', time())." ";
        echo "huitpxml_tcp_hcuport_onConnect: Client [{$fd}] connected, from_reactor_id=$from_id".PHP_EOL;
    }

    //HUITP cclport入口函数，收到消息直接转发给HUITP IOT模块并带上socketid，L1socket模块只负责消息收发，不进行任何消息解码工作
    public function huitpxml_tcp_hcuport_onReceive($swoole_socket_serv, $fd, $reactor_id, $data) {
        echo PHP_EOL.date('Y/m/d H:i:s', time())." ";
        echo "huitpxml_tcp_hcuport_onReceive: From Client [{$fd}] : {$data}".PHP_EOL;

        $msg = array("socketid" => $fd, "data"=>$data);
        $obj = new classTaskL1vmCoreRouter();
        $obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_IOT_HUITP, MSG_ID_L2SDK_HUITP_DATA_COMING, "MSG_ID_L2SDK_HUITP_DATA_COMING", $msg);
    }

    public function huitpxml_tcp_hcuport_onClose($swoole_socket_serv, $fd, $reactor_id) {
        echo date('Y/m/d H:i:s', time())." ";
        echo "huitpxml_tcp_hcuport_onClose: Client [{$fd}] connection closed.".PHP_EOL;

        //reset socketid in t_l2sdk_iothcu_inventory when connection closed.
        $query="UPDATE t_l2sdk_iothcu_inventory  SET socketid = 0 WHERE socketid = $fd";
        $result = $swoole_socket_serv->taskwait($query);
        if ($result !== false) {
            list($status, $db_res) = explode(':', $result, 2);
            if ($status == 'OK') {
                echo date('Y/m/d H:i:s', time())." ";
                echo "huitpxml_tcp_hcuport_onClose: socketid [{$fd}] was set to 0. Affacted_rows : {$db_res}".PHP_EOL;
            } else {
                echo date('Y/m/d H:i:s', time())." ";
                echo "[ERROR]huitpxml_tcp_hcuport_onClose: socketid [{$fd}] set to 0 failed.".PHP_EOL;
            }
            return;
        } else {
            echo date('Y/m/d H:i:s', time())." ";
            echo "[ERROR]huitpxml_tcp_hcuport_onClose: socketid [{$fd}] not found".PHP_EOL;
        }
    }

    /********************************************HUITP TCP picport****************************************************/

    public function huitpxml_tcp_picport_onConnect($swoole_socket_serv, $fd, $from_id ) {
        echo date('Y/m/d H:i:s', time())." ";
        echo "huitpxml_tcp_picport_onConnect: Client [{$fd}] connected, from_reactor_id=$from_id".PHP_EOL;
        //$swoole_socket_serv->send( $fd, "Hello {$fd}!" );
    }

    public function huitpxml_tcp_picport_onReceive($swoole_socket_serv, $fd, $reactor_id, $data)
    {
        echo PHP_EOL.date('Y/m/d H:i:s', time())." ";
        echo "huitpxml_tcp_picport_onReceive: receive picture data from Client [{$fd}]".PHP_EOL;
        $msg = array("socketid" => $fd, "data"=>$data);

        $obj = new classTaskL1vmCoreRouter();
        $obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_SOCKET_LISTEN, MSG_ID_L2SOCKET_LISTEN_DATA_COMING, "MSG_ID_L2SOCKET_LISTEN_DATA_COMING", $msg);
    }

    public function huitpxml_tcp_picport_onClose( $swoole_socket_serv, $fd, $from_id ) {
        echo date('Y/m/d H:i:s', time())." ";
        echo "huitpxml_tcp_picport_onClose: Client [{$fd}] connection closed".PHP_EOL;

        //reset socketid in t_l2sdk_iothcu_inventory when connection closed.
        $query="UPDATE t_l2sdk_iothcu_inventory  SET socketid = 0 WHERE socketid = $fd";
        $result = $swoole_socket_serv->taskwait($query);
        if ($result !== false) {
            list($status, $db_res) = explode(':', $result, 2);
            if ($status == 'OK') {
                echo date('Y/m/d H:i:s', time())." ";
                echo "huitpxml_tcp_picport_onClose: socketid [{$fd}] was set to 0. Affacted_rows : {$db_res}".PHP_EOL;
            } else {
                echo date('Y/m/d H:i:s', time())." ";
                echo "[ERROR]huitpxml_tcp_picport_onClose: socketid [{$fd}] set to 0 failed.".PHP_EOL;
            }
            return;
        } else {
            echo date('Y/m/d H:i:s', time())." ";
            echo "[ERROR]huitpxml_tcp_picport_onClose: socketid [{$fd}] not found".PHP_EOL;
        }
    }

}//end of classL1MainEntrySocketListenServer

//该服务目前只能在AQ云下跑，其它的待开发完善
$server = new classL1MainEntrySocketListenServer();

?>
