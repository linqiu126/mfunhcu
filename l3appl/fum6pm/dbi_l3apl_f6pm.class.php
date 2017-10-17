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
  `sid` int(4) NOT NULL,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `createtime` datetime NOT NULL,
  `restartCnt` int(4) NOT NULL DEFAULT '0',
  `networkConnCnt` int(4) NOT NULL DEFAULT '0',
  `networkConnFailCnt` int(4) NOT NULL DEFAULT '0',
  `networkDiscCnt` int(4) NOT NULL DEFAULT '0',
  `socketDiscCnt` int(4) NOT NULL DEFAULT '0',
  `cpuOccupy` int(4) NOT NULL DEFAULT '0',
  `memOccupy` int(4) NOT NULL DEFAULT '0',
  `diskOccupy` int(4) NOT NULL DEFAULT '0',
  `cpuTemp` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l3f6pm_perfdata`
--
ALTER TABLE `t_l3f6pm_perfdata`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l3f6pm_perfdata`
--
ALTER TABLE `t_l3f6pm_perfdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;

*/

class classDbiL3apF6pm
{
    //构造函数
    public function __construct()
    {

    }

    //查询用户授权的stat_code和proj_code list
    private function dbi_user_statproj_inqury($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //查询该用户授权的项目和项目组列表
        $query_str = "SELECT `auth_code` FROM `t_l3f1sym_authlist` WHERE `uid` = '$uid'";
        $result = $mysqli->query($query_str);
        $p_list = array();
        $pg_list = array();
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $temp = $row["auth_code"];
            $fromat = substr($temp, 0, MFUN_L3APL_F2CM_CODE_FORMAT_LEN);
            if($fromat == MFUN_L3APL_F2CM_PROJ_CODE_PREFIX)
                array_push($p_list,$temp);
            elseif ($fromat == MFUN_L3APL_F2CM_PG_CODE_PREFIX)
                array_push($pg_list,$temp);
        }

        //把授权的项目组列表里对应的项目号也取出来追加到项目列表，获得该用户授权的完整项目列表
        for($i=0; $i<count($pg_list); $i++){
            $query_str = "SELECT `p_code` FROM `t_l3f2cm_projinfo` WHERE `pg_code` = '$pg_list[$i]'";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($row = $result->fetch_array()) > 0))
            {
                $temp = $row["p_code"];
                array_push($p_list,$temp);
            }
        }
        //查询授权项目号下对应的所有监测点code
        $auth_list= array();
        for($i=0; $i<count($p_list); $i++){
            $query_str = "SELECT `statcode` FROM `t_l3f3dm_siteinfo` WHERE `p_code` = '$p_list[$i]'";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($row = $result->fetch_array()) > 0)){
                $temp = array("stat_code"=>$row["statcode"],"p_code"=>$p_list[$i]);
                array_push($auth_list ,$temp);
            }
        }
        //删除列表里重复的项
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $unique_authlist = $dbiL1vmCommonObj->unique_array($auth_list,false,true);

        $mysqli->close();
        return $unique_authlist;
    }

    //删除对应设备所有超期的告警数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    private function dbi_perform_data_3mondel($statCode, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("DELETE FROM `t_l3f6pm_perfdata` WHERE ((`statcode` = '$statCode') AND (TO_DAYS(NOW()) - TO_DAYS(`date`) > '$days'))");
        $mysqli->close();
        return $result;
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

        $auth_list = $this->dbi_user_statproj_inqury($uid);
        array_push($resp["column"], "设备编号");
        array_push($resp["column"], "监测点编号");
        array_push($resp["column"], "监测点名称");
        array_push($resp["column"], "地址");
        array_push($resp["column"], "报告时间");
        array_push($resp["column"], "系统重启次数");
        array_push($resp["column"], "网络连接统计");
        array_push($resp["column"], "网络连接失败");
        array_push($resp["column"], "网络断开统计");
        array_push($resp["column"], "Socket断开统计");
        array_push($resp["column"], "CPU占用");
        array_push($resp["column"], "内存占用");
        array_push($resp["column"], "硬盘占用");
        array_push($resp["column"], "CPU温度");


        for($i=0; $i<count($auth_list); $i++){
            $one_row = array();
            //$pcode = $auth_list[$i]["p_code"];
            $statCode = $auth_list[$i]["stat_code"];

            //删除超期的历史数据
            $this->dbi_perform_data_3mondel($statCode, MFUN_HCU_DATA_SAVE_DURATION_BY_PROJ);
            //查询站点相关信息
            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statCode'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows) > 0){
                $row = $result->fetch_array();
                $statName = $row["statname"];
                $address = $row["address"];
            }

            $query_str = "SELECT * FROM `t_l3f6pm_perfdata` WHERE `statcode` = '$statCode'";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($row = $result->fetch_array()) > 0)){
                $row = $result->fetch_array();
                $devcode = $row["devcode"];
                $createtime =  $row["createtime"];
                $restartCnt = $row["restartCnt"];
                $networkConnCnt = $row["networkConnCnt"];
                $networkConnFailCnt = $row["networkConnFailCnt"];
                $networkDiscCnt = $row["networkDiscCnt"];
                $socketDiscCnt = $row["socketDiscCnt"];
                $cpuOccupy = $row["cpuOccupy"]."%";
                $memOccupy = $row["memOccupy"]."%";
                $diskOccupy = $row["diskOccupy"]."%";
                $cpuTemp = $row["cpuTemp"]."C";

                array_push($one_row, $devcode);
                array_push($one_row, $statCode);
                array_push($one_row, $statName);
                array_push($one_row, $address);
                array_push($one_row, $createtime);
                array_push($one_row, $restartCnt);
                array_push($one_row, $networkConnCnt);
                array_push($one_row, $networkConnFailCnt);
                array_push($one_row, $networkDiscCnt);
                array_push($one_row, $socketDiscCnt);
                array_push($one_row, $cpuOccupy);
                array_push($one_row, $memOccupy);
                array_push($one_row, $diskOccupy);
                array_push($one_row, $cpuTemp);

                array_push($resp['data'], $one_row);
            }
        }

        $mysqli->close();
        return $resp;
    }
}
?>