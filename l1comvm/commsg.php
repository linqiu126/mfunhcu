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
//消息定义均以SOURCE为基础
$index = 0;
define("MSG_ID_MFUN_MIN", $index++);
//L1L2部分消息
define("MSG_ID_L1VM_TO_L2SDK_WECHAT_INCOMING", $index++);
define("MSG_ID_WECHAT_TO_L2SDK_IOT_WX_INCOMING", $index++);
define("MSG_ID_IOTWX_TO_L2SDK_IOT_WX_JSSDK_INCOMING", $index++);
define("MSG_ID_L1VM_TO_L2SDK_IOT_HCU_INCOMING", $index++);
define("MSG_ID_L1VM_TO_L2SDK_IOT_APPLE_INCOMING", $index++);
define("MSG_ID_L1VM_TO_L2SDK_IOT_JD_INCOMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_EMC", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_EMC_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_EMC_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_HSMMP", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_HSMMP_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_HSMMP_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_HUMID", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_HUMID_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_HUMID_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_NOISE", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_NOISE_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_NOISE_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_PM25", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_PM25_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_PM25_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_TEMP", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_TEMP_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_TEMP_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_WINDDIR", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_WINDDIR_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_WINDDIR_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_WINDSPD", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_WINDSPD_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_WINDSPD_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_AIRPRS", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_AIRPRS_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_AIRPRS_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_ALCOHOL", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_ALCOHOL_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_ALCOHOL_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_CO1", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_CO1_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_CO1_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_HCHO", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_HCHO_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_HCHO_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_TOXICGAS", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_TOXICGAS_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_TOXICGAS_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_LIGHTSTR", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_LIGHTSTR_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_LIGHTSTR_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_HCU_TO_L2SNR_RAIN", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_RAIN_DATA_READ_INSTANT", $index++);
define("MSG_ID_L2SDK_EMCWX_TO_L2SNR_RAIN_DATA_REPORT_TIMING", $index++);
define("MSG_ID_L2SDK_WECHAT_DATA_COMING", $index++);
define("MSG_ID_L2SDK_HCU_DATA_COMING", $index++);
//L2SDK_JD消息部分
define("MSG_ID_L2SDK_JD_INCOMING", $index++);
//L2SDK_APPLE消息部分
define("MSG_ID_L2SDK_APPLE_INCOMING", $index++);
//L2SDK_NBIOT_STD_QG376消息部分
define("MSG_ID_L2SDK_NBIOT_STD_QG376_INCOMING", $index++);
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_CNFNG", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_RESET", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_LICK", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_RELAY", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_SETPAR", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_CONTROL", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_SECNEG", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_REQREP", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_REQCFG", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_INQPAR", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_REQTSK", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_REQDATA1", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_REQDATA2", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_REQDATA3", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_FILETRNS", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_DATAFWD", $index++); //终端主动上报消息或者被动反馈消息
//L2SDK_NBIOT_STD_CJ188消息部分
define("MSG_ID_L2SDK_NBIOT_STD_CJ188_INCOMING", $index++);
define("MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_READ_DATA", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_READ_KEY_VER", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_READ_ADDR", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_READ_DATA", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_READ_KEY_VER", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_READ_ADDR", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_READ_DATA", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_READ_KEY_VER", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_READ_ADDR", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_READ_DATA", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_READ_KEY_VER", $index++); //终端主动上报消息或者被动反馈消息
define("MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_READ_ADDR", $index++); //终端主动上报消息或者被动反馈消息

