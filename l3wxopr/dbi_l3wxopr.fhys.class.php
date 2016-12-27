<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/26
 * Time: 19:52
 */

class classDbiL3wxOprFhys
{

    public function dbi_fhyswechat_get_userinfo($openid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $keytype = MFUN_L3APL_F2CM_KEY_TYPE_WECHAT;
        $userinfo = array(); //初始化
        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$openid') AND (`keytype` = '$keytype') ";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $userinfo = array('username'=>$row['keyusername'], 'userid'=>$row['keyuserid']);
        }

        $mysqli->close();
        return $userinfo;
    }

    public function dbi_fhyswechat_get_locklist($user)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $keyid = ""; //初始化
        $lock_list = array();
        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`keyuserid` = '$user') ";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $keyid = $row['keyid'];
        }

        if(!empty($keyid)){
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE (`keyid` = '$keyid') ";
            $result = $mysqli->query($query_str);
            while(($result !=false) && (($row = $result->fetch_array()) > 0)) {
                $authlevel = $row['authlevel'];
                $authobjcode = $row['authobjcode'];
                if ($authlevel == MFUN_L3APL_F2CM_AUTH_LEVEL_PROJ){
                    $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE (`p_code` = '$authobjcode') ";
                    $resp = $mysqli->query($query_str);
                    while(($resp !=false) && (($resp_row = $resp->fetch_array()) > 0)) {
                        $temp = array(
                                        'statcode'=>$resp_row['statcode'],
                                        'lockname'=>$resp_row['statname'],
                                        'lockdetail'=>$resp_row['address'],
                                        'longitude'=>$resp_row['longitude'],
                                        'latitude'=>$resp_row['latitude']
                                    );
                        array_push($lock_list, $temp);
                    }
                }
                elseif ($authlevel == MFUN_L3APL_F2CM_AUTH_LEVEL_DEVICE){
                    $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE (`statcode` = '$authobjcode') ";
                    $resp = $mysqli->query($query_str);
                    while(($resp !=false) && (($resp_row = $resp->fetch_array()) > 0)) {
                        $temp = array(
                            'statcode'=>$resp_row['statcode'],
                            'lockname'=>$resp_row['statname'],
                            'lockdetail'=>$resp_row['address'],
                            'longitude'=>$resp_row['longitude'],
                            'latitude'=>$resp_row['latitude']
                        );
                        array_push($lock_list, $temp);
                    }
                }
            }
        }

        $mysqli->close();
        return $lock_list;
    }

    public function dbi_fhyswechat_get_lockstatus($user, $statcode)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $lockstatus = false; //初始化
        $query_str = "SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`statcode` = '$statcode') ";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $lockstatus = $row['lockstat'];
            if ($lockstatus == MFUN_HCU_FHYS_LOCK_OPEN)
                $lockstatus = true;
            else
                $lockstatus = false;
        }

        $mysqli->close();
        return $lockstatus;
    }


    public function dbi_fhyswechat_set_lockopen($user, $statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $keyid = "";
        $key_type = MFUN_L3APL_F2CM_KEY_TYPE_WECHAT;
        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`keyuserid` = '$user' AND `keytype` = '$key_type')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0){
            $row = $result->fetch_array();
            $keyid = $row["keyid"];
        }

        //插入一条开锁授权
        $authlevel = MFUN_L3APL_F2CM_AUTH_LEVEL_DEVICE;
        $authtype = MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER;
        $validnum = 1; //单次授权

        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE (`keyid` = '$keyid' AND `authobjcode` = '$statcode' AND `authtype` = '$authtype')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0){
            $row = $result->fetch_array();
            $validnum = $row['validnum'] + 1;
            $query_str = "UPDATE `t_l3f2cm_fhys_keyauth` SET `validnum` = '$validnum' WHERE (`keyid` = '$keyid' AND `authobjcode` = '$statcode' AND `authtype` = '$authtype')";
            $result = $mysqli->query($query_str);
        }
        else
        {
            $query_str = "INSERT INTO `t_l3f2cm_fhys_keyauth` (keyid, authlevel, authobjcode, authtype, validnum)
                                  VALUES ('$keyid','$authlevel','$statcode','$authtype','$validnum')";
            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }


}

?>