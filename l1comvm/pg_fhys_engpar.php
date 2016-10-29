<?php
/**
 * Created by PhpStorm.
 * User: Zehong
 * Date: 2016/10/28
 * Time: 22:18
 */
include_once "../l1comvm/sysconfig.php";
include_once "../l1comvm/pg_general_engpar.php";


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


/**************************************************************************************
 * FHYS: 智能云锁项目相关缺省配置参数                                                  *
 *************************************************************************************/
//定义数据保存不删的时间长度
if (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_FHYS){
    define ("MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS", 90);
}

?>