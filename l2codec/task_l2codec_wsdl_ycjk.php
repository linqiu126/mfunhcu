<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 2:48
 */

class classTaskL2codecWsdlYcjk
{

    //1、EmsProject 工程信息
    private function func_wsdl_ycjk_EmsProject_encode($input)
    {
        //判断是否存在
        if (isset($input["code"])) $code = $input["code"]; else  $code = "";
        if (isset($input["name"])) $name = $input["name"]; else  $name = "";
        if (isset($input["district"])) $district = $input["district"]; else  $district = "";
        if (isset($input["prjType"])) $prjType = $input["prjType"]; else  $prjType = "";
        if (isset($input["prjCategory"])) $prjCategory = $input["prjCategory"]; else  $prjCategory = "";
        if (isset($input["prjPeriod"])) $prjPeriod = $input["prjPeriod"]; else  $prjPeriod = "";
        if (isset($input["region"])) $region = $input["region"]; else  $region = "";
        if (isset($input["street"])) $street = $input["street"]; else  $street = "";
        if (isset($input["longitude"])) $longitude = $input["longitude"]; else  $longitude = "";
        if (isset($input["latitude"])) $latitude = $input["latitude"]; else  $latitude = "";
        if (isset($input["contractors"])) $contractors = $input["contractors"]; else  $contractors = "";
        if (isset($input["superintendent"])) $superintendent = $input["superintendent"]; else  $superintendent = "";
        if (isset($input["telephone"])) $telephone = $input["telephone"]; else  $telephone = "";
        if (isset($input["address"])) $address = $input["address"]; else  $address = "";
        if (isset($input["siteArea"])) $siteArea = $input["siteArea"]; else  $siteArea = "";
        if (isset($input["buildingArea"])) $buildingArea = $input["buildingArea"]; else  $buildingArea = "";
        if (isset($input["startDate"])) $startDate = $input["startDate"]; else  $startDate = "";
        if (isset($input["endDate"])) $endDate = $input["endDate"]; else  $endDate = "";
        if (isset($input["stage"])) $stage = $input["stage"]; else  $stage = "";
        if (isset($input["isCompleted"])) $isCompleted = $input["isCompleted"]; else  $isCompleted = "";
        if (isset($input["status"])) $status = $input["status"]; else  $status = "";

        $xmlTpl = "<EmsProject>
                    <code><![CDATA[%s]]></code>
                    <name><![CDATA[%s]]></name>
                    <district><![CDATA[%s]]></district>
                    <prjType><![CDATA[%s]]></prjType>
                    <prjCategory><![CDATA[%s]]></prjCategory>
                    <prjPeriod><![CDATA[%s]]></prjPeriod>
                    <street><![CDATA[%s]]></street>
                    <longitude><![CDATA[%s]]></longitude>
                    <latitude><![CDATA[%s]]></latitude>
                    <contractors><![CDATA[%s]]></contractors>
                    <superintendent><![CDATA[%s]]></superintendent>
                    <telephone><![CDATA[%s]]></telephone>
                    <address><![CDATA[%s]]></address>
                    <siteArea><![CDATA[%s]]></siteArea>
                    <buildingArea><![CDATA[%s]]></buildingArea>
                    <startDate><![CDATA[%s]]></startDate>
                    <endDate><![CDATA[%s]]></endDate>
                    <stage><![CDATA[%s]]></stage>
                    <isCompleted><![CDATA[%s]]></isCompleted>
                    <status><![CDATA[%s]]></status></EmsProject>";
        //sprintf :主要是把格式化数据写入字符串中
        $result = sprintf($xmlTpl,$code,$name,$district,$prjType,$prjCategory,$prjPeriod,$region,$street,$longitude,$latitude,$contractors,$superintendent,$telephone,$address,$siteArea,$buildingArea,$startDate,$endDate,$stage,$isCompleted,$status);
        return $result;
    }
    //2、EmsDevice 设备信息
    private function  func_wsdl_ycjk_EmsDevice_encode($input)
    {
        //判断是否存在？
        if (isset($input["code"])) $code = $input["code"]; else  $code = "";
        if (isset($input["name"])) $name = $input["name"]; else  $name = "";
        if (isset($input["ipAddr"])) $ipAddr = $input["ipAddr"]; else  $ipAddr = "";
        if (isset($input["macAddr"])) $macAddr = $input["macAddr"]; else  $macAddr = "";
        if (isset($input["port"])) $port = $input["port"]; else  $port = "";
        if (isset($input["version"])) $version = $input["version"]; else  $version = "";
        if (isset($input["projectCode"])) $projectCode = $input["projectCode"]; else  $projectCode = "";
        if (isset($input["longitude"])) $longitude = $input["longitude"]; else  $longitude = "";
        if (isset($input["latitude"])) $latitude = $input["latitude"]; else  $latitude = "";
        if (isset($input["startDate"])) $startDate = $input["startDate"]; else  $startDate = "";
        if (isset($input["endDate"])) $endDate = $input["endDate"]; else  $endDate = "";
        if (isset($input["installDate"])) $installDate = $input["installDate"]; else  $installDate = "";
        if (isset($input["onlineStatus"])) $onlineStatus = $input["onlineStatus"]; else  $onlineStatus = "";
        if (isset($input["videoUrl"])) $videoUrl = $input["videoUrl"]; else  $videoUrl = "";

        $xmlTpl = "<EmsDevice>
                    <code><![CDATA[%s]]></code>
                    <name><![CDATA[%s]]></name>
                    <ipAddr><![CDATA[%s]]></ipAddr>
                    <macAddr><![CDATA[%s]]></macAddr>
                    <port><![CDATA[%s]]></port>
                    <version><![CDATA[%s]]></version>
                    <projectCode><![CDATA[%s]]></projectCode>
                    <longitude><![CDATA[%s]]></longitude>
                    <latitude><![CDATA[%s]]></latitude>
                    <startDate><![CDATA[%s]]></startDate>
                    <endDate><![CDATA[%s]]></endDate>
                    <installDate><![CDATA[%s]]></installDate>
                    <onlineStatus><![CDATA[%s]]></onlineStatus>
                    <videoUrl><![CDATA[%s]]></videoUrl>
                 </EmsDevice>";
        $result = sprintf($xmlTpl,$code,$name,$ipAddr,$macAddr,$port,$version,$projectCode,$longitude,$latitude,$startDate,$endDate,$installDate,$onlineStatus,$videoUrl);
        return $result;
    }
    //3.EmsData 设备数据
    private function  func_wsdl_ycjk_EmsData_encode($input)
    {
        //判断是否存在
        if (isset($input["devCode"])) $devCode = $input["devCode"]; else  $devCode = "";
        if (isset($input["prjCode"])) $prjCode = $input["prjCode"]; else  $prjCode = "";
        if (isset($input["prjType"])) $prjType = $input["prjType"]; else  $prjType = "";
        if (isset($input["dust"]))    $dust =  $input["dust"];      else  $dust = "";
        if (isset($input["maxDust"])) $maxDust = $input["maxDust"]; else  $maxDust = "";

        if (isset($input["minDust"]))  $minDust = $input["minDust"]; else  $minDust = "";
        if (isset($input["temperature"])) $temperature = $input["temperature"]; else  $temperature = "";
        if (isset($input["maxTemperature"])) $maxTemperature = $input["maxTemperature"]; else  $maxTemperature = "";
        if (isset($input["minTemperature"])) $minTemperature = $input["minTemperature"]; else  $minTemperature = "";
        if (isset($input["humidity"])) $humidity = $input["humidity"]; else  $humidity = "";

        if (isset($input["maxHumidity"])) $maxHumidity = $input["maxHumidity"]; else  $maxHumidity = "";
        if (isset($input["minHumidity"])) $minHumidity = $input["minHumidity"]; else  $minHumidity = "";
        if (isset($input["noise"])) $noise = $input["noise"]; else  $noise = "";
        if (isset($input["maxNoise"])) $maxNoise = $input["maxNoise"]; else  $maxNoise = "";
        if (isset($input["minNoise"])) $minNoise = $input["minNoise"]; else  $minNoise = "";

        if (isset($input["pressure"])) $pressure = $input["pressure"]; else  $pressure = "";
        if (isset($input["maxPressure"])) $maxPressure = $input["maxPressure"]; else  $maxPressure  = "";
        if (isset($input["minPressure"])) $minPressure = $input["minPressure"]; else  $minPressure = "";
        if (isset($input["rainfall"])) $rainfall = $input["rainfall"]; else  $rainfall = "";
        if (isset($input["maxRainfall"])) $maxRainfall = $input["maxRainfall"]; else  $maxRainfall = "";

        if (isset($input["minRainfall"])) $minRainfall = $input["minRainfall"]; else  $minRainfall = "";
        if (isset($input["windSpeed"])) $windSpeed = $input["windSpeed"]; else  $windSpeed = "";
        if (isset($input["windDirection"])) $windDirection = $input["windDirection"]; else  $windDirection = "";
        if (isset($input["dateTime"])) $dateTime = $input["dateTime"]; else  $dateTime = "";
        if (isset($input["dustFlag"])) $dustFlag = $input["dustFlag"]; else  $dustFlag = "";
        if (isset($input["humiFlag"])) $humiFlag = $input["humiFlag"]; else  $humiFlag = "";
        if (isset($input["noiseFlag"])) $noiseFlag = $input["noiseFlag"]; else  $noiseFlag = "";

        $xmlTpl = "<EmsData>
                    <devCode><![CDATA[%s]]></devCode>
                    <prjCode><![CDATA[%s]]></prjCode>
                    <prjType><![CDATA[%s]]></prjType>
                    <dust><![CDATA[%s]]></dust>
                    <maxDust><![CDATA[%s]]></maxDust>

                    <minDust><![CDATA[%s]]></minDust>
                    <temperature><![CDATA[%s]]></temperature>
                    <maxTemperature><![CDATA[%s]]></maxTemperature>
                    <minTemperature><![CDATA[%s]]></minTemperature>
                    <humidity><![CDATA[%s]]></humidity>

                    <maxHumidity><![CDATA[%s]]></maxHumidity>
                    <minHumidity><![CDATA[%s]]></minHumidity>
                    <noise><![CDATA[%s]]></noise>
                    <maxNoise><![CDATA[%s]]></maxNoise>
                    <minNoise><![CDATA[%s]]></minNoise>

                    <pressure><![CDATA[%s]]></pressure>
                    <maxPressure><![CDATA[%s]]></maxPressure>
                    <minPressure><![CDATA[%s]]></minPressure>
                    <rainfall><![CDATA[%s]]></rainfall>
                    <maxRainfall><![CDATA[%s]]></maxRainfall>

                    <minRainfall><![CDATA[%s]]></minRainfall>
                    <windSpeed><![CDATA[%s]]></windSpeed>
                    <windDirection><![CDATA[%s]]></windDirection>
                    <dateTime><![CDATA[%s]]></dateTime>
                    <dustFlag><![CDATA[%s]]></dustFlag>
                    <humiFlag><![CDATA[%s]]></humiFlag>
                    <noiseFlag><![CDATA[%s]]></noiseFlag>
                 </EmsData>";
        $result = sprintf($xmlTpl,$devCode,$prjCode,$prjType,$dust,$maxDust,$minDust,$temperature,$maxTemperature,$minTemperature,$humidity,$maxHumidity,$minHumidity,$noise,$maxNoise,$minNoise,$pressure,$maxPressure,$minPressure,$rainfall,$maxRainfall,$minRainfall,$windSpeed,$windDirection,$dateTime,$dustFlag,$humiFlag,$noiseFlag);
        return $result;

    }
    //4.EmsPrjType（工程类型）
    private function  func_wsdl_ycjk_EmsPrjType_encode($input)
    {

        //判断是否存在？
        if (isset($input["code"])) $code = $input["code"]; else  $code = "";
        if (isset($input["name"])) $name = $input["name"]; else  $name = "";

        $xmlTpl = "<EmsPrjType>
                   <code><![CDATA[%s]]></code>
                   <name><![CDATA[%s]]></name>
                  </EmsPrjType>";
        $result =sprintf($xmlTpl,$code,$name);
        return $result;
    }
    //5、EmsPrjCategory  (工程性质)
    private function  func_wsdl_ycjk_EmsPrjCategory_encode($input)
    {

        //判断是否存在？
        if (isset($input["code"])) $code = $input["code"]; else  $code = "";
        if (isset($input["name"])) $name = $input["name"]; else  $name = "";
        $xmlTpl = "<EmsPrjCategory>
                   <code><![CDATA[%s]]></code>
                   <name><![CDATA[%s]]></name>
                  </EmsPrjCategory>";
        $result =sprintf($xmlTpl,$code,$name);
        return $result;

    }
    //6、EmsPrjPeriod  工程工期
    private function  func_wsdl_ycjk_EmsPrjPeriod_encode($input)
    {
        //判断是否存在？
        if (isset($input["code"])) $code = $input["code"]; else  $code = "";
        if (isset($input["name"])) $name = $input["name"]; else  $name = "";
        $xmlTpl = "<EmsPrjPeriod>
                   <code><![CDATA[%s]]></code>
                   <name><![CDATA[%s]]></name>
                  </EmsPrjPeriod>";
        $result =sprintf($xmlTpl,$code,$name);
        return $result;

    }
    //7、EmsDistrict  区县信息
    private function  func_wsdl_ycjk_EmsDistrict_encode($input)
    {
        //判断是否存在？
        if (isset($input["code"])) $code = $input["code"]; else  $code = "";
        if (isset($input["name"])) $name = $input["name"]; else  $name = "";
        $xmlTpl = "<EmsDistrict>
                   <code><![CDATA[%s]]></code>
                   <name><![CDATA[%s]]></name>
                  </EmsDistrict>";
        $result =sprintf($xmlTpl,$code,$name);
        return $result;
    }
    //8、EmsRegion  区域信息
    private function  func_wsdl_ycjk_EmsRegion_encode($input)
    {
        //判断是否存在？
        if (isset($input["code"])) $code = $input["code"]; else  $code = "";
        if (isset($input["name"])) $name = $input["name"]; else  $name = "";
        $xmlTpl = "<EmsRegion>
                   <code><![CDATA[%s]]></code>
                   <name><![CDATA[%s]]></name>
                  </EmsRegion>";
        $result =sprintf($xmlTpl,$code,$name);
        return $result;

    }



