<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:35
 */
//include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l3apl_f4icm.class.php";

class classTaskL3aplF4icm
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

    //查询指定监测点指定时间的视频列表
    function func_hcu_videolist_process($StatCode, $date,$hour)
    {
        $uiF4icmDbObj = new classDbiL3apF4icm(); //初始化一个UI DB对象
        $videolist = $uiF4icmDbObj->dbi_hcu_vediolist_inqury($StatCode, $date,$hour);
        if (!empty($videolist))
            $retval=array(
                'status'=>'true',
                'ret'=> $videolist
            );
        else
            $retval=array(
                'status'=>'false',
                'ret'=> null
            );
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    //请求播放指定视频
    function func_hcu_videoplay_process($videoid)
    {
        $uiF4icmDbObj = new classDbiL3apF4icm(); //初始化一个UI DB对象
        $result = $uiF4icmDbObj->dbi_hcu_vedioplay_request($videoid);
        if (!empty($result))
            $retval=array(
                'status'=>'true',
                'url'=> $result
            );
        else
            $retval=array(
                'status'=>'false',
                'url'=> null
            );
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    //查询所有可用的软件版本列表
    function func_allsw_version_process()
    {
        $uiF4icmDbObj = new classDbiL3apF4icm(); //初始化一个UI DB对象
        $sw_list = $uiF4icmDbObj->dbi_hcu_allsw_inqury();
        //返回结果
        $retval=array(
            'status'=>'true',
            'ret'=> $sw_list
        );
        $jsonencode = json_encode($retval);
        return $jsonencode;
    }

    //查询指定项目下所有设备的当前版本信息
    function func_devsw_version_process($projcode)
    {
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $sitelist = $uiF3dmDbObj->dbi_proj_sitelist_req($projcode); //查询指定项目号下的所有监测点


        $i = 0;
        $devlist = array();
        while($i < count($sitelist)){
            $devlist = $uiF3dmDbObj->dbi_site_devlist_req($sitelist[$i]["id"]); //查询指定监测点下的HCU设备
            $i++;
        }

        $j = 0;
        while($j < count($devlist)){
            $devcode = $devlist[$j]["name"];
            $j++;
            $uiF4icmDbObj = new classDbiL3apF4icm(); //初始化一个UI DB对象
            $latestver = $uiF4icmDbObj->dbi_latest_hcu_swver_inqury();

        }
        //返回结果
        $retval=array(
            'status'=>'true',
            'ret'=> $latestver
        );
        $jsonencode = json_encode($retval);
        return $jsonencode;
    }

    //更新指定设备到指定的版本
    function func_devsw_update_process($deviceid, $projectid)
    {
        //获取最新版本, swbin和dbbin
        $uiF4icmDbObj = new classDbiL3apF4icm(); //初始化一个UI DB对象
        $latestver = $uiF4icmDbObj->dbi_latest_hcu_swver_inqury();
        $result = $uiF4icmDbObj->dbi_hcu_swver_inqury($latestver);

        //发送软件版本到HCU网关

        //返回结果
        $retval=array(
            'status'=>'true',
            'ret'=> ""
        );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3apl_f4icm_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM4ICM", "mfun_l3apl_f4icm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L3APPL_F4ICM，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM4ICM", "mfun_l3apl_f4icm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //功能
        if ($msgId == MSG_ID_L4AQYCUI_TO_L3F4_ALLSW)
        {
            //解开消息
            if (isset($msg["uid"])) $user = $msg["uid"]; else  $user = "";  //此处的UID是为了将来做权限控制
            //具体处理函数
            $resp = $this->func_allsw_version_process();
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F4_DEVSW)
        {
            //解开消息
            if (isset($msg["uid"])) $user = $msg["uid"]; else  $user = "";  //此处的UID是为了将来做权限控制
            if (isset($msg["ProjCode"])) $projcode = $msg["ProjCode"]; else  $projcode = "";
            //具体处理函数
            $resp = $this->func_devsw_version_process($projcode);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F4_SWUPDATE)
        {
            //解开消息
            if (isset($msg["deviceid"])) $deviceid = $msg["deviceid"]; else  $deviceid = "";
            if (isset($msg["projectid"])) $projectid = $msg["projectid"]; else  $projectid = "";
            //具体处理函数
            $resp = $this->func_devsw_update_process($deviceid, $projectid);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F4_VIDEOLIST)
        {
            if (isset($msg["id"])) $uid = $msg["id"]; else  $uid = "";
            if (isset($msg["StatCode"])) $StatCode = $msg["StatCode"]; else  $StatCode = "";
            if (isset($msg["date"])) $date = $msg["date"]; else  $date = "";
            if (isset($msg["hour"])) $hour = $msg["hour"]; else  $hour = "";
            $resp = $this->func_hcu_videolist_process($StatCode, $date,$hour);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F4_VIDEOPLAY)
        {
            if (isset($msg["id"])) $videoid = $msg["id"]; else  $videoid = "";
            $resp = $this->func_hcu_videoplay_process($videoid);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }


        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, "MFUN_TASK_ID_L3APPL_FUM4ICM", $log_time, $log_content);
            echo trim($resp); //这里需要编码送出去，跟其他处理方式还不太一样
        }

        //返回
        return true;
    }

}//End of class_task_service

?>