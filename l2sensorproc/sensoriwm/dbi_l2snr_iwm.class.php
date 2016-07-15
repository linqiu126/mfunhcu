<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/7/15
 * Time: 9:36
 */
/*
--
-- 表的结构 `t_l2snr_iwm_data_cj188`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_iwm_data_cj188` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `cj188address` char(14) NOT NULL,
  `equtype` int(1) NOT NULL,
  `flowvolume` float(6,2) NOT NULL,
  `flowvolumeuint` int(1) NOT NULL,
  `currentaccuvolume` float(6,2) NOT NULL,
  `currentaccuvolumeuint` int(1) NOT NULL,
  `todayaccuvolume` float(6,2) NOT NULL,
  `todayaccuvolumeuint` int(1) NOT NULL,
  `lastmonth` int(1) NOT NULL,
  `accumuworktime` int(3) NOT NULL,
  `supplywatertemp` float(4,2) NOT NULL,
  `backwatertemp` float(4,2) NOT NULL,
  `realtime` char(14) NOT NULL,
  `st` char(4) NOT NULL,
  `todaydate` char(2) NOT NULL,
  `key` int(8) NOT NULL,
  `buycode` int(1) NOT NULL,
  `amount` float(6,2) NOT NULL,
  `price` float(4,2) NOT NULL,
  `volume` int(3) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



*/

class classDbiL2snrIwm
{
    //构造函数
    public function __construct()
    {

    }

    public function dbi_iwm_std_cj188_data_save($cj188address, $equtype, $curaccuvolume, $curaccuvolumeunit, $todayaccuvolume, $todayaccuvolumeunit, $realtime, $st)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        $result=$mysqli->query("INSERT INTO `t_l2snr_iwm_data_cj188` (cj188address, equtype, currentaccuvolume, currentaccuvolumeuint, todayaccuvolume, todayaccuvolumeuint, realtime, st)
                    VALUES ('$cj188address','$equtype','$curaccuvolume','$curaccuvolumeunit','$todayaccuvolume','$todayaccuvolumeunit','$realtime','$st')");

        $mysqli->close();
        return $result;
    }

    public function dbi_iwm_std_cj188_data_save_last_month($cj188address, $equtype, $curaccuvolume, $curaccuvolumeunit, $lastmonth)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        $result=$mysqli->query("INSERT INTO `t_l2snr_iwm_data_cj188` (cj188address, equtype, todayaccuvolume, todayaccuvolumeuint, lastmonth)
                    VALUES ('$cj188address','$equtype','$curaccuvolume','$curaccuvolumeunit', '$lastmonth')");

        $mysqli->close();
        return $result;
    }

}


?>