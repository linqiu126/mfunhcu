<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/17
 * Time: 15:06
 */

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

            $result = $this->https_request(HUIRST_ACTIONID_SPECIAL_URL, json_encode($parJson));

            $resp = json_decode($result);


            if (!empty($result)) {
                $log_content = "HUIREST decode result: " . json_encode($result, JSON_UNESCAPED_UNICODE);
                $loggerObj->mylog($project,"NULL","MFUN_TASK_ID_L2CODEC_PRIVATE_GTJY","MFUN_TASK_ID_L2CODEC_PRIVATE_GTJY",$msgName,$log_content);
                return false;
            }
        }
    }
}