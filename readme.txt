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
> 将所有的全局常量全部命名成为MFUN_XXX，以便减少潜在的重名错误，同时让命名具备更加明确的意义
> 修改所有CLASS和DBI的命名
> 增加所有任务模块的入口
> 框架基本搭建完成，还需要完善消息发送和处理方式
> 二次包含vmlayer.php出现告警全部消除，所有的包含都放在VM中，其它任务模块不再包含了VMLAYER了
> 搭建好了IOT_STDXML对应传感器的所有任务框架
> 修改好了SDK_WECHAT
> IOT_WX还未修改完整，
  =>ihu_device_L25_content_process：发送到EMC/PM25的L3/L4处理信息，需要到SENSOR EMC/PM25处理完整，
  不再回来，目前的流程需要在L3/L4完成一部分后，再返回IOT_WX程序模块再处理。这部分等待完善。
  =>ihu_device_L28_usercmd_text_process：同上

//= ZJL, 2016 June.29, CURRENT_SW_DELIVERY R02.D13
> 增加AQYC/TBSWR/EMCWX的H5YUI界面入口，先考虑将界面模块纳入到统一的VM处理模块机制中，包括CRON模块
> IOT_WX修改好了，支持气象6参数以及相应的任务模块
> 扩展系统消息到DATA_READ_INSTANT以及DATA_REPORT_TIMING，以支持所有的瞬时读取和定时发送模式。L2SNR传感器框架改好以支持。
> 搭建后台数据库分库的雏形，BXXH分为bxxhl1l2l3, bxxhl4aqyc, bxxhl4tbswr, bxxhl4emcwx, bxxhl5bi等不同数据库
> 最复杂的AQYC界面对应的数据库也分开了，但可能有潜在的问题，需要再测试和调整
> 数据库文件分别保存备份了

//= ZJL, 2016 June.29, CURRENT_SW_DELIVERY R02.D14
> 研究图像文件的存储，经过验证，图片二进制文件的存储和读取，均成功！

//= Multi author, 2016 June30, CURRENT_SW_DELIVERY R02.D15
> 数据表单访问单一原则：同一个表单，只能在一个地方撰写相应的DBI接口API函数，如果其他任务模块需要用到，则需要通过调用相应API函数达成，
而非直接访问该数据库，以便减少数据表单修改而导致多个地方修改的问题
> 基于这个思路，l4aqycui中的dbi_xxx需要较多修改，基于几个诉求：
  = 本文件太大，不利于多人并行开发工作
  = 同一个CLASS，集成了访问多个数据库和数据表单的API，不适合于表单API单一原则
  = 希望该项目是基于大模块机制，以便提高复用性以及简单性
  = 数据生成功能需要移到l3appl中，界面项目只完成接口的任务，从而简化整个项目
> 数据表单命名大调整
> 其它L2SNR传感器在数据库以及DBI访问函数，均创建了基本的功能

//= Multi author, 2016 July.1, CURRENT_SW_DELIVERY R02.D16
> 临时修复L4AQYC的REQUEST.php，让其可以使用，等待将其结构转换为不同功能的VM机制

//= LZH, 2016 July.3, CURRENT_SW_DELIVERY R02.D17
> 合并调试最新UI模块

//= ZJL, 2016 July.4, CURRENT_SW_DELIVERY R02.D18
> 继续完善L4AQYC UI的VM
> 将L4AQYC UI任务全部改造为VM机制
> Requet.php改造为入口函数，同时调用L1_MAIN_ENTRY中的AQYC_UI入口，从而将所有入口全部排到一个层次
> 试图增加SOCKET LISTENING的入口，待完善

//= ZJL, 2016 July.5, CURRENT_SW_DELIVERY R02.D19
> CRON增加到VM任务中，同时支持1-10级不同的时间颗粒度
> SOCKET LISTENING任务增加到VM中，处理函数挂载到onReceive事件中
> 这两项执行任务需要通过Linux/VPS的服务配置来启动，而不是通过appach来启动的，这个要特别注意。
> 本来打算支持的RabbitMQ也是类似机理，考虑到其使用的复杂性，暂时没用，未来一旦需要支持超过1M的连接，就需要了
> 建立JD/APPLE入口的框架
> 逐步建立L2SENSOR中的工程参数配置，减少直接数据常量定义

