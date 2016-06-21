<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2015/7/2
 * Time: 20:12
 */
include_once "../l1comvm/vmlayer.php";
include_once "../l2sdk/dbi_l2sdk_wx.class.php";
include_once "../l2sdk/task_l2sdk_iot_wx_jssdk.php";

//该文件的处理，将成为标准的WEIXIN Layer3处理，而非SDK层面的L2处理，等待移动到L3层面

//BXXH硬件设备级 Layer 2.2 SDK02，用户设备级接入到微信系统中
class class_wx_IOT_sdk
{
    var $appid = "";
    var $appsecret = "";

    /** 函数列表开始
     * public function __construct($appid = NULL, $appsecret = NULL)
     * public function get_user_list($next_openid = NULL)
     * get_user_info($openid)
     * public function create_menu($data)
     * public function send_custom_message($touser, $type, $data)
     * public function create_qrcode($scene_type, $scene_id)
     * public function create_group($name)
     * public function update_group($openid, $to_groupid)
     * public function upload_media($type, $file)
     * protected function https_request($url, $data = null)
     * //硬件设备部分的处理
     * public function receive_deviceMessage($data = null, $content)
     * public function xms_responseDeviceText($toUser, $fromUser, $deviceType, $deviceID, $sessionID, $content)
     * public function xms_responseDeviceEvent($toUser, $fromUser, $event, $deviceType, $deviceID, $sessionID, $content)
     * public function L3_deviceL3msgReceive($optType, $content)
     * public function trans_msgtodevice($deviceType, $deviceId, $openId, $content)
     * public function get_openIDbyDeviceId($deviceType, $deviceId)
     * public function create_qrcodebyDeviceid($deviceId)
     * public function device_AuthBLE($deviceId)
     * public function device_AuthAndUpdate($authKey, $deviceId, $mac, $isCreate)
     * public function getstat_qrcodebyDeviceid($deviceId)
     * MSG_1.8/wechat_class public function transmitSocialMessage($object)
     * public function verify_qrcode($ticket)
     * MSG_1.10.2 WIFI设备消息接口
     * public function trans_msgtodeviceWIFI($deviceType, $deviceId, $openId, $msgType, $device_status)
     * public function create_DeviceidAndQrcode()
     * public function create_qrcodeDisplay($url)
     * public function notify_bindSuccessful($ticket, $deviceId, $openId)
     * public function notify_unbindSuccessful($ticket, $deviceId, $openId)
     * public function compel_bind($deviceId, $openId)
     * public function compel_unbind($deviceId, $openId)
     * public function getstat_qrcodebyOpenId($openId)
     * public function generateRandomString($length = 10)
     * public function generateDeviceId()
     *
     **/ //函数列表结束

    //构造函数，获取Access Token
    public function __construct($appid = NULL, $appsecret = NULL)
    {
        if ($appid) {
            $this->appid = $appid;
        }
        if ($appsecret) {
            $this->appsecret = $appsecret;
        }

        //这里的Token刷的太快，会出现超过微信设置的每天API刷新的上限问题
        //解决了Token的心病问题：官方程序使用定时器+共享中控服务器的方式，咱们这里完全采用数据库+用户业务逻辑触发，一样可靠
        //原则上，同一个Appid/Appsecrete的逻辑功能，包括不同Subscriber的操作，都
        $wxDbObj = new class_wx_db();
        // $result = $wxDbObj->db_accesstoken_inqury($appid, $appsecret);
        $result = $wxDbObj->db_accesstoken_inqury(WX_APPID, WX_APPSECRET);
        //2小时=7200秒为最长限度，考虑到余量，少放点
        if (($result == "NOTEXIST") || (time() > $result["lasttime"] + 6500))
        {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->appid . "&secret=" . $this->appsecret;
            $res = $this->https_request($url);
            $result = json_decode($res, true);
            //下一步存在当前临时变量和数据库中
            $this->lasttime = time();
            $this->access_token = $result["access_token"];


            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=" . $this->access_token;
            $res = $this->https_request($url);
            $result = json_decode($res, true);
            $this->js_ticket = $result["ticket"];

            $wxDbObj->db_accesstoken_save($appid, $appsecret, $this->lasttime, $this->access_token,$this->js_ticket);
        }
        else
        {
            $this->lasttime = $result["lasttime"];
            $this->access_token = $result["access_token"];
            $this->js_ticket = $result["js_ticket"];
        }
    }

    //强制刷微信token, 由于一天最多2000次，所以强制刷新间隔不能超过45 （24x60x60)/2000=43.2
    public function compel_get_token($appid, $appsecret)
    {
        $wxDbObj = new class_wx_db();
        $result = $wxDbObj->db_accesstoken_inqury($appid, $appsecret);
        if (($result == "NOTEXIST") || (time() > $result["lasttime"] + 60))
        {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->appid . "&secret=" . $this->appsecret;
            $res = $this->https_request($url);
            $result = json_decode($res, true);
            //下一步存在当前临时变量和数据库中
            $this->lasttime = time();
            $this->access_token = $result["access_token"];

            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=" . $this->access_token;
            $res = $this->https_request($url);
            $result = json_decode($res, true);
            $this->js_ticket = $result["ticket"];

            $wxDbObj->db_accesstoken_save($appid, $appsecret, $this->lasttime, $this->access_token,$this->js_ticket);
        }
        else
        {
            $this->lasttime = $result["lasttime"];
            $this->access_token = $result["access_token"];
            $this->js_ticket = $result["js_ticket"];
        }
    }

