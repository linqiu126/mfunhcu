<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 13:16
 */

//由于PHP中无法定义结构，而且消息就是两个模块之间协商的结构，故而这里不再定义详细的消息结构，留给两个任务自行确定
//这里只是定义了消息ID。由于消息ID的多寡并没有太多限制，建议未来不要在消息内部区分不同的子消息，而是平铺直叙，一个消息
//完成一个任务功能，所以两个任务之间可以定义多个消息
define("MSG_ID_MFUN_MIN", 0);
define("MSG_ID_L1VM_TO_L2SDK_WECHAT_INCOMING", 1);
define("MSG_ID_WECHAT_TO_L2SDK_IOT_WX_INCOMING", 2);
define("MSG_ID_IOTWX_TO_L2SDK_IOT_WX_JSSDK_INCOMING", 3);
define("MSG_ID_L1VM_TO_L2SDK_IOT_HCU_INCOMING", 4);
define("MSG_ID_L1VM_TO_L2SDK_IOT_APPLE_INCOMING", 5);
define("MSG_ID_L1VM_TO_L2SDK_IOT_JD_INCOMING", 6);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_EMC", 7);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_EMC_DATA_READ_INSTANT", 8);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_EMC_DATA_REPORT_TIMING", 9);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_HSMMP", 10);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_HSMMP_DATA_READ_INSTANT", 11);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_HSMMP_DATA_REPORT_TIMING", 12);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_HUMID", 13);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_HUMID_DATA_READ_INSTANT", 14);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_HUMID_DATA_REPORT_TIMING", 15);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_NOISE", 16);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_NOISE_DATA_READ_INSTANT", 17);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_NOISE_DATA_REPORT_TIMING", 18);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_PM25", 19);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_PM25_DATA_READ_INSTANT", 20);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_PM25_DATA_REPORT_TIMING", 21);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_TEMP", 22);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_TEMP_DATA_READ_INSTANT", 23);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_TEMP_DATA_REPORT_TIMING", 24);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_WINDDIR", 25);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_WINDDIR_DATA_READ_INSTANT", 26);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_WINDDIR_DATA_REPORT_TIMING", 27);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_WINDSPD", 28);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_WINDSPD_DATA_READ_INSTANT", 29);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_WINDSPD_DATA_REPORT_TIMING", 30);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_AIRPRS", 31);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_AIRPRS_DATA_READ_INSTANT", 32);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_AIRPRS_DATA_REPORT_TIMING", 33);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_ALCOHOL", 34);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_ALCOHOL_DATA_READ_INSTANT", 35);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_ALCOHOL_DATA_REPORT_TIMING", 36);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_CO1", 37);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_CO1_DATA_READ_INSTANT", 38);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_CO1_DATA_REPORT_TIMING", 39);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_HCHO", 40);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_HCHO_DATA_READ_INSTANT", 41);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_HCHO_DATA_REPORT_TIMING", 42);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_TOXICGAS", 43);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_TOXICGAS_DATA_READ_INSTANT", 44);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_TOXICGAS_DATA_REPORT_TIMING", 45);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_LIGHTSTR", 46);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_LIGHTSTR_DATA_READ_INSTANT", 47);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_LIGHTSTR_DATA_REPORT_TIMING", 48);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_RAIN", 49);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_RAIN_DATA_READ_INSTANT", 50);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_RAIN_DATA_REPORT_TIMING", 51);
define("MSG_ID_MFUN_MAX", 100);

/**************************************************************************************
 *                             公共消息全局量定义                                     *
 *************************************************************************************/
define("TIME_GRID_SIZE", 1); //定义用于数据存储的时间网格为。单位为分钟

define("XML_FORMAT", "<x"); //XML数据格式，消息以<xml开头
define("ZHB_FORMAT", "##"); //中环保数据格式，消息以##开头

define("IHU_MSG_HEAD_FORMAT", "A4MagicCode/A4Version/A4Length/A4CmdId/A4Seq/A4ErrCode");
define("IHU_MSG_HEAD_LENGTH", 24); //12 Byte
define("HCU_MSG_HEAD_FORMAT", "A2Key/A2Len/A2Cmd");// 1B 控制字ctrl_key, 1B 长度length（除控制字和长度本身外），1B 操作字opt_key
define("HCU_MSG_HEAD_LENGTH", 6); //3 Byte

define("MFUN_PLTF_WX", 0x01);  //微信平台
define("MFUN_PLTF_HCU", 0x02); //HCU平台
define("MFUN_PLTF_JD", 0x03);  //京东平台


//用于区分WECHAT->IOT_HCU的处理内容及过程
define("MFUN_IOT_WX_DEVICE_TEXT","DEVICE_TEXT");
define("MFUN_IOT_WX_DEVICE_EVENT","DEVICE_EVENT");

//层三处理消息的定义，保留，暂时没有使用
define("L3_HEAD_MAGIC", 0xFE);
define("L3_HEAD_VERSION",0x01);
define("L3_HEAD_LENGTH", 0x08);
define("MFUN_CMDID_SEND_TEXT_REQ", 0x1);    //HW -> CLOUD
define("MFUN_CMDID_SEND_TEXT_RESP", 0x1001);   //CLOUD ->HW
define("MFUN_CMDID_OPEN_LIGHT_PUSH", 0x2001);  //CLOUD ->HW
define("MFUN_CMDID_CLOSE_LIGHT_PUSH", 0x2002);   //CLOUD ->HW
define("MFUN_CMDID_HW_VERSION_REQ", 0x3001);
define("MFUN_CMDID_HW_VERSION_RESP", 0x3002);
define("MFUN_CMDID_HW_VERSION_PUSH", 0x3003);
define("MFUN_CMDID_EMC_DATA_REV", 0x2712);
define("MFUN_CMDID_OCH_DATA_REQ", 0x4010);  //酒精测试量
define("MFUN_CMDID_OCH_DATA_RESP", 0x4011);

//下列L3控制字有效，功能已经实现
define("MFUN_CMDID_VERSION_SYNC", 0xF0);   //IHU软，硬件版本查询命令字
define("MFUN_CMDID_TIME_SYNC", 0xF2);    //时间同步命令字
define("MFUN_CMDID_EMC_DATA", 0x20);   //电磁波辐射测量命令字
define("MFUN_CMDID_PM25_DATA", 0x25);  //MODBUS 颗粒物命令字
define("MFUN_CMDID_WINDSPD_DATA", 0x26);  //MODBUS 风速命令字
define("MFUN_CMDID_WINDDIR_DATA", 0x27);  //MODBUS 风向命令字
define("MFUN_CMDID_TEMP_DATA", 0x28);  //MODBUS 温度命令字
define("MFUN_CMDID_HUMID_DATA", 0x29);  //MODBUS 湿度命令字
define("MFUN_CMDID_HSMMP_DATA", 0x2C);  //Video命令字
define("MFUN_CMDID_NOISE_DATA", 0x2B);  //Noise命令字
define("MFUN_CMDID_INVENTORY_DATA", 0xA0); //SW,HW 版本信息
define("MFUN_CMDID_SW_UPDATE", 0xA1);   //HCU软件更新
define("MFUN_CMDID_HEART_BEAT", 0xFE); //HCU心跳特殊控制字
define("MFUN_CMDID_HCU_POLLING", 0xFD); //HCU命令轮询控制字
define("MFUN_CMDID_EMC_DATA_PUSH", 0x2001); //临时定义给IHU测试
define("MFUN_CMDID_EMC_DATA_RESP", 0x2081); //临时定义给IHU测试

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




?>