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
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `pm01` int(4) NOT NULL,
  `pm25` int(4) NOT NULL,
  `pm10` int(4) NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4059 ;

--
-- 转存表中的数据 `t_l2snr_pm25data`
--

INSERT INTO `t_l2snr_pm25data` (`sid`, `deviceid`, `sensorid`, `pm01`, `pm25`, `pm10`, `dataflag`, `reportdate`, `hourminindex`, `altitude`, `flag_la`, `latitude`, `flag_lo`, `longitude`) VALUES
(4058, 'HCU_SH_0301', 1, 274, 274, 1170, 'N', '2016-03-13', 1233, 0, '\0', 0, '\0', 0);



 */


class classDbiL2snrPm25
{

    //更新每个传感器自己对应的l2snr data表
    private function dbi_l2snr_pmdata_update($statCode, $timeStamp, $pm01, $pm25, $pm10)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $date = intval(date("ymd", $timeStamp));
        $stamp = getdate($timeStamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/MFUN_TIME_GRID_SIZE)));

        $query_str = "SELECT * FROM `t_l2snr_pm25data` WHERE (`deviceid` = '$statCode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_pm25data` SET `pm01` = '$pm01',`pm25` = '$pm25',`pm10` = '$pm10' WHERE (`deviceid` = '$statCode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        else   //不存在，新增
        {
            $query_str = "INSERT INTO `t_l2snr_pm25data` (deviceid,pm01,pm25,pm10,reportdate,hourminindex) VALUES ('$statCode','$pm01','$pm25','$pm10','$date','$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        $mysqli->close();
        return $result;
    }

    //更新传感器分钟聚合表
    public function dbi_l2snr_pmdata_minreport_update($devCode,$statCode,$timestamp,$pm01, $pm25, $pm10)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $date = intval(date("ymd", $timestamp));
        $stamp = getdate($timestamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/MFUN_TIME_GRID_SIZE)));

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $query_str = "SELECT * FROM `t_l2snr_aqyc_minreport` WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode'
                                  AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)  //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_aqyc_minreport` SET `pm01` = '$pm01',`pm25` = '$pm25',`pm10` = '$pm10'
                          WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        else   //不存在，新增
        {
            $query_str = "INSERT INTO `t_l2snr_aqyc_minreport` (devcode,statcode,pm01,pm25,pm10,reportdate,hourminindex)
                                  VALUES ('$devCode', '$statCode', '$pm01','$pm25','$pm10','$date','$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        $mysqli->close();
        return $result;
    }

    //更新传感器当前报告聚合表
    private function dbi_l2snr_pmdata_currentreport_update($devCode, $statCode, $timestamp, $pm01, $pm25, $pm10)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $currenttime = date("Y-m-d H:i:s",$timestamp);

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

    //删除对应用户所有超过90天的数据
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

    public function dbi_huitp_msg_uni_pm25_data_report($devCode, $statCode, $content)
    {
        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用

        $dbiL2snrCommon = new classDbiL2snrCommon();
        $pm01data = hexdec($content[1]['HUITP_IEID_uni_pm01_value']['pm01Value']) & 0xFFFFFFFF;
        $pm01dataFormat = hexdec($content[1]['HUITP_IEID_uni_pm01_value']['dataFormat']) & 0xFF;
        $pm01Value = $dbiL2snrCommon->dbi_datavalue_convert($pm01dataFormat, $pm01data);

        $pm25data = hexdec($content[2]['HUITP_IEID_uni_pm25_value']['pm25Value']) & 0xFFFFFFFF;
        $pm25dataFormat = hexdec($content[2]['HUITP_IEID_uni_pm25_value']['dataFormat']) & 0xFF;
        $pm25Value = $dbiL2snrCommon->dbi_datavalue_convert($pm25dataFormat, $pm25data);

        $pm10data = hexdec($content[3]['HUITP_IEID_uni_pm10_value']['pm10Value']) & 0xFFFFFFFF;
        $pm10dataFormat = hexdec($content[3]['HUITP_IEID_uni_pm10_value']['dataFormat']) & 0xFF;
        $pm10Value = $dbiL2snrCommon->dbi_datavalue_convert($pm10dataFormat, $pm10data);

        $timeStamp = time();

        //保存记录到对应l2snr表
        $result = $this->dbi_l2snr_pmdata_update($devCode, $timeStamp, $pm01Value, $pm25Value, $pm10Value);
        //清理超过90天记录的数据
        $result = $this->dbi_l2snr_pmdata_old_delete($devCode, 90);  //remove 90 days old data.

        //更新分钟测量报告聚合表
        $result = $this->dbi_l2snr_pmdata_minreport_update($devCode,$statCode,$timeStamp,$pm01Value, $pm25Value, $pm10Value);

        //更新瞬时测量值聚合表
        $result = $this->dbi_l2snr_pmdata_currentreport_update($devCode,$statCode,$timeStamp,$pm01Value, $pm25Value, $pm10Value);

        return true;
    }


}

?>