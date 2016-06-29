<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/3
 * Time: 16:25
 */
//include_once "../l1comvm/vmlayer.php";
//header("Content-type:text/html;charset=utf-8");

class classDbiL4aqycUi
{
    //构造函数
    public function __construct()
    {

    }

    /**********************************************************************************************************************
     *                                         UI用户相关操作DB API                                                        *
     *********************************************************************************************************************/

    //随机生成8位字符串作为session id
    private function getRandomSid($strlen)
    {

        $str = "";
        $str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < $strlen; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }


    private function getRandomUid($strlen)
    {

        $str = "";
        $str_pol = "0123456789";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < $strlen; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }

    /*

    -- --------------------------------------------------------

    --
    -- 表的结构 `t_session`
    --

    CREATE TABLE IF NOT EXISTS `t_session` (
      `sessionid` char(8) NOT NULL,
      `uid` char(20) NOT NULL,
      `lastupdate` int(4) NOT NULL,
      PRIMARY KEY (`sessionid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    --
    -- 转存表中的数据 `t_session`
    --

    INSERT INTO `t_session` (`sessionid`, `uid`, `lastupdate`) VALUES
    ('KpjEAyCZ', 'UID001', 1466300141);

    */


    //更新UI用户session ID
    private function updateSession ($uid, $sessionid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $timestamp = time();
        //先检查用户名是否存在
        $result = $mysqli->query("SELECT * FROM `t_session` WHERE `uid` = '$uid'");
        if (($result->num_rows)>0)
        {
            $query_str = "UPDATE `t_session` SET `sessionid` = '$sessionid', `lastupdate` = '$timestamp' WHERE (`uid` = '$uid')";
            $result=$mysqli->query($query_str);
        }
        else    //否则插入一条新记录
        {
            $result=$mysqli->query("INSERT INTO `t_session` (uid, sessionid, lastupdate) VALUES ('$uid', '$sessionid', '$timestamp')");
        }

        $mysqli->close();
        return $result;
    }

    //当前登录用户session id检查,如果session id对应UID不存在或者session id的更新时间超过有效时间，则返回false，否则返回UID
    public function dbi_session_check($sessionid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_session` WHERE `sessionid` = '$sessionid'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $lastupdate = $row['lastupdate'];
            $currenttime = time();
            if($currenttime < ($lastupdate + SESSIONID_VALID_TIME))
                $uid = $row['uid'];
            else
                $uid = "";
        }
        else
            $uid = "";

        $mysqli->close();
        return $uid;
    }


    /*
     -- --------------------------------------------------------

     --
     -- 表的结构 `t_account`
     --

     CREATE TABLE IF NOT EXISTS `t_account` (
       `uid` char(10) NOT NULL,
       `user` char(20) DEFAULT NULL,
       `nick` char(20) DEFAULT NULL,
       `pwd` char(20) DEFAULT NULL,
       `attribute` char(10) DEFAULT NULL,
       `phone` char(20) DEFAULT NULL,
       `email` char(50) DEFAULT NULL,
       `regdate` date DEFAULT NULL,
       `city` char(10) DEFAULT NULL,
       `backup` text,
       PRIMARY KEY (`uid`)
     ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

     --
     -- 转存表中的数据 `t_account`
     --

     INSERT INTO `t_account` (`uid`, `user`, `nick`, `pwd`, `attribute`, `phone`, `email`, `regdate`, `city`, `backup`) VALUES
     ('UID001', 'admin', '爱启用户', 'admin', '管理员', '13912341234', '13912341234@cmcc.com', '2016-05-28', '上海', ''),
     ('UID002', '李四', '老李', 'li_4', '管理员', '13912341234', '13912341234@cmcc.com', '2016-06-17', '上海', ''),
     ('UID003', 'user_01', '用户01', 'user01', '管理员', '13912349901', '13912349901@qq.com', '2016-04-01', '上海', NULL),
     ('UID004', 'user_02', '用户2', 'user02', '用户', '13912349902', '13912349902@qq.com', '2016-05-28', '上海', ''),
     ('UID005', 'user_03', '用户三', 'user03', '用户', '13912349903', '13912349902@qq.com', '2016-05-28', '上海', '');

     */

    //UI login request  用户登录请求
    public function dbi_login_req($name, $password)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");
        $mysqli->query("SET NAMES utf8");

        //先检查用户名是否存在
        $query_str = "SELECT * FROM `t_account` WHERE `user` = '$name'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $pwd = $row['pwd'];
            $uid = $row['uid'];
            $attribute = $row['attribute'];
            if ($attribute == 'admin' or  $attribute == '管理员')
                $admin = "true";
            else
                $admin = "false";

            if ($pwd == $password) {
                $strlen = SESSION_ID_LEN;
                $sessionid = $this->getRandomSid($strlen);
                $userinfo = array(
                    'status' => "true",
                    'text' => "login success",
                    'key' => $sessionid,
                    'admin' => $admin);
                $this->updateSession($uid, $sessionid);
            }
            else {
                $userinfo = array(
                    'status' => "false",
                    'text' => "password invalid",
                    'key' => null,
                    'admin' => null);
            }
        }
        else {
            $userinfo = array(
                'status' => "false",
                'text' => "user name not exist",
                'key' => null,
                'admin' => null);
        }

        $mysqli->close();
        return $userinfo;
    }

    //UI UserInfo request  获取当前登录用户信息
    public function dbi_userinfo_req($sessionid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $userinfo = ""; //初始化

        $query_str = "SELECT * FROM `t_session` WHERE `sessionid` = '$sessionid'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $uid = $row['uid'];
            $lastupdate = $row['lastupdate'];
            $now= time();
            if ($lastupdate < $now + SESSIONID_VALID_TIME) //sessionid 在有效时间内
            {
                $query_str = "SELECT * FROM `t_account` WHERE `uid` = '$uid'";
                $result = $mysqli->query($query_str);
                if (($result->num_rows)>0)
                {
                    $row = $result->fetch_array();
                    $attribute = $row['attribute'];
                    if ($attribute == 'admin' or  $attribute == '管理员')
                        $admin = "true";
                    else
                        $admin = "false";

                    $userinfo = array(
                        'id' => $sessionid,
                        'name' => $row['user'],
                        'admin' => $admin,
                        'city' => $row['city'] );
                }
            }
        }

        $mysqli->close();
        return $userinfo;
    }

    //查询用户表中记录总数
    public function dbi_usernum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "SELECT * FROM `t_account` WHERE 1";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    //UI UserTable request, 获取所有用户信息表
    public function dbi_usertable_req($uid_start, $uid_total)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_account` limit $uid_start, $uid_total";
        $result = $mysqli->query($query_str);

        $usertable = array();
        while($row = $result->fetch_array())
        {
            $attribute = $row['attribute'];
            if ($attribute == 'admin' or  $attribute == '管理员')
                $attribute = "true";
            else
                $attribute = "false";
            $temp = array(
                'id' => $row['uid'],
                'name' => $row['user'],
                'nickname'=> $row['nick'],
                'mobile' => $row['phone'],
                'mail' => $row['email'],
                'type' => $attribute,
                'date' => $row['regdate'],
                'memo' => $row['backup']
            );
            array_push($usertable,$temp);
        }

        $mysqli->close();
        return $usertable;
    }

