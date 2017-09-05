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
    //构造函数
    public function __construct()
    {

    }

    //查询用户授权的stat_code和proj_code list
    public function dbi_user_statproj_inqury($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //查询该用户授权的项目和项目组列表
        $query_str = "SELECT `auth_code` FROM `t_l3f1sym_authlist` WHERE `uid` = '$uid'";
        $result = $mysqli->query($query_str);
        $p_list = array();
        $pg_list = array();
        while($row = $result->fetch_array())
        {
            $temp = $row["auth_code"];
            $fromat = substr($temp, 0, MFUN_L3APL_F2CM_CODE_FORMAT_LEN);
            if($fromat == MFUN_L3APL_F2CM_PROJ_CODE_PREFIX)
                array_push($p_list,$temp);
            elseif ($fromat == MFUN_L3APL_F2CM_PG_CODE_PREFIX)
                array_push($pg_list,$temp);
        }

        //把授权的项目组列表里对应的项目号也取出来追加到项目列表，获得该用户授权的完整项目列表
        for($i=0; $i<count($pg_list); $i++)
        {
            $query_str = "SELECT `p_code` FROM `t_l3f2cm_projinfo` WHERE `pg_code` = '$pg_list[$i]'";
            $result = $mysqli->query($query_str);
            while($row = $result->fetch_array())
            {
                $temp = $row["p_code"];
                array_push($p_list,$temp);
            }
        }

        //查询授权项目号下对应的所有监测点code
        $auth_list["p_code"] = array();
        $auth_list["stat_code"] = array();
        for($i=0; $i<count($p_list); $i++)
        {
            $query_str = "SELECT `statcode` FROM `t_l3f3dm_siteinfo` WHERE `p_code` = '$p_list[$i]'";
            $result = $mysqli->query($query_str);
            while($row = $result->fetch_array())
            {
                $temp = $row["statcode"];
                array_push($auth_list["stat_code"] ,$temp);
                array_push($auth_list["p_code"] ,$p_list[$i]);
            }
        }

        $mysqli->close();
        return $auth_list;
    }

    //查询该站点是否正处于告警状态
    private function dbi_site_alarm_check($statcode)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE `statcode` = '$statcode'");
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
        if(($pm25>MFUN_L3APL_F3DM_TH_ALARM_PM25) OR ($noise)>MFUN_L3APL_F3DM_TH_ALARM_NOISE OR ($temperature)>MFUN_L3APL_F3DM_TH_ALARM_TEMP )
            $resp = true;
        else
            $resp = false;

        $mysqli->close();
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

        $auth_list["stat_code"] = array();
        $auth_list["p_code"] = array();
        $auth_list = $this->dbi_user_statproj_inqury($uid);

        $sitelist = array();
        for($i=0; $i<count($auth_list["stat_code"]); $i++)
        {
            $statcode = $auth_list['stat_code'][$i];

            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";      //查询监测点对应的项目号
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0) {
                $alarm_check = $this->dbi_site_alarm_check($statcode);
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

    public function dbi_alarm_data_save($sid, $alarmdesc)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l3f5fm_aqyc_alarmdata` WHERE (`sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l3f5fm_aqyc_alarmdata` SET  `alarmdesc` = '$alarmdesc' WHERE (`sid` = '$sid')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l3f5fm_aqyc_alarmdata` (sid, alarmdesc) VALUES ('$sid', '$alarmdesc')");
        }
        $mysqli->close();
        return $result;
    }

    //删除对应用户所有超过90天的数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    public function dbi_alarm_data_3mondel($sid, $days)
    {
        if ($days <90) $days = 90;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("DELETE FROM `t_l3f5fm_aqyc_alarmdata` WHERE ((`sid` = '$sid') AND (TO_DAYS(NOW()) - TO_DAYS(`date`) > '$days'))");
        $mysqli->close();
        return $result;
    }

    public function dbi_alarm_data_inqury($sid)
    {
        $LatestValue = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l3f5fm_aqyc_alarmdata` WHERE `sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $LatestValue = $row['alarmdesc'];
        }
        $mysqli->close();
        return $LatestValue;
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

    public function dbi_aqyc_current_alarmtable_req($uid)
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
        $auth_list = $this->dbi_user_statproj_inqury($uid);

        array_push($resp["column"], "监测点编号");
        array_push($resp["column"], "监测点名称");
        array_push($resp["column"], "项目单位");
        array_push($resp["column"], "区县");
        array_push($resp["column"], "地址");
        array_push($resp["column"], "负责人");
        array_push($resp["column"], "联系电话");
        array_push($resp["column"], "PM2.5");
        array_push($resp["column"], "温度");
        array_push($resp["column"], "湿度");
        array_push($resp["column"], "噪音");
        array_push($resp["column"], "风速");
        array_push($resp["column"], "风向");
        array_push($resp["column"], "设备状态");

        for($i=0; $i<count($auth_list["stat_code"]); $i++)
        {
            $one_row = array();
            $pcode = $auth_list["p_code"][$i];
            $statcode = $auth_list["stat_code"][$i];
            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                array_push($one_row, $statcode);
                array_push($one_row, $row["statname"]);
                array_push($one_row, $row["department"]);
                array_push($one_row, $row["country"]);
                array_push($one_row, $row["address"]);
                array_push($one_row, $row["chargeman"]);
                array_push($one_row, $row["telephone"]);
            }
            $query_str = "SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);
            //初始化返回值，确保数据库没有测试报告的情况下界面返回数据长度不报错
            $pm25 = 0;
            $temperature = 0;
            $humidity = 0;
            $noise = 0;
            $windspeed = 0;
            $winddir = 0;
            $status = "停止";
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                $pm25 =  $row["pm25"]/10;
                $temperature = $row["temperature"]/10;
                $humidity = $row["humidity"]/10;
                $noise = $row["noise"]/100;
                $windspeed = $row["windspeed"]/10;
                $winddir = $row["winddirection"];

                $timestamp = strtotime($row["createtime"]);
                $currenttime = time();
                if ($currenttime > ($timestamp+180))  //如果最后一次测量报告距离现在已经超过3分钟
                    $status = "停止";
                else
                    $status = "运行";
            }
            array_push($one_row, $pm25);
            array_push($one_row, $temperature);
            array_push($one_row, $humidity);
            array_push($one_row, $noise);
            array_push($one_row, $windspeed);
            array_push($one_row, $winddir);
            array_push($one_row, $status);

            array_push($resp['data'], $one_row);
        }

        $mysqli->close();
        return $resp;
    }

    public function dbi_fhys_alarm_handle_table_req($uid)
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
        $auth_list = $this->dbi_user_statproj_inqury($uid);

        array_push($resp["column"], "站点编号");
        array_push($resp["column"], "处理状态");
        array_push($resp["column"], "站点名称");
        array_push($resp["column"], "区县");
        array_push($resp["column"], "地址");
        array_push($resp["column"], "负责人");
        array_push($resp["column"], "联系电话");
        array_push($resp["column"], "告警级别");
        array_push($resp["column"], "告警描述");
        array_push($resp["column"], "告警产生时间");
        array_push($resp["column"], "告警关闭时间");
        array_push($resp["column"], "告警处理");

        //初始化返回值，确保数据库查询不到的情况下界面返回数据长度不报错
        $statcode = "";
        $statname = "";
        $country = "";
        $address = "";
        $chargeman = "";
        $telephone = "";
        $alarmflag = "";
        $alarmseverity = "";
        $alarmdescription = "";
        $tsgen = "";
        $tsclose = "";
        $alarmproc = "";


        $objFhysAlarm = new classConstFhysEngpar();
        for($i=0; $i<count($auth_list["stat_code"]); $i++)
        {
            $statcode = $auth_list["stat_code"][$i];
            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                $statname = $row["statname"];
                $country = $row["country"];
                $address = $row["address"];
                $chargeman = $row["chargeman"];
                $telephone = $row["telephone"];
            }
            $alarmflag = MFUN_HCU_FHYS_ALARM_PROC_FLAG_C;
            $query_str = "SELECT * FROM `t_l3f5fm_fhys_alarmdata` WHERE (`statcode` = '$statcode' AND `alarmflag` != '$alarmflag')"; //授权站点中尚未关闭的告警
            $result = $mysqli->query($query_str);
            while($row = $result->fetch_array())
            {
                $one_row = array();
                $alarmflag = $row["alarmflag"];
                $alarmseverity = $row["alarmseverity"];
                $alarmcode = intval($row["alarmcode"]) ;
                $alarmdescription = $objFhysAlarm->mfun_hcu_fhys_getAlarmDescription($alarmcode);
                $tsgen = $row["tsgen"];
                $tsclose = $row["tsclose"];
                $alarmproc = $row["alarmproc"];

                array_push($one_row, $statcode);
                array_push($one_row, $alarmflag);
                array_push($one_row, $statname);
                array_push($one_row, $country);
                array_push($one_row, $address);
                array_push($one_row, $chargeman);
                array_push($one_row, $telephone);
                array_push($one_row, $alarmseverity);
                array_push($one_row, $alarmdescription);
                array_push($one_row, $tsgen);
                array_push($one_row, $tsclose);
                array_push($one_row, $alarmproc);

                array_push($resp['data'], $one_row);
            }
        }

        $mysqli->close();
        return $resp;
    }

    public function dbi_fhys_alarm_handle_process($statcode,$mobile,$action)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $timestamp = time();
        $alarmproc = "";

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows) > 0) {
            $row = $result->fetch_array();
            $statname = $row["statname"];
            //LEXIN短信平台
            //$url = MFUN_HCU_FHYS_LEXIN_URL.MFUN_HCU_FHYS_LEXIN_ACCNAME."&".MFUN_HCU_FHYS_LEXIN_ACCPWD."&aimcodes=".trim($mobile).
            //    "&content=".trim($action).MFUN_HCU_FHYS_LEXIN_SIGNATURE."&bizId=".$timestamp."&dataType=string";

            //CMCC短信平台
            //http://api.sms.heclouds.com/tempsmsSend?sicode=a2bb3546a41649a29e2fcb635e091dd5&mobiles=13917334681&tempid=10003&name=foha
            $url = MFUN_HCU_FHYS_CMCC_URL.'?sicode='.MFUN_HCU_FHYS_CMCC_SICODE.'&mobiles='.trim($mobile).
                '&tempid='.MFUN_HCU_FHYS_CMCC_TEMPCODE_ALARM.'&name='.$statname.'&action='.$action;
            $l2sdkIotWxObj = new classTaskL2sdkIotWx();
            $resp =$l2sdkIotWxObj->https_request($url);

            $currenttime = date("Y-m-d H:i:s",$timestamp);
            $alarmflag = MFUN_HCU_FHYS_ALARM_PROC_FLAG_Y;
            $alarmproc = $currenttime . ":发送信息（".$action."）到手机".$mobile;
            $query_str = "UPDATE `t_l3f5fm_fhys_alarmdata` SET `alarmflag` = '$alarmflag', `alarmproc` = '$alarmproc' WHERE (`statcode` = '$statcode')";
            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $alarmproc;
    }

    public function dbi_fhys_alarm_close_process($uid,$statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $timestamp = time();
        $currenttime = date("Y-m-d H:i:s",$timestamp);
        $closeflag = MFUN_HCU_FHYS_ALARM_PROC_FLAG_C;
        $alarmproc = $currenttime . ":操作员（".$uid."）关闭告警";
        $query_str = "UPDATE `t_l3f5fm_fhys_alarmdata` SET `alarmflag` = '$closeflag', `alarmproc` = '$alarmproc', `tsclose` = '$currenttime' WHERE (`statcode` = '$statcode' AND `alarmflag` != '$closeflag')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }


}

?>