//L2SDK_NBIOT_LTEV消息部分
define("MSG_ID_L2SDK_NBIOT_LTEV_INCOMING", $index++);
//L2SDK_NBIOT_AGC消息部分
define("MSG_ID_L2SDK_NBIOT_AGC_INCOMING", $index++);
//L2TIMERCRON消息部分
define("MSG_ID_L2TIMER_CRON_1MIN_COMING", $index++);
define("MSG_ID_L2TIMER_CRON_3MIN_COMING", $index++);
define("MSG_ID_L2TIMER_CRON_10MIN_COMING", $index++);
define("MSG_ID_L2TIMER_CRON_30MIN_COMING", $index++);
define("MSG_ID_L2TIMER_CRON_1HOUR_COMING", $index++);
define("MSG_ID_L2TIMER_CRON_6HOUR_COMING", $index++);
define("MSG_ID_L2TIMER_CRON_24HOUR_COMING", $index++);
define("MSG_ID_L2TIMER_CRON_2DAY_COMING", $index++);
define("MSG_ID_L2TIMER_CRON_7DAY_COMING", $index++);
define("MSG_ID_L2TIMER_CRON_30DAY_COMING", $index++);
//L2SOCKET_LISTEN消息部分
define("MSG_ID_L2SOCKET_LISTEN_DATA_COMING", $index++);
//L3APPL消息部分
define("MSG_ID_L3APPL_DATA_COMING", $index++);
//L4AQYCUI部分
define("MSG_ID_L4AQYCUI_CLICK_INCOMING", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F1_LOGIN", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F1_USERINFO", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F1_USERNEW", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F1_USERMOD", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F1_USERDEL", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F1_USERTABLE", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F1_HCUSWUPDATE", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F2_PROJECTPGLIST", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F2_PROJECTLIST", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F2_USERPROJ", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F2_PGTABLE", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F2_PGNEW", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F2_PGMOD", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F2_PGDEL", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F2_PGPROJ", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F2_PROJTABLE", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F2_PROJNEW", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F2_PROJMOD", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_PROJDEL", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_PROJPOINT", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_POINTPROJ", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_POINTTABLE", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_POINTDETAIL", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_POINTNEW", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_POINTMOD", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_POINTDEL", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_POINTDEV", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_DEVTABLE", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_DEVNEW", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_DEVMOD", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_DEVDEL", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_MONITORLIST", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_ALARMTYPE", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_TABLEQUERY", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_SENSORLIST", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_DEVSENSOR", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_SENSORUPDATE", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F3_GETSTATICMONITORTABLE", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F5_DEVALARM", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F5_ALARMQUERY", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F7_SETUSERMSG", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F7_GETUSERMSG", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F7_SHOWUSERMSG", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F7_GETUSERIMG", $index++);
define("MSG_ID_L4AQYCUI_TO_L3F7_CLEARUSERIMG", $index++);
//L4EMCWXUI部分
define("MSG_ID_L4EMCWXUI_CLICK_INCOMING", $index++);
//L4TBSWRUI部分
define("MSG_ID_L4TBSWR_CLICK_INCOMING", $index++);
//L4NBIOTIPMUI部分
define("MSG_ID_L4NBIOT_IPMUI_CLICK_INCOMING", $index++);
define("MSG_ID_L4NBIOT_IPMUI_TO_NBIOT_STD_QG376_DL_REQUEST", $index++);
define("MSG_ID_L4NBIOT_IPMUI_TO_NBIOT_STD_CK188_DL_REQUEST", $index++);
define("MSG_ID_L4NBIOT_IPMUI_TO_L3F1_LOGIN", $index++);
//L4NBIOTIGMUI部分
define("MSG_ID_L4NBIOT_IGMUI_CLICK_INCOMING", $index++);
define("MSG_ID_L4NBIOT_IGMUI_TO_NBIOT_STD_CK188_DL_REQUEST", $index++);
//L4NBIOTIWMUI部分
define("MSG_ID_L4NBIOT_IWMUI_CLICK_INCOMING", $index++);
define("MSG_ID_L4NBIOT_IWMUI_TO_NBIOT_STD_CK188_DL_REQUEST", $index++);
//L4NBIOTIHMUI部分
define("MSG_ID_L4NBIOT_IHMUI_CLICK_INCOMING", $index++);
define("MSG_ID_L4NBIOT_IHMUI_TO_NBIOT_STD_CK188_DL_REQUEST", $index++);

//L5BI部分
define("MSG_ID_L4BI_CLICK_INCOMING", $index++);
define("MSG_ID_MFUN_MAX", $index++);


/**************************************************************************************
 *                             公共消息全局量定义                                     *
 *************************************************************************************/
