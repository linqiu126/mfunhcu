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

    private function dbi_datavalue_convert($format, $data)
    {
        switch($format)
        {
            case HUITP_IEID_UNI_COM_FORMAT_TYPE_NULL:
                $value = false;
                break;
            case HUITP_IEID_UNI_COM_FORMAT_TYPE_INT_ONLY:
                $value = intval($data);
                break;
            case HUITP_IEID_UNI_COM_FORMAT_TYPE_FLOAT_WITH_NF1:
                $value = intval($data)/10;
                break;
            case HUITP_IEID_UNI_COM_FORMAT_TYPE_FLOAT_WITH_NF2:
                $value = intval($data)/100;
                break;
            case HUITP_IEID_UNI_COM_FORMAT_TYPE_FLOAT_WITH_NF3:
                $value = intval($data)/1000;
                break;
            case HUITP_IEID_UNI_COM_FORMAT_TYPE_FLOAT_WITH_NF4:
                $value = intval($data)/10000;
                break;
            case HUITP_IEID_UNI_COM_FORMAT_TYPE_INVALID:
                $value = false;
                break;
            default:
                $value = false;
                break;
        }
        return $value;
    }

    private function dbi_hcu_event_log_process($keyid, $statcode, $eventtype,$picname)
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


        $timestamp = time();
        $currenttime = date("Y-m-d H:i:s",$timestamp);

        $query_str = "INSERT INTO `t_l3fxprcm_fhys_locklog` (keyid,keyname,keyuserid,keyusername,eventtype,statcode,createtime,picname)
                              VALUES ('$keyid','$keyname','$keyuserid', '$keyusername', '$eventtype', '$statcode', '$currenttime', '$picname')";
        $result = $mysqli->query($query_str);

        /*
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
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //$data[0] = HUITP_IEID_uni_com_req，暂时没有使用

        $authRequestType = hexdec($data[1]['HUITP_IEID_uni_ccl_lock_auth_req']['authReqType']) & 0xFF;
        $bleAddrLen = hexdec($data[1]['HUITP_IEID_uni_ccl_lock_auth_req']['bleAddrLen']) & 0xFF;
        $bleMacAddr = trim($data[1]['HUITP_IEID_uni_ccl_lock_auth_req']['bleMacAddr']);  //MAC地址保留HEX CHAR格式
        $bleMacAddr = substr($bleMacAddr, 0, $bleAddrLen*2);
        $rfidAddrLen = hexdec($data[1]['HUITP_IEID_uni_ccl_lock_auth_req']['rfidAddrLen']) & 0xFF;
        $rfidAddr = trim($data[1]['HUITP_IEID_uni_ccl_lock_auth_req']['rfidAddr']);  //RFID Code保留HEX CHAR格式
        $rfidAddr = substr($rfidAddr, 0, $rfidAddrLen*2);

        $auth_check = false; //初始化
        $keyid = "";
        $event = "";

        //判断是否检测到RFID开锁请求
        if (($authRequestType == HUITP_IEID_UNI_CCL_LOCK_AUTH_REQ_TYPE_RFID) AND !empty($rfidAddr))
        {
            $key_type = MFUN_L3APL_F2CM_KEY_TYPE_RFID;
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$rfidAddr' AND `keytype` = '$key_type')"; //暂时只判断是否有
            $resp = $mysqli->query($query_str);
            if (($resp != false) && ($resp->num_rows)>0){
                $row = $resp->fetch_array();
                $keyid = $row['keyid'];
                $auth_check = $this->dbi_hcu_lock_keyauth_check($keyid, $statCode);
            }

            $event = MFUN_L3APL_F2CM_EVENT_TYPE_RFID;
        }
        //判断是否检测到BLE开锁请求且RFID开锁没有授权
        elseif (($authRequestType == HUITP_IEID_UNI_CCL_LOCK_AUTH_REQ_TYPE_BLE) AND !empty($bleMacAddr) AND ($auth_check == false))
        {
            $key_type = MFUN_L3APL_F2CM_KEY_TYPE_BLE;
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$bleMacAddr' AND `keytype` = '$key_type')"; //暂时只判断是否有
            $resp = $mysqli->query($query_str);
            if (($resp != false) && ($resp->num_rows)>0){
                $row = $resp->fetch_array();
                $keyid = $row['keyid'];
                $auth_check = $this->dbi_hcu_lock_keyauth_check($keyid, $statCode);
            }
            else{ //为该MAC地址生成一把蓝牙虚拟钥匙
                $keyid = MFUN_L3APL_F2CM_KEY_PREFIX.$this->getRandomKeyid(MFUN_L3APL_F2CM_KEY_ID_LEN);  //KEYID的分配机制将来要重新考虑，避免重复
                $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statCode' ";
                $resp = $mysqli->query($query_str);
                if (($resp->num_rows) > 0) {
                    $resp_row = $resp->fetch_array();
                    $pcode = $resp_row['p_code'];
                }
                $keyname = "蓝牙钥匙-".$bleMacAddr;
                $keytype = MFUN_L3APL_F2CM_KEY_TYPE_BLE;
                $keystatus = MFUN_HCU_FHYS_KEY_INVALID;
                $memo = "系统自动生成的蓝牙虚拟钥匙，暂未授权";
                $query_str = "INSERT INTO `t_l3f2cm_fhys_keyinfo` (keyid,keyname,p_code,keystatus,keytype,hwcode,memo)
                                      VALUES ('$keyid','$keyname','$pcode','$keystatus','$keytype','$bleMacAddr','$memo')";
                $result = $mysqli->query($query_str);
            }

            $event = MFUN_L3APL_F2CM_EVENT_TYPE_BLE;
        }
        //如果RFID和BLE开锁认证都不通过，看看是否有有用户名开锁授权
        elseif (($authRequestType == HUITP_IEID_UNI_CCL_LOCK_AUTH_REQ_TYPE_LOCK) AND ($auth_check == false))
        {
            //暂时只判断是否有针对该站点的有效次数授权
            $auth_type = MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER;
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE (`authobjcode` = '$statCode' AND `authtype` = '$auth_type')";
            $resp = $mysqli->query($query_str);
            if (($resp != false) && ($resp->num_rows) > 0) {
                $row = $resp->fetch_array();
                $sid = $row['sid'];
                $keyid = $row['keyid'];
                $validnum = $row['validnum'];
                //防止用户重复点击，对于用户名开锁，只保留一次开锁

                if ($validnum > 0) {
                    $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE (`sid` = '$sid') ";
                    $mysqli->query($query_str);
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
            }

            $event = MFUN_L3APL_F2CM_EVENT_TYPE_USER;
        }

        if($auth_check == true){
            $timestamp = time();
            $filename = $statCode . "_" . $timestamp; //生成jpg文件名
            $picname = $filename . MFUN_HCU_SITE_PIC_FILE_TYPE;
            $this->dbi_hcu_event_log_process($keyid, $statCode, $event, $picname); //保存开锁记录
            $authResp = HUITP_IEID_UNI_CCL_LOCK_AUTH_RESP_YES;
        }
        else {
            $filename = "";
            $authResp = HUITP_IEID_UNI_CCL_LOCK_AUTH_RESP_NO;
        }

        //生成 HUITP_MSGID_uni_ccl_lock_auth_resp 消息的内容
        $respMsgContent = array();
        $comRespIE = array();
        $authRespIE = array();
        $picNameIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;

        //组装IE HUITP_IEID_uni_com_resp
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_resp);
        $huitpIeLen = intval($huitpIe['len']);
        $comResp = HUITP_IEID_UNI_COM_RESPONSE_YES;
        array_push($comRespIE, HUITP_IEID_uni_com_resp);
        array_push($comRespIE, $huitpIeLen);
        array_push($comRespIE, $comResp);

        //组装IE HUITP_IEID_uni_ccl_lock_auth_resp
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_ccl_lock_auth_resp);
        $huitpIeLen = intval($huitpIe['len']);
        array_push($authRespIE, HUITP_IEID_uni_ccl_lock_auth_resp);
        array_push($authRespIE, $huitpIeLen);
        array_push($authRespIE, $authResp);

        //组装IE HUITP_IEID_uni_ccl_gen_picid
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_ccl_gen_picid);
        $huitpIeLen = intval($huitpIe['len']);

        //处理照片文件名，将其补足固定长度
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $filename = $dbiL1vmCommonObj->str_padding($filename, "_", HUITP_IEID_UNI_CCL_GEN_PIC_ID_LEN_MAX);
        //将文件名字符串转成Hex字符串
        $picId = array();
        for($i = 0; $i < HUITP_IEID_UNI_CCL_GEN_PIC_ID_LEN_MAX; $i++){
            $one_char = substr($filename, $i, 1);
            $int_char = ord($one_char);
            array_push($picId, $int_char);
        }
        array_push($picNameIE, HUITP_IEID_uni_ccl_gen_picid);
        array_push($picNameIE, $huitpIeLen);
        array_push($picNameIE, $picId);

        array_push($respMsgContent, $comRespIE);
        array_push($respMsgContent, $authRespIE);
        array_push($respMsgContent, $picNameIE);

        $mysqli->close();
        return $respMsgContent;
    }

    public function dbi_huitp_msg_uni_ccl_state_resp($devCode, $statCode, $data)
    {
        return true;
    }

    public function dbi_huitp_msg_uni_ccl_state_report($devCode, $statcode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //$data[0] = HUITP_IEID_uni_com_req，暂时没有使用

        $maxLockNo = hexdec($data[1]['HUITP_IEID_uni_ccl_lock_state']['maxLockNo']) & 0xFF;
        $maxDoorNo = hexdec($data[2]['HUITP_IEID_uni_ccl_door_state']['maxDoorNo']) & 0xFF;
        if ($maxDoorNo == 1){
            $lock_1 = hexdec($data[1]['HUITP_IEID_uni_ccl_lock_state']['lock_1']) & 0xFF;
            $door_1 = hexdec($data[2]['HUITP_IEID_uni_ccl_door_state']['door_1']) & 0xFF;
            $lock_2 = HUITP_IEID_UNI_LOCK_STATE_NULL;
            $door_2 = HUITP_IEID_UNI_DOOR_STATE_NULL;
            $lock_3 = HUITP_IEID_UNI_LOCK_STATE_NULL;
            $door_3 = HUITP_IEID_UNI_DOOR_STATE_NULL;
            $lock_4 = HUITP_IEID_UNI_LOCK_STATE_NULL;
            $door_4 = HUITP_IEID_UNI_DOOR_STATE_NULL;
        }
        elseif($maxDoorNo == 2){
            $lock_1 = hexdec($data[1]['HUITP_IEID_uni_ccl_lock_state']['lock_1']) & 0xFF;
            $door_1 = hexdec($data[2]['HUITP_IEID_uni_ccl_door_state']['door_1']) & 0xFF;
            $lock_2 = hexdec($data[1]['HUITP_IEID_uni_ccl_lock_state']['lock_2']) & 0xFF;
            $door_2 = hexdec($data[2]['HUITP_IEID_uni_ccl_door_state']['door_2']) & 0xFF;
            $lock_3 = HUITP_IEID_UNI_LOCK_STATE_NULL;
            $door_3 = HUITP_IEID_UNI_DOOR_STATE_NULL;
            $lock_4 = HUITP_IEID_UNI_LOCK_STATE_NULL;
            $door_4 = HUITP_IEID_UNI_DOOR_STATE_NULL;
        }
        elseif($maxDoorNo == 3){
            $lock_1 = hexdec($data[1]['HUITP_IEID_uni_ccl_lock_state']['lock_1']) & 0xFF;
            $door_1 = hexdec($data[2]['HUITP_IEID_uni_ccl_door_state']['door_1']) & 0xFF;
            $lock_2 = hexdec($data[1]['HUITP_IEID_uni_ccl_lock_state']['lock_2']) & 0xFF;
            $door_2 = hexdec($data[2]['HUITP_IEID_uni_ccl_door_state']['door_2']) & 0xFF;
            $lock_3 = hexdec($data[1]['HUITP_IEID_uni_ccl_lock_state']['lock_3']) & 0xFF;
            $door_3 = hexdec($data[2]['HUITP_IEID_uni_ccl_door_state']['door_3']) & 0xFF;
            $lock_4 = HUITP_IEID_UNI_LOCK_STATE_NULL;
            $door_4 = HUITP_IEID_UNI_DOOR_STATE_NULL;
        }
        elseif($maxDoorNo == 4){
            $lock_1 = hexdec($data[1]['HUITP_IEID_uni_ccl_lock_state']['lock_1']) & 0xFF;
            $door_1 = hexdec($data[2]['HUITP_IEID_uni_ccl_door_state']['door_1']) & 0xFF;
            $lock_2 = hexdec($data[1]['HUITP_IEID_uni_ccl_lock_state']['lock_2']) & 0xFF;
            $door_2 = hexdec($data[2]['HUITP_IEID_uni_ccl_door_state']['door_2']) & 0xFF;
            $lock_3 = hexdec($data[1]['HUITP_IEID_uni_ccl_lock_state']['lock_3']) & 0xFF;
            $door_3 = hexdec($data[2]['HUITP_IEID_uni_ccl_door_state']['door_3']) & 0xFF;
            $lock_4 = hexdec($data[1]['HUITP_IEID_uni_ccl_lock_state']['lock_4']) & 0xFF;
            $door_4 = hexdec($data[2]['HUITP_IEID_uni_ccl_door_state']['door_4']) & 0xFF;
        }
        else{
            $lock_1 = HUITP_IEID_UNI_LOCK_STATE_INVALID;
            $door_1 = HUITP_IEID_UNI_DOOR_STATE_INVALID;
            $lock_2 = HUITP_IEID_UNI_LOCK_STATE_INVALID;
            $door_2 = HUITP_IEID_UNI_DOOR_STATE_INVALID;
            $lock_3 = HUITP_IEID_UNI_LOCK_STATE_INVALID;
            $door_3 = HUITP_IEID_UNI_DOOR_STATE_INVALID;
            $lock_4 = HUITP_IEID_UNI_LOCK_STATE_INVALID;
            $door_4 = HUITP_IEID_UNI_DOOR_STATE_INVALID;
        }
        //水浸状态
        $waterState = hexdec($data[3]['HUITP_IEID_uni_ccl_water_state']['waterState']) & 0xFF;
        //倾斜状态
        $fallState = hexdec($data[4]['HUITP_IEID_uni_ccl_fall_state']['fallState']) & 0xFF;
        //震动状态
        $shakeState = hexdec($data[5]['HUITP_IEID_uni_ccl_shake_state']['shakeState']) & 0xFF;
        //烟雾状态
        $smokeState = hexdec($data[6]['HUITP_IEID_uni_ccl_smoke_state']['smokeState']) & 0xFF;
        //电池状态
        $battState = hexdec($data[7]['HUITP_IEID_uni_ccl_bat_state']['batState']) & 0xFF;
        //温度值
        $format = hexdec($data[8]['HUITP_IEID_uni_ccl_temp_value']['dataFormat']) & 0xFF;
        $value = hexdec($data[8]['HUITP_IEID_uni_ccl_temp_value']['tempValue']) & 0xFFFF;
        $tempValue = $this->dbi_datavalue_convert($format, $value);
        //湿度值
        $format = hexdec($data[9]['HUITP_IEID_uni_ccl_humid_value']['dataFormat']) & 0xFF;
        $value = hexdec($data[9]['HUITP_IEID_uni_ccl_humid_value']['humidValue']) & 0xFFFF;
        $humidValue = $this->dbi_datavalue_convert($format, $value);
        //电量值
        $format = hexdec($data[10]['HUITP_IEID_uni_ccl_bat_value']['dataFormat']) & 0xFF;
        $value = hexdec($data[10]['HUITP_IEID_uni_ccl_bat_value']['batValue']) & 0xFFFF;
        $battValue = $this->dbi_datavalue_convert($format, $value);
        //倾斜角
        $format = hexdec($data[11]['HUITP_IEID_uni_ccl_fall_value']['dataFormat']) & 0xFF;
        $value = hexdec($data[11]['HUITP_IEID_uni_ccl_fall_value']['fallValue']) & 0xFFFF;
        $fallValue = $this->dbi_datavalue_convert($format, $value);
        //备用：通用值-1
        $format = hexdec($data[12]['HUITP_IEID_uni_ccl_general_value1']['dataFormat']) & 0xFF;
        $value = hexdec($data[12]['HUITP_IEID_uni_ccl_general_value1']['generalValue1']) & 0xFFFF;
        $generalValue1 = $this->dbi_datavalue_convert($format, $value);
        //备用：通用值-2
        $format = hexdec($data[13]['HUITP_IEID_uni_ccl_general_value2']['dataFormat']) & 0xFF;
        $value = hexdec($data[13]['HUITP_IEID_uni_ccl_general_value2']['generalValue2']) & 0xFFFF;
        $generalValue2 = $this->dbi_datavalue_convert($format, $value);
        //信号强度RSSI值
        $format = hexdec($data[14]['HUITP_IEID_uni_ccl_rssi_value']['dataFormat']) & 0xFF;
        $value = hexdec($data[14]['HUITP_IEID_uni_ccl_rssi_value']['rssiValue']) & 0xFFFF;
        $rssiValue = $this->dbi_datavalue_convert($format, $value);
        //$data[15]['HUITP_IEID_uni_ccl_dcmi_value'] NOT USED
        //状态报告事件
        $reportType = hexdec($data[16]['HUITP_IEID_uni_ccl_report_type']['event']) & 0xFF;


        $timestamp = time();
        $reportdate = date("Y-m-d", $timestamp);
        $temp = getdate($timestamp);
        $hourminindex = intval(($temp["hours"] * 60 + floor($temp["minutes"]/MFUN_HCU_FHYS_TIME_GRID_SIZE)));
        //更新分钟报告表
        $query_str ="SELECT * FROM `t_l2snr_fhys_minreport` WHERE (( `devcode` = '$devCode' AND `statcode` = '$statcode') AND (`reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex'))";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_fhys_minreport` SET `reporttype` = '$reportType',`door_1` = '$door_1',`door_2` = '$door_2',`door_3` = '$door_3',`door_4` = '$door_4',`lock_1` = '$lock_1',`lock_2` = '$lock_2',`lock_3` = '$lock_3',`lock_4` = '$lock_4',
                          `battstate` = '$battState',`waterstate` = '$waterState',`shakestate` = '$shakeState',`fallstate` = '$fallState',`smokestate` = '$smokeState',`battvalue` = '$battValue',`fallvalue` = '$fallValue',`tempvalue` = '$tempValue',`humidvalue` = '$humidValue',`rssivalue` = '$rssiValue'
                            WHERE (`devcode` = '$devCode' AND `statcode` = '$statcode' AND `reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex')";
            $result = $mysqli->query($query_str);
        }
        else
        {
            $query_str = "INSERT INTO `t_l2snr_fhys_minreport` (devcode,statcode,reportdate,hourminindex,reporttype,door_1,door_2,door_3,door_4,lock_1,lock_2,lock_3,lock_4,battstate,waterstate,shakestate,fallstate,smokestate,battvalue,fallvalue,tempvalue,humidvalue,rssivalue)
                            VALUES ('$devCode','$statcode','$reportdate','$hourminindex','$reportType','$door_1','$door_2','$door_3','$door_4','$lock_1','$lock_2','$lock_3','$lock_4','$battState','$waterState','$shakeState','$fallState','$smokeState','$battValue','$fallValue','$tempValue','$humidValue','$rssiValue')";
            $result = $mysqli->query($query_str);
        }

        //更新当前聚合表
        $currenttime = date("Y-m-d H:i:s",$timestamp);
        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`devcode` = '$devCode' AND `statcode` = '$statcode') ");
        if (($result->num_rows)>0) {
            $query_str = "UPDATE `t_l3f3dm_fhys_currentreport` SET `createtime` = '$currenttime',`reporttype` = '$reportType',`door_1` = '$door_1',`door_2` = '$door_2',`door_3` = '$door_3',`door_4` = '$door_4',`lock_1` = '$lock_1',`lock_2` = '$lock_2',`lock_3` = '$lock_3',`lock_4` = '$lock_4',
                          `battstate` = '$battState',`waterstate` = '$waterState',`shakestate` = '$shakeState',`fallstate` = '$fallState',`smokestate` = '$smokeState',`battvalue` = '$battValue',`fallvalue` = '$fallValue',`tempvalue` = '$tempValue',`humidvalue` = '$humidValue',`rssivalue` = '$rssiValue'
                            WHERE (`devcode` = '$devCode')";
            $result = $mysqli->query($query_str);
        }
        else {
            $query_str = "INSERT INTO `t_l3f3dm_fhys_currentreport` (devcode,statcode,createtime,reporttype,door_1,door_2,door_3,door_4,lock_1,lock_2,lock_3,lock_4,battstate,waterstate,shakestate,fallstate,smokestate,battvalue,fallvalue,tempvalue,humidvalue,rssivalue)
                            VALUES ('$devCode','$statcode','$currenttime','$reportType','$door_1','$door_2','$door_3','$door_4','$lock_1','$lock_2','$lock_3','$lock_4','$battState','$waterState','$shakeState','$fallState','$smokeState','$battValue','$fallValue','$tempValue','$humidValue','$rssiValue')";
            $result = $mysqli->query($query_str);
        }

        //初始化
        $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_0;
        $alarm_code = MFUN_HCU_FHYS_ALARM_NONE;

        //告警处理, 根据客户要求为简化告警处理,告警记录以站点为单位,每次只记录最高等级的告警,同一等级的告警只记录一项,人工处理关闭的告警记录将保存.
        if($reportType == HUITP_IEID_UNI_CCL_REPORT_TYPE_FAULT_EVENT) //状态报告为故障事件触发
        {
            if ($door_1==HUITP_IEID_UNI_DOOR_STATE_OPEN){
                $alarm_code = MFUN_HCU_FHYS_ALARM_DOOR1_OPEN;
                $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
            }
            elseif ($door_2==HUITP_IEID_UNI_DOOR_STATE_OPEN){
                $alarm_code = MFUN_HCU_FHYS_ALARM_DOOR2_OPEN;
                $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
            }
            elseif ($door_3==HUITP_IEID_UNI_DOOR_STATE_OPEN){
                $alarm_code = MFUN_HCU_FHYS_ALARM_DOOR3_OPEN;
                $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
            }
            elseif ($door_4==HUITP_IEID_UNI_DOOR_STATE_OPEN){
                $alarm_code = MFUN_HCU_FHYS_ALARM_DOOR4_OPEN;
                $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
            }
            elseif ($waterState == HUITP_IEID_UNI_WATER_STATE_ACTIVE){
                $alarm_code = MFUN_HCU_FHYS_ALARM_WATER;
                $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
            }
            elseif ($smokeState == HUITP_IEID_UNI_SMOKE_STATE_ACTIVE){
                $alarm_code = MFUN_HCU_FHYS_ALARM_SMOK;
                $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
            }
            elseif ($fallState == HUITP_IEID_UNI_FALL_STATE_ACTIVE){
                $alarm_code = MFUN_HCU_FHYS_ALARM_SMOK;
                $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_M;
            }
            elseif ($shakeState == HUITP_IEID_UNI_SHAKE_STATE_ACTIVE){
                $alarm_code = MFUN_HCU_FHYS_ALARM_VIBR;
                $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_M;
            }
            elseif ($battValue < MFUN_L3APL_F3DM_TH_ALARM_BATT){
                $alarm_code = MFUN_HCU_FHYS_ALARM_LOW_BATT;
                $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_M;
            }
            elseif ($rssiValue < MFUN_L3APL_F3DM_TH_ALARM_GPRS_LOW){
                $alarm_code = MFUN_HCU_FHYS_ALARM_LOW_SIG;
                $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_L;
            }
            else{
                $alarm_code = MFUN_HCU_FHYS_ALARM_NONE;
                $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_0;
            }
        }

        //告警等级大于0，则新插入一条新纪录
        if(($alarm_severity != MFUN_HCU_FHYS_ALARM_LEVEL_0) AND ($alarm_code != MFUN_HCU_FHYS_ALARM_NONE))
        {
            //更新告警记录表
            $alarm_flag = MFUN_HCU_FHYS_ALARM_PROC_FLAG_N;
            $alarm_proc = "新增告警，等待处理中";
            $query_str = "INSERT INTO `t_l3f5fm_fhys_alarmdata` (devcode,statcode,alarmflag,alarmseverity,alarmcode,tsgen,alarmproc)
                            VALUES ('$devCode','$statcode','$alarm_flag','$alarm_severity','$alarm_code','$currenttime','$alarm_proc')";
            $result = $mysqli->query($query_str);
        }

        //生成 HUITP_MSGID_uni_ccl_state_confirm 消息的内容
        $respMsgContent = array();
        $baseConfirmIE = array();
        $reportTypeIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;

        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
        array_push($baseConfirmIE, HUITP_IEID_uni_com_confirm);
        array_push($baseConfirmIE, $huitpIeLen);
        array_push($baseConfirmIE, $comConfirm);

        //组装IE HUITP_IEID_uni_ccl_report_type
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_ccl_report_type);
        $huitpIeLen = intval($huitpIe['len']);
        $event = $reportType;
        array_push($reportTypeIE, HUITP_IEID_uni_ccl_report_type);
        array_push($reportTypeIE, $huitpIeLen);
        array_push($reportTypeIE, $event);

        array_push($respMsgContent, $baseConfirmIE);
        array_push($respMsgContent, $reportTypeIE);

        $mysqli->close();
        return $respMsgContent;
    }

}

?>