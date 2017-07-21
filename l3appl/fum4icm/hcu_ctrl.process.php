<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/1/11
 * Time: 22:20
 */
include_once "../../l1comvm/vmlayer.php";
header("Content-type:text/html;charset=utf-8");

$devCode = $_POST["select_content"];
if ($devCode == ""){
    echo "<script type='text/javascript'> alert('告警：请选择监测设备编号！'); history.back();</script>";
    exit(0);
}

$sensorType = $_POST["sensor_type"];
if ($sensorType == NULL){
    echo "<script type='text/javascript'> alert('告警：请选择传感器类型！'); history.back();</script>";
    exit(0);
}

$opt_type = $_POST["opt_type"];
if (empty($opt_type)){
    echo "<script type='text/javascript'> alert('告警：请选择操作类型！'); history.back();</script>";
    exit(0);
}

$dbiL1vmCommonObj = new classDbiL1vmCommon();
switch($sensorType)
{
    case "temperature":
        $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_TEMP_DATA);
        $sensorid = $dbiL1vmCommonObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_TEMP);
        break;
    case "humidity":
        $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_HUMID_DATA);
        $sensorid = $dbiL1vmCommonObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_HUMID);
        break;
    case "windspeed":
        $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_WINDSPD_DATA);
        $sensorid = $dbiL1vmCommonObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_WINDSPD);
        break;
    case "winddirection":
        $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_WINDDIR_DATA);
        $sensorid = $dbiL1vmCommonObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_WINDDIR);
        break;
    case "pmdata":
        $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_PM25_DATA);
        $sensorid = $dbiL1vmCommonObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_PM);
        break;
    case "noise":
        $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_NOISE_DATA);
        $sensorid = $dbiL1vmCommonObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_NOISE);
        break;
    case "emc":
        $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_EMC_DATA);
        $sensorid = $dbiL1vmCommonObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_EMC);
        break;
    case "airpressure":
        $ctrl_key = "";
        $sensorid ="";
        break;
    case "rain":
        $ctrl_key = "";
        $sensorid = "";
        break;
    default:
        $ctrl_key = "";
        $sensorid = "";
        echo"Undefined sensor type!";
        exit;
}