//= ZJL, 2016 July.6, CURRENT_SW_DELIVERY R02.D20
> 给Logger数据条目增加版本属性，以便及时分析是在哪个版本下出现的问题
> 增加TRACE机制，方便调试
> 修正L2SNR_MINREPORT数据表单中$result=inqury的结果==FALSE的潜在性错误
> 完善消息定义中的自动编码，解放了每次需要手动调整数值的过程

//= ZJL, 2016 July.6, CURRENT_SW_DELIVERY R02.D21
> 工参数据表单的初步框架
> AQYC的开机图片等信息将存入到系统工参配置数据表单中
> 初步搭建完成F1到FX的数据DBI框架

//= ZJL, 2016 July.7, CURRENT_SW_DELIVERY R02.D22
> 完善项目+logfrom的完整标识
> 扩展更加丰富支持的协议标准，到APPLE/JD的程序框架
> ZHB的解码需要进一步完善，目前还非常不完善
> Log功能再完善，可以开始恢复后台管理界面及相应LOG工具了
> 给L4AQYC制作完整的TEST CASES，发现9个遗留问题
> 给CRON增加自动化测试，待完善程序执行细节
> 试图给EMCWX增加自动化测试集，欠缺完善的测试数据
> SOCKET只有在AQ_HCU环境下才能测试，待完善

//= ZJL, 2016 July.7, CURRENT_SW_DELIVERY R02.D23
> 完善EMCWX测试例程
> 将commsg.php中的全局定义分为IHU/HCU两个不同的类别
> 增加NBIOT的基础框架功能

//= ZJL, 2016 July.8, CURRENT_SW_DELIVERY R02.D24
> 增加sysinfo数据表单
> 完善WECHAT之中部分函数的命名，以方便理解程序结构
> 完善整个NBIOT的程序架构以及相应的命名规则，以便后期扩展更加方便和准确
> 排比句，创出框架LTE-V车联网，IGM煤气表以及农业AGC，暂时没创其UI部分

//= ZJL, 2016 July.10, CURRENT_SW_DELIVERY R02.D25
> 完善常亮命名的丰富性和一致性
> IPM376架构搭建完成

//= ZJL, 2016 July.11, CURRENT_SW_DELIVERY R02.D26
> 构建IPM376的解码功能
> 构建CJ188规范的对应程序框架，以支持水表、煤气表、电表等内容

//= ZJL, 2016 July.13, CURRENT_SW_DELIVERY R02.D27
> 增加AQYC程序升级的接口，以及相应的处理函数功能，还有待完善管理模块对软件版本的后天管理，以及用户界面对程序升级的触发
> 增加相应的SW UPDATE测试程序
> 继续完善CJ188编解码

//= LZH, 2016 July.13, CURRENT_SW_DELIVERY R02.D28
> 增加最新手机界面UI功能支持，界面十大功能框架
> 继续完善CJ188功能

//= ZJL, 2016 July.15, CURRENT_SW_DELIVERY R02.D29
> IPM376改造为完善的STD_QG376规范，跟IPM不再保持唯一的映射关系
> 完善CJ188功能框架，完成上行解码链路的工作
> QL：单独创建了一个给Yii2使用的数据库，从而不再跟本数据库相混淆
> 继续测试代码：UL的测试代码完成

//= LZH, 2016 July.15, CURRENT_SW_DELIVERY R02.D30
> fix UI界面bug，所有修改框架前的界面功能回归测试OK

//= ZJL, 2016 July.16, CURRENT_SW_DELIVERY R02.D31
> 继续下行链路CJ188的编制
> 下行链路的功能部分完成，CJ188 SDK还等待完成

//= ZJL, 2016 July.18, CURRENT_SW_DELIVERY R02.D32
> DL测试代码完成
> 上行链路增加了写入过程
> 新增加的上行链路中测试代码也完善

//= ZJL, 2016 July.18, CURRENT_SW_DELIVERY R02.D33
> 下行DL代码的SDK
> SDK DL全部完善好，测试脚本验证好，输出码流正常
> CJ188服务器一侧的，算是全部完成了
> Bug fix on L2SDK NBIOT dbi functions.

//= LZH, 2016 July.21, CURRENT_SW_DELIVERY R02.D34
> UI界面增加视频播放和软件下载功能
> 视频播放功能测试代码完善，输出正确
> ZJL: 修正apach中报出的几个小错误