define("MFUN_TIME_GRID_SIZE", 1); //定义用于数据存储的时间网格为。单位为分钟
define("MFUN_L2_FRAME_FORMAT_PREFIX_XML", "<x"); //XML数据格式，消息以<xml开头
define("MFUN_L2_FRAME_FORMAT_PREFIX_ZHB", "##"); //中环保数据格式，消息以##开头
define("MFUN_L2_FRAME_FORMAT_PREFIX_APPLE", "$<"); //APPLE数据格式
define("MFUN_L2_FRAME_FORMAT_PREFIX_JD", "#$"); //JD数据格式

/**************************************************************************************
 *                             IHU公共消息全局量定义                                  *
 *************************************************************************************/
//L2处理消息的定义，用于处理微信头。由于微信后台服务器已经完成了这个消息体的处理，因而暂时没用，保留
define("MFUN_IHU_MSG_HEAD_FORMAT", "A2MagicCode/A2Version/A4Length/A4CmdId/A2Seq/A2ErrCode");
define("MFUN_IHU_MSG_HEAD_LENGTH", 24); //12 Byte
define("MFUN_IHU_L3_HEAD_MAGIC", 0xFE);
define("MFUN_IHU_L3_HEAD_VERSION",0x01);
define("MFUN_IHU_L3_HEAD_LENGTH", 0x08);
define("MFUN_IHU_CMDID_SEND_TEXT_REQ", 0x1);    //HW -> CLOUD
define("MFUN_IHU_CMDID_SEND_TEXT_RESP", 0x1001);   //CLOUD ->HW
define("MFUN_IHU_CMDID_OPEN_LIGHT_PUSH", 0x2001);  //CLOUD ->HW
define("MFUN_IHU_CMDID_CLOSE_LIGHT_PUSH", 0x2002);   //CLOUD ->HW
define("MFUN_IHU_CMDID_HW_VERSION_REQ", 0x3001);
define("MFUN_IHU_CMDID_HW_VERSION_RESP", 0x3002);
define("MFUN_IHU_CMDID_HW_VERSION_PUSH", 0x3003);
define("MFUN_IHU_CMDID_EMC_DATA_REV", 0x2712);
define("MFUN_IHU_CMDID_OCH_DATA_REQ", 0x4010);  //酒精测试量
define("MFUN_IHU_CMDID_OCH_DATA_RESP", 0x4011);

//IHU下列L3控制字有效，功能已经实现
define("MFUN_IHU_CMDID_VERSION_SYNC", 0xF0);   //IHU软，硬件版本查询命令字
define("MFUN_IHU_CMDID_TIME_SYNC", 0xF2);    //时间同步命令字
define("MFUN_IHU_CMDID_EMC_DATA", 0x20);   //电磁波辐射测量命令字
define("MFUN_IHU_CMDID_PM25_DATA", 0x25);  //MODBUS 颗粒物命令字
define("MFUN_IHU_CMDID_WINDSPD_DATA", 0x26);  //MODBUS 风速命令字
define("MFUN_IHU_CMDID_WINDDIR_DATA", 0x27);  //MODBUS 风向命令字
define("MFUN_IHU_CMDID_TEMP_DATA", 0x28);  //MODBUS 温度命令字
define("MFUN_IHU_CMDID_HUMID_DATA", 0x29);  //MODBUS 湿度命令字
define("MFUN_IHU_CMDID_HSMMP_DATA", 0x2C);  //Video命令字
define("MFUN_IHU_CMDID_NOISE_DATA", 0x2B);  //Noise命令字
define("MFUN_IHU_CMDID_INVENTORY_DATA", 0xA0); //SW,HW 版本信息
define("MFUN_IHU_CMDID_SW_UPDATE", 0xA1);   //HCU软件更新
define("MFUN_IHU_CMDID_HEART_BEAT", 0xFE); //HCU心跳特殊控制字
define("MFUN_IHU_CMDID_HCU_POLLING", 0xFD); //HCU命令轮询控制字
define("MFUN_IHU_CMDID_EMC_DATA_PUSH", 0x2001); //临时定义给IHU测试
define("MFUN_IHU_CMDID_EMC_DATA_RESP", 0x2081); //临时定义给IHU测试


