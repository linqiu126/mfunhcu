<?php
/**
 * Created by PhpStorm.
 * User: Zehong
 * Date: 2016/10/28
 * Time: 22:18
 */
include_once "../l1comvm/sysconfig.php";
include_once "../l1comvm/pg_general_engpar.php";

//FHYS项目用于短信通知的系统常量定义
define("MFUN_HCU_FHYS_LEXIN_URL","http://www.lx198.com/sdk/send?");  //乐信短信平台请求地址
define("MFUN_HCU_FHYS_LEXIN_ACCNAME","accName=18616271103");  //用户名(乐信登录账号)
define("MFUN_HCU_FHYS_LEXIN_ACCPWD","accPwd=E10ADC3949BA59ABBE56E057F20F883E");  //密码123456(乐信登录密码32位MD5加密后转大写)
define("MFUN_HCU_FHYS_LEXIN_SIGNATURE","【光交箱云平台】"); //短信签名
define("MFUN_HCU_FHYS_LEXIN_AUTHCODE_LEN", 6); //短信验证码长度

//中国移动短彩信平台
define("MFUN_HCU_FHYS_CMCC_URL", "http://api.sms.heclouds.com/tempsmsSend");  //模板短信请求地址
define("MFUN_HCU_FHYS_CMCC_SICODE", "a2bb3546a41649a29e2fcb635e091dd5");  //短信平台SI CODE
define("MFUN_HCU_FHYS_CMCC_TEMPCODE_PW", "10832");  //短信模板码  “您的验证码是#smscode#【阜华光交箱云平台】"
define("MFUN_HCU_FHYS_CMCC_TEMPCODE_ALARM", "10833");  //短信模板码  “站点#name#告警：#action#【阜华光交箱云平台】"
//模板短信参数
//http://api.sms.heclouds.com/tempsmsSend?sicode=a2bb3546a41649a29e2fcb635e091dd5&mobiles=13917334681&tempid=10003&name=foha

//FHYS项目关键字
define("MFUN_HCU_FHYS_PIC_UPLOAD_DIR", "../../avorion/upload/"); //云控锁安装后，手机拍照上传照片目录
define("MFUN_HCU_FHYS_PIC_WWW_FOLDER", "/avorion/upload/");   //手机拍照上传照片存放目录，相对于www/html的路径
define("MFUN_HCU_FHYS_PIC_ABS_FOLDER", "/var/www/html/avorion/upload/");   //手机拍照上传照片服务器绝对路径
define("MFUN_HCU_FHYS_SLEEP_DURATION", 180); //如果最后一次测量报告距离现在已经超过3x60秒
define ("MFUN_HCU_FHYS_TIME_GRID_SIZE", 3); //每分钟一条记录

//FHYS钥匙类型
define("MFUN_L3APL_F2CM_KEY_PREFIX", "KEY");  //定义KEY ID的特征字，钥匙KEYID必须以KEY开头
define("MFUN_L3APL_F2CM_KEY_ID_LEN", 6);     //UI界面key id字符串长度=该值+3（KEY)
define("MFUN_L3APL_F2CM_KEY_TYPE_RFID", "R");
define("MFUN_L3APL_F2CM_KEY_TYPE_BLE", "B");
define("MFUN_L3APL_F2CM_KEY_TYPE_USER", "U");
define("MFUN_L3APL_F2CM_KEY_TYPE_WECHAT", "W");
define("MFUN_L3APL_F2CM_KEY_TYPE_IDCARD", "I");
define("MFUN_L3APL_F2CM_KEY_TYPE_PHONE", "P");
define("MFUN_L3APL_F2CM_KEY_TYPE_UNDEFINED", "N");

//钥匙授权级别,类型
define("MFUN_L3APL_F2CM_AUTH_LEVEL_PROJ", "P"); //项目级授权
define("MFUN_L3APL_F2CM_AUTH_LEVEL_DEVICE", "D"); //单个站点(设备)级授权
define("MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER", "N");
define("MFUN_L3APL_F2CM_AUTH_TYPE_TIME", "T");
define("MFUN_L3APL_F2CM_AUTH_TYPE_FOREVER", "F");

