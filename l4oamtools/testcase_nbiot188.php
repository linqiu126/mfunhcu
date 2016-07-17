<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/17
 * Time: 23:44
 */
include_once "../l1comvm/vmlayer.php";

/**************************************************************************************
 *                             NBIOT IPM/IWM/IGM/IHM @CJ188 TEST CASES                              *
 *************************************************************************************/
if (TC_NBIOT_CJ188_UL == true){
    //TEST CASE: NBIOT IWM/IPM/IGM/IHM@CJ188: START

    echo " [TC UL READ_DATA返回错误帧 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "681011223344556677C1030111223416";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL READ_DATA返回错误帧 END]\n";

    echo " [TC UL IWM: READ DATA - 读计量数据 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778116901F01132333432C142434442C201607150959591122A416";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: READ DATA - 读计量数据 END]\n";

    echo " [TC UL IGM: READ DATA - 读计量数据 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778116901F01132333432C142434442C201607150959591122A416";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: READ DATA - 读计量数据 END]\n";

    echo " [TC UL IPM: READ DATA - 读计量数据 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778116901F01132333432C142434442C201607150959591122A416";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: READ DATA - 读计量数据 END]\n";

    echo " [TC UL IHM: READ DATA - 读计量数据 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "682011223344556677812E901F01132333432C142434442C152535452C162636462C172737472C182838192939102030201607150959591122A316";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: READ DATA - 读计量数据 END]\n";

    echo " [TC UL IWM: READ DATA - 读历史数据1 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778108D12001132333432CCA16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: READ DATA - 读历史数据1 END]\n";

    echo " [TC UL IHM: READ DATA - 读历史数据7 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778108D12601132333432CD016";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: READ DATA - 读历史数据7 END]\n";

    echo " [TC UL IGM: READ DATA - 读历史数据9 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778108D12801132333432CD216";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: READ DATA - 读历史数据9 END]\n";

    echo " [TC UL IPM: READ DATA - 读历史数据12 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778108D12B01132333432CD516";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: READ DATA - 读历史数据12 END]\n";

    echo " [TC UL IWM: READ DATA - 读价格信息 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778112810201122232132333142434152535162636A016";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: READ DATA - 读价格信息 END]\n";

    echo " [TC UL IHM: READ DATA - 读价格信息 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778112810201122232132333142434152535162636A016";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: READ DATA - 读价格信息 END]\n";

    echo " [TC UL IGM: READ DATA - 读价格信息 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778112810201122232132333142434152535162636A016";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: READ DATA - 读价格信息 END]\n";

    echo " [TC UL IPM: READ DATA - 读价格信息 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778112810201122232132333142434152535162636A016";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: READ DATA - 读价格信息 END]\n";

    echo " [TC UL IHM: READ DATA - 读结算日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778104810401119716";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: READ DATA - 读结算日 END]\n";

    echo " [TC UL IWM: READ DATA - 读抄表日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778104810301119616";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: READ DATA - 读抄表日 END]\n";

    echo " [TC UL IGM: READ DATA - 读购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "68301122334455667781128105013311213141122232421323334333442916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: READ DATA - 读购入金额 END]\n";

    echo " [TC UL IWM: READ DATA - 读购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "68101122334455667781128105013311213141122232421323334333442916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: READ DATA - 读购入金额 END]\n";

    echo " [TC UL IHM: READ DATA - 读购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "68201122334455667781128105013311213141122232421323334333442916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: READ DATA - 读购入金额 END]\n";

    echo " [TC UL IPM: READ DATA - 读购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "68401122334455667781128105013311213141122232421323334333442916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: READ DATA - 读购入金额 END]\n";

    echo " [TC UL IPM: READ DATA - 读秘钥版本号 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778904810601119916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: READ DATA - 读秘钥版本号 END]\n";

    echo " [TC UL IWM: READ DATA - 读秘钥版本号 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778904810601119916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: READ DATA - 读秘钥版本号 END]\n";

    echo " [TC UL IHM: READ DATA - 读秘钥版本号 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778904810601119916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: READ DATA - 读秘钥版本号 END]\n";

    echo " [TC UL IGM: READ DATA - 读秘钥版本号 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778904810601119916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: READ DATA - 读秘钥版本号 END]\n";

    echo " [TC UL IWM: READ DATA - 读地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778303810A018C16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: READ DATA - 读地址 END]\n";

    echo " [TC UL IHM: READ DATA - 读地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778303810A018C16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: READ DATA - 读地址 END]\n";

    echo " [TC UL IGM: READ DATA - 读地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778303810A018C16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: READ DATA - 读地址 END]\n";

    echo " [TC UL IPM: READ DATA - 读地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778303810A018C16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: READ DATA - 读地址 END]\n";

    echo " [TC UL IWM: WRITE DATA CONFIRM - 写价格表 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778405A010011122E416";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: WRITE DATA CONFIRM - 写价格表 END]\n";

    echo " [TC UL IHM: WRITE DATA CONFIRM - 写价格表 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778405A010011122E416";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: WRITE DATA CONFIRM - 写价格表 END]\n";

    echo " [TC UL IGM: WRITE DATA CONFIRM - 写价格表 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778405A010011122E416";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: WRITE DATA CONFIRM - 写价格表 END]\n";

    echo " [TC UL IPM: WRITE DATA CONFIRM - 写价格表 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778405A010011122E416";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: WRITE DATA CONFIRM - 写价格表 END]\n";

    echo " [TC UL IWM: WRITE DATA CONFIRM - 写结算表 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778403A01101B216";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: WRITE DATA CONFIRM - 写结算表 END]\n";

    echo " [TC UL IHM: WRITE DATA CONFIRM - 写结算表 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778403A01101B216";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: WRITE DATA CONFIRM - 写结算表 END]\n";

    echo " [TC UL IGM: WRITE DATA CONFIRM - 写结算表 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778403A01101B216";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: WRITE DATA CONFIRM - 写结算表 END]\n";

    echo " [TC UL IPM: WRITE DATA CONFIRM - 写结算表 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778403A01101B216";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: WRITE DATA CONFIRM - 写结算表 END]\n";

    echo " [TC UL IWM: WRITE DATA CONFIRM - 写抄表日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778403A01201B316";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: WRITE DATA CONFIRM - 写抄表日 END]\n";

    echo " [TC UL IHM: WRITE DATA CONFIRM - 写抄表日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778403A01201B316";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: WRITE DATA CONFIRM - 写抄表日 END]\n";

    echo " [TC UL IGM: WRITE DATA CONFIRM - 写抄表日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778403A01201B316";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: WRITE DATA CONFIRM - 写抄表日 END]\n";

    echo " [TC UL IPM: WRITE DATA CONFIRM - 写抄表日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778403A01201B316";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: WRITE DATA CONFIRM - 写抄表日 END]\n";

    echo " [TC UL IWM: WRITE DATA CONFIRM - 写购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778408A013011122334455B316";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: WRITE DATA CONFIRM - 写购入金额 END]\n";

    echo " [TC UL IHM: WRITE DATA CONFIRM - 写购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778408A013011122334455B316";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: WRITE DATA CONFIRM - 写购入金额 END]\n";

    echo " [TC UL IGM: WRITE DATA CONFIRM - 写购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778408A013011122334455B316";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: WRITE DATA CONFIRM - 写购入金额 END]\n";

    echo " [TC UL IPM: WRITE DATA CONFIRM - 写购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778408A013011122334455B316";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: WRITE DATA CONFIRM - 写购入金额 END]\n";

    echo " [TC UL IWM: WRITE DATA CONFIRM - 写新秘钥 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778404A0140111C616";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: WRITE DATA CONFIRM - 写新秘钥 END]\n";

    echo " [TC UL IHM: WRITE DATA CONFIRM - 写新秘钥 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778404A0140111C616";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: WRITE DATA CONFIRM - 写新秘钥 END]\n";

    echo " [TC UL IGM: WRITE DATA CONFIRM - 写新秘钥 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778404A0140111C616";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: WRITE DATA CONFIRM - 写新秘钥 END]\n";

    echo " [TC UL IPM: WRITE DATA CONFIRM - 写新秘钥 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778404A0140111C616";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: WRITE DATA CONFIRM - 写新秘钥 END]\n";

    echo " [TC UL IWM: WRITE DATA CONFIRM - 写标准时间 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778403A01501B616";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: WRITE DATA CONFIRM - 写标准时间 END]\n";

    echo " [TC UL IHM: WRITE DATA CONFIRM - 写标准时间 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778403A01501B616";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: WRITE DATA CONFIRM - 写标准时间 END]\n";

    echo " [TC UL IGM: WRITE DATA CONFIRM - 写标准时间 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778403A01501B616";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: WRITE DATA CONFIRM - 写标准时间 END]\n";

    echo " [TC UL IPM: WRITE DATA CONFIRM - 写标准时间 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778403A01501B616";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: WRITE DATA CONFIRM - 写标准时间 END]\n";

    echo " [TC UL IWM: WRITE DATA CONFIRM - 写阀门控制 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778405A017011122EB16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: WRITE DATA CONFIRM - 写阀门控制 END]\n";

    echo " [TC UL IHM: WRITE DATA CONFIRM - 写阀门控制 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778405A017011122EB16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: WRITE DATA CONFIRM - 写阀门控制 END]\n";

    echo " [TC UL IGM: WRITE DATA CONFIRM - 写阀门控制 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778405A017011122EB16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: WRITE DATA CONFIRM - 写阀门控制 END]\n";

    echo " [TC UL IPM: WRITE DATA CONFIRM - 写阀门控制 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778405A017011122EB16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: WRITE DATA CONFIRM - 写阀门控制 END]\n";

    echo " [TC UL IWM: WRITE DATA CONFIRM - 写出厂启动 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778403A01901BA16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: WRITE DATA CONFIRM - 写出厂启动 END]\n";

    echo " [TC UL IHM: WRITE DATA CONFIRM - 写出厂启动 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778403A01901BA16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: WRITE DATA CONFIRM - 写出厂启动 END]\n";

    echo " [TC UL IGM: WRITE DATA CONFIRM - 写出厂启动 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778403A01901BA16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: WRITE DATA CONFIRM - 写出厂启动 END]\n";

    echo " [TC UL IPM: WRITE DATA CONFIRM - 写出厂启动 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778403A01901BA16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: WRITE DATA CONFIRM - 写出厂启动 END]\n";

    echo " [TC UL IWM: WRITE ADDR CONFIRM - 写地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566779503A01801B916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: WRITE ADDR CONFIRM - 写地址 END]\n";

    echo " [TC UL IHM: WRITE ADDR CONFIRM - 写地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566779503A01801B916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: WRITE ADDR CONFIRM - 写地址 END]\n";

    echo " [TC UL IGM: WRITE ADDR CONFIRM - 写地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566779503A01801B916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: WRITE ADDR CONFIRM - 写地址 END]\n";

    echo " [TC UL IPM: WRITE ADDR CONFIRM - 写地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566779503A01801B916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: WRITE ADDR CONFIRM - 写地址 END]\n";

    echo " [TC UL IWM: WRITE ADDR CONFIRM - 写机电数据同步 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566779605A016011122EA16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IWM: WRITE ADDR CONFIRM - 写机电数据同步 END]\n";

    echo " [TC UL IHM: WRITE ADDR CONFIRM - 写机电数据同步 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566779605A016011122EA16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IHM: WRITE ADDR CONFIRM - 写机电数据同步 END]\n";

    echo " [TC UL IGM: WRITE ADDR CONFIRM - 写机电数据同步 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566779605A016011122EA16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IGM: WRITE ADDR CONFIRM - 写机电数据同步 END]\n";

    echo " [TC UL IPM: WRITE ADDR CONFIRM - 写机电数据同步 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566779605A016011122EA16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC UL IPM: WRITE ADDR CONFIRM - 写机电数据同步 END]\n";

