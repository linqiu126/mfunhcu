<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/23
 * Time: 10:22
 */

include_once "../l1comvm/vmlayer.php";
class classTaskEarth{
    //构造函数
    public function __construct()
    {

    }

    public function mfun_l2sdk_task_earth($parObj, $msgId, $msgName, $msg)
    {
//        echo json_decode($msg['data']);

//        $data = $msg;
//        $msg = json_decode($msg);

//        var_dump($json->data->IeCnt->yData[0]);
//        echo $json->data->IeCnt->yData[0];
//        echo $json;

        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_STDXML;
        if (empty($msg) == true) {
            $log_content = "E: IOT_STDXML received null message body";
            $loggerObj->mylog($project,"NULL","MFUN_TASK_VID_L1VM_SWOOLE","MFUN_TASK_ID_L2SDK_IOT_STDXML",$msgName,$log_content);//
            echo trim($log_content); //这里echo主要是为了swoole log打印，帮助查找问题
            return false;
        }
        if (($msgId != EARTHQUICK_COMING) || ($msgName != "EARTHQUICK_COMING")){
            $log_content = "E: IOT_STDXML receive Msgid or MsgName error";
            $loggerObj->mylog($project,"NULL","MFUN_TASK_VID_L1VM_SWOOLE","MFUN_TASK_ID_L2SDK_IOT_STDXML",$msgName,$log_content);
            return false;
        }

        if (isset($msg["socketid"])) $socketid = $msg["socketid"]; else  $socketid = "";
        if (isset($msg["data"])) $data = $msg["data"]; else  $data = "";

//        var_dump($socketid);
//        var_dump(json_decode($data));

        $data = json_decode($data);
        if(empty($data)){
            $log_content = "E:IOT_STDJSON received JSON message format error, socketid = ".$socketid;
            $loggerObj->mylog($project,"NULL","MFUN_TASK_VID_L1VM_SWOOLE","MFUN_TASK_ID_L2SDK_IOT_STDXML",$msgName,$log_content);//
            echo trim($log_content); //这里echo主要是为了swoole log打印，帮助查找问题
            return true;
        }

        $toUser = trim($data->ToUsr);
        $FrUsr = trim($data->FrUsr);
        $CrTim = trim($data->CrTim);
        $MsgTp = trim($data->MsgTp);
        $MsgId = trim($data->MsgId);
        $MsgLn = trim($data->MsgLn);
        $IeCnt = $data->IeCnt;
        $FnFlg = trim($data->FnFlg);

//        echo $toUser,$FrUsr,$CrTim,$MsgTp,$MsgId,$MsgLn,$IeCnt,$FnFlg;
        echo $FrUsr."  ";
        echo $CrTim."  ";
        echo $MsgTp."  ";
        echo $MsgId."  ";
        echo $MsgLn."  ";
        var_dump($IeCnt);
        echo $FnFlg."  ";

        //再操作
    }
}

?>