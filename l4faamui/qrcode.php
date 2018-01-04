<?php
    require_once('PHPresource/phpqrcode/qrlib.php');
    require_once('PHPresource/phpqrcode/qrconfig.php');

    //"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf2150c4d2941b2ab&redirect_uri=http://www.hkrob.com/mfunhcu/l4faamactive2/index1.html?xhsession=HCU_G5203GTJY_NJ001&response_type=code&scope=snsapi_base&state=STATE&connect_redirect=1#wechat_redirect"
    $static_url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf2150c4d2941b2ab&redirect_uri=http://www.hkrob.com/mfunhcu/l4faamactive2/index1.html";
    function getsession(){
        $strlen = 10;
        $str = "";
        $str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < $strlen; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }

    function buildqrcode($session,$filepath,$url){

        //Final url should be www.xxx.com/xxxx/xxx.html?xhsession=[session]#xxxxxcode=[wecharid]&xxxxxx
        $tempDir = $filepath;

        $codeContents = $url."?xhsession=".$session."#";
        $fileName = $session.'.png';

        $pngAbsoluteFilePath = $tempDir.$fileName;

        QRcode::png($codeContents, $pngAbsoluteFilePath);
        return $pngAbsoluteFilePath;
    }
    function buildcontent($QRcodename,$session){
        $filename = "./qrcodelogin.html";
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize ($filename));
        $contents = str_replace("QRCODE_REPLACE_TAG",$QRcodename,$contents);
        $contents = str_replace("SESSION_REPLACE_TAG",$session,$contents);
        fclose($handle);
        return $contents;
    }

    $session_id= getsession();



    echo buildcontent(buildqrcode($session_id,$static_url,$static_url),$session_id);

?>