<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 22:59
 */
header("Content-type:text/html;charset=utf-8");
//include_once "../../l1comvm/vmlayer.php";

/*
-- --------------------------------------------------------

--
-- 表的结构 `t_l3f2cm_projinfo`
--

CREATE TABLE IF NOT EXISTS `t_l3f2cm_projinfo` (
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
-- 转存表中的数据 `t_l3f2cm_projinfo`
--

INSERT INTO `t_l3f2cm_projinfo` (`p_code`, `p_name`, `chargeman`, `telephone`, `department`, `address`, `country`, `street`, `square`, `starttime`, `pre_endtime`, `true_endtime`, `stage`) VALUES
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

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f2cm_projgroup`
--

CREATE TABLE IF NOT EXISTS `t_l3f2cm_projgroup` (
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
-- 转存表中的数据 `t_l3f2cm_projgroup`
--

INSERT INTO `t_l3f2cm_projgroup` (`pg_code`, `pg_name`, `owner`, `phone`, `department`, `addr`, `backup`) VALUES
('PG_1111', '扬尘项目组', '张三', '13912341234', '扬尘项目组单位', '扬尘项目组单位地址', '该项目组管理所有扬尘项目的用户，项目以及相关权限'),
('PG_2222', '污水处理项目组', '李四', '13912349999', '污水项目组单位', '污水项目组单位地址', '该项目组管理所有污水处理项目的用户，项目以及相关权限');


 */

class classDbiL3apF2cm
{
    //构造函数
    public function __construct()
    {

    }

    private function getRandomKeyid($strlen)
    {

        $str = "";
        $str_pol = "0123456789";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < $strlen; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }

    /**********************************************************************************************************************
     *                          项目Project和项目组ProjectGroup相关操作DB API                                               *
     *********************************************************************************************************************/
    //查询项目表中记录总数
    public function dbi_all_projnum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE 1";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }


    //查询项目组表中记录总数
    public function dbi_all_pgnum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "SELECT * FROM `t_l3f2cm_projgroup` WHERE 1";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    //UI PGTable request, 获取全部项目组列表信息
    public function dbi_all_pgtable_req($start, $query_length)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f2cm_projgroup` limit $start, $query_length";
        $result = $mysqli->query($query_str);
        $pgtable = array();
        while(($result !=false) && (($row = $result->fetch_array()) > 0))
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
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f2cm_projinfo` limit $start, $total";
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
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $list = array();
        $query_str = "SELECT * FROM `t_l3f2cm_projgroup` WHERE 1 ";
        $result = $mysqli->query($query_str);
        while($row = $result->fetch_array()) //获得所有项目组列表
        {
            $temp = array(
                'id' => $row['pg_code'],
                'name' => $row['pg_name']
            );
            array_push($list, $temp);
        }

        $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE 1 ";
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
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $list = array();

        $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE 1 ";
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
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f1sym_authlist` WHERE `uid` = '$uid' ";
        $result = $mysqli->query($query_str);

        $pglist = array();
        while($row = $result->fetch_array())
        {
            $pgcode = "";
            $authcode = $row['auth_code'];
            $fromat = substr($authcode, 0, MFUN_L3APL_F2CM_CODE_FORMAT_LEN);
            if ($fromat == MFUN_L3APL_F2CM_PG_CODE_PREFIX)
                $pgcode = $authcode;

            $query_str = "SELECT * FROM `t_l3f2cm_projgroup` WHERE `pg_code` = '$pgcode'";
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
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f1sym_authlist` WHERE `uid` = '$uid' ";
        $result = $mysqli->query($query_str);

