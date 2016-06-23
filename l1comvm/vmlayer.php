<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2015/7/5
 * Time: 9:26
 */
include_once "../l1comvm/func_comapi.class.php";
include_once "../l1comvm/commsg.php";
include_once "../l1comvm/errCode.php";
include_once "../l1comvm/sysconfig.php";
include_once "../l1comvm/sysdim.php";
include_once "../l1comvm/pj_emcwx_engpar.php";
include_once "../l1comvm/pj_aqyc_engpar.php";
include_once "../l1comvm/pj_tbswr_engpar.php";
include_once "../l1comvm/sysversion.php";
include_once "../l1comvm/sysmodule.php";
include_once "../l1comdbi/dbi_common.class.php";

class classTaskL1vmCoreRouter
{
    public $msgBufferList = array();
        //0 => array("valid" => "false", "srcId" => 0, "destId" => 0, "msgId" => 0, "msgName" => "", "msgBody" => ""));
    public $msgBufferReadCnt;
    public $msgBufferWriteCnt;
    public $msgBufferUsedCnt;

    //构造函数
    public function __construct()
    {
        for ($i=0; $i<MFUN_MSG_BUFFER_NBR_MAX; $i++){
            $this->msgBufferList[$i] = array("valid" => "false", "srcId" => 0, "destId" => 0, "msgId" => 0, "msgName" => "", "msgBody" => "");
        }
        $this->msgBufferReadCnt = 0;
        $this->msgBufferWriteCnt = 0;
        $this->msgBufferUsedCnt = 0;
    }

    //核心API：发送消息的函数
    public function mfun_l1vm_msg_send($srcId, $destId, $msgId, $msgName, $msgBody)
    {
        //判断是否越界
        if ($this->msgBufferUsedCnt >= MFUN_MSG_BUFFER_NBR_MAX){
            $this->msgBufferUsedCnt = MFUN_MSG_BUFFER_NBR_MAX;
            return false;
        }
        if ($this->msgBufferUsedCnt < 0){
            $this->msgBufferUsedCnt = 0;
            return false;
        }
        if (($this->msgBufferWriteCnt < 0) || ($this->msgBufferWriteCnt >= MFUN_MSG_BUFFER_NBR_MAX)){
            $this->msgBufferWriteCnt = 0;
            return false;
        }

        //直接在msgBufferWriteCnt指示的地方写入
        if ($this->msgBufferList[$this->msgBufferWriteCnt]["valid"] != false){
            $this->msgBufferList[$this->msgBufferWriteCnt]["valid"] = false;
            return false;
        }
        $this->msgBufferList[$this->msgBufferWriteCnt] = array("valid" => "true",
            "srcId" => $srcId,
            "destId" => $destId,
            "msgId" => $msgId,
            "msgName" => $msgName,
            "msgBody" => $msgBody);

        //写完之后，更新计数器
        $this->msgBufferUsedCnt++;
        $this->msgBufferWriteCnt = ($this->msgBufferWriteCnt+1) % MFUN_MSG_BUFFER_NBR_MAX;

        return true;
    }

    public function mfun_l1vm_msg_rcv()
    {
        //判断是否越界
        if ($this->msgBufferUsedCnt > MFUN_MSG_BUFFER_NBR_MAX){
            $this->msgBufferUsedCnt = MFUN_MSG_BUFFER_NBR_MAX;
            return false;
        }
        if ($this->msgBufferUsedCnt <= 0){
            $this->msgBufferUsedCnt = 0;
            return false;
        }
        if (($this->msgBufferReadCnt < 0) || ($this->msgBufferReadCnt >= MFUN_MSG_BUFFER_NBR_MAX)){
            $this->msgBufferReadCnt = 0;
            return false;
        }

        //读取数据
        if ($this->msgBufferList[$this->msgBufferReadCnt]["valid"] != true){
            $this->msgBufferList[$this->msgBufferWriteCnt]["valid"] = false;
            return false;
        }
        $tmp = $this->msgBufferList[$this->msgBufferReadCnt];
        //是否可以采用这种方式输出参数和结果？
        if (isset($tmp["srcId"])) $srcId = $tmp["srcId"];
        if (isset($tmp["destId"])) $destId = $tmp["destId"];
        if (isset($tmp["msgId"])) $msgId = $tmp["msgId"];
        if (isset($tmp["msgName"])) $msgName = $tmp["msgName"];
        if (isset($tmp["msgBody"])) $msgBody = $tmp["msgBody"];
        $result = array(
            "srcId" => $srcId,
            "destId" => $destId,
            "msgId" => $msgId,
            "msgName" => $msgName,
            "msgBody" => $msgBody);

        //写完之后，更新计数器
        $this->msgBufferUsedCnt--;
        $this->msgBufferReadCnt = ($this->msgBufferReadCnt+1) % MFUN_MSG_BUFFER_NBR_MAX;
        return $result;
    }

