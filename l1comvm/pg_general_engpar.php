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
//HCU_ID命名固定前缀
define ("MFUN_HCU_NAME_FIX_PREFIX", "HCU_");

//通用项目标识
define("MFUN_L1VM_DBI_MAX_LOG_NUM", 5000);  //防止t_loginfo表单数据无限制的增长，保留的最大记录数
define("MFUN_L3APL_F1SYM_SESSION_ID_LEN", 10); //UI界面session id字符串长度
define("MFUN_L3APL_F1SYM_USER_ID_LEN", 6); //UI界面user id字符串长度=该值+3 （UID）
define("MFUN_L3APL_F1SYM_UID_PREFIX", "UID");  //定义用户ID的特征字，用户ID必须以UID开头

//Socket通讯有关常量定义
define("MFUN_SWOOLE_SOCKET_STD_XML_HTTP", 9501); //原有XML协议swoole socket server HTTP端口
define("MFUN_SWOOLE_SOCKET_STD_XML_TCP", 9502);  //原有XML协议swoole socket server TCP端口
define("MFUN_SWOOLE_SOCKET_STD_XML_UDP", 9503); //原有XML协议swoole socket server UDP端口
define("MFUN_SWOOLE_SOCKET_STD_ZHB_HTTP", 9501); //原有ZHB协议swoole socket server HTTP端口
define("MFUN_SWOOLE_SOCKET_STD_ZHB_TCP", 9502);  //原有ZHB协议swoole socket server TCP端口
define("MFUN_SWOOLE_SOCKET_STD_ZHB_UDP", 9503); //原有ZHB协议swoole socket server UDP端口
define("MFUN_SWOOLE_SOCKET_HUITP_XML_HTTP", 9510); //新HUITP XML协议swoole socket server HTTP端口
define("MFUN_SWOOLE_SOCKET_HUITP_XML_TCP", 9511);  //新HUITP XML协议swoole socket server TCP端口
define("MFUN_SWOOLE_SOCKET_HUITP_XML_UDP", 9512); //新HUITP XML协议swoole socket server UDP端口
define("MFUN_SWOOLE_SOCKET_ZHB_HJT212_HTTP", 9513); //新ZHB HJT212协议swoole socket server HTTP端口
define("MFUN_SWOOLE_SOCKET_ZHB_HJT212_TCP", 9514);  //新ZHB HJT212协议swoole socket server TCP端口
define("MFUN_SWOOLE_SOCKET_ZHB_HJT212_UDP", 9515); //新ZHB HJT212协议swoole socket server UDP端口
define("MFUN_SWOOLE_SOCKET_HUITP_JSON_HTTP", 9516); //新HUITP JSON协议swoole socket server HTTP端口
define("MFUN_SWOOLE_SOCKET_HUITP_JSON_TCP", 9517);  //新HUITP JSON协议swoole socket server TCP端口
define("MFUN_SWOOLE_SOCKET_HUITP_JSON_UDP", 9518); //新HUITP JSON协议swoole socket server UDP端口
define("MFUN_SWOOLE_SOCKET_NBIOT_CJ188_HTTP", 9519); //NBIOT_CJ188协议swoole socket server HTTP端口
define("MFUN_SWOOLE_SOCKET_NBIOT_CJ188_TCP", 9520);  //NBIOT_CJ188协议swoole socket server TCP端口
define("MFUN_SWOOLE_SOCKET_NBIOT_CJ188_UDP", 9521); //NBIOT_CJ188协议swoole socket server UDP端口
define("MFUN_SWOOLE_SOCKET_NBIOT_QG376_HTTP", 9522); //NBIOT_QG376协议swoole socket server HTTP端口
define("MFUN_SWOOLE_SOCKET_NBIOT_QG376_TCP", 9523);  //NBIOT_QG376协议swoole socket server TCP端口
define("MFUN_SWOOLE_SOCKET_NBIOT_QG376_UDP", 9524); //NBIOT_QG376协议swoole socket server UDP端口

