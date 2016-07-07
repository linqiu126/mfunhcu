<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 13:59
 */
include_once "../l1comvm/sysconfig.php";
include_once "../l1comvm/pg_general_engpar.php";

/**************************************************************************************
 * TBSWR: 水污染项目相关缺省配置参数                                                  *
 *************************************************************************************/
//定义数据保存不删的时间长度
if (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_TBSWR){
    define ("MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS", 90);
}

?>