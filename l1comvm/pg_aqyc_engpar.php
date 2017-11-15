<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 13:15
 */
include_once "../l1comvm/sysconfig.php";
include_once "../l1comvm/pg_general_engpar.php";


/**************************************************************************************
 *                             HCU公共消息全局量定义                                  *
 *************************************************************************************/
//ZHB关键字
define("MFUN_L2SNR_COMAPI_HOUR_VALIDE_NUM", 54); // HCU环保标准：1小时采集的有效分钟数据应不少于 54个
define("MFUN_L2SNR_COMAPI_DAY_VALIDE_NUM", 21);  // HCU环保标准：每日应有不少于21个有效小时均值的算术平均值为有效日均值
define("MFUN_L2SDK_IOTHCU_ZHB_HRB_FRAME","ZHB_HRB");  //中环保协议帧格式：心跳帧
define("MFUN_L2SDK_IOTHCU_ZHB_NOM_FRAME","ZHB_NOM");  //中环保协议帧格式：正常数据帧

//HCU设备状态
define ("MFUN_HCU_AQYC_STATUS_ON", "Y");
define ("MFUN_HCU_AQYC_STATUS_OFF", "N");
define("MFUN_HCU_AQYC_SLEEP_DURATION", 600); //如果最后一次测量报告距离现在已经超过10x60秒
define("MFUN_HCU_AQYC_TIME_GRID_SIZE", 3); //定义用于数据存储的时间网格为。单位为分钟

//扬尘摄像头访问常量
define ("MFUN_HCU_AQYC_CAM_USERNAME", "admin");
define ("MFUN_HCU_AQYC_CAM_PASSWORD", "Bxxh!123");

//定义传感器类型
define("MFUN_L3APL_F3DM_AQYC_STYPE_PREFIX", "YC"); //AQYC传感器类型特征字
define("MFUN_L3APL_F3DM_AQYC_STYPE_PM", "YC_001");
define("MFUN_L3APL_F3DM_AQYC_STYPE_WINDSPD", "YC_002");
define("MFUN_L3APL_F3DM_AQYC_STYPE_WINDDIR", "YC_003");
define("MFUN_L3APL_F3DM_AQYC_STYPE_EMC", "YC_005");
define("MFUN_L3APL_F3DM_AQYC_STYPE_TEMP", "YC_006");
define("MFUN_L3APL_F3DM_AQYC_STYPE_HUMID", "YC_007");
define("MFUN_L3APL_F3DM_AQYC_STYPE_NOISE", "YC_00A");

//HCU下列L3控制字有效，功能已经实现
define("MFUN_HCU_CMDID_VERSION_SYNC", 0xF0);   //IHU软，硬件版本查询命令字
define("MFUN_HCU_CMDID_TIME_SYNC", 0xF2);    //时间同步命令字
define("MFUN_HCU_CMDID_EMC_DATA", 0x20);   //电磁波辐射测量命令字
define("MFUN_HCU_CMDID_PM25_DATA", 0x25);  //MODBUS 颗粒物命令字
define("MFUN_HCU_CMDID_WINDSPD_DATA", 0x26);  //MODBUS 风速命令字
define("MFUN_HCU_CMDID_WINDDIR_DATA", 0x27);  //MODBUS 风向命令字
define("MFUN_HCU_CMDID_TEMP_DATA", 0x28);  //MODBUS 温度命令字
define("MFUN_HCU_CMDID_HUMID_DATA", 0x29);  //MODBUS 湿度命令字
define("MFUN_HCU_CMDID_HSMMP_DATA", 0x2C);  //Video命令字
define("MFUN_HCU_CMDID_NOISE_DATA", 0x2B);  //Noise命令字
define("MFUN_HCU_CMDID_INVENTORY_DATA", 0xA0); //SW,HW 版本信息
define("MFUN_HCU_CMDID_SW_UPDATE", 0xA1);   //HCU软件更新
define("MFUN_HCU_CMDID_HEART_BEAT", 0xFE); //HCU心跳特殊控制字
define("MFUN_HCU_CMDID_HCU_POLLING", 0xFD); //HCU命令轮询控制字
define("MFUN_HCU_CMDID_HCU_ALARM_DATA", 0xB0); //HCU Alarm Data控制字
define("MFUN_HCU_CMDID_HCU_PERFORMANCE", 0xB1); //HCU Performance控制字

