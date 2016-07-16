<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/7
 * Time: 22:10
 */
include_once "../l1comvm/vmlayer.php";

class classTaskL4nbiotIpmUi
{
    //构造函数
    public function __construct()
    {

    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l4nbiot_ipm_ui_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L4NBIOT_IPM_UI", "mfun_l4nbiot_ipm_ui_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L4AQYCUI，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L4NBIOT_IPM_UI", "mfun_l4nbiot_ipm_ui_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        if (($msgId == MSG_ID_L4NBIOT_IPMUI_CLICK_INCOMING) && (isset($msg)))
        {
            $resp = "";
            //这里是L4NBIOTIPMUI与底层L2SDK之间的交换矩阵
            switch($msg)
            {
                //require data structure:
                //var map={
                //    action:"login",
                //    name:$("#Username_Input").val(),
                //    password:$("#Password_Input").val()
                //};
                //return data structure:
                //usrinfo={
                //  status:"true",
                //  text:"login successfully",
                //  key: "1234567",
                //  admin: "true"
                //};
                //具体功能待实现
                case "login":  //login message:
                    if (isset($_GET["name"])) $name = trim($_GET["name"]); else $name = "";
                    if (isset($_GET["password"])) $pwd = trim($_GET["password"]); else $pwd = "";
                    $input = array("user" => $name, "pwd" => $pwd);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4NBIOT_IPMUI_TO_L3F1_LOGIN, "MSG_ID_L4NBIOT_IPMUI_TO_L3F1_LOGIN", $input);
                    break;

                //function reqdata1_f1
                case "afn_reqdata1_f1":
                    $input = array("user" => "", "func" => "afn_reqdata1_f1", "pwd" => "");
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_AFN_REQDATA1_F1, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_AFN_REQDATA1_F1", $input);
                    break;

                //function reqdata1_f2
                case "afn_reqdata1_f2":
                    $input = array("user" => "", "func" => "afn_reqdata1_f2", "pwd" => "");
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_AFN_REQDATA1_F2, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_AFN_REQDATA1_F2", $input);
                    break;

                //function reqdata1_f25
                case "afn_reqdata1_f25":
                    $input = array("user" => "", "pwd" => "");
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_AFN_REQDATA1_F25, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_AFN_REQDATA1_F25", $input);
                    break;

                //function reqdata1_f26
                case "afn_reqdata1_f26":
                    $input = array("user" => "", "pwd" => "");
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_AFN_REQDATA1_F26, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_AFN_REQDATA1_F26", $input);
                    break;

                case "ipm_read_cur_cnt_data":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_CURRENT_COUNTER_DATA, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_CURRENT_COUNTER_DATA",$input);
                    break;

                case "ipm_read_his_cnt_data1":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA1, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA1",$input);
                    break;

                case "ipm_read_his_cnt_data2":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA2, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA2",$input);
                    break;

                case "ipm_read_his_cnt_data3":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA3, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA3",$input);
                    break;

                case "ipm_read_his_cnt_data4":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA4, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA4",$input);
                    break;

                case "ipm_read_his_cnt_data5":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA5, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA5",$input);
                    break;

                case "ipm_read_his_cnt_data6":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA6, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA6",$input);
                    break;

                case "ipm_read_his_cnt_data7":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA7, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA7",$input);
                    break;

                case "ipm_read_his_cnt_data8":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA8, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA8",$input);
                    break;

                case "ipm_read_his_cnt_data9":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA9, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA9",$input);
                    break;

                case "ipm_read_his_cnt_data10":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA10, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA10",$input);
                    break;

                case "ipm_read_his_cnt_data11":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA11, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA11",$input);
                    break;

                case "ipm_read_his_cnt_data12":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA12, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA12",$input);
                    break;

                case "ipm_read_price_table":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_PRICE_TABLE, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_PRICE_TABLE",$input);
                    break;

                case "ipm_read_bill_date":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_BILL_DATE, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_BILL_DATE",$input);
                    break;

                case "ipm_read_account_date":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_ACCOUNT_DATE, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_ACCOUNT_DATE",$input);
                    break;

                case "ipm_read_buy_amount":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_BUY_AMOUNT, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_BUY_AMOUNT",$input);
                    break;

                case "ipm_read_key_ver":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_KEY_VER, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_KEY_VER",$input);
                    break;

                case "ipm_read_address":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_ADDRESS, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_ADDRESS",$input);
                    break;

                case "ipm_write_price_table":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["price1"])) $price1 = trim($_GET["price1"]); else $price1 = "";
                    if (isset($_GET["volume1"])) $volume1 = trim($_GET["volume1"]); else $volume1 = "";
                    if (isset($_GET["price2"])) $price2 = trim($_GET["price2"]); else $price2 = "";
                    if (isset($_GET["volume2"])) $volume2 = trim($_GET["volume2"]); else $volume2 = "";
                    if (isset($_GET["price3"])) $price3 = trim($_GET["price3"]); else $price3 = "";
                    if (isset($_GET["startdate"])) $startdate = trim($_GET["startdate"]); else $startdate = "";
                    $input = array("type" => $type, "len" => $len, "price1" => $price1, "volume1" => $volume1, "price2" => $price2, "volume2" => $volume2, "price3" => $price3, "startdate" => $startdate);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_PRICE_TABLE, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_PRICE_TABLE",$input);
                    break;

