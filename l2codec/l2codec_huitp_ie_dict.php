<?php
/**
 * Created by PhpStorm.
 * User: Zehong Liu
 * Date: 2017/2/13
 * Time: 22:46
 */

/***********************************************************************************************************************
 *                                                   HUITP接口协议v2.2
 **********************************************************************************************************************/

/**********************************************HUITP公共信息单元IE定义***************************************************/
define("HUITP_IEID_uni_min", 0x0000);
define("HUITP_IEID_uni_none", 0x0000);

//公共IE区域
define("HUITP_IEID_uni_com_req", 0x0001);
define("HUITP_IEID_uni_com_resp", 0x0002);
define("HUITP_IEID_uni_com_report", 0x0003);
define("HUITP_IEID_uni_com_confirm", 0x0004);
define("HUITP_IEID_uni_com_state", 0x0010);
define("HUITP_IEID_uni_com_auth", 0x0011);
define("HUITP_IEID_uni_com_warning", 0x0012);
define("HUITP_IEID_uni_com_action", 0x0013);
define("HUITP_IEID_uni_com_switch_onoff", 0x0014);
define("HUITP_IEID_uni_com_command", 0x0015);
define("HUITP_IEID_uni_com_back_type", 0x0016);
define("HUITP_IEID_uni_com_equp_id", 0x0020);
define("HUITP_IEID_uni_com_format_type", 0x0021);
define("HUITP_IEID_uni_com_work_cycle", 0x0022);
define("HUITP_IEID_uni_com_sample_cycle", 0x0023);
define("HUITP_IEID_uni_com_sample_number", 0x0024);
define("HUITP_IEID_uni_com_unix_time", 0x0025);
define("HUITP_IEID_uni_com_ymd_time", 0x0026);
define("HUITP_IEID_uni_com_ntimes", 0x0027);
define("HUITP_IEID_uni_com_gps_x", 0x0028);
define("HUITP_IEID_uni_com_gps_y", 0x0029);
define("HUITP_IEID_uni_com_gps_z", 0x002A);
define("HUITP_IEID_uni_com_gps_direction", 0x002B);
define("HUITP_IEID_uni_com_grade", 0x002C);
define("HUITP_IEID_uni_com_percentage", 0x002E);
define("HUITP_IEID_uni_com_modbus_address", 0x002F);
define("HUITP_IEID_uni_com_file_name", 0x0030);
define("HUITP_IEID_uni_com_http_link", 0x0031);
define("HUITP_IEID_uni_com_segment_total", 0x0032);
define("HUITP_IEID_uni_com_segment_index", 0x0033);

//血糖
define("HUITP_IEID_uni_blood_glucose_min", 0x0100);
define("HUITP_IEID_uni_blood_glucose_value", 0x0100);
define("HUITP_IEID_uni_blood_glucose_max", 0x0100);

//单次运动
define("HUITP_IEID_uni_single_sports_min", 0x0200);
define("HUITP_IEID_uni_single_sports_value", 0x0200);
define("HUITP_IEID_uni_single_sports_max", 0x0200);

//单次睡眠
define("HUITP_IEID_uni_single_sleep_min", 0x0300);
define("HUITP_IEID_uni_single_sleep_value", 0x0300);
define("HUITP_IEID_uni_single_sleep_max", 0x0300);

//体脂
define("HUITP_IEID_uni_body_fat_min", 0x0400);
define("HUITP_IEID_uni_body_fat_value", 0x0400);
define("HUITP_IEID_uni_body_fat_max", 0x0400);

//血压
define("HUITP_IEID_uni_blood_pressure_min", 0x0500);
define("HUITP_IEID_uni_blood_pressure_value", 0x0500);
define("HUITP_IEID_uni_blood_pressure_max", 0x0500);

//跑步机数据上报
define("HUITP_IEID_uni_runner_machine_rep_min", 0x0A00);
define("HUITP_IEID_uni_runner_machine_rep_value", 0x0A00);
define("HUITP_IEID_uni_runner_machine_rep_max", 0x0A00);

//跑步机任务控制
define("HUITP_IEID_uni_runner_machine_ctrl_min", 0x0B00);
define("HUITP_IEID_uni_runner_machine_ctrl_value", 0x0B00);
define("HUITP_IEID_uni_runner_machine_ctrl_max", 0x0B00);

//GPS地址
define("HUITP_IEID_uni_gps_specific_min", 0x0C00);
define("HUITP_IEID_uni_gps_specific_x", 0x0C00);
define("HUITP_IEID_uni_gps_specific_y", 0x0C01);
define("HUITP_IEID_uni_gps_specific_z", 0x0C02);
define("HUITP_IEID_uni_gps_sensor_max", 0x0C02);

//IHU与IAU之间控制命令
define("HUITP_IEID_uni_iau_ctrl_min", 0x1000);
define("HUITP_IEID_uni_iau_ctrl_value", 0x1000);
define("HUITP_IEID_uni_iau_ctrl_max", 0x1000);

//电磁辐射强度
define("HUITP_IEID_uni_emc_data_min", 0x2000);
define("HUITP_IEID_uni_emc_data_value", 0x2000);
define("HUITP_IEID_uni_emc_data_max", 0x2000);

