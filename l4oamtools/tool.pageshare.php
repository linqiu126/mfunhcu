<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2015/7/15
 * Time: 11:58
 */
header("Content-type:text/html;charset=utf-8");
include_once "../l1comvm/vmlayer.php";
require_once "../l2sdk/task_l2sdk_iot_wx_jssdk.php";


$jssdk = new JSSDK(WX_APPID, WX_APPSECRET);
$signPackage = $jssdk->GetSignPackage();

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>分享及图形界面测试</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <link rel="stylesheet" href="http://demo.open.weixin.qq.com/jssdk/css/style.css?ts=1420774989">
</head>

<!-- Test for Cavans  -->

<style type="text/css">
    canvas{border:dashed 2px #CCC}
</style>
<script type="text/javascript">

    function pageLoad(id){
        var mpWidth = document.documentElement.clientWidth;
        if (mpWidth > 400) {mpWidth = 400;}
        var mpHeight = 500;
        var workHeight = 1000;
        var can = document.getElementById(id);
        var cans = can.getContext('2d');

        //数据显示区初始化
        cans.strokeStyle = 'red';
        cans.strokeRect(0,0,mpWidth,workHeight);
        cans.fillStyle = 'white';
        cans.fillRect(0,0,mpWidth,workHeight);
        cans.textAlign = 'left';
        cans.textBaseline = 'top';
        cans.font = 'bold 12px arial';
        cans.fillStyle = "green";
        cans.fillText("你还没有绑定设备", mpWidth/2, 20);

        //圆形数据显示框
        cans.beginPath();
        cans.arc(mpWidth/2,mpWidth/2,mpWidth/4,0,Math.PI*2,false);
        cans.closePath();
        cans.lineWidth = 5;
        cans.strokeStyle = 'green';
        cans.stroke();
        cans.textAlign = 'left';
        cans.textBaseline = 'top';
        cans.font = 'bold 80px arial';
        cans.fillStyle = "blue";
        var fillFigure = <?php
            include_once "../l1comvm/vmlayer.php";
            include_once "../l2sdk/task_l2sdk_iot_wx.class.php";
            //访问数据库数据
            $db = new class_wx_db();
            $tmp = 36;
            echo $tmp;
            ?>;
        cans.fillText(fillFigure, mpWidth/2-45, mpWidth/2-45);
        cans.textAlign = 'left';
        cans.textBaseline = 'top';
        cans.font = 'bold 20px arial';
        cans.fillStyle = "green";
        cans.fillText("刷新历史数据", mpWidth/3, mpWidth*3/4+20);

        //日周月的图标
        var y1 = mpHeight*3/4;
        var y2 = 20;
        cans.fillStyle  = 'grey';
        cans.fillRect(0,y1,mpWidth,y2);
        var xDay = 0;
        var xWidth = mpWidth/3;
        var xWeek = xDay + xWidth;
        var xMonth = xWeek + xWidth;
        var yStart = y1+y2;
        var yHeight = 40;
        cans.textAlign = 'left';
        cans.textBaseline = 'top';
        cans.font = 'bold 16px arial';
        cans.fillStyle = "blue";
        cans.fillRect(xDay,yStart,xWidth,yHeight); //日
        cans.fillStyle  = 'black';
        cans.fillText("日", xDay+xWidth/2-10, yStart+yHeight/2-10);
        cans.fillStyle  = 'yellow';
        cans.fillRect(xWeek,yStart,xWidth,yHeight); //周
        cans.fillStyle  = 'black';
        cans.fillText("周", xWeek+xWidth/2-10, yStart+yHeight/2-10);
        cans.fillStyle  = 'red';
        cans.fillRect(xMonth,yStart,xWidth,yHeight); //月
        cans.fillStyle  = 'black';
        cans.fillText("月", xMonth+xWidth/2-10, yStart+yHeight/2-10);

        //累计辐射图形背景
        var y3 = yStart + yHeight + 40;
        yHeight = 150;
        var y4 = y3 + yHeight;
        var y5 = y4 + yHeight;
        var xStart = 20;
        cans.fillStyle  = "rgb(255,100,100)";
        cans.fillRect(xStart,y3,mpWidth-xStart,yHeight); //超标部分
        cans.fillStyle  = 'yellow';
        cans.fillRect(xStart,y4,mpWidth-xStart,yHeight); //不安全部分
        cans.fillStyle  = 'green';
        cans.fillRect(xStart,y5,mpWidth-xStart,yHeight); //安全部分
        cans.textAlign = 'left';
        cans.textBaseline = 'top';
        cans.font = 'bold 14px arial';
        cans.fillStyle = "blue";
        cans.fillText("历史累计测试数据", mpWidth/4, y3-20);

        //画Y轴坐标
        cans.lineWidth=1;
        cans.strokeStyle = 'grey';
        cans.textAlign = 'left';
        cans.textBaseline = 'top';
        cans.font = 'bold 12px arial';
        cans.fillStyle = "red";
        cans.fillText("mV", 0, y3-20);
        cans.fillStyle = "green";
        for (i=0; i<15; i++)
        {
            cans.moveTo(xStart,y3+i*30);
            cans.lineTo(mpWidth,y3+i*30);
            cans.fillText(150-i*10, 0,y3+i*30+10);
        }
        cans.stroke();

        //画X轴坐标
        cans.lineWidth=1;
        cans.strokeStyle = 'grey';
        y6 = y5+yHeight;
        xLength = (mpWidth-xStart)/12;
        yLength = 10;
        cans.font = 'bold 144px consolas';
        cans.textAlign = 'left';
        cans.textBaseline = 'top';
        cans.font = 'bold 12px arial';
        cans.fillStyle = "blue";
        for (i=0; i<12; i++)
        {
            cans.moveTo(xStart+i*xLength,y6);
            cans.lineTo(xStart+i*xLength,y6+yLength);
            cans.fillText((i+1)*2, xStart+(i+0.4)*xLength,y6+yLength);
        }
        cans.stroke();
    }

    function clientWidth()
    {
        return document.documentElement.clientWidth;
    }

    //获取事件的坐标
    function getEventPosition(ev){
        var x, y;
        if (ev.layerX || ev.layerX == 0) {
            x = ev.layerX;
            y = ev.layerY;
        } else if (ev.offsetX || ev.offsetX == 0) { // Opera
            x = ev.offsetX;
            y = ev.offsetY;
        }
        return {x: x, y: y};
    }

    //判断坐标是否在“刷新历史数据”的范畴内，然后执行AJAX的Php处理
    function historyButtonClick(id){
        var mpWidth = document.documentElement.clientWidth;
        if (mpWidth > 400) {mpWidth = 400;}
        var mpHeight = 500;
        var workHeight = 1000;
        var can = document.getElementById(id);
        var cans = can.getContext('2d');
        var position = getEventPosition(cans);
        var x0 = mpWidth/3 - 10;
        var y0 = mpWidth*3/4+20 - 10;
        var x1 = x0+100;
        var y1 = y0+50;
        if ((position.x > x0) && (position.x < x1) && (position.y > y0) && (position.y <y1))
        {//在矩形范围类
            var xmlHttp=null;
            xmlHttp=new XMLHttpRequest();
            var url="tool.ajaxhisdata.php";
            var localWxUser = "";  //未来需要仔细设计这个信息
            url=url+"?q="+localWxUser;
            //url=url+"&sid="+Math.random();  //W3C官方例子，再探究其用意
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    var result = xmlhttp.responseText;
                    cans.textAlign = 'left';
                    cans.textBaseline = 'top';
                    cans.font = 'bold 12px arial';
                    cans.fillStyle = "green";
                    cans.fillText(result, mpWidth/3+50, mpWidth*3/4+20);
                }
            }
            xmlHttp.open("GET",url,true);
            xmlHttp.send(null);
        }
    }

