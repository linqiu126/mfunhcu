<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/2
 * Time: 16:04
 */
include_once "../l1comvm/vmlayer.php";

class class_noise_db
{
    public function db_noise_data_save($deviceid,$sensorid,$timestamp,$data,$gps)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $date = intval(date("ymd", $timestamp));
        $stamp = getdate($timestamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/TIME_GRID_SIZE)));

        if(!empty($gps)){
            $altitude = $gps["altitude"];
            $flag_la = $gps["flag_la"];
            $latitude = $gps["latitude"];
            $flag_lo = $gps["flag_lo"];
            $longitude = $gps["longitude"];
        }
        else{
            $altitude = "";
            $flag_la = "";
            $latitude = "";
            $flag_lo = "";
            $longitude = "";
        }

        $noise = $data["value"];

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_noisedata` WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid'
                                  AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        if (($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_noisedata` SET `noise` = '$noise',`altitude` = '$altitude',`flag_la` = '$flag_la',`latitude` = '$latitude',`flag_lo` = '$flag_lo',`longitude` = '$longitude'
                          WHERE (`deviceid` = '$deviceid' AND `sensorid` = '$sensorid' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_noisedata` (deviceid,sensorid,noise,reportdate,hourminindex,altitude,flag_la,latitude,flag_lo,longitude)
                                  VALUES ('$deviceid','$sensorid','$noise','$date','$hourminindex','$altitude', '$flag_la','$latitude', '$flag_lo','$longitude')");
        }
        $mysqli->close();
        return $result;
    }

    public function db_minreport_update_noise($devcode,$statcode,$timestamp,$data)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $date = intval(date("ymd", $timestamp));
        $stamp = getdate($timestamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/TIME_GRID_SIZE)));

        $noise = $data["value"];

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_minreport` WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode'
                                  AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        if (($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_minreport` SET `noise` = '$noise'
                          WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_minreport` (devcode,statcode,noise,reportdate,hourminindex)
                                  VALUES ('$devcode', '$statcode', '$noise','$date','$hourminindex')");
        }
        $mysqli->close();
        return $result;
    }
}

?>