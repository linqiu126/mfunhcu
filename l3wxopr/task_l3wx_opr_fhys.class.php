<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/26
 * Time: 19:51
 */

include_once "../l1comvm/vmlayer.php";
include_once "dbi_l3wxopr.fhys.class.php";

class classTaskL3wxOprFhys
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

    private function func_fhys_wechat_login($type, $user, $body)
    {
        if (isset($body["code"])) $code = $body["code"]; else  $code = "";

        //获取不同微信服务号的参数
        $appid = MFUN_WX_APPID;
        $appsecret = MFUN_WX_APPSECRET;
        $weixin =  $this->https_request("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code");//通过access_token查询用户信息
        $jsondecode = json_decode($weixin); //返回用户信息的JSON数据
        $array = get_object_vars($jsondecode);
        if(isset($array['openid'])){
            $openid = $array['openid']; //获取微信用户openid
            $l3wxOprFhysDbObj = new classDbiL3wxOprFhys(); //初始化一个UI DB对象
            $userinfo = $l3wxOprFhysDbObj->dbi_fhyswechat_get_userinfo($openid);
            if(!empty($userinfo))
                $retval=array('status'=>'true','auth'=>'true','ret'=>$userinfo); //如果已经绑定则返回绑定用户信息
            else
                $retval=array('status'=>'false','auth'=>'true','ret'=>$openid); //如果没有绑定则返回微信用户的openid，用于下一步的绑定操作
        }
        else
            $retval=array('status'=>'false','auth'=>'flase','ret'=>"");

        return $retval;
    }

    private function func_fhys_wechat_userbind($type, $user, $body)
    {
        if (isset($body["code"])) $openid = $body["code"]; else  $openid = "";
        if (isset($body["username"])) $username = $body["username"]; else  $username = "";
        if (isset($body["password"])) $password = $body["password"]; else  $password = "";

        if(!empty($openid)){
            $l3wxOprFhysDbObj = new classDbiL3wxOprFhys(); //初始化一个UI DB对象
            $bindinfo = $l3wxOprFhysDbObj->dbi_fhyswechat_userbind($openid,$username,$password);
            if($bindinfo['usercheck'] == true){
                $userinfo = array('username'=>$bindinfo['username'],'userid'=>$bindinfo['userid']);
                $retval=array('status'=>'true','auth'=>'true','ret'=>$userinfo,'msg'=>$bindinfo['msg']);
            }
            else
                $retval=array('status'=>'false','auth'=>'true','ret'=>'','msg'=>$bindinfo['msg']);
        }
        else
            $retval=array('status'=>'false','auth'=>'flase','ret'=>'','msg'=>"微信操作超时，请退出重新登录");

        return $retval;
    }

    private function func_fhys_wechat_lockquery($type, $user, $body)
    {
        $l3wxOprFhysDbObj = new classDbiL3wxOprFhys(); //初始化一个UI DB对象
        $locklist = $l3wxOprFhysDbObj->dbi_fhyswechat_get_locklist($user);
        if(!empty($locklist))
            $retval=array('status'=>'true','auth'=>'true','msg'=>"success",'ret'=>$locklist);
        else
            $retval=array('status'=>'false','auth'=>'false','msg'=>"failure",'ret'=>$locklist);

        return $retval;
    }

    private function func_fhys_wechat_lockstatus($type, $user, $body)
    {
        if (isset($body["statcode"])) $statcode = $body["statcode"]; else  $statcode = "";

        $l3wxOprFhysDbObj = new classDbiL3wxOprFhys(); //初始化一个UI DB对象
        $result = $l3wxOprFhysDbObj->dbi_fhyswechat_get_lockstatus($user, $statcode);
        if($result == true)
            $retval=array('status'=>'true','auth'=>'true','msg'=>"success",'ret'=>"true");
        else
            $retval=array('status'=>'true','auth'=>'true','msg'=>"failure",'ret'=>"false");

        return $retval;
    }

    private function func_fhys_wechat_lockopen($type, $user, $body)
    {
        if (isset($body["statcode"])) $statcode = $body["statcode"]; else  $statcode = "";

        $l3wxOprFhysDbObj = new classDbiL3wxOprFhys(); //初始化一个UI DB对象
        $result = $l3wxOprFhysDbObj->dbi_fhyswechat_set_lockopen($user, $statcode);
        if($result == true)
            $retval=array('status'=>'true','auth'=>'true','msg'=>"success");
        else
            $retval=array('status'=>'true','auth'=>'true','msg'=>"failure");

        return $retval;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3wx_opr_fhys_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3WX_OPR_FHYS", "mfun_l3wx_opr_fhys_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L3APPL_FXPRCM，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3WX_OPR_FHYS", "mfun_l3wx_opr_fhys_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            if (isset($msg["body"])) $body = $msg["body"]; else  $body = "";
        }

        switch($msgId)
        {
            case MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOGIN:
                $resp = $this->func_fhys_wechat_login($type, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSWX;
                break;
            case MSG_ID_FHYSWECHAT_TO_L3WXOPR_USERBIND:
                $resp = $this->func_fhys_wechat_userbind($type, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSWX;
                break;
            case MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKQUERY:
                $resp = $this->func_fhys_wechat_lockquery($type, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSWX;
                break;
            case MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKSTATUS:
                $resp = $this->func_fhys_wechat_lockstatus($type, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSWX;
                break;
            case MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKOPEN:
                $resp = $this->func_fhys_wechat_lockopen($type, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSWX;
                break;
            default:
                $resp = ""; //啥都不ECHO
                break;
        }

        //返回ECHO
        if (!empty($resp))
        {
            $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
            $log_content = "T:" . $jsonencode;
            $loggerObj->logger($project, "mfun_l3wx_opr_fhys_task_main_entry", $log_time, $log_content);
            echo trim($jsonencode); //这里需要编码送出去，跟其他处理方式还不太一样
        }
        //返回
        return true;
    }

}//End of class_task_service

?>