<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/7/1
 * Time: 13:45
 */
//include_once "../../l1comvm/vmlayer.php";

/*

-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_iothcu_inventory`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_iothcu_inventory` (
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `opendate` date DEFAULT NULL,
  `macaddr_wlan0` varchar(20) DEFAULT NULL,
  `ip_wlan0` varchar(20) DEFAULT NULL,
  `macaddr_eth0` char(20) DEFAULT NULL,
  `socketid` int(2) DEFAULT '0',
  `status` char(1) NOT NULL DEFAULT 'Y',
  `simcard` char(20) DEFAULT NULL,
  `hw_type` int(1) DEFAULT NULL,
  `hw_ver` int(2) DEFAULT NULL,
  `sw_rel` int(1) DEFAULT NULL,
  `sw_drop` int(2) DEFAULT NULL,
  `ver_base` char(1) NOT NULL DEFAULT '1',
  `hcu_db_ver` int(4) NOT NULL DEFAULT '1',
  `videourl` char(100) DEFAULT NULL,
  `camctrl` char(100) DEFAULT NULL,
  `boxpic` mediumblob,
  `hcu_sw_autoupdate` tinyint(1) NOT NULL DEFAULT '0',
  `hcu_db_autoupdate` tinyint(1) NOT NULL DEFAULT '0',
  `http_ui` varchar(100) DEFAULT NULL,
  `video_port` int(4) DEFAULT NULL,
  `rtsp_port` int(4) DEFAULT NULL,
  `service_port` int(4) DEFAULT NULL,
  `ssh_port` int(4) DEFAULT NULL,
  `vnc_port` int(4) DEFAULT NULL,
  `image_version` varchar(20) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `desc` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l2sdk_iothcu_inventory`
--
ALTER TABLE `t_l2sdk_iothcu_inventory`
  ADD PRIMARY KEY (`devcode`),
  ADD UNIQUE KEY `statcode` (`statcode`);
 */

class classDbiL2sdkIotcom
{
    //验证设备的合法性，输入的设备编号是否在HCU设备信息表（t_l2sdk_iothcu_inventory）中有记录
    public function dbi_hcuDevice_valid_device($devcode)
    {
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT `statcode` FROM `t_l2sdk_iothcu_inventory` WHERE (`devcode` = '$devcode')");

        if ($result->num_rows>0){
            $row = $result->fetch_array();
            $result = $row['statcode'];
        }
        else
            $result = "";

        $mysqli->close();
        return $result;
    }

    //验证HCU设备信息表中设备编号对应的MAC地址的合法性
    public function dbi_hcuDevice_valid_mac($devcode, $mac)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`devcode` = '$devcode'AND `macaddr` = '$mac') ");
        if ($result->num_rows>0)
            $result = true;
        else
            $result = false;

        $mysqli->close();
        return $result;
    }

    public function dbi_hcuDevice_update_status($devcode, $statcode, $status)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //因为devcode和statcode已经检查存在,所以直接更新状态
        $result = $mysqli->query("UPDATE `t_l2sdk_iothcu_inventory` SET `status` = '$status' WHERE `devcode` = '$devcode' AND `statcode` = '$statcode'");

        $mysqli->close();
        return $result;
    }

    //查询所有HCU list
    public function dbi_hcuDevice_inquiry_device()
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT `devcode` FROM `t_l2sdk_iothcu_inventory` WHERE 1");

        $i=0;
        while($row = $result->fetch_array())
        {
            $resp[$i]["devcode"] = $row['devcode'];
            $i++;
        }
        if ($i == 0) $resp = false;

        $mysqli->close();
        return $resp;
    }

    public function dbi_huitp_huc_socketid_update($devcode, $socketid)
    {
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "UPDATE `t_l2sdk_iothcu_inventory` SET `socketid` = '$socketid' WHERE (`devcode` = '$devcode')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

}

?>