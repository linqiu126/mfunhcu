<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 22:59
 */
include_once "../l1comvm/vmlayer.php";


//require_once "../../l1comvm/sysconfig.php";

/*

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_session`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_session` (
  `sessionid` char(8) NOT NULL,
  `uid` char(20) NOT NULL,
  `lastupdate` int(4) NOT NULL,
  PRIMARY KEY (`sessionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_l3f1sym_session`
--

INSERT INTO `t_l3f1sym_session` (`sessionid`, `uid`, `lastupdate`) VALUES
('KpjEAyCZ', 'UID001', 1466300141);


 -- --------------------------------------------------------

 --
 -- 表的结构 `t_l3f1sym_account`
 --

 CREATE TABLE IF NOT EXISTS `t_l3f1sym_account` (
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
 -- 转存表中的数据 `t_l3f1sym_account`
 --

 INSERT INTO `t_l3f1sym_account` (`uid`, `user`, `nick`, `pwd`, `attribute`, `phone`, `email`, `regdate`, `city`, `backup`) VALUES
 ('UID001', 'admin', '爱启用户', 'admin', '管理员', '13912341234', '13912341234@cmcc.com', '2016-05-28', '上海', ''),
 ('UID002', '李四', '老李', 'li_4', '管理员', '13912341234', '13912341234@cmcc.com', '2016-06-17', '上海', ''),
 ('UID003', 'user_01', '用户01', 'user01', '管理员', '13912349901', '13912349901@qq.com', '2016-04-01', '上海', NULL),
 ('UID004', 'user_02', '用户2', 'user02', '用户', '13912349902', '13912349902@qq.com', '2016-05-28', '上海', ''),
 ('UID005', 'user_03', '用户三', 'user03', '用户', '13912349903', '13912349902@qq.com', '2016-05-28', '上海', '');


-- --------------------------------------------------------
--
-- 表的结构 `t_l3f1sym_authlist`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_authlist` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `uid` char(10) NOT NULL,
  `auth_code` char(20) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

--
-- 转存表中的数据 `t_l3f1sym_authlist`
--

INSERT INTO `t_l3f1sym_authlist` (`sid`, `uid`, `auth_code`) VALUES
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

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_userprofile`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_userprofile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(60) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_username` (`username`),
  UNIQUE KEY `user_unique_email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- 转存表中的数据 `t_l3f1sym_userprofile`
--

INSERT INTO `t_l3f1sym_userprofile` (`id`, `username`, `email`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `created_at`, `updated_at`, `flags`) VALUES
(50, 'bxxh2015', 'bxxh2015@sina.cn', '$2y$12$3vo17XiHR8tzfmAsXOK8BeDJsd38ONOSTjbv0C19qbpr2C7IfDggK', '3au2TiBE1NjaP0D0iy9-e9MzFLJ5I7ws', 1442896173, NULL, NULL, '183.193.36.164', 1442896107, 1442896173, 0),
(49, 'linqiu12611', 'linqiu126@sina.cn', '$2y$12$9zRpK4xehj5s/npanxz6O.P1njI5MUsDBB9wskUYJ12cuTWZdrcJq', 'bqjflR9mJOyioXiYhQUGfWjMDPIg-GSJ', 1442894217, NULL, NULL, '183.193.36.164', 1442894194, 1442894217, 0),
(51, 'mfuncloud', 'liuzehong@hotmail.com', '$2y$12$/zjcwitKWqk.hfa.ligqFOtmiHMwProHj.QugIuvYFvFxY7MbY7om', 'k05QvRL9FCgxSv13BcB363dcPOFF2hJA', NULL, NULL, NULL, '101.226.125.122', 1444047832, 1444047832, 0),
(52, 'zjl', 'smdzjl@sina.cn', '$2y$12$pCBD9e0/B0bvwKs6crXA2.pzy606Bn4o19Bzx1r8jdjr1t1nN/jc.', 'GPJwlaHeV0JaMswrLuai0JsW7H8aUjPh', 1444091551, NULL, NULL, '117.135.149.14', 1444091501, 1444091551, 0),
(53, 'shanchuz', 'zsc0905@sina.com', '$2y$12$mlslUwrYelb5nV6DfYot9ORgYGI9YB5.bN/HCMYru6QRn6UrfJsP6', '7VMvRAprvPsYU-Fqt6jDYeLvUzfLzdjF', 1444527288, NULL, NULL, '101.226.125.108', 1444527242, 1444527288, 0);




*/

