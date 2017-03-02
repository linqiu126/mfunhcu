<?php
/**
 * Created by PhpStorm.
 * User: Zehong Liu
 * Date: 2017/1/22
 * Time: 15:51
 */

/***********************************************************************************************************************
 *                                                   HUITP接口协议v1.2
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

//无效
define("HUITP_MSGID_uni_none", 0x0000);
define("HUITP_MSGID_uni_min", 0x0100);

//血糖
define("HUITP_MSGID_uni_blood_glucose_min", 0x0100);
define("HUITP_MSGID_uni_blood_glucose_req", 0x0100);
define("HUITP_MSGID_uni_blood_glucose_resp", 0x0180);
define("HUITP_MSGID_uni_blood_glucose_report", 0x0181);
define("HUITP_MSGID_uni_blood_glucose_cfm", 0x0101);

//单次运动
define("HUITP_MSGID_uni_single_sports_min", 0x0200);
define("HUITP_MSGID_uni_single_sports_req", 0x0200);
define("HUITP_MSGID_uni_single_sports_resp", 0x0280);
define("HUITP_MSGID_uni_single_sports_report", 0x0281);
define("HUITP_MSGID_uni_single_sports_cfm", 0x0201);

//单次睡眠
define("HUITP_MSGID_uni_single_sleep_min", 0x0300);
define("HUITP_MSGID_uni_single_sleep_req", 0x0300);
define("HUITP_MSGID_uni_single_sleep_resp", 0x0380);
define("HUITP_MSGID_uni_single_sleep_report", 0x0381);
define("HUITP_MSGID_uni_single_sleep_cfm", 0x0301);

//体脂
define("HUITP_MSGID_uni_body_fat_min", 0x0400);
define("HUITP_MSGID_uni_body_fat_req", 0x0400);
define("HUITP_MSGID_uni_body_fat_resp", 0x0480);
define("HUITP_MSGID_uni_body_fat_report", 0x0481);
define("HUITP_MSGID_uni_body_fat_cfm", 0x0401);

//血压
define("HUITP_MSGID_uni_blood_pressure_min", 0x0500);
define("HUITP_MSGID_uni_blood_pressure_req", 0x0500);
define("HUITP_MSGID_uni_blood_pressure_resp", 0x0580);
define("HUITP_MSGID_uni_blood_pressure_report", 0x0581);
define("HUITP_MSGID_uni_blood_pressure_cfm", 0x0501);

//跑步机数据上报
define("HUITP_MSGID_uni_runner_machine_rep_min", 0x0A00);
define("HUITP_MSGID_uni_runner_machine_rep_req", 0x0A00);
define("HUITP_MSGID_uni_runner_machine_rep_resp", 0x0A80);
define("HUITP_MSGID_uni_runner_machine_rep_report", 0x0A81);
define("HUITP_MSGID_uni_runner_machine_rep_cfm", 0x0A01);

//跑步机任务控制
define("HUITP_MSGID_uni_runner_machine_ctrl_min", 0x0B00);
define("HUITP_MSGID_uni_runner_machine_ctrl_req", 0x0B00);
define("HUITP_MSGID_uni_runner_machine_ctrl_resp", 0x0B80);
define("HUITP_MSGID_uni_runner_machine_ctrl_report", 0x0B81);
define("HUITP_MSGID_uni_runner_machine_ctrl_cfm", 0x0B01);

//GPS地址
define("HUITP_MSGID_uni_gps_specific_min", 0x0C00);
define("HUITP_MSGID_uni_gps_specific_req", 0x0C00);
define("HUITP_MSGID_uni_gps_specific_resp", 0x0C80);
define("HUITP_MSGID_uni_gps_specific_report", 0x0C81);
define("HUITP_MSGID_uni_gps_specific_cfm", 0x0C01);

//IHU与IAU之间控制命令
define("HUITP_MSGID_uni_Ihu_iau_ctrl_min", 0x1000);
define("HUITP_MSGID_uni_Ihu_iau_ctrl_req", 0x1000);
define("HUITP_MSGID_uni_Ihu_iau_ctrl_resp", 0x1080);
define("HUITP_MSGID_uni_Ihu_iau_ctrl_report", 0x1081);
define("HUITP_MSGID_uni_Ihu_iau_ctrl_cfm", 0x1001);

//电磁辐射强度
define("HUITP_MSGID_uni_emc_data_min", 0x2000);
define("HUITP_MSGID_uni_emc_data_req", 0x2000);
define("HUITP_MSGID_uni_emc_data_resp", 0x2080);
define("HUITP_MSGID_uni_emc_data_report", 0x2081);
define("HUITP_MSGID_uni_emc_data_cfm", 0x2001);
define("HUITP_MSGID_uni_emc_set_switch", 0x2002);
define("HUITP_MSGID_uni_emc_set_switch_ack", 0x2082);
define("HUITP_MSGID_uni_emc_set_modbus_address", 0x2003);
define("HUITP_MSGID_uni_emc_set_modbus_address_ack", 0x2083);
define("HUITP_MSGID_uni_emc_set_work_cycle", 0x2004);   //In second
define("HUITP_MSGID_uni_emc_set_work_cycle_ack", 0x2084);   //In second
define("HUITP_MSGID_uni_emc_set_sample_cycle", 0x2005);   //In second
define("HUITP_MSGID_uni_emc_set_sample_cycle_ack", 0x2085);   //In second
define("HUITP_MSGID_uni_emc_set_sample_number", 0x2006);
define("HUITP_MSGID_uni_emc_set_sample_number_ack", 0x2086);
define("HUITP_MSGID_uni_emc_read_switch", 0x2007);
define("HUITP_MSGID_uni_emc_read_switch_ack", 0x2087);
define("HUITP_MSGID_uni_emc_read_modbus_address", 0x2008);
define("HUITP_MSGID_uni_emc_read_modbus_address_ack", 0x2088);
define("HUITP_MSGID_uni_emc_read_work_cycle", 0x2009);
define("HUITP_MSGID_uni_emc_read_work_cycle_ack", 0x2089);
define("HUITP_MSGID_uni_emc_read_sample_cycle", 0x200A);
define("HUITP_MSGID_uni_emc_read_sample_cycle_ack", 0x208A);
define("HUITP_MSGID_uni_emc_read_sample_number", 0x200B);
define("HUITP_MSGID_uni_emc_read_sample_number_ack", 0x208B);

//电磁辐射剂量
define("HUITP_MSGID_uni_emc_accu_min", 0x2100);
define("HUITP_MSGID_uni_emc_accu_req", 0x2100);
define("HUITP_MSGID_uni_emc_accu_resp", 0x2180);
define("HUITP_MSGID_uni_emc_accu_report", 0x2181);
define("HUITP_MSGID_uni_emc_accu_cfm", 0x2101);

//一氧化碳
define("HUITP_MSGID_uni_co_min", 0x2200);
define("HUITP_MSGID_uni_co_req", 0x2200);
define("HUITP_MSGID_uni_co_resp", 0x2280);
define("HUITP_MSGID_uni_co_report", 0x2281);
define("HUITP_MSGID_uni_co_cfm", 0x2201);

//甲醛HCHO
define("HUITP_MSGID_uni_formaldehyde_min", 0x2300);
define("HUITP_MSGID_uni_formaldehyde_req", 0x2300);
define("HUITP_MSGID_uni_formaldehyde_resp", 0x2380);
define("HUITP_MSGID_uni_formaldehyde_report", 0x2381);
define("HUITP_MSGID_uni_formaldehyde_cfm", 0x2301);

//酒精
define("HUITP_MSGID_uni_alcohol_min", 0x2400);
define("HUITP_MSGID_uni_alcohol_req", 0x2400);
define("HUITP_MSGID_uni_alcohol_resp", 0x2480);
define("HUITP_MSGID_uni_alcohol_report", 0x2481);
define("HUITP_MSGID_uni_alcohol_cfm", 0x2401);

//PM1/2.5/10
define("HUITP_MSGID_uni_pm25_min", 0x2500);
define("HUITP_MSGID_uni_pm25_data_req", 0x2500);
define("HUITP_MSGID_uni_pm25_data_resp", 0x2580);
define("HUITP_MSGID_uni_pm25_data_report", 0x2581);
define("HUITP_MSGID_uni_pm25_data_cfm", 0x2501);
define("HUITP_MSGID_uni_pm25_set_switch", 0x2502);
define("HUITP_MSGID_uni_pm25_set_switch_ack", 0x2582);
define("HUITP_MSGID_uni_pm25_set_modbus_address", 0x2503);
define("HUITP_MSGID_uni_pm25_set_modbus_address_ack", 0x2583);
define("HUITP_MSGID_uni_pm25_set_work_cycle", 0x2504);  //In second
define("HUITP_MSGID_uni_pm25_set_work_cycle_ack", 0x2584);
define("HUITP_MSGID_uni_pm25_set_sample_cycle", 0x2505);  //In second
define("HUITP_MSGID_uni_pm25_set_sample_cycle_ack", 0x2585);
define("HUITP_MSGID_uni_pm25_set_sample_number", 0x2506);
define("HUITP_MSGID_uni_pm25_set_sample_number_ack", 0x2586);
define("HUITP_MSGID_uni_pm25_read_switch", 0x2507);
define("HUITP_MSGID_uni_pm25_read_switch_ack", 0x2587);
define("HUITP_MSGID_uni_pm25_read_modbus_address", 0x2508);
define("HUITP_MSGID_uni_pm25_read_modbus_address_ack", 0x2588);
define("HUITP_MSGID_uni_pm25_read_work_cycle", 0x2509);  //In second
define("HUITP_MSGID_uni_pm25_read_work_cycle_ack", 0x2589);
define("HUITP_MSGID_uni_pm25_read_sample_cycle", 0x250A);  //In second
define("HUITP_MSGID_uni_pm25_read_sample_cycle_ack", 0x258A);
define("HUITP_MSGID_uni_pm25_read_sample_number", 0x250B);
define("HUITP_MSGID_uni_pm25_read_sample_number_ack", 0x258B);

//风速Wind Speed
define("HUITP_MSGID_uni_windspd_min", 0x2600);
define("HUITP_MSGID_uni_windspd_data_req", 0x2600);
define("HUITP_MSGID_uni_windspd_data_resp", 0x2680);
define("HUITP_MSGID_uni_windspd_data_report", 0x2681);
define("HUITP_MSGID_uni_windspd_data_cfm", 0x2601);
define("HUITP_MSGID_uni_windspd_set_switch", 0x2602);
define("HUITP_MSGID_uni_windspd_set_switch_ack", 0x2682);
define("HUITP_MSGID_uni_windspd_set_modbus_address", 0x2603);
define("HUITP_MSGID_uni_windspd_set_modbus_address_ack", 0x2683);
define("HUITP_MSGID_uni_windspd_set_work_cycle", 0x2604); //In second
define("HUITP_MSGID_uni_windspd_set_work_cycle_ack", 0x2684);
define("HUITP_MSGID_uni_windspd_set_sample_cycle", 0x2605);  //In second
define("HUITP_MSGID_uni_windspd_set_sample_cycle_ack", 0x2685);
define("HUITP_MSGID_uni_windspd_set_sample_number", 0x2606);
define("HUITP_MSGID_uni_windspd_set_sample_number_ack", 0x2686);
define("HUITP_MSGID_uni_windspd_read_switch", 0x2607);
define("HUITP_MSGID_uni_windspd_read_switch_ack", 0x2687);
define("HUITP_MSGID_uni_windspd_read_modbus_address", 0x2608);
define("HUITP_MSGID_uni_windspd_read_modbus_address_ack", 0x2688);
define("HUITP_MSGID_uni_windspd_read_work_cycle", 0x2609); //In second
define("HUITP_MSGID_uni_windspd_read_work_cycle_ack", 0x2689);
define("HUITP_MSGID_uni_windspd_read_sample_cycle", 0x260A);  //In second
define("HUITP_MSGID_uni_windspd_read_sample_cycle_ack", 0x268A);
define("HUITP_MSGID_uni_windspd_read_sample_number", 0x260B);
define("HUITP_MSGID_uni_windspd_read_sample_number_ack", 0x268B);

//风向Wind Direction
define("HUITP_MSGID_uni_winddir_min", 0x2700);
define("HUITP_MSGID_uni_winddir_data_req", 0x2700);
define("HUITP_MSGID_uni_winddir_data_resp", 0x2780);
define("HUITP_MSGID_uni_winddir_data_report", 0x2781);
define("HUITP_MSGID_uni_winddir_data_cfm", 0x2701);
define("HUITP_MSGID_uni_winddir_set_switch", 0x2702);
define("HUITP_MSGID_uni_winddir_set_switch_ack", 0x2782);
define("HUITP_MSGID_uni_winddir_set_modbus_address", 0x2703);
define("HUITP_MSGID_uni_winddir_set_modbus_address_ack", 0x2783);
define("HUITP_MSGID_uni_winddir_set_work_cycle", 0x2704); //In second
define("HUITP_MSGID_uni_winddir_set_work_cycle_ack", 0x2784);
define("HUITP_MSGID_uni_winddir_set_sample_cycle", 0x2705);  //In second
define("HUITP_MSGID_uni_winddir_set_sample_cycle_ack", 0x2785);
define("HUITP_MSGID_uni_winddir_set_sample_number", 0x2706);
define("HUITP_MSGID_uni_winddir_set_sample_number_ack", 0x2786);
define("HUITP_MSGID_uni_winddir_read_switch", 0x2707);
define("HUITP_MSGID_uni_winddir_read_switch_ack", 0x2787);
define("HUITP_MSGID_uni_winddir_read_modbus_address", 0x2708);
define("HUITP_MSGID_uni_winddir_read_modbus_address_ack", 0x2788);
define("HUITP_MSGID_uni_winddir_read_work_cycle", 0x2709); //In second
define("HUITP_MSGID_uni_winddir_read_work_cycle_ack", 0x2789);
define("HUITP_MSGID_uni_winddir_read_sample_cycle", 0x270A);  //In second
define("HUITP_MSGID_uni_winddir_read_sample_cycle_ack", 0x278A);
define("HUITP_MSGID_uni_winddir_read_sample_number", 0x270B);
define("HUITP_MSGID_uni_winddir_read_sample_number_ack", 0x278B);

//温度Temperature
define("HUITP_MSGID_uni_temp_min", 0x2800);
define("HUITP_MSGID_uni_temp_data_req", 0x2800);
define("HUITP_MSGID_uni_temp_data_resp", 0x2880);
define("HUITP_MSGID_uni_temp_data_report", 0x2881);
define("HUITP_MSGID_uni_temp_data_cfm", 0x2801);
define("HUITP_MSGID_uni_temp_set_switch", 0x2802);
define("HUITP_MSGID_uni_temp_set_switch_ack", 0x2882);
define("HUITP_MSGID_uni_temp_set_modbus_address", 0x2803);
define("HUITP_MSGID_uni_temp_set_modbus_address_ack", 0x2883);
define("HUITP_MSGID_uni_temp_set_work_cycle", 0x2804); //In second
define("HUITP_MSGID_uni_temp_set_work_cycle_ack", 0x2884);
define("HUITP_MSGID_uni_temp_set_sample_cycle", 0x2805);  //In second
define("HUITP_MSGID_uni_temp_set_sample_cycle_ack", 0x2885);
define("HUITP_MSGID_uni_temp_set_sample_number", 0x2806);
define("HUITP_MSGID_uni_temp_set_sample_number_ack", 0x2886);
define("HUITP_MSGID_uni_temp_read_switch", 0x2807);
define("HUITP_MSGID_uni_temp_read_switch_ack", 0x2887);
define("HUITP_MSGID_uni_temp_read_modbus_address", 0x2808);
define("HUITP_MSGID_uni_temp_read_modbus_address_ack", 0x2888);
define("HUITP_MSGID_uni_temp_read_work_cycle", 0x2809); //In second
define("HUITP_MSGID_uni_temp_read_work_cycle_ack", 0x2889);
define("HUITP_MSGID_uni_temp_read_sample_cycle", 0x280A);  //In second
define("HUITP_MSGID_uni_temp_read_sample_cycle_ack", 0x288A);
define("HUITP_MSGID_uni_temp_read_sample_number", 0x280B);
define("HUITP_MSGID_uni_temp_read_sample_number_ack", 0x288B);

//湿度Humidity
define("HUITP_MSGID_uni_humid_min", 0x2900);
define("HUITP_MSGID_uni_humid_data_req", 0x2900);
define("HUITP_MSGID_uni_humid_data_resp", 0x2980);
define("HUITP_MSGID_uni_humid_data_report", 0x2981);
define("HUITP_MSGID_uni_humid_data_cfm", 0x2901);
define("HUITP_MSGID_uni_humid_set_switch", 0x2902);
define("HUITP_MSGID_uni_humid_set_switch_ack", 0x2982);
define("HUITP_MSGID_uni_humid_set_modbus_address", 0x2903);
define("HUITP_MSGID_uni_humid_set_modbus_address_ack", 0x2983);
define("HUITP_MSGID_uni_humid_set_work_cycle", 0x2904); //In second
define("HUITP_MSGID_uni_humid_set_work_cycle_ack", 0x2984);
define("HUITP_MSGID_uni_humid_set_sample_cycle", 0x2905);  //In second
define("HUITP_MSGID_uni_humid_set_sample_cycle_ack", 0x2985);
define("HUITP_MSGID_uni_humid_set_sample_number", 0x2906);
define("HUITP_MSGID_uni_humid_set_sample_number_ack", 0x2986);
define("HUITP_MSGID_uni_humid_read_switch", 0x2907);
define("HUITP_MSGID_uni_humid_read_switch_ack", 0x2987);
define("HUITP_MSGID_uni_humid_read_modbus_address", 0x2908);
define("HUITP_MSGID_uni_humid_read_modbus_address_ack", 0x2988);
define("HUITP_MSGID_uni_humid_read_work_cycle", 0x2909); //In second
define("HUITP_MSGID_uni_humid_read_work_cycle_ack", 0x2989);
define("HUITP_MSGID_uni_humid_read_sample_cycle", 0x290A);  //In second
define("HUITP_MSGID_uni_humid_read_sample_cycle_ack", 0x298A);
define("HUITP_MSGID_uni_humid_read_sample_number", 0x290B);
define("HUITP_MSGID_uni_humid_read_sample_number_ack", 0x298B);

//气压Air pressure
define("HUITP_MSGID_uni_airprs_min", 0x2A00);
define("HUITP_MSGID_uni_airprs_data_req", 0x2A00);
define("HUITP_MSGID_uni_airprs_data_resp", 0x2A80);
define("HUITP_MSGID_uni_airprs_data_report", 0x2A81);
define("HUITP_MSGID_uni_airprs_data_cfm", 0x2A01);
define("HUITP_MSGID_uni_airprs_set_switch", 0x2A02);
define("HUITP_MSGID_uni_airprs_set_switch_ack", 0x2A82);
define("HUITP_MSGID_uni_airprs_set_modbus_address", 0x2A03);
define("HUITP_MSGID_uni_airprs_set_modbus_address_ack", 0x2A83);
define("HUITP_MSGID_uni_airprs_set_work_cycle", 0x2A04); //In second
define("HUITP_MSGID_uni_airprs_set_work_cycle_ack", 0x2A84);
define("HUITP_MSGID_uni_airprs_set_sample_cycle", 0x2A05);  //In second
define("HUITP_MSGID_uni_airprs_set_sample_cycle_ack", 0x2A85);
define("HUITP_MSGID_uni_airprs_set_sample_number", 0x2A06);
define("HUITP_MSGID_uni_airprs_set_sample_number_ack", 0x2A86);
define("HUITP_MSGID_uni_airprs_read_switch", 0x2A07);
define("HUITP_MSGID_uni_airprs_read_switch_ack", 0x2A87);
define("HUITP_MSGID_uni_airprs_read_modbus_address", 0x2A08);
define("HUITP_MSGID_uni_airprs_read_modbus_address_ack", 0x2A88);
define("HUITP_MSGID_uni_airprs_read_work_cycle", 0x2A09); //In second
define("HUITP_MSGID_uni_airprs_read_work_cycle_ack", 0x2A89);
define("HUITP_MSGID_uni_airprs_read_sample_cycle", 0x2A0A);  //In second
define("HUITP_MSGID_uni_airprs_read_sample_cycle_ack", 0x2A8A);
define("HUITP_MSGID_uni_airprs_read_sample_number", 0x2A0B);
define("HUITP_MSGID_uni_airprs_read_sample_number_ack", 0x2A8B);

//噪声Noise
define("HUITP_MSGID_uni_noise_min", 0x2B00);
define("HUITP_MSGID_uni_noise_data_req", 0x2B00);
define("HUITP_MSGID_uni_noise_data_resp", 0x2B80);
define("HUITP_MSGID_uni_noise_data_report", 0x2B81);
define("HUITP_MSGID_uni_noise_data_cfm", 0x2B01);
define("HUITP_MSGID_uni_noise_set_switch", 0x2B02);
define("HUITP_MSGID_uni_noise_set_switch_ack", 0x2B82);
define("HUITP_MSGID_uni_noise_set_modbus_address", 0x2B03);
define("HUITP_MSGID_uni_noise_set_modbus_address_ack", 0x2B83);
define("HUITP_MSGID_uni_noise_set_work_cycle", 0x2B04); //In second
define("HUITP_MSGID_uni_noise_set_work_cycle_ack", 0x2B84);
define("HUITP_MSGID_uni_noise_set_sample_cycle", 0x2B05);  //In second
define("HUITP_MSGID_uni_noise_set_sample_cycle_ack", 0x2B85);
define("HUITP_MSGID_uni_noise_set_sample_number", 0x2B06);
define("HUITP_MSGID_uni_noise_set_sample_number_ack", 0x2B86);
define("HUITP_MSGID_uni_noise_read_switch", 0x2B07);
define("HUITP_MSGID_uni_noise_read_switch_ack", 0x2B87);
define("HUITP_MSGID_uni_noise_read_modbus_address", 0x2B08);
define("HUITP_MSGID_uni_noise_read_modbus_address_ack", 0x2B88);
define("HUITP_MSGID_uni_noise_read_work_cycle", 0x2B09); //In second
define("HUITP_MSGID_uni_noise_read_work_cycle_ack", 0x2B89);
define("HUITP_MSGID_uni_noise_read_sample_cycle", 0x2B0A);  //In second
define("HUITP_MSGID_uni_noise_read_sample_cycle_ack", 0x2B8A);
define("HUITP_MSGID_uni_noise_read_sample_number", 0x2B0B);
define("HUITP_MSGID_uni_noise_read_sample_number_ack", 0x2B8B);

//相机Camer or audio high speed
define("HUITP_MSGID_uni_hsmmp_min", 0x2C00);
define("HUITP_MSGID_uni_hsmmp_data_req", 0x2C00);
define("HUITP_MSGID_uni_hsmmp_data_resp", 0x2C80);
define("HUITP_MSGID_uni_hsmmp_data_report", 0x2C81);
define("HUITP_MSGID_uni_hsmmp_data_cfm", 0x2C01);
define("HUITP_MSGID_uni_hsmmp_set_switch", 0x2C02);
define("HUITP_MSGID_uni_hsmmp_set_switch_ack", 0x2C82);
define("HUITP_MSGID_uni_hsmmp_set_modbus_address", 0x2C03);
define("HUITP_MSGID_uni_hsmmp_set_modbus_address_ack", 0x2C83);
define("HUITP_MSGID_uni_hsmmp_set_work_cycle", 0x2C04); //In second
define("HUITP_MSGID_uni_hsmmp_set_work_cycle_ack", 0x2C84);
define("HUITP_MSGID_uni_hsmmp_set_sample_cycle", 0x2C05);  //In second
define("HUITP_MSGID_uni_hsmmp_set_sample_cycle_ack", 0x2C85);
define("HUITP_MSGID_uni_hsmmp_set_sample_number", 0x2C06);
define("HUITP_MSGID_uni_hsmmp_set_sample_number_ack", 0x2C86);
define("HUITP_MSGID_uni_hsmmp_read_switch", 0x2C07);
define("HUITP_MSGID_uni_hsmmp_read_switch_ack", 0x2C87);
define("HUITP_MSGID_uni_hsmmp_read_modbus_address", 0x2C08);
define("HUITP_MSGID_uni_hsmmp_read_modbus_address_ack", 0x2C88);
define("HUITP_MSGID_uni_hsmmp_read_work_cycle", 0x2C09); //In second
define("HUITP_MSGID_uni_hsmmp_read_work_cycle_ack", 0x2C89);
define("HUITP_MSGID_uni_hsmmp_read_sample_cycle", 0x2C0A);  //In second
define("HUITP_MSGID_uni_hsmmp_read_sample_cycle_ack", 0x2C8A);
define("HUITP_MSGID_uni_hsmmp_read_sample_number", 0x2C0B);
define("HUITP_MSGID_uni_hsmmp_read_sample_number_ack", 0x2C8B);

//声音
define("HUITP_MSGID_uni_audio_min", 0x2D00);
define("HUITP_MSGID_uni_audio_data_req", 0x2D00);
define("HUITP_MSGID_uni_audio_data_resp", 0x2D80);
define("HUITP_MSGID_uni_audio_data_report", 0x2D81);
define("HUITP_MSGID_uni_audio_data_cfm", 0x2D01);
define("HUITP_MSGID_uni_audio_set_switch", 0x2D02);
define("HUITP_MSGID_uni_audio_set_switch_ack", 0x2D82);
define("HUITP_MSGID_uni_audio_set_modbus_address", 0x2D03);
define("HUITP_MSGID_uni_audio_set_modbus_address_ack", 0x2D83);
define("HUITP_MSGID_uni_audio_set_work_cycle", 0x2D04); //In second
define("HUITP_MSGID_uni_audio_set_work_cycle_ack", 0x2D84);
define("HUITP_MSGID_uni_audio_set_sample_cycle", 0x2D05);  //In second
define("HUITP_MSGID_uni_audio_set_sample_cycle_ack", 0x2D85);
define("HUITP_MSGID_uni_audio_set_sample_number", 0x2D06);
define("HUITP_MSGID_uni_audio_set_sample_number_ack", 0x2D86);
define("HUITP_MSGID_uni_audio_read_switch", 0x2D07);
define("HUITP_MSGID_uni_audio_read_switch_ack", 0x2D87);
define("HUITP_MSGID_uni_audio_read_modbus_address", 0x2D08);
define("HUITP_MSGID_uni_audio_read_modbus_address_ack", 0x2D88);
define("HUITP_MSGID_uni_audio_read_work_cycle", 0x2D09); //In second
define("HUITP_MSGID_uni_audio_read_work_cycle_ack", 0x2D89);
define("HUITP_MSGID_uni_audio_read_sample_cycle", 0x2D0A);  //In second
define("HUITP_MSGID_uni_audio_read_sample_cycle_ack", 0x2D8A);
define("HUITP_MSGID_uni_audio_read_sample_number", 0x2D0B);
define("HUITP_MSGID_uni_audio_read_sample_number_ack", 0x2D8B);

//视频
define("HUITP_MSGID_uni_video_min", 0x2E00);
define("HUITP_MSGID_uni_video_data_req", 0x2E00);
define("HUITP_MSGID_uni_video_data_resp", 0x2E80);
define("HUITP_MSGID_uni_video_data_report", 0x2E81);
define("HUITP_MSGID_uni_video_data_cfm", 0x2E01);
define("HUITP_MSGID_uni_video_set_switch", 0x2E02);
define("HUITP_MSGID_uni_video_set_switch_ack", 0x2E82);
define("HUITP_MSGID_uni_video_set_modbus_address", 0x2E03);
define("HUITP_MSGID_uni_video_set_modbus_address_ack", 0x2E83);
define("HUITP_MSGID_uni_video_set_work_cycle", 0x2E04); //In second
define("HUITP_MSGID_uni_video_set_work_cycle_ack", 0x2E84);
define("HUITP_MSGID_uni_video_set_sample_cycle", 0x2E05);  //In second
define("HUITP_MSGID_uni_video_set_sample_cycle_ack", 0x2E85);
define("HUITP_MSGID_uni_video_set_sample_number", 0x2E06);
define("HUITP_MSGID_uni_video_set_sample_number_ack", 0x2E86);
define("HUITP_MSGID_uni_video_read_switch", 0x2E07);
define("HUITP_MSGID_uni_video_read_switch_ack", 0x2E87);
define("HUITP_MSGID_uni_video_read_modbus_address", 0x2E08);
define("HUITP_MSGID_uni_video_read_modbus_address_ack", 0x2E88);
define("HUITP_MSGID_uni_video_read_work_cycle", 0x2E09); //In second
define("HUITP_MSGID_uni_video_read_work_cycle_ack", 0x2E89);
define("HUITP_MSGID_uni_video_read_sample_cycle", 0x2E0A);  //In second
define("HUITP_MSGID_uni_video_read_sample_cycle_ack", 0x2E8A);
define("HUITP_MSGID_uni_video_read_sample_number", 0x2E0B);
define("HUITP_MSGID_uni_video_read_sample_number_ack", 0x2E8B);

//图片
define("HUITP_MSGID_uni_picture_min", 0x2F00);
define("HUITP_MSGID_uni_picture_data_req", 0x2F00);
define("HUITP_MSGID_uni_picture_data_resp", 0x2F80);
define("HUITP_MSGID_uni_picture_data_report", 0x2F81);
define("HUITP_MSGID_uni_picture_data_cfm", 0x2F01);
define("HUITP_MSGID_uni_picture_set_switch", 0x2F02);
define("HUITP_MSGID_uni_picture_set_switch_ack", 0x2F82);
define("HUITP_MSGID_uni_picture_set_modbus_address", 0x2F03);
define("HUITP_MSGID_uni_picture_set_modbus_address_ack", 0x2F83);
define("HUITP_MSGID_uni_picture_set_work_cycle", 0x2F04); //In second
define("HUITP_MSGID_uni_picture_set_work_cycle_ack", 0x2F84);
define("HUITP_MSGID_uni_picture_set_sample_cycle", 0x2F05);  //In second
define("HUITP_MSGID_uni_picture_set_sample_cycle_ack", 0x2F85);
define("HUITP_MSGID_uni_picture_set_sample_number", 0x2F06);
define("HUITP_MSGID_uni_picture_set_sample_number_ack", 0x2F86);
define("HUITP_MSGID_uni_picture_read_switch", 0x2F07);
define("HUITP_MSGID_uni_picture_read_switch_ack", 0x2F87);
define("HUITP_MSGID_uni_picture_read_modbus_address", 0x2F08);
define("HUITP_MSGID_uni_picture_read_modbus_address_ack", 0x2F88);
define("HUITP_MSGID_uni_picture_read_work_cycle", 0x2F09); //In second
define("HUITP_MSGID_uni_picture_read_work_cycle_ack", 0x2F89);
define("HUITP_MSGID_uni_picture_read_sample_cycle", 0x2F0A);  //In second
define("HUITP_MSGID_uni_picture_read_sample_cycle_ack", 0x2F8A);
define("HUITP_MSGID_uni_picture_read_sample_number", 0x2F0B);
define("HUITP_MSGID_uni_picture_read_sample_number_ack", 0x2F8B);

//扬尘监控系统
define("HUITP_MSGID_uni_ycjk_min", 0x3000);
define("HUITP_MSGID_uni_ycjk_req", 0x3000);
define("HUITP_MSGID_uni_ycjk_resp", 0x3080);
define("HUITP_MSGID_uni_ycjk_report", 0x3081);
define("HUITP_MSGID_uni_ycjk_cfm", 0x3001);

//水表
define("HUITP_MSGID_uni_water_meter_min", 0x3100);
define("HUITP_MSGID_uni_water_meter_req", 0x3100);
define("HUITP_MSGID_uni_water_meter_resp", 0x3180);
define("HUITP_MSGID_uni_water_meter_report", 0x3181);
define("HUITP_MSGID_uni_water_meter_cfm", 0x3101);

//热表
define("HUITP_MSGID_uni_heat_meter_min", 0x3200);
define("HUITP_MSGID_uni_heat_meter_req", 0x3200);
define("HUITP_MSGID_uni_heat_meter_resp", 0x3280);
define("HUITP_MSGID_uni_heat_meter_report", 0x3281);
define("HUITP_MSGID_uni_heat_meter_cfm", 0x3201);

//气表
define("HUITP_MSGID_uni_gas_meter_min", 0x3300);
define("HUITP_MSGID_uni_gas_meter_req", 0x3300);
define("HUITP_MSGID_uni_gas_meter_resp", 0x3380);
define("HUITP_MSGID_uni_gas_meter_report", 0x3381);
define("HUITP_MSGID_uni_gas_meter_cfm", 0x3301);

//电表
define("HUITP_MSGID_uni_power_meter_min", 0x3400);
define("HUITP_MSGID_uni_power_meter_req", 0x3400);
define("HUITP_MSGID_uni_power_meter_resp", 0x3480);
define("HUITP_MSGID_uni_power_meter_report", 0x3481);
define("HUITP_MSGID_uni_power_meter_cfm", 0x3401);

//光照强度
define("HUITP_MSGID_uni_light_strength_min", 0x3500);
define("HUITP_MSGID_uni_light_strength_req", 0x3500);
define("HUITP_MSGID_uni_light_strength_resp", 0x3580);
define("HUITP_MSGID_uni_light_strength_report", 0x3581);
define("HUITP_MSGID_uni_light_strength_cfm", 0x3501);

//有毒气体VOC
define("HUITP_MSGID_uni_toxicgas_min", 0x3600);
define("HUITP_MSGID_uni_toxicgas_req", 0x3600);
define("HUITP_MSGID_uni_toxicgas_resp", 0x3680);
define("HUITP_MSGID_uni_toxicgas_report", 0x3681);
define("HUITP_MSGID_uni_toxicgas_cfm", 0x3601);

//海拔高度
define("HUITP_MSGID_uni_altitude_min", 0x3700);
define("HUITP_MSGID_uni_altitude_req", 0x3700);
define("HUITP_MSGID_uni_altitude_resp", 0x3780);
define("HUITP_MSGID_uni_altitude_report", 0x3781);
define("HUITP_MSGID_uni_altitude_cfm", 0x3701);

//马达
define("HUITP_MSGID_uni_moto_min", 0x3800);
define("HUITP_MSGID_uni_moto_req", 0x3800);
define("HUITP_MSGID_uni_moto_resp", 0x3880);
define("HUITP_MSGID_uni_moto_report", 0x3881);
define("HUITP_MSGID_uni_moto_cfm", 0x3801);

//继电器
define("HUITP_MSGID_uni_switch_min", 0x3900);
define("HUITP_MSGID_uni_switch_req", 0x3900);
define("HUITP_MSGID_uni_switch_resp", 0x3980);
define("HUITP_MSGID_uni_switch_report", 0x3981);
define("HUITP_MSGID_uni_switch_cfm", 0x3901);

//导轨传送带
define("HUITP_MSGID_uni_transporter_min", 0x3A00);
define("HUITP_MSGID_uni_transporter_req", 0x3A00);
define("HUITP_MSGID_uni_transporter_resp", 0x3A80);
define("HUITP_MSGID_uni_transporter_report", 0x3A81);
define("HUITP_MSGID_uni_transporter_cfm", 0x3A01);

//组合秤BFSC
define("HUITP_MSGID_uni_bfsc_comb_scale_min", 0x3B00);
define("HUITP_MSGID_uni_bfsc_comb_scale_req", 0x3B00);
define("HUITP_MSGID_uni_bfsc_comb_scale_resp", 0x3B80);
define("HUITP_MSGID_uni_bfsc_comb_scale_report", 0x3B81);
define("HUITP_MSGID_uni_bfsc_comb_scale_cfm", 0x3B01);
define("HUITP_MSGID_uni_bfsc_comb_scale_cmd_start_req", 0x3B02);
define("HUITP_MSGID_uni_bfsc_comb_scale_cmd_start_resp", 0x3B82);
define("HUITP_MSGID_uni_bfsc_comb_scale_cmd_stop_req", 0x3B03);
define("HUITP_MSGID_uni_bfsc_comb_scale_cmd_stop_resp", 0x3B83);

//云控锁-锁-旧系统兼容
define("HUITP_MSGID_uni_ccl_lock_old_min", 0x4000);
define("HUITP_MSGID_uni_ccl_lock_old_req", 0x4000);
define("HUITP_MSGID_uni_ccl_lock_old_resp", 0x4080);
define("HUITP_MSGID_uni_ccl_lock_old_report", 0x4081);
define("HUITP_MSGID_uni_ccl_lock_old_confirm", 0x4001);
define("HUITP_MSGID_uni_ccl_lock_old_auth_inq", 0x4090);
define("HUITP_MSGID_uni_ccl_lock_old_auth_resp", 0x4010);

//云控锁-门
define("HUITP_MSGID_uni_ccl_door_min", 0x4100);
define("HUITP_MSGID_uni_ccl_door_req", 0x4100);
define("HUITP_MSGID_uni_ccl_door_resp", 0x4180);
define("HUITP_MSGID_uni_ccl_door_report", 0x4181);
define("HUITP_MSGID_uni_ccl_door_cfm", 0x4101);

//云控锁-RFID模块
define("HUITP_MSGID_uni_ccl_rfid_min", 0x4200);
define("HUITP_MSGID_uni_ccl_rfid_req", 0x4200);
define("HUITP_MSGID_uni_ccl_rfid_resp", 0x4280);
define("HUITP_MSGID_uni_ccl_rfid_report", 0x4281);
define("HUITP_MSGID_uni_ccl_rfid_cfm", 0x4201);

//云控锁-BLE模块
define("HUITP_MSGID_uni_ccl_ble_min", 0x4300);
define("HUITP_MSGID_uni_ccl_ble_req", 0x4300);
define("HUITP_MSGID_uni_ccl_ble_resp", 0x4380);
define("HUITP_MSGID_uni_ccl_ble_report", 0x4381);
define("HUITP_MSGID_uni_ccl_ble_cfm", 0x4301);

//云控锁-GPRS模块
define("HUITP_MSGID_uni_ccl_gprs_min", 0x4400);
define("HUITP_MSGID_uni_ccl_gprs_req", 0x4400);
define("HUITP_MSGID_uni_ccl_gprs_resp", 0x4480);
define("HUITP_MSGID_uni_ccl_gprs_report", 0x4481);
define("HUITP_MSGID_uni_ccl_gprs_cfm", 0x4401);

//云控锁-电池模块
define("HUITP_MSGID_uni_ccl_battery_min", 0x4500);
define("HUITP_MSGID_uni_ccl_battery_req", 0x4500);
define("HUITP_MSGID_uni_ccl_battery_resp", 0x4580);
define("HUITP_MSGID_uni_ccl_battery_report", 0x4581);
define("HUITP_MSGID_uni_ccl_battery_cfm", 0x4501);

//云控锁-震动
define("HUITP_MSGID_uni_ccl_shake_min", 0x4600);
define("HUITP_MSGID_uni_ccl_shake_req", 0x4600);
define("HUITP_MSGID_uni_ccl_shake_resp", 0x4680);
define("HUITP_MSGID_uni_ccl_shake_report", 0x4681);
define("HUITP_MSGID_uni_ccl_shake_cfm", 0x4601);

//云控锁-烟雾
define("HUITP_MSGID_uni_ccl_smoke_min", 0x4700);
define("HUITP_MSGID_uni_ccl_smoke_req", 0x4700);
define("HUITP_MSGID_uni_ccl_smoke_resp", 0x4780);
define("HUITP_MSGID_uni_ccl_smoke_report", 0x4781);
define("HUITP_MSGID_uni_ccl_smoke_cfm", 0x4701);

//云控锁-水浸
define("HUITP_MSGID_uni_ccl_water_min", 0x4800);
define("HUITP_MSGID_uni_ccl_water_req", 0x4800);
define("HUITP_MSGID_uni_ccl_water_resp", 0x4880);
define("HUITP_MSGID_uni_ccl_water_report", 0x4881);
define("HUITP_MSGID_uni_ccl_water_cfm", 0x4801);

//云控锁-温度
define("HUITP_MSGID_uni_ccl_temp_min", 0x4900);
define("HUITP_MSGID_uni_ccl_temp_req", 0x4900);
define("HUITP_MSGID_uni_ccl_temp_resp", 0x4980);
define("HUITP_MSGID_uni_ccl_temp_report", 0x4981);
define("HUITP_MSGID_uni_ccl_temp_cfm", 0x4901);

//云控锁-湿度
define("HUITP_MSGID_uni_ccl_humid_min", 0x4A00);
define("HUITP_MSGID_uni_ccl_humid_req", 0x4A00);
define("HUITP_MSGID_uni_ccl_humid_resp", 0x4A80);
define("HUITP_MSGID_uni_ccl_humid_report", 0x4A81);
define("HUITP_MSGID_uni_ccl_humid_cfm", 0x4A01);

//云控锁-倾倒
define("HUITP_MSGID_uni_ccl_fall_min", 0x4B00);
define("HUITP_MSGID_uni_ccl_fall_req", 0x4B00);
define("HUITP_MSGID_uni_ccl_fall_resp", 0x4B80);
define("HUITP_MSGID_uni_ccl_fall_report", 0x4B81);
define("HUITP_MSGID_uni_ccl_fall_cfm", 0x4B01);

//云控锁-状态聚合-旧系统兼容
define("HUITP_MSGID_uni_ccl_state_old_min", 0x4C00);
define("HUITP_MSGID_uni_ccl_state_old_req", 0x4C00);
define("HUITP_MSGID_uni_ccl_state_old_resp", 0x4C80);
define("HUITP_MSGID_uni_ccl_state_old_report", 0x4C81);
define("HUITP_MSGID_uni_ccl_state_old_confirm", 0x4C01);
define("HUITP_MSGID_uni_ccl_state_old_pic_report", 0x4C82);
define("HUITP_MSGID_uni_ccl_state_old_pic_confirm", 0x4C02);

//云控锁-锁
define("HUITP_MSGID_uni_ccl_lock_min", 0x4D00);
define("HUITP_MSGID_uni_ccl_lock_req", 0x4D00);
define("HUITP_MSGID_uni_ccl_lock_resp", 0x4D80);
define("HUITP_MSGID_uni_ccl_lock_report", 0x4D81);
define("HUITP_MSGID_uni_ccl_lock_confirm", 0x4D01);
define("HUITP_MSGID_uni_ccl_lock_auth_inq", 0x4D90);
define("HUITP_MSGID_uni_ccl_lock_auth_resp", 0x4D10);

//云控锁-状态聚合
define("HUITP_MSGID_uni_ccl_state_min", 0x4E00);
define("HUITP_MSGID_uni_ccl_state_req", 0x4E00);
define("HUITP_MSGID_uni_ccl_state_resp", 0x4E80);
define("HUITP_MSGID_uni_ccl_state_report", 0x4E81);
define("HUITP_MSGID_uni_ccl_state_confirm", 0x4E01);
define("HUITP_MSGID_uni_ccl_state_pic_report", 0x4E82);
define("HUITP_MSGID_uni_ccl_state_pic_confirm", 0x4E02);

//串口读取命令/返回结果
define("HUITP_MSGID_uni_itf_sps_min", 0x5000);
define("HUITP_MSGID_uni_itf_sps_req", 0x5000);
define("HUITP_MSGID_uni_itf_sps_resp", 0x5080);
define("HUITP_MSGID_uni_itf_sps_report", 0x5001);
define("HUITP_MSGID_uni_itf_sps_cfm", 0x5081);

//ADC读取命令/返回结果
define("HUITP_MSGID_uni_itf_adc_min", 0x5100);
define("HUITP_MSGID_uni_itf_adc_req", 0x5100);
define("HUITP_MSGID_uni_itf_adc_resp", 0x5180);
define("HUITP_MSGID_uni_itf_adc_report", 0x5181);
define("HUITP_MSGID_uni_itf_adc_cfm", 0x5101);

//DAC读取命令/返回结果
define("HUITP_MSGID_uni_itf_dac_min", 0x5200);
define("HUITP_MSGID_uni_itf_dac_req", 0x5200);
define("HUITP_MSGID_uni_itf_dac_resp", 0x5280);
define("HUITP_MSGID_uni_itf_dac_report", 0x5281);
define("HUITP_MSGID_uni_itf_dac_cfm", 0x5201);

//I2C读取命令/返回结果
define("HUITP_MSGID_uni_itf_i2c_min", 0x5300);
define("HUITP_MSGID_uni_itf_i2c_req", 0x5300);
define("HUITP_MSGID_uni_itf_i2c_resp", 0x5380);
define("HUITP_MSGID_uni_itf_i2c_report", 0x5381);
define("HUITP_MSGID_uni_itf_i2c_cfm", 0x5301);

//PWM读取命令/返回结果
define("HUITP_MSGID_uni_itf_pwm_min", 0x5400);
define("HUITP_MSGID_uni_itf_pwm_req", 0x5400);
define("HUITP_MSGID_uni_itf_pwm_resp", 0x5480);
define("HUITP_MSGID_uni_itf_pwm_report", 0x5481);
define("HUITP_MSGID_uni_itf_pwm_cfm", 0x5401);

//DI读取命令/返回结果
define("HUITP_MSGID_uni_itf_di_min", 0x5500);
define("HUITP_MSGID_uni_itf_di_req", 0x5500);
define("HUITP_MSGID_uni_itf_di_resp", 0x5580);
define("HUITP_MSGID_uni_itf_di_report", 0x5581);
define("HUITP_MSGID_uni_itf_di_cfm", 0x5501);

//DO读取命令/返回结果
define("HUITP_MSGID_uni_itf_do_min", 0x5600);
define("HUITP_MSGID_uni_itf_do_req", 0x5600);
define("HUITP_MSGID_uni_itf_do_resp", 0x5680);
define("HUITP_MSGID_uni_itf_do_report", 0x5681);
define("HUITP_MSGID_uni_itf_do_cfm", 0x5601);

//CAN读取命令/返回结果
define("HUITP_MSGID_uni_itf_can_min", 0x5700);
define("HUITP_MSGID_uni_itf_can_req", 0x5700);
define("HUITP_MSGID_uni_itf_can_resp", 0x5780);
define("HUITP_MSGID_uni_itf_can_report", 0x5781);
define("HUITP_MSGID_uni_itf_can_cfm", 0x5701);

//SPI读取命令/返回结果
define("HUITP_MSGID_uni_itf_spi_min", 0x5800);
define("HUITP_MSGID_uni_itf_spi_req", 0x5800);
define("HUITP_MSGID_uni_itf_spi_resp", 0x5880);
define("HUITP_MSGID_uni_itf_spi_report", 0x5881);
define("HUITP_MSGID_uni_itf_spi_cfm", 0x5801);

//USB读取命令/返回结果
define("HUITP_MSGID_uni_itf_usb_min", 0x5900);
define("HUITP_MSGID_uni_itf_usb_req", 0x5900);
define("HUITP_MSGID_uni_itf_usb_resp", 0x5980);
define("HUITP_MSGID_uni_itf_usb_report", 0x5981);
define("HUITP_MSGID_uni_itf_usb_cfm", 0x5901);

//网口读取命令/返回结果
define("HUITP_MSGID_uni_itf_eth_min", 0x5A00);
define("HUITP_MSGID_uni_itf_eth_req", 0x5A00);
define("HUITP_MSGID_uni_itf_eth_resp", 0x5A80);
define("HUITP_MSGID_uni_itf_eth_report", 0x5A81);
define("HUITP_MSGID_uni_itf_eth_cfm", 0x5A01);

//485读取命令/返回结果
define("HUITP_MSGID_uni_itf_485_min", 0x5B00);
define("HUITP_MSGID_uni_itf_485_req", 0x5B00);
define("HUITP_MSGID_uni_itf_485_resp", 0x5B80);
define("HUITP_MSGID_uni_itf_485_report", 0x5B81);
define("HUITP_MSGID_uni_itf_485_cfm", 0x5B01);

//软件清单
define("HUITP_MSGID_uni_inventory_min", 0xA000);
define("HUITP_MSGID_uni_inventory_req", 0xA000);
define("HUITP_MSGID_uni_inventory_resp", 0xA080);
define("HUITP_MSGID_uni_inventory_report", 0xA081);
define("HUITP_MSGID_uni_inventory_cfm", 0xA001);

//软件版本体
define("HUITP_MSGID_uni_sw_package_min", 0xA100);
define("HUITP_MSGID_uni_sw_package_req", 0xA100);
define("HUITP_MSGID_uni_sw_package_resp", 0xA180);
define("HUITP_MSGID_uni_sw_package_report", 0xA181);
define("HUITP_MSGID_uni_sw_package_cfm", 0xA101);

//ALARM REPORT
define("HUITP_MSGID_uni_alarm_info_min", 0xB000);
define("HUITP_MSGID_uni_alarm_info_req", 0xB000);
define("HUITP_MSGID_uni_alarm_info_resp", 0xB080);
define("HUITP_MSGID_uni_alarm_info_report", 0xB081);
define("HUITP_MSGID_uni_alarm_info_cfm", 0xB001);

//PM Report
define("HUITP_MSGID_uni_performance_info_min", 0xB100);
define("HUITP_MSGID_uni_performance_info_req", 0xB100);
define("HUITP_MSGID_uni_performance_info_resp", 0xB180);
define("HUITP_MSGID_uni_performance_info_report", 0xB181);
define("HUITP_MSGID_uni_performance_info_cfm", 0xB101);

//设备基本信息
define("HUITP_MSGID_uni_equipment_info_min", 0xF000);
define("HUITP_MSGID_uni_equipment_info_req", 0xF000);
define("HUITP_MSGID_uni_equipment_info_resp", 0xF080);
define("HUITP_MSGID_uni_equipment_info_report", 0xF081);
define("HUITP_MSGID_uni_equipment_info_cfm", 0xF001);

//个人基本信息
define("HUITP_MSGID_uni_personal_info_min", 0xF100);
define("HUITP_MSGID_uni_personal_info_req", 0xF100);
define("HUITP_MSGID_uni_personal_info_resp", 0xF180);
define("HUITP_MSGID_uni_personal_info_report", 0xF181);
define("HUITP_MSGID_uni_personal_info_cfm", 0xF101);

//时间同步
define("HUITP_MSGID_uni_time_sync_min", 0xF200);
define("HUITP_MSGID_uni_time_sync_req", 0xF200);
define("HUITP_MSGID_uni_time_sync_resp", 0xF280);
define("HUITP_MSGID_uni_time_sync_report", 0xF281);
define("HUITP_MSGID_uni_time_sync_cfm", 0xF201);

//读取数据
define("HUITP_MSGID_uni_general_read_data_min", 0xF300);
define("HUITP_MSGID_uni_general_read_data_req", 0xF300);
define("HUITP_MSGID_uni_general_read_data_resp", 0xF380);
define("HUITP_MSGID_uni_general_read_data_report", 0xF381);
define("HUITP_MSGID_uni_general_read_data_cfm", 0xF301);

//定时闹钟及久坐提醒
define("HUITP_MSGID_uni_clock_timeout_min", 0xF400);
define("HUITP_MSGID_uni_clock_timeout_req", 0xF400);
define("HUITP_MSGID_uni_clock_timeout_resp", 0xF480);
define("HUITP_MSGID_uni_clock_timeout_report", 0xF481);
define("HUITP_MSGID_uni_clock_timeout_cfm", 0xF401);

//同步充电，双击情况
define("HUITP_MSGID_uni_sync_charging_min", 0xF500);
define("HUITP_MSGID_uni_sync_charging_req", 0xF500);
define("HUITP_MSGID_uni_sync_charging_resp", 0xF580);
define("HUITP_MSGID_uni_sync_charging_report", 0xF581);
define("HUITP_MSGID_uni_sync_charging_cfm", 0xF501);

//同步通知信息
define("HUITP_MSGID_uni_sync_trigger_min", 0xF600);
define("HUITP_MSGID_uni_sync_trigger_req", 0xF600);
define("HUITP_MSGID_uni_sync_trigger_resp", 0xF680);
define("HUITP_MSGID_uni_sync_trigger_report", 0xF681);
define("HUITP_MSGID_uni_sync_trigger_cfm", 0xF601);

//CMD CONTROL
define("HUITP_MSGID_uni_cmd_ctrl_min", 0xFD00);
define("HUITP_MSGID_uni_cmd_ctrl_req", 0xFD00);
define("HUITP_MSGID_uni_cmd_ctrl_resp", 0xFD80);
define("HUITP_MSGID_uni_cmd_ctrl_report", 0xFD81);
define("HUITP_MSGID_uni_cmd_ctrl_cfm", 0xFD01);

//心跳
define("HUITP_MSGID_uni_heart_beat_min", 0xFE00);
define("HUITP_MSGID_uni_heart_beat_req", 0xFE00);
define("HUITP_MSGID_uni_heart_beat_resp", 0xFE80);
define("HUITP_MSGID_uni_heart_beat_report", 0xFE81);
define("HUITP_MSGID_uni_heart_beat_cfm", 0xFE01);

//无效
define("HUITP_MSGID_uni_max", 0xFEFF);
define("HUITP_MSGID_uni_null", 0xFFFF);




?>