</script>

<body onload="pageLoad('can1');" onclick="historyButtonClick('can1');">
<canvas id="can1" width="355px" height="1000px">4</canvas>
<!--到底是再放置一个新的canvas，实现历史查询功能，还是增加一个按钮功能，实现历史记录查询？
    canvas的好处是：文字及按钮的位置可以自定义，但相应的事件采用哪一个？
    Button很难精确放置其位置，但onclick事件非常明确-->
</body>

<!-- </html>
<!-- end of test for Cavans  -->


<body>
<div class="wxapi_container">
    <div class="wxapi_index_container">
        <ul class="label_box lbox_close wxapi_index_list">
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-basic">基础接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-share">分享接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-image">图像接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-voice">音频接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-smart">智能接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-device">设备信息接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-location">地理位置接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-webview">界面操作接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-scan">微信扫一扫接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-shopping">微信小店接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-card">微信卡券接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-pay">微信支付接口</a></li>
        </ul>
    </div>
    <div class="lbox_close wxapi_form">
        <h3 id="menu-basic">基础接口</h3>
        判断当前客户端是否支持指定JS接口
        <button class="btn btn_primary" id="checkJsApi">checkJsApi</button>

        <h3 id="menu-share">分享接口</h3>
        获取“分享到朋友圈”按钮点击状态及自定义分享内容接口
        <button class="btn btn_primary" id="onMenuShareTimeline">onMenuShareTimeline</button>
        获取“分享给朋友”按钮点击状态及自定义分享内容接口
        <button class="btn btn_primary" id="onMenuShareAppMessage">onMenuShareAppMessage</button>
        获取“分享到QQ”按钮点击状态及自定义分享内容接口
        <button class="btn btn_primary" id="onMenuShareQQ">onMenuShareQQ</button>
        获取“分享到腾讯微博”按钮点击状态及自定义分享内容接口
        <button class="btn btn_primary" id="onMenuShareWeibo">onMenuShareWeibo</button>

        <h3 id="menu-image">图像接口</h3>
        拍照或从手机相册中选图接口
        <button class="btn btn_primary" id="chooseImage">chooseImage</button>
        预览图片接口
        <button class="btn btn_primary" id="previewImage">previewImage</button>
        上传图片接口
        <button class="btn btn_primary" id="uploadImage">uploadImage</button>
        下载图片接口
        <button class="btn btn_primary" id="downloadImage">downloadImage</button>

        <h3 id="menu-voice">音频接口</h3>
        开始录音接口
        <button class="btn btn_primary" id="startRecord">startRecord</button>
        停止录音接口
        <button class="btn btn_primary" id="stopRecord">stopRecord</button>
        播放语音接口
        <button class="btn btn_primary" id="playVoice">playVoice</button>
        暂停播放接口
        <button class="btn btn_primary" id="pauseVoice">pauseVoice</button>
        停止播放接口
        <button class="btn btn_primary" id="stopVoice">stopVoice</button>
        上传语音接口
        <button class="btn btn_primary" id="uploadVoice">uploadVoice</button>
        下载语音接口
        <button class="btn btn_primary" id="downloadVoice">downloadVoice</button>

        <h3 id="menu-smart">智能接口</h3>
        识别音频并返回识别结果接口
        <button class="btn btn_primary" id="translateVoice">translateVoice</button>

        <h3 id="menu-device">设备信息接口</h3>
        获取网络状态接口
        <button class="btn btn_primary" id="getNetworkType">getNetworkType</button>

        <h3 id="menu-location">地理位置接口</h3>
        使用微信内置地图查看位置接口
        <button class="btn btn_primary" id="openLocation">openLocation</button>
        获取地理位置接口
        <button class="btn btn_primary" id="getLocation">getLocation</button>

        <h3 id="menu-webview">界面操作接口</h3>
        隐藏右上角菜单接口
        <button class="btn btn_primary" id="hideOptionMenu">hideOptionMenu</button>
        显示右上角菜单接口
        <button class="btn btn_primary" id="showOptionMenu">showOptionMenu</button>
        关闭当前网页窗口接口
        <button class="btn btn_primary" id="closeWindow">closeWindow</button>
        批量隐藏功能按钮接口
        <button class="btn btn_primary" id="hideMenuItems">hideMenuItems</button>
        批量显示功能按钮接口
        <button class="btn btn_primary" id="showMenuItems">showMenuItems</button>
        隐藏所有非基础按钮接口
        <button class="btn btn_primary" id="hideAllNonBaseMenuItem">hideAllNonBaseMenuItem</button>
        显示所有功能按钮接口
        <button class="btn btn_primary" id="showAllNonBaseMenuItem">showAllNonBaseMenuItem</button>

        <h3 id="menu-scan">微信扫一扫</h3>
        调起微信扫一扫接口
        <button class="btn btn_primary" id="scanQRCode0">scanQRCode(微信处理结果)</button>
        <button class="btn btn_primary" id="scanQRCode1">scanQRCode(直接返回结果)</button>

        <h3 id="menu-shopping">微信小店接口</h3>
        跳转微信商品页接口
        <button class="btn btn_primary" id="openProductSpecificView">openProductSpecificView</button>

        <h3 id="menu-card">微信卡券接口</h3>
        批量添加卡券接口
        <button class="btn btn_primary" id="addCard">addCard</button>
        调起适用于门店的卡券列表并获取用户选择列表
        <button class="btn btn_primary" id="chooseCard">chooseCard</button>
        查看微信卡包中的卡券接口
        <button class="btn btn_primary" id="openCard">openCard</button>

        <h3 id="menu-pay">微信支付接口</h3>
        发起一个微信支付请求
        <button class="btn btn_primary" id="chooseWXPay">chooseWXPay</button>
    </div>
