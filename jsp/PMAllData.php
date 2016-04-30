<?php
/**
 * Created by PhpStorm.
 * User: shanchuz
 * Date: 2015/9/9
 * Time: 15:50
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

        //Ajax 获取数据并解析
        var wxuser = id;
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
            $('#container2').highcharts({
                chart: {
                    zoomType: 'x',
                    spacingRight: 20
                },
                title: {
                    text: '近三个月PM2.5累积值'
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
                        text: 'PM2.5（μg/m3）'
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
                    name: 'PM2.5值',
                    pointInterval: 24 * 3 * 3600 * 1000,//间隔3天
                    pointStart: date_3M,
                    data: datas_3M
                }]
            });
        });




        $(function () {
            $('#container1').highcharts({
                chart: {
                    zoomType: 'x',
                    spacingRight: 20
                },
                title: {
                    text: '近一个月PM2.5累积值'
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
                        text: 'PM2.5（μg/m3）'
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
                    name: 'PM2.5值',
                    pointInterval: 8 * 3 * 3600 * 1000,//间隔1天
                    pointStart: date_1M,
                    data: datas_1M
                }]
            });
        });




        $(function () {
            $('#container3').highcharts({
                chart: {
                    zoomType: 'x',
                    spacingRight: 20
                },
                title: {
                    text: '近一年PM2.5累积值'
                },
                subtitle: {
                    text: document.ontouchstart === undefined ?
                        'Click and drag in the plot area to zoom in' :
                        'Pinch the chart to zoom in'
                },
                xAxis: {
                    type: 'datetime',
                    maxZoom: 30 * 24 * 3600000, // 30 天
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    title: {
                        text: 'PM2.5（μg/m3）'
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
                    name: 'PM2.5值',
                    pointInterval: 24 * 12 * 3600 * 1000,//间隔12天
                    pointStart: date,
                    data: datas_3M
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


    </script>

</head>
<body> <div id="container1" style="min-width:700px;height:400px"></div>
</body>

<body> <div id="container2" style="min-width:700px;height:400px"></div>
</body>

<!--
<body> <div id="container3" style="min-width:700px;height:400px"></div>
</body>
-->


</html>