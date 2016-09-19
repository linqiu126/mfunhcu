<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 23:01
 */
//include_once "../../l1comvm/vmlayer.php";



class classDbiL3apF0wechat
{
    //构造函数
    public function __construct()
    {

    }

    //根据用户openid查询该用户绑定设备的当前EMC值
    public function dbi_get_current_emcvalue($openid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $emcvalue = 0;
        $query_str = "SELECT * FROM `t_l2sdk_wechat_blebound` WHERE `openid` = '$openid'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $deviceid = $row['deviceid'];

            $timestamp = time();
            $date = date("Y-m-d", $timestamp);
            $stamp = getdate($timestamp);
            $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/MFUN_TIME_GRID_SIZE)));

            $query_str = "SELECT * FROM `t_l2snr_emcdata` WHERE (`deviceid` = '$deviceid' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
            $result = $mysqli->query($query_str);
            if (($result->num_rows)>0) {
                $row = $result->fetch_array();
                $emcvalue = $row['emcvalue'];
            }
        }

        $mysqli->close();
        return $emcvalue;
    }


    //根据用户openid查询该用户绑定设备的过去连续24个时间网格的历史EMC值
    public function dbi_get_history_emcvalue($openid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $valuelist = array(); //初始化EMC
        $query_str = "SELECT * FROM `t_l2sdk_wechat_blebound` WHERE `openid` = '$openid'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $deviceid = $row['deviceid'];

            $timestamp = time();
            $date = date("Y-m-d", $timestamp);
            $stamp = getdate($timestamp);
            $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/MFUN_TIME_GRID_SIZE)));

            for($i=0; $i<24; $i++){
                $emcvalue = 0;
                $hourminindex = $hourminindex - $i;
                if ($hourminindex < 0){ //跨度到前一天
                    $hourminindex = $hourminindex + 24*60;
                    $date = date("Y-m-d",strtotime("-1 day"));
                }

                $query_str = "SELECT * FROM `t_l2snr_emcdata` WHERE (`deviceid` = '$deviceid' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
                $result = $mysqli->query($query_str);
                if (($result->num_rows)>0) {
                    $row = $result->fetch_array();
                    $emcvalue = $row['emcvalue'];
                }
                array_push($valuelist, $emcvalue);
            }
        }

        $mysqli->close();
        return $valuelist;
    }
}

?>