class classDbiL3apF1sym
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
    
    //更新UI用户session ID
    private function updateSession ($uid, $sessionid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $timestamp = time();
        //先检查用户名是否存在
        $result = $mysqli->query("SELECT * FROM `t_l3f1sym_session` WHERE `uid` = '$uid'");
        if (($result->num_rows)>0)
        {
            $query_str = "UPDATE `t_l3f1sym_session` SET `sessionid` = '$sessionid', `lastupdate` = '$timestamp' WHERE (`uid` = '$uid')";
            $result=$mysqli->query($query_str);
        }
        else    //否则插入一条新记录
        {
            $result=$mysqli->query("INSERT INTO `t_l3f1sym_session` (uid, sessionid, lastupdate) VALUES ('$uid', '$sessionid', '$timestamp')");
        }

        $mysqli->close();
        return $result;
    }

    //当前登录用户session id检查,如果session id对应UID不存在或者session id的更新时间超过有效时间，则返回false，否则返回UID
    public function dbi_session_check($sessionid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_l3f1sym_session` WHERE `sessionid` = '$sessionid'";
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

    //UI login request  用户登录请求
    public function dbi_login_req($name, $password)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");
        $mysqli->query("SET NAMES utf8");

        //先检查用户名是否存在
        $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `user` = '$name'";
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
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $userinfo = ""; //初始化

        $query_str = "SELECT * FROM `t_l3f1sym_session` WHERE `sessionid` = '$sessionid'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $uid = $row['uid'];
            $lastupdate = $row['lastupdate'];
            $now= time();
            if ($lastupdate < $now + SESSIONID_VALID_TIME) //sessionid 在有效时间内
            {
                $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `uid` = '$uid'";
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
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE 1";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    //UI UserTable request, 获取所有用户信息表
    public function dbi_usertable_req($uid_start, $uid_total)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_l3f1sym_account` limit $uid_start, $uid_total";
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


    //UI UserNew request,添加新用户信息
    public function dbi_userinfo_new($userinfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
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

        $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `user` = '$user'";
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0) //重复，则覆盖
        {
            $query_str = "UPDATE `t_l3f1sym_account` SET `nick` = '$nick',`pwd` = '$pwd',`attribute` = '$attribute',`phone` = '$phone',`email` = '$email',
                          `regdate` = '$regdate', `city` = '$city',`backup` = '$backup' WHERE (`user` = '$user' )";
            $result = $mysqli->query($query_str);
        }
        else //不存在，新增
        {
            $query_str = "INSERT INTO `t_l3f1sym_account` (uid,user,nick,pwd,attribute,phone,email,regdate,city,backup)
                                  VALUES ('$uid','$user','$nick','$pwd','$attribute','$phone','$email', '$regdate','$city','$backup')";

            $result = $mysqli->query($query_str);
        }

        $query_str = "DELETE FROM `t_l3f1sym_authlist` WHERE `uid` = '$uid' ";  //先删除当前所有授权的项目或者项目组list
        $result = $mysqli->query($query_str);

        if(!empty($auth)){
            $i = 0;
            while ($i < count($auth))
            {
                $authcode = $auth[$i]["id"];
                $query_str = "INSERT INTO `t_l3f1sym_authlist` (uid, auth_code) VALUE ('$uid', '$authcode')";
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
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
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
            $query_str = "UPDATE `t_l3f1sym_account` SET `user` = '$user',`nick` = '$nick',`pwd` = '$pwd',`attribute` = '$attribute',`phone` = '$phone',`email` = '$email',
                          `regdate` = '$regdate', `backup` = '$backup' WHERE (`uid` = '$uid' )";
            $result = $mysqli->query($query_str);
        }
        else
        {
            $query_str = "UPDATE `t_l3f1sym_account` SET `user` = '$user',`nick` = '$nick',`attribute` = '$attribute',`phone` = '$phone',`email` = '$email',
                          `regdate` = '$regdate', `backup` = '$backup' WHERE (`uid` = '$uid' )";
            $result = $mysqli->query($query_str);
        }


        $query_str = "DELETE FROM `t_l3f1sym_authlist` WHERE `uid` = '$uid' ";  //先删除当前所有授权的项目或者项目组list
        $result = $mysqli->query($query_str);

        if(!empty($auth)){
            $i = 0;
            while ($i < count($auth))
            {
                $authcode = $auth[$i]["id"];
                $query_str = "INSERT INTO `t_l3f1sym_authlist` (uid, auth_code) VALUE ('$uid', '$authcode')";
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
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_l3f1sym_account` WHERE `uid` = '$uid'";  //删除用户信息表
        $result1 = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_l3f1sym_authlist` WHERE `uid` = '$uid'";  //删除该用户授权的项目和项目组list
        $result2 = $mysqli->query($query_str);

        $result = $result1 and $result2;

        $mysqli->close();
        return $result;
    }



}

?>