//开锁事件类型
define("MFUN_L3APL_F2CM_EVENT_TYPE_RFID", "R"); //RFID开锁事件
define("MFUN_L3APL_F2CM_EVENT_TYPE_BLE", "B");
define("MFUN_L3APL_F2CM_EVENT_TYPE_USER", "U");
define("MFUN_L3APL_F2CM_EVENT_TYPE_WECHAT", "W");
define("MFUN_L3APL_F2CM_EVENT_TYPE_IDCARD", "I");
define("MFUN_L3APL_F2CM_EVENT_TYPE_PHONE", "P");
define("MFUN_L3APL_F2CM_EVENT_TYPE_XJ", "X");  //巡检事件
define("MFUN_L3APL_F2CM_EVENT_TYPE_ALARM", "A");  //不明开锁事件

define("MFUN_L3APL_F2CM_EVENT_DURATION_DAY", "1");
define("MFUN_L3APL_F2CM_EVENT_DURATION_WEEK", "7");
define("MFUN_L3APL_F2CM_EVENT_DURATION_MONTH", "30");

//FHYS系统常量

define ("MFUN_HCU_FHYS_ALARM_YES", "Y");
define ("MFUN_HCU_FHYS_ALARM_NO", "N");
define ("MFUN_HCU_FHYS_STATUS_UNKNOWN", "U"); //未知状态

define ("MFUN_HCU_FHYS_ALARM_LEVEL_0", "0"); //告警级别0，正常无告警
define ("MFUN_HCU_FHYS_ALARM_LEVEL_L", "1"); //告警级别1，告警级别Low
define ("MFUN_HCU_FHYS_ALARM_LEVEL_M", "2"); //告警级别2，告警级别Middle
define ("MFUN_HCU_FHYS_ALARM_LEVEL_H", "3"); //告警级别3，告警级别High

define ("MFUN_HCU_FHYS_KEY_VALID", "Y");  //虚拟钥匙有效，已授予用户
define ("MFUN_HCU_FHYS_KEY_INVALID", "N"); //虚拟钥匙无效，未授予用户
define ("MFUN_HCU_FHYS_RFID_NULL", "00000000");  //无效RFID
define ("MFUN_HCU_FHYS_BLEMAC_NULL", "000000000000");  //无效BLE MAC

//下位机的数据常量
define ("MFUN_HCU_DATA_FHYS_STATUS_OK", 0x00); //设备状态正常或者门锁闭合
define ("MFUN_HCU_DATA_FHYS_STATUS_NOK", 0x01); //设备状态异常或者门锁打开
define ("MFUN_HCU_DATA_FHYS_STATUS_NULL", 0x02); //设备为空或门锁没有安装
define ("MFUN_HCU_DATA_FHYS_STATUS_ALARM", 0x03); //设备状态异常或者门锁未授权打开
define ("MFUN_HCU_DATA_FHYS_LOCK_OPEN", 0x00);  //开锁命令
define ("MFUN_HCU_DATA_FHYS_LOCK_CLOSE", 0x01);  //闭锁命令

//定义智能云锁所带传感器类型
define("MFUN_L3APL_F3DM_FHYS_STYPE_PREFIX", "CL"); //FHYS传感器类型特征字

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
define("MFUN_HCU_CMDID_FHYS_DOORLOCK_OPEN", 0x4B);    //光交箱开锁控制字
define("MFUN_HCU_CMDID_FHYS_DOORLOCK_STATUS", 0x4C);  //光交箱状态聚合控制字

//锁操作字
define("MFUN_HCU_OPT_FHYS_BOXSTAT_IND", 0x81);
define("MFUN_HCU_OPT_FHYS_BOXSTAT_RESP", 0x01);
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

