<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/7/7
 * Time: 10:02
 */
include_once "../l1comvm/sysconfig.php";

/**************************************************************************************
 * 通用配置参数: 所有项目相关缺省配置参数                                             *
 *************************************************************************************/
//通用项目标识
define("MFUN_L1VM_DBI_MAX_LOG_NUM", 5000);  //防止t_loginfo表单数据无限制的增长，保留的最大记录数
define("MFUN_L3APL_F1SYM_SESSION_ID_LEN", 10); //UI界面session id字符串长度
define("MFUN_L3APL_F1SYM_USER_ID_LEN", 6); //UI界面user id字符串长度=该值+3 （UID）
define("MFUN_L3APL_F1SYM_UID_PREFIX", "UID");  //定义用户ID的特征字，用户ID必须以UID开头

//项目类关键字
define("MFUN_L3APL_F2CM_PG_CODE_PREFIX", "PG");   //定义项目组code的特征字，项目组code必须以“PG”开头
define("MFUN_L3APL_F2CM_PROJ_CODE_PREFIX", "P_");  //定义项目code的特征字，项目code必须以“P_”开头
define("MFUN_L3APL_F2CM_CODE_FORMAT_LEN", 2); //定义项目code和项目组code的特征字长度
define("MFUN_L3APL_F3DM_FHYS_STYPE_PREFIX", "CL"); //FHYS传感器类型特征字
define("MFUN_L3APL_F3DM_AQYC_STYPE_PREFIX", "YC"); //AQYC传感器类型特征字
define("MFUN_L3APL_F3DM_SENSOR_TYPE_PREFIX_LEN", 2);
define("MFUN_L3APL_F1SYM_SESSIONID_VALID_TIME", 1800);  //Session ID有效时间为30分钟

define("MFUN_HCU_MSG_HEAD_FORMAT", "A2Key/A2Len/A2Cmd");// 1B 控制字ctrl_key, 1B 长度length（除控制字和长度本身外），1B 操作字opt_key
define("MFUN_HCU_MSG_HEAD_LENGTH", 6); //3 Byte

//定义HCU视频文件状态，N-正常状态，文件名上传但文件本身没有上传；D-文件下载中；R-文件上传完成，可以随时播放; F-视频下载失败
define ("MFUN_HCU_VIDEO_DATA_STATUS_NORMAL", "N");
define ("MFUN_HCU_VIDEO_DATA_STATUS_DOWNLOAD", "D");
define ("MFUN_HCU_VIDEO_DATA_STATUS_READY", "R");
define ("MFUN_HCU_VIDEO_DATA_STATUS_FAIL", "F");

//FHYS项目关键字
define("MFUN_L3APL_F2CM_KEY_PREFIX", "KEY");  //定义KEY ID的特征字，钥匙KEYID必须以KEY开头
define("MFUN_L3APL_F2CM_KEY_ID_LEN", 6);     //UI界面key id字符串长度=该值+3（KEY)
define("MFUN_L3APL_F2CM_KEY_TYPE_RFID", "R");
define("MFUN_L3APL_F2CM_KEY_TYPE_BLE", "B");
define("MFUN_L3APL_F2CM_KEY_TYPE_USER", "U");
define("MFUN_L3APL_F2CM_KEY_TYPE_WECHAT", "W");
define("MFUN_L3APL_F2CM_KEY_TYPE_IDCARD", "I");
define("MFUN_L3APL_F2CM_KEY_TYPE_PHONE", "P");
define("MFUN_L3APL_F2CM_KEY_TYPE_UNDEFINED", "N");

define("MFUN_L3APL_F2CM_AUTH_LEVEL_PROJ", "P"); //项目级授权
define("MFUN_L3APL_F2CM_AUTH_LEVEL_DEVICE", "D"); //单个站点(设备)级授权
define("MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER", "N");
define("MFUN_L3APL_F2CM_AUTH_TYPE_TIME", "T");
define("MFUN_L3APL_F2CM_AUTH_TYPE_FOREVER", "F");

