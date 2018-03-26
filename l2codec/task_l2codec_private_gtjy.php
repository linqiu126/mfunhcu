<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/17
 * Time: 15:06
 */

header("Content-type:text/html;charset=utf-8");
include_once "l2codec_huirestful_msg_dict.php";

class classTaskL2codecPrivateGtjy
{

    private function https_request($url, $data = null)  //protected function
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    public function func_private_gtjy_json_process($json_input)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $input = json_decode($json_input);
        //一级解码
        if (isset($input->restTag)) $restTag = $input->restTag; else  $restTag = "";
        if (isset($input->actionId)) $actionId = intval($input->actionId); else  $actionId = 0;
        if (isset($input->parFlag)) $parFlag = $input->parFlag; else  $parFlag = "";
        if (isset($input->parContent)) $parContent = $input->parContent; else  $parContent = "";
        if (isset($parContent->returnStringCode)) $returnStringCode = $parContent->returnStringCode; else  $returnStringCode = "";
        //二级解码
        if (isset($returnStringCode->剩余量)) $remainVol= $returnStringCode->剩余量; else  $remainVol = "";
        if (isset($returnStringCode->GPRS累计充值量)) $accGprsVol= $returnStringCode->GPRS累计充值量; else  $accGprsVol = "";
        if (isset($returnStringCode->阀门状态)) $valveState= $returnStringCode->阀门状态; else  $valveState = "";
        if (isset($returnStringCode->单价)) $unitPrice= $returnStringCode->单价; else  $unitPrice = "";
        if (isset($returnStringCode->累积量)) $accVol= $returnStringCode->累积量; else  $accVol = "";
        if (isset($returnStringCode->负计数)) $minusNum= $returnStringCode->负计数; else  $minusNum = "";
        if (isset($returnStringCode->rtn)) $rtn= $returnStringCode->rtn; else  $rtn = "";
        if (isset($returnStringCode->最后一次充值量)) $lastRecharge= $returnStringCode->最后一次充值量; else  $lastRecharge = "";
        if (isset($returnStringCode->启动日期)) $startDate= $returnStringCode->启动日期; else  $startDate = "";
        if (isset($returnStringCode->信号强度)) $sigLevel= $returnStringCode->信号强度; else  $sigLevel = "";
        if (isset($returnStringCode->表类型)) $meterType= $returnStringCode->表类型; else  $meterType = "";
        if (isset($returnStringCode->累计金额)) $accMoney= $returnStringCode->累计金额; else  $accMoney = "";
        if (isset($returnStringCode->表内运行状态)) $meterState= $returnStringCode->表内运行状态; else  $meterState = "";
        if (isset($returnStringCode->表内时间)) $meterTime= $returnStringCode->表内时间; else  $meterTime = "";
        if (isset($returnStringCode->IC卡最后一次充值量)) $lastIcRecharge= $returnStringCode->IC卡最后一次充值量; else  $lastIcRecharge = "";
        if (isset($returnStringCode->表号)) $devCode= MFUN_HCU_GTJY_DEVICE_NAME_PREFIX.$returnStringCode->表号; else  $devCode = "";

        $statCode = "";
        //更新当前聚合表
        $timestamp = time();
        $currentTime = date("Y-m-d H:i:s",$timestamp);
        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_gtjy_currentreport` WHERE (`devcode` = '$devCode') ");
        if (($result->num_rows)>0) {
            $query_str = "UPDATE `t_l3f3dm_gtjy_currentreport` SET `statcode` = '$statCode',`createtime` = '$currentTime',`remainvol` = '$remainVol',`accgprsvol` = '$accGprsVol',
                          `valvestate` = '$valveState',`unitprice` = '$unitPrice',`accvol` = '$accVol',`minusnum` = '$minusNum',`rtn` = '$rtn',`lastrecharge` = '$lastRecharge',`startdate` = '$startDate',
                          `siglevel` = '$sigLevel',`metertype` = '$meterType',`accmoney` = '$accMoney',`meterstate` = '$meterState',`metertime` = '$meterTime',`lasticrecharge` = '$lastIcRecharge'
                          WHERE (`devcode` = '$devCode')";
            $result = $mysqli->query($query_str);
        }
        else {
            $query_str = "INSERT INTO `t_l3f3dm_gtjy_currentreport` (`devcode`,`statcode`,`createtime`,`remainvol`,`accgprsvol`,`valvestate`,`unitprice`,`accvol`,`minusnum`,`rtn`,`lastrecharge`,`startdate`,`siglevel`,`metertype`,`accmoney`,`meterstate`,`metertime`,`lasticrecharge`)
                            VALUES ('$devCode','$statCode','$currentTime','$remainVol','$accGprsVol','$valveState','$unitPrice','$accVol','$minusNum','$rtn','$lastRecharge','$startDate','$sigLevel','$meterType','$accMoney','$meterState','$meterTime','$lastIcRecharge')";
            $result = $mysqli->query($query_str);
        }

        return $result;
    }



    /**************************************************************************************
     *                               任务入口函数                                           *
     *************************************************************************************/

    public function mfun_l2codec_private_gtjy_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_GTJYUI;

        //判断入口消息是否为空
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2CODEC_PRIVATE_GTJY",$msgName,$log_content);
            return false;
        }

        if (($msgId != MSG_ID_L2CODEC_PRIVATE_GTJY_DATA_INCOMING) AND ($msgId != MSG_ID_L2CODEC_PRIVATE_GTJY_DATA_INCOMING)){
            $log_content = "E: receive MsgId or MsgName error";
            $loggerObj->mylog($project,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2CODEC_PRIVATE_GTJY",$msgName,$log_content);
            return false;
        }
        else{ // HUIREST decode
            //$msg = array("inputBinCode"=>"AA11C538326217CCA301092A0C0E1C1B7E2C01640000002C010000881300000000000024CC1000CC1000000000000100002100000000000000E803000001000D0B191B7E460111176309813D0D00F401C10341BB");
            $inputBinCode = "";
            for($i=0; $i<strlen($msg["data"]); $i++){
                $inputBinCode = $inputBinCode.bin2hex($msg["data"][$i]);
            }

            $parContent = array("inputBinCode"=>$inputBinCode);
            $parJson = array("restTag" =>HUIREST_ACCESS_CONST_SVRTAG_SPECIAL_IN_STRING,
                            "actionId" => HUIREST_ACTIONID_SPECIAL_GTJY_water_meter_decode,
                            "parFlag" => 1,
                            "parContent" => $parContent);

            $huirest = $this->https_request(HUIRST_ACTIONID_SPECIAL_URL, json_encode($parJson)); //HTTP发送参数需要JSON编码成string

            if (empty($huirest)){
                $log_content = "E: HUIREST decode error";
                $loggerObj->mylog($project,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2CODEC_PRIVATE_GTJY",$msgName,$log_content);
                return false;
            }

            $result = $this->func_private_gtjy_json_process($huirest);

            if (!empty($huirest)) {
                $log_content = "HUIREST decode result: " . json_encode($result, JSON_UNESCAPED_UNICODE);
                $loggerObj->mylog($project,"NULL","MFUN_TASK_ID_L2CODEC_PRIVATE_GTJY","MFUN_TASK_ID_L2CODEC_PRIVATE_GTJY",$msgName,$log_content);
                return false;
            }
        }
    }
}