//电磁辐射剂量
define("HUITP_IEID_uni_emc_accu_min", 0x2100);
define("HUITP_IEID_uni_emc_accu_value", 0x2100);
define("HUITP_IEID_uni_emc_accu_max", 0x2100);

//一氧化碳
define("HUITP_IEID_uni_co_min", 0x2200);
define("HUITP_IEID_uni_co_value", 0x2200);
define("HUITP_IEID_uni_co_max", 0x2200);

//甲醛HCHO
define("HUITP_IEID_uni_formaldehyde_min", 0x2300);
define("HUITP_IEID_uni_formaldehyde_value", 0x2300);
define("HUITP_IEID_uni_hcho_value", 0x2301);
define("HUITP_IEID_uni_formaldehyde_max", 0x2301);

//酒精
define("HUITP_IEID_uni_alcohol_min", 0x2400);
define("HUITP_IEID_uni_alcohol_value", 0x2400);
define("HUITP_IEID_uni_alcohol_max", 0x2400);

//PM1/2.5/10
define("HUITP_IEID_uni_pm25_min", 0x2500);
define("HUITP_IEID_uni_pm01_value", 0x2500);
define("HUITP_IEID_uni_pm25_value", 0x2501);
define("HUITP_IEID_uni_pm10_value", 0x2502);
define("HUITP_IEID_uni_pm25_max", 0x2502);

//风速Wind Speed
define("HUITP_IEID_uni_windspd_min", 0x2600);
define("HUITP_IEID_uni_windspd_value", 0x2600);
define("HUITP_IEID_uni_windspd_max", 0x2600);

//风向Wind Direction
define("HUITP_IEID_uni_winddir_min", 0x2700);
define("HUITP_IEID_uni_winddir_value", 0x2700);
define("HUITP_IEID_uni_winddir_max", 0x2700);

//温度Temperature
define("HUITP_IEID_uni_temp_min", 0x2800);
define("HUITP_IEID_uni_temp_value", 0x2800);
define("HUITP_IEID_uni_temp_max", 0x2800);

//湿度Humidity
define("HUITP_IEID_uni_humid_min", 0x2900);
define("HUITP_IEID_uni_humid_value", 0x2900);
define("HUITP_IEID_uni_humid_max", 0x2900);

//气压Air pressure
define("HUITP_IEID_uni_airprs_min", 0x2A00);
define("HUITP_IEID_uni_airprs_value", 0x2A00);
define("HUITP_IEID_uni_airprs_max", 0x2A00);

//噪声Noise
define("HUITP_IEID_uni_noise_min", 0x2B00);
define("HUITP_IEID_uni_noise_value", 0x2B00);
define("HUITP_IEID_uni_noise_max", 0x2B00);

//相机Camer or audio high speed
define("HUITP_IEID_uni_hsmmp_min", 0x2C00);
define("HUITP_IEID_uni_hsmmp_value", 0x2C00);
define("HUITP_IEID_uni_hsmmp_max", 0x2C00);

//声音
define("HUITP_IEID_uni_audio_min", 0x2D00);
define("HUITP_IEID_uni_audio_value", 0x2D00);
define("HUITP_IEID_uni_audio_max", 0x2D00);

//视频
define("HUITP_IEID_uni_video_min", 0x2D00);
define("HUITP_IEID_uni_video_value", 0x2D00);
define("HUITP_IEID_uni_video_max", 0x2D00);

//图片
define("HUITP_IEID_uni_picture_min", 0x2F00);
define("HUITP_IEID_uni_picture_value", 0x2F00);
define("HUITP_IEID_uni_picture_segment", 0x2F01);
define("HUITP_IEID_uni_picture_format", 0x2F02);
define("HUITP_IEID_uni_picture_body", 0x2F03);
define("HUITP_IEID_uni_picture_max", 0x2F03);

//扬尘监控系统
define("HUITP_IEID_uni_ycjk_min", 0x3000);
define("HUITP_IEID_uni_ycjk_value", 0x3000);
define("HUITP_IEID_uni_ycjk_sensor_selection", 0x3001);
define("HUITP_IEID_uni_ycjk_max", 0x3000);

//水表
define("HUITP_IEID_uni_water_meter_min", 0x3100);
define("HUITP_IEID_uni_water_meter_value", 0x3100);
define("HUITP_IEID_uni_water_meter_max", 0x3100);

//热表
define("HUITP_IEID_uni_heat_meter_min", 0x3200);
define("HUITP_IEID_uni_heat_meter_value", 0x3200);
define("HUITP_IEID_uni_heat_meter_max", 0x3200);

//气表
define("HUITP_IEID_uni_gas_meter_min", 0x3300);
define("HUITP_IEID_uni_gas_meter_value", 0x3300);
define("HUITP_IEID_uni_gas_meter_max", 0x3300);

//电表
define("HUITP_IEID_uni_power_meter_min", 0x3400);
define("HUITP_IEID_uni_power_meter_value", 0x3400);
define("HUITP_IEID_uni_power_meter_max", 0x3400);

//光照强度
define("HUITP_IEID_uni_light_strength_min", 0x3500);
define("HUITP_IEID_uni_light_strength_value", 0x3500);
define("HUITP_IEID_uni_light_strength_max", 0x3500);

