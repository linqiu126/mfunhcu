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

        $this->serv->on('Start', array($this, 'onStart'));
        $this->serv->on('Connect', array($this, 'onConnect'));
        $this->serv->on('Receive', array($this, 'onReceive'));
        $this->serv->on('Close', array($this, 'onClose'));
        //worker
        $this->serv->on('WorkerStart', array($this, 'my_onWorkerStart'));
        $this->serv->on('WorkerStop', array($this, 'my_onWorkerStop'));
        // bind callback
        $this->serv->on('Task', array($this, 'onTask'));
        $this->serv->on('Finish', array($this, 'onFinish'));
        //manager
        $this->serv->on('ManagerStart', function($serv) {
             global $argv;
             swoole_set_process_name("php {$argv[0]}: manager");
         });
        //add port for UI
        $port2 = $this->serv->listen("0.0.0.0", 9502, SWOOLE_SOCK_TCP);
        /*$port2->set(array(
            'open_length_check' => true,
            'package_length_type' => 'N',
            'package_length_offset' => 0,
            'package_max_length' => 800,
        ));*/
        $port2->on('connect', function ($serv, $fd){
            echo "Port2 Client:Connect.\n";
        });

        $port2->on('receive', function ($serv, $fd, $from_id, $data) {
            $serv->send($fd, 'Port2 Swoole: '.$data);
            //connect to mysql, reset all socketid
             $mysqli = mysqli_connect("127.0.0.1", "TestUser", "123456", "bxxhl1l2l3");
            if (!$mysqli ) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
            echo "Success: A proper connection to MySQL was made! bxxhl1l2l3 database is great." . PHP_EOL;
            
            $query="select devcode,socketid from t_l2sdk_iothcu_inventory where devcode=\"$data\"";
            $result=$mysqli->query($query);
            if ($result) {
                     if($result->num_rows>0){                                               //判断结果集中行的数目是否大于0
                              while($row =$result->fetch_array() ){                        //循环输出结果集中的记录
                                       echo ($row[0]).PHP_EOL;
                                       echo ($row[1]).PHP_EOL;
                                       //send current HCUs to all connected HCU
                                       $serv->send( $row[1], "$row[0], This is hello from UI!" );
                              }
                     }
            }else {
                     echo "查询失败";
            }

            $serv->close($fd);
        });

        $port2->on('close', function ($serv, $fd) {
            echo "Port2 Client: Close.\n";
        });
        $this->serv->start();
        return;
    }

    public function onStart( $serv ) {
        global $argv;
         swoole_set_process_name("php {$argv[0]}: master");
         echo "MasterPid={$serv->master_pid}|Manager_pid={$serv->manager_pid}\n";
         echo "Server: start.Swoole version is [".SWOOLE_VERSION."]\n";
         //$serv->addtimer(1000);
         //connect to mysql, reset all socketid
         $mysqli = mysqli_connect("127.0.0.1", "TestUser", "123456", "bxxhl1l2l3");
        if (!$mysqli ) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        echo "Success: A proper connection to MySQL was made! bxxhl1l2l3 database is great." . PHP_EOL;
        
        $query="UPDATE t_l2sdk_iothcu_inventory  SET socketid = 0 WHERE socketid != 0"; //修改update，UPDATE 表名称 SET 列名称 = 新值 WHERE 列名称 = 某值
        echo 'query sentence is:'.$query.PHP_EOL;
        $result=$mysqli->query($query);
        if ($result){
                 echo "操作执行成功".PHP_EOL;
                 echo "updated rows: ".$mysqli->affected_rows.PHP_EOL;
        }else {
                 echo "操作执行失败".PHP_EOL;
        }
        $mysqli->close();
        
    }

    public function onConnect( $serv, $fd, $from_id ) {
        echo "Client fd={$fd} connected.\n";
        $serv->send( $fd, "Hello {$fd}!" );
        
    }
    //入口函数挂载在这个函数体中，待测试
    public function onReceive( swoole_server $serv, $fd, $from_id, $data ) {
        echo "Get Message From Client {$fd}:{$data}\n";
        echo "fd is:".$fd.PHP_EOL;
        echo "data is:".$data.PHP_EOL;
        
        //a test to read from t_l2sdk_iothcu_inventory, devcode + socketid
        //MySql connection test
        $mysqli = mysqli_connect("127.0.0.1", "TestUser", "123456", "bxxhl1l2l3");
        if (!$mysqli ) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        echo "Success: A proper connection to MySQL was made! bxxhl1l2l3 database is great." . PHP_EOL;
        echo "Host information: " . mysqli_get_host_info($mysqli ) . PHP_EOL;
        //Db connection to be closed at shutdown function

        //update start
        $query="UPDATE t_l2sdk_iothcu_inventory  SET socketid = $fd WHERE devcode = \"$data\""; //修改update，UPDATE 表名称 SET 列名称 = 新值 WHERE 列名称 = 某值
        echo 'query sentence is:'.$query.PHP_EOL;
        $result=$mysqli->query($query);
        if ($result){
                 echo "操作执行成功".PHP_EOL;
                 echo "updated rows: ".$mysqli->affected_rows.PHP_EOL;
        }else {
                 echo "操作执行失败".PHP_EOL;
        }
        //update end

        //select sample
        $query="select devcode,socketid from t_l2sdk_iothcu_inventory where devcode=\"$data\"";
        //echo 'select query sentence is:'.$query.PHP_EOL;
        $result=$mysqli->query($query);
        if ($result) {
            if($result->num_rows>0){                                               //判断结果集中行的数目是否大于0
                          while($row =$result->fetch_array() ){              //循环输出结果集中的记录
                                   echo ($row[0]).PHP_EOL;
                                   echo ($row[1]).PHP_EOL;
                          }
              }
        } else {
            echo "select action failed".PHP_EOL;
        }
        $query="select devcode,socketid from t_l2sdk_iothcu_inventory where socketid!=0";
        $result=$mysqli->query($query);
        if ($result) {
                 if($result->num_rows>0){                                               //判断结果集中行的数目是否大于0
                          while($row =$result->fetch_array() ){                        //循环输出结果集中的记录
                                   echo ($row[0]).PHP_EOL;
                                   echo ($row[1]).PHP_EOL;
                                   //send current HCUs to all connected HCU
                                   $serv->send( $row[1], "$row[0], This is hello from $data!" );
                          }
                 }
        }else {
                 echo "查询失败";
        }
        $result->free();
        $mysqli->close();
        //db end

        $msg = array(
            "serv" => $serv, "fd" => $fd, "fromid" => $from_id, "data" => $data);
        $obj = new classTaskL1vmCoreRouter();
        $obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_SOCKET_LISTEN, NULL, NULL, $msg);
        // send a task to task worker.
        //$param = array(
        //	'fd' => $fd
        //);
        //$serv->task( json_encode( $param ) );
        //echo "Continue Handle Worker\n";
    }
    public function onClose( $serv, $fd, $from_id ) {
        echo "Client {$fd} close connection\n";
        $mysqli = mysqli_connect("127.0.0.1", "TestUser", "123456", "bxxhl1l2l3");
        if (!$mysqli ) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        echo "Success: A proper connection to MySQL was made! bxxhl1l2l3 database is great." . PHP_EOL;
        //update start
        $query="UPDATE t_l2sdk_iothcu_inventory  SET socketid = 0 WHERE socketid = $fd"; //修改update，UPDATE 表名称 SET 列名称 = 新值 WHERE 列名称 = 某值
        echo 'query sentence is:'.$query.PHP_EOL;
        $result=$mysqli->query($query);
        if ($result){
                 echo "操作执行成功".PHP_EOL;
                 echo "updated rows: ".$mysqli->affected_rows.PHP_EOL;
        }else {
                 echo "操作执行失败".PHP_EOL;
        }
        //update end

        $mysqli->close();
    }

    public function my_onWorkerStart($serv, $worker_id)
     {
         global $argv;
         if($worker_id >= $serv->setting['worker_num']) {
             swoole_set_process_name("php {$argv[0]}: task_worker");
         } else {
             swoole_set_process_name("php {$argv[0]}: worker");
         }
         //echo "WorkerStart|MasterPid={$serv->master_pid}|Manager_pid={$serv->manager_pid}|WorkerId=$worker_id\n";
             //$serv->addtimer(500); //500ms
     }

     public function my_onWorkerStop($serv, $worker_id)
     {
             echo "WorkerStop[$worker_id]|pid=".posix_getpid().".\n";
     }

    public function onTask($serv,$task_id,$from_id, $data) {
    	echo "This Task {$task_id} from Worker {$from_id}\n";
    	echo "Data: {$data}\n";
    	for($i = 0 ; $i < 10 ; $i ++ ) {
    		sleep(1);
    		echo "Task {$task_id} Handle {$i} times...\n";
    	}
        $fd = json_decode( $data , true )['fd'];
    	$serv->send( $fd , "Data in Task {$task_id}");
    	return "Task {$task_id}'s result";
    }
    public function onFinish($serv,$task_id, $data) {
    	echo "Task {$task_id} finish\n";
    	echo "Result: {$data}\n";
    }
}

//该服务目前只能在AQ云下跑，其它的待开发完善
$server = new classL1MainEntrySocketListenServer();

?>

