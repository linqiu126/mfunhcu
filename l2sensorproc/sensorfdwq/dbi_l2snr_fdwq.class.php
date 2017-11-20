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

        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用

        $equId = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['equId']) & 0xFFFFFFFF;
        $rfId = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['rfId']) & 0xFFFFFFFF;
        $reportTime = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['reportTime']) & 0xFFFFFFFF;
        $sampleTime = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['sampleTime']) & 0xFFFFFFFF;
        $dataFormat = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['dataFormat']) & 0xFF;
        $temp = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['temp']) & 0xFFFFFFFF;
        $miles = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['miles']) & 0xFFFFFFFF;
        $curHbRate = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['curHbRate']) & 0xFFFF;
        $hbRateMax = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['hbRateMax']) & 0xFFFF;
        $hbRateMin = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['hbRateMin']) & 0xFFFF;
        $hbRateAvg = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['hbRateAvg']) & 0xFFFFFFFF;
        $bloodPress = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['bloodPress']) & 0xFFFFFFFF;
        $sleepLvl = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['sleepLvl']) & 0xFFFFFFFF;
        $airPress = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['airPress']) & 0xFFFFFFFF;
        $energyLvl = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['energyLvl']) & 0xFFFFFFFF;
        $waterDrink = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['waterDrink']) & 0xFFFFFFFF;
        $skinAttached = hexdec($data[1]['HUITP_IEID_uni_fdwq_sports_wrist_data']['skinAttached']) & 0xFF;

        //生成 HUITP_MSGID_uni_fdwq_data_confirm 消息的内容
        $respMsgContent = array();
        $baseConfirmIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;

        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
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

        $rfId = hexdec($data[1]['HUITP_IEID_uni_fdwq_profile_simple_data']['rfId']) & 0xFFFFFFFF;

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
        array_push($profileIE, $detailProfile);

        array_push($respMsgContent, $baseConfirmIE);
        array_push($respMsgContent, $profileIE);

        $mysqli->close();
        return $respMsgContent;
    }

}

?>