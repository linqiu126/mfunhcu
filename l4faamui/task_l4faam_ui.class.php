<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:47
 */
include_once "../l1comvm/vmlayer.php";

class classTaskL4faamUi
{

    private function get_file_detail($path){
        $ret = "";
        if(!file_exists($path)) {
            //echo $path." is not exist!";
            return "";
        }
        $afile=$path;
        $json_string = file_get_contents($afile);
        return $json_string;
    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l4faam_ui_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_AQYCUI;

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","H5UI_ENTRY_FAAM","MFUN_TASK_ID_L4FAAM_UI",$msgName,$log_content);
            echo trim($log_content);
            return false;
        }
        if (($msgId != MSG_ID_L4FAAMUI_CLICK_INCOMING) || ($msgName != "MSG_ID_L4FAAMUI_CLICK_INCOMING")){
            $log_content = "E: Msgid or MsgName error";
            $loggerObj->mylog($project,"NULL","H5UI_ENTRY_FAAM","MFUN_TASK_ID_L4FAAM_UI",$msgName,$log_content);
            echo trim($log_content);
            return false;
        }

        $resp = "";
        if (isset($msg)) $action = trim($msg); else $action = "";
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        //这里是L4AQYC与L3APPL功能之间的交换矩阵，从而让UI对应的多种不确定组合变换为L3APPL确定的功能组合
        switch($action)
        {
            case "FactoryCodeList":
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_FACTORYCODELIST, "MSG_ID_L4FAAMUI_TO_L3F11_FACTORYCODELIST",$input);
                break;

