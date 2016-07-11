<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:37
 */
//include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l3apl_f7ads.class.php";

class classTaskL3aplF7ads
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

    //TBD，功能待完善
    function func_set_user_msg_process($msginfo)
    {
        $uiF7adsDbObj = new classDbiL3apF7ads(); //初始化一个UI DB对象
        $retval=array(
            'status'=>'true',
            'msg'=>''
        );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
       return $jsonencode;
    }

    //TBD，功能待完善
    function func_get_user_msg_process($id)
    {
        $uiF7adsDbObj = new classDbiL3apF7ads(); //初始化一个UI DB对象
        $retval=array(
            'status'=>'true',
            'msg'=>'您好，今天是xxxx号，欢迎领导前来视察，今天的气温是 今天的PM2.5是....',
            'ifdev'=>"true"
        );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    //TBD，功能待完善
    function func_show_user_msg_process($id, $StatCode)
    {
        $uiF7adsDbObj = new classDbiL3apF7ads(); //初始化一个UI DB对象
        $temp =(string)rand(1000,9999);
        $retval=array(
            'status'=>'true',
            'msg'=>$temp.'您好，今天是'.$temp.'号，欢迎领导前来视察，今天的气温是 今天的PM2.5是....'
        );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    //TBD，功能待完善
    function func_get_user_image_process($id)
    {
        $uiF7adsDbObj = new classDbiL3apF7ads(); //初始化一个UI DB对象
        $ImgList = array();
        for ($i=1;$i<6;$i++){
            $map = array(
                'name'=>"test".(string)$i.".jpg",
                'url'=>"assets/img/test".(string)$i.".jpg"
            );
            array_push($ImgList,$map);
        }
        $retval=array(
            'status'=>'true',
            'img'=>$ImgList
        );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    //TBD，功能待完善
    function func_clear_user_image_process($id)
    {
        $uiF7adsDbObj = new classDbiL3apF7ads(); //初始化一个UI DB对象
        $retval=array(
            'status'=>'true'
        );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3apl_f7ads_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM7ADS", "mfun_l3apl_f7ads_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L3APPL_F7ADS，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM7ADS", "mfun_l3apl_f7ads_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //功能Set User Message
        if ($msgId == MSG_ID_L4AQYCUI_TO_L3F7_SETUSERMSG)
        {
            //解开消息
            if (isset($msg["id"])) $id = $msg["id"]; else  $id = "";
            if (isset($msg["msg"])) $msg1 = $msg["msg"]; else  $msg1 = "";
            if (isset($msg["ifdev"])) $ifdev = $msg["ifdev"]; else  $ifdev = "";
            $msginfo = array("id" => $id, "msg" => $msg1, "ifdev" => $ifdev);
            //具体处理函数
            $resp = $this->func_set_user_msg_process($msginfo);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Get User Message
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F7_GETUSERMSG)
        {
            //解开消息
            if (isset($msg["id"])) $id = $msg["id"]; else  $id = "";
            //具体处理函数
            $resp = $this->func_get_user_msg_process($id);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Show User Message
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F7_SHOWUSERMSG)
        {
            //解开消息
            if (isset($msg["id"])) $id = $msg["id"]; else  $id = "";
            if (isset($msg["StatCode"])) $StatCode = $msg["StatCode"]; else  $StatCode = "";
            //具体处理函数
            $resp = $this->func_show_user_msg_process($id, $StatCode);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Get User Image
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F7_GETUSERIMG)
        {
            //解开消息
            if (isset($msg["id"])) $id = $msg["id"]; else  $id = "";
            //具体处理函数
            $resp = $this->func_get_user_image_process($id);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Clear User Image
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F7_CLEARUSERIMG)
        {
            //解开消息
            if (isset($msg["id"])) $id = $msg["id"]; else  $id = "";
            //具体处理函数
            $resp = $this->func_clear_user_image_process($id);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, "MFUN_TASK_ID_L3APPL_FUM7ADS", $log_time, $log_content);
            echo trim($resp); //这里需要编码送出去，跟其他处理方式还不太一样
        }

        //返回
        return true;
    }

}//End of class_task_service

?>