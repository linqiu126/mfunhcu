<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 2:48
 */

class classTaskL2codecWsdlYcjk
{

    //1、EmsProject 工程信息
    private function func_wsdl_ycjk_EmsProject_encode($input)
    {
        if (isset($input["code"])) $code = $input["code"]; else  $code = "";
        if (isset($input["name"])) $name = $input["name"]; else  $name = "";
        if (isset($input["district"])) $district = $input["district"]; else  $district = "";
        if (isset($input["prjType"])) $prjType = $input["prjType"]; else  $prjType = "";
        if (isset($input["prjCategory"])) $prjCategory = $input["prjCategory"]; else  $prjCategory = "";
        if (isset($input["prjPeriod"])) $prjPeriod = $input["prjPeriod"]; else  $prjPeriod = "";
        if (isset($input["region"])) $region = $input["region"]; else  $region = "";
        if (isset($input["street"])) $street = $input["street"]; else  $street = "";
        if (isset($input["longitude"])) $longitude = $input["longitude"]; else  $longitude = "";
        if (isset($input["latitude"])) $latitude = $input["latitude"]; else  $latitude = "";
        if (isset($input["contractors"])) $contractors = $input["contractors"]; else  $contractors = "";
        if (isset($input["superintendent"])) $superintendent = $input["superintendent"]; else  $superintendent = "";
        if (isset($input["telephone"])) $telephone = $input["telephone"]; else  $telephone = "";
        if (isset($input["address"])) $address = $input["address"]; else  $address = "";
        if (isset($input["siteArea"])) $siteArea = $input["siteArea"]; else  $siteArea = "";
        if (isset($input["buildingArea"])) $buildingArea = $input["buildingArea"]; else  $buildingArea = "";
        if (isset($input["startDate"])) $startDate = $input["startDate"]; else  $startDate = "";
        if (isset($input["endDate"])) $endDate = $input["endDate"]; else  $endDate = "";
        if (isset($input["stage"])) $stage = $input["stage"]; else  $stage = "";
        if (isset($input["isCompleted"])) $isCompleted = $input["isCompleted"]; else  $isCompleted = "";
        if (isset($input["status"])) $status = $input["status"]; else  $status = "";

        $xmlTpl = "<EmsProject>
                    <code><![CDATA[%s]]></code>
                    <name><![CDATA[%s]]></name>
                    <district><![CDATA[%s]]></district>
                    <prjType><![CDATA[%s]]></prjType>
                    <prjCategory><![CDATA[%s]]></prjCategory>
                    <prjPeriod><![CDATA[%s]]></prjPeriod>
                    <street><![CDATA[%s]]></street>
                    <longitude><![CDATA[%s]]></longitude>
                    <latitude><![CDATA[%s]]></latitude>
                    <contractors><![CDATA[%s]]></contractors>
                    <superintendent><![CDATA[%s]]></superintendent>
                    <telephone><![CDATA[%s]]></telephone>
                    <address><![CDATA[%s]]></address>
                    <siteArea><![CDATA[%s]]></siteArea>
                    <buildingArea><![CDATA[%s]]></buildingArea>
                    <startDate><![CDATA[%s]]></startDate>
                    <endDate><![CDATA[%s]]></endDate>
                    <stage><![CDATA[%s]]></stage>
                    <isCompleted><![CDATA[%s]]></isCompleted>
                    <status><![CDATA[%s]]></status></EmsProject>";
        $result = sprintf($xmlTpl,$code,$name,$district,$prjType,$prjCategory,$prjPeriod,$region,$street,$longitude,$latitude,$contractors,$superintendent,$telephone,$address,$siteArea,$buildingArea,$startDate,$endDate,$stage,$isCompleted,$status);
        return $result;
    }



    /**************************************************************************************
     *                               任务入口函数                                           *
     *************************************************************************************/
    //扬尘监控项目联通平台接口消息编码任务，实现对联通平台消息的WSDL格式编码，并通过Soapclient发送
    public function mfun_l2codec_wsdl_ycjk_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_AQYCCU;

        //判断入口消息是否为空
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project, "NULL", "NULL", "MFUN_TASK_ID_L2CODEC_WSDL_YCJK", $msgName, $log_content);
            return false;
        }
        //来自各L2SNR模块发给给HCU的HUITP消息
        if (($msgId != MSG_ID_L2CODEC_WSDL_YCJK_INCOMING) || ($msgName != "MSG_ID_L2CODEC_WSDL_YCJK_INCOMING")) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project, "NULL", "NULL", "MFUN_TASK_ID_L2CODEC_WSDL_YCJK", $msgName, $log_content);
            return false;
        } else { //解开消息
            if (isset($msg["project"])) $project = $msg["project"]; else  $project = "";
            if (isset($msg["devCode"])) $devCode = $msg["devCode"]; else  $devCode = "";
            if (isset($msg["respMsg"])) $huitpMsgId = intval($msg["respMsg"]); else  $huitpMsgId = 0;
            if (isset($msg["content"])) $content = $msg["content"]; else  $content = "";
        }


        if (!empty($respIeStr)) {


//            //通过建立tcp阻塞式socket连接，向HCU发送回复消息
//            $socketid = $dbiL1vmCommonObj->dbi_huitp_huc_socketid_inqery($devCode);
//            if ($socketid != 0) {
//                $client = new socket_client_sync($socketid, $devCode, $xmlMsgStr);
//                $client->connect();
//                //返回消息log
//                $log_content = "T:" . json_encode($respMsgStr);
//                $loggerObj->mylog($project, $devCode, "MFUN_TASK_ID_L2ENCODE_HUITP", "MFUN_TASK_VID_L1VM_SWOOLE", "MSG_VID_L2CODEC_ENCODE_HUITP_OUTPUT", $log_content);
//            } else {
//                $log_content = "E: Socket closed!";
//                $loggerObj->mylog($project, $devCode, "MFUN_TASK_ID_L2ENCODE_HUITP", "MFUN_TASK_VID_L1VM_SWOOLE", "MSG_VID_L2CODEC_ENCODE_HUITP_OUTPUT", $log_content);
//            }
        }
        //结束，返回
        return true;

    }//end of mfun_l2codec_wsdl_ycjk_task_main_entry

}
?>