define ("MFUN_HCU_FHYS_ALARM_NONE", 0x00); //正常无告警
define ("MFUN_HCU_FHYS_ALARM_DOOR1_OPEN", 0x01); //门-1暴力打开
define ("MFUN_HCU_FHYS_ALARM_DOOR2_OPEN", 0x02); //门-2暴力打开
define ("MFUN_HCU_FHYS_ALARM_DOOR3_OPEN", 0x03); //门-3暴力打开
define ("MFUN_HCU_FHYS_ALARM_DOOR4_OPEN", 0x04); //门-4暴力打开
define ("MFUN_HCU_FHYS_ALARM_LOCK1_OPEN", 0x05); //锁-1暴力打开
define ("MFUN_HCU_FHYS_ALARM_LOCK2_OPEN", 0x06); //锁-2暴力打开
define ("MFUN_HCU_FHYS_ALARM_LOCK3_OPEN", 0x07); //锁-3暴力打开
define ("MFUN_HCU_FHYS_ALARM_LOCK4_OPEN", 0x08); //锁-4暴力打开
define ("MFUN_HCU_FHYS_ALARM_SMOK", 0x09); //烟雾报警
define ("MFUN_HCU_FHYS_ALARM_WATER", 0x0A); //水浸报警
define ("MFUN_HCU_FHYS_ALARM_VIBR", 0x0B); //震动报警
define ("MFUN_HCU_FHYS_ALARM_TILT", 0x0C);  //倾斜报警
define ("MFUN_HCU_FHYS_ALARM_LOW_SIG", 0x0D); //GPRS信号强度弱
define ("MFUN_HCU_FHYS_ALARM_LOW_BATT", 0x0E); //低电量告警
define ("MFUN_HCU_FHYS_ALARM_CODE_MAX", 0x0F); //Alarmcode的最大值，如有新alarmcode添加，该值要顺延


/**************************************************************************************
 * FHYS: 智能云锁项目相关缺省配置参数                                                  *
 *************************************************************************************/
if (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_FHYS){
    define("MFUN_CLOUD_WWW", "http://www.foome.com.cn");
    define ("MFUN_HCU_DATA_SAVE_DURATION_BY_PROJ", 180);//定义数据保存不删的时间长度
    define ("MFUN_HCU_USER_NAME_GRADE_0", "管理员");
    define ("MFUN_HCU_USER_NAME_GRADE_1", "市级网管");
    define ("MFUN_HCU_USER_NAME_GRADE_2", "区级网管");
    define ("MFUN_HCU_USER_NAME_GRADE_3", "市级代维");
    define ("MFUN_HCU_USER_NAME_GRADE_4", "区级代维");
    define ("MFUN_HCU_USER_NAME_GRADE_N", "用户等级未知");

}

class classConstFhysEngpar
{
    public static $mfunFhysAlarmCode=array(
        MFUN_HCU_FHYS_ALARM_NONE => '工作正常',
        MFUN_HCU_FHYS_ALARM_DOOR1_OPEN => '门-1暴力打开',
        MFUN_HCU_FHYS_ALARM_DOOR2_OPEN => '门-2暴力打开',
        MFUN_HCU_FHYS_ALARM_DOOR3_OPEN => '门-3暴力打开',
        MFUN_HCU_FHYS_ALARM_DOOR4_OPEN => '门-4暴力打开',
        MFUN_HCU_FHYS_ALARM_LOCK1_OPEN => '锁-1暴力打开',
        MFUN_HCU_FHYS_ALARM_LOCK2_OPEN => '锁-2暴力打开',
        MFUN_HCU_FHYS_ALARM_LOCK3_OPEN => '锁-3暴力打开',
        MFUN_HCU_FHYS_ALARM_LOCK4_OPEN => '锁-4暴力打开',
        MFUN_HCU_FHYS_ALARM_SMOK => '烟雾报警',
        MFUN_HCU_FHYS_ALARM_WATER => '水浸报警',
        MFUN_HCU_FHYS_ALARM_VIBR => '震动报警',
        MFUN_HCU_FHYS_ALARM_TILT => '箱体倾斜报警',
        MFUN_HCU_FHYS_ALARM_LOW_SIG => 'GPRS信号强度弱',
        MFUN_HCU_FHYS_ALARM_LOW_BATT => '低电量告警'
    );

    //通过告警码获取详细告警信息
    public static function mfun_hcu_fhys_getAlarmDescription($alarmcode)
    {
        if ($alarmcode >= 0 AND $alarmcode <MFUN_HCU_FHYS_ALARM_CODE_MAX) {
            return self::$mfunFhysAlarmCode[$alarmcode];
        }else {
            return '未知告警';
        }
    }

}

?>