<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 13:29
 */
include_once "../l1comvm/sysconfig.php";
include_once "../l1comvm/sysdim.php";

//全局TaskId的定义，全系统唯一定义，后面会不断的用到
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
define("MFUN_TASK_ID_NULL", 39); //注意，不能超过系统DIMENSION中的MAX_TASK_NUM_IN_ONE_MFUN

//全局TaskName的定义
class MfunSysTaskList
{
    public static $mfunTaskArrayVar = array(
        MFUN_TASK_ID_MIN => array("NAME" => "MFUN_TASK_MIN", "PRESENT" => true),
        MFUN_TASK_ID_L1VM => array("NAME" => "MFUN_TASK_L1VM", "PRESENT" => true),
        MFUN_TASK_ID_L2SDK_IOT_APPLE => array("NAME" => "MFUN_TASK_L2SDK_IOT_APPLE", "PRESENT" => true),
        MFUN_TASK_ID_L2SDK_IOT_JD => array("NAME" => "MFUN_TASK_L2SDK_IOT_JD", "PRESENT" => true),
        MFUN_TASK_ID_L2SDK_WECHAT => array("NAME" => "MFUN_TASK_L2SDK_WECHAT", "PRESENT" => true),
        MFUN_TASK_ID_L2SDK_IOT_WX => array("NAME" => "MFUN_TASK_L2SDK_IOT_WX", "PRESENT" => true),
        MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK => array("NAME" => "MFUN_TASK_L2SDK_IOT_WX_JSSDK", "PRESENT" => true),
        MFUN_TASK_ID_L2SDK_IOT_HCU => array("NAME" => "MFUN_TASK_L2SDK_IOT_HCU", "PRESENT" => true),
        MFUN_TASK_ID_L2SENSOR_EMC => array("NAME" => "MFUN_TASK_L2SENSOR_EMC", "PRESENT" => true),
        MFUN_TASK_ID_L2SENSOR_HSMMP => array("NAME" => "MFUN_TASK_L2SENSOR_HSMMP", "PRESENT" => true),
        MFUN_TASK_ID_L2SENSOR_HUMID => array("NAME" => "MFUN_TASK_L2SENSOR_HUMID", "PRESENT" => true),
        MFUN_TASK_ID_L2SENSOR_NOISE => array("NAME" => "MFUN_TASK_L2SENSOR_NOISE", "PRESENT" => true),
        MFUN_TASK_ID_L2SENSOR_PM25 => array("NAME" => "MFUN_TASK_L2SENSOR_PM25", "PRESENT" => true),
        MFUN_TASK_ID_L2SENSOR_TEMP => array("NAME" => "MFUN_TASK_L2SENSOR_TEMP", "PRESENT" => true),
        MFUN_TASK_ID_L2SENSOR_WINDDIR => array("NAME" => "MFUN_TASK_L2SENSOR_WINDDIR", "PRESENT" => true),
        MFUN_TASK_ID_L2SENSOR_WINDSPD => array("NAME" => "MFUN_TASK_L2SENSOR_WINDSPD", "PRESENT" => true),
        MFUN_TASK_ID_L2SENSOR_AIRPRS => array("NAME" => "MFUN_TASK_L2SENSOR_AIRPRS", "PRESENT" => true),
        MFUN_TASK_ID_L2SENSOR_ALCOHOL => array("NAME" => "MFUN_TASK_L2SENSOR_ALCOHOL", "PRESENT" => true),
        MFUN_TASK_ID_L2SENSOR_CO1 =>array("NAME" => "MFUN_TASK_L2SENSOR_CO1", "PRESENT" => true),
        MFUN_TASK_ID_L2SENSOR_HCHO => array("NAME" => "MFUN_TASK_L2SENSOR_HCHO", "PRESENT" => true),
        MFUN_TASK_ID_L2SENSOR_TOXICGAS => array("NAME" => "MFUN_TASK_L2SENSOR_TOXICGAS", "PRESENT" => true),
        MFUN_TASK_ID_L2SENSOR_LIGHTSTR => array("NAME" => "MFUN_TASK_L2SENSOR_LIGHTSTR", "PRESENT" => true),
        MFUN_TASK_ID_L3APPL_FUM1SYM => array("NAME" => "MFUN_TASK_L3APPL_FUM1SYM", "PRESENT" => true),
        MFUN_TASK_ID_L3APPL_FUM2CM => array("NAME" => "MFUN_TASK_L3APPL_FUM2CM", "PRESENT" => true),
        MFUN_TASK_ID_L3APPL_FUM3DM => array("NAME" => "MFUN_TASK_L3APPL_FUM3DM", "PRESENT" => true),
        MFUN_TASK_ID_L3APPL_FUM4ICM => array("NAME" => "MFUN_TASK_L3APPL_FUM4ICM", "PRESENT" => true),
        MFUN_TASK_ID_L3APPL_FUM5FM => array("NAME" => "MFUN_TASK_L3APPL_FUM5FM", "PRESENT" => true),
        MFUN_TASK_ID_L3APPL_FUM6PM => array("NAME" => "MFUN_TASK_L3APPL_FUM6PM", "PRESENT" => true),
        MFUN_TASK_ID_L3APPL_FUM7ADS => array("NAME" => "MFUN_TASK_L3APPL_FUM7ADS", "PRESENT" => true),
        MFUN_TASK_ID_L3APPL_FUM8PSM => array("NAME" => "MFUN_TASK_L3APPL_FUM8PSM", "PRESENT" => true),
        MFUN_TASK_ID_L3APPL_FUM9GISM => array("NAME" => "MFUN_TASK_L3APPL_FUM9GISM", "PRESENT" => true),
        MFUN_TASK_ID_L3APPL_FUMXPRCM => array("NAME" => "MFUN_TASK_L3APPL_FUMXPRCM", "PRESENT" => true),
        MFUN_TASK_ID_L3WXPRC_EMC => array("NAME" => "MFUN_TASK_L3WXPRC_EMC", "PRESENT" => true),
        MFUN_TASK_ID_L4AQYC_UI => array("NAME" => "MFUN_TASK_L4AQYC_UI", "PRESENT" => true),
        MFUN_TASK_ID_L4EMCWX_UI => array("NAME" => "MFUN_TASK_L4EMCWX_UI", "PRESENT" => true),
        MFUN_TASK_ID_L4TBSWR_UI => array("NAME" => "MFUN_TASK_L4TBSWR_UI", "PRESENT" => true),
        MFUN_TASK_ID_L4OAMTOOLS => array("NAME" => "MFUN_TASK_L4OAMTOOLS", "PRESENT" => true),
        MFUN_TASK_ID_L5BI => array("NAME" => "MFUN_TASK_L5BI", "PRESENT" => true),
        MFUN_TASK_ID_MAX => array("NAME" => "MFUN_TASK_MAX", "PRESENT" => true),
        MFUN_TASK_ID_NULL => array("NAME" => "MFUN_TASK_NULL", "PRESENT" => true),
    );

