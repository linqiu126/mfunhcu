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

    public function dbi_faam_qrcode_kq_process($scanCode,$latitude,$longitude,$nickName)
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
            $targetLatitude = round($row['latitude']/1000000, 2); //GPS取2位小数
            $targetLongitude = round($row['longitude']/1000000, 2);
            $latitude = round($latitude/1000000, 2);
            $longitude = round($longitude/1000000, 2);
            if($targetLatitude != $latitude OR $targetLongitude != $longitude){
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

        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`openid` = '$nickName' AND `pjcode` = '$scanCode') ";
        $membersheet = $mysqli->query($query_str);
        if (($membersheet !=false) AND (($row = $membersheet->fetch_array()) > 0)){
            $employee = $row['employee'];
            if (!empty($employee)){ //合法用户，记录考勤信息
                $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`employee` = '$employee' AND `workday` = '$workDay') ";
                $dailysheet = $mysqli->query($query_str);
                if (($dailysheet !=false) AND ($dailysheet->num_rows>0)){ //当天已经有考勤记录，则该次考勤时间记录为下班时间
                    $query_str = "UPDATE `t_l3f11faam_dailysheet` SET `leavetime` = '$currentTime' WHERE (`employee` = '$employee' AND `workday` = '$workDay')";
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
        else{ //初次扫码，未注册用户
            $mid = MFUN_L3APL_F1SYM_MID_PREFIX.$this->getRandomUid(MFUN_L3APL_F1SYM_USER_ID_LEN);  //随机生成员工ID
            $query_str = "INSERT INTO `t_l3f11faam_membersheet` (mid,pjcode,openid,regdate) VALUES ('$mid','$scanCode','$nickName','$workDay')";
            $mysqli->query($query_str);
            $resp = array('employee'=>$nickName, 'message'=>"用户未注册");
        }

        $mysqli->close();
        return $resp;
    }

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
            $qrcode_owner = $row['owner'];
            $appleWeight = $row['appleweight'];
            $appleGrade = $row['applegrade'];
            $appleNum = $row['applenum'];
            $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`openid` = '$nickName') ";
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
                    $resp = array('flag'=>false,'employee'=>$qrcode_owner, 'message'=>"姓名:".$qrcode_owner."; 重量:".$appleWeight."; 粒数:".$appleNum."; 品级:".$appleGrade);
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

    public function dbi_faam_qrcode_sh_process()
    {
        return true;
    }


}

?>