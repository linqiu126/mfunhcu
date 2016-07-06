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
//项目目前支持：HCU_PRJ_AQYC, HCU_PRJ_TBSWR, HCU_PRJ_EMCWX, 本地=HCU_PRJ_AQYC
define ("MFUN_WORKING_PROJECT_NAME_UNIQUE_AQYC", "HCU_PRJ_AQYC");
define ("MFUN_WORKING_PROJECT_NAME_UNIQUE_EMCWX", "HCU_PRJ_EMCWX");
define ("MFUN_WORKING_PROJECT_NAME_UNIQUE_TBSWR", "HCU_PRJ_TBSWR");
define ("MFUN_CURRENT_WORKING_PROJECT_NAME_UNIQUE", MFUN_WORKING_PROJECT_NAME_UNIQUE_AQYC);

//定义系统消息入口
define ("MFUN_MAIN_ENTRY_IOT_HCU", "MFUN_MAIN_ENTRY_IOT_HCU");
define ("MFUN_MAIN_ENTRY_WECHAT", "MFUN_MAIN_ENTRY_WECHAT");
define ("MFUN_MAIN_ENTRY_JINGDONG", "MFUN_MAIN_ENTRY_JINGDONG");
define ("MFUN_MAIN_ENTRY_APPLE", "MFUN_MAIN_ENTRY_APPLE");
define ("MFUN_MAIN_ENTRY_CRON", "MFUN_MAIN_ENTRY_CRON");
define ("MFUN_MAIN_ENTRY_SOCKET_LISTEN", "MFUN_MAIN_ENTRY_SOCKET_LISTEN");
define ("MFUN_MAIN_ENTRY_AQYC_UI", "MFUN_MAIN_ENTRY_AQYC_UI");
define ("MFUN_MAIN_ENTRY_TBSWR_UI", "MFUN_MAIN_ENTRY_TBSWR_UI");
define ("MFUN_MAIN_ENTRY_EMCWX_UI", "MFUN_MAIN_ENTRY_EMCWX_UI");
define ("MFUN_MAIN_ENTRY_DIRECT_IN", "MFUN_MAIN_ENTRY_DIRECT_IN");