            case "FactoryTable":
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_FACTORYTABLE, "MSG_ID_L4FAAMUI_TO_L3F11_FACTORYTABLE",$input);
                break;

            case "FactoryMod":
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_FACTORYMOD, "MSG_ID_L4FAAMUI_TO_L3F11_FACTORYMOD",$input);
                break;

            case "FactoryNew":
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_FACTORYNEW, "MSG_ID_L4FAAMUI_TO_L3F11_FACTORYNEW",$input);
                break;

            case "FactoryDel":
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_FACTORYDEL, "MSG_ID_L4FAAMUI_TO_L3F11_FACTORYDEL",$input);
                break;

            case "SpecificationTable":
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTTYPE, "MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTTYPE",$input);
                break;

            case "SpecificationMod":
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTTYPEMOD, "MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTTYPEMOD",$input);
                break;

            case "SpecificationNew":
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTTYPENEW, "MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTTYPENEW",$input);
                break;

            case "SpecificationDel":
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTTYPEDEL, "MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTTYPEDEL",$input);
                break;

            case "StaffnameList": //查询员工名单
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_STAFFNAMELIST, "MSG_ID_L4FAAMUI_TO_L3F11_STAFFNAMELIST",$input);
                break;

            case "StaffTable":  //查询员工信息表
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_STAFFTABLE, "MSG_ID_L4FAAMUI_TO_L3F11_STAFFTABLE",$input);
                break;

            case "StaffNew":
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_STAFFNEW, "MSG_ID_L4FAAMUI_TO_L3F11_STAFFNEW",$input);
                break;

            case "StaffMod":
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_STAFFMOD, "MSG_ID_L4FAAMUI_TO_L3F11_STAFFMOD",$input);
                break;

            case "StaffDel":
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_STAFFDEL, "MSG_ID_L4FAAMUI_TO_L3F11_STAFFDEL",$input);
                break;

            case "AttendanceHistory": //查询考勤历史记录表
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEHISTORY, "MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEHISTORY",$input);
                break;

            case "AttendanceNew":  //手工添加一条考勤记录
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCERECORDNEW, "MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCERECORDNEW",$input);
                break;

            case "AttendanceBatchNew": //批量添加考勤记录
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCERECORDBATCH, "MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCERECORDBATCH",$input);
                break;

            case "AttendanceDel":  //删除一条考勤记录
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEDEL, "MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEDEL",$input);
                break;

            case "GetAttendance":  //查询一条考勤记录
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEGET, "MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEGET",$input);
                break;

            case "AttendanceMod": //修改一条考勤记录
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEMOD, "MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEMOD",$input);
                break;

            case "AttendanceAudit": //考勤统计
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEAUDIT, "MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEAUDIT",$input);
                break;

            case "AssembleHistory": //考勤历史记录
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTIONHISTORY, "MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEDEL",$input);
                break;

            case "AssembleAudit":  //生产统计
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTIONAUDIT, "MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTIONAUDIT",$input);
                break;

            case "KPIAudit": //绩效统计
                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_KPIAUDIT, "MSG_ID_L4FAAMUI_TO_L3F11_KPIAUDIT",$input);
                break;
            /*************************************自己更改起始处***********************************************/
            case "ConsumablesPurchaseNew";//耗材入库
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_BUYCONSUMABLES, "MSG_ID_L4FAAMUI_TO_L3F11_BUYCONSUMABLES",$input);
                break;
            case "ConsumablesTable":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_CONSUMABLESTABLES, "MSG_ID_L4FAAMUI_TO_L3F11_CONSUMABLESTABLES",$input);
                break;
            case "ConsumablesHistory":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_CONSUMABLESHISTORY, "MSG_ID_L4FAAMUI_TO_L3F11_CONSUMABLESHISTORY",$input);
                break;
            case "GetConsumablesPurchase":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_GETCONSUMABLESPURCHASE, "MSG_ID_L4FAAMUI_TO_L3F11_GETCONSUMABLESPURCHASE",$input);
                break;
            case "ConsumablesPurchaseMod":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_CONSUMABLESPURCHASEMOD, "MSG_ID_L4FAAMUI_TO_L3F11_CONSUMABLESPURCHASEMOD",$input);
                break;
            case "ConsumablesPurchaseDel":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_CONSUMABLESPUTCHASEDEL, "MSG_ID_L4FAAMUI_TO_L3F11_CONSUMABLESPUTCHASEDEL",$input);
                break;
            case "ProductStockNew":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKNEW, "MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKNEW",$input);
                break;
            case "GetProductWeightAndSize":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTWEIGHTANDSIZE, "MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTWEIGHTANDSIZE",$input);
                break;
            case "GetProductStockList":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTSTOCKLIST, "MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTSTOCKLIST",$input);
                break;
            case "GetProductEmptyStock":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTEMPTYSTOCK, "MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTEMPTYSTOCK",$input);
                break;
            case "ProductStockTable":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKTABLE, "MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKTABLE",$input);
                break;
            case "ProductStockDel":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKDEL, "MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKDEL",$input);
                break;
            case "GetProductStockDetail":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTSTOCKDETAIL, "MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTSTOCKDETAIL",$input);
                break;
            case "ProductStockTransfer":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKTRANSFER, "MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKTRANSFER",$input);
                break;
            case "ProductStockHistory":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKHISTORY, "MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKHISTORY",$input);
                break;
            case "MaterialStockNew":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKNEW, "MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKNEW",$input);
                break;
            case "GetMaterialStockList":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_GETMATERIALSTOCKLIST, "MSG_ID_L4FAAMUI_TO_L3F11_GETMATERIALSTOCKLIST",$input);
                break;
            case "GetMaterialEmptyStock":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_GETMATERIALEMPTYSTOCK, "MSG_ID_L4FAAMUI_TO_L3F11_GETMATERIALEMPTYSTOCK",$input);
                break;
            case "MaterialStockDel":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKDEL, "MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKDEL",$input);
                break;
            //显示原料仓库的信息及存储量
            case "MaterialStockTable":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKTABLE, "MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKTABLE",$input);
                break;
            case "GetMaterialStockDetail":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_GETMATERIALSTOCKDETAIL, "MSG_ID_L4FAAMUI_TO_L3F11_GETMATERIALSTOCKDETAIL",$input);
                break;
            case "MaterialStockIncomeNew":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKINCOMENEW, "MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKINCOMENEW",$input);
                break;
            case "MaterialStockRemovalNew":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKREMOVANEW, "MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKREMOVANEW",$input);
                break;
            case "MaterialStockHistory":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKHISTORY, "MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKHISTORY",$input);
                break;
            case "GetMaterialStockHistoryDetail":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_GETMATERIALSTOCKHISTORYDETAIL, "MSG_ID_L4FAAMUI_TO_L3F11_GETMATERIALSTOCKHISTORYDETAIL",$input);
                break;
            case "MaterialStockIncomeMod":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_METERIALSTOCKINCOMEMOD, "MSG_ID_L4FAAMUI_TO_L3F11_METERIALSTOCKINCOMEMOD",$input);
                break;
            case "MaterialStockRemovalMod":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_METERIALSTOCKREMOVAMOD, "MSG_ID_L4FAAMUI_TO_L3F11_METERIALSTOCKREMOVAMOD",$input);
                break;
            case "MaterialStockRemovalDel":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_METERIALSTOCKREMOVALDEL, "MSG_ID_L4FAAMUI_TO_L3F11_METERIALSTOCKREMOVALDEL",$input);
                break;
            case "GetProductStockHistoryDetail":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTSTOCKHISTORYDETAIL, "MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTSTOCKHISTORYDETAIL",$input);
                break;
            case "ProductStockRemovalMod":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKREMOVALMOD, "MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKREMOVALMOD",$input);
                break;
            case "ProductStockRemovalDel":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKREMOVALDEL, "MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKREMOVALDEL",$input);
                break;
            case "ProductStockRemovalNew":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKREMOVALNEW, "MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKREMOVALNEW",$input);
                break;
