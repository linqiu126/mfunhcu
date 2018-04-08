<?php
/**
 * Created by PhpStorm.
 * User: Zehong Liu
 * Date: 2017/1/22
 * Time: 15:51
 */

/***********************************************************************************************************************
 *                                                   HUITP接口协议v2.2
 **********************************************************************************************************************/


/***********************************************HUITP公共参数***********************************************************/
define("MFUN_HUITP_MSG_HEAD_FORMAT", "A4MsgId/A4MsgLen"); //2B MsgId and 2B MsgLen
define("MFUN_HUITP_MSG_HEAD_LENGTH", 8); //2B MsgId(1B CmdId+1B OptId),2B Len
define("MFUN_HUITP_IE_HEAD_LENGTH", 8); //2B IE Id,2B IE Len
define("MFUN_HUITP_IEID_LENGTH", 4);  //ieId 2Byte
define("MFUN_HUITP_IELEN_LENGTH", 4); //ieLen 2Byte
define("MFUN_HUITP_IELEN_1B", 2); //1Byte
define("MFUN_HUITP_IELEN_2B", 4); //2Byte
define("MFUN_HUITP_IELEN_4B", 8); //4Byte

define("HUITP_IEID_UNI_CCL_LOCK_MAX_NUMBER", 4); //最多支持4把锁
define("HUITP_IEID_UNI_CCL_GEN_PIC_ID_LEN_MAX", 32);
define("HUITP_IEID_UNI_FDWQ_GEN_RFID_ID_LEN_MAX", 16);
define("HUITP_IEID_UNI_FDWQ_GEN_NAME_LEN_MAX", 20);

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
define("HUITP_MSGID_uni_none",  0x0000);
define("HUITP_MSGID_uni_min",  0x0100);

//血糖
define("HUITP_MSGID_uni_blood_glucose_min",  0x0100);
define("HUITP_MSGID_uni_blood_glucose_req",  0x0100);
define("HUITP_MSGID_uni_blood_glucose_resp",  0x0180);
define("HUITP_MSGID_uni_blood_glucose_report",  0x0181);
define("HUITP_MSGID_uni_blood_glucose_confirm",  0x0101);

//单次运动
define("HUITP_MSGID_uni_single_sports_min",  0x0200);
define("HUITP_MSGID_uni_single_sports_req",  0x0200);
define("HUITP_MSGID_uni_single_sports_resp",  0x0280);
define("HUITP_MSGID_uni_single_sports_report",  0x0281);
define("HUITP_MSGID_uni_single_sports_confirm",  0x0201);

//单次睡眠
define("HUITP_MSGID_uni_single_sleep_min",  0x0300);
define("HUITP_MSGID_uni_single_sleep_req",  0x0300);
define("HUITP_MSGID_uni_single_sleep_resp",  0x0380);
define("HUITP_MSGID_uni_single_sleep_report",  0x0381);
define("HUITP_MSGID_uni_single_sleep_confirm",  0x0301);

//体脂
define("HUITP_MSGID_uni_body_fat_min",  0x0400);
define("HUITP_MSGID_uni_body_fat_req",  0x0400);
define("HUITP_MSGID_uni_body_fat_resp",  0x0480);
define("HUITP_MSGID_uni_body_fat_report",  0x0481);
define("HUITP_MSGID_uni_body_fat_confirm",  0x0401);

//血压
define("HUITP_MSGID_uni_blood_pressure_min",  0x0500);
define("HUITP_MSGID_uni_blood_pressure_req",  0x0500);
define("HUITP_MSGID_uni_blood_pressure_resp",  0x0580);
define("HUITP_MSGID_uni_blood_pressure_report",  0x0581);
define("HUITP_MSGID_uni_blood_pressure_confirm",  0x0501);

//跑步机数据上报
define("HUITP_MSGID_uni_runner_machine_rep_min",  0x0A00);
define("HUITP_MSGID_uni_runner_machine_rep_req",  0x0A00);
define("HUITP_MSGID_uni_runner_machine_rep_resp",  0x0A80);
define("HUITP_MSGID_uni_runner_machine_rep_report",  0x0A81);
define("HUITP_MSGID_uni_runner_machine_rep_confirm",  0x0A01);

//跑步机任务控制
define("HUITP_MSGID_uni_runner_machine_ctrl_min",  0x0B00);
define("HUITP_MSGID_uni_runner_machine_ctrl_req",  0x0B00);
define("HUITP_MSGID_uni_runner_machine_ctrl_resp",  0x0B80);
define("HUITP_MSGID_uni_runner_machine_ctrl_report",  0x0B81);
define("HUITP_MSGID_uni_runner_machine_ctrl_confirm",  0x0B01);

//GPS地址
define("HUITP_MSGID_uni_gps_specific_min",  0x0C00);
define("HUITP_MSGID_uni_gps_specific_req",  0x0C00);
define("HUITP_MSGID_uni_gps_specific_resp",  0x0C80);
define("HUITP_MSGID_uni_gps_specific_report",  0x0C81);
define("HUITP_MSGID_uni_gps_specific_confirm",  0x0C01);

//IHU与IAU之间控制命令
define("HUITP_MSGID_uni_iau_ctrl_min",  0x1000);
define("HUITP_MSGID_uni_iau_ctrl_req",  0x1000);
define("HUITP_MSGID_uni_iau_ctrl_resp",  0x1080);
define("HUITP_MSGID_uni_iau_ctrl_report",  0x1081);
define("HUITP_MSGID_uni_iau_ctrl_confirm",  0x1001);

//电磁辐射强度
define("HUITP_MSGID_uni_emc_data_min",  0x2000);
define("HUITP_MSGID_uni_emc_data_req",  0x2000);
define("HUITP_MSGID_uni_emc_data_resp",  0x2080);
define("HUITP_MSGID_uni_emc_data_report",  0x2081);
define("HUITP_MSGID_uni_emc_data_confirm",  0x2001);
define("HUITP_MSGID_uni_emc_ctrl_req",  0x2002);
define("HUITP_MSGID_uni_emc_ctrl_resp",  0x2082);

//电磁辐射剂量
define("HUITP_MSGID_uni_emc_accu_min",  0x2100);
define("HUITP_MSGID_uni_emc_accu_req",  0x2100);
define("HUITP_MSGID_uni_emc_accu_resp",  0x2180);
define("HUITP_MSGID_uni_emc_accu_report",  0x2181);
define("HUITP_MSGID_uni_emc_accu_confirm",  0x2101);

//一氧化碳
define("HUITP_MSGID_uni_co1_min",  0x2200);
define("HUITP_MSGID_uni_co1_data_req",  0x2200);
define("HUITP_MSGID_uni_co1_data_resp",  0x2280);
define("HUITP_MSGID_uni_co1_data_report",  0x2281);
define("HUITP_MSGID_uni_co1_data_confirm",  0x2201);

//甲醛HCHO
define("HUITP_MSGID_uni_hcho_min",  0x2300);
define("HUITP_MSGID_uni_hcho_data_req",  0x2300);
define("HUITP_MSGID_uni_hcho_data_resp",  0x2380);
define("HUITP_MSGID_uni_hcho_data_report",  0x2381);
define("HUITP_MSGID_uni_hcho_data_confirm",  0x2301);

//酒精
define("HUITP_MSGID_uni_alcohol_min",  0x2400);
define("HUITP_MSGID_uni_alcohol_data_req",  0x2400);
define("HUITP_MSGID_uni_alcohol_data_resp",  0x2480);
define("HUITP_MSGID_uni_alcohol_data_report",  0x2481);
define("HUITP_MSGID_uni_alcohol_data_confirm",  0x2401);

//PM1/2.5/10
define("HUITP_MSGID_uni_pm25_min",  0x2500);
define("HUITP_MSGID_uni_pm25_data_req",  0x2500);
define("HUITP_MSGID_uni_pm25_data_resp",  0x2580);
define("HUITP_MSGID_uni_pm25_data_report",  0x2581);
define("HUITP_MSGID_uni_pm25_data_confirm",  0x2501);
define("HUITP_MSGID_uni_pm25_ctrl_req",  0x2502);
define("HUITP_MSGID_uni_pm25_ctrl_resp",  0x2582);
define("HUITP_MSGID_uni_pm25sp_data_req",  0x2503);
define("HUITP_MSGID_uni_pm25sp_data_resp",  0x2583);
define("HUITP_MSGID_uni_pm25sp_data_report",  0x2504);
define("HUITP_MSGID_uni_pm25sp_data_confirm",  0x2584);

//风速Wind Speed
define("HUITP_MSGID_uni_windspd_min",  0x2600);
define("HUITP_MSGID_uni_windspd_data_req",  0x2600);
define("HUITP_MSGID_uni_windspd_data_resp",  0x2680);
define("HUITP_MSGID_uni_windspd_data_report",  0x2681);
define("HUITP_MSGID_uni_windspd_data_confirm",  0x2601);
define("HUITP_MSGID_uni_windspd_ctrl_req",  0x2602);
define("HUITP_MSGID_uni_windspd_ctrl_resp",  0x2682);

//风向Wind Direction
define("HUITP_MSGID_uni_winddir_min",  0x2700);
define("HUITP_MSGID_uni_winddir_data_req",  0x2700);
define("HUITP_MSGID_uni_winddir_data_resp",  0x2780);
define("HUITP_MSGID_uni_winddir_data_report",  0x2781);
define("HUITP_MSGID_uni_winddir_data_confirm",  0x2701);
define("HUITP_MSGID_uni_winddir_ctrl_req",  0x2702);
define("HUITP_MSGID_uni_winddir_ctrl_resp",  0x2782);

//温度Temperature
define("HUITP_MSGID_uni_temp_min",  0x2800);
define("HUITP_MSGID_uni_temp_data_req",  0x2800);
define("HUITP_MSGID_uni_temp_data_resp",  0x2880);
define("HUITP_MSGID_uni_temp_data_report",  0x2881);
define("HUITP_MSGID_uni_temp_data_confirm",  0x2801);
define("HUITP_MSGID_uni_temp_ctrl_req",  0x2802);
define("HUITP_MSGID_uni_temp_ctrl_resp",  0x2882);

//湿度Humidity
define("HUITP_MSGID_uni_humid_min",  0x2900);
define("HUITP_MSGID_uni_humid_data_req",  0x2900);
define("HUITP_MSGID_uni_humid_data_resp",  0x2980);
define("HUITP_MSGID_uni_humid_data_report",  0x2981);
define("HUITP_MSGID_uni_humid_data_confirm",  0x2901);
define("HUITP_MSGID_uni_humid_ctrl_req",  0x2902);
define("HUITP_MSGID_uni_humid_ctrl_resp",  0x2982);

//气压Air pressure
define("HUITP_MSGID_uni_airprs_min",  0x2A00);
define("HUITP_MSGID_uni_airprs_data_req",  0x2A00);
define("HUITP_MSGID_uni_airprs_data_resp",  0x2A80);
define("HUITP_MSGID_uni_airprs_data_report",  0x2A81);
define("HUITP_MSGID_uni_airprs_data_confirm",  0x2A01);

//噪声Noise
define("HUITP_MSGID_uni_noise_min",  0x2B00);
define("HUITP_MSGID_uni_noise_data_req",  0x2B00);
define("HUITP_MSGID_uni_noise_data_resp",  0x2B80);
define("HUITP_MSGID_uni_noise_data_report",  0x2B81);
define("HUITP_MSGID_uni_noise_data_confirm",  0x2B01);
define("HUITP_MSGID_uni_noise_ctrl_req",  0x2B02);
define("HUITP_MSGID_uni_noise_ctrl_resp",  0x2B82);

