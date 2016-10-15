<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 2016/10/15
 * Time: 14:57
 */

include_once "../l1comvm/vmlayer.php";

/**************************************************************************************
 *                             L4TBSWR-UI TEST CASES                                   *
 *************************************************************************************/
if (TC_L4TBSWR_UI == true) {
    //TEST CASE: L4TBSWR-UI界面: START

    echo " [TC L4TBSWR: GetTempStatus START]\n";
    $_GET["action"] = "GetTempStatus";
    $_GET["id"] = "admin"; //暂时用admin用户名
    $_GET["StatCode"] = "120101001"; //t_l3f3dm_siteinfo中对应HCU_SH_0301
    require("../l4tbswrui/request.php");
    echo " [TC L4TBSWR: GetTempStatus END]\n";

    //TEST CASE: L4TBSWR-UI界面: END
}




?>