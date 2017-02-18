<?php
include_once "../l1comvm/vmlayer.php";
require_once "dbi_l4fhys_wechat.class.php";

//L4FHYS Wechat的入口起点
//这里调用h5ui_entry_fhys_wechat是为了保证所有的入口都在/l1mainentry下面

/*
$request_body = file_get_contents('php://input');
//echo $request_body;
$payload = json_decode($request_body,true);
//echo $payload;
if (isset($payload["action"])) $_GET["action"] = trim($payload["action"]); else $_GET["action"] = "";
if (isset($payload["type"])) $_GET["type"] = trim($payload["type"]); else $_GET["type"] = "";
if (isset($payload["user"])) $_GET["user"] = trim($payload["user"]); else $_GET["user"] = "";
if (isset($payload["body"])) $_GET["body"] = $payload["body"]; else $_GET["body"] = "";
*/

if (isset($_GET["action"])){
    require("../l1mainentry/h5ui_entry_fhys_wechat.php");
}

?>