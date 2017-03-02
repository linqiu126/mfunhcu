<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 13:15
 */

/**************************************************************************************
 *                             全局控制常量                                           *
 *************************************************************************************/
//项目名称，每个项目均为唯一用于本项目选择启动配置数据库中的工参信息
//项目目前支持：MFUN_PRG_AQYC, MFUN_PRG_EMCWX, MFUN_PRG_TBSWR, 本地=MFUN_PRG_AQYC
define ("MFUN_WORKING_PROGRAM_NAME_UNIQUE_AQYC", "MFUN_PRG_AQYC");      //爱启扬尘
define ("MFUN_WORKING_PROGRAM_NAME_UNIQUE_EMCWX", "MFUN_PRG_EMCWX");    //电磁辐射
define ("MFUN_WORKING_PROGRAM_NAME_UNIQUE_TBSWR", "MFUN_PRG_TBSWR");    //水污染
define ("MFUN_WORKING_PROGRAM_NAME_UNIQUE_FHYS", "MFUN_PRG_FHYS");      //智能云锁
define ("MFUN_WORKING_PROGRAM_NAME_UNIQUE_NBIOT_IPM", "MFUN_PRG_NBIPM");  //智能电表
define ("MFUN_WORKING_PROGRAM_NAME_UNIQUE_NBIOT_IWM", "MFUN_PRG_NBIWM");  //智能水表
define ("MFUN_WORKING_PROGRAM_NAME_UNIQUE_NBIOT_IGM", "MFUN_PRG_NBIGM");  //智能煤气表
define ("MFUN_WORKING_PROGRAM_NAME_UNIQUE_NBIOT_IHM", "MFUN_PRG_NBIHM");  //智能热力表
define ("MFUN_WORKING_PROGRAM_NAME_UNIQUE_NBIOT_LTEV", "MFUN_PRG_NBLTEV");  //智能车联网
define ("MFUN_WORKING_PROGRAM_NAME_UNIQUE_NBIOT_AGC", "MFUN_PRG_NBAGC");  //智能农业
define ("MFUN_WORKING_PROGRAM_NAME_UNIQUE_TESTMODE", "MFUN_PRG_TESTMODE");  //测试模式，该模式默认所有任务模块都是激活的
//定义当前工作的项目，不同的项目决定激活的任务模块和工参配置
define ("MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE", MFUN_WORKING_PROGRAM_NAME_UNIQUE_TESTMODE);

//定义系统消息入口，这里的ENTRY只跟L1MAINENTRY相关，用于定义不同项目和任务的入口MAIN函数
//这里的入口，暂时不要跟PROJECT、PROGRAM、PLATFORM联系起来
define ("MFUN_MAIN_ENTRY_IOT_HCU", "MFUN_MAIN_ENTRY_IOT_HCU");
define ("MFUN_MAIN_ENTRY_WECHAT", "MFUN_MAIN_ENTRY_WECHAT");
define ("MFUN_MAIN_ENTRY_JINGDONG", "MFUN_MAIN_ENTRY_JINGDONG");
define ("MFUN_MAIN_ENTRY_APPLE", "MFUN_MAIN_ENTRY_APPLE");
define ("MFUN_MAIN_ENTRY_NBIOT_STD_QG376", "MFUN_MAIN_ENTRY_NBIOT_STD_QG376");
define ("MFUN_MAIN_ENTRY_NBIOT_STD_CJ188", "MFUN_MAIN_ENTRY_NBIOT_STD_CJ188");
define ("MFUN_MAIN_ENTRY_NBIOT_LTEV", "MFUN_MAIN_ENTRY_NBIOT_LTEV");
define ("MFUN_MAIN_ENTRY_NBIOT_AGC", "MFUN_MAIN_ENTRY_NBIOT_AGC");
define ("MFUN_MAIN_ENTRY_CRON", "MFUN_MAIN_ENTRY_CRON");
define ("MFUN_MAIN_ENTRY_SOCKET_LISTEN", "MFUN_MAIN_ENTRY_SOCKET_LISTEN");
define ("MFUN_MAIN_ENTRY_AQYC_UI", "MFUN_MAIN_ENTRY_AQYC_UI");
define ("MFUN_MAIN_ENTRY_FHYS_UI", "MFUN_MAIN_ENTRY_FHYS_UI");
define ("MFUN_MAIN_ENTRY_FHYS_WECHAT", "MFUN_MAIN_ENTRY_FHYS_WECHAT");
define ("MFUN_MAIN_ENTRY_BFSC_UI", "MFUN_MAIN_ENTRY_BFSC_UI");
define ("MFUN_MAIN_ENTRY_TBSWR_UI", "MFUN_MAIN_ENTRY_TBSWR_UI");
define ("MFUN_MAIN_ENTRY_EMCWX_UI", "MFUN_MAIN_ENTRY_EMCWX_UI");
define ("MFUN_MAIN_ENTRY_NBIOT_IPM_UI", "MFUN_MAIN_ENTRY_NBIOT_IPM_UI");
define ("MFUN_MAIN_ENTRY_NBIOT_IGM_UI", "MFUN_MAIN_ENTRY_NBIOT_IGM_UI");
define ("MFUN_MAIN_ENTRY_NBIOT_IWM_UI", "MFUN_MAIN_ENTRY_NBIOT_IWM_UI");
define ("MFUN_MAIN_ENTRY_NBIOT_IHM_UI", "MFUN_MAIN_ENTRY_NBIOT_IHM_UI");
define ("MFUN_MAIN_ENTRY_DIRECT_IN", "MFUN_MAIN_ENTRY_DIRECT_IN");

