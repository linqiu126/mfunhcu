<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 13:15
 */
include_once "../l1comvm/sysconfig.php";

/**************************************************************************************
 * AQYC: 爱启杨尘项目相关缺省配置参数                                                   *
 *************************************************************************************/

define("PG_CODE_PREFIX", "PG");   //定义项目组code的特征字，项目组code必须以“PG”开头
define("PROJ_CODE_PREFIX", "P_");  //定义项目code的特征字，项目code必须以“P_”开头
define("UID_PREFIX", "UID");  //定义用户ID的特征字，用户ID必须以UID开头
define("CODE_FORMAT_LEN", 2); //定义项目code和项目组code的特征字长度
define("SESSIONID_VALID_TIME", 1800);  //Session ID有效时间为30分钟

define("HOUR_VALIDE_NUM", 54); // HCU环保标准：1小时采集的有效分钟数据应不少于 54个
define("DAY_VALIDE_NUM", 21);  // HCU环保标准：每日应有不少于21个有效小时均值的算术平均值为有效日均值

define("MAX_LOG_NUM", 5000);  //防止t_loginfo表单数据无限制的增长，保留的最大记录数

define("ZHB_HRB_FRAME","ZHB_HRB");  //中环保协议帧格式：心跳帧
define("ZHB_NOM_FRAME","ZHB_NOM");  //中环保协议帧格式：正常数据帧

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

//传感器ID定义
define ("ID_EQUIP_PM", 0x01);
define ("ID_EQUIP_WINDSPEED", 0x02);
define ("ID_EQUIP_WINDDIR", 0x03);
define ("ID_EQUIP_EMC", 0x05);
define ("ID_EQUIP_TEMPERATURE", 0x06);
define ("ID_EQUIP_HUMIDITY", 0x06);
define ("ID_EQUIP_NOISE", 0x0A);



?>