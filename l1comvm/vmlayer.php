<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2015/7/5
 * Time: 9:26
 */
//包含所有本目录下的基础定义
include_once "../l1comvm/func_comapi.class.php";
include_once "../l1comvm/commsg.php";
include_once "../l1comvm/errCode.php";
include_once "../l1comvm/sysconfig.php";
include_once "../l1comvm/sysdim.php";
include_once "../l1comvm/pg_emcwx_engpar.php";
include_once "../l1comvm/pg_aqyc_engpar.php";
include_once "../l1comvm/pg_tbswr_engpar.php";
include_once "../l1comvm/pg_fhys_engpar.php";
include_once "../l1comvm/sysversion.php";
include_once "../l1comvm/sysmodule.php";
include_once "../l1comvm/dbi_common.class.php";
include_once "../l1comvm/func_comapi.class.php";
//层2编解码任务模块
include_once "../l2codec/l2codec_huitp_msg_dict.php"; //HUITP消息字典
include_once "../l2codec/l2codec_huitp_ie_dict.php";  //HUITP消息IE字典
include_once "../l2codec/task_l2decode_huitp_xml.php";
include_once "../l2codec/task_l2encode_huitp_xml.php";
include_once "../l2codec/task_l2codec_private_gtjy.php";
include_once "../l2codec/task_l2codec_wsdl_ycjk.php";
//包含所有的任务模块，不然无法调用
include_once "../l2sdk/task_l2sdk_iot_huitp.class.php";
include_once "../l2sdk/task_l2sdk_iot_stdxml.class.php";
include_once "../l2sdk/task_l2sdk_wechat.class.php";
include_once "../l2sdk/task_l2sdk_iot_apple.class.php";
include_once "../l2sdk/task_l2sdk_iot_jd.class.php";
include_once "../l2sdk/task_l2sdk_iot_wx.class.php";
include_once "../l2sdk/task_l2sdk_iot_wx_jssdk.php";
include_once "../l2sdk/task_l2sdk_nbiot_std_qg376.class.php";
include_once "../l2sdk/task_l2sdk_nbiot_std_cj188.class.php";
include_once "../l2sdk/task_l2sdk_iot_json.class.php";
include_once "../l2socketlisten/task_l2socket_listen.class.php";
include_once "../l2sensorproc/proccom/task_l2snr_com.class.php";
include_once "../l2sensorproc/sensorccl/task_l2snr_ccl.class.php";
include_once "../l2sensorproc/sensorairprs/task_l2snr_airprs.class.php";
include_once "../l2sensorproc/sensoremc/task_l2snr_emc.class.php";
include_once "../l2sensorproc/sensoralcohol/task_l2snr_alcohol.class.php";
include_once "../l2sensorproc/sensorco1/task_l2snr_co1.class.php";
include_once "../l2sensorproc/sensorhcho/task_l2snr_hcho.class.php";
include_once "../l2sensorproc/sensorhsmmp/task_l2snr_hsmmp.class.php";
include_once "../l2sensorproc/sensorhumid/task_l2snr_humid.class.php";
include_once "../l2sensorproc/sensorlightstr/task_l2snr_lightstr.class.php";
include_once "../l2sensorproc/sensornoise/task_l2snr_noise.class.php";
include_once "../l2sensorproc/sensorpm25/task_l2snr_pm25.class.php";
include_once "../l2sensorproc/sensorrain/task_l2snr_rain.class.php";
include_once "../l2sensorproc/sensortemp/task_l2snr_temp.class.php";
include_once "../l2sensorproc/sensortoxicgas/task_l2snr_toxicgas.class.php";
include_once "../l2sensorproc/sensorwinddir/task_l2snr_winddir.class.php";
include_once "../l2sensorproc/sensorwindspd/task_l2snr_windspd.class.php";
include_once "../l2sensorproc/sensoripm/task_l2snr_ipm.class.php";
include_once "../l2sensorproc/sensoriwm/task_l2snr_iwm.class.php";
include_once "../l2sensorproc/sensorigm/task_l2snr_igm.class.php";
include_once "../l2sensorproc/sensorihm/task_l2snr_ihm.class.php";
include_once "../l2sensorproc/sensorble/task_l2snr_ble.class.php";
include_once "../l2sensorproc/sensorbatt/task_l2snr_batt.class.php";
include_once "../l2sensorproc/sensordoorlock/task_l2snr_doorlock.class.php";
include_once "../l2sensorproc/sensorgprs/task_l2snr_gprs.class.php";
include_once "../l2sensorproc/sensorrfid/task_l2snr_rfid.class.php";
include_once "../l2sensorproc/sensorsmok/task_l2snr_smok.class.php";
include_once "../l2sensorproc/sensorvibr/task_l2snr_vibr.class.php";
include_once "../l2sensorproc/sensorwater/task_l2snr_water.class.php";
include_once "../l2sensorproc/sensorweight/task_l2snr_weight.class.php";
include_once "../l2sensorproc/sensorfdwq/task_l2snr_fdwq.class.php";
include_once "../l2sensorproc/sensorearthdin/task_l2snr_earthdin.class.php";
include_once "../l3appl/fum1sym/task_l3apl_f1sym.class.php";
include_once "../l3appl/fum2cm/task_l3apl_f2cm.class.php";
include_once "../l3appl/fum3dm/task_l3apl_f3dm.class.php";
include_once "../l3appl/fum4icm/task_l3apl_f4icm.class.php";
include_once "../l3appl/fum5fm/task_l3apl_f5fm.class.php";
include_once "../l3appl/fum6pm/task_l3apl_f6pm.class.php";
include_once "../l3appl/fum7ads/task_l3apl_f7ads.class.php";
include_once "../l3appl/fum8psm/task_l3apl_f8psm.class.php";
include_once "../l3appl/fum9gism/task_l3apl_f9gism.class.php";
include_once "../l3appl/fumxprcm/task_l3apl_fxprcm.class.php";
include_once "../l3appl/fum11faam/task_l3apl_f11faam.class.php";
include_once "../l3wxopr/task_l3wx_opr_emc.class.php";
include_once "../l3wxopr/task_l3wx_opr_fhys.class.php";
include_once "../l3wxopr/task_l3wx_opr_faam.php";
include_once "../l3nbiotopr/task_l3nbiot_opr_meter.class.php";
include_once "../l2timercron/task_l2timer_cron.class.php";
include_once "../l4comui/task_l4com_ui.class.php";
include_once "../l5bi/task_bi_service.class.php";

