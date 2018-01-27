<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/1/2
 * Time: 16:06
 */
//include_once "../../l1comvm/vmlayer.php";

/*

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_hsmmpdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_hsmmpdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `statcode` varchar(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `filesize` int(4) NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56013 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_picturedata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_picturedata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `statcode` varchar(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `filesize` varchar(10) NOT NULL DEFAULT '0',
  `filedescription` char(50) DEFAULT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28094 ;

 */


class classDbiL2snrHsmmp
{
    //验证照片名称
    public function dbi_fhys_locklog_picture_name_inqury($picName)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $statCode = "";
        //查询该站点的开锁事件照片记录
        $query_str = "SELECT * FROM `t_l3fxprcm_fhys_locklog`  WHERE (`picname`= '$picName')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $row = $result->fetch_array();
            $statCode = $row['statcode'];
        }

        $mysqli->close();
        return $statCode;
    }

    //将开锁抓拍照片信息存到开锁历史记录表中
    public function dbi_fhys_locklog_picture_name_save($timeStamp, $statCode, $picName)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //查询该站点的最后一次开锁事件记录
        $query_str = "SELECT * FROM `t_l3fxprcm_fhys_locklog` WHERE `sid`= (SELECT MAX(sid) FROM `t_l3fxprcm_fhys_locklog` WHERE `statcode`= '$statCode' )";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $row = $result->fetch_array();
            $eventid = $row['sid'];
            $query_str = "UPDATE `t_l3fxprcm_fhys_locklog` SET `picname` = '$picName' WHERE (`sid` = '$eventid')";
            $result=$mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    //保存照片信息到picturedata表中，对于FHYS这个可以不需要，直接将照片信息存到开锁记录表中，这样便于开锁抓拍照片关联查询
    public function dbi_door_open_picture_info_save($devCode, $statCode, $picName, $picSize)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $timeStamp = time();
        $reportDate = date("Y-m-d", $timeStamp);
        $stamp = getdate($timeStamp);
        $hourminindex = floor(($stamp["hours"] * 60 + $stamp["minutes"])/MFUN_HCU_AQYC_TIME_GRID_SIZE);

        $dataFlag = MFUN_HCU_DATA_FLAG_VALID;
        $description = "来自设备".$devCode."上传的照片";

        $query_str = "SELECT * FROM `t_l2snr_picturedata`  WHERE (`statcode`= '$statCode' AND`picname`= '$picName')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0){
            $query_str = "UPDATE `t_l2snr_picturedata` SET `reportdate` = '$reportDate',`hourminindex` = '$hourminindex',`filesize` = '$picSize',`filedescription` = '$description',`dataflag` = '$dataFlag'
                          WHERE (`statcode`= '$statCode' AND`picname`= '$picName')";
            $result=$mysqli->query($query_str);
        }
        else{
            $query_str = "INSERT INTO `t_l2snr_picturedata` (statcode,reportdate,hourminindex,filename,filesize,filedescription,dataflag)
                          VALUES ('$statCode','$reportDate','$hourminindex','$picName','$picSize','$description','$dataFlag')";
            $result=$mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    /***************************************HUITP摄像头消息处理***********************************/

    public function dbi_huitp_msg_uni_picture_data_report($devCode, $statCode, $content)
    {
        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用

        $flag = hexdec($content[1]['HUITP_IEID_uni_picture_ind']['flag']) & 0xFF;
        $eventId = hexdec($content[1]['HUITP_IEID_uni_picture_ind']['eventId']) & 0xFFFFFFFF;
        $picName = $content[1]['HUITP_IEID_uni_picture_ind']['picName'];

        //先判断照片是否已经上传成功
        $file_link = MFUN_HCU_SITE_PIC_BASE_DIR.$statCode."/".$picName;
        if(file_exists($file_link)){
            $filesize = filesize($file_link);
            $description = "来自设备".$devCode."上传的照片";
            $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;

            $timeStamp = time();
            $reportdate = date("Y-m-d", $timeStamp);
            $stamp = getdate($timeStamp);
            $hourminindex = floor(($stamp["hours"] * 60 + $stamp["minutes"])/MFUN_HCU_AQYC_TIME_GRID_SIZE);

            $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
            if (!$mysqli) {
                die('Could not connect: ' . mysqli_error($mysqli));
            }

            $query_str = "INSERT INTO `t_l2snr_picturedata` (statcode,filename,filesize,filedescription,reportdate,hourminindex) VALUES ('$statCode','$picName','$filesize','$description','$reportdate','$hourminindex')";
            $result=$mysqli->query($query_str);
            $mysqli->close();
        }
        else
            $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_NO;

        //生成 HUITP_MSGID_uni_picture_data_confirm 消息的内容
        $respMsgContent = array();
        $baseConfirmIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;
        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        array_push($baseConfirmIE, HUITP_IEID_uni_com_confirm);
        array_push($baseConfirmIE, $huitpIeLen);
        array_push($baseConfirmIE, $comConfirm);

        array_push($respMsgContent, $baseConfirmIE);

        return $respMsgContent;
    }

    public function dbi_huitp_msg_uni_hsmmp_data_report($devCode, $statCode, $content)
    {
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用

        $alarmFlag = hexdec($content[1]['HUITP_IEID_uni_hsmmp_value']['alarmFlag']) & 0xFFF;
        $alarmTime = hexdec($content[1]['HUITP_IEID_uni_hsmmp_value']['timeStamp']) & 0xFFFFFFFF;

        $timeStamp = time();
        $reportdate = date("Y-m-d", $timeStamp);
        $stamp = getdate($timeStamp);
        $hourminindex = floor(($stamp["hours"] * 60 + $stamp["minutes"])/MFUN_HCU_AQYC_TIME_GRID_SIZE);

        if ($alarmFlag == HUITP_IEID_UNI_HSMMP_ALARM_FLAG_ON){
            $query_str = "SELECT * FROM `t_l2snr_hsmmpdata`  WHERE (`statcode`= '$statCode' AND `reportdate`= '$reportdate' AND `alarmflag`= '$alarmFlag')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($row = $result->fetch_array())>0){
                $sid = $row['sid'];
                $query_str = "UPDATE `t_l2snr_hsmmpdata` SET `hourminindex` = '$hourminindex',`videostart` = '$alarmTime',`videoend` = '$timeStamp' WHERE (`sid`= '$sid')";
                $result=$mysqli->query($query_str);
            }
            else{
                $query_str = "INSERT INTO `t_l2snr_hsmmpdata` (statcode,reportdate,hourminindex,videostart,alarmflag) VALUES ('$statCode','$reportdate','$hourminindex','$alarmTime','$alarmFlag')";
                $result=$mysqli->query($query_str);
            }
        }
        elseif ($alarmFlag == HUITP_IEID_UNI_HSMMP_ALARM_FLAG_OFF){
            $flag_on = HUITP_IEID_UNI_HSMMP_ALARM_FLAG_ON;
            $query_str = "UPDATE `t_l2snr_hsmmpdata` SET `hourminindex` = '$hourminindex',`videoend` = '$alarmTime',`dataflag` = '$alarmFlag'
                          WHERE (`statcode`= '$statCode' AND `reportdate`= '$reportdate' AND `alarmflag`= '$flag_on')";
            $result=$mysqli->query($query_str);
        }
        else
            $result = false;

        //生成 HUITP_MSGID_uni_picture_data_confirm 消息的内容
        $respMsgContent = array();
        $baseConfirmIE = array();
        if($result == true)
            $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
        else
            $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_NO;

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;
        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        array_push($baseConfirmIE, HUITP_IEID_uni_com_confirm);
        array_push($baseConfirmIE, $huitpIeLen);
        array_push($baseConfirmIE, $comConfirm);

        array_push($respMsgContent, $baseConfirmIE);

        return $respMsgContent;
    }


}

?>