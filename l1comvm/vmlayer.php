<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2015/7/5
 * Time: 9:26
 */
include_once "../l1comvm/comapi.php";
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
    //构造函数
    public function __construct()
    {
    }

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

    public function mfun_l1vm_task_entry($msg)
    {

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


*/
