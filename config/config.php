<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2015/7/5
 * Time: 9:26
 */


/**************************************************************************************
 *                             公共消息全局量定义                                     *
 *************************************************************************************/
define("CURRENT_VERSION", "R02_D11");  //当前SAE应用版本号

define("TIME_GRID_SIZE", 1); //定义用于数据存储的时间网格为。单位为分钟

define("XML_FORMAT", "<x"); //XML数据格式，消息以<xml开头
define("ZHB_FORMAT", "##"); //中环保数据格式，消息以##开头

define("PG_CODE_PREFIX", "PG");   //定义项目组code的特征字，项目组code必须以“PG”开头
define("PROJ_CODE_PREFIX", "P_");  //定义项目code的特征字，项目code必须以“P_”开头
define("UID_PREFIX", "UID");  //定义用户ID的特征字，用户ID必须以UID开头
define("CODE_FORMAT_LEN", 2); //定义项目code和项目组code的特征字长度
define("SESSIONID_VALID_TIME", 1800);  //Session ID有效时间为30分钟

define("IHU_MSG_HEAD_FORMAT", "A4MagicCode/A4Version/A4Length/A4CmdId/A4Seq/A4ErrCode");
define("IHU_MSG_HEAD_LENGTH", 24); //12 Byte
define("HCU_MSG_HEAD_FORMAT", "A2Key/A2Len/A2Cmd");// 1B 控制字ctrl_key, 1B 长度length（除控制字和长度本身外），1B 操作字opt_key
define("HCU_MSG_HEAD_LENGTH", 6); //3 Byte

define("PLTF_WX", 0x01);  //微信平台
define("PLTF_HCU", 0x02); //HCU平台
define("PLTF_JD", 0x03);  //京东平台

define("HOUR_VALIDE_NUM", 54); // HCU环保标准：1小时采集的有效分钟数据应不少于 54个
define("DAY_VALIDE_NUM", 21);  // HCU环保标准：每日应有不少于21个有效小时均值的算术平均值为有效日均值

define("MAX_LOG_NUM", 5000);  //防止t_loginfo表单数据无限制的增长，保留的最大记录数

define("ZHB_HRB_FRAME","ZHB_HRB");
define("ZHB_NOM_FRAME","ZHB_NOM");

define("SESSION_ID_LEN", 8); //UI界面session id字符串长度
define("USER_ID_LEN", 6); //UI界面user id字符串长度

//定义各测量值告警门限
define("TH_ALARM_NOISE", 80);
define("TH_ALARM_HUMIDITY", 50);
define("TH_ALARM_TEMPERATURE", 45);
define("TH_ALARM_PM25", 100);
define("TH_ALARM_WINDSPEED", 20);
define("TH_ALARM_EMC", 100);
define("TH_ALARM_WINDDIR", 360);

//定义传感器类型
define("S_TYPE_PM", "S_0001");
define("S_TYPE_WINDSPEED", "S_0002");
define("S_TYPE_WINDDIR", "S_0003");
define("S_TYPE_EMC", "S_0005");
define("S_TYPE_TEMPERATURE", "S_0006");
define("S_TYPE_HUMIDITY", "S_0007");
define("S_TYPE_NOISE", "S_000A");

//层三处理消息的定义，保留，暂时没有使用
define("L3_HEAD_MAGIC", 0xFE);
define("L3_HEAD_VERSION",0x01);
define("L3_HEAD_LENGTH", 0x08);
define("CMDID_SEND_TEXT_REQ", 0x1);    //HW -> CLOUD
define("CMDID_SEND_TEXT_RESP", 0x1001);   //CLOUD ->HW
define("CMDID_OPEN_LIGHT_PUSH", 0x2001);  //CLOUD ->HW
define("CMDID_CLOSE_LIGHT_PUSH", 0x2002);   //CLOUD ->HW
define("CMDID_HW_VERSION_REQ", 0x3001);
define("CMDID_HW_VERSION_RESP", 0x3002);
define("CMDID_HW_VERSION_PUSH", 0x3003);
define("CMDID_EMC_DATA_REV", 0x2712);
define("CMDID_OCH_DATA_REQ", 0x4010);  //酒精测试量
define("CMDID_OCH_DATA_RESP", 0x4011);