    //构造函数，根据配置信息初始化Present状态
    public function __construct()
    {
        //按照不同的工作配置情况，设置模块标识及PRESENT情况
        if (MFUN_CURRENT_WORKING_PROJECT_NAME_UNIQUE == "HCU_PRJ_AQYC")
        {
            $mfunTaskArrayVar[MFUN_TASK_ID_MIN]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_APPLE]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_JD]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_HCU]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_EMC]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_HSMMP]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_HUMID]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_NOISE]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_PM25]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_TEMP]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_WINDDIR]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_WINDSPD]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_AIRPRS]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_ALCOHOL]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_CO1]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_HCHO]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_TOXICGAS]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_LIGHTSTR]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM1SYM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM2CM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM3DM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM4ICM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM5FM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM6PM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM7ADS]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM8PSM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM9GISM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUMXPRCM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3WXPRC_EMC]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4AQYC_UI]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4EMCWX_UI]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4TBSWR_UI]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_MAX]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_NULL]["PRESENT"] = false;
        }
        elseif (MFUN_CURRENT_WORKING_PROJECT_NAME_UNIQUE == "HCU_PRJ_EMCWX")
        {
            $mfunTaskArrayVar[MFUN_TASK_ID_MIN]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_APPLE]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_JD]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_HCU]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_EMC]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_HSMMP]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_HUMID]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_NOISE]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_PM25]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_TEMP]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_WINDDIR]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_WINDSPD]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_AIRPRS]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_ALCOHOL]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_CO1]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_HCHO]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_TOXICGAS]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_LIGHTSTR]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM1SYM]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM2CM]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM3DM]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM4ICM]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM5FM]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM6PM]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM7ADS]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM8PSM]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM9GISM]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUMXPRCM]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3WXPRC_EMC]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4AQYC_UI]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4EMCWX_UI]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4TBSWR_UI]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_MAX]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_NULL]["PRESENT"] = false;
        }
        elseif (MFUN_CURRENT_WORKING_PROJECT_NAME_UNIQUE == "HCU_PRJ_TBSWR")
        {
            $mfunTaskArrayVar[MFUN_TASK_ID_MIN]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_APPLE]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_JD]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_HCU]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_EMC]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_HSMMP]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_HUMID]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_NOISE]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_PM25]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_TEMP]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_WINDDIR]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_WINDSPD]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_AIRPRS]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_ALCOHOL]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_CO1]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_HCHO]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_TOXICGAS]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_LIGHTSTR]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM1SYM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM2CM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM3DM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM4ICM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM5FM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM6PM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM7ADS]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM8PSM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM9GISM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUMXPRCM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3WXPRC_EMC]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4AQYC_UI]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4EMCWX_UI]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4TBSWR_UI]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_MAX]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_NULL]["PRESENT"] = false;
        }
        else
        {
            //缺省配置成AQYC项目
            define("MFUN_CURRENT_WORKING_PROJECT_NAME_UNIQUE", "HCU_PRJ_AQYC");
            $mfunTaskArrayVar[MFUN_TASK_ID_MIN]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_APPLE]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_JD]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SDK_IOT_HCU]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_EMC]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_HSMMP]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_HUMID]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_NOISE]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_PM25]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_TEMP]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_WINDDIR]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_WINDSPD]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_AIRPRS]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_ALCOHOL]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_CO1]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_HCHO]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_TOXICGAS]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L2SENSOR_LIGHTSTR]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM1SYM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM2CM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM3DM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM4ICM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM5FM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM6PM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM7ADS]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM8PSM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUM9GISM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3APPL_FUMXPRCM]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L3WXPRC_EMC]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4AQYC_UI]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4EMCWX_UI]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4TBSWR_UI]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
            $mfunTaskArrayVar[MFUN_TASK_ID_MAX]["PRESENT"] = false;
            $mfunTaskArrayVar[MFUN_TASK_ID_NULL]["PRESENT"] = false;
        }
    }

    //通过TaskId读取TaskName
    public static function mfun_vm_getTaskName($taskId)
    {
        if (isset(self::$mfunTaskArrayVar[$taskId]["NAME"])) {
            return self::$mfunTaskArrayVar[$taskId]["NAME"];
        }else {
            return false;
        };
    }

    //通过TaskName读取TaskId
    public static function mfun_vm_getTaskId($taskName)
    {
        for ($i = MFUN_TASK_ID_MIN; $i < MFUN_TASK_ID_MAX; $i++) {
            if (isset(self::$mfunTaskArrayVar[$i]["NAME"]) == $taskName)
                return $i;
        }
        return false;
    }

    //通过TaskId读取Present状态
    public static function mfun_vm_getTaskPresent($taskId)
    {
        if (isset(self::$mfunTaskArrayVar[$taskId]["PRESENT"])) {
            return self::$mfunTaskArrayVar[$taskId]["PRESENT"];
        }else {
            return false;
        };
    }
}

?>