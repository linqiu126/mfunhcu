<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 23:00
 */
//include_once "../../l1comvm/vmlayer.php";

/*
//性能统计数据
//如果涉及到区分，则需要通过具体的dbi函数来完成
//DBI函数仅仅是样例

-- --------------------------------------------------------
--
-- 表的结构 `t_l3f6pm_perfdata`
--

CREATE TABLE IF NOT EXISTS `t_l3f6pm_perfdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` int(4) NOT NULL,
  `sensorid` int(4) NOT NULL,
  `stability` int(4) NOT NULL,
  `errcnt` int(4) NOT NULL,
  `timeupdate` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_l3f6pm_perfdata`
--

INSERT INTO `t_l3f6pm_perfdata` (`sid`, `deviceid`, `sensorid`, `stability`) VALUES
(1, 111, 15, 90);

*/

class classDbiL3apF6pm
{
    //构造函数
    public function __construct()
    {

    }

    public function dbi_perform_data_save($sid, $stability)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l3f6pm_perfdata` WHERE (`sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l3f6pm_perfdata` SET  `stability` = '$stability' WHERE (`sid` = '$sid')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l3f6pm_perfdata` (sid, stability) VALUES ('$sid', '$stability')");
        }
        $mysqli->close();
        return $result;
    }

    //删除对应用户所有超过90天的数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    public function dbi_perform_data_3mondel($sid, $days)
    {
        if ($days <90) $days = 90;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("DELETE FROM `t_l3f6pm_perfdata` WHERE ((`sid` = '$sid') AND (TO_DAYS(NOW()) - TO_DAYS(`date`) > '$days'))");
        $mysqli->close();
        return $result;
    }

    public function dbi_perform_data_inqury($sid)
    {
        $LatestValue = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l3f6pm_perfdata` WHERE `sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $LatestValue = $row['stability'];
        }
        $mysqli->close();
        return $LatestValue;
    }

}
?>