    //任务入口函数
    public function mfun_l1vm_task_main_entry($parObj, $msg)
    {
        //先处理接收到的消息的基本情况
        if (empty($msg) == true){
            $obj = new classL1vmFuncComApi();
            $log_time = date("Y-m-d H:i:s", time());
            $obj->logger("NULL", "mfun_l1vm_task_main_entry", $log_time, "P: Nothing received");
            echo "";
            return false;
            //exit;
        }

        //然后发送消息到缓冲区中
        if ($parObj == MFUN_MAIN_ENTRY_HCU_IOT){
            if ($this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SDK_IOT_HCU,
                    MSG_ID_L1VM_L2SDK_IOT_HCU_INCOMING,
                    "MSG_ID_L1VM_L2SDK_IOT_HCU_INCOMING",
                    $msg) == false){
                //logsave
                $obj = new classL1vmFuncComApi();
                $log_time = date("Y-m-d H:i:s", time());
                $obj->logger("MFUN_MAIN_ENTRY_HCU_IOT", "mfun_l1vm_task_main_entry", $log_time, "P: Send to message buffer error.");
                echo "Cloud internal error.";
                return false;
            };
        }elseif($parObj == MFUN_MAIN_ENTRY_EMC_WX){
            if ($this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SDK_IOT_WX,
                    MSG_ID_L1VM_L2SDK_IOT_WX_INCOMING,
                    "MSG_ID_L1VM_L2SDK_IOT_WX_INCOMING",
                    $msg) == false) {
                //logsave
                $obj = new classL1vmFuncComApi();
                $log_time = date("Y-m-d H:i:s", time());
                $obj->logger("MFUN_MAIN_ENTRY_EMC_WX", "mfun_l1vm_task_main_entry", $log_time, "P: Send to message buffer error.");
                echo "Cloud internal error.";
                return false;
            };
        }elseif($parObj == MFUN_MAIN_ENTRY_CRON){

        }elseif($parObj == $this){

        }else{

        }

        //最后进入循环读取阶段
        //$this做为父CLASS的指针传到被调用任务的CLASS的主入口中去，是为了调用本CLASS的HCU_MSG_SEND函数及其空间，不然无法
        //将消息发送到这个任务L1VM模块中来
        //echo的最终返回，现在暂时假设在最后一条处理消息中完成
        //每个不同任务模块之间的消息结构，由发送者和接收者自行商量结构，因为PHP下是无法定义结构的。同一个CLASS内部可以使
        //用ARRAY进行传递，不同CLASS任务之间则只能采用JSON进行传递，因为不同空间内显然无法将数组传递过去
        $modObj = new classConstL1vmSysTaskList();
        while(($result = mfun_l1vm_msg_rcv()) == true){
            //语法差错检查
            if (isset($result["srcId"]) != true) continue;
            if (isset($result["destId"]) != true) continue;
            if (isset($result["msgId"]) != true) continue;
            if (isset($result["msgName"]) != true) continue;
            if (isset($result["msgBody"]) != true) continue;
            if (($result["srcId"] <= MFUN_TASK_ID_MIN) || ($result["srcId"] >=MFUN_TASK_ID_MAX)) continue;
            if (($result["destId"] <= MFUN_TASK_ID_MIN) || ($result["destId"] >=MFUN_TASK_ID_MAX)) continue;
            if (($result["msgId"] <= MSG_ID_MFUN_MIN) || ($result["msgId"] >=MSG_ID_MFUN_MAX)) continue;
            //检查目标任务模块是否激活
            if ($modObj->mfun_vm_getTaskPresent($result["destId"]) != true){
                $obj = new classL1vmFuncComApi();
                $log_time = date("Y-m-d H:i:s", time());
                $obj->logger("NULL", "mfun_l1vm_task_main_entry", $log_time, "P: Target module is not actived.");
                echo "Cloud internal error.";
                continue;
            }
            //具体开始处理目标消息的大循环
            switch($result["destId"]){
                case MFUN_TASK_ID_L1VM:
                    $obj = new classTaskL1vmCoreRouter();
                    $obj->mfun_l1vm_task_main_entry($this, ["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SDK_IOT_APPLE:
                    break;
                case MFUN_TASK_ID_L2SDK_IOT_JD:
                    break;
                case MFUN_TASK_ID_L2SDK_WECHAT:
                    break;
                case MFUN_TASK_ID_L2SDK_IOT_WX:
                    $obj = new classTaskL2sdkIotWx();
                    $obj->mfun_l2sdk_iot_wx_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK:
                    break;
                case MFUN_TASK_ID_L2SDK_IOT_HCU:
                    $obj = new classTaskL2sdkIotHcu();
                    $obj->mfun_l2sdk_iot_hcu_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_EMC:
                    break;
                case MFUN_TASK_ID_L2SENSOR_HSMMP:
                    break;
                case MFUN_TASK_ID_L2SENSOR_HUMID:
                    break;
                case MFUN_TASK_ID_L2SENSOR_NOISE:
                    break;
                case MFUN_TASK_ID_L2SENSOR_PM25:
                    break;
                case MFUN_TASK_ID_L2SENSOR_TEMP:
                    break;
                case MFUN_TASK_ID_L2SENSOR_WINDDIR:
                    break;
                case MFUN_TASK_ID_L2SENSOR_WINDSPD:
                    break;
                case MFUN_TASK_ID_L2SENSOR_AIRPRS:
                    break;
                case MFUN_TASK_ID_L2SENSOR_ALCOHOL:
                    break;
                case MFUN_TASK_ID_L2SENSOR_CO1:
                    break;
                case MFUN_TASK_ID_L2SENSOR_HCHO:
                    break;
                case MFUN_TASK_ID_L2SENSOR_TOXICGAS:
                    break;
                case MFUN_TASK_ID_L2SENSOR_LIGHTSTR:
                    break;
                case MFUN_TASK_ID_L3APPL_FUM1SYM:
                    break;
                case MFUN_TASK_ID_L3APPL_FUM2CM:
                    break;
                case MFUN_TASK_ID_L3APPL_FUM3DM:
                    break;
                case MFUN_TASK_ID_L3APPL_FUM4ICM:
                    break;
                case MFUN_TASK_ID_L3APPL_FUM5FM:
                    break;
                case MFUN_TASK_ID_L3APPL_FUM6PM:
                    break;
                case MFUN_TASK_ID_L3APPL_FUM7ADS:
                    break;
                case MFUN_TASK_ID_L3APPL_FUM8PSM:
                    break;
                case MFUN_TASK_ID_L3APPL_FUM9GISM:
                    break;
                case MFUN_TASK_ID_L3APPL_FUMXPRCM:
                    break;
                case MFUN_TASK_ID_L3WXPRC_EMC:
                    break;
                case MFUN_TASK_ID_L4AQYC_UI:
                    break;
                case MFUN_TASK_ID_L4EMCWX_UI:
                    break;
                case MFUN_TASK_ID_L4TBSWR_UI:
                    break;
                case MFUN_TASK_ID_L4OAMTOOLS:
                    break;
                case MFUN_TASK_ID_L5BI:
                    break;
                default:
                    break;
            }//End of switch
        }//End of while
        //最终结束
        return true;
    }

}

