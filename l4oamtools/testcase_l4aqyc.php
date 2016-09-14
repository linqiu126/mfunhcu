<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/17
 * Time: 23:47
 */

include_once "../l1comvm/vmlayer.php";

/**************************************************************************************
 *                             L4AQYC-UI TEST CASES                                   *
 *************************************************************************************/
if (TC_L4AQYC_UI == true) {
    //TEST CASE: L4AQYC-UI界面: START
    echo " [TC L4AQYC: LOGIN START]\n";
    $_GET["action"] = "login";
    $_GET["name"] = "admin";
    $_GET["password"] = "admin";
    require("../l4aqycui/request.php");
//$obj = new classTaskL1vmCoreRouter();
//$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_AQYC_UI, MSG_ID_L2SDK_HCU_DATA_COMING, "MSG_ID_L2SDK_HCU_DATA_COMING", $_GET["action"]);
    echo " [TC L4AQYC: LOGIN END]\n";

    echo " [TC L4AQYC: USERINFO START]\n";
    $_GET["action"] = "UserInfo";
    $_GET["session"] = 1;
    require("../l4aqycui/request.php");
//$obj = new classTaskL1vmCoreRouter();
//$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_AQYC_UI, MSG_ID_L2SDK_HCU_DATA_COMING, "MSG_ID_L2SDK_HCU_DATA_COMING", $_GET["action"]);
    echo " [TC L4AQYC: USERINFO END]\n";

    echo " [TC L4AQYC: USERNEW START]\n";
    $_GET["action"] = "UserNew";
    $_GET["name"] = "ZZZ";
    $_GET["nickname"] = "ZZZ";
    $_GET["password"] ="zzz";
    $_GET["mobile"] ="zzz";
    $_GET["mail"] ="zzz";
    $_GET["type"] ="aa";
    $_GET["memo"] ="zz";
    $_GET["auth"] ="zz";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: USERNEW END]\n";

    echo " [TC L4AQYC: UserMod START]\n";
    $_GET["action"] = "UserMod";
    $_GET["id"] = "11";
    $_GET["name"] = "ZZZ";
    $_GET["nickname"] = "ZZZ";
    $_GET["password"] ="zzz";
    $_GET["mobile"] ="zzz";
    $_GET["mail"] ="zzz";
    $_GET["type"] ="aa";
    $_GET["memo"] ="zz";
    $_GET["auth"] ="zz";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: UserMod END]\n";

    echo " [TC L4AQYC: UserDel START]\n";
    $_GET["action"] = "UserMod";
    $_GET["id"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: UserDel END]\n";

    echo " [TC L4AQYC: UserTable START]\n";
    $_GET["action"] = "UserTable";
    $_GET["length"] = "5";
    $_GET["startseq"] = "1";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: UserTable END]\n";

    echo " [TC L4AQYC: HcuSwUpdate START]\n";
    $_GET["action"] = "HcuSwUpdate";
    $_GET["deviceid"] = "11";
    $_GET["projectid"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: HcuSwUpdate END]\n";

    echo " [TC L4AQYC: ProjectPGList START]\n";
    $_GET["action"] = "ProjectPGList";
    $_GET["user"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjectPGList END]\n";

    echo " [TC L4AQYC: ProjectList START]\n";
    $_GET["action"] = "ProjectList";
    $_GET["user"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjectList END]\n";

    echo " [TC L4AQYC: UserProj START]\n";
    $_GET["action"] = "UserProj";
    $_GET["userid"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: UserProj END]\n";

    echo " [TC L4AQYC: PGTable START]\n";
    $_GET["action"] = "PGTable";
    $_GET["length"] = "5";
    $_GET["startseq"] = "1";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PGTable END]\n";

    echo " [TC L4AQYC: PGNew START]\n";
    $_GET["action"] = "PGNew";
    $_GET["PGCode"] = "11";
    $_GET["PGName"] = "11";
    $_GET["ChargeMan"] = "11";
    $_GET["Telephone"] = "11";
    $_GET["Department"] = "11";
    $_GET["Address"] = "11";
    $_GET["Stage"] = "11";
    $_GET["Projlist"] = "11";
    $_GET["user"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PGNew END]\n";

    echo " [TC L4AQYC: PGMod START]\n";
    $_GET["action"] = "PGMod";
    $_GET["PGCode"] = "11";
    $_GET["PGName"] = "11";
    $_GET["ChargeMan"] = "11";
    $_GET["Telephone"] = "11";
    $_GET["Department"] = "11";
    $_GET["Address"] = "11";
    $_GET["Stage"] = "11";
    $_GET["Projlist"] = "11";
    $_GET["user"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PGMod END]\n";

    echo " [TC L4AQYC: PGDel START]\n";
    $_GET["action"] = "PGDel";
    $_GET["id"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PGDel END]\n";

    echo " [TC L4AQYC: PGProj START]\n";
    $_GET["action"] = "PGProj";
    $_GET["id"] = "PG_1111";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PGProj END]\n";

    echo " [TC L4AQYC: ProjTable START]\n";
    $_GET["action"] = "ProjTable";
    $_GET["length"] = "5";
    $_GET["startseq"] = "1";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjTable END]\n";

    echo " [TC L4AQYC: ProjNew START]\n";
    $_GET["action"] = "ProjNew";
    $_GET["ProjCode"] = "11";
    $_GET["ProjName"] = "11";
    $_GET["ChargeMan"] = "11";
    $_GET["Telephone"] = "11";
    $_GET["Department"] = "11";
    $_GET["Address"] = "11";
    $_GET["ProStartTime"] = "11";
    $_GET["Stage"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjNew END]\n";

    echo " [TC L4AQYC: ProjMod START]\n";
    $_GET["action"] = "ProjMod";
    $_GET["ProjCode"] = "11";
    $_GET["ProjName"] = "11";
    $_GET["ChargeMan"] = "11";
    $_GET["Telephone"] = "11";
    $_GET["Department"] = "11";
    $_GET["Address"] = "11";
    $_GET["ProStartTime"] = "11";
    $_GET["Stage"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjMod END]\n";

    echo " [TC L4AQYC: ProjDel START]\n";
    $_GET["action"] = "ProjDel";
    $_GET["ProjCode"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjDel END]\n";

    echo " [TC L4AQYC: ProjPoint START]\n";
    $_GET["action"] = "ProjPoint";
    $_GET["user"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjPoint END]\n";

    echo " [TC L4AQYC: PointProj START]\n";
    $_GET["action"] = "PointProj";
    $_GET["ProjCode"] = "P_0001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointProj END]\n";

    echo " [TC L4AQYC: PointTable START]\n";
    $_GET["action"] = "PointTable";
    $_GET["length"] = "5";
    $_GET["startseq"] = "1";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointTable END]\n";

    echo " [TC L4AQYC: PointDetail START]\n";
    $_GET["action"] = "PointDetail";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointDetail END]\n";

    echo " [TC L4AQYC: PointNew START]\n";
    $_GET["action"] = "PointNew";
    $_GET["StatCode"] = "11";
    $_GET["StatName"] = "11";
    $_GET["ProjCode"] = "11";
    $_GET["ChargeMan"] = "11";
    $_GET["Telephone"] = "11";
    $_GET["Longitude"] = "11";
    $_GET["Latitude"] = "11";
    $_GET["Department"] = "11";
    $_GET["Address"] = "11";
    $_GET["Country"] = "11";
    $_GET["Street"] = "11";
    $_GET["Square"] = "11";
    $_GET["ProStartTime"] = "11";
    $_GET["Stage"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointNew END]\n";

    echo " [TC L4AQYC: PointMod START]\n";
    $_GET["action"] = "PointMod";
    $_GET["StatCode"] = "11";
    $_GET["StatName"] = "11";
    $_GET["ProjCode"] = "11";
    $_GET["ChargeMan"] = "11";
    $_GET["Telephone"] = "11";
    $_GET["Longitude"] = "11";
    $_GET["Latitude"] = "11";
    $_GET["Department"] = "11";
    $_GET["Address"] = "11";
    $_GET["Country"] = "11";
    $_GET["Street"] = "11";
    $_GET["Square"] = "11";
    $_GET["ProStartTime"] = "11";
    $_GET["Stage"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointMod END]\n";

    echo " [TC L4AQYC: PointDel START]\n";
    $_GET["action"] = "PointDel";
    $_GET["StatCode"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointDel END]\n";

    echo " [TC L4AQYC: PointDev START]\n";
    $_GET["action"] = "PointDev";
    $_GET["StatCode"] = "120101001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointDev END]\n";

    echo " [TC L4AQYC: DevTable START]\n";
    $_GET["action"] = "DevTable";
    $_GET["length"] = "5";
    $_GET["startseq"] = "1";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevTable END]\n";

    echo " [TC L4AQYC: DevNew START]\n";
    $_GET["action"] = "DevNew";
    $_GET["DevCode"] = "11";
    $_GET["StatCode"] = "11";
    $_GET["StartTime"] = "11";
    $_GET["PreEndTime"] = "11";
    $_GET["EndTime"] = "11";
    $_GET["DevStatus"] = "11";
    $_GET["VideoURL"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevNew END]\n";

    echo " [TC L4AQYC: DevMod START]\n";
    $_GET["action"] = "DevMod";
    $_GET["DevCode"] = "11";
    $_GET["StatCode"] = "11";
    $_GET["StartTime"] = "11";
    $_GET["PreEndTime"] = "11";
    $_GET["EndTime"] = "11";
    $_GET["DevStatus"] = "11";
    $_GET["VideoURL"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevMod END]\n";

    echo " [TC L4AQYC: DevDel START]\n";
    $_GET["action"] = "DevDel";
    $_GET["DevCode"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevDel END]\n";

    echo " [TC L4AQYC: DevAlarm START]\n";
    $_GET["action"] = "DevAlarm";
    $_GET["StatCode"] = "120101001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevAlarm END]\n";

    echo " [TC L4AQYC: DevAlarm START]\n";
    $_GET["action"] = "DevAlarm";
    $_GET["StatCode"] = "120101001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevAlarm END]\n";

    echo " [TC L4AQYC: MonitorList START]\n";
    $_GET["action"] = "MonitorList";
    $_GET["id"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: MonitorList END]\n";

    echo " [TC L4AQYC: AlarmQuery START]\n";
    $_GET["action"] = "AlarmQuery";
    $_GET["id"] = "UID001";
    $_GET["StatCode"] = "120101001";
    $_GET["date"] = "11";
    $_GET["type"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: AlarmQuery END]\n";

    echo " [TC L4AQYC: AlarmType START]\n";
    $_GET["action"] = "AlarmType";
    $_GET["user"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: AlarmType END]\n";

    echo " [TC L4AQYC: TableQuery START]\n";
    $_GET["action"] = "TableQuery";
    $_GET["TableName"] = 1;
    $_GET["Condition"] = 1;
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: TableQuery END]\n";

    echo " [TC L4AQYC: SensorList START]\n";
    $_GET["action"] = "SensorList";
    $_GET["user"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: SensorList END]\n";

    echo " [TC L4AQYC: DevSensor START]\n";
    $_GET["action"] = "DevSensor";
    $_GET["DevCode"] = "HCU_SH_0301";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevSensor END]\n";

    echo " [TC L4AQYC: SensorUpdate START]\n";
    $_GET["action"] = "SensorUpdate";
    $_GET["DevCode"] = "HCU_SH_0301";
    $_GET["SensorCode"] = "S_0001";
    $_GET["status"] = "true";
    //$_GET["status"] = "false";
    $para_list = array();
    $temp = array(
        'name'=>"MODBUS_Addr",
        'memo'=>"MODBUS地址",
        'value'=>0x05);
    array_push($para_list, $temp);
    $_GET["ParaList"] = $para_list;
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: SensorUpdate END]\n";

    echo " [TC L4AQYC: SetUserMsg START]\n";
    $_GET["action"] = "SetUserMsg";
    $_GET["id"] = "11";
    $_GET["msg"] = "11";
    $_GET["ifdev"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: SetUserMsg END]\n";

    echo " [TC L4AQYC: GetUserMsg START]\n";
    $_GET["action"] = "GetUserMsg";
    $_GET["id"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetUserMsg END]\n";

    echo " [TC L4AQYC: ShowUserMsg START]\n";
    $_GET["action"] = "ShowUserMsg";
    $_GET["id"] = "11";
    $_GET["StatCode"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ShowUserMsg END]\n";

    echo " [TC L4AQYC: GetUserImg START]\n";
    $_GET["action"] = "GetUserImg";
    $_GET["id"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetUserImg END]\n";

    echo " [TC L4AQYC: ClearUserImg START]\n";
    $_GET["action"] = "ClearUserImg";
    $_GET["id"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ClearUserImg END]\n";

    echo " [TC L4AQYC: GetStaticMonitorTable START]\n";
    $_GET["action"] = "GetStaticMonitorTable";
    $_GET["id"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetStaticMonitorTable END]\n";

    echo " [TC L4AQYC: GetVideoList START]\n";
    $_GET["action"] = "GetVideoList";
    $_GET["id"] = "UID001";
    $_GET["StatCode"] = "120101001";
    $_GET["date"] = "2016-04-16";
    $_GET["hour"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetVideoList END]\n";

    echo " [TC L4AQYC: GetVideo START]\n";
    $_GET["action"] = "GetVideo";
    $_GET["id"] = "HCU_SH_0301_av201607201122.h264.mp4";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetVideo END]\n";

    echo " [TC L4AQYC: GetVersionList START]\n";
    $_GET["action"] = "GetVersionList";
    $_GET["id"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetVersionList END]\n";

    echo " [TC L4AQYC: GetProjDevVersion START]\n";
    $_GET["action"] = "GetProjDevVersion";
    $_GET["id"] = "UID001";
    $_GET["ProjCode"] = "P_0001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetProjDevVersion END]\n";

    echo " [TC L4AQYC: UpdateDevVersion START]\n";
    $_GET["action"] = "UpdateDevVersion";
    $_GET["id"] = "UID001";
        $dev1 = "HCU_SH_0301";
        $dev2 = "HCU_SH_0314";
        $list = array();
        array_push($list, $dev1); array_push($list, $dev2);
    $_GET["list"] = $list;
    $_GET["version"] = "SW_R01.D0066";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: UpdateDevVersion END]\n";

    echo " [TC L4AQYC: GetCameraStatus START]\n";
    $_GET["action"] = "GetCameraStatus";
    $_GET["id"] = "admin"; //暂时用admin用户名
    $_GET["StatCode"] = "120101001"; //t_l3f3dm_siteinfo中对应HCU_SH_0301
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetCameraStatus END]\n";

//TEST CASE: L4AQYC-UI界面: END

}




?>