//有毒气体VOC
define("HUITP_IEID_uni_toxicgas_min", 0x3600);
define("HUITP_IEID_uni_toxicgas_value", 0x3600);
define("HUITP_IEID_uni_toxicgas_max", 0x3600);

//海拔高度
define("HUITP_IEID_uni_altitude_min", 0x3700);
define("HUITP_IEID_uni_altitude_value", 0x3700);
define("HUITP_IEID_uni_altitude_max", 0x3700);

//马达
define("HUITP_IEID_uni_moto_min", 0x3800);
define("HUITP_IEID_uni_moto_value", 0x3800);
define("HUITP_IEID_uni_moto_max", 0x3800);

//继电器
define("HUITP_IEID_uni_switch_resistor_min", 0x3900);
define("HUITP_IEID_uni_switch_resistor_value", 0x3900);
define("HUITP_IEID_uni_switch_resistor_max", 0x3900);

//导轨传送带
define("HUITP_IEID_uni_transporter_min", 0x3A00);
define("HUITP_IEID_uni_transporter_value", 0x3A00);
define("HUITP_IEID_uni_transporter_max", 0x3A00);

//组合秤BFSC
define("HUITP_IEID_uni_bfsc_comb_scale_min", 0x3B00);
define("HUITP_IEID_uni_scale_weight_value", 0x3B00);
define("HUITP_IEID_uni_scale_weight_cmd", 0x3B01);
define("HUITP_IEID_uni_bfsc_comb_scale_max", 0x3B01);

//云控锁-锁-旧系统
define("HUITP_IEID_uni_ccl_lock_old_min", 0x4000);
define("HUITP_IEID_uni_ccl_lock_old_state", 0x4000);
define("HUITP_IEID_uni_ccl_lock_old_auth_req", 0x4001);
define("HUITP_IEID_uni_ccl_lock_old_auth_resp", 0x4002);
define("HUITP_IEID_uni_ccl_lock_old_max", 0x4002);

//云控锁-门
define("HUITP_IEID_uni_ccl_door_min", 0x4100);
define("HUITP_IEID_uni_ccl_door_state", 0x4100);
define("HUITP_IEID_uni_ccl_door_max", 0x4100);

//云控锁-RFID模块
define("HUITP_IEID_uni_ccl_rfid_min", 0x4200);
define("HUITP_IEID_uni_ccl_rfid_value", 0x4200);
define("HUITP_IEID_uni_ccl_rfid_max", 0x4200);

//云控锁-BLE模块
define("HUITP_IEID_uni_ccl_ble_min", 0x4300);
define("HUITP_IEID_uni_ccl_ble_value", 0x4300);
define("HUITP_IEID_uni_ccl_ble_max", 0x4300);

//云控锁-GPRS模块
define("HUITP_IEID_uni_ccl_gprs_min", 0x4400);
define("HUITP_IEID_uni_ccl_rssi_value", 0x4400);
define("HUITP_IEID_uni_ccl_gprs_max", 0x4400);

//云控锁-电池模块
define("HUITP_IEID_uni_ccl_battery_min", 0x4500);
define("HUITP_IEID_uni_ccl_bat_state", 0x4500);
define("HUITP_IEID_uni_ccl_bat_value", 0x4501);
define("HUITP_IEID_uni_ccl_battery_max", 0x4501);

//云控锁-震动
define("HUITP_IEID_uni_ccl_shake_min", 0x4600);
define("HUITP_IEID_uni_ccl_shake_state", 0x4600);
define("HUITP_IEID_uni_ccl_shake_max", 0x4600);

//云控锁-烟雾
define("HUITP_IEID_uni_ccl_smoke_min", 0x4700);
define("HUITP_IEID_uni_ccl_smoke_state", 0x4700);
define("HUITP_IEID_uni_ccl_smoke_max", 0x4700);

//云控锁-水浸
define("HUITP_IEID_uni_ccl_water_min", 0x4800);
define("HUITP_IEID_uni_ccl_water_state", 0x4800);
define("HUITP_IEID_uni_ccl_water_max", 0x4800);

//云控锁-温度
define("HUITP_IEID_uni_ccl_temp_min", 0x4900);
define("HUITP_IEID_uni_ccl_temp_value", 0x4900);
define("HUITP_IEID_uni_ccl_temp_max", 0x4900);

//云控锁-湿度
define("HUITP_IEID_uni_ccl_humid_min", 0x4A00);
define("HUITP_IEID_uni_ccl_humid_value", 0x4A00);
define("HUITP_IEID_uni_ccl_humid_max", 0x4A00);

//云控锁-倾倒
define("HUITP_IEID_uni_ccl_fall_min", 0x4B00);
define("HUITP_IEID_uni_ccl_fall_state", 0x4B00);
define("HUITP_IEID_uni_ccl_fall_max", 0x4B00);

//云控锁-状态聚合-旧系统
define("HUITP_IEID_uni_ccl_state_old_min", 0x4C00);
define("HUITP_IEID_uni_ccl_general_old_value1", 0x4C00);
define("HUITP_IEID_uni_ccl_general_old_value2", 0x4C01);
define("HUITP_IEID_uni_ccl_dcmi_old_value", 0x4C02);
define("HUITP_IEID_uni_ccl_report_old_type", 0x4C03);
define("HUITP_IEID_uni_ccl_state_old_max", 0x4C03);

