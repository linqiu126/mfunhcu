<?php
/**
 * Created by PhpStorm.
 * User: Zehong
 * Date: 2016/10/28
 * Time: 22:18
 */
include_once "../l1comvm/sysconfig.php";
include_once "../l1comvm/pg_general_engpar.php";

//FHYS系统常量
define ("MFUN_HCU_FHYS_TIME_GRID_SIZE", 1); //每分钟一条记录

define ("MFUN_HCU_FHYS_STATUS_OK", "Y");  //设备正常，运行中
define ("MFUN_HCU_FHYS_STATUS_NOK", "N"); //设备异常，关闭中
define ("MFUN_HCU_FHYS_STATUS_SLEEP", "S"); //设备休眠中
define ("MFUN_HCU_FHYS_STATUS_UNKNOWN", "U"); //未知状态

define ("MFUN_HCU_FHYS_DOOR_OPEN", "Y");  //光交箱门打开
define ("MFUN_HCU_FHYS_DOOR_CLOSE", "N"); //光交箱门关闭
define ("MFUN_HCU_FHYS_DOOR_ALARM", "A"); //光交箱门暴力打开
define ("MFUN_HCU_FHYS_LOCK_OPEN", "Y");  //智能云锁打开
define ("MFUN_HCU_FHYS_LOCK_CLOSE", "N"); //智能云锁关闭
define ("MFUN_HCU_FHYS_LOCK_ALARM", "A"); //智能云锁暴力打开
define ("MFUN_HCU_FHYS_ALARM_YES", "Y");
define ("MFUN_HCU_FHYS_ALARM_NO", "N");
//下位机的数据常量
define ("MFUN_HCU_DATA_FHYS_STATUS_OK", 0x00); //设备状态正常或者门锁闭合
define ("MFUN_HCU_DATA_FHYS_STATUS_NOK", 0x01); //设备状态异常或者门锁打开
define ("MFUN_HCU_DATA_FHYS_STATUS_ALARM", 0x02); //设备告警或者门锁暴力打开
define ("MFUN_HCU_DATA_FHYS_LOCK_OPEN", 0x00);  //开锁命令
define ("MFUN_HCU_DATA_FHYS_LOCK_CLOSE", 0x01);  //闭锁命令

define ("MFUN_HCU_BFSC_STATUS_OK", "Y");  //设备正常，运行中
define ("MFUN_HCU_BFSC_STATUS_NOK", "N"); //设备异常，关闭中

//定义智能云锁所带传感器类型
define("MFUN_L3APL_F3DM_FHYS_STYPE_DOOR", "CL_001");
define("MFUN_L3APL_F3DM_FHYS_STYPE_LOCK", "CL_002");
define("MFUN_L3APL_F3DM_FHYS_STYPE_RFID", "CL_003");
define("MFUN_L3APL_F3DM_FHYS_STYPE_BLE", "CL_004");
define("MFUN_L3APL_F3DM_FHYS_STYPE_BATT", "CL_005");
define("MFUN_L3APL_F3DM_FHYS_STYPE_GPRS", "CL_006");
define("MFUN_L3APL_F3DM_FHYS_STYPE_SOMK", "CL_007");
define("MFUN_L3APL_F3DM_FHYS_STYPE_VIBR", "CL_008");
define("MFUN_L3APL_F3DM_FHYS_STYPE_WATER", "CL_009");
define("MFUN_L3APL_F3DM_FHYS_STYPE_TEMP", "CL_00A");
define("MFUN_L3APL_F3DM_FHYS_STYPE_HUMI", "CL_00B");

//FHYS控制字
define("MFUN_HCU_CMDID_FHYS_LOCK", 0x40);       //智能锁控制字
define("MFUN_HCU_CMDID_FHYS_DOOR", 0x41);       //光交箱门控制字
define("MFUN_HCU_CMDID_FHYS_RFID", 0x42);       //RFID控制字
define("MFUN_HCU_CMDID_FHYS_BLE", 0x43);        //BLE控制字
define("MFUN_HCU_CMDID_FHYS_GPRS", 0x44);       //GPRS控制字
define("MFUN_HCU_CMDID_FHYS_BATT", 0x45);       //电池控制字
define("MFUN_HCU_CMDID_FHYS_VIBR", 0x46);       //震动控制字
define("MFUN_HCU_CMDID_FHYS_SMOK", 0x47);       //烟雾控制字
define("MFUN_HCU_CMDID_FHYS_WATER", 0x48);       //水浸控制字
define("MFUN_HCU_CMDID_FHYS_TEMP", 0x49);       //温度控制字
define("MFUN_HCU_CMDID_FHYS_HUMI", 0x4A);       //湿度控制字

//BFSC控制字
define("MFUN_HCU_CMDID_BFSC_WEIGHT", 0x3B);