define("MFUN_SWOOLE_SOCKET_DATA_STREAM_FTP", 9550); //DATA_STREAM协议swoole socket server FTP端口


//项目类关键字
define("MFUN_L3APL_F2CM_PG_CODE_PREFIX", "PG");   //定义项目组code的特征字，项目组code必须以“PG”开头
define("MFUN_L3APL_F2CM_PROJ_CODE_PREFIX", "P_");  //定义项目code的特征字，项目code必须以“P_”开头
define("MFUN_L3APL_F2CM_CODE_FORMAT_LEN", 2); //定义项目code和项目组code的特征字长度
define("MFUN_L3APL_F3DM_FHYS_STYPE_PREFIX", "CL"); //FHYS传感器类型特征字
define("MFUN_L3APL_F3DM_AQYC_STYPE_PREFIX", "YC"); //AQYC传感器类型特征字
define("MFUN_L3APL_F3DM_SENSOR_TYPE_PREFIX_LEN", 2);
define("MFUN_L3APL_F1SYM_SESSIONID_VALID_TIME", 600);  //Session ID有效时间为10分钟
define("MFUN_L3APL_F2CM_FAVOURSITE_MAX_NUM", 5); //最大常用站点数量

define("MFUN_HCU_SITE_PIC_BASE_DIR", "../../avorion/");  //站点照片存放路径
define("MFUN_HCU_SITE_PIC_FOLDER_NAME", "avorion/");     //站点照片存放目录

define("MFUN_HCU_MSG_HEAD_FORMAT", "A2Key/A2Len/A2Cmd");// 1B 控制字ctrl_key, 1B 长度length（除控制字和长度本身外），1B 操作字opt_key
define("MFUN_HCU_MSG_HEAD_LENGTH", 6); //3 Byte

//定义HCU视频文件状态，N-正常状态，文件名上传但文件本身没有上传；D-文件下载中；R-文件上传完成，可以随时播放; F-视频下载失败
define ("MFUN_HCU_VIDEO_DATA_STATUS_NORMAL", "N");
define ("MFUN_HCU_VIDEO_DATA_STATUS_DOWNLOAD", "D");
define ("MFUN_HCU_VIDEO_DATA_STATUS_READY", "R");
define ("MFUN_HCU_VIDEO_DATA_STATUS_FAIL", "F");

//BFSC控制字
define("MFUN_HCU_CMDID_BFSC_WEIGHT", 0x3B);

