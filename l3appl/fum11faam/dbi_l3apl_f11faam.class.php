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

    //UI StaffTable request, 获取所有员工信息表
    public function dbi_faam_stafftable_query($uid_start, $uid_total,$keyword)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //考虑到多工厂情况，将来需要根据登录用户属性选择对应工厂的员工列表显示
        $pjCode = MFUN_HCU_FAAM_PJCODE;
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
            while (($result != false) && (($row = $result->fetch_array()) > 0))
            {
                $temp = array(
                    'id' => $row['mid'],
                    'name' => $row['employee'],
                    'PJcode'=> $row['pjcode'],
                    'nickname' => $row['openid'],
                    'mobile' => $row['phone'],
                    'gender' => $row['gender'],
                    'address' => $row['address'],
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
        if (isset($staffInfo["memo"])) $memo = trim($staffInfo["memo"]); else  $memo = "";

        $date = date("Y-m-d", time());
        $query_str = "UPDATE `t_l3f11faam_membersheet` SET `pjcode` = '$pjCode',`employee` = '$employee',`gender` = '$gender',`phone` = '$phone',
                      `regdate` = '$date',`position` = '$position',`address` = '$address', `memo` = '$memo' WHERE (`mid` = '$staffId')";
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
        if (isset($staffInfo["memo"])) $memo = trim($staffInfo["memo"]); else  $memo = "";

        $date = date("Y-m-d", time());
        $mid = MFUN_L3APL_F1SYM_MID_PREFIX.$this->getRandomUid(MFUN_L3APL_F1SYM_USER_ID_LEN);  //随机生成员工ID

        $query_str = "INSERT INTO `t_l3f11faam_membersheet` (mid,pjcode,employee,gender,phone,regdate,position,address,memo)
                              VALUES ('$mid','$pjCode','$employee','$gender','$phone','$date','$position','$address','$memo')";
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

    //UI AttendanceHistory request, 考勤记录查询
    public function dbi_faam_attendance_history_query($duration, $keyWord)
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
        array_push($history["ColumnName"], "工作时长");

        $timestamp = time();
        $end = intval(date("Ymd", $timestamp));
        $start = $end;
        if($duration == MFUN_L3APL_F2CM_EVENT_DURATION_DAY)
            $start = intval(date("Ymd",strtotime('-1 day')));
        elseif($duration == MFUN_L3APL_F2CM_EVENT_DURATION_WEEK)
            $start = intval(date("Ymd",strtotime('-7 day')));
        elseif($duration == MFUN_L3APL_F2CM_EVENT_DURATION_MONTH)
            $start = intval(date("Ymd",strtotime('-30 day')));

        $pjCode = MFUN_HCU_FAAM_PJCODE;
        $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode` = '$pjCode' AND (concat(`employee`) like '%$keyWord%'))";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $sid = $row['sid'];
            $employee = $row['employee'];
            $workDay = $row['workday'];
            $arriveTime = $row['arrivetime'];
            $leaveTime = $row['leavetime'];

            $dateintval = intval(date('Ymd',strtotime($workDay)));
            if($dateintval < $start OR $dateintval > $end) continue; //如果不在查询时间范围内，直接跳过

            if(!empty($arriveTime) AND !empty($leaveTime)){
                $timeInterval = strtotime($leaveTime) - strtotime($arriveTime);
                $hour = (int)(($timeInterval%(3600*24))/(3600));
                $min = (int)($timeInterval%(3600)/60);
                $workTime = $hour."小时".$min."分";
            }
            else
                $workTime = "0小时0分";

            $temp = array();
            array_push($temp, $sid);
            array_push($temp, $employee);
            array_push($temp, $workDay);
            array_push($temp, $arriveTime);
            array_push($temp, $leaveTime);
            array_push($temp, $workTime);
            array_push($history['TableData'], $temp);
        }

        $mysqli->close();
        return $history;
    }

    //UI AttendanceNew request,手动添加一条考勤记录
    public function dbi_faam_attendance_record_new($record)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($record["name"])) $employee = trim($record["name"]); else  $employee = "";
        if (isset($record["PJcode"])) $pjCode = trim($record["PJcode"]); else  $pjCode = "";
        if (isset($record["date"])) $workDay = trim($record["date"]); else  $workDay = "";
        if (isset($record["arrivetime"])) $arriveTime = trim($record["arrivetime"]); else  $arriveTime = "";
        if (isset($record["leavetime"])) $leaveTime = trim($record["leavetime"]); else  $leaveTime = "";

        $pjCode = MFUN_HCU_FAAM_PJCODE;
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`employee` = '$employee' AND `pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        if(($result != false) && ($result->num_rows)>0){ //输入员工姓名合法
            $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode` = '$pjCode' AND `employee` = '$employee' AND `workday` = '$workDay')";
            $result = $mysqli->query($query_str);
            if(($result != false) && ($result->num_rows)>0){
                $query_str = "UPDATE `t_l3f11faam_dailysheet` SET `arrivetime` = '$arriveTime',`leavetime` = '$leaveTime' WHERE (`pjcode` = '$pjCode' AND `employee` = '$employee' AND `workday` = '$workDay')";
                $result = $mysqli->query($query_str);
            }
            else{
                $query_str = "INSERT INTO `t_l3f11faam_dailysheet` (pjcode,employee,workday,arrivetime,leavetime)
                                  VALUES ('$pjCode','$employee','$workDay','$arriveTime','$leaveTime')";
                $result = $mysqli->query($query_str);
            }
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

    public function dbi_faam_production_history_query($duration, $keyWord)
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

        $timestamp = time();
        $end = intval(date("Ymd", $timestamp));
        $start = $end;
        if($duration == MFUN_L3APL_F2CM_EVENT_DURATION_DAY)
            $start = intval(date("Ymd",strtotime('-1 day')));
        elseif($duration == MFUN_L3APL_F2CM_EVENT_DURATION_WEEK)
            $start = intval(date("Ymd",strtotime('-7 day')));
        elseif($duration == MFUN_L3APL_F2CM_EVENT_DURATION_MONTH)
            $start = intval(date("Ymd",strtotime('-30 day')));

        $pjCode = MFUN_HCU_FAAM_PJCODE;
        $query_str = "SELECT * FROM `t_l3f11faam_appleproduction` WHERE (`pjcode` = '$pjCode' AND (concat(`owner`,`applegrade`) like '%$keyWord%'))";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $sid = $row['sid'];
            $employee = $row['owner'];
            $qrcode = $row['qrcode'];
            $appleGrade = $row['applegrade'];
            $applyTime = $row['applytime'];
            $activeTime = $row['activetime'];

            $dateintval = intval(date('Ymd',strtotime($activeTime)));
            if($dateintval < $start OR $dateintval > $end) continue; //如果不在查询时间范围内，直接跳过

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



}

?>