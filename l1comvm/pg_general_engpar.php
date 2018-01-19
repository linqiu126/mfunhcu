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
define("MFUN_HCU_NAME_FIX_PREFIX", "HCU_");

//软件有效性标识
define("MFUN_HCU_SW_LOAD_FLAG_INVALID", 0);
define("MFUN_HCU_SW_LOAD_FLAG_VALID", 1);

//站点状态标识，站点分配了设备HCU即视为激活
define("MFUN_HCU_SITE_STATUS_INITIAL", "I"); //站点新创建，没有添加设备
define("MFUN_HCU_SITE_STATUS_ATTACH", "A");  //站点添加了设备
define("MFUN_HCU_SITE_STATUS_CONFIRM", "C"); //用户人工确认了站点开通

//传感器数据标识
define("MFUN_HCU_DATA_FLAG_INVALID", "N"); //无效数据
define("MFUN_HCU_DATA_FLAG_VALID", "Y");   //有效数据
define("MFUN_HCU_DATA_FLAG_FAKE", "F");    //人工插入数据

//告警处理状态标识
define ("MFUN_HCU_ALARM_PROC_FLAG_Y", "Y"); //告警已经处理，等待关闭
define ("MFUN_HCU_ALARM_PROC_FLAG_N", "N"); //告警未处理
define ("MFUN_HCU_ALARM_PROC_FLAG_C", "C"); //告警已经处理关闭

//通用项目标识
define("MFUN_L1VM_DBI_MAX_LOG_NUM", 50000);  //防止t_loginfo表单数据无限制的增长，保留的最大记录数
define("MFUN_L3APL_F1SYM_SESSION_ID_LEN", 10); //UI界面session id字符串长度
define("MFUN_L3APL_F1SYM_USER_ID_LEN", 6); //UI界面user id字符串长度=该值+3 （UID）
define("MFUN_L3APL_F1SYM_UID_PREFIX", "UID");  //定义用户ID的特征字，用户ID必须以UID开头
define("MFUN_L3APL_F1SYM_MID_PREFIX", "MID");  //员工ID
define("MFUN_L3APL_F1SYM_ONLINE_MAP_FLAG", "Y");  //用户使用在线地图
define("MFUN_L3APL_F1SYM_OFFLINE_MAP_FLAG", "N"); //用户使用离线地图

