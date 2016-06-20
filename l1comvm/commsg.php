<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 13:16
 */

/**************************************************************************************
 *                             公共消息全局量定义                                     *
 *************************************************************************************/
define("TIME_GRID_SIZE", 1); //定义用于数据存储的时间网格为。单位为分钟

define("XML_FORMAT", "<x"); //XML数据格式，消息以<xml开头
define("ZHB_FORMAT", "##"); //中环保数据格式，消息以##开头

define("PG_CODE_PREFIX", "PG");   //定义项目组code的特征字，项目组code必须以“PG”开头
define("PROJ_CODE_PREFIX", "P_");  //定义项目code的特征字，项目code必须以“P_”开头
define("UID_PREFIX", "UID");  //定义用户ID的特征字，用户ID必须以UID开头
define("CODE_FORMAT_LEN", 2); //定义项目code和项目组code的特征字长度
define("SESSIONID_VALID_TIME", 1800);  //Session ID有效时间为30分钟

define("IHU_MSG_HEAD_FORMAT", "A4MagicCode/A4Version/A4Length/A4CmdId/A4Seq/A4ErrCode");
define("IHU_MSG_HEAD_LENGTH", 24); //12 Byte
define("HCU_MSG_HEAD_FORMAT", "A2Key/A2Len/A2Cmd");// 1B 控制字ctrl_key, 1B 长度length（除控制字和长度本身外），1B 操作字opt_key
define("HCU_MSG_HEAD_LENGTH", 6); //3 Byte

define("PLTF_WX", 0x01);  //微信平台
define("PLTF_HCU", 0x02); //HCU平台
define("PLTF_JD", 0x03);  //京东平台

define("HOUR_VALIDE_NUM", 54); // HCU环保标准：1小时采集的有效分钟数据应不少于 54个
define("DAY_VALIDE_NUM", 21);  // HCU环保标准：每日应有不少于21个有效小时均值的算术平均值为有效日均值

define("MAX_LOG_NUM", 5000);  //防止t_loginfo表单数据无限制的增长，保留的最大记录数

define("ZHB_HRB_FRAME","ZHB_HRB");
define("ZHB_NOM_FRAME","ZHB_NOM");

define("SESSION_ID_LEN", 8); //UI界面session id字符串长度
define("USER_ID_LEN", 6); //UI界面user id字符串长度

//定义各测量值告警门限
define("TH_ALARM_NOISE", 80);
define("TH_ALARM_HUMIDITY", 50);
define("TH_ALARM_TEMPERATURE", 45);
define("TH_ALARM_PM25", 100);
define("TH_ALARM_WINDSPEED", 20);
define("TH_ALARM_EMC", 100);
define("TH_ALARM_WINDDIR", 360);

//定义传感器类型
define("S_TYPE_PM", "S_0001");
define("S_TYPE_WINDSPEED", "S_0002");
define("S_TYPE_WINDDIR", "S_0003");
define("S_TYPE_EMC", "S_0005");
define("S_TYPE_TEMPERATURE", "S_0006");
define("S_TYPE_HUMIDITY", "S_0007");
define("S_TYPE_NOISE", "S_000A");

//层三处理消息的定义，保留，暂时没有使用
define("L3_HEAD_MAGIC", 0xFE);
define("L3_HEAD_VERSION",0x01);
define("L3_HEAD_LENGTH", 0x08);
define("CMDID_SEND_TEXT_REQ", 0x1);    //HW -> CLOUD
define("CMDID_SEND_TEXT_RESP", 0x1001);   //CLOUD ->HW
define("CMDID_OPEN_LIGHT_PUSH", 0x2001);  //CLOUD ->HW
define("CMDID_CLOSE_LIGHT_PUSH", 0x2002);   //CLOUD ->HW
define("CMDID_HW_VERSION_REQ", 0x3001);
define("CMDID_HW_VERSION_RESP", 0x3002);
define("CMDID_HW_VERSION_PUSH", 0x3003);
define("CMDID_EMC_DATA_REV", 0x2712);
define("CMDID_OCH_DATA_REQ", 0x4010);  //酒精测试量
define("CMDID_OCH_DATA_RESP", 0x4011);

