<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 23:01
 */
header("Content-type:text/html;charset=utf-8");
//include_once "../../l1comvm/vmlayer.php";


class classDbiL3apF11faam
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

    //获取该用户授权的工厂号，暂时复用用户表里的backup字段，将来考虑利用现有的项目表和项目组表
    private function dbi_get_user_auth_factory($mysqli, $uid)
    {
        $pjCode = ""; //初始化
        $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `uid` = '$uid' ";
        $result = $mysqli->query($query_str);
        if(($result != false) AND ($result->num_rows>0)) {
            $row = $result->fetch_array();
            $pjCode = $row['backup'];
        }

        return $pjCode;
    }

    private function dbi_get_product_type($mysqli, $pjCode)
    {
        $typeList = array(); //初始化
        $query_str = "SELECT * FROM `t_l3f11faam_typesheet` WHERE `pjcode` = '$pjCode' ";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            array_push($typeList, $row);
        }

        return $typeList;
    }

    private function dbi_get_factory_config($mysqli, $pjCode)
    {
        $config = ""; //初始化
        $query_str = "SELECT * FROM `t_l3f11faam_factorysheet` WHERE `pjcode` = '$pjCode' ";
        $result = $mysqli->query($query_str);
        if(($result != false) AND ($result->num_rows>0)) {
            $row = $result->fetch_array();
            $config = array("workstart" => $row['workstart'],
                            "workend" => $row['workend'],
                            "reststart" => $row['reststart'],
                            "restend" => $row['restend'],
                            "fullwork" => $row['fullwork']);
        }

        return $config;
    }

    private function dbi_get_employee_config($mysqli, $pjCode,$employee)
    {
        $config = ""; //初始化
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode' AND `employee` = '$employee')";
        $result = $mysqli->query($query_str);
        if(($result != false) AND ($result->num_rows>0)) {
            $row = $result->fetch_array();
            $config = array("unitprice" => $row['unitprice'],
                            "standardnum" => $row['standardnum']);
        }

        return $config;
    }

    //查询员工记录表中记录总数
    public function dbi_faam_employeenum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE 1";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    //UI StaffnameList request
    public function dbi_faam_staff_namelist_query($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $nameList = array();
        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $temp = array('id' => $row['mid'],'name' => $row['employee']);
            array_push($nameList, $temp);
        }
        $mysqli->close();
        return $nameList;
    }

    //UI StaffTable request, 获取所有员工信息表
    public function dbi_faam_stafftable_query($uid,$start,$query_length,$keyword)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //考虑到多工厂情况，将来需要根据登录用户属性选择对应工厂的员工列表显示
        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $staffTable = array(); //初始化
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        //没有关键字查询
        if (empty($keyword)){
            while (($result != false) && (($row = $result->fetch_array()) > 0)) {
                $temp = array(
                    'id' => $row['mid'],
                    'name' => $row['employee'],
                    'PJcode'=> $row['pjcode'],
                    'nickname' => $row['openid'],
                    'mobile' => $row['phone'],
                    'gender' => $row['gender'],
                    'address' => $row['address'],
                    'salary' => $row['unitprice'],
                    'position' => $row['position'],
                    'memo' => $row['memo']
                );
                array_push($staffTable, $temp);
            }
        }
        //有关键字模糊查询
        else{
            $query_str = "SELECT * FROM `t_l3f11faam_membersheet` where concat(`employee`,`phone`) like '%$keyword%'";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($row = $result->fetch_array()) > 0)) {
                $temp = array(
                    'id' => $row['mid'],
                    'name' => $row['employee'],
                    'PJcode'=> $row['pjcode'],
                    'nickname' => $row['openid'],
                    'mobile' => $row['phone'],
                    'gender' => $row['gender'],
                    'address' => $row['address'],
                    'salary' => $row['unitprice'],
                    'position' => $row['position'],
                    'memo' => $row['memo']
                );
                array_push($staffTable, $temp);
            }
        }

        $mysqli->close();
        return $staffTable;
    }

    // UI StaffMod request, 修改员工信息表
    public function dbi_faam_staff_table_modify($staffInfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($staffInfo["staffid"])) $staffId = trim($staffInfo["staffid"]); else  $staffId = "";
        if (isset($staffInfo["name"])) $employee = trim($staffInfo["name"]); else  $employee = "";
        if (isset($staffInfo["PJcode"])) $pjCode = trim($staffInfo["PJcode"]); else  $pjCode = "";
        if (isset($staffInfo["position"])) $position = trim($staffInfo["position"]); else  $position = "";
        if (isset($staffInfo["gender"])) $gender = trim($staffInfo["gender"]); else  $gender = "";
        if (isset($staffInfo["mobile"])) $phone = trim($staffInfo["mobile"]); else  $phone = "";
        if (isset($staffInfo["address"])) $address = trim($staffInfo["address"]); else  $address = "";
        if (isset($staffInfo["salary"])) $unitPrice = intval($staffInfo["salary"]); else  $unitPrice = 0;
        if (isset($staffInfo["memo"])) $memo = trim($staffInfo["memo"]); else  $memo = "";

        $date = date("Y-m-d", time());
        $query_str = "UPDATE `t_l3f11faam_membersheet` SET `pjcode` = '$pjCode',`employee` = '$employee',`gender` = '$gender',`phone` = '$phone',
                      `regdate` = '$date',`position` = '$position',`address` = '$address',`unitprice` = '$unitPrice',`memo` = '$memo' WHERE (`mid` = '$staffId')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    // UI StaffNew request, 新建员工信息表
    public function dbi_faam_staff_table_new($staffInfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($staffInfo["name"])) $employee = trim($staffInfo["name"]); else  $employee = "";
        if (isset($staffInfo["PJcode"])) $pjCode = trim($staffInfo["PJcode"]); else  $pjCode = "";
        if (isset($staffInfo["position"])) $position = trim($staffInfo["position"]); else  $position = "";
        if (isset($staffInfo["gender"])) $gender = trim($staffInfo["gender"]); else  $gender = "";
        if (isset($staffInfo["mobile"])) $phone = trim($staffInfo["mobile"]); else  $phone = "";
        if (isset($staffInfo["address"])) $address = trim($staffInfo["address"]); else  $address = "";
        if (isset($staffInfo["salary"])) $unitPrice = intval($staffInfo["salary"]); else  $unitPrice = 0;
        if (isset($staffInfo["memo"])) $memo = trim($staffInfo["memo"]); else  $memo = "";

        $date = date("Y-m-d", time());
        $mid = MFUN_L3APL_F1SYM_MID_PREFIX.$this->getRandomUid(MFUN_L3APL_F1SYM_USER_ID_LEN);  //随机生成员工ID

        $query_str = "INSERT INTO `t_l3f11faam_membersheet` (mid,pjcode,employee,gender,phone,regdate,position,address,unitprice,memo)
                              VALUES ('$mid','$pjCode','$employee','$gender','$phone','$date','$position','$address','$unitPrice','$memo')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    //UI StaffDel request, 员工信息删除
    public function dbi_faam_staff_table_delete($staffId)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $query_str = "DELETE FROM `t_l3f11faam_membersheet` WHERE `mid` = '$staffId'";  //删除员工信息
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    //UI AttendanceHistory request, 考勤记录表查询
    public function dbi_faam_attendance_history_query($uid, $timeStart, $timeEnd, $keyWord)
    {
        //初始化返回值
        $history["ColumnName"] = array();
        $history['TableData'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        array_push($history["ColumnName"], "序号");
        array_push($history["ColumnName"], "姓名");
        array_push($history["ColumnName"], "日期");
        array_push($history["ColumnName"], "上班时间");
        array_push($history["ColumnName"], "下班时间");
        array_push($history["ColumnName"], "请假时长");
        array_push($history["ColumnName"], "工时(小时)");

        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode` = '$pjCode' AND `workday`>='$timeStart' AND `workday`<='$timeEnd' AND (concat(`employee`) like '%$keyWord%'))";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $sid = $row['sid'];
            $employee = $row['employee'];
            $workDay = $row['workday'];
            $arriveTime = $row['arrivetime'];
            $leaveTime = $row['leavetime'];
            $offWork = $row['offwork'];
            $workTime = $row['worktime'];

            $temp = array();
            array_push($temp, $sid);
            array_push($temp, $employee);
            array_push($temp, $workDay);
            array_push($temp, $arriveTime);
            array_push($temp, $leaveTime);
            array_push($temp, $offWork);
            array_push($temp, $workTime);
            array_push($history['TableData'], $temp);
        }

        $mysqli->close();
        return $history;
    }

    public function dbi_faam_attendance_history_audit($uid, $timeStart, $timeEnd, $keyWord)
    {
        //初始化返回值
        $history["ColumnName"] = array();
        $history['TableData'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        array_push($history["ColumnName"], "序号");
        array_push($history["ColumnName"], "姓名");
        array_push($history["ColumnName"], "开始日期");
        array_push($history["ColumnName"], "结束日期");
        array_push($history["ColumnName"], "迟到次数");
        array_push($history["ColumnName"], "早退次数");
        array_push($history["ColumnName"], "请假次数");
        array_push($history["ColumnName"], "请假时长");
        array_push($history["ColumnName"], "工作天数");
        array_push($history["ColumnName"], "工作时长");

        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);

        $buffer = array();
        if(!empty($keyWord)) { //关键字不空，查找指定员工
            $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode`='$pjCode' AND `workday`>='$timeStart' AND `workday`<='$timeEnd' AND `employee`='$keyWord')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {  //输入的关键字为用户名
                while (($row = $result->fetch_array()) > 0)
                    array_push($buffer, $row);
            }
        }
        else{ //关键字为空，查找全部员工
            $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode`='$pjCode' AND `workday`>='$timeStart' AND `workday`<='$timeEnd')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {
                while (($row = $result->fetch_array()) > 0)
                    array_push($buffer, $row);
            }
        }
        if(empty($buffer)) {  //如果查询结果为空，这直接返回
            $mysqli->close();
            return $history;
        }
        //查询员工列表
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        $nameList = array();
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $temp = array('employee' => $row['employee']);
            array_push($nameList, $temp);
        }

        //处理查询结果
        for($i=0; $i<count($buffer); $i++){
            $employee = $buffer[$i]['employee'];
            $lateWorkFlag = $buffer[$i]['lateworkflag'];
            $earlyLeaveFlag = $buffer[$i]['earlyleaveflag'];
            $offWorkTime = $buffer[$i]['offwork'];
            $workTime = $buffer[$i]['worktime'];

            if(isset($workingDay[$employee]) AND isset($lateWorkDay[$employee]) AND isset($earlyLeaveDay[$employee]) AND
                isset($totalWorkTime[$employee]) AND isset($offWorkDay[$employee]) AND isset($totalOffWorkTime[$employee])){
                if($lateWorkFlag) $lateWorkDay[$employee]++;
                if($earlyLeaveFlag) $earlyLeaveDay[$employee]++;
                if($workTime != 0) {
                    $workingDay[$employee]++;
                    $totalWorkTime[$employee] = $totalWorkTime[$employee] + $workTime;
                }
                if($offWorkTime != 0){
                    $offWorkDay[$employee]++;
                    $totalOffWorkTime[$employee] = $totalOffWorkTime[$employee] + $offWorkTime;
                }
            }
            else{ //第一次查询到某员工
                if($lateWorkFlag) $lateWorkDay[$employee] = 1;else $lateWorkDay[$employee] = 0;
                if($earlyLeaveFlag) $earlyLeaveDay[$employee] = 1; else $earlyLeaveDay[$employee] = 0;
                if($workTime != 0) {
                    $workingDay[$employee] = 1;
                    $totalWorkTime[$employee] = $workTime;
                }
                else{
                    $workingDay[$employee] = 0;
                    $totalWorkTime[$employee] = 0;
                }

                if($offWorkTime != 0){
                    $offWorkDay[$employee] = 1;
                    $totalOffWorkTime[$employee] = $offWorkTime;
                }
                else{
                    $offWorkDay[$employee] = 0;
                    $totalOffWorkTime[$employee] = 0;
                }
            }
        }
        //显示查询结果
        $sid = 0;
        for($i=0; $i<count($nameList); $i++){
            $employee = $nameList[$i]['employee'];
            if(isset($workingDay[$employee]) AND isset($lateWorkDay[$employee]) AND isset($earlyLeaveDay[$employee]) AND
                isset($totalWorkTime[$employee]) AND isset($offWorkDay[$employee]) AND isset($totalOffWorkTime[$employee])){
                $sid++;
                $temp = array();
                array_push($temp, $sid++);
                array_push($temp, $employee);
                array_push($temp, $timeStart);
                array_push($temp, $timeEnd);
                array_push($temp, $lateWorkDay[$employee]);
                array_push($temp, $earlyLeaveDay[$employee]);
                array_push($temp, $offWorkDay[$employee]);
                array_push($temp, $totalOffWorkTime[$employee]);
                array_push($temp, $workingDay[$employee]);
                array_push($temp, $totalWorkTime[$employee]);
                array_push($history['TableData'], $temp);
            }
        }

        $mysqli->close();
        return $history;
    }

    //UI AttendanceNew request,手动添加一条考勤记录
    public function dbi_faam_attendance_record_new($uid, $record)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($record["name"])) $employee = trim($record["name"]); else  $employee = "";
        //if (isset($record["PJcode"])) $pjCode = trim($record["PJcode"]); else  $pjCode = "";
        if (isset($record["PJcode"])) $offWork = trim($record["PJcode"]); else  $offWork = 0;  //暂时使用此字段作为请假时间
        if (isset($record["date"])) $workDay = trim($record["date"]); else  $workDay = "";
        if (isset($record["arrivetime"])) $arriveTime = trim($record["arrivetime"]); else  $arriveTime = "";
        if (isset($record["leavetime"])) $leaveTime = trim($record["leavetime"]); else  $leaveTime = "";

        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $employee_config = $this->dbi_get_employee_config($mysqli, $pjCode, $employee);
        $unitPrice = $employee_config['unitprice'];

        $factory_config = $this->dbi_get_factory_config($mysqli, $pjCode);
        $restStart = strtotime($factory_config['reststart']);
        $restEnd = strtotime($factory_config['restend']);
        $stdWorkStart = strtotime($factory_config['workstart']);
        $stdWorkEnd = strtotime($factory_config['workend']);

        $arriveTimeInt = strtotime($arriveTime);
        $leaveTimeInt = strtotime($leaveTime);
        $offWorkTime = round($offWork, 1);
        if($arriveTimeInt <= $restStart AND $leaveTimeInt >= $restEnd){ //正常情况，在午休前上班，午休后下班
            $timeInterval = ($restStart - $arriveTimeInt) + ($leaveTimeInt - $restEnd);
        }
        elseif($arriveTimeInt >= $restStart AND $arriveTimeInt <= $restEnd){ //在午休中间上班
            $timeInterval = ($leaveTimeInt - $restEnd);
        }
        elseif($leaveTimeInt >= $restStart AND $leaveTimeInt <= $restEnd){ //在午休中间下班
            $timeInterval = ($restStart - $arriveTimeInt);
        }
        elseif($arriveTimeInt >= $restEnd){ //在午休后上班
            $timeInterval = ($leaveTimeInt - $arriveTimeInt);
        }
        elseif($leaveTimeInt <= $restStart){ //在午休前下班
            $timeInterval = ($leaveTimeInt - $arriveTimeInt);
        }
        else{
            $timeInterval = 0;
        }

        $hour = (int)(($timeInterval%(3600*24))/(3600));
        $min = (int)($timeInterval%(3600)/60);
        $workTime = $hour + round($min/60, 1)  - $offWorkTime; //扣除请假时间
        if ($workTime < 0) $workTime = 0; //避免工作时间为负数

        if($arriveTimeInt < $stdWorkStart) $lateWorkFlag = false; else $lateWorkFlag = true;  //迟到标志
        if($leaveTimeInt > $stdWorkEnd) $earlyLeaveFlag = false; else $earlyLeaveFlag = true; //早退标志

        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`employee` = '$employee' AND `pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        if(($result != false) && ($result->num_rows)>0){ //输入员工姓名合法
            $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode` = '$pjCode' AND `employee` = '$employee' AND `workday` = '$workDay')";
            $result = $mysqli->query($query_str);
            if(($result != false) && ($result->num_rows)>0){  //如果该员工当天已经有考勤记录则更新，否则插入新纪录
                $query_str = "UPDATE `t_l3f11faam_dailysheet` SET `arrivetime` = '$arriveTime',`leavetime` = '$leaveTime',`offwork` = '$offWork',`worktime` = '$workTime',
                          `unitprice` = '$unitPrice',`lateworkflag` = '$lateWorkFlag',`earlyleaveflag` = '$earlyLeaveFlag' WHERE (`pjcode` = '$pjCode' AND `employee` = '$employee' AND `workday` = '$workDay')";
                $result = $mysqli->query($query_str);
            }
            else{
                $query_str = "INSERT INTO `t_l3f11faam_dailysheet` (pjcode,employee,workday,arrivetime,leavetime,offwork,worktime,unitprice,lateworkflag,earlyleaveflag)
                                  VALUES ('$pjCode','$employee','$workDay','$arriveTime','$leaveTime','$offWork','$workTime','$unitPrice','$lateWorkFlag','$earlyLeaveFlag')";
                $result = $mysqli->query($query_str);
            }
        }
        else
            $result = false;

        $mysqli->close();
        return $result;
    }

    //UI AttendanceMod request
    public function dbi_faam_attendance_record_modify($uid, $record)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($record["attendanceID"])) $sid = trim($record["attendanceID"]); else  $sid = "";
        if (isset($record["name"])) $employee = trim($record["name"]); else  $employee = "";
        //if (isset($record["PJcode"])) $pjCode = trim($record["PJcode"]); else  $pjCode = "";
        if (isset($record["PJcode"])) $offWork = (float)($record["PJcode"]); else  $offWork = 0;  //暂时使用此字段作为请假时间
        if (isset($record["date"])) $workDay = trim($record["date"]); else  $workDay = "";
        if (isset($record["arrivetime"])) $arriveTime = trim($record["arrivetime"]); else  $arriveTime = "";
        if (isset($record["leavetime"])) $leaveTime = trim($record["leavetime"]); else  $leaveTime = "";

        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $employee_config = $this->dbi_get_employee_config($mysqli, $pjCode, $employee);
        if (isset($employee_config['unitprice'])) $unitPrice = $employee_config['unitprice']; else  $unitPrice = 0;

        $factory_config = $this->dbi_get_factory_config($mysqli, $pjCode);
        $restStart = strtotime($factory_config['reststart']);
        $restEnd = strtotime($factory_config['restend']);
        $stdWorkStart = strtotime($factory_config['workstart']);
        $stdWorkEnd = strtotime($factory_config['workend']);

        $arriveTimeInt = strtotime($arriveTime);
        $leaveTimeInt = strtotime($leaveTime);
        $offWorkTime = round($offWork, 1);
        if($arriveTimeInt <= $restStart AND $leaveTimeInt >= $restEnd){ //正常情况，在午休前上班，午休后下班
            $timeInterval = ($restStart - $arriveTimeInt) + ($leaveTimeInt - $restEnd);
        }
        elseif($arriveTimeInt >= $restStart AND $arriveTimeInt <= $restEnd){ //在午休中间上班
            $timeInterval = ($leaveTimeInt - $restEnd);
        }
        elseif($leaveTimeInt >= $restStart AND $leaveTimeInt <= $restEnd){ //在午休中间下班
            $timeInterval = ($restStart - $arriveTimeInt);
        }
        elseif($arriveTimeInt >= $restEnd){ //在午休后上班
            $timeInterval = ($leaveTimeInt - $arriveTimeInt);
        }
        elseif($leaveTimeInt <= $restStart){ //在午休前下班
            $timeInterval = ($leaveTimeInt - $arriveTimeInt);
        }
        else{
            $timeInterval = 0;
        }

        $hour = (int)(($timeInterval%(3600*24))/(3600));
        $min = (int)($timeInterval%(3600)/60);
        $workTime = $hour + round($min/60, 1) - $offWorkTime; //扣除请假时间
        if ($workTime < 0) $workTime = 0; //避免工作时间为负数

        if($arriveTimeInt < $stdWorkStart) $lateWorkFlag = false; else $lateWorkFlag = true;  //迟到标志
        if($leaveTimeInt > $stdWorkEnd) $earlyLeaveFlag = false; else $earlyLeaveFlag = true; //早退标志

        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`employee` = '$employee' AND `pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        if(($result != false) && ($result->num_rows)>0){ //输入员工姓名合法
            $query_str = "UPDATE `t_l3f11faam_dailysheet` SET `workday` = '$workDay',`arrivetime` = '$arriveTime',`leavetime` = '$leaveTime',`offwork` = '$offWork',`worktime` = '$workTime',
                          `unitprice` = '$unitPrice',`lateworkflag` = '$lateWorkFlag',`earlyleaveflag` = '$earlyLeaveFlag' WHERE (`sid` = '$sid')";
            $result = $mysqli->query($query_str);
        }
        else
            $result = false;

        $mysqli->close();
        return $result;
    }

    //UI AttendanceDel request, 删除一条考勤记录
    public function dbi_faam_attendance_record_delete($recordId)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $query_str = "DELETE FROM `t_l3f11faam_dailysheet` WHERE `sid` = '$recordId'";  //删除一条考勤信息
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    //UI GetAttendance request
    public function dbi_faam_attendance_record_get($recordId)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $record = array();
        $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`sid` = '$recordId')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0){
            $row = $result->fetch_array();
            $record = array("attendanceID" => $row['sid'],
                            "PJcode" => $row['offwork'],
                            "name" => $row['employee'],
                            "arrivetime" => $row['arrivetime'],
                            "leavetime" => $row['leavetime'],
                            "date" => $row['workday']);
        }
        $mysqli->close();
        return $record;
    }

    //UI AssembleHistory request
    public function dbi_faam_production_history_query($uid, $timeStart, $timeEnd, $keyWord)
    {
        //初始化返回值
        $history["ColumnName"] = array();
        $history['TableData'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        array_push($history["ColumnName"], "序号");
        array_push($history["ColumnName"], "二维码");
        array_push($history["ColumnName"], "工人姓名");
        array_push($history["ColumnName"], "产品规格");
        array_push($history["ColumnName"], "申请时间");
        array_push($history["ColumnName"], "成品时间");

        $dayTimeStart = $timeStart." 00:00:00";
        $dayTimeEnd = $timeEnd." 23:59:59";
        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $query_str = "SELECT * FROM `t_l3f11faam_appleproduction` WHERE (`pjcode` = '$pjCode' AND `applytime`>='$dayTimeStart' AND `applytime`<='$dayTimeEnd' AND (concat(`owner`,`typecode`) like '%$keyWord%'))";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $sid = $row['sid'];
            $employee = $row['owner'];
            $qrcode = $row['qrcode'];
            $appleGrade = $row['typecode'];
            $applyTime = $row['applytime'];
            $activeTime = $row['activetime'];

            $temp = array();
            array_push($temp, $sid);
            array_push($temp, $qrcode);
            array_push($temp, $employee);
            array_push($temp, $appleGrade);
            array_push($temp, $applyTime);
            array_push($temp, $activeTime);
            array_push($history['TableData'], $temp);
        }

        $mysqli->close();
        return $history;
    }

    //UI AssembleAudit request
    public function dbi_faam_production_history_audit($uid, $timeStart, $timeEnd, $keyWord)
    {
        //初始化返回值
        $history["ColumnName"] = array();
        $history['TableData'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        array_push($history["ColumnName"], "序号");
        array_push($history["ColumnName"], "员工姓名");
        array_push($history["ColumnName"], "开始日期");
        array_push($history["ColumnName"], "结束日期");
        array_push($history["ColumnName"], "产品规格");
        array_push($history["ColumnName"], "总箱数");
        array_push($history["ColumnName"], "总粒数");
        array_push($history["ColumnName"], "总重量");

        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $dayTimeStart = $timeStart." 00:00:00";
        $dayTimeEnd = $timeEnd." 23:59:59";

        $buffer = array();
        if(!empty($keyWord)) {
            $query_str = "SELECT * FROM `t_l3f11faam_appleproduction` WHERE (`pjcode` = '$pjCode' AND `activetime`>='$dayTimeStart' AND `activetime`<='$dayTimeEnd' AND `owner` = '$keyWord')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {  //输入的关键字为用户名
                while (($row = $result->fetch_array()) > 0)
                    array_push($buffer, $row);
            }
            else {  //使用用户名查询结果为0，尝试用产品类型查询
                $query_str = "SELECT * FROM `t_l3f11faam_appleproduction` WHERE (`pjcode` = '$pjCode' AND `activetime`>='$dayTimeStart' AND `activetime`<='$dayTimeEnd' AND (concat(`typecode`) like '%$keyWord%'))";
                $result = $mysqli->query($query_str);
                if (($result != false) && ($result->num_rows) > 0) {  //输入的关键字为产品类型
                    while (($row = $result->fetch_array()) > 0)
                        array_push($buffer, $row);
                }
            }
        }
        else{ //关键字为空
            $query_str = "SELECT * FROM `t_l3f11faam_appleproduction` WHERE (`pjcode` = '$pjCode' AND `activetime`>='$dayTimeStart' AND `activetime`<='$dayTimeEnd')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {
                while (($row = $result->fetch_array()) > 0)
                    array_push($buffer, $row);
            }
        }

        if(empty($buffer)) {  //如果查询结果为空，这直接返回
            $mysqli->close();
            return $history;
        }

        //查询员工列表
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        $nameList = array();
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $temp = array('employee' => $row['employee']);
            array_push($nameList, $temp);
        }
        //查询产品规格列表
        $typeList = $this->dbi_get_product_type($mysqli, $pjCode);

        //处理查询结果
        for($i=0; $i<count($buffer); $i++){
            $employee = $buffer[$i]['owner'];
            $typeCode = $buffer[$i]['typecode'];
            if(isset($package[$employee][$typeCode]))
                $package[$employee][$typeCode]++;
            else
                $package[$employee][$typeCode] = 1;
        }

        //显示查询结果
        $sid = 0;
        for($i=0; $i<count($nameList); $i++){
            $employee = $nameList[$i]['employee'];
            for($j=0; $j<count($typeList); $j++){
                $typeCode = $typeList[$j]['typecode'];
                $appleNum = $typeList[$j]['applenum'];
                $appleWeight = $typeList[$j]['appleweight'];
                if(isset($package[$employee][$typeCode])){
                    $sid++;
                    $totalPackage = (int)$package[$employee][$typeCode];
                    $totalNum = $totalPackage * (int)$appleNum;
                    $totalWeight = $totalPackage * (int)$appleWeight;
                    $temp =array();
                    array_push($temp, $sid);
                    array_push($temp, $employee);
                    array_push($temp, $timeStart);
                    array_push($temp, $timeEnd);
                    array_push($temp, $typeCode);
                    array_push($temp, $totalPackage);
                    array_push($temp, $totalNum);
                    array_push($temp, $totalWeight);
                    array_push($history['TableData'], $temp);
                }
            }
        }

        $mysqli->close();
        return $history;
    }

}

?>