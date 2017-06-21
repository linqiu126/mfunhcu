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

/***********************************************************************************************************************
*                                              与UI界面无关的私有函数API                                                 *
***********************************************************************************************************************/
    //获取随机数
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

    //去除二维数组中的重复项
    private function unique_arr($array2D,$stkeep=false,$ndformat=true)
    {
        // 判断是否保留一级数组键 (一级数组键可以为非数字)
        if($stkeep) $stArr = array_keys($array2D);
        // 判断是否保留二级数组键 (所有二级数组键必须相同)
        if($ndformat) $ndArr = array_keys(end($array2D));
        //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
        foreach ($array2D as $v){
            $v = join(",",$v);
            $temp[] = $v;
        }
        //去掉重复的字符串,也就是重复的一维数组
        $temp = array_unique($temp);
        //再将拆开的数组重新组装
        $i = 0;
        foreach ($temp as $k => $v)
        {
            if($stkeep) $k = $stArr[$k];
            if($ndformat)
            {
                $tempArr = explode(",",$v);
                foreach($tempArr as $ndkey => $ndval) $output[$i][$ndArr[$ndkey]] = $ndval;
                $i++;
            }
            else $output[$k] = explode(",",$v);
        }
        return $output;
    }

    //获取用户授权的项目组列表，如果没有直接授权项目组，则默认授权项目对应的项目组允许访问
    private function dbi_get_user_auth_projgroup($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $projectlist = $this->dbi_get_user_auth_project($uid);

        $pg_list = array();
        for($i=0; $i<count($projectlist); $i++)
        {
            $projcode = $projectlist[$i]['id'];
            $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE `p_code` = '$projcode'";
            $result = $mysqli->query($query_str);
            if ($result->num_rows > 0){
                $row = $result->fetch_array();
                $pgcode = $row['pg_code'];
                $query_str = "SELECT * FROM `t_l3f2cm_projgroup` WHERE `pg_code` = '$pgcode'";
                $resp = $mysqli->query($query_str);
                if (($resp->num_rows) > 0) {
                    $list = $resp->fetch_array();
                    $temp = array(
                        'id' => $list['pg_code'],
                        'name' => $list['pg_name']
                    );
                    array_push($pg_list, $temp);
                }
            }
        }
        //删除项目组列表里重复的项
        $unique_pglist = $this->unique_arr($pg_list, false, true);
        $mysqli->close();
        return $unique_pglist;
    }

    //获取该用户授权的全部项目列表,包括授权项目组下面的项目列表
    private function dbi_get_user_auth_project($uid)
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
        //删除项目列表里重复的项
        $unique_projlist = $this->unique_arr($projlist,false,true);
        $mysqli->close();
        return $unique_projlist;
    }

    //获取该用户授权的站点列表
    private function dbi_get_user_auth_site($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $projectlist = $this->dbi_get_user_auth_project($uid);

        $site_list = array();
        for($i=0; $i<count($projectlist); $i++)
        {
            $projcode = $projectlist[$i]['id'];

            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `p_code` = '$projcode'";
            $result = $mysqli->query($query_str);
            while($row = $result->fetch_array())
            {
                $temp = array(
                    'id' => $row['statcode'],
                    'name' => $row['statname'],
                );
                array_push($site_list, $temp);
            }
        }

        $mysqli->close();
        return $site_list;
    }

    private function dbi_print_export_usertable($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $resp["column"] = array();
        $resp['data'] = array();

        array_push($resp["column"],"用户ID");
        array_push($resp["column"],"用户名");
        array_push($resp["column"],"昵称");
        array_push($resp["column"],"电话");
        array_push($resp["column"],"邮箱");
        array_push($resp["column"],"属性");
        array_push($resp["column"],"更新日期");
        array_push($resp["column"],"备注");

        $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE (`uid` = '$uid')";
        $result = $mysqli->query($query_str);
        $user = "";
        if (($result != false) && (($info = $result->fetch_array()) > 0))
        {
            $user = $info['user'];
            $grade = $info["grade"];
            if ($grade == "0")
                $grade_name = "管理员";
            elseif ($grade == "1")
                $grade_name = "高级用户";
            elseif ($grade == "2")
                $grade_name = "一级用户";
            elseif ($grade == "3")
                $grade_name = "二级用户";
            elseif ($grade == "4")
                $grade_name = "三级用户";
            else
                $grade_name = "用户登记未知";

            $one_row = array();
            array_push($one_row, $info["uid"]);
            array_push($one_row, $info["user"]);
            array_push($one_row, $info["nick"]);
            array_push($one_row, $info["phone"]);
            array_push($one_row, $info["email"]);
            array_push($one_row, $grade_name);
            array_push($one_row, $info["regdate"]);
            array_push($one_row, $info["backup"]);

            array_push($resp['data'],$one_row);
        }


        //如果是特殊用户则显示所有用户表
        if ($user == 'admin' OR $user == 'foha')
        {
            $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE 1";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($info = $result->fetch_array()) > 0))
            {
                $grade = $info["grade"];
                if ($grade == "0")
                    $grade_name = "管理员";
                elseif ($grade == "1")
                    $grade_name = "高级用户";
                elseif ($grade == "2")
                    $grade_name = "一级用户";
                elseif ($grade == "3")
                    $grade_name = "二级用户";
                elseif ($grade == "4")
                    $grade_name = "三级用户";
                else
                    $grade_name = "用户等级未知";
                $one_row = array();
                array_push($one_row, $info["uid"]);
                array_push($one_row, $info["user"]);
                array_push($one_row, $info["nick"]);
                array_push($one_row, $info["phone"]);
                array_push($one_row, $info["email"]);
                array_push($one_row, $grade_name);
                array_push($one_row, $info["regdate"]);
                array_push($one_row, $info["backup"]);

                array_push($resp['data'],$one_row);
            }
        }

        $mysqli->close();
        return $resp;
    }

    private function dbi_print_export_pgtable($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $pg_table["column"] = array();
        $pg_table['data'] = array();
        array_push($pg_table["column"],"项目组编号");
        array_push($pg_table["column"],"项目组名称");
        array_push($pg_table["column"],"责任人");
        array_push($pg_table["column"],"电话");
        array_push($pg_table["column"],"所属单位");
        array_push($pg_table["column"],"地址");
        array_push($pg_table["column"],"备注");

        $pglist = $this->dbi_get_user_auth_projgroup($uid);

        for($i=0; $i<count($pglist); $i++)
        {
            $pgcode = $pglist[$i]['id'];
            $query_str = "SELECT * FROM `t_l3f2cm_projgroup` WHERE `pg_code` = '$pgcode' ";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($info = $result->fetch_array()) > 0)) {
                $one_row = array();
                array_push($one_row, $info["pg_code"]);
                array_push($one_row, $info["pg_name"]);
                array_push($one_row, $info["owner"]);
                array_push($one_row, $info["phone"]);
                array_push($one_row, $info["department"]);
                array_push($one_row, $info["addr"]);
                array_push($one_row, $info["backup"]);

                array_push($pg_table['data'],$one_row);
            }
        }
        $mysqli->close();
        return $pg_table;
    }

    private function dbi_print_export_projtable($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $proj_table["column"] = array();
        $proj_table['data'] = array();
        array_push($proj_table["column"],"项目编号");
        array_push($proj_table["column"],"项目名称");
        array_push($proj_table["column"],"负责人");
        array_push($proj_table["column"],"电话");
        array_push($proj_table["column"],"所属单位");
        array_push($proj_table["column"],"地址");
        array_push($proj_table["column"],"备注");

        $projectlist = $this->dbi_get_user_auth_project($uid);

        for($i=0; $i<count($projectlist); $i++)
        {
            $projcode = $projectlist[$i]['id'];
            $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE `p_code` = '$projcode' ";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($info = $result->fetch_array()) > 0)) {
                $one_row = array();
                array_push($one_row, $info["p_code"]);
                array_push($one_row, $info["p_name"]);
                array_push($one_row, $info["chargeman"]);
                array_push($one_row, $info["telephone"]);
                array_push($one_row, $info["department"]);
                array_push($one_row, $info["address"]);
                array_push($one_row, $info["stage"]);

                array_push($proj_table['data'],$one_row);
            }
        }
        $mysqli->close();
        return $proj_table;
    }

    private function dbi_print_export_sitetable($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $site_table["column"] = array();
        $site_table['data'] = array();
        array_push($site_table["column"],"站点编号");
        array_push($site_table["column"],"站点名称");
        array_push($site_table["column"],"负责人");
        array_push($site_table["column"],"电话");
        array_push($site_table["column"],"区县");
        array_push($site_table["column"],"街道");
        array_push($site_table["column"],"地址");
        array_push($site_table["column"],"经度");
        array_push($site_table["column"],"纬度");
        array_push($site_table["column"],"开通时间");
        array_push($site_table["column"],"备注");

        $projectlist = $this->dbi_get_user_auth_project($uid);

        for($i=0; $i<count($projectlist); $i++)
        {
            $projcode = $projectlist[$i]['id'];
            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `p_code` = '$projcode' ";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($info = $result->fetch_array()) > 0)) {
                $one_row = array();
                array_push($one_row, $info["statcode"]);
                array_push($one_row, $info["statname"]);
                array_push($one_row, $info["chargeman"]);
                array_push($one_row, $info["telephone"]);
                array_push($one_row, $info["country"]);
                array_push($one_row, $info["street"]);
                array_push($one_row, $info["address"]);
                array_push($one_row, $info["longitude"]);
                array_push($one_row, $info["latitude"]);
                array_push($one_row, $info["starttime"]);
                array_push($one_row, $info["memo"]);

                array_push($site_table['data'],$one_row);
            }
        }
        $mysqli->close();
        return $site_table;
    }

    private function dbi_print_export_devtable($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $dev_table["column"] = array();
        $dev_table['data'] = array();
        array_push($dev_table["column"],"设备编号");
        array_push($dev_table["column"],"站点名称");
        array_push($dev_table["column"],"所属项目");
        array_push($dev_table["column"],"安装时间");

        $site_list = $this->dbi_get_user_auth_site($uid);

        for($i=0; $i<count($site_list); $i++)
        {
            $statcode = $site_list[$i]['id'];
            $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($devinfo = $result->fetch_array()) > 0)) {
                $devcode = $devinfo['devcode'];
                $statcode = $devinfo['statcode'];
                $starttime = $devinfo['opendate'];

                $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";      //查询HCU设备对应监测点号
                $resp = $mysqli->query($query_str);
                if (($resp != false )&& (($siteinfo = $resp->fetch_array()) > 0)){
                    $projcode = $siteinfo['p_code'];
                    $one_row = array();
                    array_push($one_row, $devcode);
                    array_push($one_row, $statcode);
                    array_push($one_row, $projcode);
                    array_push($one_row, $starttime);

                    array_push($dev_table['data'],$one_row);
                }
            }
        }
        $mysqli->close();
        return $dev_table;
    }

    public function dbi_print_excel_table_query_process($uid, $tablename)
    {
        $resp["column"] = array();
        $resp['data'] = array();
        switch ($tablename)
        {
            case "usertable":
                $resp = $this->dbi_print_export_usertable($uid);
                break;
            case "PGtable":
                $resp = $this->dbi_print_export_pgtable($uid);
                break;
            case "Projtable":
                $resp = $this->dbi_print_export_projtable($uid);
                break;
            case "Pointtable":
                $resp = $this->dbi_print_export_sitetable($uid);
                break;
            case "Devtable":
                $resp = $this->dbi_print_export_devtable($uid);
                break;
            default:
                //do nothing
                break;
        }

        return $resp;
    }