//下列L3控制字有效，功能已经实现
define("CMDID_VERSION_SYNC", 0xF0);   //IHU软，硬件版本查询命令字
define("CMDID_TIME_SYNC", 0xF2);    //时间同步命令字
define("CMDID_EMC_DATA", 0x20);   //电磁波辐射测量命令字
define("CMDID_PM_DATA", 0x25);  //MODBUS 颗粒物命令字
define("CMDID_WINDSPEED_DATA", 0x26);  //MODBUS 风速命令字
define("CMDID_WINDDIR_DATA", 0x27);  //MODBUS 风向命令字
define("CMDID_TEMPERATURE_DATA", 0x28);  //MODBUS 温度命令字
define("CMDID_HUMIDITY_DATA", 0x29);  //MODBUS 湿度命令字
define("CMDID_VIDEO_DATA", 0x2C);  //Video命令字
define("CMDID_NOISE_DATA", 0x2B);  //Noise命令字

define("CMDID_INVENTORY_DATA", 0xA0); //SW,HW 版本信息
define("CMDID_SW_UPDATE", 0xA1);   //HCU软件更新

define("CMDID_HEART_BEAT", 0xFE); //HCU心跳特殊控制字
define("CMDID_HCU_POLLING", 0xFD); //HCU命令轮询控制字

define("CMDID_EMC_DATA_PUSH", 0x2001); //临时定义给IHU测试
define("CMDID_EMC_DATA_RESP", 0x2081); //临时定义给IHU测试

//MODBUS操作字，0x0开头表示下行从CLOUD到下位机
define("MODBUS_DATA_REQ", 0x01); //测量命令
define("MODBUS_SWITCH_SET", 0x02);
define("MODBUS_ADDR_SET", 0x03);
define("MODBUS_PERIOD_SET", 0x04);
define("MODBUS_SAMPLES_SET", 0x05);
define("MODBUS_TIMES_SET", 0x06);
define("MODBUS_SWITCH_READ", 0x07);
define("MODBUS_ADDR_READ", 0x08);
define("MODBUS_PERIOD_READ", 0x09);
define("MODBUS_SAMPLES_READ", 0x0A);
define("MODBUS_TIMES_READ", 0x0B);

//MODBUS操作字，0x8开头表示下行从下位机到CLOUD
define("MODBUS_DATA_REPORT", 0x81);  //测量报告
define("MODBUS_SWITCH_SET_ACK", 0x82);
define("MODBUS_ADDR_SET_ACK", 0x83);
define("MODBUS_PERIOD_SET_ACK", 0x84);
define("MODBUS_SAMPLE_SET_ACK", 0x85);
define("MODBUS_TIMES_SET_ACK", 0x86);
define("MODBUS_SWITCH_READ_ACK", 0x87);
define("MODBUS_ADDR_READ_ACK", 0x88);
define("MODBUS_PERIOD_READ_ACK", 0x89);
define("MODBUS_SAMPLE_READ_ACK", 0x8A);
define("MODBUS_TIMES_READ_ACK", 0x8B);

//其他命令操作字
define("OPT_INVENTORY_REQ", 0x01);
define("OPT_INVENTORY_RESP", 0x81);

define("OPT_VEDIOLINK_REQ", 0x01);  //读取下位机存放的视频文件link
define("OPT_VEDIOLINK_RESP", 0x81); //返回下位机存放的视频文件link
define("OPT_VEDIOFILE_REQ", 0x02);   //命令下位机上传选中的视频文件
define("OPT_VEDIOFILE_RESP", 0x82);  //视频文件传输完成响应

//传感器ID定义
define ("ID_EQUIP_PM", 0x01);
define ("ID_EQUIP_WINDSPEED", 0x02);
define ("ID_EQUIP_WINDDIR", 0x03);
define ("ID_EQUIP_EMC", 0x05);
define ("ID_EQUIP_TEMPERATURE", 0x06);
define ("ID_EQUIP_HUMIDITY", 0x06);
define ("ID_EQUIP_NOISE", 0x0A);


?>