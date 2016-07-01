<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/2
 * Time: 16:06
 */
//include_once "../../l1comvm/vmlayer.php";

/*

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_hsmmpdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_hsmmpdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `videourl` text NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28070 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_picturedata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_picturedata` (
`sid` int(4) NOT NULL AUTO_INCREMENT,
`deviceid` char(50) NOT NULL,
`sensorid` int(1) NOT NULL,
`filedescription` char(50) NOT NULL,
`filename` char(50) NOT NULL,
`filesize` char(50) NOT NULL,
`filetype` char(50) NOT NULL,
`bindata` MEDIUMBLOB NOT NULL,
`dataflag` char(1) NOT NULL DEFAULT 'N',
`reportdate` date NOT NULL,
`hourminindex` int(2) NOT NULL,
`altitude` int(4) NOT NULL,
`flag_la` char(1) NOT NULL,
`latitude` int(4) NOT NULL,
`flag_lo` char(1) NOT NULL,
`longitude` int(4) NOT NULL,
PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28070 ;

 */


class classDbiL2snrHsmmp
{
    //构造函数
    public function __construct()
    {

    }
    
    public function dbi_video_data_save($deviceid,$sensorid,$timestamp,$url,$gps)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli4=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli4)
        {
            die('Could not connect: ' . mysqli_error($mysqli4));
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

        //是否需要这么干？？？
        //更新HCU设备信息表（t_hcudevice）中最新的视频链接，使之永远保存最后一次更新
        $mysqli4->query("UPDATE `t_siteinfo` SET `videourl` = '$url' WHERE (`devcode` = '$deviceid')");

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l2snr_hsmmpdata` WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid'
                                  AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        if (($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l2snr_hsmmpdata` SET `videourl` = '$url',`altitude` = '$altitude',`flag_la` = '$flag_la',`latitude` = '$latitude',`flag_lo` = '$flag_lo',`longitude` = '$longitude'
                    WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2snr_hsmmpdata` (deviceid,sensorid,videourl,reportdate,hourminindex,altitude,flag_la,latitude,flag_lo,longitude)
                    VALUES ('$deviceid','$sensorid','$url','$date','$hourminindex','$altitude', '$flag_la','$latitude', '$flag_lo','$longitude')");
        }
        $mysqli->close();
        return $result;
    }

    public function dbi_picture_data_save($deviceid, $sensorid, $timestamp, $bindata, $gps)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
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

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l2snr_picturedata` WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid'
                                  AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        if (($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l2snr_picturedata` SET `bindata` = '$bindata',`altitude` = '$altitude',`flag_la` = '$flag_la',`latitude` = '$latitude',`flag_lo` = '$flag_lo',`longitude` = '$longitude'
                    WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2snr_picturedata` (deviceid,sensorid,bindata,reportdate,hourminindex,altitude,flag_la,latitude,flag_lo,longitude)
                    VALUES ('$deviceid','$sensorid','$bindata','$date','$hourminindex','$altitude', '$flag_la','$latitude', '$flag_lo','$longitude')");
        }
        $mysqli->close();
        return $result;
    }

    //读取最新的bindata数据
    public function dbi_latest_picture_data_inqury($deviceid)
    {
        $LatestEmcValue = 0;
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `t_l2snr_picturedata` WHERE `deviceid` = '$deviceid'");
        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $LatestEmcValue = $row['bindata'];
        }
        $mysqli->close();
        return $LatestEmcValue;
    }

    //HCU历史视频查询
    public function dbi_videodata_inquiry_url($deviceid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l2snr_hsmmpdata` WHERE `deviceid` = '$deviceid'");

        $i=0;
        while($row = $result->fetch_array())
        {
            $resp[$i]["reportdate"] = $row['reportdate'];
            $resp[$i]["videourl"] = $row['videourl'];
            $i++;
        }
        if ($i == 0) $resp = false;

        $mysqli->close();
        return $resp;
    }

}

?>