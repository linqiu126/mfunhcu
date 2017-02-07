<?php
/**
 * Created by PhpStorm.
 * User: Zehong Liu
 * Date: 2017/1/22
 * Time: 15:51
 */

/***********************************************************************************************************************
 *                                                   HUITP接口协议v0.9
 **********************************************************************************************************************/


/***********************************************HUITP公共参数***********************************************************/
define("MFUN_HUITP_MSG_HEAD_FORMAT", "A2CmdId/A2OptId/A4Len");
define("MFUN_HUITP_MSG_HEAD_LENGTH", 8); //2B MsgId(1B CmdId+1B OptId),2B Len
define("MFUN_HUITP_IEID_LENGTH", 4);  //ieId 2Byte
define("MFUN_HUITP_IELEN_LENGTH", 4); //ieLen 2Byte
define("MFUN_HUITP_IELEN_1B", 2); //1Byte
define("MFUN_HUITP_IELEN_2B", 4); //2Byte
define("MFUN_HUITP_IELEN_4B", 8); //4Byte

define("HUITP_IEID_UNI_CCL_LOCK_MAX_NUMBER", 4); //最多支持4把锁

/*********************************************HUITP命令字HuitpCmdId*****************************************************/
define("HUITP_CMDID_uni_none",                  0x00);
define("HUITP_CMDID_uni_blood_glucose",         0x01);  //血糖
define("HUITP_CMDID_uni_single_sports",         0x02);  //单次运动
define("HUITP_CMDID_uni_single_sleep",          0x03);  //单次睡眠
define("HUITP_CMDID_uni_body_fat",              0x04);  //体脂
define("HUITP_CMDID_uni_blood_pressure",        0x05);  //血压
define("HUITP_CMDID_uni_runner_machine_report", 0x0A);  //跑步机数据上报
define("HUITP_CMDID_uni_runner_machine_control",0x0B);  //跑步机任务控制
define("HUITP_CMDID_uni_gps",                   0x0C);  //GPS地址
define("HUITP_CMDID_uni_Ihu_iau_control ",      0x10);  //IHU与IAU之间控制命令
define("HUITP_CMDID_uni_emc",                   0x20);  //电磁辐射强度
define("HUITP_CMDID_uni_emc_accumulation",      0x21);  //电磁辐射剂量
define("HUITP_CMDID_uni_co",                    0x22);  //一氧化碳
define("HUITP_CMDID_uni_formaldehyde",          0x23);  //甲醛HCHO
define("HUITP_CMDID_uni_alcohol",               0x24);  //酒精
define("HUITP_CMDID_uni_pm25",                  0x25);  //PM1/2.5/10
define("HUITP_CMDID_uni_windspd",               0x26);  //风速Wind Speed
define("HUITP_CMDID_uni_winddir",               0x27);  //风向Wind Direction
define("HUITP_CMDID_uni_temp",                  0x28);  //温度Temperature
define("HUITP_CMDID_uni_humid",                 0x29);  //湿度Humidity
define("HUITP_CMDID_uni_airprs",                0x2A);  //气压Air pressure
define("HUITP_CMDID_uni_noise",                 0x2B);  //噪声Noise
define("HUITP_CMDID_uni_hsmmp",                 0x2C);  //相机Camer or audio high speed
define("HUITP_CMDID_uni_audio",                 0x2D);  //声音
define("HUITP_CMDID_uni_video",                 0x2E);  //视频
define("HUITP_CMDID_uni_picture",               0x2F);  //图片
define("HUITP_CMDID_uni_ycjk",                  0x30);  //扬尘监控
define("HUITP_CMDID_uni_water_meter",           0x31);  //水表
define("HUITP_CMDID_uni_heat_meter",            0x32);  //热表
define("HUITP_CMDID_uni_gas_meter",             0x33);  //气表
define("HUITP_CMDID_uni_power_meter",           0x34);  //电表
define("HUITP_CMDID_uni_light_strength",        0x35);  //光照强度
define("HUITP_CMDID_uni_toxicgas",              0x36);  //有毒气体VOC
define("HUITP_CMDID_uni_altitude",              0x37);  //海拔高度
define("HUITP_CMDID_uni_moto",                  0x38);  //马达
define("HUITP_CMDID_uni_switch",                0x39);  //继电器
define("HUITP_CMDID_uni_transporter",           0x3A);  //导轨传送带
define("HUITP_CMDID_uni_bfsc_comb_scale",       0x3B);  //组合秤
define("HUITP_CMDID_uni_ccl_lock_old",          0x40);  //智能锁，兼容老系统
define("HUITP_CMDID_uni_ccl_door",              0x41);  //光交箱门，兼容老系统
define("HUITP_CMDID_uni_ccl_rfid",              0x42);  //光交箱RFID模块，兼容老系统
define("HUITP_CMDID_uni_ccl_ble",               0x43);  //光交箱BLE模块，兼容老系统
define("HUITP_CMDID_uni_ccl_gprs",              0x44);  //光交箱GPRS模块，兼容老系统
define("HUITP_CMDID_uni_ccl_battery",           0x45);  //光交箱电池模块，兼容老系统
define("HUITP_CMDID_uni_ccl_shake",             0x46);  //光交箱震动，兼容老系统
define("HUITP_CMDID_uni_ccl_smoke",             0x47);  //光交箱烟雾，兼容老系统
define("HUITP_CMDID_uni_ccl_water",             0x48);  //光交箱水浸，兼容老系统
define("HUITP_CMDID_uni_ccl_temp",              0x49);  //光交箱温度，兼容老系统
define("HUITP_CMDID_uni_ccl_humid",             0x4A);  //光交箱湿度，兼容老系统
define("HUITP_CMDID_uni_ccl_fall",              0x4B);  //倾倒，兼容老系统
define("HUITP_CMDID_uni_ccl_state_old",         0x4C);  //状态聚合，兼容老系统
define("HUITP_CMDID_uni_ccl_lock",              0x4D);  //光交箱智能锁
define("HUITP_CMDID_uni_ccl_state",             0x4E);  //光交箱状态聚合
define("HUITP_CMDID_uni_itf_sps",               0x50);  //串口读取命令/返回结果
define("HUITP_CMDID_uni_itf_adc",               0x51);  //ADC读取命令/返回结果
define("HUITP_CMDID_uni_itf_dac",               0x52);  //DAC读取命令/返回结果
define("HUITP_CMDID_uni_itf_i2c",               0x53);  //I2C读取命令/返回结果
define("HUITP_CMDID_uni_itf_pwm",               0x54);  //PWM读取命令/返回结果
define("HUITP_CMDID_uni_itf_di",                0x55);  //DI读取命令/返回结果
define("HUITP_CMDID_uni_itf_do",                0x56);  //DO读取命令/返回结果
define("HUITP_CMDID_uni_itf_can",               0x57);  //CAN读取命令/返回结果
define("HUITP_CMDID_uni_itf_spi",               0x58);  //SPI读取命令/返回结果
define("HUITP_CMDID_uni_itf_usb",               0x59);  //USB读取命令/返回结果
define("HUITP_CMDID_uni_itf_eth",               0x5A);  //网口读取命令/返回结果
define("HUITP_CMDID_uni_itf_485",               0x5B);  //485读取命令/返回结果
define("HUITP_CMDID_uni_Ihu_inventory",         0xA0);	//软件清单
define("HUITP_CMDID_uni_sw_package",            0xA1);	//软件版本体
define("HUITP_CMDID_uni_alarm_info",            0xB0);  //for alarm report
define("HUITP_CMDID_uni_performance_info",      0xB1);  //for PM report
define("HUITP_CMDID_uni_equipment_info",        0xF0);	//设备基本信息
define("HUITP_CMDID_uni_personal_info",         0xF1);	//个人基本信息
define("HUITP_CMDID_uni_time_sync",             0xF2);	//时间同步
define("HUITP_CMDID_uni_read_data",             0xF3);	//读取数据
define("HUITP_CMDID_uni_clock_timeout",         0xF4);	//定时闹钟及久坐提醒
define("HUITP_CMDID_uni_sync_charging",         0xF5);	//同步充电，双击情况
define("HUITP_CMDID_uni_sync_trigger",          0xF6);	//同步通知信息
define("HUITP_CMDID_uni_cmd_control",           0xFD);  //for cmd control by Shanchun
define("HUITP_CMDID_uni_heart_beat",            0xFE);  //心跳
define("HUITP_CMDID_uni_null",                  0xFF);  //无效

