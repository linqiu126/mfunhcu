<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 22:59
 */
header("Content-type:text/html;charset=utf-8");
include_once "../l1comvm/vmlayer.php";  //此处include不可修改！！！
//require_once "../../l1comvm/sysconfig.php";
/*

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_account`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_account` (
  `uid` char(10) NOT NULL,
  `user` char(20) NOT NULL,
  `nick` char(20) DEFAULT NULL,
  `pwd` char(100) NOT NULL,
  `admin` char(5) DEFAULT NULL,
  `grade` char(1) NOT NULL DEFAULT '0',
  `phone` char(20) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `regdate` date DEFAULT NULL,
  `city` char(10) DEFAULT NULL,
  `backup` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l3f1sym_account`
--
ALTER TABLE `t_l3f1sym_account`
  ADD PRIMARY KEY (`uid`);

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_authlist`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_authlist` (
  `sid` int(4) NOT NULL,
  `uid` char(10) NOT NULL,
  `auth_code` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l3f1sym_authlist`
--
ALTER TABLE `t_l3f1sym_authlist`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l3f1sym_authlist`
--
ALTER TABLE `t_l3f1sym_authlist`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_session`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_session` (
  `uid` char(20) NOT NULL,
  `sessionid` char(10) NOT NULL,
  `lastupdate` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l3f1sym_session`
--
ALTER TABLE `t_l3f1sym_session`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `sessionid` (`sessionid`);

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_sysinfo`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_sysinfo` (
  `sid` int(4) NOT NULL,
  `keyid` char(50) NOT NULL,
  `vendorinfo` char(200) NOT NULL,
  `customerinfo` char(200) NOT NULL,
  `licenseinfo` char(200) NOT NULL,
  `maxadmin` int(4) NOT NULL DEFAULT '10',
  `maxsubscribers` int(4) NOT NULL DEFAULT '1000',
  `maxservers` int(4) NOT NULL DEFAULT '5'
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_l3f1sym_sysinfo`
--

INSERT INTO `t_l3f1sym_sysinfo` (`sid`, `keyid`, `vendorinfo`, `customerinfo`, `licenseinfo`, `maxadmin`, `maxsubscribers`, `maxservers`) VALUES
(100, 'AAA-BBB-012', 'Aiqi Yancheng Shanghai Ltd.', '上海是环保局，中环工程', '', 10, 1000, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l3f1sym_sysinfo`
--
ALTER TABLE `t_l3f1sym_sysinfo`
  ADD PRIMARY KEY (`sid`);

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_userprofile`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_userprofile` (
  `id` int(11) NOT NULL,
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
  `flags` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_l3f1sym_userprofile`
--

INSERT INTO `t_l3f1sym_userprofile` (`id`, `username`, `email`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `created_at`, `updated_at`, `flags`) VALUES
(50, 'bxxh2015', 'bxxh2015@sina.cn', '$2y$12$3vo17XiHR8tzfmAsXOK8BeDJsd38ONOSTjbv0C19qbpr2C7IfDggK', '3au2TiBE1NjaP0D0iy9-e9MzFLJ5I7ws', 1442896173, NULL, NULL, '183.193.36.164', 1442896107, 1442896173, 0),
(49, 'linqiu12611', 'linqiu126@sina.cn', '$2y$12$9zRpK4xehj5s/npanxz6O.P1njI5MUsDBB9wskUYJ12cuTWZdrcJq', 'bqjflR9mJOyioXiYhQUGfWjMDPIg-GSJ', 1442894217, NULL, NULL, '183.193.36.164', 1442894194, 1442894217, 0),
(51, 'mfuncloud', 'liuzehong@hotmail.com', '$2y$12$/zjcwitKWqk.hfa.ligqFOtmiHMwProHj.QugIuvYFvFxY7MbY7om', 'k05QvRL9FCgxSv13BcB363dcPOFF2hJA', NULL, NULL, NULL, '101.226.125.122', 1444047832, 1444047832, 0),
(52, 'zjl', 'smdzjl@sina.cn', '$2y$12$pCBD9e0/B0bvwKs6crXA2.pzy606Bn4o19Bzx1r8jdjr1t1nN/jc.', 'GPJwlaHeV0JaMswrLuai0JsW7H8aUjPh', 1444091551, NULL, NULL, '117.135.149.14', 1444091501, 1444091551, 0),
(53, 'shanchuz', 'zsc0905@sina.com', '$2y$12$mlslUwrYelb5nV6DfYot9ORgYGI9YB5.bN/HCMYru6QRn6UrfJsP6', '7VMvRAprvPsYU-Fqt6jDYeLvUzfLzdjF', 1444527288, NULL, NULL, '101.226.125.108', 1444527242, 1444527288, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l3f1sym_userprofile`
--
ALTER TABLE `t_l3f1sym_userprofile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_unique_username` (`username`),
  ADD UNIQUE KEY `user_unique_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l3f1sym_userprofile`
--
ALTER TABLE `t_l3f1sym_userprofile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54;

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
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f1sym_session` WHERE `sessionid` = '$sessionid'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $lastupdate = $row['lastupdate'];
            $currenttime = time();
            if($currenttime < ($lastupdate + MFUN_L3APL_F1SYM_SESSIONID_VALID_TIME)){
                $uid = $row['uid'];
                $query_str = "UPDATE `t_l3f1sym_session` SET `lastupdate` = '$currenttime' WHERE (`sessionid` = '$sessionid')"; //更新一下session时间
                $mysqli->query($query_str);
            }
            else
                $uid = "";
        }
        else
            $uid = "";

        $mysqli->close();
        return $uid;
    }

    public function dbi_user_authcheck($action, $sessionid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //初始化状态变量
        $auth = "true";
        $status = "true";
        $msg = "";

        $uid = $this->dbi_session_check($sessionid);
        if (!empty($uid)){
            $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `uid` = '$uid'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows)>0) {
                $row = $result->fetch_array();
                $grade_idx = intval($row['grade']);

                $taskObj = new classConstL1vmUserWebRight();
                $grade_info = $taskObj->mfun_vm_getUserGrade($grade_idx);
                if (isset($grade_info["actionauth"])) $actionauth = $grade_info["actionauth"]; else  $actionauth = "";
                if (isset($actionauth[$action])) $auth = $actionauth[$action]; else  $auth = "true";  //如果没有特别限制的操作，默认为ture
            }
        }
        else{
            $auth = "fasle";
            $status = "false";
            $msg = "网页长时间没有操作，会话超时";
        }

        $authcheck = array('status' => $status,'auth' => $auth,'uid' =>$uid, 'msg' => $msg);
        $mysqli->close();
        return $authcheck;
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
        $mysqli->query("SET NAMES utf8");

        //先检查用户名是否存在
        $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `user` = '$name'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $pwd = $row['pwd'];
            $uid = $row['uid'];
            $admin = $row['admin'];

            if ($pwd == $password) {
                $strlen = MFUN_L3APL_F1SYM_SESSION_ID_LEN;
                $sessionid = $this->getRandomSid($strlen);
                $body = array('key'=> $sessionid, 'admin'=> $admin);
                $msg = "登录成功";
                $this->updateSession($uid, $sessionid);
            }
            else {
                $body = array('key'=> "", 'admin'=> "");
                $msg = "登录失败，密码错误";
            }
        }
        else {
            $body = array('key'=> "", 'admin'=> "");
            $msg = "登录失败，用户名错误";
        }
        $login_info = array('body' => $body,'msg' => $msg);

        $mysqli->close();
        return $login_info;
    }

    //Get_user_auth_code, 发送手机验证码帮助找回密码
    public function dbi_userauthcode_process($username)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //生成验证码并保存用于后面密码重置时校验
        $authcode = $this->getRandomUid(MFUN_HCU_FHYS_LEXIN_AUTHCODE_LEN);
        $query_str = "UPDATE `t_l3f1sym_account` SET `authcode` = '$authcode' WHERE `user` = '$username'";
        $result = $mysqli->query($query_str);

        $resp = false;
        $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `user` = '$username'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0){
            $row = $result->fetch_array();
            $mobile = $row['phone'];

            //LEXIN短信平台
            //$content = "【阜华光交箱云平台】".$authcode."（动态验证码），请在30分钟内填写";
            //$bizId = time();
            //$url = MFUN_HCU_FHYS_LEXIN_URL.MFUN_HCU_FHYS_LEXIN_ACCNAME."&".MFUN_HCU_FHYS_LEXIN_ACCPWD."&aimcodes=".trim($mobile).
            //    "&content=".trim($content).MFUN_HCU_FHYS_LEXIN_SIGNATURE."&bizId=".$bizId."&dataType=string";

            //CMCC短信平台
            $url = MFUN_HCU_FHYS_CMCC_URL.'?sicode='.MFUN_HCU_FHYS_CMCC_SICODE.'&mobiles='.trim($mobile).
                '&tempid='.MFUN_HCU_FHYS_CMCC_TEMPCODE_PW.'&smscode='.$authcode;

            $l2sdkIotWxObj = new classTaskL2sdkIotWx();
            $resp =$l2sdkIotWxObj->https_request($url);
        }

        $mysqli->close();
        return $resp;
    }

    public function dbi_reset_password_process($username, $code, $password)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //先检查用户名是否存在
        $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `user` = '$username'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $authcode = $row['authcode'];
            $uid = $row['uid'];
            $admin = $row['admin'];

            if ($authcode == $code) {
                $strlen = MFUN_L3APL_F1SYM_SESSION_ID_LEN;
                $sessionid = $this->getRandomSid($strlen);
                $body = array('key'=> $sessionid, 'admin'=> $admin);
                $msg = "验证码正确，登录成功";
                $this->updateSession($uid, $sessionid);
                //更新密码
                $query_str = "UPDATE `t_l3f1sym_account` SET `pwd` = '$password' WHERE `user` = '$username'";
                $result = $mysqli->query($query_str);
            }
            else {
                $body = array('key'=> "", 'admin'=> "");
                $msg = "验证码错误，登录失败";
            }
        }
        else {
            $body = array('key'=> "", 'admin'=> "");
            $msg = "登录失败，用户名错误";
        }
        $login_info = array('body' => $body,'msg' => $msg);

        $mysqli->close();
        return $login_info;
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
        $mysqli->query("SET NAMES utf8");

        $userinfo = array(); //初始化

        $query_str = "SELECT * FROM `t_l3f1sym_session` WHERE `sessionid` = '$sessionid'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $uid = $row['uid'];
            $lastupdate = $row['lastupdate'];
            $now= time();
            if ($lastupdate < $now + MFUN_L3APL_F1SYM_SESSIONID_VALID_TIME) //sessionid 在有效时间内
            {
                $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `uid` = '$uid'";
                $result = $mysqli->query($query_str);
                if (($result->num_rows)>0)
                {
                    $userauth = array();
                    $row = $result->fetch_array();
                    $grade_idx = $row['grade'];
                    $city = $row['city'];
                    $name = $row['user'];
                    $taskObj = new classConstL1vmUserWebRight();
                    $grade_info = $taskObj->mfun_vm_getUserGrade($grade_idx);
                    if (isset($grade_info["webauth"])) $userauth['webauth'] = $grade_info["webauth"]; else  $userauth['webauth'] = "";
                    if (isset($grade_info["query"])) $userauth['query'] = $grade_info["query"]; else  $userauth['query'] = "";
                    if (isset($grade_info["mod"])) $userauth['mod'] = $grade_info["mod"]; else  $userauth['mod'] = "";

                    $userinfo = array('id'=>$sessionid,'name'=>$name,'level'=>$grade_idx,'city'=>$city,'userauth'=>$userauth);
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
    public function dbi_usertable_req($uid, $uid_start, $uid_total)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //按照阜华要求，默认用户表只显示自己
        $usertable = array(); //初始化
        $user = "";
        $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE (`uid` = '$uid')";
        $result = $mysqli->query($query_str);
        if (($result != false) && (($row = $result->fetch_array()) > 0)){
            $user = $row['user'];
            $temp = array(
                'id' => $row['uid'],
                'name' => $row['user'],
                'nickname'=> $row['nick'],
                'mobile' => $row['phone'],
                'mail' => $row['email'],
                'type' => $row['grade'],
                'date' => $row['regdate'],
                'memo' => $row['backup']
            );
            array_push($usertable,$temp);

        }

        //如果是特殊用户则显示所有用户表
        if ($user == 'admin' OR $user == 'foha')
        {
            $query_str = "SELECT * FROM `t_l3f1sym_account` limit $uid_start, $uid_total";
            $resp = $mysqli->query($query_str);
            while (($resp != false) && (($row = $resp->fetch_array()) > 0))
            {
                $temp = array(
                    'id' => $row['uid'],
                    'name' => $row['user'],
                    'nickname'=> $row['nick'],
                    'mobile' => $row['phone'],
                    'mail' => $row['email'],
                    'type' => $row['grade'],
                    'date' => $row['regdate'],
                    'memo' => $row['backup']
                );
                array_push($usertable,$temp);
            }
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
        //$mysqli->query("set character_set_connection = utf8");
        $mysqli->query("SET NAMES utf8");

        $uid = MFUN_L3APL_F1SYM_UID_PREFIX.$this->getRandomUid(MFUN_L3APL_F1SYM_USER_ID_LEN);  //UID的分配机制将来要重新考虑，避免重复
        if (isset($userinfo["name"])) $user = trim($userinfo["name"]); else  $user = "";
        if (isset($userinfo["nickname"])) $nick = trim($userinfo["nickname"]); else  $nick = "";
        if (isset($userinfo["password"])) $pwd = trim($userinfo["password"]); else  $pwd = "";
        if (isset($userinfo["type"])) $grade = trim($userinfo["type"]); else  $grade = "";
        if (isset($userinfo["mobile"])) $phone = trim($userinfo["mobile"]); else  $phone = "";
        if (isset($userinfo["mail"])) $email = trim($userinfo["mail"]); else  $email = "";
        if (isset($userinfo["memo"])) $backup = trim($userinfo["memo"]); else  $backup = "";
        if (isset($userinfo["auth"])) $auth = $userinfo["auth"]; else  $auth = "";

        $regdate = date("Y-m-d", time());
        $city = "上海"; //暂定用户所在城市，将来需要修改
        $admin = "false";

        $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `user` = '$user'";
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0) //重复，则覆盖
        {
            $query_str = "UPDATE `t_l3f1sym_account` SET `nick` = '$nick',`pwd` = '$pwd',`admin` = '$admin',`grade` = '$grade',`phone` = '$phone',`email` = '$email',
                          `regdate` = '$regdate', `city` = '$city',`backup` = '$backup' WHERE (`user` = '$user' )";
            $result = $mysqli->query($query_str);
        }
        else //不存在，新增
        {
            $query_str = "INSERT INTO `t_l3f1sym_account` (uid,user,nick,pwd,admin,grade,phone,email,regdate,city,backup)
                                  VALUES ('$uid','$user','$nick','$pwd','$admin','$grade','$phone','$email', '$regdate','$city','$backup')";

            $result = $mysqli->query($query_str);
        }

        $query_str = "DELETE FROM `t_l3f1sym_authlist` WHERE `uid` = '$uid' ";  //先删除当前所有授权的项目或者项目组list
        $result = $mysqli->query($query_str);

        if(!empty($auth)){
            $i = 0;
            while ($i < count($auth))
            {
                if (isset($auth[$i]["id"])) $authcode = $auth[$i]["id"]; else $authcode = "";
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
        //$mysqli->query("set character_set_connection = utf8");
        $mysqli->query("SET NAMES utf8");

        if (isset($userinfo["userid"])) $uid = trim($userinfo["userid"]); else  $uid = "";
        if (isset($userinfo["name"])) $user = trim($userinfo["name"]); else  $user = "";
        if (isset($userinfo["nickname"])) $nick = trim($userinfo["nickname"]); else  $nick = "";
        if (isset($userinfo["password"])) $pwd = trim($userinfo["password"]); else  $pwd = "";
        if (isset($userinfo["type"])) $grade = trim($userinfo["type"]); else  $grade = "";
        if (isset($userinfo["mobile"])) $phone = trim($userinfo["mobile"]); else  $phone = "";
        if (isset($userinfo["mail"])) $email = trim($userinfo["mail"]); else  $email = "";
        if (isset($userinfo["memo"])) $backup = trim($userinfo["memo"]); else  $backup = "";
        if (isset($userinfo["auth"])) $auth = $userinfo["auth"]; else  $auth = "";
        $regdate = date("Y-m-d", time());

        if (!empty($pwd)) //如果输入有密码，则覆盖
        {
            $query_str = "UPDATE `t_l3f1sym_account` SET `user` = '$user',`nick` = '$nick',`pwd` = '$pwd',`grade` = '$grade',`phone` = '$phone',`email` = '$email',
                          `regdate` = '$regdate', `backup` = '$backup' WHERE (`uid` = '$uid' )";
            $result = $mysqli->query($query_str);
        }
        else
        {
            $query_str = "UPDATE `t_l3f1sym_account` SET `user` = '$user',`nick` = '$nick',`grade` = '$grade',`phone` = '$phone',`email` = '$email',
                          `regdate` = '$regdate', `backup` = '$backup' WHERE (`uid` = '$uid' )";
            $result = $mysqli->query($query_str);
        }


        $query_str = "DELETE FROM `t_l3f1sym_authlist` WHERE `uid` = '$uid' ";  //先删除当前所有授权的项目或者项目组list
        $mysqli->query($query_str);

        if(!empty($auth)){
            $i = 0;
            while ($i < count($auth))
            {
                if (isset($auth[$i]["id"])) $authcode = $auth[$i]["id"]; else $authcode = "";
                $query_str = "INSERT INTO `t_l3f1sym_authlist` (uid, auth_code) VALUE ('$uid', '$authcode')";
                $mysqli->query($query_str);
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