//下列L3控制字有效，功能已经实现
define("CMDID_VERSION_SYNC", 0xF0);   //IHU软，硬件版本查询命令字
define("CMDID_TIME_SYNC", 0xF2);    //时间同步命令字
define("CMDID_EMC_DATA", 0x20);   //电磁波辐射测量命令字
define("CMDID_PM_DATA", 0x25);  //MODBUS 颗粒物命令字
define("CMDID_WINDSPEED_DATA", 0x26);  //MODBUS 风速命令字
define("CMDID_WINDDIR_DATA", 0x27);  //MODBUS 风向命令字
define("CMDID_TEMPERATURE_DATA", 0x28);  //MODBUS 温度命令字
define("CMDID_HUMIDITY_DATA", 0x29);  //MODBUS 湿度命令字
define("CMDID_VIDEO_DATA", 0x2C);  //Video命令字
define("CMDID_NOISE_DATA", 0x2B);  //Noise命令字

define("CMDID_INVENTORY_DATA", 0xA0); //SW,HW 版本信息
define("CMDID_SW_UPDATE", 0xA1);   //HCU软件更新

define("CMDID_HEART_BEAT", 0xFE); //HCU心跳特殊控制字
define("CMDID_HCU_POLLING", 0xFD); //HCU命令轮询控制字

define("CMDID_EMC_DATA_PUSH", 0x2001); //临时定义给IHU测试
define("CMDID_EMC_DATA_RESP", 0x2081); //临时定义给IHU测试

//MODBUS操作字，0x0开头表示下行从CLOUD到下位机
define("MODBUS_DATA_REQ", 0x01); //测量命令
define("MODBUS_SWITCH_SET", 0x02);
define("MODBUS_ADDR_SET", 0x03);
define("MODBUS_PERIOD_SET", 0x04);
define("MODBUS_SAMPLES_SET", 0x05);
define("MODBUS_TIMES_SET", 0x06);
define("MODBUS_SWITCH_READ", 0x07);
define("MODBUS_ADDR_READ", 0x08);
define("MODBUS_PERIOD_READ", 0x09);
define("MODBUS_SAMPLES_READ", 0x0A);
define("MODBUS_TIMES_READ", 0x0B);

//MODBUS操作字，0x8开头表示下行从下位机到CLOUD
define("MODBUS_DATA_REPORT", 0x81);  //测量报告
define("MODBUS_SWITCH_SET_ACK", 0x82);
define("MODBUS_ADDR_SET_ACK", 0x83);
define("MODBUS_PERIOD_SET_ACK", 0x84);
define("MODBUS_SAMPLE_SET_ACK", 0x85);
define("MODBUS_TIMES_SET_ACK", 0x86);
define("MODBUS_SWITCH_READ_ACK", 0x87);
define("MODBUS_ADDR_READ_ACK", 0x88);
define("MODBUS_PERIOD_READ_ACK", 0x89);
define("MODBUS_SAMPLE_READ_ACK", 0x8A);
define("MODBUS_TIMES_READ_ACK", 0x8B);

//其他命令操作字
define("OPT_INVENTORY_REQ", 0x01);
define("OPT_INVENTORY_RESP", 0x81);

define("OPT_VEDIOLINK_REQ", 0x01);  //读取下位机存放的视频文件link
define("OPT_VEDIOLINK_RESP", 0x81); //返回下位机存放的视频文件link
define("OPT_VEDIOFILE_REQ", 0x02);   //命令下位机上传选中的视频文件
define("OPT_VEDIOFILE_RESP", 0x82);  //视频文件传输完成响应

//传感器ID定义
define ("ID_EQUIP_PM", 0x01);
define ("ID_EQUIP_WINDSPEED", 0x02);
define ("ID_EQUIP_WINDDIR", 0x03);
define ("ID_EQUIP_EMC", 0x05);
define ("ID_EQUIP_TEMPERATURE", 0x06);
define ("ID_EQUIP_HUMIDITY", 0x06);
define ("ID_EQUIP_NOISE", 0x0A);

/**************************************************************************************
 *                             微信相关配置参数                                       *
 *************************************************************************************/
//正式测试公号/服务公号的配置参数
date_default_timezone_set('prc');  //设置时区为北京时间
define("WX_TOKEN", "weixin");  //TOKEN，必须和微信绑定的URL使用的TOKEN一致
define("WX_DEBUG", false);
define("WX_LOGCALLBACK", false);

