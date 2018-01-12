<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 23:00
 */
header("Content-type:text/html;charset=utf-8");
//include_once "../../l1comvm/vmlayer.php";

/*

//告警数据的存储
//如果涉及到区分，则需要通过具体的dbi函数来完成
//DBI函数仅仅是样例

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f5fm_aqyc_alarmdata`
--

CREATE TABLE IF NOT EXISTS `t_l3f5fm_aqyc_alarmdata` (
  `sid` int(4) NOT NULL,
  `devcode` varchar(20) NOT NULL,
  `equipmentid` int(4) NOT NULL,
  `alarmtype` int(4) DEFAULT NULL,
  `alarmdesc` int(4) DEFAULT NULL,
  `alarmseverity` int(4) DEFAULT '0',
  `alarmclearflag` int(4) NOT NULL,
  `timestamp` datetime NOT NULL,
  `picturename` varchar(100) DEFAULT NULL,
  `causeid` int(4) DEFAULT NULL,
  `alarmcontent` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l3f5fm_aqyc_alarmdata`
--
ALTER TABLE `t_l3f5fm_aqyc_alarmdata`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l3f5fm_aqyc_alarmdata`
--
ALTER TABLE `t_l3f5fm_aqyc_alarmdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f5fm_fhys_alarmdata`
--

CREATE TABLE IF NOT EXISTS `t_l3f5fm_fhys_alarmdata` (
  `sid` int(4) NOT NULL,
  `devcode` varchar(20) NOT NULL,
  `statcode` varchar(20) NOT NULL,
  `alarmflag` char(1) NOT NULL DEFAULT 'N',
  `alarmseverity` char(1) DEFAULT '0',
  `alarmcode` int(2) NOT NULL,
  `tsgen` datetime NOT NULL,
  `tsclose` datetime DEFAULT NULL,
  `alarmproc` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l3f5fm_fhys_alarmdata`
--
ALTER TABLE `t_l3f5fm_fhys_alarmdata`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l3f5fm_fhys_alarmdata`
--
ALTER TABLE `t_l3f5fm_fhys_alarmdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
*/


class classDbiL3apF5fm
{
    //查询用户授权的stat_code和proj_code list
    private function dbi_user_statproj_inqury($mysqli, $uid)
    {
        //查询该用户授权的项目和项目组列表
        $query_str = "SELECT `auth_code` FROM `t_l3f1sym_authlist` WHERE `uid` = '$uid'";
        $result = $mysqli->query($query_str);
        $p_list = array();
        $pg_list = array();
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $temp = $row["auth_code"];
            $fromat = substr($temp, 0, MFUN_L3APL_F2CM_CODE_FORMAT_LEN);
            if($fromat == MFUN_L3APL_F2CM_PROJ_CODE_PREFIX)
                array_push($p_list,$temp);
            elseif ($fromat == MFUN_L3APL_F2CM_PG_CODE_PREFIX)
                array_push($pg_list,$temp);
        }