/*********************************************HUITP操作字HuitpOptId*****************************************************/
define("HUITP_OPTID_uni_min",                       0x00);
define("HUITP_OPTID_uni_data_req",                  0x00);  //Data Request, 或命令请求
define("HUITP_OPTID_uni_data_resp",                 0x80);  //Data Response
define("HUITP_OPTID_uni_data_report_cfm",           0x01);  //Data report confirm
define("HUITP_OPTID_uni_data_report",               0x81);  //Data Report，或命令响应
define("HUITP_OPTID_uni_set_switch",                0x02);  //Set Switch
define("HUITP_OPTID_uni_set_switch_ack",            0x82);  //Set Switch ack
define("HUITP_OPTID_uni_set_modbus_address",        0x03);  //Set Modbus Address
define("HUITP_OPTID_uni_set_modbus_address_ack",    0x83);  //Set Modbus Address ack
define("HUITP_OPTID_uni_set_work_cycle",            0x04);  //Work cycle, in second
define("HUITP_OPTID_uni_set_work_cycle_ack",        0x84);  //Work cycle, in second
define("HUITP_OPTID_uni_set_sample_cycle",          0x05);  //Set Sample cycle, in second
define("HUITP_OPTID_uni_set_sample_cycle_ack",      0x85);  //Set Sample cycle, in second
define("HUITP_OPTID_uni_set_sample_number",         0x06);  //Set Sample number
define("HUITP_OPTID_uni_set_sample_number_ack",     0x86);  //Set Sample number
define("HUITP_OPTID_uni_read_switch",               0x07);  //Read switch
define("HUITP_OPTID_uni_read_switch_ack",           0x87);  //Read switch
define("HUITP_OPTID_uni_read_modbus_address",       0x08);  //Read Modbus Address
define("HUITP_OPTID_uni_read_modbus_address_ack",   0x88);  //Read Modbus Address
define("HUITP_OPTID_uni_read_work_cycle",           0x09);  //Read Work Cycle
define("HUITP_OPTID_uni_read_work_cycle_ack",       0x89);  //Read Work Cycle
define("HUITP_OPTID_uni_read_sample_cycle",         0x0A);  //Read Sample Cycle
define("HUITP_OPTID_uni_read_sample_cycle_ack",     0x8A);  //Read Sample Cycle
define("HUITP_OPTID_uni_read_sample_number",        0x0B);  //Read Sample Number
define("HUITP_OPTID_uni_read_sample_number_ack",    0x8B);  //Read Sample Number
define("HUITP_OPTID_uni_auth_inq",                  0x90);  //授权询问
define("HUITP_OPTID_uni_auth_resp",                 0x10);  //授权应答
define("HUITP_OPTID_uni_max",                       0x10);


