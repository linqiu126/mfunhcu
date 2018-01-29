<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/15
 * Time: 10:27
 */

include_once "../l1comvm/vmlayer.php";

// 微信小程序主入口
$obj = new classTaskL1vmCoreRouter();
//$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
$postStr = file_get_contents('php://input','r');

$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_WECHAT_XCX, NULL, NULL, $postStr);