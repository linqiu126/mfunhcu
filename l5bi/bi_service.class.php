<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2016/1/6
 * Time: 13:40
 */

include_once "../l5bi/bi_db.class.php";


$biObj = new class_bi_db();

$timestamp = time();
$date = date("ymd",$timestamp);
$hour =date('H',$timestamp);

$devcode = "HCU_SH_0301";
$statcode = "120101001";

$biObj->bi_hourreport_process($devcode,$statcode,$date,$hour);

?>