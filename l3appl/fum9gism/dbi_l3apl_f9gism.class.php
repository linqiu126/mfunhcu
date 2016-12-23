<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 23:01
 */
header("Content-type:text/html;charset=utf-8");
//include_once "../../l1comvm/vmlayer.php";

/*
//指挥调度模块
//如果涉及到区分，则需要通过具体的dbi函数来完成
//DBI函数仅仅是样例
-- --------------------------------------------------------
--
-- 表的结构 `t_l3f9gism_scheduledirection`
--

CREATE TABLE IF NOT EXISTS `t_l3f9gism_scheduledirection` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `title` char(50) NOT NULL,
  `perf1` int(4) NOT NULL,
  `perf2` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_l3f9gism_scheduledirection`
--

INSERT INTO `t_l3f9gism_scheduledirection` (`sid`, `title`) VALUES
(1, "上海浦东污染形势图");

//事故调度模块
-- --------------------------------------------------------
--
-- 表的结构 `t_l3f9gism_accidencedirection`
--

CREATE TABLE IF NOT EXISTS `t_l3f9gism_accidencedirection` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `title` char(50) NOT NULL,
  `content1` char(50) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_l3f9gism_accidencedirection`
--

INSERT INTO `t_l3f9gism_accidencedirection` (`sid`, `title`) VALUES
(1, "上海中江公司污染事故应急处理态势一览表");

*/



class classDbiL3apF9gism
{
    //构造函数
    public function __construct()
    {

    }

    public function dbi_schedule_direction_save($sid, $title)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l3f9gism_scheduledirection` WHERE (`sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l3f9gism_scheduledirection` SET  `title` = '$title' WHERE (`sid` = '$sid')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l3f9gism_scheduledirection` (sid, title) VALUES ('$sid', '$title')");
        }
        $mysqli->close();
        return $result;
    }

    //删除对应用户所有超过90天的数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    public function dbi_schedule_direction_3mondel($sid, $days)
    {
        if ($days <90) $days = 90;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("DELETE FROM `t_l3f9gism_scheduledirection` WHERE ((`sid` = '$sid') AND (TO_DAYS(NOW()) - TO_DAYS(`date`) > '$days'))");
        $mysqli->close();
        return $result;
    }

    public function dbi_schedule_direction_inqury($sid)
    {
        $LatestValue = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l3f9gism_scheduledirection` WHERE `sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $LatestValue = $row['title'];
        }
        $mysqli->close();
        return $LatestValue;
    }


    
}

?>