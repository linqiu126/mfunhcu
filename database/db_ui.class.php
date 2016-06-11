<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/3
 * Time: 16:25
 */
header("Content-type:text/html;charset=utf-8");
include_once "../config/config.php";
class class_ui_db
{
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

    //更新UI用户session ID
    private function updateSession ($name, $sessionid)
    {
        //建立连接
        $mysqli=new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $timestamp = time();
        //先检查用户名是否存在
        $result = $mysqli->query("SELECT * FROM `t_session` WHERE `user` = '$name'");
        if (($result->num_rows)>0)
        {
            $query_str = "UPDATE `t_session` SET `sessionid` = '$sessionid', `lastupdate` = '$timestamp' WHERE (`user` = '$name')";
            $result=$mysqli->query($query_str);
        }
        else    //否则插入一条新记录
        {
            $result=$mysqli->query("INSERT INTO `t_session` (user, sessionid, lastupdate) VALUES ('$name', '$sessionid', '$timestamp')");
        }

        $mysqli->close();
        return $result;
    }

    //当前登录用户session id查询
    public function db_session_check($sessionid)
    {
        //建立连接
        $mysqli=new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_session` WHERE `sessionid` = '$sessionid'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $result = $row['user'];

        }
        else
            $result = "";

        $mysqli->close();
        return $result;
    }

    //UI login request  用户登录请求
    public function db_login_req($name, $password)
    {
        //建立连接
        $mysqli=new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
            $attribute = $row['attribute'];
            if ($attribute == 'admin' or  $attribute == '管理员')
                $admin = "true";
            else
                $admin = "false";

            if ($pwd == $password) {
                $strlen = SESSION_ID_LEN;
                $session = $this->getRandomSid($strlen);
                $userinfo = array(
                    'status' => "true",
                    'text' => "login successfully",
                    'key' => $session,
                    'admin' => $admin);
                $this->updateSession($name, $session);
            }
            else {
                $userinfo = array(
                    'status' => "false",
                    'text' => "password invaild",
                    'key' => null,
                    'admin' => null);
            }
        }
        else {
            $userinfo = array(
                'status' => "false",
                'text' => "user not exist",
                'key' => null,
                'admin' => null);
        }

        $mysqli->close();
        return $userinfo;
    }

    //UI UserInfo request  获取当前登录用户信息
    public function db_userinfo_req($sessionid)
    {
        //建立连接
        $mysqli=new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
            $user = $row['user'];
            $lastupdate = $row['lastupdate'];
            $now= time();
            if ($lastupdate < $now + 7200) //sessionid 超过2小时
            {
                $query_str = "SELECT * FROM `t_account` WHERE `user` = '$user'";
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
                        'name' => $user,
                        'admin' => $admin,
                        'city' => $row['city'] );
                }
            }
        }

        $mysqli->close();
        return $userinfo;
    }

    //查询用户表中记录总数
    public function db_usernum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_usertable_req($uid_start, $uid_total)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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

    //UI UserNew request,添加新用户信息
    public function db_userinfo_new($userinfo)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
        $attribute = $userinfo["type"];
        $phone = $userinfo["mobile"];
        $email = $userinfo["mail"];
        $regdate = date("Y-m-d", time());
        $backup = $userinfo["memo"];

        $auth = array();
        $auth = $userinfo["auth"];

        $query_str = "SELECT * FROM `t_account` WHERE `user` = '$user'";
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0) //重复，则覆盖
        {
            $query_str = "UPDATE `t_account` SET `nick` = '$nick',`pwd` = '$pwd',`attribute` = '$attribute',`phone` = '$phone',`email` = '$email',
                          `regdate` = '$regdate', `backup` = '$backup' WHERE (`user` = '$user' )";
            $result = $mysqli->query($query_str);
        }
        else //不存在，新增
        {
            $query_str = "INSERT INTO `t_account` (user,nick,pwd,attribute,phone,email,regdate,backup)
                                  VALUES ('$user','$nick','$pwd','$attribute','$phone','$email', '$regdate','$backup')";

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
    public function db_userinfo_update($userinfo)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_userinfo_delete($uid)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    //查询项目表中记录总数
    public function db_all_projnum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "SELECT * FROM `t_projinfo` WHERE 1";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    //查询项目组表中记录总数
    public function db_all_pgnum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_all_pgtable_req($start, $total)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_all_projtable_req($start, $total)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_all_projpglist_req()
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_all_projlist_req()
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_user_pglist_req($user)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_authlist` WHERE `user` = '$user' ";
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

    //UI ProjList request, 获取该用户授权的全部项目列表
    public function db_user_projlist_req($uid)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_authlist` WHERE `uid` = '$uid' ";
        $result = $mysqli->query($query_str);

        $projlist = array();
        while($row = $result->fetch_array())
        {
            $pcode = "";
            $authcode = $row['auth_code'];
            $fromat = substr($authcode, 0, CODE_FORMAT_LEN);
            if($fromat == PROJ_CODE_PREFIX)
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

        $mysqli->close();
        return $projlist;
    }


    //UI ProjectPGList request, 获取该用户授权的项目及项目组列表
    public function db_user_projpglist_req($uid)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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

    //查询项目组下面包含的项目列表
    public function db_pg_projlist_req($pg_code)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_pginfo_update($pginfo)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
                                  VALUES ('$pgcode','$pgname','$owner','$phone','$phone','$department', '$addr','$stage')";

            $result1 = $mysqli->query($query_str);
        }

        //如果存在，先删除项目组所有当前授权的项目list
        $query_str = "DELETE FROM `t_projmapping` WHERE `pg_code` = '$pgcode' ";
        $result = $mysqli->query($query_str);

        //添加授权的项目list到该项目组
        if(!empty($projlist)){
            $i = 0;
            while ($i < count($projlist))
            {
                $pcode = $projlist[$i]["id"];
                $query_str = "INSERT INTO `t_projmapping` (p_code, pg_code) VALUE ('$pcode', '$pgcode')";
                $result2 = $mysqli->query($query_str);
                $i++;
            }
        }

        //$result = $result1 and $result2;
        $mysqli->close();
        return $result;
    }

    //UI ProjDel request，项目信息删除
    public function db_projinfo_delete($pcode)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_pginfo_delete($pgcode)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    private function db_user_statproj_inqury($uid)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_all_sitenum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_all_hcunum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_all_sitelist_req()
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_proj_sitelist_req($p_code)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_all_sitetable_req($start, $total)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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

    //UI DevTable request, 获取全部HCU设备列表信息
    public function db_all_hcutable_req($start, $total)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_site_devlist_req($statcode)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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

    //UI PointDel request，删除一个监测点
    public function db_siteinfo_delete($statcode)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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

    //UI DevDel request，删除一个监测点
    public function db_deviceinfo_delete($devcode)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_hcudevice` WHERE `devcode` = '$devcode'";  //删除HCU device信息表
        $result1 = $mysqli->query($query_str);

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
    public function db_map_sitetinfo_req($uid)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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


    /**********************************************************************************************************************
     *                                                 传感器相关操作DB API                                                 *
     *********************************************************************************************************************/
    //UI AlarmType request, 获取所有需要生成告警数据表的传感器类型信息
    public function db_all_alarmtype_req()
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_all_sensorlist_req()
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_dev_sensorinfo_req($devcode)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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

    //UI DevAlarm Request, 获取当前的测量值，如果测量值超出范围，提示告警
    public function db_dev_currentvalue_req($statcode)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
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
    public function db_dev_alarmhistory_req($statcode, $date, $alarm_type)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        //根据监测点号查找对应的设备号
        $query_str = "SELECT * FROM `t_siteinfo` WHERE `statcode` = '$statcode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows) > 0) {
            $row = $result->fetch_array();
            $devcode = $row['devcode'];
        }

