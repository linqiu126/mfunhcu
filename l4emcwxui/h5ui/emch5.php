<?php
/**
 * Created by PhpStorm.
 * User: shanchuz
 * Date: 2015/9/9
 * Time: 15:50
 */
include_once "../../l1comvm/vmlayer.php";
include_once "../../l2sdk/task_l2sdk_iot_wx_jssdk.php";

$jssdk = new classTaskL2sdkIotWxJssdk(MFUN_WX_APPID, MFUN_WX_APPSECRET);
$signPackage = $jssdk->GetSignPackage();

//Start: OAuth2.0认证
$code = $_GET["code"];
$userinfo = getUserInfo($code);

function getUserInfo($code)
{
    //$appid = WX_APPID;
    //$appsecret = WX_APPSECRET;
    
    $appid = "wx32f73ab219f56efb";
    $appsecret = "eca20c2a26a5ec5b64a89d15ba92a781";

    //oauth2的方式获得openid
	$access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
	$access_token_json = https_request($access_token_url);
	$access_token_array = json_decode($access_token_json, true);
	$openid = $access_token_array['openid'];

    //非oauth2的方式获得全局access token
    /*
    $new_access_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
    $new_access_token_json = https_request($new_access_token_url);
	$new_access_token_array = json_decode($new_access_token_json, true);
	$new_access_token = $new_access_token_array['access_token'];
    */
    
    //全局access token获得用户基本信息
    /*
    $userinfo_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$new_access_token&openid=$openid";
	$userinfo_json = https_request($userinfo_url);
	$userinfo_array = json_decode($userinfo_json, true);    
    return $userinfo_array;
    */
    return $openid;
}

function https_request($url)
{
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($curl);
	if (curl_errno($curl)) {return 'ERROR '.curl_error($curl);}
	curl_close($curl);
	return $data;
}
//End: OAuth2.0认证


//Start: EMC push data (H5 -> IHU)

$emc_push_data = emc_data_push_process();

function emc_data_push_process()
{

    $body_ctrl = "20";
    //$body_manufacture = "001800";
    $body_manufacture = "00"; //"0018914E";
    $msg_body = $body_ctrl . $body_manufacture;

    $hex_body = pack('H*',$msg_body);

    $base64Data = base64_encode($hex_body);

    return $base64Data;
}
//End: EMC push data

?>



<!doctype html>
<html lang="en">
    

<head><TITLE>小趣科技</TITLE>

    <meta charset="utf-8">   


    
<!-- 
   
<body bgcolor="#ffffff" onload="newtext()">
<script language=javascript >
var text=document.title
var timerID
function newtext() {
            clearTimeout(timerID)                  
            document.title=text.substring(1,text.length)+text.substring(0,1)
            text=document.title.substring(0,text.length)
            timerID = setTimeout("newtext()", 1000)
}
</script>
</body>  

-->
    
    
<body bgcolor="#ffffff" onload="newtext()">    
<script language=javascript >

var text=document.title;
var timerID;
var state = 1;
function newtext() {
            clearTimeout(timerID);
            if(state == 1)  
            document.title = 'Disconnected';
            if(state == 2)  
            document.title = 'Connecting...'; 
            if(state == 3)  
            document.title = 'Connected';     
            timerID = setTimeout("newtext()", 100);
}
</script>
</body> 

    
    