        $projlist = array();
        if($result->num_rows>0)
        {
            while($row = $result->fetch_array())
            {
                $authcode = $row['auth_code'];
                $fromat = substr($authcode, 0, MFUN_L3APL_F2CM_CODE_FORMAT_LEN);
                if($fromat == MFUN_L3APL_F2CM_PROJ_CODE_PREFIX)  //取得code为项目号
                {
                    $pcode = $authcode;
                    $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE `p_code` = '$pcode'";
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
                elseif($fromat == MFUN_L3APL_F2CM_PG_CODE_PREFIX)  //取得的code为项目组号
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
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f1sym_authlist` WHERE `uid` = '$uid' ";
        $result = $mysqli->query($query_str);

        $table = array();
        while($row = $result->fetch_array())
        {
            //获得授权的项目组
            $pgcode = "";
            $pcode = "";
            $authcode = $row['auth_code'];
            $fromat = substr($authcode, 0, MFUN_L3APL_F2CM_CODE_FORMAT_LEN);
            if ($fromat == MFUN_L3APL_F2CM_PG_CODE_PREFIX)
                $pgcode = $authcode;
            elseif($fromat == MFUN_L3APL_F2CM_PROJ_CODE_PREFIX)
                $pcode = $authcode;

            $query_str = "SELECT * FROM `t_l3f2cm_projgroup` WHERE `pg_code` = '$pgcode'";
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
            $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE `p_code` = '$pcode'";
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
    public function dbi_pg_projlist_req($pg_code)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE `pg_code` = '$pg_code' ";
        $result = $mysqli->query($query_str);

        $projlist = array();
        while($row = $result->fetch_array())
        {
            $pcode = $row['p_code'];
            $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE `p_code` = '$pcode'";
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
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
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

        $query_str = "SELECT * FROM `t_l3f2cm_projgroup` WHERE `pg_code` = '$pgcode'";
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0) //重复，则覆盖
        {
            $query_str = "UPDATE `t_l3f2cm_projgroup` SET `pg_name` = '$pgname',`owner` = '$owner',`phone` = '$phone',`department` = '$department',
                          `addr` = '$addr', `backup` = '$stage' WHERE (`pg_code` = '$pgcode' )";
            $result = $mysqli->query($query_str);
        }
        else //不存在，新增
        {
            $query_str = "INSERT INTO `t_l3f2cm_projgroup` (pg_code,pg_name,owner,phone,department,addr,backup)
                                  VALUES ('$pgcode','$pgname','$owner','$phone','$department', '$addr','$stage')";

            $result = $mysqli->query($query_str);
        }

        //先把该项目组下面的原有的项目解绑
        $query_str = "UPDATE `t_l3f2cm_projinfo` SET `pg_code` = '' WHERE (`pg_code` = '$pgcode') ";
        $result = $mysqli->query($query_str);

        //再把更新后授权的项目list到该项目组
        if(!empty($projlist)){
            $i = 0;
            while ($i < count($projlist))
            {
                if(isset($projlist[$i]["id"])) $pcode = $projlist[$i]["id"]; else $pcode = "";
                $query_str = "UPDATE `t_l3f2cm_projinfo` SET `pg_code` = '$pgcode' WHERE (`p_code` = '$pcode') ";
                $result = $mysqli->query($query_str);
                $i++;
            }
        }

        $mysqli->close();
        return $result;
    }

    //UI ProjNew & ProjMod request,添加新项目信息或者修改项目信息
    public function dbi_projinfo_update($projinfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
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

        $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE `p_code` = '$pcode'";
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0) //重复，则覆盖
        {
            $query_str = "UPDATE `t_l3f2cm_projinfo` SET `p_name` = '$pname',`chargeman` = '$chargeman',`telephone` = '$telephone',`department` = '$department',
                          `address` = '$addr', `starttime` = '$starttime', `stage` = '$stage' WHERE (`p_code` = '$pcode' )";
            $result = $mysqli->query($query_str);
        }
        else //不存在，新增
        {
            $query_str = "INSERT INTO `t_l3f2cm_projinfo` (p_code,p_name,chargeman,telephone,department,address,starttime,stage)
                                  VALUES ('$pcode','$pname','$chargeman','$telephone','$department', '$addr','$starttime','$stage')";

            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    //UI ProjDel request，项目信息删除
    public function dbi_projinfo_delete($pcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_l3f2cm_projinfo` WHERE `p_code` = '$pcode'";  //删除项目信息表
        $result1 = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_l3f2cm_sitemapping` WHERE `p_code` = '$pcode'";  //删除项目和监测点的映射关系
        $result2 = $mysqli->query($query_str);

        $query_str = "UPDATE `t_l3f3dm_siteinfo` SET `p_code` = '' WHERE (`p_code` = '$pcode' )"; //删除监测点表中的对应项目号
        $result3 = $mysqli->query($query_str);

        $result = $result1 and $result2 and $result3;

        $mysqli->close();
        return $result;
    }

    //UI PGDel request，项目组信息删除
    public function dbi_pginfo_delete($pgcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_l3f2cm_projgroup` WHERE `pg_code` = '$pgcode'";  //删除项目组信息表
        $result1 = $mysqli->query($query_str);

        $query_str = "UPDATE `t_l3f2cm_projinfo` SET `pg_code` = '' WHERE (`pg_code` = '$pgcode') "; //删除项目组和项目的映射关系
        $result2 = $mysqli->query($query_str);

        $result = $result1 and $result2;

        $mysqli->close();
        return $result;
    }

    /*********************************智能云锁新增处理 Start*********************************************/

    public function dbi_project_userkey_process($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE `keyuserid` = '$uid'";
        $result = $mysqli->query($query_str);

        $user_keylist = array();
        while($row = $result->fetch_array()){
            $keyid = $row['keyid'];
            $keyname = $row['keyname'];
            $p_code = $row['p_code'];
            $temp = array('id'=>$keyid, 'name'=>$keyname, 'domain'=>$p_code);
            array_push($user_keylist,$temp);
        }
        $mysqli->close();
        return $user_keylist;
    }

    public function dbi_all_projkey_process()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE 1 ";
        $result = $mysqli->query($query_str);

        $all_keylist = array();
        while($row = $result->fetch_array()){
            $keyid = $row['keyid'];
            $keyname = $row['keyname'];
            $p_code = $row['p_code'];
            $keyusername = $row['keyusername'];
            $temp = array('id'=>$keyid, 'name'=>$keyname, 'ProjCode'=>$p_code, 'username'=>$keyusername);
            array_push($all_keylist,$temp);
        }
        $mysqli->close();
        return $all_keylist;
    }

    public function dbi_project_keylist_process($projCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE `p_code` = '$projCode' ";
        $result = $mysqli->query($query_str);

        $proj_keylist = array();
        while($row = $result->fetch_array()){
            $keyid = $row['keyid'];
            $keyname = $row['keyname'];
            if($row['keyusername'] != "NULL")
                $keyusername = $row['keyusername'];
            else
                $keyusername = "non-authorized";
            $temp = array('id'=>$keyid, 'name'=>$keyname, 'username'=>$keyusername);
            array_push($proj_keylist,$temp);
        }
        $mysqli->close();
        return $proj_keylist;
    }

    public function dbi_all_projkeyuser_process()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f1sym_authlist` WHERE 1 ";
        $result = $mysqli->query($query_str);

        $all_projuser = array();
        while($row = $result->fetch_array()){
            $auth_code = $row['auth_code'];
            $code_prefix = substr($auth_code, 0, MFUN_L3APL_F2CM_CODE_FORMAT_LEN);
            if ($code_prefix == MFUN_L3APL_F2CM_PROJ_CODE_PREFIX)  //项目号
            {
                $p_code = $auth_code;
                $keyuserid = $row['uid'];

                $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `uid` = '$keyuserid' ";
                $resp = $mysqli->query($query_str);
                $resp_row = $resp->fetch_array();
                $keyusername = $resp_row['nick'];

                $temp = array('id'=>$keyuserid, 'name'=>$keyusername, 'ProjCode'=>$p_code);
                array_push($all_projuser,$temp);
            }
        }

        $mysqli->close();
        return $all_projuser;
    }

    //查询钥匙总数
    public function dbi_all_keynum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE 1";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    //UI ProjTable request, 获取全部项目列表信息
    public function dbi_all_keytable_req($start, $query_length)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` limit $start, $query_length";
        $result = $mysqli->query($query_str);

        $keytable = array();
        while($row = $result->fetch_array())
        {
            $projCode = $row['p_code'];
            $projName = "";
            $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE `p_code` = '$projCode' ";
            $resp = $mysqli->query($query_str);
            if(($resp->num_rows) > 0){
                $resp_row = $resp->fetch_array();
                $projName = $resp_row['p_name'];
            }

            $keytype = $row['keytype'];
            /*
            if ($keytype == MFUN_L3APL_F2CM_KEY_TYPE_RFID)
                $keytype = "RFID钥匙";
            elseif ($keytype == MFUN_L3APL_F2CM_KEY_TYPE_BLE)
                $keytype = "手机蓝牙钥匙";
            elseif ($keytype == MFUN_L3APL_F2CM_KEY_TYPE_USER)
                $keytype = "用户名钥匙";
            elseif ($keytype == MFUN_L3APL_F2CM_KEY_TYPE_WECHAT)
                $keytype = "微信号钥匙";
            elseif ($keytype == MFUN_L3APL_F2CM_KEY_TYPE_IDCARD)
                $keytype = "身份证钥匙";
            elseif ($keytype == MFUN_L3APL_F2CM_KEY_TYPE_PHONE)
                $keytype = "电话号码钥匙";
            else
                $keytype = "未知类型钥匙";
            */

            $temp = array(
                'KeyCode' => $row['keyid'],
                'KeyName' => $row['keyname'],
                'KeyType' => $keytype,
                'HardwareCode' => $row['hwcode'],
                'KeyProj' => $projCode,
                'KeyProjName' => $projName,
                'KeyUser' => $row['keyuserid'],
                'KeyUserName' => $row['keyusername'],
                'Memo' => $row['memo']
            );
            array_push($keytable, $temp);
        }

        $mysqli->close();
        return $keytable;
    }