define("MFUN_L3APL_F2CM_EVENT_TYPE_RFID", "R"); //RFID开锁事件
define("MFUN_L3APL_F2CM_EVENT_TYPE_BLE", "B");
define("MFUN_L3APL_F2CM_EVENT_TYPE_USER", "U");
define("MFUN_L3APL_F2CM_EVENT_TYPE_WECHAT", "W");
define("MFUN_L3APL_F2CM_EVENT_TYPE_IDCARD", "I");
define("MFUN_L3APL_F2CM_EVENT_TYPE_PHONE", "P");
define("MFUN_L3APL_F2CM_EVENT_TYPE_XJ", "X");  //巡检事件

define("MFUN_L3APL_F2CM_EVENT_DURATION_DAY", "1");
define("MFUN_L3APL_F2CM_EVENT_DURATION_WEEK", "7");
define("MFUN_L3APL_F2CM_EVENT_DURATION_MONTH", "30");

//ZHB关键字
define("MFUN_L2SNR_COMAPI_HOUR_VALIDE_NUM", 54); // HCU环保标准：1小时采集的有效分钟数据应不少于 54个
define("MFUN_L2SNR_COMAPI_DAY_VALIDE_NUM", 21);  // HCU环保标准：每日应有不少于21个有效小时均值的算术平均值为有效日均值
define("MFUN_L2SDK_IOTHCU_ZHB_HRB_FRAME","ZHB_HRB");  //中环保协议帧格式：心跳帧
define("MFUN_L2SDK_IOTHCU_ZHB_NOM_FRAME","ZHB_NOM");  //中环保协议帧格式：正常数据帧

//定义各测量值告警门限
define("MFUN_L3APL_F3DM_TH_ALARM_NOISE", 80);
define("MFUN_L3APL_F3DM_TH_ALARM_HUMID", 50);
define("MFUN_L3APL_F3DM_TH_ALARM_TEMP", 45);
define("MFUN_L3APL_F3DM_TH_ALARM_PM25", 100);
define("MFUN_L3APL_F3DM_TH_ALARM_WINDSPD", 20);
define("MFUN_L3APL_F3DM_TH_ALARM_EMC", 100);
define("MFUN_L3APL_F3DM_TH_ALARM_WINDDIR", 360);
define("MFUN_L3APL_F3DM_TH_ALARM_GPRS", 50);
define("MFUN_L3APL_F3DM_TH_ALARM_BATT", 30);

//传感器 EQUIPMENT ID定义
define ("MFUN_L3APL_F4ICM_ID_EQUIP_PM", 0x01);
define ("MFUN_L3APL_F4ICM_ID_EQUIP_WINDSPD", 0x02);
define ("MFUN_L3APL_F4ICM_ID_EQUIP_WINDDIR", 0x03);
define ("MFUN_L3APL_F4ICM_ID_EQUIP_EMC", 0x05);
define ("MFUN_L3APL_F4ICM_ID_EQUIP_TEMP", 0x06);
define ("MFUN_L3APL_F4ICM_ID_EQUIP_HUMID", 0x06);
define ("MFUN_L3APL_F4ICM_ID_EQUIP_NOISE", 0x0A);

if (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_TESTMODE){
    define ("MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS", 90);
    define ("MFUN_EMCWX_DATA_SAVE_DURATION_IN_DAYS", 90);
}

//定义用户权限级别
define ("MFUN_USER_GRADE_LEVEL_0", 0);
define ("MFUN_USER_GRADE_LEVEL_1", 1);
define ("MFUN_USER_GRADE_LEVEL_2", 2);
define ("MFUN_USER_GRADE_LEVEL_3", 3);
define ("MFUN_USER_GRADE_LEVEL_4", 4);

