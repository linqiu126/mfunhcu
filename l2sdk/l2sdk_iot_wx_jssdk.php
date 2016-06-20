<?php
/**
 * Created by PhpStorm.
 * User: Shanchun
 * Date: 2015/9/8
 * Time: 13:08
 */
include_once "../l1comvm/vmlayer.php";
include_once "../l2sdk/dbi_l2sdk_wx.class.php";

class JSSDK {
    private $appId;
    private $appSecret;
    private $access_token;

    public function __construct($appId, $appSecret) {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        
        /*        
        $wxDbObj = new class_mysql_db();
        $result = $wxDbObj->db_AccessTokenInfo_inqury($appId, $appSecret);

        if (($result == "NOTEXIST") || (time() > $result["lasttime"] + 6500))
        {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->appId . "&secret=" . $this->appSecret;
            $res = $this->httpGet($url);
            $result = json_decode($res, true);
            //下一步存在当前临时变量和数据库中
            $this->lasttime = time();
            $this->access_token = $result["access_token"];
            $wxDbObj->db_AccessTokenInfo_save($appId, $appSecret, $this->lasttime, $this->access_token);
        }
        else{
            $this->lasttime = $result["lasttime"];
            $this->access_token = $result["access_token"];
        }
        */
        
    }

    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();
            // 注意 URL 一定要动态获取，不能 hardcode
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        //$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";   
        
        
        
        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    
    /*
    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新
        
        $data = json_decode(file_get_contents("jsapi_ticket.json"));
        if ($data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            //$accessToken = $this->access_token;
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $fp = fopen("jsapi_ticket.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }

        return $ticket;
               
        
        
    }
    */

    
  
    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新
        
        $wxDbObj = new class_wx_db();
        $result = $wxDbObj->db_accesstoken_inqury($this->appId, $this->appSecret);


        if (($result == "NOTEXIST") || (time() > $result["lasttime"] + 6500))
            {           

            $accessToken = $this->getAccessToken();
            //$accessToken = $this->access_token;
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $this->lasttime = time();
            $this->js_ticket = $res->ticket;
            if ($this->js_ticket) {
                $wxDbObj->db_accesstoken_save($this->appId, $this->appSecret, $this->lasttime, $this->access_token, $this->js_ticket);
            
            }
        }
            
            
        else{           
            
            $this->lasttime = $result["lasttime"];
            $this->js_ticket = $result["js_ticket"];
            }
             return $this->js_ticket;
        
        }

    
   

    private function getAccessToken() {
        // access_token 应该全局存储与更新
        $wxDbObj = new class_wx_db();
        $result = $wxDbObj->db_accesstoken_inqury($this->appId, $this->appSecret);
        //$result = $wxDbObj->db_AccessTokenInfo_inqury(WX_APPID, WX_APPSECRET);

        if (($result == "NOTEXIST") || (time() > $result["lasttime"] + 6500))
        {
            //$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->appId . "&secret=" . $this->appSecret;
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = $this->httpGet($url);
            $result = json_decode($res, true);
            $this->lasttime = time();
            $this->access_token = $result["access_token"];
            //$wxDbObj->db_AccessTokenInfo_save($this->appId, $this->appSecret, $this->lasttime, $this->access_token);
            //remove this line when save access_token & JsApiTicket in function getJsApiTicket();
        }
        else{
            $this->lasttime = $result["lasttime"];
            $this->access_token = $result["access_token"];
        }
        return $this->access_token;
    }

    
    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }
}


?>