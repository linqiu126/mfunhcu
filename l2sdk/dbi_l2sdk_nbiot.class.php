<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/7/11
 * Time: 15:40
 */
/*
-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_nbiot_std_qg376_context`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_nbiot_std_qg376_context` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `ipmaddress` int(4) NOT NULL,
  `cntpfc` int(1) NOT NULL,
  `deviceflag` int(1) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 转存表中的数据 `t_l2sdk_nbiot_std_qg376_context`
--

INSERT INTO `t_l2sdk_nbiot_std_qg376_context` (`sid`, `ipmaddress`, `cntpfc`, `deviceflag`) VALUES (1, 111, 17, 1);


--
-- 表的结构 `t_l2sdk_nbiot_std_cj188_context`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_nbiot_std_cj188_context` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `cj188address` char(14) NOT NULL,
  `cntser` int(1) NOT NULL,
  `deviceflag` int(1) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 转存表中的数据 `t_l2sdk_nbiot_std_cj188_context`
--

INSERT INTO `t_l2sdk_nbiot_std_cj188_context` (`sid`, `cj188address`, `cntser`, `deviceflag`) VALUES (1, 111, 17, 1);


*/

class classDbiL2sdkNbiotIpm376
{
    //构造函数
    public function __construct()
    {

    }

    public function dbi_ipm376_context_data_save($ipmaddress, $cntpfc, $deviceflag)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_nbiot_std_qg376_context` WHERE (`deviceid` = '$ipmaddress')");
        if (($result != false) && ($result->num_rows)>0)  //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l2sdk_nbiot_std_qg376_context` SET  `cntpfc` = '$cntpfc',`deviceflag` = '$deviceflag'
                    WHERE (`ipmaddress` = '$ipmaddress')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2sdk_nbiot_std_qg376_context` (ipmaddress, cntpfc, deviceflag)
                    VALUES ('$ipmaddress','$cntpfc','$deviceflag')");
        }

        $mysqli->close();
        return $result;
    }

    //先只放一个返回值
    public function dbi_ipm376_context_pfc_inqury($ipmaddress)
    {
        $LatestValue = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_nbiot_std_qg376_context` WHERE `ipmaddress` = '$ipmaddress'");
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $LatestValue = $row['cntpfc'];
        }
        $mysqli->close();
        return $LatestValue;
    }


}

class classDbiL2sdkNbiotStdCj188
{
    //构造函数
    public function __construct()
    {

    }

    public function dbi_std_cj188_context_data_save($cj188address, $cntser, $deviceflag)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_nbiot_std_cj188_context` WHERE (`deviceid` = '$cj188address')");
        if (($result != false) && ($result->num_rows)>0)  //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l2sdk_nbiot_std_cj188_context` SET  `cntpfc` = '$cntser',`deviceflag` = '$deviceflag'
                    WHERE (`ipmaddress` = '$cj188address')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2sdk_nbiot_std_cj188_context` (ipmaddress, cntser, deviceflag)
                    VALUES ('$cj188address','$cntser','$deviceflag')");
        }

        $mysqli->close();
        return $result;
    }

    //先只放一个返回值
    public function dbi_std_cj188_context_ser_inqury($cj188address)
    {
        $LatestValue = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_nbiot_std_cj188_context` WHERE `cj188address` = '$cj188address'");
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $LatestValue = $row['cntser'];
        }
        $mysqli->close();
        return $LatestValue;
    }

    public function dbi_std_cj188_cntser_increase($cj188address)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_nbiot_std_cj188_context` WHERE (`cj188address` = '$cj188address')");
        if (($result != false) && ($result->num_rows)>0)  //重复，则覆盖
        {
            $row = $result->fetch_array();
            $LatestValue = ($row['cntser'] + 1) % 256;
            $result=$mysqli->query("UPDATE `t_l2sdk_nbiot_std_cj188_context` SET  `cntser` = '$LatestValue'
                    WHERE (`cj188address` = '$cj188address')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2sdk_nbiot_std_cj188_context` (cj188address, cntser)
                    VALUES ('$cj188address', 0)");
        }

        $mysqli->close();
        return $result;
    }

    public function dbi_std_cj188_cntser_set_value($cj188address, $ser)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) { die('Could not connect: ' . mysqli_error($mysqli)); }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_nbiot_std_cj188_context` WHERE (`cj188address` = '$cj188address')");
        if (($result != false) && ($result->num_rows)>0)  //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l2sdk_nbiot_std_cj188_context` SET  `cntser` = '$ser' WHERE (`cj188address` = '$cj188address')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l2sdk_nbiot_std_cj188_context` (cj188address, cntser)
                    VALUES ('$cj188address', '$ser')");
        }

        $mysqli->close();
        return $result;
    }
}

?>