//相机Camer or audio high speed
define("HUITP_MSGID_uni_hsmmp_min",  0x2C00);
define("HUITP_MSGID_uni_hsmmp_data_req",  0x2C00);
define("HUITP_MSGID_uni_hsmmp_data_resp",  0x2C80);
define("HUITP_MSGID_uni_hsmmp_data_report",  0x2C81);
define("HUITP_MSGID_uni_hsmmp_data_confirm",  0x2C01);
define("HUITP_MSGID_uni_hsmmp_ctrl_req",  0x2C02);
define("HUITP_MSGID_uni_hsmmp_ctrl_resp",  0x2C82);

//声音
define("HUITP_MSGID_uni_audio_min",  0x2D00);
define("HUITP_MSGID_uni_audio_data_req",  0x2D00);
define("HUITP_MSGID_uni_audio_data_resp",  0x2D80);
define("HUITP_MSGID_uni_audio_data_report",  0x2D81);
define("HUITP_MSGID_uni_audio_data_confirm",  0x2D01);

//视频
define("HUITP_MSGID_uni_video_min",  0x2E00);
define("HUITP_MSGID_uni_video_data_req",  0x2E00);
define("HUITP_MSGID_uni_video_data_resp",  0x2E80);
define("HUITP_MSGID_uni_video_data_report",  0x2E81);
define("HUITP_MSGID_uni_video_data_confirm",  0x2E01);

//图片
define("HUITP_MSGID_uni_picture_min",  0x2F00);
define("HUITP_MSGID_uni_picture_data_req",  0x2F00);
define("HUITP_MSGID_uni_picture_data_resp",  0x2F80);
define("HUITP_MSGID_uni_picture_data_report",  0x2F81);
define("HUITP_MSGID_uni_picture_data_confirm",  0x2F01);

//扬尘监控系统
define("HUITP_MSGID_uni_ycjk_min",  0x3000);
define("HUITP_MSGID_uni_ycjk_data_req",  0x3000);
define("HUITP_MSGID_uni_ycjk_data_resp",  0x3080);
define("HUITP_MSGID_uni_ycjk_data_report",  0x3081);
define("HUITP_MSGID_uni_ycjk_data_confirm",  0x3001);
define("HUITP_MSGID_uni_ycjk_ctrl_req",  0x3002);
define("HUITP_MSGID_uni_ycjk_ctrl_resp",  0x3082);

//水表
define("HUITP_MSGID_uni_water_meter_min",  0x3100);
define("HUITP_MSGID_uni_water_meter_req",  0x3100);
define("HUITP_MSGID_uni_water_meter_resp",  0x3180);
define("HUITP_MSGID_uni_water_meter_report",  0x3181);
define("HUITP_MSGID_uni_water_meter_confirm",  0x3101);

//热表
define("HUITP_MSGID_uni_heat_meter_min",  0x3200);
define("HUITP_MSGID_uni_heat_meter_req",  0x3200);
define("HUITP_MSGID_uni_heat_meter_resp",  0x3280);
define("HUITP_MSGID_uni_heat_meter_report",  0x3281);
define("HUITP_MSGID_uni_heat_meter_confirm",  0x3201);

//气表
define("HUITP_MSGID_uni_gas_meter_min",  0x3300);
define("HUITP_MSGID_uni_gas_meter_req",  0x3300);
define("HUITP_MSGID_uni_gas_meter_resp",  0x3380);
define("HUITP_MSGID_uni_gas_meter_report",  0x3381);
define("HUITP_MSGID_uni_gas_meter_confirm",  0x3301);

//电表
define("HUITP_MSGID_uni_power_meter_min",  0x3400);
define("HUITP_MSGID_uni_power_meter_req",  0x3400);
define("HUITP_MSGID_uni_power_meter_resp",  0x3480);
define("HUITP_MSGID_uni_power_meter_report",  0x3481);
define("HUITP_MSGID_uni_power_meter_confirm",  0x3401);

//光照强度
define("HUITP_MSGID_uni_lightstr_data_min",  0x3500);
define("HUITP_MSGID_uni_lightstr_data_req",  0x3500);
define("HUITP_MSGID_uni_lightstr_data_resp",  0x3580);
define("HUITP_MSGID_uni_lightstr_data_report",  0x3581);
define("HUITP_MSGID_uni_lightstr_data_confirm",  0x3501);

//有毒气体VOC
define("HUITP_MSGID_uni_toxicgas_data_min",  0x3600);
define("HUITP_MSGID_uni_toxicgas_data_req",  0x3600);
define("HUITP_MSGID_uni_toxicgas_data_resp",  0x3680);
define("HUITP_MSGID_uni_toxicgas_data_report",  0x3681);
define("HUITP_MSGID_uni_toxicgas_data_confirm",  0x3601);

//海拔高度
define("HUITP_MSGID_uni_altitude_data_min",  0x3700);
define("HUITP_MSGID_uni_altitude_data_req",  0x3700);
define("HUITP_MSGID_uni_altitude_data_resp",  0x3780);
define("HUITP_MSGID_uni_altitude_data_report",  0x3781);
define("HUITP_MSGID_uni_altitude_data_confirm",  0x3701);

//马达
define("HUITP_MSGID_uni_moto_min",  0x3800);
define("HUITP_MSGID_uni_moto_req",  0x3800);
define("HUITP_MSGID_uni_moto_resp",  0x3880);
define("HUITP_MSGID_uni_moto_report",  0x3881);
define("HUITP_MSGID_uni_moto_confirm",  0x3801);

//继电器
define("HUITP_MSGID_uni_switch_resistor_min",  0x3900);
define("HUITP_MSGID_uni_switch_resistor_req",  0x3900);
define("HUITP_MSGID_uni_switch_resistor_resp",  0x3980);
define("HUITP_MSGID_uni_switch_resistor_report",  0x3981);
define("HUITP_MSGID_uni_switch_resistor_confirm",  0x3901);

//导轨传送带
define("HUITP_MSGID_uni_transporter_min",  0x3A00);
define("HUITP_MSGID_uni_transporter_req",  0x3A00);
define("HUITP_MSGID_uni_transporter_resp",  0x3A80);
define("HUITP_MSGID_uni_transporter_report",  0x3A81);
define("HUITP_MSGID_uni_transporter_confirm",  0x3A01);

//组合秤BFSC
define("HUITP_MSGID_uni_bfsc_comb_scale_min",  0x3B00);
define("HUITP_MSGID_uni_bfsc_comb_scale_data_req",  0x3B00);
define("HUITP_MSGID_uni_bfsc_comb_scale_data_resp",  0x3B80);
define("HUITP_MSGID_uni_bfsc_comb_scale_data_report",  0x3B81);
define("HUITP_MSGID_uni_bfsc_comb_scale_data_confirm",  0x3B01);
define("HUITP_MSGID_uni_bfsc_comb_scale_event_report",  0x3B82);
define("HUITP_MSGID_uni_bfsc_comb_scale_event_confirm",  0x3B02);
define("HUITP_MSGID_uni_bfsc_comb_scale_ctrl_req",  0x3B03);
define("HUITP_MSGID_uni_bfsc_comb_scale_ctrl_resp",  0x3B83);
define("HUITP_MSGID_uni_bfsc_statistic_report",  0x3B84);
define("HUITP_MSGID_uni_bfsc_statistic_confirm",  0x3B04);

//云控锁-锁-旧系统兼容
define("HUITP_MSGID_uni_ccl_lock_old_min",  0x4000);
define("HUITP_MSGID_uni_ccl_lock_old_req",  0x4000);
define("HUITP_MSGID_uni_ccl_lock_old_resp",  0x4080);
define("HUITP_MSGID_uni_ccl_lock_old_report",  0x4081);
define("HUITP_MSGID_uni_ccl_lock_old_confirm",  0x4001);
define("HUITP_MSGID_uni_ccl_lock_old_auth_inq",  0x4090);
define("HUITP_MSGID_uni_ccl_lock_old_auth_resp",  0x4010);

//云控锁-门
define("HUITP_MSGID_uni_ccl_door_min",  0x4100);
define("HUITP_MSGID_uni_ccl_door_req",  0x4100);
define("HUITP_MSGID_uni_ccl_door_resp",  0x4180);
define("HUITP_MSGID_uni_ccl_door_report",  0x4181);
define("HUITP_MSGID_uni_ccl_door_confirm",  0x4101);

//云控锁-RFID模块
define("HUITP_MSGID_uni_ccl_rfid_min",  0x4200);
define("HUITP_MSGID_uni_ccl_rfid_req",  0x4200);
define("HUITP_MSGID_uni_ccl_rfid_resp",  0x4280);
define("HUITP_MSGID_uni_ccl_rfid_report",  0x4281);
define("HUITP_MSGID_uni_ccl_rfid_confirm",  0x4201);

//云控锁-BLE模块
define("HUITP_MSGID_uni_ccl_ble_min",  0x4300);
define("HUITP_MSGID_uni_ccl_ble_req",  0x4300);
define("HUITP_MSGID_uni_ccl_ble_resp",  0x4380);
define("HUITP_MSGID_uni_ccl_ble_report",  0x4381);
define("HUITP_MSGID_uni_ccl_ble_confirm",  0x4301);

//云控锁-GPRS模块
define("HUITP_MSGID_uni_ccl_gprs_min",  0x4400);
define("HUITP_MSGID_uni_ccl_gprs_req",  0x4400);
define("HUITP_MSGID_uni_ccl_gprs_resp",  0x4480);
define("HUITP_MSGID_uni_ccl_gprs_report",  0x4481);
define("HUITP_MSGID_uni_ccl_gprs_confirm",  0x4401);

//云控锁-电池模块
define("HUITP_MSGID_uni_ccl_battery_min",  0x4500);
define("HUITP_MSGID_uni_ccl_battery_req",  0x4500);
define("HUITP_MSGID_uni_ccl_battery_resp",  0x4580);
define("HUITP_MSGID_uni_ccl_battery_report",  0x4581);
define("HUITP_MSGID_uni_ccl_battery_confirm",  0x4501);

//云控锁-震动
define("HUITP_MSGID_uni_ccl_shake_min",  0x4600);
define("HUITP_MSGID_uni_ccl_shake_req",  0x4600);
define("HUITP_MSGID_uni_ccl_shake_resp",  0x4680);
define("HUITP_MSGID_uni_ccl_shake_report",  0x4681);
define("HUITP_MSGID_uni_ccl_shake_confirm",  0x4601);

//云控锁-烟雾
define("HUITP_MSGID_uni_ccl_smoke_min",  0x4700);
define("HUITP_MSGID_uni_ccl_smoke_req",  0x4700);
define("HUITP_MSGID_uni_ccl_smoke_resp",  0x4780);
define("HUITP_MSGID_uni_ccl_smoke_report",  0x4781);
define("HUITP_MSGID_uni_ccl_smoke_confirm",  0x4701);

//云控锁-水浸
define("HUITP_MSGID_uni_ccl_water_min",  0x4800);
define("HUITP_MSGID_uni_ccl_water_req",  0x4800);
define("HUITP_MSGID_uni_ccl_water_resp",  0x4880);
define("HUITP_MSGID_uni_ccl_water_report",  0x4881);
define("HUITP_MSGID_uni_ccl_water_confirm",  0x4801);