?>



/*
https://segmentfault.com/a/1190000002963223
http://blog.haohtml.com/archives/15484
http://blog.csdn.net/lmj623565791/article/details/37607165
http://pecl.php.net/package/amqp
http://blog.haohtml.com/archives/15491
http://stackoverflow.com/questions/13776164/connect-to-rabbitmq-from-php-windows
http://www.th7.cn/Program/php/201410/297470.shtml

消息的处理，是有两种方式：
A，一次性。用 $q->get([...])，不管取到取不到消息都会立即返回，一般情况下使用轮询处理消息队列就要用这种方式；
B，阻塞。用 $q->consum( callback, [...] ) 程序会进入持续侦听状态，每收到一个消息就会调用callback指定的函数一次，直到某个callback函数返回FALSE才结束。
关于callback，这里多说几句： PHP的call_back是支持使用数组的，比如： $c = new MyClass(); $c->counter = 100; $q->consume( array($c,'myfunc') ) 这样就可以调用自己写的处理类。MyClass中myfunc的参数定义，与上例中processMessage一样就行。
在上述示例中，使用的$routingkey = ''， 意味着接收全部的消息。我们可以将其改为 $routingkey = 'key_1'，可以看到结果中仅有设置routingkey为key_1的内容了。
注意： routingkey = 'key_1' 与 routingkey = 'key_2' 是两个不同的队列。假设： client1 与 client2 都连接到 key_1 的队列上，一个消息被client1处理之后，就不会被client2处理。而 routingkey = '' 是另类，client_all绑定到 '' 上，将消息全都处理后，client1和client2上也就没有消息了。
在程序设计上，需要规划好exchange的名称，以及如何使用key区分开不同类型的标记，在消息产生的地方插入发送消息代码。后端处理，可以针对每一个key启动一个或多个client，以提高消息处理的实时性。如何使用PHP进行多线程的消息处理，将在下一节中讲述。
更多消息模型，可以参考： http://www.rabbitmq.com/tutorials/tutorial-two-python.html

public function mfun_l1vm_msg_send($msg)
{
//配置信息
$conn_args = array(
'host' => MFUN_MQ_RABBIT_HOST,
'port' => MFUN_MQ_RABBIT_PORT,
'login' => MFUN_MQ_RABBIT_LOGIN,
'password' => MFUN_MQ_RABBIT_PSWD,
'vhost'=> MFUN_MQ_RABBIT_VHOST);
//$e_name = 'e_linvo'; //交换机名
//$q_name = 'q_linvo'; //无需队列名
//$k_route = 'key_1'; //路由key

//创建连接和channel
$conn = new AMQPConnection($conn_args);
if (!$conn->connect()) {
die("Cannot connect to the broker!\n");
}
$channel = new AMQPChannel($conn);

//消息内容
//$message = "TEST MESSAGE! 测试消息！";
$message = $msg;

//创建交换机对象
$ex = new AMQPExchange($channel);
$ex->setName(MFUN_MQ_RABBIT_EXCHANGE);

//发送消息
$channel->startTransaction(); //开始事务
for($i=0; $i<5; ++$i){
echo "Send Message:".$ex->publish($message, MFUN_MQ_RABBIT_EXCHANGE)."\n";
}
$channel->commitTransaction(); //提交事务
$conn->disconnect();
}

public function mfun_l1vm_msg_rcv()
{
//配置信息
$conn_args = array(
'host' => MFUN_MQ_RABBIT_HOST,
'port' => MFUN_MQ_RABBIT_PORT,
'login' => MFUN_MQ_RABBIT_LOGIN,
'password' => MFUN_MQ_RABBIT_PSWD,
'vhost'=> MFUN_MQ_RABBIT_VHOST);
//$e_name = 'e_linvo'; //交换机名
//$q_name = 'q_linvo'; //队列名
//$k_route = 'key_1'; //路由key

//创建连接和channel
$conn = new AMQPConnection($conn_args);
if (!$conn->connect()) {
die("Cannot connect to the broker!\n");
}
$channel = new AMQPChannel($conn);

//创建交换机
$ex = new AMQPExchange($channel);
$ex->setName(MFUN_MQ_RABBIT_EXCHANGE);
$ex->setType(AMQP_EX_TYPE_DIRECT); //direct类型
$ex->setFlags(AMQP_DURABLE); //持久化
echo "Exchange Status:".$ex->declare()."\n";

//创建队列
$msgQue = new AMQPQueue($channel);
$msgQue->setName(MFUN_MQ_RABBIT_QUEUE);
$msgQue->setFlags(AMQP_DURABLE); //持久化
echo "Message Total:".$msgQue->declare()."\n";

//绑定交换机与队列，并指定路由键
echo 'Queue Bind: '.$msgQue->bind(MFUN_MQ_RABBIT_EXCHANGE, MFUN_MQ_RABBIT_ROUTE_KEY)."\n";

//阻塞模式接收消息
echo "Message:\n";
while(True){
$msgQue->consume('processMessage');
$msgQue->consume('processMessage', AMQP_AUTOACK); //自动ACK应答
}
$conn->disconnect();
}

/**
* 消费回调函数
* 处理消息
*/
function processMessage($envelope, $queue) {
var_dump($envelope->getRoutingKey);
$msg = $envelope->getBody();
echo $msg."\n"; //处理消息
$queue->ack($envelope->getDeliveryTag()); //手动发送ACK应答
}


*/