//不同的方式来确定本机运行环境，还是服务器运行环境，本来想获取Localhost来进行判断，但没成功
//实验了不同的方式，包括$_SERVER['LOCAL_ADDR']， $_SERVER['SERVER_ADDR']， getenv('SERVER_ADDR')等方式
//GetHostByName($_SERVER['SERVER_NAME'])只能获取IP地址，也不稳定
//使用php_uname('n') == "CV0002816N4")也算是一个不错的方式，但依然丑陋，需要每个测试者单独配置，
//也可以使用云服务器的名字来反向匹配，因为服务器的名字是唯一的
//SAE官方的说法：可以使用isset(SAE_TMP_PATH)来判断是不是在SAE云上
//
if (isset($_SERVER['SERVER_NAME']))
{
    if ($_SERVER['SERVER_NAME'] == "mfuncard.sinaapp.com") //LZH微信公号服务器数据库配置信息
    {
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

    } elseif ($_SERVER['SERVER_NAME'] == "mfunhcu.sinaapp.com") {
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

    } elseif ($_SERVER['SERVER_NAME'] == "smdzjl.sinaapp.com") //ZJL微信公号服务器数据库配置信息
    {
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
        define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF24");
        //RabbitMQ消息队列定义
        define("MFUN_MQ_RABBIT_HOST", SAE_MYSQL_HOST_M);
        define("MFUN_MQ_RABBIT_PORT", "5672");
        define("MFUN_MQ_RABBIT_LOGIN", "guest");
        define("MFUN_MQ_RABBIT_PSWD", "guest");
        define("MFUN_MQ_RABBIT_VHOST", "/");
        define("MFUN_MQ_RABBIT_EXCHANGE", "e_linvo");
        define("MFUN_MQ_RABBIT_QUEUE", "q_linvo");
        define("MFUN_MQ_RABBIT_ROUTE_KEY", "key_1");

    } elseif ($_SERVER['SERVER_NAME'] == "zscble.sinaapp.com") //ZSC微信公号服务器数据库配置信息
    {
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
        define("MFUN_WX_APPID", "wx6b0e904f5e91a404");  //微信测试号AppID
        define("MFUN_WX_APPSECRET", "aeb0cf36a1aa37b0180711304f3f3131");  //填写高级调用功能的app id, 请在微信开发模式后台查询
        define("MFUN_WX_ENCODINGAESKEY", "p1zUNVmJAOWX7QsnArWIbuAEYaqtRNFY6Rz1JcqEklu");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略
        //测试公号的后台运行配置参数
        define("MFUN_WX_TOOL_SERVICENUM", "gh_b6df3b7c56eb");
        define("MFUN_WX_TOOL_APPID", "wx6b0e904f5e91a404");
        define("MFUN_WX_TOOL_APPSECRET", "aeb0cf36a1aa37b0180711304f3f3131");
        define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF12");
        //RabbitMQ消息队列定义
        define("MFUN_MQ_RABBIT_HOST", SAE_MYSQL_HOST_M);
        define("MFUN_MQ_RABBIT_PORT", "5672");
        define("MFUN_MQ_RABBIT_LOGIN", "guest");
        define("MFUN_MQ_RABBIT_PSWD", "guest");
        define("MFUN_MQ_RABBIT_VHOST", "/");
        define("MFUN_MQ_RABBIT_EXCHANGE", "e_linvo");
        define("MFUN_MQ_RABBIT_QUEUE", "q_linvo");
        define("MFUN_MQ_RABBIT_ROUTE_KEY", "key_1");

    } elseif ($_SERVER['SERVER_NAME'] == "121.40.185.177") //爱启云
    {
        //云后台定义
        define("MFUN_CLOUD_HCU", "AQ_HCU"); //HCU后台云应用
        define("MFUN_CLOUD_WX", "AQ_WX"); //微信后台云应用
        //主数据库定义
        //define("MFUN_CLOUD_DBHOST", "h5.aiqiworld.com/myAdmin");    //连接的服务器地址
        define("MFUN_CLOUD_DBHOST", "127.0.0.1");    //连接的服务器地址
        define("MFUN_CLOUD_DBUSER", "root");     //连接数据库的用户名
        define("MFUN_CLOUD_DBPSW", "smoon");        //连接数据库的密码
        define("MFUN_CLOUD_DBNAME_L1L2L3", "bxxhl1l2l3");         //连接的数据库名称
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

    }elseif ($_SERVER['SERVER_NAME'] == "localhost"){  //用于本地浏览器调试
        //云后台定义
        define("MFUN_CLOUD_HCU", "AQ_HCU"); //HCU后台云应用
        define("MFUN_CLOUD_WX", "AQ_WX"); //微信后台云应用
        //主数据库定义
        define("MFUN_CLOUD_DBHOST", "localhost");    //连接的服务器地址
        define("MFUN_CLOUD_DBUSER", "TestUser");     //连接数据库的用户名
        define("MFUN_CLOUD_DBPSW", "123456");        //连接数据库的密码
        define("MFUN_CLOUD_DBNAME_L1L2L3", "bxxhl1l2l3");         //连接的数据库名称
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
        define("MFUN_WX_TOOL_SERVICENUM", "gh_70c714952b02");//微信号
        define("MFUN_WX_TOOL_APPID", "wx1183be5c8f6a24b4");//微信测试号信息
        define("MFUN_WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
        define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF11");
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
}else   //本地配置数据库信息,需要根据个人配置修改
{
    //云后台定义
    define("MFUN_CLOUD_HCU", "AQ_HCU"); //HCU后台云应用
    define("MFUN_CLOUD_WX", "AQ_WX"); //微信后台云应用
    //主数据库定义
    define("MFUN_CLOUD_DBHOST", "localhost");    //连接的服务器地址
    define("MFUN_CLOUD_DBUSER", "TestUser");     //连接数据库的用户名
    define("MFUN_CLOUD_DBPSW", "123456");        //连接数据库的密码
    define("MFUN_CLOUD_DBNAME_L1L2L3", "bxxhl1l2l3");         //连接的数据库名称
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
    define("MFUN_WX_TOOL_SERVICENUM", "gh_70c714952b02");//微信号
    define("MFUN_WX_TOOL_APPID", "wx1183be5c8f6a24b4");//微信测试号信息
    define("MFUN_WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
    define("MFUN_WX_TOOL_BLEMAC", "D03972A5EF11");
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