</div>
</body>

<!--步骤二：引入JS文件  -->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<!--步骤三：通过config接口注入权限验证配置 -->
<script>
    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'translateVoice',
            'startRecord',
            'stopRecord',
            'onRecordEnd',
            'playVoice',
            'pauseVoice',
            'stopVoice',
            'uploadVoice',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'getNetworkType',
            'openLocation',
            'getLocation',
            'hideOptionMenu',
            'showOptionMenu',
            'closeWindow',
            'scanQRCode',
            'chooseWXPay',
            'openProductSpecificView',
            'addCard',
            'chooseCard',
            'openCard'
        ]
    });
</script>

<!-- //步骤四：通过ready接口处理成功验证 -->
<script>
    wx.ready(function () {
        // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
        document.querySelector('#checkJsApi').onclick = function () {
            wx.checkJsApi({
                jsApiList: [
                    'getNetworkType',
                    'previewImage'
                ],
                success: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        };

        // 2. 分享接口
        // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口
        document.querySelector('#onMenuShareAppMessage').onclick = function () {
            wx.onMenuShareAppMessage({
                title: '<a mcolored="true" href="http://www.it165.net/news/nhlw/" target="_blank" class="keylink">互联网</a>之子',
                desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
                link: 'http://movie.douban.com/subject/25785114/',
                imgUrl: 'http://demo.open.weixin.qq.com/jssdk/images/p2166127561.jpg',
                trigger: function (res) {
                    // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
                    alert('用户点击发送给朋友');
                },
                success: function (res) {
                    alert('已分享');
                },
                cancel: function (res) {
                    alert('已取消');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
            alert('已注册获取“发送给朋友”状态事件');
        };

        // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
        document.querySelector('#onMenuShareTimeline').onclick = function () {
            wx.onMenuShareTimeline({
                title: '<a mcolored="true" href="http://www.it165.net/news/nhlw/" target="_blank" class="keylink">互联网</a>之子',
                link: 'http://movie.douban.com/subject/25785114/',
                imgUrl: 'http://demo.open.weixin.<a mcolored="true" href="http://www.it165.net/qq/" target="_blank" class="keylink">qq</a>.com/jssdk/images/p2166127561.jpg',
                trigger: function (res) {
                    // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
                    alert('用户点击分享到朋友圈');
                },
                success: function (res) {
                    alert('已分享');
                },
                cancel: function (res) {
                    alert('已取消');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
            alert('已注册获取“分享到朋友圈”状态事件');
        };

        // 2.3 监听“分享到QQ”按钮点击、自定义分享内容及分享结果接口
        document.querySelector('#onMenuShareQQ').onclick = function () {
            wx.onMenuShareQQ({
                title: '互联网之子',
                desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
                link: 'http://movie.douban.com/subject/25785114/',
                imgUrl: 'http://img3.douban.com/view/movie_poster_cover/spst/public/p2166127561.jpg',
                trigger: function (res) {
                    alert('用户点击分享到QQ');
                },
                complete: function (res) {
                    alert(JSON.stringify(res));
                },
                success: function (res) {
                    alert('已分享');
                },
                cancel: function (res) {
                    alert('已取消');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
            alert('已注册获取“分享到 QQ”状态事件');
        };

        // 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
        document.querySelector('#onMenuShareWeibo').onclick = function () {
            wx.onMenuShareWeibo({
                title: '互联网之子',
                desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
                link: 'http://movie.douban.com/subject/25785114/',
                imgUrl: 'http://img3.douban.com/view/movie_poster_cover/spst/public/p2166127561.jpg',
                trigger: function (res) {
                    alert('用户点击分享到微博');
                },
                complete: function (res) {
                    alert(JSON.stringify(res));
                },
                success: function (res) {
                    alert('已分享');
                },
                cancel: function (res) {
                    alert('已取消');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
            alert('已注册获取“分享到微博”状态事件');
        };


        // 3 智能接口
        var voice = {
            localId: '',
            serverId: ''
        };
        // 3.1 识别音频并返回识别结果
        document.querySelector('#translateVoice').onclick = function () {
            if (voice.localId == '') {
                alert('请先使用 startRecord 接口录制一段声音');
                return;
            }
            wx.translateVoice({
                localId: voice.localId,
                complete: function (res) {
                    if (res.hasOwnProperty('translateResult')) {
                        alert('识别结果：' + res.translateResult);
                    } else {
                        alert('无法识别');
                    }
                }
            });
        };

        // 4 音频接口
        // 4.2 开始录音
        document.querySelector('#startRecord').onclick = function () {
            wx.startRecord({
                cancel: function () {
                    alert('用户拒绝授权录音');
                }
            });
        };

        // 4.3 停止录音
        document.querySelector('#stopRecord').onclick = function () {
            wx.stopRecord({
                success: function (res) {
                    voice.localId = res.localId;
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        };

        // 4.4 监听录音自动停止
        wx.onVoiceRecordEnd({
            complete: function (res) {
                voice.localId = res.localId;
                alert('录音时间已超过一分钟');
            }
        });

        // 4.5 播放音频
        document.querySelector('#playVoice').onclick = function () {
            if (voice.localId == '') {
                alert('请先使用 startRecord 接口录制一段声音');
                return;
            }
            wx.playVoice({
                localId: voice.localId
            });
        };

        // 4.6 暂停播放音频
        document.querySelector('#pauseVoice').onclick = function () {
            wx.pauseVoice({
                localId: voice.localId
            });
        };

        // 4.7 停止播放音频
        document.querySelector('#stopVoice').onclick = function () {
            wx.stopVoice({
                localId: voice.localId
            });
        };

        // 4.8 监听录音播放停止
        wx.onVoicePlayEnd({
            complete: function (res) {
                alert('录音（' + res.localId + '）播放结束');
            }
        });

        // 4.8 上传语音
        document.querySelector('#uploadVoice').onclick = function () {
            if (voice.localId == '') {
                alert('请先使用 startRecord 接口录制一段声音');
                return;
            }
            wx.uploadVoice({
                localId: voice.localId,
                success: function (res) {
                    alert('上传语音成功，serverId 为' + res.serverId);
                    voice.serverId = res.serverId;
                }
            });
        };

        // 4.9 下载语音
        document.querySelector('#downloadVoice').onclick = function () {
            if (voice.serverId == '') {
                alert('请先使用 uploadVoice 上传声音');
                return;
            }
            wx.downloadVoice({
                serverId: voice.serverId,
                success: function (res) {
                    alert('下载语音成功，localId 为' + res.localId);
                    voice.localId = res.localId;
                }
            });
        };

        // 5 图片接口
        // 5.1 拍照、本地选图
        var images = {
            localId: [],
            serverId: []
        };
        document.querySelector('#chooseImage').onclick = function () {
            wx.chooseImage({
                success: function (res) {
                    images.localId = res.localIds;
                    alert('已选择 ' + res.localIds.length + ' 张图片');
                }
            });
        };

        // 5.2 图片预览
        document.querySelector('#previewImage').onclick = function () {
            wx.previewImage({
                current: 'http://img5.douban.com/view/photo/photo/public/p1353993776.jpg',
                urls: [
                    'http://img3.douban.com/view/photo/photo/public/p2152117150.jpg',
                    'http://img5.douban.com/view/photo/photo/public/p1353993776.jpg',
                    'http://img3.douban.com/view/photo/photo/public/p2152134700.jpg'
                ]
            });
        };

        // 5.3 上传图片
        document.querySelector('#uploadImage').onclick = function () {
            if (images.localId.length == 0) {
                alert('请先使用 chooseImage 接口选择图片');
                return;
            }
            var i = 0, length = images.localId.length;
            images.serverId = [];
            function upload() {
                wx.uploadImage({
                    localId: images.localId[i],
                    success: function (res) {
                        i++;
                        alert('已上传：' + i + '/' + length);
                        images.serverId.push(res.serverId);
                        if (i < length) {
                            upload();
                        }
                    },
                    fail: function (res) {
                        alert(JSON.stringify(res));
                    }
                });
            }
            upload();
        };

        // 5.4 下载图片
        document.querySelector('#downloadImage').onclick = function () {
            if (images.serverId.length === 0) {
                alert('请先使用 uploadImage 上传图片');
                return;
            }
            var i = 0, length = images.serverId.length;
            images.localId = [];
            function download() {
                wx.downloadImage({
                    serverId: images.serverId[i],
                    success: function (res) {
                        i++;
                        alert('已下载：' + i + '/' + length);
                        images.localId.push(res.localId);
                        if (i < length) {
                            download();
                        }
                    }
                });
            }
            download();
        };

        // 6 设备信息接口
        // 6.1 获取当前网络状态
        document.querySelector('#getNetworkType').onclick = function () {
            wx.getNetworkType({
                success: function (res) {
                    alert(res.networkType);
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        };

        // 7 地理位置接口
        // 7.1 查看地理位置
        document.querySelector('#openLocation').onclick = function () {
            wx.openLocation({
                latitude: 23.099994,
                longitude: 113.324520,
                name: 'TIT 创意园',
                address: '广州市海珠区新港中路 397 号',
                scale: 14,
                infoUrl: 'http://weixin.<a mcolored="true" href="http://www.it165.net/qq/" target="_blank" class="keylink">qq</a>.com'
            });
        };

        // 7.2 获取当前地理位置
        document.querySelector('#getLocation').onclick = function () {
            wx.getLocation({
                success: function (res) {
                    alert(JSON.stringify(res));
                },
                cancel: function (res) {
                    alert('用户拒绝授权获取地理位置');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        };

        // 8 界面操作接口
        // 8.1 隐藏右上角菜单
        document.querySelector('#hideOptionMenu').onclick = function () {
            wx.hideOptionMenu();
        };

        // 8.2 显示右上角菜单
        document.querySelector('#showOptionMenu').onclick = function () {
            wx.showOptionMenu();
        };

        // 8.3 批量隐藏菜单项
        document.querySelector('#hideMenuItems').onclick = function () {
            wx.hideMenuItems({
                menuList: [
                    'menuItem:readMode', // 阅读模式
                    'menuItem:share:timeline', // 分享到朋友圈
                    'menuItem:copyUrl' // 复制链接
                ],
                success: function (res) {
                    alert('已隐藏“阅读模式”，“分享到朋友圈”，“复制链接”等按钮');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        };

        // 8.4 批量显示菜单项
        document.querySelector('#showMenuItems').onclick = function () {
            wx.showMenuItems({
                menuList: [
                    'menuItem:readMode', // 阅读模式
                    'menuItem:share:timeline', // 分享到朋友圈
                    'menuItem:copyUrl' // 复制链接
                ],
                success: function (res) {
                    alert('已显示“阅读模式”，“分享到朋友圈”，“复制链接”等按钮');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        };

        // 8.5 隐藏所有非基本菜单项
        document.querySelector('#hideAllNonBaseMenuItem').onclick = function () {
            wx.hideAllNonBaseMenuItem({
                success: function () {
                    alert('已隐藏所有非基本菜单项');
                }
            });
        };

        // 8.6 显示所有被隐藏的非基本菜单项
        document.querySelector('#showAllNonBaseMenuItem').onclick = function () {
            wx.showAllNonBaseMenuItem({
                success: function () {
                    alert('已显示所有非基本菜单项');
                }
            });
        };

        // 8.7 关闭当前窗口
        document.querySelector('#closeWindow').onclick = function () {
            wx.closeWindow();
        };

        // 9 微信原生接口
        // 9.1.1 扫描二维码并返回结果
        document.querySelector('#scanQRCode0').onclick = function () {
            wx.scanQRCode();
        };
        // 9.1.2 扫描二维码并返回结果
        document.querySelector('#scanQRCode1').onclick = function () {
            wx.scanQRCode({
                needResult: 1,
                desc: 'scanQRCode desc',
                success: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        };

        // 10 微信支付接口
        // 10.1 发起一个支付请求
        document.querySelector('#chooseWXPay').onclick = function () {
            // 注意：此 Demo 使用 2.7 版本支付接口实现，建议使用此接口时参考微信支付相关最新文档。
            wx.chooseWXPay({
                timestamp: 1414723227,
                nonceStr: 'noncestr',
                package: 'addition=action_id%3dgaby1234%26limit_pay%3d&bank_type=WX&body=innertest&fee_type=1&input_charset=GBK¬ify_url=http%3A%2F%2F120.204.206.246%2Fcgi-bin%2Fmmsupport-bin%2Fnotifypay&out_trade_no=1414723227818375338&partner=1900000109&spbill_create_ip=127.0.0.1&total_fee=1&sign=432B647FE95C7BF73BCD177CEECBEF8D',
                signType: 'SHA1', // 注意：新版支付接口使用 MD5 加密
                paySign: 'bd5b1933cda6e9548862944836a9b52e8c9a2b69'
            });
        };

        // 11.3  跳转微信商品页
        document.querySelector('#openProductSpecificView').onclick = function () {
            wx.openProductSpecificView({
                productId: 'pDF3iY_m2M7EQ5EKKKWd95kAxfNw'
            });
        };

        // 12 微信卡券接口
        // 12.1 添加卡券
        document.querySelector('#addCard').onclick = function () {
            wx.addCard({
                cardList: [
                    {
                        cardId: 'pDF3iY9tv9zCGCj4jTXFOo1DxHdo',
                        cardExt: '{"code": "", "openid": "", "timestamp": "1418301401", "signature":"64e6a7cc85c6e84b726f2d1cbef1b36e9b0f9750"}'
                    },
                    {
                        cardId: 'pDF3iY9tv9zCGCj4jTXFOo1DxHdo',
                        cardExt: '{"code": "", "openid": "", "timestamp": "1418301401", "signature":"64e6a7cc85c6e84b726f2d1cbef1b36e9b0f9750"}'
                    }
                ],
                success: function (res) {
                    alert('已添加卡券：' + JSON.stringify(res.cardList));
                }
            });
        };

        // 12.2 选择卡券
        document.querySelector('#chooseCard').onclick = function () {
            wx.chooseCard({
                cardSign: '97e9c5e58aab3bdf6fd6150e599d7e5806e5cb91',
                timestamp: 1417504553,
                nonceStr: 'k0hGdSXKZEj3Min5',
                success: function (res) {
                    alert('已选择卡券：' + JSON.stringify(res.cardList));
                }
            });
        };

        // 12.3 查看卡券
        document.querySelector('#openCard').onclick = function () {
            alert('您没有该公众号的卡券无法打开卡券。');
            wx.openCard({
                cardList: [
                ]
            });
        };

        var shareData = {
            title: '微信JS-SDK Demo',
            desc: '微信JS-SDK,帮助第三方为用户提供更优质的移动web服务',
            link: 'http://demo.open.weixin.qq.com/jssdk/',
            imgUrl: 'http://mmbiz.qpic.cn/mmbiz/icTdbqWNOwNRt8Qia4lv7k3M9J1SKqKCImxJCt7j9rHYicKDI45jRPBxdzdyREWnk0ia0N5TMnMfth7SdxtzMvVgXg/0'
        };
        wx.onMenuShareAppMessage(shareData);
        wx.onMenuShareTimeline(shareData);
    });

    wx.error(function (res) {
        alert(res.errMsg);
    });
</script>

</html>

