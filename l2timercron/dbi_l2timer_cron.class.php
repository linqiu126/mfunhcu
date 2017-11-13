<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 13:45
 */

class classDbiL2timerCron
{

    /*******************************************清理历史数据CRON任务*****************************************************/
    //删除对应表单中所有超过指定天的数据，缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可

    //湿度传感器数据表 t_l2snr_humiddata
    private function dbi_cron_l2snr_humiddata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_humiddata` WHERE ((TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days')";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //温度传感器数据表 t_l2snr_tempdata
    private function dbi_cron_l2snr_tempdata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_tempdata` WHERE ((TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days')";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //噪声传感器数据表 t_l2snr_noisedata
    private function dbi_cron_l2snr_noisedata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_noisedata` WHERE ((TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days')";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //颗粒物传感器数据表 t_l2snr_pm25data
    private function dbi_cron_l2snr_pm25data_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_pm25data` WHERE ((TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days')";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //风速传感器数据表 t_l2snr_windspd
    private function dbi_cron_l2snr_windspd_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_windspd` WHERE ((TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days')";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //风向传感器数据表 t_l2snr_winddir
    private function dbi_cron_l2snr_winddir_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_winddir` WHERE ((TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days')";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //EMC传感器数据表 t_l2snr_emcdata
    private function dbi_cron_l2snr_emcdata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_emcdata` WHERE ((TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days')";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //照片数据表 t_l2snr_picturedata
    private function dbi_cron_l2snr_picturedata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "SELECT * FROM `t_l2snr_picturedata` WHERE ((TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days')";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)) {
            $sid = $row['sid'];
            $fileName = $row['filename'];
            $statCode = $row['statcode'];
            //清理过期照片
            if(!empty($fileName)){
                $fileLink = MFUN_HCU_SITE_PIC_BASE_DIR.$statCode.'/'.$fileName;
                chmod($fileLink, 0777);
                $resp = unlink($fileLink);
            }
            //删除对应的告警记录
            $query_str = "DELETE FROM `t_l2snr_picturedata` WHERE (`sid` = '$sid')";
            $mysqli->query($query_str);
        }
        return $result;
    }

    //视频数据表 t_l2snr_hsmmpdata
    private function dbi_cron_l2snr_hsmmpdata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "SELECT * FROM `t_l2snr_hsmmpdata` WHERE ((TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days')";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)) {
            $sid = $row['sid'];
            $fileName = $row['filename'];
            $statCode = $row['statcode'];
            //清理过期照片
            if(!empty($fileName)){
                $fileLink = MFUN_HCU_SITE_VIDEO_BASE_DIR.$statCode.'/'.$fileName;
                chmod($fileLink, 0777);
                $resp = unlink($fileLink);
            }
            //删除对应的告警记录
            $query_str = "DELETE FROM `t_l2snr_hsmmpdata` WHERE (`sid` = '$sid')";
            $mysqli->query($query_str);
        }
        return $result;
    }

    //扬尘分钟聚合表 t_l2snr_aqyc_minreport
    private function dbi_cron_l2snr_aqyc_minreport_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_aqyc_minreport` WHERE ((TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days')";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //扬尘系统性能统计表 t_l3f6pm_perfdata
    private function dbi_cron_l3f6pm_perfdata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l3f6pm_perfdata` WHERE (TO_DAYS(NOW()) - TO_DAYS(`createtime`) > '$days')";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //扬尘告警数据表 t_l3f5fm_aqyc_alarmdata
    private function dbi_cron_l3f5fm_aqyc_alarmdata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "SELECT * FROM `t_l3f5fm_aqyc_alarmdata` WHERE (TO_DAYS(NOW()) - TO_DAYS(`tsgen`) > '$days')";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)) {
            $sid = $row['sid'];
            $fileName = $row['alarmpic'];
            $statCode = $row['statcode'];

            //清理过期照片
            if (!empty($alarmpic)) {
                $fileLink = MFUN_HCU_SITE_PIC_BASE_DIR . $statCode . '/' . $fileName;
                chmod($fileLink, 0777);
                $resp = unlink($fileLink);
            }
            //删除对应的告警记录
            $query_str = "DELETE FROM `t_l3f5fm_aqyc_alarmdata` WHERE (`sid` = '$sid')";
            $mysqli->query($query_str);
        }
        return $result;
    }

    //云控锁告警数据表t_l3f5fm_fhys_alarmdata
    private function dbi_cron_l3f5fm_fhys_alarmdata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l3f5fm_fhys_alarmdata` WHERE ((TO_DAYS(NOW()) - TO_DAYS(`tsgen`) > '$days')";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //云控锁开锁历史表t_l3fxprcm_fhys_locklog
    private function dbi_cron_l3fxprcm_fhys_locklog_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "SELECT * FROM `t_l3fxprcm_fhys_locklog` WHERE ((TO_DAYS(NOW()) - TO_DAYS(`createtime`) > '$days')";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)) {
            $sid = $row['sid'];
            $fileName = $row['picname'];
            $statCode = $row['statcode'];
            //清理过期照片
            if(!empty($filename)){
                $fileLink = $fileLink = MFUN_HCU_SITE_PIC_BASE_DIR.$statCode.'/'.$fileName;
                chmod($fileLink, 0777);
                $resp = unlink($fileLink);
            }
            //删除对应的告警记录
            $query_str = "DELETE FROM `t_l3fxprcm_fhys_locklog` WHERE (`sid` = '$sid')";
            $mysqli->query($query_str);
        }
        return $result;
    }

    //云控锁分钟聚合表 t_l2snr_fhys_minreport
    private function dbi_cron_l2snr_fhys_minreport_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_fhys_minreport` WHERE ((TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > '$days')";
        $result = $mysqli->query($query_str);
        return $result;
    }


    /***AQYC扬尘项目超期历史数据清理***/

    public function dbi_cron_aqyc_olddata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据
        //温度
        $result1 = $this->dbi_cron_l2snr_tempdata_cleanup($mysqli, $days);
        //湿度
        $result2 = $this->dbi_cron_l2snr_humiddata_cleanup($mysqli, $days);
        //风向
        $result3 = $this->dbi_cron_l2snr_winddir_cleanup($mysqli, $days);
        //风速
        $result4 = $this->dbi_cron_l2snr_windspd_cleanup($mysqli, $days);
        //噪声
        $result5 = $this->dbi_cron_l2snr_noisedata_cleanup($mysqli, $days);
        //颗粒物
        $result6 = $this->dbi_cron_l2snr_pm25data_cleanup($mysqli, $days);
        //照片
        $result7 = $this->dbi_cron_l2snr_picturedata_cleanup($mysqli, $days);
        //分钟聚合
        $result8 = $this->dbi_cron_l2snr_aqyc_minreport_cleanup($mysqli, $days);
        //性能统计
        $result9 = $this->dbi_cron_l3f6pm_perfdata_cleanup($mysqli, $days);
        //告警数据
        $result10 = $this->dbi_cron_l3f5fm_aqyc_alarmdata_cleanup($mysqli, $days);

        $result = $result1 AND $result2 AND $result3 AND $result4 AND $result5 AND $result6 AND $result7 AND $result8 AND $result9 AND $result10;
        return $result;
    }

    /***FHYS云控锁项目超期历史数据清理***/

    public function dbi_cron_fhys_olddata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        //告警数据
        $result1 = $this->dbi_cron_l3f5fm_fhys_alarmdata_cleanup($mysqli, $days);
        //开锁历史数据
        $result2 = $this->dbi_cron_l3fxprcm_fhys_locklog_cleanup($mysqli, $days);
        //分钟聚合数据
        $result3 = $this->dbi_cron_l2snr_fhys_minreport_cleanup($mysqli, $days);
        //照片
        $result4 = $this->dbi_cron_l2snr_picturedata_cleanup($mysqli, $days);

        $result = $result1 AND $result2 AND $result3 AND $result4;
        return $result;
    }
}