//云控锁-温度
define("HUITP_MSGID_uni_ccl_temp_min",  0x4900);
define("HUITP_MSGID_uni_ccl_temp_req",  0x4900);
define("HUITP_MSGID_uni_ccl_temp_resp",  0x4980);
define("HUITP_MSGID_uni_ccl_temp_report",  0x4981);
define("HUITP_MSGID_uni_ccl_temp_confirm",  0x4901);

//云控锁-湿度
define("HUITP_MSGID_uni_ccl_humid_min",  0x4A00);
define("HUITP_MSGID_uni_ccl_humid_req",  0x4A00);
define("HUITP_MSGID_uni_ccl_humid_resp",  0x4A80);
define("HUITP_MSGID_uni_ccl_humid_report",  0x4A81);
define("HUITP_MSGID_uni_ccl_humid_confirm",  0x4A01);

//云控锁-倾倒
define("HUITP_MSGID_uni_ccl_fall_min",  0x4B00);
define("HUITP_MSGID_uni_ccl_fall_req",  0x4B00);
define("HUITP_MSGID_uni_ccl_fall_resp",  0x4B80);
define("HUITP_MSGID_uni_ccl_fall_report",  0x4B81);
define("HUITP_MSGID_uni_ccl_fall_confirm",  0x4B01);

//云控锁-状态聚合-旧系统兼容
define("HUITP_MSGID_uni_ccl_state_old_min",  0x4C00);
define("HUITP_MSGID_uni_ccl_state_old_req",  0x4C00);
define("HUITP_MSGID_uni_ccl_state_old_resp",  0x4C80);
define("HUITP_MSGID_uni_ccl_state_old_report",  0x4C81);
define("HUITP_MSGID_uni_ccl_state_old_confirm",  0x4C01);
define("HUITP_MSGID_uni_ccl_state_old_pic_report",  0x4C82);
define("HUITP_MSGID_uni_ccl_state_old_pic_confirm",  0x4C02);

//云控锁-锁
define("HUITP_MSGID_uni_ccl_lock_min",  0x4D00);
define("HUITP_MSGID_uni_ccl_lock_req",  0x4D00);
define("HUITP_MSGID_uni_ccl_lock_resp",  0x4D80);
define("HUITP_MSGID_uni_ccl_lock_report",  0x4D81);
define("HUITP_MSGID_uni_ccl_lock_confirm",  0x4D01);
define("HUITP_MSGID_uni_ccl_lock_auth_inq",  0x4D90);
define("HUITP_MSGID_uni_ccl_lock_auth_resp",  0x4D10);

//云控锁-状态聚合
define("HUITP_MSGID_uni_ccl_state_min",  0x4E00);
define("HUITP_MSGID_uni_ccl_state_req",  0x4E00);
define("HUITP_MSGID_uni_ccl_state_resp",  0x4E80);
define("HUITP_MSGID_uni_ccl_state_report",  0x4E81);
define("HUITP_MSGID_uni_ccl_state_confirm",  0x4E01);
define("HUITP_MSGID_uni_ccl_state_pic_report",  0x4E82);
define("HUITP_MSGID_uni_ccl_state_pic_confirm",  0x4E02);

//复旦卫勤
define("HUITP_MSGID_uni_fdwq_data_req", 0x4F00);
define("HUITP_MSGID_uni_fdwq_data_resp", 0x4F80);
define("HUITP_MSGID_uni_fdwq_data_report", 0x4F81);
define("HUITP_MSGID_uni_fdwq_data_confirm", 0x4F01);
define("HUITP_MSGID_uni_fdwq_profile_report", 0x4F82);
define("HUITP_MSGID_uni_fdwq_profile_confirm", 0x4F02);

//串口读取命令/返回结果
define("HUITP_MSGID_uni_itf_sps_min",  0x5000);
define("HUITP_MSGID_uni_itf_sps_req",  0x5000);
define("HUITP_MSGID_uni_itf_sps_resp",  0x5080);
define("HUITP_MSGID_uni_itf_sps_report",  0x5001);
define("HUITP_MSGID_uni_itf_sps_confirm",  0x5081);

//ADC读取命令/返回结果
define("HUITP_MSGID_uni_itf_adc_min",  0x5100);
define("HUITP_MSGID_uni_itf_adc_req",  0x5100);
define("HUITP_MSGID_uni_itf_adc_resp",  0x5180);
define("HUITP_MSGID_uni_itf_adc_report",  0x5181);
define("HUITP_MSGID_uni_itf_adc_confirm",  0x5101);

//DAC读取命令/返回结果
define("HUITP_MSGID_uni_itf_dac_min",  0x5200);
define("HUITP_MSGID_uni_itf_dac_req",  0x5200);
define("HUITP_MSGID_uni_itf_dac_resp",  0x5280);
define("HUITP_MSGID_uni_itf_dac_report",  0x5281);
define("HUITP_MSGID_uni_itf_dac_confirm",  0x5201);

//I2C读取命令/返回结果
define("HUITP_MSGID_uni_itf_i2c_min",  0x5300);
define("HUITP_MSGID_uni_itf_i2c_req",  0x5300);
define("HUITP_MSGID_uni_itf_i2c_resp",  0x5380);
define("HUITP_MSGID_uni_itf_i2c_report",  0x5381);
define("HUITP_MSGID_uni_itf_i2c_confirm",  0x5301);

//PWM读取命令/返回结果
define("HUITP_MSGID_uni_itf_pwm_min",  0x5400);
define("HUITP_MSGID_uni_itf_pwm_req",  0x5400);
define("HUITP_MSGID_uni_itf_pwm_resp",  0x5480);
define("HUITP_MSGID_uni_itf_pwm_report",  0x5481);
define("HUITP_MSGID_uni_itf_pwm_confirm",  0x5401);

//DI读取命令/返回结果
define("HUITP_MSGID_uni_itf_di_min",  0x5500);
define("HUITP_MSGID_uni_itf_di_req",  0x5500);
define("HUITP_MSGID_uni_itf_di_resp",  0x5580);
define("HUITP_MSGID_uni_itf_di_report",  0x5581);
define("HUITP_MSGID_uni_itf_di_confirm",  0x5501);

//DO读取命令/返回结果
define("HUITP_MSGID_uni_itf_do_min",  0x5600);
define("HUITP_MSGID_uni_itf_do_req",  0x5600);
define("HUITP_MSGID_uni_itf_do_resp",  0x5680);
define("HUITP_MSGID_uni_itf_do_report",  0x5681);
define("HUITP_MSGID_uni_itf_do_confirm",  0x5601);

//CAN读取命令/返回结果
define("HUITP_MSGID_uni_itf_can_min",  0x5700);
define("HUITP_MSGID_uni_itf_can_req",  0x5700);
define("HUITP_MSGID_uni_itf_can_resp",  0x5780);
define("HUITP_MSGID_uni_itf_can_report",  0x5781);
define("HUITP_MSGID_uni_itf_can_confirm",  0x5701);

//SPI读取命令/返回结果
define("HUITP_MSGID_uni_itf_spi_min",  0x5800);
define("HUITP_MSGID_uni_itf_spi_req",  0x5800);
define("HUITP_MSGID_uni_itf_spi_resp",  0x5880);
define("HUITP_MSGID_uni_itf_spi_report",  0x5881);
define("HUITP_MSGID_uni_itf_spi_confirm",  0x5801);

//USB读取命令/返回结果
define("HUITP_MSGID_uni_itf_usb_min",  0x5900);
define("HUITP_MSGID_uni_itf_usb_req",  0x5900);
define("HUITP_MSGID_uni_itf_usb_resp",  0x5980);
define("HUITP_MSGID_uni_itf_usb_report",  0x5981);
define("HUITP_MSGID_uni_itf_usb_confirm",  0x5901);

//网口读取命令/返回结果
define("HUITP_MSGID_uni_itf_eth_min",  0x5A00);
define("HUITP_MSGID_uni_itf_eth_req",  0x5A00);
define("HUITP_MSGID_uni_itf_eth_resp",  0x5A80);
define("HUITP_MSGID_uni_itf_eth_report",  0x5A81);
define("HUITP_MSGID_uni_itf_eth_confirm",  0x5A01);

//485读取命令/返回结果
define("HUITP_MSGID_uni_itf_485_min",  0x5B00);
define("HUITP_MSGID_uni_itf_485_req",  0x5B00);
define("HUITP_MSGID_uni_itf_485_resp",  0x5B80);
define("HUITP_MSGID_uni_itf_485_report",  0x5B81);
define("HUITP_MSGID_uni_itf_485_confirm",  0x5B01);

//地震
define("HUITP_JSON_MSGID_uni_earthquake_ctrl_req", 0x5C00);
define("HUITP_JSON_MSGID_uni_earthquake_ctrl_resp", 0x5C80);
define("HUITP_JSON_MSGID_uni_earthquake_data_report", 0x5C81);
define("HUITP_JSON_MSGID_uni_earthquake_data_confirm", 0x5C01);
define("HUITP_JSON_MSGID_uni_heart_beat_report", 0x5CFF);
define("HUITP_JSON_MSGID_uni_heart_beat_confirm", 0x5C7F);

//软件清单
define("HUITP_MSGID_uni_inventory_min",  0xA000);
define("HUITP_MSGID_uni_inventory_req",  0xA000);
define("HUITP_MSGID_uni_inventory_resp",  0xA080);
define("HUITP_MSGID_uni_inventory_report",  0xA081);
define("HUITP_MSGID_uni_inventory_confirm",  0xA001);

//软件版本体
define("HUITP_MSGID_uni_sw_package_min",  0xA100);
define("HUITP_MSGID_uni_sw_package_req",  0xA100);
define("HUITP_MSGID_uni_sw_package_resp",  0xA180);
define("HUITP_MSGID_uni_sw_package_report",  0xA181);
define("HUITP_MSGID_uni_sw_package_confirm",  0xA101);

//工厂批量生产相关
define("HUITP_MSGID_uni_equlable_apply_report",  0xA281);
define("HUITP_MSGID_uni_equlable_apply_confirm",  0xA201);
define("HUITP_MSGID_uni_equlable_userlist_sync_report",  0xA284);
define("HUITP_MSGID_uni_equlable_userlist_sync_confirm",  0xA204);

//ALARM REPORT
define("HUITP_MSGID_uni_alarm_info_min",  0xB000);
define("HUITP_MSGID_uni_alarm_info_req",  0xB000);
define("HUITP_MSGID_uni_alarm_info_resp",  0xB080);
define("HUITP_MSGID_uni_alarm_info_report",  0xB081);
define("HUITP_MSGID_uni_alarm_info_confirm",  0xB001);

//PM Report
define("HUITP_MSGID_uni_performance_info_min",  0xB100);
define("HUITP_MSGID_uni_performance_info_req",  0xB100);
define("HUITP_MSGID_uni_performance_info_resp",  0xB180);
define("HUITP_MSGID_uni_performance_info_report",  0xB181);
define("HUITP_MSGID_uni_performance_info_confirm",  0xB101);

//设备基本信息
define("HUITP_MSGID_uni_equipment_info_min",  0xF000);
define("HUITP_MSGID_uni_equipment_info_req",  0xF000);
define("HUITP_MSGID_uni_equipment_info_resp",  0xF080);
define("HUITP_MSGID_uni_equipment_info_report",  0xF081);
define("HUITP_MSGID_uni_equipment_info_confirm",  0xF001);

