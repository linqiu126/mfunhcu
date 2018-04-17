<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 13:43
 */
include_once "../l1comvm/sysconfig.php";
include_once "../l1comvm/pg_general_engpar.php";
//require_once "../l1comvm/sysconfig.php";

/**************************************************************************************
 *                             IHU公共消息全局量定义                                  *
 *************************************************************************************/
//L2处理消息的定义，用于处理微信头。由于微信后台服务器已经完成了这个消息体的处理，因而暂时没用，保留
define("MFUN_IHU_MSG_HEAD_FORMAT", "A2MagicCode/A2Version/A4Length/A4CmdId/A2Seq/A2ErrCode");
define("MFUN_IHU_MSG_HEAD_LENGTH", 16); //8 Byte
define("MFUN_IHU_L3_HEAD_MAGIC", 0xFE);
define("MFUN_IHU_L3_HEAD_VERSION",0x01);
define("MFUN_IHU_L3_HEAD_LENGTH", 0x08);
define("MFUN_IHU_CMDID_SEND_TEXT_REQ", 0x1);    //HW -> CLOUD
define("MFUN_IHU_CMDID_SEND_TEXT_RESP", 0x1001);   //CLOUD ->HW
define("MFUN_IHU_CMDID_OPEN_LIGHT_PUSH", 0x2001);  //CLOUD ->HW
define("MFUN_IHU_CMDID_CLOSE_LIGHT_PUSH", 0x2002);   //CLOUD ->HW
define("MFUN_IHU_CMDID_HW_VERSION_REQ", 0x3001);
define("MFUN_IHU_CMDID_HW_VERSION_RESP", 0x3002);
define("MFUN_IHU_CMDID_HW_VERSION_PUSH", 0x3003);
define("MFUN_IHU_CMDID_EMC_DATA_REV", 0x2712);
define("MFUN_IHU_CMDID_OCH_DATA_REQ", 0x4010);  //酒精测试量
define("MFUN_IHU_CMDID_OCH_DATA_RESP", 0x4011);

//IHU下列L3控制字有效，功能已经实现
define("MFUN_IHU_CMDID_VERSION_SYNC", 0xF0);   //IHU软，硬件版本查询命令字
define("MFUN_IHU_CMDID_TIME_SYNC", 0xF2);    //时间同步命令字
define("MFUN_IHU_CMDID_EMC_DATA", 0x20);   //电磁波辐射测量命令字
define("MFUN_IHU_CMDID_PM25_DATA", 0x25);  //MODBUS 颗粒物命令字
define("MFUN_IHU_CMDID_WINDSPD_DATA", 0x26);  //MODBUS 风速命令字
define("MFUN_IHU_CMDID_WINDDIR_DATA", 0x27);  //MODBUS 风向命令字
define("MFUN_IHU_CMDID_TEMP_DATA", 0x28);  //MODBUS 温度命令字
define("MFUN_IHU_CMDID_HUMID_DATA", 0x29);  //MODBUS 湿度命令字
define("MFUN_IHU_CMDID_HSMMP_DATA", 0x2C);  //Video命令字
define("MFUN_IHU_CMDID_NOISE_DATA", 0x2B);  //Noise命令字
define("MFUN_IHU_CMDID_INVENTORY_DATA", 0xA0); //SW,HW 版本信息
define("MFUN_IHU_CMDID_SW_UPDATE", 0xA1);   //HCU软件更新
define("MFUN_IHU_CMDID_HEART_BEAT", 0xFE); //HCU心跳特殊控制字
define("MFUN_IHU_CMDID_HCU_POLLING", 0xFD); //HCU命令轮询控制字
define("MFUN_IHU_CMDID_EMC_INSTANT_READ", 0x2001); //临时定义给IHU测试,EMC瞬时读取命令
define("MFUN_IHU_CMDID_EMC_PERIOD_READ_OPEN", 0x2002); //EMC周期读取开
define("MFUN_IHU_CMDID_EMC_PERIOD_READ_CLOSE", 0x2003); //EMC周期读取关
define("MFUN_IHU_CMDID_EMC_POWER_STATUS_REQ", 0x2005);  //设备电量查询

define("MFUN_IHU_CMDID_EMC_DATA_RESP", 0x2081); //临时定义给IHU测试
define("MFUN_IHU_CMDID_EMC_POWER_STATUS_RESP", 0x2085); //设备电量查询响应


/**************************************************************************************
 * EMCWX: 电磁辐射微信项目相关缺省配置参数                                            *
 *************************************************************************************/