    /**************************************************************************************
     *                               任务入口函数                                           *
     *************************************************************************************/
    //扬尘监控项目联通平台接口消息编码任务，实现对联通平台消息的WSDL格式编码，并通过Soapclient发送
    public function mfun_l2codec_wsdl_ycjk_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_AQYCCU;

        //判断入口消息是否为空
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project, "NULL", "NULL", "MFUN_TASK_ID_L2CODEC_WSDL_YCJK", $msgName, $log_content);
            return false;
        }
        //来自各L2SNR模块发给给HCU的HUITP消息
        if (($msgId != MSG_ID_L2CODEC_WSDL_YCJK_INCOMING) || ($msgName != "MSG_ID_L2CODEC_WSDL_YCJK_INCOMING")) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project, "NULL", "NULL", "MFUN_TASK_ID_L2CODEC_WSDL_YCJK", $msgName, $log_content);
            return false;
        } else { //解开消息
            if (isset($msg["project"])) $project = $msg["project"]; else  $project = "";
            if (isset($msg["devCode"])) $devCode = $msg["devCode"]; else  $devCode = "";
            if (isset($msg["respMsg"])) $huitpMsgId = intval($msg["respMsg"]); else  $huitpMsgId = 0;
            if (isset($msg["content"])) $content = $msg["content"]; else  $content = "";
        }


        if (!empty($respIeStr)) {


//            //通过建立tcp阻塞式socket连接，向HCU发送回复消息
//            $socketid = $dbiL1vmCommonObj->dbi_huitp_huc_socketid_inqery($devCode);
//            if ($socketid != 0) {
//                $client = new socket_client_sync($socketid, $devCode, $xmlMsgStr);
//                $client->connect();
//                //返回消息log
//                $log_content = "T:" . json_encode($respMsgStr);
//                $loggerObj->mylog($project, $devCode, "MFUN_TASK_ID_L2ENCODE_HUITP", "MFUN_TASK_VID_L1VM_SWOOLE", "MSG_VID_L2CODEC_ENCODE_HUITP_OUTPUT", $log_content);
//            } else {
//                $log_content = "E: Socket closed!";
//                $loggerObj->mylog($project, $devCode, "MFUN_TASK_ID_L2ENCODE_HUITP", "MFUN_TASK_VID_L1VM_SWOOLE", "MSG_VID_L2CODEC_ENCODE_HUITP_OUTPUT", $log_content);
//            }
        }
        //结束，返回
        return true;

    }//end of mfun_l2codec_wsdl_ycjk_task_main_entry

}
?>