//不同的方式来确定本机运行环境，还是服务器运行环境，本来想获取Localhost来进行判断，但没成功
//实验了不同的方式，包括$_SERVER['LOCAL_ADDR']， $_SERVER['SERVER_ADDR']， getenv('SERVER_ADDR')等方式
//GetHostByName($_SERVER['SERVER_NAME'])只能获取IP地址，也不稳定
//使用php_uname('n') == "CV0002816N4")也算是一个不错的方式，但依然丑陋，需要每个测试者单独配置，
//也可以使用云服务器的名字来反向匹配，因为服务器的名字是唯一的
//SAE官方的说法：可以使用isset(SAE_TMP_PATH)来判断是不是在SAE云上
//
if ($_SERVER['SERVER_NAME'] == "mfuncard.sinaapp.com") //LZH微信公号服务器数据库配置信息
{
    /*
    define("WX_APPID", "wx1183be5c8f6a24b4");  //微信测试号AppID
    define("WX_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");  //填写高级调用功能的app id, 请在微信开发模式后台查询
    define("WX_ENCODINGAESKEY", "ihIyvJ8LLAnOHpHzKTG0yIJxlzl1Fzw5ygRgHO96ieW");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

    //测试公号的后台运行配置参数
    define("WX_TOOL_SERVICENUM", "gh_70c714952b02");//微信号
    define("WX_TOOL_APPID", "wx1183be5c8f6a24b4");//微信测试号信息
    define("WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
    define("WX_TOOL_BLEMAC", "D03972A5EF25");
    */
    define("CLOUD_HCU", "SAE_HCU"); //HCU后台云应用
    define("CLOUD_WX", "SAE_WX"); //微信后台云应用

    define("WX_APPID", "wx32f73ab219f56efb");  //微信测试号AppID
    define("WX_APPSECRET", "eca20c2a26a5ec5b64a89d15ba92a781");  //填写高级调用功能的app id, 请在微信开发模式后台查询
    define("WX_ENCODINGAESKEY", "7Tp1NIUzUa0JBezeJUjG8O61Kdjcu2ce6BQVukZlv3u");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

    //测试公号的后台运行配置参数
    define("WX_TOOL_SERVICENUM", "gh_9b450bb63282");
    define("WX_TOOL_APPID", "wx32f73ab219f56efb");
    define("WX_TOOL_APPSECRET", "eca20c2a26a5ec5b64a89d15ba92a781");
    define("WX_TOOL_BLEMAC", "D03972A5EF25");

    define("WX_DBHOST", SAE_MYSQL_HOST_M);    //连接的服务器地址 w.rdc.sae.sina.com.cn
    define("WX_DBUSER",SAE_MYSQL_USER);     //连接数据库的用户名
    define("WX_DBPSW", SAE_MYSQL_PASS);        //连接数据库的密码
    define("WX_DBNAME","app_mfuncard");         //连接的数据库名称
    define("WX_DBPORT", SAE_MYSQL_PORT);
    define("WX_DBHOST_S", SAE_MYSQL_DB);

}elseif ($_SERVER['SERVER_NAME'] == "mfunhcu.sinaapp.com")
{
    define("CLOUD_HCU", "SAE_HCU"); //HCU后台云应用
    define("CLOUD_WX", "SAE_WX"); //微信后台云应用

    define("WX_APPID", "wx1183be5c8f6a24b4");  //微信测试号AppID
    define("WX_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");  //填写高级调用功能的app id, 请在微信开发模式后台查询
    define("WX_ENCODINGAESKEY", "ihIyvJ8LLAnOHpHzKTG0yIJxlzl1Fzw5ygRgHO96ieW");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

    //测试公号的后台运行配置参数
    define("WX_TOOL_SERVICENUM", "gh_70c714952b02");
    define("WX_TOOL_APPID", "wx1183be5c8f6a24b4");
    define("WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
    define("WX_TOOL_BLEMAC", "D03972A5EF27");

    define("WX_DBHOST", SAE_MYSQL_HOST_M);    //连接的服务器地址 w.rdc.sae.sina.com.cn
    define("WX_DBUSER",SAE_MYSQL_USER);     //连接数据库的用户名
    define("WX_DBPSW", SAE_MYSQL_PASS);        //连接数据库的密码
    define("WX_DBNAME","app_mfunhcu");         //连接的数据库名称
    define("WX_DBPORT", SAE_MYSQL_PORT);
    define("WX_DBHOST_S", SAE_MYSQL_DB);

}elseif ($_SERVER['SERVER_NAME'] == "smdzjl.sinaapp.com") //ZJL微信公号服务器数据库配置信息
{
    define("CLOUD_HCU", "SAE_HCU"); //HCU后台云应用
    define("CLOUD_WX", "SAE_WX"); //微信后台云应用

    define("WX_APPID", "wx32f73ab219f56efb");  //微信测试号AppID
    define("WX_APPSECRET", "eca20c2a26a5ec5b64a89d15ba92a781");  //填写高级调用功能的app id, 请在微信开发模式后台查询
    define("WX_ENCODINGAESKEY", "7Tp1NIUzUa0JBezeJUjG8O61Kdjcu2ce6BQVukZlv3u");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

    //测试公号的后台运行配置参数
    define("WX_TOOL_SERVICENUM", "gh_9b450bb63282");
    define("WX_TOOL_APPID", "wx32f73ab219f56efb");
    define("WX_TOOL_APPSECRET", "eca20c2a26a5ec5b64a89d15ba92a781");
    define("WX_TOOL_BLEMAC", "D03972A5EF24");

    define("WX_DBHOST", SAE_MYSQL_HOST_M);    //连接的服务器地址 w.rdc.sae.sina.com.cn
    define("WX_DBUSER",SAE_MYSQL_USER);     //连接数据库的用户名
    define("WX_DBPSW", SAE_MYSQL_PASS);        //连接数据库的密码
    define("WX_DBNAME","app_smdzjl");         //连接的数据库名称
    define("WX_DBPORT", SAE_MYSQL_PORT);
    define("WX_DBHOST_S", SAE_MYSQL_DB);

}elseif ($_SERVER['SERVER_NAME'] == "zscble.sinaapp.com") //ZSC微信公号服务器数据库配置信息
{
    define("CLOUD_HCU", "SAE_HCU"); //HCU后台云应用
    define("CLOUD_WX", "SAE_WX"); //微信后台云应用

    define("WX_APPID", "wx6b0e904f5e91a404");  //微信测试号AppID
    define("WX_APPSECRET", "aeb0cf36a1aa37b0180711304f3f3131");  //填写高级调用功能的app id, 请在微信开发模式后台查询
    define("WX_ENCODINGAESKEY", "p1zUNVmJAOWX7QsnArWIbuAEYaqtRNFY6Rz1JcqEklu");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

    //测试公号的后台运行配置参数
    define("WX_TOOL_SERVICENUM", "gh_b6df3b7c56eb");
    define("WX_TOOL_APPID", "wx6b0e904f5e91a404");
    define("WX_TOOL_APPSECRET", "aeb0cf36a1aa37b0180711304f3f3131");
    define("WX_TOOL_BLEMAC", "D03972A5EF12");

    define("WX_DBHOST", SAE_MYSQL_HOST_M);    //连接的服务器地址 w.rdc.sae.sina.com.cn
    define("WX_DBUSER",SAE_MYSQL_USER);     //连接数据库的用户名
    define("WX_DBPSW", SAE_MYSQL_PASS);        //连接数据库的密码
    define("WX_DBNAME","app_zscble");         //连接的数据库名称
    define("WX_DBPORT", SAE_MYSQL_PORT);
    define("WX_DBHOST_S", SAE_MYSQL_DB);

}elseif ($_SERVER['SERVER_NAME'] == "121.40.185.177") //爱启云
{
    define("CLOUD_HCU", "AQ_HCU"); //HCU后台云应用
    define("CLOUD_WX", "AQ_WX"); //微信后台云应用

    //define("WX_DBHOST", "h5.aiqiworld.com/myAdmin");    //连接的服务器地址
    define("WX_DBHOST", "127.0.0.1");    //连接的服务器地址
    define("WX_DBUSER","root");     //连接数据库的用户名
    define("WX_DBPSW", "smoon");        //连接数据库的密码
    define("WX_DBNAME","bxxh");         //连接的数据库名称BXXH
    define("WX_DBPORT", 3306);           //缺省设置
    define("WX_DBHOST_S", "");          //无效

    define("WX_APPID", "wx1183be5c8f6a24b4");  //微信测试号AppID
    define("WX_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");  //填写高级调用功能的app id, 请在微信开发模式后台查询
    define("WX_ENCODINGAESKEY", "ihIyvJ8LLAnOHpHzKTG0yIJxlzl1Fzw5ygRgHO96ieW");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

    //测试公号的后台运行配置参数
    define("WX_TOOL_SERVICENUM", "gh_70c714952b02");
    define("WX_TOOL_APPID", "wx1183be5c8f6a24b4");
    define("WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
    define("WX_TOOL_BLEMAC", "D03972A5EF27");

}else   //本地配置数据库信息,需要根据个人配置修改
{
    define("CLOUD_HCU", "AQ_HCU"); //HCU后台云应用
    define("CLOUD_WX", "AQ_WX"); //微信后台云应用

    define("WX_DBHOST", "localhost");    //连接的服务器地址
    define("WX_DBUSER","TestUser");     //连接数据库的用户名
    define("WX_DBPSW", "123456");        //连接数据库的密码
    define("WX_DBNAME","BXXH");         //连接的数据库名称BXXH
    define("WX_DBPORT", 3306);           //缺省设置
    define("WX_DBHOST_S", "");          //无效

    define("WX_APPID", "wx1183be5c8f6a24b4");  //微信测试号AppID
    define("WX_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");  //填写高级调用功能的app id, 请在微信开发模式后台查询
    define("WX_ENCODINGAESKEY", "ihIyvJ8LLAnOHpHzKTG0yIJxlzl1Fzw5ygRgHO96ieW");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

    //测试公号的后台运行配置参数
    define("WX_TOOL_SERVICENUM", "gh_70c714952b02");//微信号
    define("WX_TOOL_APPID", "wx1183be5c8f6a24b4");//微信测试号信息
    define("WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
    define("WX_TOOL_BLEMAC", "D03972A5EF11");
}

//用于bind/unbind临时处理功能
if (WX_APPID =="wx1183be5c8f6a24b4")  //用于LZH的订阅号
{
    define("device_type","gh_70c714952b02");

    define ("LZH_openid", "oS0Chv3Uum1TZqHaCEb06AoBfCvY");
    define("LZH_deviceid","gh_70c714952b02_8cd47e1f6141e49a4e45f4b807cf41fe");
    define("LZH_qrcode","http://we.qq.com/d/AQBLQKG-27gIDCKf03DmiwAXh27qptK_scSJJRAn");
    define("LZH_mac","D03972A5EF28");

    define ("ZSC_openid", "oS0ChvxMQEtEhVdxJytcIab5FaHY");
    define("ZSC_deviceid","gh_70c714952b02_961aeb4272962a376564617830334c23");
    define("ZSC_qrcode","http://we.qq.com/d/AQBLQKG-DzKNi89E6XF8QsBUg_OTZqrSTvl80sd5");
    define("ZSC_mac","D03972A5EF25");

    define ("MYC_openid", "oS0Chv0aebwN8O3-7v0hNAX7gy4c");
    define("MYC_deviceid","gh_70c714952b02_f8ac45cf39c447e9bb41dfd449796474");
    define("MYC_qrcode","http://we.qq.com/d/AQBLQKG-ekqCcmpZw5z91QExD6_TDwpzM1-SiC9z");
    define("MYC_mac","D03972A5EFB5");

    define ("ZJL_openid", "oS0Chv-avCH7W4ubqOQAFXojYODY");
    define("ZJL_deviceid","gh_70c714952b02_8248307502397542f48a3775bcb234d4");
    define("ZJL_qrcode","http://we.qq.com/d/AQBLQKG-cFODzg6aCE5C92D1SKGHOirRJtBGwCmd");
    define("ZJL_mac","D03972A5EF27");

    define ("CZ_openid", "oS0Chv9XjoSv9IvXI-ggBxpNVPck");
    define("CZ_deviceid","gh_70c714952b02_955677dfa6db7590f2033b20d3fbad8c");
    define("CZ_qrcode","http://we.qq.com/d/AQBLQKG-4i5gYb6vU8kM8cNnvx0Pg-sdIgXb0n17");
    define("CZ_mac","D03972A5EFF2");

    define ("QL_openid", "oS0Chv_Z776kKJ3IeGr8CcpltoYs");
    define("QL_deviceid","gh_70c714952b02_0e152a3026ce99b8687b3a6368e12e26");
    define("QL_qrcode","http://we.qq.com/d/AQBLQKG-vj7lZUDseFmwQh6M6fp8kZon_QQFFHRh");
    define("QL_mac","D03972A5EFF3");

    define ("JT_openid", "oS0Chv0v4eklqQNcaA7cJ_h8Nq4k");
    define("JT_deviceid","gh_70c714952b02_1b6034a2ce38851f999bacc493e3b992");
    define("JT_qrcode","http://we.qq.com/d/AQBLQKG-ksL4ZB14plxy0_pppMVsW9i96e6PzgSJ");
    define("JT_mac","D03972A5EFF4");
}
elseif(WX_APPID =="wx32f73ab219f56efb") //用于ZJL的服务号
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

?>

