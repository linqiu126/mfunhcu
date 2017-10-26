<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:44
 */
include_once "../l1comvm/vmlayer.php";
include_once "dbi_l3wxopr.emc.class.php";

class classTaskL3wxOprEmc
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

    //https请求（支持GET和POST）
    protected function https_request($url, $data = null)
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

    private function func_get_emcuser_process($code)
    {
        $weixin =  $this->https_request("https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf2150c4d2941b2ab&secret=ab95997f454e04b77911c18d09807831&code=".$code."&grant_type=authorization_code");//通过access_token查询用户信息
        $jsondecode = json_decode($weixin); //返回用户信息的JSON数据
        $array = get_object_vars($jsondecode);
        if(isset($array['openid']))
            $openid = $array['openid']; //获取微信用户openid
        else
            $openid="Weixin User Not Autherized";
        $retval=array(
            'status'=>'true',
            'ret'=>$openid
        );
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    private function func_get_emcnow_process($openid)
    {
        $l3wxOprEmcDbObj = new classDbiL3wxOprEmc(); //初始化一个UI DB对象
        $emcvalue = $l3wxOprEmcDbObj->dbi_get_current_emcvalue($openid);

        $wxDbObj = new classDbiL2sdkWechat();
        $dbi_info = $wxDbObj->dbi_blebound_query(trim($openid));

        $l2sdkIotWxObj = new classTaskL2sdkIotWx();
        if($dbi_info != false){
            $ihuObj = new classTaskL2snrEmc();
            $msg_body = $ihuObj->func_emc_instant_read_process("", "");

            $i = 0;
            while ($i < count($dbi_info)) //考虑同一个用户绑定多个设备的情况,循环发送命令给该用户绑定的所有设备
            {
                $dev_table = $dbi_info[$i];
                //BYTE系列化处理在L3消息处理过程中已完成,推送数据到硬件设备
                $result = $l2sdkIotWxObj->trans_msgtodevice($dev_table["deviceType"], $dev_table["deviceID"], $dev_table["openID"], $msg_body);

                if (isset($result["errcode"])) $errcode = $result["errcode"]; else  $errcode = 0;
                if ($errcode==40001)  //防止偶然未知原因导致token失效，强制刷新token并再次发送
                {
                    $l2sdkIotWxObj->invalid_token_compel_update($l2sdkIotWxObj->appid,$l2sdkIotWxObj->appsecret);
                    $l2sdkIotWxObj->trans_msgtodevice($dev_table["deviceType"], $dev_table["deviceID"], $dev_table["openID"], $msg_body);
                }
                $i++;
            }
        }

        $retval = array(
            'status' => 'true',
            'ret' => $emcvalue
        );
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    private function func_get_emchistory_process($openid)
    {
        $l3wxOprEmcDbObj = new classDbiL3wxOprEmc(); //初始化一个UI DB对象
        $emc_history = $l3wxOprEmcDbObj->dbi_get_history_emcvalue($openid);

        $retval = array(
            'status' => 'true',
            'ret' => $emc_history
        );
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    private function func_get_emcalarm_process($deviceId)
    {
        $l3wxOprEmcDbObj = new classDbiL3wxOprEmc(); //初始化一个UI DB对象

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
        $l3wxOprEmcDbObj = new classDbiL3wxOprEmc(); //初始化一个UI DB对象

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
    public function mfun_l3wx_opr_emc_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_IHU_EMCWXUI;
        $user = "";

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","MFUN_TASK_ID_L4EMCWX_UI","MFUN_TASK_ID_L3WX_OPR_EMC",$msgName,$log_content);
            return false;
        }

        //解开消息
        if (isset($msg["code"])) $code = $msg["code"]; else  $code = "";
        if (isset($msg["openid"])) $openid = $msg["openid"]; else  $openid = "";

        //功能:EMC H5界面请求当前微信用户OPEN ID
        if ($msgId == MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCUSER){
            $resp = $this->func_get_emcuser_process($code);
            $user = $code; //统一赋值给$user，方便后面的log记录
        }
        //功能:EMC H5界面请求当前辐射值
        elseif ($msgId == MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCNOW){
            $resp = $this->func_get_emcnow_process($openid);
            $user = $openid; //统一赋值给$user，方便后面的log记录
        }
        //功能:EMC H5界面请求历史辐射值
        elseif ($msgId == MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCHISTORY){
            $resp = $this->func_get_emchistory_process($openid);
            $user = $openid; //统一赋值给$user，方便后面的log记录
        }
        //功能:EMC H5界面请求辐射值warning，alarm门限
        elseif ($msgId == MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCALARM){
            $resp = $this->func_get_emcalarm_process($openid);
            $user = $openid; //统一赋值给$user，方便后面的log记录
        }
        //功能:EMC H5界面请求当前辐射记录地理轨迹
        elseif ($msgId == MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCTRACK){
            $resp = $this->func_get_emctrack_process($openid);
            $user = $openid; //统一赋值给$user，方便后面的log记录
        }
        else{
            $resp = ""; //啥都不ECHO
        }

        //这里需要将response返回给微信界面
        if (!empty($resp)) {
            $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
            $log_content = "T:" . $jsonencode;
            $loggerObj->mylog($project,$user,"MFUN_TASK_ID_L3WX_OPR_EMC","NULL",$msgName,$log_content);
            echo trim($jsonencode);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>