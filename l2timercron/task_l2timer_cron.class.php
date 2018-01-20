<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/4
 * Time: 20:40
 */

include_once "dbi_l2timer_cron.class.php";

class classTaskL2TimerCron
{
    private function func_timer_1min_process()
    {
        return "";
    }

    private function func_timer_3min_process()
    {
        return "";
    }

    private function func_timer_10min_process()
    {
        return "";
    }

    private function func_timer_30min_process()
    {
        return "";
    }

    public function func_timer_1hour_process()
    {
        //每小时计算FAAM工厂标准绩效数据
        $dbiL2timerCronObj = new classDbiL2timerCron();
        $result = $dbiL2timerCronObj->dbi_cron_faam_employee_standard_kpi_calc('HYGS');
        if($result)
            $resp = "HYGS employee standard KPI calculation success";
        else
            $resp = "HYGS employee standard KPI calculation failure";

        return $resp;
    }

    private function func_timer_6hour_process()
    {
        return "";
    }

    private function func_timer_24hour_process($day)
    {
        $dbiL2timerCronObj = new classDbiL2timerCron();
        if (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_AQYC){
            $result = $dbiL2timerCronObj->dbi_cron_aqyc_olddata_cleanup($day);
            if($result)
                $resp = "AQYC history data cleanup success";
            else
                $resp = "AQYC history data cleanup failure";
        }
        elseif (MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE == MFUN_WORKING_PROGRAM_NAME_UNIQUE_FHYS){
            $result = $dbiL2timerCronObj->dbi_cron_fhys_olddata_cleanup($day);
            if($result)
                $resp = "FHYS history data cleanup success";
            else
                $resp = "FHYS history data cleanup failure";
        }
        else {
            $result1 = $dbiL2timerCronObj->dbi_cron_aqyc_olddata_cleanup($day);
            $result2 = $dbiL2timerCronObj->dbi_cron_fhys_olddata_cleanup($day);
            $result = $result1 AND $result2;
            if($result)
                $resp = "All project history data cleanup success";
            else
                $resp = "All project history data cleanup failure";
        }
        return $resp;
    }

    private function func_timer_2day_process()
    {
        return "";
    }

    private function func_timer_7day_process()
    {
        return "";
    }

    private function func_timer_30day_process()
    {
        return "";
    }
    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2timer_cron_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_CRON;

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","MFUN_MAIN_ENTRY_CRON","MFUN_TASK_ID_L2TIMER_CRON",$msgName,$log_content);
            return false;
        }
        switch($msgId){
            case MSG_ID_L2TIMER_CRON_1MIN_COMING:
                $resp = $this->func_timer_1min_process();
                break;
            case MSG_ID_L2TIMER_CRON_3MIN_COMING:
                $resp = $this->func_timer_3min_process();
                break;
            case MSG_ID_L2TIMER_CRON_10MIN_COMING:
                $resp = $this->func_timer_10min_process();
                break;
            case MSG_ID_L2TIMER_CRON_30MIN_COMING:
                $resp = $this->func_timer_30min_process();
                break;
            case MSG_ID_L2TIMER_CRON_1HOUR_COMING:
                $resp = $this->func_timer_1hour_process();
                break;
            case MSG_ID_L2TIMER_CRON_6HOUR_COMING:
                $resp = $this->func_timer_6hour_process();
                break;
            case MSG_ID_L2TIMER_CRON_24HOUR_COMING:
                $resp = $this->func_timer_24hour_process(MFUN_HCU_DATA_SAVE_DURATION_BY_PROJ);
                break;
            case MSG_ID_L2TIMER_CRON_2DAY_COMING:
                $resp = $this->func_timer_2day_process();
                break;
            case MSG_ID_L2TIMER_CRON_7DAY_COMING:
                $resp = $this->func_timer_7day_process();
                break;
            case MSG_ID_L2TIMER_CRON_30DAY_COMING:
                $resp = $this->func_timer_30day_process();
                break;
            default:
                $resp = "";
                break;
        }

        if (!empty($resp)) {
            $log_content = json_encode($resp,JSON_UNESCAPED_UNICODE);
            $loggerObj->mylog($project,"NULL","MFUN_MAIN_ENTRY_CRON","MFUN_TASK_ID_L2TIMER_CRON",$msgName,$log_content);
        }
        //返回
        return true;
    }

}//End of class_task_service