<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/1/2
 * Time: 16:04
 */
//include_once "../../l1comvm/vmlayer.php";

/*

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_noisedata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_noisedata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `noise` int(4) NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9319 ;

--
-- 转存表中的数据 `t_l2snr_noisedata`
--

INSERT INTO `t_l2snr_noisedata` (`sid`, `deviceid`, `sensorid`, `noise`, `dataflag`, `reportdate`, `hourminindex`, `altitude`, `flag_la`, `latitude`, `flag_lo`, `longitude`) VALUES
(19899, 'HCU_SH_0301', 6, 172, 'N', '2016-03-13', 1235, 0, '\0', 0, '\0', 0);

 */


class classDbiL2snrNoise
{
    //构造函数
    public function __construct()
    {

    }

    public function dbi_noise_data_save($deviceid,$sensorid,$timestamp,$data,$gps)
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

        $noise = $data["value"];

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l2snr_noisedata` WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid'
                                  AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l2snr_noisedata` SET `noise` = '$noise',`altitude` = '$altitude',`flag_la` = '$flag_la',`latitude` = '$latitude',`flag_lo` = '$flag_lo',`longitude` = '$longitude'
                          WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2snr_noisedata` (deviceid,sensorid,noise,reportdate,hourminindex,altitude,flag_la,latitude,flag_lo,longitude)
                                  VALUES ('$deviceid','$sensorid','$noise','$date','$hourminindex','$altitude', '$flag_la','$latitude', '$flag_lo','$longitude')");
        }
        $mysqli->close();
        return $result;
    }

    //删除对应用户所有超过90天的数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    public function dbi_noiseData_delete_3monold($deviceid, $sensorid,$days)
    {
        if ($days <90) $days = 90;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("DELETE FROM `t_l2snr_noisedata` WHERE ((`deviceid` = '$deviceid' AND `sensorid` ='$sensorid') AND (TO_DAYS(NOW()) - TO_DAYS(`date`) > '$days'))");
        $mysqli->close();
        return $result;
    }

    public function dbi_LatestNoiseValue_inqury($sid)
    {
        $LatestNoiseValue = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l2snr_noisedata` WHERE `sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $LatestNoiseValue = $row['noise'];
        }
        $mysqli->close();
        return $LatestNoiseValue;
    }
    
    public function dbi_minreport_update_noise($devcode,$statcode,$timestamp,$data)
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

        $noise = $data["value"];

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l2snr_aqyc_minreport` WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode'
                                  AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l2snr_aqyc_minreport` SET `noise` = '$noise'
                          WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2snr_aqyc_minreport` (devcode,statcode,noise,reportdate,hourminindex)
                                  VALUES ('$devcode', '$statcode', '$noise','$date','$hourminindex')");
        }
        $mysqli->close();
        return $result;
    }
}

?>