<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/7
 * Time: 22:07
 */
include_once "../l1comvm/vmlayer.php";

// 主程序MAIN()
$obj = new classTaskL1vmCoreRouter();
$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_NBIOT_IPM376, MSG_ID_L2SDK_NBIOT_IPM376_INCOMING, "MSG_ID_L2SDK_NBIOT_IPM376_INCOMING", $GLOBALS["HTTP_RAW_POST_DATA"]);

?>