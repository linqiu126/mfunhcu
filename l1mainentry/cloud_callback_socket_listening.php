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
    private $serv;
    public function __construct() {
        $this->serv = new swoole_server("0.0.0.0", 9501);
        $this->serv->set(array(
            'worker_num' => 1,
            'daemonize' => false,
            //'log_file' => '/home/hitpony/phpsocket/tasksample/swoole.log',
            'max_request' => 10000,
            'dispatch_mode' => 2,
            'debug_mode'=> 1,
            'task_worker_num' => 1
        ));

        $this->serv->on('Start', array($this, 'my_onStart'));
        $this->serv->on('Connect', array($this, 'my_onConnect'));
        $this->serv->on('Receive', array($this, 'my_onReceive'));
        $this->serv->on('Close', array($this, 'my_onClose'));
        //worker
        $this->serv->on('WorkerStart', array($this, 'my_onWorkerStart'));
        $this->serv->on('WorkerStop', array($this, 'my_onWorkerStop'));
        //task_worker for mysql function
        $this->serv->on('Task', array($this, 'my_onTask'));
        $this->serv->on('Finish', array($this, 'my_onFinish'));
        //manager
        $this->serv->on('ManagerStart', array($this, 'my_onManagerStart'));
        //port2 opened for UI command
        $port2 = $this->serv->listen("0.0.0.0", 9502, SWOOLE_SOCK_TCP);
        /*$port2->set(array(
            'open_length_check' => true,
            'package_length_type' => 'N',
            'package_length_offset' => 0,
            'package_max_length' => 800,
        ));*/
        $port2->on('connect', array($this, 'port2_onConnect'));
        $port2->on('receive', array($this, 'port2_onReceive'));
        $port2->on('close', array($this, 'port2_onClose'));
         
        $this->serv->start();
        return;
    }

    public function my_onStart( $serv ) {
        global $argv;
         swoole_set_process_name("php {$argv[0]}: master");
         echo "Swoole start: MasterPid={$serv->master_pid}|Manager_pid={$serv->manager_pid}\n";
         //$serv->addtimer(1000);
         //connect to mysql, reset all socketid to 0
         $mysqli = mysqli_connect("127.0.0.1", "TestUser", "123456", "bxxhl1l2l3");
        if (!$mysqli ) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        $query="UPDATE t_l2sdk_iothcu_inventory  SET socketid = 0 WHERE socketid != 0"; 
        $result=$mysqli->query($query);
        if ($result){
                 echo "Swoole start: Swoole version is ".SWOOLE_VERSION.". All socketid reseted to 0, updated rows: ".$mysqli->affected_rows.PHP_EOL;
        }else {
                 echo "Swoole start: Reset socketid failed!".PHP_EOL;
        }
        $mysqli->close();
    }

    public function my_onManagerStart($serv) {
             global $argv;
             swoole_set_process_name("php {$argv[0]}: manager");
    }


    public function my_onConnect( $serv, $fd, $from_id ) {
        echo "Swoole worker: Client fd={$fd} connected.\n";
        $serv->send( $fd, "Hello {$fd}!" );
        
    }
    //入口函数挂载在这个函数体中，待测试
    public function my_onReceive( swoole_server $serv, $fd, $from_id, $data ) {
        echo "Swoole worker: Get Message From Client {$fd} : {$data}\n";
        
        //a test to read from t_l2sdk_iothcu_inventory, devcode + socketid
        //taskwait就是投递一条任务，这里直接传递SQL语句了
        //然后阻塞等待SQL完成
        $query="UPDATE t_l2sdk_iothcu_inventory  SET socketid = $fd WHERE devcode = \"$data\"";
        $result = $serv->taskwait($query);
        if ($result !== false) {
            list($status, $db_res) = explode(':', $result, 2);
            if ($status == 'OK') {
                echo "Swoole worker: Client ".$data."'s socketid ".$fd." is stored in t_l2sdk_iothcu_inventory. Affacted_rows: ".$db_res.PHP_EOL;
            } else {
                echo "Swoole worker: Socketid store failed.";
            }
            return;
        } else {
            echo "Swoole worker: Socketid store timeout.";
        }

        $msg = array(
            "serv" => $serv, "fd" => $fd, "fromid" => $from_id, "data" => $data);
        $obj = new classTaskL1vmCoreRouter();
        $obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_SOCKET_LISTEN, NULL, NULL, $msg);
    }

    public function my_onClose( $serv, $fd, $from_id ) {
        echo "Swoole worker: Client {$fd} closed connection.".PHP_EOL;
        //reset socketid in t_l2sdk_iothcu_inventory when connection closed.
        $query="UPDATE t_l2sdk_iothcu_inventory  SET socketid = 0 WHERE socketid = $fd"; 
        $result = $serv->taskwait($query);
        if ($result !== false) {
            list($status, $db_res) = explode(':', $result, 2);
            if ($status == 'OK') {
                echo "Swoole worker: Socketid ".$fd." is reseted to 0 in t_l2sdk_iothcu_inventory. Affacted_rows : ".$db_res.PHP_EOL;
            } else {
                echo "Swoole worker: Socketid".$fd." reset failed.".PHP_EOL;
            }
            return;
        } else {
            echo "Swoole worker: Socketid".$fd." reset timeout.".PHP_EOL;
        }
    }

    public function my_onWorkerStart($serv, $worker_id)
     {
         global $argv;
         if($worker_id >= $serv->setting['worker_num']) {
             swoole_set_process_name("php {$argv[0]}: task_worker");
         } else {
             swoole_set_process_name("php {$argv[0]}: worker");
         }
        echo "Worker start: MasterPid={$serv->master_pid}|Manager_pid={$serv->manager_pid}|WorkerId=$worker_id\n";
        //$serv->addtimer(500); //500ms
     }

    public function my_onWorkerStop($serv, $worker_id)
    {
        echo "WorkerStop[$worker_id]|pid=".posix_getpid().".\n";
    }

    public function my_onTask($serv, $task_id, $from_id, $sql)
    {
        static $link = null;
        if ($link == null) {
            $link = mysqli_connect("127.0.0.1", "TestUser", "123456", "bxxhl1l2l3");
            if (!$link) {
                $link = null;
                $serv->finish("ER:" . mysqli_error($link));
                return;
            }
        } else {
            //try to resolve mysql has gone away problem
            if(!mysql_ping($link)){
                mysql_close($link); //注意：一定要先执行数据库关闭，这是关键
                $link = mysqli_connect("127.0.0.1", "TestUser", "123456", "bxxhl1l2l3");
                if (!$link) {
                    $link = null;
                    $serv->finish("ER:" . mysqli_error($link));
                    return;
                }
            }
        }

        $result = $link->query($sql);//mysqli_result return resultset if the command is SELECT, SHOW, DESCRIBE, EXPLAIN, others will be TRUE instead
        if (!$result) {
            $serv->finish("ER:" . mysqli_error($link));
            
            return;
        }
        $command = substr($sql, 0, 6);
        //echo "command is ".$command.PHP_EOL;
        switch ($command){
            case "UPDATE":
                $serv->finish("OK:".$link->affected_rows);
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
                $serv->finish("OK:" . serialize($data));
                break;
        }        
    }

    public function my_onFinish($serv, $data)
    {
        echo "AsyncTask Finish:Connect.PID=" . posix_getpid() . PHP_EOL;
    }

    public  function port2_onConnect($serv, $fd){
        echo "Swoole worker port2: Client {$fd} connected. ".PHP_EOL;
    }

    public function port2_onReceive($serv, $fd, $from_id, $data) {
        $serv->send($fd, $data);
        $arr = json_decode($data);
        $query="SELECT devcode,socketid from t_l2sdk_iothcu_inventory where devcode=\"$arr[0]\"";
        $result = $serv->taskwait($query);
        if ($result !== false) {
            list($status, $db_res) = explode(':', $result, 2);
            if ($status == 'OK') {
                //数据库操作成功了，执行业务逻辑代码，这里就自动释放掉MySQL连接的占用
                //$serv->send($fd, var_export(unserialize($db_res), true) . "\n");
                $devcode=unserialize($db_res)[0]['devcode']; //restore to array
                $socketid=unserialize($db_res)[0]['socketid'];
                echo ("Swoole worker port2: Target {$devcode} received from UI, Command from UI thru Swoole worker is ").$arr[1].PHP_EOL;
                if ($socketid != 0){
                    $sendresult = $serv->send($socketid, $arr[1]);
                    if ($sendresult){
                        echo ("Swoole worker port2: Message delivered to {$devcode}.").PHP_EOL;
                    } else {
                        echo ("Swoole worker port2: Message delivery to {$devcode} failed.").PHP_EOL;
                    }
                } else {
                    echo ("Swoole worker port2: sockid = 0, $devcode is offline.".PHP_EOL);
                }
                $serv->close($fd);
            } else {
                $serv->send($fd, $db_res);
                echo ("Swoole worker port2: query mysql failed.").PHP_EOL;
                $serv->close($fd);
            }
            return;
        } else {
            $serv->send($fd, "Error. Task timeout\n");
            echo ("Swoole worker port2: query mysql timeout.").PHP_EOL;
        }

        $serv->close($fd);
    }

    public function port2_onClose($serv, $fd) {
        echo "Swoole worker port2: Client {$fd} connection closed.".PHP_EOL;
    }
}

//该服务目前只能在AQ云下跑，其它的待开发完善
$server = new classL1MainEntrySocketListenServer();

?>

