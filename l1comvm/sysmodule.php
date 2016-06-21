<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 13:29
 */
include_once "../l1comvm/sysconfig.php";
include_once "../l1comvm/sysdim.php";

//全局TaskId的定义
define("MFUN_TASK_ID_MIN", 0);
define("MFUN_TASK_ID_L1VM", 1);
define("MFUN_TASK_ID_L2SDK_IOT_APPLE", 2);
define("MFUN_TASK_ID_L2SDK_IOT_JD", 3);
define("MFUN_TASK_ID_L2SDK_WECHAT", 4);
define("MFUN_TASK_ID_L2SDK_IOT_WX", 5);
define("MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK", 6);
define("MFUN_TASK_ID_L2SDK_IOT_HCU", 7);
define("MFUN_TASK_ID_L2SENSOR_EMC", 8);
define("MFUN_TASK_ID_L2SENSOR_HSMMP", 9);
define("MFUN_TASK_ID_L2SENSOR_HUMID", 10);
define("MFUN_TASK_ID_L2SENSOR_NOISE", 11);
define("MFUN_TASK_ID_L2SENSOR_PM25", 12);
define("MFUN_TASK_ID_L2SENSOR_TEMP", 13);
define("MFUN_TASK_ID_L2SENSOR_WINDDIR", 14);
define("MFUN_TASK_ID_L2SENSOR_WINDSPD", 15);
define("MFUN_TASK_ID_L2SENSOR_AIRPRS", 16);
define("MFUN_TASK_ID_L2SENSOR_ALCOHOL", 17);
define("MFUN_TASK_ID_L2SENSOR_CO1", 18);
define("MFUN_TASK_ID_L2SENSOR_HCHO", 19);
define("MFUN_TASK_ID_L2SENSOR_TOXICGAS", 20);
define("MFUN_TASK_ID_L2SENSOR_LIGHTSTR", 21);
define("MFUN_TASK_ID_L3APPL_FUM1SYM", 22);
define("MFUN_TASK_ID_L3APPL_FUM2CM", 23);
define("MFUN_TASK_ID_L3APPL_FUM3DM", 24);
define("MFUN_TASK_ID_L3APPL_FUM4ICM", 25);
define("MFUN_TASK_ID_L3APPL_FUM5FM", 26);
define("MFUN_TASK_ID_L3APPL_FUM6PM", 27);
define("MFUN_TASK_ID_L3APPL_FUM7ADS", 28);
define("MFUN_TASK_ID_L3APPL_FUM8PSM", 29);
define("MFUN_TASK_ID_L3APPL_FUM9GISM", 30);
define("MFUN_TASK_ID_L3APPL_FUMXPRCM", 31);
define("MFUN_TASK_ID_L3WXPRC_EMC", 32);
define("MFUN_TASK_ID_L4AQYC_UI", 33);
define("MFUN_TASK_ID_L4EMCWX_UI", 34);
define("MFUN_TASK_ID_L4TBSWR_UI", 35);
define("MFUN_TASK_ID_L4OAMTOOLS", 36);
define("MFUN_TASK_ID_L5BI", 37);
define("MFUN_TASK_ID_MAX", 38);
define("MFUN_TASK_ID_NULL", 39);

