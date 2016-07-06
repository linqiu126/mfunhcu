<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 22:40
 */
//include_once "../../l1comvm/vmlayer.php";

/*
-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_alcoholdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_alcoholdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `alcohol` int(4) NOT NULL,
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
-- 转存表中的数据 `t_l2snr_alcoholdata`
--

INSERT INTO `t_l2snr_alcoholdata` (`sid`, `deviceid`, `sensorid`, `alcohol`, `dataflag`, `reportdate`, `hourminindex`, `altitude`, `flag_la`, `latitude`, `flag_lo`, `longitude`) VALUES
(19899, 'HCU_SH_0301', 6, 172, 'N', '2016-03-13', 1235, 0, '\0', 0, '\0', 0);

*/

class classDbiL2snrAlcohol
{
    //构造函数
    public function __construct()
    {

    }

    public function dbi_alcohol_data_save($deviceid,$sensorid,$timestamp,$data,$gps)
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

        $alcohol = $data["value"];

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l2snr_alcoholdata` WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid'
                                  AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        if ($result == false){
            $mysqli->close();
            return $result;
        }
        if (($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l2snr_alcoholdata` SET  `alcohol` = '$alcohol',`altitude` = '$altitude',`flag_la` = '$flag_la',`latitude` = '$latitude',`flag_lo` = '$flag_lo',`longitude` = '$longitude'
                    WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2snr_alcoholdata` (deviceid,sensorid,alcohol,reportdate,hourminindex,altitude,flag_la,latitude,flag_lo,longitude)
                    VALUES ('$deviceid','$sensorid','$alcohol','$date','$hourminindex','$altitude', '$flag_la','$latitude', '$flag_lo','$longitude')");
        }
        $mysqli->close();
        return $result;
    }

    //删除对应用户所有超过90天的数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    public function dbi_alcoholData_delete_3monold($deviceid, $sensorid,$days)
    {
        if ($days <90) $days = 90;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("DELETE FROM `t_l2snr_alcoholdata` WHERE ((`deviceid` = '$deviceid' AND `sensorid` ='$sensorid') AND (TO_DAYS(NOW()) - TO_DAYS(`date`) > '$days'))");
        $mysqli->close();
        return $result;
    }

    public function dbi_LatestAlcoholValue_inqury($sid)
    {
        $LatestAlcoholValue = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `t_l2snr_alcoholdata` WHERE `sid` = '$sid'");

        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $LatestAlcoholValue = $row['alcohol'];
        }
        $mysqli->close();
        return $LatestAlcoholValue;
    }

    public function dbi_minreport_update_alcohol($devcode,$statcode,$timestamp,$data)
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

        $alcohol = $data["value"];

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l2snr_minreport` WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode'
                                  AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        if (($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l2snr_minreport` SET `alcohol` = '$alcohol'
                          WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2snr_minreport` (devcode,statcode,alcohol,reportdate,hourminindex)
                                  VALUES ('$devcode', '$statcode', '$alcohol','$date','$hourminindex')");
        }
        $mysqli->close();
        return $result;
    }

}

?>