//定义技术平台，用于SDK在相互之间调用以及SDK调用不同的SENSOR任务时的一种技术性交换矩阵，以节省代码的重复性
//技术平台本身没有任何意义，它纯粹从实用性角度，人为的给调用函数提供了一种方便性的区分而已
//技术平台+PROJECT构成了函数调用的两个灵活区分，这两者的应用由于历史的缘故，在使用规则上和概念上，并没有严格的区分，全拼调用者的喜好
//PROGRAM是更为高层的概念，原则上我们可以认为，PROGRAM > PLATFORM > PROJECT
define("MFUN_TECH_PLTF_WECHAT", "MFUN_TECH_PLTF_WECHAT");  //微信物联网平台
define("MFUN_TECH_PLTF_WECHAT_DEVICE_TEXT","MFUN_TECH_PLTF_WECHAT_DEVICE_TEXT"); //DEVICE_TEXT //用于区分WECHAT->IOT_HCU的处理内容及过程
define("MFUN_TECH_PLTF_WECHAT_DEVICE_EVENT","MFUN_TECH_PLTF_WECHAT_DEVICE_EVENT"); //DEVICE_EVENT //用于区分WECHAT->IOT_HCU的处理内容及过程
define("MFUN_TECH_PLTF_WECHAT_MENU_CLICK","MFUN_TECH_PLTF_WECHAT_MENU_CLICK"); //MENU_CLICK //用于区分WECHAT->IOT_HCU的处理内容及过程
define("MFUN_TECH_PLTF_HCUGX", "MFUN_TECH_PLTF_HCUGX"); //HCU网关平台
define("MFUN_TECH_PLTF_HCUGX_HCU_TEXT","MFUN_TECH_PLTF_HCUGX_DEVICE_TEXT"); //HCU_TEXT
define("MFUN_TECH_PLTF_HCUGX_HCU_EVENT","MFUN_TECH_PLTF_HCUGX_DEVICE_EVENT"); //HCU_EVENT
define("MFUN_TECH_PLTF_HCUSTM", "MFUN_TECH_PLTF_HCUSTM"); //HCU STM32平台，用于FHYS项目
define("MFUN_TECH_PLTF_HCUPI", "MFUN_TECH_PLTF_HCUPI"); //HCU 树莓派平台，用于BFSC波峰智能组合秤项目
define("MFUN_TECH_PLTF_JDIOT", "MFUN_TECH_PLTF_JDIOT");  //京东物联平台
define("MFUN_TECH_PLTF_APPLE_HOMEKIT", "MFUN_TECH_PLTF_APPLE_HOMEKIT");  //京东物联平台
define("MFUN_TECH_PLTF_NBIOT_QG376", "MFUN_TECH_PLTF_NBIOT_QG376");  //窄带物联平台
define("MFUN_TECH_PLTF_NBIOT_CJ188", "MFUN_TECH_PLTF_NBIOT_CJ188");  //窄带物联平台

//为了重用不同情形下的传感器处理任务，这里定义不同的技术平台和项目概念，以便不同的SDK可以统一调用相同的传感器处理任务函数
//这里的PRJ目前只是为了在Log记录中起到应用场景的区分作用，还没有在消息处理中起到真正的作用
define("MFUN_PRJ_IHU_EMCWX", "MFUN_PRJ_IHU_EMCWX");
define("MFUN_PRJ_HCU_XML", "MFUN_PRJ_HCU_XML");
define("MFUN_PRJ_HCU_ZHB", "MFUN_PRJ_HCU_ZHB");
define("MFUN_PRJ_HCU_APPLE", "MFUN_PRJ_HCU_APPLE");
define("MFUN_PRJ_HCU_JD", "MFUN_PRJ_HCU_JD");
define("MFUN_PRJ_HCU_AQYCUI", "MFUN_PRJ_HCU_AQYCUI");
define("MFUN_PRJ_HCU_FHYSUI", "MFUN_PRJ_HCU_FHYSUI");
define("MFUN_PRJ_HCU_FHYSWX", "MFUN_PRJ_HCU_FHYSWX");
define("MFUN_PRJ_HCU_BFSCUI", "MFUN_PRJ_HCU_BFSCUI");
define("MFUN_PRJ_NB_IOT_IPM376", "MFUN_PRJ_NB_IOT_IPM376");
define("MFUN_PRJ_NB_IOT_IPM188", "MFUN_PRJ_NB_IOT_IPM188");
define("MFUN_PRJ_NB_IOT_IGM188", "MFUN_PRJ_NB_IOT_IGM188");
define("MFUN_PRJ_NB_IOT_IWM188", "MFUN_PRJ_NB_IOT_IWM188");
define("MFUN_PRJ_NB_IOT_IHM188", "MFUN_PRJ_NB_IOT_IHM188");