                case "ipm_write_bill_date":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["billdate"])) $billdate = trim($_GET["billdate"]); else $billdate = "";
                    $input = array("type" => $type, "len" => $len, "billdate" => $billdate);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_BILL_DATE, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_BILL_DATE",$input);
                    break;

                case "ipm_write_account_date":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["accountdate"])) $accountdate = trim($_GET["accountdate"]); else $accountdate = "";
                    $input = array("type" => $type, "len" => $len, "accountdate" => $accountdate);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_ACCOUNT_DATE, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_ACCOUNT_DATE",$input);
                    break;

                case "ipm_write_buy_amount":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["buycode"])) $buycode = trim($_GET["buycode"]); else $buycode = "";
                    if (isset($_GET["buyamount"])) $buyamount = trim($_GET["buyamount"]); else $buyamount = "";
                    $input = array("type" => $type, "len" => $len, "buycode" => $buycode, "buyamount" => $buyamount);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_BUY_AMOUNT, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_BUY_AMOUNT",$input);
                    break;

                case "ipm_write_new_key":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["kerver"])) $kerver = trim($_GET["kerver"]); else $kerver = "";
                    if (isset($_GET["newkey"])) $newkey = trim($_GET["newkey"]); else $newkey = "";
                    $input = array("type" => $type, "len" => $len, "kerver" => $kerver, "newkey" => $newkey);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_NEW_KEY, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_NEW_KEY",$input);
                    break;

                case "ipm_write_std_time":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["realtime"])) $realtime = trim($_GET["realtime"]); else $realtime = "";
                    $input = array("type" => $type, "len" => $len, "realtime" => $realtime);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_STD_TIME, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_STD_TIME",$input);
                    break;

                case "ipm_write_switch_ctrl":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["switch"])) $switch = trim($_GET["switch"]); else $switch = "";
                    $input = array("type" => $type, "len" => $len, "switch" => $switch);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_SWITCH_CTRL, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_SWITCH_CTRL",$input);
                    break;

                case "ipm_write_off_fac_start":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    $input = array("type" => $type, "len" => $len);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_OFF_FACTORY_START, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_OFF_FACTORY_START",$input);
                    break;

                case "ipm_write_address":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["newaddr"])) $newaddr = trim($_GET["newaddr"]); else $newaddr = "";
                    $input = array("type" => $type, "len" => $len, "newaddr" => $newaddr);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_ADDRESS, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_ADDRESS",$input);
                    break;

                case "ipm_write_device_syn":
                    if (isset($_GET["len"])) $len = trim($_GET["len"]); else $len = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["curaccumvolume"])) $curaccumvolume = trim($_GET["curaccumvolume"]); else $curaccumvolume = "";
                    $input = array("type" => $type, "len" => $len, "curaccumvolume" => $curaccumvolume);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3NBIOT_OPR_METER, MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DEVICE_SYN_DATA, "MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DEVICE_SYN_DATA",$input);
                    break;

                default:
                    $resp = ""; //啥都不ECHO
                    break;
            }

        }
        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger("L4IPMUI", "MFUN_TASK_ID_L4NBIOT_IPM_UI", $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>