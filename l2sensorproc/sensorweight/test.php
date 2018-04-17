<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/17
 * Time: 14:45
 */
include_once "task_l2snr_weight.class.php";
$json = '{
        "ToUsr": "XHZN",
        "FrUsr": "HCU_G201_AQYC_SH002",
        "CrTim": 1522728411,
        "MsgTp": "huitp-json",
        "MsgId": 23936,
        "MsgLn": 58,
        "IeCnt": {
                "rfidUser": "1402217203",
                "spsValue": "0.3547781768795756"
                },
        "FnFlg": 0
    }';
$json=json_decode($json);
$toUser = strtoupper(trim($json->ToUsr));
$fromUser = strtoupper(trim($json->FrUsr));
$createTime = intval($json->CrTim);
$msgType = trim($json->MsgTp);
$jsonMsgId = intval($json->MsgId);
$msgLen = intval($json->MsgLn);
$ieCnt = $json->IeCnt;
$ieContent = array("rfidUser"=>$ieCnt->rfidUser, "spsValue"=>$ieCnt->spsValue);

$funcFlag = trim($json->FnFlg);
$msg = array("project" => "1232",
    "devCode" => $fromUser,
    "statCode" => "123",
    "jsonMsgId" => $jsonMsgId,
    "content" => $ieContent,
    "funcFlag" => $funcFlag);
var_dump($msg);
if (isset($msg["project"])) $project = $msg["project"]; else $project = "";
if (isset($msg["devCode"])) $devCode = $msg["devCode"]; else $devCode = "";
if (isset($msg["statCode"])) $statCode = $msg["statCode"]; else $statCode = "";
if (isset($msg["content"])) $content = $msg["content"]; else $content = "";
if (isset($msg["funcFlag"])) $funcFlag = $msg["funcFlag"]; else $funcFlag = "";
$classTaskL2snrWeight=new classTaskL2snrWeight();
$resp=$classTaskL2snrWeight->func_weight_product_insert($devCode,$content);
print_r($resp) ;
?>