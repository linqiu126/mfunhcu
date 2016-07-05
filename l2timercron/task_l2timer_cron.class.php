<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/4
 * Time: 20:40
 */
//include_once "../l1comvm/vmlayer.php";

class classTaskL2TimerCron
{
    //构造函数
    public function __construct()
    {

    }

    function func_timer_1min_process()
    {
        return "";
    }

    function func_timer_3min_process()
    {
        return "";
    }

    function func_timer_10min_process()
    {
        $this->func_timer_10min_process_sae_database_backup();
        return "";
    }

    function func_timer_10min_process_sae_database_backup()
    {
        $dj = new SaeDeferredJob();
        //添加任务，导入数据库
        // $taskID=$dj->addTask("import","mysql","domainA","abc.sql","databaseA","tableA","callback.php");
        // if($taskID===false)
        //     var_dump($dj->errno(), $dj->errmsg());
        // else
        // var_dump($taskID);
        $tasktype = "export";
        $dbtype = "mysql";
        $stor_domain = "backupdatabase";
        $dbname = "app_mfuncard";
        $tbname = null;

        //$tbname = null应该是选择全部表，需要试试
        //$tbname = "loginfo";
        date_default_timezone_set("Asia/Shanghai");
        $my_t=getdate(date("U"));
        $stor_filename = "$dbname-$my_t[year]-$my_t[mon]-$my_t[mday]-$my_t[hours]-$my_t[minutes]-$my_t[seconds].sql.zip";
        //$stor_filename = "201509191321.sql.zip";
        $callbackurl = null;
        //$callbackurl = null 设置为null是否就不出错，要试试
        //$callbackurl = "csv.php";
        $ignore_errors = true;

        $taskID=$dj->addTask($tasktype,$dbtype,$stor_domain,$stor_filename,$dbname,$tbname,$callbackurl, $ignore_errors);
        if($taskID===false) var_dump($dj->errno(), $dj->errmsg());

        // //获得任务状态
        // $ret=$dj->getStatus($taskID);
        // if($ret===false)
        //     var_dump($dj->errno(), $dj->errmsg());

        // //删除任务
        // $ret=$dj->deleteTask($taskID);
        // if($ret===false)
        //     var_dump($dj->errno(), $dj->errmsg());

        return "";
    }

    function func_timer_30min_process()
    {
        return "";
    }

    function func_timer_1hour_process()
    {
        return "";
    }

    function func_timer_6hour_process()
    {
        return "";
    }

    function func_timer_24hour_process()
    {
        return "";
    }

    function func_timer_2day_process()
    {
        return "";
    }

    function func_timer_7day_process()
    {
        return "";
    }

    function func_timer_30day_process()
    {
        return "";
    }
    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2timer_cron_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2TIMER_CRON", "mfun_l2timer_cron_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L2TIMER_CRON，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2TIMER_CRON", "mfun_l2timer_cron_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        if ($msgId == MSG_ID_L2TIMER_CRON_1MIN_COMING)
        {
            $this->func_timer_1min_process();
        }

        elseif ($msgId == MSG_ID_L2TIMER_CRON_3MIN_COMING)
        {
            $this->func_timer_3min_process();
        }

        elseif ($msgId == MSG_ID_L2TIMER_CRON_10MIN_COMING)
        {
            $this->func_timer_10min_process();
        }

        elseif ($msgId == MSG_ID_L2TIMER_CRON_30MIN_COMING)
        {
            $this->func_timer_30min_process();
        }

        elseif ($msgId == MSG_ID_L2TIMER_CRON_1HOUR_COMING)
        {
            $this->func_timer_1hour_process();
        }

        elseif ($msgId == MSG_ID_L2TIMER_CRON_6HOUR_COMING)
        {
            $this->func_timer_6hour_process();
        }

        elseif ($msgId == MSG_ID_L2TIMER_CRON_24HOUR_COMING)
        {
            $this->func_timer_24hour_process();
        }

        elseif ($msgId == MSG_ID_L2TIMER_CRON_2DAY_COMING)
        {
            $this->func_timer_2day_process();
        }

        elseif ($msgId == MSG_ID_L2TIMER_CRON_7DAY_COMING)
        {
            $this->func_timer_7day_process();
        }

        elseif ($msgId == MSG_ID_L2TIMER_CRON_30DAY_COMING)
        {
            $this->func_timer_30day_process();
        }

        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger("L2TIMERCRON", "MFUN_TASK_ID_L2TIMER_CRON", $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;

    }

}//End of class_task_service