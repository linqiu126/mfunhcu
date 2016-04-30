<?php
/*
本文件位置
$redirect_url= "http://israel.duapp.com/weixin/oauth2_openid.php";

URL
https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx6292681b13329528&redirect_uri=http://israel.duapp.com/weixin/oauth2_openid.php&response_type=code&scope=snsapi_base&state=1#wechat_redirect
*/

/*
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
    $new_access_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
    $new_access_token_json = https_request($new_access_token_url);
	$new_access_token_array = json_decode($new_access_token_json, true);
	$new_access_token = $new_access_token_array['access_token'];
    
    //全局access token获得用户基本信息
    $userinfo_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$new_access_token&openid=$openid";
	$userinfo_json = https_request($userinfo_url);
	$userinfo_array = json_decode($userinfo_json, true);
	return $userinfo_array;
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
*/
?>





<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">

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
        var wxuser = id;
        
      

        //    echo $userinfo["openid"];
/*            include_once "../config/config.php";

            $code = $_GET[code];
            $OpenId = getOpenId($code);
            echo $OpenId;

            function getOpenId($code)
            {
                //$appid = WX_APPID;
                //$appsecret = WX_APPSECRET;
                
                $appid = "wx32f73ab219f56efb";
	            $appsecret = "eca20c2a26a5ec5b64a89d15ba92a781";
                $access_token = "";
                //Get Access Token and OpenId by code
                $access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
                $access_token_json = https_request($access_token_url);
                $access_token_array = json_decode($access_token_json,true);
                $access_token = $access_token_array['access_token'];          
                
                $openid = $access_token_array['openid'];
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
*/
              
        //           ?>;

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


        var datas;

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
                        text: '辐射测量进行中'
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
</head>
<body> <div id="container1" style="min-width:700px;height:400px"></div>
</body>
-->
    
<body> <div id="container2" style="min-width:700px;height:400px"></div>
</body>

<body> <div id="container3" style="min-width:700px;height:400px"></div>
</body>


</html>