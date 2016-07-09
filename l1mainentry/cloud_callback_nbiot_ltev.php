<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/9
 * Time: 14:39
 */
include_once "../l1comvm/vmlayer.php";

// 主程序MAIN()
$obj = new classTaskL1vmCoreRouter();
$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_NBIOT_LTEV, MSG_ID_L2SDK_NBIOT_LTEV_INCOMING, "MSG_ID_L2SDK_NBIOT_LTEV_INCOMING", $GLOBALS["HTTP_RAW_POST_DATA"]);

?>