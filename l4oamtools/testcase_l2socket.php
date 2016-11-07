<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/8/27
 * Time: 11:25
 */

include_once "../l1comvm/vmlayer.php";

/**************************************************************************************
 *                             SOCKET TEST CASES                              *
 *************************************************************************************/
if (TC_SOCKET == true) {
//SOCKET测试开始
    echo " [TC SOCKET: xxx START]\n";
    if (MFUN_CLOUD_HCU == "AQ_HCU") {
        require("../l1mainentry/cloud_callback_socket_listening.php");
    }
    echo " [TC SOCKET: xxx END]\n";

//SOCKET测试结束
}