    /*
    -- --------------------------------------------------------
    --
    -- 表的结构 `t_authlist`
    --

    CREATE TABLE IF NOT EXISTS `t_authlist` (
      `sid` int(4) NOT NULL AUTO_INCREMENT,
      `uid` char(10) NOT NULL,
      `auth_code` char(20) DEFAULT NULL,
      PRIMARY KEY (`sid`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

    --
    -- 转存表中的数据 `t_authlist`
    --

    INSERT INTO `t_authlist` (`sid`, `uid`, `auth_code`) VALUES
    (1, 'UID001', 'P_0001'),
    (2, 'UID001', 'P_0002'),
    (3, 'UID003', 'PG_1111'),
    (64, 'UID005', 'P_0002'),
    (65, 'UID005', 'P_0004'),
    (66, 'UID005', 'P_0012'),
    (67, 'UID004', 'P_0008'),
    (68, 'UID004', 'P_0009'),
    (69, 'UID004', 'P_0010'),
    (70, 'UID001', 'P_0003'),
    (72, 'UID002', 'P_0004'),
    (73, 'UID002', 'P_0010'),
    (74, 'UID002', 'P_0012');


    */
    //UI UserNew request,添加新用户信息
    public function dbi_userinfo_new($userinfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");
        //$mysqli->query("set character_set_connection = utf8");
        $mysqli->query("SET NAMES utf8");

        $uid = UID_PREFIX.$this->getRandomUid(3);  //UID的分配机制将来要重新考虑，避免重复
        $user = $userinfo["name"];
        $nick = $userinfo["nickname"];
        $pwd = $userinfo["password"];
        $attribute = $userinfo["type"];
        $phone = $userinfo["mobile"];
        $email = $userinfo["mail"];
        $regdate = date("Y-m-d", time());
        $backup = $userinfo["memo"];
        $city = "上海"; //暂定用户所在城市，将来需要修改

        $auth = array();
        $auth = $userinfo["auth"];

        $query_str = "SELECT * FROM `t_account` WHERE `user` = '$user'";
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0) //重复，则覆盖
        {
            $query_str = "UPDATE `t_account` SET `nick` = '$nick',`pwd` = '$pwd',`attribute` = '$attribute',`phone` = '$phone',`email` = '$email',
                          `regdate` = '$regdate', `city` = '$city',`backup` = '$backup' WHERE (`user` = '$user' )";
            $result = $mysqli->query($query_str);
        }
        else //不存在，新增
        {
            $query_str = "INSERT INTO `t_account` (uid,user,nick,pwd,attribute,phone,email,regdate,city,backup)
                                  VALUES ('$uid','$user','$nick','$pwd','$attribute','$phone','$email', '$regdate','$city','$backup')";

            $result = $mysqli->query($query_str);
        }

        $query_str = "DELETE FROM `t_authlist` WHERE `uid` = '$uid' ";  //先删除当前所有授权的项目或者项目组list
        $result = $mysqli->query($query_str);

        if(!empty($auth)){
            $i = 0;
            while ($i < count($auth))
            {
                $authcode = $auth[$i]["id"];
                $query_str = "INSERT INTO `t_authlist` (uid, auth_code) VALUE ('$uid', '$authcode')";
                $result = $mysqli->query($query_str);
                $i++;
            }
        }