//MODBUS操作字，0x0开头表示下行从CLOUD到下位机
define("MFUN_HCU_MODBUS_DATA_REQ", 0x01); //测量命令
define("MFUN_HCU_MODBUS_SWITCH_SET", 0x02);
define("MFUN_HCU_MODBUS_ADDR_SET", 0x03);
define("MFUN_HCU_MODBUS_PERIOD_SET", 0x04);
define("MFUN_HCU_MODBUS_SAMPLES_SET", 0x05);
define("MFUN_HCU_MODBUS_TIMES_SET", 0x06);
define("MFUN_HCU_MODBUS_SWITCH_READ", 0x07);
define("MFUN_HCU_MODBUS_ADDR_READ", 0x08);
define("MFUN_HCU_MODBUS_PERIOD_READ", 0x09);
define("MFUN_HCU_MODBUS_SAMPLES_READ", 0x0A);
define("MFUN_HCU_MODBUS_TIMES_READ", 0x0B);

//MODBUS操作字，0x8开头表示下行从下位机到CLOUD
define("MFUN_HCU_MODBUS_DATA_REPORT", 0x81);  //测量报告
define("MFUN_HCU_MODBUS_SWITCH_SET_ACK", 0x82);
define("MFUN_HCU_MODBUS_ADDR_SET_ACK", 0x83);
define("MFUN_HCU_MODBUS_PERIOD_SET_ACK", 0x84);
define("MFUN_HCU_MODBUS_SAMPLE_SET_ACK", 0x85);
define("MFUN_HCU_MODBUS_TIMES_SET_ACK", 0x86);
define("MFUN_HCU_MODBUS_SWITCH_READ_ACK", 0x87);
define("MFUN_HCU_MODBUS_ADDR_READ_ACK", 0x88);
define("MFUN_HCU_MODBUS_PERIOD_READ_ACK", 0x89);
define("MFUN_HCU_MODBUS_SAMPLE_READ_ACK", 0x8A);
define("MFUN_HCU_MODBUS_TIMES_READ_ACK", 0x8B);

/**************************************************************************************
 * AQYC: 爱启杨尘项目相关缺省配置参数                                                 *
 *************************************************************************************/
define ("MFUN_HCU_AQYC_ALARM_CODE_MAX", 0x0A); //Alarmcode的最大值，如有新alarmcode添加，该值要顺延

if (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_AQYC){
    define("MFUN_CLOUD_WWW", "www.hkrob.com");
    define ("MFUN_HCU_DATA_SAVE_DURATION_BY_PROJ", 180); //定义数据保存不删的时间长度
    define ("MFUN_HCU_USER_NAME_GRADE_0", "管理员");
    define ("MFUN_HCU_USER_NAME_GRADE_1", "高级用户");
    define ("MFUN_HCU_USER_NAME_GRADE_2", "一级用户");
    define ("MFUN_HCU_USER_NAME_GRADE_3", "二级用户");
    define ("MFUN_HCU_USER_NAME_GRADE_4", "三级用户");
    define ("MFUN_HCU_USER_NAME_GRADE_N", "用户等级未知");
}

class classConstAqycEngpar
{
    public static $mfunAqycAlarmCode=array(
        HUITP_IEID_UNI_ALARM_CONTENT_NONE => '工作正常',
        HUITP_IEID_UNI_ALARM_CONTENT_PM25_NO_CONNECT => '颗粒物传感器故障',
        HUITP_IEID_UNI_ALARM_CONTENT_TEMP_NO_CONNECT => '温度传感器故障',
        HUITP_IEID_UNI_ALARM_CONTENT_HUMID_NO_CONNECT => '湿度传感器故障',
        HUITP_IEID_UNI_ALARM_CONTENT_WINDDIR_NO_CONNECT => '风向传感器故障',
        HUITP_IEID_UNI_ALARM_CONTENT_WINDSPD_NO_CONNECT => '风速传感器故障',
        HUITP_IEID_UNI_ALARM_CONTENT_NOISE_NO_CONNECT => '噪声传感器故障',
        HUITP_IEID_UNI_ALARM_CONTENT_VIDEO_NO_CONNECT => '摄像头故障',
        HUITP_IEID_UNI_ALARM_CONTENT_TSP_VALUE_EXCEED_THRESHLOD => '扬尘超标',
        HUITP_IEID_UNI_ALARM_CONTENT_NOISE_VALUE_EXCEED_THRESHLOD => '噪声超标'
    );

    //通过告警码获取详细告警信息
    public static function mfun_hcu_aqyc_getAlarmDescription($alarmcode)
    {
        if ($alarmcode >= 0 AND $alarmcode <MFUN_HCU_AQYC_ALARM_CODE_MAX) {
            return self::$mfunAqycAlarmCode[$alarmcode];
        }else {
            return '未知告警';
        }
    }

}

?>