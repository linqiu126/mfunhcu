
<?php
/**
 * Created by PhpStorm.
 * User: shanchuz
 * Date: 2015/10/19
 * Time: 15:50
 */

include_once "../../l1comvm/vmlayer.php";
include_once "../../l2sdk/iot_wx.class.php";
header("Content-type:text/html;charset=utf-8");
//访问数据库数据



if(isset($_GET["data"])) {
    $data = $_GET["data"];
}

/*
if(isset($_GET["deviceid"])) {
    $deviceid = $_GET["deviceid"];
}
*/

//$deviceid = $db->db_DeviceID_inqury($wxuser);

//$result = $db->db_EmcAccumulationInfo_inqury($wxuser, $deviceid);


$content = base64_decode($data);
$content = unpack('H*',$content);
$strContent = strtoupper($content["1"]); //转换成16进制格式的字符串
$emc_value = hexdec(substr($content, 4, 4)) & 0xFFFF;

echo json_encode($emc_value);

?>