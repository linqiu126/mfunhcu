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
-- --------------------------------------------------------

--
-- 表的结构 `t_l3f3dm_aqyc_currentreport`
--

CREATE TABLE IF NOT EXISTS `t_l3f3dm_aqyc_currentreport` (
  `sid` int(4) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `statcode` char(20) NOT NULL,
  `createtime` char(20) NOT NULL,
  `pm01` float DEFAULT NULL,
  `pm25` float DEFAULT NULL,
  `pm10` float DEFAULT NULL,
  `noise` float DEFAULT NULL,
  `windspeed` float DEFAULT NULL,
  `winddirection` float DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `humidity` float DEFAULT NULL,
  `rain` float DEFAULT NULL,
  `airpressure` float DEFAULT NULL,
  `emcvalue` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l3f3dm_aqyc_currentreport`
--
ALTER TABLE `t_l3f3dm_aqyc_currentreport`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `deviceid` (`deviceid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l3f3dm_aqyc_currentreport`
--
ALTER TABLE `t_l3f3dm_aqyc_currentreport`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f3dm_fhys_currentreport`
--

CREATE TABLE IF NOT EXISTS `t_l3f3dm_fhys_currentreport` (
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `createtime` char(20) NOT NULL,
  `reporttype` int(1) NOT NULL DEFAULT '0',
  `door_1` int(1) NOT NULL DEFAULT '0',
  `door_2` int(1) NOT NULL DEFAULT '0',
  `door_3` int(1) NOT NULL DEFAULT '0',
  `door_4` int(1) NOT NULL DEFAULT '0',
  `lock_1` int(1) NOT NULL DEFAULT '0',
  `lock_2` int(1) NOT NULL DEFAULT '0',
  `lock_3` int(1) NOT NULL DEFAULT '0',
  `lock_4` int(1) NOT NULL DEFAULT '0',
  `battstate` int(1) NOT NULL DEFAULT '0',
  `waterstate` int(1) NOT NULL DEFAULT '0',
  `shakestate` int(1) NOT NULL DEFAULT '0',
  `fallstate` int(1) NOT NULL DEFAULT '0',
  `smokestate` int(1) NOT NULL DEFAULT '0',
  `battvalue` float NOT NULL DEFAULT '0',
  `fallvalue` float NOT NULL DEFAULT '0',
  `tempvalue` float NOT NULL DEFAULT '0',
  `humidvalue` float NOT NULL DEFAULT '0',
  `rssivalue` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='云控锁项目光交箱状态监控表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l3f3dm_fhys_currentreport`
--
ALTER TABLE `t_l3f3dm_fhys_currentreport`
  ADD PRIMARY KEY (`devcode`),
  ADD UNIQUE KEY `statcode` (`statcode`);

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f3dm_siteinfo`
--

CREATE TABLE IF NOT EXISTS `t_l3f3dm_siteinfo` (
  `statcode` char(20) NOT NULL,
  `statname` char(50) NOT NULL,
  `p_code` char(20) DEFAULT NULL,
  `chargeman` char(20) DEFAULT NULL,
  `telephone` char(15) DEFAULT NULL,
  `department` char(30) DEFAULT NULL,
  `country` char(20) DEFAULT NULL,
  `street` char(20) DEFAULT NULL,
  `address` char(50) DEFAULT NULL,
  `starttime` date DEFAULT NULL,
  `square` char(10) NOT NULL DEFAULT '0',
  `altitude` int(4) DEFAULT '0',
  `flag_la` char(1) DEFAULT 'N',
  `latitude` int(4) DEFAULT '0',
  `flag_lo` char(1) DEFAULT 'E',
  `longitude` int(4) DEFAULT '0',
  `memo` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l3f3dm_siteinfo`
--
ALTER TABLE `t_l3f3dm_siteinfo`
  ADD PRIMARY KEY (`statcode`),
  ADD KEY `statCode` (`statcode`);

*/


class classDbiL3apF3dm
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

    //将风向传感器的角度值转换为风向16方位
    private function dbi_winddir_convert($degree)
    {
        if (($degree >= 337.5 AND $degree < 360) OR ($degree < 22.5))
            $winddir = "北风";
        else if ($degree >= 22.5 AND $degree < 67.5)
            $winddir = "东北风";
        else if ($degree >= 67.5 AND $degree < 112.5)
            $winddir = "东风";
        else if ($degree >= 112.5 AND $degree < 157.5)
            $winddir = "东南风";
        else if ($degree >= 157.5 AND $degree < 202.5)
            $winddir = "东南风";
        else if ($degree >= 202.5 AND $degree < 247.5)
            $winddir = "西南风";
        else if ($degree >= 247.5 AND $degree < 292.5)
            $winddir = "西风";
        else if ($degree >= 292.5 AND $degree < 337.5)
            $winddir = "西北风";
        else
            $winddir = "未知";

        return $winddir;
    }

    //查询该HCU设备的视频地址link
    public function dbi_siteinfo_inquiry_url($deviceid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `devcode` = '$deviceid'");
        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $resp = trim($row['videourl']); //返回该设备的视频地址
        }
        else{
            $resp = false;
        }

        $mysqli->close();
        return $resp;
    }


    /**********************************************************************************************************************
     *                                                 地图显示相关操作DB API                                               *
     *********************************************************************************************************************/
    //UI MonitorList request, 获取该用户地图显示的所有监测点信息
    public function dbi_map_active_sitetinfo_req($uid)
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
        $siteStatus = MFUN_HCU_SITE_STATUS_INITIAL;
        for($i=0; $i<count($auth_list); $i++)
        {
            $statCode = $auth_list[$i]['stat_code'];
            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE (`statcode` = '$statCode' AND `status` != '$siteStatus')";      //查询监测点对应的项目号
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0) {
                $info = $resp->fetch_array();
                $latitude = (string)(($info['latitude'])/1000000);  //百度地图经纬度转换
                $longitude = (string)(($info['longitude'])/1000000);

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

        $mysqli->close();
        return $sitelist;
    }

    public function dbi_map_inactive_sitetinfo_req($uid)
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
        $siteStatus = MFUN_HCU_SITE_STATUS_INITIAL;
        for($i=0; $i<count($auth_list); $i++)
        {
            $statCode = $auth_list[$i]['stat_code'];
            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE (`statcode` = '$statCode' AND `status` = '$siteStatus')";      //查询监测点对应的项目号
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0) {
                $info = $resp->fetch_array();
                $latitude = (string)(($info['latitude'])/1000000);  //百度地图经纬度转换
                $longitude = (string)(($info['longitude'])/1000000);

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

        $mysqli->close();
        return $sitelist;
    }


    public function dbi_favourite_count_process($uid, $statCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $timestamp = time();
        $currenttime = date("Y-m-d H:i:s",$timestamp);
        $query_str = "SELECT * FROM `t_l3f2cm_favourlist` WHERE `uid` = '$uid'";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;
        if($total < MFUN_L3APL_F2CM_FAVOURSITE_MAX_NUM){ //新增一个站点
            $query_str = "SELECT * FROM `t_l3f2cm_favourlist` WHERE (`uid` = '$uid' AND `statcode` = '$statCode')";
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0){//如果有重复，则更新这个站点的点击日期
                $row = $resp->fetch_array();
                $sid = $row['sid'];
                $query_str = "UPDATE `t_l3f2cm_favourlist` SET `createtime` = '$currenttime' WHERE (`sid` = '$sid' )";
                $result = $mysqli->query($query_str);
            }
            else{
                $query_str = "INSERT INTO `t_l3f2cm_favourlist` (uid,statcode,createtime) VALUES ('$uid','$statCode','$currenttime')";
                $result = $mysqli->query($query_str);
            }
        }
        else{//替换一个站点
            $query_str = "SELECT * FROM `t_l3f2cm_favourlist` WHERE (`uid` = '$uid' AND `statcode` = '$statCode')";
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0){//如果有重复，则更新这个站点的点击日期
                $row = $resp->fetch_array();
                $sid = $row['sid'];
                $query_str = "UPDATE `t_l3f2cm_favourlist` SET `createtime` = '$currenttime' WHERE (`sid` = '$sid' )";
                $result = $mysqli->query($query_str);
            }
            else{ //替换一个时间最早的站点
                $query_str = "SELECT * FROM `t_l3f2cm_favourlist` WHERE (`createtime` = (SELECT MIN(`createtime`) FROM `t_l3f2cm_favourlist` where `uid` = '$uid' )) AND (`uid` = '$uid')";
                $result = $mysqli->query($query_str);
                if (($result->num_rows)>0) {
                    $row = $result->fetch_array();
                    $sid = $row['sid'];
                    $query_str = "UPDATE `t_l3f2cm_favourlist` SET `uid` = '$uid',`statcode` = '$statCode', `createtime` = '$currenttime' WHERE (`sid` = '$sid' )";
                    $result = $mysqli->query($query_str);
                }
            }

        }
        $mysqli->close();
        return $result;
    }

    public function dbi_favourite_list_process($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $sitelist = array();
        $query_str = "SELECT * FROM `t_l3f2cm_favourlist` WHERE `uid` = '$uid'";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $statCode = $row['statcode'];

            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statCode'";      //查询监测点对应的项目号
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0) {
                $info = $resp->fetch_array();

                $latitude = (string)(($info['latitude'])/1000000);  //百度地图经纬度转换
                $longitude = (string)(($info['longitude'])/1000000);

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
        $mysqli->close();
        return $sitelist;
    }

    /**********************************************************************************************************************
     *                                                 传感器相关操作DB API                                                 *
     *********************************************************************************************************************/
    //UI DevAlarm Request, 获取当前的测量值，如果测量值超出范围，提示告警
    public function dbi_aqyc_dev_currentvalue_req($statCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $vcrname = array();
        $vcrlink = array();
        $vcrlist = array();
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `statcode` = '$statCode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            array_push($vcrname,"RTSP");
            array_push($vcrname,"CAMCTRL");
            $rtsp = $row['videourl'];
            $cam_ctrl = $row['camctrl'];
            array_push($vcrlink,$rtsp);
            array_push($vcrlink,$cam_ctrl);
            $vcrlist = array('vcrname'=>$vcrname, 'vcraddress'=>$vcrlink);
        }

        $currentvalue = array(); //初始化
        $query_str = "SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE `statcode` = '$statCode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();  //暂时先这样处理，此处测量值计算要根据上报精度进行修改。。。。。
            $noise = $row['noise'];
            $winddir = $row['winddirection'];
            $humidity = $row['humidity'];
            $temperature = $row['temperature'];
            $pm25 = $row['pm25'];
            $windspeed = $row['windspeed'];

            //更新设备运行状态
            $last_report = $row["createtime"];
            $timestamp = strtotime($last_report);
            $currenttime = time();
            if ($currenttime > ($timestamp + MFUN_HCU_AQYC_SLEEP_DURATION)) { //如果最后一次测量报告距离现在已经超过休眠间隔门限
                $dev_status = "休眠中";
                $alarm = "false";
            }
            else{
                $dev_status = "运行中";
                $alarm = "false";
            }
            $temp = array(
                'AlarmName'=>"设备状态 ",
                'AlarmEName'=> "AQYC_status",
                'AlarmValue'=>(string)$dev_status,
                'AlarmUnit'=>" ",
                'WarningTarget'=>$alarm
            );
            //将设备运行状态注销，只显示其他6种环境参量
            //array_push($currentvalue,$temp);

            if ($pm25 !== NULL){
                if ($pm25 > MFUN_L3APL_F3DM_TH_ALARM_PM25)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"颗粒物 ",
                    'AlarmEName'=> "AQYC_pm2.5",
                    'AlarmValue'=>(string)$pm25,
                    'AlarmUnit'=>" μg/m3",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }
            else{
                $temp = array(
                    'AlarmName'=>"颗粒物 ",
                    'AlarmEName'=> "AQYC_pm2.5",
                    'AlarmValue'=>"NULL",
                    'AlarmUnit'=>" ",
                    'WarningTarget'=>"true"
                );
                array_push($currentvalue,$temp);
            }


            if ($noise !== NULL){
                if ($noise > MFUN_L3APL_F3DM_TH_ALARM_NOISE)
                    $alarm = "true";
                else
                    $alarm = "false";

                $temp = array(
                    'AlarmName'=>"噪声 ",
                    'AlarmEName'=> "AQYC_noise",
                    'AlarmValue'=>(string)$noise,
                    'AlarmUnit'=>" dB",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }
            else{
                $temp = array(
                    'AlarmName'=>"噪声 ",
                    'AlarmEName'=> "AQYC_noise",
                    'AlarmValue'=> "NULL",
                    'AlarmUnit'=>" ",
                    'WarningTarget'=> "true"
                );
                array_push($currentvalue,$temp);
            }

            if ($windspeed !== NULL){
                if ($windspeed > MFUN_L3APL_F3DM_TH_ALARM_WINDSPD)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"风速 ",
                    'AlarmEName'=> "AQYC_windspeed",
                    'AlarmValue'=>(string)$windspeed,
                    'AlarmUnit'=>" m/s",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }
            else{
                $temp = array(
                    'AlarmName'=>"风速 ",
                    'AlarmEName'=> "AQYC_windspeed",
                    'AlarmValue'=> "NULL",
                    'AlarmUnit'=>" ",
                    'WarningTarget'=> "true"
                );
                array_push($currentvalue,$temp);
            }


            if ($winddir !== NULL){
                $temp = array(
                    'AlarmName'=>"风向 ",
                    'AlarmEName'=> "AQYC_winddir",
                    'AlarmValue'=>$this->dbi_winddir_convert($winddir),
                    'AlarmUnit'=>" ",
                    'WarningTarget'=>"false"
                );
                array_push($currentvalue,$temp);
            }
            else{
                $temp = array(
                    'AlarmName'=>"风向 ",
                    'AlarmEName'=> "AQYC_winddir",
                    'AlarmValue'=> "NULL",
                    'AlarmUnit'=>" ",
                    'WarningTarget'=> "true"
                );
                array_push($currentvalue,$temp);
            }

            if ($humidity !== NULL){
                if ($humidity > MFUN_L3APL_F3DM_TH_ALARM_HUMID)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"湿度 ",
                    'AlarmEName'=> "AQYC_humi",
                    'AlarmValue'=>(string)$humidity,
                    'AlarmUnit'=>" %",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }
            else{
                $temp = array(
                    'AlarmName'=>"湿度 ",
                    'AlarmEName'=> "AQYC_humi",
                    'AlarmValue'=> "NULL",
                    'AlarmUnit'=>" ",
                    'WarningTarget'=> "true"
                );
                array_push($currentvalue,$temp);
            }

            if ($temperature !== NULL){
                if ($temperature > MFUN_L3APL_F3DM_TH_ALARM_TEMP)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"温度 ",
                    'AlarmEName'=> "AQYC_temp",
                    'AlarmValue'=>(string)$temperature,
                    'AlarmUnit'=>" °C",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }
            else{
                $temp = array(
                    'AlarmName'=>"温度 ",
                    'AlarmEName'=> "AQYC_temp",
                    'AlarmValue'=> "NULL",
                    'AlarmUnit'=>" ",
                    'WarningTarget'=> "true"
                );
                array_push($currentvalue,$temp);
            }
        }
        else
            $currentvalue = "";

        $resp = array('StatCode'=>$statCode, 'alarmlist'=>$currentvalue, 'vcr'=>$vcrlist);

        $mysqli->close();
        return $resp;
    }

