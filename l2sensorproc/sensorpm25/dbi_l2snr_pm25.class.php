<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/1/2
 * Time: 16:03
 */
//include_once "../../l1comvm/vmlayer.php";

/*
-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_pm25data`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_pm25data` (
  `sid` int(4) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `pm01` float NOT NULL,
  `pm25` float NOT NULL,
  `pm10` float NOT NULL,
  `dataflag` char(1) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l2snr_pm25data`
--
ALTER TABLE `t_l2snr_pm25data`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l2snr_pm25data`
--
ALTER TABLE `t_l2snr_pm25data`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_aqyc_minreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_aqyc_minreport` (
  `sid` int(4) NOT NULL,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `dataflag` char(10) NOT NULL DEFAULT 'Y',
  `pm01` float DEFAULT NULL,
  `pm25` float DEFAULT NULL,
  `pm10` float DEFAULT NULL,
  `noise` float DEFAULT NULL,
  `windspeed` float DEFAULT NULL,
  `winddirection` float DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `humidity` float DEFAULT NULL,
  `airpressure` float DEFAULT NULL,
  `rain` float DEFAULT NULL,
  `emcvalue` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l2snr_aqyc_minreport`
--
ALTER TABLE `t_l2snr_aqyc_minreport`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l2snr_aqyc_minreport`
--
ALTER TABLE `t_l2snr_aqyc_minreport`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;

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

*/


class classDbiL2snrPm25
{

    //用于PM2.5传感器缺失数据的插值
    private function dbi_missing_pmdata_insert($pm01_start,$pm25_start,$pm10_start,$date_start,$timeindex_start,$pm01_end,$pm25_end,$pm10_end,$date_end,$timeindex_end)
    {
        $resp =array(); //初始化
        $pm01_start = intval($pm01_start);
        $pm25_start = intval($pm25_start);
        $pm10_start = intval($pm10_start);
        $pm01_end = intval($pm01_end);
        $pm25_end = intval($pm25_end);
        $pm10_end = intval($pm10_end);
        $time_start = strtotime($date_start);
        $time_end = strtotime($date_end);
        $diff_day = ($time_end - $time_start)/86400;

        if ($diff_day == 0){
            //同一天，从上次的hourminindex插值到当前的hourminindex
            for ($i=$timeindex_start+1; $i<$timeindex_end; $i++){
                $pm01 = rand ($pm01_start, $pm01_end);
                $pm25 = rand ($pm25_start, $pm25_end);
                $pm10 = rand ($pm10_start, $pm10_end);
                $onerow = array('date'=>$date_start, 'hourminindex'=>$i, 'pm01'=>$pm01, 'pm25'=>$pm25, 'pm10'=>$pm10);
                array_push($resp, $onerow);
            }
        }
        elseif ($diff_day == 1){
            //先插入上次记录当天剩余值
            for ($i=$timeindex_start+1; $i<(23*60+60/MFUN_TIME_GRID_SIZE); $i++){
                $pm01 = rand ($pm01_start, $pm01_end);
                $pm25 = rand ($pm25_start, $pm25_end);
                $pm10 = rand ($pm10_start, $pm10_end);
                $onerow = array('date'=>$date_start, 'hourminindex'=>$i, 'pm01'=>$pm01, 'pm25'=>$pm25, 'pm10'=>$pm10);
                array_push($resp, $onerow);
            }
            //再插入今天当前hourminindex前的记录
            for ($i=1; $i<$timeindex_end; $i++){
                $pm01 = rand ($pm01_start, $pm01_end);
                $pm25 = rand ($pm25_start, $pm25_end);
                $pm10 = rand ($pm10_start, $pm10_end);
                $onerow = array('date'=>$date_end, 'hourminindex'=>$i, 'pm01'=>$pm01, 'pm25'=>$pm25, 'pm10'=>$pm10);
                array_push($resp, $onerow);
            }
        }
        elseif ($diff_day > 1){
            //先插入上次记录当天剩余值
            for ($i=$timeindex_start+1; $i<(23*60+60/MFUN_TIME_GRID_SIZE); $i++){
                $pm01 = rand ($pm01_start, $pm01_end);
                $pm25 = rand ($pm25_start, $pm25_end);
                $pm10 = rand ($pm10_start, $pm10_end);
                $onerow = array('date'=>$date_start, 'hourminindex'=>$i, 'pm01'=>$pm01, 'pm25'=>$pm25, 'pm10'=>$pm10);
                array_push($resp, $onerow);
            }
            //插入中间欠缺的完整天记录
            for($j = 1; $j<$diff_day; $j++){
                $format = '+'.$j.' day';
                $date_current = date('Y-m-d',strtotime($format,strtotime($date_start)));
                for ($i=1; $i<(23*60+60/MFUN_TIME_GRID_SIZE); $i++){
                    $pm01 = rand ($pm01_start, $pm01_end);
                    $pm25 = rand ($pm25_start, $pm25_end);
                    $pm10 = rand ($pm10_start, $pm10_end);
                    $onerow = array('date'=>$date_current, 'hourminindex'=>$i, 'pm01'=>$pm01, 'pm25'=>$pm25, 'pm10'=>$pm10);
                    array_push($resp, $onerow);
                }
            }
            //再插入今天当前hourminindex前的记录
            for ($i=1; $i<$timeindex_end; $i++){
                $pm01 = rand ($pm01_start, $pm01_end);
                $pm25 = rand ($pm25_start, $pm25_end);
                $pm10 = rand ($pm10_start, $pm10_end);
                $onerow = array('date'=>$date_end, 'hourminindex'=>$i, 'pm01'=>$pm01, 'pm25'=>$pm25, 'pm10'=>$pm10);
                array_push($resp, $onerow);
            }
        }

        return $resp;
    }