        $mysqli->close();
        return $result;
    }

    //UI UserMod request,添加新用户信息
    public function dbi_userinfo_update($userinfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");
        //$mysqli->query("set character_set_connection = utf8");
        $mysqli->query("SET NAMES utf8");

        $uid = $userinfo["id"];
        $user = $userinfo["name"];
        $nick = $userinfo["nickname"];
        $pwd = $userinfo["password"];
        $phone = $userinfo["mobile"];
        $email = $userinfo["mail"];
        $regdate = date("Y-m-d", time());
        $backup = $userinfo["memo"];
        $auth = array();
        $auth = $userinfo["auth"];

        $attribute = $userinfo["type"];
        if ($attribute == "true")
            $attribute = "管理员";
        else
            $attribute = "用户";


        if (!empty($pwd)) //如果输入有密码，则覆盖
        {
            $query_str = "UPDATE `t_account` SET `user` = '$user',`nick` = '$nick',`pwd` = '$pwd',`attribute` = '$attribute',`phone` = '$phone',`email` = '$email',
                          `regdate` = '$regdate', `backup` = '$backup' WHERE (`uid` = '$uid' )";
            $result = $mysqli->query($query_str);
        }
        else
        {
            $query_str = "UPDATE `t_account` SET `user` = '$user',`nick` = '$nick',`attribute` = '$attribute',`phone` = '$phone',`email` = '$email',
                          `regdate` = '$regdate', `backup` = '$backup' WHERE (`uid` = '$uid' )";
            $result = $mysqli->query($query_str);
        }


        $query_str = "DELETE FROM `t_authlist` WHERE `uid` = '$uid' ";  //先删除当前所有授权的项目或者项目组list
        $result = $mysqli->query($query_str);

        if(!empty($auth)){
            $i = 0;
            while ($i < count($auth))
            {
                $authcode = $auth[$i]["id"];
                $query_str = "INSERT INTO `t_authlist` (uid, auth_code) VALUE ('$uid', '$authcode')";
                $result = $mysqli->query($query_str);
                $i++;
            }
        }

        $mysqli->close();
        return $result;
    }

    //UI UserDel request
    public function dbi_userinfo_delete($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_account` WHERE `uid` = '$uid'";  //删除用户信息表
        $result1 = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_authlist` WHERE `uid` = '$uid'";  //删除该用户授权的项目和项目组list
        $result2 = $mysqli->query($query_str);

        $result = $result1 and $result2;

        $mysqli->close();
        return $result;
    }

    /**********************************************************************************************************************
     *                          项目Project和项目组ProjectGroup相关操作DB API                                               *
     *********************************************************************************************************************/


    /*
    -- --------------------------------------------------------

    --
    -- 表的结构 `t_projinfo`
    --

    CREATE TABLE IF NOT EXISTS `t_projinfo` (
      `p_code` char(20) NOT NULL,
      `p_name` char(50) NOT NULL,
      `chargeman` char(20) NOT NULL,
      `telephone` char(20) NOT NULL,
      `department` char(30) NOT NULL,
      `address` char(30) NOT NULL,
      `country` char(20) NOT NULL,
      `street` char(20) NOT NULL,
      `square` int(4) NOT NULL,
      `starttime` date NOT NULL,
      `pre_endtime` date NOT NULL,
      `true_endtime` date NOT NULL,
      `stage` text NOT NULL,
      PRIMARY KEY (`p_code`),
      KEY `statCode` (`p_code`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    --
    -- 转存表中的数据 `t_projinfo`
    --

    INSERT INTO `t_projinfo` (`p_code`, `p_name`, `chargeman`, `telephone`, `department`, `address`, `country`, `street`, `square`, `starttime`, `pre_endtime`, `true_endtime`, `stage`) VALUES
    ('P_0014', '万宝国际广场', '张三', '13912345678', '上海建筑', '延安西路500号', '长宁区', '', 10000, '2015-04-01', '2016-05-01', '2016-05-31', '项目延期1月'),
    ('P_0019', '港运大厦', '张三', '13912345678', '', '杨树浦路1963弄24号', '虹口区', '', 0, '2016-04-01', '0000-00-00', '0000-00-00', ''),
    ('P_0002', '浦东环球金融中心工程', '张三', '13912345678', '浦东建筑', '世纪大道100号', '浦东新区', '', 40000, '2015-01-01', '0000-00-00', '0000-00-00', '项目延期'),
    ('P_0004', '金桥创科园', '李四', '13912345678', '', '桂桥路255号', '浦东新区', '', 0, '2016-04-01', '0000-00-00', '0000-00-00', ''),
    ('P_0005', '江湾体育场', '李四', '13912345678', '上海建筑', '国和路346号', '杨浦区', '', 0, '2016-04-13', '0000-00-00', '0000-00-00', ''),
    ('P_0006', '滨海新村', '李四', '13912345678', '', '同泰北路100号', '宝山区', '', 0, '2016-02-01', '0000-00-00', '0000-00-00', ''),
    ('P_0007', '银都苑', '李四', '13912345678', '', '银都路3118弄', '闵行区', '', 0, '2016-02-01', '0000-00-00', '0000-00-00', ''),
    ('P_0008', '万科花园小城', '王五', '13912345678', '', '龙吴路5710号', '闵行区', '', 0, '2016-02-18', '0000-00-00', '0000-00-00', ''),
    ('P_0009', '合生国际花园', '王五', '13912345678', '', '长兴东路1290', '松江区', '', 0, '2016-02-18', '0000-00-00', '0000-00-00', ''),
    ('P_0010', '江南国际会议中心', '王五', '13912345678', '', '青浦区Y095(阁游路)', '青浦区', '', 0, '2016-02-18', '0000-00-00', '0000-00-00', ''),
    ('P_0011', '佳邸别墅', '王五', '13912345678', '', '盈港路1555弄', '青浦区', '', 0, '2016-02-18', '0000-00-00', '0000-00-00', ''),
    ('P_0012', '西郊河畔家园', '王五', '13912345678', '', '繁兴路469弄', '闵行区', '华漕镇', 0, '2016-02-18', '0000-00-00', '0000-00-00', ''),
    ('P_0013', '东视大厦', '赵六', '13912345678', '', '东方路2000号', '浦东新区', '南码头', 0, '2016-02-18', '0000-00-00', '0000-00-00', ''),
    ('P_0001', '曙光大厦', '赵六', '13912345678', '', '普安路189号', '黄埔区', '淮海中路街道', 0, '2016-02-29', '0000-00-00', '0000-00-00', ''),
    ('P_0015', '上海贝尔', '赵六', '13912345678', '', '西藏北路525号', '闸北区', '芷江西路街道', 0, '2016-03-15', '0000-00-00', '0000-00-00', ''),
    ('P_0016', '嘉宝大厦', '赵六', '13912345678', '', '洪德路1009号', '嘉定区', '马陆镇', 0, '2015-03-19', '0000-00-00', '0000-00-00', ''),
    ('P_0017', '金山豪庭', '赵六', '13912345678', '', '卫清东路2988', '金山区', '', 0, '2015-08-25', '0000-00-00', '0000-00-00', ''),
    ('P_0018', '临港城投大厦', '赵六', '13912345678', '', '环湖西一路333号', '浦东新区', '', 0, '2015-11-30', '0000-00-00', '0000-00-00', ''),
    ('P_0003', '金鹰大厦', '张三', '13912345678', '上海爱启', '含笑路80号', '浦东新区', '联洋街道', 10000, '2015-04-30', '2016-05-01', '2016-05-31', '项目进行中');


     */


    //查询项目表中记录总数
    public function dbi_all_projnum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "SELECT * FROM `t_projinfo` WHERE 1";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    /*
    -- --------------------------------------------------------

    --
    -- 表的结构 `t_projgroup`
    --

    CREATE TABLE IF NOT EXISTS `t_projgroup` (
      `pg_code` char(20) NOT NULL,
      `pg_name` char(50) DEFAULT NULL,
      `owner` char(20) DEFAULT NULL,
      `phone` char(20) DEFAULT NULL,
      `department` char(50) DEFAULT NULL,
      `addr` char(100) DEFAULT NULL,
      `backup` text,
      PRIMARY KEY (`pg_code`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    --
    -- 转存表中的数据 `t_projgroup`
    --

    INSERT INTO `t_projgroup` (`pg_code`, `pg_name`, `owner`, `phone`, `department`, `addr`, `backup`) VALUES
    ('PG_1111', '扬尘项目组', '张三', '13912341234', '扬尘项目组单位', '扬尘项目组单位地址', '该项目组管理所有扬尘项目的用户，项目以及相关权限'),
    ('PG_2222', '污水处理项目组', '李四', '13912349999', '污水项目组单位', '污水项目组单位地址', '该项目组管理所有污水处理项目的用户，项目以及相关权限');
        */

    //查询项目组表中记录总数
    public function dbi_all_pgnum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "SELECT * FROM `t_projgroup` WHERE 1";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    //UI PGTable request, 获取全部项目组列表信息
    public function dbi_all_pgtable_req($start, $total)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_projgroup` limit $start, $total";
        $result = $mysqli->query($query_str);
        $pgtable = array();
        while($row = $result->fetch_array())
        {

            $temp = array(
                'PGCode' => $row['pg_code'],
                'PGName' => $row['pg_name'],
                'ChargeMan' => $row['owner'],
                'Telephone' => $row['phone'],
                'Department' => $row['department'],
                'Address' => $row['addr'],
                'Stage' => $row['backup']
            );
            array_push($pgtable, $temp);
        }

        $mysqli->close();
        return $pgtable;
    }

    //UI ProjTable request, 获取全部项目列表信息
    public function dbi_all_projtable_req($start, $total)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_projinfo` limit $start, $total";
        $result = $mysqli->query($query_str);

        $projtable = array();
        while($row = $result->fetch_array())
        {

            $temp = array(
                'ProjCode' => $row['p_code'],
                'ProjName' => $row['p_name'],
                'ChargeMan' => $row['chargeman'],
                'Telephone' => $row['telephone'],
                'Department' => $row['department'],
                'Address' => $row['address'],
                'ProStartTime' => $row['starttime'],
                'Stage' => $row['stage']
            );
            array_push($projtable, $temp);
        }

        $mysqli->close();
        return $projtable;
    }

    //UI ProjectPGList request, 获取所有项目及项目组列表
    public function dbi_all_projpglist_req()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $list = array();
        $query_str = "SELECT * FROM `t_projgroup` WHERE 1 ";
        $result = $mysqli->query($query_str);
        while($row = $result->fetch_array()) //获得所有项目组列表
        {
            $temp = array(
                'id' => $row['pg_code'],
                'name' => $row['pg_name']
            );
            array_push($list, $temp);
        }

        $query_str = "SELECT * FROM `t_projinfo` WHERE 1 ";
        $result = $mysqli->query($query_str);
        while($row = $result->fetch_array()) //获得所有项目列表
        {
            $temp = array(
                'id' => $row['p_code'],
                'name' => $row['p_name']
            );
            array_push($list, $temp);
        }

        $mysqli->close();
        return $list;
    }

    //UI ProjectList request, 获取所有项目列表
    public function dbi_all_projlist_req()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $list = array();

        $query_str = "SELECT * FROM `t_projinfo` WHERE 1 ";
        $result = $mysqli->query($query_str);
        while($row = $result->fetch_array()) //获得所有项目列表
        {
            $temp = array(
                'id' => $row['p_code'],
                'name' => $row['p_name']
            );
            array_push($list, $temp);
        }

        $mysqli->close();
        return $list;
    }

    //UI PGlist request, 获取该用户授权的全部项目组列表
    public function dbi_user_pglist_req($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_authlist` WHERE `uid` = '$uid' ";
        $result = $mysqli->query($query_str);

        $pglist = array();
        while($row = $result->fetch_array())
        {
            $pgcode = "";
            $authcode = $row['auth_code'];
            $fromat = substr($authcode, 0, CODE_FORMAT_LEN);
            if ($fromat == PG_CODE_PREFIX)
                $pgcode = $authcode;

            $query_str = "SELECT * FROM `t_projgroup` WHERE `pg_code` = '$pgcode'";
            $resp = $mysqli->query($query_str);

            if (($resp->num_rows)>0) {
                $list = $resp->fetch_array();
                $temp = array(
                    'id' => $list['pg_code'],
                    'name' => $list['pg_name']
                );
                array_push($pglist, $temp);
            }
        }

        $mysqli->close();
        return $pglist;
    }

    //UI ProjList request, 获取该用户授权的全部项目列表,包括授权项目组下面的项目list
    public function dbi_user_projlist_req($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_authlist` WHERE `uid` = '$uid' ";
        $result = $mysqli->query($query_str);

        $projlist = array();
        if($result->num_rows>0)
        {
            while($row = $result->fetch_array())
            {
                $authcode = $row['auth_code'];
                $fromat = substr($authcode, 0, CODE_FORMAT_LEN);
                if($fromat == PROJ_CODE_PREFIX)  //取得code为项目号
                {
                    $pcode = $authcode;
                    $query_str = "SELECT * FROM `t_projinfo` WHERE `p_code` = '$pcode'";
                    $resp = $mysqli->query($query_str);
                    if (($resp->num_rows)>0) {
                        $list = $resp->fetch_array();
                        $temp = array(
                            'id' => $list['p_code'],
                            'name' => $list['p_name']
                        );
                        array_push($projlist, $temp);
                    }
                }
                elseif($fromat == PG_CODE_PREFIX)  //取得的code为项目组号
                {
                    $pgcode = $authcode;
                    $temp = $this->dbi_pg_projlist_req($pgcode);
                    for($i=0; $i<count($temp); $i++)
                        array_push($projlist, $temp[$i]);
                }
            }
        }

        $mysqli->close();
        return $projlist;
    }


    //UI ProjectPGList request, 获取该用户授权的项目及项目组列表
    public function dbi_user_projpglist_req($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_authlist` WHERE `uid` = '$uid' ";
        $result = $mysqli->query($query_str);

        $table = array();
        while($row = $result->fetch_array())
        {
            //获得授权的项目组
            $pgcode = "";
            $pcode = "";
            $authcode = $row['auth_code'];
            $fromat = substr($authcode, 0, CODE_FORMAT_LEN);
            if ($fromat == PG_CODE_PREFIX)
                $pgcode = $authcode;
            elseif($fromat == PROJ_CODE_PREFIX)
                $pcode = $authcode;

            $query_str = "SELECT * FROM `t_projgroup` WHERE `pg_code` = '$pgcode'";
            $resp = $mysqli->query($query_str);

            if (($resp->num_rows)>0) {
                $info = $resp->fetch_array();
                $temp = array(
                    'id' => $info['pg_code'],
                    'name' => $info['pg_name']
                );
                array_push($table, $temp);
            }

            //获得授权的项目
            $query_str = "SELECT * FROM `t_projinfo` WHERE `p_code` = '$pcode'";
            $resp = $mysqli->query($query_str);

            if (($resp->num_rows)>0) {
                $info = $resp->fetch_array();
                $temp = array(
                    'id' => $info['p_code'],
                    'name' => $info['p_name']
                );
                array_push($table, $temp);
            }
        }

        $mysqli->close();
        return $table;
    }

    /*
    -- --------------------------------------------------------

    --
    -- 表的结构 `t_projmapping`
    --

    CREATE TABLE IF NOT EXISTS `t_projmapping` (
      `sid` int(4) NOT NULL AUTO_INCREMENT,
      `p_code` char(20) NOT NULL,
      `pg_code` char(20) NOT NULL,
      PRIMARY KEY (`sid`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

    --
    -- 转存表中的数据 `t_projmapping`
    --

    INSERT INTO `t_projmapping` (`sid`, `p_code`, `pg_code`) VALUES
    (1, 'P_0001', 'PG_1111'),
    (2, 'P_0002', 'PG_2222'),
    (5, 'P_0004', 'PG_1111'),
    (6, 'P_0006', 'PG_2222'),
    (7, 'P_0005', 'PG_1111'),
    (8, 'P_0007', 'PG_2222'),
    (9, 'P_0008', 'PG_2222'),
    (10, 'P_0009', 'PG_1111'),
    (11, 'P_0010', 'PG_2222'),
    (12, 'P_0003', 'PG_1111'),
    (13, 'P_0011', 'PG_1111'),
    (14, 'P_0012', 'PG_1111'),
    (15, 'P_0013', 'PG_1111'),
    (16, 'P_0014', 'PG_1111'),
    (17, 'P_0015', 'PG_1111'),
    (18, 'P_0018', 'PG_2222'),
    (19, 'P_0017', 'PG_2222'),
    (20, 'P_0016', 'PG_2222'),
    (36, 'P_0015', 'PG_3333'),
    (37, 'P_0017', 'PG_3333'),
    (38, 'P_0018', 'PG_3333');




     */
    //查询项目组下面包含的项目列表
    public function dbi_pg_projlist_req($pg_code)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_projmapping` WHERE `pg_code` = '$pg_code' ";
        $result = $mysqli->query($query_str);

        $projlist = array();
        while($row = $result->fetch_array())
        {
            $pcode = $row['p_code'];
            $query_str = "SELECT * FROM `t_projinfo` WHERE `p_code` = '$pcode'";
            $resp = $mysqli->query($query_str);

            if (($resp->num_rows)>0) {
                $list = $resp->fetch_array();
                $temp = array(
                    'id' => $list['p_code'],
                    'name' => $list['p_name']
                );
                array_push($projlist, $temp);
            }
        }

        $mysqli->close();
        return $projlist;
    }

    //UI PGNew & PGMod request,添加新项目组信息或者修改项目组信息
    public function dbi_pginfo_update($pginfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");
        $mysqli->query("SET NAMES utf8");

        //$session = $pginfo["user"];
        $pgcode = $pginfo["PGCode"];
        $pgname = $pginfo["PGName"];
        $owner = $pginfo["ChargeMan"];
        $phone = $pginfo["Telephone"];
        $department = $pginfo["Department"];
        $addr = $pginfo["Address"];
        $stage = $pginfo["Stage"];
        $projlist = $pginfo["Projlist"];

        $query_str = "SELECT * FROM `t_projgroup` WHERE `pg_code` = '$pgcode'";
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0) //重复，则覆盖
        {
            $query_str = "UPDATE `t_projgroup` SET `pg_name` = '$pgname',`owner` = '$owner',`phone` = '$phone',`department` = '$department',
                          `addr` = '$addr', `backup` = '$stage' WHERE (`pg_code` = '$pgcode' )";
            $result1 = $mysqli->query($query_str);
        }
        else //不存在，新增
        {
            $query_str = "INSERT INTO `t_projgroup` (pg_code,pg_name,owner,phone,department,addr,backup)
                                  VALUES ('$pgcode','$pgname','$owner','$phone','$department', '$addr','$stage')";

            $result1 = $mysqli->query($query_str);
        }

        //如果存在，先删除项目组所有当前授权的项目list
        $query_str = "DELETE FROM `t_projmapping` WHERE `pg_code` = '$pgcode' ";
        $result2 = $mysqli->query($query_str);

        //添加授权的项目list到该项目组
        if(!empty($projlist)){
            $i = 0;
            while ($i < count($projlist))
            {
                $pcode = $projlist[$i]["id"];
                $query_str = "INSERT INTO `t_projmapping` (p_code, pg_code) VALUE ('$pcode', '$pgcode')";
                $result3 = $mysqli->query($query_str);
                $i++;
            }
        }

        $result = $result1 and $result2;
        $mysqli->close();
        return $result;
    }

    //UI ProjNew & ProjMod request,添加新项目信息或者修改项目信息
    public function dbi_projinfo_update($projinfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");
        $mysqli->query("SET NAMES utf8");

        //$session = $projinfo["user"];
        $pcode = $projinfo["ProjCode"];
        $pname = $projinfo["ProjName"];
        $chargeman = $projinfo["ChargeMan"];
        $telephone = $projinfo["Telephone"];
        $department = $projinfo["Department"];
        $addr = $projinfo["Address"];
        $starttime = $projinfo["ProStartTime"];
        $stage = $projinfo["Stage"];

        $query_str = "SELECT * FROM `t_projinfo` WHERE `p_code` = '$pcode'";
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0) //重复，则覆盖
        {
            $query_str = "UPDATE `t_projinfo` SET `p_name` = '$pname',`chargeman` = '$chargeman',`telephone` = '$telephone',`department` = '$department',
                          `address` = '$addr', `starttime` = '$starttime', `stage` = '$stage' WHERE (`p_code` = '$pcode' )";
            $result = $mysqli->query($query_str);
        }
        else //不存在，新增
        {
            $query_str = "INSERT INTO `t_projinfo` (p_code,p_name,chargeman,telephone,department,address,starttime,stage)
                                  VALUES ('$pcode','$pname','$chargeman','$telephone','$department', '$addr','$starttime','$stage')";

            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    /*
    --
    -- 表的结构 `t_siteinfo`
    --

    CREATE TABLE IF NOT EXISTS `t_siteinfo` (
      `statcode` char(20) NOT NULL,
      `name` char(50) NOT NULL,
      `devcode` char(20) NOT NULL,
      `p_code` char(20) NOT NULL,
      `starttime` date NOT NULL,
      `altitude` int(4) NOT NULL,
      `flag_la` char(1) NOT NULL,
      `latitude` int(4) NOT NULL,
      `flag_lo` char(1) NOT NULL,
      `longitude` int(4) NOT NULL,
      PRIMARY KEY (`statcode`),
      KEY `statCode` (`statcode`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    --
    -- 转存表中的数据 `t_siteinfo`
    --

    INSERT INTO `t_siteinfo` (`statcode`, `name`, `devcode`, `p_code`, `starttime`, `altitude`, `flag_la`, `latitude`, `flag_lo`, `longitude`) VALUES
    ('120101014', '万宝国际广场西监测点', 'HCU_SH_0314', 'P_0014', '0000-00-00', 0, 'N', 31223441, 'E', 121442703),
    ('120101017', '港运大厦东监测点', 'HCU_SH_0317', 'P_0017', '0000-00-00', 0, 'N', 31255719, 'E', 121517700),
    ('120101002', '环球金融中心主监测点', 'HCU_SH_0302', 'P_0002', '0000-00-00', 0, 'N', 31240246, 'E', 121514168),
    ('120101004', '金桥创科园主入口监测点', 'HCU_SH_0304', 'P_0004', '0000-00-00', 0, 'N', 31248271, 'E', 121615476),
    ('120101005', '江湾体育场一号监测点', 'HCU_SH_0305', 'P_0005', '0000-00-00', 0, 'N', 31313004, 'E', 121525701),
    ('120101006', '滨海新村西监测点', 'HCU_SH_0306', 'P_0006', '0000-00-00', 0, 'N', 31382624, 'E', 121501387),
    ('120101008', '八号监测点', 'HCU_SH_0308', 'P_0008', '0000-00-00', 0, 'N', 31101605, 'E', 121404873),
    ('120101009', '九号监测点', 'HCU_SH_0309', 'P_0009', '0000-00-00', 0, 'N', 31043827, 'E', 121476450),
    ('120101010', '十号监测点', 'HCU_SH_0310', 'P_0010', '2016-06-08', 0, 'N', 31088973, 'E', 121295459),
    ('120101011', '十一号监测点', 'HCU_SH_0311', 'P_0011', '0000-00-00', 0, 'N', 31127234, 'E', 121062241),
    ('120101012', '十二号监测点', 'HCU_SH_0312', 'P_0012', '0000-00-00', 0, 'N', 31164430, 'E', 121102934),
    ('120101013', '十三号监测点', 'HCU_SH_0313', 'P_0013', '0000-00-00', 0, 'N', 31218057, 'E', 121297076),
    ('120101001', '曙光大厦主监测点', 'HCU_SH_0301', 'P_0001', '0000-00-00', 0, 'N', 31203650, 'E', 121526288),
    ('120101015', '十五号监测点', 'HCU_SH_0302', 'P_0015', '0000-00-00', 0, 'N', 31228283, 'E', 121485388),
    ('120101016', '十六号监测点', 'HCU_SH_0316', 'P_0016', '0000-00-00', 0, 'N', 31256691, 'E', 121475583),
    ('120101018', '十八号监测点', 'HCU_SH_0318', 'P_0018', '0000-00-00', 0, 'N', 31357885, 'E', 121256060),
    ('120101019', '十九号监测点', 'HCU_SH_0319', 'P_0019', '0000-00-00', 0, 'N', 30739094, 'E', 121360693),
    ('120101007', '七号监测点', 'HCU_SH_0307', 'P_0007', '0000-00-00', 0, 'N', 30900796, 'E', 121933166),
    ('120101003', '爱启工地主监测点', 'HCU_SH_0303', 'P_0003', '2016-06-01', 0, 'N', 31226542, 'E', 121556498);

    -- --------------------------------------------------------

    --
    -- 表的结构 `t_sitemapping`
    --

    CREATE TABLE IF NOT EXISTS `t_sitemapping` (
      `sid` int(4) NOT NULL AUTO_INCREMENT,
      `statcode` char(20) NOT NULL,
      `p_code` char(20) NOT NULL,
      PRIMARY KEY (`sid`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

    --
    -- 转存表中的数据 `t_sitemapping`
    --

    INSERT INTO `t_sitemapping` (`sid`, `statcode`, `p_code`) VALUES
    (1, '120101001', 'P_0001'),
    (2, '120101002', 'P_0002'),
    (3, '120101003', 'P_0003'),
    (4, '120101004', 'P_0004'),
    (5, '120101005', 'P_0005'),
    (6, '120101006', 'P_0006'),
    (7, '120101007', 'P_0007'),
    (8, '120101008', 'P_0008'),
    (9, '120101009', 'P_0009'),
    (10, '120101010', 'P_0010'),
    (11, '120101011', 'P_0011'),
    (12, '120101012', 'P_0012'),
    (13, '120101013', 'P_0013'),
    (14, '120101014', 'P_0014'),
    (15, '120101015', 'P_0015'),
    (16, '120101016', 'P_0016'),
    (17, '120101017', 'P_0017'),
    (18, '120101018', 'P_0018'),
    (19, '120101019', 'P_0019');
    */


    //UI ProjDel request，项目信息删除
    public function dbi_projinfo_delete($pcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_projinfo` WHERE `p_code` = '$pcode'";  //删除项目信息表
        $result1 = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_sitemapping` WHERE `p_code` = '$pcode'";  //删除项目和监测点的映射关系
        $result2 = $mysqli->query($query_str);

        $query_str = "UPDATE `t_siteinfo` SET `p_code` = '' WHERE (`p_code` = '$pcode' )"; //删除监测点表中的对应项目号
        $result3 = $mysqli->query($query_str);

        $result = $result1 and $result2 and $result3;

        $mysqli->close();
        return $result;
    }

    //UI PGDel request，项目组信息删除
    public function dbi_pginfo_delete($pgcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_projgroup` WHERE `pg_code` = '$pgcode'";  //删除项目组信息表
        $result1 = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_projmapping` WHERE `pg_code` = '$pgcode'";  //删除项目组和项目的映射关系
        $result2 = $mysqli->query($query_str);

        $result = $result1 and $result2;

        $mysqli->close();
        return $result;
    }



    /**********************************************************************************************************************
     *                                          监测点及HCU设备相关操作DB API                                               *
     *********************************************************************************************************************/
    //查询用户授权的stat_code和proj_code list
    private function dbi_user_statproj_inqury($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        //查询该用户授权的项目和项目组列表
        $query_str = "SELECT `auth_code` FROM `t_authlist` WHERE `uid` = '$uid'";
        $result = $mysqli->query($query_str);
        $p_list = array();
        $pg_list = array();
        while($row = $result->fetch_array())
        {
            $temp = $row["auth_code"];
            $fromat = substr($temp, 0, CODE_FORMAT_LEN);
            if($fromat == PROJ_CODE_PREFIX)
                array_push($p_list,$temp);
            elseif ($fromat == PG_CODE_PREFIX)
                array_push($pg_list,$temp);
        }

        //把授权的项目组列表里对应的项目号也取出来追加到项目列表，获得该用户授权的完整项目列表
        for($i=0; $i<count($pg_list); $i++)
        {
            $query_str = "SELECT `p_code` FROM `t_projmapping` WHERE `pg_code` = '$pg_list[$i]'";
            $result = $mysqli->query($query_str);
            while($row = $result->fetch_array())
            {
                $temp = $row["p_code"];
                array_push($p_list,$temp);
            }
        }

        //查询授权项目号下对应的所有监测点code
        $auth_list["p_code"] = array();
        $auth_list["stat_code"] = array();
        for($i=0; $i<count($p_list); $i++)
        {
            $query_str = "SELECT `statcode` FROM `t_sitemapping` WHERE `p_code` = '$p_list[$i]'";
            $result = $mysqli->query($query_str);
            while($row = $result->fetch_array())
            {
                $temp = $row["statcode"];
                array_push($auth_list["stat_code"] ,$temp);
                array_push($auth_list["p_code"] ,$p_list[$i]);
            }
        }

        $mysqli->close();
        return $auth_list;
    }



    //查询监控点表中记录总数
    public function dbi_all_sitenum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "SELECT * FROM `t_siteinfo` WHERE 1";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    //查询HCU设备表中记录总数
    public function dbi_all_hcunum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "SELECT * FROM `t_hcudevice` WHERE 1";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    //UI ProjPoint request,查询所有项目监测点列表
    public function dbi_all_sitelist_req()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_siteinfo` WHERE 1 ";
        $result = $mysqli->query($query_str);

        $sitelist = array();
        while($row = $result->fetch_array())
        {
            $temp = array(
                'id' => $row['statcode'],
                'name' => $row['name'],
                'ProjCode' => $row['p_code']
            );
            array_push($sitelist, $temp);
        }

        $mysqli->close();
        return $sitelist;
    }

    //UI ProjPoint request,查询项目下面包含的监测点列表
    public function dbi_proj_sitelist_req($p_code)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_siteinfo` WHERE `p_code` = '$p_code' ";
        $result = $mysqli->query($query_str);

        $sitelist = array();
        while($row = $result->fetch_array())
        {
            $temp = array(
                'id' => $row['statcode'],
                'name' => $row['name'],
                'ProjCode' => $p_code
            );
            array_push($sitelist, $temp);
        }

        $mysqli->close();
        return $sitelist;
    }

    //UI ProjTable request, 获取全部监测点列表信息
    public function dbi_all_sitetable_req($start, $total)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_siteinfo` limit $start, $total";
        $result = $mysqli->query($query_str);

        $sitetable = array();
        while($row = $result->fetch_array())
        {
            $pcode = $row['p_code'];
            $statcode = $row['statcode'];
            $statname = $row['name'];
            $longitude = $row['longitude'];
            $latitude = $row['latitude'];

            $query_str = "SELECT * FROM `t_projinfo` WHERE `p_code` = '$pcode'";      //查询监测点对应的项目号
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0) {
                $info = $resp->fetch_array();
                $temp = array(
                    'StatCode' => $statcode,
                    'StatName' => $statname,
                    'ProjCode' => $info['p_code'],
                    'ChargeMan' => $info['chargeman'],
                    'Telephone' => $info['telephone'],
                    'Longitude' => $longitude,
                    'Latitude' => $latitude,
                    'Department' => $info['department'],
                    'Address' => $info['address'],
                    'Country' => $info['country'],
                    'Street' => $info['street'],
                    'Square' => $info['square'],
                    'ProStartTime' => $info['starttime'],
                    'Stage' => $info['stage']
                );
                array_push($sitetable, $temp);
            }
        }

        $mysqli->close();
        return $sitetable;
    }


    //UI PointNew & PointMod request,添加监测点信息或者修改监测点信息
    public function dbi_siteinfo_update($siteinfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");
        $mysqli->query("SET NAMES utf8");

        $statcode = $siteinfo["StatCode"];
        $statname = $siteinfo["StatName"];
        $pcode = $siteinfo["ProjCode"];
        $chargeman = $siteinfo["ChargeMan"];
        $telephone = $siteinfo["Telephone"];
        $longitude = $siteinfo["Longitude"];
        $latitude = $siteinfo["Latitude"];
        $department = $siteinfo["Department"];
        $addr = $siteinfo["Address"];
        $country = $siteinfo["Country"];
        $street = $siteinfo["Street"];
        $square = $siteinfo["Square"];
        $starttime = $siteinfo["ProStartTime"];
        $stage = $siteinfo["Stage"];

        $query_str = "SELECT * FROM `t_siteinfo` WHERE `statcode` = '$statcode'";
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0) //重复，则覆盖
        {
            $query_str = "UPDATE `t_siteinfo` SET `name` = '$statname',`p_code` = '$pcode',`starttime` = '$starttime',
                          `latitude` = '$latitude',`longitude` = '$longitude' WHERE (`statcode` = '$statcode' )";
            $result1 = $mysqli->query($query_str);
        }
        else //不存在，新增
        {
            $query_str = "INSERT INTO `t_siteinfo` (statcode,name,p_code,starttime,latitude,longitude)
                                  VALUES ('$statcode','$statname','$pcode','$starttime','$latitude', '$longitude')";

            $result1 = $mysqli->query($query_str);
        }

        $query_str = "UPDATE `t_projinfo` SET `country` = '$country',`street` = '$street',`square` = '$square' WHERE (`p_code` = '$pcode' )";
        $result2 = $mysqli->query($query_str);

        $result = $result1 AND $result2;
        $mysqli->close();
        return $result;
    }

    //UI DevTable request, 获取全部HCU设备列表信息
    public function dbi_all_hcutable_req($start, $total)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_hcudevice` limit $start, $total";
        $result = $mysqli->query($query_str);

        $hcutable = array();
        while($row = $result->fetch_array())
        {
            $devcode = $row['devcode'];
            $statcode = $row['statcode'];
            $macaddr = $row['macaddr'];
            $ipaddr = $row['ipaddr'];
            $devstatus = $row['switch'];
            $url = $row['videourl'];
            if ($devstatus == "1")
                $devstatus = "true";
            elseif($devstatus == "0")
                $devstatus = "false";

            $query_str = "SELECT * FROM `t_siteinfo` WHERE `statcode` = '$statcode'";      //查询HCU设备对应监测点号
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0) {
                $info = $resp->fetch_array();
                $temp = array(
                    'DevCode' => $devcode,
                    'StatCode' => $statcode,
                    'ProjCode' => $info['p_code'],
                    'StartTime' => $info['starttime'],
                    'PreEndTime' => "",  //需要确认
                    'EndTime' => "",
                    'DevStatus' => $devstatus,
                    'VideoURL' => $url,
                    'MAC' => $macaddr,
                    'IP' => $ipaddr
                );
                array_push($hcutable, $temp);
            }
        }

        $mysqli->close();
        return $hcutable;
    }

    //UI PointDev Request，查询监测点下面HCU列表
    public function dbi_site_devlist_req($statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_siteinfo` WHERE `statcode` = '$statcode' ";
        $result = $mysqli->query($query_str);

        $devlist = array();
        while($row = $result->fetch_array())
        {
            $temp = array(
                'id' => $row['statcode'],
                'name' => $row['devcode']
            );
            array_push($devlist, $temp);
        }

        $mysqli->close();
        return $devlist;
    }


    //UI DevNew & DevMod request,添加HCU设备信息或者修改HCU设备信息
    public function dbi_devinfo_update($devinfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");
        $mysqli->query("SET NAMES utf8");

        $devcode = $devinfo["DevCode"];
        $statcode = $devinfo["StatCode"];
        $starttime = $devinfo["StartTime"];
        $preendtime = $devinfo["PreEndTime"];
        $endtime = $devinfo["EndTime"];
        $devstatue = $devinfo["DevStatus"];
        $videourl = $devinfo["VideoURL"];
        $default_sensor = S_TYPE_EMC.";";

        $query_str = "SELECT * FROM `t_hcudevice` WHERE `devcode` = '$devcode'";
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0) //重复，则覆盖
        {
            $query_str = "UPDATE `t_hcudevice` SET `statcode` = '$statcode',`switch` = '$devstatue',`videourl` = '$videourl' WHERE (`devcode` = '$devcode' )";
            $result = $mysqli->query($query_str);
        }
        else //不存在，新增
        {
            $query_str = "INSERT INTO `t_hcudevice` (devcode,statcode,switch,videourl,sensorlist) VALUES ('$devcode','$statcode','$devstatue','$videourl','$default_sensor')";
            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    //UI PointDel request，删除一个监测点
    public function dbi_siteinfo_delete($statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_siteinfo` WHERE `statcode` = '$statcode'";  //删除监测点信息表
        $result1 = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_sitemapping` WHERE `statcode` = '$statcode'";  //删除项目和监测点的映射关系
        $result2 = $mysqli->query($query_str);

        $query_str = "UPDATE `t_hcudevice` SET `statcode` = '' WHERE (`statcode` = '$statcode' )"; //删除HCU设备表中的对应监测点号
        $result3 = $mysqli->query($query_str);

        $result = $result1 and $result2 and $result3;

        $mysqli->close();
        return $result;
    }

    //ZJL: 这个东西同时连接两个数据库，需要分开
    //UI DevDel request，删除一个监测点
    public function dbi_deviceinfo_delete($devcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //建立连接
        $mysqli1 = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_hcudevice` WHERE `devcode` = '$devcode'";  //删除HCU device信息表
        $result1 = $mysqli1->query($query_str);

        $query_str = "UPDATE `t_siteinfo` SET `devcode` = '' WHERE (`devcode` = '$devcode' )"; //删除监测点信息表中的HCU信息
        $result2 = $mysqli->query($query_str);

        $result = $result1 and $result2;

        $mysqli->close();
        return $result;
    }

    /**********************************************************************************************************************
     *                                                 地图显示相关操作DB API                                               *
     *********************************************************************************************************************/


    //UI MonitorList request, 获取该用户地图显示的所有监测点信息
    public function dbi_map_sitetinfo_req($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_projinfo` WHERE 1";
        $result = $mysqli->query($query_str);

        $sitelist = array();
        while($row = $result->fetch_array())
        {
            $pcode = $row['p_code'];
            $chargeman = $row['chargeman'];
            $phone = $row['telephone'];
            $department = $row['department'];
            $addr = $row['address'];
            $country = $row['country'];
            $street = $row['street'];
            $square = $row['square'];
            $stage = $row['stage'];

            $query_str = "SELECT * FROM `t_siteinfo` WHERE `p_code` = '$pcode'";      //查询监测点对应的项目号
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0) {
                $info = $resp->fetch_array();

                $latitude = ($info['latitude'])/1000000;  //百度地图经纬度转换
                $longitude =  ($info['longitude'])/1000000;

                $temp = array(
                    'StatCode' => $info['statcode'],
                    'StatName' => $info['name'],
                    'ChargeMan' => $chargeman,
                    'Telephone' => $phone,
                    'Department' => $department,
                    'Address' => $addr,
                    'Country' => $country,
                    'Street' => $street,
                    'Square' => $square,
                    'Flag_la' => $info['flag_la'],
                    'Latitude' => $latitude,
                    'Flag_lo' =>  $info['flag_lo'],
                    'Longitude' => $longitude,
                    'ProStartTime' => $info['starttime'],
                    'Stage' => $stage
                );
                array_push($sitelist, $temp);
            }
        }

        $mysqli->close();
        return $sitelist;
    }

    public function dbi_excel_historydata_req($condition)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L5BI, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        if($condition[0]["ConditonName"] == "UserId")
            $session = $condition[0]["Equal"];
        if($condition[1]["ConditonName"] == "StatCode")
            $statcode = $condition[1]["Equal"];
        if($condition[2]["ConditonName"] == "AlarmType")
            $type = $condition[2]["Equal"];
        if($condition[3]["ConditonName"] == "AlarmDate"){
            $start = $condition[3]["GEQ"];
            $end = $condition[3]["LEQ"];
        }

        $resp["column"] = array();
        $resp['data'] = array();

        array_push($resp["column"],"监测点编号");
        array_push($resp["column"],"设备编号");
        array_push($resp["column"],"报告日期");
        array_push($resp["column"],"PM2.5");
        array_push($resp["column"],"风速");
        array_push($resp["column"],"风向");
        array_push($resp["column"],"温度");
        array_push($resp["column"],"湿度");
        array_push($resp["column"],"噪声");

        $query_str = "SELECT * FROM `t_minreport` WHERE `statcode` = '$statcode'AND `reportdate`>= '$start' AND `reportdate`<= '$end'";
        $result = $mysqli->query($query_str);
        while($info = $result->fetch_array())
        {
            $one_row = array();
            array_push($one_row, $statcode);
            array_push($one_row, $info["devcode"]);
            array_push($one_row, $info["reportdate"]);
            array_push($one_row, $info["pm25"]/10);
            array_push($one_row, $info["windspeed"]/10);
            array_push($one_row, $info["winddirection"]);
            array_push($one_row, $info["temperature"]/10);
            array_push($one_row, $info["humidity"]/10);
            array_push($one_row, $info["noise"]/100);

            array_push($resp['data'],$one_row);
        }

        $mysqli->close();
        return $resp;
    }


    /**********************************************************************************************************************
     *                                                 传感器相关操作DB API                                                 *
     *********************************************************************************************************************/
    //UI AlarmType request, 获取所有需要生成告警数据表的传感器类型信息
    public function dbi_all_alarmtype_req()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_sensorinfo` WHERE 1";
        $result = $mysqli->query($query_str);

        $alarm_type = array();
        while($row = $result->fetch_array())
        {
            $temp = array(
                'id' => $row['id'],
                'name' => $row['name']
            );
            array_push($alarm_type, $temp);
        }

        $mysqli->close();
        return $alarm_type;
    }

    //UI SensorList request, 获取所有传感器类型信息
    public function dbi_all_sensorlist_req()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_sensorinfo` WHERE 1";
        $result = $mysqli->query($query_str);

        $sensor_list = array();
        while($row = $result->fetch_array())
        {
            $temp = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'nickname' => $row['model'],  //to be update
                'memo' => $row['vendor'],
                'code' => ""
            );
            array_push($sensor_list, $temp);
        }

        $mysqli->close();
        return $sensor_list;
    }


    //UI DevSensor request, 获取所有传感器类型信息
    public function dbi_dev_sensorinfo_req($devcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_hcudevice` WHERE `devcode` = '$devcode'";
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $strlist = $row['sensorlist'];
            $onoff = $row['switch'];

            $i = 0;
            $temp = "";
            $sensor_list =array();
            while($i < strlen($strlist)){
                $str = substr($strlist, $i, 1);
                if($str != ";")
                    $temp = $temp.$str;
                elseif($str == ";"){
                    array_push($sensor_list, $temp);
                    $temp = "";
                }
                $i++;
            }
        }
        else{
            $sensor_list = "";
        }

        $i = 0;
        $sensorinfo = array();
        while ($i < count($sensor_list))
        {
            $id = $sensor_list[$i];
            $query_str = "SELECT * FROM `t_sensorinfo` WHERE `id` = '$id'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows)>0)
            {
                $row = $result->fetch_array();
                $modbus = $row['modbus'];
                $period = $row['period'];
                $samples = $row['samples'];
                $times = $row['times'];

                $paralist = array();
                if ($id == "S_0001"){
                    $temp = array(
                        'name'=>"Status",
                        'memo'=>"颗粒物传感器当前工作状态",
                        'value'=>$onoff
                    );
                    array_push($paralist,$temp);
                }
                if(!empty($modbus)){
                    $temp = array(
                        'name'=>"MODBUS_Addr",
                        'memo'=>"MODBUS地址",
                        'value'=>$modbus
                    );
                    array_push($paralist,$temp);
                }
                if(!empty($period)){
                    $temp = array(
                        'name'=>"Measurement_Period",
                        'memo'=>"测量周期",
                        'value'=>$period
                    );
                    array_push($paralist,$temp);
                }
                if(!empty($samples)){
                    $temp = array(
                        'name'=>"Samples_Interval",
                        'memo'=>"采样间隔",
                        'value'=>$samples
                    );
                    array_push($paralist,$temp);
                }
                if(!empty($times)){
                    $temp = array(
                        'name'=>"Measurement_Times",
                        'memo'=>"测量次数",
                        'value'=>$times
                    );
                    array_push($paralist,$temp);
                }

                $temp = array(
                    'id' => $id,
                    'status' => "true",
                    'para'=>$paralist
                );
                array_push($sensorinfo, $temp);

            }
            $i++;
        }

        $mysqli->close();
        return $sensorinfo;
    }

    /*
    -- --------------------------------------------------------

    --
    -- 表的结构 `t_currentreport`
    --

    CREATE TABLE IF NOT EXISTS `t_currentreport` (
      `sid` int(4) NOT NULL AUTO_INCREMENT,
      `deviceid` char(50) NOT NULL,
      `statcode` char(20) NOT NULL,
      `createtime` char(20) NOT NULL,
      `emcvalue` int(4) DEFAULT NULL,
      `pm01` int(4) DEFAULT NULL,
      `pm25` int(4) DEFAULT NULL,
      `pm10` int(4) DEFAULT NULL,
      `noise` int(4) DEFAULT NULL,
      `windspeed` int(4) DEFAULT NULL,
      `winddirection` int(4) DEFAULT NULL,
      `temperature` int(4) DEFAULT NULL,
      `humidity` int(4) DEFAULT NULL,
      `rain` int(4) DEFAULT NULL,
      `airpressure` int(4) DEFAULT NULL,
      PRIMARY KEY (`sid`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

    --
    -- 转存表中的数据 `t_currentreport`
    --

    INSERT INTO `t_currentreport` (`sid`, `deviceid`, `statcode`, `createtime`, `emcvalue`, `pm01`, `pm25`, `pm10`, `noise`, `windspeed`, `winddirection`, `temperature`, `humidity`, `rain`, `airpressure`) VALUES
    (2, 'HCU_SH_0301', '120101001', '2016-04-27 19:48:03', 5219, 231, 231, 637, 641, 0, 106, 188, 205, 0, 0),
    (15, 'HCU_SH_0302', '120101002', '2016-06-19 12:56:19', 5050, NULL, NULL, NULL, NULL, NULL, NULL, 451, 350, NULL, NULL),
    (6, 'HCU_SH_0305', '120101005', '2016-05-10 15:27:44', 4867, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
    (16, 'HCU_SH_0309', '120101009', '2016-06-18 23:30:39', 5151, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
    (11, 'HCU_SH_0304', '120101004', '2016-06-16 17:41:00', 4767, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
    (12, 'HCU_SH_0303', '120101003', '2016-06-12 15:29:50', 5620, 136, 136, 237, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

    */



    //UI DevAlarm Request, 获取当前的测量值，如果测量值超出范围，提示告警
    public function dbi_dev_currentvalue_req($statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_currentreport` WHERE `statcode` = '$statcode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();  //暂时先这样处理，此处测量值计算要根据上报精度进行修改。。。。。
            $noise = $row['noise']/100;
            $winddir = $row['winddirection']/10;
            $humidity = $row['humidity']/10;
            $temperature = $row['temperature']/10;
            $pm25 = $row['pm25']/10;
            $windspeed = $row['windspeed']/10;

            $currentvalue = array();
            if ($noise != NULL){
                if ($noise > TH_ALARM_NOISE)
                    $alarm = "true";
                else
                    $alarm = "false";

                $temp = array(
                    'AlarmName'=>"噪声",
                    'AlarmEName'=> "Noise",
                    'AlarmValue'=>(string)$noise,
                    'AlarmUnit'=>" 分贝",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }

            if ($winddir != NULL){
                $temp = array(
                    'AlarmName'=>"风向",
                    'AlarmEName'=> "WD",
                    'AlarmValue'=>(string)$winddir,
                    'AlarmUnit'=>" 度",
                    'WarningTarget'=>"false"
                );
                array_push($currentvalue,$temp);
            }

            if ($humidity != NULL){
                if ($humidity > TH_ALARM_HUMIDITY)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"湿度",
                    'AlarmEName'=> "Wet",
                    'AlarmValue'=>(string)$humidity,
                    'AlarmUnit'=>" %",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }

            if ($temperature != NULL){
                if ($temperature > TH_ALARM_TEMPERATURE)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"温度",
                    'AlarmEName'=> "Temperature",
                    'AlarmValue'=>(string)$temperature,
                    'AlarmUnit'=>" 摄氏度",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }

            if ($pm25 != NULL){
                if ($pm25 > TH_ALARM_PM25)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"细颗粒物",
                    'AlarmEName'=> "PM",
                    'AlarmValue'=>(string)$pm25,
                    'AlarmUnit'=>" 毫克/立方米",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }

            if ($windspeed != NULL){
                if ($windspeed > TH_ALARM_WINDSPEED)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"风速",
                    'AlarmEName'=> "WS",
                    'AlarmValue'=>(string)$windspeed,
                    'AlarmUnit'=>" 公里/小时",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }
        }
        else
            $currentvalue = "";

        $mysqli->close();
        return $currentvalue;
    }

    //UI AlarmQuery Request, 获取告警历史数据
    public function dbi_dev_alarmhistory_req($statcode, $date, $alarm_type)
    {
        //建立连接
        $mysqli1 = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli1) {
            die('Could not connect: ' . mysqli_error($mysqli1));
        }
        $mysqli1->query("set character_set_results = utf8");
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        //根据监测点号查找对应的设备号
        $query_str = "SELECT * FROM `t_siteinfo` WHERE `statcode` = '$statcode'";
        $result = $mysqli1->query($query_str);
        if (($result->num_rows) > 0) {
            $row = $result->fetch_array();
            $devcode = $row['devcode'];
        }

        switch($alarm_type) {
            case S_TYPE_PM:
                $resp["alarm_name"] = "细颗粒物";
                $resp["alarm_unit"] = "毫克/立方米";
                $resp["warning"] = TH_ALARM_PM25;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_pmdata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["pm25"]/10;
                        $huorminindex = $row["hourminindex"];
                        $hour = floor($huorminindex/60) ;
                        $min = $huorminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"],$data);
                        array_push($resp["minute_head"],$head);
                    }

                    //临时填的随机数
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                break;

            case S_TYPE_WINDSPEED:
                $resp["alarm_name"] = "风速";
                $resp["alarm_unit"] = "千米/小时";
                $resp["warning"] = TH_ALARM_WINDSPEED;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_windspeed` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["windspeed"]/10;
                        $huorminindex = $row["hourminindex"];
                        $hour = floor($huorminindex/60) ;
                        $min = $huorminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"],$data);
                        array_push($resp["minute_head"],$head);
                    }
                    //临时填的随机数
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                break;

            case S_TYPE_WINDDIR:
                $resp["alarm_name"] = "风向";
                $resp["alarm_unit"] = "度";
                $resp["warning"] = TH_ALARM_WINDDIR;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_winddirection` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["winddirection"];
                        $huorminindex = $row["hourminindex"];
                        $hour = floor($huorminindex/60) ;
                        $min = $huorminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                    //临时填的随机数
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                break;

            case S_TYPE_EMC:
                $resp["alarm_name"] = "电磁辐射";
                $resp["alarm_unit"] = "毫瓦/平方毫米";
                $resp["warning"] = TH_ALARM_EMC;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_emcdata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["emcvalue"]/100;
                        $huorminindex = $row["hourminindex"];
                        $hour = floor($huorminindex/60) ;
                        $min = $huorminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                    //临时填的随机数
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                break;

            case S_TYPE_TEMPERATURE:
                $resp["alarm_name"] = "温度";
                $resp["alarm_unit"] = "摄氏度";
                $resp["warning"] = TH_ALARM_TEMPERATURE;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_temperature` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["temperature"]/10;
                        $huorminindex = $row["hourminindex"];
                        $hour = floor($huorminindex/60) ;
                        $min = $huorminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                    //临时填的随机数
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                break;

            case S_TYPE_HUMIDITY:
                $resp["alarm_name"] = "湿度";
                $resp["alarm_unit"] = "%";
                $resp["warning"] = TH_ALARM_HUMIDITY;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_humidity` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["humidity"]/10;
                        $huorminindex = $row["hourminindex"];
                        $hour = floor($huorminindex/60) ;
                        $min = $huorminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                    //临时填的随机数
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                break;

            case S_TYPE_NOISE:
                $resp["alarm_name"] = "噪声";
                $resp["alarm_unit"] = "分贝";
                $resp["warning"] = TH_ALARM_NOISE;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_noisedata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["noise"]/100;
                        $huorminindex = $row["hourminindex"];
                        $hour = floor($huorminindex/60) ;
                        $min = $huorminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                    //临时填的随机数
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                break;

            default:
                $resp = "";
                break;
        }

        $mysqli->close();
        return $resp;

    }

//UI GetStaticMonitorTable Request, 获取用户聚合数据
    public function dbi_user_dataaggregate_req($uid)
    {
        //初始化返回值
        $resp["column"] = array();
        $resp['data'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $auth_list["stat_code"] = array();
        $auth_list["p_code"] = array();
        $auth_list = $this->dbi_user_statproj_inqury($uid);

        array_push($resp["column"], "监测点编号");
        array_push($resp["column"], "项目单位");
        array_push($resp["column"], "区县");
        array_push($resp["column"], "地址");
        array_push($resp["column"], "负责人");
        array_push($resp["column"], "联系电话");
        array_push($resp["column"], "PM2.5");
        array_push($resp["column"], "温度");
        array_push($resp["column"], "湿度");
        array_push($resp["column"], "噪音");
        array_push($resp["column"], "风速");
        array_push($resp["column"], "风向");
        array_push($resp["column"], "设备状态");

        for($i=0; $i<count($auth_list["stat_code"]); $i++)
        {
            $one_row = array();
            $pcode = $auth_list["p_code"][$i];
            $statcode = $auth_list["stat_code"][$i];
            $query_str = "SELECT * FROM `t_projinfo` WHERE `p_code` = '$pcode'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                array_push($one_row, $statcode);
                array_push($one_row, $row["p_name"]);
                array_push($one_row, $row["country"]);
                array_push($one_row, $row["address"]);
                array_push($one_row, $row["chargeman"]);
                array_push($one_row, $row["telephone"]);
            }
            $query_str = "SELECT * FROM `t_currentreport` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                array_push($one_row, $row["pm25"]/10);
                array_push($one_row, $row["temperature"]/10);
                array_push($one_row, $row["humidity"]/10);
                array_push($one_row, $row["noise"]/100);
                array_push($one_row, $row["windspeed"]/10);
                array_push($one_row, $row["winddirection"]);

                $timestamp = strtotime($row["createtime"]);
                $currenttime = time();
                if ($currenttime > ($timestamp+180))  //如果最后一次测量报告距离现在已经超过3分钟
                    array_push($one_row, "停止");
                else
                    array_push($one_row, "运行");

            }

/*
            $query_str = "SELECT * FROM `t_hcudevice` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows) > 0) {
                $row = $result->fetch_array();
                if ($row["switch"] == "on")
                    array_push($one_row, "运行");
                elseif ($row["switch"] == "off")
                    array_push($one_row, "停止");
            }
*/

            array_push($resp['data'], $one_row);
        }

        $mysqli->close();
        return $resp;
    }


}//End of class_ui_db

?>