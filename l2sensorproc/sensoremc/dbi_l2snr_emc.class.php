<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/2
 * Time: 16:03
 */
//include_once "../../l1comvm/vmlayer.php";

class classDbiL2snrEmc
{
    //构造函数
    public function __construct()
    {

    }

    //存储EMC数据，每一次存储，都是新增一条记录
    //记录存储是以TIME_GRID_SIZE分钟为网格化的，保证每一个时间网格只有一条记录
    public function dbi_emcData_save($deviceid, $sensorid,$timestamp,$data,$gps)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

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

        $emc = $data["value"];

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $date = intval(date("ymd", $timestamp));
        $stamp = getdate($timestamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/TIME_GRID_SIZE)));

        $result = $mysqli->query("SELECT * FROM `t_emcdata` WHERE (( `deviceid` = '$deviceid' AND `sensorid` = '$sensorid')
                        AND (`reportdate` = '$date' AND `hourminindex` = '$hourminindex'))");
        if (($result->num_rows)>0)   //重复，则覆盖
        {
            $result = $mysqli->query("UPDATE `t_emcdata` SET `emcvalue` = '$emc',`altitude` = '$altitude',`flag_la` = '$flag_la',`latitude` = '$latitude',`flag_lo` = '$flag_lo',`longitude` = '$longitude'
                      WHERE ((`deviceid` = '$deviceid' AND `sensorid` = '$sensorid') AND (`reportdate` = '$date' AND `hourminindex` = '$hourminindex'))");
        }
        else   //不存在，新增
        {
            $result = $mysqli->query("INSERT INTO `t_emcdata` (deviceid,sensorid,emcvalue,reportdate,hourminindex,altitude,flag_la,latitude,flag_lo,longitude)
                      VALUES ('$deviceid','$sensorid','$emc', '$date', '$hourminindex','$altitude', '$flag_la','$latitude', '$flag_lo','$longitude')");
        }
        $mysqli->close();
        return $result;
    }

    //删除对应用户所有超过90天的数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    public function dbi_emcData_delete_3monold($deviceid,$sensorid,$days)
    {
        if ($days <90) $days = 90;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //删除距离当前超过90天的数据，数据的第90天稍微有点截断，但问题不大
        //比较蠢的细节方法
        /*$result = $mysqli->query("SELECT `sid` FROM `emcdatainfo` WHERE `date` < (now()-$days)");
        while($row = $result->fetch_array())
        {
            $sidtmp = $row['sid'];
            $res = $mysqli->query("DELETE FROM `emcdatainfo` WHERE `sid` = '$sidtmp'");
        }*/
        //尝试使用一次性删除技巧，结果非常好!!!
        $result = $mysqli->query("DELETE FROM `t_emcdata` WHERE ((`deviceid` = '$deviceid' AND `sensorid` = '$sensorid')
                      AND (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days'))");
        $mysqli->close();
        return $result;
    }

    //新增或者更新累计辐射剂量数据，每个用户一条记录，不得重复
    public function dbi_emcAccumulation_save( $deviceid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_emcaccumulation` WHERE (`deviceid` = '$deviceid')");
        $tag = 0;
        if (($result->num_rows)>0)   //更新数据而已，而且假设每个用户只有唯一的一条记录
        {
            $row = $result->fetch_array();
            $lastupdatedate = date("ymd", strtotime($row['lastupdatedate']));  //字符串
            $lastUpdateStart = date("ymd", strtotime($row['lastupdatedate'])-2*24*60*60);  //解决模2的边界问题
            if ($lastupdatedate != date("ymd")) {
                $tag = 1;
                $sid = $row['sid'];
                $lastUpdateStart = intval($lastUpdateStart);
            }
        }
        else  //如果是第一次创建
        {
            //先找到当前表中最大的SID系列号
            $result = $mysqli->query("SELECT  MAX(`sid`)  FROM `t_emcaccumulation` WHERE 1 ");
            if ($result->num_rows>0){
                $row_max =  $result->fetch_array();
                $sid_max = $row_max['MAX(`sid`)'];
            }
            $sid = $sid_max + 1;

            //初始化各种数值，插入一条记录
            $lastupdatedate = intval(date("ymd"));
            $avg30days = "0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0";  //使用;做数据之间的分割
            $avg3month = "0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0";
            $result = $mysqli->query("INSERT INTO `t_emcaccumulation` (deviceid, lastupdatedate, avg30days, avg3month)
                          VALUES ('$deviceid', '$lastupdatedate', '$avg30days', '$avg3month')");
            $tag = 2;
        }
        if ($tag ==1 || $tag ==2)  //不同天的更新，或者新创时的全面计算
        {
            //从数据库中取出，进行处理
            $result = $mysqli->query("SELECT * FROM `t_emcaccumulation` WHERE (`sid` = '$sid')");
            $row = $result->fetch_array();  //原则上只有唯一的一个记录
            $avg30days = $row['avg30days'];
            $avg3month = $row['avg3month'];
            $avgd1 = explode(";", $avg30days);
            $avgm1 = explode(";", $avg3month);
            for ($i=0;$i<32;$i++)
            {
                $avgd2 [$i] = intval($avgd1[$i]);
                $avgm2 [$i] = intval($avgm1[$i]);
                $daynum [$i] = 0;
                $monthnum [$i] = 0;
            }
            //全面做一次计算处理，先做当月的处理
            $day0 = intval(date("ymd"));
            if ($tag == 1) $day90 = $lastUpdateStart;  //两天的边界问题需要考虑在内
            if ($tag == 2) $day90 = intval(date("ymd", time()-90*24*60*60));

            $result = $mysqli->query("SELECT * FROM `t_emcdata` WHERE (`deviceid` = '$deviceid')");
            while($row = $result->fetch_array())
            {
                $getdate0 = date("ymd", strtotime($row['date']));
                $getdate = intval($getdate0);
                if (($getdate <= $day0) &&  ($getdate >= $day90))
                {
                    $tm = intval(substr($getdate0,2,2));
                    $td = intval(substr($getdate0,4,2));
                    $index1 = $tm*31 + $td;
                    $index = intval(($index1 - intval($index1/90)*90)/3);
                    $value = intval($row['emcvalue']);
                    //日加总
                    if ($daynum[$td] == 0){
                        $avgd2[$td] = $value;
                    }else{
                        $avgd2[$td] = $avgd2[$td] + $value;
                    }
                    $daynum[$td] = $daynum[$td] + 1;
                    //季加总平均
                    if ($monthnum[$index] == 0){
                        $avgm2[$index] = $value;
                    }else{
                        $avgm2[$index] = $avgm2[$index] + $value;
                    }
                    $monthnum[$index] = $monthnum[$index] + 1;
                }
            }
            for ($i=0;$i<32;$i++)
            {
                if ($daynum[$i] != 0)
                    $avgd2 [$i] = intval($avgd2[$i] / $daynum[$i]);
                if ($monthnum[$i] != 0)
                    $avgm2 [$i] = intval($avgm2[$i] / $monthnum[$i]);
            }
            $avg30days = implode(";", $avgd2);
            $avg3month = implode(";", $avgm2);
            //再重新存入数据文件
            $res1=$mysqli->query("UPDATE `t_emcaccumulation` SET `avg30days` = '$avg30days' WHERE (`sid` = '$sid')");
            $res2=$mysqli->query("UPDATE `t_emcaccumulation` SET `avg3month` = '$avg3month' WHERE (`sid` = '$sid')");
            $res3=$mysqli->query("UPDATE `t_emcaccumulation` SET `lastupdatedate` = '$day0' WHERE (`sid` = '$sid')");

            $result = $res1 OR $res2 OR $res3;
        }
        $mysqli->close();
        return $result;
    }

    //新增或者更新累计辐射剂量数据，每个用户一条记录，不得重复
    //返回双结构数据：数组的第一个包含了31天的平均值，30个采样点，第二个包含了90天的平均值（每三天平均一次），30个点的采样数据
    //数组是32个元素，DAY数据在1-31中，90天的均值数在0-29中
    //这样设计只是为了处理的方便，上层使用时自行处理边界问题
    public function dbi_EmcAccumulationInfo_inqury( $deviceid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_emcaccumulation` WHERE (`deviceid` = '$deviceid')");
        $row = $result->fetch_array();
        //Shanchun: 取时间给前台界面显示调用
        $date = $row['lastupdatedate'];
        $avgd = $row['avg30days'];
        $avgm = $row['avg3month'];
        $avgd1 = explode(";", $avgd);
        $avgm1 = explode(";", $avgm);
        for ($i=0;$i<32;$i++)
        {
            $avgd2 [$i] = intval($avgd1[$i]);
            $avgm2 [$i] = intval($avgm1[$i]);
        }
        $result = array ("lastupdatedate" => $date,"avg30days" => $avgd2,  "avg3month" => $avgm2);
        $mysqli->close();
        return $result;
    }

    public function dbi_minreport_update_emc($devcode,$statcode,$timestamp,$data)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L5BI, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $date = intval(date("ymd", $timestamp));
        $stamp = getdate($timestamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/TIME_GRID_SIZE)));

        $emc = $data["value"];

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_minreport` WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode'
                                  AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        if (($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_minreport` SET `emcvalue` = '$emc'
                          WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增
        {
            $result = $mysqli->query("INSERT INTO `t_minreport` (devcode,statcode,reportdate,hourminindex,emcvalue)
                          VALUES ('$devcode','$statcode','$date', '$hourminindex','$emc')");
        }
        $mysqli->close();
        return $result;
    }

    //ZSC
    public function dbi_LatestEmcValue_inqury($sid)
    {
        $LatestEmcValue = 0;
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `t_emcdata` WHERE `sid` = '$sid'");

        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $LatestEmcValue = $row['emcvalue'];
        }
        $mysqli->close();
        return $LatestEmcValue;
    }

    //ZSC 通过sid=0查询到最近的一个测量值索引及测量值信息
    //2016－02－26 LZH 此函数需要修改，sid=0保存最大sid的机制已经修改
    public function dbi_LatestEmcValueIndex_inqury($sid)
    {
        //$LatestEmcValueIndex = 0;
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `t_emcdata` WHERE `sid` = '$sid'");


        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $LatestEmcValueIndex = $row['longitude'];
        }

        $mysqli->close();
        return $LatestEmcValueIndex;

    }
    //ZSC

}

?>