//分项目include文件
if(MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_AQYC){
    include_once "../l4aqycui/task_l4aqyc_ui.class.php";
    include_once "../l4faamui/task_l4faam_ui.class.php"; //公用AQ云HTTPS
}
elseif(MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_FAAM){

    include_once "../l4faamui/task_l4faam_ui.class.php";
}
elseif(MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_FHYS){
    include_once "../l4fhysui/task_l4fhys_ui.class.php";
    include_once "../l4fhyswechat/task_l4fhys_wechat.class.php";
}
elseif(MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_BFZN){
    include_once "../l4bfscui/task_l4bfsc_ui.class.php";
}
elseif(MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_EMCWX){
    include_once "../l4emcwxui/task_l4emcwx_ui.class.php";
}
elseif(MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_GTJY){
    include_once "../l4gtjyui/task_l4gtjy_ui.class.php";
}
elseif(MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_FDWQ){
    include_once "../l4fdwqui/task_l4fdwq_ui.class.php";
}
elseif(MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_TBSWR){
    include_once "../l4tbswrui/task_l4tbswr_ui.class.php";
}
elseif(MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_NBIOT_IPM){
    include_once "../l4nbiotipmui/task_l4nbiot_ipm_ui.class.php";
}
elseif(MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_NBIOT_IWM){
    include_once "../l4nbiotiwmui/task_l4nbiot_iwm_ui.class.php";
}
elseif(MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_NBIOT_IGM){
    include_once "../l4nbiotigmui/task_l4nbiot_igm_ui.class.php";
}
elseif(MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_NBIOT_IHM){
    include_once "../l4nbiotihmui/task_l4nbiot_ihm_ui.class.php";
}
elseif(MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_TESTMODE){
    include_once "../l4aqycui/task_l4aqyc_ui.class.php";
    include_once "../l4faamui/task_l4faam_ui.class.php";
    include_once "../l4fhysui/task_l4fhys_ui.class.php";
    include_once "../l4fhyswechat/task_l4fhys_wechat.class.php";
    include_once "../l4bfscui/task_l4bfsc_ui.class.php";
    include_once "../l4emcwxui/task_l4emcwx_ui.class.php";
    include_once "../l4gtjyui/task_l4gtjy_ui.class.php";
    include_once "../l4fdwqui/task_l4fdwq_ui.class.php";
    include_once "../l4tbswrui/task_l4tbswr_ui.class.php";
    include_once "../l4nbiotipmui/task_l4nbiot_ipm_ui.class.php";
    include_once "../l4nbiotiwmui/task_l4nbiot_iwm_ui.class.php";
    include_once "../l4nbiotigmui/task_l4nbiot_igm_ui.class.php";
    include_once "../l4nbiotihmui/task_l4nbiot_ihm_ui.class.php";
}


class classTaskL1vmCoreRouter
{
    public $msgBufferList = array();
    public $msgBufferReadCnt;
    public $msgBufferWriteCnt;
    public $msgBufferUsedCnt;

    //构造函数
    public function __construct()
    {
        for ($i=0; $i<MFUN_MSG_BUFFER_NBR_MAX; $i++){
            $this->msgBufferList[$i] = array("valid" => false, "srcId" => 0, "destId" => 0, "msgId" => 0, "msgName" => "", "msgBody" => "");
        }
        $this->msgBufferReadCnt = 0;
        $this->msgBufferWriteCnt = 0;
        $this->msgBufferUsedCnt = 0;
    }