<!--步骤二：引入JS文件  -->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<!--步骤三：通过config接口注入权限验证配置 -->
<script>
    signData = {
           "verifyAppId" : '<?php echo $signPackage["appId"];?>',
           "verifyTimestamp" : <?php echo $signPackage["timestamp"];?>,  // 签名的时间戳
           "verifySignType" : "sha1",
           "verifyNonceStr" : '<?php echo $signPackage["nonceStr"];?>',  //签名字符串
           "verifySignature" : '<?php echo $signPackage["signature"];?>'
    }; 
    
    
    var emc_push_data = '<?php echo $emc_push_data; ?>';
    var emc_req_data = 0;
    
    var datas = 0;
    var deviceId = 0;
   
    
    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            'checkJsApi',
        'openWXDeviceLib',
        'closeWXDeviceLib',
        'getWXDeviceInfos',
        'getWXDeviceTicket',
        'getWXDeviceBindTicket',
        'getWXDeviceUnbindTicket',
        'setSendDataDirection',
        'startScanWXDevice',
        'stopScanWXDevice',
        'connectWXDevice',
        'disconnectWXDevice',
        'sendDataToWXDevice',
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
        /*
        document.querySelector('#checkJsApi').onclick = function () {
            wx.checkJsApi({
                jsApiList: [
        'openWXDeviceLib',
        'closeWXDeviceLib',
        'getWXDeviceInfos',
        'getWXDeviceTicket',
        'getWXDeviceBindTicket',
        'getWXDeviceUnbindTicket',
        'setSendDataDirection',
        'startScanWXDevice',
        'stopScanWXDevice',
        'connectWXDevice',
        'disconnectWXDevice',
        'sendDataToWXDevice'

                ],
                success: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        }; 
        */
        
        

        alert("ready!");
        console.log("config", "ready");
        WeixinJSBridge.on('onWXDeviceBindStateChange', function(argv) {
            alert('onWXDeviceBindStateChange：' + JSON.stringify(argv));
        });

        WeixinJSBridge.on('onWXDeviceStateChange', function(argv) {
            //alert('onWXDeviceStateChange：' + JSON.stringify(argv));
            
            if (argv.state === 'disconnected')
            {
                datas = 0;
                state = 1;
                
            }
                
            if (argv.state === 'connecting')
            {
                datas = 0;
                state = 2;
                
            }          
            if (argv.state === 'connected')
            {
                datas = 100;
                state = 3;
                
            }
            
            //else
            //alert("No Device Info!!");
            //to show the connect status info in the status bar or html title.
        });
        
        

        WeixinJSBridge.on('onReceiveDataFromWXDevice', function(argv) {
            alert('onReceiveDataFromWXDevice：' + JSON.stringify(argv));
            
            emc_req_data = argv.base64Data;

            $.ajax({
                url: 'EmcDataDecode.php?data=' + emc_req_data,
                type: 'get',
                dataType: "json",
                cache:false,
                //async:false,
                success: function(data) {
                    datas = data;
                }
            });            
            
        });
        
        

        WeixinJSBridge.on('onWXDeviceBluetoothStateChange', function(argv) {
            alert('onWXDeviceBluetoothStateChange：' + JSON.stringify(argv));
        });

        WeixinJSBridge.on('onScanWXDeviceResult', function(argv){
            alert('onScanWXDeviceResult：' + JSON.stringify(argv));
        });        
        
           openWXDeviceLib();
           getWXDeviceInfos();
           connectWXDevice();       

        onConfigReady();     
        
        
    });   
    
    

     /**
     * config 失败
     */
    wx.error(function (res) {
        alert(res.errMsg);
    });
    
    
    
     /**
     * 事件绑定初始化
     */

    var readyFunc = function onConfigReady() {

        
        document.querySelector('#openWXDeviceLib').onclick = function () {
          
            /*
           openWXDeviceLib();
           getWXDeviceInfos();
           connectWXDevice();
            
           
             
           setInterval(function(){
               sendDataToWXDevice(deviceId, emc_push_data);
           },5000);
           */
            
            sendDataToWXDevice(deviceId, emc_push_data);

            
        };         
        
        
       document.querySelector('#getWXDeviceInfos').onclick = function () {
          
           getWXDeviceInfos();
            //disconnectWXDevice();           
        }; 
        
       document.querySelector('#disconnectWXDevice').onclick = function () {
          
           disconnectWXDevice(); 
           //getWXDeviceInfos();

        };        
        
        
       document.querySelector('#connectWXDevice').onclick = function () {
          
           connectWXDevice();           
        }; 
        
       document.querySelector('#sendDataToWXDevice').onclick = function () {
          
           sendDataToWXDevice(); 

        };    
       
       document.querySelector('#closeWXDeviceLib').onclick = function () {
          
           closeWXDeviceLib(); 
        }; 
    }; 

    
   
    
     /**
     * 各个 JSSDK 的 API 接口实现
     */

    function openWXDeviceLib(){
        WeixinJSBridge.invoke('openWXDeviceLib', signData, function(res){
            //console.log("openWXDeviceLib", res);
            //console.log("signData", signData);
            //alert(res);
            alert(JSON.stringify(res));
        });
    }

    function closeWXDeviceLib(){
        //alert("closing!");
        WeixinJSBridge.invoke('closeWXDeviceLib', signData, function(res){
            //console.log("closeWXDeviceLib", res);
            //alert(res);
            //alert("closed!");
            alert(JSON.stringify(res));
        });
    }


    function getWXDeviceInfos(){
        WeixinJSBridge.invoke('getWXDeviceInfos', signData, function(res){
            //console.log("getWXDeviceInfos", res);
            alert(JSON.stringify(res));
            //if (res.err_msg === 'getWXDeviceInfos:ok')
            //alert(res.deviceInfos[0].deviceId);
            //else
            //alert("No Device Info!!");
            deviceId = res.deviceInfos[0].deviceId;
            if(res.deviceInfos[0].state ==='connected'){
                datas = 100;
                state = 3
            }
            else
            {
                datas = 0;
                state = 1;
                
            }

            
        });
    }

    function connectWXDevice(){
        //var _data = {"deviceId":deviceId};
        //var _data = {"deviceId":'gh_9b450bb63282_02414f1001725e2531d65c544d40fefb'};
        var _data = {"deviceId":deviceId};
        WeixinJSBridge.invoke('connectWXDevice', _data, function(res){
            //console.log("connectWXDevice", res);
            alert(JSON.stringify(res));
        });
    }

    function sendDataToWXDevice(deviceId, buf){ 
        
        var _data = {"deviceId":deviceId, "base64Data": buf};
        WeixinJSBridge.invoke('sendDataToWXDevice', _data, function(res){
        //console.log("sendDataToWXDevice", res);
            alert(JSON.stringify(res));            
        });        

 /*       
        var s:
        var buf = Base64.encode(s);
                var buf = "3455";
        
        var _data = mixin({
            "deviceId": deviceId,
            "base64Data": buf
            }, signData);
        WeixinJSBridge.invoke('sendDataToWXDevice', _data, function(res) {
            if (res.err_msg === 'sendDataToWXDevice:fail')
                alert(JSON.stringify(res));
            });
*/            
        //timer here?
    }
    
   
    function disconnectWXDevice(){
        var _data = {"deviceId":deviceId};
        alert("你真的要停止测量吗?");
        WeixinJSBridge.invoke('disconnectWXDevice', _data, function(res){
            //console.log("disconnectWXDevice", res);
            alert(JSON.stringify(res));
            
        });
    }


    function startScanWXDevice(cb){
        var _data = {btVersion:'ble'};
        WeixinJSBridge.invoke('startScanWXDevice', _data, function(res){
            console.log("startScanWXDevice", res);
        });
    }

    function stopScanWXDevice(){
        WeixinJSBridge.invoke('stopScanWXDevice', signData, function(res){
            console.log("stopScanWXDevice", res);
        });
    }

    if (typeof WeixinJSBridge === "undefined") {
        document.addEventListener('WeixinJSBridgeReady', readyFunc, false);
    } else {
        readyFunc();
    }

    
  // 工具集
  /*
  function mixin(dest, src) {
    Object.getOwnPropertyNames(src).forEach(function(name) {
      var descriptor = Object.getOwnPropertyDescriptor(src, name);
      Object.defineProperty(dest, name, descriptor);
    });
    return dest;
  }
  */
    