//= LZH, 2016 July.25, CURRENT_SW_DELIVERY R02.D35
> UI界面增加仪表反控功能
> 修改数据库swfactory和hwinventory表单，完善软件下载功能

//= LZH, 2016 Aug.04, CURRENT_SW_DELIVERY R02.D36
> 修改新框架下微信配置提交不成功的bug，新框架下微信配置cloud_callback_wechat提交成功
> 修改AQYC界面上查询结果为空时返回false导致页面无效，退回登录界面的不合理操作
> 修改微信EMC_READ click事件发送消息没有构造的bug
> 修改微信菜单

//= LZH, 2016 Aug.09, CURRENT_SW_DELIVERY R02.D37
> 修改微信菜单
> 爱启扬尘UI采用JS编译文件，去掉了路径依赖，可以部署在WWW下任意路径

//= LZH, 2016 Aug.11, CURRENT_SW_DELIVERY R02.D38
> 增加小慧云支持（http://121.40.118.33）

//= LZH, 2016 Aug.23, CURRENT_SW_DELIVERY R02.D39
> 增加小慧智能服务号支持，服务号和测试号分别创建新菜单
> EMC微信H5页面支持

//= LZH, 2016 Aug.30, CURRENT_SW_DELIVERY R02.D40
> 修改EMC微信H5界面功能使用新架构
> 使用服务号微信公众平台开发 OAuth2.0网页授权认证, EMC微信H5网页授权获取用户基本信息(openid)

//= LZH, 2016 Sep.04, CURRENT_SW_DELIVERY R02.D41
> 修改EMC微信测试号菜单，增加生产工具的扫码绑定功能
> 完善EMCWX测试case

//= QL, 2016 Sep.12, CURRENT_SW_DELIVERY R02.D42
> Socket功能增加，实现PM25操控
> GetCameraStatus功能的消息和相应函数增加

//= QL, 2016 Sep.13, CURRENT_SW_DELIVERY R02.D43
> Socket只设置heartbeat_idle_time，未设置heartbeat_check_interval，底层将不会创建心跳检测线程，PHP代码中未来可以调用heartbeat方法手工处理超时的连接

//= QL, 2016 Sep.14, CURRENT_SW_DELIVERY R02.D44
> 改变原先require特定文件开启9502socket端口的做法，增加socket_client_sync.class类开启阻塞式tcp连接，目前先发后收，实现UI参数传递，
> swoole server开启demonize参数，运行日志记录到log文件

//= QL, 2016 Sep.19, CURRENT_SW_DELIVERY R02.D45
> socket心跳重新开启，60秒遍历所有连接，600秒内没有传送，关闭连接
> swoole server关闭demonize参数，利用crontab脚本来守护进程

//= LZH, 2016 Sep.19, CURRENT_SW_DELIVERY R02.D46
> 修改微信公众号菜单，完善EMC网页显示功能
> 完善扫描绑定功能，增加相应WXEMC测试case

//= LZH, 2016 Oct.02, CURRENT_SW_DELIVERY R02.D47
> 完善小慧智能服务号菜单以及EMC H5功能
> 增加智能云锁任务

//= LZH, 2016 Oct.07, CURRENT_SW_DELIVERY R02.D48
> l4oamtool增加批量导入MAC，deviceID功能

//= QL, 2016 Oct.15, CURRENT_SW_DELIVERY R02.D49
> draft tbswr module done with draft test case passed

//= LZH, 2016 Oct.26, CURRENT_SW_DELIVERY R02.D50
> 清理代码，去掉表t_l3f3dm_sitemapping和表t_l3f2cm_projmapping
> 修改数据表单的属性，将可以为空的字段设置成NULL
> 数据库增加云控制锁项目表单

//= LZH, 2016 Oct.29, CURRENT_SW_DELIVERY R03.D01
> 添加云控锁项目

//= LZH, 2016 Nov.05, CURRENT_SW_DELIVERY R03.D02
> 添加云控锁接口消息，全局量定义
> 将l1comvm中全局消息常量按照工程重新组合
> 清除testcase中的告警，现在除了需要用到swoole_client的case，本地windows环境测试无法运行外，所有case运行正常

//= LZH, 2016 Nov.07, CURRENT_SW_DELIVERY R03.D03
> 创建云控锁所有l2sensorproc任务并添加相应消息

//= LZH, 2016 Nov.13, CURRENT_SW_DELIVERY R03.D04
> 完成云控锁所有与下位机的接口消息
> 添加云控锁UI界面的钥匙管理功能