//云控锁-锁
define("HUITP_IEID_uni_ccl_lock_min", 0x4D00);
define("HUITP_IEID_uni_ccl_lock_state", 0x4D00);
define("HUITP_IEID_uni_ccl_lock_auth_req", 0x4D01);
define("HUITP_IEID_uni_ccl_lock_auth_resp", 0x4D02);
define("HUITP_IEID_uni_ccl_lock_max", 0x4D02);

//云控锁-状态聚合
define("HUITP_IEID_uni_ccl_state_min", 0x4E00);
define("HUITP_IEID_uni_ccl_general_value1", 0x4E00);
define("HUITP_IEID_uni_ccl_general_value2", 0x4E01);
define("HUITP_IEID_uni_ccl_dcmi_value", 0x4E02);
define("HUITP_IEID_uni_ccl_report_type", 0x4E03);
define("HUITP_IEID_uni_ccl_state_max", 0x4E03);


//串口读取命令/返回结果
define("HUITP_IEID_uni_itf_sps_min", 0x5000);
define("HUITP_IEID_uni_itf_sps_value", 0x5000);
define("HUITP_IEID_uni_itf_sps_max", 0x5000);

//ADC读取命令/返回结果
define("HUITP_IEID_uni_itf_adc_min", 0x5100);
define("HUITP_IEID_uni_itf_adc_value", 0x5100);
define("HUITP_IEID_uni_itf_adc_max", 0x5100);

//DAC读取命令/返回结果
define("HUITP_IEID_uni_itf_dac_min", 0x5200);
define("HUITP_IEID_uni_itf_dac_value", 0x5200);
define("HUITP_IEID_uni_itf_dac_max", 0x5200);

//I2C读取命令/返回结果
define("HUITP_IEID_uni_itf_i2c_min", 0x5300);
define("HUITP_IEID_uni_itf_i2c_value", 0x5300);
define("HUITP_IEID_uni_itf_i2c_max", 0x5300);

//PWM读取命令/返回结果
define("HUITP_IEID_uni_itf_pwm_min", 0x5400);
define("HUITP_IEID_uni_itf_pwm_value", 0x5400);
define("HUITP_IEID_uni_itf_pwm_max", 0x5400);

//DI读取命令/返回结果
define("HUITP_IEID_uni_itf_di_min", 0x5500);
define("HUITP_IEID_uni_itf_di_value", 0x5500);
define("HUITP_IEID_uni_itf_di_max", 0x5500);

//DO读取命令/返回结果
define("HUITP_IEID_uni_itf_do_min", 0x5600);
define("HUITP_IEID_uni_itf_do_value", 0x5600);
define("HUITP_IEID_uni_itf_do_max", 0x5600);

//CAN读取命令/返回结果
define("HUITP_IEID_uni_itf_can_min", 0x5700);
define("HUITP_IEID_uni_itf_can_value", 0x5700);
define("HUITP_IEID_uni_itf_can_max", 0x5700);

//SPI读取命令/返回结果
define("HUITP_IEID_uni_itf_spi_min", 0x5800);
define("HUITP_IEID_uni_itf_spi_value", 0x5800);
define("HUITP_IEID_uni_itf_spi_max", 0x5800);

//USB读取命令/返回结果
define("HUITP_IEID_uni_itf_usb_min", 0x5900);
define("HUITP_IEID_uni_itf_usb_value", 0x5900);
define("HUITP_IEID_uni_itf_usb_max", 0x5900);

//网口读取命令/返回结果
define("HUITP_IEID_uni_itf_eth_min", 0x5A00);
define("HUITP_IEID_uni_itf_eth_value", 0x5A00);
define("HUITP_IEID_uni_itf_eth_max", 0x5A00);

//485读取命令/返回结果
define("HUITP_IEID_uni_itf_485_min", 0x5B00);
define("HUITP_IEID_uni_itf_485_value", 0x5B00);
define("HUITP_IEID_uni_itf_485_max", 0x5B00);

//软件清单
define("HUITP_IEID_uni_inventory_min", 0xA000);
//define("HUITP_IEID_uni_inventory_hw_type", 0xA000);
define("HUITP_IEID_uni_inventory_element", 0xA000);
define("HUITP_IEID_uni_inventory_hw_id", 0xA001);
define("HUITP_IEID_uni_inventory_sw_rel", 0xA002);
define("HUITP_IEID_uni_inventory_sw_ver", 0xA003);
define("HUITP_IEID_uni_inventory_max", 0xA003);

//软件版本体
define("HUITP_IEID_uni_sw_package_min", 0xA100);
define("HUITP_IEID_uni_sw_package_body", 0xA100);
define("HUITP_IEID_uni_sw_package_max", 0xA100);

//ALARM REPORT
define("HUITP_IEID_uni_alarm_info_min", 0xB000);
//define("HUITP_IEID_uni_alarm_info_type", 0xB000);
define("HUITP_IEID_uni_alarm_info_element", 0xB000);
define("HUITP_IEID_uni_alarm_info_value", 0xB001);
define("HUITP_IEID_uni_alarm_info_max", 0xB001);

