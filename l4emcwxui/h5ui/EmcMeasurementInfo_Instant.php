<?php
/**
 * Created by PhpStorm.
 * User: shanchuz
 * Date: 2015/9/10
 * Time: 11:12
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
        var datas;

        $(function () {

            $('#container').highcharts({

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
                                     async:false,
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

                        }, 900);

                        //停止刷新

                    }
                });
        });
        
        
        

        $("button").click(function() {

            clearInterval(timer);

        });


        Highcharts.setOptions({
            credits: {enabled: false}
        })

    </script>


</head>
<body> <div id="container" style="min-width:100px;height:400px"></div>
</body>


</html>