class classConstL1vmUserWebRight
{
    public static $mfunUserGradeArrayConst = array(
        MFUN_USER_GRADE_LEVEL_0 => array(
            'webauth'=>array(
                        'UserManage' => 'true',
                        'ParaManage' => 'true',
                        'InstControl' => 'true',
                        'PGManage' => 'true',
                        'ProjManage' => 'true',
                        'MPManage' => 'true',
                        'DevManage' => 'true',
                        'KeyManage' => 'true',
                        'KeyAuth' => 'true',
                        'KeyHistory' => 'true',
                        'MPMonitor' => 'true',
                        'MPStaticMonitorTable' => 'true',
                        'WarningCheck' => 'true',
                        'WarningHandle' => 'true',
                        'InstConf' => 'true',
                        'InstRead' => 'true'),
            'query' => 'true',
            'mod' => 'true'),
        MFUN_USER_GRADE_LEVEL_1 => array(
            'webauth'=>array(
                'UserManage' => 'true',
                'ParaManage' => 'true',
                'InstControl' => 'true',
                'PGManage' => 'true',
                'ProjManage' => 'true',
                'MPManage' => 'true',
                'DevManage' => 'true',
                'KeyManage' => 'true',
                'KeyAuth' => 'true',
                'KeyHistory' => 'true',
                'MPMonitor' => 'true',
                'MPStaticMonitorTable' => 'true',
                'WarningCheck' => 'true',
                'WarningHandle' => 'true',
                'InstConf' => 'true',
                'InstRead' => 'true'),
            'query' => 'true',
            'mod' => 'true'),
        MFUN_USER_GRADE_LEVEL_2 => array(
            'webauth'=>array(
                'UserManage' => 'true',
                'ParaManage' => 'true',
                'InstControl' => 'true',
                'PGManage' => 'true',
                'ProjManage' => 'true',
                'MPManage' => 'true',
                'DevManage' => 'true',
                'KeyManage' => 'true',
                'KeyAuth' => 'true',
                'KeyHistory' => 'true',
                'MPMonitor' => 'true',
                'MPStaticMonitorTable' => 'true',
                'WarningCheck' => 'true',
                'WarningHandle' => 'true',
                'InstConf' => 'true',
                'InstRead' => 'true'),
            'query' => 'true',
            'mod' => 'false'),
        MFUN_USER_GRADE_LEVEL_3 => array(
            'webauth'=>array(
                'UserManage' => 'false',
                'ParaManage' => 'false',
                'InstControl' => 'true',
                'PGManage' => 'true',
                'ProjManage' => 'true',
                'MPManage' => 'true',
                'DevManage' => 'true',
                'KeyManage' => 'true',
                'KeyAuth' => 'false',
                'KeyHistory' => 'true',
                'MPMonitor' => 'true',
                'MPStaticMonitorTable' => 'true',
                'WarningCheck' => 'true',
                'WarningHandle' => 'true',
                'InstConf' => 'true',
                'InstRead' => 'true'),
            'query' => 'true',
            'mod' => 'false'),
        MFUN_USER_GRADE_LEVEL_4 => array(
            'webauth'=>array(
                'UserManage' => 'true',
                'ParaManage' => 'true',
                'InstControl' => 'true',
                'PGManage' => 'true',
                'ProjManage' => 'true',
                'MPManage' => 'true',
                'DevManage' => 'true',
                'KeyManage' => 'true',
                'KeyAuth' => 'true',
                'KeyHistory' => 'true',
                'MPMonitor' => 'true',
                'MPStaticMonitorTable' => 'true',
                'WarningCheck' => 'true',
                'WarningHandle' => 'true',
                'InstConf' => 'true',
                'InstRead' => 'true'),
            'query' => 'false',
            'mod' => 'false'),
        );
    //通过TaskId读取TaskName
    public static function mfun_vm_getUserGrade($gradeIndex)
    {

        if ($gradeIndex >= 0 AND $gradeIndex <=4) {
            return self::$mfunUserGradeArrayConst[$gradeIndex];
        }else {
            return false;
        }
    }

}

?>