//= LZH, 2016 Dec.02, CURRENT_SW_DELIVERY R03.D05
> FHYS功能完善，第一个deliver现场版本
> 增加BFSC波峰组合秤项目

//= LZH, 2016 Dec.11, CURRENT_SW_DELIVERY R03.D06
> FHYS UI和后台MFUNHCU采用统一新消息结构定义
> 登录功能调试OK，其他接口还在测试中，改动比较大，先git上传一次

//= LZH, 2016 Dec.13, CURRENT_SW_DELIVERY R03.D07
> FHYS UI和后台MFUNHCU新消息结构测试完成

//= LZH, 2016 Dec.16, CURRENT_SW_DELIVERY R03.D08
> AQYC UI和后台MFUNHCU新消息结构测试完成
> 修改视频和摄像头控制处理

//= LZH, 2016 Dec.27, CURRENT_SW_DELIVERY R03.D09
> 添加FHYS微信开锁界面
> 调整t_l3f2cm_projinfo和t_l3f3dm_siteinfo表单，使项目和站点1对多映射逻辑更合理

//= QL, 2017 Jan.5, CURRENT_SW_DELIVERY R03.D10
> 增加hcu performance性能统计功能

//= QL, 2017 Jan.11, CURRENT_SW_DELIVERY R03.D11
> 增加hcu alarm data上报功能

//= QL, 2017 Jan.13, CURRENT_SW_DELIVERY R03.D12
> 丰富hcu inventory data上报功能，增加db version字段的存入，增加mac地址的传递
> 关于mac地址和hcu name之间的匹配逻辑，后续待讨论和完善

//= LZH, 2017 Feb.05, CURRENT_SW_DELIVERY R03.D13
> FHYS第二版调试，增加4C聚合状态报告
> AQYC UI功能完善
> 增加HUITP协议消息定义

//= QL, 2017 Feb.14, CURRENT_SW_DELIVERY R03.D14
> 增加对于alarm消息的解析，根据PM25阀值触发录像开启、关闭，拍摄照片，并回传参数

//= LZH, 2017 Feb.21, CURRENT_SW_DELIVERY R03.D15
> FHYS功能完善，增加微信开锁，蓝牙开锁和RFID开锁功能，增加告警处理功能
> AQYC根据客户反馈UI功能完善

//= LZH, 2017 Mar.19, CURRENT_SW_DELIVERY R03.D16
> FHYS功能完善，修复微信开锁bug，socket listening bug
> 增加HUITP消息，IE字典，完善HUITP消息解码功能，测试OK

//= LZH, 2017 Apr.08, CURRENT_SW_DELIVERY R03.D17
> 增加FHYS常用站点功能
> 更新FHYS状态报告消息，增加锁未安装状态
> 添加FHYS蓝牙钥匙自动生成功能

//= LZH, 2017 May.26, CURRENT_SW_DELIVERY R03.D18
> 增加短信密码找回功能，增加告警短信通知功能
> 修改用户权限管理，用户登录后只能看到自己授权的项目，站点，设备等
> 根据阜华和爱启用户的反馈，完善FHYS和AQYC界面

//= LZH, 2017 June.12, CURRENT_SW_DELIVERY R03.D19
> 更新FHYS短信平台，修改用户权限分类
> 修改FHYS开锁抓拍照片处理流程，开站上传照片和开锁抓拍照片分开显示
> 更新AQYC登录界面，highchart，视频跳转，站点地图跳转等

//= LZH, 2017 July.25, CURRENT_SW_DELIVERY R03.D20
> 软件架构演进，对以前的IOT HCU代码进行了清理。
> 增加CCL HUITP支持，同时对Swoole socket进行了修改，不同的协议端口进行了区分
> FHYS数据表单进行了修改，适配CCL

//= LZH, 2017 July.27, CURRENT_SW_DELIVERY R03.D21
> 继续软件代码清理，删除老的IOT_HCU SDK的功能，改IOT_HCU为IOT_STDXML
> 添加图片传送HEX data Socket端口，和相应L2snr_hsmmp处理

//= LZH, 2017 Aug.25, CURRENT_SW_DELIVERY R03.D22
> 添加5510 socket端口用于照片HEX码流上传
> 完成CLL HUITP消息调试，支持4把锁功能
> 完成软件下载功能

