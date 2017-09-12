<?php
/**
 * Created by PhpStorm.
 * User: zehongl
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
  `sid` int(4) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `videourl` text NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l2snr_hsmmpdata`
--
ALTER TABLE `t_l2snr_hsmmpdata`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l2snr_hsmmpdata`
--
ALTER TABLE `t_l2snr_hsmmpdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_picturedata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_picturedata` (
  `sid` int(4) NOT NULL,
  `statcode` varchar(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `filetype` varchar(10) DEFAULT NULL,
  `filesize` varchar(10) NOT NULL DEFAULT '0',
  `filedescription` char(50) DEFAULT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l2snr_picturedata`
--
ALTER TABLE `t_l2snr_picturedata`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l2snr_picturedata`
--
ALTER TABLE `t_l2snr_picturedata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;

 */


class classDbiL2snrHsmmp
{
    //构造函数
    public function __construct()
    {

    }
    
    public function dbi_video_data_save($deviceid,$sensorid,$timeStamp,$url,$gps)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $reportdate = date("Y-m-d", $timeStamp);
        $stamp = getdate($timeStamp);
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

        //是否需要这么干？？？
        //更新HCU设备信息表（t_hcudevice）中最新的视频链接，使之永远保存最后一次更新
        $mysqli->query("UPDATE `t_l2sdk_iothcu_inventory` SET `videourl` = '$url' WHERE (`devcode` = '$deviceid')");

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l2snr_hsmmpdata` WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid'
                                  AND `reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex')");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l2snr_hsmmpdata` SET `videourl` = '$url',`altitude` = '$altitude',`flag_la` = '$flag_la',`latitude` = '$latitude',`flag_lo` = '$flag_lo',`longitude` = '$longitude'
                    WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid' AND `reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2snr_hsmmpdata` (deviceid,sensorid,videourl,reportdate,hourminindex,altitude,flag_la,latitude,flag_lo,longitude)
                    VALUES ('$deviceid','$sensorid','$url','$reportdate','$hourminindex','$altitude', '$flag_la','$latitude', '$flag_lo','$longitude')");
        }
        $mysqli->close();
        return $result;
    }

    public function dbi_video_data_status_update($deviceid, $status, $videoid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if ($status == MFUN_HCU_CMD_RESP_FAILURE)
            $dataflag = MFUN_HCU_VIDEO_DATA_STATUS_FAIL;
        elseif ($status == MFUN_HCU_CMD_RESP_SUCCESS)
            $dataflag = MFUN_HCU_VIDEO_DATA_STATUS_READY;

        $query_str = "UPDATE `t_l2snr_hsmmpdata` SET `dataflag` = '$dataflag' WHERE (`deviceid` = '$deviceid' AND `videourl` = '$videoid')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    //删除对应用户所有超过90天的数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    public function dbi_hsmmpData_delete_3monold($deviceid, $sensorid,$days)
    {
        if ($days <90) $days = 90;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("DELETE FROM `t_l2snr_hsmmpdata` WHERE ((`deviceid` = '$deviceid' AND `sensorid` ='$sensorid') AND (TO_DAYS(NOW()) - TO_DAYS(`date`) > '$days'))");
        $mysqli->close();
        return $result;
    }

    public function dbi_LatestHsmmpValue_inqury($sid)
    {
        $LatestHsmmpValue = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l2snr_hsmmpdata` WHERE `sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $LatestHsmmpValue = $row['videourl'];
        }
        $mysqli->close();
        return $LatestHsmmpValue;
    }


    //HCU历史视频查询
    public function dbi_videodata_inquiry_url($deviceid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
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

    //直接存储照片数据到数据库里，暂时没有采用这种机制
    public function dbi_picture_data_save($statcode, $timeStamp, $bindata)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $reportdate = date("Y-m-d", $timeStamp);
        $stamp = getdate($timeStamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/MFUN_TIME_GRID_SIZE)));

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $query_str = "SELECT * FROM `t_l2snr_picturedata` WHERE (`statcode` = '$statcode' AND `reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_picturedata` SET `bindata` = '$bindata' WHERE (`statcode` = '$statcode' AND `reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        else   //不存在，新增
        {
            $query_str = "INSERT INTO `t_l2snr_picturedata` (statcode,bindata,reportdate,hourminindex) VALUES ('$statcode','$bindata','$reportdate','$hourminindex')";
            $result=$mysqli->query($query_str);
        }
        $mysqli->close();
        return $result;
    }

    //将开锁抓拍照片信息存到开锁历史记录表中
    public function dbi_fhys_locklog_picture_name_save($statcode, $filename)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //查询该站点的最后一次开锁事件记录
        $query_str = "SELECT * FROM `t_l3fxprcm_fhys_locklog` WHERE `sid`= (SELECT MAX(sid) FROM `t_l3fxprcm_fhys_locklog` WHERE `statcode`= '$statcode' )";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $row = $result->fetch_array();
            $eventid = $row['sid'];
            $query_str = "UPDATE `t_l3fxprcm_fhys_locklog` SET `picname` = '$filename' WHERE (`sid` = '$eventid')";
            $result=$mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    public function dbi_fhys_locklog_picture_name_inqury($picname)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $statcode = "";
        //查询该站点的开锁事件照片记录
        $query_str = "SELECT * FROM `t_l3fxprcm_fhys_locklog`  WHERE (`picname`= '$picname')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $row = $result->fetch_array();
            $statcode = $row['statcode'];
        }

        $mysqli->close();
        return $statcode;
    }



    //保存照片信息到picturedata表中，对于FHYS这个可以不需要，直接将照片信息存到开锁记录表中，这样便于开锁抓拍照片关联查询
    public function dbi_door_open_picture_link_save($statcode, $timeStamp, $filelink, $filesize)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $reportdate = date("Y-m-d", $timeStamp);
        $stamp = getdate($timeStamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/MFUN_TIME_GRID_SIZE)));

        $filetype = "JPG";
        $filesize = (int)$filesize;
        $description = "站点".$statcode."上传的照片";
        $query_str = "INSERT INTO `t_l2snr_picturedata` (statcode,filename,filetype,filesize,filedescription,reportdate,hourminindex) VALUES ('$statcode','$filelink','$filetype','$filesize','$description','$reportdate','$hourminindex')";
        $result=$mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    public function dbi_door_open_picture_filesize_update($statcode, $deviceId, $timeStamp, $filename, $filesize)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $reportdate = date("Y-m-d", $timeStamp);
        $stamp = getdate($timeStamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/MFUN_TIME_GRID_SIZE)));

        $query_str = "SELECT * FROM `t_l2snr_picturedata` WHERE (`statcode` = '$statcode' AND `filename` = '$filename')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0) {
            $row = $result->fetch_array();
            $oldsize = (int)$row['filesize'];
            $newsize = (int)$filesize + $oldsize;
            $query_str = "UPDATE `t_l2snr_picturedata` SET `filesize` = '$newsize', `reportdate` = '$reportdate',`hourminindex` = '$hourminindex' WHERE (`statcode` = '$statcode' AND `filename` = '$filename')";
            $result=$mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    //删除对应用户所有超过90天的数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    public function dbi_pictureData_delete_3monold($statcode, $days)
    {
        if ($days <90) $days = 90;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("DELETE FROM `t_l2snr_picturedata` WHERE (`statcode` = '$statcode'  AND (TO_DAYS(NOW()) - TO_DAYS(`date`) > '$days'))");
        $mysqli->close();
        return $result;
    }

    //读取最新的bindata数据
    public function dbi_latestPictureData_inqury($statcode)
    {
        $LatestPictureValue = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `t_l2snr_picturedata` WHERE `statcode` = '$statcode'");
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $LatestPictureValue = $row['bindata'];
        }
        $mysqli->close();
        return $LatestPictureValue;
    }


}

?>