/**************************************************************************************
 *                             HCU公共消息全局量定义                                  *
 *************************************************************************************/
define("MFUN_HCU_MSG_HEAD_FORMAT", "A2Key/A2Len/A2Cmd");// 1B 控制字ctrl_key, 1B 长度length（除控制字和长度本身外），1B 操作字opt_key
define("MFUN_HCU_MSG_HEAD_LENGTH", 6); //3 Byte

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
define("MFUN_HCU_CMDID_EMC_DATA_PUSH", 0x2001); //临时定义给IHU测试
define("MFUN_HCU_CMDID_EMC_DATA_RESP", 0x2081); //临时定义给IHU测试

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

//其他命令操作字
define("MFUN_HCU_OPT_INVENTORY_REQ", 0x01);
define("MFUN_HCU_OPT_INVENTORY_RESP", 0x81);
define("MFUN_HCU_OPT_VEDIOLINK_REQ", 0x01);  //读取下位机存放的视频文件link
define("MFUN_HCU_OPT_VEDIOLINK_RESP", 0x81); //返回下位机存放的视频文件link
define("MFUN_HCU_OPT_VEDIOFILE_REQ", 0x02);   //命令下位机上传选中的视频文件
define("MFUN_HCU_OPT_VEDIOFILE_RESP", 0x82);  //视频文件传输完成响应


/**************************************************************************************
 *                            NBIOT IPM376消息定义                                    *
 *************************************************************************************/
//AFN消息字段
define("MFUN_NBIOT_IPM376_AFN_CMDID_CNFNG", 0x00);
define("MFUN_NBIOT_IPM376_AFN_CMDID_RESET", 0x01);
define("MFUN_NBIOT_IPM376_AFN_CMDID_LICK", 0x02);  //Link Interface Check
define("MFUN_NBIOT_IPM376_AFN_CMDID_RELAY", 0x03);
define("MFUN_NBIOT_IPM376_AFN_CMDID_SETPAR", 0x04);
define("MFUN_NBIOT_IPM376_AFN_CMDID_CONTROL", 0x05);
define("MFUN_NBIOT_IPM376_AFN_CMDID_SECNEG", 0x06);
define("MFUN_NBIOT_IPM376_AFN_CMDID_REQREP", 0x08);
define("MFUN_NBIOT_IPM376_AFN_CMDID_REQCFG", 0x09);
define("MFUN_NBIOT_IPM376_AFN_CMDID_INQPAR", 0x0A);
define("MFUN_NBIOT_IPM376_AFN_CMDID_REQTSK", 0x0B);
define("MFUN_NBIOT_IPM376_AFN_CMDID_REQDATA1", 0x0C);
define("MFUN_NBIOT_IPM376_AFN_CMDID_REQDATA2", 0x0D);
define("MFUN_NBIOT_IPM376_AFN_CMDID_REQDATA3", 0x0E);
define("MFUN_NBIOT_IPM376_AFN_CMDID_FILETRNS", 0x0F);
define("MFUN_NBIOT_IPM376_AFN_CMDID_DATAFWD", 0x10);

//消息头的全局定义
define("MFUN_NBIOT_IPM376_FRAME_FIX_HEAD", 0x68);
define("MFUN_NBIOT_IPM376_FRAME_FIX_START", 0x68);
define("MFUN_NBIOT_IPM376_FRAME_FIX_TAIL", 0x16);
define("MFUN_NBIOT_IPM376_FRAME_MAX_LEN", 255); //16383 under fix network transmission


/**************************************************************************************
 *                            NBIOT CJ188消息定义                                    *
 *************************************************************************************/
//T代码标识不同的仪表
define("MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MIN", 0x10);
define("MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MAX", 0x19);
define("MFUN_NBIOT_CJ188_T_TYPE_HEAT_METER_MIN", 0x20);
define("MFUN_NBIOT_CJ188_T_TYPE_HEAT_METER_MAX", 0x29);
define("MFUN_NBIOT_CJ188_T_TYPE_GAS_METER_MIN", 0x30);
define("MFUN_NBIOT_CJ188_T_TYPE_GAS_METER_MAX", 0x39);
define("MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MIN", 0x40);
define("MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MAX", 0x49);