</script>

    
 
    
    
    
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript" src="jquery.min.js"></script>
    <script type="text/javascript" src="highcharts.js"></script>
    <script type="text/javascript" src="highcharts-more.js"></script>


    <script>
        //Javascript代码

        //取Openid
        
        var id='';
        var url=window.location.search;
        if(url.indexOf("?")!=-1)
        {
            var str   =   url.substr(1);
            strs = str.split("&");
            for(i=0;i<strs.length;i++) {
                if([strs[i].split("=")[0]]=='id')
                    id=unescape(strs[i].split("=")[1]);
            }
        }
        //var wxuser = id;
        var wxuser = '<?php echo $userinfo; ?>'; 
        
        //$userinfo["openid"];
        
        //var wxuser = "oAjc8uJALtEIF_b5cCRhSWXCOG1A";      

        //Ajax 获取数据并解析
        //var wxuser = id;
        //var deviceid = wxuser;
        var datas_1M = [];
        var datas_3M = [];
        var lastdate;

        $.ajax({
            //url: 'getAjaxData.php?wxuser=' + wxuser + '&deviceid='+ deviceid,
            url: 'getAjaxData.php?wxuser=' + wxuser,
            type: 'get',
            dataType: "json",
            cache:false,
            async:false,
            success: function(data) {
                lastdate = data.lastupdatedate;
                datas_1M = data.avg30days;
                datas_3M = data.avg3month;

            }
        });

        var date_1M = getUTC_1M(lastdate);
        var date_3M = getUTC_3M(lastdate);        

        $(function () {
            $('#container3').highcharts({
                chart: {
                    zoomType: 'x',
                    spacingRight: 20
                },
                title: {
                    text: '近三个月辐射值'
                },
                subtitle: {
                    text: document.ontouchstart === undefined ?
                        'Click and drag in the plot area to zoom in' :
                        'Pinch the chart to zoom in'
                },
                xAxis: {
                    type: 'datetime',
                    maxZoom: 14 * 24 * 3600000, // 14 天
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    title: {
                        text: '辐射值（mV）'
                    }
                },
                tooltip: {
                    shared: true
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    area: {
                        fillColor: {
                            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                            stops: [
                                [0, Highcharts.getOptions().colors[6]],
                                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                            ]
                        },
                        lineWidth: 1,
                        marker: {
                            enabled: false
                        },
                        shadow: false,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        threshold: null
                    }
                },

                series: [{
                    type: 'area',
                    name: '辐射值',
                    pointInterval: 24 * 3 * 3600 * 1000,//间隔3天
                    pointStart: date_3M,
                    data: datas_3M
                }]
            });
        });




        $(function () {
            $('#container2').highcharts({
                chart: {
                    zoomType: 'x',
                    spacingRight: 20
                },
                title: {
                    text: '近一个月辐射值'
                },
                subtitle: {
                    text: document.ontouchstart === undefined ?
                        'Click and drag in the plot area to zoom in' :
                        'Pinch the chart to zoom in'
                },
                xAxis: {
                    type: 'datetime',
                    maxZoom: 14 * 24 * 3600000, // 14 天
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    title: {
                        text: '辐射值（mV）'
                    }
                },
                tooltip: {
                    shared: true
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    area: {
                        fillColor: {
                            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                            stops: [
                                [0, Highcharts.getOptions().colors[6]],
                                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                            ]
                        },
                        lineWidth: 1,
                        marker: {
                            enabled: false
                        },
                        shadow: false,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        threshold: null
                    }
                },

                series: [{
                    type: 'area',
                    name: '辐射值',
                    pointInterval: 8 * 3 * 3600 * 1000,//间隔1天
                    pointStart: date_1M,
                    data: datas_1M
                }]
            });
        });




        Highcharts.setOptions({
            credits: {enabled: false}
            // series[0].data = datas
        })

        function getUTC_3M(DateTime){
            var yr = DateTime.substring(0,4);
            var mo = DateTime.substring(5,7);
            var dy = DateTime.substring(8,10);
            var hr = DateTime.substring(11,13);
            var min = DateTime.substring(14,16);
            var sec = DateTime.substring(17,19);
            return Date.UTC(yr,mo-4,dy,hr,min,sec);
        }
        
        function getUTC_1M(DateTime){
            var yr = DateTime.substring(0,4);
            var mo = DateTime.substring(5,7);
            var dy = DateTime.substring(8,10);
            var hr = DateTime.substring(11,13);
            var min = DateTime.substring(14,16);
            var sec = DateTime.substring(17,19);
            return Date.UTC(yr,mo-2,dy,hr,min,sec);
        }        





        //var datas = 0;

        $(function () {

            $('#container1').highcharts({

                    chart: {
                        type: 'gauge',
                        plotBackgroundColor: null,
                        plotBackgroundImage: null,
                        plotBorderWidth: 0,
                        plotShadow: false
                    },

                    title: {
                        text: '辐射测量'
                    },

                    pane: {
                        startAngle: -150,
                        endAngle: 150,
                        background: [{
                            backgroundColor: {
                                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                stops: [
                                    [0, '#FFF'],
                                    [1, '#333']
                                ]
                            },
                            borderWidth: 0,
                            outerRadius: '109%'
                        }, {
                            backgroundColor: {
                                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                stops: [
                                    [0, '#333'],
                                    [1, '#FFF']
                                ]
                            },
                            borderWidth: 1,
                            outerRadius: '107%'
                        }, {
                            // default background
                        }, {
                            backgroundColor: '#DDD',
                            borderWidth: 0,
                            outerRadius: '105%',
                            innerRadius: '103%'
                        }]
                    },

                    // the value axis
                    yAxis: {
                        min: 0,
                        max: 400,

                        minorTickInterval: 'auto',
                        minorTickWidth: 1,
                        minorTickLength: 10,
                        minorTickPosition: 'inside',
                        minorTickColor: '#666',

                        tickPixelInterval: 30,
                        tickWidth: 2,
                        tickPosition: 'inside',
                        tickLength: 10,
                        tickColor: '#666',
                        labels: {
                            step: 2,
                            rotation: 'auto'
                        },
                        title: {
                            text: 'mV'
                        },
                        plotBands: [{
                            from: 0,
                            to: 80,
                            color: '#55BF3B' // green
                        }, {
                            from: 80,
                            to: 200,
                            color: '#DDDF0D' // yellow
                        }, {
                            from: 200,
                            to: 400,
                            color: '#DF5353' // red
                        }]
                    },

                    series: [{
                        name: '辐射值',
                        data: [0],
                        tooltip: {
                            valueSuffix: ' mV'
                        }
                    }]

                },

                // Add some life
                function (chart) {
                    if (!chart.renderer.forExport) {

                        setInterval(function () {
                            var point = chart.series[0].points[0],
                                newVal;
/*
                            $.ajax({
                                url: 'getAjaxDataInstant.php?wxuser=' + wxuser,
                                type: 'get',
                                dataType: "json",
                                cache:false,
                                //async:false,
                                success: function(data) {
                                    datas = data;
                                }
                            });
*/

                            newVal = datas;
                            /*
                             if (newVal < 0 || newVal > 400) {
                             //newVal = point.y - inc;
                             newVal = point.y - datas;
                             }
                             */
                            if (newVal < 0) {
                                //newVal = point.y - inc;
                                newVal = 0;
                            }

                            if (newVal > 400) {
                                //newVal = point.y - inc;
                                newVal = 400;
                            }
                            
                            point.update(newVal);

                        }, 100);

                        //停止刷新

                    }
                });
        });

    </script>     



    