//PM Report
define("HUITP_IEID_uni_performance_info_min", 0xB100);
//define("HUITP_IEID_uni_performance_info_type", 0xB100);
define("HUITP_IEID_uni_performance_info_element", 0xB100);
define("HUITP_IEID_uni_performance_info_value", 0xB101);
define("HUITP_IEID_uni_performance_info_max", 0xB101);

//设备基本信息
define("HUITP_IEID_uni_equipment_info_min", 0xF000);
define("HUITP_IEID_uni_equipment_info_value", 0xF000);
define("HUITP_IEID_uni_equipment_info_max", 0xF000);

//个人基本信息
define("HUITP_IEID_uni_personal_info_min", 0xF100);
define("HUITP_IEID_uni_personal_info_value", 0xF100);
define("HUITP_IEID_uni_personal_info_max", 0xF100);

//时间同步
define("HUITP_IEID_uni_time_sync_min", 0xF200);
define("HUITP_IEID_uni_time_sync_value", 0xF200);
define("HUITP_IEID_uni_time_sync_max", 0xF200);

//读取数据
define("HUITP_IEID_uni_general_read_data_min", 0xF300);
define("HUITP_IEID_uni_general_read_data_value", 0xF300);
define("HUITP_IEID_uni_general_read_data_max", 0xF300);

//定时闹钟及久坐提醒
define("HUITP_IEID_uni_clock_timeout_min", 0xF400);
define("HUITP_IEID_uni_clock_timeout_value", 0xF400);
define("HUITP_IEID_uni_clock_timeout_max", 0xF400);

//同步充电，双击情况
define("HUITP_IEID_uni_sync_charging_min", 0xF500);
define("HUITP_IEID_uni_sync_charging_value", 0xF500);
define("HUITP_IEID_uni_sync_charging_max", 0xF500);

//同步通知信息
define("HUITP_IEID_uni_sync_trigger_min", 0xF600);
define("HUITP_IEID_uni_sync_trigger_value", 0xF600);
define("HUITP_IEID_uni_sync_trigger_max", 0xF600);

//CMD CONTROL
define("HUITP_IEID_uni_cmd_ctrl_min", 0xFD00);
define("HUITP_IEID_uni_cmd_ctrl_send", 0xFD00);
define("HUITP_IEID_uni_cmd_ctrl_confirm", 0xFD01);
define("HUITP_IEID_uni_cmd_ctrl_max", 0xFD01);

//心跳
define("HUITP_IEID_uni_heart_beat_min", 0xFE00);
define("HUITP_IEID_uni_heart_beat_ping", 0xFE00);
define("HUITP_IEID_uni_heart_beat_pong", 0xFE01);
define("HUITP_IEID_uni_heart_beat_max", 0xFE01);

//最大值
define("HUITP_IEID_uni_max", 0xFE01);

//无效
define("HUITP_IEID_uni_null", 0xFFFF);


/*******************************************HUITP公共信息单元IE格式字典定义***********************************************/

