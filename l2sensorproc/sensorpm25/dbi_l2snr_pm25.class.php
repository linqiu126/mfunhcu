<?php
/**
 * Created by PhpStorm.
 * User: Administrator
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
    //构造函数
    public function __construct()
    {

    }

    //以下为处理空气污染物颗粒数据表单（t_l2snr_pm25data）相关函数
    //存储空气污染物颗粒数据，每一次存储，都是新增一条记录
    //记录存储是以TIME_GRID_SIZE分钟为网格化的，保证每一个时间网格只有一条记录
    public function dbi_pmData_save($deviceid, $sensorid,$timestamp,$data,$gps)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $date = intval(date("ymd", $timestamp));
        $stamp = getdate($timestamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/TIME_GRID_SIZE)));

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

        $pm01 = $data["pm01"];
        $pm25 = $data["pm25"];
        $pm10 = $data["pm10"];

        $result = $mysqli->query("SELECT * FROM `t_l2snr_pm25data` WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid'
                                  AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        if ($result == false){
            $mysqli->close();
            return $result;
        }
        if (($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l2snr_pm25data` SET `pm01` = '$pm01',`pm25` = '$pm25',`pm10` = '$pm10',`altitude` = '$altitude',`flag_la` = '$flag_la',`latitude` = '$latitude',`flag_lo` = '$flag_lo',`longitude` = '$longitude'
                    WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2snr_pm25data` (deviceid,sensorid,pm01,pm25,pm10,reportdate,hourminindex,altitude,flag_la,latitude,flag_lo,longitude)
                    VALUES ('$deviceid','$sensorid','$pm01','$pm25','$pm10','$date','$hourminindex','$altitude', '$flag_la','$latitude', '$flag_lo','$longitude')");
        }
        $mysqli->close();
        return $result;
    }

    //删除对应用户所有超过90天的数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    public function dbi_pmdata_delete_3monold($deviceid, $sensorid,$days)
    {
        if ($days <90) $days = 90;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("DELETE FROM `t_l2snr_pm25data` WHERE ((`deviceid` = '$deviceid' AND `sensorid` ='$sensorid') AND (TO_DAYS(NOW()) - TO_DAYS(`date`) > '$days'))");
        $mysqli->close();
        return $result;
    }

    public function dbi_LatestPm25Value_inqury($sid)
    {
        $LatestPm25Value = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `t_l2snr_pm25data` WHERE `sid` = '$sid'");

        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $LatestPm25Value = $row['pm25'];
        }
        $mysqli->close();
        return $LatestPm25Value;
    }


    public function dbi_minreport_update_pmdata($devcode,$statcode,$timestamp,$data)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $date = intval(date("ymd", $timestamp));
        $stamp = getdate($timestamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/TIME_GRID_SIZE)));
        $pm01 = $data["pm01"];
        $pm25 = $data["pm25"];
        $pm10 = $data["pm10"];

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l2snr_minreport` WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode'
                                  AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        if ($result == false){
            $mysqli->close();
            return $result;
        }
        if (($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l2snr_minreport` SET `pm01` = '$pm01',`pm25` = '$pm25',`pm10` = '$pm10'
                          WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2snr_minreport` (devcode,statcode,pm01,pm25,pm10,reportdate,hourminindex)
                                  VALUES ('$devcode', '$statcode', '$pm01','$pm25','$pm10','$date','$hourminindex')");
        }
        $mysqli->close();
        return $result;
    }

}

?>