//不同的方式来确定本机运行环境，还是服务器运行环境，本来想获取Localhost来进行判断，但没成功
//实验了不同的方式，包括$_SERVER['LOCAL_ADDR']， $_SERVER['SERVER_ADDR']， getenv('SERVER_ADDR')等方式
//GetHostByName($_SERVER['SERVER_NAME'])只能获取IP地址，也不稳定
//使用php_uname('n') == "CV0002816N4")也算是一个不错的方式，但依然丑陋，需要每个测试者单独配置，
//也可以使用云服务器的名字来反向匹配，因为服务器的名字是唯一的
//SAE官方的说法：可以使用isset(SAE_TMP_PATH)来判断是不是在SAE云上
//
if (isset($_SERVER['SERVER_NAME']))
{
    $server_name = $_SERVER['SERVER_NAME'];
    switch($server_name)
    {
        case "www.hkrob.com"://小慧智能云 "121.40.118.33"
            define("MFUN_CLOUD_HCU", "XHZN_HCU"); //HCU后台云应用
            define("MFUN_CLOUD_WX", "XHZN_WX"); //微信后台云应用
            //主数据库定义
            //define("MFUN_CLOUD_DBHOST", "h5.aiqiworld.com/myAdmin");    //连接的服务器地址
            define("MFUN_CLOUD_DBHOST", "127.0.0.1");    //连接的服务器地址
            define("MFUN_CLOUD_DBUSER", "root");     //连接数据库的用户名
            define("MFUN_CLOUD_DBPSW", "bxxhbxxh");        //连接数据库的密码
            define("MFUN_CLOUD_DBNAME_L1L2L3", "bxxhl1l2l3");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_DEBUG", "bxxhl1vmlog");         //连接的log数据库名称
            define("MFUN_CLOUD_DBNAME_L4EMCWX", "bxxhl4emcwx");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4AQYC", "bxxhl4aqyc");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4TBSWR", "bxxhl4tbswr");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L5BI", "bxxhl5bi");         //连接的数据库名称
            define("MFUN_CLOUD_DBPORT", 3306);           //缺省设置
            define("MFUN_CLOUD_DBHOST_S", "");          //无效
            //EMCWX应用定义
            define("MFUN_WX_APPID", "wxf2150c4d2941b2ab");  //小慧智能服务号AppID
            define("MFUN_WX_APPSECRET", "ab95997f454e04b77911c18d09807831");  //填写高级调用功能的app id, 请在微信开发模式后台查询
            define("MFUN_WX_ENCODINGAESKEY", "1NxQnLdUUOr4s1r0rnxfuhoRdF14C5NO79o6AknsIYE");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

            //测试公号的后台运行配置参数
            define("MFUN_WX_TOOL_SERVICENUM", "gh_4667dc241921");
            define("MFUN_WX_TOOL_APPID", "wxf2150c4d2941b2ab");
            define("MFUN_WX_TOOL_APPSECRET", "ab95997f454e04b77911c18d09807831");
            define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF27");
            //RabbitMQ消息队列定义
            define("MFUN_MQ_RABBIT_HOST", "127.0.0.1");
            define("MFUN_MQ_RABBIT_PORT", "5672");
            define("MFUN_MQ_RABBIT_LOGIN", "guest");
            define("MFUN_MQ_RABBIT_PSWD", "guest");
            define("MFUN_MQ_RABBIT_VHOST", "/");
            define("MFUN_MQ_RABBIT_EXCHANGE", "e_linvo");
            define("MFUN_MQ_RABBIT_QUEUE", "q_linvo");
            define("MFUN_MQ_RABBIT_ROUTE_KEY", "key_1");
            break;
        case "www.aiqiworld.com"://爱启云"121.40.185.177"
            define("MFUN_CLOUD_HCU", "AQ_HCU"); //HCU后台云应用
            define("MFUN_CLOUD_WX", "AQ_WX"); //微信后台云应用
            //主数据库定义
            //define("MFUN_CLOUD_DBHOST", "h5.aiqiworld.com/myAdmin");    //连接的服务器地址
            define("MFUN_CLOUD_DBHOST", "127.0.0.1");    //连接的服务器地址
            define("MFUN_CLOUD_DBUSER", "root");     //连接数据库的用户名
            define("MFUN_CLOUD_DBPSW", "aiqiMySQL@321");        //连接数据库的密码
            define("MFUN_CLOUD_DBNAME_L1L2L3", "bxxhl1l2l3");         //连接的业务数据库名称
            define("MFUN_CLOUD_DBNAME_DEBUG", "bxxhl1vmlog");         //连接的log数据库名称
            define("MFUN_CLOUD_DBNAME_L4EMCWX", "bxxhl4emcwx");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4AQYC", "bxxhl4aqyc");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4TBSWR", "bxxhl4tbswr");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L5BI", "bxxhl5bi");         //连接的数据库名称
            define("MFUN_CLOUD_DBPORT", 3306);           //缺省设置
            define("MFUN_CLOUD_DBHOST_S", "");          //无效
            //EMCWX应用定义
            define("MFUN_WX_APPID", "wx1183be5c8f6a24b4");  //微信测试号AppID
            define("MFUN_WX_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");  //填写高级调用功能的app id, 请在微信开发模式后台查询
            define("MFUN_WX_ENCODINGAESKEY", "ihIyvJ8LLAnOHpHzKTG0yIJxlzl1Fzw5ygRgHO96ieW");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略
            //测试公号的后台运行配置参数
            define("MFUN_WX_TOOL_SERVICENUM", "gh_70c714952b02");
            define("MFUN_WX_TOOL_APPID", "wx1183be5c8f6a24b4");
            define("MFUN_WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
            define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF27");
            //RabbitMQ消息队列定义
            define("MFUN_MQ_RABBIT_HOST", "127.0.0.1");
            define("MFUN_MQ_RABBIT_PORT", "5672");
            define("MFUN_MQ_RABBIT_LOGIN", "guest");
            define("MFUN_MQ_RABBIT_PSWD", "guest");
            define("MFUN_MQ_RABBIT_VHOST", "/");
            define("MFUN_MQ_RABBIT_EXCHANGE", "e_linvo");
            define("MFUN_MQ_RABBIT_QUEUE", "q_linvo");
            define("MFUN_MQ_RABBIT_ROUTE_KEY", "key_1");
            break;
        case "www.foome.com.cn": //FOHA云 120.26.105.35
            define("MFUN_CLOUD_HCU", "XHZN_HCU"); //HCU后台云应用
            define("MFUN_CLOUD_WX", "XHZN_WX"); //微信后台云应用
            //主数据库定义
            //define("MFUN_CLOUD_DBHOST", "h5.aiqiworld.com/myAdmin");    //连接的服务器地址
            define("MFUN_CLOUD_DBHOST", "127.0.0.1");    //连接的服务器地址
            define("MFUN_CLOUD_DBUSER", "root");     //连接数据库的用户名
            define("MFUN_CLOUD_DBPSW", "bxxhbxxh");        //连接数据库的密码
            define("MFUN_CLOUD_DBNAME_L1L2L3", "bxxhl1l2l3");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_DEBUG", "bxxhl1vmlog");         //连接的log数据库名称
            define("MFUN_CLOUD_DBNAME_L4EMCWX", "bxxhl4emcwx");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4AQYC", "bxxhl4aqyc");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4TBSWR", "bxxhl4tbswr");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L5BI", "bxxhl5bi");         //连接的数据库名称
            define("MFUN_CLOUD_DBPORT", 3306);           //缺省设置
            define("MFUN_CLOUD_DBHOST_S", "");          //无效
            //EMCWX应用定义
            define("MFUN_WX_APPID", "wxd054d0d6bae92d04");  //FOHA服务号AppID
            define("MFUN_WX_APPSECRET", "9dc605f7d63ed12bfcd7f43c16224e5a");  //填写高级调用功能的app id, 请在微信开发模式后台查询
            define("MFUN_WX_ENCODINGAESKEY", "Q33ZExkHMosHua6jxTKDb54SSz0eZlEfWQHZzTZK4OO");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

            //测试公号的后台运行配置参数
            define("MFUN_WX_TOOL_SERVICENUM", "gh_0ab9a32c6381");
            define("MFUN_WX_TOOL_APPID", "wxd054d0d6bae92d04");
            define("MFUN_WX_TOOL_APPSECRET", "9dc605f7d63ed12bfcd7f43c16224e5a");
            define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF27");
            //RabbitMQ消息队列定义
            define("MFUN_MQ_RABBIT_HOST", "127.0.0.1");
            define("MFUN_MQ_RABBIT_PORT", "5672");
            define("MFUN_MQ_RABBIT_LOGIN", "guest");
            define("MFUN_MQ_RABBIT_PSWD", "guest");
            define("MFUN_MQ_RABBIT_VHOST", "/");
            define("MFUN_MQ_RABBIT_EXCHANGE", "e_linvo");
            define("MFUN_MQ_RABBIT_QUEUE", "q_linvo");
            define("MFUN_MQ_RABBIT_ROUTE_KEY", "key_1");
            break;
        case "mfuncard.sinaapp.com"://新浪云，LZH微信公号服务器数据库配置信息
            //云后台定义
            define("MFUN_CLOUD_HCU", "SAE_HCU"); //HCU后台云应用
            define("MFUN_CLOUD_WX", "SAE_WX"); //微信后台云应用
            //主数据库定义
            define("MFUN_CLOUD_DBHOST", SAE_MYSQL_HOST_M);    //连接的服务器地址 w.rdc.sae.sina.com.cn
            define("MFUN_CLOUD_DBUSER", SAE_MYSQL_USER);     //连接数据库的用户名
            define("MFUN_CLOUD_DBPSW", SAE_MYSQL_PASS);        //连接数据库的密码
            define("MFUN_CLOUD_DBNAME_L1L2L3", "app_mfuncard");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4EMCWX", "app_mfuncard");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4AQYC", "app_mfuncard");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4TBSWR", "app_mfuncard");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L5BI", "app_mfuncard");         //连接的数据库名称
            define("MFUN_CLOUD_DBPORT", SAE_MYSQL_PORT);
            define("MFUN_CLOUD_DBHOST_S", SAE_MYSQL_DB);
            //EMCWX应用定义
            define("MFUN_WX_APPID", "wx32f73ab219f56efb");  //微信测试号AppID
            define("MFUN_WX_APPSECRET", "eca20c2a26a5ec5b64a89d15ba92a781");  //填写高级调用功能的app id, 请在微信开发模式后台查询
            define("MFUN_WX_ENCODINGAESKEY", "7Tp1NIUzUa0JBezeJUjG8O61Kdjcu2ce6BQVukZlv3u");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略
            //测试公号的后台运行配置参数
            define("MFUN_WX_TOOL_SERVICENUM", "gh_9b450bb63282");
            define("MFUN_WX_TOOL_APPID", "wx32f73ab219f56efb");
            define("MFUN_WX_TOOL_APPSECRET", "eca20c2a26a5ec5b64a89d15ba92a781");
            define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF25");
            //RabbitMQ消息队列定义
            define("MFUN_MQ_RABBIT_HOST", SAE_MYSQL_HOST_M);
            define("MFUN_MQ_RABBIT_PORT", "5672");
            define("MFUN_MQ_RABBIT_LOGIN", "guest");
            define("MFUN_MQ_RABBIT_PSWD", "guest");
            define("MFUN_MQ_RABBIT_VHOST", "/");
            define("MFUN_MQ_RABBIT_EXCHANGE", "e_linvo");
            define("MFUN_MQ_RABBIT_QUEUE", "q_linvo");
            define("MFUN_MQ_RABBIT_ROUTE_KEY", "key_1");
            break;
        case "mfunhcu.sinaapp.com": //新浪云，微信测试号配置
            //云后台定义
            define("MFUN_CLOUD_HCU", "SAE_HCU"); //HCU后台云应用
            define("MFUN_CLOUD_WX", "SAE_WX"); //微信后台云应用
            //主数据库定义
            define("MFUN_CLOUD_DBHOST", SAE_MYSQL_HOST_M);    //连接的服务器地址 w.rdc.sae.sina.com.cn
            define("MFUN_CLOUD_DBUSER", SAE_MYSQL_USER);     //连接数据库的用户名
            define("MFUN_CLOUD_DBPSW", SAE_MYSQL_PASS);        //连接数据库的密码
            define("MFUN_CLOUD_DBNAME_L1L2L3", "app_mfuncard");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4EMCWX", "app_mfuncard");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4AQYC", "app_mfuncard");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4TBSWR", "app_mfuncard");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L5BI", "app_mfuncard");         //连接的数据库名称
            define("MFUN_CLOUD_DBPORT", SAE_MYSQL_PORT);
            define("MFUN_CLOUD_DBHOST_S", SAE_MYSQL_DB);
            //EMCWX应用定义
            define("MFUN_WX_APPID", "wx1183be5c8f6a24b4");  //微信测试号AppID
            define("MFUN_WX_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");  //填写高级调用功能的app id, 请在微信开发模式后台查询
            define("MFUN_WX_ENCODINGAESKEY", "ihIyvJ8LLAnOHpHzKTG0yIJxlzl1Fzw5ygRgHO96ieW");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略
            //测试公号的后台运行配置参数
            define("MFUN_WX_TOOL_SERVICENUM", "gh_70c714952b02");
            define("MFUN_WX_TOOL_APPID", "wx1183be5c8f6a24b4");
            define("MFUN_WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
            define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF27");
            //RabbitMQ消息队列定义
            define("MFUN_MQ_RABBIT_HOST", SAE_MYSQL_HOST_M);
            define("MFUN_MQ_RABBIT_PORT", "5672");
            define("MFUN_MQ_RABBIT_LOGIN", "guest");
            define("MFUN_MQ_RABBIT_PSWD", "guest");
            define("MFUN_MQ_RABBIT_VHOST", "/");
            define("MFUN_MQ_RABBIT_EXCHANGE", "e_linvo");
            define("MFUN_MQ_RABBIT_QUEUE", "q_linvo");
            define("MFUN_MQ_RABBIT_ROUTE_KEY", "key_1");
            break;
        case "www.tengxun.com.cn": //腾讯云
            define("MFUN_CLOUD_HCU", "TENXUN_HCU"); //HCU后台云应用
            define("MFUN_CLOUD_WX", "TENXUN_WX"); //微信后台云应用
            //主数据库定义
            //define("MFUN_CLOUD_DBHOST", "h5.aiqiworld.com/myAdmin");    //连接的服务器地址
            define("MFUN_CLOUD_DBHOST", "127.0.0.1");    //连接的服务器地址
            define("MFUN_CLOUD_DBUSER", "root");     //连接数据库的用户名
            define("MFUN_CLOUD_DBPSW", "smoon");        //连接数据库的密码
            define("MFUN_CLOUD_DBNAME_L1L2L3", "bxxhl1l2l3");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_DEBUG", "bxxhl1vmlog");         //连接的log数据库名称
            define("MFUN_CLOUD_DBNAME_L4EMCWX", "bxxhl4emcwx");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4AQYC", "bxxhl4aqyc");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4TBSWR", "bxxhl4tbswr");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L5BI", "bxxhl5bi");         //连接的数据库名称
            define("MFUN_CLOUD_DBPORT", 3306);           //缺省设置
            define("MFUN_CLOUD_DBHOST_S", "");          //无效
            //EMCWX应用定义
            define("MFUN_WX_APPID", "wx1183be5c8f6a24b4");  //微信测试号AppID
            define("MFUN_WX_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");  //填写高级调用功能的app id, 请在微信开发模式后台查询
            define("MFUN_WX_ENCODINGAESKEY", "ihIyvJ8LLAnOHpHzKTG0yIJxlzl1Fzw5ygRgHO96ieW");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略
            //测试公号的后台运行配置参数
            define("MFUN_WX_TOOL_SERVICENUM", "gh_70c714952b02");
            define("MFUN_WX_TOOL_APPID", "wx1183be5c8f6a24b4");
            define("MFUN_WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
            define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF27");
            //RabbitMQ消息队列定义
            define("MFUN_MQ_RABBIT_HOST", "127.0.0.1");
            define("MFUN_MQ_RABBIT_PORT", "5672");
            define("MFUN_MQ_RABBIT_LOGIN", "guest");
            define("MFUN_MQ_RABBIT_PSWD", "guest");
            define("MFUN_MQ_RABBIT_VHOST", "/");
            define("MFUN_MQ_RABBIT_EXCHANGE", "e_linvo");
            define("MFUN_MQ_RABBIT_QUEUE", "q_linvo");
            define("MFUN_MQ_RABBIT_ROUTE_KEY", "key_1");
            break;
        case "www.baidu.com.cn": //百度云
            define("MFUN_CLOUD_HCU", "BAIDU_HCU"); //HCU后台云应用
            define("MFUN_CLOUD_WX", "BAIDU_WX"); //微信后台云应用
            //主数据库定义
            //define("MFUN_CLOUD_DBHOST", "h5.aiqiworld.com/myAdmin");    //连接的服务器地址
            define("MFUN_CLOUD_DBHOST", "127.0.0.1");    //连接的服务器地址
            define("MFUN_CLOUD_DBUSER", "root");     //连接数据库的用户名
            define("MFUN_CLOUD_DBPSW", "smoon");        //连接数据库的密码
            define("MFUN_CLOUD_DBNAME_L1L2L3", "bxxhl1l2l3");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_DEBUG", "bxxhl1vmlog");         //连接的log数据库名称
            define("MFUN_CLOUD_DBNAME_L4EMCWX", "bxxhl4emcwx");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4AQYC", "bxxhl4aqyc");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4TBSWR", "bxxhl4tbswr");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L5BI", "bxxhl5bi");         //连接的数据库名称
            define("MFUN_CLOUD_DBPORT", 3306);           //缺省设置
            define("MFUN_CLOUD_DBHOST_S", "");          //无效
            //EMCWX应用定义
            define("MFUN_WX_APPID", "wx1183be5c8f6a24b4");  //微信测试号AppID
            define("MFUN_WX_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");  //填写高级调用功能的app id, 请在微信开发模式后台查询
            define("MFUN_WX_ENCODINGAESKEY", "ihIyvJ8LLAnOHpHzKTG0yIJxlzl1Fzw5ygRgHO96ieW");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略
            //测试公号的后台运行配置参数
            define("MFUN_WX_TOOL_SERVICENUM", "gh_70c714952b02");
            define("MFUN_WX_TOOL_APPID", "wx1183be5c8f6a24b4");
            define("MFUN_WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
            define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF27");
            //RabbitMQ消息队列定义
            define("MFUN_MQ_RABBIT_HOST", "127.0.0.1");
            define("MFUN_MQ_RABBIT_PORT", "5672");
            define("MFUN_MQ_RABBIT_LOGIN", "guest");
            define("MFUN_MQ_RABBIT_PSWD", "guest");
            define("MFUN_MQ_RABBIT_VHOST", "/");
            define("MFUN_MQ_RABBIT_EXCHANGE", "e_linvo");
            define("MFUN_MQ_RABBIT_QUEUE", "q_linvo");
            define("MFUN_MQ_RABBIT_ROUTE_KEY", "key_1");
            break;
        case "www.jingdong.com.cn": //京东云
            define("MFUN_CLOUD_HCU", "JD_HCU"); //HCU后台云应用
            define("MFUN_CLOUD_WX", "JD_WX"); //微信后台云应用
            //主数据库定义
            //define("MFUN_CLOUD_DBHOST", "h5.aiqiworld.com/myAdmin");    //连接的服务器地址
            define("MFUN_CLOUD_DBHOST", "127.0.0.1");    //连接的服务器地址
            define("MFUN_CLOUD_DBUSER", "root");     //连接数据库的用户名
            define("MFUN_CLOUD_DBPSW", "smoon");        //连接数据库的密码
            define("MFUN_CLOUD_DBNAME_L1L2L3", "bxxhl1l2l3");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_DEBUG", "bxxhl1vmlog");         //连接的log数据库名称
            define("MFUN_CLOUD_DBNAME_L4EMCWX", "bxxhl4emcwx");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4AQYC", "bxxhl4aqyc");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4TBSWR", "bxxhl4tbswr");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L5BI", "bxxhl5bi");         //连接的数据库名称
            define("MFUN_CLOUD_DBPORT", 3306);           //缺省设置
            define("MFUN_CLOUD_DBHOST_S", "");          //无效
            //EMCWX应用定义
            define("MFUN_WX_APPID", "wx1183be5c8f6a24b4");  //微信测试号AppID
            define("MFUN_WX_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");  //填写高级调用功能的app id, 请在微信开发模式后台查询
            define("MFUN_WX_ENCODINGAESKEY", "ihIyvJ8LLAnOHpHzKTG0yIJxlzl1Fzw5ygRgHO96ieW");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略
            //测试公号的后台运行配置参数
            define("MFUN_WX_TOOL_SERVICENUM", "gh_70c714952b02");
            define("MFUN_WX_TOOL_APPID", "wx1183be5c8f6a24b4");
            define("MFUN_WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
            define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF27");
            //RabbitMQ消息队列定义
            define("MFUN_MQ_RABBIT_HOST", "127.0.0.1");
            define("MFUN_MQ_RABBIT_PORT", "5672");
            define("MFUN_MQ_RABBIT_LOGIN", "guest");
            define("MFUN_MQ_RABBIT_PSWD", "guest");
            define("MFUN_MQ_RABBIT_VHOST", "/");
            define("MFUN_MQ_RABBIT_EXCHANGE", "e_linvo");
            define("MFUN_MQ_RABBIT_QUEUE", "q_linvo");
            define("MFUN_MQ_RABBIT_ROUTE_KEY", "key_1");
            break;
        case "localhost": //用于本地浏览器调试
            define("MFUN_CLOUD_HCU", "LOCAL_HCU"); //HCU后台云应用
            define("MFUN_CLOUD_WX", "LOCAL_WX"); //微信后台云应用
            //主数据库定义
            define("MFUN_CLOUD_DBHOST", "localhost");    //连接的服务器地址
            define("MFUN_CLOUD_DBUSER", "TestUser");     //连接数据库的用户名
            define("MFUN_CLOUD_DBPSW", "123456");        //连接数据库的密码
            define("MFUN_CLOUD_DBNAME_L1L2L3", "bxxhl1l2l3");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_DEBUG", "bxxhl1vmlog");         //连接的log数据库名称
            define("MFUN_CLOUD_DBNAME_L4EMCWX", "bxxhl4emcwx");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4AQYC", "bxxhl4aqyc");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4TBSWR", "bxxhl4tbswr");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L5BI", "bxxhl5bi");         //连接的数据库名称
            define("MFUN_CLOUD_DBPORT", 3306);           //缺省设置
            define("MFUN_CLOUD_DBHOST_S", "");          //无效
            //EMCWX应用定义
            define("MFUN_WX_APPID", "wx1183be5c8f6a24b4");  //微信测试号AppID
            define("MFUN_WX_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");  //填写高级调用功能的app id, 请在微信开发模式后台查询
            define("MFUN_WX_ENCODINGAESKEY", "ihIyvJ8LLAnOHpHzKTG0yIJxlzl1Fzw5ygRgHO96ieW");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略
            //测试公号的后台运行配置参数
            define("MFUN_WX_TOOL_SERVICENUM", "gh_70c714952b02");
            define("MFUN_WX_TOOL_APPID", "wx1183be5c8f6a24b4");
            define("MFUN_WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
            define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF28");
            //RabbitMQ消息队列定义
            define("MFUN_MQ_RABBIT_HOST", "127.0.0.1");
            define("MFUN_MQ_RABBIT_PORT", "5672");
            define("MFUN_MQ_RABBIT_LOGIN", "guest");
            define("MFUN_MQ_RABBIT_PSWD", "guest");
            define("MFUN_MQ_RABBIT_VHOST", "/");
            define("MFUN_MQ_RABBIT_EXCHANGE", "e_linvo");
            define("MFUN_MQ_RABBIT_QUEUE", "q_linvo");
            define("MFUN_MQ_RABBIT_ROUTE_KEY", "key_1");
            break;
        default:
            define("MFUN_CLOUD_HCU", "XHZN_HCU"); //HCU后台云应用
            define("MFUN_CLOUD_WX", "PC_WX"); //微信后台云应用
            //主数据库定义
            define("MFUN_CLOUD_DBHOST", "localhost");    //连接的服务器地址
            define("MFUN_CLOUD_DBUSER", "TestUser");     //连接数据库的用户名
            define("MFUN_CLOUD_DBPSW", "123456");        //连接数据库的密码
            define("MFUN_CLOUD_DBNAME_L1L2L3", "bxxhl1l2l3");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_DEBUG", "bxxhl1vmlog");         //连接的log数据库名称
            define("MFUN_CLOUD_DBNAME_L4EMCWX", "bxxhl4emcwx");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4AQYC", "bxxhl4aqyc");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L4TBSWR", "bxxhl4tbswr");         //连接的数据库名称
            define("MFUN_CLOUD_DBNAME_L5BI", "bxxhl5bi");         //连接的数据库名称
            define("MFUN_CLOUD_DBPORT", 3306);           //缺省设置
            define("MFUN_CLOUD_DBHOST_S", "");          //无效
            //EMCWX应用定义
            define("MFUN_WX_APPID", "wx1183be5c8f6a24b4");  //微信测试号AppID
            define("MFUN_WX_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");  //填写高级调用功能的app id, 请在微信开发模式后台查询
            define("MFUN_WX_ENCODINGAESKEY", "ihIyvJ8LLAnOHpHzKTG0yIJxlzl1Fzw5ygRgHO96ieW");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略
            //测试公号的后台运行配置参数
            define("MFUN_WX_TOOL_SERVICENUM", "gh_70c714952b02");
            define("MFUN_WX_TOOL_APPID", "wx1183be5c8f6a24b4");
            define("MFUN_WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
            define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF28");
            //RabbitMQ消息队列定义
            define("MFUN_MQ_RABBIT_HOST", "127.0.0.1");
            define("MFUN_MQ_RABBIT_PORT", "5672");
            define("MFUN_MQ_RABBIT_LOGIN", "guest");
            define("MFUN_MQ_RABBIT_PSWD", "guest");
            define("MFUN_MQ_RABBIT_VHOST", "/");
            define("MFUN_MQ_RABBIT_EXCHANGE", "e_linvo");
            define("MFUN_MQ_RABBIT_QUEUE", "q_linvo");
            define("MFUN_MQ_RABBIT_ROUTE_KEY", "key_1");
            break;
    }

}else   //本地配置数据库信息,需要根据个人配置修改
{
    //云后台定义
    define("MFUN_CLOUD_HCU", "XHZN_HCU"); //HCU后台云应用
    define("MFUN_CLOUD_WX", "PC_WX"); //微信后台云应用
    //主数据库定义
    define("MFUN_CLOUD_DBHOST", "localhost");    //连接的服务器地址
    define("MFUN_CLOUD_DBUSER", "TestUser");     //连接数据库的用户名
    define("MFUN_CLOUD_DBPSW", "123456");        //连接数据库的密码
    define("MFUN_CLOUD_DBNAME_L1L2L3", "bxxhl1l2l3");         //连接的数据库名称
    define("MFUN_CLOUD_DBNAME_DEBUG", "bxxhl1vmlog");         //连接的log数据库名称
    define("MFUN_CLOUD_DBNAME_L4EMCWX", "bxxhl4emcwx");         //连接的数据库名称
    define("MFUN_CLOUD_DBNAME_L4AQYC", "bxxhl4aqyc");         //连接的数据库名称
    define("MFUN_CLOUD_DBNAME_L4TBSWR", "bxxhl4tbswr");         //连接的数据库名称
    define("MFUN_CLOUD_DBNAME_L5BI", "bxxhl5bi");         //连接的数据库名称
    define("MFUN_CLOUD_DBPORT", 3306);           //缺省设置
    define("MFUN_CLOUD_DBHOST_S", "");          //无效
    //EMCWX应用定义
    define("MFUN_WX_APPID", "wxf2150c4d2941b2ab");  //小慧智能服务号AppID
    define("MFUN_WX_APPSECRET", "ab95997f454e04b77911c18d09807831");  //填写高级调用功能的app id, 请在微信开发模式后台查询
    define("MFUN_WX_ENCODINGAESKEY", "1NxQnLdUUOr4s1r0rnxfuhoRdF14C5NO79o6AknsIYE");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

    //测试公号的后台运行配置参数
    define("MFUN_WX_TOOL_SERVICENUM", "gh_4667dc241921");
    define("MFUN_WX_TOOL_APPID", "wxf2150c4d2941b2ab");
    define("MFUN_WX_TOOL_APPSECRET", "ab95997f454e04b77911c18d09807831");
    define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF27");
    //RabbitMQ消息队列定义
    define("MFUN_MQ_RABBIT_HOST", "127.0.0.1");
    define("MFUN_MQ_RABBIT_PORT", "5672");
    define("MFUN_MQ_RABBIT_LOGIN", "guest");
    define("MFUN_MQ_RABBIT_PSWD", "guest");
    define("MFUN_MQ_RABBIT_VHOST", "/");
    define("MFUN_MQ_RABBIT_EXCHANGE", "e_linvo");
    define("MFUN_MQ_RABBIT_QUEUE", "q_linvo");
    define("MFUN_MQ_RABBIT_ROUTE_KEY", "key_1");
}

