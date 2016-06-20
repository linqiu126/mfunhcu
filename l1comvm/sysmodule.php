<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 13:29
 */

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