<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/10/6
 * Time: 20:20
 */

include_once "../l1comvm/vmlayer.php";
include_once "../l2sdk/task_l2sdk_wechat.class.php";
header("Content-type:text/html;charset=utf-8");

$result = false;

if($_FILES['csvfile']['name']!='' && is_uploaded_file($_FILES['csvfile']['tmp_name'])) {
    $fname = './csvupload/' . $_FILES['csvfile']['name'];
    move_uploaded_file($_FILES['csvfile']['tmp_name'], $fname);


    $file_csv = fopen($fname, 'r');
    while ($data = fgetcsv($file_csv)) {
        $csv_content[] = $data;
    }
    fclose($file_csv);
    unlink($fname);

    $wxDbObj = new classDbiL2sdkWechat();
    for ($k = 0; $k < count($csv_content); $k++) {
        $deviceid = $csv_content[$k][0];
        $qrcode = $csv_content[$k][1];
        $devicetype = $csv_content[$k][2];
        $macaddr = $csv_content[$k][3];
        $resp = $wxDbObj->dbi_deviceqrcode_query($deviceid, $devicetype);
        if ($resp == false)
            $result = $wxDbObj->dbi_deviceqrcode_save($deviceid, $qrcode, $devicetype, $macaddr);
        else
            $result = $wxDbObj->dbi_deviceqrcode_update_mac($deviceid, $macaddr);
    }
}

if ($result == false){
    echo "<script type='text/javascript'> alert('告警：数据导入失败！'); history.back();</script>";
    exit(0);
}
else
    echo "<script type='text/javascript'> alert('提示：数据导入成功！'); history.back();</script>";

?>