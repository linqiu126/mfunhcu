<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 13:29
 */
include_once "../l1comvm/sysconfig.php";
include_once "../l1comvm/sysdim.php";

//全局TaskId的定义，全系统唯一定义，后面会不断的用到
$taskIndex = 0;
define("MFUN_TASK_ID_MIN", $taskIndex++);
define("MFUN_TASK_ID_L1VM", $taskIndex++);
define("MFUN_TASK_ID_L2SDK_IOT_APPLE", $taskIndex++);
define("MFUN_TASK_ID_L2SDK_IOT_JD", $taskIndex++);
define("MFUN_TASK_ID_L2SDK_WECHAT", $taskIndex++);
define("MFUN_TASK_ID_L2SDK_IOT_WX", $taskIndex++);
define("MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK", $taskIndex++);
define("MFUN_TASK_ID_L2SDK_IOT_STDXML", $taskIndex++);
define("MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376", $taskIndex++);  //基于376的规范
define("MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188", $taskIndex++);//基于CJ188规范
define("MFUN_TASK_ID_L2SDK_NBIOT_LTEV", $taskIndex++);    //车联网
define("MFUN_TASK_ID_L2SDK_NBIOT_AGC", $taskIndex++);     //农业用途
define("MFUN_TASK_ID_L2SDK_IOT_HUITP", $taskIndex++); //HUITP协议处理
define("MFUN_TASK_ID_L2DECODE_HUITP",$taskIndex++); //HUITP 解码任务模块
define("MFUN_TASK_ID_L2ENCODE_HUITP",$taskIndex++); //HUITP 编码任务模块
define("MFUN_TASK_ID_L2SENSOR_COMMON",$taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_EMC", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_HSMMP", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_HUMID", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_NOISE", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_PM25", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_TEMP", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_WINDDIR", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_WINDSPD", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_AIRPRS", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_ALCOHOL", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_CO1", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_HCHO", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_TOXICGAS", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_LIGHTSTR", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_RAIN", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_IPM", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_IGM", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_IWM", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_IHM", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_BATT", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_BLE", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_DOORLOCK", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_CCL", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_GPRS", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_RFID", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_SMOK", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_VIBR", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_WATER", $taskIndex++);
define("MFUN_TASK_ID_L2SENSOR_WEIGHT", $taskIndex++); //BFSC组合秤
define("MFUN_TASK_ID_L2SENSOR_FDWQ", $taskIndex++);   //FDWQ项目
define("MFUN_TASK_ID_L2TIMER_CRON", $taskIndex++);
define("MFUN_TASK_ID_L2SOCKET_LISTEN", $taskIndex++);
define("MFUN_TASK_ID_L3APPL_FUM1SYM", $taskIndex++);
define("MFUN_TASK_ID_L3APPL_FUM2CM", $taskIndex++);
define("MFUN_TASK_ID_L3APPL_FUM3DM", $taskIndex++);
define("MFUN_TASK_ID_L3APPL_FUM4ICM", $taskIndex++);
define("MFUN_TASK_ID_L3APPL_FUM5FM", $taskIndex++);
define("MFUN_TASK_ID_L3APPL_FUM6PM", $taskIndex++);
define("MFUN_TASK_ID_L3APPL_FUM7ADS", $taskIndex++);
define("MFUN_TASK_ID_L3APPL_FUM8PSM", $taskIndex++);
define("MFUN_TASK_ID_L3APPL_FUM9GISM", $taskIndex++);
define("MFUN_TASK_ID_L3APPL_FUMXPRCM", $taskIndex++);
define("MFUN_TASK_ID_L3WX_OPR_EMC", $taskIndex++);  //用于EMC微信H5界面处理L3 task
define("MFUN_TASK_ID_L3WX_OPR_FHYS", $taskIndex++); //用于FHYS微信H5界面处理L3 task
define("MFUN_TASK_ID_L3WX_OPR_FAAM", $taskIndex++); //用于工厂辅助管理系统微信小程序处理
define("MFUN_TASK_ID_L3NBIOT_OPR_METER", $taskIndex++);

