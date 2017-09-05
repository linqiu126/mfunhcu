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
//工单管理
//如果涉及到区分，则需要通过具体的dbi函数来完成
//DBI函数仅仅是样例

-- --------------------------------------------------------

--
-- 表的结构 `t_l3fxprcm_fhys_locklog`
--

CREATE TABLE IF NOT EXISTS `t_l3fxprcm_fhys_locklog` (
  `sid` int(2) NOT NULL,
  `woid` char(10) DEFAULT '0',
  `keyid` char(10) NOT NULL,
  `keyname` char(20) NOT NULL,
  `keyuserid` char(10) NOT NULL,
  `keyusername` varchar(20) NOT NULL,
  `eventtype` char(1) NOT NULL,
  `statcode` varchar(20) NOT NULL,
  `createtime` char(20) NOT NULL,
  `picname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l3fxprcm_fhys_locklog`
--
ALTER TABLE `t_l3fxprcm_fhys_locklog`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l3fxprcm_fhys_locklog`
--
ALTER TABLE `t_l3fxprcm_fhys_locklog`
  MODIFY `sid` int(2) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------
--
-- 表的结构 `t_l3fxprcm_workerbill`
--

CREATE TABLE IF NOT EXISTS `t_l3fxprcm_workerbill` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `task1` char(50) NOT NULL,
  `approval1` char(50) NOT NULL,
  `state` char(50) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_l3fxprcm_workerbill`
--

INSERT INTO `t_l3fxprcm_workerbill` (`sid`, `task1`) VALUES
(1, "浦东中环巡视任务");

*/


class classDbiL3apFxPrcm
{
    //构造函数
    public function __construct()
    {

    }

    public function dbi_worker_bill_save($sid, $task1)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l3fxprcm_workerbill` WHERE (`sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l3fxprcm_workerbill` SET  `task1` = '$task1' WHERE (`sid` = '$sid')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l3fxprcm_workerbill` (sid, task1) VALUES ('$sid', '$task1')");
        }
        $mysqli->close();
        return $result;
    }

    //删除对应用户所有超过90天的数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    public function dbi_worker_bill_3mondel($sid, $days)
    {
        if ($days <90) $days = 90;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("DELETE FROM `t_l3fxprcm_workerbill` WHERE ((`sid` = '$sid') AND (TO_DAYS(NOW()) - TO_DAYS(`date`) > '$days'))");
        $mysqli->close();
        return $result;
    }

    public function dbi_worker_bill_inqury($sid)
    {
        $LatestValue = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l3fxprcm_workerbill` WHERE `sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $LatestValue = $row['task1'];
        }
        $mysqli->close();
        return $LatestValue;
    }

    
}

?>