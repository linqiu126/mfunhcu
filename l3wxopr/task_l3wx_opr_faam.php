<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/12
 * Time: 17:40
 */
include_once "../l1comvm/vmlayer.php";
include_once "dbi_l3wx_opr_faam.php";
header("Content-type:text/html;charset=utf-8");

$request_body = file_get_contents('php://input','r');
//$request_body = $GLOBALS["HTTP_RAW_POST_DATA"];

//echo $request_body;
$payload = json_decode($request_body,true);

if (isset($payload["codeType"])) $codeType = trim($payload["codeType"]); else $codeType = "";
if (isset($payload["scanCode"])) $scanCode = trim($payload["scanCode"]); else $scanCode = "";
if (isset($payload["latitude"])) $latitude = $payload["latitude"]; else $latitude = 0;
if (isset($payload["longitude"])) $longitude = $payload["longitude"]; else $longitude = 0;
if (isset($payload["nickName"])) $nickName = trim($payload["nickName"]); else $nickName = "";

$l3wxOprFaamDbObj = new classDbiL3wxOprFaam(); //初始化一个UI DB对象
switch($codeType) {
    case "QRCODE_KQ":  //考勤二维码
        $resp = $l3wxOprFaamDbObj->dbi_faam_qrcode_kq_process($scanCode,$latitude,$longitude,$nickName);
        break;

    case "QRCODE_SC":  //生产二维码
        $resp = $l3wxOprFaamDbObj->dbi_faam_qrcode_sc_process();
        break;

    case "QRCODE_SH":  //收货二维码
        $resp = $l3wxOprFaamDbObj->dbi_faam_qrcode_sh_process();
        break;

    default:
        $resp = "";
        break;
}


//这里需要将response返回给微信小程序界面
if (!empty($resp)) {
    $loggerObj = new classApiL1vmFuncCom();
    $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
    $log_content = "T:" . $jsonencode;
    $loggerObj->mylog(MFUN_PRJ_HCU_FAAMWX,$nickName,"MFUN_TASK_ID_L3APPL_FUM11FAAM","NULL","NULL",$log_content);
    echo $jsonencode;
}

//返回
return true;

?>