//Socket通讯有关常量定义
define("MFUN_SWOOLE_SOCKET_STDXML_TCP_HCUPORT", 9501); //原有XML协议swoole socket server TCP端口,处理与下位机的连接
define("MFUN_SWOOLE_SOCKET_STDXML_TCP_UIPORT", 9502);  //原有XML协议swoole socket server TCP端口，处理与UI的连接
define("MFUN_SWOOLE_SOCKET_STDXML_UDP", 9503); //原有XML协议swoole socket server UDP端口，暂时没用
define("MFUN_SWOOLE_SOCKET_STDZHB_HTTP", 9501); //原有ZHB协议swoole socket server HTTP端口
define("MFUN_SWOOLE_SOCKET_STDZHB_TCP", 9502);  //原有ZHB协议swoole socket server TCP端口
define("MFUN_SWOOLE_SOCKET_STDZHB_UDP", 9503); //原有ZHB协议swoole socket server UDP端口
define("MFUN_SWOOLE_SOCKET_HUITPXML_HTTP", 9510); //新HUITP XML协议swoole socket server HTTP端口,传送内容为ASCII
define("MFUN_SWOOLE_SOCKET_HUITPXML_TCP", 9511);  //新HUITP XML协议swoole socket server TCP端口,传送内容为HEX
define("MFUN_SWOOLE_SOCKET_HUITPXML_UDP", 9512); //新HUITP XML协议swoole socket server UDP端口
define("MFUN_SWOOLE_SOCKET_ZHBHJT212_HTTP", 9513); //新ZHB HJT212协议swoole socket server HTTP端口
define("MFUN_SWOOLE_SOCKET_ZHBHJT212_TCP", 9514);  //新ZHB HJT212协议swoole socket server TCP端口
define("MFUN_SWOOLE_SOCKET_ZHBHJT212_UDP", 9515); //新ZHB HJT212协议swoole socket server UDP端口
define("MFUN_SWOOLE_SOCKET_HUITPJSON_HTTP", 9516); //新HUITP JSON协议swoole socket server HTTP端口
define("MFUN_SWOOLE_SOCKET_HUITPJSON_TCP", 9517);  //新HUITP JSON协议swoole socket server TCP端口
define("MFUN_SWOOLE_SOCKET_HUITPJSON_UDP", 9518); //新HUITP JSON协议swoole socket server UDP端口
define("MFUN_SWOOLE_SOCKET_NBIOTCJ188_HTTP", 9519); //NBIOT_CJ188协议swoole socket server HTTP端口
define("MFUN_SWOOLE_SOCKET_NBIOTCJ188_TCP", 9520);  //NBIOT_CJ188协议swoole socket server TCP端口
define("MFUN_SWOOLE_SOCKET_NBIOTCJ188_UDP", 9521); //NBIOT_CJ188协议swoole socket server UDP端口
define("MFUN_SWOOLE_SOCKET_NBIOTQG376_HTTP", 9522); //NBIOT_QG376协议swoole socket server HTTP端口
define("MFUN_SWOOLE_SOCKET_NBIOTQG376_TCP", 9523);  //NBIOT_QG376协议swoole socket server TCP端口
define("MFUN_SWOOLE_SOCKET_NBIOTQG376_UDP", 9524); //NBIOT_QG376协议swoole socket server UDP端口

define("MFUN_SWOOLE_SOCKET_DATA_STREAM_TCP", 9550); //DATA_STREAM协议swoole socket server FTP端口


//项目类关键字
define("MFUN_L3APL_F2CM_PG_CODE_PREFIX", "PG");   //定义项目组code的特征字，项目组code必须以“PG”开头
define("MFUN_L3APL_F2CM_PG_CODE_DIGLEN", 7);      //项目组code数字字符长度，PG_1234567
define("MFUN_L3APL_F2CM_PROJ_CODE_PREFIX", "P_");  //定义项目code的特征字，项目code必须以“P_”开头
define("MFUN_L3APL_F2CM_PROJ_CODE_DIGLEN", 8);     //项目code数字字符长度，P_12345678
define("MFUN_L3APL_F2CM_SITE_CODE_PREFIX", "S_");  //定义站点code的特征字，站点code必须以“S_”开头
define("MFUN_L3APL_F2CM_SITE_CODE_DIGLEN", 8);     //站点code数字字符长度，S_12345678
define("MFUN_L3APL_F2CM_CODE_FORMAT_LEN", 2); //定义项目code和项目组code的特征字长度
define("MFUN_L3APL_F3DM_SENSOR_TYPE_PREFIX_LEN", 2);
define("MFUN_L3APL_F1SYM_SESSIONID_VALID_TIME", 900);  //Session ID有效时间为15分钟
define("MFUN_L3APL_F2CM_FAVOURSITE_MAX_NUM", 5); //最大常用站点数量

define("MFUN_HCU_SITE_PIC_BASE_DIR", "../../avorion/picture/");  //设备拍照上传的照片目录
define("MFUN_HCU_SITE_VIDEO_BASE_DIR", "../../avorion/video/");  //设备拍照上传的视频目录
define("MFUN_HCU_SITE_PIC_WWW_PATH", "/avorion/picture/");     //站点照片存放www路径
define("MFUN_HCU_SITE_VIDEO_WWW_PATH", "/avorion/video/");     //站点视频存放www路径
define("MFUN_HCU_SITE_PIC_FILE_TYPE", ".jpg");
define("MFUN_HCU_SITE_VIDEO_FILE_TYPE", ".mp4");

