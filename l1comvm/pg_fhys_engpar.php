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
define ("MFUN_HCU_FHYS_STATUS_OK", "Y");
define ("MFUN_HCU_FHYS_STATUS_NOK", "N");
define ("MFUN_HCU_FHYS_DOOR_OPEN", "Y");
define ("MFUN_HCU_FHYS_DOOR_CLOSE", "N");
define ("MFUN_HCU_FHYS_DOOR_ALARM", "A");
define ("MFUN_HCU_FHYS_ALARM_YES", "Y");
define ("MFUN_HCU_FHYS_ALARM_NO", "N");

//定义智能云锁所带传感器类型
define("MFUN_L3APL_F3DM_CL_TYPE_DOOR", "CL_001");
define("MFUN_L3APL_F3DM_CL_TYPE_LOCK", "CL_002");
define("MFUN_L3APL_F3DM_CL_TYPE_RFID", "CL_003");
define("MFUN_L3APL_F3DM_CL_TYPE_BLE", "CL_004");
define("MFUN_L3APL_F3DM_CL_TYPE_BATT", "CL_005");
define("MFUN_L3APL_F3DM_CL_TYPE_GPRS", "CL_006");
define("MFUN_L3APL_F3DM_CL_TYPE_SOMK", "CL_007");
define("MFUN_L3APL_F3DM_CL_TYPE_VIBR", "CL_008");
define("MFUN_L3APL_F3DM_CL_TYPE_WATER", "CL_009");
define("MFUN_L3APL_F3DM_CL_TYPE_TEMP", "CL_00A");
define("MFUN_L3APL_F3DM_CL_TYPE_HUMI", "CL_00B");

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

//FHYS操作字
define("MFUN_HCU_OPT_FHYS_LOCK_OPEN", 0x02);    //云端开锁指令
define("MFUN_HCU_OPT_FHYS_GPRS_IND", 0x82);     //GPRS信号强度指示
define("MFUN_HCU_OPT_FHYS_BLE_IND", 0x82);      //BLE信号强度指示


/**************************************************************************************
 * FHYS: 智能云锁项目相关缺省配置参数                                                  *
 *************************************************************************************/
//定义数据保存不删的时间长度
if (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_FHYS){
    define ("MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS", 90);
}

?>