class classL2codecHuitpIeDict
{
      public static $huitpIeFormatArrayConst = array(
          HUITP_IEID_uni_min                              => "",
          HUITP_IEID_uni_none                             => "",

          //公共IE区域
          HUITP_IEID_uni_com_req                          => array("format"=>"A4ieId/A4ieLen/A2comReq","name"=>"HUITP_IEID_uni_com_req"),
          HUITP_IEID_uni_com_resp                         => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_report                       => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_confirm                      => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_state                        => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_auth                         => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_warning                      => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_action                       => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_switch_onoff                 => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_command                      => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_back_type                    => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_equp_id                      => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_format_type                  => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_work_cycle                   => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_sample_cycle                 => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_sample_number                => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_unix_time                    => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_ymd_time                     => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_ntimes                       => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_gps_x                        => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_gps_y                        => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_gps_z                        => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_gps_direction                => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_grade                        => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_percentage                   => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_modbus_address               => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_file_name                    => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_http_link                    => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_segment_total                => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_com_segment_index                => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //血糖
          HUITP_IEID_uni_blood_glucose_min                => "",
          HUITP_IEID_uni_blood_glucose_value              => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //单次运动
          HUITP_IEID_uni_single_sports_min                => "",
          HUITP_IEID_uni_single_sports_value              => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //单次睡眠
          HUITP_IEID_uni_single_sleep_min                 => "",
          HUITP_IEID_uni_single_sleep_value               => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //体脂
          HUITP_IEID_uni_body_fat_min                     => "",
          HUITP_IEID_uni_body_fat_value                   => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //血压
          HUITP_IEID_uni_blood_pressure_min               => "",
          HUITP_IEID_uni_blood_pressure_value             => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //跑步机数据上报
          HUITP_IEID_uni_runner_machine_rep_min           => "",
          HUITP_IEID_uni_runner_machine_rep_value         => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //跑步机任务控制
          HUITP_IEID_uni_runner_machine_ctrl_min          => "",
          HUITP_IEID_uni_runner_machine_ctrl_value        => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //GPS地址
          HUITP_IEID_uni_gps_specific_min                 => "",
          HUITP_IEID_uni_gps_specific_x                   => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_gps_specific_y                   => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_gps_specific_z                   => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //IHU与IAU之间控制命令
          HUITP_IEID_uni_iau_ctrl_min                     => "",
          HUITP_IEID_uni_iau_ctrl_value                   => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //电磁辐射强度
          HUITP_IEID_uni_emc_data_min                     => "",
          HUITP_IEID_uni_emc_data_value                   => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //电磁辐射剂量
          HUITP_IEID_uni_emc_accu_min                     => "",
          HUITP_IEID_uni_emc_accu_value                   => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //一氧化碳
          HUITP_IEID_uni_co_min                           => "",
          HUITP_IEID_uni_co_value                         => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //甲醛HCHO
          HUITP_IEID_uni_formaldehyde_min                 => "",
          HUITP_IEID_uni_formaldehyde_value               => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_hcho_value                       => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //酒精
          HUITP_IEID_uni_alcohol_min                      => "",
          HUITP_IEID_uni_alcohol_value                    => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //PM1/2.5/10
          HUITP_IEID_uni_pm25_min                         => "",
          HUITP_IEID_uni_pm01_value                       => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A8pm01Value/A8timeStamp","name"=>"HUITP_IEID_uni_pm01_value"),
          HUITP_IEID_uni_pm25_value                       => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A8pm25Value/A8timeStamp","name"=>"HUITP_IEID_uni_pm25_value"),
          HUITP_IEID_uni_pm10_value                       => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A8pm10Value/A8timeStamp","name"=>"HUITP_IEID_uni_pm10_value"),

          //风速Wind Speed
          HUITP_IEID_uni_windspd_min                      => "",
          HUITP_IEID_uni_windspd_value                    => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A8windspdValue/A8timeStamp","name"=>"HUITP_IEID_uni_windspd_value"),

          //风向Wind Direction
          HUITP_IEID_uni_winddir_min                      => "n",
          HUITP_IEID_uni_winddir_value                    => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A8winddirValue/A8timeStamp","name"=>"HUITP_IEID_uni_winddir_value"),

          //温度Temperature
          HUITP_IEID_uni_temp_min                         => "",
          HUITP_IEID_uni_temp_value                       => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A8tempValue/A8timeStamp","name"=>"HUITP_IEID_uni_temp_value"),

          //湿度Humidity
          HUITP_IEID_uni_humid_min                        => "",
          HUITP_IEID_uni_humid_value                      => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A8humidValue/A8timeStamp","name"=>"HUITP_IEID_uni_humid_value"),

          //气压Air pressure
          HUITP_IEID_uni_airprs_min                       => "",
          HUITP_IEID_uni_airprs_value                     => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //噪声Noise
          HUITP_IEID_uni_noise_min                        => "",
          HUITP_IEID_uni_noise_value                      => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A8noiseValue/A8timeStamp","name"=>"HUITP_IEID_uni_noise_value"),

          //相机Camer or audio high speed
          HUITP_IEID_uni_hsmmp_min                        => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_hsmmp_value                      => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //声音
          HUITP_IEID_uni_audio_min                        => "",
          HUITP_IEID_uni_audio_value                      => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //视频
          HUITP_IEID_uni_video_min                        => "",
          HUITP_IEID_uni_video_value                      => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //图片
          HUITP_IEID_uni_picture_min                      => "",
          HUITP_IEID_uni_picture_value                    => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_picture_segment                  => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_picture_format                  	=> array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_picture_body                  	=> array("format"=>"A4ieId/A4ieLen","name"=>""),

          //扬尘监控系统
          HUITP_IEID_uni_ycjk_min                         => "",
          HUITP_IEID_uni_ycjk_value                       => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_ycjk_sensor_selection            => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //水表
          HUITP_IEID_uni_water_meter_min                  => "n",
          HUITP_IEID_uni_water_meter_value                => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //热表
          HUITP_IEID_uni_heat_meter_min                   => "",
          HUITP_IEID_uni_heat_meter_value                 => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //气表
          HUITP_IEID_uni_gas_meter_min                    => "",
          HUITP_IEID_uni_gas_meter_value                  => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //电表
          HUITP_IEID_uni_power_meter_min                  => "",
          HUITP_IEID_uni_power_meter_value                => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //光照强度
          HUITP_IEID_uni_light_strength_min               => "",
          HUITP_IEID_uni_light_strength_value             => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //有毒气体VOC
          HUITP_IEID_uni_toxicgas_min                     => "",
          HUITP_IEID_uni_toxicgas_value                   => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //海拔高度
          HUITP_IEID_uni_altitude_min                     => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_altitude_value                   => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //马达
          HUITP_IEID_uni_moto_min                         => "",
          HUITP_IEID_uni_moto_value                       => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //继电器
          HUITP_IEID_uni_switch_resistor_min              => "",
          HUITP_IEID_uni_switch_resistor_value            => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //导轨传送带
          HUITP_IEID_uni_transporter_min                  => "",
          HUITP_IEID_uni_transporter_value                => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //组合秤BFSC
          HUITP_IEID_uni_bfsc_comb_scale_min              => "",
          HUITP_IEID_uni_scale_weight_value               => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_scale_weight_cmd                 => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //云控锁-锁-旧系统
          HUITP_IEID_uni_ccl_lock_old_min                 => "",
          HUITP_IEID_uni_ccl_lock_old_state               => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_ccl_lock_old_auth_req            => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_ccl_lock_old_auth_resp           => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //云控锁-门
          HUITP_IEID_uni_ccl_door_min                     => "",
          HUITP_IEID_uni_ccl_door_state                   => array("format"=>"A4ieId/A4ieLen/A2maxDoorNo/A2doorId/A2door_1/A2door_2/A2door_3/A2door_4","name"=>"HUITP_IEID_uni_ccl_door_state"),

          //云控锁-RFID模块
          HUITP_IEID_uni_ccl_rfid_min                     => "",
          HUITP_IEID_uni_ccl_rfid_value                   => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //云控锁-BLE模块
          HUITP_IEID_uni_ccl_ble_min                      => "",
          HUITP_IEID_uni_ccl_ble_value                    => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //云控锁-GPRS模块
          HUITP_IEID_uni_ccl_gprs_min                     => "",
          HUITP_IEID_uni_ccl_rssi_value                   => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A4rssiValue","name"=>"HUITP_IEID_uni_ccl_rssi_value"),

          //云控锁-电池模块
          HUITP_IEID_uni_ccl_battery_min                  => "",
          HUITP_IEID_uni_ccl_bat_state                    => array("format"=>"A4ieId/A4ieLen/A2batState","name"=>"HUITP_IEID_uni_ccl_bat_state"),
          HUITP_IEID_uni_ccl_bat_value                    => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A4batValue","name"=>"HUITP_IEID_uni_ccl_bat_value"),

          //云控锁-震动
          HUITP_IEID_uni_ccl_shake_min                    => "",
          HUITP_IEID_uni_ccl_shake_state                  => array("format"=>"A4ieId/A4ieLen/A2shakeState","name"=>"HUITP_IEID_uni_ccl_shake_state"),

          //云控锁-烟雾
          HUITP_IEID_uni_ccl_smoke_min                    => "",
          HUITP_IEID_uni_ccl_smoke_state                  => array("format"=>"A4ieId/A4ieLen/A2smokeState","name"=>"HUITP_IEID_uni_ccl_smoke_state"),

          //云控锁-水浸
          HUITP_IEID_uni_ccl_water_min                    => "",
          HUITP_IEID_uni_ccl_water_state                  => array("format"=>"A4ieId/A4ieLen/A2waterState","name"=>"HUITP_IEID_uni_ccl_water_state"),

          //云控锁-温度
          HUITP_IEID_uni_ccl_temp_min                     => "",
          HUITP_IEID_uni_ccl_temp_value                   => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A4tempValue","name"=>"HUITP_IEID_uni_ccl_temp_value"),

          //云控锁-湿度
          HUITP_IEID_uni_ccl_humid_min                    => "",
          HUITP_IEID_uni_ccl_humid_value                  => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A4humidValue","name"=>"HUITP_IEID_uni_ccl_humid_value"),

          //云控锁-倾倒
          HUITP_IEID_uni_ccl_fall_min                     => "",
          HUITP_IEID_uni_ccl_fall_state                   => array("format"=>"A4ieId/A4ieLen/A2fallState","name"=>"HUITP_IEID_uni_ccl_fall_state"),

          //云控锁-状态聚合-旧系统
          HUITP_IEID_uni_ccl_state_old_min                => "",
          HUITP_IEID_uni_ccl_general_old_value1           => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_ccl_general_old_value2           => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_ccl_dcmi_old_value               => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_ccl_report_old_type              => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //云控锁-锁
          HUITP_IEID_uni_ccl_lock_min                 	=> "",
          HUITP_IEID_uni_ccl_lock_state               	=> array("format"=>"A4ieId/A4ieLen/A2maxLockNo/A2lockId/A2lock_1/A2lock_2/A2lock_3/A2lock_4","name"=>"HUITP_IEID_uni_ccl_lock_state"),
          HUITP_IEID_uni_ccl_lock_auth_req            	=> array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_ccl_lock_auth_resp           	=> array("format"=>"A4ieId/A4ieLen","name"=>""),

          //云控锁-状态聚合
          HUITP_IEID_uni_ccl_state_min                    => "",
          HUITP_IEID_uni_ccl_general_value1               => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A4generalValue1","name"=>"HUITP_IEID_uni_ccl_general_value1"),
          HUITP_IEID_uni_ccl_general_value2               => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A4generalValue1","name"=>"HUITP_IEID_uni_ccl_general_value2"),
          HUITP_IEID_uni_ccl_dcmi_value                   => array("format"=>"A4ieId/A4ieLen/A2dataFormat/A4dcmiValue","name"=>"HUITP_IEID_uni_ccl_dcmi_value"),
          HUITP_IEID_uni_ccl_report_type                  => array("format"=>"A4ieId/A4ieLen/A2event","name"=>"HUITP_IEID_uni_ccl_report_type"),

          //串口读取命令/返回结果
          HUITP_IEID_uni_itf_sps_min                      => "",
          HUITP_IEID_uni_itf_sps_value                    => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //ADC读取命令/返回结果
          HUITP_IEID_uni_itf_adc_min                      => "",
          HUITP_IEID_uni_itf_adc_value                    => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //DAC读取命令/返回结果
          HUITP_IEID_uni_itf_dac_min                      => "",
          HUITP_IEID_uni_itf_dac_value                    => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //I2C读取命令/返回结果
          HUITP_IEID_uni_itf_i2c_min                      => "",
          HUITP_IEID_uni_itf_i2c_value                    => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //PWM读取命令/返回结果
          HUITP_IEID_uni_itf_pwm_min                      => "",
          HUITP_IEID_uni_itf_pwm_value                    => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //DI读取命令/返回结果
          HUITP_IEID_uni_itf_di_min                       => "",
          HUITP_IEID_uni_itf_di_value                     => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //DO读取命令/返回结果
          HUITP_IEID_uni_itf_do_min                       => "",
          HUITP_IEID_uni_itf_do_value                     => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //CAN读取命令/返回结果
          HUITP_IEID_uni_itf_can_min                      => "",
          HUITP_IEID_uni_itf_can_value                    => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //SPI读取命令/返回结果
          HUITP_IEID_uni_itf_spi_min                      => "",
          HUITP_IEID_uni_itf_spi_value                    => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //USB读取命令/返回结果
          HUITP_IEID_uni_itf_usb_min                      => "",
          HUITP_IEID_uni_itf_usb_value                    => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //网口读取命令/返回结果
          HUITP_IEID_uni_itf_eth_min                      => "",
          HUITP_IEID_uni_itf_eth_value                    => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //485读取命令/返回结果
          HUITP_IEID_uni_itf_485_min                      => "",
          HUITP_IEID_uni_itf_485_value                    => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //软件清单
          HUITP_IEID_uni_inventory_min                    => "",
          //HUITP_IEID_uni_inventory_hw_type                => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_inventory_element                => array("format"=>"A4ieId/A4ieLen/A4hwType/A4hwId/A4swRel/A4swVer/A2upgradeFlag/A100desc/A8timeStamp","name"=>"HUITP_IEID_uni_inventory_element"),
          HUITP_IEID_uni_inventory_hw_id                  => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_inventory_sw_rel                 => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_inventory_sw_ver                 => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //软件版本体
          HUITP_IEID_uni_sw_package_min                   => "",
          HUITP_IEID_uni_sw_package_body                  => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //ALARM REPORT
          HUITP_IEID_uni_alarm_info_min                   => "",
          //HUITP_IEID_uni_alarm_info_type                  => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_alarm_info_element               => array("format"=>"A4ieId/A4ieLen/A4alarmType/A2alarmServerity/A2alarmClearFlag/A8equID/A8causeId/A8alarmContent/A200alarmDesc/A8timeStamp","name"=>"HUITP_IEID_uni_alarm_info_element"),
          HUITP_IEID_uni_alarm_info_value                 => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //PM Report
          HUITP_IEID_uni_performance_info_min             => "",
          //HUITP_IEID_uni_performance_info_type            => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_performance_info_element         => array("format"=>"A4ieId/A4ieLen/A8restartCnt/A8networkConnCnt/A8networkConnFailCnt/A8networkDiscCnt/A8socketDiscCnt/A8cpuOccupy/A8memOccupy/A8diskOccupy/A8timeStamp","name"=>"HUITP_IEID_uni_performance_info_element"),
          HUITP_IEID_uni_performance_info_value           => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //设备基本信息
          HUITP_IEID_uni_equipment_info_min               => "",
          HUITP_IEID_uni_equipment_info_value             => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //个人基本信息
          HUITP_IEID_uni_personal_info_min                => "",
          HUITP_IEID_uni_personal_info_value              => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //时间同步
          HUITP_IEID_uni_time_sync_min                    => "",
          HUITP_IEID_uni_time_sync_value                  => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //读取数据
          HUITP_IEID_uni_general_read_data_min            => "",
          HUITP_IEID_uni_general_read_data_value          => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //定时闹钟及久坐提醒
          HUITP_IEID_uni_clock_timeout_min                => "",
          HUITP_IEID_uni_clock_timeout_value              => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //同步充电，双击情况
          HUITP_IEID_uni_sync_charging_min                => "",
          HUITP_IEID_uni_sync_charging_value              => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //同步通知信息
          HUITP_IEID_uni_sync_trigger_min                 => "",
          HUITP_IEID_uni_sync_trigger_value               => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //CMD CONTROL
          HUITP_IEID_uni_cmd_ctrl_min                     => "",
          HUITP_IEID_uni_cmd_ctrl_send                    => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_cmd_ctrl_confirm                 => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //心跳
          HUITP_IEID_uni_heart_beat_min                   => "",
          HUITP_IEID_uni_heart_beat_ping                  => array("format"=>"A4ieId/A4ieLen","name"=>""),
          HUITP_IEID_uni_heart_beat_pong                  => array("format"=>"A4ieId/A4ieLen","name"=>""),

          //最大值
          HUITP_IEID_uni_max                              => "",

          //无效
          HUITP_IEID_uni_null                             => "",
   );

    //通过IeId读取IE格式信息
    public static function mfun_l2codec_getHuitpIeFormat($ieId)
    {
        if (isset(self::$huitpIeFormatArrayConst[$ieId])) {
            return self::$huitpIeFormatArrayConst[$ieId];
        }else {
            return false;
        }
    }

}

?>