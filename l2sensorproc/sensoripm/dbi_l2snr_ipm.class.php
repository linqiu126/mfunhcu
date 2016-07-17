<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/7/11
 * Time: 11:59
 */
/*
-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_ipm_afndata1_f25`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_ipm_afndata1_f25` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` int(4) NOT NULL,
  `cur_terminaltime` char(20) NOT NULL,
  `cur_sumusepower` int(3) NOT NULL,
  `cur_phaseausepwr` int(3) NOT NULL,
  `cur_phasebusepwr` int(3) NOT NULL,
  `cur_phasecusepwr` int(3) NOT NULL,
  `cur_sumnupower` int(3) NOT NULL,
  `cur_phaseanupwr` int(3) NOT NULL,
  `cur_phasebnupwr` int(3) NOT NULL,
  `cur_sumphasecnupwr` int(3) NOT NULL,
  `cur_powerfactor` int(2) NOT NULL,
  `cur_phaseapwrfac` int(2) NOT NULL,
  `cur_phasebpwrfac` int(2) NOT NULL,
  `cur_phasecpwrfac` int(2) NOT NULL,
  `cur_phaseavoltage` int(2) NOT NULL,
  `cur_phasebvoltage` int(2) NOT NULL,
  `cur_phasecvoltage` int(2) NOT NULL,
  `cur_phaseacurrent` int(3) NOT NULL,
  `cur_phasebcurrent` int(3) NOT NULL,
  `cur_phaseccurrent` int(3) NOT NULL,
  `cur_zeroordercurrent` int(3) NOT NULL,
  `cur_sumvisualpower` int(3) NOT NULL,
  `cur_phaseavisualpower` int(3) NOT NULL,
  `cur_phasebvisualpower` int(3) NOT NULL,
  `cur_phasecvisualpower` int(3) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 转存表中的数据 `t_l2snr_ipm_afndata1_f25`
--

INSERT INTO `t_l2snr_ipm_afndata1_f25` (`sid`, `deviceid`, `cur_terminaltime`, `cur_sumusepower`, `cur_phaseausepwr`, `cur_phasebusepwr`, `cur_phasecusepwr`,
`cur_sumnupower`, `cur_phaseanupwr`, `cur_phasebnupwr`, `cur_sumphasecnupwr`, `cur_powerfactor`, `cur_phaseapwrfac`, `cur_phasebpwrfac`, `cur_phasecpwrfac`,
`cur_phaseavoltage`, `cur_phasebvoltage`, `cur_phasecvoltage`, `cur_phaseacurrent`, `cur_phasebcurrent`, `cur_phaseccurrent`, `cur_zeroordercurrent`, `cur_sumvisualpower`,
`cur_phaseavisualpower`, `cur_phasebvisualpower`, `cur_phasecvisualpower`) VALUES
(1, 111, '111111', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

--
-- 表的结构 `t_l2snr_ipmdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_ipmdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `cj188address` char(14) NOT NULL,
  `equtype` int(1) NOT NULL,
  `flowvolume` float(8,2) NOT NULL,
  `flowvolumeuint` int(1) NOT NULL,
  `currentaccuvolume` float(8,2) NOT NULL,
  `currentaccuvolumeuint` int(1) NOT NULL,
  `todayaccuvolume` float(8,2) NOT NULL,
  `todayaccuvolumeuint` int(1) NOT NULL,
  `lastmonth` int(1) NOT NULL,
  `accumuworktime` int(3) NOT NULL,
  `supplywatertemp` float(6,2) NOT NULL,
  `backwatertemp` float(6,2) NOT NULL,
  `realtime` char(14) NOT NULL,
  `st` char(4) NOT NULL,
  `billdate` int(1) NOT NULL,
  `readdate` int(1) NOT NULL,
  `key` int(8) NOT NULL,
  `price1` float(6,2) NOT NULL,
  `volume1` int(3) NOT NULL,
  `price2` float(6,2) NOT NULL,
  `volume2` int(3) NOT NULL,
  `price3` float(6,2) NOT NULL,
  `buycode` int(1) NOT NULL,
  `thisamount` float(8,2) NOT NULL,
  `accuamount` float(8,2) NOT NULL,
  `remainamount` float(8,2) NOT NULL,
  `keyver` int(1) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



*/