define("MFUN_NBIOT_CJ188_T_TYPE_COLD_WATER_METER", 0x10);
define("MFUN_NBIOT_CJ188_T_TYPE_HOT_WATER_METER", 0x11);
define("MFUN_NBIOT_CJ188_T_TYPE_DRINK_WATER_METER", 0x12);
define("MFUN_NBIOT_CJ188_T_TYPE_MIDDLE_WATER_METER", 0x13);
define("MFUN_NBIOT_CJ188_T_TYPE_HEAT_ENERGY_METER", 0x20);
define("MFUN_NBIOT_CJ188_T_TYPE_COLD_ENERGY_METER", 0x21);
define("MFUN_NBIOT_CJ188_T_TYPE_GAS_METER", 0x30);
define("MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER", 0x40);

//Control码子代表的不同含义
define("MFUN_NBIOT_CJ188_CTRL_RESERVED", 0x0);
define("MFUN_NBIOT_CJ188_CTRL_READ_DATA", 0x01);
define("MFUN_NBIOT_CJ188_CTRL_WRITE_DATA", 0x04);
define("MFUN_NBIOT_CJ188_CTRL_READ_KEY_VER", 0x09);
define("MFUN_NBIOT_CJ188_CTRL_READ_ADDR", 0x03);
define("MFUN_NBIOT_CJ188_CTRL_WRITE_ADDR", 0x05);
define("MFUN_NBIOT_CJ188_CTRL_SET_DEVICE_SYN", 0x16);

//应用层DI0DI1的定义
define("MFUN_NBIOT_CJ188_READ_DI0DI1_CURRENT_COUNTER_DATA", 0x901F);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA1", 0xD120);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA2", 0xD121);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA3", 0xD122);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA4", 0xD123);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA5", 0xD124);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA6", 0xD125);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA7", 0xD126);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA8", 0xD127);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA9", 0xD128);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA10", 0xD129);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA11", 0xD12A);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA12", 0xD128);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_PRICE_TABLE", 0x8102);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_BILL_DATE", 0x8103);  //结算日
define("MFUN_NBIOT_CJ188_READ_DI0DI1_ACCOUNT_DATE", 0x8104); //抄表日
define("MFUN_NBIOT_CJ188_READ_DI0DI1_BUY_AMOUNT", 0x8105); //购入金额
define("MFUN_NBIOT_CJ188_READ_DI0DI1_KEY_VER", 0x8106);
define("MFUN_NBIOT_CJ188_READ_DI0DI1_ADDRESS", 0x810A);
define("MFUN_NBIOT_CJ188_WRITE_DI0DI1_PRICE_TABLE", 0xA010);
define("MFUN_NBIOT_CJ188_WRITE_DI0DI1_BILL_DATE", 0xA011);
define("MFUN_NBIOT_CJ188_WRITE_DI0DI1_ACCOUNT_DATE", 0xA012);
define("MFUN_NBIOT_CJ188_WRITE_DI0DI1_BUY_AMOUNT", 0xA013);
define("MFUN_NBIOT_CJ188_WRITE_DI0DI1_NEW_KEY", 0xA014);
define("MFUN_NBIOT_CJ188_WRITE_DI0DI1_STD_TIME", 0xA015);
define("MFUN_NBIOT_CJ188_WRITE_DI0DI1_SWITCH_CTRL", 0xA017);
define("MFUN_NBIOT_CJ188_WRITE_DI0DI1_OFF_FACTORY_START", 0xA019);
define("MFUN_NBIOT_CJ188_WRITE_DI0DI1_ADDRESS", 0xA018);
define("MFUN_NBIOT_CJ188_WRITE_DEVICE_SYN_DATA", 0xA016);

//消息头的全局定义
define("MFUN_NBIOT_CJ188_FRAME_FIX_HEAD", 0x68);
define("MFUN_NBIOT_CJ188_FRAME_FIX_TAIL", 0x16);
define("MFUN_NBIOT_CJ188_FRAME_READ_MAX_LEN", 64);
define("MFUN_NBIOT_CJ188_FRAME_WRITE_MAX_LEN", 32);

?>