define("MFUN_TASK_ID_L4COM_UI", $taskIndex++); //公共界面处理模块
define("MFUN_TASK_ID_L4AQYC_UI", $taskIndex++);
define("MFUN_TASK_ID_L4FHYS_UI", $taskIndex++);
define("MFUN_TASK_ID_L4FHYS_WECHAT", $taskIndex++);
define("MFUN_TASK_ID_L4BFSC_UI", $taskIndex++);
define("MFUN_TASK_ID_L4EMCWX_UI", $taskIndex++);
define("MFUN_TASK_ID_L4TBSWR_UI", $taskIndex++);
define("MFUN_TASK_ID_L4FDWQ_UI", $taskIndex++);
define("MFUN_TASK_ID_L4GTJY_UI", $taskIndex++);
define("MFUN_TASK_ID_L4NBIOT_IPM_UI", $taskIndex++);
define("MFUN_TASK_ID_L4NBIOT_IGM_UI", $taskIndex++);
define("MFUN_TASK_ID_L4NBIOT_IWM_UI", $taskIndex++);
define("MFUN_TASK_ID_L4NBIOT_IHM_UI", $taskIndex++);
define("MFUN_TASK_ID_L4OAMTOOLS", $taskIndex++);
define("MFUN_TASK_ID_L5BI", $taskIndex++);
define("MFUN_TASK_ID_MAX", $taskIndex++);
define("MFUN_TASK_ID_NULL", $taskIndex++); //注意，不能超过系统DIMENSION中的MAX_TASK_NUM_IN_ONE_MFUN

/*
 *  class的定义及规定
 *  1. 所有的类必须以class开头，形式为 class + 特殊标识 + 任务层次 + 具体命令
 *  2. Const开头表示变量常亮，classConstL1vmSysTaskList
 *  3. Dbi表示数据库封装
 *  4. Task表示任务模块
 */

