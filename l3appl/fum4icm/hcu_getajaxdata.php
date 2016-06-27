<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2016/3/4
 * Time: 14:54
 */
include_once "../../l1comvm/vmlayer.php";
header("Content-type:text/html;charset=utf-8");

$deviceid = 0;
$opt_type = 0;

if(isset($_GET["deviceid"])) {
    $deviceid = $_GET["deviceid"];
}

if(isset($_GET["opt_type"])) {
    $opt_type = $_GET["opt_type"];
}
if ($opt_type == "HCU_VIDEO_INQUIRY")
{
    $cDbObj = new classDbiL1vmCommon();
    $result = $cDbObj->dbi_videodata_inquiry_url($deviceid);

    if ($result != false)
        echo json_encode($result);
}
elseif ($opt_type == "HCU_URL_INQUIRY")
{
    $cDbObj = new classDbiL1vmCommon();
    $result = $cDbObj->dbi_siteinfo_inquiry_url($deviceid);

    if ($result != false)
        echo json_encode($result);
}
elseif ($opt_type == "HCU_DEVICE_INQUIRY"){
    $cDbObj = new classDbiL1vmCommon();
    $result = $cDbObj->dbi_hcuDevice_inquiry_device();

    if ($result != false)
        echo json_encode($result);
}

?>