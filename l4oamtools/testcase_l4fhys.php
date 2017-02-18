<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 16-10-2
 * Time: 上午10:44
 */

include_once "../l1comvm/vmlayer.php";

/**************************************************************************************
 *                             L4FHYS-WECHAT TEST CASES                               *
 *************************************************************************************/
if (TC_L4FHYS_WECHAT == true) {

    echo " [TC L4FHYS_WECHAT: HCU_Wechat_Login START]\n";
    $_GET["action"] = "HCU_Wechat_Login";
    $_GET["type"] = "query";
    $body = array('code' => 'openid');
    $_GET["body"] = $body;
    $_GET["user"] = "null";
    //require("../l4fhyswechat/request.php");
    echo " [TC L4FHYS_WECHAT: HCU_Wechat_Login END]\n";

    echo " [TC L4FHYS_WECHAT: HCU_Wechat_Bonding START]\n";
    $_GET["action"] = "HCU_Wechat_Bonding";
    $_GET["type"] = "query";
    $body = array('code' =>'openid','username'=>'foha','userid'=>'UID771073');
    $_GET["body"] = $body;
    $_GET["user"] = "UID771073";
    require("../l4fhyswechat/request.php");
    echo " [TC L4FHYS_WECHAT: HCU_Wechat_Bonding END]\n";

    echo " [TC L4FHYS_WECHAT: HCU_Lock_Query START]\n";
    $_GET["action"] = "HCU_Lock_Query";
    $_GET["type"] = "query";
    $_GET["user"] = "UID771073";
    require("../l4fhyswechat/request.php");
    echo " [TC L4FHYS_WECHAT: HCU_Lock_Query END]\n";

    echo " [TC L4FHYS_WECHAT: HCU_Lock_Status START]\n";
    $_GET["action"] = "HCU_Lock_Status";
    $_GET["type"] = "query";
    $body = array('statcode' => '120101002');
    $_GET["body"] = $body;
    $_GET["user"] = "UID771073";
    require("../l4fhyswechat/request.php");
    echo " [TC L4FHYS_WECHAT: HCU_Lock_Status END]\n";

    echo " [TC L4FHYS_WECHAT: HCU_Lock_open START]\n";
    $_GET["action"] = "HCU_Lock_open";
    $_GET["type"] = "query";
    $body = array('statcode' => '120101002');
    $_GET["body"] = $body;
    $_GET["user"] = "UID771073";
    require("../l4fhyswechat/request.php");
    echo " [TC L4FHYS_WECHAT: HCU_Lock_open END]\n";

}
/**************************************************************************************
 *                             L4FHYS-UI TEST CASES                                   *
 *************************************************************************************/