//全局TaskName的定义
class MfunSysTaskList
{
    public static $mfunTaskName = array(
        MFUN_TASK_ID_MIN => array("name" => "MFUN_TASK_MIN", "present" => true),
        MFUN_TASK_ID_L1VM => "MFUN_TASK_L1VM",
        MFUN_TASK_ID_L2SDK_IOT_APPLE => "MFUN_TASK_L2SDK_IOT_APPLE",
        MFUN_TASK_ID_L2SDK_IOT_JD => "MFUN_TASK_L2SDK_IOT_JD",
        MFUN_TASK_ID_L2SDK_WECHAT => "MFUN_TASK_L2SDK_WECHAT",
        MFUN_TASK_ID_L2SDK_IOT_WX => "MFUN_TASK_L2SDK_IOT_WX",
        MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK => "MFUN_TASK_L2SDK_IOT_WX_JSSDK",
        MFUN_TASK_ID_L2SDK_IOT_HCU => "MFUN_TASK_L2SDK_IOT_HCU",
        MFUN_TASK_ID_L2SENSOR_EMC => "MFUN_TASK_L2SENSOR_EMC",
        MFUN_TASK_ID_L2SENSOR_HSMMP => "MFUN_TASK_L2SENSOR_HSMMP",
        MFUN_TASK_ID_L2SENSOR_HUMID => "MFUN_TASK_L2SENSOR_HUMID",
        MFUN_TASK_ID_L2SENSOR_NOISE => "MFUN_TASK_L2SENSOR_NOISE",
        MFUN_TASK_ID_L2SENSOR_PM25 => "MFUN_TASK_L2SENSOR_PM25",
        MFUN_TASK_ID_L2SENSOR_TEMP => "MFUN_TASK_L2SENSOR_TEMP",
        MFUN_TASK_ID_L2SENSOR_WINDDIR => "MFUN_TASK_L2SENSOR_WINDDIR",
        MFUN_TASK_ID_L2SENSOR_WINDSPD => "MFUN_TASK_L2SENSOR_WINDSPD",
        MFUN_TASK_ID_L2SENSOR_AIRPRS => "MFUN_TASK_L2SENSOR_AIRPRS",
        MFUN_TASK_ID_L2SENSOR_ALCOHOL => "MFUN_TASK_L2SENSOR_ALCOHOL",
        MFUN_TASK_ID_L2SENSOR_CO1 => "MFUN_TASK_L2SENSOR_CO1",
        MFUN_TASK_ID_L2SENSOR_HCHO => "MFUN_TASK_L2SENSOR_HCHO",
        MFUN_TASK_ID_L2SENSOR_TOXICGAS => "MFUN_TASK_L2SENSOR_TOXICGAS",
        MFUN_TASK_ID_L2SENSOR_LIGHTSTR => "MFUN_TASK_L2SENSOR_LIGHTSTR",
        MFUN_TASK_ID_L3APPL_FUM1SYM => "MFUN_TASK_L3APPL_FUM1SYM",
        MFUN_TASK_ID_L3APPL_FUM2CM => "MFUN_TASK_L3APPL_FUM2CM",
        MFUN_TASK_ID_L3APPL_FUM3DM => "MFUN_TASK_L3APPL_FUM3DM",
        MFUN_TASK_ID_L3APPL_FUM4ICM => "MFUN_TASK_L3APPL_FUM4ICM",
        MFUN_TASK_ID_L3APPL_FUM5FM => "MFUN_TASK_L3APPL_FUM5FM",
        MFUN_TASK_ID_L3APPL_FUM6PM => "MFUN_TASK_L3APPL_FUM6PM",
        MFUN_TASK_ID_L3APPL_FUM7ADS => "MFUN_TASK_L3APPL_FUM7ADS",
        MFUN_TASK_ID_L3APPL_FUM8PSM => "MFUN_TASK_L3APPL_FUM8PSM",
        MFUN_TASK_ID_L3APPL_FUM9GISM => "MFUN_TASK_L3APPL_FUM9GISM",
        MFUN_TASK_ID_L3APPL_FUMXPRCM => "MFUN_TASK_L3APPL_FUMXPRCM",
        MFUN_TASK_ID_L3WXPRC_EMC => "MFUN_TASK_L3WXPRC_EMC",
        MFUN_TASK_ID_L4AQYC_UI => "MFUN_TASK_L4AQYC_UI",
        MFUN_TASK_ID_L4EMCWX_UI => "MFUN_TASK_L4EMCWX_UI",
        MFUN_TASK_ID_L4TBSWR_UI => "MFUN_TASK_L4TBSWR_UI",
        MFUN_TASK_ID_L4OAMTOOLS => "MFUN_TASK_L4OAMTOOLS",
        MFUN_TASK_ID_L5BI => "MFUN_TASK_L5BI",
        MFUN_TASK_ID_MAX => "MFUN_TASK_MAX",
        MFUN_TASK_ID_NULL => "MFUN_TASK_NULL"
    );

