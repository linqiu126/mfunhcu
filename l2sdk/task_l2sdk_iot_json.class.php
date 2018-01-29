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


        //取DB中的硬件信息，判断FromUser合法性
        $dbiL2sdkIotcomObj = new classDbiL2sdkIotcom();
        $statCode = $dbiL2sdkIotcomObj->dbi_hcuDevice_valid_device($FrUsr); //FromUserName对应每个HCU硬件的设备编号
        if (empty($statCode)){
            $log_content = "E: IOT_STDXML receive invalid FromUserName = ".$FrUsr;
            $loggerObj->mylog($project,$FrUsr,"MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SDK_IOT_STDXML",$msgName,$log_content);
            echo trim($log_content); //这里echo主要是为了swoole log打印，帮助查找问题
            return true;
        }

        //判断ToUser合法性
        if ($toUser != "XHZN" ){
            $log_content = "E: IOT_STDXML receive invalid ToUserName = ".$toUser;
            $loggerObj->mylog($project,$FrUsr,"MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SDK_IOT_STDXML",$msgName,$log_content);
            echo trim($log_content); //这里echo主要是为了swoole log打印，帮助查找问题
            return true;
        }

        //将socket id和设备ID（fromUser）进行绑定
        if(!empty($socketid) AND !empty($statCode)){
            $dbiL2sdkIotcomObj = new classDbiL2sdkIotcom();
            $result = $dbiL2sdkIotcomObj->dbi_huitp_huc_socketid_update($FrUsr, $socketid);
        }

        //mq modified
        switch ($MsgTp) {
            case "huitp-json":
                $msg = array("project" => $project,
                    "platform" => MFUN_TECH_PLTF_HCUSTM,
                    "devCode" => $FrUsr,
                    "statCode" => $statCode,
                    "content" => $IeCnt,
                    "funcFlag" => $FnFlg);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_IOT_STDXML,
                        MFUN_TASK_ID_L2SENSOR_DOORLOCK,
                        MSG_ID_L2SDK_HCU_TO_L2SNR_DOORLOCK,
                        "MSG_ID_L2SDK_HCU_TO_L2SNR_DOORLOCK",
                        $msg) == false)$resp = "E: send to message buffer error";
                else $resp = "";
                break;
            default:
                $resp = "E: unknown message type = " . $MsgTp;
                break;
        }

//        echo $toUser,$FrUsr,$CrTim,$MsgTp,$MsgId,$MsgLn,$IeCnt,$FnFlg;
        echo $toUser."\n";
        echo $FrUsr."\n";
        echo $CrTim."\n";
        echo $MsgTp."\n";
        echo $MsgId."\n";
        echo $MsgLn."\n";
        var_dump($IeCnt->xData[1]);
        $str = "";
        for ($i=0; $i< $IeCnt->num; $i++){
            $count = $i + 1;
            $str .= "第 $count 组数据:"."x:".(string)$IeCnt->xData[$i]." y:".(string)$IeCnt->yData[$i]." z:".(string)$IeCnt->zData[$i]."\n";
        }
        echo $str;
        //发送$str
        echo $FnFlg."\n";
    }
}

?>