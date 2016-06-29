<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2016/1/6
 * Time: 13:38
 * Description: this file provide database API for business intelligence
 */

//include_once "../l1comvm/vmlayer.php";

/*

-- --------------------------------------------------------

--
-- 表的结构 `t_hourreport`
--

CREATE TABLE IF NOT EXISTS `t_hourreport` (
`sid` int(4) NOT NULL AUTO_INCREMENT,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourindex` int(1) NOT NULL,
  `emcvalue` int(4) DEFAULT NULL,
  `pm01` int(4) DEFAULT NULL,
  `pm25` int(4) DEFAULT NULL,
  `pm10` int(4) DEFAULT NULL,
  `noise` int(4) DEFAULT NULL,
  `windspeed` int(4) DEFAULT NULL,
  `winddirection` int(4) DEFAULT NULL,
  `rain` int(4) DEFAULT NULL,
  `temperature` int(4) DEFAULT NULL,
  `humidity` int(4) DEFAULT NULL,
  `airpressure` int(4) DEFAULT NULL,
  `datastatus` char(10) DEFAULT NULL,
  `validdatanum` int(1) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `t_hourreport`
--

INSERT INTO `t_hourreport` (`sid`, `devcode`, `statcode`, `reportdate`, `hourindex`, `emcvalue`, `pm01`, `pm25`, `pm10`, `noise`, `windspeed`, `winddirection`, `rain`, `temperature`, `humidity`, `airpressure`, `datastatus`, `validdatanum`) VALUES
(1, '', NULL, '0000-00-00', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '', NULL, '0000-00-00', 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '', NULL, '0000-00-00', 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '', NULL, '0000-00-00', 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '', NULL, '0000-00-00', 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '', NULL, '0000-00-00', 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '', NULL, '0000-00-00', 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '', NULL, '0000-00-00', 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '', NULL, '0000-00-00', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '', NULL, '0000-00-00', 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '', NULL, '0000-00-00', 0, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '', NULL, '0000-00-00', 0, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '', NULL, '0000-00-00', 0, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '', NULL, '0000-00-00', 0, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '', NULL, '0000-00-00', 0, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '', NULL, '0000-00-00', 0, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '', NULL, '0000-00-00', 0, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '', NULL, '0000-00-00', 0, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `t_minreport`
--

CREATE TABLE IF NOT EXISTS `t_minreport` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `emcvalue` int(4) DEFAULT NULL,
  `pm01` int(4) DEFAULT NULL,
  `pm25` int(4) DEFAULT NULL,
  `pm10` int(4) DEFAULT NULL,
  `noise` int(4) DEFAULT NULL,
  `windspeed` int(4) DEFAULT NULL,
  `winddirection` int(4) DEFAULT NULL,
  `rain` int(4) DEFAULT NULL,
  `temperature` int(4) DEFAULT NULL,
  `humidity` int(4) DEFAULT NULL,
  `airpressure` int(4) DEFAULT NULL,
  `pmdataflag` char(10) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55777 ;

--
-- 转存表中的数据 `t_minreport`
--

INSERT INTO `t_minreport` (`sid`, `devcode`, `statcode`, `reportdate`, `hourminindex`, `emcvalue`, `pm01`, `pm25`, `pm10`, `noise`, `windspeed`, `winddirection`, `rain`, `temperature`, `humidity`, `airpressure`, `pmdataflag`) VALUES
(614, 'HCU_SH_0302', '120101002', '2016-04-21', 1387, 5655, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(615, 'HCU_SH_0302', '120101002', '2016-04-21', 1388, 4795, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(616, 'HCU_SH_0302', '120101002', '2016-04-21', 1389, 5247, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 702, 228, NULL, NULL),
(617, 'HCU_SH_0302', '120101002', '2016-04-21', 1390, 4706, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 702, 228, NULL, NULL),
(618, 'HCU_SH_0302', '120101002', '2016-04-21', 1391, 5166, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 702, 228, NULL, NULL),
(619, 'HCU_SH_0302', '120101002', '2016-04-21', 1392, 5461, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 702, 228, NULL, NULL),
(620, 'HCU_SH_0302', '120101002', '2016-04-21', 1393, 5593, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, NULL, NULL, NULL),
(621, 'HCU_SH_0302', '120101002', '2016-04-21', 1394, 5328, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(622, 'HCU_SH_0302', '120101002', '2016-04-21', 1395, 5034, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(623, 'HCU_SH_0302', '120101002', '2016-04-21', 1396, 5348, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(624, 'HCU_SH_0302', '120101002', '2016-04-21', 1397, 5623, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 227, NULL, NULL),
(625, 'HCU_SH_0302', '120101002', '2016-04-21', 1398, 5239, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 227, NULL, NULL),
(626, 'HCU_SH_0302', '120101002', '2016-04-21', 1399, 5251, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 227, NULL, NULL),
(627, 'HCU_SH_0302', '120101002', '2016-04-21', 1400, 5201, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 227, NULL, NULL),
(628, 'HCU_SH_0302', '120101002', '2016-04-21', 1401, 5542, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 699, 227, NULL, NULL),
(629, 'HCU_SH_0302', '120101002', '2016-04-21', 1402, 4939, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 699, 227, NULL, NULL),
(630, 'HCU_SH_0302', '120101002', '2016-04-21', 1403, 5280, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 698, 227, NULL, NULL),
(631, 'HCU_SH_0302', '120101002', '2016-04-21', 1404, 5481, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 698, 227, NULL, NULL),
(632, 'HCU_SH_0302', '120101002', '2016-04-21', 1405, 4966, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 698, 227, NULL, NULL),
(633, 'HCU_SH_0302', '120101002', '2016-04-21', 1406, 5447, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 697, 227, NULL, NULL),
(634, 'HCU_SH_0302', '120101002', '2016-04-21', 1407, 5469, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 696, 227, NULL, NULL),
(635, 'HCU_SH_0302', '120101002', '2016-04-21', 1408, 4858, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 696, 227, NULL, NULL),
(636, 'HCU_SH_0302', '120101002', '2016-04-21', 1409, 5177, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 227, NULL, NULL),
(637, 'HCU_SH_0302', '120101002', '2016-04-21', 1410, 4908, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 696, 227, NULL, NULL);

*/



