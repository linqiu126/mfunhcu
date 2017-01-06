<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 23:00
 */
header("Content-type:text/html;charset=utf-8");
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

    public function dbi_aqyc_performance_table_req($uid)
    {
        //初始化返回值
        $resp["column"] = array();
        $resp['data'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $auth_list["stat_code"] = array();
        $auth_list["p_code"] = array();
        $dbiL3apF3dmObj = new classDbiL3apF3dm();
        $auth_list = $dbiL3apF3dmObj->dbi_user_statproj_inqury($uid);

        array_push($resp["column"], "设备编号");
        array_push($resp["column"], "监测点编号");
        array_push($resp["column"], "监测点名称");
        array_push($resp["column"], "地址");
        array_push($resp["column"], "报告时间");
        array_push($resp["column"], "CurlConnAttempt");
        array_push($resp["column"], "CurlConnFailCnt");
        array_push($resp["column"], "CurlDiscCnt");
        array_push($resp["column"], "SocketDiscCnt");
        array_push($resp["column"], "PmTaskRestartCnt");
        array_push($resp["column"], "CPUOccupyCnt");
        array_push($resp["column"], "MemOccupyCnt");
        array_push($resp["column"], "DiskOccupyCnt");


        for($i=0; $i<count($auth_list["stat_code"]); $i++)
        {
            $one_row = array();
            $pcode = $auth_list["p_code"][$i];
            $statcode = $auth_list["stat_code"][$i];

            $query_str = "SELECT * FROM `t_l3f6pm_perfdata` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);

            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                $devcode = $row["devcode"];
                $createtime =  $row["createtime"];
                $curlConnAttempt = $row["CurlConnAttempt"];
                $curlConnFailCnt = $row["CurlConnFailCnt"];
                $curlDiscCnt = $row["CurlDiscCnt"];
                $socketDiscCnt = $row["SocketDiscCnt"];
                $pmTaskRestartCnt = $row["PmTaskRestartCnt"];
                $cpuOccupyCnt = $row["CPUOccupyCnt"];
                $memOccupyCnt = $row["MemOccupyCnt"];
                $diskOccupyCnt = $row["DiskOccupyCnt"];


                $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";
                $result = $mysqli->query($query_str);
                if (($result->num_rows) > 0)
                {
                    $row = $result->fetch_array();
                    array_push($one_row, $devcode);
                    array_push($one_row, $statcode);
                    array_push($one_row, $row["statname"]);
                    array_push($one_row, $row["address"]);
                    array_push($one_row, $createtime);
                    array_push($one_row, $curlConnAttempt);
                    array_push($one_row, $curlConnFailCnt);
                    array_push($one_row, $curlDiscCnt);
                    array_push($one_row, $socketDiscCnt);
                    array_push($one_row, $pmTaskRestartCnt);
                    array_push($one_row, $cpuOccupyCnt);
                    array_push($one_row, $memOccupyCnt);
                    array_push($one_row, $diskOccupyCnt);
                }
            }

            array_push($resp['data'], $one_row);
        }

        $mysqli->close();
        return $resp;
    }


}
?>