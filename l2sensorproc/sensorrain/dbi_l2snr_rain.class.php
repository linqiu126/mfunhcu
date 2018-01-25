<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/22
 * Time: 14:44
 */
//include_once "../../l1comvm/vmlayer.php";

/*
-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_raindata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_raindata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `rain` int(4) NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19900 ;

--
-- 转存表中的数据 `t_l2snr_raindata`
--

INSERT INTO `t_l2snr_raindata` (`sid`, `deviceid`, `sensorid`, `rain`, `dataflag`, `reportdate`, `hourminindex`, `altitude`, `flag_la`, `latitude`, `flag_lo`, `longitude`) VALUES
(19899, 'HCU_SH_0301', 6, 172, 'N', '2016-03-13', 1235, 0, '\0', 0, '\0', 0);

*/

class classDbiL2snrRain
{
    public function dbi_rain_data_save($deviceid,$sensorid,$timestamp,$data,$gps)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $date = intval(date("ymd", $timestamp));
        $stamp = getdate($timestamp);
        $hourminindex = floor(($stamp["hours"] * 60 + $stamp["minutes"])/MFUN_HCU_AQYC_TIME_GRID_SIZE);

        if(!empty($gps)){
            $altitude = $gps["altitude"];
            $flag_la = $gps["flag_la"];
            $latitude = $gps["latitude"];
            $flag_lo = $gps["flag_lo"];
            $longitude = $gps["longitude"];
        }
        else{
            $altitude = "";
            $flag_la = "";
            $latitude = "";
            $flag_lo = "";
            $longitude = "";
        }

        $rain = $data["value"];

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l2snr_raindata` WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid'
                                  AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l2snr_raindata` SET  `rain` = '$rain',`altitude` = '$altitude',`flag_la` = '$flag_la',`latitude` = '$latitude',`flag_lo` = '$flag_lo',`longitude` = '$longitude'
                    WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2snr_raindata` (deviceid,sensorid,rain,reportdate,hourminindex,altitude,flag_la,latitude,flag_lo,longitude)
                    VALUES ('$deviceid','$sensorid','$rain','$date','$hourminindex','$altitude', '$flag_la','$latitude', '$flag_lo','$longitude')");
        }
        $mysqli->close();
        return $result;
    }

    public function dbi_LatestRainValue_inqury($sid)
    {
        $LatestRainValue = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l2snr_raindata` WHERE `sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $LatestRainValue = $row['rain'];
        }
        $mysqli->close();
        return $LatestRainValue;
    }

    public function dbi_minreport_update_rain($devcode,$statcode,$timestamp,$data)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $date = intval(date("ymd", $timestamp));
        $stamp = getdate($timestamp);
        $hourminindex = floor(($stamp["hours"] * 60 + $stamp["minutes"])/MFUN_HCU_AQYC_TIME_GRID_SIZE);

        $rain = $data["value"];

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l2snr_aqyc_minreport` WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode'
                                  AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l2snr_aqyc_minreport` SET `rain` = '$rain'
                          WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2snr_aqyc_minreport` (devcode,statcode,rain,reportdate,hourminindex)
                                  VALUES ('$devcode', '$statcode', '$rain','$date','$hourminindex')");
        }
        $mysqli->close();
        return $result;
    }

}

?>