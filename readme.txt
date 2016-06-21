BXXH项目文件说明
==============
Make By：ZJL
2016/02/23 Update By：LZH

##说明 
**这里的文档可以让你更好的了解`MFUN`项目，更好的使用。 **

**欢迎对文档内容进行补充，把`MFUN`项目变得更清晰易懂。**

##为你的github生成wiki
**如果你在github上fork了`MFUN`项目，而且想为项目生成wiki，可以用这里的文件来生成。**


###文件内容说明：
</wechat根目录下>
 ->cloud_callback，做为第三方云的后台入口
 ->index，mFun欢迎进入页面, 测试用没有实际用处
 ->README，本文件
 ->config.yaml，SAE Cron应用服务配置

\bi Business “Intelligence目录”
 ->bi_db.class，BI数据库交互接口
 ->bi_service.class，BI业务逻辑处理

\config “配置目录”
 ->config，定义项目所用到的全局参数
 ->errCode，辅助wechat.class，成为其SDK的一部分

\database “数据库API目录”
 ->db_common.class, 定义跨平台的公共数据库操作相关的API
 ->db_emc.class, 定义用于EMC数据库操作相关的API
 ->db_humidity.class，定义用于湿度数据库操作相关的API
 ->db_noise.class，定义用于噪声数据库操作相关的API
 ->db_pmdata.class，定义用于颗粒物PM2.5数据库操作相关的API
 ->db_temperature.class，定义用于温度数据库操作相关的API
 ->db_video.class，定义用于视频数据库操作相关的API
 ->db_weixin.class，定义用于微信数据库操作相关的API
 ->db_winddirection.class，定义用于风向数据库操作相关的API
 ->db_windspeed.class，定义用于风速数据库操作相关的API

\hcutool "HCU工具目录"
 ->gethint，界面提示信息
 ->hcu_ctrl.index，HCU控制界面
 ->hcu_ctrl.process，HCU控制界面处理API

\jsp，“微信客户端Java界面目录 （主要由ZSC维护）”

\oam  “操作维护工具目录”
 ->DbTest，database临时测试程序
 ->index，微信工具界面
 ->qrcode.png，二维码生成临时图像文件
 ->tool.ajxhisdata，用于被tool.pageshare.php调用的后台历史数据访问php程序
 ->tool.create.menu，后台强制创建菜单
 ->tool.dev.bind，后台强制绑定用户
 ->tool.pageshare，测试页面共享以及JSSDK功能
 ->tool，测试工具角色，可以写测试脚本，进行在线测试
 ->tool.qrcode.gen，受控index.php页面的二维码自动生成程序

\sdk “底层基础SDK”
 ->\phpqrcode，二维码生成SDK目录
 ->hcu_iot.class，HCU互操作SDK，
 ->wechat.class，基础公号的SDK，SAE后台处理response入口
 ->wx_iot.class，IHU硬件设备微信公众号处理
 ->wx_jssdk，JSSDK类封装

\service “主要业务逻辑目录”
 ->common.class， 公共业务逻辑处理，如心跳，时间同步，版本等
 ->emc.class，电磁辐射业务逻辑处理
 ->humidity.class，湿度业务逻辑处理
 ->noise.class，噪声业务逻辑处理
 ->pmdata.class，空气颗粒物业务逻辑处理
 ->temperature.class，温度业务逻辑处理
 ->video.class，视频业务逻辑处理
 ->winddirection.class，风向业务逻辑处理
 ->windspeed.class，风速业务逻辑处理

###SAE运行或部署步骤：
1. 配置Config.php运行环境参数
2. 打包本项目成*.zip文件
3. 上传到SAE云
4. 导出导入MySql数据库
5. 在微信接入第三方云界面，确认微信接口URL的Token验证通过
6. 在后台管理TOOL界面，确认API接口Token刷新机制工作正常

##生成page
**你也可以将wiki文档，生成为个人站点，会更加直观。**
**比如使用 Hexo 或者其他的框架之类。**
**这块的话，请自行搜索相关资料。**

//= ZJL, 2016 June.20, CURRENT_SW_DELIVERY R02.D12
> 准备对整个项目工程进行较大的改动，改动的目的主要有几个：1）明晰的架构 2）方便可扩展性 3）多人协同工作更加方便 4）适应多个项目并存 5）模块的复用性
> 程序架构演进的第一步是目录结构，第二步是VM机制
> 修改所有的数据库命名
> 修改所有的L1-L5程序目录和目录名字
> 修改程序VM层，将不同内容分开放置
> 将系统模块定义为CLASS，名字空间全局唯一
> 定义各种CLASS的命名规则
> 搭建msg_send和msg_rcv的框架，思考其CLASS相互之间调用的关系以及生命周期
> 考虑程序被调用的入口方式问题