        //把授权的项目组列表里对应的项目号也取出来追加到项目列表，获得该用户授权的完整项目列表
        for($i=0; $i<count($pg_list); $i++){
            $query_str = "SELECT `p_code` FROM `t_l3f2cm_projinfo` WHERE `pg_code` = '$pg_list[$i]'";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($row = $result->fetch_array()) > 0))
            {
                $temp = $row["p_code"];
                array_push($p_list,$temp);
            }
        }
        //查询授权项目号下对应的所有监测点code
        $auth_list= array();
        for($i=0; $i<count($p_list); $i++){
            $query_str = "SELECT `statcode` FROM `t_l3f3dm_siteinfo` WHERE `p_code` = '$p_list[$i]'";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($row = $result->fetch_array()) > 0)){
                $temp = array("stat_code"=>$row["statcode"],"p_code"=>$p_list[$i]);
                array_push($auth_list ,$temp);
            }
        }
        //删除列表里重复的项
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $unique_authlist = $dbiL1vmCommonObj->unique_array($auth_list,false,true);

        return $unique_authlist;
    }

    //查询该站点是否正处于告警状态
    private function dbi_site_alarm_check($mysqli, $statCode)
    {
        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE `statcode` = '$statCode'");
        if ($result->num_rows>0){
            $row = $result->fetch_array();
            $pm25 = $row['pm25']/1;
            $windspeed = $row['windspeed']/1;
            $noise = $row['noise']/1;
            $temperature = $row['temperature']/1;
            $humidity = $row['humidity']/1;
        }
        else{
            $pm25 = 0;
            $windspeed = 0;
            $noise = 0;
            $temperature = 0;
            $humidity = 0;
        }

        //PM2.5，噪声或温度任意一个超标，这显示该站点告警
        if(($pm25>MFUN_L3APL_F3DM_TH_ALARM_PM25) OR ($noise>MFUN_L3APL_F3DM_TH_ALARM_NOISE) OR ($temperature>MFUN_L3APL_F3DM_TH_ALARM_TEMP))
            $resp = true;
        else
            $resp = false;

        return $resp;
    }


    //获取该用户授权站点中当前存在告警站点的地图显示信息
    public function dbi_map_alarm_sitetinfo_req($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //获取授权站点-项目列表
        $auth_list = $this->dbi_user_statproj_inqury($mysqli, $uid);

        $sitelist = array();
        for($i=0; $i<count($auth_list); $i++)
        {
            $statCode = $auth_list[$i]['stat_code'];

            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statCode'";      //查询监测点对应的项目号
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0) {
                $alarm_check = $this->dbi_site_alarm_check($mysqli, $statCode);
                if ($alarm_check){
                    $info = $resp->fetch_array();

                    $latitude = ($info['latitude'])/1000000;  //百度地图经纬度转换
                    $longitude =  ($info['longitude'])/1000000;

                    $temp = array(
                        'StatCode' => $info['statcode'],
                        'StatName' => $info['statname'],
                        'ChargeMan' => $info['chargeman'],
                        'Telephone' => $info['telephone'],
                        'Department' => $info['department'],
                        'Address' => $info['address'],
                        'Country' => $info['country'],
                        'Street' => $info['street'],
                        'Square' => $info['square'],
                        'Flag_la' => $info['flag_la'],
                        'Latitude' => $latitude,
                        'Flag_lo' =>  $info['flag_lo'],
                        'Longitude' => $longitude,
                        'ProStartTime' => $info['starttime'],
                        'Stage' => $info['memo'],
                    );
                    array_push($sitelist, $temp);
                }
            }
        }

        $mysqli->close();
        return $sitelist;
    }


    //UI AlarmType request, 获取所有需要生成告警数据表的传感器类型信息
    public function dbi_all_alarmtype_req($type)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l2snr_sensortype` WHERE 1";
        $result = $mysqli->query($query_str);

        $alarm_type = array();
        while(($result != false) && (($row = $result->fetch_array()) > 0))
        {
            $type_check = $row['typeid'];
            $tye_prefix =  substr($type_check, 0, MFUN_L3APL_F3DM_SENSOR_TYPE_PREFIX_LEN);
            if ($tye_prefix == $type) {
                $temp = array('id' => $row['typeid'],'name' => $row['name']);
                array_push($alarm_type, $temp);
            }
        }

        $mysqli->close();
        return $alarm_type;
    }

    //GetWarningHandleListTable
    public function dbi_aqyc_alarm_history_table_req($projCode,$duration,$keyWord)
    {
        //初始化返回值
        $alarm_list["column"] = array();
        $alarm_list['data'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        array_push($alarm_list["column"], "序号");
        array_push($alarm_list["column"], "处理状态");
        array_push($alarm_list["column"], "站点编号");
        array_push($alarm_list["column"], "设备编号");
        array_push($alarm_list["column"], "站点名称");
        array_push($alarm_list["column"], "地址");
        array_push($alarm_list["column"], "负责人");
        array_push($alarm_list["column"], "联系电话");
        array_push($alarm_list["column"], "告警级别");
        array_push($alarm_list["column"], "告警内容");
        array_push($alarm_list["column"], "告警产生时间");
        array_push($alarm_list["column"], "告警关闭时间");
        array_push($alarm_list["column"], "告警处理");

        $objAqycAlarm = new classConstAqycEngpar();
        $timestamp = time();
        $end = intval(date("Ymd", $timestamp));
        $start = $end;
        if($duration == MFUN_L3APL_F2CM_EVENT_DURATION_DAY)
            $start = intval(date("Ymd",strtotime('-1 day')));
        elseif($duration == MFUN_L3APL_F2CM_EVENT_DURATION_WEEK)
            $start = intval(date("Ymd",strtotime('-7 day')));
        elseif($duration == MFUN_L3APL_F2CM_EVENT_DURATION_MONTH)
            $start = intval(date("Ymd",strtotime('-30 day')));

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `p_code` = '$projCode'";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $statCode = $row['statcode'];
            $statName = $row["statname"];
            $address = $row["address"];
            $chargeMan = $row["chargeman"];
            $telephone = $row["telephone"];

            $alarmFlag = MFUN_HCU_ALARM_PROC_FLAG_C;
            $query_str = "SELECT * FROM `t_l3f5fm_aqyc_alarmdata` WHERE (`statcode` = '$statCode' AND `alarmflag` != '$alarmFlag' AND (concat(`tsgen`,`alarmproc`) like '%$keyWord%'))";
            $resp = $mysqli->query($query_str);
            while (($resp != false) && (($resp_row = $resp->fetch_array()) > 0)) {
                $sid = $resp_row["sid"];
                $devCode = $resp_row["devcode"];
                $alarmflag = $resp_row["alarmflag"];
                $alarmSeverity =  $resp_row["alarmseverity"];
                $alarmContent = $resp_row["alarmcontent"];
                $tsGen = $resp_row["tsgen"];
                $tsClose = $resp_row["tsclose"];
                //$alarmPic = $resp_row["alarmpic"];
                $alarmProc = $resp_row["alarmproc"];

                $dateintval = intval(date('Ymd',strtotime($tsGen)));
                if($dateintval < $start OR $dateintval > $end)  continue; //如果不在查询时间范围内，直接跳过

                if ($alarmSeverity == HUITP_IEID_UNI_ALARM_SEVERITY_HIGH)
                    $alarmSeverity = "高";
                elseif ($alarmSeverity == HUITP_IEID_UNI_ALARM_SEVERITY_MEDIUM)
                    $alarmSeverity = "中";
                elseif ($alarmSeverity == HUITP_IEID_UNI_ALARM_SEVERITY_MINOR)
                    $alarmSeverity = "低";
                else
                    $alarmSeverity = "无";

                $alarmDesc = $objAqycAlarm->mfun_hcu_aqyc_getAlarmDescription($alarmContent);

                $one_row = array();
                array_push($one_row, $sid);
                array_push($one_row, $alarmflag);
                array_push($one_row, $statCode);
                array_push($one_row, $devCode);
                array_push($one_row, $statName);
                array_push($one_row, $address);
                array_push($one_row, $chargeMan);
                array_push($one_row, $telephone);
                array_push($one_row, $alarmSeverity);
                array_push($one_row, $alarmDesc);
                array_push($one_row, $tsGen);
                array_push($one_row, $tsClose);
                array_push($one_row, $alarmProc);

                array_push($alarm_list['data'], $one_row);
            }
        }
        $mysqli->close();
        return $alarm_list;
    }

    public function dbi_aqyc_alarm_img_req($sid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $query_str = "SELECT * FROM `t_l3f5fm_aqyc_alarmdata` WHERE `sid` = '$sid' ";
        $result = $mysqli->query($query_str);

        $pic_result = array();
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $file_name = $row['alarmpic'];
            $statCode = $row['statcode'];
            if(!empty($file_name)){
                $file_url = MFUN_HCU_SITE_PIC_WWW_PATH.$statCode.'/'.$file_name;
                $pic_result = array('ifpicture' => 'true', 'picture' => $file_url);
            }
            else
                $pic_result = array('ifpicture' => 'false', 'picture' => '');
        }
        $mysqli->close();
        return $pic_result;
    }

    public function dbi_aqyc_alarm_handle_process($uid, $statCode,$mobile,$action)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $timestamp = time();
        $alarmproc = "";

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statCode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows) > 0) {
            $row = $result->fetch_array();
            $projcode = $row['p_code'];
            $statname = $row["statname"];
            $chargeman = $row["chargeman"];
            $telephone = $row["telephone"];
            //LEXIN短信平台
            //$url = MFUN_HCU_FHYS_LEXIN_URL.MFUN_HCU_FHYS_LEXIN_ACCNAME."&".MFUN_HCU_FHYS_LEXIN_ACCPWD."&aimcodes=".trim($mobile).
            //    "&content=".trim($action).MFUN_HCU_FHYS_LEXIN_SIGNATURE."&bizId=".$timestamp."&dataType=string";

            //CMCC短信平台
            //http://api.sms.heclouds.com/tempsmsSend?sicode=a2bb3546a41649a29e2fcb635e091dd5&mobiles=13917334681&tempid=10003&name=foha
            $url = MFUN_HCU_FHYS_CMCC_URL.'?sicode='.MFUN_HCU_FHYS_CMCC_SICODE.'&mobiles='.trim($mobile).
                '&tempid='.MFUN_HCU_FHYS_CMCC_TEMPCODE_ALARM.'&name='.$statname.'&action='.$action;
            $l2sdkIotWxObj = new classTaskL2sdkIotWx();
            $resp =$l2sdkIotWxObj->https_request($url);

            $flag_new = MFUN_HCU_ALARM_PROC_FLAG_N;
            $flag_proc = MFUN_HCU_ALARM_PROC_FLAG_Y;
            $currenttime = date("Y-m-d H:i:s", $timestamp);
            $alarmproc = "{$currenttime} 操作员[{$uid}]发送信息[{$action}]到手机[{$mobile}];";
            $query_str = "UPDATE `t_l3f5fm_aqyc_alarmdata` SET `alarmflag` = '$flag_proc', `alarmproc` = concat(`alarmproc`,'$alarmproc') WHERE (`statcode` = '$statCode' AND `alarmflag` = '$flag_new')";
            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $alarmproc;
    }

    public function dbi_aqyc_alarm_close_process($uid,$statCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $timestamp = time();
        $currenttime = date("Y-m-d H:i:s",$timestamp);
        $flag_proc = MFUN_HCU_ALARM_PROC_FLAG_Y;
        $flag_close = MFUN_HCU_ALARM_PROC_FLAG_C;
        $alarmproc = "操作员[{$uid}]关闭告警";
        $query_str = "UPDATE `t_l3f5fm_aqyc_alarmdata` SET `alarmflag` = '$flag_close', `alarmproc` = concat(`alarmproc`,'$alarmproc'), `tsclose` = '$currenttime' WHERE (`statcode` = '$statCode' AND `alarmflag` = '$flag_proc')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    //UI AlarmQuery Request, 获取告警数据highchart
    public function dbi_aqyc_dev_alarmhistory_req($statCode, $date, $alarm_type)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //根据监测点号查找对应的设备号
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `statcode` = '$statCode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows) > 0) {
            $row = $result->fetch_array();
            $devcode = $row['devcode'];
        }

        //查询highchart坐标轴的最大和最小值
        $query_str = "SELECT * FROM `t_l2snr_sensortype` WHERE `typeid` = '$alarm_type'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows) > 0) {
            $row = $result->fetch_array();
            $value_min = $row['value_min']/1;
            $value_max = $row['value_max']/1;
            $resp["value_min"] = $value_min;
            $resp["value_max"] = $value_max;
        }

        switch($alarm_type) {
            case MFUN_L3APL_F3DM_AQYC_STYPE_PM:
                $resp["alarm_name"] = "细颗粒物";
                $resp["alarm_unit"] = "微克/立方米";
                $resp["warning"] = MFUN_L3APL_F3DM_TH_ALARM_PM25;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                //24小时的分钟图表
                $query_str = "SELECT * FROM `t_l2snr_pm25data` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0) {
                    for($i=0; $i<$result->num_rows; $i++) {
                        $row = $result->fetch_array();
                        $data = $row["pm25"];
                        $hourminindex = $row["hourminindex"];
                        $hour = floor($hourminindex/60) ;
                        $min = $hourminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                }
                else {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                }

                //一周小时图表
                //$date = $date." 00:00:00";
                $start_date = date('Y-m-d',strtotime($date)-6*24*60*60); //找到一周前的起始日期
                $query_str = "SELECT * FROM `t_l2snr_pm25data` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0) {
                    //将一周内的数值，按小时归组，先按小时清零
                    for ($day_index=0;$day_index<8;$day_index++) {
                        for ($hour_index=0;$hour_index<24;$hour_index++) {
                            $pm25[$day_index][$hour_index]["sum"]=0;
                            $pm25[$day_index][$hour_index]["counter"]=0;
                            $pm25[$day_index][$hour_index]["average"]=0;
                        }
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++) {
                        $row = $result->fetch_array();
                        $data = $row["pm25"];
                        $hourminindex = $row["hourminindex"];
                        $hour_index = floor($hourminindex/60) ;

                        // 取值这一周内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $pm25[$day_index][$hour_index]["sum"] = $pm25[$day_index][$hour_index]["sum"] + $data;
                        $pm25[$day_index][$hour_index]["counter"] ++;
                    }

                    //将一周内的数值，按小时求算术平均值
                    for ($day_index=0;$day_index<7;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            if ($pm25[$day_index][$hour_index]["counter"]!=0)
                            {
                                $pm25[$day_index][$hour_index]["average"]=$pm25[$day_index][$hour_index]["sum"]/$pm25[$day_index][$hour_index]["counter"];
                            }
                            else
                            {
                                $pm25[$day_index][$hour_index]["average"]=0; //或者跳过这个值？
                            }

                            $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                            $head = $date_value." ".$hour_index.":00";
                            $average = round($pm25[$day_index][$hour_index]["average"],1);
                            array_push($resp["hour_alarm"], $average);
                            array_push($resp["hour_head"], $head);
                        }
                    }

                }
                else
                {
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                }


                //30天按天的图表
                $start_date = date('Y-m-d',strtotime($date)-29*24*60*60); //找到起始日期
                $query_str = "SELECT * FROM `t_l2snr_pm25data` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date'  ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将30天内的数值，按天归组，先按天清零
                    for ($day_index=0;$day_index<31;$day_index++)
                    {
                        $pm25[$day_index]["sum"]=0;
                        $pm25[$day_index]["counter"]=0;
                        $pm25[$day_index]["average"]=0;
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["pm25"];

                        // 取值这30天内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $pm25[$day_index]["sum"] = $pm25[$day_index]["sum"] + $data;
                        $pm25[$day_index]["counter"] ++;

                    }

                    //将30天内的数值，按天求算术平均值
                    for ($day_index=0;$day_index<30;$day_index++)
                    {
                        if ($pm25[$day_index]["counter"]!=0)
                        {
                            $pm25[$day_index]["average"]=$pm25[$day_index]["sum"]/$pm25[$day_index]["counter"];
                        }
                        else
                        {
                            $pm25[$day_index]["average"]=0; //或者跳过这个值？
                        }

                        $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                        $head = $date_value;
                        $average = round($pm25[$day_index]["average"],1);
                        array_push($resp["day_alarm"], $average);
                        array_push($resp["day_head"], $head);
                    }

                }
                else
                {
                    for ($i=0; $i<30; $i++) {
                        array_push($resp["day_alarm"], 0);
                        array_push($resp["day_head"], (string)$i);
                    }
                }

                break;

            case MFUN_L3APL_F3DM_AQYC_STYPE_WINDSPD:
                $resp["alarm_name"] = "风速";
                $resp["alarm_unit"] = "米/秒";
                $resp["warning"] = MFUN_L3APL_F3DM_TH_ALARM_WINDSPD;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                //24小时的分钟图表
                $query_str = "SELECT * FROM `t_l2snr_windspd` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["windspeed"];
                        $hourminindex = $row["hourminindex"];
                        $hour = floor($hourminindex/60) ;
                        $min = $hourminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                }

                //一周小时图表
                //$date = $date." 00:00:00";
                $start_date = date('Y-m-d',strtotime($date)-6*24*60*60); //找到一周前的起始日期
                $query_str = "SELECT * FROM `t_l2snr_windspd` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将一周内的数值，按小时归组，先按小时清零
                    for ($day_index=0;$day_index<8;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            $windspeed[$day_index][$hour_index]["sum"]=0;
                            $windspeed[$day_index][$hour_index]["counter"]=0;
                            $windspeed[$day_index][$hour_index]["average"]=0;
                        }
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["windspeed"];
                        $hourminindex = $row["hourminindex"];
                        $hour_index = floor($hourminindex/60) ;

                        // 取值这一周内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $windspeed[$day_index][$hour_index]["sum"] = $windspeed[$day_index][$hour_index]["sum"] + $data;
                        $windspeed[$day_index][$hour_index]["counter"] ++;

                    }

                    //将一周内的数值，按小时求算术平均值
                    for ($day_index=0;$day_index<7;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            if ($windspeed[$day_index][$hour_index]["counter"]!=0)
                            {
                                $windspeed[$day_index][$hour_index]["average"]=$windspeed[$day_index][$hour_index]["sum"]/$windspeed[$day_index][$hour_index]["counter"];
                            }
                            else
                            {
                                $windspeed[$day_index][$hour_index]["average"]=0; //或者跳过这个值？
                            }

                            $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                            $head = $date_value." ".$hour_index.":00";
                            $average = round($windspeed[$day_index][$hour_index]["average"],1);
                            array_push($resp["hour_alarm"], $average);
                            array_push($resp["hour_head"], $head);
                        }
                    }

                }
                else
                {
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                }


                //30天按天的图表
                $start_date = date('Y-m-d',strtotime($date)-29*24*60*60); //找到起始日期
                $query_str = "SELECT * FROM `t_l2snr_windspd` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将30天内的数值，按天归组，先按天清零
                    for ($day_index=0;$day_index<31;$day_index++)
                    {
                        $windspeed[$day_index]["sum"]=0;
                        $windspeed[$day_index]["counter"]=0;
                        $windspeed[$day_index]["average"]=0;
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["windspeed"];

                        // 取值这30天内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $windspeed[$day_index]["sum"] = $windspeed[$day_index]["sum"] + $data;
                        $windspeed[$day_index]["counter"] ++;

                    }

                    //将30天内的数值，按天求算术平均值
                    for ($day_index=0;$day_index<30;$day_index++)
                    {
                        if ($windspeed[$day_index]["counter"]!=0)
                        {
                            $windspeed[$day_index]["average"]=$windspeed[$day_index]["sum"]/$windspeed[$day_index]["counter"];
                        }
                        else
                        {
                            $windspeed[$day_index]["average"]=0; //或者跳过这个值？
                        }

                        $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                        $head = $date_value;
                        $average = round($windspeed[$day_index]["average"],1);
                        array_push($resp["day_alarm"], $average);
                        array_push($resp["day_head"], $head);
                    }

                }
                else
                {
                    for ($i=0; $i<30; $i++) {
                        array_push($resp["day_alarm"], 0);
                        array_push($resp["day_head"], (string)$i);
                    }
                }

                break;

            case MFUN_L3APL_F3DM_AQYC_STYPE_WINDDIR:
                $resp["alarm_name"] = "风向";
                $resp["alarm_unit"] = "度";
                $resp["warning"] = MFUN_L3APL_F3DM_TH_ALARM_WINDDIR;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_l2snr_winddir` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["winddirection"];
                        $huorminindex = $row["hourminindex"];
                        $hour = floor($huorminindex/60) ;
                        $min = $huorminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                    //临时填的随机数
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                break;

            case MFUN_L3APL_F3DM_AQYC_STYPE_EMC:
                $resp["alarm_name"] = "电磁辐射";
                $resp["alarm_unit"] = "毫瓦/平方毫米";
                $resp["warning"] = MFUN_L3APL_F3DM_TH_ALARM_EMC;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_l2snr_emcdata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["emcvalue"]/100;
                        $huorminindex = $row["hourminindex"];
                        $hour = floor($huorminindex/60) ;
                        $min = $huorminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                    //临时填的随机数
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                break;

            case MFUN_L3APL_F3DM_AQYC_STYPE_TEMP:
                $resp["alarm_name"] = "温度";
                $resp["alarm_unit"] = "摄氏度";
                $resp["warning"] = MFUN_L3APL_F3DM_TH_ALARM_TEMP;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                //24小时的分钟图表
                $query_str = "SELECT * FROM `t_l2snr_tempdata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["temperature"];
                        $hourminindex = $row["hourminindex"];
                        $hour = floor($hourminindex/60) ;
                        $min = $hourminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                }

                //一周小时图表
                //$date = $date." 00:00:00";
                $start_date = date('Y-m-d',strtotime($date)-6*24*60*60); //找到一周前的起始日期
                $query_str = "SELECT * FROM `t_l2snr_tempdata` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将一周内的数值，按小时归组，先按小时清零
                    for ($day_index=0;$day_index<8;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            $temperature[$day_index][$hour_index]["sum"]=0;
                            $temperature[$day_index][$hour_index]["counter"]=0;
                            $temperature[$day_index][$hour_index]["average"]=0;
                        }
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["temperature"];
                        $hourminindex = $row["hourminindex"];
                        $hour_index = floor($hourminindex/60) ;

                        // 取值这一周内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $temperature[$day_index][$hour_index]["sum"] = $temperature[$day_index][$hour_index]["sum"] + $data;
                        $temperature[$day_index][$hour_index]["counter"] ++;

                    }

                    //将一周内的数值，按小时求算术平均值
                    for ($day_index=0;$day_index<7;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            if ($temperature[$day_index][$hour_index]["counter"]!=0)
                            {
                                $temperature[$day_index][$hour_index]["average"]=$temperature[$day_index][$hour_index]["sum"]/$temperature[$day_index][$hour_index]["counter"];
                            }
                            else
                            {
                                $temperature[$day_index][$hour_index]["average"]=0; //或者跳过这个值？
                            }

                            $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                            $head = $date_value." ".$hour_index.":00";
                            $average = round($temperature[$day_index][$hour_index]["average"],1);
                            array_push($resp["hour_alarm"], $average);
                            array_push($resp["hour_head"], $head);
                        }
                    }
                }
                else
                {
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                }

                //30天按天的图表
                $start_date = date('Y-m-d',strtotime($date)-29*24*60*60); //找到起始日期
                $query_str = "SELECT * FROM `t_l2snr_tempdata` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将30天内的数值，按天归组，先按天清零
                    for ($day_index=0;$day_index<31;$day_index++)
                    {
                        $noise[$day_index]["sum"]=0;
                        $noise[$day_index]["counter"]=0;
                        $noise[$day_index]["average"]=0;
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["temperature"];

                        // 取值这30天内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $temperature[$day_index]["sum"] = $temperature[$day_index]["sum"] + $data;
                        $temperature[$day_index]["counter"] ++;

                    }

                    //将30天内的数值，按天求算术平均值
                    for ($day_index=0;$day_index<30;$day_index++)
                    {
                        if ($temperature[$day_index]["counter"]!=0)
                        {
                            $temperature[$day_index]["average"]=$temperature[$day_index]["sum"]/$temperature[$day_index]["counter"];
                        }
                        else
                        {
                            $temperature[$day_index]["average"]=0; //或者跳过这个值？
                        }

                        $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                        $head = $date_value;
                        $average = round($temperature[$day_index]["average"],1);
                        array_push($resp["day_alarm"], $average);
                        array_push($resp["day_head"], $head);
                    }
                }
                else
                {
                    for ($i=0; $i<30; $i++) {
                        array_push($resp["day_alarm"], 0);
                        array_push($resp["day_head"], (string)$i);
                    }
                }

                break;

            case MFUN_L3APL_F3DM_AQYC_STYPE_HUMID:
                $resp["alarm_name"] = "湿度";
                $resp["alarm_unit"] = "%";
                $resp["warning"] = MFUN_L3APL_F3DM_TH_ALARM_HUMID;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                //24小时的分钟图表
                $query_str = "SELECT * FROM `t_l2snr_humiddata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["humidity"];
                        $hourminindex = $row["hourminindex"];
                        $hour = floor($hourminindex/60) ;
                        $min = $hourminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                }

                //一周小时图表
                //$date = $date." 00:00:00";
                $start_date = date('Y-m-d',strtotime($date)-6*24*60*60); //找到一周前的起始日期
                $date_temp = $start_date;
                $query_str = "SELECT * FROM `t_l2snr_humiddata` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将一周内的数值，按小时归组，先按小时清零
                    for ($day_index=0;$day_index<8;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            $humidity[$day_index][$hour_index]["sum"]=0;
                            $humidity[$day_index][$hour_index]["counter"]=0;
                            $humidity[$day_index][$hour_index]["average"]=0;
                        }
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["humidity"];
                        $hourminindex = $row["hourminindex"];
                        $hour_index = floor($hourminindex/60) ;

                        // 取值这一周内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $humidity[$day_index][$hour_index]["sum"] = $humidity[$day_index][$hour_index]["sum"] + $data;
                        $humidity[$day_index][$hour_index]["counter"] ++;

                    }

                    //将一周内的数值，按小时求算术平均值
                    for ($day_index=0;$day_index<7;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            if ($humidity[$day_index][$hour_index]["counter"]!=0)
                            {
                                $humidity[$day_index][$hour_index]["average"]=$humidity[$day_index][$hour_index]["sum"]/$humidity[$day_index][$hour_index]["counter"];
                            }
                            else
                            {
                                $humidity[$day_index][$hour_index]["average"]=0; //或者跳过这个值？
                            }

                            $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                            $head = $date_value." ".$hour_index.":00";
                            $average = round($humidity[$day_index][$hour_index]["average"],1);
                            array_push($resp["hour_alarm"], $average);
                            array_push($resp["hour_head"], $head);
                        }
                    }

                }
                else
                {
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                }


                //30天按天的图表
                $start_date = date('Y-m-d',strtotime($date)-29*24*60*60); //找到起始日期
                $query_str = "SELECT * FROM `t_l2snr_humiddata` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将30天内的数值，按天归组，先按天清零
                    for ($day_index=0;$day_index<31;$day_index++)
                    {
                        $noise[$day_index]["sum"]=0;
                        $noise[$day_index]["counter"]=0;
                        $noise[$day_index]["average"]=0;
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["humidity"];

                        // 取值这30天内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $humidity[$day_index]["sum"] = $humidity[$day_index]["sum"] + $data;
                        $humidity[$day_index]["counter"] ++;

                    }

                    //将30天内的数值，按天求算术平均值
                    for ($day_index=0;$day_index<30;$day_index++)
                    {
                        if ($humidity[$day_index]["counter"]!=0)
                        {
                            $humidity[$day_index]["average"]=$humidity[$day_index]["sum"]/$humidity[$day_index]["counter"];
                        }
                        else
                        {
                            $humidity[$day_index]["average"]=0; //或者跳过这个值？
                        }

                        $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                        $head = $date_value;
                        $average = round($humidity[$day_index]["average"],1);
                        array_push($resp["day_alarm"], $average);
                        array_push($resp["day_head"], $head);
                    }

                }
                else
                {
                    for ($i=0; $i<30; $i++) {
                        array_push($resp["day_alarm"], 0);
                        array_push($resp["day_head"], (string)$i);
                    }
                }

                break;

            case MFUN_L3APL_F3DM_AQYC_STYPE_NOISE:
                $resp["alarm_name"] = "噪声";
                $resp["alarm_unit"] = "分贝";
                $resp["warning"] = MFUN_L3APL_F3DM_TH_ALARM_NOISE;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                //24小时的分钟图表
                $query_str = "SELECT * FROM `t_l2snr_noisedata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["noise"];
                        $hourminindex = $row["hourminindex"];
                        $hour = floor($hourminindex/60) ;
                        $min = $hourminindex - $hour*60;
                        $head = $hour.":".$min;
                        $data=intval($data);
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                }

                //一周小时图表
                //$date = $date." 00:00:00";
                $start_date = date('Y-m-d',strtotime($date)-6*24*60*60); //找到一周前的起始日期
                $date_temp = $start_date;
                $query_str = "SELECT * FROM `t_l2snr_noisedata` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将一周内的数值，按小时归组，先按小时清零
                    for ($day_index=0;$day_index<8;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            $noise[$day_index][$hour_index]["sum"]=0;
                            $noise[$day_index][$hour_index]["counter"]=0;
                            $noise[$day_index][$hour_index]["average"]=0;
                        }
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["noise"];
                        $hourminindex = $row["hourminindex"];
                        $hour_index = floor($hourminindex/60) ;

                        // 取值这一周内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $noise[$day_index][$hour_index]["sum"] = $noise[$day_index][$hour_index]["sum"] + $data;
                        $noise[$day_index][$hour_index]["counter"] ++;

                    }

                    //将一周内的数值，按小时求算术平均值
                    for ($day_index=0;$day_index<7;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            if ($noise[$day_index][$hour_index]["counter"]!=0)
                            {
                                $noise[$day_index][$hour_index]["average"]=$noise[$day_index][$hour_index]["sum"]/$noise[$day_index][$hour_index]["counter"];
                            }
                            else
                            {
                                $noise[$day_index][$hour_index]["average"]=0; //或者跳过这个值？
                            }

                            $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                            $head = $date_value." ".$hour_index.":00";
                            $average = round($noise[$day_index][$hour_index]["average"],1);
                            array_push($resp["hour_alarm"], $average);
                            array_push($resp["hour_head"], $head);
                        }
                    }

                }
                else
                {
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                }

                //30天按天的图表
                $start_date = date('Y-m-d',strtotime($date)-29*24*60*60); //找到起始日期
                $query_str = "SELECT * FROM `t_l2snr_noisedata` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将30天内的数值，按天归组，先按天清零
                    for ($day_index=0;$day_index<31;$day_index++)
                    {
                        $noise[$day_index]["sum"]=0;
                        $noise[$day_index]["counter"]=0;
                        $noise[$day_index]["average"]=0;
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["noise"];

                        // 取值这30天内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $noise[$day_index]["sum"] = $noise[$day_index]["sum"] + $data;
                        $noise[$day_index]["counter"] ++;

                    }

                    //将30天内的数值，按天求算术平均值
                    for ($day_index=0;$day_index<30;$day_index++)
                    {
                        if ($noise[$day_index]["counter"]!=0)
                        {
                            $noise[$day_index]["average"]=$noise[$day_index]["sum"]/$noise[$day_index]["counter"];
                        }
                        else
                        {
                            $noise[$day_index]["average"]=0; //或者跳过这个值？
                        }

                        $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                        $head = $date_value;
                        $average = round($noise[$day_index]["average"],1);
                        array_push($resp["day_alarm"], $average);
                        array_push($resp["day_head"], $head);
                    }

                }
                else
                {
                    for ($i=0; $i<30; $i++) {
                        array_push($resp["day_alarm"], 0);
                        array_push($resp["day_head"], (string)$i);
                    }
                }

                break;

            default:
                $resp = "";
                break;
        }

        $mysqli->close();
        return $resp;
    }

    /*********************************智能云锁新增处理************************************************/
    public function dbi_fhys_alarm_history_table_req($uid)
    {
        //初始化返回值
        $resp["column"] = array();
        $resp['data'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $auth_list["stat_code"] = array();
        $auth_list["p_code"] = array();
        $auth_list = $this->dbi_user_statproj_inqury($mysqli, $uid);

        array_push($resp["column"], "站点编号");
        array_push($resp["column"], "处理状态");
        array_push($resp["column"], "设备编号");
        array_push($resp["column"], "站点名称");
        array_push($resp["column"], "地址");
        array_push($resp["column"], "负责人");
        array_push($resp["column"], "联系电话");
        array_push($resp["column"], "告警级别");
        array_push($resp["column"], "告警产生时间");
        array_push($resp["column"], "告警关闭时间");
        array_push($resp["column"], "告警内容及处理");

        //初始化返回值，确保数据库查询不到的情况下界面返回数据长度不报错
        $statname = "";
        $country = "";
        $address = "";
        $chargeman = "";
        $telephone = "";

        $objFhysAlarm = new classConstFhysEngpar();
        for($i=0; $i<count($auth_list); $i++)
        {
            $statCode = $auth_list[$i]["stat_code"];

            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statCode'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows) > 0) {
                $row = $result->fetch_array();
                $statname = $row["statname"];
                $address = $row["address"];
                $chargeman = $row["chargeman"];
                $telephone = $row["telephone"];
            }
            $alarmflag = MFUN_HCU_ALARM_PROC_FLAG_C;
            $query_str = "SELECT * FROM `t_l3f5fm_fhys_alarmdata` WHERE (`statcode` = '$statCode' AND `alarmflag` != '$alarmflag')"; //授权站点中尚未关闭的告警
            $result = $mysqli->query($query_str);
            while (($result != false) && (($row = $result->fetch_array()) > 0)) {
                $one_row = array();
                $devCode = $row["devcode"];
                $alarmflag = $row["alarmflag"];
                $alarmseverity = $row["alarmseverity"];
                $tsgen = $row["tsgen"];
                $tsclose = $row["tsclose"];
                $alarmproc = $row["alarmproc"];

                array_push($one_row, $statCode);
                array_push($one_row, $alarmflag);
                array_push($one_row, $devCode);
                array_push($one_row, $statname);
                array_push($one_row, $address);
                array_push($one_row, $chargeman);
                array_push($one_row, $telephone);
                array_push($one_row, $alarmseverity);
                array_push($one_row, $tsgen);
                array_push($one_row, $tsclose);
                array_push($one_row, $alarmproc);

                array_push($resp['data'], $one_row);
            }
        }

        $mysqli->close();
        return $resp;
    }

    public function dbi_fhys_alarm_handle_process($uid,$statCode,$mobile,$action)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $timestamp = time();
        $alarmproc = "";

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statCode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows) > 0) {
            $row = $result->fetch_array();
            $projcode = $row['p_code'];
            $statname = $row["statname"];
            $chargeman = $row["chargeman"];
            $telephone = $row["telephone"];
            //LEXIN短信平台
            //$url = MFUN_HCU_FHYS_LEXIN_URL.MFUN_HCU_FHYS_LEXIN_ACCNAME."&".MFUN_HCU_FHYS_LEXIN_ACCPWD."&aimcodes=".trim($mobile).
            //    "&content=".trim($action).MFUN_HCU_FHYS_LEXIN_SIGNATURE."&bizId=".$timestamp."&dataType=string";

            //CMCC短信平台
            //http://api.sms.heclouds.com/tempsmsSend?sicode=a2bb3546a41649a29e2fcb635e091dd5&mobiles=13917334681&tempid=10003&name=foha
            $url = MFUN_HCU_FHYS_CMCC_URL.'?sicode='.MFUN_HCU_FHYS_CMCC_SICODE.'&mobiles='.trim($mobile).
                '&tempid='.MFUN_HCU_FHYS_CMCC_TEMPCODE_ALARM.'&name='.$statname.'&action='.$action;
            $l2sdkIotWxObj = new classTaskL2sdkIotWx();
            $resp =$l2sdkIotWxObj->https_request($url);

            //微信公众号通知
            //先查询这个有这个项目授权的所有手机微信openid
            $currenttime = date("Y-m-d H:i:s", $timestamp);
            $key_type = MFUN_L3APL_F2CM_KEY_TYPE_WECHAT;
            $query_str = "SELECT `hwcode` FROM `t_l3f2cm_fhys_keyinfo` WHERE (`p_code` = '$projcode' AND `keytype` = '$key_type')";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($row = $result->fetch_array()) > 0)){
                $wx_touser = $row['hwcode'];
                $template = array('touser' => $wx_touser,
                                //'template_id' => "SAoMGA7GYeavgwpOImgWDs5BaoDMKIT5luASeZ671XM",  //小慧公众号
                                'template_id' => "JtIqUduhqFSJYRbnBLQnlSri7gT6NRkLKgzohHyDUrs",    //阜华公众号
                                'topcolor' => "#7B68EE",
                                //'url' => "http://weixin.qq.com/download", //详细信息URL
                                'data' => array('first' => array('value' => "您好，光交箱智能管理平台告警通知!", 'color' => "#743A3A"),
                                    'keyword1' => array('value' => $statname, 'color' => "#0000FF"),
                                    'keyword2' => array('value' => $action, 'color' => "#FF0000"),
                                    'keyword3' => array('value' => $currenttime, 'color' => "#0000FF"),
                                    'keyword4' => array('value' => $chargeman, 'color' => "#0000FF"),
                                    'keyword5' => array('value' => $telephone, 'color' => "#0000FF"),
                                    'remark' => array('value' => "请及时联系相关人员处理该告警", 'color' => "#0000FF"))
                                );
                $resp = $l2sdkIotWxObj->send_template_message(json_encode($template, JSON_UNESCAPED_UNICODE));
            }

            $flag_new = MFUN_HCU_ALARM_PROC_FLAG_N;
            $flag_proc = MFUN_HCU_ALARM_PROC_FLAG_Y;
            $alarmproc = "{$currenttime} 操作员[{$uid}]发送信息[{$action}]到手机[{$mobile}];";
            $query_str = "UPDATE `t_l3f5fm_fhys_alarmdata` SET `alarmflag` = '$flag_proc', `alarmproc` = concat(`alarmproc`,'$alarmproc') WHERE (`statcode` = '$statCode' AND `alarmflag` = '$flag_new')";
            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $alarmproc;
    }

    public function dbi_fhys_alarm_close_process($uid,$statCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $timestamp = time();
        $currenttime = date("Y-m-d H:i:s",$timestamp);
        $flag_proc = MFUN_HCU_ALARM_PROC_FLAG_Y;
        $flag_close = MFUN_HCU_ALARM_PROC_FLAG_C;
        $alarmproc = "操作员[{$uid}]关闭告警";
        $query_str = "UPDATE `t_l3f5fm_fhys_alarmdata` SET `alarmflag` = '$flag_close', `alarmproc` = concat(`alarmproc`,'$alarmproc'), `tsclose` = '$currenttime' WHERE (`statcode` = '$statCode' AND `alarmflag` = '$flag_proc')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }


}

?>