        switch($alarm_type) {
            case S_TYPE_PM:
                $resp["alarm_name"] = "细颗粒物";
                $resp["alarm_unit"] = "毫克每立方米";
                $resp["warning"] = TH_ALARM_PM25;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_pmdata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
                $result = $mysqli->query($query_str);
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

                    //临时填的随机数
                    array_push($resp["hour_alarm"],rand(10,110));
                    array_push($resp["hour_head"],(string)$i);
                    array_push($resp["day_alarm"],rand(10,110));
                    array_push($resp["day_head"],(string)$i);
                }

                break;
            case S_TYPE_WINDSPEED:
                break;

            case S_TYPE_WINDDIR:
                break;

            case S_TYPE_EMC:
                break;

            case S_TYPE_TEMPERATURE:

                break;

            case S_TYPE_HUMIDITY:
                break;
            case S_TYPE_NOISE:
                break;

            default:
                break;
        }

        $mysqli->close();
        return $resp;

    }

//UI GetStaticMonitorTable Request, 获取用户聚合数据
    public function db_user_dataaggregate_req($uid)
    {
        //初始化返回值
        $resp["column"] = array();
        $resp['data'] = array();

        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $auth_list["stat_code"] = array();
        $auth_list["p_code"] = array();
        $auth_list = $this->db_user_statproj_inqury($uid);

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
        array_push($resp["column"], "状态");

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
                array_push($one_row, $row["pm25"]);
                array_push($one_row, $row["temperature"]);
                array_push($one_row, $row["humidity"]);
                array_push($one_row, $row["noise"]);
                array_push($one_row, $row["windspeed"]);
                array_push($one_row, $row["winddirection"]);
            }

            $query_str = "SELECT * FROM `t_hcudevice` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows) > 0) {
                $row = $result->fetch_array();
                if ($row["switch"] == "on")
                    array_push($one_row, "运行");
                elseif ($row["switch"] == "off")
                    array_push($one_row, "停止");
            }

            array_push($resp['data'], $one_row);
        }

        $mysqli->close();
        return $resp;
    }


}//End of class_ui_db

?>