//= LZH, 2017 Sep.23, CURRENT_SW_DELIVERY R03.D23
> 增加Admin tools支持，二维码工具和软件包管理
> 增加扬尘聚合，照片报告/摄像头控制HUITP支持, 清理扬尘l2snr数据表单，修改扬尘照片/视频显示
> 增加FHYS表单模糊查询，修改用户等级定义，分项目定义用户权限控制

//= LZH, 2017 Oct.26, CURRENT_SW_DELIVERY R03.D24
> 增加BFSC UI支持
> 更新FHYS二维码激活功能，微信公众号功能增强
> 更新AQYC性能管理，超标照片抓拍，软件下载
> 后台log功能增强

//= LZH, 2017 Nov.08, CURRENT_SW_DELIVERY R03.D25
> 优化Swoole socket参数设置
> 增加爱启扬尘视频播放和告警照片抓拍功能
> 增加扬尘，云控锁历史数据，告警记录，照片清理功能
> 增加L4COMUI模块，处理例如界面用户登录，项目组/项目/站点/设备管理等COMMON功能，其他项目独特操作放到对应的L4XXXXUI模块，提高代码的复用性
> 添加FDWQ项目第一版

//待完善的功能
1. dbi_devinfo_update（）需要修改，添加设备时预计结束时间和实际结束时间应该在项目信息里
2. 添加设备时没有选择该设备装配了那些传感器，sensorctrl表没有更新

//已知的潜在错误
1. task_l2sdk_iot_hcu.class.php, line108，引用父进程的函数指针，编译器发现潜在错误，如何消除？ 目前执行都很正常，但是程序代码不好看
2. l3appl->fxyyy中，调用_encode函数出错，如何办？
    //$jsonencode = _encode($retval);
    $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);


/**************************************************************************************
*  架构描述                                                                           *
**************************************************************************************/
==> NBIOT_IPM376: 整个设计是以NBIOT_IPM376为基础，主要是为了电力系统中协议376的编解码
==> NBIOT_IPM_UI: 模拟后台对NBIOT的模块进行操作，包括主动读取电表数据的菜单项
==> 物联网模块的后台接入，以及手机终端APP的查询，造成后台将会有2个程序入口
==> 目前所有的不同系统都是这种架构
==> 当前暂时支持的程序架构有：电磁辐射项目，爱启扬尘项目，陶波水污染项目，窄带物联网电表项目
==> 特殊缩写代表的含义：IPM智能电表，IGM智能气表，LTEV车联网，AGC农业物联网，IWM智能水表。SDK已经创建完成，但对应的UI并没有全部创建，需要等待具体的业务需求。

==> 有关PROGRAM / PLATFORM / POROJECT之间的关系
    //定义技术平台，用于SDK在相互之间调用以及SDK调用不同的SENSOR任务时的一种技术性交换矩阵，以节省代码的重复性
    //技术平台本身没有任何意义，它纯粹从实用性角度，人为的给调用函数提供了一种方便性的区分而已
    //技术平台+PROJECT构成了函数调用的两个灵活区分，这两者的应用由于历史的缘故，在使用规则上和概念上，并没有严格的区分，全拼调用者的喜好
    //PROGRAM是更为高层的概念，原则上我们可以认为，PROGRAM > PLATFORM > PROJECT