<!--
    
<body> 

                <div class="state">
                  <span>状态:</span>
                  <span>{{state == 3 ? '已连接' : (state == 1 ? '未连接' : '连接中..')}}</span>
                </div>  
                  

</body>  
-->    

    
<body> <div id="container1" style="min-width:900px;height:700px"></div>
</body>
<body> <div id="container2" style="min-width:900px;height:300px"></div>
</body>
<body> <div id="container3" style="min-width:900px;height:300px"></div>
</body>
    
<body>    
        <h1>======================================================</h1> 
</body>  



<body>
<div class="wxapi_container">

    <div class="lbox_close wxapi_form">

<!--        
        <h1 id="menu-basic">基础接口测试</h1>
        判断当前微信是否支持指定JSAPI接口
        <button class="btn btn_primary" id="checkJsApi">checkJsApi</button>      
-->      
        

 
        <button style="width:315px;height:110px;background:grey;color:black;font-size:40px;font-weight:bold;" class="btn btn_primary" id="openWXDeviceLib">开始测量</button>
        <button style="width:315px;height:110px;background:grey;color:black;font-size:40px;font-weight:bold;" class="btn btn_primary" id="disconnectWXDevice">停止测量</button>
        <button style="width:315px;height:110px;background:grey;color:black;font-size:40px;font-weight:bold;" class="btn btn_primary" id="getWXDeviceInfos">设备状态</button>
<!--
        <button style="width:315px;height:110px;background:green;color:black;font-size:40px;font-weight:bold;" class="btn btn_primary" id="checkJsApi">checkJsApi</button>

 
        <button class="btn btn_primary" id="connectWXDevice">connectWXDevice</button>  
        <button class="btn btn_primary" id="sendDataToWXDevice">sendDataToWXDevice</button>  
        <button class="btn btn_primary" id="closeWXDeviceLib">closeWXDeviceLib</button> 
-->


        <h1>======================================================</h1>  

    </div> 


    
    
</div>
</body>
        
</head>      

</html>




    
    