//个人基本信息
define("HUITP_MSGID_uni_personal_info_min",  0xF100);
define("HUITP_MSGID_uni_personal_info_req",  0xF100);
define("HUITP_MSGID_uni_personal_info_resp",  0xF180);
define("HUITP_MSGID_uni_personal_info_report",  0xF181);
define("HUITP_MSGID_uni_personal_info_confirm",  0xF101);

//时间同步
define("HUITP_MSGID_uni_time_sync_min",  0xF200);
define("HUITP_MSGID_uni_time_sync_req",  0xF200);
define("HUITP_MSGID_uni_time_sync_resp",  0xF280);
define("HUITP_MSGID_uni_time_sync_report",  0xF281);
define("HUITP_MSGID_uni_time_sync_confirm",  0xF201);

//读取数据
define("HUITP_MSGID_uni_general_read_data_min",  0xF300);
define("HUITP_MSGID_uni_general_read_data_req",  0xF300);
define("HUITP_MSGID_uni_general_read_data_resp",  0xF380);
define("HUITP_MSGID_uni_general_read_data_report",  0xF381);
define("HUITP_MSGID_uni_general_read_data_confirm",  0xF301);

//定时闹钟及久坐提醒
define("HUITP_MSGID_uni_clock_timeout_min",  0xF400);
define("HUITP_MSGID_uni_clock_timeout_req",  0xF400);
define("HUITP_MSGID_uni_clock_timeout_resp",  0xF480);
define("HUITP_MSGID_uni_clock_timeout_report",  0xF481);
define("HUITP_MSGID_uni_clock_timeout_confirm",  0xF401);

//同步充电，双击情况
define("HUITP_MSGID_uni_sync_charging_min",  0xF500);
define("HUITP_MSGID_uni_sync_charging_req",  0xF500);
define("HUITP_MSGID_uni_sync_charging_resp",  0xF580);
define("HUITP_MSGID_uni_sync_charging_report",  0xF581);
define("HUITP_MSGID_uni_sync_charging_confirm",  0xF501);

//同步通知信息
define("HUITP_MSGID_uni_sync_trigger_min",  0xF600);
define("HUITP_MSGID_uni_sync_trigger_req",  0xF600);
define("HUITP_MSGID_uni_sync_trigger_resp",  0xF680);
define("HUITP_MSGID_uni_sync_trigger_report",  0xF681);
define("HUITP_MSGID_uni_sync_trigger_confirm",  0xF601);

//测试命令
define("HUITP_MSGID_uni_test_command_min",  0xF700);
define("HUITP_MSGID_uni_test_command_req",  0xF700);
define("HUITP_MSGID_uni_test_command_resp",  0xF780);
define("HUITP_MSGID_uni_test_command_report",  0xF781);
define("HUITP_MSGID_uni_test_command_confirm",  0xF701);

//CMD CONTROL
define("HUITP_MSGID_uni_cmd_ctrl_min",  0xFD00);
define("HUITP_MSGID_uni_cmd_ctrl_req",  0xFD00);
define("HUITP_MSGID_uni_cmd_ctrl_resp",  0xFD80);
define("HUITP_MSGID_uni_cmd_ctrl_report",  0xFD81);
define("HUITP_MSGID_uni_cmd_ctrl_confirm",  0xFD01);

//心跳
define("HUITP_MSGID_uni_heart_beat_min",  0xFE00);
define("HUITP_MSGID_uni_heart_beat_req",  0xFE00);
define("HUITP_MSGID_uni_heart_beat_resp",  0xFE80);
define("HUITP_MSGID_uni_heart_beat_report",  0xFE81);
define("HUITP_MSGID_uni_heart_beat_confirm",  0xFE01);

//无效
define("HUITP_MSGID_uni_max",  0xFEFF);
define("HUITP_MSGID_uni_null",  0xFFFF);