//TRACE开关，缺省打开
define ("TRACE_MSG_GENERAL_ON", 1); //开
define ("TRACE_MSG_GENERAL_OFF", 0); //关
define ("MFUN_TRACE_VM", "VM_TRACE");

define ("TRACE_MSG_MODE_INVALID", 0xFF); //无效
define ("TRACE_MSG_MODE_ALL_OFF", 0); //全关
define ("TRACE_MSG_MODE_ALL_ON", 1); //放开所有的TRACE模块和消息，该模式将忽略模块和消息的设置
define ("TRACE_MSG_MODE_MOUDLE_TO_ALLOW", 10);  //只通过模块号过滤消息
define ("TRACE_MSG_MODE_MOUDLE_TO_RESTRICT", 11);  //只通过模块号过滤消息
define ("TRACE_MSG_MODE_MOUDLE_FROM_ALLOW", 12);  //只通过模块号过滤消息
define ("TRACE_MSG_MODE_MOUDLE_FROM_RESTRICT", 13);  //只通过模块号过滤消息
define ("TRACE_MSG_MODE_MOUDLE_DOUBLE_ALLOW", 14);  //只通过模块号过滤消息
define ("TRACE_MSG_MODE_MOUDLE_DOUBLE_RESTRICT", 15);  //只通过模块号过滤消息
define ("TRACE_MSG_MODE_MSGID_ALLOW", 20);  //只通过模块号过滤消息
define ("TRACE_MSG_MODE_MSGID_RESTRICT", 21);  //只通过模块号过滤消息
define ("TRACE_MSG_MODE_COMBINE_TO_ALLOW", 30);  //通过模块和消息枚举
define ("TRACE_MSG_MODE_COMBINE_TO_RESTRICT", 31);  //通过模块和消息枚举
define ("TRACE_MSG_MODE_COMBINE_FROM_ALLOW", 32);  //通过模块和消息枚举
define ("TRACE_MSG_MODE_COMBINE_FROM_RESTRICT", 33);  //通过模块和消息枚举
define ("TRACE_MSG_MODE_COMBINE_DOUBLE_ALLOW", 34);  //通过模块和消息枚举
define ("TRACE_MSG_MODE_COMBINE_DOUBLE_RESTRICT", 35);  //通过模块和消息枚举
define ("TRACE_MSG_ON", TRACE_MSG_MODE_ALL_ON);


?>