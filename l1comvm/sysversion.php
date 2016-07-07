<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 13:16
 */

//SW version control, for internal usage
define ("MFUN_CURRENT_SW_RELEASE", "02");  //R01 = 0x01 (MFUN.SW.R01.456)
define ("MFUN_CURRENT_SW_DELIVERY","D22"); //001 = 0x01 (XQ.HCU.SW.R01.456), starting from 100 as 2015/11/02
define("MFUN_CURRENT_VERSION", "R" . MFUN_CURRENT_SW_RELEASE . "." . MFUN_CURRENT_SW_DELIVERY);  //当前SAE应用版本号

/*
 软件版本命名
 MFUN_Rxx_Dyy
 		-xx为软件大版本Release，01为mfuncard微信应用，02为mfunhcu扬尘项目，并兼容微信平台
 		-yy为软件小版本Drop
    R01_D02：
        mFun_Card（IHU PEM2）第一次客户完美演示版

 	R02_D01：HCU第一版，HCU数据使用curl上报联调成功
 	R02_D02：按照新后台软件框架，并完成气象5要素及噪声视频的处理
 	R02_D03：2016/01/06，增加分钟报告数据聚合和小时报告数据BI功能
    R02_D04：2016/01/11，增加HCU控制界面功能
    R02_D05：2016/01/16，更新HCU控制界面功能
    R02_D06：2016/01/19，Socket功能加入
    R02_D07: 2016/01/23，完善HCU控制命令
    R02_D08：2016/01/30，修改HCU控制命令通过socket下发为curl polling，增加CMDID_HCU_POLLING消息
    R02_D09：2016/02/26，程序框架完善/代码清理，引入unpack函数解析消息流，数据库表单sid=0项保存最大sid机制修改，HCU控制界面优化
                    IHU基于小趣科技公号实现EMC PUSH/RESP,config文件引入当前版本定义，更新readme文档
    R02_D10: 2016/03/01，删除根目录下QL以前不需要的文件，增加测量数据精度字段，GPS经度（E,W)纬度(N，S)标识
    R02_D11: 2016/03/08，后台界面增加视频处理功能
//= ZJL, 2016 June.20, CURRENT_SW_DELIVERY R02.D12
//= ZJL, 2016 June.29, CURRENT_SW_DELIVERY R02.D13
//= ZJL, 2016 June.29, CURRENT_SW_DELIVERY R02.D14
//= ZJL, 2016 June.30, CURRENT_SW_DELIVERY R02.D15
//= ZJL, 2016 July.1, CURRENT_SW_DELIVERY R02.D16
//= LZH, 2016 July.3, CURRENT_SW_DELIVERY R02.D17, 合并调试最新UI模块
//= ZJL, 2016 July.4, CURRENT_SW_DELIVERY R02.D18
//= ZJL, 2016 July.5, CURRENT_SW_DELIVERY R02.D19
//= ZJL, 2016 July.6, CURRENT_SW_DELIVERY R02.D20
//= ZJL, 2016 July.6, CURRENT_SW_DELIVERY R02.D21
//= ZJL, 2016 July.7, CURRENT_SW_DELIVERY R02.D22


 */


?>