//正式测试公号/服务公号的配置参数
define("MFUN_WX_TOKEN", "weixin");  //TOKEN，必须和微信绑定的URL使用的TOKEN一致
define("MFUN_WX_DEBUG", false);
define("MFUN_WX_LOGCALLBACK", false);

//用于bind/unbind临时处理功能
if (MFUN_WX_APPID =="wx1183be5c8f6a24b4")  //用于LZH的订阅号
{
    define("device_type","gh_70c714952b02");

    define ("LZH_openid", "oS0Chv3Uum1TZqHaCEb06AoBfCvY");
    define("LZH_deviceid","gh_70c714952b02_8cd47e1f6141e49a4e45f4b807cf41fe");
    define("LZH_qrcode","http://we.qq.com/d/AQBLQKG-27gIDCKf03DmiwAXh27qptK_scSJJRAn");
    define("LZH_mac","D03972A5EF28");

    //define ("ZSC_openid", "oS0ChvxMQEtEhVdxJytcIab5FaHY");
    define ("CZ_openid", "oS0Chv9XjoSv9IvXI-ggBxpNVPck");
    define("CZ_deviceid","gh_70c714952b02_961aeb4272962a376564617830334c23");
    define("CZ_qrcode","http://we.qq.com/d/AQBLQKG-DzKNi89E6XF8QsBUg_OTZqrSTvl80sd5");
    define("CZ_mac","D03972A5EF2A");

    define ("MYC_openid", "oS0Chv0aebwN8O3-7v0hNAX7gy4c");
    define("MYC_deviceid","gh_70c714952b02_f8ac45cf39c447e9bb41dfd449796474");
    define("MYC_qrcode","http://we.qq.com/d/AQBLQKG-ekqCcmpZw5z91QExD6_TDwpzM1-SiC9z");
    //define("MYC_mac","D03972A5EFB5");
    define("MYC_mac","D03972A5EF29");

    define ("ZJL_openid", "oS0Chv-avCH7W4ubqOQAFXojYODY");
    define("ZJL_deviceid","gh_70c714952b02_8248307502397542f48a3775bcb234d4");
    define("ZJL_qrcode","http://we.qq.com/d/AQBLQKG-cFODzg6aCE5C92D1SKGHOirRJtBGwCmd");
    define("ZJL_mac","D03972A5EF27");

    define ("XPH_openid", "oS0ChvwWJOQsIk5xGsRPTQm00C3U");
    define("XPH_deviceid","gh_70c714952b02_955677dfa6db7590f2033b20d3fbad8c");
    define("XPH_qrcode","http://we.qq.com/d/AQBLQKG-4i5gYb6vU8kM8cNnvx0Pg-sdIgXb0n17");
    define("XPH_mac","D03972A5EF30");

    define ("QL_openid", "oS0Chv_Z776kKJ3IeGr8CcpltoYs");
    define("QL_deviceid","gh_70c714952b02_0e152a3026ce99b8687b3a6368e12e26");
    define("QL_qrcode","http://we.qq.com/d/AQBLQKG-vj7lZUDseFmwQh6M6fp8kZon_QQFFHRh");
    define("QL_mac","D03972A5EFF3");

    define ("JT_openid", "oS0Chv0v4eklqQNcaA7cJ_h8Nq4k");
    define("JT_deviceid","gh_70c714952b02_1b6034a2ce38851f999bacc493e3b992");
    define("JT_qrcode","http://we.qq.com/d/AQBLQKG-ksL4ZB14plxy0_pppMVsW9i96e6PzgSJ");
    define("JT_mac","D03972A5EF2C");
}
elseif(MFUN_WX_APPID =="wxf2150c4d2941b2ab") //用于小慧智能的服务号
{
    define("device_type","gh_70c714952b02");

    define ("LZH_openid", "oS0Chv3Uum1TZqHaCEb06AoBfCvY");
    define("LZH_deviceid","gh_70c714952b02_8cd47e1f6141e49a4e45f4b807cf41fe");
    define("LZH_qrcode","http://we.qq.com/d/AQBLQKG-27gIDCKf03DmiwAXh27qptK_scSJJRAn");
    define("LZH_mac","D03972A5EF28");

    //define ("ZSC_openid", "oS0ChvxMQEtEhVdxJytcIab5FaHY");
    define ("CZ_openid", "oS0Chv9XjoSv9IvXI-ggBxpNVPck");
    define("CZ_deviceid","gh_70c714952b02_961aeb4272962a376564617830334c23");
    define("CZ_qrcode","http://we.qq.com/d/AQBLQKG-DzKNi89E6XF8QsBUg_OTZqrSTvl80sd5");
    define("CZ_mac","D03972A5EF2A");

    define ("MYC_openid", "oS0Chv0aebwN8O3-7v0hNAX7gy4c");
    define("MYC_deviceid","gh_70c714952b02_f8ac45cf39c447e9bb41dfd449796474");
    define("MYC_qrcode","http://we.qq.com/d/AQBLQKG-ekqCcmpZw5z91QExD6_TDwpzM1-SiC9z");
    define("MYC_mac","D03972A5EF29");

    define ("ZJL_openid", "oS0Chv-avCH7W4ubqOQAFXojYODY");
    define("ZJL_deviceid","gh_70c714952b02_8248307502397542f48a3775bcb234d4");
    define("ZJL_qrcode","http://we.qq.com/d/AQBLQKG-cFODzg6aCE5C92D1SKGHOirRJtBGwCmd");
    define("ZJL_mac","D03972A5EF27");

    define ("XPH_openid", "oS0ChvwWJOQsIk5xGsRPTQm00C3U");
    define("XPH_deviceid","gh_70c714952b02_955677dfa6db7590f2033b20d3fbad8c");
    define("XPH_qrcode","http://we.qq.com/d/AQBLQKG-4i5gYb6vU8kM8cNnvx0Pg-sdIgXb0n17");
    define("XPH_mac","D03972A5EF30");

    define ("QL_openid", "oS0Chv_Z776kKJ3IeGr8CcpltoYs");
    define("QL_deviceid","gh_70c714952b02_0e152a3026ce99b8687b3a6368e12e26");
    define("QL_qrcode","http://we.qq.com/d/AQBLQKG-vj7lZUDseFmwQh6M6fp8kZon_QQFFHRh");
    define("QL_mac","D03972A5EFF3");

    define ("JT_openid", "oS0Chv0v4eklqQNcaA7cJ_h8Nq4k");
    define("JT_deviceid","gh_70c714952b02_1b6034a2ce38851f999bacc493e3b992");
    define("JT_qrcode","http://we.qq.com/d/AQBLQKG-ksL4ZB14plxy0_pppMVsW9i96e6PzgSJ");
    define("JT_mac","D03972A5EF2C");
}
elseif(MFUN_WX_APPID =="wx32f73ab219f56efb") //用于ZJL的服务号
{
    define("device_type","gh_9b450bb63282");

    define ("ZSC_openid", "oAjc8uJALtEIF_b5cCRhSWXCOG1A");
    define("ZSC_deviceid","gh_9b450bb63282_02414f1001725e2531d65c544d40fefb");
    define("ZSC_qrcode","http://we.qq.com/d/AQACNzy4rYHiiD84ocyPRa-NMM70_vULC2OdJmWB");
    define("ZSC_mac","D03972A5EF25");

    define ("LZH_openid", "oAjc8uL3gUATT-99a5giFDgWMlFI");
    define("LZH_deviceid","gh_9b450bb63282_f042865f8a506bbcf1a98d1badf013dd");
    define("LZH_qrcode","http://we.qq.com/d/AQACNzy4wiXaw5bg8V3yG_Nx6-IqavEnmfZ9Ff92");
    define("LZH_mac","D03972A5EF26");

    define ("MYC_openid", "oAjc8uBMxuO-Vr0jmApNZF4sGB1A");
    define("MYC_deviceid","gh_9b450bb63282_141e7fe7d78afb93fdd0672529d5ad32");
    define("MYC_qrcode","http://we.qq.com/d/AQACNzy4JOGhuiMEWTjlZZ-Z4Xk0gDIQ0eJMbBzG");
    define("MYC_mac","D03972A5EF28");

    define ("ZJL_openid", "oAjc8uKl-QS9EGIfRGb81kc9fdJE");
    define("ZJL_deviceid","gh_9b450bb63282_f0c80cde21690dd1e4507d3cc69e7112");
    define("ZJL_qrcode","http://we.qq.com/d/AQACNzy4W-V4iwjP0aiuU0Wrpp6n-ODxlkIfIQZY");
    define("ZJL_mac","D03972A5EF27");
}

//定义数据保存不删的时间长度
if (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_EMCWX){
    define ("MFUN_HCU_DATA_SAVE_DURATION_BY_PROJ", 90);
}

?>