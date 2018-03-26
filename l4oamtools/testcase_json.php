<?php

include_once "../l1comvm/vmlayer.php";
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/23
 * Time: 10:31
 */
if (TC_EARTH_QUAKE_JSON == true) {

//    {
//        “ToUsr”:”XHZN”,
//	“FrUsr”:”IHU_LHEQ10060_RND01”,
//	“CrTim”:4335667,
//	“MsgTp”:"huitp-json",
//	“MsgId”:23681,  //0x5C81
//	“MsgLn”:115,
//	“IeCnt”:
//	{
//        “num”: 5,  //该值根据实际发送数据长度修改
//		“xData”: [2.45, 2.45, 2.45, 2.45, 2.45],
//		“yData”: [3.69, 3.69, 3.69, 3.69, 3.69],
//		“zData”: [6.88, 6.88, 6.88, 6.88, 6.88]
//	},
//	“FnFlg”:0
//}
    $obj = new classTaskL1vmCoreRouter();
//    $json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
//    $json = json_decode('{"a":1,"b":2,"c":3,"d":4,"e":5}');
//    $json = $json;
/*
       "IeCnt":{
            "num":5,
            "xData":[2.45, 2.45, 2.45, 2.45, 2.45],
            "yData":[3.69, 3.69, 3.69, 3.69, 3.69],
            "zData":[6.88, 6.88, 6.88, 6.88, 6.88],
        },*/
    $json = '{
        "ToUsr":"XHZN",
        "FrUsr":"IHU_LHEQ10060_RND01",
        "CrTim":4335667,
        "MsgTp":"huitp",
        "MsgId":23681,
        "MsgLn":"115",
        "IeCnt":{
            "num":5,
            "xData":[2.45, 1.45, 3.45, 4.45, 5.45],
            "yData":[3.69, 1.69, 3.69, 4.69, 5.69],
            "zData":[6.88, 1.88, 3.88, 4.88, 5.88]
        },
        "FnFlg":0
    }';
//    $json = json_decode($json);
    $msg = array("socketid" => 1, "data"=>$json);
//    $msg = json_encode($msg);

    $obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_IOT_JSON, MSG_ID_L2SDK_JSON_DATA_INCOMING, "MSG_ID_L2SDK_JSON_DATA_INCOMING", $msg);
}

elseif(TC_GTJY_SPECIAL_JSON == true){
    $json =  "{\"restTag\": \"special\", \"actionId\": 20482, \"parFlag\": 1, \"parContent\": {\"returnStringCode\": {\"剩余量\":0.0,\"GPRS累计充值量\":0.0,\"阀门状态\":\"开阀\",\"单价\":0.48,\"累积量\":0.0,\"负计数\":2304.0,\"rtn\":\"9000\",\"最后一次充值量\":0.0,\"启动日期\":\"05-06\",\"信号强度\":0,\"表类型\":\"A8\",\"累计金额\":0.0,\"表内运行状态\":\" \",\"表内时间\":\"912-1-1 126:23:11\",\"IC卡最后一次充值量\":0.0,\"表号\":\"04140318\"}}}";

    $obj = new classTaskL2codecPrivateGtjy();

    $resp = $obj->func_private_gtjy_json_process($json);


    $msg = array("socketid" => 1, "data"=>$json);
//    $obj = new classTaskL1vmCoreRouter();
//    $obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_GTJY_NBIOT, MSG_ID_L2SDK_GTJY_NBIOT_DATA_INCOMING, "MSG_ID_L2SDK_GTJY_NBIOT_DATA_INCOMING", $msg);

}

?>