    //获取关注者列表
    public function get_user_list($next_openid = NULL)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=" . $this->access_token . "&next_openid=" . $next_openid;
        $res = $this->https_request($url);
        return json_decode($res, true);
    }

    //获取用户基本信息
    public function get_user_info($openid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $this->access_token . "&openid=" . $openid . "&lang=zh_CN";
        $res = $this->https_request($url);
        return json_decode($res, true);
    }

    //创建菜单
    //POST
    public function create_menu($data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $this->access_token;
        $res = $this->https_request($url, $data);
        return json_decode($res, true);
    }

    //删除菜单
    //GET
    public function delete_menu()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=" . $this->access_token;
        $res = $this->https_request($url);
        return json_decode($res, true);
    }

    //查询菜单
    //GET
    public function inquery_menu()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=" . $this->access_token;
        $res = $this->https_request($url);
        return json_decode($res, true);
    }

    //发送客服消息，已实现发送文本，其他类型可扩展
    public function send_custom_message($touser, $type, $data)
    {
        $msg ['touser'] = $touser;
        switch ($type) {
            case "text":
                $msg['msgtype'] = "text";
                //$msg['text'] = array('content' => urlencode($data));
                $msg['text'] = array('content' => $data);
                break;
        }
        $msg = json_encode($msg);
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $this->access_token;
        $res = $this->https_request($url, $msg);
        return json_decode($res, true);
    }

    //生成参数二维码
    public function create_qrcode($scene_type, $scene_id)
    {
        $data = NULL;
        switch ($scene_type) {
            case 'QR_LIMIT_SCENE': //永久
                $data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": ' . $scene_id . '}}}';
                break;
            case 'QR_SCENE':       //临时
                $data = '{"expire_seconds": 1800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": ' . $scene_id . '}}}';
                break;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $this->access_token;
        $res = $this->https_request($url, $data);
        $result = json_decode($res, true);
        return "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($result["ticket"]);
    }

    //创建分组
    public function create_group($name)
    {
        $data = '{"group": {"name": "' . $name . '"}}';
        $url = "https://api.weixin.qq.com/cgi-bin/groups/create?access_token=" . $this->access_token;
        $res = $this->https_request($url, $data);
        return json_decode($res, true);
    }

    //移动用户分组
    public function update_group($openid, $to_groupid)
    {
        $data = '{"openid":"' . $openid . '","to_groupid":' . $to_groupid . '}';
        $url = "https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=" . $this->access_token;
        $res = $this->https_request($url, $data);
        return json_decode($res, true);
    }

    //上传多媒体文件
    public function upload_media($type, $file)
    {
        $data = array("media" => "@" . dirname(__FILE__) . '\\' . $file);
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=" . $this->access_token . "&type=" . $type;
        $res = $this->https_request($url, $data);
        return json_decode($res, true);
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

    //以下部分为硬件公号相关的功能部分

    //MSG_1.1-1.2 设备通过微信发消息给第三方，以及设备绑定/解绑信息
    //这里的消息属于处理函数并发送返回消息功能
    //输入的$data属于XML解码后的数据，不是Json数据，全部是SimpleXMLElement Object结构体，只能使用指针访问
    //POST方式

    //XML回复消息接口: DEVICE_TEXT
    public function xms_responseDeviceText($toUser, $fromUser, $deviceType, $deviceID, $sessionID, $content)
    {
        $xmlTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%u</CreateTime>
            <MsgType><![CDATA[device_text]]></MsgType>
            <DeviceType><![CDATA[%s]]></DeviceType>
            <DeviceID><![CDATA[%s]]></DeviceID>
            <SessionID>%u</SessionID>
            <Content><![CDATA[%s]]></Content></xml>";
        $result = sprintf($xmlTpl, $toUser, $fromUser, time(), $deviceType, $deviceID, $sessionID, $content);
        return $result;
    }

    //XML回复消息接口: DEVICE_EVENT
    public function xms_responseDeviceEvent($toUser, $fromUser, $event, $deviceType, $deviceID, $sessionID, $content)
    {
        $xmlTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%u</CreateTime>
            <MsgType><![CDATA[device_event]]></MsgType>
            <Event><![CDATA[%s]]></Event>
            <DeviceType><![CDATA[%s]]></DeviceType>
            <DeviceID><![CDATA[%s]]></DeviceID>
            <SessionID>%u</SessionID>
            <Content><![CDATA[%s]]></Content></xml>";
        $result = sprintf($xmlTpl, $toUser, $fromUser, time(), $event, $deviceType, $deviceID, $sessionID, $content);
        return $result;
    }

    //XML回复消息接口: TEXT
    public function xms_responseText($toUser, $fromUser,$content)
    {
        $xmlTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content></xml>";
        $result = sprintf($xmlTpl, $toUser, $fromUser, time(), $content);
        return $result;
    }

    //API_1.3 第三方发送消息给硬件设备
    //POST方式
    //这个是在用户使用扫码关注后，才能干这件事，否则返回ErrorMsg
    //content内容是明文，Base64编码在本函数直接完成
    public function trans_msgtodevice($deviceType, $deviceId, $openId, $content)
    {
        $data = array("device_type" => $deviceType, "device_id" => $deviceId, "open_id" => $openId, "content" => base64_encode($content));
        $url = "https://api.weixin.qq.com/device/transmsg?access_token=" . $this->access_token;
        $res = $this->https_request($url, json_encode($data));
        return json_decode($res, true);
    }

    //API_1.4 获取硬件设备OPEN-ID
    //GET方式
    public function get_openIDbyDeviceId($deviceType, $deviceId)
    {
        $url = "https://api.weixin.qq.com/device/get_openid?access_token=" . $this->access_token . "&device_type=" . $deviceType . "&device_id=" . $deviceId ;
        $res = $this->https_request($url);
        return json_decode($res, true);
    }

    //API_1.5 生成硬件设备二维码
    //本函数只取出了第一个DEVICEID，并没有取出全部
    //完整的本函数应该返回完整地DEVICE_LIST
    //由于微信本身的原因，这个函数并不成功，因为根据这个生成的二维码通不过验证
    //至于BlueLight Java官方DEMO为什么可以成功，还需要进一步了解
    //POST方式
    public function create_qrcodebyDeviceid($deviceId)
    {
        $data = '{"device_num": 1, "device_id_list": ["' . $deviceId . '"]}';
        $url = "https://api.weixin.qq.com/device/create_qrcode?access_token=" . $this->access_token;
        $res = $this->https_request($url, $data);
        $result = json_decode($res, true);
        //var_dump($result);
        //return urlencode($result["code_list"][0]["ticket"]); //为了安全，做了转义
        return $result["code_list"][0]["ticket"];
    }

    //本TOOL主函数调用，设备授权调用主函数
    public function device_AuthBLE($deviceId, $mac)
    {
        $authKey = "";		//"1234567890ABCDEF1234567890ABCD11"  这里不加密
        $mac1 = $mac;//"1234567890AB";
        $isCreate = 1;	//是否首次授权： true 首次授权； false 更新设备属性
        return $this->device_AuthAndUpdate($authKey, $deviceId, $mac1, $isCreate);
    }

    /**
     * API_1.6 / API_1.11.2 设备授权
     * @param authKey 加密key
     * @param deviceId 设备id
     * @param mac 设备的mac地址
     * @param 是否首次授权： true 首次授权； false 更新设备属性
     * POST方式
     */
    public function device_AuthAndUpdate($authKey, $deviceId, $mac, $isCreate)
    {
        $device_list[0] = array(
            "id" => "$deviceId",  //设备id
            "mac" => "$mac",    //设备的mac地址 采用16进制串的方式（长度为12字节），不需要0X前缀，如： 1234567890AB
            "connect_protocol" => "3",  //设备类型 android classic bluetooth – 1 ios classic bluetooth – 2 ble – 3 wifi -- 4
            /**
             * 连接策略，32位整型，按bit位置位，目前仅第1bit和第3bit位有效（bit置0为无效，1为有效；第2bit已被废弃），且bit位可以按或置位
             * （如1|4=5），各bit置位含义说明如下：<br/>
             * 1：（第1bit置位）在公众号对话页面，不停的尝试连接设备<br/>
             * 4：（第3bit置位）处于非公众号页面（如主界面等），微信自动连接。当用户切换微信到前台时，可能尝试去连接设备，连上后一定时间会断开<br/>
             * 8：（第4bit置位），进入微信后即刻开始连接。只要微信进程在运行就不会主动断开
             */
            // 不加密时 authKey 为空字符串，crypt_method、auth_ver都为0
            // 加密时 authKey 需为符合格式的值，crypt_method、auth_ver都为1
            "auth_key" => "$authKey",  //加密key 1234567890ABCDEF1234567890ABCDEF
            "close_strategy" => "2", //1：退出公众号页面时断开 2：退出公众号之后保持连接不断开 3：一直保持连接（设备主动断开连接后，微信尝试重连）
            "conn_strategy" => "1", //连接策略
            "crypt_method" => "0", //auth加密方法  0：不加密 1：AES加密
            "auth_ver" => "0", //0：不加密的version 1：version 1
            // 低功耗蓝牙必须为-1
            "manu_mac_pos" => "-1", //表示mac地址在厂商广播manufature data里含有mac地址的偏移，取值如下： -1：在尾部、 -2：表示不包含mac地址
            "ser_mac_pos" => "-2" //表示mac地址在厂商serial number里含有mac地址的偏移，取值如下： -1：表示在尾部 -2：表示不包含mac地址 其他：非法偏移
        );  //第二部分搞定
        $device = array ("device_num" => "1", "device_list" => $device_list, "op_type" => $isCreate);
        // 调用授权
        //API 11.2, 利用Device_ID生成Json，并调用API，从而授权设备
        $url = "https://api.weixin.qq.com/device/authorize_device?access_token=" . $this->access_token;
        $res = $this->https_request($url, json_encode($device));
        return json_decode($res, true);
    }

    //API_1.7 获取硬件状态
    //只要DEVICE_ID
    //GET方式
    public function getstat_qrcodebyDeviceid($deviceId)
    {
        $url = "https://api.weixin.qq.com/device/get_stat?access_token=" . $this->access_token . "&device_id=" .$deviceId ;
        $res = $this->https_request($url);
        return json_decode($res, true);
    }

    //MSG_1.8 接入社交功能消息
    //class_wechat中transmitSocialMessage($object)函数功能体，暂时不清楚Myrank/Ranklist的生成方法

    //API_1.9 验证硬件设备二维码
    //POST方式
    public function verify_qrcode($ticket)
    {
        $data = '{"ticket":"' . $ticket . '"}';
        $url = "https://api.weixin.qq.com/device/verify_qrcode?access_token=" . $this->access_token;
        $res = $this->https_request($url, $data);
        return json_decode($res, true);
    }

    //MSG_1.10.2 WIFI设备消息接口：用户订阅/退订设备状态
    //to be update

    //API_1.10.3 第三方主动发送消息给硬件设备
    public function trans_msgtodeviceWIFI($deviceType, $deviceId, $openId, $msgType, $device_status)
    {
        $data = array("device_type" => $deviceType, "device_id" => $deviceId, "open_id" => $openId, "msg_type" => $msgType, "device_status" =>$device_status);
        $url = "https://api.weixin.qq.com/device/transmsg?access_token=" . $this->access_token;
        $res = $this->https_request($url, json_encode($data));
        return json_decode($res, true);
    }

    //API_11.1 创建DeviceId + QrCode合二为一的方式，在PHP环境下使用成功，而且在微信测试界面通过测试
    //GET方式
    public function create_DeviceidAndQrcode()
    {
        $url = "https://api.weixin.qq.com/device/getqrcode?access_token=" . $this->access_token;
        $res = $this->https_request($url);
        return json_decode($res, true);
    }

    //引入核心库文件，在界面上显示二维码图像
    public function create_qrcodeDisplay($url)
    {
        //帮助之地：
        //  http://www.jb51.net/article/48124.htm
        //  http://jingyan.baidu.com/article/4b52d70277fbd6fc5d774b61.html

        include "phpqrcode/phpqrcode.php";
        //定义纠错级别
        $errorLevel = "L";
        //定义生成图片宽度和高度;默认为3
        $size = "4";
        //定义生成内容
        $content="微信公众平台：思维与逻辑;公众号:siweiyuluoji";
        //调用QRcode类的静态方法png生成二维码图片//
        //QRcode::png($content, false, $errorLevel, $size);
        //生成网址类型
        /*
        $url="http://jingyan.baidu.com/article/48a42057bff0d2a925250464.html";
        $url.="\r\n";
        $url.="http://jingyan.baidu.com/article/acf728fd22fae8f8e510a3d6.html";
        $url.="\r\n";
        $url.="http://jingyan.baidu.com/article/92255446953d53851648f412.html";
        */
        QRcode::png($url, 'qrcode.png', $errorLevel, $size);
        echo '<img src="../l4oamtools/qrcode.png">';
        return true;
    }

    //API_1.12.1 绑定成功通知
    //POST方式
    public function notify_bindSuccessful($ticket, $deviceId, $openId)
    {
        $data = '{"ticket":"' . $ticket . '","device_id":"' . $deviceId . '","openid":"' . $openId . '"}';
        $url = "https://api.weixin.qq.com/device/bind?access_token=" . $this->access_token;
        $res = $this->https_request($url, $data);
        return json_decode($res, true);
    }

    //API_1.12.2 解绑成功通知
    //POST方式
    public function notify_unbindSuccessful($ticket, $deviceId, $openId)
    {
        $data = '{"ticket":"' . $ticket . '","device_id":"' . $deviceId . '","openid":"' . $openId . '"}';
        $url = "https://api.weixin.qq.com/device/unbind?access_token=" . $this->access_token;
        $res = $this->https_request($url, $data);
        return json_decode($res, true);
    }

    //API_1.12.3 强制绑定用户和设备 （意味着不是通过扫码完成的)
    //POST方式
    public function compel_bind($deviceId, $openId)
    {
        $data = '{"device_id":"' . $deviceId . '","openid":"' . $openId . '"}';
        $url = "https://api.weixin.qq.com/device/compel_bind?access_token=" . $this->access_token;
        $res = $this->https_request($url, $data);
        return json_decode($res, true);
    }

    //API_1.12.4 强制解绑用户和设备 （意味着不是通过微信界面操作完成)
    //POST方式
    public function compel_unbind($deviceId, $openId)
    {
        $data = '{"device_id":"' . $deviceId . '","openid":"' . $openId . '"}';
        $url = "https://api.weixin.qq.com/device/compel_unbind?access_token=" . $this->access_token;
        $res = $this->https_request($url, $data);
        return json_decode($res, true);
    }

    //API_1.13 获取硬件状态， 只要openid
    //GET方式
    //这个是在用户使用扫码关注后，才能干这件事，否则返回ErrorMsg
    public function getstat_qrcodebyOpenId($openId)
    {
        $url = "https://api.weixin.qq.com/device/get_bind_device?access_token=" . $this->access_token . "&openid=" .$openId ;
        $res = $this->https_request($url);
        return json_decode($res, true);
    }

    /******************************************************************************************************************
    *                                               自定义API部分                                                     *
    ******************************************************************************************************************/
    //接收微信消息类型为“device_text”的处理函数，传入data为下位机发送的16进制码流
    public function receive_wx_deviceMessage($data)
    {
        //发送到L3的比特流还需要进行base64解码和16进制unpack
        $content = base64_decode($data->Content);
        $content = unpack('H*',$content);
        $strContent = strtoupper($content["1"]); //转换成16进制格式的字符串

        $fromUser = trim($data->FromUserName);
        $deviceId = trim($data->DeviceID);

        $logDbObj = new class_common_db();
        $wx_trace = $logDbObj->db_LogSwitchInfo_inqury($fromUser);
        if ($wx_trace == 1) //打印收到的device消息
        {
            $msgContent = "R:DEVICE_TEXT= " . $strContent;
            $this->send_custom_message(trim($data->FromUserName), "text", $msgContent);  //使用API-CURL推送客服微信用户
        }
        //调用统一的deviceTask处理入口函数
        $resp_msg = $this->ihu_deviceTaskProcess("device_text", $strContent, $fromUser, $deviceId);

        $wxDbObj = new class_wx_db();
        $db_info = $wxDbObj->db_blebound_query($data->FromUserName);  //查询该用户是否是绑定用户
        if ($db_info == true && !empty($resp_msg) )
        {
            $check = unpack('A5Hint', $resp_msg);
            if($check['Hint'] == "ERROR")
                return $resp_msg;

            $i = 0;
            while ($i<count($db_info)) //考虑同一个用户绑定多个设备的情况,循环发送response给该用户绑定的所有设备
            {
                $dev_table = $db_info[$i];
                $result = $this->trans_msgtodevice($dev_table["deviceType"], $dev_table["deviceID"], $dev_table["openID"], $resp_msg);
                /*
                if ($result["errcode"] ==40001)  //防止偶然未知原因导致token失效，强制刷新token并再次发送
                {
                    $this->compel_get_token($this->appid,$this->appsecret);
                    $result = $this->trans_msgtodevice($dev_table["deviceType"], $dev_table["deviceID"], $dev_table["openID"], $resp_msg);
                }
                */
                $i++;
            }
            //推送回复消息给微信界面
            if ($wx_trace == 1)
            {
                //$msg_body = unpack('H*',$resp_msg);
                //$str_body = strtoupper($msg_body["1"]);
                $transMsg = $this->send_custom_message(trim($data->FromUserName), "text",
                    "T:DEVICE_TEXT= " . $resp_msg . "\n Result= " . json_encode($result));
            }
            else{
                $transMsg = $result;
            }
        }
        else{
            $transMsg = $resp_msg;
        }

        return $transMsg;
    } //receive_deviceMessage处理结束

    //接收微信消息类型为“device_event”的处理函数，传入data为下位机发送的16进制码流
    public function receive_wx_deviceEvent($data)
    {
        $content = base64_decode($data->Content);
        $content = unpack('H*',$content);
        $strContent = strtoupper($content["1"]);//转换成16进制格式的字符串

        //这里有个假设：解绑来自于用户的操作，Event/Ubscribe和Event_device/Ubind是分离的
        $wxDbObj = new class_wx_db();
        switch ($data->Event)
        {
            case "bind":
                $resp1 = "R:DEVICE_EVENT=bind\n";
                $result = $wxDbObj->db_blebound_duplicate($data->FromUserName, $data->DeviceID, $data->OpenID, $data->DeviceType);
                if ($result == true)
                    $resp2 = "Result= BLE device user bind duplicate, ";
                else
                {
                    $wxDbObj->db_blebound_save($data->FromUserName, $data->DeviceID, $data->OpenID, $data->DeviceType);
                    $resp2 = "Result= BLE device user bind OK,";
                }
                $db_table = $wxDbObj->db_deviceqrcode_query($data->DeviceID,$data->DeviceType);
                if ($db_table == true)
                {
                    if (!empty($db_table["mac"]))
                    {

                        $this->device_AuthBLE($db_table["deviceid"], $db_table["mac"]);
                        $this->compel_bind($data->DeviceID, $data->OpenID);
                        $resp3 = "Weixin device MAC bind OK";
                    }
                    else
                        $resp3 = "Illegal device, no MAC assigned!";
                }
                else
                    $resp3 = "No deviceid or qrcode in l1comdbi";

                $respMsg = $resp1 . $resp2 . $resp3;
                break;

            case "unbind":
                $result = $wxDbObj->db_blebound_delete($data->FromUserName);
                $respMsg = "R:DEVICE_EVENT=unbind, Result= " . $result;
                break;
            default:
                $respMsg = "R:DEVICE_EVENT=unknown event, Result= ". $data->Event;
                break;
        }

        //因为是DEVICE_EVENT事件，设备内传输的L3信息应该是空的，这里保留设备L3消息相关处理
        $event_resp = $this->ihu_deviceTaskProcess("device_text", $strContent, $data->FromUserName, $data->DeviceID);

        $logDbObj = new class_common_db();
        $wx_trace = $logDbObj->db_LogSwitchInfo_inqury($data->FromUserName);
        if ($wx_trace == 1)
            $transMsg = $this->send_custom_message(trim($data->FromUserName), "text", $respMsg . "\n" . json_encode($event_resp));
        else
            $transMsg = $respMsg;

        return $transMsg;
    }

    //用户自己定义的微信点击菜单命令“event->CLICK”处理函数
    public function receive_wx_deviceClick($data)
    {
        switch($data->EventKey) {
            case "CLICK_USER":
                $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName, "Appid = " . $this->appid . "\nTokenID = " . $this->access_token ."\nJS_ticket =" . $this->js_ticket);
                break;
            case "CLICK_VERSION":
                $wxDbObj = new class_wx_db();
                $db_info = $wxDbObj->db_blebound_query($data->FromUserName);

                if ($db_info == false)
                {
                    $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName, "No device bind for this user in database");
                }
                else
                {
                    //对版本读取操作进行层三处理，构造可以发送给硬件设备的信息
                    $msg_body = $this->ihu_deviceTaskProcess($data->EventKey, "", $data->FromUserName, $data->DeviceID);

                    if (!empty($msg_body))
                    {
                        $i = 0;
                        while ($i<count($db_info)) //考虑同一个用户绑定多个设备的情况,循环发送命令给该用户绑定的所有设备
                        {
                            $dev_table = $db_info[$i];
                            //BYTE系列化处理在L3消息处理过程中已完成，推送数据到硬件设备
                            $result = $this->trans_msgtodevice($dev_table["deviceType"], $dev_table["deviceID"], $dev_table["openID"], $msg_body);
                            /*
                            if ($result["errcode"] ==40001)  //防止偶然未知原因导致token失效，强制刷新token并再次发送
                            {
                                $this->compel_get_token($this->appid,$this->appsecret);
                                $result = $this->trans_msgtodevice($dev_table["deviceType"], $dev_table["deviceID"], $dev_table["openID"], $msg_body);
                            }
                            */
                            $i++;
                        }
                    }
                    //推送回复消息给微信界面
                    $logDbObj = new class_common_db();
                    $wx_trace = $logDbObj->db_LogSwitchInfo_inqury($data->FromUserName);
                    if ($wx_trace ==1)
                    {
                        $str_body = unpack('H*',$msg_body);
                        $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName,
                            "Send VERSION_PUSH to Device" ."\n Result= " .json_encode($result) . "\n Content= " . json_encode($str_body));
                    }
                    else
                        $transMsg = $result;
                }
                break;
            case "CLICK_BIND":
                $transMsg = $this->click_bindCommand ($data); //强制绑定该用户，用于测试目的
                break;
            case "CLICK_BIND_INQ":
                //增加第三方后台云的绑定状态
                $wxDbObj = new class_wx_db();
                $result = $wxDbObj->db_blebound_query($data->FromUserName);
                if ($result == false)
                {
                    $dbResp = "DB User-Device bind: None";
                }
                else
                {
                    $dev_table = $result[0];
                    $res = $wxDbObj->db_deviceqrcode_query($dev_table["deviceID"], $dev_table["deviceType"]);
                    $dbResp = "DB User-Device bind: Yes, MAC=" . json_encode($res["mac"]);
                }
                //再查微信云上的绑定状态
                $result = $this->getstat_qrcodebyOpenId($data->FromUserName);
                /*
                if ($result["errcode"] ==40001)  //防止偶然未知原因导致token失效，强制刷新token并再次发送
                {
                    $this->compel_get_token($this->appid,$this->appsecret);
                    $result = $this->getstat_qrcodebyOpenId($data->FromUserName);
                }
                */
                if (count($result["device_list"]) == 0)
                    $wxResp = "Weixin User get_bind_device, result=" .  json_encode($result["resp_msg"]);
                else
                    $wxResp = "Weixin User get_bind_device, result=" . json_encode($result["device_list"]);

                $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName, $dbResp . " \n" . $wxResp);
                break;
            case "CLICK_UNBIND":
                //先解绑微信云上的绑定状态
                //这里就考虑一个设备，如果存储多个设备的话，需要多次解绑
                $result = $this->getstat_qrcodebyOpenId($data->FromUserName);

                /*
                if ($result["errcode"] ==40001)  //防止偶然未知原因导致token失效，强制刷新token并再次发送
                {
                    $this->compel_get_token($this->appid,$this->appsecret);
                    $result = $this->getstat_qrcodebyOpenId($data->FromUserName);
                }
                */

                if (count($result["device_list"]) != 0)
                {
                    $result = $this->compel_unbind($result["device_list"][0]["device_id"], $data->FromUserName);
                    $wxResp = "Weixin User unbind one device, result=" .  json_encode($result);
                }
                else
                {
                    $wxResp = "No device bind for this user in Weixin, result=" . json_encode($result["resp_msg"]);
                }
                //再解绑第三方数据库的绑定状态
                $wxDbObj = new class_wx_db();
                $db_info = $wxDbObj->db_blebound_query($data->FromUserName);
                if ($db_info == false)
                {
                    $dbResp = "No device bind for this user in database";
                }
                else
                {
                    $wxDbObj->db_blebound_delete($data->FromUserName); //解绑用户和device
                    $dbResp = "All device unbind for this user in database";
                }
                $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName, $dbResp . " \n" . $wxResp);
                break;

            case "CLICK_EMC_READ":
                $wxDbObj = new class_wx_db();
                $db_info = $wxDbObj->db_blebound_query($data->FromUserName);

                if ($db_info == false)
                {
                    $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName, "No device bind for this user in database");
                }
                else
                {
                    //对辐射强度瞬时读取操作进行层三处理，构造可以发送给硬件设备的信息
                    $msg_body = $this->ihu_deviceTaskProcess($data->EventKey, "", $data->FromUserName, $data->DeviceID);

                    if (!empty($msg_body))
                    {
                        $i = 0;
                        while ($i<count($db_info)) //考虑同一个用户绑定多个设备的情况,循环发送命令给该用户绑定的所有设备
                        {
                            $dev_table = $db_info[$i];
                            //BYTE系列化处理在L3消息处理过程中已完成,推送数据到硬件设备
                            $result = $this->trans_msgtodevice($dev_table["deviceType"], $dev_table["deviceID"], $dev_table["openID"], $msg_body);
                            /*
                            if ($result["errcode"] ==40001)  //防止偶然未知原因导致token失效，强制刷新token并再次发送
                            {
                                $this->compel_get_token($this->appid,$this->appsecret);
                                $result = $this->trans_msgtodevice($dev_table["deviceType"], $dev_table["deviceID"], $dev_table["openID"], $msg_body);
                            }
                            */
                            $i++;
                        }
                    }

                    //推送回复消息给微信界面
                    $logDbObj = new class_common_db();
                    $wx_trace = $logDbObj->db_LogSwitchInfo_inqury($data->FromUserName);
                    if ($wx_trace ==1)
                    {
                        $str_body = unpack('H*',$msg_body);
                        $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName,
                            "Send EMC_PUSH to Device" ."\n Result= " .json_encode($result) . "\n Content= " . json_encode($str_body));
                        //$transMsg = $this->send_custom_message(trim($data->FromUserName),"text",
                        //    "Send EMC_PUSH to Device" ."\n Result= " .json_encode($result) . "\n Content= " . json_encode($str_body));
                    }
                    else
                        $transMsg = $result;
                }
                break;
            case "CLICK_PM25_READ":
                $wxDbObj = new class_wx_db();
                $db_info = $wxDbObj->db_blebound_query($data->FromUserName);

                if ($db_info == false)
                {
                    $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName, "No device bind for this user in database");
                }
                else
                {
                    //对PM2.5读取操作进行层三处理，构造可以发送给硬件设备的信息
                    $msg_body = $this->ihu_deviceTaskProcess($data->EventKey, "", $data->FromUserName, $data->DeviceID);

                    if (!empty($msg_body))
                    {
                        $i = 0;
                        while ($i<count($db_info)) //考虑同一个用户绑定多个设备的情况,循环发送命令给该用户绑定的所有设备
                        {
                            $dev_table = $db_info[$i];
                            //BYTE系列化处理在L3消息处理过程中已完成,推送数据到硬件设备
                            $result = $this->trans_msgtodevice($dev_table["deviceType"], $dev_table["deviceID"], $dev_table["openID"], $msg_body);

                            /*
                            if ($result["errcode"] ==40001)  //防止偶然未知原因导致token失效，强制刷新token并再次发送
                            {
                                $this->compel_get_token($this->appid,$this->appsecret);
                                $result = $this->trans_msgtodevice($dev_table["deviceType"], $dev_table["deviceID"], $dev_table["openID"], $msg_body);
                            }
                            */
                            $i++;
                        }
                    }

                    //推送回复消息给微信界面
                    $logDbObj = new class_common_db();
                    $wx_trace = $logDbObj->db_LogSwitchInfo_inqury($data->FromUserName);
                    if ($wx_trace ==1)
                    {
                        $str_body = unpack('H*',$msg_body);
                        $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName,
                            "Send PM2.5_PUSH to Device" . "\n Result= " .json_encode($result) . "\n Content= " . json_encode($str_body));
                        //$transMsg = $this->send_custom_message(trim($data->FromUserName),"text",
                        //    "Send PM2.5_PUSH to Device" . "\n Result= " .json_encode($result) . "\n Content= " . json_encode($str_body));
                    }
                    else
                        $transMsg = $result;
                }
                break;
            case "CLICK_TRACE_ON":
                $trace_set = 1;
                $logDbObj = new class_common_db();
                $result = $logDbObj->db_LogSwitchInfo_set($data->FromUserName,$trace_set);
                $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName, "设置微信log打印开关ON，Result=" . json_encode($result));
                break;

            case "CLICK_TRACE_OFF":
                $trace_set = 0;
                $logDbObj = new class_common_db();
                $result = $logDbObj->db_LogSwitchInfo_set($data->FromUserName,$trace_set);
                $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName, "设置微信log打印开关OFF，Result=" . json_encode($result));
                break;

            default:
                $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName,"收到未识别菜单EventKey值");
                break;
        }
        return $transMsg;
    }//End of receive_deviceClickCommand

    //统一的deviceTask处理入口函数
    public function ihu_deviceTaskProcess ($optType, $content, $fromuser, $deviceid)
    {
        switch ($optType)
        {
            case "device_text":
                $respContent = $this->ihu_device_text_process($fromuser, $deviceid, $content);
                break;
            case "bind":
                $respContent = $this->ihu_bind_process($content);
                break;
            case "unbind":
                $respContent = $this->ihu_unbind_process($content);
                break;
            case "CLICK_EMC_READ":
                $ihuObj = new class_emc_service();
                $respContent = $ihuObj->func_emc_data_push_process();
                break;
            case "CLICK_PM25_READ":
                $ihuObj = new class_pmData_service();
                $respContent = $ihuObj->func_pm_data_push_process();
                break;
            case "CLICK_VERSION":
                $ihuObj = new class_common_service();
                $respContent = $ihuObj->func_version_push_process();
                break;
            default:
                $respContent = "";
                break;
        }
        return $respContent;
    }

    //Layer3 业务消息的处理函数，跳转到对应的业务处理模块
    public function ihu_device_text_process($fromUser, $deviceId, $content)
    {
        //因为收到的Airsync数据消息头已经被微信处理掉，传递过来的消息体在上级函数中已经被处理成16制格式的字符串
        if (strlen($content) < IHU_MSG_HEAD_LENGTH) {
            return "ERROR WX_IOT: invalid message";  //消息长度小于固定消息头的长度
        }
        $raw_MsgHead = substr($content, 0, IHU_MSG_HEAD_LENGTH);  //截取12Byte MsgHead
        $msgHead = unpack(IHU_MSG_HEAD_FORMAT, $raw_MsgHead);

        $length = hexdec($msgHead['Length']) & 0xFFFF; //total length包括长度域本身
        $length =  $length * 2; //因为收到的消息为16进制字符，消息总长度等于实际长度的2倍
        if ($length != strlen($content)) {
            return "ERROR WX_IOT: message length invalid";  //消息长度不合法，直接返回
        }

        $data = substr($content, IHU_MSG_HEAD_LENGTH, $length - IHU_MSG_HEAD_LENGTH); //截取消息数据域
        $ctrl_key = hexdec($msgHead['CmdId']) & 0xFFFF;
        $statCode = "";
        switch ($ctrl_key)
        {
            case CMDID_VERSION_SYNC:
                //定时辐射强度处理
                $ihuObj = new class_common_service();
                $resp = $ihuObj->func_version_update_process(PLTF_WX, $deviceId, $data);
                break;
            case CMDID_TIME_SYNC:
                $ihuObj = new class_common_service();
                $msg_body = $ihuObj->func_timeSync_process(PLTF_WX, $deviceId, $data);
                if(!empty($msg_body))
                    $resp = pack('H*',$msg_body);
                else
                    $resp = $msg_body;
                break;
            case CMDID_EMC_DATA_RESP://定时辐射强度处理
                $ihuObj = new class_emc_service();
                $resp = $ihuObj->func_emc_process(PLTF_WX, $deviceId, $statCode, $data);
                break;
            case CMDID_PM_DATA:
                //MODBUS数据处理
                $ihuObj = new class_pmData_service();
                $resp = $ihuObj->func_pmData_process(PLTF_WX, $deviceId, $statCode, $data);
                break;
            case CMDID_WINDSPEED_DATA:
                $ihuObj = new class_windSpeed_service();
                $resp = $ihuObj->func_windSpeed_process(PLTF_WX, $deviceId, $statCode, $data);
                break;
            case CMDID_WINDDIR_DATA:
                $ihuObj = new class_windDirection_service();
                $resp = $ihuObj->func_windDirection_process(PLTF_WX, $deviceId, $statCode, $data);
                break;
            case CMDID_TEMPERATURE_DATA:
                $ihuObj = new class_temperature_service();
                $resp = $ihuObj->func_temperature_process(PLTF_WX, $deviceId, $statCode, $data);
                break;
            case CMDID_HUMIDITY_DATA:
                $ihuObj = new class_humidity_service();
                $resp = $ihuObj->func_humidity_process(PLTF_WX, $deviceId, $statCode, $data);
                break;
            default:
                $resp ="ERROR WX_IOT: invalid service type";
                break;
        }
        return $resp;
    }

    //来自设备的bind事件，类似手环敲击进行绑定
    private function ihu_bind_process($content)
    {
        //目前假设是空包，所以不处理
        return "";
    }

    //来自设备的unbind事件
    private function ihu_unbind_process($content)
    {
        //目前假设是空包，所以不处理
        return "";
    }

    //强制绑定菜单处理函数，主要用于调试目的
    public function click_bindCommand ($data)
    {
        $wxDbObj = new class_wx_db();
        switch ($data->FromUserName){
            case LZH_openid:
                $result = $wxDbObj->db_blebound_duplicate(LZH_openid, LZH_deviceid, LZH_openid, device_type);
                if ($result == false)
                {
                    $result = $wxDbObj->db_blebound_save(LZH_openid, LZH_deviceid, LZH_openid, device_type);
                    $this->send_custom_message(trim($data->FromUserName), "text","User-Device DB bind, Result= ".json_encode($result) );
                }
                else
                    $this->send_custom_message(trim($data->FromUserName), "text","User-Device DB duplicated, no action");

                $result = $wxDbObj->db_deviceqrcode_save(LZH_deviceid, LZH_qrcode, device_type, LZH_mac);
                $this->send_custom_message(trim($data->FromUserName), "text","Qrcode-MAC DB bind, Result= " .json_encode($result));

                $this->device_AuthBLE(LZH_deviceid, LZH_mac);
                $result = $this->compel_bind(LZH_deviceid, LZH_openid);
                $this->send_custom_message(trim($data->FromUserName), "text","Weixin User-Device compel_bind, Result= " .json_encode($result));

                $result = $this->getstat_qrcodebyOpenId($data->FromUserName);
                $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName,"Weixin get_bind_device , Result= " .json_encode($result));

                break;
            case ZJL_openid:
                $result = $wxDbObj->db_blebound_duplicate(ZJL_openid, ZJL_deviceid, ZJL_openid, device_type);
                if ($result == false)
                {
                    $result = $wxDbObj->db_blebound_save(ZJL_openid, ZJL_deviceid, ZJL_openid, device_type);
                    $this->send_custom_message(trim($data->FromUserName), "text","User-Device DB bind, Result= ".json_encode($result) );
                }
                else
                    $this->send_custom_message(trim($data->FromUserName), "text","User-Device DB duplicated, no action");

                $this->device_AuthBLE(ZJL_deviceid, ZJL_mac);
                $result = $wxDbObj->db_deviceqrcode_save(ZJL_deviceid, ZJL_qrcode, device_type, ZJL_mac);
                $this->send_custom_message(trim($data->FromUserName), "text","Qrcode-MAC DB bind, Result= " .json_encode($result));

                $result = $this->compel_bind(ZJL_deviceid, ZJL_openid);
                $this->send_custom_message(trim($data->FromUserName), "text","Weixin User-Device compel_bind, Result= " .json_encode($result));

                $result = $this->getstat_qrcodebyOpenId($data->FromUserName);
                $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName,"Weixin get_bind_device , Result= " .json_encode($result));
                break;

            case MYC_openid:
                $result = $wxDbObj->db_blebound_duplicate(MYC_openid, MYC_deviceid, MYC_openid, device_type);
                if ($result == false)
                {
                    $result = $wxDbObj->db_blebound_save(MYC_openid, MYC_deviceid, MYC_openid, device_type);
                    $this->send_custom_message(trim($data->FromUserName), "text","User-Device DB bind, Result= ".json_encode($result) );
                }
                else
                    $this->send_custom_message(trim($data->FromUserName), "text","User-Device DB duplicated, no action");

                $result = $wxDbObj->db_deviceqrcode_save(MYC_deviceid, MYC_qrcode, device_type, MYC_mac);
                $this->send_custom_message(trim($data->FromUserName), "text","Qrcode-MAC DB bind, Result= " .json_encode($result));

                $this->device_AuthBLE(MYC_deviceid, MYC_mac);
                $result = $this->compel_bind(MYC_deviceid, MYC_openid);
                $this->send_custom_message(trim($data->FromUserName), "text","Weixin User-Device compel_bind, Result= " .json_encode($result));

                $result = $this->getstat_qrcodebyOpenId($data->FromUserName);
                $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName,"Weixin get_bind_device , Result= " .json_encode($result));
                break;
            case CZ_openid:
                $result = $wxDbObj->db_blebound_duplicate(CZ_openid, CZ_deviceid, CZ_openid, device_type);
                if ($result == false)
                {
                    $result = $wxDbObj->db_blebound_save(CZ_openid, ZJL_deviceid, CZ_openid, device_type);
                    $this->send_custom_message(trim($data->FromUserName), "text","User-Device DB bind, Result= ".json_encode($result) );
                }
                else
                    $this->send_custom_message(trim($data->FromUserName), "text","User-Device DB duplicated, no action");

                $result = $wxDbObj->db_deviceqrcode_save(CZ_deviceid, CZ_qrcode, device_type, CZ_mac);
                $this->send_custom_message(trim($data->FromUserName), "text","Qrcode-MAC DB bind, Result= " .json_encode($result));

                $this->device_AuthBLE(CZ_deviceid, CZ_mac);
                $result = $this->compel_bind(CZ_deviceid, CZ_openid);
                $this->send_custom_message(trim($data->FromUserName), "text","Weixin User-Device compel_bind, Result= " .json_encode($result));

                $result = $this->getstat_qrcodebyOpenId($data->FromUserName);
                $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName,"Weixin get_bind_device , Result= " .json_encode($result));
                break;
            case QL_openid:
                $result = $wxDbObj->db_blebound_duplicate(QL_openid, QL_deviceid, QL_openid, device_type);
                if ($result == false)
                {
                    $result = $wxDbObj->db_blebound_save(QL_openid, QL_deviceid, QL_openid, device_type);
                    $this->send_custom_message(trim($data->FromUserName), "text","User-Device DB bind, Result= ".json_encode($result) );
                }
                else
                    $this->send_custom_message(trim($data->FromUserName), "text","User-Device DB duplicated, no action");

                $result = $wxDbObj->db_deviceqrcode_save(QL_deviceid, QL_qrcode, device_type, QL_mac);
                $this->send_custom_message(trim($data->FromUserName), "text","Qrcode-MAC DB bind, Result= " .json_encode($result));

                $this->device_AuthBLE(QL_deviceid, QL_mac);
                $result = $this->compel_bind(QL_deviceid, QL_openid);
                $this->send_custom_message(trim($data->FromUserName), "text","Weixin User-Device compel_bind, Result= " .json_encode($result));

                $result = $this->getstat_qrcodebyOpenId($data->FromUserName);
                $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName,"Weixin get_bind_device , Result= " .json_encode($result));
                break;
            case JT_openid:
                $result = $wxDbObj->db_blebound_duplicate(JT_openid, JT_deviceid, JT_openid, device_type);
                if ($result == false)
                {
                    $result = $wxDbObj->db_blebound_save(JT_openid, JT_deviceid, JT_openid, device_type);
                    $this->send_custom_message(trim($data->FromUserName), "text","User-Device DB bind, Result= ".json_encode($result) );
                }
                else
                    $this->send_custom_message(trim($data->FromUserName), "text","User-Device DB duplicated, no action");

                $result = $wxDbObj->db_deviceqrcode_save(JT_deviceid, JT_qrcode, device_type, JT_mac);
                $this->send_custom_message(trim($data->FromUserName), "text","Qrcode-MAC DB bind, Result= " .json_encode($result));

                $this->device_AuthBLE(JT_deviceid, JT_mac);
                $result = $this->compel_bind(JT_deviceid, JT_openid);
                $this->send_custom_message(trim($data->FromUserName), "text","Weixin User-Device compel_bind, Result= " .json_encode($result));

                $result = $this->getstat_qrcodebyOpenId($data->FromUserName);
                $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName,"Weixin get_bind_device , Result= " .json_encode($result));
                break;
            case ZSC_openid:
                $result = $wxDbObj->db_blebound_duplicate(ZSC_openid, ZSC_deviceid, ZSC_openid, device_type);
                if ($result == false)
                {
                    $result = $wxDbObj->db_blebound_save(ZSC_openid, ZSC_deviceid, ZSC_openid, device_type);
                    $this->send_custom_message(trim($data->FromUserName), "text","User-Device DB bind, Result= ".json_encode($result) );
                }
                else
                    $this->send_custom_message(trim($data->FromUserName), "text","User-Device DB duplicated, no action");

                $result = $wxDbObj->db_deviceqrcode_save(ZSC_deviceid, ZSC_qrcode, device_type, ZSC_mac);
                $this->send_custom_message(trim($data->FromUserName), "text","Qrcode-MAC DB bind, Result= " .json_encode($result));

                $this->device_AuthBLE(ZSC_deviceid, ZSC_mac);
                $result = $this->compel_bind(ZSC_deviceid, ZSC_openid);
                $this->send_custom_message(trim($data->FromUserName), "text","Weixin User-Device compel_bind, Result= " .json_encode($result));

                $result = $this->getstat_qrcodebyOpenId($data->FromUserName);
                $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName,"Weixin get_bind_device , Result= " .json_encode($result));
                break;
            default:
                $transMsg = "Undefined OpenId";
                break;
        }
        return $transMsg;
    } //end of click_bindCommand()


    //接收微信消息类型为“event->LOCATION”的处理函数，获取微信当时的GPS地址
    public function receive_locationEvent($data)
    {
        $user = $data->FromUserName;
        $latitude = (float)($data->Latitude)*100000;
        $longitude = (float)($data->Longitude)*10000;
        $timestamp = time();

        $wxDbObj = new class_wx_db();
        $db_info = $wxDbObj->db_blebound_query($user);

        if ($db_info == false)
        {
            $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName, "数据库中该用户未绑定设备\n".$data->FromUserName);
        }
        else
        {
            $i = 0;
            while ($i<count($db_info)) //考虑同一个用户绑定多个设备的情况
            {
                $dev_table = $db_info[$i];
                $deviceid = $dev_table["deviceID"];
                $wxDbObj->db_emcdata_save_gps($timestamp, $user, $deviceid, $latitude,$longitude);
                $i++;
            }

            $transMsg = $this->xms_responseText($data->FromUserName, $data->ToUserName, "GPS信息更新，纬度 ".$data->Latitude.";经度 ".$data->Longitude);
        }
        return $transMsg;
    }

    //随机字符串
    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function generateDeviceId()
    {
        $tmpArr = array(WX_APPID, $this->generateRandomString(10));
        return implode($tmpArr);
    }

}// End of class_wx_IOT_sdk


?>