<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2016/3/4
 * Time: 14:54
 */

//include_once "../config/config.php";
include_once "../database/db_common.class.php";
//header("Content-type:text/html;charset=utf-8");


if(isset($_GET["deviceid"])) {
    $deviceid = $_GET["deviceid"];
}

if(isset($_GET["opt_type"])) {
    $opt_type = $_GET["opt_type"];
}
if ($opt_type == "HCU_VIDEO_INQUIRY")
{
    $cDbObj = new class_common_db();
    $result = $cDbObj->db_videodata_inquiry_url($deviceid);

    if ($result != false)
        echo json_encode($result);
}
elseif ($opt_type == "HCU_URL_INQUIRY")
{
    $cDbObj = new class_common_db();
    $result = $cDbObj->db_hcuDevice_inquiry_url($deviceid);

    if ($result != false)
        echo json_encode($result);
}
elseif ($opt_type == "HCU_DEVICE_INQUIRY"){
    $cDbObj = new class_common_db();
    $result = $cDbObj->db_hcuDevice_inquiry_device();

    if ($result != false)
        echo json_encode($result);
}

?>