//            case "MaterialStockIncomeDel":
//                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
//                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKINCOMEDEL, "MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKINCOMEDEL",$input);
//                break;
            case "GetPrint":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_GETPRINT, "MSG_ID_L4FAAMUI_TO_L3F11_GETPRINT",$input);
                break;
            case "GetConsumablesVendorList":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_GETCONSUMABLESVENDORLIST, "MSG_ID_L4FAAMUI_TO_L3F11_GETCONSUMABLESVENDORLIST",$input);
                break;
            case "GetConsumablesTypeList":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_GETCONSUMABLESTYPELIST, "MSG_ID_L4FAAMUI_TO_L3F11_GETCONSUMABLESTYPELIST",$input);
                break;
            case "TableQuery":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_TABLEQUERY, "MSG_ID_L4FAAMUI_TO_L3F11_TABLEQUERY",$input);
                break;

            //水产管理
            case "SeafoodInfo":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_SEAFOODINFO, "MSG_ID_L4FAAMUI_TO_L3F11_SEAFOODINFO",$input);
                break;
            case "SeafoodAudit":
                $input=array("project"=>$project,"action"=>$action,"type"=>$type,"user"=>$user,"body"=>$body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM11FAAM, MSG_ID_L4FAAMUI_TO_L3F11_SEAFOODAUDIT, "MSG_ID_L4FAAMUI_TO_L3F11_SEAFOODAUDIT",$input);
                break;
            /*************************************自己更改终止处***********************************************/
            case "GetGeoList":  //获取山东的地理区域信息
                $retarray = $this->get_file_detail("./json/geography.json");
                $obj = json_decode($retarray,true);
                $resp = array('status'=>'true','ret'=>$obj['shandong'],'auth'=>'true','msg'=>'');
                break;


            default:
                $msg = array("project" => $project, "action" => $action);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L4COM_UI, MSG_ID_L4COMUI_CLICK_INCOMING, "MSG_ID_L4COMUI_CLICK_INCOMING",$msg);
                break;
        }

        if (!empty($resp)) {
            $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
            $log_content = "T:" . $jsonencode;
            $loggerObj->mylog($project,$user,"H5UI_ENTRY_FAAM","MFUN_TASK_ID_L4FAAM_UI",$msgName,$log_content);
            echo trim($jsonencode);
        }

        //返回
        return true;
    }

}//End of class_task_service

