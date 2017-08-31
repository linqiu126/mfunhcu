<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/1/2
 * Time: 16:07
 */
//include_once "../../l1comvm/vmlayer.php";

/*
-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_winddir`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_winddir` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `winddirection` int(4) NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9992 ;

--
-- 转存表中的数据 `t_l2snr_winddir`
--

INSERT INTO `t_l2snr_winddir` (`sid`, `deviceid`, `sensorid`, `winddirection`, `dataflag`, `reportdate`, `hourminindex`, `altitude`, `flag_la`, `latitude`, `flag_lo`, `longitude`) VALUES
(19899, 'HCU_SH_0301', 6, 172, 'N', '2016-03-13', 1235, 0, '\0', 0, '\0', 0);

 */
class classDbiL2snrWinddir
{

    //更新每个传感器自己对应的l2snr data表
    private function dbi_l2snr_winddir_update($devCode, $timeStamp, $winddirValue)
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

        $query_str = "SELECT * FROM `t_l2snr_winddir` WHERE (`deviceid` = '$devCode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_winddir` SET `winddirection` = '$winddirValue' WHERE (`deviceid` = '$devCode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        else   //不存在，新增
        {
            $query_str = "INSERT INTO `t_l2snr_winddir` (deviceid,winddirection,reportdate,hourminindex) VALUES ('$devCode','$winddirValue','$date','$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        $mysqli->close();
        return $result;
    }

    //更新传感器分钟聚合表
    public function dbi_l2snr_winddir_minreport_update($devCode,$statCode,$timeStamp,$winddirValue)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $reportdate = intval(date("ymd", $timeStamp));
        $stamp = getdate($timeStamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/MFUN_TIME_GRID_SIZE)));

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $query_str = "SELECT * FROM `t_l2snr_aqyc_minreport` WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode'
                                  AND `reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)  //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_aqyc_minreport` SET `winddirection` = '$winddirValue'
                          WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode' AND `reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        else   //不存在，新增
        {
            $query_str = "INSERT INTO `t_l2snr_aqyc_minreport` (devcode,statcode,winddirection,reportdate,hourminindex)
                                  VALUES ('$devCode', '$statCode', '$winddirValue','$reportdate','$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        $mysqli->close();
        return $result;
    }

    //更新传感器当前报告聚合表
    private function dbi_l2snr_winddir_currentreport_update($devCode,$statCode,$timeStamp,$winddirValue)
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
            $query_str = "UPDATE `t_l3f3dm_aqyc_currentreport` SET `statcode` = '$statCode',`winddirection` = '$winddirValue',`createtime` = '$currenttime' WHERE (`deviceid` = '$devCode')";
            $result = $mysqli->query($query_str);
        }
        else {
            $query_str = "INSERT INTO `t_l3f3dm_aqyc_currentreport` (deviceid,statcode,createtime,winddirection) VALUES ('$devCode','$statCode','$currenttime','$winddirValue')";
            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    //删除对应用户所有超过90天的数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    private function dbi_l2snr_winddir_olddata_delete($devCode, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $query_str = "DELETE FROM `t_l2snr_winddir` WHERE ((`deviceid` = '$devCode') AND (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days'))";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    public function dbi_huitp_msg_uni_winddir_data_report($devCode, $statCode, $content)
    {
        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用

        $dbiL2snrCommon = new classDbiL2snrCommon();
        $winddirData = hexdec($content[1]['HUITP_IEID_uni_winddir_value']['winddirValue']) & 0xFFFFFFFF;
        $dataFormat =hexdec($content[1]['HUITP_IEID_uni_winddir_value']['dataFormat']) & 0xFF;
        $winddirValue = $dbiL2snrCommon->dbi_datavalue_convert($dataFormat, $winddirData);

        $timeStamp = time();

        //保存记录到对应l2snr表
        $result = $this->dbi_l2snr_winddir_update($devCode, $timeStamp, $winddirValue);
        //清理超过90天记录的数据
        $result = $this->dbi_l2snr_winddir_olddata_delete($devCode, 90);  //remove 90 days old data.

        //更新分钟测量报告聚合表
        $result = $this->dbi_l2snr_winddir_minreport_update($devCode,$statCode,$timeStamp,$winddirValue);

        //更新瞬时测量值聚合表
        $result = $this->dbi_l2snr_winddir_currentreport_update($devCode,$statCode,$timeStamp,$winddirValue);

        //构造返回消息TBD
        return true;
    }

}