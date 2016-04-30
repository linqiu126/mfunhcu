
<?php
/**
 * Created by PhpStorm.
 * User: shanchuz
 * Date: 2015/9/9
 * Time: 15:50
 */

include_once "../config/config.php";
include_once "../database/db_weixin.class.php";
//header("Content-type:text/html;charset=utf-8");


if(isset($_GET["wxuser"])) {
    $wxuser = $_GET["wxuser"];
}

/*
if(isset($_GET["deviceid"])) {
    $deviceid = $_GET["deviceid"];
}
*/


//访问数据库数据
$db = new class_emc_db();

//临时注销，需要根据新架构调整
//$deviceid = $db->db_deviceid_inqury($wxuser);
//$result = $db->db_EmcAccumulationInfo_inqury( $deviceid);


//$Temp = array(180,78,62,98,64,58,32,33,258,83,78,56,300,39,39,45,65,161,82,73,82,104,72,39,46,64,82,69,69,100,190);
//$Temp = reset($result);

echo json_encode($result);

?>