/************************************************HUITP消息HuitpMsgId****************************************************/

//云控锁-锁
define("HUITP_MSGID_uni_ccl_lock_min", 0x4D00);
define("HUITP_MSGID_uni_ccl_lock_req", 0x4D00);
define("HUITP_MSGID_uni_ccl_lock_resp", 0x4D80);
define("HUITP_MSGID_uni_ccl_lock_report", 0x4D81);
define("HUITP_MSGID_uni_ccl_lock_confirm", 0x4D01);
define("HUITP_MSGID_uni_ccl_lock_auth_inq", 0x4D90);
define("HUITP_MSGID_uni_ccl_lock_auth_resp", 0x4D10);
define("HUITP_MSGID_uni_ccl_lock_max", 0x4D10);

//云控锁-状态聚合
define("HUITP_MSGID_uni_ccl_state_min", 0x4E00);
define("HUITP_MSGID_uni_ccl_state_req", 0x4E00);
define("HUITP_MSGID_uni_ccl_state_resp", 0x4E80);
define("HUITP_MSGID_uni_ccl_state_report", 0x4E81);
define("HUITP_MSGID_uni_ccl_state_confirm", 0x4E01);
define("HUITP_MSGID_uni_ccl_state_max", 0x4E01);


/*************************************************HUITP公共信息单元IE定义************************************************/
//IE常量定义
define("HUITP_IEID_UNI_COM_REPORT_NULL", 0);
define("HUITP_IEID_UNI_COM_REPORT_YES", 1);
define("HUITP_IEID_UNI_COM_REPORT_NO", 2);
define("HUITP_IEID_UNI_COM_REPORT_INVALID", 0xFF);



//IEID定义
define("HUITP_IEID_uni_com_req", 0x0001);
define("HUITP_IEID_uni_com_resp", 0x0002);
define("HUITP_IEID_uni_com_report", 0x0003);
define("HUITP_IEID_uni_com_confirm", 0x0004);
define("HUITP_IEID_uni_com_state", 0x0010);

define("HUITP_IEID_uni_ccl_lock_state", 0x4000);


?>