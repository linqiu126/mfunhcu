<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 2016/10/15
 * Time: 14:57
 */

include_once "../l1comvm/vmlayer.php";

/**************************************************************************************
 *                             L4TBSWR-UI TEST CASES                                   *
 *************************************************************************************/
if (TC_L4FAAM_UI == true) {
    $sessionid = "0FDfiQ58z8";
    $uerid = "UID000001";

    $timeStart = '2017-12-01';
    $timeEnd = '2017-12-25';

    echo " [TC L4FAAM: AttendanceMod START]\n";
    $_GET["action"] = "AttendanceMod";
    $_GET["user"] = $sessionid;
    $body = array("attendanceID"=>"7","PJcode"=>0.5,"name"=>'小慧同学',"arrivetime"=>'12:52:56',"leavetime"=>'18:00:00',"date"=>'2017-12-19');
    $_GET["body"] = $body;
    require("../l4faamui/request.php");
    echo " [TC L4FAAM: AttendanceMod END]\n";

    echo " [TC L4FAAM: AttendanceAudit START]\n";
    $_GET["action"] = "AttendanceAudit";
    $_GET["user"] = $sessionid;
    $body = array("TimeStart"=>"2017-12-01", "TimeEnd"=>"2017-12-26","KeyWord"=>"孙尚翠");
    $_GET["body"] = $body;
    require("../l4faamui/request.php");
    echo " [TC L4FAAM: AttendanceAudit END]\n";

    echo " [TC L4FAAM: StaffNew START]\n";
    $_GET["action"] = "StaffNew";
    $_GET["user"] = $sessionid;
    $body = array("staffid"=>"MID391949","name"=>'老李',"position"=>'管理员',"PJcode"=>'XHZN',"mobile"=>'13912345678',"address"=>'上海浦东',"gender"=>1,"memo"=>'恒源果蔬',"salary"=>100);
    $_GET["body"] = $body;
    require("../l4faamui/request.php");
    echo " [TC L4FAAM: StaffNew END]\n";

    echo " [TC L4FAAM: AssembleHistory START]\n";
    $_GET["action"] = "AssembleHistory";
    $_GET["user"] = $sessionid;
    $body = array("TimeStart"=>"2017-12-01", "TimeEnd"=>"2017-12-24","KeyWord"=>"");
    $_GET["body"] = $body;
    require("../l4faamui/request.php");
    echo " [TC L4FAAM: AssembleHistory END]\n";

    echo " [TC L4FAAM: StaffMod START]\n";
    $_GET["action"] = "StaffMod";
    $_GET["user"] = $sessionid;
    $body = array("staffid"=>"MID391940","name"=>'老刘',"position"=>'管理员',"PJcode"=>'XHZN',"mobile"=>'13912345678',"address"=>'上海浦东',"gender"=>1,"memo"=>'恒源果蔬',"salary"=>100);
    $_GET["body"] = $body;
    require("../l4faamui/request.php");
    echo " [TC L4FAAM: StaffMod END]\n";

    echo " [TC L4FAAM: AttendanceNew START]\n";
    $_GET["action"] = "AttendanceNew";
    $_GET["user"] = $sessionid;
    $body = array("PJcode"=>0.5,"name"=>'老刘',"arrivetime"=>'12:52:56',"leavetime"=>'18:00:00',"date"=>'2017-12-24');
    $_GET["body"] = $body;
    require("../l4faamui/request.php");
    echo " [TC L4FAAM: AttendanceNew END]\n";

    echo " [TC L4FAAM: GetAttendance START]\n";
    $_GET["action"] = "GetAttendance";
    $_GET["user"] = $sessionid;
    $body = array("attendanceID"=>"2");
    $_GET["body"] = $body;
    require("../l4faamui/request.php");
    echo " [TC L4FAAM: GetAttendance END]\n";

    echo " [TC L4FAAM: AttendanceHistory START]\n";
    $_GET["action"] = "AttendanceHistory";
    $_GET["user"] = $sessionid;
    $body = array("Time"=>"1", "KeyWord"=>"");
    $_GET["body"] = $body;
    require("../l4faamui/request.php");
    echo " [TC L4FAAM: AttendanceHistory END]\n";

    echo " [TC L4FAAM: StaffTable START]\n";
    $_GET["action"] = "StaffTable";
    $_GET["user"] = $sessionid;
    require("../l4faamui/request.php");
    echo " [TC L4FAAM: StaffTable END]\n";

    echo " [TC L4FAAM: StaffDel START]\n";
    $_GET["action"] = "StaffDel";
    $_GET["user"] = $sessionid;
    require("../l4faamui/request.php");
    echo " [TC L4FAAM: StaffDel END]\n";

}




?>