/*
https://segmentfault.com/a/1190000002963223
http://blog.haohtml.com/archives/15484
http://blog.csdn.net/lmj623565791/article/details/37607165
http://pecl.php.net/package/amqp
http://blog.haohtml.com/archives/15491
http://stackoverflow.com/questions/13776164/connect-to-rabbitmq-from-php-windows
http://www.th7.cn/Program/php/201410/297470.shtml

消息的处理，是有两种方式：
A，一次性。用 $q->get([...])，不管取到取不到消息都会立即返回，一般情况下使用轮询处理消息队列就要用这种方式；
B，阻塞。用 $q->consum( callback, [...] ) 程序会进入持续侦听状态，每收到一个消息就会调用callback指定的函数一次，直到某个callback函数返回FALSE才结束。
关于callback，这里多说几句： PHP的call_back是支持使用数组的，比如： $c = new MyClass(); $c->counter = 100; $q->consume( array($c,'myfunc') ) 这样就可以调用自己写的处理类。MyClass中myfunc的参数定义，与上例中processMessage一样就行。
在上述示例中，使用的$routingkey = ''， 意味着接收全部的消息。我们可以将其改为 $routingkey = 'key_1'，可以看到结果中仅有设置routingkey为key_1的内容了。
注意： routingkey = 'key_1' 与 routingkey = 'key_2' 是两个不同的队列。假设： client1 与 client2 都连接到 key_1 的队列上，一个消息被client1处理之后，就不会被client2处理。而 routingkey = '' 是另类，client_all绑定到 '' 上，将消息全都处理后，client1和client2上也就没有消息了。
在程序设计上，需要规划好exchange的名称，以及如何使用key区分开不同类型的标记，在消息产生的地方插入发送消息代码。后端处理，可以针对每一个key启动一个或多个client，以提高消息处理的实时性。如何使用PHP进行多线程的消息处理，将在下一节中讲述。
更多消息模型，可以参考： http://www.rabbitmq.com/tutorials/tutorial-two-python.html

public function mfun_l1vm_msg_send($msg)
{
//配置信息
$conn_args = array(
'host' => MFUN_MQ_RABBIT_HOST,
'port' => MFUN_MQ_RABBIT_PORT,
'login' => MFUN_MQ_RABBIT_LOGIN,
'password' => MFUN_MQ_RABBIT_PSWD,
'vhost'=> MFUN_MQ_RABBIT_VHOST);
//$e_name = 'e_linvo'; //交换机名
//$q_name = 'q_linvo'; //无需队列名
//$k_route = 'key_1'; //路由key

//创建连接和channel
$conn = new AMQPConnection($conn_args);
if (!$conn->connect()) {
die("Cannot connect to the broker!\n");
}
$channel = new AMQPChannel($conn);

//消息内容
//$message = "TEST MESSAGE! 测试消息！";
$message = $msg;

//创建交换机对象
$ex = new AMQPExchange($channel);
$ex->setName(MFUN_MQ_RABBIT_EXCHANGE);

//发送消息
$channel->startTransaction(); //开始事务
for($i=0; $i<5; ++$i){
echo "Send Message:".$ex->publish($message, MFUN_MQ_RABBIT_EXCHANGE)."\n";
}
$channel->commitTransaction(); //提交事务
$conn->disconnect();
}

public function mfun_l1vm_msg_rcv()
{
//配置信息
$conn_args = array(
'host' => MFUN_MQ_RABBIT_HOST,
'port' => MFUN_MQ_RABBIT_PORT,
'login' => MFUN_MQ_RABBIT_LOGIN,
'password' => MFUN_MQ_RABBIT_PSWD,
'vhost'=> MFUN_MQ_RABBIT_VHOST);
//$e_name = 'e_linvo'; //交换机名
//$q_name = 'q_linvo'; //队列名
//$k_route = 'key_1'; //路由key

//创建连接和channel
$conn = new AMQPConnection($conn_args);
if (!$conn->connect()) {
die("Cannot connect to the broker!\n");
}
$channel = new AMQPChannel($conn);

//创建交换机
$ex = new AMQPExchange($channel);
$ex->setName(MFUN_MQ_RABBIT_EXCHANGE);
$ex->setType(AMQP_EX_TYPE_DIRECT); //direct类型
$ex->setFlags(AMQP_DURABLE); //持久化
echo "Exchange Status:".$ex->declare()."\n";

//创建队列
$msgQue = new AMQPQueue($channel);
$msgQue->setName(MFUN_MQ_RABBIT_QUEUE);
$msgQue->setFlags(AMQP_DURABLE); //持久化
echo "Message Total:".$msgQue->declare()."\n";

//绑定交换机与队列，并指定路由键
echo 'Queue Bind: '.$msgQue->bind(MFUN_MQ_RABBIT_EXCHANGE, MFUN_MQ_RABBIT_ROUTE_KEY)."\n";

//阻塞模式接收消息
echo "Message:\n";
while(True){
$msgQue->consume('processMessage');
$msgQue->consume('processMessage', AMQP_AUTOACK); //自动ACK应答
}
$conn->disconnect();
}

/**
* 消费回调函数
* 处理消息
*/
/*
function processMessage($envelope, $queue) {
var_dump($envelope->getRoutingKey);
$msg = $envelope->getBody();
echo $msg."\n"; //处理消息
$queue->ack($envelope->getDeliveryTag()); //手动发送ACK应答
}


*/