//暂时不用删除的消息
/*
    case "ProjDel":  //删除一个项目
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PROJDEL, "MSG_ID_L4AQYCUI_TO_L3F2_PROJDEL",$input);
                break;

    case "PointDel":  //删除一个监测点
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_POINTDEL, "MSG_ID_L4AQYCUI_TO_L3F2_POINTDEL",$input);
        break;

    case "DevDel":  //删除HCU设备
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_DEVDEL, "MSG_ID_L4AQYCUI_TO_L3F2_DEVDEL",$input);
        break;
    case "SensorList":  //获取传感器列表
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_SENSORLIST, "MSG_ID_L4AQYCUI_TO_L3F3_SENSORLIST",$input);
        break;

    case "DevSensor": //查询设备下传感器列表
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_DEVSENSOR, "MSG_ID_L4AQYCUI_TO_L3F3_DEVSENSOR",$input);
        break;

    case "GetStaticMonitorTable":  //查询测量点聚合信息
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_GETSTATICMONITORTABLE, "MSG_ID_L4AQYCUI_TO_L3F3_GETSTATICMONITORTABLE",$input);
        break;

    case "MonitorAlarmList":      // get alarm monitorList in map by user id
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMMONITORLIST, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMMONITORLIST",$input);
        break;

    case "DevAlarm":  //获取当前的测量值，如果测量值超出范围，提示告警
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_DEVALARM, "MSG_ID_L4AQYCUI_TO_L3F5_DEVALARM",$input);
        break;

    case "AlarmType":  //获取所有传感器类型
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMTYPE, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMTYPE",$input);
        break;

    case "AlarmQuery": //查询一个监测点历史告警数据 minute/hour/day
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMQUERY, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMQUERY",$input);
        break;

    case "GetWarningHandleListTable":  //告警处理表
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMHANDLETABLE, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMHANDLETABLE",$input);
        break;

    case "GetWarningImg":  //查询告警抓拍照片
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMIMGGET, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMIMGGET",$input);
        break;

    case "AlarmHandle":  //告警处理
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMHANDLE, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMHANDLE",$input);
        break;

    case "AlarmClose":  //告警关闭
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMCLOSE, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMCLOSE",$input);
        break;

    case "GetVersionList":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_ALLSW, "MSG_ID_L4AQYCUI_TO_L3F4_ALLSW",$input);
        break;

    case "GetProjDevVersion":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_DEVSW, "MSG_ID_L4AQYCUI_TO_L3F4_DEVSW",$input);
        break;

    case "UpdateDevVersion":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_SWUPDATE, "MSG_ID_L4AQYCUI_TO_L3F4_SWUPDATE",$input);
        break;

    //获取软件3条版本基线的最新说明
    case "VersionInformation":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_SWVERINFO, "MSG_ID_L4AQYCUI_TO_L3F4_SWVERINFO",$input);
        break;

    //获取指定项目下所有设备的软件更新策略，包括软件版本，版本基线，是否允许自动更新
    case "ProjUpdateStrategyList":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_PROJSUSTRATEGY, "MSG_ID_L4AQYCUI_TO_L3F4_PROJSUSTRATEGY",$input);
        break;

    //修改项目软件版本基线
    case "ProjVersionStrategyChange":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_PROJSWBASECHANGE, "MSG_ID_L4AQYCUI_TO_L3F4_SWBASECHANGE",$input);
        break;

    //修改某站点软件更新策略
    case "PointUpdateStrategyChange":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_DEVSUSTRATEGYCHANGE, "MSG_ID_L4AQYCUI_TO_L3F4_DEVSUSTRATEGYCHANGE",$input);
        break;

    //修改某项目软件更新策略
    case "ProjUpdateStrategyChange":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_PROJSUSTRATEGYCHANGE, "MSG_ID_L4AQYCUI_TO_L3F4_PROJSUSTRATEGYCHANGE",$input);
        break;

    //获取某项目软件更新策略
    case "GetProjUpdateStrategy":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FAAM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_PROJSUSTRATEGYGET, "MSG_ID_L4AQYCUI_TO_L3F4_PROJSUSTRATEGYGET",$input);
        break;
*/

?>
