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

        $query_str = "DELETE FROM `t_l2snr_humiddata` WHERE (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > $days)";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //温度传感器数据表 t_l2snr_tempdata
    private function dbi_cron_l2snr_tempdata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_tempdata` WHERE (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > $days)";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //噪声传感器数据表 t_l2snr_noisedata
    private function dbi_cron_l2snr_noisedata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_noisedata` WHERE (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > $days)";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //颗粒物传感器数据表 t_l2snr_pm25data
    private function dbi_cron_l2snr_pm25data_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_pm25data` WHERE (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > $days)";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //风速传感器数据表 t_l2snr_windspd
    private function dbi_cron_l2snr_windspd_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_windspd` WHERE (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > $days)";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //风向传感器数据表 t_l2snr_winddir
    private function dbi_cron_l2snr_winddir_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_winddir` WHERE (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > $days)";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //EMC传感器数据表 t_l2snr_emcdata
    private function dbi_cron_l2snr_emcdata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l2snr_emcdata` WHERE (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > $days)";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //照片数据表 t_l2snr_picturedata
    private function dbi_cron_l2snr_picturedata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "SELECT * FROM `t_l2snr_picturedata` WHERE (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > $days)";
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

        $query_str = "SELECT * FROM `t_l2snr_hsmmpdata` WHERE (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > $days)";
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

        $query_str = "DELETE FROM `t_l2snr_aqyc_minreport` WHERE (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > $days)";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //扬尘系统性能统计表 t_l3f6pm_perfdata
    private function dbi_cron_l3f6pm_perfdata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "DELETE FROM `t_l3f6pm_perfdata` WHERE (TO_DAYS(NOW()) - TO_DAYS(`createtime`) > $days)";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //扬尘告警数据表 t_l3f5fm_aqyc_alarmdata
    private function dbi_cron_l3f5fm_aqyc_alarmdata_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "SELECT * FROM `t_l3f5fm_aqyc_alarmdata` WHERE (TO_DAYS(NOW()) - TO_DAYS(`tsgen`) > $days)";
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

        $query_str = "DELETE FROM `t_l3f5fm_fhys_alarmdata` WHERE (TO_DAYS(NOW()) - TO_DAYS(`tsgen`) > $days)";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //云控锁开锁历史表t_l3fxprcm_fhys_locklog
    private function dbi_cron_l3fxprcm_fhys_locklog_cleanup($mysqli, $days)
    {
        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据

        $query_str = "SELECT * FROM `t_l3fxprcm_fhys_locklog` WHERE (TO_DAYS(NOW()) - TO_DAYS(`createtime`) > $days)";
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

        $query_str = "DELETE FROM `t_l2snr_fhys_minreport` WHERE (TO_DAYS(NOW()) - TO_DAYS(`reportdate`) > $days)";
        $result = $mysqli->query($query_str);
        return $result;
    }

    //系统日志表 t_l1vm_loginfo
    private function dbi_cron_l1vm_loginfo_cleanup()
    {
        //连接log数据库
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_DEBUG, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //初始化
        $sid_min = 0;
        $sid_max = 0;
        //查找最大SID
        $result = $mysqli->query("SELECT  MAX(`sid`)  FROM `t_l1vm_loginfo` WHERE 1 ");
        if ($result->num_rows>0){
            $row_max =  $result->fetch_array();
            $sid_max = $row_max['MAX(`sid`)'];
        }
        //查找最小SID
        $result = $mysqli->query("SELECT  MIN(`sid`)  FROM `t_l1vm_loginfo` WHERE 1 ");
        if ($result->num_rows>0) {
            $row_min =  $result->fetch_array();
            $sid_min = $row_min['MIN(`sid`)'] ;
        }

        //检查记录数如果超过MAX_LOG_NUM，则删除老的记录
        if (($sid_max - $sid_min) > MFUN_L1VM_DBI_MAX_LOG_NUM) {
            $count = $sid_max - MFUN_L1VM_DBI_MAX_LOG_NUM;
            $result = $mysqli->query("DELETE FROM `t_l1vm_loginfo` WHERE (`sid` >0 AND `sid`< $count) ");
        }

        $mysqli->close();
        return $result;
    }

    public function dbi_cron_10min_process_sae_database_backup()
    {
        $dj = new SaeDeferredJob();
        //添加任务，导入数据库
        // $taskID=$dj->addTask("import","mysql","domainA","abc.sql","databaseA","tableA","callback.php");
        // if($taskID===false)
        //     var_dump($dj->errno(), $dj->errmsg());
        // else
        // var_dump($taskID);
        $tasktype = "export";
        $dbtype = "mysql";
        $stor_domain = "backupdatabase";
        $dbname = "app_mfuncard";
        $tbname = null;

        //$tbname = null应该是选择全部表，需要试试
        //$tbname = "loginfo";
        date_default_timezone_set("Asia/Shanghai");
        $my_t=getdate(date("U"));
        $stor_filename = "$dbname-$my_t[year]-$my_t[mon]-$my_t[mday]-$my_t[hours]-$my_t[minutes]-$my_t[seconds].sql.zip";
        //$stor_filename = "201509191321.sql.zip";
        $callbackurl = null;
        //$callbackurl = null 设置为null是否就不出错，要试试
        //$callbackurl = "csv.php";
        $ignore_errors = true;

        $taskID=$dj->addTask($tasktype,$dbtype,$stor_domain,$stor_filename,$dbname,$tbname,$callbackurl, $ignore_errors);
        if($taskID===false) var_dump($dj->errno(), $dj->errmsg());

        // //获得任务状态
        // $ret=$dj->getStatus($taskID);
        // if($ret===false)
        //     var_dump($dj->errno(), $dj->errmsg());

        // //删除任务
        // $ret=$dj->deleteTask($taskID);
        // if($ret===false)
        //     var_dump($dj->errno(), $dj->errmsg());

        return "";
    }

    /***FAAM工厂智能管理项目计算工人当天标准绩效***/
    public function dbi_cron_faam_employee_standard_kpi_calc($pjCode)
    {
        //连接log数据库
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //查询员工列表
        $onJob = MFUN_HCU_FAAM_EMPLOYEE_ONJOB_YES; //在职员工
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode' AND `onjob` = '$onJob')";
        $result = $mysqli->query($query_str);
        $nameList = array();
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            array_push($nameList, $row);
        }

        //查询当天有上下班考勤的记录
        $workDay = date('Y-m-d', time());
        $dailySheet = array();
        $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode`='$pjCode' AND `workday`='$workDay')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows) > 0) {
            while (($row = $result->fetch_array()) > 0)
                array_push($dailySheet, $row);
        }
        //处理员工表查询结果
        for($i=0; $i<count($nameList); $i++) {
            $employee = $nameList[$i]['employee'];
            $standardNum = $nameList[$i]['standardnum'];
            $standardNumList[$employee] = $standardNum;
        }
        //处理考勤表查询结果
        for($i=0; $i<count($dailySheet); $i++) {
            $employee = $dailySheet[$i]['employee'];
            if(isset($standardNumList[$employee])){
                $hourStandardNum = intval($standardNumList[$employee]);
                $workTime = $dailySheet[$i]['worktime'];
                $dayStandardNum = $hourStandardNum * $workTime;
                $query_str = "UPDATE `t_l3f11faam_dailysheet` SET `daystandardnum` = '$dayStandardNum' WHERE (`pjcode`='$pjCode' AND `workday`='$workDay' AND `employee`='$employee')";
                $result = $mysqli->query($query_str);
            }
        }

        $mysqli->close();
        return $result;
    }

    /***AQYC扬尘项目超期历史数据清理***/

    public function dbi_cron_aqyc_olddata_cleanup($days)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

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
        //关闭数据库
        $mysqli->close();

        //系统日志，log表在不同的数据库，需要重新连接
        $result11 = $this->dbi_cron_l1vm_loginfo_cleanup();

        $result = $result1 AND $result2 AND $result3 AND $result4 AND $result5 AND $result6 AND $result7 AND $result8 AND $result9 AND $result10 AND $result11;

        $mysqli->close();
        return $result;
    }

    /***FHYS云控锁项目超期历史数据清理***/

    public function dbi_cron_fhys_olddata_cleanup($days)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        if ($days < MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS) $days = MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS;  //不允许删除90天以内的数据
        //告警数据
        $result1 = $this->dbi_cron_l3f5fm_fhys_alarmdata_cleanup($mysqli, $days);
        //开锁历史数据
        $result2 = $this->dbi_cron_l3fxprcm_fhys_locklog_cleanup($mysqli, $days);
        //分钟聚合数据
        $result3 = $this->dbi_cron_l2snr_fhys_minreport_cleanup($mysqli, $days);
        //照片
        $result4 = $this->dbi_cron_l2snr_picturedata_cleanup($mysqli, $days);
        //关闭数据库
        $mysqli->close();

        //系统日志，log表在不同的数据库，需要重新连接
        $result5 = $this->dbi_cron_l1vm_loginfo_cleanup();

        $result = $result1 AND $result2 AND $result3 AND $result4 AND $result5;

        $mysqli->close();
        return $result;
    }
}