//锁操作字
define("MFUN_HCU_OPT_FHYS_LOCKSTAT_IND", 0x81);
define("MFUN_HCU_OPT_FHYS_LOCKSTAT_RESP", 0x01);
define("MFUN_HCU_OPT_FHYS_USERID_LOCKOPEN_REQ", 0x82);
define("MFUN_HCU_OPT_FHYS_USERID_LOCKOPEN_RESP", 0x02);
define("MFUN_HCU_OPT_FHYS_RFID_LOCKOPEN_REQ", 0x83);
define("MFUN_HCU_OPT_FHYS_RFID_LOCKOPEN_RESP", 0x03);
define("MFUN_HCU_OPT_FHYS_BLE_LOCKOPEN_REQ", 0x84);
define("MFUN_HCU_OPT_FHYS_BLE_LOCKOPEN_RESP", 0x04);
define("MFUN_HCU_OPT_FHYS_WECHAT_LOCKOPEN_REQ", 0x85);
define("MFUN_HCU_OPT_FHYS_WECHAT_LOCKOPEN_RESP", 0x05);
define("MFUN_HCU_OPT_FHYS_IDCARD_LOCKOPEN_REQ", 0x86);
define("MFUN_HCU_OPT_FHYS_IDCARD_LOCKOPEN_RESP", 0x06);
define("MFUN_HCU_OPT_FHYS_FORCE_LOCKOPEN_CMD", 0x07);  //强制开锁

//门操作字
define("MFUN_HCU_OPT_FHYS_DOORSTAT_IND", 0x8A);
define("MFUN_HCU_OPT_FHYS_DOORSTAT_RESP", 0x0A);
//RFID操作字
define("MFUN_HCU_OPT_FHYS_RFIDSTAT_IND", 0x81);
define("MFUN_HCU_OPT_FHYS_RFIDSTAT_RESP", 0x01);
//蓝牙操作字
define("MFUN_HCU_OPT_FHYS_BLESTAT_IND", 0x81);
define("MFUN_HCU_OPT_FHYS_BLESTAT_RESP", 0x01);
//GPRS操作字
define("MFUN_HCU_OPT_FHYS_GPRSSTAT_IND", 0x81);
define("MFUN_HCU_OPT_FHYS_GPRSSTAT_RESP", 0x01);
define("MFUN_HCU_OPT_FHYS_SIGLEVEL_IND", 0x82);
define("MFUN_HCU_OPT_FHYS_SIGLEVEL_RESP", 0x02);
//电池操作字
define("MFUN_HCU_OPT_FHYS_BATTSTAT_IND", 0x81);
define("MFUN_HCU_OPT_FHYS_BATTSTAT_RESP", 0x01);
define("MFUN_HCU_OPT_FHYS_BATTLEVEL_IND", 0x82);
define("MFUN_HCU_OPT_FHYS_BATTLEVEL_RESP", 0x02);
//震动传感器操作字
define("MFUN_HCU_OPT_FHYS_VIBRSTAT_IND", 0x81);
define("MFUN_HCU_OPT_FHYS_VIBRSTAT_RESP", 0x01);
define("MFUN_HCU_OPT_FHYS_VIBRALARM_IND", 0x82);
define("MFUN_HCU_OPT_FHYS_VIBRALARM_RESP", 0x02);
//烟雾传感器操作字
define("MFUN_HCU_OPT_FHYS_SMOKSTAT_IND", 0x81);
define("MFUN_HCU_OPT_FHYS_SMOKSTAT_RESP", 0x01);
define("MFUN_HCU_OPT_FHYS_SMOKALARM_IND", 0x82);
define("MFUN_HCU_OPT_FHYS_SMOKALARM_RESP", 0x02);
//水浸传感器操作字
define("MFUN_HCU_OPT_FHYS_WATERSTAT_IND", 0x81);
define("MFUN_HCU_OPT_FHYS_WATERSTAT_RESP", 0x01);
define("MFUN_HCU_OPT_FHYS_WATERALARM_IND", 0x82);
define("MFUN_HCU_OPT_FHYS_WATERALARM_RESP", 0x02);
//温度传感器操作字
define("MFUN_HCU_OPT_FHYS_TEMPSTAT_IND", 0x81);
define("MFUN_HCU_OPT_FHYS_TEMPSTAT_RESP", 0x01);
define("MFUN_HCU_OPT_FHYS_TEMPDATA_IND", 0x82);
define("MFUN_HCU_OPT_FHYS_TEMPDATA_RESP", 0x02);
//湿度传感器操作字
define("MFUN_HCU_OPT_FHYS_HUMISTAT_IND", 0x81);
define("MFUN_HCU_OPT_FHYS_HUMISTAT_RESP", 0x01);
define("MFUN_HCU_OPT_FHYS_HUMIDATA_IND", 0x82);
define("MFUN_HCU_OPT_FHYS_HUMIDATA_RESP", 0x02);

//组合秤操作字
define("MFUN_HCU_OPT_BFSC_WEIGHTDATA_IND", 0x81);
define("MFUN_HCU_OPT_BFSC_WEIGHTSTART_RESP", 0x82);
define("MFUN_HCU_OPT_BFSC_WEIGHTSTOP_RESP", 0x83);




/**************************************************************************************
 * FHYS: 智能云锁项目相关缺省配置参数                                                  *
 *************************************************************************************/
//定义数据保存不删的时间长度
if (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_FHYS){
    define ("MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS", 90);
}

?>