<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 23:00
 */
//include_once "../../l1comvm/vmlayer.php";

/*

//该数据表单的逻辑是试图将所有的不同参数组成一个大表，通过SENSOR_ID来记录不同SENSOR的仪表操控状态
//由于不同仪表的潜在操控参数不完全一样，这里是讲所有可能的仪表参数组合成为一个大表，而不再为不同仪表进行区分
//如果涉及到区分，则需要通过具体的dbi函数来完成
//这个表格是否与设备中SENSOR列表相互冲突，待完善

-- --------------------------------------------------------
--
-- 表的结构 `t_l3f4icm_sensorctrltable`
--

CREATE TABLE IF NOT EXISTS `t_l3f4icm_sensorctrltable` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(20) NOT NULL,
  `sensorid` int(2) NOT NULL,
  `equid` int(2) NOT NULL,
  `sensortype` char(10) NOT NULL,
  `workingcycle` int(2) NOT NULL,
  `onoffstatus` tinyint(1) NOT NULL,
  `sampleduaration` int(2) NOT NULL,
  `paralpha` int(2) NOT NULL,
  `parbeta` int(2) NOT NULL,
  `pargama` int(2) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_l3f4icm_sensorctrltable`
--

INSERT INTO `t_l3f4icm_sensorctrltable` (`sid`, `deviceid`, `sensorid`, `equid`, `sensortype`, `workingcycle`, `onoffstatus`, `sampleduaration`, `paralpha`, `parbeta`, `pargama`) VALUES
(1, 'HCU301_22', 111, 6, '风速', 0, 0, 0, 0, 0, 0);

*/

class classDbiL3apF4icm
{
    //构造函数
    public function __construct()
    {

    }

    public function dbi_sensor_control_table_save($deviceid, $sensorid, $equid, $sensortype)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l3f4icm_sensorctrltable` WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid'");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l3f4icm_sensorctrltable` SET  `equid` = '$equid',`sensortype` = '$sensortype' WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l3f4icm_sensorctrltable` (deviceid,sensorid,equid,sensortype)
                    VALUES ('$deviceid','$sensorid','$equid','$sensortype')");
        }
        $mysqli->close();
        return $result;
    }

    //删除对应用户所有超过90天的数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    public function dbi_sensor_control_table_3mondel($deviceid, $sensorid, $days)
    {
        if ($days <90) $days = 90;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("DELETE FROM `t_l3f4icm_sensorctrltable` WHERE ((`deviceid` = '$deviceid' AND `sensorid` ='$sensorid') AND (TO_DAYS(NOW()) - TO_DAYS(`date`) > '$days'))");
        $mysqli->close();
        return $result;
    }

    public function dbi_sensor_control_table_inqury($sid)
    {
        $LatestValue = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l3f4icm_sensorctrltable` WHERE `sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $LatestValue = $row['sensorid'];
        }
        $mysqli->close();
        return $LatestValue;
    }


}

?>