class classDbiL2snrIpm
{
    //构造函数
    public function __construct()
    {

    }

    public function dbi_ipm_afndata1_f25_data_save($deviceid, $cur_terminaltime, $cur_sumusepower, $cur_phaseausepwr, $cur_phasebusepwr, $cur_phasecusepwr, $cur_sumnupower,
                                      $cur_phaseanupwr, $cur_phasebnupwr, $cur_sumphasecnupwr, $cur_powerfactor, $cur_phaseapwrfac, $cur_phasebpwrfac, $cur_phasecpwrfac,
                                      $cur_phaseavoltage, $cur_phasebvoltage, $cur_phasecvoltage, $cur_phaseacurrent, $cur_phasebcurrent, $cur_phaseccurrent,
                                      $cur_zeroordercurrent, $cur_sumvisualpower, $cur_phaseavisualpower, $cur_phasebvisualpower, $cur_phasecvisualpower)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        $result=$mysqli->query("INSERT INTO `t_l2snr_ipm_afndata1_f25` (deviceid, cur_terminaltime, cur_sumusepower, cur_phaseausepwr, cur_phasebusepwr, cur_phasecusepwr,
                    cur_sumnupower, cur_phaseanupwr, cur_phasebnupwr, cur_sumphasecnupwr, cur_powerfactor, cur_phaseapwrfac, cur_phasebpwrfac, cur_phasecpwrfac,
                    cur_phaseavoltage, cur_phasebvoltage, cur_phasecvoltage, cur_phaseacurrent, cur_phasebcurrent, cur_phaseccurrent, cur_zeroordercurrent, cur_sumvisualpower,
                    cur_phaseavisualpower, cur_phasebvisualpower, cur_phasecvisualpower)
                    VALUES ('$deviceid', '$cur_terminaltime', '$cur_sumusepower', '$cur_phaseausepwr', '$cur_phasebusepwr', '$cur_phasecusepwr', '$cur_sumnupower', '$cur_phaseanupwr',
                    '$cur_phasebnupwr', '$cur_sumphasecnupwr', '$cur_powerfactor', '$cur_phaseapwrfac', '$cur_phasebpwrfac', '$cur_phasecpwrfac', '$cur_phaseavoltage',
                    '$cur_phasebvoltage', '$cur_phasecvoltage', '$cur_phaseacurrent', '$cur_phasebcurrent', '$cur_phaseccurrent', '$cur_zeroordercurrent', '$cur_sumvisualpower',
                    '$cur_phaseavisualpower', '$cur_phasebvisualpower', '$cur_phasecvisualpower')");

