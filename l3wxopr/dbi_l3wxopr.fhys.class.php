<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/26
 * Time: 19:52
 */

class classDbiL3wxOprFhys
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
            $keyid = $row['keyid'];
            $username = $row['keyusername'];
            $userid = $row['keyuserid'];
            if (!empty($username) AND !empty($userid)){  //如果该微信钥匙已经绑定
                $userinfo = array('username'=>$username, 'userid'=>$userid);
            }
            else{
                $memo = "临时微信虚拟钥匙，暂未绑定";
                $keystatus = MFUN_HCU_FHYS_KEY_INVALID; //钥匙未授予用户
                $query_str = "UPDATE `t_l3f2cm_fhys_keyinfo` SET `keystatus` = '$keystatus', `memo` = '$memo' WHERE (`keyid` = '$keyid' )";
                $result = $mysqli->query($query_str);
            }
        }

        $mysqli->close();
        return $userinfo;
    }

    public function dbi_fhyswechat_userbind($openid,$username,$password)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //先检查用户名是否存在
        $userid = "";
        $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `user` = '$username'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $pwd = $row['pwd'];
            if ($pwd == $password) {  //验证输入的用户名和密码
                $userid = $row['uid'];
                $usercheck = true;
                $query_str = "SELECT * FROM `t_l3f1sym_authlist` WHERE `uid` = '$userid' ";
                $resp = $mysqli->query($query_str);
                $projlist = array();
                while($row = $resp->fetch_array()){
                    $authcode = $row['auth_code'];
                    $fromat = substr($authcode, 0, MFUN_L3APL_F2CM_CODE_FORMAT_LEN);
                    if($fromat == MFUN_L3APL_F2CM_PROJ_CODE_PREFIX) { //取得code为项目号
                        $pcode = $authcode;
                        array_push($projlist, $pcode);
                    }
                }
                $msg = "用户验证通过";
            }
            else{
                $msg = "密码错误，请重新输入";
                $usercheck = false;
            }
        }
        else{
            $msg = "该用户不存在，请重新输入";
            $usercheck = false;
        }

        if(($usercheck==true) AND (!empty($projlist)))
        {
            $i = 0;
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_WECHAT;
            $keystatus = MFUN_HCU_FHYS_KEY_VALID; //Key授予用户,启用
            $memo = "微信虚拟钥匙，已启用绑定用户";
            while ($i < count($projlist)){
                $keyid = MFUN_L3APL_F2CM_KEY_PREFIX.$this->getRandomKeyid(MFUN_L3APL_F2CM_KEY_ID_LEN);  //KEYID的分配机制将来要重新考虑，避免重复
                $keyname = $username."微信钥匙-".$i;
                $pcode = $projlist[$i];
                $query_str = "INSERT INTO `t_l3f2cm_fhys_keyinfo` (keyid,keyname,p_code,keyuserid,keyusername,keystatus,keytype,hwcode,memo)
                                      VALUES ('$keyid','$keyname','$pcode','$userid','$username','$keystatus','$keytype','$openid','$memo')";
                $result = $mysqli->query($query_str);
                $i++;
            }
            $msg = "用户微信钥匙绑定成功";
        }

        $bindinfo = array('usercheck'=>$usercheck, 'msg'=>$msg,'username'=>$username, 'userid'=>$userid);
        $mysqli->close();
        return $bindinfo;
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
        $key_type = MFUN_L3APL_F2CM_KEY_TYPE_WECHAT;
        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`keyuserid` = '$user' AND `keytype` = '$key_type') ";
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
            $lock_1 = $row['lock_1'];
            $lock_2 = $row['lock_2'];
            if ($lock_1 == MFUN_HCU_FHYS_LOCK_OPEN AND $lock_2 == MFUN_HCU_FHYS_LOCK_OPEN)
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