class classL2codecHuitpMsgDict
{
    public static $mfunL2codecHuitpMsgArrayConst = array(
        //无效
        HUITP_MSGID_uni_none => array(),  //0x0000
        HUITP_MSGID_uni_min => array(),  //0x0100

        //血糖
        //0x0100
        HUITP_MSGID_uni_blood_glucose_req => array("MSGNAME" => "HUITP_MSGID_uni_blood_glucose_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x0180
        HUITP_MSGID_uni_blood_glucose_resp => array("MSGNAME" => "HUITP_MSGID_uni_blood_glucose_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x0181
        HUITP_MSGID_uni_blood_glucose_report => array("MSGNAME" => "HUITP_MSGID_uni_blood_glucose_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x0101
        HUITP_MSGID_uni_blood_glucose_confirm => array("MSGNAME" => "HUITP_MSGID_uni_blood_glucose_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //单次运动
        //0x0200
        HUITP_MSGID_uni_single_sports_req => array("MSGNAME" => "HUITP_MSGID_uni_single_sports_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x0280
        HUITP_MSGID_uni_single_sports_resp => array("MSGNAME" => "HUITP_MSGID_uni_single_sports_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x0281
        HUITP_MSGID_uni_single_sports_report => array("MSGNAME" => "HUITP_MSGID_uni_single_sports_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x0201
        HUITP_MSGID_uni_single_sports_confirm => array("MSGNAME" => "HUITP_MSGID_uni_single_sports_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //单次睡眠
        //0x0300
        HUITP_MSGID_uni_single_sleep_req => array("MSGNAME" => "HUITP_MSGID_uni_single_sleep_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x0380
        HUITP_MSGID_uni_single_sleep_resp => array("MSGNAME" => "HUITP_MSGID_uni_single_sleep_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x0381
        HUITP_MSGID_uni_single_sleep_report => array("MSGNAME" => "HUITP_MSGID_uni_single_sleep_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x0301
        HUITP_MSGID_uni_single_sleep_confirm => array("MSGNAME" => "HUITP_MSGID_uni_single_sleep_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //体脂
        //0x0400
        HUITP_MSGID_uni_body_fat_req => array("MSGNAME" => "HUITP_MSGID_uni_body_fat_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x0480
        HUITP_MSGID_uni_body_fat_resp =>array("MSGNAME" => "HUITP_MSGID_uni_body_fat_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x0481
        HUITP_MSGID_uni_body_fat_report => array("MSGNAME" => "HUITP_MSGID_uni_body_fat_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x0401
        HUITP_MSGID_uni_body_fat_confirm => array("MSGNAME" => "HUITP_MSGID_uni_body_fat_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //血压
        //0x0500
        HUITP_MSGID_uni_blood_pressure_req => array("MSGNAME" => "HUITP_MSGID_uni_blood_pressure_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x0580
        HUITP_MSGID_uni_blood_pressure_resp => array("MSGNAME" => "HUITP_MSGID_uni_blood_pressure_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x0581
        HUITP_MSGID_uni_blood_pressure_report => array("MSGNAME" => "HUITP_MSGID_uni_blood_pressure_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x0501
        HUITP_MSGID_uni_blood_pressure_confirm => array("MSGNAME" => "HUITP_MSGID_uni_blood_pressure_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //跑步机数据上报
        //0x0A00
        HUITP_MSGID_uni_runner_machine_rep_req => array("MSGNAME" => "HUITP_MSGID_uni_runner_machine_rep_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x0A80
        HUITP_MSGID_uni_runner_machine_rep_resp => array("MSGNAME" => "HUITP_MSGID_uni_runner_machine_rep_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x0A81
        HUITP_MSGID_uni_runner_machine_rep_report => array("MSGNAME" => "HUITP_MSGID_uni_runner_machine_rep_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x0A01
        HUITP_MSGID_uni_runner_machine_rep_confirm => array("MSGNAME" => "HUITP_MSGID_uni_runner_machine_rep_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //跑步机任务控制
        //0x0B00
        HUITP_MSGID_uni_runner_machine_ctrl_req => array("MSGNAME" => "HUITP_MSGID_uni_runner_machine_ctrl_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x0B80
        HUITP_MSGID_uni_runner_machine_ctrl_resp => array("MSGNAME" => "HUITP_MSGID_uni_runner_machine_ctrl_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x0B81
        HUITP_MSGID_uni_runner_machine_ctrl_report => array("MSGNAME" => "HUITP_MSGID_uni_runner_machine_ctrl_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x0B01
        HUITP_MSGID_uni_runner_machine_ctrl_confirm => array("MSGNAME" => "HUITP_MSGID_uni_runner_machine_ctrl_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //GPS地址
        //0x0C00
        HUITP_MSGID_uni_gps_specific_req => array("MSGNAME" => "HUITP_MSGID_uni_gps_specific_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x0C80
        HUITP_MSGID_uni_gps_specific_resp => array("MSGNAME" => "HUITP_MSGID_uni_gps_specific_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x0C81
        HUITP_MSGID_uni_gps_specific_report => array("MSGNAME" => "HUITP_MSGID_uni_gps_specific_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x0C01
        HUITP_MSGID_uni_gps_specific_confirm => array("MSGNAME" => "HUITP_MSGID_uni_gps_specific_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //IHU与IAU之间控制命令
        //0x1000
        HUITP_MSGID_uni_iau_ctrl_req => array("MSGNAME" => "HUITP_MSGID_uni_iau_ctrl_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x1080
        HUITP_MSGID_uni_iau_ctrl_resp => array("MSGNAME" => "HUITP_MSGID_uni_iau_ctrl_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x1081
        HUITP_MSGID_uni_iau_ctrl_report => array("MSGNAME" => "HUITP_MSGID_uni_iau_ctrl_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x1001
        HUITP_MSGID_uni_iau_ctrl_confirm => array("MSGNAME" => "HUITP_MSGID_uni_iau_ctrl_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //电磁辐射强度
        //0x2000
        HUITP_MSGID_uni_emc_data_req => array("MSGNAME" => "HUITP_MSGID_uni_emc_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2080
        HUITP_MSGID_uni_emc_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_emc_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2081
        HUITP_MSGID_uni_emc_data_report => array("MSGNAME" => "HUITP_MSGID_uni_emc_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x2001
        HUITP_MSGID_uni_emc_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_emc_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),
        //0x2002
        HUITP_MSGID_uni_emc_ctrl_req => array("MSGNAME" => "HUITP_MSGID_uni_emc_ctrl_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2082
        HUITP_MSGID_uni_emc_ctrl_resp => array("MSGNAME" => "HUITP_MSGID_uni_emc_ctrl_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),

        //电磁辐射剂量
        //0x2100
        HUITP_MSGID_uni_emc_accu_req => array("MSGNAME" => "HUITP_MSGID_uni_emc_accu_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2180
        HUITP_MSGID_uni_emc_accu_resp => array("MSGNAME" => "HUITP_MSGID_uni_emc_accu_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2181
        HUITP_MSGID_uni_emc_accu_report => array("MSGNAME" => "HUITP_MSGID_uni_emc_accu_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x2101
        HUITP_MSGID_uni_emc_accu_confirm => array("MSGNAME" => "HUITP_MSGID_uni_emc_accu_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //一氧化碳
        //0x2200
        HUITP_MSGID_uni_co1_data_req => array("MSGNAME" => "HUITP_MSGID_uni_co1_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2280
        HUITP_MSGID_uni_co1_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_co1_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2281
        HUITP_MSGID_uni_co1_data_report => array("MSGNAME" => "HUITP_MSGID_uni_co1_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x2201
        HUITP_MSGID_uni_co1_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_co1_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //甲醛HCHO
        //0x2300
        HUITP_MSGID_uni_hcho_data_req => array("MSGNAME" => "HUITP_MSGID_uni_hcho_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2380
        HUITP_MSGID_uni_hcho_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_hcho_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2381
        HUITP_MSGID_uni_hcho_data_report => array("MSGNAME" => "HUITP_MSGID_uni_hcho_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x2301
        HUITP_MSGID_uni_hcho_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_hcho_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //酒精
        //0x2400
        HUITP_MSGID_uni_alcohol_data_req => array("MSGNAME" => "HUITP_MSGID_uni_alcohol_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2480
        HUITP_MSGID_uni_alcohol_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_alcohol_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2481
        HUITP_MSGID_uni_alcohol_data_report => array("MSGNAME" => "HUITP_MSGID_uni_alcohol_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x2401
        HUITP_MSGID_uni_alcohol_data_confirm => array("MSGNAME" => "",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //颗粒物PM1/2.5/10
        //0x2500
        HUITP_MSGID_uni_pm25_data_req => array("MSGNAME" => "HUITP_MSGID_uni_pm25_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2580
        HUITP_MSGID_uni_pm25_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_pm25_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2581
        HUITP_MSGID_uni_pm25_data_report => array("MSGNAME" => "HUITP_MSGID_uni_pm25_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_pm01_value,
                            HUITP_IEID_uni_pm25_value,
                            HUITP_IEID_uni_pm10_value)),

        //0x2501
        HUITP_MSGID_uni_pm25_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_pm25_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),
        //0x2502
        HUITP_MSGID_uni_pm25_ctrl_req => array("MSGNAME" => "HUITP_MSGID_uni_pm25_ctrl_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2582
        HUITP_MSGID_uni_pm25_ctrl_resp => array("MSGNAME" => "HUITP_MSGID_uni_pm25_ctrl_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2503
        HUITP_MSGID_uni_pm25sp_data_req => array("MSGNAME" => "HUITP_MSGID_uni_pm25sp_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2583
        HUITP_MSGID_uni_pm25sp_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_pm25sp_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2504
        HUITP_MSGID_uni_pm25sp_data_report => array("MSGNAME" => "HUITP_MSGID_uni_pm25sp_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x2584
        HUITP_MSGID_uni_pm25sp_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_pm25sp_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //风速Wind Speed
        //0x2600
        HUITP_MSGID_uni_windspd_data_req => array("MSGNAME" => "HUITP_MSGID_uni_windspd_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2680
        HUITP_MSGID_uni_windspd_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_windspd_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2681
        HUITP_MSGID_uni_windspd_data_report => array("MSGNAME" => "HUITP_MSGID_uni_windspd_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_windspd_value)),
        //0x2601
        HUITP_MSGID_uni_windspd_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_windspd_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),
        //0x2602
        HUITP_MSGID_uni_windspd_ctrl_req => array("MSGNAME" => "HUITP_MSGID_uni_windspd_ctrl_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2682
        HUITP_MSGID_uni_windspd_ctrl_resp => array("MSGNAME" => "HUITP_MSGID_uni_windspd_ctrl_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),

        //风向Wind Direction
        //0x2700
        HUITP_MSGID_uni_winddir_data_req => array("MSGNAME" => "HUITP_MSGID_uni_winddir_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2780
        HUITP_MSGID_uni_winddir_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_winddir_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2781
        HUITP_MSGID_uni_winddir_data_report => array("MSGNAME" => "HUITP_MSGID_uni_winddir_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_winddir_value)),
        //0x2701
        HUITP_MSGID_uni_winddir_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_winddir_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),
        //0x2702
        HUITP_MSGID_uni_winddir_ctrl_req => array("MSGNAME" => "HUITP_MSGID_uni_winddir_ctrl_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2782
        HUITP_MSGID_uni_winddir_ctrl_resp => array("MSGNAME" => "HUITP_MSGID_uni_winddir_ctrl_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),

        //温度Temperature
        //0x2800
        HUITP_MSGID_uni_temp_data_req => array("MSGNAME" => "HUITP_MSGID_uni_temp_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2880
        HUITP_MSGID_uni_temp_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_temp_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2881
        HUITP_MSGID_uni_temp_data_report => array("MSGNAME" => "HUITP_MSGID_uni_temp_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_temp_value)),
        //0x2801
        HUITP_MSGID_uni_temp_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_temp_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),
        //0x2802
        HUITP_MSGID_uni_temp_ctrl_req => array("MSGNAME" => "HUITP_MSGID_uni_temp_ctrl_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2882
        HUITP_MSGID_uni_temp_ctrl_resp => array("MSGNAME" => "HUITP_MSGID_uni_temp_ctrl_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),

        //湿度Humidity
        //0x2900
        HUITP_MSGID_uni_humid_data_req => array("MSGNAME" => "HUITP_MSGID_uni_humid_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2980
        HUITP_MSGID_uni_humid_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_humid_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2981
        HUITP_MSGID_uni_humid_data_report => array("MSGNAME" => "HUITP_MSGID_uni_humid_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_humid_value)),
        //0x2901
        HUITP_MSGID_uni_humid_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_humid_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),
        //0x2902
        HUITP_MSGID_uni_humid_ctrl_req => array("MSGNAME" => "HUITP_MSGID_uni_humid_ctrl_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2982
        HUITP_MSGID_uni_humid_ctrl_resp => array("MSGNAME" => "HUITP_MSGID_uni_humid_ctrl_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),

        //气压Air pressure
        //0x2A00
        HUITP_MSGID_uni_airprs_data_req => array("MSGNAME" => "HUITP_MSGID_uni_airprs_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2A80
        HUITP_MSGID_uni_airprs_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_airprs_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2A81
        HUITP_MSGID_uni_airprs_data_report => array("MSGNAME" => "HUITP_MSGID_uni_airprs_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x2A01
        HUITP_MSGID_uni_airprs_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_airprs_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //噪声Noise
        //0x2B00
        HUITP_MSGID_uni_noise_data_req => array("MSGNAME" => "HUITP_MSGID_uni_noise_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2B80
        HUITP_MSGID_uni_noise_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_noise_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2B81
        HUITP_MSGID_uni_noise_data_report => array("MSGNAME" => "HUITP_MSGID_uni_noise_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_noise_value)),
        //0x2B01
        HUITP_MSGID_uni_noise_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_noise_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),
        //0x2B02
        HUITP_MSGID_uni_noise_ctrl_req => array("MSGNAME" => "HUITP_MSGID_uni_noise_ctrl_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2B82
        HUITP_MSGID_uni_noise_ctrl_resp => array("MSGNAME" => "HUITP_MSGID_uni_noise_ctrl_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),

        //相机Camer or audio high speed
        //0x2C00
        HUITP_MSGID_uni_hsmmp_data_req => array("MSGNAME" => "HUITP_MSGID_uni_hsmmp_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2C80
        HUITP_MSGID_uni_hsmmp_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_hsmmp_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2C81
        HUITP_MSGID_uni_hsmmp_data_report => array("MSGNAME" => "HUITP_MSGID_uni_hsmmp_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                        HUITP_IEID_uni_hsmmp_value)),
        //0x2C01
        HUITP_MSGID_uni_hsmmp_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_hsmmp_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),
        //0x2C02
        HUITP_MSGID_uni_hsmmp_ctrl_req => array("MSGNAME" => "HUITP_MSGID_uni_hsmmp_ctrl_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req,
                        HUITP_IEID_uni_com_snr_cmd_tag,
                        HUITP_IEID_uni_com_switch_onoff,
                        HUITP_IEID_uni_com_work_cycle,
                        HUITP_IEID_uni_com_sample_cycle,
                        HUITP_IEID_uni_com_sample_number,
                        HUITP_IEID_uni_com_modbus_address,
                        HUITP_IEID_uni_hsmmp_motive)),
        //0x2C82
        HUITP_MSGID_uni_hsmmp_ctrl_resp => array("MSGNAME" => "HUITP_MSGID_uni_hsmmp_ctrl_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp,
                        HUITP_IEID_uni_com_snr_cmd_tag,
                        HUITP_IEID_uni_com_switch_onoff,
                        HUITP_IEID_uni_com_work_cycle,
                        HUITP_IEID_uni_com_sample_cycle,
                        HUITP_IEID_uni_com_sample_number,
                        HUITP_IEID_uni_com_modbus_address,
                        HUITP_IEID_uni_hsmmp_motive)),
        //声音
        //0x2D00
        HUITP_MSGID_uni_audio_data_req => array("MSGNAME" => "HUITP_MSGID_uni_audio_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2D80
        HUITP_MSGID_uni_audio_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_audio_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2D81
        HUITP_MSGID_uni_audio_data_report => array("MSGNAME" => "HUITP_MSGID_uni_audio_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x2D01
        HUITP_MSGID_uni_audio_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_audio_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //视频
        //0x2E00
        HUITP_MSGID_uni_video_data_req => array("MSGNAME" => "HUITP_MSGID_uni_video_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x2E80
        HUITP_MSGID_uni_video_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_video_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp)),
        //0x2E81
        HUITP_MSGID_uni_video_data_report => array("MSGNAME" => "HUITP_MSGID_uni_video_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x2E01
        HUITP_MSGID_uni_video_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_video_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //图片
        HUITP_MSGID_uni_picture_data_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x2F00
        HUITP_MSGID_uni_picture_data_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x2F80
        //0x2F81
        HUITP_MSGID_uni_picture_data_report => array("MSGNAME" => "HUITP_MSGID_uni_picture_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_picture_ind)),
        //0x2F01
        HUITP_MSGID_uni_picture_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_picture_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //扬尘监控系统
        HUITP_MSGID_uni_ycjk_data_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3000
        HUITP_MSGID_uni_ycjk_data_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3080
        //0x3081
        HUITP_MSGID_uni_ycjk_data_report => array("MSGNAME" => "HUITP_MSGID_uni_ycjk_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                HUITP_IEID_uni_ycjk_value)),
        //0x3001
        HUITP_MSGID_uni_ycjk_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_ycjk_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),
        HUITP_MSGID_uni_ycjk_ctrl_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3002
        HUITP_MSGID_uni_ycjk_ctrl_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3082

        //水表
        HUITP_MSGID_uni_water_meter_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3100
        HUITP_MSGID_uni_water_meter_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3180
        HUITP_MSGID_uni_water_meter_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3181
        HUITP_MSGID_uni_water_meter_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3101

        //热表
        HUITP_MSGID_uni_heat_meter_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3200
        HUITP_MSGID_uni_heat_meter_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3280
        HUITP_MSGID_uni_heat_meter_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3281
        HUITP_MSGID_uni_heat_meter_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3201

        //气表
        HUITP_MSGID_uni_gas_meter_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3300
        HUITP_MSGID_uni_gas_meter_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3380
        HUITP_MSGID_uni_gas_meter_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3381
        HUITP_MSGID_uni_gas_meter_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3301

        //电表
        HUITP_MSGID_uni_power_meter_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3400
        HUITP_MSGID_uni_power_meter_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3480
        HUITP_MSGID_uni_power_meter_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3481
        HUITP_MSGID_uni_power_meter_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3401

        //光照强度
        HUITP_MSGID_uni_lightstr_data_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3500
        HUITP_MSGID_uni_lightstr_data_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3580
        HUITP_MSGID_uni_lightstr_data_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3581
        HUITP_MSGID_uni_lightstr_data_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3501

        //有毒气体VOC
        HUITP_MSGID_uni_toxicgas_data_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3600
        HUITP_MSGID_uni_toxicgas_data_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3680
        HUITP_MSGID_uni_toxicgas_data_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3681
        HUITP_MSGID_uni_toxicgas_data_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3601

        //海拔高度
        HUITP_MSGID_uni_altitude_data_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3700
        HUITP_MSGID_uni_altitude_data_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3780
        HUITP_MSGID_uni_altitude_data_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3781
        HUITP_MSGID_uni_altitude_data_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3701

        //马达
        HUITP_MSGID_uni_moto_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3800
        HUITP_MSGID_uni_moto_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3880
        HUITP_MSGID_uni_moto_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3881
        HUITP_MSGID_uni_moto_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3801

        //继电器
        HUITP_MSGID_uni_switch_resistor_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3900
        HUITP_MSGID_uni_switch_resistor_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3980
        HUITP_MSGID_uni_switch_resistor_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3981
        HUITP_MSGID_uni_switch_resistor_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3901

        //导轨传送带
        HUITP_MSGID_uni_transporter_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3A00
        HUITP_MSGID_uni_transporter_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3A80
        HUITP_MSGID_uni_transporter_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3A81
        HUITP_MSGID_uni_transporter_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3A01

        //组合秤BFSC
        HUITP_MSGID_uni_bfsc_comb_scale_data_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3B00
        HUITP_MSGID_uni_bfsc_comb_scale_data_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3B80
        HUITP_MSGID_uni_bfsc_comb_scale_data_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3B81
        HUITP_MSGID_uni_bfsc_comb_scale_data_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3B01
        HUITP_MSGID_uni_bfsc_comb_scale_event_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3B82
        HUITP_MSGID_uni_bfsc_comb_scale_event_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3B02
        HUITP_MSGID_uni_bfsc_comb_scale_ctrl_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3B03
        HUITP_MSGID_uni_bfsc_comb_scale_ctrl_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3B83
        HUITP_MSGID_uni_bfsc_statistic_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3B84
        HUITP_MSGID_uni_bfsc_statistic_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x3B04

        //云控锁-锁-旧系统兼容
        HUITP_MSGID_uni_ccl_lock_old_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4000
        HUITP_MSGID_uni_ccl_lock_old_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4080
        HUITP_MSGID_uni_ccl_lock_old_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4081
        HUITP_MSGID_uni_ccl_lock_old_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4001
        HUITP_MSGID_uni_ccl_lock_old_auth_inq => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4090
        HUITP_MSGID_uni_ccl_lock_old_auth_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4010

        //云控锁-门
        HUITP_MSGID_uni_ccl_door_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4100
        HUITP_MSGID_uni_ccl_door_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4180
        HUITP_MSGID_uni_ccl_door_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4181
        HUITP_MSGID_uni_ccl_door_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4101

        //云控锁-RFID模块
        HUITP_MSGID_uni_ccl_rfid_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4200
        HUITP_MSGID_uni_ccl_rfid_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4280
        HUITP_MSGID_uni_ccl_rfid_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4281
        HUITP_MSGID_uni_ccl_rfid_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4201

        //云控锁-BLE模块
        HUITP_MSGID_uni_ccl_ble_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4300
        HUITP_MSGID_uni_ccl_ble_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4380
        HUITP_MSGID_uni_ccl_ble_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4381
        HUITP_MSGID_uni_ccl_ble_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4301

        //云控锁-GPRS模块
        HUITP_MSGID_uni_ccl_gprs_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4400
        HUITP_MSGID_uni_ccl_gprs_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4480
        HUITP_MSGID_uni_ccl_gprs_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4481
        HUITP_MSGID_uni_ccl_gprs_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4401

        //云控锁-电池模块
        HUITP_MSGID_uni_ccl_battery_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4500
        HUITP_MSGID_uni_ccl_battery_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4580
        HUITP_MSGID_uni_ccl_battery_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4581
        HUITP_MSGID_uni_ccl_battery_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4501

        //云控锁-震动
        HUITP_MSGID_uni_ccl_shake_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4600
        HUITP_MSGID_uni_ccl_shake_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4680
        HUITP_MSGID_uni_ccl_shake_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4681
        HUITP_MSGID_uni_ccl_shake_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4601

        //云控锁-烟雾
        HUITP_MSGID_uni_ccl_smoke_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4700
        HUITP_MSGID_uni_ccl_smoke_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4780
        HUITP_MSGID_uni_ccl_smoke_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4781
        HUITP_MSGID_uni_ccl_smoke_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4701

        //云控锁-水浸
        HUITP_MSGID_uni_ccl_water_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4800
        HUITP_MSGID_uni_ccl_water_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4880
        HUITP_MSGID_uni_ccl_water_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4881
        HUITP_MSGID_uni_ccl_water_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4801

        //云控锁-温度
        HUITP_MSGID_uni_ccl_temp_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4900
        HUITP_MSGID_uni_ccl_temp_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4980
        HUITP_MSGID_uni_ccl_temp_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4981
        HUITP_MSGID_uni_ccl_temp_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4901

        //云控锁-湿度
        HUITP_MSGID_uni_ccl_humid_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4A00
        HUITP_MSGID_uni_ccl_humid_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4A80
        HUITP_MSGID_uni_ccl_humid_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4A81
        HUITP_MSGID_uni_ccl_humid_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4A01

        //云控锁-倾倒
        HUITP_MSGID_uni_ccl_fall_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4B00
        HUITP_MSGID_uni_ccl_fall_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4B80
        HUITP_MSGID_uni_ccl_fall_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4B81
        HUITP_MSGID_uni_ccl_fall_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4B01

        //云控锁-状态聚合-旧系统兼容
        HUITP_MSGID_uni_ccl_state_old_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4C00
        HUITP_MSGID_uni_ccl_state_old_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4C80
        HUITP_MSGID_uni_ccl_state_old_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4C81
        HUITP_MSGID_uni_ccl_state_old_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4C01
        HUITP_MSGID_uni_ccl_state_old_pic_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4C82
        HUITP_MSGID_uni_ccl_state_old_pic_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x4C02

        //云控锁-锁
        //0x4D00
        HUITP_MSGID_uni_ccl_lock_req => array("MSGNAME" => "HUITP_MSGID_uni_ccl_lock_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x4D80
        HUITP_MSGID_uni_ccl_lock_resp => array("MSGNAME" => "HUITP_MSGID_uni_ccl_lock_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp,
                            HUITP_IEID_uni_ccl_lock_state)),
        //0x4D81
        HUITP_MSGID_uni_ccl_lock_report => array("MSGNAME" => "HUITP_MSGID_uni_ccl_lock_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_ccl_lock_state)),
        //0x4D01
        HUITP_MSGID_uni_ccl_lock_confirm => array("MSGNAME" => "HUITP_MSGID_uni_ccl_lock_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),
        //0x4D90
        HUITP_MSGID_uni_ccl_lock_auth_inq => array("MSGNAME" => "HUITP_MSGID_uni_ccl_lock_auth_inq",
            "MSGIE" => array(HUITP_IEID_uni_com_req,
                            HUITP_IEID_uni_ccl_lock_auth_req)),
        //0x4D10
        HUITP_MSGID_uni_ccl_lock_auth_resp => array("MSGNAME" => "HUITP_MSGID_uni_ccl_lock_auth_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp,
                            HUITP_IEID_uni_ccl_lock_auth_resp,
                            HUITP_IEID_uni_ccl_gen_picid)),

        //云控锁-状态聚合
        //0x4E00
        HUITP_MSGID_uni_ccl_state_req => array("MSGNAME" => "HUITP_MSGID_uni_ccl_state_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x4E80
        HUITP_MSGID_uni_ccl_state_resp => array("MSGNAME" => "HUITP_MSGID_uni_ccl_state_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp,
                            HUITP_IEID_uni_ccl_lock_state,
                            HUITP_IEID_uni_ccl_door_state,
                            HUITP_IEID_uni_ccl_water_state,
                            HUITP_IEID_uni_ccl_fall_state,
                            HUITP_IEID_uni_ccl_shake_state,
                            HUITP_IEID_uni_ccl_smoke_state,
                            HUITP_IEID_uni_ccl_bat_state,
                            HUITP_IEID_uni_ccl_temp_value,
                            HUITP_IEID_uni_ccl_humid_value,
                            HUITP_IEID_uni_ccl_bat_value,
                            HUITP_IEID_uni_ccl_general_value1,
                            HUITP_IEID_uni_ccl_general_value2,
                            HUITP_IEID_uni_ccl_rssi_value,
                            HUITP_IEID_uni_ccl_dcmi_value,
                            HUITP_IEID_uni_ccl_report_type)),
        //0x4E81
        HUITP_MSGID_uni_ccl_state_report => array("MSGNAME" => "HUITP_MSGID_uni_ccl_state_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_ccl_lock_state,
                            HUITP_IEID_uni_ccl_door_state,
                            HUITP_IEID_uni_ccl_water_state,
                            HUITP_IEID_uni_ccl_fall_state,
                            HUITP_IEID_uni_ccl_shake_state,
                            HUITP_IEID_uni_ccl_smoke_state,
                            HUITP_IEID_uni_ccl_bat_state,
                            HUITP_IEID_uni_ccl_temp_value,
                            HUITP_IEID_uni_ccl_humid_value,
                            HUITP_IEID_uni_ccl_bat_value,
                            HUITP_IEID_uni_ccl_fall_value,
                            HUITP_IEID_uni_ccl_general_value1,
                            HUITP_IEID_uni_ccl_general_value2,
                            HUITP_IEID_uni_ccl_rssi_value,
                            HUITP_IEID_uni_ccl_dcmi_value,
                            HUITP_IEID_uni_ccl_report_type)),
        //0x4E01
        HUITP_MSGID_uni_ccl_state_confirm => array("MSGNAME" => "HUITP_MSGID_uni_ccl_state_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm,
                            HUITP_IEID_uni_ccl_report_type)),
        //0x4E82
        HUITP_MSGID_uni_ccl_state_pic_report => array("MSGNAME" => "HUITP_MSGID_uni_ccl_state_pic_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report)),
        //0x4E02
        HUITP_MSGID_uni_ccl_state_pic_confirm => array("MSGNAME" => "HUITP_MSGID_uni_ccl_state_pic_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //国通教育NB-IOT
        //0x4F00
        HUITP_MSGID_uni_fdwq_data_req => array("MSGNAME" => "HUITP_MSGID_uni_fdwq_data_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req)),
        //0x4F80
        HUITP_MSGID_uni_fdwq_data_resp => array("MSGNAME" => "HUITP_MSGID_uni_fdwq_data_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp,
                            HUITP_IEID_uni_fdwq_sports_wrist_data)),
        //0x4F81
        HUITP_MSGID_uni_fdwq_data_report => array("MSGNAME" => "HUITP_MSGID_uni_fdwq_data_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_fdwq_sports_wrist_data)),
        //0x4F01
        HUITP_MSGID_uni_fdwq_data_confirm => array("MSGNAME" => "HUITP_MSGID_uni_fdwq_data_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),
        //0x4F82
        HUITP_MSGID_uni_fdwq_profile_report => array("MSGNAME" => "HUITP_MSGID_uni_fdwq_profile_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_fdwq_profile_simple_data)),
        //0x4F02
        HUITP_MSGID_uni_fdwq_profile_confirm => array("MSGNAME" => "HUITP_MSGID_uni_fdwq_profile_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm,
                            HUITP_IEID_uni_fdwq_profile_detail_data)),

        //串口读取命令/返回结果
        HUITP_MSGID_uni_itf_sps_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5000
        HUITP_MSGID_uni_itf_sps_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_resp)),  //0x5080
        HUITP_MSGID_uni_itf_sps_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5001
        HUITP_MSGID_uni_itf_sps_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5081

        //ADC读取命令/返回结果
        HUITP_MSGID_uni_itf_adc_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5100
        HUITP_MSGID_uni_itf_adc_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5180
        HUITP_MSGID_uni_itf_adc_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5181
        HUITP_MSGID_uni_itf_adc_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5101

        //DAC读取命令/返回结果
        HUITP_MSGID_uni_itf_dac_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5200
        HUITP_MSGID_uni_itf_dac_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5280
        HUITP_MSGID_uni_itf_dac_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5281
        HUITP_MSGID_uni_itf_dac_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5201

        //I2C读取命令/返回结果
        HUITP_MSGID_uni_itf_i2c_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5300
        HUITP_MSGID_uni_itf_i2c_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5380
        HUITP_MSGID_uni_itf_i2c_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5381
        HUITP_MSGID_uni_itf_i2c_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5301

        //PWM读取命令/返回结果
        HUITP_MSGID_uni_itf_pwm_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5400
        HUITP_MSGID_uni_itf_pwm_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5480
        HUITP_MSGID_uni_itf_pwm_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5481
        HUITP_MSGID_uni_itf_pwm_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5401

        //DI读取命令/返回结果
        HUITP_MSGID_uni_itf_di_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5500
        HUITP_MSGID_uni_itf_di_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5580
        HUITP_MSGID_uni_itf_di_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5581
        HUITP_MSGID_uni_itf_di_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5501

        //DO读取命令/返回结果
        HUITP_MSGID_uni_itf_do_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5600
        HUITP_MSGID_uni_itf_do_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5680
        HUITP_MSGID_uni_itf_do_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5681
        HUITP_MSGID_uni_itf_do_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5601

        //CAN读取命令/返回结果
        HUITP_MSGID_uni_itf_can_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5700
        HUITP_MSGID_uni_itf_can_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5780
        HUITP_MSGID_uni_itf_can_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5781
        HUITP_MSGID_uni_itf_can_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5701

        //SPI读取命令/返回结果
        HUITP_MSGID_uni_itf_spi_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5800
        HUITP_MSGID_uni_itf_spi_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5880
        HUITP_MSGID_uni_itf_spi_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5881
        HUITP_MSGID_uni_itf_spi_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5801

        //USB读取命令/返回结果
        HUITP_MSGID_uni_itf_usb_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5900
        HUITP_MSGID_uni_itf_usb_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5980
        HUITP_MSGID_uni_itf_usb_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5981
        HUITP_MSGID_uni_itf_usb_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5901

        //网口读取命令/返回结果
        HUITP_MSGID_uni_itf_eth_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5A00
        HUITP_MSGID_uni_itf_eth_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5A80
        HUITP_MSGID_uni_itf_eth_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5A81
        HUITP_MSGID_uni_itf_eth_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5A01

        //485读取命令/返回结果
        HUITP_MSGID_uni_itf_485_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5B00
        HUITP_MSGID_uni_itf_485_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5B80
        HUITP_MSGID_uni_itf_485_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5B81
        HUITP_MSGID_uni_itf_485_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0x5B01

        //软件清单
        //0xA000
        HUITP_MSGID_uni_inventory_req => array("MSGNAME" => "HUITP_MSGID_uni_inventory_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req,
                            HUITP_IEID_uni_inventory_element)),
        //0xA080
        HUITP_MSGID_uni_inventory_resp => array("MSGNAME" => "HUITP_MSGID_uni_inventory_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp,
                            HUITP_IEID_uni_inventory_element)),
        //0xA081
        HUITP_MSGID_uni_inventory_report => array("MSGNAME" => "HUITP_MSGID_uni_inventory_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_inventory_element)),
        //0xA001
        HUITP_MSGID_uni_inventory_confirm => array("MSGNAME" => "HUITP_MSGID_uni_inventory_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm,
                            HUITP_IEID_uni_inventory_element)),

        //软件版本体
        //0xA100
        HUITP_MSGID_uni_sw_package_req => array("MSGNAME" => "HUITP_MSGID_uni_sw_package_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req,
                            HUITP_IEID_uni_com_segment,
                            HUITP_IEID_uni_sw_package_body)),
        //0xA180
        HUITP_MSGID_uni_sw_package_resp => array("MSGNAME" => "HUITP_MSGID_uni_sw_package_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp,
                            HUITP_IEID_uni_com_segment)),
        //0xA181
        HUITP_MSGID_uni_sw_package_report => array("MSGNAME" => "HUITP_MSGID_uni_sw_package_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_com_segment)),
        //0xA101
        HUITP_MSGID_uni_sw_package_confirm => array("MSGNAME" => "HUITP_MSGID_uni_sw_package_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm,
                            HUITP_IEID_uni_com_segment,
                            HUITP_IEID_uni_sw_package_body)),


        //工厂批量生产相关
        //0xA281
        HUITP_MSGID_uni_equlable_apply_report => array("MSGNAME" => "HUITP_MSGID_uni_equlable_apply_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_equlable_apply_user_info)),
        //0xA201
        HUITP_MSGID_uni_equlable_apply_confirm => array("MSGNAME" => "HUITP_MSGID_uni_equlable_apply_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm,
                            HUITP_IEID_uni_equlable_apply_allocation)),
        //0xA284
        HUITP_MSGID_uni_equlable_userlist_sync_report => array("MSGNAME" => "HUITP_MSGID_uni_equlable_userlist_sync_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_equlable_userlist_sync_report)),
        //0xA204
        HUITP_MSGID_uni_equlable_userlist_sync_confirm => array("MSGNAME" => "HUITP_MSGID_uni_equlable_userlist_sync_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm,
                            HUITP_IEID_uni_equlable_userlist_sync_confirm)),

        //ALARM REPORT
        HUITP_MSGID_uni_alarm_info_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xB000
        HUITP_MSGID_uni_alarm_info_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xB080
        //0xB081
        HUITP_MSGID_uni_alarm_info_report => array("MSGNAME" => "HUITP_MSGID_uni_alarm_info_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_alarm_info_element)),
        //0xB001
        HUITP_MSGID_uni_alarm_info_confirm => array("MSGNAME" => "HUITP_MSGID_uni_alarm_info_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //PM Report
        HUITP_MSGID_uni_performance_info_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xB100
        HUITP_MSGID_uni_performance_info_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xB180
        //0xB181
        HUITP_MSGID_uni_performance_info_report => array("MSGNAME" => "HUITP_MSGID_uni_performance_info_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_performance_info_element)),
        //0xB101
        HUITP_MSGID_uni_performance_info_confirm => array("MSGNAME" => "HUITP_MSGID_uni_performance_info_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm)),

        //设备基本信息
        HUITP_MSGID_uni_equipment_info_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF000
        HUITP_MSGID_uni_equipment_info_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF080
        HUITP_MSGID_uni_equipment_info_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF081
        HUITP_MSGID_uni_equipment_info_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF001

        //个人基本信息
        HUITP_MSGID_uni_personal_info_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF100
        HUITP_MSGID_uni_personal_info_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF180
        HUITP_MSGID_uni_personal_info_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF181
        HUITP_MSGID_uni_personal_info_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF101

        //时间同步
        HUITP_MSGID_uni_time_sync_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF200
        HUITP_MSGID_uni_time_sync_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF280
        HUITP_MSGID_uni_time_sync_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF281
        HUITP_MSGID_uni_time_sync_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF201

        //读取数据
        HUITP_MSGID_uni_general_read_data_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF300
        HUITP_MSGID_uni_general_read_data_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF380
        HUITP_MSGID_uni_general_read_data_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF381
        HUITP_MSGID_uni_general_read_data_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF301

        //定时闹钟及久坐提醒
        HUITP_MSGID_uni_clock_timeout_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF400
        HUITP_MSGID_uni_clock_timeout_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF480
        HUITP_MSGID_uni_clock_timeout_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF481
        HUITP_MSGID_uni_clock_timeout_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF401

        //同步充电，双击情况
        HUITP_MSGID_uni_sync_charging_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF500
        HUITP_MSGID_uni_sync_charging_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF580
        HUITP_MSGID_uni_sync_charging_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF581
        HUITP_MSGID_uni_sync_charging_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF501

        //同步通知信息
        HUITP_MSGID_uni_sync_trigger_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF600
        HUITP_MSGID_uni_sync_trigger_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF680
        HUITP_MSGID_uni_sync_trigger_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF681
        HUITP_MSGID_uni_sync_trigger_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xF601

        //测试命令
        //0xF700
        HUITP_MSGID_uni_test_command_req => array("MSGNAME" => "HUITP_MSGID_uni_test_command_req",
            "MSGIE" => array(HUITP_IEID_uni_com_req,
                            HUITP_IEID_uni_test_command_value)),
        //0xF780
        HUITP_MSGID_uni_test_command_resp => array("MSGNAME" => "HUITP_MSGID_uni_test_command_resp",
            "MSGIE" => array(HUITP_IEID_uni_com_resp,
                            HUITP_IEID_uni_test_command_value)),
        //0xF781
        HUITP_MSGID_uni_test_command_report => array("MSGNAME" => "HUITP_MSGID_uni_test_command_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_test_command_value)),
        //0xF701
        HUITP_MSGID_uni_test_command_confirm => array("MSGNAME" => "HUITP_MSGID_uni_test_command_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm,
                            HUITP_IEID_uni_test_command_value)),

        //CMD CONTROL
        HUITP_MSGID_uni_cmd_ctrl_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xFD00
        HUITP_MSGID_uni_cmd_ctrl_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xFD80
        HUITP_MSGID_uni_cmd_ctrl_report => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xFD81
        HUITP_MSGID_uni_cmd_ctrl_confirm => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xFD01

        //心跳
        HUITP_MSGID_uni_heart_beat_req => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xFE00
        HUITP_MSGID_uni_heart_beat_resp => array("MSGNAME" => "","MSGIE" => array(HUITP_IEID_uni_com_req)),  //0xFE80
        //0xFE81
        HUITP_MSGID_uni_heart_beat_report => array("MSGNAME" => "HUITP_MSGID_uni_heart_beat_report",
            "MSGIE" => array(HUITP_IEID_uni_com_report,
                            HUITP_IEID_uni_heart_beat_ping)),
        //0xFE01
        HUITP_MSGID_uni_heart_beat_confirm => array("MSGNAME" => "HUITP_MSGID_uni_heart_beat_confirm",
            "MSGIE" => array(HUITP_IEID_uni_com_confirm,
                            HUITP_IEID_uni_heart_beat_pong)),

        //无效
        HUITP_MSGID_uni_max => array("MSGNAME" => "HUITP_MSGID_uni_max","MSGIE" => array()),  //0xFFFF
        HUITP_MSGID_uni_null => array("MSGNAME" => "HUITP_MSGID_uni_null","MSGIE" => array()) //0xFFFF

    );

    //定义任务消息（Task-Msg）字典，规定每个任务模块允许收到那些消息，用于消息路由
    public static $mfunL2codecTaskMsgArrayConst = array(
        MFUN_TASK_ID_MIN => array(),
        MFUN_TASK_ID_L1VM => array(),
        MFUN_TASK_ID_L2SDK_IOT_APPLE => array(),
        MFUN_TASK_ID_L2SDK_IOT_JD => array(),
        MFUN_TASK_ID_L2SDK_WECHAT => array(),
        MFUN_TASK_ID_L2SDK_IOT_WX => array(),
        MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK => array(),
        MFUN_TASK_ID_L2SDK_IOT_STDXML => array(),
        MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376 => array(),
        MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188 => array(),
        MFUN_TASK_ID_L2SDK_NBIOT_LTEV => array(),
        MFUN_TASK_ID_L2SDK_NBIOT_AGC => array(),
        MFUN_TASK_ID_L2SDK_IOT_JSON => array(),
        MFUN_TASK_ID_L2SDK_IOT_HUITP => array(),
        MFUN_TASK_ID_L2CODEC_PRIVATE_GTJY => array(),
        MFUN_TASK_ID_L2CODEC_WSDL_YCJK => array(),
        MFUN_TASK_ID_L2DECODE_HUITP => array(),
        MFUN_TASK_ID_L2ENCODE_HUITP => array(HUITP_MSGID_uni_ccl_state_req,
                                            HUITP_MSGID_uni_ccl_state_confirm,
                                            HUITP_MSGID_uni_ccl_state_pic_confirm,
                                            HUITP_MSGID_uni_ccl_lock_auth_resp,
                                            HUITP_MSGID_uni_ccl_lock_req,
                                            HUITP_MSGID_uni_ccl_lock_confirm,
                                            HUITP_MSGID_uni_humid_data_req,
                                            HUITP_MSGID_uni_humid_data_confirm,
                                            HUITP_MSGID_uni_humid_ctrl_req,
                                            HUITP_MSGID_uni_noise_data_req,
                                            HUITP_MSGID_uni_noise_data_confirm,
                                            HUITP_MSGID_uni_noise_ctrl_req,
                                            HUITP_MSGID_uni_pm25_data_req,
                                            HUITP_MSGID_uni_pm25_data_confirm,
                                            HUITP_MSGID_uni_pm25_ctrl_req,
                                            HUITP_MSGID_uni_pm25sp_data_req,
                                            HUITP_MSGID_uni_pm25sp_data_confirm,
                                            HUITP_MSGID_uni_temp_data_req,
                                            HUITP_MSGID_uni_temp_data_confirm,
                                            HUITP_MSGID_uni_temp_ctrl_req,
                                            HUITP_MSGID_uni_winddir_data_req,
                                            HUITP_MSGID_uni_winddir_data_confirm,
                                            HUITP_MSGID_uni_winddir_ctrl_req,
                                            HUITP_MSGID_uni_windspd_data_req,
                                            HUITP_MSGID_uni_windspd_data_confirm,
                                            HUITP_MSGID_uni_windspd_ctrl_req,
                                            HUITP_MSGID_uni_ycjk_data_confirm,
                                            HUITP_MSGID_uni_heart_beat_confirm,
                                            HUITP_MSGID_uni_alarm_info_confirm,
                                            HUITP_MSGID_uni_performance_info_confirm,
                                            HUITP_MSGID_uni_inventory_confirm,
                                            HUITP_MSGID_uni_sw_package_confirm),
        MFUN_TASK_ID_L2SENSOR_COMMON => array(HUITP_MSGID_uni_heart_beat_report,
                                            HUITP_MSGID_uni_alarm_info_report,
                                            HUITP_MSGID_uni_performance_info_report,
                                            HUITP_MSGID_uni_inventory_resp,
                                            HUITP_MSGID_uni_inventory_report,
                                            HUITP_MSGID_uni_sw_package_resp,
                                            HUITP_MSGID_uni_sw_package_report),
        MFUN_TASK_ID_L2SENSOR_EMC => array(),
        MFUN_TASK_ID_L2SENSOR_HSMMP => array(HUITP_MSGID_uni_hsmmp_data_resp,
                                            HUITP_MSGID_uni_hsmmp_data_report,
                                            HUITP_MSGID_uni_hsmmp_ctrl_resp,
                                            HUITP_MSGID_uni_picture_data_report),
        MFUN_TASK_ID_L2SENSOR_HUMID => array(HUITP_MSGID_uni_humid_data_resp,
                                            HUITP_MSGID_uni_humid_data_report,
                                            HUITP_MSGID_uni_humid_ctrl_resp),
        MFUN_TASK_ID_L2SENSOR_NOISE => array(HUITP_MSGID_uni_noise_data_resp,
                                            HUITP_MSGID_uni_noise_data_report,
                                            HUITP_MSGID_uni_noise_ctrl_resp),
        MFUN_TASK_ID_L2SENSOR_PM25 => array(HUITP_MSGID_uni_pm25_data_resp,
                                            HUITP_MSGID_uni_pm25_data_report,
                                            HUITP_MSGID_uni_pm25_ctrl_resp,
                                            HUITP_MSGID_uni_pm25sp_data_resp,
                                            HUITP_MSGID_uni_pm25sp_data_report,
                                            HUITP_MSGID_uni_ycjk_data_report),
        MFUN_TASK_ID_L2SENSOR_TEMP => array(HUITP_MSGID_uni_temp_data_resp,
                                            HUITP_MSGID_uni_temp_data_report,
                                            HUITP_MSGID_uni_temp_ctrl_resp),
        MFUN_TASK_ID_L2SENSOR_WINDDIR => array(HUITP_MSGID_uni_winddir_data_resp,
                                            HUITP_MSGID_uni_winddir_data_report,
                                            HUITP_MSGID_uni_winddir_ctrl_resp),
        MFUN_TASK_ID_L2SENSOR_WINDSPD => array(HUITP_MSGID_uni_windspd_data_resp,
                                            HUITP_MSGID_uni_windspd_data_report,
                                            HUITP_MSGID_uni_windspd_ctrl_resp),
        MFUN_TASK_ID_L2SENSOR_AIRPRS => array(),
        MFUN_TASK_ID_L2SENSOR_ALCOHOL => array(),
        MFUN_TASK_ID_L2SENSOR_CO1 =>array(),
        MFUN_TASK_ID_L2SENSOR_HCHO => array(),
        MFUN_TASK_ID_L2SENSOR_TOXICGAS => array(),
        MFUN_TASK_ID_L2SENSOR_LIGHTSTR => array(),
        MFUN_TASK_ID_L2SENSOR_RAIN => array(),
        MFUN_TASK_ID_L2SENSOR_IPM => array(),
        MFUN_TASK_ID_L2SENSOR_IWM => array(),
        MFUN_TASK_ID_L2SENSOR_IGM => array(),
        MFUN_TASK_ID_L2SENSOR_IHM => array(),
        MFUN_TASK_ID_L2SENSOR_BATT => array(), //FHYS云控锁
        MFUN_TASK_ID_L2SENSOR_BLE => array(),
        MFUN_TASK_ID_L2SENSOR_DOORLOCK => array(),
        MFUN_TASK_ID_L2SENSOR_CCL => array(HUITP_MSGID_uni_ccl_lock_resp,
                                           HUITP_MSGID_uni_ccl_lock_report,
                                           HUITP_MSGID_uni_ccl_lock_auth_inq,
                                           HUITP_MSGID_uni_ccl_state_resp,
                                           HUITP_MSGID_uni_ccl_state_report,
                                           HUITP_MSGID_uni_ccl_state_pic_report),
        MFUN_TASK_ID_L2SENSOR_GPRS => array(),
        MFUN_TASK_ID_L2SENSOR_RFID => array(),
        MFUN_TASK_ID_L2SENSOR_SMOK => array(),
        MFUN_TASK_ID_L2SENSOR_VIBR => array(),
        MFUN_TASK_ID_L2SENSOR_WATER => array(),
        MFUN_TASK_ID_L2SENSOR_WEIGHT => array(), //BFSC组合秤
        MFUN_TASK_ID_L2TIMER_CRON => array(),
        MFUN_TASK_ID_L2SOCKET_LISTEN => array(),
        MFUN_TASK_ID_L2SENSOR_WEIGHT => array(), //BFSC组合秤
        MFUN_TASK_ID_L2SENSOR_FDWQ => array(HUITP_MSGID_uni_fdwq_data_resp,
                                            HUITP_MSGID_uni_fdwq_data_report,
                                            HUITP_MSGID_uni_fdwq_profile_report),
        MFUN_TASK_ID_L2SENSOR_EARTHDIN => array(),
        MFUN_TASK_ID_L3APPL_FUM1SYM => array(),
        MFUN_TASK_ID_L3APPL_FUM2CM => array(),
        MFUN_TASK_ID_L3APPL_FUM3DM => array(),
        MFUN_TASK_ID_L3APPL_FUM4ICM => array(),
        MFUN_TASK_ID_L3APPL_FUM5FM => array(),
        MFUN_TASK_ID_L3APPL_FUM6PM => array(),
        MFUN_TASK_ID_L3APPL_FUM7ADS => array(),
        MFUN_TASK_ID_L3APPL_FUM8PSM => array(),
        MFUN_TASK_ID_L3APPL_FUM9GISM => array(),
        MFUN_TASK_ID_L3APPL_FUMXPRCM => array(),
        MFUN_TASK_ID_L3WX_OPR_EMC => array(),  //用于EMC微信H5界面处理L3 task
        MFUN_TASK_ID_L3WX_OPR_FHYS => array(), //用于FHYS微信H5界面处理L3 task
        MFUN_TASK_ID_L3WX_OPR_FAAM => array(HUITP_MSGID_uni_equlable_apply_report,
                                            HUITP_MSGID_uni_equlable_userlist_sync_report),
        MFUN_TASK_ID_L3NBIOT_OPR_METER => array(),
        MFUN_TASK_ID_L4AQYC_UI => array(),
        MFUN_TASK_ID_L4FHYS_UI => array(),
        MFUN_TASK_ID_L4FHYS_WECHAT => array(),
        MFUN_TASK_ID_L4BFSC_UI => array(),
        MFUN_TASK_ID_L4EMCWX_UI => array(),
        MFUN_TASK_ID_L4TBSWR_UI => array(),
        MFUN_TASK_ID_L4NBIOT_IPM_UI => array(),
        MFUN_TASK_ID_L4NBIOT_IGM_UI => array(),
        MFUN_TASK_ID_L4NBIOT_IWM_UI => array(),
        MFUN_TASK_ID_L4NBIOT_IHM_UI => array(),
        MFUN_TASK_ID_L4OAMTOOLS => array(),
        MFUN_TASK_ID_L5BI => array(),
        MFUN_TASK_ID_MAX => array(),
        MFUN_TASK_ID_NULL => array(),
    );

    //通过MsgId读取IE列表
    public static function mfun_l2codec_getHuitpIeArray($msgId)
    {
        if (isset(self::$mfunL2codecHuitpMsgArrayConst[$msgId])) {
            return self::$mfunL2codecHuitpMsgArrayConst[$msgId];
        }else {
            return false;
        }
    }

    public static function mfun_l2codec_getHuitpDestTaskId($msgId)
    {
        $taskId = 0;
        while ($taskId < MFUN_TASK_ID_MAX)
        {
            $msgArray = array();
            $msgArray = self::$mfunL2codecTaskMsgArrayConst[$taskId];
            for($i=0; $i < count($msgArray); $i++){
                if ($msgArray[$i] == $msgId)
                    return $taskId;
            }
            $taskId++;
        }
        return false;
    }
}
?>