switch($opt_type)
{
    case "set_switch":
        $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_SWITCH_SET);
        $switchSet = $_POST["set_onoff"];
        if ($switchSet == NULL){
            echo "<script type='text/javascript'> alert('告警：请选择测量开启还是停止！'); history.back();</script>";
            exit(0);
        }
        elseif($switchSet == "on"){
            $switch = "01";
        }
        elseif($switchSet == "off"){
            $switch = "00";
        }
        $len = $dbiL1vmCommonObj->byte2string(strlen( $opt_key . $sensorid . $switch)/2);
        $respCmd = $ctrl_key . $len . $opt_key . $sensorid . $switch;
        break;
    case "set_addr":
        $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_ADDR_SET);
        $addr = $_POST["modbus_addr"];
        if (empty($addr)){
            echo "<script type='text/javascript'> alert('请输入MODBUS设备地址！'); history.back();</script>";
            exit(0);
        }
        elseif (intval($addr)>255)
        {
            echo "<script type='text/javascript'> alert('MODBUS设备地址无效，最大值为255！'); history.back();</script>";
            exit(0);
        }
        $addr = $dbiL1vmCommonObj->byte2string($addr & 0xFF);
        $len = $dbiL1vmCommonObj->byte2string(strlen( $opt_key . $sensorid . $addr)/2);
        $respCmd = $ctrl_key . $len . $opt_key . $sensorid . $addr;
        break;
    case "set_period":
        $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_PERIOD_SET);
        $period = $_POST["period"];
        if (empty($period)){
            echo "<script type='text/javascript'> alert('请输入测量周期！'); history.back();</script>";
            exit(0);
        }
        $period = $dbiL1vmCommonObj->ushort2string($period & 0xFFFF);
        $len = $dbiL1vmCommonObj->byte2string(strlen( $opt_key . $sensorid . $period)/2);
        $respCmd = $ctrl_key . $len . $opt_key . $sensorid . $period;
        break;
    case "set_samples":
        $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_SAMPLES_SET);
        $samples = $_POST["samples"];
        if (empty($samples)){
            echo "<script type='text/javascript'> alert('请输入采样间隔！'); history.back();</script>";
            exit(0);
        }
        $samples = $dbiL1vmCommonObj->ushort2string($samples & 0xFFFF);
        $len = $dbiL1vmCommonObj->byte2string(strlen( $opt_key . $sensorid . $samples)/2);
        $respCmd = $ctrl_key . $len . $opt_key . $sensorid . $samples;
        break;
    case "set_times":
        $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_TIMES_SET);
        $times = $_POST["times"];
        if (empty($times)){
            echo "<script type='text/javascript'> alert('请输入测量次数！'); history.back();</script>";
            exit(0);
        }
        $times = $dbiL1vmCommonObj->ushort2string($times & 0xFFFF);
        $len = $dbiL1vmCommonObj->byte2string(strlen( $opt_key . $sensorid . $times)/2);
        $respCmd = $ctrl_key . $len . $opt_key . $sensorid . $times;
        break;
    case "read_switch":
        $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_SWITCH_READ);
        $len = $dbiL1vmCommonObj->byte2string(strlen( $opt_key . $sensorid)/2);
        $respCmd = $ctrl_key . $len . $opt_key . $sensorid;
        break;
    case "read_addr":
        $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_ADDR_READ);
        $len = $dbiL1vmCommonObj->byte2string(strlen( $opt_key . $sensorid)/2);
        $respCmd = $ctrl_key . $len . $opt_key . $sensorid;
        break;
    case "read_period":
        $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_PERIOD_READ);
        $len = $dbiL1vmCommonObj->byte2string(strlen( $opt_key . $sensorid)/2);
        $respCmd = $ctrl_key . $len . $opt_key . $sensorid;
        break;
    case "read_samples":
        $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_SAMPLES_READ);
        $len = $dbiL1vmCommonObj->byte2string(strlen( $opt_key . $sensorid)/2);
        $respCmd = $ctrl_key . $len . $opt_key . $sensorid;
        break;
    case "read_times":
        $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_TIMES_READ);
        $len = $dbiL1vmCommonObj->byte2string(strlen( $opt_key . $sensorid)/2);
        $respCmd = $ctrl_key . $len . $opt_key . $sensorid;
        break;
    default:
        break;
}

if ($respCmd != NULL)
{
    $cDbObj = new classDbiL1vmCommon();
    $result = $cDbObj->dbi_cmdbuf_save_cmd(trim($devCode), trim($respCmd));
    if ($result == TRUE){
        //echo "Command = " . $respCmd . " has been submitted successfully!";
        echo "<script type='text/javascript'> alert('操作命令= $respCmd 已经被成功发送!'); history.back();</script>";
        exit(0);
    }
    else{
        echo "<script type='text/javascript'> alert('测量命令发送失败!'); history.back();</script>";
	}

}


//echo "CMD = " . $respCmd;

/*
if ($respCmd != NULL)
{
    //error_reporting(E_ALL);
    //端口22B8
    $service_port = 4454;
    //本地
    $address = '192.168.1.103';

    //创建 TCP/IP socket
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket < 0) {
        echo "Socket Create failure: " . socket_strerror($socket) . "\n";
    } else {
        echo "Socket Create Success!\n" . $socket;
    }
    $result = socket_connect($socket, $address, $service_port);
    //$result = socket_connect($socket, "127.0.0.1","6666");
    if ($result == false) {
        echo "Socket Connect Failure: " . socket_strerror($result) . "\n";
    }
    elseif ($result == true) {
        echo "Socket Connect Success.\n";
    }
    //发送命令
    $out = "";
    $result = socket_write($socket, $respCmd, strlen($respCmd));
    if ($result == false) {
        echo "Socket Write Failure: " . socket_strerror($result) . "\n";
    }
    else{
        echo "Socket Write Success:Content = " . $respCmd . "; Length = " . $result ."\n";
    }

    while ($out = socket_read($socket, 2048)) {
        echo $out;
    }
    echo "Close socket........";
    socket_close($socket);
}
*/

?>