//全局TaskName的定义
class classConstL1vmSysTaskList
{
    public static $mfunTaskArrayConst = array(
        MFUN_TASK_ID_MIN => array("NAME" => "MFUN_TASK_MIN", "PRESENT" => true),
        MFUN_TASK_ID_L1VM => array("NAME" => "MFUN_TASK_L1VM", "PRESENT" => false),
        MFUN_TASK_ID_L2SDK_IOT_APPLE => array("NAME" => "MFUN_TASK_L2SDK_IOT_APPLE", "PRESENT" => false),
        MFUN_TASK_ID_L2SDK_IOT_JD => array("NAME" => "MFUN_TASK_L2SDK_IOT_JD", "PRESENT" => false),
        MFUN_TASK_ID_L2SDK_WECHAT => array("NAME" => "MFUN_TASK_L2SDK_WECHAT", "PRESENT" => false),
        MFUN_TASK_ID_L2SDK_IOT_WX => array("NAME" => "MFUN_TASK_L2SDK_IOT_WX", "PRESENT" => false),
        MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK => array("NAME" => "MFUN_TASK_L2SDK_IOT_WX_JSSDK", "PRESENT" => false),
        MFUN_TASK_ID_L2SDK_IOT_STDXML => array("NAME" => "MFUN_TASK_L2SDK_IOT_STDXML", "PRESENT" => false),
        MFUN_TASK_ID_L2SDK_IOT_HUITP => array("NAME" => "MFUN_TASK_ID_L2SDK_IOT_HUITP", "PRESENT" => false),
        MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376 => array("NAME" => "MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376", "PRESENT" => false),
        MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188 => array("NAME" => "MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188", "PRESENT" => false),
        MFUN_TASK_ID_L2SDK_NBIOT_LTEV => array("NAME" => "MFUN_TASK_ID_L2SDK_NBIOT_LTEV", "PRESENT" => false),
        MFUN_TASK_ID_L2SDK_NBIOT_AGC => array("NAME" => "MFUN_TASK_ID_L2SDK_NBIOT_AGC", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_COMMON => array("NAME" => "MFUN_TASK_ID_L2SENSOR_COMMON", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_EMC => array("NAME" => "MFUN_TASK_L2SENSOR_EMC", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_HSMMP => array("NAME" => "MFUN_TASK_L2SENSOR_HSMMP", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_HUMID => array("NAME" => "MFUN_TASK_L2SENSOR_HUMID", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_NOISE => array("NAME" => "MFUN_TASK_L2SENSOR_NOISE", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_PM25 => array("NAME" => "MFUN_TASK_L2SENSOR_PM25", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_TEMP => array("NAME" => "MFUN_TASK_L2SENSOR_TEMP", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_WINDDIR => array("NAME" => "MFUN_TASK_L2SENSOR_WINDDIR", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_WINDSPD => array("NAME" => "MFUN_TASK_L2SENSOR_WINDSPD", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_AIRPRS => array("NAME" => "MFUN_TASK_L2SENSOR_AIRPRS", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_ALCOHOL => array("NAME" => "MFUN_TASK_L2SENSOR_ALCOHOL", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_CO1 =>array("NAME" => "MFUN_TASK_L2SENSOR_CO1", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_HCHO => array("NAME" => "MFUN_TASK_L2SENSOR_HCHO", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_TOXICGAS => array("NAME" => "MFUN_TASK_L2SENSOR_TOXICGAS", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_LIGHTSTR => array("NAME" => "MFUN_TASK_L2SENSOR_LIGHTSTR", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_RAIN => array("NAME" => "MFUN_TASK_ID_L2SENSOR_RAIN", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_IPM => array("NAME" => "MFUN_TASK_ID_L2SENSOR_IPM", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_IWM => array("NAME" => "MFUN_TASK_ID_L2SENSOR_IWM", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_IGM => array("NAME" => "MFUN_TASK_ID_L2SENSOR_IGM", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_IHM => array("NAME" => "MFUN_TASK_ID_L2SENSOR_IHM", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_BATT => array("NAME" => "MFUN_TASK_ID_L2SENSOR_BATT", "PRESENT" => false), //FHYS云控锁
        MFUN_TASK_ID_L2SENSOR_BLE => array("NAME" => "MFUN_TASK_ID_L2SENSOR_BLE", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_DOORLOCK => array("NAME" => "MFUN_TASK_ID_L2SENSOR_DOORLOCK", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_CCL => array("NAME" => "MFUN_TASK_ID_L2SENSOR_CCL", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_GPRS => array("NAME" => "MFUN_TASK_ID_L2SENSOR_GPRS", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_RFID => array("NAME" => "MFUN_TASK_ID_L2SENSOR_RFID", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_SMOK => array("NAME" => "MFUN_TASK_ID_L2SENSOR_SMOK", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_VIBR => array("NAME" => "MFUN_TASK_ID_L2SENSOR_VIBR", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_WATER => array("NAME" => "MFUN_TASK_ID_L2SENSOR_WATER", "PRESENT" => false),
        MFUN_TASK_ID_L2SENSOR_WEIGHT => array("NAME" => "MFUN_TASK_ID_L2SENSOR_WEIGHT", "PRESENT" => false), //BFSC组合秤
        MFUN_TASK_ID_L2SENSOR_FDWQ => array("NAME" => "MFUN_TASK_ID_L2SENSOR_FDWQ", "PRESENT" => false), //FDWQ
        MFUN_TASK_ID_L2TIMER_CRON => array("NAME" => "MFUN_TASK_ID_L2TIMER_CRON", "PRESENT" => false),
        MFUN_TASK_ID_L2SOCKET_LISTEN => array("NAME" => "MFUN_TASK_ID_L2SOCKET_LISTEN", "PRESENT" => false),
        MFUN_TASK_ID_L2DECODE_HUITP => array("NAME" => "MFUN_TASK_ID_L2DECODE_HUITP", "PRESENT" => false),
        MFUN_TASK_ID_L2ENCODE_HUITP => array("NAME" => "MFUN_TASK_ID_L2ENCODE_HUITP", "PRESENT" => false),
        MFUN_TASK_ID_L3APPL_FUM1SYM => array("NAME" => "MFUN_TASK_L3APPL_FUM1SYM", "PRESENT" => false),
        MFUN_TASK_ID_L3APPL_FUM2CM => array("NAME" => "MFUN_TASK_L3APPL_FUM2CM", "PRESENT" => false),
        MFUN_TASK_ID_L3APPL_FUM3DM => array("NAME" => "MFUN_TASK_L3APPL_FUM3DM", "PRESENT" => false),
        MFUN_TASK_ID_L3APPL_FUM4ICM => array("NAME" => "MFUN_TASK_L3APPL_FUM4ICM", "PRESENT" => false),
        MFUN_TASK_ID_L3APPL_FUM5FM => array("NAME" => "MFUN_TASK_L3APPL_FUM5FM", "PRESENT" => false),
        MFUN_TASK_ID_L3APPL_FUM6PM => array("NAME" => "MFUN_TASK_L3APPL_FUM6PM", "PRESENT" => false),
        MFUN_TASK_ID_L3APPL_FUM7ADS => array("NAME" => "MFUN_TASK_L3APPL_FUM7ADS", "PRESENT" => false),
        MFUN_TASK_ID_L3APPL_FUM8PSM => array("NAME" => "MFUN_TASK_L3APPL_FUM8PSM", "PRESENT" => false),
        MFUN_TASK_ID_L3APPL_FUM9GISM => array("NAME" => "MFUN_TASK_L3APPL_FUM9GISM", "PRESENT" => false),
        MFUN_TASK_ID_L3APPL_FUMXPRCM => array("NAME" => "MFUN_TASK_L3APPL_FUMXPRCM", "PRESENT" => false),
        MFUN_TASK_ID_L3WX_OPR_EMC => array("NAME" => "MFUN_TASK_ID_L3WX_OPR_EMC", "PRESENT" => false),
        MFUN_TASK_ID_L3WX_OPR_FHYS => array("NAME" => "MFUN_TASK_ID_L3WX_OPR_FHYS", "PRESENT" => false),
        MFUN_TASK_ID_L3WX_OPR_FAAM => array("NAME" => "MFUN_TASK_ID_L3WX_OPR_FAAM", "PRESENT" => false),
        MFUN_TASK_ID_L3NBIOT_OPR_METER => array("NAME" => "MFUN_TASK_ID_L3NBIOT_OPR_METER", "PRESENT" => false),
        MFUN_TASK_ID_L4COM_UI => array("NAME" => "MFUN_TASK_ID_L4COM_UI", "PRESENT" => false),
        MFUN_TASK_ID_L4AQYC_UI => array("NAME" => "MFUN_TASK_L4AQYC_UI", "PRESENT" => false),
        MFUN_TASK_ID_L4FHYS_UI => array("NAME" => "MFUN_TASK_L4FHYS_UI", "PRESENT" => false),
        MFUN_TASK_ID_L4FHYS_WECHAT => array("NAME" => "MFUN_TASK_ID_L4FHYS_WECHAT", "PRESENT" => false),
        MFUN_TASK_ID_L4BFSC_UI => array("NAME" => "MFUN_TASK_L4BFSC_UI", "PRESENT" => false),
        MFUN_TASK_ID_L4EMCWX_UI => array("NAME" => "MFUN_TASK_L4EMCWX_UI", "PRESENT" => false),
        MFUN_TASK_ID_L4TBSWR_UI => array("NAME" => "MFUN_TASK_L4TBSWR_UI", "PRESENT" => false),
        MFUN_TASK_ID_L4FDWQ_UI => array("NAME" => "MFUN_TASK_ID_L4FDWQ_UI", "PRESENT" => false),
        MFUN_TASK_ID_L4GTJY_UI => array("NAME" => "MFUN_TASK_ID_L4GTJY_UI", "PRESENT" => false),
        MFUN_TASK_ID_L4NBIOT_IPM_UI => array("NAME" => "MFUN_TASK_ID_L4NBIOT_IPM_UI", "PRESENT" => false),
        MFUN_TASK_ID_L4NBIOT_IGM_UI => array("NAME" => "MFUN_TASK_ID_L4NBIOT_IGM_UI", "PRESENT" => false),
        MFUN_TASK_ID_L4NBIOT_IWM_UI => array("NAME" => "MFUN_TASK_ID_L4NBIOT_IWM_UI", "PRESENT" => false),
        MFUN_TASK_ID_L4NBIOT_IHM_UI => array("NAME" => "MFUN_TASK_ID_L4NBIOT_IHM_UI", "PRESENT" => false),
        MFUN_TASK_ID_L4OAMTOOLS => array("NAME" => "MFUN_TASK_L4OAMTOOLS", "PRESENT" => false),
        MFUN_TASK_ID_L5BI => array("NAME" => "MFUN_TASK_L5BI", "PRESENT" => false),
        MFUN_TASK_ID_MAX => array("NAME" => "MFUN_TASK_MAX", "PRESENT" => true),
        MFUN_TASK_ID_NULL => array("NAME" => "MFUN_TASK_NULL", "PRESENT" => true),
    );

    //构造函数，根据配置信息初始化Present状态
    public function __construct()
    {
        //按照不同的工作配置情况，设置模块标识及PRESENT情况. 系统初始化为false，根据项目需要打开对应的模块为true
        if (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_AQYC)
        {
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_STDXML]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2DECODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2ENCODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_COMMON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_EMC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HSMMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HUMID]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_NOISE]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_PM25]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TEMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDDIR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDSPD]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_AIRPRS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_ALCOHOL]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_CO1]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HCHO]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TOXICGAS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_LIGHTSTR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_RAIN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IPM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IWM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IGM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IHM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2TIMER_CRON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SOCKET_LISTEN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM1SYM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM2CM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM3DM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM4ICM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM5FM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM6PM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM7ADS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM8PSM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM9GISM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUMXPRCM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3WX_OPR_EMC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4COM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4AQYC_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
        }
        elseif (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_EMCWX)
        {
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2DECODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2ENCODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_STDXML]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_COMMON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_EMC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2TIMER_CRON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SOCKET_LISTEN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3WX_OPR_EMC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3WX_OPR_FHYS]["PRESENT"] = false;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4EMCWX_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
        }
        elseif (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_TBSWR)
        {
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2DECODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2ENCODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_STDXML]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_COMMON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_EMC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HSMMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HUMID]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_NOISE]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_PM25]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TEMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDDIR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDSPD]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_AIRPRS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_ALCOHOL]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_CO1]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HCHO]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TOXICGAS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_LIGHTSTR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_RAIN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2TIMER_CRON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SOCKET_LISTEN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM1SYM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM2CM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM3DM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM4ICM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM5FM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM6PM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM7ADS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM8PSM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM9GISM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUMXPRCM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3WX_OPR_EMC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4COM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4TBSWR_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
        }
        elseif (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_FHYS)
        {
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2DECODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2ENCODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_STDXML]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_COMMON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HSMMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HUMID]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TEMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_BATT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_BLE]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_DOORLOCK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_CCL]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_GPRS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_RFID]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_SMOK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_VIBR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WATER]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WEIGHT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2TIMER_CRON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SOCKET_LISTEN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM1SYM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM2CM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM3DM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM4ICM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM5FM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM6PM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM7ADS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM8PSM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM9GISM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUMXPRCM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3WX_OPR_FHYS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4COM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4FHYS_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4FHYS_WECHAT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
        }
        elseif (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_GTJY)
        {
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2DECODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2ENCODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_STDXML]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_COMMON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HSMMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HUMID]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TEMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_BATT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_BLE]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_DOORLOCK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_CCL]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_GPRS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_RFID]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_SMOK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_VIBR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WATER]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WEIGHT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2TIMER_CRON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SOCKET_LISTEN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM1SYM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM2CM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM3DM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM4ICM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM5FM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM6PM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM7ADS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM8PSM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM9GISM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUMXPRCM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3WX_OPR_FHYS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4COM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4GTJY_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4FHYS_WECHAT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
        }
        elseif (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_NBIOT_IPM)
        {
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2DECODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2ENCODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_STDXML]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_LTEV]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_AGC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_COMMON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HSMMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HUMID]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_NOISE]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_PM25]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TEMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDDIR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDSPD]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_AIRPRS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_ALCOHOL]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_CO1]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HCHO]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TOXICGAS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_LIGHTSTR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_RAIN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IPM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2TIMER_CRON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SOCKET_LISTEN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM1SYM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM2CM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM3DM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM4ICM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM5FM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM6PM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM7ADS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM8PSM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM9GISM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUMXPRCM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3WX_OPR_EMC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3NBIOT_OPR_METER]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4COM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4EMCWX_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4NBIOT_IPM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
        }
        elseif (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_NBIOT_IWM)
        {
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_COMMON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2DECODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2ENCODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_STDXML]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_LTEV]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_AGC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HSMMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HUMID]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_NOISE]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_PM25]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TEMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDDIR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDSPD]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_AIRPRS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_ALCOHOL]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_CO1]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HCHO]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TOXICGAS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_LIGHTSTR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_RAIN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IWM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2TIMER_CRON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SOCKET_LISTEN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM1SYM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM2CM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM3DM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM4ICM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM5FM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM6PM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM7ADS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM8PSM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM9GISM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUMXPRCM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3NBIOT_OPR_METER]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4COM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4NBIOT_IWM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
        }
        elseif (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_NBIOT_IGM)
        {
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2DECODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2ENCODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_STDXML]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_LTEV]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_AGC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_COMMON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HSMMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HUMID]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_NOISE]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_PM25]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TEMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDDIR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDSPD]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_AIRPRS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_ALCOHOL]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_CO1]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HCHO]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TOXICGAS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_LIGHTSTR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_RAIN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IGM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2TIMER_CRON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SOCKET_LISTEN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM1SYM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM2CM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM3DM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM4ICM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM5FM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM6PM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM7ADS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM8PSM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM9GISM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUMXPRCM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3NBIOT_OPR_METER]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4COM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4NBIOT_IGM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
        }
        elseif (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_NBIOT_IHM)
        {
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2DECODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2ENCODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_STDXML]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_LTEV]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_AGC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_COMMON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HSMMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HUMID]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_NOISE]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_PM25]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TEMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDDIR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDSPD]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_AIRPRS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_ALCOHOL]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_CO1]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HCHO]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TOXICGAS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_LIGHTSTR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_RAIN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IHM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2TIMER_CRON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SOCKET_LISTEN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM1SYM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM2CM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM3DM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM4ICM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM5FM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM6PM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM7ADS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM8PSM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM9GISM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUMXPRCM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3NBIOT_OPR_METER]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4COM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4NBIOT_IHM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
        }
        elseif(MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_FDWQ)
        {
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_STDXML]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2DECODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2ENCODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_COMMON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_EMC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HSMMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HUMID]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_NOISE]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_PM25]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TEMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDDIR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDSPD]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_AIRPRS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_ALCOHOL]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_CO1]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HCHO]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TOXICGAS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_LIGHTSTR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_RAIN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IPM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IWM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IGM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IHM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_FDWQ]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2TIMER_CRON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SOCKET_LISTEN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM1SYM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM2CM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM3DM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM4ICM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM5FM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM6PM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM7ADS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM8PSM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM9GISM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUMXPRCM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3WX_OPR_EMC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4COM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4FDWQ_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
        }
        elseif (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_TESTMODE)
        {
            self::$mfunTaskArrayConst[MFUN_TASK_ID_MIN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L1VM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_APPLE]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_JD]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_WECHAT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2DECODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2ENCODE_HUITP]["PRESENT"] =  true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_IOT_STDXML]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_LTEV]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SDK_NBIOT_AGC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_COMMON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_EMC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HSMMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HUMID]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_NOISE]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_PM25]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TEMP]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDDIR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WINDSPD]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_AIRPRS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_ALCOHOL]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_CO1]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_HCHO]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_TOXICGAS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_LIGHTSTR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_RAIN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IPM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IWM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IGM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_IHM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_BATT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_BLE]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_DOORLOCK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_CCL]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_GPRS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_RFID]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_SMOK]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_VIBR]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WATER]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_WEIGHT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SENSOR_FDWQ]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2TIMER_CRON]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L2SOCKET_LISTEN]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM1SYM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM2CM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM3DM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM4ICM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM5FM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM6PM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM7ADS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM8PSM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUM9GISM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3APPL_FUMXPRCM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3WX_OPR_EMC]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3WX_OPR_FHYS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3WX_OPR_FAAM]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L3NBIOT_OPR_METER]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4COM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4AQYC_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4FHYS_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4FDWQ_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4GTJY_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4FHYS_WECHAT]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4BFSC_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4EMCWX_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4TBSWR_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4NBIOT_IPM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4NBIOT_IGM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4NBIOT_IWM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4NBIOT_IHM_UI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L4OAMTOOLS]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_L5BI]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_MAX]["PRESENT"] = true;
            self::$mfunTaskArrayConst[MFUN_TASK_ID_NULL]["PRESENT"] = true;
        }
    }

    //通过TaskId读取TaskName
    public static function mfun_vm_getTaskName($taskId)
    {
        if (isset(self::$mfunTaskArrayConst[$taskId]["NAME"])) {
            return self::$mfunTaskArrayConst[$taskId]["NAME"];
        }else {
            return false;
        }
    }

    //通过TaskName读取TaskId
    public static function mfun_vm_getTaskId($taskName)
    {
        for ($i = MFUN_TASK_ID_MIN; $i < MFUN_TASK_ID_MAX; $i++) {
            if (isset(self::$mfunTaskArrayConst[$i]["NAME"]) == $taskName)
                return $i;
        }
        return false;
    }

    //通过TaskId读取Present状态
    public static function mfun_vm_getTaskPresent($taskId)
    {
        if (isset(self::$mfunTaskArrayConst[$taskId]["PRESENT"])) {
            return self::$mfunTaskArrayConst[$taskId]["PRESENT"];
        }else {
            return false;
        }
    }
}

?>