class classDbiL5biService
{
    //构造函数
    public function __construct()
    {

    }

    public function dbi_hourreport_process($devcode,$statcode,$date,$hour)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L5BI, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //找到数据库中已有序号最大的，也许会出现序号(6 BYTE)用满的情况，这时应该考虑更新该算法，短期内不需要考虑这么复杂的情况
        //数据库SID=0的记录保留作为特殊用途，对应的emcvalue字段保存当前最大可用sid
        $result = $mysqli->query("SELECT * FROM `t_hourreport` WHERE `sid` = '0'");
        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $sid = intval($row['emcvalue']); //记录中存储着最大的SID
        }
        else //如果没有sid＝0记录项,找到当前最大sid并插入一条sid＝0记录项，其"longitude"字段存入sid＋1
        {
            $result = $mysqli->query("SELECT `sid` FROM `t_hourreport` WHERE 1");
            $sid =0;
            while($row = $result->fetch_array())
            {
                if ($row['sid'] > $sid)
                {
                    $sid = $row['sid'];
                }
            }
            $sid = $sid+1;
            $mysqli->query("INSERT INTO `t_hourreport` (sid,emcvalue) VALUES ('0', '$sid')");
        }
        //查找在给定日期给定小时内该设备的所有记录
        $start = $hour*60;
        $end = ($hour+1)*60;
        $result = $mysqli->query("SELECT * FROM `t_minreport` WHERE `devcode` = '$devcode' AND `statcode` = '$statcode' AND
                          (`hourminindex` >= '$start' AND `hourminindex` < '$end')");

        if ($result->num_rows < HOUR_VALIDE_NUM )  //如果该日期指定的小时里分钟测量值小于最低要求值，则该小时平均值无效，直接返回
            return false;

        //初始化各测试参数的小时平均值
        $avg_emc = 0;
        $avg_noise = 0;
        $avg_pm01 = 0;
        $avg_pm25 = 0;
        $avg_pm10 = 0;
        $avg_windspeed = 0;
        $avg_temperature = 0;
        $avg_humidity = 0;

        //初始化各测试参数小时有效值的个数
        $count_emc = 0;
        $count_noise = 0;
        $count_pm01 = 0;
        $count_pm25 = 0;
        $count_pm10 = 0;
        $count_windspeed = 0;
        $count_temperature = 0;
        $count_humidity = 0;

        while($row = $result->fetch_array())
        {
            if (!empty($row['emcvalue']))
            {
                $avg_emc = $avg_emc + $row['emcvalue'];
                $count_emc++;
            }
            if (!empty($row['noise']))
            {
                $avg_noise = $avg_noise + $row['noise'];
                $count_noise++;
            }
            if (!empty($row['pm01']))
            {
                $avg_pm01 = $avg_pm01 + $row['pm01'];
                $count_pm01++;
            }
            if (!empty($row['pm25']))
            {
                $avg_pm25 = $avg_pm25 + $row['pm25'];
                $count_pm25++;
            }
            if (!empty($row['pm10']))
            {
                $avg_pm10 = $avg_pm10 + $row['pm10'];
                $count_pm10++;
            }
            if (!empty($row['windspeed']))
            {
                $avg_windspeed = $avg_windspeed + $row['windspeed'];
                $count_windspeed++;
            }
            if (!empty($row['temperature']))
            {
                $avg_temperature = $avg_temperature + $row['temperature'];
                $count_temperature++;
            }
            if (!empty($row['humidity']))
            {
                $avg_humidity = $avg_humidity + $row['humidity'];
                $count_humidity++;
            }
        }
        if ($count_emc >= HOUR_VALIDE_NUM)
            $avg_emc = $avg_emc/$count_emc;
        if ($count_noise >= HOUR_VALIDE_NUM)
            $avg_noise = $avg_noise/$count_noise;
        if ($count_pm01 >= HOUR_VALIDE_NUM)
            $avg_pm01 = $avg_pm01/$count_pm01;
        if ($count_pm25 >= HOUR_VALIDE_NUM)
            $avg_pm25 = $avg_pm25/$count_pm25;
        if ($count_pm10 >= HOUR_VALIDE_NUM)
            $avg_pm10 = $avg_pm10/$count_pm10;
        if ($count_windspeed >= HOUR_VALIDE_NUM)
            $avg_windspeed = $avg_windspeed/$count_windspeed;
        if ($count_temperature >= HOUR_VALIDE_NUM)
            $avg_temperature = $avg_temperature/$count_temperature;
        if ($count_humidity >= HOUR_VALIDE_NUM)
            $avg_humidity = $avg_humidity/$count_humidity;

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT `sid` FROM `t_hourreport` WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode'
                              AND `reportdate` = '$date' AND `hourindex` = '$hour')");
        if (($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_hourreport` SET `emcvalue` = '$avg_emc',`noise` = '$avg_noise',`pm01` = '$avg_pm01',`pm25` = '$avg_pm25',`pm10` = '$avg_pm10',`windspeed` = '$avg_windspeed',`temperature` = '$avg_temperature',`humidity` = '$avg_humidity'
                      WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode' AND  `reportdate` = '$date' AND `hourindex` = '$hour')");
        }
        else   //不存在，新增
        {
            $res1=$mysqli->query("INSERT INTO `t_hourreport` (sid,devcode,statcode,reportdate,hourindex,emcvalue,pm01,pm25,pm10,noise,windspeed,temperature,humidity)
                              VALUES ('$sid','$devcode','$statcode','$date','$hour','$avg_emc','$avg_pm01','$avg_pm25','$avg_pm10','$avg_noise','$avg_windspeed','$avg_temperature','$avg_humidity')");
            //更新最大可用的sid到数据库SID=0的记录项
            $sid = $sid + 1;
            $res2=$mysqli->query("UPDATE `t_hourreport` SET `emcvalue` = '$sid' WHERE (`sid` = '0')");
            $result = $res1 AND $res2;
        }
        $mysqli->close();
        return $result;

    }//End of function bi_hourreport_process


}//End of class_bi_db

?>