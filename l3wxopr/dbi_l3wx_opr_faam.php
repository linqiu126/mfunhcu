<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/13
 * Time: 11:29
 */

class classDbiL3wxOprFaam
{
    private function getRandomUid($strlen)
    {
        $str = "";
        $str_pol = "0123456789";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < $strlen; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }

    //用填充字符将字符串填充到指定长度
    private function str_pre_padding($strInput,$padding,$lenInput)
    {
        $len = strlen($strInput);
        while ($len < $lenInput)
        {
            $strInput = $padding .$strInput;
            $len++;
        }
        return $strInput;
    }

    private function urlstr($str){
        $url="";
        $m1="";
        for($i=0;$i<=strlen($str);$i++){
            $m1=base_convert(ord(substr($str,$i,1)),10,16);
            if ($m1!="0")
                $url=$url.$m1;
        }
        return $url;
    }

    //考勤二维码处理
    public function dbi_faam_qrcode_kq_process($scanCode,$latitude,$longitude,$nickName,$pagephone)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $timeStamp = time();
        $workDay = date("Y-m-d",$timeStamp);
        $currentTime = date("H:i:s",$timeStamp);

        $query_str = "SELECT * FROM `t_l3f11faam_factorysheet` WHERE (`pjcode` = '$scanCode') ";
        $factorysheet = $mysqli->query($query_str);
        if (($factorysheet !=false) AND (($row = $factorysheet->fetch_array()) > 0)){
            $restStart = strtotime($row['reststart']);
            $restEnd = strtotime($row['restend']);
            $stdWorkStart = strtotime($row['workstart']);
            $stdWorkEnd = strtotime($row['workend']);
            $targetLatitude = intval($row['latitude']); //GPS取2位小数
            $targetLongitude = intval($row['longitude']);
            $delta_latitude = abs($latitude - $targetLatitude);
            $delta_longitude = abs($longitude - $targetLongitude);
            if($delta_latitude > 50000 OR $delta_longitude > 50000){
                $resp = array('employee'=>$nickName, 'message'=>"考勤位置错误");
                $mysqli->close();
                return $resp;
            }
        }
        else{
            $resp = array('employee'=>$nickName, 'message'=>"二维码无效");
            $mysqli->close();
            return $resp;
        }

//        if (!empty($pagephone)){
//            $query_str = "UPDATE `t_l3f11faam_membersheet` SET `phone`='$pagephone' WHERE (`openid` = '$nickName' AND `pjcode` = '$scanCode')";   /////////////joe modify/////////////////////////
//            $mysqli->query($query_str);
//        }

        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`openid` = '$nickName' AND `pjcode` = '$scanCode') ";
        $membersheet = $mysqli->query($query_str);
        if (($membersheet !=false) AND (($row = $membersheet->fetch_array()) > 0)){
            if (isset($row['employee'])) $employee = $row['employee']; else  $employee = "";
            if (isset($row['pjcode'])) $pjCode = $row['pjcode']; else  $pjCode = "";
            if (isset($row['standardnum'])) $standardnum = $row['standardnum']; else  $standardnum = "";


           // if (isset($row['phone'])) $phone = $row['phone']; else  $phone = "";//////////////////////////////////////////////////////////////////joe modify/////////////////////////


            if (!empty($employee)){ //合法用户，记录考勤信息

                $unitPrice = $row['unitprice'];
                $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode` = '$scanCode' AND `employee` = '$employee' AND `workday` = '$workDay') ";
                $dailysheet = $mysqli->query($query_str);
                if (($dailysheet !=false) AND ($row = $dailysheet->fetch_array()) > 0){ //当天已经有考勤记录，则该次考勤时间记录为下班时间
                    $arriveTimeInt = strtotime($row['arrivetime']);
                    $leaveTimeInt = strtotime($currentTime);
                    $offWorkTime = round($row['offwork'], 1);
                    if($arriveTimeInt < $restStart AND $leaveTimeInt > $restEnd){ //正常情况，在午休前上班，午休后下班
                        $timeInterval = ($restStart - $arriveTimeInt) + ($leaveTimeInt - $restEnd);
                    }
                    elseif($arriveTimeInt >= $restStart AND $arriveTimeInt < $restEnd){ //在午休中间上班
                        $timeInterval = ($leaveTimeInt - $restEnd);
                    }
                    elseif($leaveTimeInt > $restStart AND $leaveTimeInt < $restEnd){ //在午休中间下班
                        $timeInterval = ($restStart - $arriveTimeInt);
                    }
                    elseif($arriveTimeInt > $restEnd){ //在午休后上班
                        $timeInterval = ($leaveTimeInt - $arriveTimeInt);
                    }
                    elseif($leaveTimeInt < $restStart){ //在午休前下班
                        $timeInterval = ($leaveTimeInt - $arriveTimeInt);
                    }
                    else{
                        $timeInterval = 0;
                    }
                    $hour = (int)(($timeInterval%(3600*24))/(3600));
                    $min = (int)($timeInterval%(3600)/60);
                    $workTime = $hour + round($min/60, 1)  - $offWorkTime; //扣除请假时间
                    if ($workTime < 0) $workTime = 0; //避免工作时间为负数

                    if($arriveTimeInt <= $stdWorkStart) $lateWorkFlag = false; else $lateWorkFlag = true;  //迟到标志
                    if($leaveTimeInt >= $stdWorkEnd) $earlyLeaveFlag = false; else $earlyLeaveFlag = true; //早退标志

                    $totalnum = $standardnum * $workTime;
                    $today = date("Y.m.d");
                    $dayTimeStart = $today." 00:00:00";  //今天开始
                    $dayTimeEnd = $today." 23:59:59";      //今天结束

/////////////////////////////////////

                    $typeList = array(); //获取苹果类型
                    $query_str = "SELECT * FROM `t_l3f11faam_typesheet` WHERE `pjcode` = '$pjCode' ";
                    $result = $mysqli->query($query_str);
                    while (($result != false) && (($row = $result->fetch_array()) > 0)) {
                        array_push($typeList, $row);
                    }

                    $completeNum = 0; //初始化完成个数
                    $query_str = "SELECT * FROM `t_l3f11faam_appleproduction` WHERE (`owner` = '$employee' AND `activetime`>'$dayTimeStart' AND `activetime`<='$dayTimeEnd')";
                    $result = $mysqli->query($query_str);
                    if (($result != false) && ($result->num_rows) > 0) {
                        while (($row = $result->fetch_array()) > 0){
                            if (isset($row['typecode'])) $typeCode = $row['typecode']; else  $typeCode = "";
                            $completeNum += $typeList[$typeCode]['applenum'];
                        }
                    }

////////////////////////////////////////
                    $query_str = "UPDATE `t_l3f11faam_dailysheet` SET `leavetime` = '$currentTime',`worktime` = '$workTime',`unitprice` = '$unitPrice',`lateworkflag` = '$lateWorkFlag',
                                  `earlyleaveflag` = '$earlyLeaveFlag' WHERE (`pjcode` = '$scanCode' AND `employee` = '$employee' AND `workday` = '$workDay'AND `totalstandardnum` = '$totalnum'AND `completenumber` = '$completeNum')"; ///////////////////////////////////////joe modify
                    $mysqli->query($query_str);
                    $resp = array('employee'=>$employee, 'message'=>"考勤成功");
                }
                else{ //当天第一次考勤
                    $query_str = "INSERT INTO `t_l3f11faam_dailysheet` (pjcode,employee,workday,arrivetime) VALUES ('$scanCode','$employee','$workDay','$currentTime')";
                    $mysqli->query($query_str);
                    $resp = array('employee'=>$employee, 'message'=>"考勤成功");
                }
            }
            else{ //注册未审核用户
                $resp = array('employee'=>$nickName, 'message'=>"用户注册未审核");
            }
        }
        else{ //初次扫码，未注册用户  // 初次扫码 ，跳回让用户输入手机号码 ，看管理员是否在表中添加了该员工的部分信息

            if (empty($pagephone)){
                    $resp = array('employee'=>$nickName, 'message'=>"请输入手机号");       //////////////////////////////////////////////////////////////////joe modify/////////////////////////
                    return $resp;
                }

            $query_member = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`phone`='$pagephone') ";
            $member_by_phone_sheet = $mysqli->query($query_member);

            if (($member_by_phone_sheet !=false) AND ($row = $member_by_phone_sheet->fetch_array()) > 0){ // 说明表中管理员添加了一些用户信息
//                $mid = MFUN_L3APL_F1SYM_MID_PREFIX.$this->getRandomUid(MFUN_L3APL_F1SYM_USER_ID_LEN);///////////joe modify/////////////////////////
//                $query_str = "UPDATE `t_l3f11faam_membersheet` SET `openid` = '$nickName',`mid`='$mid',`regdate` = '$workDay' WHERE (`phone`='$pagephone' AND `pjcode` = '$scanCode')";
                $query_str = "UPDATE `t_l3f11faam_membersheet` SET `openid` = '$nickName' WHERE (`phone`='$pagephone')";
                $mysqli->query($query_str);
                $resp = array('employee'=>$nickName, 'message'=>"注册成功");
            }else{  //管理员没有添加
//                $mid = MFUN_L3APL_F1SYM_MID_PREFIX.$this->getRandomUid(MFUN_L3APL_F1SYM_USER_ID_LEN);     //  /////joe modify///////////////////////// 不每次添加员工 ，需要工厂管理员先添加用户信息到数据库中
//                $query_str = "INSERT INTO `t_l3f11faam_membersheet` (mid,pjcode,openid,regdate) VALUES ('$mid','$scanCode','$nickName','$workDay')";
//                $mysqli->query($query_str);
                $resp = array('employee'=>$nickName, 'message'=>"用户未注册");
            }

//            $mid = MFUN_L3APL_F1SYM_MID_PREFIX.$this->getRandomUid(MFUN_L3APL_F1SYM_USER_ID_LEN);  //随机生成员工ID
//            $query_str = "INSERT INTO `t_l3f11faam_membersheet` (mid,pjcode,openid,regdate) VALUES ('$mid','$scanCode','$nickName','$workDay')";
//            $mysqli->query($query_str);
//            $resp = array('employee'=>$nickName, 'message'=>"用户未注册");
        }

        $mysqli->close();
        return $resp;
    }

    //生产二维码处理
    public function dbi_faam_qrcode_sc_process($scanCode,$latitude,$longitude,$nickName)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $timeStamp = time();
        $currentTime = date("Y-m-d H:i:s",$timeStamp);

        $query_str = "SELECT * FROM `t_l3f11faam_appleproduction` WHERE (`qrcode` = '$scanCode') ";
        $codeResult = $mysqli->query($query_str);
        if (($codeResult != false) AND (($row = $codeResult->fetch_array()) > 0)){  //判断二维码是否有效
            $activeTime = $row['activetime'];
            $pjCode = $row['pjcode'];
            $qrcode_owner = $row['owner'];
            $appleGrade = $row['typecode'];
            $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`openid` = '$nickName' AND `pjcode` = '$pjCode' ) ";
            $memberResult = $mysqli->query($query_str);
            if (($memberResult != false) AND (($row = $memberResult->fetch_array()) > 0)){ //判断扫描人员是否合法
                $scan_operator = $row['employee'];
                $position = $row['position'];  //是否指定岗位才能扫描？
                if (empty($activeTime)){  //二维码没有激活
                    $query_str = "UPDATE `t_l3f11faam_appleproduction` SET `activetime` = '$currentTime',  `activeman` = '$scan_operator' WHERE (`qrcode` = '$scanCode')";
                    $mysqli->query($query_str);
                    $resp = array('flag'=>true,'employee'=>$scan_operator, 'message'=>"统计成功");
                }
                else{ //二维码已经激活，回显包装信息
                    $query_str = "UPDATE `t_l3f11faam_appleproduction` SET `lastactivetime` = '$currentTime'' WHERE (`qrcode` = '$scanCode')";/////////////////////joe modify
                    $mysqli->query($query_str);
                    $resp = array('flag'=>false,'employee'=>$qrcode_owner, 'message'=>"姓名:".$qrcode_owner."; 粒数:".$appleGrade);
                }
            }
            else{ //未注册用户扫描
                $resp = array('flag'=>false,'employee'=>$nickName, 'message'=>"扫描用户未注册");
            }
        }
        else{
            $resp = array('flag'=>false,'employee'=>$nickName, 'message'=>"二维码无效");
        }

        $mysqli->close();
        return $resp;
    }

    //收货二维码处理
    public function dbi_faam_qrcode_sh_process()
    {
        return true;
    }

    //标签申请
    public function dbi_huitp_xmlmsg_equlable_apply_report($devCode, $statCode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用

        //$data[1] = HUITP_IEID_uni_equlable_apply_user_info
        $productType = hexdec($data[1]['HUITP_IEID_uni_equlable_apply_user_info']['productType']) & 0xFF;
        $pdCode = trim(pack('H*',$data[1]['HUITP_IEID_uni_equlable_apply_user_info']['pdCode']), '_');
        $pjCode = trim(pack('H*',$data[1]['HUITP_IEID_uni_equlable_apply_user_info']['pjCode']), '_');
        $userCode = trim(pack('H*',$data[1]['HUITP_IEID_uni_equlable_apply_user_info']['userCode']), '_');
        $facCode = trim(pack('H*',$data[1]['HUITP_IEID_uni_equlable_apply_user_info']['facCode']), '_');
        $labelUsage = hexdec($data[1]['HUITP_IEID_uni_equlable_apply_user_info']['labelUsage']) & 0xFFFF;
        $uAccount = trim(pack('H*',$data[1]['HUITP_IEID_uni_equlable_apply_user_info']['uAccount']), '_');
        $uPsd = trim(pack('H*',$data[1]['HUITP_IEID_uni_equlable_apply_user_info']['uPsd']), '_');
        $macAddr = trim(pack('H*',$data[1]['HUITP_IEID_uni_equlable_apply_user_info']['macAddr']), '_');
        $userTabTL = trim(pack('H*',$data[1]['HUITP_IEID_uni_equlable_apply_user_info']['userTabTL']), '_');
        $userTabTR = trim(pack('H*',$data[1]['HUITP_IEID_uni_equlable_apply_user_info']['userTabTR']), '_');
        $userTabBL = trim(pack('H*',$data[1]['HUITP_IEID_uni_equlable_apply_user_info']['userTabBL']), '_');
        $userTabBR = trim(pack('H*',$data[1]['HUITP_IEID_uni_equlable_apply_user_info']['userTabBR']), '_');
        $formalFlag = hexdec($data[1]['HUITP_IEID_uni_equlable_apply_user_info']['formalFlag']) & 0xFF;
        $applyNum = hexdec($data[1]['HUITP_IEID_uni_equlable_apply_user_info']['applyNum']) & 0xFFFF;

        //处理数据
        if($productType == HUITP_IEID_UNI_EQULABLE_APPLY_USER_INFO_HCU)
            $productType = "HCU";
        elseif($productType == HUITP_IEID_UNI_EQULABLE_APPLY_USER_INFO_IHU)
            $productType = "IHU";
        elseif($productType == HUITP_IEID_UNI_EQULABLE_APPLY_USER_INFO_FAM)
            $productType = "FAM";
        else
            $productType = "XXX";

        $timeStamp = time();
        $currentTime = date("Y-m-d H:i:s",$timeStamp);
        $workYear = date('y');
        $workWeek = date('W');
        $labelBaseInfo = $productType."_".$pjCode."_W".$workYear.$workWeek;

        $query_str = "SELECT * FROM `t_l3f11faam_appleproduction` WHERE `sid`= (SELECT MAX(sid) FROM `t_l3f11faam_appleproduction` WHERE (`applyweek`= '$workWeek' AND `pjcode`= '$pjCode'))";
        $result = $mysqli->query($query_str);
        if (($result != false) AND (($row = $result->fetch_array()) > 0)){
            $lastCode = $row['qrcode'];
            $lastNum = intval(substr($lastCode, 14,HUITP_IEID_UNI_EQULABLE_DIGCODE_NUM_MAX));  //二维码从第14开始是随机数字
            if (($lastNum + $applyNum) < HUITP_IEID_UNI_EQULABLE_ALLOCATION_NUM_MAX){
                $start = $lastNum + 1;
                $end = $start + $applyNum;
                for ($i = $start; $i < $end; $i++){ //保存分配的二维码
                    $digNum = $this->str_pre_padding($i, "0", 5); //二维码最后为5位数字
                    $rqcode = $labelBaseInfo.$digNum;
                    $query_str = "INSERT INTO `t_l3f11faam_appleproduction` (pjcode,qrcode,owner,typecode,applyweek,applytime) VALUES ('$pjCode','$rqcode','$userTabTL','$userTabTR','$workWeek','$currentTime')";
                    $mysqli->query($query_str);
                }
                $allocateResp = HUITP_IEID_UNI_EQULABLE_ALLOCATION_FLAG_TRUE; //1-FALSE/2-TRUE
                $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
            }
            else{ //超出可分配范围
                $allocateResp = HUITP_IEID_UNI_EQULABLE_ALLOCATION_FLAG_FALSE;
                $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_NO;
            }
        }
        else{
            if ($applyNum < HUITP_IEID_UNI_EQULABLE_ALLOCATION_NUM_MAX){
                $start = 1;
                $end = $start + $applyNum;
                for ($i = $start; $i < $end; $i++){ //保存分配的二维码
                    $digNum = $this->str_pre_padding($i, "0", HUITP_IEID_UNI_EQULABLE_DIGCODE_NUM_MAX); //二维码最后为5位数字
                    $rqcode = $labelBaseInfo.$digNum;
                    $query_str = "INSERT INTO `t_l3f11faam_appleproduction` (pjcode,qrcode,owner,typecode,applyweek,applytime) VALUES ('$pjCode','$rqcode','$userTabTL','$userTabTR','$workWeek','$currentTime')";
                    $mysqli->query($query_str);
                }
                $allocateResp = HUITP_IEID_UNI_EQULABLE_ALLOCATION_FLAG_TRUE;
                $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
            }
            else{ //超出可分配范围
                $allocateResp = HUITP_IEID_UNI_EQULABLE_ALLOCATION_FLAG_FALSE;
                $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_NO;
            }
        }

        $respMsgContent = array();
        $baseConfirmIE = array();
        $allocationValueIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;

        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        array_push($baseConfirmIE, HUITP_IEID_uni_com_confirm);
        array_push($baseConfirmIE, $huitpIeLen);
        array_push($baseConfirmIE, $comConfirm);

        //组装IE HUITP_IEID_uni_equlable_apply_allocation
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_equlable_apply_allocation);
        $huitpIeLen = intval($huitpIe['len']);
        $labelBaseInfo = $this->urlstr($labelBaseInfo);

        array_push($allocationValueIE, HUITP_IEID_uni_equlable_apply_allocation);
        array_push($allocationValueIE, $huitpIeLen);
        array_push($allocationValueIE, $allocateResp);
        array_push($allocationValueIE, $applyNum);
        array_push($allocationValueIE, $start);
        array_push($allocationValueIE, $end);
        array_push($allocationValueIE, $labelBaseInfo);

        array_push($respMsgContent, $baseConfirmIE);
        array_push($respMsgContent, $allocationValueIE);

        $mysqli->close();
        return $respMsgContent;
    }

    //用户列表同步
    public function dbi_huitp_xmlmsg_equlable_userlist_sync_report($devCode, $statCode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用

        //$data[1] = HUITP_IEID_uni_equlable_userlist_sync_report
        $pjCode = trim(pack('H*',$data[1]['HUITP_IEID_uni_equlable_userlist_sync_report']['pjCode']), '_');
        $syncStart = hexdec($data[1]['HUITP_IEID_uni_equlable_userlist_sync_report']['syncStart']) & 0xFFFF;

        $userList = "";
        $currentNum = 0;
        $counter = 0;

        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode' AND `onjob` = 1)";
        $memberResult = $mysqli->query($query_str);
        if ($memberResult != false) {
            $total_num = $memberResult->num_rows;
            if ($total_num < $syncStart+100){ //每次同步最多100名员工信息
                while (($row = $memberResult->fetch_array()) > 0){
                    $counter = $counter + 1;
                    if ($syncStart > $counter) continue;
                    $employee = trim($row['employee']);
                    $userList = $userList.$employee.";";
                    $currentNum = $currentNum + 1;
                }
            }
            else{
                while (($row = $memberResult->fetch_array()) > 0 AND $currentNum < 100){
                    $counter = $counter + 1;
                    if ($syncStart > $counter) continue;
                    $employee = trim($row['employee']);
                    $userList = $userList.$employee.";";
                    $currentNum = $currentNum + 1;
                }
            }
            $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
        }
        else
            $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_NO;

        $respMsgContent = array();
        $baseConfirmIE = array();
        $userListIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;

        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        array_push($baseConfirmIE, HUITP_IEID_uni_com_confirm);
        array_push($baseConfirmIE, $huitpIeLen);
        array_push($baseConfirmIE, $comConfirm);

        //组装IE HUITP_IEID_uni_equlable_userlist_sync_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_equlable_userlist_sync_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        $userList = $this->urlstr($userList);

        array_push($userListIE, HUITP_IEID_uni_equlable_userlist_sync_confirm);
        array_push($userListIE, $huitpIeLen);
        array_push($userListIE, $total_num);
        array_push($userListIE, $currentNum);
        array_push($userListIE, $syncStart);
        array_push($userListIE, $userList);

        array_push($respMsgContent, $baseConfirmIE);
        array_push($respMsgContent, $userListIE);

        $mysqli->close();
        return $respMsgContent;
    }

}

?>