define("MFUN_HCU_MSG_HEAD_FORMAT", "A2Key/A2Len/A2Cmd");// 1B 控制字ctrl_key, 1B 长度length（除控制字和长度本身外），1B 操作字opt_key
define("MFUN_HCU_MSG_HEAD_LENGTH", 6); //3 Byte

//定义各测量值告警门限
define("MFUN_L3APL_F3DM_TH_ALARM_NOISE", 80);
define("MFUN_L3APL_F3DM_TH_ALARM_HUMID", 80);
define("MFUN_L3APL_F3DM_TH_ALARM_TEMP", 45);
define("MFUN_L3APL_F3DM_TH_ALARM_PM25", 10);
define("MFUN_L3APL_F3DM_TH_ALARM_WINDSPD", 20);
define("MFUN_L3APL_F3DM_TH_ALARM_EMC", 100);
define("MFUN_L3APL_F3DM_TH_ALARM_WINDDIR", 360);
define("MFUN_L3APL_F3DM_TH_ALARM_GPRS_LOW", 15); //GPRS信号弱门限
define("MFUN_L3APL_F3DM_TH_ALARM_GPRS_HIGH", 22); //GPRS信号强门限
define("MFUN_L3APL_F3DM_TH_ALARM_BATT", 20); //低电量告警门限

//传感器 EQUIPMENT ID定义
define ("MFUN_L3APL_F4ICM_ID_EQUIP_PM", 0x01);
define ("MFUN_L3APL_F4ICM_ID_EQUIP_WINDSPD", 0x02);
define ("MFUN_L3APL_F4ICM_ID_EQUIP_WINDDIR", 0x03);
define ("MFUN_L3APL_F4ICM_ID_EQUIP_EMC", 0x05);
define ("MFUN_L3APL_F4ICM_ID_EQUIP_TEMP", 0x06);
define ("MFUN_L3APL_F4ICM_ID_EQUIP_HUMID", 0x06);
define ("MFUN_L3APL_F4ICM_ID_EQUIP_NOISE", 0x0A);

define ("MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS", 90); //限定最低保存时间，项目定义的时间如果小于这个时间则不被接受
if (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_TESTMODE){
    define("MFUN_CLOUD_WWW", "www.hkrob.com");  //默认小慧智能主页
    define ("MFUN_HCU_DATA_SAVE_DURATION_BY_PROJ", 180);
    define ("MFUN_HCU_USER_NAME_GRADE_0", "管理员");
    define ("MFUN_HCU_USER_NAME_GRADE_1", "高级用户");
    define ("MFUN_HCU_USER_NAME_GRADE_2", "一级用户");
    define ("MFUN_HCU_USER_NAME_GRADE_3", "二级用户");
    define ("MFUN_HCU_USER_NAME_GRADE_4", "三级用户");
    define ("MFUN_HCU_USER_NAME_GRADE_N", "用户等级未知");
}

//定义用户权限级别
define ("MFUN_USER_GRADE_LEVEL_0", 0);
define ("MFUN_USER_GRADE_LEVEL_1", 1);
define ("MFUN_USER_GRADE_LEVEL_2", 2);
define ("MFUN_USER_GRADE_LEVEL_3", 3);
define ("MFUN_USER_GRADE_LEVEL_4", 4);

//BFSC常量，临时定义在这里，后面根据需要移除
define ("MFUN_HCU_BFSC_STATUS_OK", "Y");  //设备正常，运行中
define ("MFUN_HCU_BFSC_STATUS_NOK", "N"); //设备异常，关闭中
//BFSC控制字
define("MFUN_HCU_CMDID_BFSC_WEIGHT", 0x3B);
//组合秤操作字
define("MFUN_HCU_OPT_BFSC_WEIGHTDATA_IND", 0x81);
define("MFUN_HCU_OPT_BFSC_WEIGHTSTART_RESP", 0x82);
define("MFUN_HCU_OPT_BFSC_WEIGHTSTOP_RESP", 0x83);

