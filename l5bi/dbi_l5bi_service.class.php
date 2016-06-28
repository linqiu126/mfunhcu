<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2016/1/6
 * Time: 13:38
 * Description: this file provide database API for business intelligence
 */

//include_once "../l1comvm/vmlayer.php";

class classDbiL5biService
{
    //构造函数
    public function __construct()
    {

    }

    public function dbi_hourreport_process($devcode,$statcode,$date,$hour)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME, MFUN_CLOUD_DBPORT);
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