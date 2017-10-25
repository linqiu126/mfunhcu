<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/17
 * Time: 23:49
 */
include_once "../l1comvm/vmlayer.php";

/**************************************************************************************
 *                             WECHAT / EMCWX TEST CASES                              *
 *************************************************************************************/
if (TC_EMCWX == true){
//EMCWX测试开始

    //HUITP pm Data, 增加树莓派CPU温度
    echo " [TC IOT_STDXML: HUITP pm Data START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQYC_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G201_AQYC_SH001]]></FromUserName><CreateTime>1496584441</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[B18100310003000101B1000028000000000000000000000000000000000000000100000005000000210000005600000036593410F9]]></Content><FuncFlag>0</FuncFlag></xml>";
    //require("../l1mainentry/cloud_callback_wechat.php");
    echo " [TC IOT_STDXML: HUITP pm Data END]\n";

    //HUITP sw inventory Data
    echo " [TC IOT_STDXML: HUITP sw inventory Data START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G201_AQYC_SH001]]></FromUserName><CreateTime>1492506331</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[A08100480003000101A000003F02010005000100C104000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000058F5D6DB]]></Content><FuncFlag>0</FuncFlag></xml>";
    //require("../l1mainentry/cloud_callback_wechat.php");
    echo " [TC IOT_STDXML: HUITP sw inventory Data END]\n";

    //HUITP Alarm Data
    echo " [TC IOT_STDXML: HUITP Alarm Data START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G201_AQYC_SH001]]></FromUserName><CreateTime>1491539699</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[B08100810003000101B0000078000300000000000100000000000000084843555F473230315F415159435F53483030315F686B32303137303430373132333400000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000058E716F3]]></Content><FuncFlag>0</FuncFlag></xml>";
    //require("../l1mainentry/cloud_callback_wechat.php");
    echo " [TC IOT_STDXML: HUITP Alarm Data END]\n";

    //HUITP Noise Data
    echo " [TC IOT_STDXML: HUITP Noise Data START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G201_AQYC_SH001]]></FromUserName><CreateTime>1504188646</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[2B81001200030001012B00000901000001F359A818E6]]></Content><FuncFlag>0</FuncFlag></xml>";
    //require("../l1mainentry/cloud_callback_wechat.php");
    echo " [TC IOT_STDXML: HUITP Noise Data END]\n";

    //HUITP Windspd Data
    echo " [TC IOT_STDXML: HUITP Windspd Data START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G201_AQYC_SH001]]></FromUserName><CreateTime>1504189207</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[26810012000300010126000009010000000059A81B17]]></Content><FuncFlag>0</FuncFlag></xml>";
    //require("../l1mainentry/cloud_callback_wechat.php");
    echo " [TC IOT_STDXML: HUITP Windspd Data END]\n";

    //HUITP Winddir Data
    echo " [TC IOT_STDXML: HUITP Winddir Data START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G201_AQYC_SH001]]></FromUserName><CreateTime>1504189208</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[27810012000300010127000009020000047659A81B18]]></Content><FuncFlag>0</FuncFlag></xml>";
    //require("../l1mainentry/cloud_callback_wechat.php");
    echo " [TC IOT_STDXML: HUITP Winddir Data END]\n";

    //HUITP Temp Data
    echo " [TC IOT_STDXML: HUITP Temperature Data START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G201_AQYC_SH001]]></FromUserName><CreateTime>1504189210</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[2881001200030001012800000901000000EE59A81B1A]]></Content><FuncFlag>0</FuncFlag></xml>";
    //require("../l1mainentry/cloud_callback_wechat.php");
    echo " [TC IOT_STDXML: HUITP Temperature Data END]\n";

    //HUITP Humidity Data
    echo " [TC IOT_STDXML: HUITP Humidity Data START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G201_AQYC_SH001]]></FromUserName><CreateTime>1504189208</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[29810012000300010129000009010000030D59A81B18]]></Content><FuncFlag>0</FuncFlag></xml>";
    //require("../l1mainentry/cloud_callback_wechat.php");
    echo " [TC IOT_STDXML: HUITP Humidity Data END]\n";

    //HUITP pm25 Data
    echo " [TC IOT_STDXML: HUITP pm25 Data START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G201_AQYC_SH001]]></FromUserName><CreateTime>1504188646</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[2581002C000300010125000009010000000059A818E625010009010000000059A818E625020009010000000059A818E6]]></Content><FuncFlag>0</FuncFlag></xml>";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[hcu_g201_aqyc_sh050]]></FromUserName><CreateTime>1504323120</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[2581002C000300010125000009000000003C59AA263025010009000000002159AA263025020009000000002659AA2630]]></Content><FuncFlag>0</FuncFlag></xml>";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_G201_AQYC_SH001]]></FromUserName><CreateTime>1504323120</CreateTime><MsgType><![CDATA[huitp_text]]></MsgType><Content><![CDATA[2581002C000300010125000009000000003C59AA263025010009000000002159AA263025020009000000002659AA2630]]></Content><FuncFlag>0</FuncFlag></xml>";

    require("../l1mainentry/cloud_callback_wechat.php");
    echo " [TC IOT_STDXML: HUITP pm25 Data END]\n";

    //original data
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_4667dc241921]]></ToUserName>
                                        <FromUserName><![CDATA[oMjZ7v_s-Y5R1fKTvBTzcMl9C65o]]></FromUserName>
                                        <CreateTime>1488459310</CreateTime>
                                        <MsgType><![CDATA[text]]></MsgType>
                                        <Content><![CDATA[120101002]]></Content>
                                        <MsgId>6392884058293815710</MsgId>
                                    </xml>";
    require("../l1mainentry/cloud_callback_wechat.php");

    //公众号关注事件
    echo " [TC EMCWX: WEIXIN “subscribe” EVENT START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_70c714952b02]]></ToUserName>
                                        <FromUserName><![CDATA[oS0Chv3Uum1TZqHaCEb06AoBfCvY]]></FromUserName>
                                        <CreateTime>1474206863</CreateTime>
                                        <MsgType><![CDATA[event]]></MsgType>
                                        <Event><![CDATA[subscribe]]></Event>
                                        <EventKey><![CDATA[]]></EventKey>
                                       </xml>";
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " \n[TC EMCWX: WEIXIN “subscribe” EVENT END]\n";

    //微信device_event，bind
    echo " [TC EMCWX: WEIXIN “bind” EVENT START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_70c714952b02]]></ToUserName>
                                        <FromUserName><![CDATA[oS0Chv3Uum1TZqHaCEb06AoBfCvY]]></FromUserName>
                                        <CreateTime>1472887993</CreateTime>
                                        <MsgType><![CDATA[device_event]]></MsgType>
                                        <Event><![CDATA[bind]]></Event>
                                        <DeviceType><![CDATA[gh_70c714952b02]]></DeviceType>
                                        <DeviceID><![CDATA[gh_70c714952b02_8cd47e1f6141e49a4e45f4b807cf41fe]]></DeviceID>
                                        <Content><![CDATA[]]></Content>
                                        <SessionID>0</SessionID>
                                        <OpenID><![CDATA[oS0Chv3Uum1TZqHaCEb06AoBfCvY]]></OpenID>
                                     </xml>";
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " \n[TC EMCWX: WEIXIN “bind” EVENT END]\n";

    //微信二维码扫码事件
    echo " [TC EMCWX: WEIXIN “scancode_push” EVENT START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_70c714952b02]]></ToUserName>
                                        <FromUserName><![CDATA[oS0Chv3Uum1TZqHaCEb06AoBfCvY]]></FromUserName>
                                        <CreateTime>1472912757</CreateTime>
                                        <MsgType><![CDATA[event]]></MsgType>
                                        <Event><![CDATA[scancode_push]]></Event>
                                        <EventKey><![CDATA[QR_SCAN]]></EventKey>
                                        <ScanCodeInfo><ScanType><![CDATA[qrcode]]></ScanType>
                                        <ScanResult><![CDATA[http://we.qq.com/d/AQBLQKG-27gIDCKf03DmiwAXh27qptK_scSJJRAn]]></ScanResult>
                                        </ScanCodeInfo>
                                     </xml>";
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " \n[TC EMCWX: WEIXIN “scancode_push” EVENT END]\n";

    //微信位置更新“LOCATION”事件
    echo " [TC EMCWX: WEIXIN “LOCATION” event START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_70c714952b02]]></ToUserName>
                                        <FromUserName><![CDATA[oS0Chv3Uum1TZqHaCEb06AoBfCvY]]></FromUserName>
                                        <CreateTime>1474206866</CreateTime>
                                        <MsgType><![CDATA[event]]></MsgType>
                                        <Event><![CDATA[LOCATION]]></Event>
                                        <Latitude>31.202703</Latitude>
                                        <Longitude>121.514626</Longitude>
                                        <Precision>30.000000</Precision>
                                      </xml>";
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " \n[TC EMCWX: WEIXIN “LOCATION” event END]\n";

    //微信VIEW事件
    echo " [TC EMCWX: WEIXIN “VIEW” event START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] ="<xml><ToUserName><![CDATA[gh_4667dc241921]]></ToUserName>
                                        <FromUserName><![CDATA[oMjZ7v_s-Y5R1fKTvBTzcMl9C65o]]></FromUserName>
                                        <CreateTime>1475241840</CreateTime>
                                        <MsgType><![CDATA[event]]></MsgType>
                                        <Event><![CDATA[VIEW]]></Event>
                                        <EventKey><![CDATA[https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf2150c4d2941b2ab&redirect_uri=http://www.hkrob.com/mfunhcu/l4emcwxui/index.html?response_type=code&scope=snsapi_base&state=1#wechat_redirect]]></EventKey>
                                        <MenuId>414775299</MenuId>
                                     </xml>";
    /*$GLOBALS["HTTP_RAW_POST_DATA"] ="<xml><ToUserName><![CDATA[gh_4667dc241921]]></ToUserName>
                                        <FromUserName><![CDATA[oMjZ7v_s-Y5R1fKTvBTzcMl9C65o]]></FromUserName>
                                        <CreateTime>1483163309</CreateTime>
                                        <MsgType><![CDATA[event]]></MsgType>
                                        <Event><![CDATA[VIEW]]></Event>
                                        <EventKey><![CDATA[https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf2150c4d2941b2ab&redirect_uri=http://www.hkrob.com/mfunhcu/l4fhyswechat/index.html?response_type=code&scope=snsapi_base&state=1#wechat_redirect]]></EventKey>
                                        <MenuId>416339768</MenuId>
                                        </xml>";*/
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " \n[TC EMCWX: WEIXIN “VIEW” event END]\n";

    //微信device_text消息
    echo " [TC EMCWX: EMC DEVICE_TEXT START]\n";
    //$content = base64_encode(pack("H*", "201000220650040302010102030405060708"));
    $content = base64_encode(pack("H*", "FECF0001000E208100030000036E"));  //EMC data
    $content = base64_encode(pack("H*", "FECF0001000D20850003000032"));  //Power status data

    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[IHU]]></ToUserName>
                                        <FromUserName><![CDATA[oS0Chv3Uum1TZqHaCEb06AoBfCvY]]></FromUserName>
                                        <DeviceID><![CDATA[gh_70c714952b02_8cd47e1f6141e49a4e45f4b807cf41fe]]></DeviceID>
                                        <CreateTime>1472739347</CreateTime>
                                        <MsgType><![CDATA[device_text]]></MsgType>
                                        <Content><![CDATA[" . $content . "]]></Content>
                                        <FuncFlag>0</FuncFlag>
                                      </xml>";

    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_70c714952b02]]></ToUserName>
                                        <FromUserName><![CDATA[oS0Chv3Uum1TZqHaCEb06AoBfCvY]]></FromUserName>
                                        <CreateTime>1474904683</CreateTime>
                                        <MsgType><![CDATA[device_text]]></MsgType>
                                        <DeviceType><![CDATA[gh_70c714952b02]]></DeviceType>
                                        <DeviceID><![CDATA[gh_70c714952b02_8cd47e1f6141e49a4e45f4b807cf41fe]]></DeviceID>
                                        <Content><![CDATA[/s8AAQAOIIEACwAAAAA=]]></Content>
                                        <SessionID>2150</SessionID>
                                        <MsgID>13430170338</MsgID>
                                        <OpenID><![CDATA[oS0Chv3Uum1TZqHaCEb06AoBfCvY]]></OpenID>
                                     </xml>";


    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_4667dc241921]]></ToUserName>
                                        <FromUserName><![CDATA[oMjZ7v_s-Y5R1fKTvBTzcMl9C65o]]></FromUserName>
                                        <CreateTime>1477844120</CreateTime>
                                        <MsgType><![CDATA[device_text]]></MsgType>
                                        <DeviceType><![CDATA[gh_4667dc241921]]></DeviceType>
                                        <DeviceID><![CDATA[gh_4667dc241921_e8c6e463debe1d01]]></DeviceID>
                                        <Content><![CDATA[/s8AAQAPIIEAEwAAIAAA]]></Content>
                                        <SessionID>2309</SessionID>
                                        <MsgID>14600315373</MsgID>
                                        <OpenID><![CDATA[oMjZ7v_s-Y5R1fKTvBTzcMl9C65o]]></OpenID>
                                     </xml>";
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " \n[TC EMCWX: EMC DEVICE_TEXT END]\n";

    //服务号菜单Click事件
    echo " [TC EMCWX: WEIXIN CLICK_COMPANY START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_70c714952b02]]></ToUserName>
                                        <FromUserName><![CDATA[oS0Chv3Uum1TZqHaCEb06AoBfCvY]]></FromUserName>
                                        <CreateTime>1470315946</CreateTime>
                                        <MsgType><![CDATA[event]]></MsgType>
                                        <Event><![CDATA[CLICK]]></Event>
                                        <EventKey><![CDATA[CLICK_XHZN_COMPANY]]></EventKey>
                                     </xml>";

    $GLOBALS["HTTP_RAW_POST_DATA"] =  "<xml><ToUserName><![CDATA[gh_0ab9a32c6381]]></ToUserName>
                <FromUserName><![CDATA[oVJPKv9WTvaWLD65LxLdyziL3Uuo]]></FromUserName>
                <CreateTime>1494079696</CreateTime>
                <MsgType><![CDATA[event]]></MsgType>
                <Event><![CDATA[CLICK]]></Event>
                <EventKey><![CDATA[CLICK_FHYS_WECHATKEY_UNBIND]]></EventKey>
                </xml>";

    require("../l1mainentry/cloud_callback_wechat.php");
    echo " \n[TC EMCWX: WEIXIN CLICK_COMPANY END]\n";
    //服务号菜单Click事件
    echo " [TC EMCWX: WEIXIN CLICK_BIND_INQ START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_70c714952b02]]></ToUserName>
                                        <FromUserName><![CDATA[oS0Chv3Uum1TZqHaCEb06AoBfCvY]]></FromUserName>
                                        <CreateTime>1472912904</CreateTime>
                                        <MsgType><![CDATA[event]]></MsgType>
                                        <Event><![CDATA[CLICK]]></Event>
                                        <EventKey><![CDATA[CLICK_TEST_BIND_INQ]]></EventKey>
                                      </xml>";
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " \n[TC EMCWX: WEIXIN CLICK_BIND_INQ END]\n";

    echo " [TC EMCWX: WEIXIN CLICK_XHZN_UNBIND START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_4667dc241921]]></ToUserName>
                                        <FromUserName><![CDATA[oMjZ7v_s-Y5R1fKTvBTzcMl9C65o]]></FromUserName>
                                        <CreateTime>1477834174</CreateTime>
                                        <MsgType><![CDATA[event]]></MsgType>
                                        <Event><![CDATA[CLICK]]></Event>
                                        <EventKey><![CDATA[CLICK_XHZN_UNBIND]]></EventKey>
                                      </xml>";
    //require("../l1mainentry/cloud_callback_wechat.php");
    echo " \n[TC EMCWX: WEIXIN CLICK_XHZN_UNBIND END]\n";

    echo " [TC FHYSWECHAT: WEIXIN CLICK_FHYS_WECHATKEY_UNBIND START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_0ab9a32c6381]]></ToUserName>
                                        <FromUserName><![CDATA[oVJPKv9WTvaWLD65LxLdyziL3Uuo]]></FromUserName>
                                        <CreateTime>1508899880</CreateTime>
                                        <MsgType><![CDATA[event]]></MsgType>
                                        <Event><![CDATA[CLICK]]></Event>
                                        <EventKey><![CDATA[CLICK_FHYS_WECHATKEY_UNBIND]]></EventKey>
                                        </xml>";
    //require("../l1mainentry/cloud_callback_wechat.php");
    echo " \n[TC FHYSWECHAT: WEIXIN CLICK_FHYS_WECHATKEY_UNBIND END]\n";

    echo " [TC EMCWX: WEIXIN CLICK_EMC_INSTANT_READ START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_70c714952b02]]></ToUserName>
                                        <FromUserName><![CDATA[oS0Chv-avCH7W4ubqOQAFXojYODY]]></FromUserName>
                                        <CreateTime>1470315946</CreateTime>
                                        <MsgType><![CDATA[event]]></MsgType>
                                        <Event><![CDATA[CLICK]]></Event>
                                        <EventKey><![CDATA[CLICK_EMC_INSTANT_READ]]></EventKey>
                                      </xml>";

    //小马的openid，数据库查找有问题
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_70c714952b02]]></ToUserName>
                                        <FromUserName><![CDATA[oS0Chv0aebwN8O3-7v0hNAX7gy4c]]></FromUserName>
                                        <CreateTime>1475388353</CreateTime>
                                        <MsgType><![CDATA[event]]></MsgType>
                                        <Event><![CDATA[CLICK]]></Event>
                                        <EventKey><![CDATA[CLICK_EMC_INSTANT_READ]]></EventKey>
                                        </xml>";
    //WY的openid
    /*
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_70c714952b02]]></ToUserName>
                                        <FromUserName><![CDATA[oS0ChvzjHVx4urkipzc0EehuwQYE]]></FromUserName>
                                        <CreateTime>1475388353</CreateTime>
                                        <MsgType><![CDATA[event]]></MsgType>
                                        <Event><![CDATA[CLICK]]></Event>
                                        <EventKey><![CDATA[CLICK_EMC_INSTANT_READ]]></EventKey>
                                        </xml>";
    */
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " \n[TC EMCWX: WEIXIN CLICK_EMC_INSTANT_READ END]\n";

    echo " [TC EMCWX: WEIXIN CLICK_EMC_PERIOD_READ_OPEN START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_70c714952b02]]></ToUserName>
                                        <FromUserName><![CDATA[oS0Chv-avCH7W4ubqOQAFXojYODY]]></FromUserName>
                                        <CreateTime>1470315946</CreateTime>
                                        <MsgType><![CDATA[event]]></MsgType>
                                        <Event><![CDATA[CLICK]]></Event>
                                        <EventKey><![CDATA[CLICK_EMC_PERIOD_READ_OPEN]]></EventKey>
                                      </xml>";
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " \n[TC EMCWX: WEIXIN CLICK_EMC_PERIOD_READ_OPEN END]\n";

    echo " [TC EMCWX: WEIXIN CLICK_EMC_PERIOD_READ_CLOSE START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_70c714952b02]]></ToUserName>
                                        <FromUserName><![CDATA[oS0Chv-avCH7W4ubqOQAFXojYODY]]></FromUserName>
                                        <CreateTime>1470315946</CreateTime>
                                        <MsgType><![CDATA[event]]></MsgType>
                                        <Event><![CDATA[CLICK]]></Event>
                                        <EventKey><![CDATA[CLICK_EMC_PERIOD_READ_CLOSE]]></EventKey>
                                      </xml>";
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " \n[TC EMCWX: WEIXIN CLICK_EMC_PERIOD_READ_CLOSE END]\n";

    //EMC H5界面测试case
    echo " [TC L4EMCWX: wechat_login START]\n";
    $_GET["action"] = "wechat_login";
    $_GET["code"] = "001MGo242OUNvI0Vq55426Ol242MGo2e";
    require("../l4emcwxui/request.php");
    echo " \n[TC L4EMCWX: wechat_login END]\n";

    echo " [TC L4EMCWX: personal_bracelet_radiation_current START]\n";
    $_GET["action"] = "personal_bracelet_radiation_current";
    $_GET["id"] = "oMjZ7v_s-Y5R1fKTvBTzcMl9C65o";
    require("../l4emcwxui/request.php");
    echo " \n[TC L4EMCWX: personal_bracelet_radiation_current END]\n";

    echo " [TC L4EMCWX: personal_bracelet_radiation_alarm START]\n";
    $_GET["action"] = "personal_bracelet_radiation_alarm";
    $_GET["id"] = "oS0Chv3Uum1TZqHaCEb06AoBfCvY";
    require("../l4emcwxui/request.php");
    echo " \n[TC L4EMCWX: personal_bracelet_radiation_alarm END]\n";

    echo " [TC L4EMCWX: personal_bracelet_radiation_history START]\n";
    $_GET["action"] = "personal_bracelet_radiation_history";
    $_GET["id"] = "oS0Chv3Uum1TZqHaCEb06AoBfCvY";
    require("../l4emcwxui/request.php");
    echo " \n[TC L4EMCWX: personal_bracelet_radiation_history END]\n";

    echo " [TC L4EMCWX: personal_bracelet_radiation_track START]\n";
    $_GET["action"] = "personal_bracelet_radiation_track";
    $_GET["id"] = "oS0Chv3Uum1TZqHaCEb06AoBfCvY";
    require("../l4emcwxui/request.php");
    echo " \n[TC L4EMCWX: personal_bracelet_radiation_track END]\n";


    $l2sdkIotWxObj = new classTaskL2sdkIotWx();
    //微信公众号通知
    $wx_touser = "oMjZ7v_s-Y5R1fKTvBTzcMl9C65o";
    $currenttime = date("Y-m-d H:i:s",$timestamp);
    $template = array('touser' => $wx_touser,
        'template_id' => "SAoMGA7GYeavgwpOImgWDs5BaoDMKIT5luASeZ671XM",
        "topcolor" => "#FF0000",
        'data' => array('first' => array('value' => ("您好，光交箱智能管理平台告警通知!"), 'color' => "#743A3A"),
            'keyword1' => array('value' => ("益阳光交箱测试点"), 'color' => "#0000FF"),
            'keyword2' => array('value' => ("烟雾告警"), 'color' => "#FF0000"),
            'keyword3' => array('value' => ($currenttime), 'color' => "#0000FF"),
            'keyword4' => array('value' => ("刘工"), 'color' => "#0000FF"),
            'keyword5' => array('value' => ("13917334681"), 'color' => "#0000FF"),
            'remark' => array('value' => ("请及时联系相关人员处理该告警"), 'color' => "#0000FF")
        )
    );
    $data = json_encode($template);
    $resp = $l2sdkIotWxObj->send_template_message(($data));

//EMCWX测试结束
}


?>