/***********************************************************************************************************************
*                          项目Project和项目组ProjectGroup相关操作DB API                                                 *
***********************************************************************************************************************/
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
    public function dbi_user_pg_table_req($uid, $startseq, $query_length)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $pglist = $this->dbi_get_user_auth_projgroup($uid);

        $pgtable = array();
        $pgtotal = count($pglist);
        if(($startseq <= $pgtotal) AND ($startseq + $query_length > $pgtotal))
            $query_length = $pgtotal - $startseq;
        elseif ($startseq > $pgtotal)
            $query_length = 0;

        for($i=$startseq; $i<$startseq + $query_length; $i++)
        {

            $pgcode = $pglist[$i]['id'];
            $query_str = "SELECT * FROM `t_l3f2cm_projgroup` WHERE `pg_code` = '$pgcode' ";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($row = $result->fetch_array()) > 0)) {
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
        }

        $mysqli->close();
        return $pgtable;
    }

    //UI ProjTable request, 获取全部项目列表信息
    public function dbi_all_projtable_req($uid, $startseq, $query_length)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $projectlist = $this->dbi_get_user_auth_project($uid);

        $projtotal = count($projectlist);
        if(($startseq <= $projtotal) AND ($startseq + $query_length > $projtotal))
            $query_length = $projtotal - $startseq;
        elseif ($startseq > $projtotal)
            $query_length = 0;

        $projtable = array();

        for($i=$startseq; $i<$startseq + $query_length; $i++){
            $projcode = $projectlist[$i]['id'];
            $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE `p_code` = '$projcode' ";
            $result = $mysqli->query($query_str);
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
        }

        $mysqli->close();
        return $projtable;
    }

    //UI ProjectPGList request, 获取所有项目及项目组列表,该列表信息用户初始授权，所有给出的是全列表
    public function dbi_user_all_projpglist_req()
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
    public function dbi_user_all_projlist_req($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $list = array();
        $list = $this->dbi_get_user_auth_project($uid);

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

    /**********************************************************************************************************************
     *                                          监测点及HCU设备相关操作DB API                                               *
     *********************************************************************************************************************/

    //查询监控点表中记录总数
    public function dbi_all_sitenum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE 1";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    //UI ProjPoint request,查询某用户授权的所有项目监测点列表
    public function dbi_user_all_proj_sitelist_req($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $projectlist = $this->dbi_get_user_auth_project($uid);
        $projtotal = count($projectlist);
        $sitelist = array();

        for($i=0; $i<$projtotal; $i++)
        {
            $projcode = $projectlist[$i]['id'];
            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `p_code` = '$projcode' ";
            $result = $mysqli->query($query_str);
            while($row = $result->fetch_array())
            {
                $temp = array(
                    'id' => $row['statcode'],
                    'name' => $row['statname'],
                    'ProjCode' => $row['p_code']
                );
                array_push($sitelist, $temp);
            }
        }

        $mysqli->close();
        return $sitelist;
    }

    //UI ProjPoint request,查询某一个项目下面包含的所有监测点列表
    public function dbi_one_proj_sitelist_req($p_code)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `p_code` = '$p_code' ";
        $result = $mysqli->query($query_str);

        $sitelist = array();
        while($row = $result->fetch_array())
        {
            $temp = array(
                'id' => $row['statcode'],
                'name' => $row['statname'],
                'ProjCode' => $p_code
            );
            array_push($sitelist, $temp);
        }

        $mysqli->close();
        return $sitelist;
    }

    //UI ProjTable request, 获取全部监测点列表信息
    public function dbi_all_sitetable_req($uid, $startseq, $query_length)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $projectlist = $this->dbi_get_user_auth_project($uid);

        $projtotal = count($projectlist);
        if(($startseq <= $projtotal) AND ($startseq + $query_length > $projtotal))
            $query_length = $projtotal - $startseq;
        elseif ($startseq > $projtotal)
            $query_length = 0;

        $sitetable = array();
        for($i=$startseq; $i<$startseq + $query_length; $i++)
        {
            $projcode = $projectlist[$i]['id'];

            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `p_code` = '$projcode'";
            $result = $mysqli->query($query_str);
            while($row = $result->fetch_array())
            {
                $temp = array(
                    'StatCode' => $row['statcode'],
                    'StatName' => $row['statname'],
                    'ProjCode' => $row['p_code'],
                    'ChargeMan' => $row['chargeman'],
                    'Telephone' => $row['telephone'],
                    'Longitude' => $row['longitude'],
                    'Latitude' => $row['latitude'],
                    'Department' => $row['department'],
                    'Address' => $row['address'],
                    'Country' => $row['country'],
                    'Street' => $row['street'],
                    'Square' => $row['square'],
                    'ProStartTime' => $row['starttime'],
                    'Stage' => $row['memo']
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
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($siteinfo["StatCode"])) $statcode = trim($siteinfo["StatCode"]); else  $statcode = "";
        if (isset($siteinfo["StatName"])) $statname = trim($siteinfo["StatName"]); else  $statname = "";
        if (isset($siteinfo["ProjCode"])) $pcode = trim($siteinfo["ProjCode"]); else  $pcode = "";
        if (isset($siteinfo["ChargeMan"])) $chargeman = trim($siteinfo["ChargeMan"]); else  $chargeman = "";
        if (isset($siteinfo["Telephone"])) $telephone = trim($siteinfo["Telephone"]); else  $telephone = "";
        if (isset($siteinfo["Longitude"])) $longitude = trim($siteinfo["Longitude"]); else  $longitude = "";
        if (isset($siteinfo["Latitude"])) $latitude = trim($siteinfo["Latitude"]); else  $latitude = "";
        if (isset($siteinfo["Department"])) $department = trim($siteinfo["Department"]); else  $department = "";
        if (isset($siteinfo["Address"])) $addr = trim($siteinfo["Address"]); else  $addr = "";
        if (isset($siteinfo["Country"])) $country = trim($siteinfo["Country"]); else  $country = "";
        if (isset($siteinfo["Street"])) $street = trim($siteinfo["Street"]); else  $street = "";
        if (isset($siteinfo["Square"])) $square = trim($siteinfo["Square"]); else  $square = "";
        if (isset($siteinfo["ProStartTime"])) $starttime = trim($siteinfo["ProStartTime"]); else  $starttime = "";
        if (isset($siteinfo["Stage"])) $memo = trim($siteinfo["Stage"]); else  $memo = "";

        //暂时初始化的值，将来需要调整
        $altitude = 0;
        $flag_la = "N";
        $flag_lo = "E";

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0) //重复，则覆盖
        {
            $query_str = "UPDATE `t_l3f3dm_siteinfo` SET `statname` = '$statname',`p_code` = '$pcode',`chargeman` = '$chargeman',`telephone` = '$telephone',`department` = '$department',
                          `country` = '$country',`street` = '$street',`address` = '$addr',`starttime` = '$starttime',`square` = '$square',`altitude` = '$altitude',
                          `flag_la` = '$flag_la',`latitude` = '$latitude',`flag_lo` = '$flag_lo',`longitude` = '$longitude',`memo` = '$memo'  WHERE (`statcode` = '$statcode' )";
            $result = $mysqli->query($query_str);
        }
        else //不存在，新增
        {
            $query_str = "INSERT INTO `t_l3f3dm_siteinfo` (statcode,statname,p_code,chargeman,telephone,department,country,street,address,starttime,square,altitude,flag_la,latitude,flag_lo,longitude,memo)
                                  VALUES ('$statcode','$statname','$pcode','$chargeman','$telephone','$department','$country','$street','$addr','$starttime','$square','$altitude','$flag_la','$latitude','$flag_lo','$longitude','$memo')";
            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    public function dbi_siteinfo_update_gps($devcode, $latitude, $longitude)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT `statcode` FROM `t_l2sdk_iothcu_inventory` WHERE (`devcode` = '$devcode')";
        $result = $mysqli->query($query_str);
        if ($result->num_rows>0){
            $row = $result->fetch_array();
            $statcode = $row['statcode'];
        }
        else
            $statcode = "";

        $flag_la = "N";
        $flag_lo = "E";
        $query_str = "UPDATE `t_l3f3dm_siteinfo` SET `flag_la` = '$flag_la', `latitude` = '$latitude',`flag_lo` = '$flag_lo',`longitude` = '$longitude' WHERE (`statcode` = '$statcode' )";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    //UI DevTable request, 获取全部HCU设备列表信息
    public function dbi_all_hcutable_req($uid, $startseq, $query_length)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $site_list = $this->dbi_get_user_auth_site($uid);

        $sitetotal = count($site_list);
        if(($startseq <= $sitetotal) AND ($startseq + $query_length > $sitetotal))
            $query_length = $sitetotal - $startseq;
        elseif ($startseq > $sitetotal)
            $query_length = 0;

        $hcutable = array();
        for($i=$startseq; $i<$startseq + $query_length; $i++)
        {
            $statcode = $site_list[$i]['id'];
            $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);

            while (($result != false) && (($row = $result->fetch_array()) > 0))
            {
                $devcode = $row['devcode'];
                $statcode = $row['statcode'];
                $macaddr = $row['macaddr_eth0'];
                $ipaddr = $row['ip_wlan0'];
                $devstatus = $row['status'];
                $starttime = $row['opendate'];
                $url = $row['videourl'];
                if ($devstatus == MFUN_HCU_AQYC_STATUS_ON)
                    $devstatus = "true";
                elseif($devstatus == MFUN_HCU_AQYC_STATUS_OFF)
                    $devstatus = "false";

                $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";      //查询HCU设备对应监测点号
                $resp = $mysqli->query($query_str);
                if (($resp->num_rows)>0) {
                    $info = $resp->fetch_array();
                    $temp = array(
                        'DevCode' => $devcode,
                        'StatCode' => $statcode,
                        'ProjCode' => $info['p_code'],
                        'StartTime' => $starttime, //$info['starttime'], 取用HCU_inventory表中HCU开通时间
                        'PreEndTime' => "",  //TBD
                        'EndTime' => "",     //TBD
                        'DevStatus' => $devstatus,
                        'VideoURL' => $url,
                        'MAC' => $macaddr,
                        'IP' => $ipaddr
                    );
                    array_push($hcutable, $temp);
                }
            }
        }

        $mysqli->close();
        return $hcutable;
    }

    //UI PointDev Request，查询监测点下面HCU列表
    public function dbi_site_devlist_req($statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `statcode` = '$statcode' ";
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
    public function dbi_siteinfo_delete($statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";  //删除监测点信息表
        $result1 = $mysqli->query($query_str);

        $query_str = "UPDATE `t_l2sdk_iothcu_inventory` SET `statcode` = '' WHERE (`statcode` = '$statcode' )"; //删除HCU设备表中的对应监测点号
        $result2 = $mysqli->query($query_str);

        $result = $result1 and $result2;

        $mysqli->close();
        return $result;
    }

    //ZJL: 这个东西同时连接两个数据库，需要分开
    //UI DevDel request，删除一个监测点
    public function dbi_deviceinfo_delete($devcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_l2sdk_iothcu_inventory` WHERE `devcode` = '$devcode'";  //删除HCU device信息表
        $result1 = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_l3f4icm_sensorctrl` WHERE `deviceid` = '$devcode'";  //删除Sensorctrl表中HUC信息
        $result2 = $mysqli->query($query_str);

        $result = $result1 and $result2;

        $mysqli->close();
        return $result;
    }

    //查询HCU设备表中记录总数
    public function dbi_all_hcunum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE 1";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    //UI DevNew & DevMod request,添加HCU设备信息或者修改HCU设备信息
    public function dbi_devinfo_update($devinfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($devinfo["DevCode"])) $devcode = trim($devinfo["DevCode"]); else  $devcode = "";
        if (isset($devinfo["StatCode"])) $statcode = trim($devinfo["StatCode"]); else  $statcode = "";
        if (isset($devinfo["StartTime"])) $starttime = trim($devinfo["StartTime"]); else  $starttime = "";
        if (isset($devinfo["PreEndTime"])) $preendtime = trim($devinfo["PreEndTime"]); else  $preendtime = "";
        if (isset($devinfo["EndTime"])) $endtime = trim($devinfo["EndTime"]); else  $endtime = "";
        if (isset($devinfo["DevStatus"])) $devstatus = trim($devinfo["DevStatus"]); else  $devstatus = "";
        if (isset($devinfo["VideoURL"])) $videourl = trim($devinfo["VideoURL"]); else  $videourl = "";

        if($devstatus == "true")
            $devstatus = MFUN_HCU_AQYC_STATUS_ON;
        else
            $devstatus = MFUN_HCU_AQYC_STATUS_OFF;

        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `devcode` = '$devcode'";  //更新设备表
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0) //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2sdk_iothcu_inventory` SET `statcode` = '$statcode',`opendate` = '$starttime',`status` = '$devstatus',`videourl` = '$videourl' WHERE (`devcode` = '$devcode' )";
            $result = $mysqli->query($query_str);
        }
        else //不存在，新增
        {
            $query_str = "INSERT INTO `t_l2sdk_iothcu_inventory` (devcode,statcode,opendate,status,videourl) VALUES ('$devcode','$statcode','$starttime','$devstatus','$videourl')";
            $result = $mysqli->query($query_str);
        }

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

    public function dbi_all_projkey_process($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $all_keylist = array();
        $projectlist = $this->dbi_get_user_auth_project($uid);

        for($i=0; $i<count($projectlist); $i++)
        {
            $projCode = $projectlist[$i]['id'];
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE  `p_code` = '$projCode' ";
            $result = $mysqli->query($query_str);

            while($row = $result->fetch_array()){
                $keyid = $row['keyid'];
                $keyname = $row['keyname'];
                $p_code = $row['p_code'];
                $keyusername = $row['keyusername'];
                $temp = array('id'=>$keyid, 'name'=>$keyname, 'ProjCode'=>$p_code, 'username'=>$keyusername);
                array_push($all_keylist,$temp);
            }
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
                $keyusername = "未授予";
            $temp = array('id'=>$keyid, 'name'=>$keyname, 'username'=>$keyusername);
            array_push($proj_keylist,$temp);
        }
        $mysqli->close();
        return $proj_keylist;
    }

    public function dbi_all_projkeyuser_process($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $projectlist = $this->dbi_get_user_auth_project($uid);

        $all_projuser = array();
        for($i=0; $i<count($projectlist);$i++)
        {
            $projcode = $projectlist[$i]['id'];
            $query_str = "SELECT * FROM `t_l3f1sym_authlist` WHERE `auth_code` = '$projcode' ";
            $result = $mysqli->query($query_str);
            while($row = $result->fetch_array()){
                $keyuserid = $row['uid'];
                $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `uid` = '$keyuserid' ";
                $resp = $mysqli->query($query_str);
                $resp_row = $resp->fetch_array();
                $keyusername = $resp_row['nick'];

                $temp = array('id'=>$keyuserid, 'name'=>$keyusername, 'ProjCode'=>$projcode);
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
    public function dbi_all_keytable_req($uid, $startseq, $query_length)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $projectlist = $this->dbi_get_user_auth_project($uid);

        $projtotal = count($projectlist);
        if(($startseq <= $projtotal) AND ($startseq + $query_length > $projtotal))
            $query_length = $projtotal - $startseq;
        elseif ($startseq > $projtotal)
            $query_length = 0;

        $keytable = array();
        for($i=$startseq; $i<$startseq + $query_length; $i++)
        {
            $projcode = $projectlist[$i]['id'];
            $projname = $projectlist[$i]['name'];

            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE `p_code` = '$projcode'";
            $result = $mysqli->query($query_str);
            while($row = $result->fetch_array())
            {
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
                    'KeyProj' => $projcode,
                    'KeyProjName' => $projname,
                    'KeyUser' => $row['keyuserid'],
                    'KeyUserName' => $row['keyusername'],
                    'Memo' => $row['memo']
                );
                array_push($keytable, $temp);
            }
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
                    $authtype = "时间授权";
                elseif ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER)
                    $authtype = "次数授权";
                elseif ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_FOREVER)
                    $authtype = "永久授权";

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
                    $authtype = "时间授权";
                elseif ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER)
                    $authtype = "次数授权";
                elseif ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_FOREVER)
                    $authtype = "永久授权";

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
                $authtype = "时间授权";
            elseif ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER)
                $authtype = "次数授权";
            elseif ($authtype == MFUN_L3APL_F2CM_AUTH_TYPE_FOREVER)
                $authtype = "永久授权";

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

            //判断是否重复的授权，不重复才插入一条记录，这个地方代码有点低效丑陋，可以考虑用relace语句
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE (`keyid` = '$keyid' AND `authobjcode` = '$authobjcode' AND `authtype` = '$authtype')";
            $result = $mysqli->query($query_str);
            if (($result->num_rows)==0) {
                $query_str = "INSERT INTO `t_l3f2cm_fhys_keyauth` (keyid, authlevel, authobjcode, authtype)
                                  VALUES ('$keyid','$authlevel','$authobjcode','$authtype')";
                $result = $mysqli->query($query_str);
            }
        }
        else{
            $validend = $authtype;
            $authtype = MFUN_L3APL_F2CM_AUTH_TYPE_TIME;

            //判断是否重复的授权，不重复才插入一条记录，这个地方代码有点低效丑陋，可以考虑用relace语句
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE (`keyid` = '$keyid' AND `authobjcode` = '$authobjcode' AND `authtype` = '$authtype')";
            $result = $mysqli->query($query_str);
            if (($result->num_rows)>0) {
                $query_str = "UPDATE `t_l3f2cm_fhys_keyauth` SET `authlevel` = '$authlevel',`validstart` = '$validstart',`validend` = '$validend'
                            WHERE (`keyid` = '$keyid' AND `authobjcode` = '$authobjcode' AND `authtype` = '$authtype') ";
                $result = $mysqli->query($query_str);
            }
            else{
                $query_str = "INSERT INTO `t_l3f2cm_fhys_keyauth` (keyid, authlevel, authobjcode, authtype, validstart, validend)
                                  VALUES ('$keyid','$authlevel','$authobjcode','$authtype','$validstart','$validend')";
                $result = $mysqli->query($query_str);
            }
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
        array_push($resp["column"], "RTU代码");
        array_push($resp["column"], "RTU名称");
        array_push($resp["column"], "IP地址");
        array_push($resp["column"], "端口");
        array_push($resp["column"], "超时");
        array_push($resp["column"], "槽位数");
        array_push($resp["column"], "机房代码");
        array_push($resp["column"], "数据采集器代码");
        array_push($resp["column"], "备注");

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
        array_push($resp["column"], "OTDR代码");
        array_push($resp["column"], "OTDR名称");
        array_push($resp["column"], "IP地址");
        array_push($resp["column"], "端口");
        array_push($resp["column"], "RTU代码");
        array_push($resp["column"], "RTU槽位");
        array_push($resp["column"], "读取信息命令格式");
        array_push($resp["column"], "数据采集器代码");
        array_push($resp["column"], "备注");

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