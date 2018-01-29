<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/21
 * Time: 21:38
 */
include_once "../l1comvm/vmlayer.php";

// 主程序MAIN()
$obj = new classTaskL1vmCoreRouter();
//if(! isset($GLOBALS["HTTP_RAW_POST_DATA"])) return '';
//$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
$postStr = file_get_contents('php://input','r');

$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_IOT_STDXML, MSG_ID_L2SDK_STDXML_DATA_INCOMING, "MSG_ID_L2SDK_STDXML_DATA_INCOMING", $postStr);


?>