    //核心API：发送消息的函数
    public function mfun_l1vm_msg_send($srcId, $destId, $msgId, $msgName, $msgBody)
    {
        //判断是否越界
        if ($this->msgBufferUsedCnt >= MFUN_MSG_BUFFER_NBR_MAX){
            $this->msgBufferUsedCnt = MFUN_MSG_BUFFER_NBR_MAX;
            return false;
        }
        if ($this->msgBufferUsedCnt < 0){
            $this->msgBufferUsedCnt = 0;
            return false;
        }
        if (($this->msgBufferWriteCnt < 0) || ($this->msgBufferWriteCnt >= MFUN_MSG_BUFFER_NBR_MAX)){
            $this->msgBufferWriteCnt = 0;
            return false;
        }

        //直接在msgBufferWriteCnt指示的地方写入
        if ($this->msgBufferList[$this->msgBufferWriteCnt]["valid"] != false){
            $this->msgBufferList[$this->msgBufferWriteCnt]["valid"] = false;
            return false;
        }
        $this->msgBufferList[$this->msgBufferWriteCnt] = array(
                        "valid" => "true",
                        "srcId" => $srcId,
                        "destId" => $destId,
                        "msgId" => $msgId,
                        "msgName" => $msgName,
                        "msgBody" => $msgBody);

        //写完之后，更新计数器
        $this->msgBufferUsedCnt++;
        $this->msgBufferWriteCnt = ($this->msgBufferWriteCnt+1) % MFUN_MSG_BUFFER_NBR_MAX;

        if(sizeof($msgBody, 1) > MFUN_MSG_BODY_LENGTH){
            $loggerObj = new classApiL1vmFuncCom();
            $log_content = "I: MsgBody over max length";
            $loggerObj->mylog("NULL","NULL","MFUN_TASK_ID_L1VM","NULL",$msgName,$log_content);
            return true;
        }

        //完事的MESSAGE TRACE机制, 先生成$loggerObj对应的指针
        //公共变量没有放在外面统一声明的原因，是为了优化TRACE_MSG_MODE_ALL_OFF的最小开销
        if (TRACE_MSG_ON == TRACE_MSG_MODE_ALL_OFF){
            //No trace
        }
        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_ALL_ON){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
        }

        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_MOUDLE_TO_ALLOW){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $result = $loggerObj->trace_module_inqury($destId);
            if (isset($result) == true){
                if ($result["allowflag"] == TRACE_MSG_GENERAL_ON)
                    $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
            }
        }
        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_MOUDLE_TO_RESTRICT){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $result = $loggerObj->trace_module_inqury($destId);
            if (isset($result) == true){
                if ($result["restrictflag"] != TRACE_MSG_GENERAL_ON)
                    $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
            }
        }
        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_MOUDLE_FROM_ALLOW){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $result = $loggerObj->trace_module_inqury($srcId);
            if (isset($result) == true){
                if ($result["allowflag"] == TRACE_MSG_GENERAL_ON)
                    $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
            }
        }
        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_MOUDLE_FROM_RESTRICT){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $result = $loggerObj->trace_module_inqury($srcId);
            if (isset($result) == true){
                if ($result["restrictflag"] != TRACE_MSG_GENERAL_ON)
                    $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
            }
        }
        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_MOUDLE_DOUBLE_ALLOW){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $result1 = $loggerObj->trace_module_inqury($srcId);
            $result2 = $loggerObj->trace_module_inqury($destId);
            if (isset($result) == true){
                if (($result1["allowflag"] == TRACE_MSG_GENERAL_ON) && ($result2["allowflag"] == TRACE_MSG_GENERAL_ON))
                    $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
            }
        }
        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_MOUDLE_DOUBLE_RESTRICT){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $result1 = $loggerObj->trace_module_inqury($srcId);
            $result2 = $loggerObj->trace_module_inqury($destId);
            if (isset($result) == true){
                if (($result1["restrictflag"] != TRACE_MSG_GENERAL_ON) && ($result2["restrictflag"] != TRACE_MSG_GENERAL_ON))
                    $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
            }
        }
        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_MSGID_ALLOW){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $result = $loggerObj->trace_msg_inqury($msgId);
            if (isset($result) == true){
                if ($result["allowflag"] == TRACE_MSG_GENERAL_ON)
                    $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
            }
        }
        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_MSGID_RESTRICT){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $result = $loggerObj->trace_msg_inqury($msgId);
            if (isset($result) == true){
                if ($result["restrictflag"] != TRACE_MSG_GENERAL_ON)
                    $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
            }
        }
        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_COMBINE_TO_ALLOW){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $result1 = $loggerObj->trace_module_inqury($destId);
            $result2 = $loggerObj->trace_msg_inqury($msgId);
            if (isset($result) == true){
                if (($result1["allowflag"] == TRACE_MSG_GENERAL_ON) && ($result2["allowflag"] == TRACE_MSG_GENERAL_ON))
                    $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
            }
        }
        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_COMBINE_TO_RESTRICT){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $result1 = $loggerObj->trace_module_inqury($destId);
            $result2 = $loggerObj->trace_msg_inqury($msgId);
            if (isset($result) == true){
                if (($result1["restrictflag"] != TRACE_MSG_GENERAL_ON) && ($result2["restrictflag"] != TRACE_MSG_GENERAL_ON))
                    $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
            }
        }
        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_COMBINE_FROM_ALLOW){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $result1 = $loggerObj->trace_module_inqury($srcId);
            $result2 = $loggerObj->trace_msg_inqury($msgId);
            if (isset($result) == true){
                if (($result1["allowflag"] == TRACE_MSG_GENERAL_ON) && ($result2["allowflag"] == TRACE_MSG_GENERAL_ON))
                    $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
            }
        }
        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_COMBINE_FROM_RESTRICT){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $result1 = $loggerObj->trace_module_inqury($srcId);
            $result2 = $loggerObj->trace_msg_inqury($msgId);
            if (isset($result) == true){
                if (($result1["restrictflag"] != TRACE_MSG_GENERAL_ON) && ($result2["restrictflag"] != TRACE_MSG_GENERAL_ON))
                    $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
            }
        }
        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_COMBINE_DOUBLE_ALLOW){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $result1 = $loggerObj->trace_module_inqury($srcId);
            $result2 = $loggerObj->trace_module_inqury($destId);
            $result3 = $loggerObj->trace_msg_inqury($msgId);
            if (isset($result) == true){
                if (($result1["allowflag"] == TRACE_MSG_GENERAL_ON) && ($result2["allowflag"] == TRACE_MSG_GENERAL_ON) && ($result3["allowflag"] == TRACE_MSG_GENERAL_ON))
                    $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
            }
        }
        elseif (TRACE_MSG_ON == TRACE_MSG_MODE_COMBINE_DOUBLE_RESTRICT){
            $loggerObj = new classApiL1vmFuncCom();
            $taskObj = new classConstL1vmSysTaskList;
            $srcIdName = $taskObj->mfun_vm_getTaskName($srcId);
            $destIdName = $taskObj->mfun_vm_getTaskName($destId);
            $logmsg = "I: " . json_encode($msgBody,JSON_UNESCAPED_UNICODE);
            $result1 = $loggerObj->trace_module_inqury($srcId);
            $result2 = $loggerObj->trace_module_inqury($destId);
            $result3 = $loggerObj->trace_msg_inqury($msgId);
            if (isset($result) == true){
                if (($result1["restrictflag"] != TRACE_MSG_GENERAL_ON) && ($result2["restrictflag"] != TRACE_MSG_GENERAL_ON) && ($result3["restrictflag"] != TRACE_MSG_GENERAL_ON))
                    $loggerObj->mylog(MFUN_TRACE_VM,"NULL",$srcIdName,$destIdName,$msgName,$logmsg);
            }
        }
        else{
            //Do nothing
        }

        //返回
        return true;
    }

    //接收消息，$result可以是false，也可以是真正的结果
    public function mfun_l1vm_msg_rcv()
    {
        //判断是否越界
        if ($this->msgBufferUsedCnt > MFUN_MSG_BUFFER_NBR_MAX){
            $this->msgBufferUsedCnt = MFUN_MSG_BUFFER_NBR_MAX;
            return false;
        }
        if ($this->msgBufferUsedCnt <= 0){
            $this->msgBufferUsedCnt = 0;
            return false;
        }
        //MFUN_MSG_BUFFER_NBR_MAX是最大消息缓冲区+1，所以不可能达到
        if (($this->msgBufferReadCnt < 0) || ($this->msgBufferReadCnt >= MFUN_MSG_BUFFER_NBR_MAX)){
            $this->msgBufferReadCnt = 0;
            return false;
        }

        //读取数据
        if ($this->msgBufferList[$this->msgBufferReadCnt]["valid"] != true){
            $this->msgBufferList[$this->msgBufferWriteCnt]["valid"] = false;
            return false;
        }
        $tmp = $this->msgBufferList[$this->msgBufferReadCnt];
        //是否可以采用这种方式输出参数和结果？
        $srcId =0; $destId=0; $msgId=0; $msgName = ""; $msgBody = "";
        if (isset($tmp["srcId"])) $srcId = $tmp["srcId"];
        if (isset($tmp["destId"])) $destId = $tmp["destId"];
        if (isset($tmp["msgId"])) $msgId = $tmp["msgId"];
        if (isset($tmp["msgName"])) $msgName = $tmp["msgName"];
        if (isset($tmp["msgBody"])) $msgBody = $tmp["msgBody"];
        $result = array(
            "srcId" => $srcId,
            "destId" => $destId,
            "msgId" => $msgId,
            "msgName" => $msgName,
            "msgBody" => $msgBody);

        //写完之后，更新计数器
        $this->msgBufferUsedCnt--;
        $this->msgBufferReadCnt = ($this->msgBufferReadCnt+1) % MFUN_MSG_BUFFER_NBR_MAX;
        return $result;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l1vm_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //先生成$loggerObj对应的指针
        $loggerObj = new classApiL1vmFuncCom();

        //先处理接收到的消息的基本情况
        if (empty($msg) == true){
            $log_content = "P: Nothing received";
            $loggerObj->mylog("NULL","NULL","NULL","MFUN_TASK_ID_L1VM",$msgName,$log_content);
            echo $log_content;
            //return false;
        }

        //然后发送从L1_MAIN_ENTRY接收到的消息到缓冲区中
        switch($parObj)
        {
                    case MFUN_MAIN_ENTRY_WECHAT:  //微信公众号
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SDK_WECHAT,
                    MSG_ID_L1VM_TO_L2SDK_WECHAT_INCOMING,
                    "MSG_ID_L1VM_TO_L2SDK_WECHAT_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_WECHAT,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SDK_WECHAT","MSG_ID_L1VM_TO_L2SDK_WECHAT_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_WECHAT_XCX: //微信小程序
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L3WX_OPR_FAAM,
                    MSG_ID_L1VM_TO_L3WXOPR_FAAM_INCOMING,
                    "MSG_ID_L1VM_TO_L3WXOPR_FAAM_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_WECHAT_XCX,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L3WX_OPR_FAAM","MSG_ID_L1VM_TO_L3WX_XCX_FAAM",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_IOT_STDXML:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SDK_IOT_STDXML,
                    MSG_ID_L1VM_TO_L2SDK_IOT_STDXML_INCOMING,
                    "MSG_ID_L1VM_TO_L2SDK_IOT_STDXML_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_IOT_STDXML,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SDK_IOT_STDXML","MSG_ID_L1VM_TO_L2SDK_IOT_STDXML_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_IOT_HUITP:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SDK_IOT_HUITP,
                    MSG_ID_L1VM_TO_L2SDK_IOT_HUITP_INCOMING,
                    "MSG_ID_L1VM_TO_L2SDK_IOT_HUITP_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_IOT_HUITP,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SDK_IOT_HUITP","MSG_ID_L1VM_TO_L2SDK_IOT_HUITP_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_IOT_JSON:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SDK_IOT_JSON,
                    MSG_ID_L1VM_TO_L2SDK_IOT_JSON_INCOMING,
                    "MSG_ID_L1VM_TO_L2SDK_IOT_JSON_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_IOT_JSON,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SDK_IOT_JSON","MSG_ID_L1VM_TO_L2SDK_IOT_JSON_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_JINGDONG:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SDK_IOT_JD,
                    MSG_ID_L2SDK_JD_INCOMING,
                    "MSG_ID_L2SDK_JD_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_JINGDONG,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SDK_IOT_JD","MSG_ID_L2SDK_JD_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_APPLE:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SDK_IOT_APPLE,
                    MSG_ID_L2SDK_APPLE_INCOMING,
                    "MSG_ID_L2SDK_APPLE_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_APPLE,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SDK_IOT_APPLE","MSG_ID_L2SDK_APPLE_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                    break;
            case MFUN_MAIN_ENTRY_CRON:
                if ($msg == MSG_ID_L2TIMER_CRON_1MIN_COMING)
                    $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM, MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_1MIN_COMING, "MSG_ID_L2TIMER_CRON_60SEC_COMING", MSG_ID_L2TIMER_CRON_1MIN_COMING);
                elseif ($msg == MSG_ID_L2TIMER_CRON_3MIN_COMING)
                    $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM, MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_3MIN_COMING, "MSG_ID_L2TIMER_CRON_180SEC_COMING", MSG_ID_L2TIMER_CRON_3MIN_COMING);
                elseif ($msg == MSG_ID_L2TIMER_CRON_10MIN_COMING)
                    $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM, MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_10MIN_COMING, "MSG_ID_L2TIMER_CRON_10MIN_COMING", MSG_ID_L2TIMER_CRON_10MIN_COMING);
                elseif ($msg == MSG_ID_L2TIMER_CRON_30MIN_COMING)
                    $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM, MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_30MIN_COMING, "MSG_ID_L2TIMER_CRON_30MIN_COMING", MSG_ID_L2TIMER_CRON_30MIN_COMING);
                elseif ($msg == MSG_ID_L2TIMER_CRON_1HOUR_COMING)
                    $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM, MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_1HOUR_COMING, "MSG_ID_L2TIMER_CRON_1HOUR_COMING", MSG_ID_L2TIMER_CRON_1HOUR_COMING);
                elseif ($msg == MSG_ID_L2TIMER_CRON_6HOUR_COMING)
                    $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM, MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_6HOUR_COMING, "MSG_ID_L2TIMER_CRON_6HOUR_COMING", MSG_ID_L2TIMER_CRON_6HOUR_COMING);
                elseif ($msg == MSG_ID_L2TIMER_CRON_24HOUR_COMING)
                    $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM, MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_24HOUR_COMING, "MSG_ID_L2TIMER_CRON_24HOUR_COMING", MSG_ID_L2TIMER_CRON_24HOUR_COMING);
                elseif ($msg == MSG_ID_L2TIMER_CRON_2DAY_COMING)
                    $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM, MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_2DAY_COMING, "MSG_ID_L2TIMER_CRON_2DAY_COMING", MSG_ID_L2TIMER_CRON_2DAY_COMING);
                elseif ($msg == MSG_ID_L2TIMER_CRON_7DAY_COMING)
                    $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM, MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_7DAY_COMING, "MSG_ID_L2TIMER_CRON_7DAY_COMING", MSG_ID_L2TIMER_CRON_7DAY_COMING);
                elseif ($msg == MSG_ID_L2TIMER_CRON_30DAY_COMING)
                    $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM, MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_30DAY_COMING, "MSG_ID_L2TIMER_CRON_30DAY_COMING", MSG_ID_L2TIMER_CRON_30DAY_COMING);

                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_CRON,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2TIMER_CRON","MSG_ID_L2TIMER_CRON_XXX_COMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_SOCKET://暂时只处理从swoole socket收到的HEX DATA（照片码流）
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SOCKET_LISTEN,
                    MSG_ID_L2SOCKET_LISTEN_DATA_COMING,
                    "MSG_ID_L2SOCKET_LISTEN_DATA_COMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_SOCKET,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SOCKET_LISTEN","MSG_ID_L2SOCKET_LISTEN_DATA_COMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_NBIOT_STD_QG376:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376,
                    MSG_ID_L2SDK_NBIOT_STD_QG376_INCOMING,
                    "MSG_ID_L2SDK_NBIOT_STD_QG376_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_NBIOT_STD_QG376,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376","MSG_ID_L2SDK_NBIOT_STD_QG376_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_NBIOT_STD_CJ188:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188,
                    MSG_ID_L2SDK_NBIOT_STD_CJ188_INCOMING,
                    "MSG_ID_L2SDK_NBIOT_STD_CJ188_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_NBIOT_STD_CJ188,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188","MSG_ID_L2SDK_NBIOT_STD_CJ188_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_NBIOT_LTEV:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SDK_NBIOT_LTEV,
                    MSG_ID_L2SDK_NBIOT_LTEV_INCOMING,
                    "MSG_ID_L2SDK_NBIOT_LTEV_INCOMING",
                    $msg) ;
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_NBIOT_LTEV,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SDK_NBIOT_LTEV","MSG_ID_L2SDK_NBIOT_LTEV_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_NBIOT_AGC:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SDK_NBIOT_AGC,
                    MSG_ID_L2SDK_NBIOT_AGC_INCOMING,
                    "MSG_ID_L2SDK_NBIOT_AGC_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_NBIOT_AGC,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SDK_NBIOT_AGC","MSG_ID_L2SDK_NBIOT_AGC_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_EMCWX_UI:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L4EMCWX_UI,
                    MSG_ID_L4EMCWXUI_CLICK_INCOMING,
                    "MSG_ID_L4EMCWXUI_CLICK_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_EMCWX_UI,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L4EMCWX_UI","MSG_ID_L4EMCWXUI_CLICK_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_AQYC_UI:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L4AQYC_UI,
                    MSG_ID_L4AQYCUI_CLICK_INCOMING,
                    "MSG_ID_L4AQYCUI_CLICK_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_AQYC_UI,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L4AQYC_UI","MSG_ID_L4AQYCUI_CLICK_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_FHYS_UI:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L4FHYS_UI,
                    MSG_ID_L4FHYSUI_CLICK_INCOMING,
                    "MSG_ID_L4FHYSUI_CLICK_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_FHYS_UI,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L4FHYS_UI","MSG_ID_L4FHYSUI_CLICK_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_FHYS_WECHAT:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L4FHYS_WECHAT,
                    MSG_ID_L4FHYS_WECHAT_CLICK_INCOMING,
                    "MSG_ID_L4FHYS_WECHAT_CLICK_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_FHYS_WECHAT,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L4FHYS_WECHAT","MSG_ID_L4FHYS_WECHAT_CLICK_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_BFSC_UI:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                MFUN_TASK_ID_L4BFSC_UI,
                MSG_ID_L4BFSCUI_CLICK_INCOMING,
                "MSG_ID_L4BFSCUI_CLICK_INCOMING",
                $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_BFSC_UI,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L4BFSC_UI","MSG_ID_L4BFSCUI_CLICK_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_TBSWR_UI:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L4TBSWR_UI,
                    MSG_ID_L4TBSWR_CLICK_INCOMING,
                    "MSG_ID_L4TBSWR_CLICK_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_TBSWR_UI,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L4TBSWR_UI","MSG_ID_L4TBSWR_CLICK_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_FDWQ_UI:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L4FDWQ_UI,
                    MSG_ID_L4FDWQUI_CLICK_INCOMING,
                    "MSG_ID_L4FDWQUI_CLICK_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_FDWQ_UI,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L4FDWQ_UI","MSG_ID_L4FDWQUI_CLICK_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_GTJY_UI:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L4GTJY_UI,
                    MSG_ID_L4GTJYUI_CLICK_INCOMING,
                    "MSG_ID_L4GTJYUI_CLICK_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_GTJY_UI,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L4GTJY_UI","MSG_ID_L4GTJYUI_CLICK_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_GTJY_NBIOT:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2CODEC_PRIVATE_GTJY,
                    MSG_ID_L2CODEC_PRIVATE_GTJY_DATA_INCOMING,
                    "MSG_ID_L2CODEC_PRIVATE_GTJY_DATA_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_GTJY_NBIOT,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2CODEC_PRIVATE_GTJY","MSG_ID_L2CODEC_PRIVATE_GTJY_DATA_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_FAAM_UI:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L4FAAM_UI,
                    MSG_ID_L4FAAMUI_CLICK_INCOMING,
                    "MSG_ID_L4FAAMUI_CLICK_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_FAAM_UI,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L4FAAM_UI","MSG_ID_L4FAAMUI_CLICK_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_NBIOT_IPM_UI:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L4NBIOT_IPM_UI,
                    MSG_ID_L4NBIOT_IPMUI_CLICK_INCOMING,
                    "MSG_ID_L4NBIOT_IPMUI_CLICK_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_NBIOT_IPM_UI,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L4NBIOT_IPM_UI","MSG_ID_L4NBIOT_IPMUI_CLICK_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_NBIOT_IWM_UI:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L4NBIOT_IWM_UI,
                    MSG_ID_L4NBIOT_IWMUI_CLICK_INCOMING,
                    "MSG_ID_L4NBIOT_IWMUI_CLICK_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_NBIOT_IWM_UI,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L4NBIOT_IWM_UI","MSG_ID_L4NBIOT_IWMUI_CLICK_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_NBIOT_IGM_UI:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L4NBIOT_IGM_UI,
                    MSG_ID_L4NBIOT_IGMUI_CLICK_INCOMING,
                    "MSG_ID_L4NBIOT_IGMUI_CLICK_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_NBIOT_IGM_UI,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L4NBIOT_IGM_UI","MSG_ID_L4NBIOT_IGMUI_CLICK_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_NBIOT_IHM_UI:
                $resp = $this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L4NBIOT_IHM_UI,
                    MSG_ID_L4NBIOT_IHMUI_CLICK_INCOMING,
                    "MSG_ID_L4NBIOT_IHMUI_CLICK_INCOMING",
                    $msg);
                if ($resp == false){
                    $result = "Cloud: Send to message buffer error.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog(MFUN_MAIN_ENTRY_NBIOT_IHM_UI,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L4NBIOT_IHM_UI","MSG_ID_L4NBIOT_IHMUI_CLICK_INCOMING",$log_content);
                    echo trim($result);
                    return false;
                }
                break;
            case MFUN_MAIN_ENTRY_DIRECT_IN://本来就不需要处理，因为消息已经发送进队列了
                //Do nothing so far
                break;
            default :
                break;
        }


        //最后进入循环读取阶段
        //$this做为父CLASS的指针传到被调用任务的CLASS的主入口中去，是为了调用本CLASS的HCU_MSG_SEND函数及其空间，不然无法
        //将消息发送到这个任务L1VM模块中来
        //echo的最终返回，现在暂时假设在最后一条处理消息中完成
        //每个不同任务模块之间的消息结构，由发送者和接收者自行商量结构，因为PHP下是无法定义结构的。同一个CLASS内部可以使
        //用ARRAY进行传递，不同CLASS任务之间则只能采用JSON进行传递，因为不同空间内显然无法将数组传递过去
        $modObj = new classConstL1vmSysTaskList();
        while(($result = $this->mfun_l1vm_msg_rcv()) != false){                  ////////////////////////////////////////////////////
            //语法差错检查
            if (isset($result["srcId"]) != true) continue;
            if (isset($result["destId"]) != true) continue;
            if (isset($result["msgId"]) != true) continue;
            if (isset($result["msgName"]) != true) continue;
            if (isset($result["msgBody"]) != true) continue;
            if (($result["srcId"] <= MFUN_TASK_ID_MIN) || ($result["srcId"] >=MFUN_TASK_ID_MAX)) continue;
            if (($result["destId"] <= MFUN_TASK_ID_MIN) || ($result["destId"] >=MFUN_TASK_ID_MAX)) continue;
            if (($result["msgId"] <= MSG_ID_MFUN_MIN) || ($result["msgId"] >=MSG_ID_MFUN_MAX)) continue;

            //检查目标任务模块是否激活
            if ($modObj->mfun_vm_getTaskPresent($result["destId"]) != true){///////////////////////////////////要打开
                $result = "Cloud: Target module is not actived.";
                $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                $loggerObj->mylog("NULL","NULL","MFUN_TASK_ID_L1VM",$result["destId"],$result["msgName"],$log_content);
                echo trim($result);
                continue;
            }

            //具体开始处理目标消息的大循环
            switch($result["destId"]){
                case MFUN_TASK_ID_L1VM:
                    $obj = new classTaskL1vmCoreRouter();
                    $obj->mfun_l1vm_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SDK_IOT_APPLE:
                    $obj = new classTaskL2sdkIotApple();
                    $obj->mfun_l2sdk_iot_apple_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SDK_IOT_JD:
                    $obj = new classTaskL2sdkIotJd();
                    $obj->mfun_l2sdk_iot_jd_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SDK_WECHAT:
                    $wx_options = array(
                        'token'=>MFUN_WX_TOKEN, //填写你设定的key
                        'encodingaeskey'=>MFUN_WX_ENCODINGAESKEY, //填写加密用的EncodingAESKey，如接口为明文模式可忽略
                        'appid'=>MFUN_WX_APPID,
                        'appsecret'=>MFUN_WX_APPSECRET, //填写高级调用功能的密钥
                        'debug'=> MFUN_WX_DEBUG,
                        'logcallback' => MFUN_WX_LOGCALLBACK);
                    $obj = new classTaskL2sdkWechat($wx_options);
                    //如果是第一次设定，则需要进去设置环境, 方倍工作室原创而改动
                    if (isset($_GET['echostr'])) {
                        $obj->valid_sdk01();
                    }else{
                        $obj->mfun_l2sdk_wechat_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    }
                    break;

                case MFUN_TASK_ID_L3WX_OPR_FAAM:
                    $obj = new classTaskL3wxOprFaam();
                    $obj->mfun_l3wx_opr_faam_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SDK_IOT_WX:
                    $obj = new classTaskL2sdkIotWx(MFUN_WX_APPID, MFUN_WX_APPSECRET);
                    $obj->mfun_l2sdk_iot_wx_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK:
                    $obj = new classTaskL2sdkIotWxJssdk(MFUN_WX_APPID, MFUN_WX_APPSECRET);
                    $obj->mfun_l2sdk_iot_wx_jssdk_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SDK_IOT_STDXML:
                    $obj = new classTaskL2sdkIotStdxml();
                    $obj->mfun_l2sdk_iot_stdxml_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SDK_IOT_JSON:
                    $obj = new classTaskL2sdkIotJson();
                    $obj->mfun_l2sdk_iot_json_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SDK_IOT_HUITP:
                    $obj = new classTaskL2sdkIotHuitp();
                    $obj->mfun_l2sdk_iot_huitp_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2DECODE_HUITP:
                    $obj = new classTaskL2decodeHuitpXml();
                    $obj->mfun_l2decode_huitp_xml_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2ENCODE_HUITP:
                    $obj = new classTaskL2encodeHuitpXml();
                    $obj->mfun_l2encode_huitp_xml_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2CODEC_PRIVATE_GTJY:
                    $obj = new classTaskL2codecPrivateGtjy();
                    $obj->mfun_l2codec_private_gtjy_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2CODEC_WSDL_YCJK:
                    $obj = new classTaskL2codecWsdlYcjk();
                    $obj->mfun_l2codec_wsdl_ycjk_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376:
                    $obj = new classTaskL2sdkNbiotStdQg376();
                    $obj->mfun_l2sdk_nbiot_std_qg376_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188:
                    $obj = new classTaskL2sdkNbiotStdCj188();
                    $obj->mfun_l2sdk_nbiot_std_cj188_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SDK_NBIOT_LTEV:
                    $obj = new classTaskL2sdkNbiotLtev();
                    $obj->mfun_l2sdk_nbiot_ltev_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SDK_NBIOT_AGC:
                    $obj = new classTaskL2sdkNbiotAgc();
                    $obj->mfun_l2sdk_nbiot_agc_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_COMMON:
                    $obj = new classTaskL2snrCommonService();
                    $obj->mfun_l2snr_common_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_EMC:
                    $obj = new classTaskL2snrEmc();
                    $obj->mfun_l2snr_emc_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_HSMMP:
                    $obj = new classTaskL2snrHsmmp();
                    $obj->mfun_l2snr_hsmmp_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_HUMID:
                    $obj = new classTaskL2snrHumid();
                    $obj->mfun_l2snr_humid_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_NOISE:
                    $obj = new classTaskL2snrNoise();
                    $obj->mfun_l2snr_noise_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_PM25:
                    $obj = new classTaskL2snrPm25();
                    $obj->mfun_l2snr_pm25_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_TEMP:
                    $obj = new classTaskL2snrTemp();
                    $obj->mfun_l2snr_temp_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_WINDDIR:
                    $obj = new classTaskL2snrWinddir();
                    $obj->mfun_l2snr_winddir_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_WINDSPD:
                    $obj = new classTaskL2snrWindspd();
                    $obj->mfun_l2snr_windspd_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_AIRPRS:
                    $obj = new classTaskL2snrAirprs();
                    $obj->mfun_l2snr_airprs_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_ALCOHOL:
                    $obj = new classTaskL2snrAlcohol();
                    $obj->mfun_l2snr_alcohol_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_CO1:
                    $obj = new classTaskL2snrCo1();
                    $obj->mfun_l2snr_co1_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_HCHO:
                    $obj = new classTaskL2snrHcho();
                    $obj->mfun_l2snr_hcho_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_TOXICGAS:
                    $obj = new classTaskL2snrToxicgas();
                    $obj->mfun_l2snr_toxicgas_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_LIGHTSTR:
                    $obj = new classTaskL2snrLightstr();
                    $obj->mfun_l2snr_lightstr_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_RAIN:
                    $obj = new classTaskL2snrRain();
                    $obj->mfun_l2snr_rain_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_IPM:
                    $obj = new classTaskL2snrIpm();
                    $obj->mfun_l2snr_ipm_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_IGM:
                    $obj = new classTaskL2snrIgm();
                    $obj->mfun_l2snr_igm_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_IWM:
                    $obj = new classTaskL2snrIwm();
                    $obj->mfun_l2snr_iwm_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_IHM:
                    $obj = new classTaskL2snrIhm();
                    $obj->mfun_l2snr_ihm_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2TIMER_CRON:
                    $obj = new classTaskL2TimerCron();
                    $obj->mfun_l2timer_cron_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SOCKET_LISTEN:
                    $obj = new classTaskL2SocketListen();
                    $obj->mfun_l2socket_listen_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_BATT:
                    $obj = new classTaskL2snrBatt();
                    $obj->mfun_l2snr_batt_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_BLE:
                    $obj = new classTaskL2snrBle();
                    $obj->mfun_l2snr_ble_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_DOORLOCK:
                    $obj = new classTaskL2snrDoorlock();
                    $obj->mfun_l2snr_doorlock_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_CCL:
                    $obj = new classTaskL2snrCcl();
                    $obj->mfun_l2snr_ccl_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_GPRS:
                    $obj = new classTaskL2snrGprs();
                    $obj->mfun_l2snr_gprs_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_RFID:
                    $obj = new classTaskL2snrRfid();
                    $obj->mfun_l2snr_rfid_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_SMOK:
                    $obj = new classTaskL2snrSmok();
                    $obj->mfun_l2snr_smok_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_VIBR:
                    $obj = new classTaskL2snrVibr();
                    $obj->mfun_l2snr_vibr_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_WATER:
                    $obj = new classTaskL2snrWater();
                    $obj->mfun_l2snr_water_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_WEIGHT:
                    $obj = new classTaskL2snrWeight();
                    $obj->mfun_l2snr_weight_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_FDWQ:
                    $obj = new classTaskL2snrFdwq();
                    $obj->mfun_l2snr_fdwq_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L2SENSOR_EARTHDIN:
                    $obj = new classTaskL2snrEarthdin();
                    $obj->mfun_l2snr_earthdin_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L3APPL_FUM1SYM:
                    $obj = new classTaskL3aplF1sym();
                    $obj->mfun_l3apl_f1sym_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L3APPL_FUM2CM:
                    $obj = new classTaskL3aplF2cm();
                    $obj->mfun_l3apl_f2cm_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L3APPL_FUM3DM:
                    $obj = new classTaskL3aplF3dm();
                    $obj->mfun_l3apl_f3dm_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L3APPL_FUM4ICM:
                    $obj = new classTaskL3aplF4icm();
                    $obj->mfun_l3apl_f4icm_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L3APPL_FUM5FM:
                    $obj = new classTaskL3aplF5fm();
                    $obj->mfun_l3apl_f5fm_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L3APPL_FUM6PM:
                    $obj = new classTaskL3aplF6pm();
                    $obj->mfun_l3apl_f6pm_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L3APPL_FUM7ADS:
                    $obj = new classTaskL3aplF7ads();
                    $obj->mfun_l3apl_f7ads_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L3APPL_FUM8PSM:
                    $obj = new classTaskL3aplF8psm();
                    $obj->mfun_l3apl_f8psm_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L3APPL_FUM9GISM:
                    $obj = new classTaskL3aplF9gism();
                    $obj->mfun_l3apl_f9gism_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L3APPL_FUMXPRCM:
                    $obj = new classTaskL3aplFxprcm();
                    $obj->mfun_l3apl_fxprcm_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L3APPL_FUM11FAAM:
                    $obj = new classTaskL3aplF11faam();
                    $obj->mfun_l3apl_f11faam_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L3WX_OPR_EMC:
                    $obj = new classTaskL3wxOprEmc();
                    $obj->mfun_l3wx_opr_emc_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L3WX_OPR_FHYS:
                    $obj = new classTaskL3wxOprFhys();
                    $obj->mfun_l3wx_opr_fhys_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L3NBIOT_OPR_METER:
                    $obj = new classTaskL3nbiotOprMeter();
                    $obj->mfun_l3nbiot_opr_meter_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4COM_UI:
                    $obj = new classTaskL4comUi();
                    $obj->mfun_l4com_ui_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4AQYC_UI:
                    $obj = new classTaskL4aqycUi();
                    $obj->mfun_l4aqyc_ui_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4FHYS_UI:
                    $obj = new classTaskL4fhysUi();
                    $obj->mfun_l4fhys_ui_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4FHYS_WECHAT:
                    $obj = new classTaskL4fhysWechat();
                    $obj->mfun_l4fhys_wechat_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4BFSC_UI:
                    $obj = new classTaskL4bfscUi();
                    $obj->mfun_l4bfsc_ui_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4EMCWX_UI:
                    $obj = new classTaskL4emcwxUi();
                    $obj->mfun_l4emcwx_ui_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4TBSWR_UI:
                    $obj = new classTaskL4tbswrUi();
                    $obj->mfun_l4tbswr_ui_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4FDWQ_UI:
                    $obj = new classTaskL4fdwqUi();
                    $obj->mfun_l4fdwq_ui_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4GTJY_UI:
                    $obj = new classTaskL4gtjyUi();
                    $obj->mfun_l4gtjy_ui_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4FAAM_UI:
                    $obj = new classTaskL4faamUi();
                    $obj->mfun_l4faam_ui_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4NBIOT_IPM_UI:
                    $obj = new classTaskL4nbiotIpmUi();
                    $obj->mfun_l4nbiot_ipm_ui_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4NBIOT_IGM_UI:
                    $obj = new classTaskL4nbiotIgmUi();
                    $obj->mfun_l4nbiot_igm_ui_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4NBIOT_IWM_UI:
                    $obj = new classTaskL4nbiotIwmUi();
                    $obj->mfun_l4nbiot_iwm_ui_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4NBIOT_IHM_UI:
                    $obj = new classTaskL4nbiotIhmUi();
                    $obj->mfun_l4nbiot_ihm_ui_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                case MFUN_TASK_ID_L4OAMTOOLS:
                    break;

                case MFUN_TASK_ID_L5BI:
                    $obj = new classTaskL5biService();
                    $obj->mfun_l5bi_service_task_main_entry($this, $result["msgId"], $result["msgName"], $result["msgBody"]);
                    break;

                default:
                    $result = "Cloud: Not supported destination module.";
                    $log_content = "P:" . json_encode($result,JSON_UNESCAPED_UNICODE);
                    $loggerObj->mylog("NULL","NULL","MFUN_TASK_ID_L1VM",$result["destId"],$result["msgName"],$log_content);
                    echo trim($result);
                    break;

            }//End of switch

            //一直持续到整个流程完成，没有新消息在缓冲区中，然后就结束服务，并结束WHILE循环

        }//End of while
        //最终结束
        return true;
    }

}


?>