    //更新每个传感器自己对应的l2snr data表
    private function dbi_l2snr_pmdata_update($devCode, $timeStamp, $pm01, $pm25, $pm10)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //在更新之前先判断从上次记录到现在是否有数据缺失，如果有缺失则插入从上次上报值到当前值的随机值，补全记录
        $reportdate = date("Y-m-d", $timeStamp);
        $stamp = getdate($timeStamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/MFUN_TIME_GRID_SIZE)));

        //先判断数据是否缺失
        $fakedata = array();
        $query_str = "SELECT MAX(`sid`) FROM `t_l2snr_pm25data` WHERE (`deviceid` = '$devCode')";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0){
            $row = $result->fetch_array();
            $last_reportdate = $row['reportdate'];
            $last_hourminindex = $row['hourminindex'];
            $last_pm01 = $row['pm01'];
            $last_pm25 = $row['pm25'];
            $last_pm10 = $row['pm10'];

            $fakedata = $this->dbi_missing_pmdata_insert($last_pm01,$last_pm25,$last_pm10,$last_reportdate,$last_hourminindex,$pm01,$pm25,$pm10,$reportdate,$hourminindex);

            $dataFlag = MFUN_HCU_DATA_FLAG_FAKE;
            for($i=0; $i<count($fakedata); $i++){
                $fake_pm01 = $fakedata[$i]['pm01'];
                $fake_pm25 = $fakedata[$i]['pm25'];
                $fake_pm10 = $fakedata[$i]['pm10'];
                $fake_reportdate = $fakedata[$i]['date'];
                $fake_hourminindex = $fakedata[$i]['hourminindex'];
                $query_str = "INSERT INTO `t_l2snr_pm25data` (deviceid,pm01,pm25,pm10,dataflag,reportdate,hourminindex) VALUES ('$devCode','$fake_pm01','$fake_pm25','$fake_pm10','$dataFlag','$fake_reportdate','$fake_hourminindex')";
                $result=$mysqli->query($query_str);
            }
        }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $dataFlag = MFUN_HCU_DATA_FLAG_VALID;
        $query_str = "SELECT * FROM `t_l2snr_pm25data` WHERE (`deviceid` = '$devCode' AND `reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_pm25data` SET `pm01` = '$pm01',`pm25` = '$pm25',`pm10` = '$pm10',`dataflag` = '$dataFlag' WHERE (`deviceid` = '$devCode' AND `reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        else   //不存在，新增
        {
            $query_str = "INSERT INTO `t_l2snr_pm25data` (deviceid,pm01,pm25,pm10,dataflag,reportdate,hourminindex) VALUES ('$devCode','$pm01','$pm25','$pm10','$dataFlag','$reportdate','$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        $mysqli->close();
        return $result;
    }

    //更新传感器分钟聚合表
    public function dbi_l2snr_pmdata_minreport_update($devCode,$statCode,$timeStamp,$pm01, $pm25, $pm10)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $reportdate = date("Y-m-d", $timeStamp);
        $stamp = getdate($timeStamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/MFUN_TIME_GRID_SIZE)));
        $dataFlag = MFUN_HCU_DATA_FLAG_VALID;

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $query_str = "SELECT * FROM `t_l2snr_aqyc_minreport` WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode'
                                  AND `reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)  //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_aqyc_minreport` SET `pm01` = '$pm01',`pm25` = '$pm25',`pm10` = '$pm10',`dataflag` = '$dataFlag'
                          WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode' AND `reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        else   //不存在，新增
        {
            $query_str = "INSERT INTO `t_l2snr_aqyc_minreport` (devcode,statcode,pm01,pm25,pm10,dataflag,reportdate,hourminindex)
                                  VALUES ('$devCode', '$statCode', '$pm01','$pm25','$pm10','$dataFlag','$reportdate','$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        $mysqli->close();
        return $result;
    }

    //更新传感器当前报告聚合表
    private function dbi_l2snr_pmdata_currentreport_update($devCode, $statCode, $timeStamp, $pm01, $pm25, $pm10)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $currenttime = date("Y-m-d H:i:s",$timeStamp);

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $query_str = "SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE (`deviceid` = '$devCode')";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $query_str = "UPDATE `t_l3f3dm_aqyc_currentreport` SET `statcode` = '$statCode',`pm01` = '$pm01',`pm25` = '$pm25',`pm10` = '$pm10',`createtime` = '$currenttime' WHERE (`deviceid` = '$devCode')";
            $result = $mysqli->query($query_str);
        }
        else {
            $query_str = "INSERT INTO `t_l3f3dm_aqyc_currentreport` (deviceid,statcode,createtime,pm01,pm25,pm10) VALUES ('$devCode','$statCode','$currenttime','$pm01','$pm25','$pm10')";
            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    private function dbi_l2snr_pmdata_old_delete($devCode, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $query_str = "DELETE FROM `t_l2snr_pm25data` WHERE ((`deviceid` = '$devCode') AND (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days'))";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    private function dbi_l2snr_ycjk_data_update($devCode,$timeStamp,$report)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $reportdate = date("Y-m-d", $timeStamp);
        $stamp = getdate($timeStamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/MFUN_TIME_GRID_SIZE)));

        $tempValue = $report['tempValue'];
        $humidValue = $report['humidValue'];
        $winddirValue = $report['winddirValue'];
        $windspdValue = $report['windspdValue'];
        $noiseValue = $report['noiseValue'];
        $pm01Value = $report['pm01Value'];  //暂时没用，和TSP一样
        $pm25Value = $report['pm25Value'];
        $pm10Value = $report['pm10Value'];
        $tspValue = $report['tspValue'];

        $dataFlag = MFUN_HCU_DATA_FLAG_VALID;

        $query_str = " REPLACE INTO `t_l2snr_tempdata`  (`deviceid`,`temperature`,`dataflag`,`reportdate`,`hourminindex`) VALUES ('$devCode','$tempValue','$dataFlag','$reportdate','$hourminindex')";
        $result = $mysqli->query($query_str);

        $query_str = " REPLACE INTO `t_l2snr_humiddata`  (`deviceid`,`humidity`,`dataflag`,`reportdate`,`hourminindex`) VALUES ('$devCode','$humidValue','$dataFlag','$reportdate','$hourminindex')";
        $result = $mysqli->query($query_str);

        $query_str = " REPLACE INTO `t_l2snr_winddir`  (`deviceid`,`winddirection`,`dataflag`,`reportdate`,`hourminindex`) VALUES ('$devCode','$winddirValue','$dataFlag','$reportdate','$hourminindex')";
        $result = $mysqli->query($query_str);

        $query_str = " REPLACE INTO `t_l2snr_windspd`  (`deviceid`,`windspeed`,`dataflag`,`reportdate`,`hourminindex`) VALUES ('$devCode','$windspdValue','$dataFlag','$reportdate','$hourminindex')";
        $result = $mysqli->query($query_str);

        $query_str = " REPLACE INTO `t_l2snr_noisedata`  (`deviceid`,`noise`,`dataflag`,`reportdate`,`hourminindex`) VALUES ('$devCode','$noiseValue','$dataFlag','$reportdate','$hourminindex')";
        $result = $mysqli->query($query_str);

        $query_str = " REPLACE INTO `t_l2snr_pm25data`  (`deviceid`,`pm01`,`pm25`,`pm10`,`dataflag`,`reportdate`,`hourminindex`) VALUES ('$devCode','$tspValue','$pm25Value','$pm10Value','$dataFlag','$reportdate','$hourminindex')";
        $result = $mysqli->query($query_str);


        $mysqli->close();
        return $result;
    }

    private function dbi_l2snr_ycjk_data_old_delete($devCode, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_l2snr_tempdata` WHERE ((`deviceid` = '$devCode') AND (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days'))";
        $result = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_l2snr_humiddata` WHERE ((`deviceid` = '$devCode') AND (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days'))";
        $result = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_l2snr_winddir` WHERE ((`deviceid` = '$devCode') AND (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days'))";
        $result = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_l2snr_windspd` WHERE ((`deviceid` = '$devCode') AND (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days'))";
        $result = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_l2snr_noisedata` WHERE ((`deviceid` = '$devCode') AND (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days'))";
        $result = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_l2snr_pm25data` WHERE ((`deviceid` = '$devCode') AND (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days'))";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    private function dbi_l2snr_ycjk_data_minreport_update($devCode,$statCode,$timeStamp,$report)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $tempValue = $report['tempValue'];
        $humidValue = $report['humidValue'];
        $winddirValue = $report['winddirValue'];
        $windspdValue = $report['windspdValue'];
        $noiseValue = $report['noiseValue'];
        $pm01Value = $report['pm01Value'];  //暂时没用，和TSP一样
        $pm25Value = $report['pm25Value'];
        $pm10Value = $report['pm10Value'];
        $tspValue = $report['tspValue'];

        $reportdate = date("Y-m-d", $timeStamp);
        $stamp = getdate($timeStamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/MFUN_TIME_GRID_SIZE)));

        //更新数据前先判断上次记录到现在是否有缺失，如果有则补充缺失记录
        $value_last = array();
        $query_str = "SELECT * FROM `t_l2snr_aqyc_minreport` WHERE `sid` = (SELECT MAX(`sid`) FROM `t_l2snr_aqyc_minreport` WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode'))";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $reportdate_last = $row['reportdate'];
            $hourminindex_last = $row['hourminindex'];
            $pm01_last = intval($row['pm01']);
            $pm25_last = intval($row['pm25']);
            $pm10_last = intval($row['pm10']);
            $noise_last = intval($row['noise']);
            $temp_last = intval($row['temperature']);
            $humid_last = intval($row['humidity']);
            $windspd_last = intval($row['windspeed']);
            $winddir_last = intval($row['winddirection']);
            $value_last = array("pm01"=>$pm01_last,"pm25"=>$pm25_last,"pm10"=>$pm10_last,"noise"=>$noise_last,"temp"=>$temp_last,"humid"=>$humid_last,"windspd"=>$windspd_last,"winddir"=>$winddir_last);
        }

        if (!empty($value_last)){
            $value_now = array("pm01"=>$tspValue,"pm25"=>$pm25Value,"pm10"=>$pm10Value,"noise"=>$noiseValue,"temp"=>$tempValue,"humid"=>$humidValue,"windspd"=>$windspdValue,"winddir"=>$winddirValue);
            $dbiL2snrCommonObj = new classDbiL2snrCommon();
            $fakedata = $dbiL2snrCommonObj->dbi_l2snr_missingdata_insert($value_last,$reportdate_last,$hourminindex_last,$value_now,$reportdate,$hourminindex);
            $dataFlag = MFUN_HCU_DATA_FLAG_FAKE;
            for($i=0; $i<count($fakedata); $i++){
                $fake_tsp = $fakedata[$i]['pm01'];
                $fake_pm25 = $fakedata[$i]['pm25'];
                $fake_pm10 = $fakedata[$i]['pm10'];
                $fake_noise = $fakedata[$i]['noise'];
                $fake_temp = $fakedata[$i]['temp'];
                $fake_humid = $fakedata[$i]['humid'];
                $fake_windspd = $fakedata[$i]['windspd'];
                $fake_winddir = $fakedata[$i]['winddir'];
                $fake_reportdate = $fakedata[$i]['date'];
                $fake_hourminindex = $fakedata[$i]['hourminindex'];

                $query_str = "INSERT INTO `t_l2snr_aqyc_minreport` (devcode,statcode,pm01,pm25,pm10,noise,windspeed,winddirection,temperature,humidity,reportdate,hourminindex,dataflag)
                          VALUES ('$devCode', '$statCode', '$fake_tsp','$fake_pm25','$fake_pm10','$fake_noise','$fake_windspd','$fake_winddir','$fake_temp','$fake_humid','$fake_reportdate','$fake_hourminindex','$dataFlag')";
                $result=$mysqli->query($query_str);
            }
        }

        $dataFlag = MFUN_HCU_DATA_FLAG_VALID;
        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $query_str = "SELECT * FROM `t_l2snr_aqyc_minreport` WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode' AND `reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)  //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_aqyc_minreport` SET `pm01` = '$tspValue',`pm25` = '$pm25Value',`pm10` = '$pm10Value',`noise` = '$noiseValue',`windspeed` = '$windspdValue',`winddirection` = '$winddirValue',`temperature` = '$tempValue',`humidity` = '$humidValue',`dataflag` = '$dataFlag'
                          WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode' AND `reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        else   //不存在，新增
        {
            $query_str = "INSERT INTO `t_l2snr_aqyc_minreport` (devcode,statcode,pm01,pm25,pm10,noise,windspeed,winddirection,temperature,humidity,reportdate,hourminindex,dataflag)
                          VALUES ('$devCode', '$statCode', '$tspValue','$pm25Value','$pm10Value','$noiseValue','$windspdValue','$winddirValue','$tempValue','$humidValue','$reportdate','$hourminindex','$dataFlag')";
            $result=$mysqli->query($query_str);
        }
        $mysqli->close();
        return $result;
    }

    private function dbi_l2snr_ycjk_data_currentreport_update($devCode,$statCode,$timeStamp,$report)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $tempValue = $report['tempValue'];
        $humidValue = $report['humidValue'];
        $winddirValue = $report['winddirValue'];
        $windspdValue = $report['windspdValue'];
        $noiseValue = $report['noiseValue'];
        $pm01Value = $report['pm01Value'];  //暂时没用，和TSP一样
        $pm25Value = $report['pm25Value'];
        $pm10Value = $report['pm10Value'];
        $tspValue = $report['tspValue'];

        $currenttime = date("Y-m-d H:i:s",$timeStamp);

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $query_str = "SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE (`deviceid` = '$devCode')";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $query_str = "UPDATE `t_l3f3dm_aqyc_currentreport` SET `statcode` = '$statCode',`pm01` = '$tspValue',`pm25` = '$pm25Value',`pm10` = '$pm10Value',`noise` = '$noiseValue',`windspeed` = '$windspdValue',`winddirection` = '$winddirValue',`temperature` = '$tempValue',`humidity` = '$humidValue',`createtime` = '$currenttime' WHERE (`deviceid` = '$devCode')";
            $result = $mysqli->query($query_str);
        }
        else {
            $query_str = "INSERT INTO `t_l3f3dm_aqyc_currentreport` (deviceid,statcode,createtime,pm01,pm25,pm10,noise,windspeed,winddirection,temperature,humidity) VALUES ('$devCode','$statCode','$currenttime','$tspValue','$pm25Value','$pm10Value','$noiseValue','$windspdValue','$winddirValue','$tempValue','$humidValue')";
            $result = $mysqli->query($query_str);
        }
        $mysqli->close();
        return $result;
    }

    public function dbi_huitp_msg_uni_pm25_data_report($devCode, $statCode, $content)
    {
        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用

        $dbiL2snrCommon = new classDbiL2snrCommon();
        $pm01data = hexdec($content[1]['HUITP_IEID_uni_pm01_value']['pm01Value']) & 0xFFFFFFFF;
        $pm01dataFormat = hexdec($content[1]['HUITP_IEID_uni_pm01_value']['dataFormat']) & 0xFF;
        $pm01Value = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($pm01dataFormat, $pm01data);

        $pm25data = hexdec($content[2]['HUITP_IEID_uni_pm25_value']['pm25Value']) & 0xFFFFFFFF;
        $pm25dataFormat = hexdec($content[2]['HUITP_IEID_uni_pm25_value']['dataFormat']) & 0xFF;
        $pm25Value = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($pm25dataFormat, $pm25data);

        $pm10data = hexdec($content[3]['HUITP_IEID_uni_pm10_value']['pm10Value']) & 0xFFFFFFFF;
        $pm10dataFormat = hexdec($content[3]['HUITP_IEID_uni_pm10_value']['dataFormat']) & 0xFF;
        $pm10Value = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($pm10dataFormat, $pm10data);

        $timeStamp = time();

        //保存记录到对应l2snr表
        $result = $this->dbi_l2snr_pmdata_update($devCode, $timeStamp, $pm01Value, $pm25Value, $pm10Value);
        //清理超期的数据
        $result = $this->dbi_l2snr_pmdata_old_delete($devCode, MFUN_HCU_DATA_SAVE_DURATION_BY_PROJ);  //remove old data.

        //更新分钟测量报告聚合表
        $result = $this->dbi_l2snr_pmdata_minreport_update($devCode,$statCode,$timeStamp,$pm01Value, $pm25Value, $pm10Value);

        //更新瞬时测量值聚合表
        $result = $this->dbi_l2snr_pmdata_currentreport_update($devCode,$statCode,$timeStamp,$pm01Value, $pm25Value, $pm10Value);

        //生成 HUITP_MSGID_uni_pm25_data_confirm 消息的内容
        $respMsgContent = array();
        $baseConfirmIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;
        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
        array_push($baseConfirmIE, HUITP_IEID_uni_com_confirm);
        array_push($baseConfirmIE, $huitpIeLen);
        array_push($baseConfirmIE, $comConfirm);

        array_push($respMsgContent, $baseConfirmIE);

        return $respMsgContent;
    }

    public function dbi_huitp_msg_uni_ycjk_data_report($devCode, $statCode, $content)
    {
        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用

        $dbiL2snrCommon = new classDbiL2snrCommon();
        $dataFormat = hexdec($content[1]['HUITP_IEID_uni_ycjk_value']['dataFormat']) & 0xFF;
        //温度
        $tempData = hexdec($content[1]['HUITP_IEID_uni_ycjk_value']['tempValue']) & 0xFFFFFFFF;
        $tempValue = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $tempData);
        //湿度
        $humidData = hexdec($content[1]['HUITP_IEID_uni_ycjk_value']['humidValue']) & 0xFFFFFFFF;
        $humidValue = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $humidData);
        //风向
        $winddirData = hexdec($content[1]['HUITP_IEID_uni_ycjk_value']['winddirValue']) & 0xFFFFFFFF;
        $winddirValue = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $winddirData);
        //风速
        $windspdData = hexdec($content[1]['HUITP_IEID_uni_ycjk_value']['windspdValue']) & 0xFFFFFFFF;
        $windspdValue = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $windspdData);
        //噪声
        $noiseData = hexdec($content[1]['HUITP_IEID_uni_ycjk_value']['noiseValue']) & 0xFFFFFFFF;
        $noiseValue = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $noiseData);
        //PM1.0
        $pm01Data = hexdec($content[1]['HUITP_IEID_uni_ycjk_value']['pm1d0Value']) & 0xFFFFFFFF;
        $pm01Value = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $pm01Data);
        //PM2.5
        $pm25Data = hexdec($content[1]['HUITP_IEID_uni_ycjk_value']['pm2d5Value']) & 0xFFFFFFFF;
        $pm25Value = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $pm25Data);
        //PM10
        $pm10Data = hexdec($content[1]['HUITP_IEID_uni_ycjk_value']['pm10Value']) & 0xFFFFFFFF;
        $pm10Value = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $pm10Data);
        //TSP
        $tspData = hexdec($content[1]['HUITP_IEID_uni_ycjk_value']['tspValue']) & 0xFFFFFFFF;
        $tspValue = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $tspData);

        $report = array('tempValue'=>$tempValue,'humidValue'=>$humidValue,'winddirValue'=>$winddirValue,'windspdValue'=>$windspdValue,'noiseValue'=>$noiseValue,'pm01Value'=>$pm01Value, 'pm25Value'=>$pm25Value, 'pm10Value'=>$pm10Value,'tspValue'=>$tspValue);

        $timeStamp = time();
        //保存记录到对应l2snr表
        $result = $this->dbi_l2snr_ycjk_data_update($devCode,$timeStamp,$report);
        //清理超过90天记录的数据
        $result = $this->dbi_l2snr_ycjk_data_old_delete($devCode, MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS);  //remove old data.

        //更新分钟测量报告聚合表
        $result = $this->dbi_l2snr_ycjk_data_minreport_update($devCode,$statCode,$timeStamp,$report);

        //更新瞬时测量值聚合表
        $result = $this->dbi_l2snr_ycjk_data_currentreport_update($devCode,$statCode,$timeStamp,$report);

        //生成 HUITP_MSGID_uni_ycjk_data_confirm 消息的内容
        $respMsgContent = array();
        $baseConfirmIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;
        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
        array_push($baseConfirmIE, HUITP_IEID_uni_com_confirm);
        array_push($baseConfirmIE, $huitpIeLen);
        array_push($baseConfirmIE, $comConfirm);

        array_push($respMsgContent, $baseConfirmIE);

        return $respMsgContent;
    }


}

?>