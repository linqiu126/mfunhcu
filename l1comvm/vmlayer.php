<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2015/7/5
 * Time: 9:26
 */
include_once "../l1comvm/func_comapi.class.php";
include_once "../l1comvm/commsg.php";
include_once "../l1comvm/errCode.php";
include_once "../l1comvm/sysconfig.php";
include_once "../l1comvm/sysdim.php";
include_once "../l1comvm/pj_emcwx_engpar.php";
include_once "../l1comvm/pj_aqyc_engpar.php";
include_once "../l1comvm/pj_tbswr_engpar.php";
include_once "../l1comvm/sysversion.php";
include_once "../l1comvm/sysmodule.php";
include_once "../l1comvm/dbi_common.class.php";

class classTaskL1vmCoreRouter
{
    public $msgBufferList = array();
        //0 => array("valid" => "false", "srcId" => 0, "destId" => 0, "msgId" => 0, "msgName" => "", "msgBody" => ""));
    public $msgBufferReadCnt;
    public $msgBufferWriteCnt;
    public $msgBufferUsedCnt;

    //构造函数
    public function __construct()
    {
        for ($i=0; $i<MFUN_MSG_BUFFER_NBR_MAX; $i++){
            $this->msgBufferList[$i] = array("valid" => "false", "srcId" => 0, "destId" => 0, "msgId" => 0, "msgName" => "", "msgBody" => "");
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
        $this->msgBufferList[$this->msgBufferWriteCnt] = array("valid" => "true",
            "srcId" => $srcId,
            "destId" => $destId,
            "msgId" => $msgId,
            "msgName" => $msgName,
            "msgBody" => $msgBody);

        //写完之后，更新计数器
        $this->msgBufferUsedCnt++;
        $this->msgBufferWriteCnt = ($this->msgBufferWriteCnt+1) % MFUN_MSG_BUFFER_NBR_MAX;

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

    //任务入口函数
    public function mfun_l1vm_task_main_entry($parObj, $msg)
    {
        //先处理接收到的消息的基本情况
        if (empty($msg) == true){
            $obj = new classL1vmFuncComApi();
            $log_time = date("Y-m-d H:i:s", time());
            $obj->logger("NULL", "mfun_l1vm_task_main_entry", $log_time, "P: Nothing received");
            echo "";
            return false;
            //exit;
        }

        //然后发送消息到缓冲区中
        if ($parObj == MFUN_MAIN_ENTRY_HCU_IOT){
            if ($this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SDK_IOT_HCU,
                    MSG_ID_L1VM_L2SDK_IOT_HCU_INCOMING,
                    "MSG_ID_L1VM_L2SDK_IOT_HCU_INCOMING",
                    $msg) == false){
                //logsave
                $obj = new classL1vmFuncComApi();
                $log_time = date("Y-m-d H:i:s", time());
                $obj->logger("MFUN_MAIN_ENTRY_HCU_IOT", "mfun_l1vm_task_main_entry", $log_time, "P: Send to message buffer error.");
                echo "Cloud internal error.";
                return false;
            };
        }elseif($parObj == MFUN_MAIN_ENTRY_EMC_WX){
            if ($this->mfun_l1vm_msg_send(MFUN_TASK_ID_L1VM,
                    MFUN_TASK_ID_L2SDK_IOT_WX,
                    MSG_ID_L1VM_L2SDK_IOT_WX_INCOMING,
                    "MSG_ID_L1VM_L2SDK_IOT_WX_INCOMING",
                    $msg) == false) {
                //logsave
                $obj = new classL1vmFuncComApi();
                $log_time = date("Y-m-d H:i:s", time());
                $obj->logger("MFUN_MAIN_ENTRY_EMC_WX", "mfun_l1vm_task_main_entry", $log_time, "P: Send to message buffer error.");
                echo "Cloud internal error.";
                return false;
            };
        }elseif($parObj == MFUN_MAIN_ENTRY_CRON){

        }elseif($parObj == $this){

        }else{

        }

        //最后进入循环读取阶段
        //$this做为父CLASS的指针传到被调用任务的CLASS的主入口中去，是为了调用本CLASS的HCU_MSG_SEND函数及其空间，不然无法
        //将消息发送到这个任务L1VM模块中来
        //echo的最终返回，现在暂时假设在最后一条处理消息中完成
        //每个不同任务模块之间的消息结构，由发送者和接收者自行商量结构，因为PHP下是无法定义结构的。同一个CLASS内部可以使
        //用ARRAY进行传递，不同CLASS任务之间则只能采用JSON进行传递，因为不同空间内显然无法将数组传递过去
        $modObj = new classConstL1vmSysTaskList();
        while(($result = $this->mfun_l1vm_msg_rcv()) != false){
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
            if ($modObj->mfun_vm_getTaskPresent($result["destId"]) != true){
                $obj = new classL1vmFuncComApi();
                $log_time = date("Y-m-d H:i:s", time());
                $obj->logger("NULL", "mfun_l1vm_task_main_entry", $log_time, "P: Target module is not actived.");
                echo "Cloud internal error.";
                continue;
            }
            //具体开始处理目标消息的大循环
            switch($result["destId"]){
                case MFUN_TASK_ID_L1VM:
                    $obj = new classTaskL1vmCoreRouter();
                    $obj->mfun_l1vm_task_main_entry($this, ["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SDK_IOT_APPLE:
                    $obj = new classTaskL2sdkIotApple();
                    $obj->mfun_l2sdk_iot_apple_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SDK_IOT_JD:
                    $obj = new classTaskL2sdkIotJd();
                    $obj->mfun_l2sdk_iot_jd_task_main_entry($this, $result["msgBody"]);
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
                    $obj->mfun_l2sdk_wechat_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SDK_IOT_WX:
                    $obj = new classTaskL2sdkIotWx(MFUN_WX_APPID, MFUN_WX_APPSECRET);
                    $obj->mfun_l2sdk_iot_wx_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SDK_IOT_WX_JSSDK:
                    $obj = new classTaskL2sdkIotWxJssdk(MFUN_WX_APPID, MFUN_WX_APPSECRET);
                    $obj->mfun_l2sdk_iot_wx_jssdk_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SDK_IOT_HCU:
                    $obj = new classTaskL2sdkIotHcu();
                    $obj->mfun_l2sdk_iot_hcu_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_EMC:
                    $obj = new classTaskL2snrEmc();
                    $obj->mfun_l2snr_emc_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_HSMMP:
                    $obj = new classTaskL2snrHsmmp();
                    $obj->mfun_l2snr_hsmmp_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_HUMID:
                    $obj = new classTaskL2snrHumid();
                    $obj->mfun_l2snr_humid_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_NOISE:
                    $obj = new classTaskL2snrNoise();
                    $obj->mfun_l2snr_noise_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_PM25:
                    $obj = new classTaskL2snrPm25();
                    $obj->mfun_l2snr_pm25_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_TEMP:
                    $obj = new classTaskL2snrTemp();
                    $obj->mfun_l2snr_temp_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_WINDDIR:
                    $obj = new classTaskL2snrWinddir();
                    $obj->mfun_l2snr_winddir_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_WINDSPD:
                    $obj = new classTaskL2snrWindspd();
                    $obj->mfun_l2snr_windspd_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_AIRPRS:
                    $obj = new classTaskL2snrAirprs();
                    $obj->mfun_l2snr_airprs_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_ALCOHOL:
                    $obj = new classTaskL2snrAlcohol();
                    $obj->mfun_l2snr_alcohol_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_CO1:
                    $obj = new classTaskL2snrCo1();
                    $obj->mfun_l2snr_co1_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_HCHO:
                    $obj = new classTaskL2snrHcho();
                    $obj->mfun_l2snr_hcho_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_TOXICGAS:
                    $obj = new classTaskL2snrToxicgas();
                    $obj->mfun_l2snr_toxicgas_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L2SENSOR_LIGHTSTR:
                    $obj = new classTaskL2snrLightstr();
                    $obj->mfun_l2snr_lightstr_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L3APPL_FUM1SYM:
                    $obj = new classTaskL3aplF1sym();
                    $obj->mfun_l3apl_f1sym_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L3APPL_FUM2CM:
                    $obj = new classTaskL3aplF2cm();
                    $obj->mfun_l3apl_f2cm_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L3APPL_FUM3DM:
                    $obj = new classTaskL3aplF3dm();
                    $obj->mfun_l3apl_f3dm_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L3APPL_FUM4ICM:
                    $obj = new classTaskL3aplF4icm();
                    $obj->mfun_l3apl_f4icm_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L3APPL_FUM5FM:
                    $obj = new classTaskL3aplF5fm();
                    $obj->mfun_l3apl_f5fm_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L3APPL_FUM6PM:
                    $obj = new classTaskL3aplF6pm();
                    $obj->mfun_l3apl_f6pm_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L3APPL_FUM7ADS:
                    $obj = new classTaskL3aplF7ads();
                    $obj->mfun_l3apl_f7ads_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L3APPL_FUM8PSM:
                    $obj = new classTaskL3aplF8psm();
                    $obj->mfun_l3apl_f8psm_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L3APPL_FUM9GISM:
                    $obj = new classTaskL3aplF9gism();
                    $obj->mfun_l3apl_f9gism_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L3APPL_FUMXPRCM:
                    $obj = new classTaskL3aplFxprcm();
                    $obj->mfun_l3apl_fxprcm_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L3WXPRC_EMC:
                    $obj = new classTaskL3wxCtrlEmc();
                    $obj->mfun_l3wx_ctrl_emc_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L4AQYC_UI:
                    $obj = new classTaskL4aqycUi();
                    $obj->mfun_l4aqyc_ui_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L4EMCWX_UI:
                    $obj = new classTaskL4emcwxUi();
                    $obj->mfun_l4emcwx_ui_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L4TBSWR_UI:
                    $obj = new classTaskL4tbswrUi();
                    $obj->mfun_l4tbswr_ui_task_main_entry($this, $result["msgBody"]);
                    break;
                case MFUN_TASK_ID_L4OAMTOOLS:
                    break;
                case MFUN_TASK_ID_L5BI:
                    $obj = new classTaskL5biService();
                    $obj->mfun_l5bi_service_task_main_entry($this, $result["msgBody"]);
                    break;
                default:
                    break;
            }//End of switch

            //一直持续到整个流程完成，没有新消息在缓冲区中，然后就结束服务，并结束WHILE循环

        }//End of while
        //最终结束
        return true;
    }

}


?>