if (TC_L4FHYS_UI == true) {
    $sessionid = "mue1uPdDq1";

    echo " [TC L4FHYS: GetWarningHandleListTable START]\n";
    $_GET["action"] = "GetWarningHandleListTable";
    $_GET["type"] = "query";
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: GetWarningHandleListTable END]\n";

    echo " [TC L4FHYS: DomainAuthlist START]\n";
    $_GET["action"] = "DomainAuthlist";
    $_GET["type"] = "query";
    $body = array('DomainCode' => "P_0010");
    $_GET["body"] = $body;
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: DomainAuthlist END]\n";

    echo " [TC L4FHYS: GetStaticMonitorTable START]\n";
    $_GET["action"] = "GetStaticMonitorTable";
    $_GET["type"] = "query";
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: GetStaticMonitorTable END]\n";

    //公共消息测试
    echo " [TC L4FHYS: LOGIN START]\n";
    $_GET["action"] = "login";
    $_GET["name"] = "admin";
    $_GET["password"] = "admin";
    //require("../l4fhysui/request.php");
    echo " [TC L4FHYS: LOGIN END]\n";

    echo " [TC L4FHYS: USERINFO START]\n";
    $_GET["action"] = "UserInfo";
    $body = array('session' => $sessionid);
    $_GET["type"] = "query";
    $_GET["body"] = $body;
    $_GET["user"] = "";
    require("../l4fhysui/request.php");
    echo " \n[TC L4FHYS: USERINFO END]\n";

    echo " [TC L4FHYS: USERNEW START]\n";
    $_GET["action"] = "UserNew";
    $body = array('name' => "aaa", 'nickname' => "bbb",'password' => "AAA",'mobile' => "139",'mail' => "aaa@139",'type' => "1",'memo' => "ZZZ",'auth' => "");
    $_GET["type"] = "mod";
    $_GET["body"] = $body;
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: USERNEW END]\n";

    echo " [TC L4FHYS: ProjTable START]\n";
    $_GET["action"] = "ProjTable";
    $body = array('startseq' => "0", 'length' => "10");
    $_GET["type"] = "query";
    $_GET["body"] = $body;
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: ProjTable END]\n";

    echo " [TC L4FHYS: PGTable START]\n";
    $_GET["action"] = "PGTable";
    $body = array('startseq' => "0", 'length' => "10");
    $_GET["type"] = "query";
    $_GET["body"] = $body;
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: PGTable END]\n";

    echo " [TC L4FHYS: MonitorList START]\n";
    $_GET["action"] = "MonitorList";
    $_GET["type"] = "query";
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: MonitorList END]\n";

    echo " [TC L4FHYS: ProjectPGList START]\n";
    $_GET["action"] = "ProjectPGList";
    $_GET["type"] = "query";
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: ProjectPGList END]\n";

    echo " [TC L4FHYS: UserProj START]\n";
    $_GET["action"] = "UserProj";
    $body = array('userid' => "UID000003");
    $_GET["body"] = $body;
    $_GET["type"] = "query";
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: UserProj END]\n";

    echo " [TC L4FHYS: ProjectList START]\n";
    $_GET["action"] = "ProjectList";
    $_GET["type"] = "query";
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: ProjectList END]\n";

    echo " [TC L4FHYS: DevAlarm START]\n";
    $_GET["action"] = "DevAlarm";
    $body = array('StatCode' => "120101015");
    $_GET["body"] = $body;
    $_GET["type"] = "query";
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: DevAlarm END]\n";

    //智能云锁专用消息测试
    echo " [TC L4FHYS: UserKey START]\n";
    $_GET["action"] = "UserKey";
    $body = array('userid' => "UID000003");
    $_GET["body"] = $body;
    $_GET["type"] = "query";
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: UserKey END]\n";

    echo " [TC L4FHYS: ProjKeyList START]\n";
    $_GET["action"] = "ProjKeyList";
    $_GET["type"] = "query";
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: ProjKeyList END]\n";

    echo " [TC L4FHYS: ProjKey START]\n";
    $_GET["action"] = "ProjKey";
    $body = array('ProjCode' => "P_0015");
    $_GET["body"] = $body;
    $_GET["type"] = "query";
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: ProjKey END]\n";

    echo " [TC L4FHYS: ProjUserList START]\n";
    $_GET["action"] = "ProjUserList";
    $_GET["type"] = "query";
    $_GET["user"] = $sessionid;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: ProjUserList END]\n";

    echo " [TC L4FHYS: KeyTable START]\n";
    $_GET["action"] = "KeyTable";
    $_GET["length"] = "15";
    $_GET["startseq"] = "0";
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: KeyTable END]\n";

    echo " [TC L4FHYS: DomainAuthlist START]\n";
    $_GET["action"] = "DomainAuthlist";
    $_GET["DomainCode"] = "P_0014";
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: DomainAuthlist END]\n";

    echo " [TC L4FHYS: KeyAuthlist START]\n";
    $_GET["action"] = "KeyAuthlist";
    $_GET["KeyId"] = "KEY540970";
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: KeyAuthlist END]\n";

    echo " [TC L4FHYS: KeyAuthNew START]\n";
    $_GET["action"] = "KeyAuthNew";
    $_GET["id"] = "gCuv92Barf";
    $auth = array("DomainId"=>"P_0014", "KeyId"=>"KEY278347", "Authway" =>"2016-12-01");
    $_GET["Auth"] = $auth;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: KeyAuthNew END]\n";

    echo " [TC L4FHYS: GetStaticMonitorTable START]\n";
    $_GET["action"] = "GetStaticMonitorTable";
    $_GET["id"] = "gCuv92Barf";
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: GetStaticMonitorTable END]\n";

    echo " [TC L4FHYS: KeyHistory START]\n";
    $_GET["action"] = "KeyHistory";
    $_GET["id"] = "gCuv92Barf";
    $condition = array("ProjCode"=>"P_0015", "Time"=>"7");
    $_GET["condition"] = $condition;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: KeyHistory END]\n";

    //HCU_Lock_open
    echo " [TC L4FHYS: Compel OpenLock START]\n";
    $_GET["action"] = "OpenLock";
    $_GET["id"] = "rcu4SoomAd"; //暂时用admin用户名
    $_GET["StatCode"] = "120101015"; //t_l3f3dm_siteinfo中对应HCU_SH_0301
    //require("../l4fhysui/request.php");
    echo " [TC L4FHYS: Compel OpenLock END]\n";

    //HCU_Lock_Status
    echo " [TC L4FHYS: HCU_Lock_Status START]\n";
    $_GET["action"] = "HCU_Lock_Status";
    $_GET["id"] = "admin"; //暂时用admin用户名
    $_GET["StatCode"] = "120101001"; //t_l3f3dm_siteinfo中对应HCU_SH_0301
    //require("../l4fhysui/request.php");
    echo " [TC L4FHYS: HCU_Lock_Status END]\n";

}