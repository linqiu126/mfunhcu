<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/7/12
 * Time: 14:53
 */
include_once "../l1comvm/vmlayer.php";

// 主程序MAIN()
$obj = new classTaskL1vmCoreRouter();
$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_NBIOT_IWM_UI, NULL, NULL, $_GET["action"]);

?>