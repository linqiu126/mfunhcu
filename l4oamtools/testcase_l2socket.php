<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/8/27
 * Time: 11:25
 */

include_once "../l1comvm/vmlayer.php";

/**************************************************************************************
 *                             SOCKET TEST CASES                              *
 *************************************************************************************/
if (TC_SOCKET == true) {
//SOCKET测试开始
    echo " [TC SOCKET: xxx START]\n";

    /*********************图片数据，消息来自9501端口*********************/
    $data = "4843555F473530325F464859535F50303030315F303132333435363738395F5F000000024040";

    $msg = array("socketid" => 1, "data"=>$data);
    $obj = new classTaskL1vmCoreRouter();
    //$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_SOCKET_LISTEN, MSG_ID_L2SOCKET_LISTEN_DATA_COMING, "MSG_ID_L2SOCKET_LISTEN_DATA_COMING", $msg);

    /*******************老的云控制锁项目，消息来自9501端口****************/
    //状态报告
    $data ="<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[4C1001010101010018291A00520001000000]]></Content><FuncFlag>0</FuncFlag></xml>";
    //开锁请求
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[4B0A00000000a0934765c0dd]]></Content><FuncFlag>0</FuncFlag></xml>";
    //图片数据
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_pic]]></MsgType><Content><![CDATA[FF8CA59C848C7B8C838383838C9C9483838383949C948CA49C8C837373737373738CAD9C736B737B7B52628CBDA48C736B6B736B7394AD7B7373738C7373A5A4737B6B6B395A94946B625A5A5A7394738483838C9C8C84848C847B847B838CA58C838C9C9C7B9C9C8483A58373736B6B946B6B94B58C6B8C6B6B6A526A94A58C6B6B6B6B846B73A59C6B6B736B6B6B84A4836B6B63295A73948C5A5262525284848484838C8CA58C8C8C8C7B7B7B837B949C8C9C83949C8C847B7BA5A5837B84736B6B6B739CA4836B737373629462A5B57B6B6B7B6B6B6B8CAD8C6B6B6B6B6B7B8CAD736B626B6262849C6B7352524A8484848C7B7B849CA58C848C8C847B83838C9C8C8CA494848473737B84AD9C83836B6B6B6B737BADB57B7373846B4A5A6BADA48C6B6B6B6B6B738CAD736B6B6B7B6B73A59C6B7B295A5A63948352415284848C7B525283848C949C8C8C8C8C848CA49483A49C84837373737B83839CB594837B6B7394737384BDA473836B526B526284A58C6B6B6B6B8C6B73AD9C6B836B6B63638C947B316262627B7B9C6252A58C836B527B83848C848CA5949494949C9C839CA48C848C7B737B7B83948484A5B58C8494736B736B7394A594636B736B638C6294B57B6B736B6B6B6B8CA5836B6B6B636B7B949C626262635A5A948C]]></Content><FuncFlag>01</FuncFlag></xml>";

    $msg = array("socketid" => 1, "data"=>$data);
    $obj = new classTaskL1vmCoreRouter();
    //$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_IOT_STDXML, MSG_ID_L2SDK_HCU_DATA_COMING, "MSG_ID_L2SDK_HCU_DATA_COMING", $msg);

    /********************HUITP消息，来自9511端口************************/

    //4E81,HUITP_MSGID_uni_ccl_state_report
    $data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1485035971</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[4E81006800030001014D0000060404010101014100000604040101010148000001024B000001024600000102470000010245000001024900000303FFFF4A00000303FFFF450100030300234E00000303FB5D4E01000303DFD84400000303E0C04E02000303C68B4E03000102]]></Content><FuncFlag>0</FuncFlag></xml>";

    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1485033688</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[4D90003400010001014D01002B01000000000000000000000000000000000000000000000000000000000000000000000000000000000000]]></Content><FuncFlag>0</FuncFlag></xml>";
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1485033674</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[4D90003400010001014D01002B0206F4F5DB759CEF0000000000000000000000000000000000000000000000000000000000000000000000]]></Content><FuncFlag>0</FuncFlag></xml>";
    $data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1485033714</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[4E81006800030001014D0000060404020202024D00000604040202020248000001024B0000010146000001014700000101450000010149000003030BB84A0000030311CC450100030100294E00000303C02C4E010003033B4B440000030100104E0200030377824E03000102]]></Content><FuncFlag>0</FuncFlag></xml>";
    //HUITP_MSGID_uni_noise_data_report
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1490757257</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[2B81000E00030001012B00000502000001B2]]></Content><FuncFlag>0</FuncFlag></xml>";

    //B181, HUITP_MSGID_uni_performance_info_report
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1502853593</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[B18100310003000101B10000280000000000000000000000000000000000000000000000000000001700000059000000005993B9D9]]></Content><FuncFlag>0</FuncFlag></xml>";

    //FE81, HUITP_MSGID_uni_heart_beat_report
    $data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1502966475</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[FE81000B0003000101FE000002CA29]]></Content><FuncFlag>0</FuncFlag></xml>";

    //A081, HUITP_MSGID_uni_inventory_report
    //$data = " <xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1502891284</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[A08100250003000101A000001C08010006000300F00001000000000000000000000000040159944D14]]></Content><FuncFlag>0</FuncFlag></xml>";

    //A181, HUITP_MSGID_uni_sw_package_report
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1502970733</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[A181001900030001010032001008010006000300FA040100016F560082]]></Content><FuncFlag>0</FuncFlag></xml>";

    $msg = array("socketid" => 1, "data"=>$data);
    $obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_IOT_HUITP, MSG_ID_L2SDK_HUITP_DATA_COMING, "MSG_ID_L2SDK_HUITP_DATA_COMING", $msg);


    $data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0301]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[400182]]></Content><FuncFlag>0</FuncFlag></xml>";
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0301]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[4A028101]]></Content><FuncFlag>XXX</FuncFlag></xml>";

    //FHYS Temperature
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0302]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[4903820C00]]></Content><FuncFlag>0</FuncFlag></xml>";
    //FHYS Humidity
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0302]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[4A03821700]]></Content><FuncFlag>0</FuncFlag></xml>";
    //FHYS 异常消息，多条XML消息粘连
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0302]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[400182]]></Content><FuncFlag>0</FuncFlag></xml><xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0302]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[4903821000]]></Content><FuncFlag>0</FuncFlag></xml>";

    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0499]]></FromUserName><CreateTime>1480759074</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[3B32810C000002890000028A0000028B0000028C0000028D0000028E0000028F0000029000000291000002920000029300000294]]></Content><FuncFlag>0</FuncFlag></xml>";
    //hcu_alarm
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1484654902</CreateTime><MsgType><![CDATA[hcu_alarm]]></MsgType><Content><![CDATA[B00C8101010100010101587E0936]]></Content><FuncFlag>0</FuncFlag></xml>";

    //RFID开锁请求
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[400183]]></Content><FuncFlag>00000001</FuncFlag></xml>";
    //BLE开锁请求
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[400184]]></Content><FuncFlag>587f66dd2b0</FuncFlag></xml>";
    //用户名开锁请求
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0001]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[400182]]></Content><FuncFlag>0</FuncFlag></xml>";
    //图片数据
    //$pic = "FF8CA59C848C7B8C838383838C9C9483838383949C948CA49C8C837373737373738CAD9C736B737B7B52628CBDA48C736B6B736B7394AD7B7373738C7373A5A4737B6B6B395A94946B625A5A5A7394738483838C9C8C84848C847B847B838CA58C838C9C9C7B9C9C8483A58373736B6B946B6B94B58C6B8C6B6B6A526A94A58C6B6B6B6B846B73A59C6B6B736B6B6B84A4836B6B63295A73948C5A5262525284848484838C8CA58C8C8C8C7B7B7B837B949C8C9C83949C8C847B7BA5A5837B84736B6B6B739CA4836B737373629462A5B57B6B6B7B6B6B6B8CAD8C6B6B6B6B6B7B8CAD736B626B6262849C6B7352524A8484848C7B7B849CA58C848C8C847B83838C9C8C8CA494848473737B84AD9C83836B6B6B6B737BADB57B7373846B4A5A6BADA48C6B6B6B6B6B738CAD736B6B6B7B6B73A59C6B7B295A5A63948352415284848C7B525283848C949C8C8C8C8C848CA49483A49C84837373737B83839CB594837B6B7394737384BDA473836B526B526284A58C6B6B6B6B8C6B73AD9C6B836B6B63638C947B316262627B7B9C6252A58C836B527B83848C848CA5949494949C9C839CA48C848C7B737B7B83948484A5B58C8494736B736B7394A594636B736B638C6294B57B6B736B6B6B6B8CA5836B6B6B636B7B949C626262635A5A948C";
    //$picdata = base64_encode(pack('H*',$pic));
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G502_FHYS_P0003]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_pic]]></MsgType><Content><![CDATA[$picdata]]></Content><FuncFlag>02</FuncFlag></xml>";


    if (MFUN_CLOUD_HCU == "AQ_HCU") {
        require("../l1mainentry/cloud_callback_socket_listening.php");
    }
    echo " [TC SOCKET: xxx END]\n";

//SOCKET测试结束
}