    public function dbi_key_new_process($keyinfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //if (isset($keyinfo["KeyCode"])) $KeyCode = trim($keyinfo["KeyCode"]); else  $KeyCode = "";
        if (isset($keyinfo["KeyName"])) $keyname = trim($keyinfo["KeyName"]); else  $keyname = "";
        if (isset($keyinfo["KeyProj"])) $projcode = trim($keyinfo["KeyProj"]); else  $projcode = "";
        if (isset($keyinfo["KeyType"])) $keytype = trim($keyinfo["KeyType"]); else  $keytype = "";
        if (isset($keyinfo["HardwareCode"])) $hwcode = trim($keyinfo["HardwareCode"]); else  $hwcode = "";
        if (isset($keyinfo["Memo"])) $memo = trim($keyinfo["Memo"]); else  $memo = "";

        $keyid = MFUN_L3APL_F2CM_KEY_PREFIX.$this->getRandomKeyid(MFUN_L3APL_F2CM_KEY_ID_LEN);  //KEYID的分配机制将来要重新考虑，避免重复
        $keystatus = MFUN_HCU_FHYS_KEY_INVALID; //默认新建的Key是没有启用的，未授予用户

        //转换keytype
        /*
        if ($keytype == "射频卡")
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_RFID;
        elseif ($keytype == "蓝牙")
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_BLE;
        elseif ($keytype == "用户账号")
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_USER;
        elseif ($keytype == "微信号")
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_WECHAT;
        elseif ($keytype == "身份证")
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_IDCARD;
        elseif ($keytype == "电话号码")
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_PHONE;
        else
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_UNDEFINED;
        */

        $query_str = "INSERT INTO `t_l3f2cm_fhys_keyinfo` (keyid, keyname, p_code, keystatus, keytype, hwcode, memo)
                                  VALUES ('$keyid','$keyname','$projcode','$keystatus','$keytype','$hwcode','$memo')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    public function dbi_key_mod_process($keyinfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($keyinfo["KeyCode"])) $keyid = trim($keyinfo["KeyCode"]); else  $keyid = "";
        if (isset($keyinfo["KeyName"])) $keyname = trim($keyinfo["KeyName"]); else  $keyname = "";
        if (isset($keyinfo["KeyProj"])) $projcode = trim($keyinfo["KeyProj"]); else  $projcode = "";
        if (isset($keyinfo["KeyType"])) $keytype = trim($keyinfo["KeyType"]); else  $keytype = "";
        if (isset($keyinfo["HardwareCode"])) $hwcode = trim($keyinfo["HardwareCode"]); else  $hwcode = "";
        if (isset($keyinfo["Memo"])) $memo = trim($keyinfo["Memo"]); else  $memo = "";

        //转换keytype
        /*
        if ($keytype == "射频卡")
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_RFID;
        elseif ($keytype == "蓝牙")
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_BLE;
        elseif ($keytype == "用户账号")
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_USER;
        elseif ($keytype == "微信号")
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_WECHAT;
        elseif ($keytype == "身份证")
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_IDCARD;
        elseif ($keytype == "电话号码")
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_PHONE;
        else
            $keytype = MFUN_L3APL_F2CM_KEY_TYPE_UNDEFINED;
        */

        $query_str = "UPDATE `t_l3f2cm_fhys_keyinfo` SET `keyname` = '$keyname',`p_code` = '$projcode',`keytype` = '$keytype',
                          `hwcode` = '$hwcode', `memo` = '$memo' WHERE (`keyid` = '$keyid' )";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    public function dbi_key_del_process($keyid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE `keyid` = '$keyid'";  //删除该钥匙的所有授权信息
        $result = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_l3f2cm_fhys_keyinfo` WHERE `keyid` = '$keyid'";  //删除钥匙信息
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    public function dbi_obj_authlist_process($authobjcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $code_prefix = substr($authobjcode, 0, MFUN_L3APL_F2CM_CODE_FORMAT_LEN);

        $authlist = array();
        if ($code_prefix == MFUN_L3APL_F2CM_PROJ_CODE_PREFIX)
        {
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE `authobjcode` = '$authobjcode' ";
            $result = $mysqli->query($query_str);
            while($row = $result->fetch_array()){
                //初始化
                $department = "";
                $keyname = "";
                $keyuserid = "";
                $keyusername = "";

                $authid = $row['sid'];
                $keyid = $row['keyid'];
                $authtype = $row['authtype'];
                if ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_TIME)
                    $authtype = "AUTH_TYPE_TIME";
                elseif ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER)
                    $authtype = "AUTH_TYPE_NUMBER";
                elseif ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_FOREVER)
                    $authtype = "AUTH_TYPE_FOREVER";

                $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE `keyid` = '$keyid' ";
                $resp = $mysqli->query($query_str);
                if(($resp->num_rows) > 0){
                    $resp_row = $resp->fetch_array();
                    $keyname = $resp_row['keyname'];
                    $keyuserid = $resp_row['keyuserid'];
                    $keyusername = $resp_row['keyusername'];
                }

                $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE `p_code` = '$authobjcode' ";
                $resp = $mysqli->query($query_str);
                if(($resp->num_rows) > 0){
                    $resp_row = $resp->fetch_array();
                    $department = $resp_row['department'];
                }

                $temp = array('AuthId' => (string)($authid),
                    'DomainId' => $authobjcode,
                    'DomainName' => $department,
                    'KeyId' => $keyid,
                    'KeyName' => $keyname,
                    'UserId' => $keyuserid,
                    'UserName' => $keyusername,
                    'AuthWay' => $authtype);
                array_push($authlist, $temp);
            }
        }
        else{
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE `authobjcode` = '$authobjcode' ";
            $result = $mysqli->query($query_str);
            while($row = $result->fetch_array()) {
                //初始化
                $department = "";
                $keyname = "";
                $keyuserid = "";
                $keyusername = "";

                $authid = $row['sid'];
                $keyid = $row['keyid'];
                $authtype = $row['authtype'];
                if ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_TIME)
                    $authtype = "AUTH_TYPE_TIME";
                elseif ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER)
                    $authtype = "AUTH_TYPE_NUMBER";
                elseif ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_FOREVER)
                    $authtype = "AUTH_TYPE_FOREVER";

                $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE `keyid` = '$keyid' ";
                $resp = $mysqli->query($query_str);
                if (($resp->num_rows) > 0) {
                    $resp_row = $resp->fetch_array();
                    $keyname = $resp_row['keyname'];
                    $keyuserid = $resp_row['keyuserid'];
                    $keyusername = $resp_row['keyusername'];
                }

                $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$authobjcode' ";
                $resp = $mysqli->query($query_str);
                if (($resp->num_rows) > 0) {
                    $resp_row = $resp->fetch_array();
                    $department = $resp_row['statname'];
                }

                $temp = array('AuthId' => (string)($authid),
                              'DomainId' => $authobjcode,
                              'DomainName' => $department,
                              'KeyId' => $keyid,
                              'KeyName' => $keyname,
                              'UserId' => $keyuserid,
                              'UserName' => $keyusername,
                              'AuthWay' => $authtype);
                array_push($authlist, $temp);
            }
        }
        $mysqli->close();
        return $authlist;
    }

    public function dbi_key_authlist_process($keyid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $authlist = array();
        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE `keyid` = '$keyid' ";
        $result = $mysqli->query($query_str);
        while($row = $result->fetch_array())
        {
            //初始化
            $department = "";
            $keyname = "";
            $keyuserid = "";
            $keyusername = "";

            $authid = $row['sid'];
            $authtype = $row['authtype'];
            $authobjcode = $row['authobjcode'];

            if ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_TIME)
                $authtype = "AUTH_TYPE_TIME";
            elseif ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER)
                $authtype = "AUTH_TYPE_NUMBER";
            elseif ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_FOREVER)
                $authtype = "AUTH_TYPE_FOREVER";

            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE `keyid` = '$keyid' ";
            $resp = $mysqli->query($query_str);
            if(($resp->num_rows) > 0){
                $resp_row = $resp->fetch_array();
                $keyname = $resp_row['keyname'];
                $keyuserid = $resp_row['keyuserid'];
                $keyusername = $resp_row['keyusername'];
            }

            $code_prefix = substr($authobjcode, 0, MFUN_L3APL_F2CM_CODE_FORMAT_LEN);
            if ($code_prefix == MFUN_L3APL_F2CM_PROJ_CODE_PREFIX) //项目级授权
            {
                $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE `p_code` = '$authobjcode' ";
                $resp = $mysqli->query($query_str);
                if (($resp->num_rows) > 0) {
                    $resp_row = $resp->fetch_array();
                    $department = $resp_row['p_name']; //取项目名称
                }
            }
            else //站点级授权
            {
                $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$authobjcode' ";
                $resp = $mysqli->query($query_str);
                if (($resp->num_rows) > 0) {
                    $resp_row = $resp->fetch_array();
                    $department = $resp_row['statname'];  //取站点名称
                }
            }

            $temp = array('AuthId' => (string)($authid),
                'DomainId' => $authobjcode,
                'DomainName' => $department,
                'KeyId' => $keyid,
                'KeyName' => $keyname,
                'UserId' => $keyuserid,
                'UserName' => $keyusername,
                'AuthWay' => $authtype);
            array_push($authlist, $temp);
        }
        $mysqli->close();
        return $authlist;
    }

    public function dbi_key_grant_process($keyid, $keyuserid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `uid` = '$keyuserid'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $keyusername = $row['user'];
        }
        //更新钥匙实际使用人
        $query_str = "UPDATE `t_l3f2cm_fhys_keyinfo` SET `keyuserid` = '$keyuserid',`keyusername` = '$keyusername' WHERE (`keyid` = '$keyid') ";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    public function dbi_key_authnew_process($authinfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($authinfo["DomainId"])) $authobjcode = trim($authinfo["DomainId"]); else  $authobjcode = "";
        if (isset($authinfo["KeyId"])) $keyid = trim($authinfo["KeyId"]); else  $keyid = "";
        if (isset($authinfo["Authway"])) $authtype = trim($authinfo["Authway"]); else  $authtype = "";

        $code_prefix = substr($authobjcode, 0, MFUN_L3APL_F2CM_CODE_FORMAT_LEN);
        if ($code_prefix == MFUN_L3APL_F2CM_PROJ_CODE_PREFIX)
            $authlevel = MFUN_L3APL_F2CM_AUTH_LEVEL_PROJ;
        else
            $authlevel = MFUN_L3APL_F2CM_AUTH_LEVEL_DEVICE;

        $timestamp = time();
        $validstart = date("Y-m-d", $timestamp);
        if ($authtype =='always'){
            $authtype = MFUN_L3APL_F2CM_AUTH_TYPE_FOREVER;
            $query_str = "INSERT INTO `t_l3f2cm_fhys_keyauth` (keyid, authlevel, authobjcode, authtype)
                                  VALUES ('$keyid','$authlevel','$authobjcode','$authtype')";
            $result = $mysqli->query($query_str);
        }
        else{
            $validend = $authtype;
            $authtype = MFUN_L3APL_F2CM_AUTH_TYPE_TIME;
            $query_str = "INSERT INTO `t_l3f2cm_fhys_keyauth` (keyid, authlevel, authobjcode, authtype, validstart, validend)
                                  VALUES ('$keyid','$authlevel','$authobjcode','$authtype','$validstart','$validend')";
            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
   }

    public function dbi_key_authdel_process($authid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE `sid` = '$authid'";  //删除一条授权信息
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    //用于FHYS临时纤芯资源管理
    public function dbi_fhys_get_rtutable_req($uid)
    {
        //初始化返回值
        $resp["column"] = array();
        $resp['data'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        //填充表头
        array_push($resp["column"], "RTU-Code");
        array_push($resp["column"], "RTU-Name");
        array_push($resp["column"], "IP-Addr");
        array_push($resp["column"], "Port");
        array_push($resp["column"], "Timeout");
        array_push($resp["column"], "Slot-Num");
        array_push($resp["column"], "Room-Code");
        array_push($resp["column"], "Collector-Code");
        array_push($resp["column"], "Memo");

        $query_str = "SELECT * FROM `t_l3f2cm_fhys_rtu` WHERE 1";
        $result = $mysqli->query($query_str);
        while ($row = $result->fetch_array())
        {
            $one_row = array();//初始化

            array_push($one_row, $row["rtucode"]);
            array_push($one_row, $row["rtuname"]);
            array_push($one_row, $row["ipaddr"]);
            array_push($one_row, $row["port"]);
            array_push($one_row, $row["timeout"]);
            array_push($one_row, $row["slot"]);
            array_push($one_row, $row["roomcode"]);
            array_push($one_row, $row["collector"]);
            array_push($one_row, $row["backup"]);

            array_push($resp['data'], $one_row);
        }

        $mysqli->close();
        return $resp;
    }

    public function dbi_fhys_get_otdrtable_req($uid)
    {
        //初始化返回值
        $resp["column"] = array();
        $resp['data'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        //填充表头
        array_push($resp["column"], "OTDR-Code");
        array_push($resp["column"], "OTDR-Name");
        array_push($resp["column"], "IP-Addr");
        array_push($resp["column"], "Port");
        array_push($resp["column"], "RTU-Code");
        array_push($resp["column"], "RTU-Slot");
        array_push($resp["column"], "Read-Format");
        array_push($resp["column"], "Collector-Code");
        array_push($resp["column"], "Memo");

        $query_str = "SELECT * FROM `t_l3f2cm_fhys_otdr` WHERE 1";
        $result = $mysqli->query($query_str);
        while ($row = $result->fetch_array())
        {
            $one_row = array();//初始化

            array_push($one_row, $row["otdrcode"]);
            array_push($one_row, $row["otdrname"]);
            array_push($one_row, $row["ipaddr"]);
            array_push($one_row, $row["port"]);
            array_push($one_row, $row["rtucode"]);
            array_push($one_row, $row["rtuslot"]);
            array_push($one_row, $row["cmdformat"]);
            array_push($one_row, $row["collector"]);
            array_push($one_row, $row["backup"]);

            array_push($resp['data'], $one_row);
        }

        $mysqli->close();
        return $resp;
    }

}

?>