        $mysqli->close();
        return $result;
    }

    //删除对应用户所有超过90天的数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    public function dbi_ipm_afndata1_f25_data_delete_3monold($deviceid, $days)
    {
        if ($days <90) $days = 90;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("DELETE FROM `t_l2snr_ipm_afndata1_f25` WHERE ((`deviceid` = '$deviceid') AND (TO_DAYS(NOW()) - TO_DAYS(`date`) > '$days'))");
        $mysqli->close();
        return $result;
    }

    //先只放一个返回值
    public function dbi_ipm_afndata1_f25_data_inqury($sid)
    {
        $LatestValue = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l2snr_ipm_afndata1_f25` WHERE `sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $LatestValue = $row['cur_sumusepower'];
        }
        $mysqli->close();
        return $LatestValue;
    }

    public function dbi_ipm_std_cj188_data_save($cj188address, $equtype, $curaccuvolume, $curaccuvolumeunit, $todayaccuvolume, $todayaccuvolumeunit, $realtime, $st)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        $result=$mysqli->query("INSERT INTO `t_l2snr_ipmdata` (cj188address, equtype, currentaccuvolume, currentaccuvolumeuint, todayaccuvolume, todayaccuvolumeuint, realtime, st)
                    VALUES ('$cj188address','$equtype','$curaccuvolume','$curaccuvolumeunit','$todayaccuvolume','$todayaccuvolumeunit','$realtime','$st')");

        $mysqli->close();
        return $result;
    }

    public function dbi_ipm_std_cj188_data_save_last_month($cj188address, $equtype, $curaccuvolume, $curaccuvolumeunit, $lastmonth)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        $result=$mysqli->query("INSERT INTO `t_l2snr_ipmdata` (cj188address, equtype, todayaccuvolume, todayaccuvolumeuint, lastmonth)
                    VALUES ('$cj188address','$equtype','$curaccuvolume','$curaccuvolumeunit', '$lastmonth')");

        $mysqli->close();
        return $result;
    }

    public function dbi_ipm_std_cj188_data_save_price($cj188address, $equtype, $price1, $volume1, $price2, $volume2, $price3)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        $result=$mysqli->query("INSERT INTO `t_l2snr_ipmdata` (cj188address, equtype, price1, volume1, price2, volume2, price3)
                    VALUES ('$cj188address','$equtype','$price1','$volume1', '$price2','$volume2', '$price3')");

        $mysqli->close();
        return $result;
    }

    public function dbi_ipm_std_cj188_data_save_bill_date($cj188address, $equtype, $billdate)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        $result=$mysqli->query("INSERT INTO `t_l2snr_ipmdata` (cj188address, equtype, billdate)
                    VALUES ('$cj188address','$equtype','$billdate')");

        $mysqli->close();
        return $result;
    }

    public function dbi_ipm_std_cj188_data_save_read_date($cj188address, $equtype, $readdate)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        $result=$mysqli->query("INSERT INTO `t_l2snr_ipmdata` (cj188address, equtype, readdate)
                    VALUES ('$cj188address','$equtype','$readdate')");

        $mysqli->close();
        return $result;
    }

    public function dbi_ipm_std_cj188_data_save_buy_amount($cj188address, $equtype, $bc, $thisamount, $accuamount, $remainamount)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        $result=$mysqli->query("INSERT INTO `t_l2snr_ipmdata` (cj188address, equtype, buycode, thisamount, accuamount, remainamount)
                    VALUES ('$cj188address','$equtype','$bc','$thisamount','$accuamount','$remainamount')");

        $mysqli->close();
        return $result;
    }

    public function dbi_ipm_std_cj188_data_save_key_ver($cj188address, $equtype, $keyver)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        $result=$mysqli->query("INSERT INTO `t_l2snr_ipmdata` (cj188address, equtype, keyver)
                    VALUES ('$cj188address','$equtype','$keyver')");

        $mysqli->close();
        return $result;
    }

    public function dbi_ipm_std_cj188_data_save_address($cj188address, $equtype)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        $result=$mysqli->query("INSERT INTO `t_l2snr_ipmdata` (cj188address, equtype)
                    VALUES ('$cj188address','$equtype')");

        $mysqli->close();
        return $result;
    }

    public function dbi_ipm_std_cj188_data_save_write_st($cj188address, $equtype, $st)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        $result=$mysqli->query("INSERT INTO `t_l2snr_ipmdata` (cj188address, equtype, st)
                    VALUES ('$cj188address','$equtype','$st')");

        $mysqli->close();
        return $result;
    }

    //是否需要单独建BUYAMOUNT数据域，待定
    public function dbi_ipm_std_cj188_data_save_write_buy_amount($cj188address, $equtype, $bc, $buyamount)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        $result=$mysqli->query("INSERT INTO `t_l2snr_ipmdata` (cj188address, equtype, buycode, accuamount)
                    VALUES ('$cj188address','$equtype','$bc','$buyamount')");

        $mysqli->close();
        return $result;
    }

    public function dbi_ipm_std_cj188_data_save_key($cj188address, $equtype, $key)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        $result=$mysqli->query("INSERT INTO `t_l2snr_ipmdata` (cj188address, equtype, key)
                    VALUES ('$cj188address','$equtype','$key')");

        $mysqli->close();
        return $result;
    }



}


?>