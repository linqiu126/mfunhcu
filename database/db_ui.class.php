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
    /**
     * 随机生成8位字符串作为session id
     * @return string 生成的字符串
     */
    private function getRandomSid()
    {

        $str = "";
        $str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < 8; $i++) {
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
        $mysqli->query("set character_set_connection = utf8");

        //先检查用户名是否存在
        $query_str = "SELECT * FROM `t_account` WHERE `user` = '$name'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $pwd = $row['pwd'];
            $attribute = $row['attribute'];
            if ($attribute == 'admin')
                $admin = "true";
            else
                $admin = "false";

            if ($pwd == $password) {
                $session = $this->getRandomSid();
                $usrinfo = array(
                    'status' => "true",
                    'text' => "login successfully",
                    'key' => $session,
                    'admin' => $admin);
                $this->updateSession($name, $session);
            }
            else {
                $usrinfo = array(
                    'status' => "false",
                    'text' => "password invaild",
                    'key' => null,
                    'admin' => null);
            }
        }
        else {
            $usrinfo = array(
                'status' => "false",
                'text' => "user not exist",
                'key' => null,
                'admin' => null);
        }

        $mysqli->close();
        return $usrinfo;
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

        $query_str = "SELECT * FROM `t_session` WHERE `sessionid` = '$sessionid'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $user = $row['user'];
            $lastupdate = $row['lastupdate'];
            $now= time();
            if ($lastupdate > $now + 7200) //sessionid 超过2小时
                return null;

            $query_str = "SELECT * FROM `t_account` WHERE `user` = '$user'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows)>0) {
                $row = $result->fetch_array();
                $attribute = $row['attribute'];
                if ($attribute == 'admin')
                    $admin = "true";
                else
                    $admin = "false";

                $userinfo = array(
                    'id' => $sessionid,
                    'name' => $user,
                    'admin' => $admin,
                    'city' => $row['city'] );
            }
            else
                return null;
        }
        else
            return null;

        $mysqli->close();
        return $userinfo;
    }

    //查询用户表中记录总数
    public function db_userunm_inqury()
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
    public function db_usertable_req($sid_start, $sid_total)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_account` WHERE `sid` >= $sid_start AND `sid` < ($sid_start+$sid_total)";
        $result = $mysqli->query($query_str);

        $usertable = array();
        while($row = $result->fetch_array())
        {
            $temp = array(
                'id' => $row['sid'],
                'name' => $row['user'],
                'nickname'=> $row['nick'],
                'mobile' => $row['phone'],
                'mail' => $row['email'],
                'type' => $row['attribute'],
                'date' => $row['regdate'],
                'memo' => $row['backup']
            );
            array_push($usertable,$temp);
        }

        $mysqli->close();
        return $usertable;
    }

    //UI userinfo update
    public function db_usertable_add($userinfo)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $user = $userinfo["name"];
        $sid = $userinfo["id"];
        $nick = $userinfo["nickname"];
        $pwd = $userinfo["password"];
        $attribute = $userinfo["type"];
        $phone = $userinfo["mobile"];
        $email = $userinfo["mail"];
        $regdate = $userinfo["regdate"];
        $city = $userinfo["city"];
        $backup = $userinfo["memo"];


        $query_str = "SELECT * FROM `t_account` WHERE `user` = '$user'";
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0) //重复，则覆盖
        {
            $query_str = "UPDATE `t_account` SET `nick` = '$nick',`pwd` = '$pwd',`attribute` = '$attribute',`phone` = '$phone',`email` = '$email',
                          `regdate` = '$regdate', `backup` = '$backup' WHERE (`deviceid` = '$deviceid' )";
            $result = $mysqli->query($query_str);
        }
        else //不存在，新增
        {
            $query_str = "INSERT INTO `t_account` (user,nick,pwd,attribute,phone,email,regdate,backup)
                                  VALUES ('$user','$nick','$pwd','$attribute','$phone','$email', '$regdate','$backup')";

            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }


    //UI userinfo delete
    public function db_usertable_delete($sid)
    {
        //建立连接
        $mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_account` WHERE `sid` = '$sid'";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }





}//End of class_ui_db

?>