//TEST CASE: NBIOT IWM/IPM/IGM/IHM@CJ188: END
}

if (TC_NBIOT_CJ188_DL == true){
    //TEST CASE: NBIOT IWM/IPM/IGM/IHM@CJ188: START

    echo " [TC DL IWM: WRITE DATA - 写结算日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_write_bill_date";
    $_GET["len"] = 0x4;
    $_GET["type"] = 0x10;
    $_GET["billdate"] = 14;
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: WRITE DATA - 写结算日 END]\n";

    echo " [TC DL IPM: READ DATA - 读取计量器 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ipm_read_cur_cnt_data";
    $_GET["len"] = 3;
    $_GET["type"] = 0x40;
    require("../l1mainentry/h5ui_entry_nbiot_ipm.php");
    echo " [TC DL IPM: READ DATA - 读取计量器 END]\n";

    echo " [TC DL IWM: READ DATA - 读取计量器 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_read_cur_cnt_data";
    $_GET["len"] = 3;
    $_GET["type"] = 0x10;
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: READ DATA - 读取计量器 END]\n";

    echo " [TC DL IHM: READ DATA - 读取计量器 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_read_cur_cnt_data";
    $_GET["len"] = 3;
    $_GET["type"] = 0x20;
    require("../l1mainentry/h5ui_entry_nbiot_ihm.php");
    echo " [TC DL IHM: READ DATA - 读取计量器 END]\n";

    echo " [TC DL IGM: READ DATA - 读取计量器 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "igm_read_cur_cnt_data";
    $_GET["len"] = 3;
    $_GET["type"] = 0x30;
    require("../l1mainentry/h5ui_entry_nbiot_igm.php");
    echo " [TC DL IGM: READ DATA - 读取计量器 END]\n";

    echo " [TC DL IWM: READ DATA - 读历史计数数据1 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_read_his_cnt_data1";
    $_GET["len"] = 3;
    $_GET["type"] = 0x10;
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: READ DATA - 读历史计数数据1 END]\n";

    echo " [TC DL IHM: READ DATA - 读历史计数数据2 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_read_his_cnt_data2";
    $_GET["len"] = 3;
    $_GET["type"] = 0x20;
    require("../l1mainentry/h5ui_entry_nbiot_ihm.php");
    echo " [TC DL IHM: READ DATA - 读历史计数数据2 END]\n";

    echo " [TC DL IGM: READ DATA - 读历史计数数据3 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "igm_read_his_cnt_data3";
    $_GET["len"] = 3;
    $_GET["type"] = 0x30;
    require("../l1mainentry/h5ui_entry_nbiot_igm.php");
    echo " [TC DL IGM: READ DATA - 读历史计数数据3 END]\n";

    echo " [TC DL IPM: READ DATA - 读历史计数数据4 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ipm_read_his_cnt_data4";
    $_GET["len"] = 3;
    $_GET["type"] = 0x40;
    require("../l1mainentry/h5ui_entry_nbiot_ipm.php");
    echo " [TC DL IPM: READ DATA - 读历史计数数据4 END]\n";

    echo " [TC DL IWM: READ DATA - 读历史计数数据5 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_read_his_cnt_data5";
    $_GET["len"] = 3;
    $_GET["type"] = 0x10;
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: READ DATA - 读历史计数数据5 END]\n";

    echo " [TC DL IHM: READ DATA - 读历史计数数据6 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_read_his_cnt_data6";
    $_GET["len"] = 3;
    $_GET["type"] = 0x20;
    require("../l1mainentry/h5ui_entry_nbiot_ihm.php");
    echo " [TC DL IHM: READ DATA - 读历史计数数据6 END]\n";

    echo " [TC DL IGM: READ DATA - 读历史计数数据7 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "igm_read_his_cnt_data7";
    $_GET["len"] = 3;
    $_GET["type"] = 0x30;
    require("../l1mainentry/h5ui_entry_nbiot_igm.php");
    echo " [TC DL IGM: READ DATA - 读历史计数数据7 END]\n";

    echo " [TC DL IPM: READ DATA - 读历史计数数据8 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ipm_read_his_cnt_data8";
    $_GET["len"] = 3;
    $_GET["type"] = 0x40;
    require("../l1mainentry/h5ui_entry_nbiot_ipm.php");
    echo " [TC DL IPM: READ DATA - 读历史计数数据8 END]\n";

    echo " [TC DL IWM: READ DATA - 读历史计数数据9 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_read_his_cnt_data9";
    $_GET["len"] = 3;
    $_GET["type"] = 0x10;
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: READ DATA - 读历史计数数据9 END]\n";

    echo " [TC DL IHM: READ DATA - 读历史计数数据10 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_read_his_cnt_data10";
    $_GET["len"] = 3;
    $_GET["type"] = 0x20;
    require("../l1mainentry/h5ui_entry_nbiot_ihm.php");
    echo " [TC DL IHM: READ DATA - 读历史计数数据10 END]\n";

    echo " [TC DL IGM: READ DATA - 读历史计数数据11 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "igm_read_his_cnt_data11";
    $_GET["len"] = 3;
    $_GET["type"] = 0x30;
    require("../l1mainentry/h5ui_entry_nbiot_igm.php");
    echo " [TC DL IGM: READ DATA - 读历史计数数据11 END]\n";

    echo " [TC DL IPM: READ DATA - 读历史计数数据12 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ipm_read_his_cnt_data12";
    $_GET["len"] = 3;
    $_GET["type"] = 0x40;
    require("../l1mainentry/h5ui_entry_nbiot_ipm.php");
    echo " [TC DL IPM: READ DATA - 读历史计数数据12 END]\n";

    echo " [TC DL IWM: WRITE DATA - 写价格表 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_write_price_table";
    $_GET["len"] = 0x13;
    $_GET["type"] = 0x10;
    $_GET["price1"] = 11.222;
    $_GET["volume1"] = 33.444;
    $_GET["price2"] = 55.664;
    $_GET["volume2"] = 1234.6666;
    $_GET["price3"] = 4567.1213;
    $_GET["startdate"] = 23;
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: WRITE DATA - 写价格表 END]\n";

    echo " [TC DL IWM: WRITE DATA - 写抄表日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_write_account_date";
    $_GET["len"] = 0x4;
    $_GET["type"] = 0x10;
    $_GET["accountdate"] = 14;
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: WRITE DATA - 写抄表日 END]\n";


    echo " [TC DL IWM: WRITE DATA - 写结算日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_write_bill_date";
    $_GET["len"] = 0x4;
    $_GET["type"] = 0x10;
    $_GET["billdate"] = 14;
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: WRITE DATA - 写结算日 END]\n";

    echo " [TC DL IWM: WRITE DATA - 写购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_write_buy_amount";
    $_GET["len"] = 0x8;
    $_GET["type"] = 0x10;
    $_GET["buycode"] = 14;
    $_GET["buyamount"] = 1231.323;
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: WRITE DATA - 写购入金额 END]\n";

    echo " [TC DL IWM: WRITE DATA - 写新秘钥 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_write_new_key";
    $_GET["len"] = 0x0C;
    $_GET["type"] = 0x10;
    $_GET["kerver"] = 14;
    $_GET["newkey"] = "8B1A334411223344";
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: WRITE DATA - 写新秘钥 END]\n";

    echo " [TC DL IWM: WRITE DATA - 写标准时间 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_write_std_time";
    $_GET["len"] = 0x0A;
    $_GET["type"] = 0x10;
    $_GET["realtime"] = "20110131152233";
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: WRITE DATA - 写标准时间 END]\n";

    echo " [TC DL IWM: WRITE DATA - 写阀门控制 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_write_switch_ctrl";
    $_GET["len"] = 0x04;
    $_GET["type"] = 0x10;
    $_GET["switch"] = true;
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: WRITE DATA - 写阀门控制 END]\n";

    echo " [TC DL IWM: WRITE DATA - 写出厂启动 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_write_off_fac_start";
    $_GET["len"] = 0x03;
    $_GET["type"] = 0x10;
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: WRITE DATA - 写出厂启动 END]\n";

    echo " [TC DL IWM: WRITE ADDR - 写地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_write_address";
    $_GET["len"] = 0x0A;
    $_GET["type"] = 0x10;
    $_GET["newaddr"] = "77665544332211";
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: WRITE ADDR - 写地址 END]\n";

    echo " [TC DL IWM: WRITE DEVICE SYN - 写机电同步 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "iwm_write_device_syn";
    $_GET["len"] = 0x8;
    $_GET["type"] = 0x10;
    $_GET["curaccumvolume"] = 12345.446;
    require("../l1mainentry/h5ui_entry_nbiot_iwm.php");
    echo " [TC DL IWM: WRITE DEVICE SYN - 写机电同步 END]\n";

    echo " [TC DL IHM: WRITE DATA - 写价格表 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_write_price_table";
    $_GET["len"] = 0x13;
    $_GET["type"] = 0x20;
    $_GET["price1"] = 11.222;
    $_GET["volume1"] = 33.444;
    $_GET["price2"] = 55.664;
    $_GET["volume2"] = 1234.6666;
    $_GET["price3"] = 4567.1213;
    $_GET["startdate"] = 23;
    require("../l1mainentry/h5ui_entry_nbiot_ihm.php");
    echo " [TC DL IHM: WRITE DATA - 写价格表 END]\n";

    echo " [TC DL IHM: WRITE DATA - 写抄表日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_write_account_date";
    $_GET["len"] = 0x4;
    $_GET["type"] = 0x20;
    $_GET["accountdate"] = 14;
    require("../l1mainentry/h5ui_entry_nbiot_ihm.php");
    echo " [TC DL IHM: WRITE DATA - 写抄表日 END]\n";

    echo " [TC DL IHM: WRITE DATA - 写结算日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_write_bill_date";
    $_GET["len"] = 0x4;
    $_GET["type"] = 0x20;
    $_GET["billdate"] = 14;
    require("../l1mainentry/h5ui_entry_nbiot_ihm.php");
    echo " [TC DL IHM: WRITE DATA - 写结算日 END]\n";

    echo " [TC DL IHM: WRITE DATA - 写购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_write_buy_amount";
    $_GET["len"] = 0x8;
    $_GET["type"] = 0x20;
    $_GET["buycode"] = 14;
    $_GET["buyamount"] = 1231.323;
    require("../l1mainentry/h5ui_entry_nbiot_ihm.php");
    echo " [TC DL IHM: WRITE DATA - 写购入金额 END]\n";

    echo " [TC DL IHM: WRITE DATA - 写新秘钥 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_write_new_key";
    $_GET["len"] = 0x0C;
    $_GET["type"] = 0x20;
    $_GET["kerver"] = 14;
    $_GET["newkey"] = "8B1A334411223344";
    require("../l1mainentry/h5ui_entry_nbiot_ihm.php");
    echo " [TC DL IHM: WRITE DATA - 写新秘钥 END]\n";

    echo " [TC DL IHM: WRITE DATA - 写标准时间 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_write_std_time";
    $_GET["len"] = 0x0A;
    $_GET["type"] = 0x20;
    $_GET["realtime"] = "20110131152233";
    require("../l1mainentry/h5ui_entry_nbiot_ihm.php");
    echo " [TC DL IHM: WRITE DATA - 写标准时间 END]\n";

    echo " [TC DL IHM: WRITE DATA - 写阀门控制 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_write_switch_ctrl";
    $_GET["len"] = 0x04;
    $_GET["type"] = 0x20;
    $_GET["switch"] = true;
    require("../l1mainentry/h5ui_entry_nbiot_ihm.php");
    echo " [TC DL IHM: WRITE DATA - 写阀门控制 END]\n";

    echo " [TC DL IHM: WRITE DATA - 写出厂启动 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_write_off_fac_start";
    $_GET["len"] = 0x03;
    $_GET["type"] = 0x20;
    require("../l1mainentry/h5ui_entry_nbiot_ihm.php");
    echo " [TC DL IHM: WRITE DATA - 写出厂启动 END]\n";

    echo " [TC DL IHM: WRITE ADDR - 写地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_write_address";
    $_GET["len"] = 0x0A;
    $_GET["type"] = 0x20;
    $_GET["newaddr"] = "77665544332211";
    require("../l1mainentry/h5ui_entry_nbiot_ihm.php");
    echo " [TC DL IHM: WRITE ADDR - 写地址 END]\n";

    echo " [TC DL IHM: WRITE DEVICE SYN - 写机电同步 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_write_device_syn";
    $_GET["len"] = 0x8;
    $_GET["type"] = 0x20;
    $_GET["curaccumvolume"] = 12345.446;
    require("../l1mainentry/h5ui_entry_nbiot_ihm.php");
    echo " [TC DL IHM: WRITE DEVICE SYN - 写机电同步 END]\n";

    echo " [TC DL IGM: WRITE DATA - 写价格表 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "igm_write_price_table";
    $_GET["len"] = 0x13;
    $_GET["type"] = 0x30;
    $_GET["price1"] = 11.222;
    $_GET["volume1"] = 33.444;
    $_GET["price2"] = 55.664;
    $_GET["volume2"] = 1234.6666;
    $_GET["price3"] = 4567.1213;
    $_GET["startdate"] = 23;
    require("../l1mainentry/h5ui_entry_nbiot_igm.php");
    echo " [TC DL IGM: WRITE DATA - 写价格表 END]\n";

    echo " [TC DL IGM: WRITE DATA - 写抄表日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "igm_write_account_date";
    $_GET["len"] = 0x4;
    $_GET["type"] = 0x30;
    $_GET["accountdate"] = 14;
    require("../l1mainentry/h5ui_entry_nbiot_igm.php");
    echo " [TC DL IGM: WRITE DATA - 写抄表日 END]\n";

    echo " [TC DL IGM: WRITE DATA - 写结算日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ihm_write_bill_date";
    $_GET["len"] = 0x4;
    $_GET["type"] = 0x30;
    $_GET["billdate"] = 14;
    require("../l1mainentry/h5ui_entry_nbiot_igm.php");
    echo " [TC DL IGM: WRITE DATA - 写结算日 END]\n";

    echo " [TC DL IGM: WRITE DATA - 写购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "igm_write_buy_amount";
    $_GET["len"] = 0x8;
    $_GET["type"] = 0x30;
    $_GET["buycode"] = 14;
    $_GET["buyamount"] = 1231.323;
    require("../l1mainentry/h5ui_entry_nbiot_igm.php");
    echo " [TC DL IGM: WRITE DATA - 写购入金额 END]\n";

    echo " [TC DL IGM: WRITE DATA - 写新秘钥 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "igm_write_new_key";
    $_GET["len"] = 0x0C;
    $_GET["type"] = 0x30;
    $_GET["kerver"] = 14;
    $_GET["newkey"] = "8B1A334411223344";
    require("../l1mainentry/h5ui_entry_nbiot_igm.php");
    echo " [TC DL IGM: WRITE DATA - 写新秘钥 END]\n";

    echo " [TC DL IGM: WRITE DATA - 写标准时间 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "igm_write_std_time";
    $_GET["len"] = 0x0A;
    $_GET["type"] = 0x30;
    $_GET["realtime"] = "20110131152233";
    require("../l1mainentry/h5ui_entry_nbiot_igm.php");
    echo " [TC DL IGM: WRITE DATA - 写标准时间 END]\n";

    echo " [TC DL IGM: WRITE DATA - 写阀门控制 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "igm_write_switch_ctrl";
    $_GET["len"] = 0x04;
    $_GET["type"] = 0x30;
    $_GET["switch"] = true;
    require("../l1mainentry/h5ui_entry_nbiot_igm.php");
    echo " [TC DL IGM: WRITE DATA - 写阀门控制 END]\n";

    echo " [TC DL IGM: WRITE DATA - 写出厂启动 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "igm_write_off_fac_start";
    $_GET["len"] = 0x03;
    $_GET["type"] = 0x30;
    require("../l1mainentry/h5ui_entry_nbiot_igm.php");
    echo " [TC DL IGM: WRITE DATA - 写出厂启动 END]\n";

    echo " [TC DL IGM: WRITE ADDR - 写地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "igm_write_address";
    $_GET["len"] = 0x0A;
    $_GET["type"] = 0x30;
    $_GET["newaddr"] = "77665544332211";
    require("../l1mainentry/h5ui_entry_nbiot_igm.php");
    echo " [TC DL IGM: WRITE ADDR - 写地址 END]\n";

    echo " [TC DL IGM: WRITE DEVICE SYN - 写机电同步 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "igm_write_device_syn";
    $_GET["len"] = 0x8;
    $_GET["type"] = 0x30;
    $_GET["curaccumvolume"] = 12345.446;
    require("../l1mainentry/h5ui_entry_nbiot_igm.php");
    echo " [TC DL IGM: WRITE DEVICE SYN - 写机电同步 END]\n";

    echo " [TC DL IPM: WRITE DATA - 写价格表 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ipm_write_price_table";
    $_GET["len"] = 0x13;
    $_GET["type"] = 0x40;
    $_GET["price1"] = 11.222;
    $_GET["volume1"] = 33.444;
    $_GET["price2"] = 55.664;
    $_GET["volume2"] = 1234.6666;
    $_GET["price3"] = 4567.1213;
    $_GET["startdate"] = 23;
    require("../l1mainentry/h5ui_entry_nbiot_ipm.php");
    echo " [TC DL IPM: WRITE DATA - 写价格表 END]\n";

    echo " [TC DL IPM: WRITE DATA - 写抄表日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ipm_write_account_date";
    $_GET["len"] = 0x4;
    $_GET["type"] = 0x40;
    $_GET["accountdate"] = 14;
    require("../l1mainentry/h5ui_entry_nbiot_ipm.php");
    echo " [TC DL IPM: WRITE DATA - 写抄表日 END]\n";

    echo " [TC DL IPM: WRITE DATA - 写结算日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ipm_write_bill_date";
    $_GET["len"] = 0x4;
    $_GET["type"] = 0x40;
    $_GET["billdate"] = 14;
    require("../l1mainentry/h5ui_entry_nbiot_ipm.php");
    echo " [TC DL IPM: WRITE DATA - 写结算日 END]\n";

    echo " [TC DL IPM: WRITE DATA - 写购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ipm_write_buy_amount";
    $_GET["len"] = 0x8;
    $_GET["type"] = 0x40;
    $_GET["buycode"] = 14;
    $_GET["buyamount"] = 1231.323;
    require("../l1mainentry/h5ui_entry_nbiot_ipm.php");
    echo " [TC DL IPM: WRITE DATA - 写购入金额 END]\n";

    echo " [TC DL IPM: WRITE DATA - 写新秘钥 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ipm_write_new_key";
    $_GET["len"] = 0x0C;
    $_GET["type"] = 0x40;
    $_GET["kerver"] = 14;
    $_GET["newkey"] = "8B1A334411223344";
    require("../l1mainentry/h5ui_entry_nbiot_ipm.php");
    echo " [TC DL IPM: WRITE DATA - 写新秘钥 END]\n";

    echo " [TC DL IPM: WRITE DATA - 写标准时间 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ipm_write_std_time";
    $_GET["len"] = 0x0A;
    $_GET["type"] = 0x40;
    $_GET["realtime"] = "20110131152233";
    require("../l1mainentry/h5ui_entry_nbiot_ipm.php");
    echo " [TC DL IPM: WRITE DATA - 写标准时间 END]\n";

    echo " [TC DL IPM: WRITE DATA - 写阀门控制 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ipm_write_switch_ctrl";
    $_GET["len"] = 0x04;
    $_GET["type"] = 0x40;
    $_GET["switch"] = true;
    require("../l1mainentry/h5ui_entry_nbiot_ipm.php");
    echo " [TC DL IPM: WRITE DATA - 写阀门控制 END]\n";

    echo " [TC DL IPM: WRITE DATA - 写出厂启动 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ipm_write_off_fac_start";
    $_GET["len"] = 0x03;
    $_GET["type"] = 0x40;
    require("../l1mainentry/h5ui_entry_nbiot_ipm.php");
    echo " [TC DL IPM: WRITE DATA - 写出厂启动 END]\n";

    echo " [TC DL IPM: WRITE ADDR - 写地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ipm_write_address";
    $_GET["len"] = 0x0A;
    $_GET["type"] = 0x40;
    $_GET["newaddr"] = "77665544332211";
    require("../l1mainentry/h5ui_entry_nbiot_ipm.php");
    echo " [TC DL IPM: WRITE ADDR - 写地址 END]\n";

    echo " [TC DL IPM: WRITE DEVICE SYN - 写机电同步 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $_GET["action"] = "ipm_write_device_syn";
    $_GET["len"] = 0x8;
    $_GET["type"] = 0x40;
    $_GET["curaccumvolume"] = 12345.446;
    require("../l1mainentry/h5ui_entry_nbiot_ipm.php");
    echo " [TC DL IPM: WRITE DEVICE SYN - 写机电同步 END]\n";


//TEST CASE: NBIOT IWM/IPM/IGM/IHM@CJ188: END
}


?>