    //通过TaskId读取TaskName
    public static function mfun_getTaskNameText($taskId)
    {
        if (isset(self::$mfunTaskName[$taskId])) {
            return self::$mfunTaskName[$taskId];
        }else {
            return false;
        };
    }

    //通过TaskName读取TaskId
    public static function mfun_getTaskId($taskName)
    {
        for ($i = 0; i < MAX_TASK_NUM_IN_ONE_MFUN; $i++) {
            if (isset(self::$mfunTaskName[$i]) == $taskName)
                return $i;
        }
        return false;
    }
}

//按照不同的工作配置情况，设置模块标识及PRESENT情况
if (MFUN_CURRENT_WORKING_PROJECT_NAME_UNIQUE == "HCU_PRJ_AQYC")
{
    define("MFUN_MOD_L1VM", true);
    define("MFUN_MOD_L2SDK_IOT_APPLE", false);
    define("MFUN_MOD_L2SDK_IOT_JD", false);
    define("MFUN_MOD_L2SDK_WECHAT", true);
    define("MFUN_MOD_L2SDK_IOT_WX", true);
    define("MFUN_MOD_L2SDK_IOT_WX_JSSDK", true);
    define("MFUN_MOD_L2SDK_IOT_HCU", true);
    define("MFUN_MOD_L2SENSOR_EMC", true);
    define("MFUN_MOD_L2SENSOR_HSMMP", true);
    define("MFUN_MOD_L2SENSOR_HUMID", true);
    define("MFUN_MOD_L2SENSOR_NOISE", true);
    define("MFUN_MOD_L2SENSOR_PM25", true);
    define("MFUN_MOD_L2SENSOR_TEMP", true);
    define("MFUN_MOD_L2SENSOR_WINDDIR", true);
    define("MFUN_MOD_L2SENSOR_WINDSPD", true);
    define("MFUN_MOD_L2SENSOR_AIRPRS", true);
    define("MFUN_MOD_L2SENSOR_ALCOHOL", true);
    define("MFUN_MOD_L2SENSOR_CO1", true);
    define("MFUN_MOD_L2SENSOR_HCHO", true);
    define("MFUN_MOD_L2SENSOR_TOXICGAS", true);
    define("MFUN_MOD_L2SENSOR_LIGHTSTR", true);
    define("MFUN_MOD_L3APPL_FUM1SYM", true);
    define("MFUN_MOD_L3APPL_FUM2CM", true);
    define("MFUN_MOD_L3APPL_FUM3DM", true);
    define("MFUN_MOD_L3APPL_FUM4ICM", true);
    define("MFUN_MOD_L3APPL_FUM5FM", true);
    define("MFUN_MOD_L3APPL_FUM6PM", true);
    define("MFUN_MOD_L3APPL_FUM7ADS", true);
    define("MFUN_MOD_L3APPL_FUM8PSM", true);
    define("MFUN_MOD_L3APPL_FUM9GISM", true);
    define("MFUN_MOD_L3APPL_FUMXPRCM", true);
    define("MFUN_MOD_L3WXPRC_EMC", true);
    define("MFUN_MOD_L4AQYC_UI", true);
    define("MFUN_MOD_L4EMCWX_UI", true);
    define("MFUN_MOD_L4TBSWR_UI", false);
    define("MFUN_MOD_L4OAMTOOLS", true);
    define("MFUN_MOD_L5BI", true);
}
elseif (MFUN_CURRENT_WORKING_PROJECT_NAME_UNIQUE == "HCU_PRJ_EMCWX")
{
    define("MFUN_MOD_L1VM", true);
    define("MFUN_MOD_L2SDK_IOT_APPLE", false);
    define("MFUN_MOD_L2SDK_IOT_JD", false);
    define("MFUN_MOD_L2SDK_WECHAT", true);
    define("MFUN_MOD_L2SDK_IOT_WX", true);
    define("MFUN_MOD_L2SDK_IOT_WX_JSSDK", true);
    define("MFUN_MOD_L2SDK_IOT_HCU", false);
    define("MFUN_MOD_L2SENSOR_EMC", true);
    define("MFUN_MOD_L2SENSOR_HSMMP", false);
    define("MFUN_MOD_L2SENSOR_HUMID", false);
    define("MFUN_MOD_L2SENSOR_NOISE", false);
    define("MFUN_MOD_L2SENSOR_PM25", false);
    define("MFUN_MOD_L2SENSOR_TEMP", false);
    define("MFUN_MOD_L2SENSOR_WINDDIR", false);
    define("MFUN_MOD_L2SENSOR_WINDSPD", false);
    define("MFUN_MOD_L2SENSOR_AIRPRS", false);
    define("MFUN_MOD_L2SENSOR_ALCOHOL", false);
    define("MFUN_MOD_L2SENSOR_CO1", false);
    define("MFUN_MOD_L2SENSOR_HCHO", false);
    define("MFUN_MOD_L2SENSOR_TOXICGAS", false);
    define("MFUN_MOD_L2SENSOR_LIGHTSTR", false);
    define("MFUN_MOD_L3APPL_FUM1SYM", false);
    define("MFUN_MOD_L3APPL_FUM2CM", false);
    define("MFUN_MOD_L3APPL_FUM3DM", false);
    define("MFUN_MOD_L3APPL_FUM4ICM", false);
    define("MFUN_MOD_L3APPL_FUM5FM", false);
    define("MFUN_MOD_L3APPL_FUM6PM", false);
    define("MFUN_MOD_L3APPL_FUM7ADS", false);
    define("MFUN_MOD_L3APPL_FUM8PSM", false);
    define("MFUN_MOD_L3APPL_FUM9GISM", false);
    define("MFUN_MOD_L3APPL_FUMXPRCM", false);
    define("MFUN_MOD_L3WXPRC_EMC", true);
    define("MFUN_MOD_L4AQYC_UI", false);
    define("MFUN_MOD_L4EMCWX_UI", true);
    define("MFUN_MOD_L4TBSWR_UI", false);
    define("MFUN_MOD_L4OAMTOOLS", true);
    define("MFUN_MOD_L5BI", true);
}
elseif (MFUN_CURRENT_WORKING_PROJECT_NAME_UNIQUE == "HCU_PRJ_TBSWR")
{
    define("MFUN_MOD_L1VM", true);
    define("MFUN_MOD_L2SDK_IOT_APPLE", false);
    define("MFUN_MOD_L2SDK_IOT_JD", false);
    define("MFUN_MOD_L2SDK_WECHAT", true);
    define("MFUN_MOD_L2SDK_IOT_WX", true);
    define("MFUN_MOD_L2SDK_IOT_WX_JSSDK", true);
    define("MFUN_MOD_L2SDK_IOT_HCU", true);
    define("MFUN_MOD_L2SENSOR_EMC", true);
    define("MFUN_MOD_L2SENSOR_HSMMP", true);
    define("MFUN_MOD_L2SENSOR_HUMID", true);
    define("MFUN_MOD_L2SENSOR_NOISE", true);
    define("MFUN_MOD_L2SENSOR_PM25", true);
    define("MFUN_MOD_L2SENSOR_TEMP", true);
    define("MFUN_MOD_L2SENSOR_WINDDIR", true);
    define("MFUN_MOD_L2SENSOR_WINDSPD", true);
    define("MFUN_MOD_L2SENSOR_AIRPRS", true);
    define("MFUN_MOD_L2SENSOR_ALCOHOL", true);
    define("MFUN_MOD_L2SENSOR_CO1", true);
    define("MFUN_MOD_L2SENSOR_HCHO", true);
    define("MFUN_MOD_L2SENSOR_TOXICGAS", true);
    define("MFUN_MOD_L2SENSOR_LIGHTSTR", true);
    define("MFUN_MOD_L3APPL_FUM1SYM", true);
    define("MFUN_MOD_L3APPL_FUM2CM", true);
    define("MFUN_MOD_L3APPL_FUM3DM", true);
    define("MFUN_MOD_L3APPL_FUM4ICM", true);
    define("MFUN_MOD_L3APPL_FUM5FM", true);
    define("MFUN_MOD_L3APPL_FUM6PM", true);
    define("MFUN_MOD_L3APPL_FUM7ADS", true);
    define("MFUN_MOD_L3APPL_FUM8PSM", true);
    define("MFUN_MOD_L3APPL_FUM9GISM", true);
    define("MFUN_MOD_L3APPL_FUMXPRCM", true);
    define("MFUN_MOD_L3WXPRC_EMC", true);
    define("MFUN_MOD_L4AQYC_UI", false);
    define("MFUN_MOD_L4EMCWX_UI", true);
    define("MFUN_MOD_L4TBSWR_UI", true);
    define("MFUN_MOD_L4OAMTOOLS", true);
    define("MFUN_MOD_L5BI", true);
}
else
{
    define("MFUN_CURRENT_WORKING_PROJECT_NAME_UNIQUE", "HCU_PRJ_AQYC");
    define("MFUN_MOD_L1VM", true);
    define("MFUN_MOD_L2SDK_IOT_APPLE", false);
    define("MFUN_MOD_L2SDK_IOT_JD", false);
    define("MFUN_MOD_L2SDK_WECHAT", true);
    define("MFUN_MOD_L2SDK_IOT_WX", true);
    define("MFUN_MOD_L2SDK_IOT_WX_JSSDK", true);
    define("MFUN_MOD_L2SDK_IOT_HCU", true);
    define("MFUN_MOD_L2SENSOR_EMC", true);
    define("MFUN_MOD_L2SENSOR_HSMMP", true);
    define("MFUN_MOD_L2SENSOR_HUMID", true);
    define("MFUN_MOD_L2SENSOR_NOISE", true);
    define("MFUN_MOD_L2SENSOR_PM25", true);
    define("MFUN_MOD_L2SENSOR_TEMP", true);
    define("MFUN_MOD_L2SENSOR_WINDDIR", true);
    define("MFUN_MOD_L2SENSOR_WINDSPD", true);
    define("MFUN_MOD_L2SENSOR_AIRPRS", true);
    define("MFUN_MOD_L2SENSOR_ALCOHOL", true);
    define("MFUN_MOD_L2SENSOR_CO1", true);
    define("MFUN_MOD_L2SENSOR_HCHO", true);
    define("MFUN_MOD_L2SENSOR_TOXICGAS", true);
    define("MFUN_MOD_L2SENSOR_LIGHTSTR", true);
    define("MFUN_MOD_L3APPL_FUM1SYM", true);
    define("MFUN_MOD_L3APPL_FUM2CM", true);
    define("MFUN_MOD_L3APPL_FUM3DM", true);
    define("MFUN_MOD_L3APPL_FUM4ICM", true);
    define("MFUN_MOD_L3APPL_FUM5FM", true);
    define("MFUN_MOD_L3APPL_FUM6PM", true);
    define("MFUN_MOD_L3APPL_FUM7ADS", true);
    define("MFUN_MOD_L3APPL_FUM8PSM", true);
    define("MFUN_MOD_L3APPL_FUM9GISM", true);
    define("MFUN_MOD_L3APPL_FUMXPRCM", true);
    define("MFUN_MOD_L3WXPRC_EMC", true);
    define("MFUN_MOD_L4AQYC_UI", true);
    define("MFUN_MOD_L4EMCWX_UI", true);
    define("MFUN_MOD_L4TBSWR_UI", false);
    define("MFUN_MOD_L4OAMTOOLS", true);
    define("MFUN_MOD_L5BI", true);
}



?>