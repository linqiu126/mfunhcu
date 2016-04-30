<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2016/1/11
 * Time: 13:56
 */

header("Content-type:text/html;charset=utf-8");
echo "<H1>WELCOME! 上海小慧智能科技欢迎您！<br><br>";
echo "<H2>扬尘项目HCU操作维护工具<br>";
?>


<!DOCTYPE HTML>
<html>
<head>

    <script type="text/javascript" src="../jsp/jquery.min.js"></script>
    <script type="text/javascript">
        
        //暂时没有使用，输入框有输入是对应提示框txtHint显示对应的提示信息
        function showHint(str)
        {
            var xmlhttp;
            if (str.length==0)
            {
                document.getElementById("txtHint").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","gethint.php?q="+str,true);
            xmlhttp.send();
        }

        //视频打开按钮点击弹出窗口显示该设备当前监控视频
        function btn_onclick() 
        {
            var index = document.getElementById("sel_devicelist").selectedIndex;
            var deviceid = document.getElementById("sel_devicelist").options[index].text ;

            var todo = "HCU_URL_INQUIRY";
            var address = "";
            $.ajax({
                url: "hcu_getajaxdata.php?deviceid=" + deviceid + "&opt_type=" + todo,
                type: "get",
                dataType: "json",
                cache:false,
                async:false,
                success: function(data) {
                    address = data;
                }
            });

            if (address != "") {
                window.open(address,'','width=720,height=500,resizable=yes,scrollbars=yes,status=no');
            }

        }

        //检测设备被选中时，把下拉框的text传递给select_content,这样在提交按钮单击时$_POST给hcu_ctrl.process.php
        function deviceid_onselect()
        {
            var index = document.getElementById("sel_deviceid").selectedIndex;
            if (index !=0)  //防止下拉框第一项提示信息被当作deviceid传递过去
            {
                var deviceid = document.getElementById("sel_deviceid").options[index].text ;
                document.getElementById("select_content").value = deviceid;
            }
            else{
                document.getElementById("select_content").value = "";
            }
        }

        //视频处理菜单，选择不同的HCU设备，对应该设备的历史video相应更新
        function devicelist_onchange()
        {
            var videolist = [];
            var maxindex;
            var index = document.getElementById("sel_devicelist").selectedIndex;
            var deviceid = document.getElementById("sel_devicelist").options[index].text ;
            var todo = "HCU_VIDEO_INQUIRY";

            $.ajax({
                url: "hcu_getajaxdata.php?deviceid=" + deviceid + "&opt_type=" + todo,
                type: "get",
                dataType: "json",
                cache:false,
                async:false,
                success: function(data) {
                    videolist = data;
                }
            });

            var obj=document.getElementById('sel_historyvideo');
            maxindex = obj.options.length; //清除界面上次存储的历史记录
            for(var i=1;i<maxindex;i++) {
                obj.remove(1);
            }

            for(var i=0;i<videolist.length;i++)  //查询的新记录追加到下拉框中
            {
                var date = videolist[i].reportdate;
                var url = videolist[i].videourl;
                //$("#sel_historyvideo").append("<option value='"+(i+1)+"'>"+url+"</option>");
                $("#sel_historyvideo").append("<option value='"+(i+1)+"'>"+date+"  "+url+"</option>");
            }
        }

        //历史视频link点击打开
        function url_onchange()  
        {
            var index;
            var obj=document.getElementById('sel_historyvideo');
            var url = obj.options[obj.selectedIndex].text;

            var startIndex = url.lastIndexOf("http");
            var link = url.substring(startIndex);  //去除link前面的日期生成有效http link

            index = obj.options[obj.selectedIndex].index;
            if (index !=0)
                window.open(link,'','width=720,height=500,resizable=yes,scrollbars=yes,status=no');
        }

        //EMC radion button onclick
        function switchon_onclick() {
            var obj;

            obj = document.getElementById('set_switch');
            obj.checked = true;
        }

        function switchon_onoff() {
            var obj;

            obj = document.getElementById('set_switch');
            obj.checked = true;
        }

        //EMC radion button onclick
        function emc_onclick()
        {
            var obj;

            obj=document.getElementById('set_period');
            obj.disabled=true;
            obj=document.getElementById('text_period');
            obj.disabled=true;

            obj=document.getElementById('set_samples');
            obj.disabled=true;
            obj=document.getElementById('text_samples');
            obj.disabled=true;

            obj=document.getElementById('set_times');
            obj.disabled=true;
            obj=document.getElementById('text_times');
            obj.disabled=true;
        }

        //PMdata radion button onclick
        function pmdata_onclick()
        {
            var obj;

            obj=document.getElementById('set_period');
            obj.disabled=false;
            obj=document.getElementById('text_period');
            obj.disabled=false;

            obj=document.getElementById('set_samples');
            obj.disabled=false;
            obj=document.getElementById('text_samples');
            obj.disabled=false;

            obj=document.getElementById('set_times');
            obj.disabled=false;
            obj=document.getElementById('text_times');
            obj.disabled=false;
        }

        //HTML页面加载时查询所有HCU设备并导入设备下拉菜单
        function html_load()  
        {
            var todo = "HCU_DEVICE_INQUIRY";
            var deviceid = "";
            var deviceList = "";
            $.ajax({
                url: "hcu_getajaxdata.php?deviceid=" + deviceid + "&opt_type=" + todo,
                type: "get",
                dataType: "json",
                cache:false,
                async:false,
                success: function(data) {
                    deviceList = data;
                }
            });
            for(var i=0; i<deviceList.length; i++)  //查询的新记录追加到HCU设备下拉框中
            {
                var device = deviceList[i].devcode;
                $("#sel_devicelist").append("<option value='"+(i+1)+"'>" +device+ "</option>");
                $("#sel_deviceid").append("<option value='"+(i+1)+"'>" +device+ "</option>");
            }
        }

    </script>
</head>


<body onload = "html_load()">
<H3>HCU设置菜单
    <ul>
        <H6><form action="hcu_ctrl.process.php" method="post" >
        请选择要操作的设备编号：
        <select name="sel_deviceid" id="sel_deviceid" onchange="deviceid_onselect()">
            <option value="0">监测设备列表...</option>
        </select><br><br>
        <input type="hidden" id="select_content" name="select_content" />

        传感器类型：<br>
        <input type="radio" name="sensor_type" value="temperature" />温度
        <input type="radio" name="sensor_type" value="humidity" />湿度
        <input type="radio" name="sensor_type" value="windspeed" />风速
        <input type="radio" name="sensor_type" value="winddirection" />风向
        <input type="radio" name="sensor_type" value="pmdata" onclick="pmdata_onclick()"/>颗粒物
        <input type="radio" name="sensor_type" value="noise" />噪声
        <input type="radio" name="sensor_type" value="emc" onclick="emc_onclick()"/>电磁辐射
        <input type="radio" name="sensor_type" value="airpressure" />气压
        <input type="radio" name="sensor_type" value="rain" />降雨量<br /><br>

        操作类型：<br>
         -------------------------设置操作-----------------------------<br>
        <input type="radio" name="opt_type" id = "set_switch"value="set_switch" /> 设置测量开关：
                                    <input type="radio" name="set_onoff" id = "set_switchon" onclick = "switchon_onclick()" value="on" />启动
                                    <input type="radio" name="set_onoff" id = "set_switchoff" onclick = "switchoff_onclick()" value="off" />停止<br />
        <input type="radio" name="opt_type" value="set_addr" /> 设置MODBUS设备地址(1Byte)： <input type="text" name="modbus_addr" id="text_addr"/><br />
        <input type="radio" name="opt_type" id = "set_period" value="set_period" /> 设置测量周期(2Byte)： <input type="text" name="period" id="text_period"/>秒<br />
        <input type="radio" name="opt_type" id = "set_samples" value="set_samples" /> 设置采样间隔(2Byte)： <input type="text" name="samples" id="text_samples"/>秒<br />
        <input type="radio" name="opt_type" id = "set_times" value="set_times" /> 设置测量次数(2Byte)： <input type="text" name="times" id="text_times"/>次<br />
        --------------------------读取操作-----------------------------<br>
        <input type="radio" name="opt_type" value="read_switch" /> 读取测量开关状态<br />
        <input type="radio" name="opt_type" value="read_addr" /> 读取MODBUS地址<br />
        <input type="radio" name="opt_type" value="read_period" /> 读取测量测量周期<br />
        <input type="radio" name="opt_type" value="read_samples" /> 读取测量采样间隔<br />
        <input type="radio" name="opt_type" value="read_times" /> 读取测量次数<br /><br><br>


        <input type="reset" name="b_reset" value="重置">
        <input type="submit" name="mySubmit" value="提交" ><br />
        </form></H6>
    </ul>

<H3>视频操作
    <ul>
        <from name = 'video' action = '' method = 'post'>
            <select name="sel_devicelist" id="sel_devicelist" onchange="devicelist_onchange()">
                <option value="0">请选择要查看的设备...</option>
            </select>
        </from>

        <input type="button" name="Sub" value="打开视频" class="btn" onclick="btn_onclick()" /><br />

        <select name="sel_historyvideo" id="sel_historyvideo" onchange="url_onchange()">
            <option value="0">该设备历史视频...</option>
        </select>

    </ul>
</body>

</html>
