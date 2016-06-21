<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2015/7/7
 * Time: 14:15
 */

/**Start of tool_main
 * 本工具用于管理员创建用户侧菜单
 *
 **/
include_once "../l1comvm/vmlayer.php";
//include_once "../l2sdk/l2sdk_iot_wx.class.php";
include_once "../l2sdk/task_l2sdk_wechat.class.php";

header("Content-type:text/html;charset=utf-8");

$wx_options = array(
    'token'=>WX_TOKEN, //填写你设定的key
    'encodingaeskey'=>WX_ENCODINGAESKEY, //填写加密用的EncodingAESKey，如接口为明文模式可忽略
    'appid'=>WX_APPID,
    'appsecret'=>WX_APPSECRET, //填写高级调用功能的密钥
    'debug'=> WX_DEBUG,
    'logcallback' => WX_LOGCALLBACK
);
$wxObj = new class_wechat_sdk($wx_options);


//Step1:刷新Token
echo "<br><H2>微信硬件工作环境即将开始......<br></H2>";
echo "WX_APPID = " . WX_APPID . "<br>";
echo "WX_APPSECRET = " . WX_APPSECRET .  "<br>";


$wxDevObj = new class_wx_IOT_sdk(WX_APPID, WX_APPSECRET);


//实验Token是否已经被刷新
echo "<br>测试最新刷新的Token=<br>".$wxDevObj->access_token ."<br>";


//Step2:测试创建微信界面上自定义的菜单
static $self_create_menu =
'{"button":[
                {"name":"测量",
                    "sub_button":[{"type":"click","name":"PM2.5读取","key":"CLICK_PM25_READ"},
                                  {"type":"click","name":"辐射读取","key":"CLICK_EMC_READ"},
                                  {"type":"click","name":"历史数据","key":"CLICK__EMC_HIS"}]
                },

                {"name":"设置",
                     "sub_button":[{"type":"click","name":"绑定","key":"CLICK_BIND"},
                                   {"type":"click","name":"解绑","key":"CLICK_UNBIND"},
                                   {"type":"click","name":"查询","key":"CLICK_BIND_INQ"},
                                   {"type":"click","name":"Trace开","key":"CLICK_TRACE_ON"},
                                   {"type":"click","name":"Trace关","key":"CLICK_TRACE_OFF"}]
                },

                {"name":"关于",
                    "sub_button":[{"type":"click","name":"版本信息","key":"CLICK_VERSION"},
                                  {"type":"click","name":"用户信息","key":"CLICK_USER"},
                                  {"type":"view","name":"H5页面","url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx32f73ab219f56efb&redirect_uri=http://mfuncard.sinaapp.com/wechat/l4emcwxui/h5ui/emch5.php&response_type=code&scope=snsapi_base&state=1#wechat_redirect"}]
                }
         ]
 }';

echo "<br>自定义菜单创建（先删再建-微信界面需要24小时更新，重新关注可立即刷新） <br><br>";

echo "菜单删除结果：<br>";
var_dump($wxDevObj->delete_menu());
echo "<br>新菜单创建结果：<br>";
var_dump($wxDevObj->create_menu($self_create_menu));


?>