<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/11/7
 * Time: 21:35
 */

class classDbiL2snrFdwq
{

    public function dbi_huitp_msg_uni_fdwq_data_resp($devCode, $statCode, $data)
    {
        return true;
    }

    public function dbi_huitp_msg_uni_fdwq_data_report($devCode, $statCode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $dbiL2snrCommon = new classDbiL2snrCommon();
        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用

        $equId = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['equId']) & 0xFFFFFFFF;
        $rfId = $data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['rfId'];
        $reportTime = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['reportTime']) & 0xFFFFFFFF;
        $sampleTime = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['sampleTime']) & 0xFFFFFFFF;
        $dataFormat = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['dataFormat']) & 0xFF;
        $value = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['temp']) & 0xFFFFFFFF;
        $temp = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $value);
        $value = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['miles']) & 0xFFFFFFFF;
        $miles = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $value);
        $value = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['curHbRate']) & 0xFFFF;
        $curHbRate = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $value);
        $value = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['hbRateMax']) & 0xFFFF;
        $hbRateMax = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $value);
        $value = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['hbRateMin']) & 0xFFFF;
        $hbRateMin = $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $value);
        $value = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['hbRateAvg']) & 0xFFFFFFFF;
        $hbRateAvg= $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $value);
        $value = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['bloodPress']) & 0xFFFFFFFF;
        $bloodPress= $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $value);
        $value = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['sleepLvl']) & 0xFFFFFFFF;
        $sleepLvl= $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $value);
        $value = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['airPress']) & 0xFFFFFFFF;
        $airPress= $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $value);
        $value = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['energyLvl']) & 0xFFFFFFFF;
        $energyLvl= $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $value);
        $value = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['waterDrink']) & 0xFFFFFFFF;
        $waterDrink= $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $value);
        $value = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['skinAttached']) & 0xFF;
        $skinAttached= $dbiL2snrCommon->dbi_l2snr_datavalue_convert($dataFormat, $value);

        $query_str = "INSERT INTO `t_l2snr_fdwq_wrist` (devcode,rfid,reporttime,sampletime,temp,miles,curhbrate,hbratemax,hbratemin,hbrateavg,bloodpress,sleeplvl,airpress,energylvl,waterdrink,skinattached)
                        VALUES ('$devCode','$rfId','$reportTime','$sampleTime','$temp','$miles','$curHbRate','$hbRateMax','$hbRateMin','$hbRateAvg','$bloodPress','$sleepLvl','$airPress','$energyLvl','$waterDrink','$skinAttached')";
        $result = $mysqli->query($query_str);

        //生成 HUITP_MSGID_uni_fdwq_data_confirm 消息的内容
        $respMsgContent = array();
        $baseConfirmIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;
        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        if($result == true)
            $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
        else
            $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_NO;
        array_push($baseConfirmIE, HUITP_IEID_uni_com_confirm);
        array_push($baseConfirmIE, $huitpIeLen);
        array_push($baseConfirmIE, $comConfirm);
        array_push($respMsgContent, $baseConfirmIE);

        $mysqli->close();
        return $respMsgContent;
    }

    public function dbi_huitp_msg_uni_fdwq_profile_report($devCode, $statCode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用

        $rfId = $data[1]['HUITP_IEID_uni_fdwq_profile_simple_data']['rfId'];

        //初始化
        $name = "";
        $gender = 0;
        $dataFormat = 0;
        $hight = 0;
        $weight = 0;
        $bloodType = 0;

        $query_str ="SELECT * FROM `t_l3f2cm_fdwq_soldierinfo` WHERE (`rfid` = '$rfId')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0){
            $row = $result->fetch_array();
            $name = $row['soldiername'];
            $gender = $row['gender'];
            $dataFormat = HUITP_IEID_UNI_COM_FORMAT_TYPE_INT_ONLY;
            $hight = $row['hight'];
            $weight = $row['weight'];
            $bloodType = $row['bloodtype'];
        }

        //处理RFID，将其补足固定长度
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $rfId = $dbiL1vmCommonObj->str_padding($rfId, "_", HUITP_IEID_UNI_FDWQ_GEN_RFID_ID_LEN_MAX);
        //将RFID字符串转成Hex字符串
        $rfidHex = array();
        for($i = 0; $i < strlen($rfId); $i++){
            $one_char = substr($rfId, $i, 1);
            $int_char = ord($one_char);
            array_push($rfidHex, $int_char);
        }

        //处理姓名，将其补足固定长度
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $name = $dbiL1vmCommonObj->str_padding($name, "_", HUITP_IEID_UNI_FDWQ_GEN_NAME_LEN_MAX);
        //将RFID字符串转成Hex字符串
        $nameHex = array();
        for($i = 0; $i < strlen($name); $i++){
            $one_char = substr($name, $i, 1);
            $int_char = ord($one_char);
            array_push($nameHex, $int_char);
        }

        //生成 HUITP_MSGID_uni_fdwq_profile_confirm 消息的内容
        $respMsgContent = array();
        $baseConfirmIE = array();
        $profileIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;

        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
        array_push($baseConfirmIE, HUITP_IEID_uni_com_confirm);
        array_push($baseConfirmIE, $huitpIeLen);
        array_push($baseConfirmIE, $comConfirm);

        //组装IE HUITP_IEID_uni_fdwq_profile_detail_data
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_fdwq_profile_detail_data);
        $huitpIeLen = intval($huitpIe['len']);
        array_push($profileIE, HUITP_IEID_uni_fdwq_profile_detail_data);
        array_push($profileIE, $huitpIeLen);
        array_push($profileIE, $rfidHex);
        array_push($profileIE, $nameHex);
        array_push($profileIE, $gender);
        array_push($profileIE, $dataFormat);
        array_push($profileIE, $hight);
        array_push($profileIE, $weight);
        array_push($profileIE, $bloodType);

        array_push($respMsgContent, $baseConfirmIE);
        array_push($respMsgContent, $profileIE);

        $mysqli->close();
        return $respMsgContent;
    }

}

?>