//UI GetStaticMonitorTable Request, 获取用户聚合数据
    public function dbi_aqyc_user_dataaggregate_req($uid)
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

        //获取授权站点-项目列表
        $auth_list = $this->dbi_user_statproj_inqury($mysqli, $uid);

        array_push($resp["column"], "监测点编号");
        array_push($resp["column"], "监测点名称");
        array_push($resp["column"], "项目单位");
        array_push($resp["column"], "区县");
        array_push($resp["column"], "地址");
        array_push($resp["column"], "负责人");
        array_push($resp["column"], "联系电话");
        array_push($resp["column"], "上次报告时间");
        array_push($resp["column"], "设备状态");
        array_push($resp["column"], "PM2.5");
        array_push($resp["column"], "温度");
        array_push($resp["column"], "湿度");
        array_push($resp["column"], "噪音");
        array_push($resp["column"], "风速");
        array_push($resp["column"], "风向");

        for($i=0; $i<count($auth_list); $i++)
        {
            $one_row = array();
            $pcode = $auth_list[$i]["p_code"];
            $statCode = $auth_list[$i]["stat_code"];
            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statCode'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                array_push($one_row, $statCode);
                array_push($one_row, $row["statname"]);
                array_push($one_row, $row["department"]);
                array_push($one_row, $row["country"]);
                array_push($one_row, $row["address"]);
                array_push($one_row, $row["chargeman"]);
                array_push($one_row, $row["telephone"]);
            }
            $query_str = "SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE `statcode` = '$statCode'";
            $result = $mysqli->query($query_str);
            //初始化返回值，确保数据库没有测试报告的情况下界面返回数据长度不报错
            $pm25 = 0;
            $temperature = 0;
            $humidity = 0;
            $noise = 0;
            $windspeed = 0;
            $winddir = 0;
            $reportTime = "NULL";
            $status = "休眠中";
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                $pm25 =  $row["pm25"];
                $temperature = $row["temperature"];
                $humidity = $row["humidity"];
                $noise = $row["noise"];
                $windspeed = $row["windspeed"];
                $winddir = $this->dbi_winddir_convert($row["winddirection"]);
                $reportTime = $row["createtime"];

                $timestamp = strtotime($reportTime);
                $currenttime = time();
                if ($currenttime > ($timestamp+MFUN_HCU_AQYC_SLEEP_DURATION))  //如果最后一次测量报告距离现在已经超过休眠间隔门限
                    $status = "休眠中";
                else
                    $status = "运行中";
            }
            array_push($one_row, $reportTime);
            array_push($one_row, $status);
            array_push($one_row, $pm25);
            array_push($one_row, $temperature);
            array_push($one_row, $humidity);
            array_push($one_row, $noise);
            array_push($one_row, $windspeed);
            array_push($one_row, $winddir);

            array_push($resp['data'], $one_row);
        }

        $mysqli->close();
        return $resp;
    }


    /*********************************波峰组合秤新增处理************************************************/
    //UI GetStaticMonitorTable Request, 获取用户聚合数据
    public function dbi_bfsc_user_dataaggregate_req($uid)
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

        //获取授权站点-项目列表
        $auth_list = $this->dbi_user_statproj_inqury($mysqli, $uid);

        array_push($resp["column"], "站点编号");
        array_push($resp["column"], "设备编号");
        array_push($resp["column"], "设备状态");
        array_push($resp["column"], "秤_01");
        array_push($resp["column"], "秤_02");
        array_push($resp["column"], "秤_03");
        array_push($resp["column"], "秤_04");
        array_push($resp["column"], "秤_05");
        array_push($resp["column"], "秤_06");
        array_push($resp["column"], "秤_07");
        array_push($resp["column"], "秤_08");
        array_push($resp["column"], "秤_09");
        array_push($resp["column"], "秤_10");
        array_push($resp["column"], "秤_11");
        array_push($resp["column"], "秤_12");

        for($i=0; $i<count($auth_list); $i++)
        {
            $one_row = array();
            $statCode = $auth_list[$i]["stat_code"];

            $query_str = "SELECT * FROM `t_l3f3dm_bfsc_currentreport` WHERE `statcode` = '$statCode'";
            $result = $mysqli->query($query_str);
            //初始化返回值，确保数据库没有测试报告的情况下界面返回数据长度不报错
            $status = "休眠中";
            $w01 = 0;
            $w02 = 0;
            $w03 = 0;
            $w04 = 0;
            $w05 = 0;
            $w06 = 0;
            $w07 = 0;
            $w08 = 0;
            $w09 = 0;
            $w10 = 0;
            $w11 = 0;
            $w12 = 0;
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                $devcode = $row["devcode"];
                array_push($one_row, $statCode);
                array_push($one_row, $devcode);
                //更新设备运行状态
                $timestamp = strtotime($row["createtime"]);
                $currenttime = time();
                if ($currenttime > ($timestamp+180))  //如果最后一次测量报告距离现在已经超过3分钟
                    $status = "休眠中";
                else
                    $status = "运行中";

                $w01 = $row["weight_01"];
                $w02 = $row["weight_02"];
                $w03 = $row["weight_03"];
                $w04 = $row["weight_04"];
                $w05 = $row["weight_05"];
                $w06 = $row["weight_06"];
                $w07 = $row["weight_07"];
                $w08 = $row["weight_08"];
                $w09 = $row["weight_09"];
                $w10 = $row["weight_10"];
                $w11 = $row["weight_11"];
                $w12 = $row["weight_12"];
            }
            array_push($one_row, $status);
            array_push($one_row, $w01);
            array_push($one_row, $w02);
            array_push($one_row, $w03);
            array_push($one_row, $w04);
            array_push($one_row, $w05);
            array_push($one_row, $w06);
            array_push($one_row, $w07);
            array_push($one_row, $w08);
            array_push($one_row, $w09);
            array_push($one_row, $w10);
            array_push($one_row, $w11);
            array_push($one_row, $w12);
            array_push($resp['data'], $one_row);
        }

        $mysqli->close();
        return $resp;
    }

    /*********************************智能云锁新增处理************************************************/

    //UI GetStaticMonitorTable Request, 获取用户聚合数据
    public function dbi_fhys_user_dataaggregate_req($uid)
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

        //获取授权站点-项目列表
        $auth_list = $this->dbi_user_statproj_inqury($mysqli, $uid);

        array_push($resp["column"], "站点编号");
        array_push($resp["column"], "站点名称");
        array_push($resp["column"], "区县");
        array_push($resp["column"], "地址");
        array_push($resp["column"], "负责人");
        array_push($resp["column"], "联系电话");
        array_push($resp["column"], "设备状态");
        array_push($resp["column"], "上次报告时间");
        array_push($resp["column"], "门锁-1状态");
        array_push($resp["column"], "门锁-2状态");
        //array_push($resp["column"], "门锁-3状态");
        //array_push($resp["column"], "门锁-4状态");
        array_push($resp["column"], "信号强度");
        array_push($resp["column"], "剩余电量");
        array_push($resp["column"], "温度");
        array_push($resp["column"], "湿度");
        array_push($resp["column"], "震动告警");
        array_push($resp["column"], "倾斜告警");
        array_push($resp["column"], "水浸告警");

        for($i=0; $i<count($auth_list); $i++)
        {
            $one_row = array();
            $statCode = $auth_list[$i]["stat_code"];
            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statCode'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                array_push($one_row, $statCode);
                array_push($one_row, $row["statname"]);
                array_push($one_row, $row["country"]);
                array_push($one_row, $row["address"]);
                array_push($one_row, $row["chargeman"]);
                array_push($one_row, $row["telephone"]);
            }
            $query_str = "SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE `statcode` = '$statCode'";
            $result = $mysqli->query($query_str);
            //初始化返回值，确保数据库没有测试报告的情况下界面返回数据长度不报错
            $dev_status = "状态未知";
            $doorlock_1 = "状态未知";
            $doorlock_2 = "状态未知";
            //$doorlock_3 = "状态未知";
            //$doorlock_4 = "状态未知";
            $batt_level = "0%";
            $vibr_alarm = "未知";
            $water_alarm = "未知";
            $fall_alarm = "未知";
            $temperature = "0";
            $humidity = "0%";

            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                //更新设备运行状态
                $last_report = $row["createtime"];
                $timestamp = strtotime($last_report);
                $currenttime = time();
                if ($currenttime > ($timestamp + MFUN_HCU_FHYS_SLEEP_DURATION))  //如果最后一次测量报告距离现在已经超过休眠间隔门限
                    $dev_status = "休眠中";
                else
                    $dev_status = "运行中";

                //门锁-1运行状态
                if($row["lock_1"] == HUITP_IEID_UNI_LOCK_STATE_OPEN AND $row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_OPEN){
                    $doorlock_1 = "门锁打开";
                }
                elseif($row["lock_1"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE){
                    $doorlock_1 = "门锁关闭";
                }
                elseif($row["lock_1"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_ALARM){
                    $doorlock_1 = "暴力开门";
                }
                elseif($row["lock_1"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_OPEN){
                    $doorlock_1 = "锁关门开";
                }
                elseif($row["lock_1"] == HUITP_IEID_UNI_LOCK_STATE_OPEN AND $row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE){
                    $doorlock_1 = "锁开门关";
                }
                else{
                    $doorlock_1 = "状态异常";
                }
                if($row["lock_1"] == HUITP_IEID_UNI_LOCK_STATE_NULL AND $row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_NULL){
                    $doorlock_1 = "未安装";
                }

                //门锁-2运行状态
                if($row["lock_2"] == HUITP_IEID_UNI_LOCK_STATE_OPEN AND $row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_OPEN){
                    $doorlock_2 = "门锁打开";
                }
                elseif($row["lock_2"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE){
                    $doorlock_2 = "门锁关闭";
                }
                elseif($row["lock_2"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_ALARM){
                    $doorlock_2 = "暴力开门";
                }
                elseif($row["lock_2"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_OPEN){
                    $doorlock_2 = "锁关门开";
                }
                elseif($row["lock_2"] == HUITP_IEID_UNI_LOCK_STATE_OPEN AND $row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE){
                    $doorlock_2 = "锁开门关";
                }
                else{
                    $doorlock_2 = "状态异常";
                }
                if($row["lock_2"] == HUITP_IEID_UNI_LOCK_STATE_NULL AND $row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_NULL){
                    $doorlock_2 = "未安装";
                }

/*                //门锁-3运行状态
                if($row["lock_3"] == HUITP_IEID_UNI_LOCK_STATE_OPEN AND $row["door_3"] == HUITP_IEID_UNI_DOOR_STATE_OPEN){
                    $doorlock_3 = "门锁打开";
                }
                elseif($row["lock_3"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_3"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE){
                    $doorlock_3 = "门锁关闭";
                }
                elseif($row["lock_3"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_3"] == HUITP_IEID_UNI_DOOR_STATE_ALARM){
                    $doorlock_3 = "暴力开门";
                }
                elseif($row["lock_3"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_3"] == HUITP_IEID_UNI_DOOR_STATE_OPEN){
                    $doorlock_3 = "锁关门开";
                }
                elseif($row["lock_3"] == HUITP_IEID_UNI_LOCK_STATE_OPEN AND $row["door_3"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE){
                    $doorlock_3 = "锁开门关";
                }
                elseif($row["lock_3"] == HUITP_IEID_UNI_LOCK_STATE_OPEN AND $row["door_3"] == HUITP_IEID_UNI_DOOR_STATE_INVALID){
                    $doorlock_3 = "状态异常";
                }
                else{
                    $doorlock_3 = "状态未知";
                }

                //门锁-4运行状态
                if($row["lock_4"] == HUITP_IEID_UNI_LOCK_STATE_OPEN AND $row["door_4"] == HUITP_IEID_UNI_DOOR_STATE_OPEN){
                    $doorlock_4 = "门锁打开";
                }
                elseif($row["lock_4"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_4"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE){
                    $doorlock_4 = "门锁关闭";
                }
                elseif($row["lock_4"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_4"] == HUITP_IEID_UNI_DOOR_STATE_ALARM){
                    $doorlock_4 = "暴力开门";
                }
                elseif($row["lock_4"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_4"] == HUITP_IEID_UNI_DOOR_STATE_OPEN){
                    $doorlock_4 = "锁关门开";
                }
                elseif($row["lock_4"] == HUITP_IEID_UNI_LOCK_STATE_OPEN AND $row["door_4"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE){
                    $doorlock_4 = "锁开门关";
                }
                elseif($row["lock_4"] == HUITP_IEID_UNI_LOCK_STATE_OPEN AND $row["door_4"] == HUITP_IEID_UNI_DOOR_STATE_INVALID){
                    $doorlock_4 = "状态异常";
                }
                else{
                    $doorlock_4 = "状态未知";
                }
*/
                //更新GPRS信号强度
                $sig_level = intval($row["rssivalue"]);
                if ($sig_level < MFUN_L3APL_F3DM_TH_ALARM_GPRS_LOW)
                    $gprs = "较差";
                elseif (($sig_level >= MFUN_L3APL_F3DM_TH_ALARM_GPRS_LOW) AND ($sig_level <= MFUN_L3APL_F3DM_TH_ALARM_GPRS_HIGH))
                    $gprs = "一般";
                else
                    $gprs = "良好";

                //更新电池剩余电量
                if($row["battvalue"] < 100)
                    $batt_level = (string)($row["battvalue"])."%";
                else
                    $batt_level = "100%";
                //更新温度,
                $temperature = (string)($row["tempvalue"]);
                //更新湿度
                $humidity = (string)($row["humidvalue"]). "%";
                //更新震动告警状态
                if($row["shakestate"] == HUITP_IEID_UNI_SHAKE_STATE_ACTIVE)
                    $vibr_alarm = "有";
                elseif($row["shakestate"] == HUITP_IEID_UNI_SHAKE_STATE_DEACTIVE)
                    $vibr_alarm = "无";
                //更新水浸告警状态
                if($row["waterstate"] == HUITP_IEID_UNI_WATER_STATE_ACTIVE)
                    $water_alarm = "有";
                elseif($row["waterstate"] == HUITP_IEID_UNI_WATER_STATE_DEACTIVE)
                    $water_alarm = "无";
                //更新倾斜告警状态
                if($row["fallstate"] == HUITP_IEID_UNI_FALL_STATE_ACTIVE)
                    $fall_alarm = "有";
                elseif($row["fallstate"] == HUITP_IEID_UNI_FALL_STATE_DEACTIVE)
                    $fall_alarm = "无";
            }
            array_push($one_row, $dev_status);
            array_push($one_row, $last_report);
            array_push($one_row, $doorlock_1);
            array_push($one_row, $doorlock_2);
            //array_push($one_row, $doorlock_3);
            //array_push($one_row, $doorlock_4);
            array_push($one_row, $gprs);
            array_push($one_row, $batt_level);
            array_push($one_row, $temperature);
            array_push($one_row, $humidity);
            array_push($one_row, $vibr_alarm);
            array_push($one_row, $fall_alarm);
            array_push($one_row, $water_alarm);

            array_push($resp['data'], $one_row);
        }

        $mysqli->close();
        return $resp;
    }

    //UI DevAlarm Request, 获取当前的测量值，如果测量值超出范围，提示告警
    public function dbi_fhys_dev_currentvalue_req($statCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $vcrname = array();
        $vcrlink = array();
        $vcrlist = array();
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `statcode` = '$statCode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            array_push($vcrname,"RTSP");
            array_push($vcrname,"CAMCTRL");
            $rtsp = $row['videourl'];
            $cam_ctrl = $row['camctrl'];
            array_push($vcrlink,$rtsp);
            array_push($vcrlink,$cam_ctrl);
            $vcrlist = array('vcrname'=>$vcrname, 'vcraddress'=>$vcrlink);
        }

        $query_str = "SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE `statcode` = '$statCode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            //更新温度
            $temperature = $row["tempvalue"];
            //更新湿度
            $humidity = $row["humidvalue"];
            //剩余电量
            $battlevel = $row['battvalue'];
            //RSSI
            $siglevel = $row['rssivalue'];

            $currentvalue = array();
            //更新集中器设备运行状态
            $timestamp = strtotime($row["createtime"]);
            $currenttime = time();
            if ($currenttime > ($timestamp+180))  //如果最后一次测量报告距离现在已经超过3分钟
            {
                $devstat = "休眠中";
                $alarm = "true";
            } else {
                $devstat = "运行中";
                $alarm = "false";
            }
            $temp = array(
                        'AlarmName'=> "设备状态：",
                        'AlarmEName'=> "FHYS_fibbox",
                        'AlarmValue'=> $devstat,
                        'AlarmUnit'=> "",
                        'WarningTarget'=>$alarm);
            array_push($currentvalue,$temp);

            //更新门锁-1运行状态
            if($row["lock_1"] == HUITP_IEID_UNI_LOCK_STATE_OPEN AND $row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_OPEN){
                $doorlock_1_status = "门锁打开";
                $doorlock_1_alarm = "false";
                $doorlock_1_picname = "FHYS_locko";
            }
            elseif($row["lock_1"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE){
                $doorlock_1_status = "门锁关闭";
                $doorlock_1_alarm = "false";
                $doorlock_1_picname = "FHYS_lockc";
            }
            elseif($row["lock_1"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_ALARM){
                $doorlock_1_status = "暴力开门";
                $doorlock_1_alarm = "true";
                $doorlock_1_picname = "FHYS_door";
            }
            elseif($row["lock_1"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_OPEN){
                $doorlock_1_status = "锁关门开";
                $doorlock_1_alarm = "false";
                $doorlock_1_picname = "FHYS_lockc";
            }
            elseif($row["lock_1"] == HUITP_IEID_UNI_LOCK_STATE_OPEN AND $row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE){
                $doorlock_1_status = "锁开门关";
                $doorlock_1_alarm = "false";
                $doorlock_1_picname = "FHYS_locko";
            }
            else{
                $doorlock_1_status = "状态异常";
                $doorlock_1_alarm = "true";
                $doorlock_1_picname = "FHYS_locko";
            }
            if ($row["lock_1"] == HUITP_IEID_UNI_LOCK_STATE_NULL OR $row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_NULL) {
                $doorlock_1_status = "未安装";
                $doorlock_1_alarm = "true";
                $doorlock_1_picname = "FHYS_lockc";
            }

            $temp = array(
                'AlarmName'=> "门锁-1 状态：",
                'AlarmEName'=> (string)$doorlock_1_picname,
                'AlarmValue'=> (string)$doorlock_1_status,
                'AlarmUnit'=> "",
                'WarningTarget'=>$doorlock_1_alarm);
            array_push($currentvalue,$temp);

            //更新门锁-2运行状态
            if($row["lock_2"] == HUITP_IEID_UNI_LOCK_STATE_OPEN AND $row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_OPEN){
                $doorlock_2_status = "门锁打开";
                $doorlock_2_alarm = "false";
                $doorlock_2_picname = "FHYS_locko";
            }
            elseif($row["lock_2"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE){
                $doorlock_2_status = "门锁关闭";
                $doorlock_2_alarm = "false";
                $doorlock_2_picname = "FHYS_lockc";
            }
            elseif($row["lock_2"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_ALARM){
                $doorlock_2_status = "暴力开门";
                $doorlock_2_alarm = "true";
                $doorlock_2_picname = "FHYS_door";
            }
            elseif($row["lock_2"] == HUITP_IEID_UNI_LOCK_STATE_CLOSE AND $row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_OPEN){
                $doorlock_2_status = "锁关门开";
                $doorlock_2_alarm = "false";
                $doorlock_2_picname = "FHYS_lockc";
            }
            elseif($row["lock_2"] == HUITP_IEID_UNI_LOCK_STATE_OPEN AND $row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE){
                $doorlock_2_status = "锁开门关";
                $doorlock_2_alarm = "false";
                $doorlock_2_picname = "FHYS_locko";
            }
            else{
                $doorlock_2_status = "状态异常";
                $doorlock_2_alarm = "true";
                $doorlock_2_picname = "FHYS_locko";
            }
            if($row["lock_2"] == HUITP_IEID_UNI_LOCK_STATE_NULL OR $row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_NULL){
                $doorlock_2_status = "未安装";
                $doorlock_2_alarm = "true";
                $doorlock_2_picname = "FHYS_lockc";
            }

            $temp = array(
                'AlarmName'=> "门锁-2 状态：",
                'AlarmEName'=> (string)$doorlock_2_picname,
                'AlarmValue'=> (string)$doorlock_2_status,
                'AlarmUnit'=> "",
                'WarningTarget'=>$doorlock_2_alarm);
            array_push($currentvalue,$temp);

            //更新GPRS信号强度
            if ($siglevel != NULL){
                if ($siglevel < MFUN_L3APL_F3DM_TH_ALARM_GPRS_LOW){
                    $gprs = "较差";
                    $alarm = "true";
                }
                elseif (($siglevel >= MFUN_L3APL_F3DM_TH_ALARM_GPRS_LOW) AND ($siglevel <= MFUN_L3APL_F3DM_TH_ALARM_GPRS_HIGH)){
                    $gprs = "一般";
                    $alarm = "false";
                }
                else{
                    $gprs = "良好";
                    $alarm = "false";
                }

                $temp = array(
                            'AlarmName'=>"信号强度：",
                            'AlarmEName'=> "FHYS_sig",
                            'AlarmValue'=>(string)$gprs,
                            'AlarmUnit'=>"",
                            'WarningTarget'=>$alarm);
            }
            else{ //防止数据缺失，保持界面显示完整性
                $temp = array(
                    'AlarmName'=>"信号强度：",
                    'AlarmEName'=> "FHYS_sig",
                    'AlarmValue'=>"NULL",
                    'AlarmUnit'=>"",
                    'WarningTarget'=>"false");
            }
            array_push($currentvalue,$temp);

            //更新电池剩余电量
            if ($battlevel != NULL){
                if ($battlevel < MFUN_L3APL_F3DM_TH_ALARM_BATT)
                    $alarm = "true";
                else
                    $alarm = "false";
                if ($battlevel > 100) $battlevel = 100;

                $temp = array(
                            'AlarmName'=>"剩余电量：",
                            'AlarmEName'=> "FHYS_batt",
                            'AlarmValue'=>(string)($battlevel),
                            'AlarmUnit'=>" %",
                            'WarningTarget'=>$alarm);
            }
            else{ //防止数据缺失，保持界面显示完整性
                $temp = array(
                    'AlarmName'=>"剩余电量：",
                    'AlarmEName'=> "FHYS_batt",
                    'AlarmValue'=> "NULL",
                    'AlarmUnit'=>"",
                    'WarningTarget'=>"false");
            }
            array_push($currentvalue,$temp);

            //更新温度
            if ($temperature != NULL) {
                if ($temperature > MFUN_L3APL_F3DM_TH_ALARM_TEMP)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName' => "温度：",
                    'AlarmEName' => "FHYS_temp",
                    'AlarmValue' => (string)$temperature,
                    'AlarmUnit' => " °C",
                    'WarningTarget' => $alarm );
            }
            else{ //防止数据缺失，保持界面显示完整性
                $temp = array(
                    'AlarmName' => "温度：",
                    'AlarmEName' => "FHYS_temp",
                    'AlarmValue' => "NULL",
                    'AlarmUnit' => "",
                    'WarningTarget' => "false" );
            }
            array_push($currentvalue, $temp);

            //更新湿度
            if ($humidity != NULL){
                if ($humidity > MFUN_L3APL_F3DM_TH_ALARM_HUMID)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"湿度：",
                    'AlarmEName'=> "FHYS_humi",
                    'AlarmValue'=>(string)$humidity,
                    'AlarmUnit'=>" %",
                    'WarningTarget'=>$alarm);
            }
            else{ //防止数据缺失，保持界面显示完整性
                $temp = array(
                    'AlarmName'=>"湿度：",
                    'AlarmEName'=> "FHYS_humi",
                    'AlarmValue'=>"NULL",
                    'AlarmUnit'=>"",
                    'WarningTarget'=>"false");
            }
            array_push($currentvalue,$temp);

            //更新震动告警状态
            if($row["shakestate"] == HUITP_IEID_UNI_SHAKE_STATE_ACTIVE){
                $vibralarm = "有";
                $alarm = "true";
            }
            elseif($row["shakestate"] == HUITP_IEID_UNI_SHAKE_STATE_DEACTIVE){
                $vibralarm = "无";
                $alarm = "false";
            }
            else{
                $vibralarm = "状态未知";
                $alarm = "true";
            }
            $temp = array(
                        'AlarmName'=>"震动告警：",
                        'AlarmEName'=> "FHYS_vibr",
                        'AlarmValue'=>(string)$vibralarm,
                        'AlarmUnit'=>"",
                        'WarningTarget'=>$alarm );
            array_push($currentvalue,$temp);

            //更新水浸告警状态
            if($row["waterstate"] == HUITP_IEID_UNI_WATER_STATE_ACTIVE){
                $wateralarm = "有";
                $alarm = "true";
            }
            elseif($row["waterstate"] == HUITP_IEID_UNI_WATER_STATE_DEACTIVE){
                $wateralarm = "无";
                $alarm = "false";
            }
            else{
                $wateralarm = "未知";
                $alarm = "true";
            }
            $temp = array(
                'AlarmName'=>"水浸告警：",
                'AlarmEName'=> "FHYS_water",
                'AlarmValue'=>(string)$wateralarm,
                'AlarmUnit'=>"",
                'WarningTarget'=>$alarm );
            array_push($currentvalue,$temp);

            //更新倾斜告警状态
            if($row["fallstate"] == HUITP_IEID_UNI_FALL_STATE_ACTIVE){
                $fallalarm = "有";
                $alarm = "true";
            }
            elseif($row["fallstate"] == HUITP_IEID_UNI_FALL_STATE_DEACTIVE){
                $fallalarm = "无";
                $alarm = "false";
            }
            else{
                $fallalarm = "未知";
                $alarm = "true";
            }
            $temp = array(
                'AlarmName'=>"倾斜告警：",
                'AlarmEName'=> "FHYS_smok",
                'AlarmValue'=>(string)$fallalarm,
                'AlarmUnit'=>"",
                'WarningTarget'=>$alarm );
            array_push($currentvalue,$temp);
        }
        else
            $currentvalue = "";

        $resp = array('StatCode'=>$statCode, 'alarmlist'=>$currentvalue, 'vcr'=>$vcrlist);

        $mysqli->close();
        return $resp;
    }

    public function dbi_key_event_history_process($projCode,$duration,$keyWord)
    {
        //初始化返回值
        $history["ColumnName"] = array();
        $history['TableData'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        array_push($history["ColumnName"], "序号");
        //array_push($history["ColumnName"], "工单号");
        array_push($history["ColumnName"], "站点名称");
        array_push($history["ColumnName"], "事件时间");
        array_push($history["ColumnName"], "事件类型");
        array_push($history["ColumnName"], "钥匙编号");
        array_push($history["ColumnName"], "钥匙名称");
        array_push($history["ColumnName"], "使用者工号");
        array_push($history["ColumnName"], "使用者姓名");

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
            $statname = $row['statname'];
            $query_str = "SELECT * FROM `t_l3fxprcm_fhys_locklog` WHERE (`statcode` = '$statCode' AND (concat(`keyname`,`keyusername`) like '%$keyWord%'))";
            $resp = $mysqli->query($query_str);
            while (($resp != false) && (($resp_row = $resp->fetch_array()) > 0)){
                $sid = $resp_row['sid'];
                $woid = $resp_row['woid'];
                $keyid = $resp_row['keyid'];
                $keyname = $resp_row['keyname'];
                $keyuserid = $resp_row['keyuserid'];
                $keyusername = $resp_row['keyusername'];
                $eventtype = $resp_row['eventtype'];
                $eventtime = $resp_row['createtime'];

                $dateintval = intval(date('Ymd',strtotime($eventtime)));
                if($dateintval < $start OR $dateintval > $end) continue; //如果不在查询时间范围内，直接跳过

                if ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_RFID)
                    $eventtype = "RFID开锁";
                elseif ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_BLE)
                    $eventtype = "蓝牙开锁";
                elseif ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_USER)
                    $eventtype = "用户账号开锁";
                elseif ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_IDCARD)
                    $eventtype = "身份证开锁";
                elseif ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_WECHAT)
                    $eventtype = "微信开锁";
                elseif ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_PHONE)
                    $eventtype = "电话号码开锁";
                elseif ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_XJ)
                    $eventtype = "巡检事件";
                elseif ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_ALARM)
                    $eventtype = "未授权开锁";
                else
                    $eventtype = "未知事件";

                $temp = array();
                array_push($temp, $sid);
                array_push($temp, $statname);
                array_push($temp, $eventtime);
                array_push($temp, $eventtype);
                //array_push($temp, $woid);
                array_push($temp, $keyid);
                array_push($temp, $keyname);
                array_push($temp, $keyuserid);
                array_push($temp, $keyusername);

                array_push($history['TableData'], $temp);
            }
        }

        $mysqli->close();
        return $history;
    }

    public function dbi_door_open_picture_process($enventid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3fxprcm_fhys_locklog` WHERE `sid` = '$enventid' ";
        $result = $mysqli->query($query_str);

        $pic_result = array();
        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $file_name = $row['picname'];
            $statCode = $row['statcode'];
            if(!empty($file_name)){
                $file_url = MFUN_HCU_SITE_PIC_WWW_PATH.$statCode.'/'.$file_name;
                $pic_result = array(
                    'ifpicture' => 'true',
                    'picture' => $file_url
                );
            }
            else{
                $pic_result = array(
                    'ifpicture' => 'false',
                    'picture' => ''
                );
            }
        }

        $mysqli->close();
        return $pic_result;
    }

    public function dbi_point_install_picture_process($statCode)
    {
        $pic_list = array();
        $path = MFUN_HCU_FHYS_PIC_ABS_FOLDER.$statCode;
        if(!file_exists($path)) return $pic_list;
        foreach(glob($path."/*".MFUN_HCU_SITE_PIC_FILE_TYPE) as $afile) {
            if (is_dir($afile)) { //如果是目录
                //do nothing;
            }
            else{
                //获取的文件名含有路径信息，需要进行字符串截取操作，提取纯文件名
                $str_arr = explode("/", $afile);
                $file_name = $str_arr[count($str_arr)-1];

                $file_url = MFUN_HCU_FHYS_PIC_WWW_FOLDER.$statCode.'/'.$file_name;
                $temp = array(
                    'name' => $file_name,
                    'url' => $file_url
                );
                array_push($pic_list, $temp);
            }
        }

        return $pic_list;
    }
}

?>