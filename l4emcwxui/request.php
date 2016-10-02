<?php

include_once "../l1comvm/vmlayer.php";
require_once "dbi_l4emcwx_ui.class.php";
//header("Content-type:text/html;charset=utf-8");
//require '/php/req.php';

//L4EMCWXUI的入口起点
//这里的入参格式是跟前端界面商量约定好的
if (isset($_GET["action"])){
    //for debug
    $log_time = time();
    $action = $_GET["action"];
    $code = $_GET["code"];
    $log_content = "Action=".$action."  Code=".$code;
    $loggerObj = new classApiL1vmFuncCom();
    $loggerObj->logger("MFUN_TASK_ID_L4EMCWX_UI", "mfun_l1vm_task_main_entry", $log_time, $log_content);

    require("../l1mainentry/h5ui_entry_emcwx.php");
    //$obj = new classTaskL1vmCoreRouter();
    //$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_AQYC_UI, NULL, NULL, $_GET["action"]);
}

?>