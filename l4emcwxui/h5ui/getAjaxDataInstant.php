
<?php
/**
 * Created by PhpStorm.
 * User: shanchuz
 * Date: 2015/9/9
 * Time: 15:50
 */

include_once "../l1comvm/l1comvm.php";
include_once "../db_class.php";
header("Content-type:text/html;charset=utf-8");


if(isset($_GET["wxuser"])) {
    $wxuser = $_GET["wxuser"];
}

/*
if(isset($_GET["deviceid"])) {
    $deviceid = $_GET["deviceid"];
}
*/

$db = new class_mysql_db();

$sid = 0;
$LatestEmcValueIndex = $db->db_LatestEmcValueIndex_inqury($sid);
$wxuser_db = $db->db_wxuser_inqury($LatestEmcValueIndex-1);
if($wxuser_db = $wxuser)
{
    $EmcValue = $db->db_LatestEmcValue_inqury($LatestEmcValueIndex-1);
}
else
{
    $EmcValue = 0;
}

//$result =  rand(10,300);

$result = intval($EmcValue);
echo json_encode($result);

?>