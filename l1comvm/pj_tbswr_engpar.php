<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 13:59
 */
include_once "../l1comvm/sysconfig.php";


//定义数据保存不删的时间长度
if (MFUN_CURRENT_WORKING_PROJECT_NAME_UNIQUE == MFUN_WORKING_PROJECT_NAME_UNIQUE_TBSWR){
    define ("MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS", 90);
}

?>