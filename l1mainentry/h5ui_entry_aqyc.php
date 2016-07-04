<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/29
 * Time: 10:35
 */
include_once "../l1comvm/vmlayer.php";

// 主程序MAIN()
$obj = new classTaskL1vmCoreRouter();
$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_AQYC_UI, NULL, NULL, $_GET["action"]);

?>