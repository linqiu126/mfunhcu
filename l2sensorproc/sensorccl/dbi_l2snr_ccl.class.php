<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/11/7
 * Time: 21:35
 */

class classDbiL2snrCcl
{
    private function getRandomKeyid($strlen)
    {

        $str = "";
        $str_pol = "0123456789";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < $strlen; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }

    private function dbi_hcu_event_log_process($keyid, $statcode, $eventtype)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //确认要操作的设备在 HCU Inventory表中是否存在
        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`keyid` = '$keyid')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $keyname = $row['keyname'];
            $keyuserid = $row['keyuserid'];
            $keyusername = $row['keyusername'];
        }
        else{
            $keyid = "NA";
            $keyname = "NA";
            $keyuserid = "NA";
            $keyusername = "NA";
        }

        $lasttime = 0;
        //查询该站点的最后一次开锁事件记录
        $query_str = "SELECT * FROM `t_l3fxprcm_fhys_locklog` WHERE `sid`= (SELECT MAX(sid) FROM `t_l3fxprcm_fhys_locklog` WHERE `statcode`= '$statcode' )";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0) {
            $row = $row = $result->fetch_array();
            $last_event = $row['createtime'];
            $lasttime = strtotime($last_event);
            $event_id = $row['sid'];
        }
        $timestamp = time();
        $currenttime = date("Y-m-d H:i:s",$timestamp);

        $query_str = "INSERT INTO `t_l3fxprcm_fhys_locklog` (keyid,keyname,keyuserid,keyusername,eventtype,statcode,createtime)
                              VALUES ('$keyid','$keyname','$keyuserid', '$keyusername', '$eventtype', '$statcode', '$currenttime')";
        $result = $mysqli->query($query_str);

        /*
        if ($timestamp < ($lasttime + MFUN_HCU_FHYS_SLEEP_DURATION)) {
            $query_str = "UPDATE `t_l3fxprcm_fhys_locklog` SET `keyid` = '$keyid',`keyname` = '$keyname',`keyuserid` = '$keyuserid',`keyusername` = '$keyusername'
                                 `eventtype` = '$eventtype',`createtime` = '$currenttime'  WHERE (`sid` = '$event_id')";
            $result = $mysqli->query($query_str);
        }
        else{
            $query_str = "INSERT INTO `t_l3fxprcm_fhys_locklog` (keyid,keyname,keyuserid,keyusername,eventtype,statcode,createtime)
                              VALUES ('$keyid','$keyname','$keyuserid', '$keyusername', '$eventtype', '$statcode', '$currenttime')";
            $result = $mysqli->query($query_str);
        }
        */

        $mysqli->close();
        return $result;
    }

    private function dbi_hcu_lock_keyauth_check($keyid, $statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $auth_check = false;
        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE (`keyid` = '$keyid')";
        $result = $mysqli->query($query_str);
        while ($row = $result->fetch_array())
        {
            $sid = $row['sid'];
            $authlevel = $row['authlevel'];
            $authobjcode = $row['authobjcode'];
            $authtype = $row['authtype'];
            $validnum = $row['validnum'];
            $validend = $row['validend'];

            //如果该钥匙授权是项目级授权，查询该站点是否属于授权项目
            if ($authlevel == MFUN_L3APL_F2CM_AUTH_LEVEL_PROJ)
            {
                $query_str = " SELECT * FROM `t_l3f3dm_siteinfo` WHERE (`statcode` = '$statcode' AND `p_code` = '$authobjcode' ) ";
                $resp = $mysqli->query($query_str);
                if (($resp != false) && ($resp->num_rows)>0)
                    $authobjcode = $statcode;
            }

            if ($authobjcode == $statcode)
            {
                switch ($authtype)
                {
                    case MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER:
                        //防止用户重复点击，对于用户名开锁，只保留一次开锁
                        if($validnum > 0){
                            $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE (`sid` = '$sid') ";
                            $resp = $mysqli->query($query_str);
                            $auth_check = true;
                        }
                        /*
                        $remain_validnum = $validnum - 1;
                        if ($remain_validnum == 0){
                            $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE (`sid` = '$sid') ";
                            $resp = $mysqli->query($query_str);
                            $auth_check = true;
                        }
                        else{
                            $query_str = "UPDATE `t_l3f2cm_fhys_keyauth` SET  `validnum` = '$remain_validnum' WHERE (`sid` = '$sid')";
                            $resp = $mysqli->query($query_str);
                            $auth_check = true;
                        }*/
                        break;
                    case MFUN_L3APL_F2CM_AUTH_TYPE_TIME:
                        $timestamp = time();
                        $current_date = intval(date("Ymd", $timestamp));
                        $validend = intval(date('Ymd',strtotime($validend)));
                        if ($current_date > $validend){
                            $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE (`sid` = '$sid') ";
                            $resp = $mysqli->query($query_str);
                            $auth_check = false;
                        }
                        else
                            $auth_check = true;
                        break;
                    case MFUN_L3APL_F2CM_AUTH_TYPE_FOREVER:
                        $auth_check = true;
                        break;
                    default:
                        $auth_check = false;
                        break;
                }
            }
            else
                $auth_check = false;

            if ($auth_check == true) //如何验证授权通过就直接返回，否则继续遍历
                return $auth_check;
        }
        return $auth_check;
    }



    public function dbi_huitp_msg_uni_ccl_lock_resp($devCode, $statCode, $data)
    {
        return true;
    }

    public function dbi_huitp_msg_uni_ccl_lock_report($devCode, $statCode, $data)
    {
        return true;
    }

    public function dbi_huitp_msg_uni_ccl_auth_inq($devCode, $statCode, $data)
    {
        return true;
    }

    public function dbi_huitp_msg_uni_ccl_state_resp($devCode, $statCode, $data)
    {
        return true;
    }

    public function dbi_huitp_msg_uni_ccl_state_report($devCode, $statcode, $data)
    {
        return true;
    }


}

?>