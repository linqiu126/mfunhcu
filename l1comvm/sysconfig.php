<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 13:15
 */

/*
 *  全局控制常量
 *
 */

//项目名称，每个项目均为唯一用于本项目选择启动配置数据库中的工参信息
define (MFUN_CURRENT_WORKING_PROJECT_NAME_UNIQUE, "HCU_PRJ_AQYC");

//不同的方式来确定本机运行环境，还是服务器运行环境，本来想获取Localhost来进行判断，但没成功
//实验了不同的方式，包括$_SERVER['LOCAL_ADDR']， $_SERVER['SERVER_ADDR']， getenv('SERVER_ADDR')等方式
//GetHostByName($_SERVER['SERVER_NAME'])只能获取IP地址，也不稳定
//使用php_uname('n') == "CV0002816N4")也算是一个不错的方式，但依然丑陋，需要每个测试者单独配置，
//也可以使用云服务器的名字来反向匹配，因为服务器的名字是唯一的
//SAE官方的说法：可以使用isset(SAE_TMP_PATH)来判断是不是在SAE云上
//
if ($_SERVER['SERVER_NAME'] == "mfuncard.sinaapp.com") //LZH微信公号服务器数据库配置信息
{
    define("CLOUD_HCU", "SAE_HCU"); //HCU后台云应用
    define("CLOUD_WX", "SAE_WX"); //微信后台云应用

    define("WX_APPID", "wx32f73ab219f56efb");  //微信测试号AppID
    define("WX_APPSECRET", "eca20c2a26a5ec5b64a89d15ba92a781");  //填写高级调用功能的app id, 请在微信开发模式后台查询
    define("WX_ENCODINGAESKEY", "7Tp1NIUzUa0JBezeJUjG8O61Kdjcu2ce6BQVukZlv3u");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

    //测试公号的后台运行配置参数
    define("WX_TOOL_SERVICENUM", "gh_9b450bb63282");
    define("WX_TOOL_APPID", "wx32f73ab219f56efb");
    define("WX_TOOL_APPSECRET", "eca20c2a26a5ec5b64a89d15ba92a781");
    define("WX_TOOL_BLEMAC", "D03972A5EF25");

    define("MFUN_DBHOST", SAE_MYSQL_HOST_M);    //连接的服务器地址 w.rdc.sae.sina.com.cn
    define("MFUN_DBUSER",SAE_MYSQL_USER);     //连接数据库的用户名
    define("MFUN_DBPSW", SAE_MYSQL_PASS);        //连接数据库的密码
    define("MFUN_DBNAME","app_mfuncard");         //连接的数据库名称
    define("MFUN_DBPORT", SAE_MYSQL_PORT);
    define("MFUN_DBHOST_S", SAE_MYSQL_DB);

}elseif ($_SERVER['SERVER_NAME'] == "mfunhcu.sinaapp.com")
{
    define("CLOUD_HCU", "SAE_HCU"); //HCU后台云应用
    define("CLOUD_WX", "SAE_WX"); //微信后台云应用

    define("WX_APPID", "wx1183be5c8f6a24b4");  //微信测试号AppID
    define("WX_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");  //填写高级调用功能的app id, 请在微信开发模式后台查询
    define("WX_ENCODINGAESKEY", "ihIyvJ8LLAnOHpHzKTG0yIJxlzl1Fzw5ygRgHO96ieW");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

    //测试公号的后台运行配置参数
    define("WX_TOOL_SERVICENUM", "gh_70c714952b02");
    define("WX_TOOL_APPID", "wx1183be5c8f6a24b4");
    define("WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
    define("WX_TOOL_BLEMAC", "D03972A5EF27");

    define("MFUN_DBHOST", SAE_MYSQL_HOST_M);    //连接的服务器地址 w.rdc.sae.sina.com.cn
    define("MFUN_DBUSER",SAE_MYSQL_USER);     //连接数据库的用户名
    define("MFUN_DBPSW", SAE_MYSQL_PASS);        //连接数据库的密码
    define("MFUN_DBNAME","app_mfunhcu");         //连接的数据库名称
    define("MFUN_DBPORT", SAE_MYSQL_PORT);
    define("MFUN_DBHOST_S", SAE_MYSQL_DB);

}elseif ($_SERVER['SERVER_NAME'] == "smdzjl.sinaapp.com") //ZJL微信公号服务器数据库配置信息
{
    define("CLOUD_HCU", "SAE_HCU"); //HCU后台云应用
    define("CLOUD_WX", "SAE_WX"); //微信后台云应用

    define("WX_APPID", "wx32f73ab219f56efb");  //微信测试号AppID
    define("WX_APPSECRET", "eca20c2a26a5ec5b64a89d15ba92a781");  //填写高级调用功能的app id, 请在微信开发模式后台查询
    define("WX_ENCODINGAESKEY", "7Tp1NIUzUa0JBezeJUjG8O61Kdjcu2ce6BQVukZlv3u");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

    //测试公号的后台运行配置参数
    define("WX_TOOL_SERVICENUM", "gh_9b450bb63282");
    define("WX_TOOL_APPID", "wx32f73ab219f56efb");
    define("WX_TOOL_APPSECRET", "eca20c2a26a5ec5b64a89d15ba92a781");
    define("WX_TOOL_BLEMAC", "D03972A5EF24");

    define("MFUN_DBHOST", SAE_MYSQL_HOST_M);    //连接的服务器地址 w.rdc.sae.sina.com.cn
    define("MFUN_DBUSER",SAE_MYSQL_USER);     //连接数据库的用户名
    define("MFUN_DBPSW", SAE_MYSQL_PASS);        //连接数据库的密码
    define("MFUN_DBNAME","app_smdzjl");         //连接的数据库名称
    define("MFUN_DBPORT", SAE_MYSQL_PORT);
    define("MFUN_DBHOST_S", SAE_MYSQL_DB);

}elseif ($_SERVER['SERVER_NAME'] == "zscble.sinaapp.com") //ZSC微信公号服务器数据库配置信息
{
    define("CLOUD_HCU", "SAE_HCU"); //HCU后台云应用
    define("CLOUD_WX", "SAE_WX"); //微信后台云应用

    define("WX_APPID", "wx6b0e904f5e91a404");  //微信测试号AppID
    define("WX_APPSECRET", "aeb0cf36a1aa37b0180711304f3f3131");  //填写高级调用功能的app id, 请在微信开发模式后台查询
    define("WX_ENCODINGAESKEY", "p1zUNVmJAOWX7QsnArWIbuAEYaqtRNFY6Rz1JcqEklu");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

    //测试公号的后台运行配置参数
    define("WX_TOOL_SERVICENUM", "gh_b6df3b7c56eb");
    define("WX_TOOL_APPID", "wx6b0e904f5e91a404");
    define("WX_TOOL_APPSECRET", "aeb0cf36a1aa37b0180711304f3f3131");
    define("WX_TOOL_BLEMAC", "D03972A5EF12");

    define("MFUN_DBHOST", SAE_MYSQL_HOST_M);    //连接的服务器地址 w.rdc.sae.sina.com.cn
    define("MFUN_DBUSER",SAE_MYSQL_USER);     //连接数据库的用户名
    define("MFUN_DBPSW", SAE_MYSQL_PASS);        //连接数据库的密码
    define("MFUN_DBNAME","app_zscble");         //连接的数据库名称
    define("MFUN_DBPORT", SAE_MYSQL_PORT);
    define("MFUN_DBHOST_S", SAE_MYSQL_DB);

}elseif ($_SERVER['SERVER_NAME'] == "121.40.185.177") //爱启云
{
    define("CLOUD_HCU", "AQ_HCU"); //HCU后台云应用
    define("CLOUD_WX", "AQ_WX"); //微信后台云应用

    //define("MFUN_DBHOST", "h5.aiqiworld.com/myAdmin");    //连接的服务器地址
    define("MFUN_DBHOST", "127.0.0.1");    //连接的服务器地址
    define("MFUN_DBUSER","root");     //连接数据库的用户名
    define("MFUN_DBPSW", "smoon");        //连接数据库的密码
    define("MFUN_DBNAME","bxxh");         //连接的数据库名称BXXH
    define("MFUN_DBPORT", 3306);           //缺省设置
    define("MFUN_DBHOST_S", "");          //无效

    define("WX_APPID", "wx1183be5c8f6a24b4");  //微信测试号AppID
    define("WX_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");  //填写高级调用功能的app id, 请在微信开发模式后台查询
    define("WX_ENCODINGAESKEY", "ihIyvJ8LLAnOHpHzKTG0yIJxlzl1Fzw5ygRgHO96ieW");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

    //测试公号的后台运行配置参数
    define("WX_TOOL_SERVICENUM", "gh_70c714952b02");
    define("WX_TOOL_APPID", "wx1183be5c8f6a24b4");
    define("WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
    define("WX_TOOL_BLEMAC", "D03972A5EF27");

}else   //本地配置数据库信息,需要根据个人配置修改
{
    define("CLOUD_HCU", "AQ_HCU"); //HCU后台云应用
    define("CLOUD_WX", "AQ_WX"); //微信后台云应用

    define("MFUN_DBHOST", "localhost");    //连接的服务器地址
    define("MFUN_DBUSER","TestUser");     //连接数据库的用户名
    define("MFUN_DBPSW", "123456");        //连接数据库的密码
    define("MFUN_DBNAME","BXXH");         //连接的数据库名称BXXH
    define("MFUN_DBPORT", 3306);           //缺省设置
    define("MFUN_DBHOST_S", "");          //无效

    define("WX_APPID", "wx1183be5c8f6a24b4");  //微信测试号AppID
    define("WX_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");  //填写高级调用功能的app id, 请在微信开发模式后台查询
    define("WX_ENCODINGAESKEY", "ihIyvJ8LLAnOHpHzKTG0yIJxlzl1Fzw5ygRgHO96ieW");   //填写加密用的EncodingAESKey，如接口为明文模式可忽略

    //测试公号的后台运行配置参数
    define("WX_TOOL_SERVICENUM", "gh_70c714952b02");//微信号
    define("WX_TOOL_APPID", "wx1183be5c8f6a24b4");//微信测试号信息
    define("WX_TOOL_APPSECRET", "d52a63064ed543c5eecae6c3df35be55");
    define("WX_TOOL_BLEMAC", "D03972A5EF11");
}


?>