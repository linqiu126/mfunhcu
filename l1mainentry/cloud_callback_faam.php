<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/17
 * Time: 7:17
 */

include_once "../l1comvm/vmlayer.php";

// 主程序MAIN()
$obj = new classTaskL1vmCoreRouter();
//if(! isset($GLOBALS["HTTP_RAW_POST_DATA"])) return '';
//$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
$postStr = file_get_contents('php://input','r');

$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_IOT_JSON, MSG_ID_CALLBACK_TO_IOT_JSON_DATA, "MSG_ID_CALLBACK_TO_IOT_JSON_DATA", $postStr);


?>