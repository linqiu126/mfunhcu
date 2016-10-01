<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:39
 */
//include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l3apl_f0wechat.class.php";

class classTaskL3aplF0wechat
{
    //构造函数
    public function __construct()
    {

    }

    function _encode($arr)
    {
        $na = array();
        foreach ( $arr as $k => $value ) {
            $na[_urlencode($k)] = _urlencode ($value);
        }
        return addcslashes(urldecode(json_encode($na)),"\r\n");
    }

    function _urlencode($elem)
    {
        $na = 0;
        if(is_array($elem)&&(!empty($elem))){
            foreach($elem as $k=>$v){
                $na[_urlencode($k)] = _urlencode($v);
            }
            return $na;
        }
        if(is_array($elem)&&empty($elem)){
            return $elem;
        }
        return urlencode($elem);
    }

    private function func_get_emcuser_process($code)
    {
        $weixin =  file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf2150c4d2941b2ab&secret=ab95997f454e04b77911c18d09807831&code=".$code."&grant_type=authorization_code");//通过access_token查询用户信息
        $jsondecode = json_decode($weixin); //返回用户信息的JSON数据
        $array = get_object_vars($jsondecode);
        $openid = $array['openid']; //获取微信用户openid
        if(!isset($openid)&&empty($openid)){ $openid="Not Autherized";}
        $retval=array(
            'status'=>'true',
            'ret'=>$openid
        );
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    private function func_get_emcnow_process($openid)
    {
        $uiF0wechatDbObj = new classDbiL3apF0wechat(); //初始化一个UI DB对象
        $emcvalue = $uiF0wechatDbObj->dbi_get_current_emcvalue($openid);

        $retval = array(
            'status' => 'true',
            'ret' => $emcvalue
        );
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    private function func_get_emchistory_process($openid)
    {
        $uiF0wechatDbObj = new classDbiL3apF0wechat(); //初始化一个UI DB对象
        $emc_history = $uiF0wechatDbObj->dbi_get_history_emcvalue($openid);

        $retval = array(
            'status' => 'true',
            'ret' => $emc_history
        );
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    private function func_get_emcalarm_process($deviceId)
    {
        $uiF0wechatDbObj = new classDbiL3apF0wechat(); //初始化一个UI DB对象

        $retval = array(
            'status' => 'true',
            'warning' => '150',
            'alarm' => '200'
        );
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    private function func_get_emctrack_process($deviceId)
    {
        $uiF0wechatDbObj = new classDbiL3apF0wechat(); //初始化一个UI DB对象

        $retlist = array();
        for ($i = 0; $i < 48; $i++) {
            $map = array(
                'longitude' => (string)(121.514168 + 0.05 * $i),
                'latitude' => "31.240246",
                'value' => (string)rand(0, 255)
            );
            array_push($retlist, $map);
        }
        $retval = array(
            'status' => 'true',
            'ret' => $retlist
        );
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3apl_f0wechat_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM0WECHAT", "mfun_l3apl_f0wechat_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L3APPL_FXPRCM，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM0WECHAT", "mfun_l3apl_f0wechat_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //功能:EMC H5界面请求当前微信用户OPEN ID
        if ($msgId == MSG_ID_L4EMCWXUI_TO_L3F0_EMCUSER){
            //解开消息
            if (isset($msg["code"])) $code = $msg["code"]; else  $code = "";
            //具体处理函数
            $resp = $this->func_get_emcuser_process($code);
            $project = MFUN_PRJ_IHU_EMCWX;
        }
        //功能:EMC H5界面请求当前辐射值
        elseif ($msgId == MSG_ID_L4EMCWXUI_TO_L3F0_EMCNOW){
            //解开消息
            if (isset($msg["openid"])) $openid = $msg["openid"]; else  $openid = "";
            //具体处理函数
            $resp = $this->func_get_emcnow_process($openid);
            $project = MFUN_PRJ_IHU_EMCWX;
        }
        //功能:EMC H5界面请求历史辐射值
        elseif ($msgId == MSG_ID_L4EMCWXUI_TO_L3F0_EMCHISTORY){
            //解开消息
            if (isset($msg["openid"])) $openid = $msg["openid"]; else  $openid = "";
            //具体处理函数
            $resp = $this->func_get_emchistory_process($openid);
            $project = MFUN_PRJ_IHU_EMCWX;
        }
        //功能:EMC H5界面请求辐射值warning，alarm门限
        elseif ($msgId == MSG_ID_L4EMCWXUI_TO_L3F0_EMCALARM){
            //解开消息
            if (isset($msg["openid"])) $openid = $msg["openid"]; else  $openid = "";
            //具体处理函数
            $resp = $this->func_get_emcalarm_process($openid);
            $project = MFUN_PRJ_IHU_EMCWX;
        }
        //功能:EMC H5界面请求当前辐射记录地理轨迹
        elseif ($msgId == MSG_ID_L4EMCWXUI_TO_L3F0_EMCTRACK){
            //解开消息
            if (isset($msg["openid"])) $openid = $msg["openid"]; else  $openid = "";
            //具体处理函数
            $resp = $this->func_get_emctrack_process($openid);
            $project = MFUN_PRJ_IHU_EMCWX;
        }

        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, "MFUN_TASK_ID_L3APPL_FUM0WECHAT", $log_time, $log_content);
            echo trim($resp); //这里需要编码送出去，跟其他处理方式还不太一样
        }

        //返回
        return true;
    }

}//End of class_task_service

?>