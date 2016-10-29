<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 2016/10/02
 * Time: 11:33
 */
include_once "../l1comvm/vmlayer.php";

// 主程序MAIN()
// 本程序的真正入口在L4FHYS中的REQUEST.php中，本php是被它调用的，起到入口统一放在一个地方的目的
// 这也可以为其它新项目形成一个好的范式，从而简化整个程序结构的框架，方便程序员理解程序整体构架

$obj = new classTaskL1vmCoreRouter();
$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_FHYS_UI, NULL, NULL, $_GET["action"]);


?>