//定义各测量值告警门限
define("MFUN_L3APL_F3DM_TH_ALARM_NOISE", 80);
define("MFUN_L3APL_F3DM_TH_ALARM_HUMID", 80);
define("MFUN_L3APL_F3DM_TH_ALARM_TEMP", 45);
define("MFUN_L3APL_F3DM_TH_ALARM_PM25", 100);
define("MFUN_L3APL_F3DM_TH_ALARM_WINDSPD", 20);
define("MFUN_L3APL_F3DM_TH_ALARM_EMC", 100);
define("MFUN_L3APL_F3DM_TH_ALARM_WINDDIR", 360);
define("MFUN_L3APL_F3DM_TH_ALARM_GPRS_LOW", 15); //GPRS信号弱门限
define("MFUN_L3APL_F3DM_TH_ALARM_GPRS_HIGH", 22); //GPRS信号强门限
define("MFUN_L3APL_F3DM_TH_ALARM_BATT", 5); //低电量告警门限

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
                'MPMonitorCard' => 'false', //menu not display
                'InstConf' => 'false',
                'InstRead' => 'false',
                'InstDesign' => 'false',
                'InstControl' => 'false',
                'InstSnapshot' => 'false',
                'InstVideo' => 'false',
                'AuditTarget' => 'false',
                'AuditAvailability' => 'false',
                'AuditError' => 'false',
                'AuditQuality' => 'false',
                'GeoInfoQuery' => 'false',
                'GeoTrendAnalysis' => 'false',
                'GeoDisaterForecast' => 'false',
                'GeoEmergencyDirect' => 'false',
                'GeoDiffusionAnalysis' => 'false',
                'ADConf' => 'false',
                'WEBConf' => 'false',
                'ParaManage' => 'false',
                'UserManage' => 'true',//menu to be display
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
                'WarningHandle' => 'true'),
            'actionauth'=>array(
                        'UserNew' => 'true',
                        'UserMod' => 'true',
                        'UserDel' => 'true',
                        'PGNew' => 'true',
                        'PGMod' => 'true',
                        'PGDel' => 'true',
                        'ProjNew' => 'true',
                        'ProjMod' => 'true',
                        'ProjDel' => 'true',
                        'PointNew' => 'true',
                        'PointMod' => 'true',
                        'PointDel' => 'true',
                        'DevNew' => 'true',
                        'DevMod' => 'true',
                        'DevDel' => 'true',
                        'KeyNew' => 'true',
                        'KeyMod' => 'true',
                        'KeyDel' => 'true',
                        'OpenLock' => 'true',
                        'KeyAuthNew' => 'true',
                        'KeyGrant' => 'true'
            ),
            'query' => 'true',
            'mod' => 'true'),
        MFUN_USER_GRADE_LEVEL_1 => array(
            'webauth'=>array(
                'MPMonitorCard' => 'false', //menu not display
                'InstConf' => 'false',
                'InstRead' => 'false',
                'InstDesign' => 'false',
                'InstControl' => 'false',
                'InstSnapshot' => 'false',
                'InstVideo' => 'false',
                'AuditTarget' => 'false',
                'AuditAvailability' => 'false',
                'AuditError' => 'false',
                'AuditQuality' => 'false',
                'GeoInfoQuery' => 'false',
                'GeoTrendAnalysis' => 'false',
                'GeoDisaterForecast' => 'false',
                'GeoEmergencyDirect' => 'false',
                'GeoDiffusionAnalysis' => 'false',
                'ADConf' => 'false',
                'WEBConf' => 'false',
                'ParaManage' => 'false',
                'UserManage' => 'true',
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
                'WarningHandle' => 'true'),
            'actionauth'=>array(
                'UserNew' => 'true',
                'UserMod' => 'true',
                'UserDel' => 'true',
                'PGNew' => 'true',
                'PGMod' => 'true',
                'PGDel' => 'true',
                'ProjNew' => 'true',
                'ProjMod' => 'true',
                'ProjDel' => 'true',
                'PointNew' => 'true',
                'PointMod' => 'true',
                'PointDel' => 'true',
                'DevNew' => 'true',
                'DevMod' => 'true',
                'DevDel' => 'true',
                'KeyNew' => 'true',
                'KeyMod' => 'true',
                'KeyDel' => 'true',
                'OpenLock' => 'true',
                'KeyAuthNew' => 'true',
                'KeyGrant' => 'true'
            ),
            'query' => 'true',
            'mod' => 'true'),
        MFUN_USER_GRADE_LEVEL_2 => array(
            'webauth'=>array(
                'MPMonitorCard' => 'false', //menu not display
                'InstConf' => 'false',
                'InstRead' => 'false',
                'InstDesign' => 'false',
                'InstControl' => 'false',
                'InstSnapshot' => 'false',
                'InstVideo' => 'false',
                'AuditTarget' => 'false',
                'AuditAvailability' => 'false',
                'AuditError' => 'false',
                'AuditQuality' => 'false',
                'GeoInfoQuery' => 'false',
                'GeoTrendAnalysis' => 'false',
                'GeoDisaterForecast' => 'false',
                'GeoEmergencyDirect' => 'false',
                'GeoDiffusionAnalysis' => 'false',
                'ADConf' => 'false',
                'WEBConf' => 'false',
                'ParaManage' => 'false',
                'UserManage' => 'true',
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
                'WarningHandle' => 'true'),
            'actionauth'=>array(
                'UserNew' => 'true',
                'UserMod' => 'false',
                'UserDel' => 'false',
                'PGNew' => 'true',
                'PGMod' => 'false',
                'PGDel' => 'false',
                'ProjNew' => 'true',
                'ProjMod' => 'false',
                'ProjDel' => 'false',
                'PointNew' => 'true',
                'PointMod' => 'false',
                'PointDel' => 'false',
                'DevNew' => 'true',
                'DevMod' => 'false',
                'DevDel' => 'false',
                'KeyNew' => 'true',
                'KeyMod' => 'false',
                'KeyDel' => 'false',
                'OpenLock' => 'true',
                'KeyAuthNew' => 'true',
                'KeyGrant' => 'true'
            ),
            'query' => 'true',
            'mod' => 'true'),
        MFUN_USER_GRADE_LEVEL_3 => array(
            'webauth'=>array(
                'MPMonitorCard' => 'false', //menu not display
                'InstConf' => 'false',
                'InstRead' => 'false',
                'InstDesign' => 'false',
                'InstControl' => 'false',
                'InstSnapshot' => 'false',
                'InstVideo' => 'false',
                'AuditTarget' => 'false',
                'AuditAvailability' => 'false',
                'AuditError' => 'false',
                'AuditQuality' => 'false',
                'GeoInfoQuery' => 'false',
                'GeoTrendAnalysis' => 'false',
                'GeoDisaterForecast' => 'false',
                'GeoEmergencyDirect' => 'false',
                'GeoDiffusionAnalysis' => 'false',
                'ADConf' => 'false',
                'WEBConf' => 'false',
                'ParaManage' => 'false',
                'UserManage' => 'true',
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
                'WarningHandle' => 'true'),
            'actionauth'=>array(
                'UserNew' => 'false',
                'UserMod' => 'false',
                'UserDel' => 'false',
                'PGNew' => 'false',
                'PGMod' => 'false',
                'PGDel' => 'false',
                'ProjNew' => 'false',
                'ProjMod' => 'false',
                'ProjDel' => 'false',
                'PointNew' => 'false',
                'PointMod' => 'false',
                'PointDel' => 'false',
                'DevNew' => 'false',
                'DevMod' => 'false',
                'DevDel' => 'false',
                'KeyNew' => 'true',
                'KeyMod' => 'false',
                'KeyDel' => 'false',
                'OpenLock' => 'true',
                'KeyAuthNew' => 'true',
                'KeyGrant' => 'true'
            ),
            'query' => 'true',
            'mod' => 'false'),
        MFUN_USER_GRADE_LEVEL_4 => array(
            'webauth'=>array(
                'MPMonitorCard' => 'false', //menu not display
                'InstConf' => 'false',
                'InstRead' => 'false',
                'InstDesign' => 'false',
                'InstControl' => 'false',
                'InstSnapshot' => 'false',
                'InstVideo' => 'false',
                'AuditTarget' => 'false',
                'AuditAvailability' => 'false',
                'AuditError' => 'false',
                'AuditQuality' => 'false',
                'GeoInfoQuery' => 'false',
                'GeoTrendAnalysis' => 'false',
                'GeoDisaterForecast' => 'false',
                'GeoEmergencyDirect' => 'false',
                'GeoDiffusionAnalysis' => 'false',
                'ADConf' => 'false',
                'WEBConf' => 'false',
                'ParaManage' => 'false',
                'UserManage' => 'false',
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
                'WarningHandle' => 'false'),
            'actionauth'=>array(
                'UserNew' => 'false',
                'UserMod' => 'false',
                'UserDel' => 'false',
                'PGNew' => 'false',
                'PGMod' => 'false',
                'PGDel' => 'false',
                'ProjNew' => 'false',
                'ProjMod' => 'false',
                'ProjDel' => 'false',
                'PointNew' => 'false',
                'PointMod' => 'false',
                'PointDel' => 'false',
                'DevNew' => 'false',
                'DevMod' => 'false',
                'DevDel' => 'false',
                'KeyNew' => 'true',
                'KeyMod' => 'false',
                'KeyDel' => 'false',
                'OpenLock' => 'false',
                'KeyAuthNew' => 'false',
                'KeyGrant' => 'false'
            ),
            'query' => 'true',
            'mod' => 'false'),
        );
    //通过授权级别获取详细授权菜单信息
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