//FAAM常量，将来视情况可以创立单独的工厂管理项目工参表pg_faam_engpar
define("MFUN_HCU_FAAM_PJCODE", "XHZN");
define("MFUN_HCU_FAAM_EMPLOYEE_ONJOB_NO", 0);  //离职
define("MFUN_HCU_FAAM_EMPLOYEE_ONJOB_YES", 1); //在职

class classConstL1vmUserWebRight
{
//定义界面菜单显示权限，如果为false则该菜单在用户登录时隐藏
    static $mfunUserGradeArrayConst = array(
        MFUN_USER_GRADE_LEVEL_0 => array(
            'webauth'=>array(
                //登录屏保
                'menu_user_profile' => 'true',
                //系统管理
                'UserManage' => 'true',
                'ParaManage' => 'false',
                'ExportTableManage' => 'true',
                'SoftwareLoadManage' =>'false',
                //项目管理
                'PGManage' => 'true',
                'ProjManage' => 'true',
                'MPManage' => 'true',
                'DevManage' => 'true',
                //测量管理
                'MPMonitor' => 'true',
                'MPStaticMonitorTable' => 'true',
                'MPMonitorCard' => 'true',
                //告警管理
                'WarningCheck' => 'true',
                'WarningHandle' => 'true',
                //性能管理
                'AuditTarget' => 'true',
                'AuditStability' => 'true',
                'AuditAvailability' => 'true',
                'AuditError' => 'true',
                'AuditQuality' => 'true',
                //工厂管理
                'StaffManage' => 'true',
                'AttendanceManage' => 'true',
                'FactoryManage' => 'true',
                'SpecificationManage' => 'true',
                'AssembleManage' => 'true',
                'AssembleAudit' => 'true',
                'AttendanceAudit' => 'true',
                'KPIAudit' => 'true',
                //仪器操作
                'InstConf' => 'true',
                'InstRead' => 'true',
                'InstDesign' => 'true',
                'InstControl' => 'true',
                'InstSnapshot' => 'true',
                'InstVideo' => 'true',
                //地理环境管理
                'GeoInfoQuery' => 'true',
                'GeoTrendAnalysis' => 'true',
                'GeoDisaterForecast' => 'true',
                'GeoEmergencyDirect' => 'true',
                'GeoDiffusionAnalysis' => 'true',
                //广告和门户
                'ADConf' => 'true',
                'WEBConf' => 'true',
                //钥匙管理  ->只适用于FHYS
                'KeyManage' => 'true',
                'KeyAuth' => 'true',
                'KeyHistory' => 'true',
                //纤芯管理
                'RTUManage' => 'true',
                'OTDRManage' => 'true'),
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
                'KeyGrant' => 'true',
                'AttendanceAudit' => 'true',
                'KPIAudit' => 'true'
            ),
            'query' => 'true',
            'mod' => 'true'),
        MFUN_USER_GRADE_LEVEL_1 => array(
            'webauth'=>array(
                //登录屏保
                'menu_user_profile' => 'false',
                //系统管理
                'UserManage' => 'false',
                'ParaManage' => 'false',
                'ExportTableManage' => 'false',
                'SoftwareLoadManage' =>'false',
                //项目管理
                'PGManage' => 'false',
                'ProjManage' => 'false',
                'MPManage' => 'false',
                'DevManage' => 'false',
                //测量管理
                'MPMonitor' => 'false',
                'MPStaticMonitorTable' => 'false',
                'MPMonitorCard' => 'false',
                //告警管理
                'WarningCheck' => 'false',
                'WarningHandle' => 'false',
                //性能管理
                'AuditTarget' => 'false',
                'AuditStability' => 'false',
                'AuditAvailability' => 'false',
                'AuditError' => 'false',
                'AuditQuality' => 'false',
                //工厂管理
                'StaffManage' => 'false',
                'AttendanceManage' => 'false',
                'FactoryManage' => 'false',
                'SpecificationManage' => 'false',
                'AssembleManage' => 'false',
                'AssembleAudit' => 'false',
                'AttendanceAudit' => 'false',
                'KPIAudit' => 'false',
                //仪器操作
                'InstConf' => 'false',
                'InstRead' => 'false',
                'InstDesign' => 'false',
                'InstControl' => 'false',
                'InstSnapshot' => 'false',
                'InstVideo' => 'false',
                //地理环境管理
                'GeoInfoQuery' => 'false',
                'GeoTrendAnalysis' => 'false',
                'GeoDisaterForecast' => 'false',
                'GeoEmergencyDirect' => 'false',
                'GeoDiffusionAnalysis' => 'false',
                //广告和门户
                'ADConf' => 'false',
                'WEBConf' => 'false',
                //钥匙管理  ->只适用于FHYS
                'KeyManage' => 'false',
                'KeyAuth' => 'false',
                'KeyHistory' => 'false',
                //纤芯管理
                'RTUManage' => 'false',
                'OTDRManage' => 'false'),
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
                'KeyNew' => 'false',
                'KeyMod' => 'false',
                'KeyDel' => 'false',
                'OpenLock' => 'false',
                'KeyAuthNew' => 'false',
                'KeyGrant' => 'false',
                'FactoryDel' => 'false',
                'FactoryNew' => 'false',
                'AttendanceAudit' => 'false',
                'KPIAudit' => 'false'
            ),
            'query' => 'false',
            'mod' => 'false'),
        MFUN_USER_GRADE_LEVEL_2 => array(
            'webauth'=>array(
                //登录屏保
                'menu_user_profile' => 'false',
                //系统管理
                'UserManage' => 'false',
                'ParaManage' => 'false',
                'ExportTableManage' => 'false',
                'SoftwareLoadManage' =>'false',
                //项目管理
                'PGManage' => 'false',
                'ProjManage' => 'false',
                'MPManage' => 'false',
                'DevManage' => 'false',
                //测量管理
                'MPMonitor' => 'false',
                'MPStaticMonitorTable' => 'false',
                'MPMonitorCard' => 'false',
                //告警管理
                'WarningCheck' => 'false',
                'WarningHandle' => 'false',
                //性能管理
                'AuditTarget' => 'false',
                'AuditStability' => 'false',
                'AuditAvailability' => 'false',
                'AuditError' => 'false',
                'AuditQuality' => 'false',
                //工厂管理
                'StaffManage' => 'false',
                'AttendanceManage' => 'false',
                'FactoryManage' => 'false',
                'SpecificationManage' => 'false',
                'AssembleManage' => 'false',
                'AssembleAudit' => 'false',
                'AttendanceAudit' => 'false',
                'KPIAudit' => 'false',
                //仪器操作
                'InstConf' => 'false',
                'InstRead' => 'false',
                'InstDesign' => 'false',
                'InstControl' => 'false',
                'InstSnapshot' => 'false',
                'InstVideo' => 'false',
                //地理环境管理
                'GeoInfoQuery' => 'false',
                'GeoTrendAnalysis' => 'false',
                'GeoDisaterForecast' => 'false',
                'GeoEmergencyDirect' => 'false',
                'GeoDiffusionAnalysis' => 'false',
                //广告和门户
                'ADConf' => 'false',
                'WEBConf' => 'false',
                //钥匙管理  ->只适用于FHYS
                'KeyManage' => 'false',
                'KeyAuth' => 'false',
                'KeyHistory' => 'false',
                //纤芯管理
                'RTUManage' => 'false',
                'OTDRManage' => 'false'),
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
                'KeyNew' => 'false',
                'KeyMod' => 'false',
                'KeyDel' => 'false',
                'OpenLock' => 'false',
                'KeyAuthNew' => 'false',
                'KeyGrant' => 'false',
                'FactoryDel' => 'false',
                'FactoryNew' => 'false',
                'AttendanceAudit' => 'false',
                'KPIAudit' => 'false'
            ),
            'query' => 'false',
            'mod' => 'false'),
        MFUN_USER_GRADE_LEVEL_3 => array(
            'webauth'=>array(
                //登录屏保
                'menu_user_profile' => 'false',
                //系统管理
                'UserManage' => 'false',
                'ParaManage' => 'false',
                'ExportTableManage' => 'false',
                'SoftwareLoadManage' =>'false',
                //项目管理
                'PGManage' => 'false',
                'ProjManage' => 'false',
                'MPManage' => 'false',
                'DevManage' => 'false',
                //测量管理
                'MPMonitor' => 'false',
                'MPStaticMonitorTable' => 'false',
                'MPMonitorCard' => 'false',
                //告警管理
                'WarningCheck' => 'false',
                'WarningHandle' => 'false',
                //性能管理
                'AuditTarget' => 'false',
                'AuditStability' => 'false',
                'AuditAvailability' => 'false',
                'AuditError' => 'false',
                'AuditQuality' => 'false',
                //工厂管理
                'StaffManage' => 'false',
                'AttendanceManage' => 'false',
                'FactoryManage' => 'false',
                'SpecificationManage' => 'false',
                'AssembleManage' => 'false',
                'AssembleAudit' => 'false',
                'AttendanceAudit' => 'false',
                'KPIAudit' => 'false',
                //仪器操作
                'InstConf' => 'false',
                'InstRead' => 'false',
                'InstDesign' => 'false',
                'InstControl' => 'false',
                'InstSnapshot' => 'false',
                'InstVideo' => 'false',
                //地理环境管理
                'GeoInfoQuery' => 'false',
                'GeoTrendAnalysis' => 'false',
                'GeoDisaterForecast' => 'false',
                'GeoEmergencyDirect' => 'false',
                'GeoDiffusionAnalysis' => 'false',
                //广告和门户
                'ADConf' => 'false',
                'WEBConf' => 'false',
                //钥匙管理  ->只适用于FHYS
                'KeyManage' => 'false',
                'KeyAuth' => 'false',
                'KeyHistory' => 'false',
                //纤芯管理
                'RTUManage' => 'false',
                'OTDRManage' => 'false'),
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
                'KeyNew' => 'false',
                'KeyMod' => 'false',
                'KeyDel' => 'false',
                'OpenLock' => 'false',
                'KeyAuthNew' => 'false',
                'KeyGrant' => 'false',
                'FactoryDel' => 'false',
                'FactoryNew' => 'false',
                'AttendanceAudit' => 'false',
                'KPIAudit' => 'false'
            ),
            'query' => 'false',
            'mod' => 'false'),
        MFUN_USER_GRADE_LEVEL_4 => array(
            'webauth'=>array(
                //登录屏保
                'menu_user_profile' => 'false',
                //系统管理
                'UserManage' => 'false',
                'ParaManage' => 'false',
                'ExportTableManage' => 'false',
                'SoftwareLoadManage' =>'false',
                //项目管理
                'PGManage' => 'false',
                'ProjManage' => 'false',
                'MPManage' => 'false',
                'DevManage' => 'false',
                //测量管理
                'MPMonitor' => 'false',
                'MPStaticMonitorTable' => 'false',
                'MPMonitorCard' => 'false',
                //告警管理
                'WarningCheck' => 'false',
                'WarningHandle' => 'false',
                //性能管理
                'AuditTarget' => 'false',
                'AuditStability' => 'false',
                'AuditAvailability' => 'false',
                'AuditError' => 'false',
                'AuditQuality' => 'false',
                //工厂管理
                'StaffManage' => 'false',
                'AttendanceManage' => 'false',
                'FactoryManage' => 'false',
                'SpecificationManage' => 'false',
                'AssembleManage' => 'false',
                'AssembleAudit' => 'false',
                'AttendanceAudit' => 'false',
                'KPIAudit' => 'false',
                //仪器操作
                'InstConf' => 'false',
                'InstRead' => 'false',
                'InstDesign' => 'false',
                'InstControl' => 'false',
                'InstSnapshot' => 'false',
                'InstVideo' => 'false',
                //地理环境管理
                'GeoInfoQuery' => 'false',
                'GeoTrendAnalysis' => 'false',
                'GeoDisaterForecast' => 'false',
                'GeoEmergencyDirect' => 'false',
                'GeoDiffusionAnalysis' => 'false',
                //广告和门户
                'ADConf' => 'false',
                'WEBConf' => 'false',
                //钥匙管理  ->只适用于FHYS
                'KeyManage' => 'false',
                'KeyAuth' => 'false',
                'KeyHistory' => 'false',
                //纤芯管理
                'RTUManage' => 'false',
                'OTDRManage' => 'false'),
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
                'KeyNew' => 'false',
                'KeyMod' => 'false',
                'KeyDel' => 'false',
                'OpenLock' => 'false',
                'KeyAuthNew' => 'false',
                'KeyGrant' => 'false',
                'FactoryDel' => 'false',
                'FactoryNew' => 'false',
                'AttendanceAudit' => 'false',
                'KPIAudit' => 'false'
            ),
            'query' => 'false',
            'mod' => 'false'),
    );
    //构造函数，根据不同项目初始化权限配置.默认都为false，不同项目根据需要修改为true
    public function __construct()
    {
        if (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_TESTMODE)
        {
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['PGManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['MPStaticMonitorTable'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['AuditStability'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['KeyManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['KeyAuth'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['KeyHistory'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['RTUManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['OTDRManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['StaffManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['AttendanceManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['FactoryManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['SpecificationManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['AssembleManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['AssembleAudit'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['AttendanceAudit'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['KPIAudit'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['UserNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['UserMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['UserDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PGNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PGMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PGDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['ProjNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['ProjMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['ProjDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PointNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PointMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PointDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['DevNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['DevMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['DevDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['OpenLock'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyAuthNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyGrant'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['AttendanceAudit'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KPIAudit'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['mod'] = 'true';

            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['MPStaticMonitorTable'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['AuditStability'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['KeyManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['KeyAuth'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['KeyHistory'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['RTUManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['OTDRManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['StaffManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['AttendanceManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['FactoryManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['SpecificationManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['AssembleManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['AssembleAudit'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['UserNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['UserMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['PGNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['PGMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['ProjNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['ProjMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['PointNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['PointMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['DevNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['DevMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['KeyNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['KeyMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['OpenLock'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['KeyAuthNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['KeyGrant'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['mod'] = 'true';

            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['PGManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['MPStaticMonitorTable'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['AuditStability'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['KeyManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['KeyAuth'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['KeyHistory'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['RTUManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['OTDRManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['StaffManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['AttendanceManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['FactoryManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['AssembleManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['AssembleAudit'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['UserNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['PGNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['ProjNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['PointNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['DevNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['KeyNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['OpenLock'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['KeyAuthNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['KeyGrant'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['mod'] = 'true';

            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['PGManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['MPStaticMonitorTable'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['AuditStability'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['KeyManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['KeyAuth'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['KeyHistory'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['RTUManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['OTDRManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['StaffManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['AttendanceManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['FactoryManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['AssembleManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['mod'] = 'false';
        }
        elseif (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_AQYC)
        {
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['PGManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['MPStaticMonitorTable'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['AuditStability'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['StaffManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['AttendanceManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['FactoryManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['SpecificationManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['AssembleManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['AssembleAudit'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['AttendanceAudit'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['KPIAudit'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['UserNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['UserMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['UserDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PGNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PGMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PGDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['ProjNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['ProjMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['ProjDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PointNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PointMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PointDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['DevNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['DevMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['DevDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['AttendanceAudit'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KPIAudit'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['mod'] = 'true';

            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['MPStaticMonitorTable'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['AuditStability'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['StaffManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['AttendanceManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['FactoryManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['SpecificationManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['AssembleManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['AssembleAudit'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['UserNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['UserMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['PGNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['PGMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['ProjNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['ProjMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['PointNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['PointMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['DevNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['DevMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['mod'] = 'true';

            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['MPStaticMonitorTable'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['AuditStability'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['StaffManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['AttendanceManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['FactoryManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['AssembleManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['AssembleAudit'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['UserNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['PGNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['ProjNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['PointNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['DevNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['mod'] = 'true';

            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['MPStaticMonitorTable'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['AuditStability'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['StaffManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['AttendanceManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['FactoryManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['AssembleManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['mod'] = 'false';
        }
        elseif (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_FHYS)
        {
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['KeyManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['KeyAuth'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['KeyHistory'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['MPStaticMonitorTable'] = 'true';
            //self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['RTUManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['OTDRManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['UserNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['UserMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['UserDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['ProjNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['ProjMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['ProjDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PointNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PointMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PointDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['DevNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['DevMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['DevDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['OpenLock'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyAuthNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyGrant'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['mod'] = 'true';

            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['KeyManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['KeyAuth'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['KeyHistory'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['MPStaticMonitorTable'] = 'true';
            //self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['RTUManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['OTDRManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['UserNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['UserMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['UserDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['ProjNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['ProjMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['ProjDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['PointNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['PointMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['PointDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['DevNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['DevMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['DevDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['KeyNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['KeyMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['KeyDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['OpenLock'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['KeyAuthNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['KeyGrant'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['mod'] = 'true';

            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['KeyManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['KeyAuth'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['KeyHistory'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['MPStaticMonitorTable'] = 'true';
            //self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['RTUManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['OTDRManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['OpenLock'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['mod'] = 'true';

            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['KeyManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['KeyAuth'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['KeyHistory'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['MPStaticMonitorTable'] = 'true';
            //self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['RTUManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['OTDRManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['actionauth']['OpenLock'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['mod'] = 'true';
        }
        elseif (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_GTJY)
        {
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['KeyManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['KeyAuth'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['KeyHistory'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['MPStaticMonitorTable'] = 'true';
            //self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['UserNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['UserMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['UserDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['ProjNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['ProjMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['ProjDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PointNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PointMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['PointDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['DevNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['DevMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['DevDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['OpenLock'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyAuthNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['actionauth']['KeyGrant'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_1]['mod'] = 'true';

            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['KeyManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['KeyAuth'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['KeyHistory'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['MPStaticMonitorTable'] = 'true';
            //self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['UserNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['UserMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['UserDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['ProjNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['ProjMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['ProjDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['PointNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['PointMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['PointDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['DevNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['DevMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['DevDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['KeyNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['KeyMod'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['KeyDel'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['OpenLock'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['KeyAuthNew'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['actionauth']['KeyGrant'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_2]['mod'] = 'true';

            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['KeyManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['KeyAuth'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['KeyHistory'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['MPStaticMonitorTable'] = 'true';
            //self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['actionauth']['OpenLock'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_3]['mod'] = 'true';

            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['UserManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['ProjManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['MPManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['DevManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['KeyManage'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['KeyAuth'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['KeyHistory'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['MPMonitor'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['MPStaticMonitorTable'] = 'true';
            //self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['WarningCheck'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['webauth']['WarningHandle'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['actionauth']['OpenLock'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['query'] = 'true';
            self::$mfunUserGradeArrayConst[MFUN_USER_GRADE_LEVEL_4]['mod'] = 'true';
        }
    }

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