<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 23:01
 */
header("Content-type:text/html;charset=utf-8");
//include_once "../../l1comvm/vmlayer.php";


class classDbiL3apF11faam
{
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

    //获取该用户授权的工厂号，暂时复用用户表里的backup字段，将来考虑利用现有的项目表和项目组表
    private function dbi_get_user_auth_factory($mysqli, $uid)
    {
        $pjCode = ""; //初始化
        $query_str = "SELECT * FROM `t_l3f1sym_account` WHERE `uid` = '$uid' ";
        $result = $mysqli->query($query_str);
        if(($result != false) AND ($result->num_rows>0)) {
            $row = $result->fetch_array();
            $pjCode = $row['backup'];
        }

        return $pjCode;
    }

    private function dbi_get_product_type($mysqli, $pjCode)
    {
        $typeList = array(); //初始化
        $query_str = "SELECT * FROM `t_l3f11faam_typesheet` WHERE `pjcode` = '$pjCode' ";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            array_push($typeList, $row);
        }

        return $typeList;
    }

    private function dbi_get_factory_config($mysqli, $pjCode)
    {
        $config = ""; //初始化
        $query_str = "SELECT * FROM `t_l3f11faam_factorysheet` WHERE `pjcode` = '$pjCode' ";
        $result = $mysqli->query($query_str);
        if(($result != false) AND ($result->num_rows>0)) {
            $row = $result->fetch_array();
            $config = array("workstart" => $row['workstart'],
                            "workend" => $row['workend'],
                            "reststart" => $row['reststart'],
                            "restend" => $row['restend'],
                            "fullwork" => $row['fullwork']);
        }
        return $config;
    }

    private function dbi_get_employee_config($mysqli, $pjCode,$employee)
    {
        $config = array(); //初始化
        $onJob = MFUN_HCU_FAAM_EMPLOYEE_ONJOB_YES; //在职员工
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode' AND `employee` = '$employee' AND `onjob` = '$onJob')";
        $result = $mysqli->query($query_str);
        if(($result != false) AND ($result->num_rows>0)) {
            $row = $result->fetch_array();
            $config = array("unitprice" => $row['unitprice'], "standardnum" => $row['standardnum']);
        }
        return $config;
    }

    public function dbi_faam_factory_codelist_query($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $codeList = array();
        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $query_str = "SELECT * FROM `t_l3f11faam_factorysheet` WHERE (`pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $temp = array('id' => $row['pjcode']);
            array_push($codeList, $temp);
        }
        $mysqli->close();
        return $codeList;
    }

    public function dbi_faam_factory_table_query($uid,$start, $query_length,$keyword)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //考虑到多工厂情况，将来需要根据登录用户属性选择对应工厂的员工列表显示
        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $factoryTable = array(); //初始化
        $query_str = "SELECT * FROM `t_l3f11faam_factorysheet` WHERE (`pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        //没有关键字查询
        if (empty($keyword)){
            while (($result != false) && (($row = $result->fetch_array()) > 0)) {
                $temp = array(
                    'factoryid' => $row['sid'],
                    'factorycode' => $row['pjcode'],
                    'factorydutyday'=> $row['fullwork'],
                    'factorylongitude' => $row['longitude'],
                    'factorylatitude' => $row['latitude'],
                    'factoryworkstarttime' => $row['workstart'],
                    'factoryworkendtime' => $row['workend'],
                    'factorylaunchstarttime' => $row['reststart'],
                    'factorylaunchendtime' => $row['restend'],
                    'factoryaddress' => $row['address'],
                    'factorymemo' => $row['memo']
                );
                array_push($factoryTable, $temp);
            }
        }
        //有关键字模糊查询
        else{
            $query_str = "SELECT * FROM `t_l3f11faam_factorysheet` where (`pjcode` = '$pjCode' AND concat(`pjcode`) like '%$keyword%')";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($row = $result->fetch_array()) > 0)) {
                $temp = array(
                    'factoryid' => $row['sid'],
                    'factorycode' => $row['pjcode'],
                    'factorydutyday'=> $row['fullwork'],
                    'factorylongitude' => $row['longitude'],
                    'factorylatitude' => $row['latitude'],
                    'factoryworkstarttime' => $row['workstart'],
                    'factoryworkendtime' => $row['workend'],
                    'factorylaunchstarttime' => $row['reststart'],
                    'factorylaunchendtime' => $row['restend'],
                    'factoryaddress' => $row['address'],
                    'factorymemo' => $row['memo']
                );
                array_push($factoryTable, $temp);
            }
        }

        $mysqli->close();
        return $factoryTable;
    }

    //新增工厂信息表
    public function dbi_faam_factory_table_new($factoryInfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($factoryInfo["factorycode"])) $pjCode = trim($factoryInfo["factorycode"]); else  $pjCode = "";
        if (isset($factoryInfo["factorydutyday"])) $fullWork = trim($factoryInfo["factorydutyday"]); else  $fullWork = "";
        if (isset($factoryInfo["factorylongitude"])) $longitude = trim($factoryInfo["factorylongitude"]); else  $longitude = "";
        if (isset($factoryInfo["factorylatitude"])) $latitude = trim($factoryInfo["factorylatitude"]); else  $latitude = "";
        if (isset($factoryInfo["factoryworkstarttime"])) $workStart = trim($factoryInfo["factoryworkstarttime"]); else  $workStart = "";
        if (isset($factoryInfo["factoryworkendtime"])) $workEnd = trim($factoryInfo["factoryworkendtime"]); else  $workEnd = "";
        if (isset($factoryInfo["factorylaunchstarttime"])) $restStart = trim($factoryInfo["factorylaunchstarttime"]); else  $restStart = "";
        if (isset($factoryInfo["factorylaunchendtime"])) $restEnd = trim($factoryInfo["factorylaunchendtime"]); else  $restEnd = 0;
        if (isset($factoryInfo["factoryaddress"])) $address = trim($factoryInfo["factoryaddress"]); else  $address = "";
        if (isset($factoryInfo["factorymemo"])) $memo = trim($factoryInfo["factorymemo"]); else  $memo = "";

        $query_str = "INSERT INTO `t_l3f11faam_factorysheet` (pjcode,workstart,workend,reststart,restend,fullwork,address,latitude,longitude,memo)
                              VALUES ('$pjCode','$workStart','$workEnd','$restStart','$restEnd','$fullWork','$address','$latitude','$longitude','$memo')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    //修改工厂信息表
    public function dbi_faam_factory_table_modify($factoryInfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($factoryInfo["factoryid"])) $sid = trim($factoryInfo["factoryid"]); else  $sid = "";
        if (isset($factoryInfo["factorycode"])) $pjCode = trim($factoryInfo["factorycode"]); else  $pjCode = "";
        if (isset($factoryInfo["factorydutyday"])) $fullWork = trim($factoryInfo["factorydutyday"]); else  $fullWork = "";
        if (isset($factoryInfo["factorylongitude"])) $longitude = trim($factoryInfo["factorylongitude"]); else  $longitude = "";
        if (isset($factoryInfo["factorylatitude"])) $latitude = trim($factoryInfo["factorylatitude"]); else  $latitude = "";
        if (isset($factoryInfo["factoryworkstarttime"])) $workStart = trim($factoryInfo["factoryworkstarttime"]); else  $workStart = "";
        if (isset($factoryInfo["factoryworkendtime"])) $workEnd = trim($factoryInfo["factoryworkendtime"]); else  $workEnd = "";
        if (isset($factoryInfo["factorylaunchstarttime"])) $restStart = trim($factoryInfo["factorylaunchstarttime"]); else  $restStart = "";
        if (isset($factoryInfo["factorylaunchendtime"])) $restEnd = trim($factoryInfo["factorylaunchendtime"]); else  $restEnd = 0;
        if (isset($factoryInfo["factoryaddress"])) $address = trim($factoryInfo["factoryaddress"]); else  $address = "";
        if (isset($factoryInfo["factorymemo"])) $memo = trim($factoryInfo["factorymemo"]); else  $memo = "";

        $query_str = "UPDATE `t_l3f11faam_factorysheet` SET `pjcode` = '$pjCode',`workstart` = '$workStart',`workend` = '$workEnd',`reststart` = '$restStart',
                      `restend` = '$restEnd',`fullwork` = '$fullWork',`address` = '$address',`latitude` = '$latitude',`longitude` = '$longitude',`memo` = '$memo' WHERE (`sid` = '$sid')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    //删除工厂信息
    public function dbi_faam_factory_table_delete($factoryId)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $query_str = "DELETE FROM `t_l3f11faam_factorysheet` WHERE `sid` = '$factoryId'";  //删除员工信息
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    //查询产品规格表中记录总数
    public function dbi_faam_product_type_num_inqury($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);

        $query_str = "SELECT * FROM `t_l3f11faam_typesheet` WHERE (`pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    //查询产品规格列表
    public function dbi_faam_product_type_table_query($uid,$start, $query_length,$keyword)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //考虑到多工厂情况，将来需要根据登录用户属性选择对应工厂的员工列表显示
        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $productType = array(); //初始化
        $query_str = "SELECT * FROM `t_l3f11faam_typesheet` WHERE (`pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        //没有关键字查询
        if (empty($keyword)){
            while (($result != false) && (($row = $result->fetch_array()) > 0)) {
                $temp = array(
                    'specificationid' => $row['sid'],
                    'specificationcode' => $row['typecode'],
                    'specificationlevel'=> $row['applegrade'],
                    'specificationnumber' => $row['applenum'],
                    'specificationweight' => $row['appleweight'],
                    'specificationmemo' => $row['memo']
                );
                array_push($productType, $temp);
            }
        }
        //有关键字模糊查询
        else{
            $query_str = "SELECT * FROM `t_l3f11faam_typesheet` where (`pjcode` = '$pjCode' AND concat(`typecode`) like '%$keyword%')";
            $result = $mysqli->query($query_str);
            while (($result != false) && (($row = $result->fetch_array()) > 0)) {
                $temp = array(
                    'specificationid' => $row['sid'],
                    'specificationcode' => $row['typecode'],
                    'specificationlevel'=> $row['applegrade'],
                    'specificationnumber' => $row['applenum'],
                    'specificationweight' => $row['appleweight'],
                    'specificationmemo' => $row['memo']
                );
                array_push($productType, $temp);
            }
        }

        $mysqli->close();
        return $productType;
    }

    public function dbi_faam_product_type_modify($typeInfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($typeInfo["specificationid"])) $sid = trim($typeInfo["specificationid"]); else  $sid = "";
        if (isset($typeInfo["specificationcode"])) $typeCode = trim($typeInfo["specificationcode"]); else  $typeCode = "";
        if (isset($typeInfo["specificationlevel"])) $appleGrade = trim($typeInfo["specificationlevel"]); else  $appleGrade = "";
        if (isset($typeInfo["specificationnumber"])) $appleNum = intval($typeInfo["specificationnumber"]); else  $appleNum = 0;
        if (isset($typeInfo["specificationweight"])) $appleWeight = intval($typeInfo["specificationweight"]); else  $appleWeight = 0;
        if (isset($typeInfo["specificationmemo"])) $memo = trim($typeInfo["specificationmemo"]); else  $memo = "";

        $query_str = "UPDATE `t_l3f11faam_typesheet` SET `typecode` = '$typeCode',`applenum` = '$appleNum',`appleweight` = '$appleWeight',
                        `applegrade` = '$appleGrade',`memo` = '$memo' WHERE (`sid` = '$sid')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    public function dbi_faam_product_type_new($uid, $typeInfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($typeInfo["specificationcode"])) $typeCode = trim($typeInfo["specificationcode"]); else  $typeCode = "";
        if (isset($typeInfo["specificationlevel"])) $appleGrade = trim($typeInfo["specificationlevel"]); else  $appleGrade = "";
        if (isset($typeInfo["specificationnumber"])) $appleNum = intval($typeInfo["specificationnumber"]); else  $appleNum = 0;
        if (isset($typeInfo["specificationweight"])) $appleWeight = intval($typeInfo["specificationweight"]); else  $appleWeight = 0;
        if (isset($typeInfo["specificationmemo"])) $memo = trim($typeInfo["specificationmemo"]); else  $memo = "";

        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $query_str = "INSERT INTO `t_l3f11faam_typesheet` (pjcode,typecode,applenum,appleweight,applegrade,memo)
                              VALUES ('$pjCode','$typeCode','$appleNum','$appleWeight','$appleGrade','$memo')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    public function dbi_faam_product_type_delete($typeId)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $query_str = "DELETE FROM `t_l3f11faam_typesheet` WHERE `sid` = '$typeId'";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    //查询员工记录表中记录总数
    public function dbi_faam_employeenum_inqury($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    //UI StaffnameList request
    public function dbi_faam_staff_namelist_query($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $nameList = array();
        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $temp = array('id' => $row['mid'],'name' => $row['employee']);
            array_push($nameList, $temp);
        }
        $mysqli->close();
        return $nameList;
    }

    //UI StaffTable request, 获取所有员工信息表
    public function dbi_faam_stafftable_query($uid,$start,$query_length,$keyword,$containLeave)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if ($containLeave == "true") { //包含离职员工
            //考虑到多工厂情况，将来需要根据登录用户属性选择对应工厂的员工列表显示
            $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
            $staffTable = array(); //初始化
            $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode')";
            $result = $mysqli->query($query_str);
            //没有关键字查询
            if (empty($keyword)){
                while (($result != false) && (($row = $result->fetch_array()) > 0)) {
                    $temp = array(
                        'id' => $row['mid'],
                        'name' => $row['employee'],
                        'PJcode'=> $row['pjcode'],
                        'nickname' => $row['openid'],
                        'mobile' => $row['phone'],
                        'gender' => $row['gender'],
                        'identify' => $row['idcard'],
                        'geoinfo' => $row['zone'],
                        'address' => $row['address'],
                        'bank' => $row['bank'],
                        'account' => $row['account'],
                        'photo' => MFUN_HCU_FAAM_EMPLOYEE_PHOTO_WWW_DIR.$row['photo'],
                        'salary' => $row['unitprice'],
                        'position' => $row['position'],
                        'status' => (string)$row['onjob'],
                        'KPI' => $row['standardnum'],
                        'memo' => $row['memo']
                    );
                    array_push($staffTable, $temp);
                }
            }
            //有关键字模糊查询
            else{
                $query_str = "SELECT * FROM `t_l3f11faam_membersheet` where (`pjcode` = '$pjCode' AND concat(`employee`,`phone`) like '%$keyword%')";
                $result = $mysqli->query($query_str);
                while (($result != false) && (($row = $result->fetch_array()) > 0)) {
                    $temp = array(
                        'id' => $row['mid'],
                        'name' => $row['employee'],
                        'PJcode'=> $row['pjcode'],
                        'nickname' => $row['openid'],
                        'mobile' => $row['phone'],
                        'gender' => $row['gender'],
                        'identify' => $row['idcard'],
                        'geoinfo' => $row['zone'],
                        'address' => $row['address'],
                        'bank' => $row['bank'],
                        'account' => $row['account'],
                        'photo' => MFUN_HCU_FAAM_EMPLOYEE_PHOTO_WWW_DIR.$row['photo'],
                        'salary' => $row['unitprice'],
                        'position' => $row['position'],
                        'status' => (string)$row['onjob'],
                        'KPI' => $row['standardnum'],
                        'memo' => $row['memo']
                    );
                    array_push($staffTable, $temp);
                }
            }
        }
        else{ //只包含在职员工
            $onJob = MFUN_HCU_FAAM_EMPLOYEE_ONJOB_YES; //在职员工
            //考虑到多工厂情况，将来需要根据登录用户属性选择对应工厂的员工列表显示
            $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
            $staffTable = array(); //初始化
            $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode' AND `onjob` = '$onJob')";
            $result = $mysqli->query($query_str);
            //没有关键字查询
            if (empty($keyword)){
                while (($result != false) && (($row = $result->fetch_array()) > 0)) {
                    $temp = array(
                        'id' => $row['mid'],
                        'name' => $row['employee'],
                        'PJcode'=> $row['pjcode'],
                        'nickname' => $row['openid'],
                        'mobile' => $row['phone'],
                        'gender' => $row['gender'],
                        'identify' => $row['idcard'],
                        'geoinfo' => $row['zone'],
                        'address' => $row['address'],
                        'bank' => $row['bank'],
                        'account' => $row['account'],
                        'photo' => MFUN_HCU_FAAM_EMPLOYEE_PHOTO_WWW_DIR.$row['photo'],
                        'salary' => $row['unitprice'],
                        'position' => $row['position'],
                        'status' => (string)$row['onjob'],
                        'KPI' => $row['standardnum'],
                        'memo' => $row['memo']
                    );
                    array_push($staffTable, $temp);
                }
            }
            //有关键字模糊查询
            else{
                $query_str = "SELECT * FROM `t_l3f11faam_membersheet` where (`pjcode` = '$pjCode' AND `onjob` = '$onJob' AND concat(`employee`,`phone`) like '%$keyword%')";
                $result = $mysqli->query($query_str);
                while (($result != false) && (($row = $result->fetch_array()) > 0)) {
                    $temp = array(
                        'id' => $row['mid'],
                        'name' => $row['employee'],
                        'PJcode'=> $row['pjcode'],
                        'nickname' => $row['openid'],
                        'mobile' => $row['phone'],
                        'gender' => $row['gender'],
                        'identify' => $row['idcard'],
                        'geoinfo' => $row['zone'],
                        'address' => $row['address'],
                        'bank' => $row['bank'],
                        'account' => $row['account'],
                        'photo' => MFUN_HCU_FAAM_EMPLOYEE_PHOTO_WWW_DIR.$row['photo'],
                        'salary' => $row['unitprice'],
                        'position' => $row['position'],
                        'status' => (string)$row['onjob'],
                        'KPI' => $row['standardnum'],
                        'memo' => $row['memo']
                    );
                    array_push($staffTable, $temp);
                }
            }
        }

        $mysqli->close();
        return $staffTable;
    }

    // UI StaffMod request, 修改员工信息表
    public function dbi_faam_staff_table_modify($staffInfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($staffInfo["staffid"])) $staffId = trim($staffInfo["staffid"]); else  $staffId = "";
        if (isset($staffInfo["name"])) $employee = trim($staffInfo["name"]); else  $employee = "";
        if (isset($staffInfo["nickname"])) $nickName = trim($staffInfo["nickname"]); else  $nickName = "";
        if (isset($staffInfo["PJcode"])) $pjCode = trim($staffInfo["PJcode"]); else  $pjCode = "";
        if (isset($staffInfo["position"])) $position = trim($staffInfo["position"]); else  $position = "";
        if (isset($staffInfo["gender"])) $gender = trim($staffInfo["gender"]); else  $gender = "";
        if (isset($staffInfo["mobile"])) $phone = trim($staffInfo["mobile"]); else  $phone = "";
        if (isset($staffInfo["geoinfo"])) $zone = trim($staffInfo["geoinfo"]); else  $zone = "";
        if (isset($staffInfo["identify"])) $idCard = trim($staffInfo["identify"]); else  $idCard = "";
        if (isset($staffInfo["address"])) $address = trim($staffInfo["address"]); else  $address = "";
        if (isset($staffInfo["bank"])) $bank = trim($staffInfo["bank"]); else  $bank = "";
        if (isset($staffInfo["account"])) $account = trim($staffInfo["account"]); else  $account = "";
        if (isset($staffInfo["photo"])) $photo = trim($staffInfo["photo"]); else  $photo = "";
        if (isset($staffInfo["salary"])) $unitPrice = intval($staffInfo["salary"]); else  $unitPrice = 0;
        if (isset($staffInfo["status"])) $onjob = intval($staffInfo["status"]); else  $onjob = 0;
        if (isset($staffInfo["KPI"])) $standardNum = intval($staffInfo["KPI"]); else  $standardNum = 0;
        if (isset($staffInfo["memo"])) $memo = trim($staffInfo["memo"]); else  $memo = "";

        $date = date("Y-m-d", time());

        $file_link = MFUN_HCU_FAAM_EMPLOYEE_PHOTO_UPLOAD_DIR.$photo;
        if(file_exists($file_link)){
            $filename_new = $staffId.".jpg";
            $filelink_new = MFUN_HCU_FAAM_EMPLOYEE_PHOTO_UPLOAD_DIR.$filename_new;
            chmod($file_link, 0777);
            if(file_exists($filelink_new))
                unlink($filelink_new);          //先删除老的以员工ID命名的照片文件
            rename($file_link, $filelink_new);  //再将新上传的照片文件名修改为对应员工ID.jpg
            $query_str = "UPDATE `t_l3f11faam_membersheet` SET `pjcode` = '$pjCode',`employee` = '$employee',`openid` = '$nickName',`gender` = '$gender',`phone` = '$phone',`regdate` = '$date',`position` = '$position',`idcard` = '$idCard',
                      `zone` = '$zone',`address` = '$address',`bank` = '$bank',`account` = '$account',`photo` = '$filename_new',`unitprice` = '$unitPrice',`standardnum` = '$standardNum',`onjob` = '$onjob',`memo` = '$memo' WHERE (`mid` = '$staffId')";
            $result = $mysqli->query($query_str);
        }
        else{ //照片为空则不更新照片
            $query_str = "UPDATE `t_l3f11faam_membersheet` SET `pjcode` = '$pjCode',`employee` = '$employee',`openid` = '$nickName',`gender` = '$gender',`phone` = '$phone',`regdate` = '$date',`position` = '$position',`idcard` = '$idCard',
                      `zone` = '$zone',`address` = '$address',`bank` = '$bank',`account` = '$account',`unitprice` = '$unitPrice',`standardnum` = '$standardNum',`onjob` = '$onjob',`memo` = '$memo' WHERE (`mid` = '$staffId')";
            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    // UI StaffNew request, 新建员工信息表
    public function dbi_faam_staff_table_new($staffInfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($staffInfo["name"])) $employee = trim($staffInfo["name"]); else  $employee = "";
        if (isset($staffInfo["PJcode"])) $pjCode = trim($staffInfo["PJcode"]); else  $pjCode = "";
        if (isset($staffInfo["position"])) $position = trim($staffInfo["position"]); else  $position = "";
        if (isset($staffInfo["gender"])) $gender = trim($staffInfo["gender"]); else  $gender = "";
        if (isset($staffInfo["mobile"])) $phone = trim($staffInfo["mobile"]); else  $phone = "";
        if (isset($staffInfo["geoinfo"])) $zone = trim($staffInfo["geoinfo"]); else  $zone = "";
        if (isset($staffInfo["identify"])) $idCard = trim($staffInfo["identify"]); else  $idCard = "";
        if (isset($staffInfo["address"])) $address = trim($staffInfo["address"]); else  $address = "";
        if (isset($staffInfo["bank"])) $bank = trim($staffInfo["bank"]); else  $bank = "";
        if (isset($staffInfo["account"])) $account = trim($staffInfo["account"]); else  $account = "";
        if (isset($staffInfo["photo"])) $photo = trim($staffInfo["photo"]); else  $photo = "";
        if (isset($staffInfo["salary"])) $unitPrice = intval($staffInfo["salary"]); else  $unitPrice = 0;
        if (isset($staffInfo["KPI"])) $standardNum = intval($staffInfo["KPI"]); else  $standardNum = 0;
        if (isset($staffInfo["memo"])) $memo = trim($staffInfo["memo"]); else  $memo = "";

        $date = date("Y-m-d", time());
        $mid = MFUN_L3APL_F1SYM_MID_PREFIX.$this->getRandomUid(MFUN_L3APL_F1SYM_USER_ID_LEN);  //随机生成员工ID

        $file_link = MFUN_HCU_FAAM_EMPLOYEE_PHOTO_UPLOAD_DIR.$photo;
        if(file_exists($file_link)) {
            $filename_new = $mid . ".jpg";
            $filelink_new = MFUN_HCU_FAAM_EMPLOYEE_PHOTO_UPLOAD_DIR . $filename_new;
            chmod($file_link, 0777);
            if(file_exists($filelink_new))
                unlink($filelink_new);          //先删除老的以员工ID命名的照片文件
            rename($file_link, $filelink_new);  //再将新上传的照片文件名修改为对应员工ID.jpg
            $query_str = "INSERT INTO `t_l3f11faam_membersheet` (mid,pjcode,employee,gender,phone,regdate,position,zone,idcard,address,bank,account,photo,unitprice,standardnum,memo)
                              VALUES ('$mid','$pjCode','$employee','$gender','$phone','$date','$position','$zone','$idCard','$address','$bank','$account','$filename_new','$unitPrice','$standardNum','$memo')";
            $result = $mysqli->query($query_str);
        }
        else{
            $query_str = "INSERT INTO `t_l3f11faam_membersheet` (mid,pjcode,employee,gender,phone,regdate,position,zone,idcard,address,bank,account,unitprice,standardnum,memo)
                              VALUES ('$mid','$pjCode','$employee','$gender','$phone','$date','$position','$zone','$idCard','$address','$bank','$account','$unitPrice','$standardNum','$memo')";
            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    //UI StaffDel request, 员工信息删除
    public function dbi_faam_staff_table_delete($staffId)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //应客户要求，用户离职不能删除，改成离职状态
        //$query_str = "DELETE FROM `t_l3f11faam_membersheet` WHERE `mid` = '$staffId'";  //删除员工信息
        $onJob = MFUN_HCU_FAAM_EMPLOYEE_ONJOB_NO;
        $query_str = "UPDATE `t_l3f11faam_membersheet` SET `onjob` = '$onJob' WHERE `mid` = '$staffId'";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    //UI AttendanceHistory request, 考勤记录表查询
    public function dbi_faam_attendance_history_query($uid, $timeStart, $timeEnd, $keyWord)
    {
        //初始化返回值
        $history["ColumnName"] = array();
        $history['TableData'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        array_push($history["ColumnName"], "序号");
        array_push($history["ColumnName"], "姓名");
        array_push($history["ColumnName"], "岗位");
        array_push($history["ColumnName"], "区域");
        array_push($history["ColumnName"], "日期");
        array_push($history["ColumnName"], "上班时间");
        array_push($history["ColumnName"], "下班时间");
        array_push($history["ColumnName"], "请假时长");
        array_push($history["ColumnName"], "工时(小时)");

        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode` = '$pjCode' AND `workday`>='$timeStart' AND `workday`<='$timeEnd' AND (concat(`employee`) like '%$keyWord%'))";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $sid = $row['sid'];
            $employee = $row['employee'];
            $workDay = $row['workday'];
            $arriveTime = $row['arrivetime'];
            $leaveTime = $row['leavetime'];
            $offWork = $row['offwork'];
            $workTime = $row['worktime'];

            $position = "";
            $zone = "";
            $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode' AND `employee` = '$employee')";
            $employee_sheet = $mysqli->query($query_str);
            if (($employee_sheet != false) && (($employee_row = $employee_sheet->fetch_array()) > 0)){
                $position = $employee_row['position'];
                $zone = $employee_row['zone'];
            }

            $temp = array();
            array_push($temp, $sid);
            array_push($temp, $employee);
            array_push($temp, $position);
            array_push($temp, $zone);
            array_push($temp, $workDay);
            array_push($temp, $arriveTime);
            array_push($temp, $leaveTime);
            array_push($temp, $offWork);
            array_push($temp, $workTime);
            array_push($history['TableData'], $temp);
        }

        $mysqli->close();
        return $history;
    }

    //考勤统计
    public function dbi_faam_attendance_history_audit($uid, $timeStart, $timeEnd, $keyWord)
    {
        //初始化返回值
        $history["ColumnName"] = array();
        $history['TableData'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        array_push($history["ColumnName"], "序号");
        array_push($history["ColumnName"], "姓名");
        array_push($history["ColumnName"], "岗位");
        array_push($history["ColumnName"], "区域");
        array_push($history["ColumnName"], "开始日期");
        array_push($history["ColumnName"], "结束日期");
        array_push($history["ColumnName"], "迟到次数");
        array_push($history["ColumnName"], "早退次数");
        array_push($history["ColumnName"], "请假次数");
        array_push($history["ColumnName"], "请假时长");
        array_push($history["ColumnName"], "工作天数");
        array_push($history["ColumnName"], "工作时长");

        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);

        $buffer = array();
        if(!empty($keyWord)) { //关键字不空，查找指定员工
            $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode`='$pjCode' AND `workday`>='$timeStart' AND `workday`<='$timeEnd' AND `employee`='$keyWord')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {  //输入的关键字为用户名
                while (($row = $result->fetch_array()) > 0)
                    array_push($buffer, $row);
            }
        }
        else{ //关键字为空，查找全部员工
            $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode`='$pjCode' AND `workday`>='$timeStart' AND `workday`<='$timeEnd')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {
                while (($row = $result->fetch_array()) > 0)
                    array_push($buffer, $row);
            }
        }
        if(empty($buffer)) {  //如果查询结果为空，这直接返回
            $mysqli->close();
            return $history;
        }
        //查询员工列表
        //$onJob = MFUN_HCU_FAAM_EMPLOYEE_ONJOB_YES; //在职员工
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        $nameList = array();
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $temp = array('employee' => $row['employee'],'position' => $row['position'],'zone' => $row['zone']);
            array_push($nameList, $temp);
        }

        //处理查询结果
        for($i=0; $i<count($buffer); $i++){
            $employee = $buffer[$i]['employee'];
            $lateWorkFlag = $buffer[$i]['lateworkflag'];
            $earlyLeaveFlag = $buffer[$i]['earlyleaveflag'];
            $offWorkTime = $buffer[$i]['offwork'];
            $workTime = $buffer[$i]['worktime'];

            if(isset($workingDay[$employee]) AND isset($lateWorkDay[$employee]) AND isset($earlyLeaveDay[$employee]) AND
                isset($totalWorkTime[$employee]) AND isset($offWorkDay[$employee]) AND isset($totalOffWorkTime[$employee])){
                if($lateWorkFlag) $lateWorkDay[$employee]++;
                if($earlyLeaveFlag) $earlyLeaveDay[$employee]++;
                if($workTime != 0) {
                    $workingDay[$employee]++;
                    $totalWorkTime[$employee] = $totalWorkTime[$employee] + $workTime;
                }
                if($offWorkTime != 0){
                    $offWorkDay[$employee]++;
                    $totalOffWorkTime[$employee] = $totalOffWorkTime[$employee] + $offWorkTime;
                }
            }
            else{ //第一次查询到某员工
                if($lateWorkFlag) $lateWorkDay[$employee] = 1;else $lateWorkDay[$employee] = 0;
                if($earlyLeaveFlag) $earlyLeaveDay[$employee] = 1; else $earlyLeaveDay[$employee] = 0;
                if($workTime != 0) {
                    $workingDay[$employee] = 1;
                    $totalWorkTime[$employee] = $workTime;
                }
                else{
                    $workingDay[$employee] = 0;
                    $totalWorkTime[$employee] = 0;
                }

                if($offWorkTime != 0){
                    $offWorkDay[$employee] = 1;
                    $totalOffWorkTime[$employee] = $offWorkTime;
                }
                else{
                    $offWorkDay[$employee] = 0;
                    $totalOffWorkTime[$employee] = 0;
                }
            }
        }
        //显示查询结果
        $sid = 0;
        for($i=0; $i<count($nameList); $i++){
            $employee = $nameList[$i]['employee'];
            $position = $nameList[$i]['position'];
            $zone = $nameList[$i]['zone'];

            if(isset($workingDay[$employee]) AND isset($lateWorkDay[$employee]) AND isset($earlyLeaveDay[$employee]) AND
                isset($totalWorkTime[$employee]) AND isset($offWorkDay[$employee]) AND isset($totalOffWorkTime[$employee])){
                $sid++;
                $temp = array();
                array_push($temp, $sid++);
                array_push($temp, $employee);
                array_push($temp, $position);
                array_push($temp, $zone);
                array_push($temp, $timeStart);
                array_push($temp, $timeEnd);
                array_push($temp, $lateWorkDay[$employee]);
                array_push($temp, $earlyLeaveDay[$employee]);
                array_push($temp, $offWorkDay[$employee]);
                array_push($temp, $totalOffWorkTime[$employee]);
                array_push($temp, $workingDay[$employee]);
                array_push($temp, $totalWorkTime[$employee]);
                array_push($history['TableData'], $temp);
            }
        }

        $mysqli->close();
        return $history;
    }

    //UI AttendanceNew request,手动添加一条考勤记录
    public function dbi_faam_attendance_record_new($uid, $record)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($record["name"])) $employee = trim($record["name"]); else  $employee = "";
        //if (isset($record["PJcode"])) $pjCode = trim($record["PJcode"]); else  $pjCode = "";
        if (isset($record["leavehour"])) $offWorkTime = $record["leavehour"]; else  $offWorkTime = 0;
        if (isset($record["date"])) $workDay = trim($record["date"]); else  $workDay = "";
        if (isset($record["arrivetime"])) $arriveTime = trim($record["arrivetime"]); else  $arriveTime = "";
        if (isset($record["leavetime"])) $leaveTime = trim($record["leavetime"]); else  $leaveTime = "";

        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $employee_config = $this->dbi_get_employee_config($mysqli, $pjCode, $employee);
        if (isset($employee_config['unitprice'])) $unitPrice = $employee_config['unitprice']; else  $unitPrice = 0;

        $factory_config = $this->dbi_get_factory_config($mysqli, $pjCode);
        $restStart = strtotime($factory_config['reststart']);
        $restEnd = strtotime($factory_config['restend']);
        $stdWorkStart = strtotime($factory_config['workstart']);
        $stdWorkEnd = strtotime($factory_config['workend']);

        $arriveTimeInt = strtotime($arriveTime);
        $leaveTimeInt = strtotime($leaveTime);

        if($arriveTimeInt <= $restStart AND $leaveTimeInt >= $restEnd){ //正常情况，在午休前上班，午休后下班
            $timeInterval = ($restStart - $arriveTimeInt) + ($leaveTimeInt - $restEnd);
        }
        elseif($arriveTimeInt >= $restStart AND $arriveTimeInt <= $restEnd){ //在午休中间上班
            $timeInterval = ($leaveTimeInt - $restEnd);
        }
        elseif($leaveTimeInt >= $restStart AND $leaveTimeInt <= $restEnd){ //在午休中间下班
            $timeInterval = ($restStart - $arriveTimeInt);
        }
        elseif($arriveTimeInt >= $restEnd){ //在午休后上班
            $timeInterval = ($leaveTimeInt - $arriveTimeInt);
        }
        elseif($leaveTimeInt <= $restStart){ //在午休前下班
            $timeInterval = ($leaveTimeInt - $arriveTimeInt);
        }
        else{
            $timeInterval = 0;
        }

        $hour = (int)(($timeInterval%(3600*24))/(3600));
        $min = (int)($timeInterval%(3600)/60);
        $workTime = $hour + round($min/60, 1)  - $offWorkTime; //扣除请假时间
        if ($workTime < 0) $workTime = 0; //避免工作时间为负数

        if($arriveTimeInt < $stdWorkStart) $lateWorkFlag = 0; else $lateWorkFlag = 1;  //迟到标志
        if($leaveTimeInt > $stdWorkEnd) $earlyLeaveFlag = 0; else $earlyLeaveFlag = 1; //早退标志

        $onJob = MFUN_HCU_FAAM_EMPLOYEE_ONJOB_YES; //在职员工
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`employee` = '$employee' AND `onjob` = '$onJob' AND `pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        if(($result != false) && ($result->num_rows)>0){ //输入员工姓名合法
            $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode` = '$pjCode' AND `employee` = '$employee' AND `workday` = '$workDay')";
            $result = $mysqli->query($query_str);
            if(($result != false) && ($result->num_rows)>0){  //如果该员工当天已经有考勤记录则更新，否则插入新纪录
                $query_str = "UPDATE `t_l3f11faam_dailysheet` SET `arrivetime` = '$arriveTime',`leavetime` = '$leaveTime',`offwork` = '$offWorkTime',`worktime` = '$workTime',
                          `unitprice` = '$unitPrice',`lateworkflag` = '$lateWorkFlag',`earlyleaveflag` = '$earlyLeaveFlag' WHERE (`pjcode` = '$pjCode' AND `employee` = '$employee' AND `workday` = '$workDay')";
                $result = $mysqli->query($query_str);
            }
            else{
                $query_str = "INSERT INTO `t_l3f11faam_dailysheet` (pjcode,employee,workday,arrivetime,leavetime,offwork,worktime,unitprice,lateworkflag,earlyleaveflag)
                                  VALUES ('$pjCode','$employee','$workDay','$arriveTime','$leaveTime','$offWorkTime','$workTime','$unitPrice','$lateWorkFlag','$earlyLeaveFlag')";
                $result = $mysqli->query($query_str);
            }
        }
        else
            $result = false;

        $mysqli->close();
        return $result;
    }

    //UI AttendanceBatchNew
    public function dbi_faam_attendance_record_batch_add($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);

        $factory_config = $this->dbi_get_factory_config($mysqli, $pjCode);
        $restStart = strtotime($factory_config['reststart']);
        $restEnd = strtotime($factory_config['restend']);
        $workStart = $factory_config['workstart'];
        $workEnd = $factory_config['workend'];
        $stdWorkStart = strtotime($workStart);
        $stdWorkEnd = strtotime($workEnd);
        $timeInterval = ($restStart - $stdWorkStart) + ($stdWorkEnd - $restEnd);
        $hour = (int)(($timeInterval%(3600*24))/(3600));
        $min = (int)($timeInterval%(3600)/60);
        $workTime = $hour + round($min/60, 1);
        $workDay = date('Y-m-d', time());
        $offWorkTime = 0;
        $lateWorkFlag = 0;
        $earlyLeaveFlag = 0;

        //查询员工列表
        $onJob = MFUN_HCU_FAAM_EMPLOYEE_ONJOB_YES; //只查询在职员工
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode' AND `onjob` = '$onJob')";
        $result = $mysqli->query($query_str);
        $nameList = array();
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $temp = array('employee' => $row['employee'],'unitprice'=>$row['unitprice']);
            array_push($nameList, $temp);
        }
        for ($i = 0; $i < count($nameList); $i++){
            $employee = $nameList[$i]['employee'];
            $unitPrice = $nameList[$i]['unitprice'];
            $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode` = '$pjCode' AND `employee` = '$employee' AND `workday` = '$workDay')";
            $result = $mysqli->query($query_str);
            if($result->num_rows == 0){
                $query_str = "INSERT INTO `t_l3f11faam_dailysheet` (pjcode,employee,workday,arrivetime,leavetime,offwork,worktime,unitprice,lateworkflag,earlyleaveflag)
                                  VALUES ('$pjCode','$employee','$workDay','$workStart','$workEnd','$offWorkTime','$workTime','$unitPrice','$lateWorkFlag','$earlyLeaveFlag')";
                $result = $mysqli->query($query_str);
            }
        }
        $mysqli->close();
        return $result;
    }

    //UI AttendanceMod request
    public function dbi_faam_attendance_record_modify($uid, $record)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($record["attendanceID"])) $sid = intval($record["attendanceID"]); else  $sid = 0;
        if (isset($record["name"])) $employee = trim($record["name"]); else  $employee = "";
        //if (isset($record["PJcode"])) $pjCode = trim($record["PJcode"]); else  $pjCode = "";
        if (isset($record["leavehour"])) $offWorkTime = $record["leavehour"]; else  $offWorkTime = 0;
        if (isset($record["date"])) $workDay = trim($record["date"]); else  $workDay = "";
        if (isset($record["arrivetime"])) $arriveTime = trim($record["arrivetime"]); else  $arriveTime = "";
        if (isset($record["leavetime"])) $leaveTime = trim($record["leavetime"]); else  $leaveTime = "";

        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $employee_config = $this->dbi_get_employee_config($mysqli, $pjCode, $employee);
        if (isset($employee_config['unitprice'])) $unitPrice = $employee_config['unitprice']; else  $unitPrice = 0;

        $factory_config = $this->dbi_get_factory_config($mysqli, $pjCode);
        $restStart = strtotime($factory_config['reststart']);
        $restEnd = strtotime($factory_config['restend']);
        $stdWorkStart = strtotime($factory_config['workstart']);
        $stdWorkEnd = strtotime($factory_config['workend']);

        $arriveTimeInt = strtotime($arriveTime);
        $leaveTimeInt = strtotime($leaveTime);

        if($arriveTimeInt <= $restStart AND $leaveTimeInt >= $restEnd){ //正常情况，在午休前上班，午休后下班
            $timeInterval = ($restStart - $arriveTimeInt) + ($leaveTimeInt - $restEnd);
        }
        elseif($arriveTimeInt >= $restStart AND $arriveTimeInt <= $restEnd){ //在午休中间上班
            $timeInterval = ($leaveTimeInt - $restEnd);
        }
        elseif($leaveTimeInt >= $restStart AND $leaveTimeInt <= $restEnd){ //在午休中间下班
            $timeInterval = ($restStart - $arriveTimeInt);
        }
        elseif($arriveTimeInt >= $restEnd){ //在午休后上班
            $timeInterval = ($leaveTimeInt - $arriveTimeInt);
        }
        elseif($leaveTimeInt <= $restStart){ //在午休前下班
            $timeInterval = ($leaveTimeInt - $arriveTimeInt);
        }
        else{
            $timeInterval = 0;
        }

        $hour = (int)(($timeInterval%(3600*24))/(3600));
        $min = (int)($timeInterval%(3600)/60);
        $workTime = $hour + round($min/60, 1) - $offWorkTime; //扣除请假时间
        if ($workTime < 0) $workTime = 0; //避免工作时间为负数

        if($arriveTimeInt < $stdWorkStart) $lateWorkFlag = 0; else $lateWorkFlag = 1;  //迟到标志
        if($leaveTimeInt > $stdWorkEnd) $earlyLeaveFlag = 0; else $earlyLeaveFlag = 1; //早退标志

        $onJob = MFUN_HCU_FAAM_EMPLOYEE_ONJOB_YES; //在职员工
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`employee` = '$employee' AND `onjob` = '$onJob' AND `pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        if(($result != false) && ($result->num_rows)>0){ //输入员工姓名合法
            $query_str = "UPDATE `t_l3f11faam_dailysheet` SET `workday` = '$workDay',`arrivetime` = '$arriveTime',`leavetime` = '$leaveTime',`offwork` = '$offWorkTime',`worktime` = '$workTime',
                          `unitprice` = '$unitPrice',`lateworkflag` = '$lateWorkFlag',`earlyleaveflag` = '$earlyLeaveFlag' WHERE (`sid` = '$sid')";
            $result = $mysqli->query($query_str);
        }
        else
            $result = false;

        $mysqli->close();
        return $result;
    }

    //UI AttendanceDel request, 删除一条考勤记录
    public function dbi_faam_attendance_record_delete($recordId)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $query_str = "DELETE FROM `t_l3f11faam_dailysheet` WHERE `sid` = '$recordId'";  //删除一条考勤信息
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    //UI GetAttendance request
    public function dbi_faam_attendance_record_get($recordId)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $record = array();
        $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`sid` = '$recordId')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0){
            $row = $result->fetch_array();
            $record = array("attendanceID" => $row['sid'],
                            "PJcode" => $row['pjcode'],
                            "name" => $row['employee'],
                            "arrivetime" => $row['arrivetime'],
                            "leavetime" => $row['leavetime'],
                            "leavehour" => $row['offwork'],
                            "date" => $row['workday']);
        }
        $mysqli->close();
        return $record;
    }

    //UI AssembleHistory request
    public function dbi_faam_production_history_query($uid, $timeStart, $timeEnd, $keyWord)
    {
        //初始化返回值
        $history["ColumnName"] = array();
        $history['TableData'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        array_push($history["ColumnName"], "序号");
        array_push($history["ColumnName"], "二维码");
        array_push($history["ColumnName"], "工人姓名");
        array_push($history["ColumnName"], "产品规格");
        array_push($history["ColumnName"], "申请时间");
        array_push($history["ColumnName"], "成品时间");

        $dayTimeStart = $timeStart." 00:00:00";
        $dayTimeEnd = $timeEnd." 23:59:59";
        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $query_str = "SELECT * FROM `t_l3f11faam_appleproduction` WHERE (`pjcode` = '$pjCode' AND `applytime`>='$dayTimeStart' AND `applytime`<='$dayTimeEnd' AND (concat(`owner`,`typecode`) like '%$keyWord%'))";
        $result = $mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $sid = $row['sid'];
            $employee = $row['owner'];
            $qrcode = $row['qrcode'];
            $appleGrade = $row['typecode'];
            $applyTime = $row['applytime'];
            $activeTime = $row['activetime'];

            $temp = array();
            array_push($temp, $sid);
            array_push($temp, $qrcode);
            array_push($temp, $employee);
            array_push($temp, $appleGrade);
            array_push($temp, $applyTime);
            array_push($temp, $activeTime);
            array_push($history['TableData'], $temp);
        }

        $mysqli->close();
        return $history;
    }

    //UI AssembleAudit request 生产统计
    public function dbi_faam_production_history_audit($uid, $timeStart, $timeEnd, $keyWord)
    {
        //初始化返回值
        $history["ColumnName"] = array();
        $history['TableData'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        array_push($history["ColumnName"], "序号");
        array_push($history["ColumnName"], "员工姓名");
        array_push($history["ColumnName"], "岗位");
        array_push($history["ColumnName"], "区域");
        array_push($history["ColumnName"], "开始日期");
        array_push($history["ColumnName"], "结束日期");
        array_push($history["ColumnName"], "产品规格");
        array_push($history["ColumnName"], "总箱数");
        array_push($history["ColumnName"], "总粒数");
        array_push($history["ColumnName"], "总重量");

        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $dayTimeStart = $timeStart." 00:00:00";
        $dayTimeEnd = $timeEnd." 23:59:59";

        $buffer = array();
        if(!empty($keyWord)) {
            $query_str = "SELECT * FROM `t_l3f11faam_appleproduction` WHERE (`pjcode` = '$pjCode' AND `activetime`>='$dayTimeStart' AND `activetime`<='$dayTimeEnd' AND `owner` = '$keyWord')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {  //输入的关键字为用户名
                while (($row = $result->fetch_array()) > 0)
                    array_push($buffer, $row);
            }
            else {  //使用用户名查询结果为0，尝试用产品类型查询
                $query_str = "SELECT * FROM `t_l3f11faam_appleproduction` WHERE (`pjcode` = '$pjCode' AND `activetime`>='$dayTimeStart' AND `activetime`<='$dayTimeEnd' AND (concat(`typecode`) like '%$keyWord%'))";
                $result = $mysqli->query($query_str);
                if (($result != false) && ($result->num_rows) > 0) {  //输入的关键字为产品类型
                    while (($row = $result->fetch_array()) > 0)
                        array_push($buffer, $row);
                }
            }
        }
        else{ //关键字为空
            $query_str = "SELECT * FROM `t_l3f11faam_appleproduction` WHERE (`pjcode` = '$pjCode' AND `activetime`>='$dayTimeStart' AND `activetime`<='$dayTimeEnd')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {
                while (($row = $result->fetch_array()) > 0)
                    array_push($buffer, $row);
            }
        }

        if(empty($buffer)) {  //如果查询结果为空，这直接返回
            $mysqli->close();
            return $history;
        }

        //查询员工列表
        //$onJob = MFUN_HCU_FAAM_EMPLOYEE_ONJOB_YES;
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        $nameList = array();
        while (($result != false) && (($row = $result->fetch_array()) > 0)){
            $temp = array('employee' => $row['employee'],'position'=>$row['position'],'zone'=>$row['zone']);
            array_push($nameList, $temp);
        }
        //查询产品规格列表
        $typeList = $this->dbi_get_product_type($mysqli, $pjCode);

        //处理查询结果
        for($i=0; $i<count($buffer); $i++){
            $employee = $buffer[$i]['owner'];
            $typeCode = $buffer[$i]['typecode'];
            if(isset($package[$employee][$typeCode]))
                $package[$employee][$typeCode]++;
            else
                $package[$employee][$typeCode] = 1;
        }

        //显示查询结果
        $sid = 0;
        $packageSum = 0;
        $numSum = 0;
        $weightSum = 0;
        for($i=0; $i<count($nameList); $i++){
            $employee = $nameList[$i]['employee'];
            $position = $nameList[$i]['position'];
            $zone = $nameList[$i]['zone'];
            for($j=0; $j<count($typeList); $j++){
                $typeCode = $typeList[$j]['typecode'];
                $appleNum = $typeList[$j]['applenum'];
                $appleWeight = $typeList[$j]['appleweight'];
                if(isset($package[$employee][$typeCode])){
                    $sid++;
                    $totalPackage = (int)$package[$employee][$typeCode];
                    $totalNum = $totalPackage * (int)$appleNum;
                    $totalWeight = $totalPackage * (int)$appleWeight;
                    $temp =array();
                    array_push($temp, $sid);
                    array_push($temp, $employee);
                    array_push($temp, $position);
                    array_push($temp, $zone);
                    array_push($temp, $timeStart);
                    array_push($temp, $timeEnd);
                    array_push($temp, $typeCode);
                    array_push($temp, $totalPackage);
                    array_push($temp, $totalNum);
                    array_push($temp, $totalWeight);
                    array_push($history['TableData'], $temp);

                    $packageSum = $packageSum + $totalPackage;
                    $numSum = $numSum + $totalNum;
                    $weightSum = $weightSum + $totalWeight;
                }
            }
        }
        if ($packageSum != 0){ //所有统计汇总
            $temp =array();
            array_push($temp, 0);  //显示在第一行
            array_push($temp, "汇总");
            array_push($temp, "-------");
            array_push($temp, "-------");
            array_push($temp, $timeStart);
            array_push($temp, $timeEnd);
            array_push($temp, "-------");
            array_push($temp, $packageSum);
            array_push($temp, $numSum);
            array_push($temp, $weightSum);
            array_push($history['TableData'], $temp);
        }

        $mysqli->close();
        return $history;
    }

    //绩效统计
    public function dbi_faam_employee_kpi_audit($uid, $timeStart, $timeEnd, $keyWord)
    {
        //初始化返回值
        $history["ColumnName"] = array();
        $history['TableData'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        array_push($history["ColumnName"], "序号");
        array_push($history["ColumnName"], "员工姓名");
        array_push($history["ColumnName"], "岗位");
        array_push($history["ColumnName"], "区域");
        array_push($history["ColumnName"], "开始日期");
        array_push($history["ColumnName"], "结束日期");
        array_push($history["ColumnName"], "工作天数");
        array_push($history["ColumnName"], "工作时间");
        array_push($history["ColumnName"], "单位时薪");
        array_push($history["ColumnName"], "总时薪");
        array_push($history["ColumnName"], "总箱数");
        array_push($history["ColumnName"], "总重量");
        array_push($history["ColumnName"], "总粒数");
        array_push($history["ColumnName"], "标准绩效");
        array_push($history["ColumnName"], "完成比例");


        $pjCode = $this->dbi_get_user_auth_factory($mysqli, $uid);
        $dayTimeStart = $timeStart." 00:00:00";  //默认从查询起始天零点开始
        $dayTimeEnd = $timeEnd." 23:59:59";      //到查询结束天24时结束
        //$interval = date_diff(date_create($timeStart), date_create($timeEnd));
        //$intervalDay = $interval->days + 1;  //总查询天数

        $workBuf = array();
        if(!empty($keyWord)) { //关键字不空，查找指定员工
            $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode`='$pjCode' AND `workday`>='$timeStart' AND `workday`<='$timeEnd' AND `employee`='$keyWord')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {  //输入的关键字为用户名
                while (($row = $result->fetch_array()) > 0)
                    array_push($workBuf, $row);
            }
        }
        else{ //关键字为空，查找全部员工
            $query_str = "SELECT * FROM `t_l3f11faam_dailysheet` WHERE (`pjcode`='$pjCode' AND `workday`>='$timeStart' AND `workday`<='$timeEnd')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {
                while (($row = $result->fetch_array()) > 0)
                    array_push($workBuf, $row);
            }
        }

        $productBuf = array();
        if(!empty($keyWord)) {//关键字不空，查找指定员工
            $query_str = "SELECT * FROM `t_l3f11faam_appleproduction` WHERE (`pjcode` = '$pjCode' AND `activetime`>='$dayTimeStart' AND `activetime`<='$dayTimeEnd' AND `owner` = '$keyWord')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {  //输入的关键字为用户名
                while (($row = $result->fetch_array()) > 0)
                    array_push($productBuf, $row);
            }
        }
        else{ //关键字为空，查找全部员工
            $query_str = "SELECT * FROM `t_l3f11faam_appleproduction` WHERE (`pjcode` = '$pjCode' AND `activetime`>='$dayTimeStart' AND `activetime`<='$dayTimeEnd')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {
                while (($row = $result->fetch_array()) > 0)
                    array_push($productBuf, $row);
            }
        }

        //查询员工列表
        //$onJob = MFUN_HCU_FAAM_EMPLOYEE_ONJOB_YES;
        $query_str = "SELECT * FROM `t_l3f11faam_membersheet` WHERE (`pjcode` = '$pjCode')";
        $result = $mysqli->query($query_str);
        $nameList = array();
        while (($result != false) && (($row = $result->fetch_array()) > 0)){    ///取出工厂中每个人的信息
            $temp = array('employee' => $row['employee'],'unitprice'=>$row['unitprice'],'position'=>$row['position'],'zone'=>$row['zone']);
            array_push($nameList, $temp);
        }
        //查询产品规格列表
        $typeList = $this->dbi_get_product_type($mysqli, $pjCode);

        //处理考勤查询结果
        for($i=0; $i<count($workBuf); $i++){
            $employee = $workBuf[$i]['employee'];
            $workTime = $workBuf[$i]['worktime'];
            $dayStandardNum = $workBuf[$i]['daystandardnum'];  //日标准绩效
            if(isset($workingDay[$employee]) AND isset($totalWorkTime[$employee])){
                if($workTime != 0) {
                    $workingDay[$employee]++;
                    $totalWorkTime[$employee] = $totalWorkTime[$employee] + $workTime;
                }
            }
            else{ //第一次查询到某员工
                if($workTime != 0) {
                    $workingDay[$employee] = 1;
                    $totalWorkTime[$employee] = $workTime;
                }
                else{
                    $workingDay[$employee] = 0;
                    $totalWorkTime[$employee] = 0;
                }
            }

            if (isset($standardNumList[$employee])){
                $standardNumList[$employee] = $standardNumList[$employee] + $dayStandardNum ;
            }else{
                $standardNumList[$employee] = $dayStandardNum ;
            }
        }

        //处理生产查询结果
        for($i=0; $i<count($productBuf); $i++){
            $employee = $productBuf[$i]['owner'];
            $typeCode = $productBuf[$i]['typecode'];
            if(isset($package[$employee][$typeCode]))
                $package[$employee][$typeCode]++;
            else
                $package[$employee][$typeCode] = 1;
        }
        for($i=0; $i<count($nameList); $i++){
            $employee = $nameList[$i]['employee'];
            $totalPackage = 0;//箱数
            $totalNum = 0;//总数量
            $totalWeight = 0;//总重
            for($j=0; $j<count($typeList); $j++){
                $typeCode = $typeList[$j]['typecode'];
                $appleNum = $typeList[$j]['applenum'];
                $appleWeight = $typeList[$j]['appleweight'];
                if(isset($package[$employee][$typeCode])){
                    $perPackage = (int)$package[$employee][$typeCode];
                    $totalPackage += $perPackage;
                    $totalNum += $perPackage * (int)$appleNum;
                    $totalWeight += $perPackage * (int)$appleWeight;
                }
            }
            if (($totalPackage == 0) OR ($totalNum == 0) OR ($totalWeight == 0)) continue;
            $packageSum[$employee] = $totalPackage;
            $numSum[$employee] = $totalNum;
            $weightSum[$employee] = $totalWeight;
        }

        //聚合显示绩效结果
        $sid = 0;
        for($i=0; $i<count($nameList); $i++){

            $position = $nameList[$i]['position'];
            $zone = $nameList[$i]['zone'];
            $employee = $nameList[$i]['employee'];
            $unitPrice = intval($nameList[$i]['unitprice']);
            if (isset($workingDay[$employee]) AND isset($totalWorkTime[$employee])){
                //如果该员工有考勤但没有生产记录
                if (isset($packageSum[$employee])) $tempPackageSum = $packageSum[$employee]; else $tempPackageSum = 0;
                if (isset($weightSum[$employee])) $tempWeightSum = $weightSum[$employee]; else $tempWeightSum = 0;
                if (isset($numSum[$employee])) $tempNumSum = $numSum[$employee]; else $tempNumSum = 0;

                $timeSalary =  $totalWorkTime[$employee]*$unitPrice;
                if (isset($standardNumList[$employee])) $totalStandardNum = $standardNumList[$employee]; else $totalStandardNum = 0;
                if ($totalStandardNum != 0)
                    $kpiSalary = round((float)($tempNumSum/($totalStandardNum))*100, 2).'%';
                else
                    $kpiSalary = "%";
                $sid++;
                $temp =array();
                array_push($temp, $sid);
                array_push($temp, $employee);
                array_push($temp, $position);
                array_push($temp, $zone);
                array_push($temp, $timeStart);
                array_push($temp, $timeEnd);
                array_push($temp, $workingDay[$employee]);
                array_push($temp, $totalWorkTime[$employee]);
                array_push($temp, $unitPrice);
                array_push($temp, $timeSalary);
                array_push($temp, $tempPackageSum);
                array_push($temp, $tempWeightSum);
                array_push($temp, $tempNumSum);
                array_push($temp ,$totalStandardNum);
                array_push($temp, $kpiSalary);
                array_push($history['TableData'], $temp);
            }
        }
        $mysqli->close();
        return $history;
    }
    /*****************************自己更改起始处*************************************/
    //耗材入库的函数
    public function dbi_faam_consumables_buy($uid,$consumablesInfo,$reason)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        if (isset($consumablesInfo["vendor"])) $supplier = trim($consumablesInfo["vendor"]); else $supplier = "";
        if (isset($consumablesInfo["item"])) $datatype = trim($consumablesInfo["item"]); else $datatype = "";
        if (isset($consumablesInfo["number"])) $number = trim($consumablesInfo["number"]); else $number = "";
        if (isset($consumablesInfo["unit"])) $unit_price = trim($consumablesInfo["unit"]); else $unit_price = "";
        if (isset($consumablesInfo["total"])) $total_price = trim($consumablesInfo["total"]); else $total_price = "";
        $datype = "标准规格";
        switch ($datatype) {
            case 1:$datatype = "纸箱";break;
            case 2:$datatype = "保鲜袋";break;
            case 3:$datatype = "胶带";break;
            case 4:$datatype = "标签";break;
            case 5:$datatype = "托盘";break;
            case 6:$datatype = "垫片";break;
            case 7:$datatype = "网套";break;
            case 8:$datatype = "打包带";break;
            default:break;
        }
        date_default_timezone_set("PRC");//设置默认时间为中国
        $storage_time = date("Y-m-d H:i:s", time());;
        $query_str = "INSERT INTO `t_l3f11faam_buy_suppliessheet`(supplier,reason,datatype,amount,unitprice,storagetime,totalprice,datype)VALUES('$supplier','$reason','$datatype','$number','$unit_price','$storage_time','$total_price','$datype')";
        $result = $mysqli->query($query_str);
        $mysqli->close();
        return $result;
    }
    //整个耗材表的信息
    public function dbi_faam_consumables_history($timeStart,$timeEnd,$type)
    {
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $history["ColumnName"] = array();
        $history["TableData"] = array();
        $sid = 0;
        array_push($history["ColumnName"], "序号");
        array_push($history["ColumnName"], "供应单位");
        array_push($history["ColumnName"], "名称");
        array_push($history["ColumnName"], "单价");
        array_push($history["ColumnName"], "数量");
        array_push($history["ColumnName"], "总价");
        array_push($history["ColumnName"], "入库时间");
        array_push($history["ColumnName"], "规格");
        array_push($history["ColumnName"], "状态");
        if (!empty($type)) {
            //$query_str="SELECT * FROM `t_l3f11faam_buy_suppliessheet`WHERE(`storagetime`>='$timeStart' AND `storagetime`<='$timeEnd' AND `datatype`='%$type%')";
            $query_str = "SELECT * FROM `t_l3f11faam_buy_suppliessheet` WHERE (`storagetime`>='$timeStart' AND `storagetime`<='$timeEnd' AND `datatype`like '%$type%')";
        } else {
            $query_str = "SELECT * FROM `t_l3f11faam_buy_suppliessheet`WHERE(`storagetime`>='$timeStart' AND `storagetime`<='$timeEnd')";
        }
        $result = $mysqli->query($query_str);

        while (($result != false) && (($row = $result->fetch_array()) > 0)) {
            $sid = $sid + 1;
            $supplyunit = $row['supplier'];
            $reason = $row['reason'];
            $datatype = $row['datatype'];
            $amount = $row['amount'];
            $unitprice = $row['unitprice'];
            $storagetime = $row['storagetime'];
            $totalprice = $row['totalprice'];
            $datype = $row['datype'];

            $temp = array();
            array_push($temp, $sid);
            array_push($temp, $supplyunit);
            array_push($temp, $datatype);
            array_push($temp, $unitprice);
            array_push($temp, $amount);
            array_push($temp, $totalprice);
            array_push($temp, $storagetime);
            array_push($temp, $datype);
            array_push($temp, $reason);

            array_push($history['TableData'], $temp);
        }
        $mysqli->close();
        return $history;
    }
    //UI耗材历史表
    public function dbi_faam_consumables_history_table($uid,$key,$timeStart,$timeEnd,$keyWord){
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $history["ColumnName"] = array();
        $history["TableData"] = array();
        array_push($history["ColumnName"], "序号");
        array_push($history["ColumnName"], "名称");
        array_push($history["ColumnName"], "单价");
        array_push($history["ColumnName"], "数量");
        array_push($history["ColumnName"], "总价");
        array_push($history["ColumnName"], "供应单位");
        array_push($history["ColumnName"], "入库时间");
        array_push($history["ColumnName"], "规格");
        array_push($history["ColumnName"], "状态");
        if(empty($keyWord)){
            if(empty($key)){
                $query_str="SELECT * FROM `t_l3f11faam_buy_suppliessheet`WHERE(`storagetime`>='$timeStart' AND `storagetime`<='$timeEnd')";
            }else{
                $query_str="SELECT * FROM `t_l3f11faam_buy_suppliessheet`WHERE(`storagetime`>='$timeStart'AND `storagetime`<='$timeEnd' AND `datatype`='$key')";
            }
        }
        else{
            if(empty($key)){
                $query_str="SELECT * FROM `t_l3f11faam_buy_suppliessheet`WHERE(`storagetime`>='$timeStart' AND `storagetime`<='$timeEnd' AND `supplier`like '%$keyWord%')";
            }
            else{
                $query_str="SELECT * FROM `t_l3f11faam_buy_suppliessheet`WHERE(`storagetime`>='$timeStart'AND `storagetime`<='$timeEnd' AND `datatype`='$key' AND `supplier`like '%$keyWord%')";
            }
        }
        $result=$mysqli->query($query_str);
        $product_table=$this->dbi_faam_consumables_table($uid);
        $consumables_used=array();
        $consumables=array(0,0,0,0,0,0,0,0);
        $used=$product_table['TableData'];
        for($i=0;$i<count($used);$i++){
            array_push($consumables_used,$used[$i][3]);
        }
        $i=1;
        while (($result != false) && (($row = $result->fetch_array()) > 0)) {
            switch($row['datatype']){
                case "纸箱":
                    $consumables[0]=$consumables[0]+$row["amount"];
                    if(($consumables[0]-$consumables_used[0])<=0){
                        $single="";
                        $reason="已经用完，不可修改";
                    }
                    elseif($consumables[0]-$consumables_used[0]>=$row["amount"]){
                        //$single="1";
                        $single=(string)($row["sid"]);
                        $reason="尚未使用，可以修改";
                    }
                    else{
                        $single="";
                        $reason="正在使用，不可修改";
                    }
                    break;
                case "网套":
                    $consumables[1]=$consumables[1]+$row["amount"];
                    if(($consumables[1]-$consumables_used[1])<=0){
                        $single="";
                        $reason="已经用完，不可修改";
                    }
                    elseif($consumables[1]-$consumables_used[1]>=$row["amount"]){
                        //$single="1";
                        $single=(string)($row["sid"]);
                        $reason="尚未使用，可以修改";
                    }
                    else{
                        $single="";
                        $reason="正在使用，不可修改";
                    }
                    break;
                case "托盘":
                    $consumables[2]=$consumables[2]+$row["amount"];
                    if(($consumables[2]-$consumables_used[2])<=0){
                        $single="";
                        $reason="已经用完，不可修改";
                    }
                    elseif($consumables[2]-$consumables_used[2]>=$row["amount"]){
                        //$single="1";
                        $single=(string)($row["sid"]);
                        $reason="尚未使用，可以修改";
                    }
                    else{
                        $single="";
                        $reason="正在使用，不可修改";
                    }
                    break;
                case "胶带":
                    $consumables[3]=$consumables[3]+$row["amount"];
                    if(($consumables[3]-$consumables_used[3])<=0){
                        $single="";
                        $reason="已经用完，不可修改";
                    }
                    elseif($consumables[3]-$consumables_used[3]>=$row["amount"]){
                        //$single="1";
                        $single=(string)($row["sid"]);
                        $reason="尚未使用，可以修改";
                    }
                    else{
                        $single="";
                        $reason="正在使用，不可修改";
                    }
                    break;
                case "标签":
                    $consumables[4]=$consumables[4]+$row["amount"];
                    if(($consumables[4]-$consumables_used[4])<=0){
                        $single="";
                        $reason="已经用完，不可修改";
                    }
                    elseif($consumables[4]-$consumables_used[4]>=$row["amount"]){
                        //$single="1";
                        $single=(string)($row["sid"]);
                        $reason="尚未使用，可以修改";
                    }
                    else{
                        $single="";
                        $reason="正在使用，不可修改";
                    }
                    break;
                case "保鲜袋":
                    $consumables[5]=$consumables[5]+$row["amount"];
                    if(($consumables[5]-$consumables_used[5])<=0){
                        $single="";
                        $reason="已经用完，不可修改";
                    }
                    elseif($consumables[5]-$consumables_used[5]>=$row["amount"]){
                        //$single="1";
                        $single=(string)($row["sid"]);
                        $reason="尚未使用，可以修改";
                    }
                    else{
                        $single="";
                        $reason="正在使用，不可修改";
                    }
                    break;
                case "打包带":
                    $consumables[6]=$consumables[6]+$row["amount"];
                    if(($consumables[6]-$consumables_used[6])<=0){
                        $single="";
                        $reason="已经用完，不可修改";
                    }
                    elseif($consumables[6]-$consumables_used[6]>=$row["amount"]){
                        //$single="1";
                        $single=(string)($row["sid"]);
                        $reason="尚未使用，可以修改";
                    }
                    else{
                        $single="";
                        $reason="正在使用，不可修改";
                    }
                    break;
                case "垫片":
                    $consumables[7]=$consumables[7]+$row["amount"];
                    if(($consumables[7]-$consumables_used[7])<=0){
                        $single="";
                        $reason="已经用完，不可修改";
                    }
                    elseif($consumables[7]-$consumables_used[7]>=$row["amount"]){
                        //$single="1";
                        $single=(string)($row["sid"]);
                        $reason="尚未使用，可以修改";
                    }
                    else{
                        $single="";
                        $reason="正在使用，不可修改";
                    }
                    break;
                default:
                    break;
            }
            $sid=(string)$i;
            $supplyunit = $row['supplier'];
            $datype = $row['datype'];
            $datatype = $row['datatype'];
            $amount = $row['amount'];
            $unitprice = $row['unitprice'];
            $storagetime = $row['storagetime'];
            $totalprice = $row['totalprice'];
            $temp = array();
            array_push($temp, $single);
            array_push($temp, $sid);
            array_push($temp, $datatype);
            array_push($temp, $unitprice);
            array_push($temp, $amount);
            array_push($temp, $totalprice);
            array_push($temp, $supplyunit);
            array_push($temp, $storagetime);
            array_push($temp, $datype);
            array_push($temp, $reason);
            array_push($history['TableData'], $temp);
            $i=$i+1;
        }
        $mysqli->close();
        return $history;
    }
    //耗材的现存信息
    public function dbi_faam_consumables_table($uid){
        $table["ColumnName"]=array();
        $table["TableData"]=array();
        $datatype=array("纸箱","网套","托盘","胶带","标签","保鲜袋","打包带","垫片");

        $timeStart="0000-00-00 00:00:00";
        date_default_timezone_set("PRC");
        $timeEnd=date("Y-m-d H:i:s",time());
        $sid=1;
        array_push($table["ColumnName"],"序号");
        array_push($table["ColumnName"],"名称");
        array_push($table["ColumnName"],"历史总量");
        array_push($table["ColumnName"],"已使用总量");
        array_push($table["ColumnName"],"剩余量");
        array_push($table["ColumnName"],"规格");
        array_push($table["ColumnName"],"状态");
        //dbi_faam_production_history_audit
        $temp=$this->dbi_faam_consumables_history($timeStart,$timeEnd,"");
        $data=array(0,0,0,0,0,0,0,0);
        $middle=$temp["TableData"];
        for($i=0;$i<count($temp["TableData"]);$i++){
            switch($middle[$i][2]){
                case "纸箱":$data[0]=$data[0]+$middle[$i][4];break;
                case "网套":$data[1]=$data[1]+$middle[$i][4];break;
                case "托盘":$data[2]=$data[2]+$middle[$i][4];break;
                case "胶带":$data[3]=$data[3]+$middle[$i][4];break;
                case "标签":$data[4]=$data[4]+$middle[$i][4];break;
                case "保鲜袋":$data[5]=$data[5]+$middle[$i][4];break;
                case "打包带":$data[6]=$data[6]+$middle[$i][4];break;
                case "垫片":$data[7]=$data[7]+$middle[$i][4];break;
                default:break;
            }
        }
        //调用函数，获得历史上的成品数量
        $history=$this->dbi_faam_production_history_audit($uid,$timeStart,$timeEnd,"");
        $product=$history["TableData"][count($history["TableData"])-1];
        $packageSum=$product[7];
        $appleSum=$product[8];
        /*耗材的损耗与成品的关系，暂时定为一像苹果消耗1.02套箱子（箱子中可能有残次品以及装箱过程中损坏的箱子），
        消耗1.1个网套（网套比较易碎），300个网套为一包，一个箱子中装有2.01个托盘（分上下两层，损耗计入在内）,托
        盘为30个为一包，10个箱子消耗一卷胶带，一箱胶带25卷，每个苹果消耗1.02个标签,一本有100个标签，每个苹果消
        耗1.02个保鲜袋，100个保鲜袋为一包，25个箱子消耗一扎打包带，每个箱子消耗2.02个垫片*/
        $box=ceil(1.02*$packageSum);//箱子已使用（套）
        $metal_net=ceil((1.1*$appleSum)/300);//网套已使用（包）
        $tray=ceil((2.01*$packageSum)/30);//托盘
        $tape=ceil($packageSum/250);//胶带
        $label=ceil(($appleSum*1.02)/100);//标签
        $fresh_package=ceil(($appleSum*1.02)/100);//保鲜袋
        $packing_belt=ceil($packageSum/25);//打包带
        $shim=ceil($packageSum*2.02);//垫片
        $consumables_used=array();
        array_push($consumables_used,$box);
        array_push($consumables_used,$metal_net);
        array_push($consumables_used,$tray);
        array_push($consumables_used,$tape);
        array_push($consumables_used,$label);
        array_push($consumables_used,$fresh_package);
        array_push($consumables_used,$packing_belt);
        array_push($consumables_used,$shim);
        //最终计算
        for($i=0;$i<8;$i++){
            $mid=array();
            //$mm=$data[$i]-0;
            array_push($mid,$sid);
            array_push($mid,$datatype[$i]);
            array_push($mid,$data[$i]);
            array_push($mid,$consumables_used[$i]);
            array_push($mid,$data[$i]-$consumables_used[$i]);

            array_push($mid,"标准规格");
            if($data[$i]-$consumables_used[$i]<=7){
                array_push($mid,"需要补充");
            }
            else{
                array_push($mid,"数量充足");
            }
            $sid++;
            array_push($table["TableData"],$mid);
        }
        return $table;
    }
    //耗材的记录信息
    public function dbi_faam_get_consumbales_purchase($sid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $consumables_key = array('consumablespurchaseID','item','number','unit','total','vendor','type');
        $consumables_values=array();
        $query_str = "SELECT * FROM `t_l3f11faam_buy_suppliessheet`WHERE(`sid`='$sid')";
        $result=$mysqli->query($query_str);
        while (($result != false) && (($row = $result->fetch_array()) > 0)) {
            array_push($consumables_values,$row["sid"]);
            switch($row["datatype"]){
                case "纸箱":array_push($consumables_values,"1");break;
                case "保鲜袋":array_push($consumables_values,"2");break;
                case "胶带":array_push($consumables_values,"3");break;
                case "标签":array_push($consumables_values,"4");break;
                case "托盘":array_push($consumables_values,"5");break;
                case "垫片":array_push($consumables_values,"6");break;
                case "网套":array_push($consumables_values,"7");break;
                case "打包带":array_push($consumables_values,"8");break;
                default:break;
            }
            array_push($consumables_values,$row["amount"]);
            array_push($consumables_values,$row["unitprice"]);
            array_push($consumables_values,$row["totalprice"]);
            array_push($consumables_values,$row["supplier"]);
            array_push($consumables_values,$row["datype"]);
            $consumables=array_combine($consumables_key,$consumables_values);
        }
        $mysqli->close();
        return $consumables;
    }
    //耗材修改
    public function dbi_faam_consumables_purchase_mod($body){
        //建立连接
        date_default_timezone_set("PRC");
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $sid=$body["consumablespurchaseID"];
        $item=$body["item"];
        $number=$body["number"];
        $unit=$body["unit"];
        $total=$body["total"];
        $vendor=$body["vendor"];
        $time=date("Y-m-d H:i:s",time());
        switch($item){
            case "1":$type="纸箱";break;
            case "2":$type="保鲜袋";break;
            case "3":$type="胶带";break;
            case "4":$type="标签";break;
            case "5":$type="托盘";break;
            case "6":$type="垫片";break;
            case "7":$type="网套";break;
            case "8":$type="打包带";break;
            default;break;
        }
        $query_str = "UPDATE `t_l3f11faam_buy_suppliessheet` SET `supplier`='$vendor',`datatype`='$type',`amount`='$number',`unitprice`='$unit',`storagetime`='$time',`totalprice`='$total'WHERE `sid`='$sid'";
        $result=$mysqli->query($query_str);
        $mysqli->close();
        return $result;
    }
    //耗材信息删除
    public function dbi_faam_consumables_purchase_del($body){
        //建立连接
        //date_default_timezone_set("PRC");
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $sid=$body["consumablespurchaseID"];
        $query_str = "DELETE FROM `t_l3f11faam_buy_suppliessheet`WHERE `sid`='$sid'";
        $result=$mysqli->query($query_str);
        $mysqli->close();
        return $result;
    }
    //仓库增加
    public function dbi_faam_product_stock_new($body){
        date_default_timezone_set("PRC");
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die('Could not connect:'.mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        if(isset($body["name"]))$name=trim($body["name"]);else $name="";
        if(isset($body["address"]))$address=trim($body["address"]);else $address="";
        //if(isset($body["charge"]))$charge=trim($body["charge"]);else $charge="";
        $query_str="SELECT * FROM `t_l3f11faam_products_stocksheet` WHERE `stockname`='$name'";
        $temp=$mysqli->query($query_str);
        $date=date("Y-m-d H:i:s",time());
        if(mysqli_num_rows($temp)>=1)
            $query_str="UPDATE `t_l3f11faam_products_stocksheet` SET `stockaddress`='$address',`stocktime`='$date' WHERE `stockname`='$name'";
        else {
            $charge="李四";
            $query_str = "INSERT INTO `t_l3f11faam_products_stocksheet` (`stockname`,`stockaddress`,`stockheader`,`stocktime`)VALUES ('$name','$address','$charge','$date')";
        }
        $result=$mysqli->query($query_str);
        $mysqli->close();
        return $result;
    }
    //获得产品的重量和尺寸
    public function dbi_faam_get_product_weight_size(){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die('Could not connect:'.mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $product["weight"]=array();
        $product["size"]=array();
        $query_str="SELECT DISTINCT `appleweight` FROM `t_l3f11faam_typesheet`";
        $weight=$mysqli->query($query_str);
        while (($weight != false) && (($row = $weight->fetch_array()) > 0)) {
            array_push($product["weight"],$row["appleweight"]."KG");
        }
        $query_str="SELECT DISTINCT `applegrade` FROM `t_l3f11faam_typesheet`";
        $size=$mysqli->query($query_str);
        while (($size != false) && (($row = $size->fetch_array()) > 0)) {
            switch($row["applegrade"]){
                case "A":$s="特级";break;
                case "1":$s="一级";break;
                case "2":$s="二级";break;
                case "3":$s="三级";break;
                case "S":$s="混合";break;
                default:break;
            }

            array_push($product["size"],$s);
        }
        $mysqli->close();
        return $product;
    }
    //获取仓库列表
    public function dbi_faam_get_product_stock_list(){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die('Could not connect:'.mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $result=array();
        $query_str="SELECT * FROM `t_l3f11faam_products_stocksheet`";
        $temp=$mysqli->query($query_str);
        while(($temp!=false)&&(($row=$temp->fetch_array())>0)){
            $id=$row["sid"];
            $name=$row["stockname"];
            $address=$row["stockaddress"];
            $cargo = array('id'=>$id, 'name'=>$name, 'address'=>$address);
            array_push($result, $cargo);
        }
        $mysqli->close();
        return $result;
    }
    //获取空仓库信息
    public function dbi_faam_get_product_empty_stock(){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $name=$this->dbi_faam_get_product_stock_list();

        $notEmpty=array();
        $empty=array();
        for($i=0;$i<count($name);$i++){
            $total=0;
            $stockname=$name[$i]["name"];
            $query_str="SELECT * FROM `t_l3f11faam_products_into` WHERE `stockname`='$stockname'";
            $temp=$mysqli->query($query_str);
            while(($temp!=false)&&(($row=$temp->fetch_array())>0)){
                $total=$total+$row["number"];
            }
            if($total>0)
                array_push($notEmpty,$name[$i]);
            else
                array_push($empty,$name[$i]);
            if((in_array($name[$i],$notEmpty))&&(in_array($name[$i],$empty))){
                array_push($empty,$name[$i]);
            }
        }
        $mysqli->close();
        return $empty;
    }
    //删除空仓
    public function dbi_faam_product_stock_del($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $id=(integer)$body["stockID"];
        $query_str="DELETE FROM `t_l3f11faam_products_stocksheet` WHERE `sid`='$id'";
        $result=$mysqli->query($query_str);
        $mysqli->close();
        return $result;
    }
    //仓库信息列表
    public function dbi_faam_product_stock_table($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $name="";
        $Product["ColumnName"]=array();
        $Product["TableData"]=array();
        array_push($Product["ColumnName"],"序号");
        array_push($Product["ColumnName"],"库名");
        array_push($Product["ColumnName"],"重量/箱");
        array_push($Product["ColumnName"],"规格");
        array_push($Product["ColumnName"],"粒数/箱");
        array_push($Product["ColumnName"],"箱数");
        array_push($Product["ColumnName"],"仓库地址");
        array_push($Product["ColumnName"],"最后操作时间");
        array_push($Product["ColumnName"],"备注");
        $mysqli->query("SET NAMES utf8");
        if($body["StockID"]!="all") $id=(integer)$body["StockID"];
        else $id="";
        if($body["Period"]!="all") $weight=(double)$body["Period"];
        else $weight="";
        if($body["KeyWord"]!="all"){
            switch($body["KeyWord"]) {
                case "特级":$size = "A";break;
                case "一级":$size = "1";break;
                case "二级":$size = "2";break;
                case "三级":$size = "3";break;
                case "混合":$size = "S";break;
                default:break;
            }
        }
        else $size="";
        if($id==""){
            if($weight!="" AND $size!="")
                $query_str="SELECT * FROM `t_l3f11faam_products_into` WHERE `productweight`='$weight' AND `productsize`='$size'";
            elseif($weight!="" AND $size=="")
                $query_str="SELECT * FROM `t_l3f11faam_products_into` WHERE `productweight`='$weight'";
            elseif($weight=="" AND $size!="")
                $query_str="SELECT * FROM `t_l3f11faam_products_into` WHERE `productsize`='$size'";
            else
                $query_str="SELECT * FROM `t_l3f11faam_products_into`";
        }
        else{
            $query="SELECT * FROM `t_l3f11faam_products_stocksheet` WHERE `sid`='$id'";
            $temp=$mysqli->query($query);
            while(($temp!=false)&&(($row=$temp->fetch_array())>0)){
                $name=$row["stockname"];
            }
            if($weight!="" AND $size!="")
                $query_str="SELECT * FROM `t_l3f11faam_products_into` WHERE `productweight`='$weight' AND `productsize`='$size' AND `stockname`='$name'";
            elseif($weight!="" AND $size=="")
                $query_str="SELECT * FROM `t_l3f11faam_products_into` WHERE `productweight`='$weight'AND `stockname`='$name'";
            elseif($weight=="" AND $size!="")
                $query_str="SELECT * FROM `t_l3f11faam_products_into` WHERE `productsize`='$size'AND `stockname`='$name'";
            else
                $query_str="SELECT * FROM `t_l3f11faam_products_into`WHERE `stockname`='$name'";
        }
        $temp1=$mysqli->query($query_str);
        $i=1;
        while(($temp1!=false)&&(($row1=$temp1->fetch_array())>0)){
            $info=array();
            switch($row1["productsize"]){
                case "A":$type="特级";break;
                case "1":$type="一级";break;
                case "2":$type="二级";break;
                case "3":$type="三级";break;
                case "S":$type="混合";break;
                default:break;
            }
            $name1=$row1["stockname"];
            $address="";
            $querystr="SELECT * FROM `t_l3f11faam_products_stocksheet` WHERE `stockname`='$name1'";
            $temp2=$mysqli->query($querystr);
            while(($temp2!=false)&&(($row2=$temp2->fetch_array())>0)){
                $address=$row2["stockaddress"];
            }
            if($address==""){
                $address="该库已删除";
            }
            array_push($info,$row1["sid"]);
            array_push($info,(string)$i);
            array_push($info,$name1);
            array_push($info,$row1["productweight"]."KG");
            array_push($info,$type);
            array_push($info,$row1["productnum"]);
            array_push($info,$row1["number"]);
            array_push($info,$address);
            array_push($info,$row1["datime"]);
            array_push($info,$row1["message"]);
            array_push($Product["TableData"],$info);
            $i=$i+1;
        }
        $mysqli->close();
        return $Product;
    }
    //查看一条入库信息
    public function  dbi_faam_get_product_stock_detail($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $stockID=(integer)$body["stockID"];
        $query_str="SELECT * FROM `t_l3f11faam_products_into` WHERE `sid`='$stockID'";
        $temp=$mysqli->query($query_str);
        while(($temp!=false)&&(($row=$temp->fetch_array())>0)){
            $name=$row["stockname"];
            $weight=(string)$row["productweight"];
            $size1=$row["productsize"];
            switch($size1){
                case "A":$size="特级";break;
                case "1":$size="一级";break;
                case "2":$size="二级";break;
                case "3":$size="三级";break;
                case "S":$size="混合";break;
                default:break;
            }
            $list=$this->dbi_faam_get_product_stock_list();
            for($i=0;$i<count($list);$i++){
                if($name==$list[$i]["name"])
                    $id=(string)$list[$i]["id"];
            }
            $result = array("ID"=>$stockID,"storageID"=> $id,"size"=> $size,"weight"=>$weight.'KG',"maxStorage"=>"100");
        }
        $mysqli->close();
        return $result;
    }
    //转库
    public function dbi_faam_product_stock_transfer($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $name=array();
        date_default_timezone_set("Asia/Shanghai");
        $time=date("Y-m-d H:i;s",time());
        $productnum=28;
        $storageID=(integer)$body["storageID"];//出库方
        $weight=(integer)$body['weight'];//重量
        $size=$body["size"];//规格
        $productcharge="李四";
        $number=(integer)$body["number"];//数量
        $target=$body["target"];//目标库
        $note=$body["note"];//备注
        switch($size){
            case "特级":$size="A";break;
            case "一级":$size="1";break;
            case "二级":$size="2";break;
            case "三级":$size="3";break;
            case "混合":$size="S";break;
            default:break;
        }
        $query_name="SELECT * FROM `t_l3f11faam_products_stocksheet` WHERE `sid`='$storageID'";
        $temp_name=$mysqli->query($query_name);
        while(($temp_name!=false)&&($row_name=$temp_name->fetch_array())>0) {
            array_push($name,$row_name["stockname"]);
        }
        $query_into_name = "SELECT * FROM `t_l3f11faam_products_stocksheet` WHERE `sid`='$target'";
        $temp_into_name = $mysqli->query($query_into_name);
        while (($temp_into_name != false) && ($row_into_name = $temp_into_name->fetch_array()) > 0) {
            array_push($name,$row_into_name["stockname"]);
        }
        $out_name=$name[0];//出库方
        $into_name=$name[1];//入库方
        $query_into = "SELECT * FROM `t_l3f11faam_products_into` WHERE `stockname`='$into_name' AND `productweight`='$weight' AND `productsize`='$size' AND `productnum`='$productnum'";
        $temp_into = $mysqli->query($query_into);
        $query_out="SELECT * FROM `t_l3f11faam_products_into` WHERE `stockname`='$out_name' AND `productweight`='$weight' AND `productsize`='$size' AND `productnum`='$productnum'";
        $temp_out=$mysqli->query($query_out);
        while(($temp_out!=false)&&($row_out=$temp_out->fetch_array())>0){
            $history_number=$row_out["number"];
        }
        $surplus=$history_number-$number;
        if($surplus>=0){
            if(mysqli_num_rows($temp_into)>0){
                $temp=$temp_into->fetch_array();
                $total=$number+$temp["number"];
                if(($note=="")&&(trim($note))==""){
                    $query_into_insert = "UPDATE `t_l3f11faam_products_into` SET `number`='$total',`datime`='$time' ,`message`='转库入库'WHERE `stockname`='$into_name' AND `productweight`='$weight' AND `productsize`='$size' AND `productnum`='$productnum'";
                    $query_into_update = "UPDATE `t_l3f11faam_products_into` SET `number`='$surplus',`datime`='$time' WHERE `stockname`='$out_name' AND `productweight`='$weight' AND `productsize`='$size' AND `productnum`='$productnum'";
                    $query_out_insert = "INSERT INTO `t_l3f11faam_products_out`(`stockname`,`productweight`,`productsize`,`productnum`,`number`, `containernumber`, `platenumber`, `drivername`, `driverpho`, `receivingunit`, `logisticsunit`, `outtime`,`message`)
                                                                        VALUES('$out_name','$weight','$size','$productnum','$number','----','----','----','----','----','----','$time','转库出库')";
                }
                else{
                    $query_into_insert = "UPDATE `t_l3f11faam_products_into` SET `number`='$total',`datime`='$time' ，`message`='$note'WHERE `stockname`='$into_name' AND `productweight`='$weight' AND `productsize`='$size' AND `productnum`='$productnum'";
                    $query_into_update = "UPDATE `t_l3f11faam_products_into` SET `number`='$surplus',`datime`='$time' WHERE `stockname`='$out_name' AND `productweight`='$weight' AND `productsize`='$size' AND `productnum`='$productnum' ";
                    $query_out_insert = "INSERT INTO `t_l3f11faam_products_out`(`stockname`,`productweight`,`productsize`,`productnum`,`number`, `containernumber`, `platenumber`, `drivername`, `driverpho`, `receivingunit`, `logisticsunit`, `outtime`,`message`)
                                                                        VALUES('$out_name','$weight','$size','$productnum','$number','----','----','----','----','----','----','$time','$note')";
                }
            }
            else {
                if (($note == "") && (trim($note)) == "") {
                    $query_into_insert = "INSERT INTO `t_l3f11faam_products_into`(`stockname`, `productweight`, `productsize`, `productnum`, `number`, `productcharge`, `message`, `datime`) VALUES ('$into_name','$weight','$size','$productnum','$number','$productcharge','转库入库','$time')";
                    $query_into_update = "UPDATE `t_l3f11faam_products_into` SET `number`='$surplus',`datime`='$time' WHERE `stockname`='$out_name' AND `productweight`='$weight' AND `productsize`='$size' AND `productnum`='$productnum'";
                    $query_out_insert = "INSERT INTO `t_l3f11faam_products_out`(`stockname`,`productweight`,`productsize`,`productnum`,`number`, `containernumber`, `platenumber`, `drivername`, `driverpho`, `receivingunit`, `logisticsunit`, `outtime`,`message`)
                                                                        VALUES('$out_name','$weight','$size','$productnum','$number','----','----','----','----','----','----','$time','转库出库')";
                } else {
                    $query_into_insert = "INSERT INTO `t_l3f11faam_products_into`(`stockname`, `productweight`, `productsize`, `productnum`, `number`, `productcharge`, `message`, `datime`) VALUES ('$into_name','$weight','$size','$productnum','$number','$productcharge','$note','$time')";
                    $query_into_update = "UPDATE `t_l3f11faam_products_into` SET `number`='$surplus',`datime`='$time' WHERE `stockname`='$out_name' AND `productweight`='$weight' AND `productsize`='$size' AND `productnum`='$productnum' ";
                    $query_out_insert = "INSERT INTO `t_l3f11faam_products_out`(`stockname`,`productweight`,`productsize`,`productnum`,`number`, `containernumber`, `platenumber`, `drivername`, `driverpho`, `receivingunit`, `logisticsunit`, `outtime`,`message`)
                                                                        VALUES('$out_name','$weight','$size','$productnum','$number','----','----','----','----','----','----','$time','$note')";

                }
            }
            $mysqli->query($query_into_insert);
            $mysqli->query($query_into_update);
            $result=$mysqli->query($query_out_insert);
        }
        else{
            $result="";
        }
        $mysqli->close();
        return $result;
    }
    //出库
    public function dbi_faam_product_stock_removal_new($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        date_default_timezone_set("Asia/Shanghai");
        $result="";
        $time=date("Y-m-d H:i;s",time());
        $productnum=28;//暂无数据，以一个固定值代替。
        $storageID=$body["storageID"];
        $weight=(integer)$body["weight"];
        $size=$body["size"];
        switch($size){
            case "特级":$size="A";break;
            case "一级":$size="1";break;
            case "二级":$size="2";break;
            case "三级":$size="3";break;
            case "混合":$size="S";break;
            default:break;
        }
        $number=(integer)$body["number"];
        $container=$body["container"];
        $trunk=$body["trunk"];
        $mobile=$body["mobile"];
        $driver=$body["driver"];
        $target=$body["target"];
        $logistics=$body["logistics"];
        $query_name="SELECT * FROM `t_l3f11faam_products_stocksheet` WHERE `sid`='$storageID'";
        $temp_name=$mysqli->query($query_name);
        while(($temp_name!=false)&&($row_name=$temp_name->fetch_array())>0){
            $name=$row_name["stockname"];
            $query_into="SELECT * FROM `t_l3f11faam_products_into` WHERE `stockname`='$name' AND `productweight`='$weight' AND `productsize`='$size' AND `productnum`='$productnum'";
            $temp_into=$mysqli->query($query_into);
            while(($temp_into!=false)&&($row_into=$temp_into->fetch_array())>0){
                if($row_into["number"]>=$number){
                    $total_num=$row_into["number"]-$number;
                    $query_out_insert="INSERT INTO `t_l3f11faam_products_out`(`stockname`,`productweight`,`productsize`,`productnum`,`number`, `containernumber`, `platenumber`, `drivername`, `driverpho`, `receivingunit`, `logisticsunit`, `outtime`,`message`) VALUES('$name','$weight','$size','$productnum','$number','$container','$trunk','$driver','$mobile','$target','$logistics','$time','正常出库')";
                    $mysqli->query($query_out_insert);
                    $query_into_update="UPDATE `t_l3f11faam_products_into` SET `number`='$total_num',`datime`='$time'WHERE `stockname`='$name' AND `productweight`='$weight' AND `productsize`='$size' AND `productnum` ='$productnum'";
                    $result=$mysqli->query($query_into_update);
                }
            }
        }
        $mysqli->close();
        return $result;
    }
    //出库历史表
    public function dbi_faam_product_stock_history($body){
        date_default_timezone_set("PRC");
        $timeEnd=date("Y-m-d",time());
        $history["ColumnName"]=array();
        array_push($history["ColumnName"],"序号");
        array_push($history["ColumnName"],"出库库名");
        array_push($history["ColumnName"],"重量/箱");
        array_push($history["ColumnName"],"规格");
        array_push($history["ColumnName"],"粒数/箱");
        array_push($history["ColumnName"],"箱数");
        array_push($history["ColumnName"],"集装箱号");
        array_push($history["ColumnName"],"车牌号");
        array_push($history["ColumnName"],"司机姓名");
        array_push($history["ColumnName"],"司机手机");
        array_push($history["ColumnName"],"收货单位");
        array_push($history["ColumnName"],"物流单位");
        array_push($history["ColumnName"],"出库时间");
        array_push($history["ColumnName"],"备注");
        $history["TableData"]=array();
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $stock_name="";
        $mysqli->query("SET NAMES utf8");
        if($body["StockID"]=="all") $ID="";
        else $ID=(integer)$body["StockID"];
        if($body["KeyWord"]=="") $keyWord="";
        else $keyWord=trim($body["KeyWord"]);
        if($ID!="") {
            $query_name = "SELECT * FROM `t_l3f11faam_products_stocksheet` WHERE `sid`='$ID'";
            $temp_name = $mysqli->query($query_name);
            while (($temp_name != false) && ($name = $temp_name->fetch_array()) > 0) {
                $stock_name = $name["stockname"];
            }
        }
        switch($body["Period"]){
            case "1":$timeStart=$timeEnd;break;;
            case "7":$timeStart=date('Y-m-d', strtotime("-6 day"));break;
            case "30":$timeStart=date('Y-m-d',strtotime("-29 day"));break;
            case "all":$timeStart="0000-00-00";
            default;break;
        }
        $timeEnd=$timeEnd." 23:59:59";
        $timeStart=$timeStart." 00:00:00";
        if($stock_name==""){
            if($keyWord=="")
                $query_str="SELECT * FROM `t_l3f11faam_products_out` WHERE `outtime`>='$timeStart' AND `outtime`<='$timeEnd'";
            else {
                $query_str="SELECT * FROM `t_l3f11faam_products_out` WHERE `outtime`>='$timeStart' AND `outtime`<='$timeEnd' AND `drivername`LIKE'%$keyWord%'";
            }
        }
        else{
            if($keyWord=="")
                $query_str="SELECT * FROM `t_l3f11faam_products_out` WHERE `outtime`>='$timeStart' AND `outtime`<='$timeEnd'AND `stockname`='$stock_name'";
            else {
                $query_str="SELECT * FROM `t_l3f11faam_products_out` WHERE `outtime`>='$timeStart' AND `outtime`<='$timeEnd'AND `stockname`='$stock_name' AND `drivername`LIKE'%$keyWord%'";
            }
        }
        $temp=$mysqli->query($query_str);
        $i=1;
        while(($temp!=false)&&($row=$temp->fetch_array())>0){
            switch($row["productsize"]){
                case "A":$size="特级";break;
                case "1":$size="一级";break;
                case "2":$size="二级";break;
                case "3":$size="三级";break;
                case "S":$size="混合";break;
                default:break;
            }
            $middle=array();
            array_push($middle,$row["sid"]);
            array_push($middle,$i);
            array_push($middle,$row["stockname"]);
            array_push($middle,$row["productweight"]);
            array_push($middle,$size);
            array_push($middle,$row["productnum"]);
            array_push($middle,$row["number"]);
            array_push($middle,$row["containernumber"]);
            array_push($middle,$row["platenumber"]);
            array_push($middle,$row["drivername"]);
            array_push($middle,$row["driverpho"]);
            array_push($middle,$row["receivingunit"]);
            array_push($middle,$row["logisticsunit"]);
            array_push($middle,$row["outtime"]);
            array_push($middle,$row["message"]);
            array_push($history["TableData"],$middle);
            $i=$i+1;
        }
        $mysqli->close();
        return $history;
    }
    //获取一条出库信息
    public function dbi_faam_get_product_stock_history_detail($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $ID=$body["removalID"];
        $query_str="SELECT * FROM `t_l3f11faam_products_out` WHERE `sid`='$ID'";
        $temp=$mysqli->query($query_str);
        while(($temp!=false)&&($row=$temp->fetch_array())>0){
            $name=$row["stockname"];
            $query_id="SELECT * FROM `t_l3f11faam_products_stocksheet` WHERE `stockname`='$name'";
            $temp_id=$mysqli->query($query_id);
            while(($temp_id!=false)&&($row_id=$temp_id->fetch_array())>0){
                $stock_id=(string)$row_id["sid"];
            }
            switch($row["productsize"]){
                case "A":$size="特级";break;
                case "1":$size="一级";break;
                case "2":$size="二级";break;
                case "3":$size="三级";break;
                case "S":$size="混合";break;
                default:break;
            }
            $weight=(string)$row["productweight"]."KG";
            $number=(string)$row["number"];
            $container=$row["containernumber"];
            $trunk=$row["platenumber"];
            $driver=$row["drivername"];
            $mobile=$row["driverpho"];
            $target=$row["receivingunit"];
            $logistics=$row["logisticsunit"];
            $result=array("storageID"=>$stock_id,"weight"=>$weight,"size"=>$size,"number"=>$number,"container"=>$container,"trunk"=>$trunk,"driver"=>$driver,"mobile"=>$mobile,"target"=>$target,"logistics"=>$logistics);
        }
        $mysqli->close();
        return $result;
    }
    //新建原料仓库
    public function dbi_faam_material_stock_new($body){
        date_default_timezone_set("PRC");
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die('Could not connect:'.mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        if(isset($body["name"]))$name=trim($body["name"]);else $name="";
        if(isset($body["address"]))$address=trim($body["address"]);else $address="";
        //if(isset($body["charge"]))$charge=trim($body["charge"]);else $charge="";
        $query_str="SELECT * FROM `t_l3f11faam_material_stocksheet` WHERE `stockname`='$name'";
        $temp=$mysqli->query($query_str);
        $date=date("Y-m-d H:i:s",time());
        $isself=$body["mode"];
        if(mysqli_num_rows($temp)>=1)
            $query_str="UPDATE `t_l3f11faam_material_stocksheet` SET `stockaddress`='$address',`stocktime`='$date',`isself`='$isself' WHERE `stockname`='$name'";
        else {
            $charge="李四";
            $query_str = "INSERT INTO `t_l3f11faam_material_stocksheet` (`stockname`,`stockaddress`,`stockheader`,`stocktime`,`isself`)VALUES ('$name','$address','$charge','$date','$isself')";
        }
        $result=$mysqli->query($query_str);
        $mysqli->close();
        return $result;
    }
    //获取原料仓库列表
    public function dbi_faam_get_material_stock_list(){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die('Could not connect:'.mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $result=array();
        $query_str="SELECT * FROM `t_l3f11faam_material_stocksheet`";
        $temp=$mysqli->query($query_str);
        while(($temp!=false)&&(($row=$temp->fetch_array())>0)){
            $id=$row["sid"];
            $name=$row["stockname"];
            $address=$row["stockaddress"];
            $cargo = array('id'=>$id, 'name'=>$name, 'address'=>$address);
            array_push($result, $cargo);
        }
        $mysqli->close();
        return $result;
    }
    //获取原料空仓库列表
    public function dbi_faam_get_material_empty_stock(){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $name=$this->dbi_faam_get_material_stock_list();

        $notEmpty=array();
        $empty=array();
        for($i=0;$i<count($name);$i++){
            $total=0;
            $stockname=$name[$i]["name"];
            $query_str="SELECT * FROM `t_l3f11faam_material_table` WHERE `stockname`='$stockname'";
            $temp=$mysqli->query($query_str);
            while(($temp!=false)&&(($row=$temp->fetch_array())>0)){
                $total=$total+$row["bucketnum"];
            }
            if($total>0)
                array_push($notEmpty,$name[$i]);
            else
                array_push($empty,$name[$i]);
            if((in_array($name[$i],$notEmpty))&&(in_array($name[$i],$empty))){
                array_push($empty,$name[$i]);
            }
        }
        $mysqli->close();
        return $empty;
    }
    //删除空仓
    public function dbi_faam_material_stock_del($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $id=(integer)$body["stockID"];
        $query_name="SELECT * FROM `t_l3f11faam_material_stocksheet` WHERE `sid`='$id'";
        $result_name=$mysqli->query($query_name);
        while(($result_name!=false)&&($row_name=$result_name->fetch_array())>0) {
            $name=$row_name["stockname"];
            $query_str = "DELETE FROM `t_l3f11faam_material_stocksheet` WHERE `sid`='$id'";
            $query_table="DELETE FROM `t_l3f11faam_material_table` WHERE `stockname`='$name'";
            //$query_history="DELETE FROM `t_l3f11faam_material_history`WHERE`stockname`='$name'";
            $mysqli->query($query_table);
            $result = $mysqli->query($query_str);
        }
        return $result;
        $mysqli->close();
    }
    //显示仓库信息
    public function dbi_faam_material_stock_table($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        $material["ColumnName"]=array();
        $material["TableData"]=array();
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        if(($body["StockID"])=="all"){
            $query="SELECT * FROM `t_l3f11faam_material_stocksheet` WHERE 1";
        }
        else{
            $ID=(integer)$body["StockID"];
            $query="SELECT * FROM `t_l3f11faam_material_stocksheet` WHERE `sid`='$ID'";
        }
        array_push($material["ColumnName"],"序号");
        array_push($material["ColumnName"],"库名");
        array_push($material["ColumnName"],"自有");
        array_push($material["ColumnName"],"桶数");
        array_push($material["ColumnName"],"总费用");
        array_push($material["ColumnName"],"最后一次操作时间");
        array_push($material["ColumnName"],"仓库地址");
        $temp_name=$mysqli->query($query);
        $i=1;
        while(($temp_name!=false)&&($row_name=$temp_name->fetch_array())>0){
            $table=array();
            $id=$row_name["sid"];
            $name=$row_name["stockname"];
            $address=$row_name["stockaddress"];
            $isself=(string)$row_name["isself"];
            switch($isself){
                case "0":$mode="是";break;
                case "1":$mode="否";break;
                default:break;
            }
            $query_str="SELECT * FROM `t_l3f11faam_material_table` WHERE `stockname`='$name'";
            $temp=$mysqli->query($query_str);
            if(mysqli_num_rows($temp)>0){
                for($m=0;$m<mysqli_num_rows($temp);$m++){
                    $row=$temp->fetch_array();
                    //$id=$row["sid"];
                    $bucket=$row["bucketnum"];
                    $price=$row["totalprice"];
                    $date=$row["operatime"];
                    array_push($table,(string)$id);
                    array_push($table,(string)$i);
                    array_push($table,$name);
                    array_push($table,$mode);
                    array_push($table,(string)$bucket);
                    array_push($table,(string)$price);
                    array_push($table,$date);
                    array_push($table,$address);
                    array_push($material["TableData"],$table);
                }
            }
            else{
                $bucket=0;
                $price=0;
                $date="尚未使用";
                array_push($table,(string)$id);
                array_push($table,(string)$i);
                array_push($table,$name);
                array_push($table,$mode);
                array_push($table,(string)$bucket);
                array_push($table,(string)$price);
                array_push($table,$date);
                array_push($table,$address);
                array_push($material["TableData"],$table);
            }
            $i=$i+1;
        }
        $mysqli->close();
        return $material;
    }
    //显示一条仓库的信息
    public function dbi_faam_get_material_stock_detail($body){
        $ID=$body["stockID"];
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $query_str="SELECT * FROM `t_l3f11faam_material_stocksheet` WHERE `sid`='$ID'";
        $temp=$mysqli->query($query_str);
        while(($temp!=false)&&($row=$temp->fetch_array())>0){
            $result=array( 'storageID'=> $row["sid"], 'mode'=> $row["isself"], 'localStorage'=> '50', 'maxStorage'=> '100',);
        }
        $mysqli->close();
        return $result;
    }
    //原料入库
    public function dbi_faam_material_stock_income_new($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        date_default_timezone_set("PRC");
        $ID=$body["storageID"];
        $bucket=(integer)$body["bucket"];
        $price=(integer)$body["price"];
        $vendor=$body["vendor"];//供应商
        $buyer=$body["buyer"];//购买人员
        $mobile=$body["mobile"];//购买人员手机
        $time=date("Y-m-d H:i:s",time());
        $query_name="SELECT * FROM `t_l3f11faam_material_stocksheet` WHERE `sid`='$ID'";
        $temp_name=$mysqli->query($query_name);
        while(($temp_name!=false)&&($row_name=$temp_name->fetch_array())>0){
            $stock_name=$row_name["stockname"];
            $query_table="SELECT * FROM `t_l3f11faam_material_table` WHERE `stockname`='$stock_name'";
            $temp_table=$mysqli->query($query_table);
            if(mysqli_num_rows($temp_table)>0){
                for($i=0;$i<mysqli_num_rows($temp_table);$i++){
                    $row_table=$temp_table->fetch_array();
                    $total_bucket=$bucket+(integer)$row_table["bucketnum"];
                    $total_price=$price+(integer)$row_table["totalprice"];

                }
                $query_table="UPDATE `t_l3f11faam_material_table` SET `bucketnum`='$total_bucket',`totalprice`='$total_price',`operatime`='$time'WHERE `stockname`='$stock_name'";
            }
            else{
                $query_table="INSERT INTO `t_l3f11faam_material_table`(`stockname`,`bucketnum`,`totalprice`,`operatime`) VALUES ('$stock_name','$bucket','$price','$time')";
            }
            $mysqli->query($query_table);
            $query_str="INSERT INTO `t_l3f11faam_material_history`(`stockid`,`stockname`, `into`, `bucketnum`, `price`, `vendor`, `charge`, `mobile`, `time`) VALUES ('$ID','$stock_name','1','$bucket','$price','$vendor','$buyer','$mobile','$time')";
            $result=$mysqli->query($query_str);
        }
        $mysqli->close();
        return $result;
    }
    //原料出库
    public function dbi_faam_material_stock_remova_new($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        date_default_timezone_set("PRC");
        $result="";
        $ID=$body["storageID"];
        $bucket=(integer)$body["bucket"];
        $price=(integer)$body["price"];
        $trunk=$body["trunk"];//车牌号
        $driver=$body["driver"];//购买人员
        $mobile=$body["mobile"];//购买人员手机
        $target=$body["target"];//收货单位
        $logistics=$body["logistics"];
        $time=date("Y-m-d H:i:s",time());
        $query_name="SELECT * FROM `t_l3f11faam_material_stocksheet` WHERE `sid`='$ID'";
        $temp_name=$mysqli->query($query_name);
        if(mysqli_num_rows($temp_name)>0) {
            while (($temp_name != false) && ($row_name = $temp_name->fetch_array()) > 0) {
                $stock_name = $row_name["stockname"];
                $query_table = "SELECT * FROM `t_l3f11faam_material_table` WHERE `stockname`='$stock_name'";
                $temp_table = $mysqli->query($query_table);
                while (($temp_table != false) && ($row_table = $temp_table->fetch_array()) > 0) {
                    if ($bucket <= (integer)$row_table["bucketnum"]) {
                        $total_bucket = $row_table["bucketnum"] - $bucket;
                        $total_price = $row_table["totalprice"] + $price;
                        $query_table = "UPDATE `t_l3f11faam_material_table` SET `bucketnum`='$total_bucket',`totalprice`='$total_price',`operatime`='$time'WHERE `stockname`='$stock_name'";
                        $mysqli->query($query_table);
                        $query_str = "INSERT INTO `t_l3f11faam_material_history`(`stockid`,`stockname`, `into`, `bucketnum`, `price`, `charge`, `mobile`, `trunk`, `target`, `logistics`, `time`)VALUES ('$ID','$stock_name','0','$bucket','$price','$driver','$mobile','$trunk','$target','$logistics','$time')";
                        $result = $mysqli->query($query_str);
                    }
                    else{
                        $result="";
                    }
                }
            }
        }
        else{
            $result="";
        }
        $mysqli->close();
        return $result;
    }
    //原料出入库历史
    public function dbi_faam_material_stock_history($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        date_default_timezone_set("PRC");
        $timeEnd=date("Y-m-d",time());
        $history["ColumnName"]=array();
        $history["TableData"]=array();
        array_push($history["ColumnName"],"序号");
        array_push($history["ColumnName"],"仓库名");
        array_push($history["ColumnName"],"入库/出库");
        array_push($history["ColumnName"],"桶数");
        array_push($history["ColumnName"],"费用");
        array_push($history["ColumnName"],"供应商");
        array_push($history["ColumnName"],"购买者/司机");
        array_push($history["ColumnName"],"手机号");
        array_push($history["ColumnName"],"车牌号");
        array_push($history["ColumnName"],"收货单位");
        array_push($history["ColumnName"],"物流");
        array_push($history["ColumnName"],"时间");
        $ID=$body["StockID"];
        $day=$body["Period"];
        $keyWord=trim($body["KeyWord"]);
        switch($day){
            case "1":$timeStart=$timeEnd;break;;
            case "7":$timeStart=date('Y-m-d', strtotime("-6 day"));break;
            case "30":$timeStart=date('Y-m-d',strtotime("-29 day"));break;
            case "all":$timeStart="0000-00-00";
            default;break;
        }
        $timeStart=$timeStart." 00:00:00";
        $timeEnd=$timeEnd." 23:59:59";
        if($ID=="all"){
            if($keyWord==""){
                $query_str="SELECT * FROM `t_l3f11faam_material_history` WHERE `time`>='$timeStart' AND `time`<='$timeEnd'";
            }
            else
                $query_str="SELECT * FROM `t_l3f11faam_material_history` WHERE `time`>='$timeStart' AND `time`<='$timeEnd' AND `charge`LIKE'%$keyWord%'";
        }
        else{
            $query_name="SELECT * FROM `t_l3f11faam_material_stocksheet` WHERE `sid`='$ID'";
            $temp_name=$mysqli->query($query_name);
            while(($temp_name!=false)&&($row_name=$temp_name->fetch_array())>0){
                $name=$row_name["stockname"];
                if($keyWord==""){
                    $query_str="SELECT * FROM `t_l3f11faam_material_history` WHERE `time`>='$timeStart' AND `time`<='$timeEnd' AND `stockname`='$name'";
                }
                else
                    $query_str="SELECT * FROM `t_l3f11faam_material_history` WHERE `time`>='$timeStart' AND `time`<='$timeEnd' AND `charge`LIKE'%$keyWord%' AND `stockname`='$name'";
            }
        }
        $temp=$mysqli->query($query_str);
        $i=1;
        while(($temp!=false)&&($row=$temp->fetch_array())>0){
            $empty=array();
            $stock_name=$row["stockname"];
            $query_empty="SELECT * FROM `t_l3f11faam_material_stocksheet` WHERE `stockname`='$stock_name'";
            if(mysqli_num_rows($mysqli->query($query_empty))>0){
                array_push($empty,(string)$row["sid"]);
            }
            else
                array_push($empty,"");
            if($row["into"]=="1"){
                array_push($empty,$i);
                array_push($empty,$row["stockname"]);
                array_push($empty,"入库");
                array_push($empty,$row["bucketnum"]);
                array_push($empty,$row["price"]);
                array_push($empty,$row["vendor"]);
                array_push($empty,$row["charge"]);
                array_push($empty,$row["mobile"]);
                array_push($empty,"----");
                array_push($empty,"----");
                array_push($empty,"----");
                array_push($empty,$row["time"]);
            }
            else{
                array_push($empty,(string)$i);
                array_push($empty,$row["stockname"]);
                array_push($empty,"出库");
                array_push($empty,(string)$row["bucketnum"]);
                array_push($empty,(string)$row["price"]);
                array_push($empty,"----");
                array_push($empty,$row["charge"]);
                array_push($empty,$row["mobile"]);
                array_push($empty,$row["trunk"]);
                array_push($empty,$row["target"]);
                array_push($empty,$row["logistics"]);
                array_push($empty,$row["time"]);
            }
            array_push($history["TableData"],$empty);
            $i=$i+1;
        }
        return $history;
    }
    //显示一条原料历史的信息
    public function dbi_faam_get_material_stock_history_detail($body){
        $ID=$body["removalID"];
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $query_str="SELECT * FROM `t_l3f11faam_material_history` WHERE `sid`='$ID'";
        $temp=$mysqli->query($query_str);
        $result=array();
        while(($temp!=false)&&($row=$temp->fetch_array())>0){
            if($row["into"]==1){
                $result=array("type"=>"0","storageID"=>$row["stockid"],'materialMode'=>(string)(rand(0,1)),"bucket"=>$row["bucketnum"],
                "price"=>$row["price"],"buyer"=>$row["charge"],"vendor"=>$row["vendor"],"mobile"=>$row["mobile"]);
            }
            else{
                $result=array("type"=>"1","storageID"=>$row["stockid"],"materialMode"=>(string)(rand(0,1)),"bucket"=>$row["bucketnum"],
                    "price"=>$row["price"],"trunk"=>$row["trunk"],"driver"=>$row["charge"],"mobile"=>$row["mobile"],"target"=>$row["target"],
                "logistics"=>$row["logistics"]);
            }
        }
        $mysqli->close();
        return $result;
    }
    //更新一条入库数据
    public function dbi_faam_material_stock_income_mod($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        date_default_timezone_set("Asia/Shanghai");
        $time=date("Y-m-d H:i:s",time());
        $result="";
        $incomeID=$body["incomeID"];
        $storageID=$body["storageID"];
        $bucket=(integer)$body["bucket"];
        $price=(integer)$body["price"];
        $vendor=$body["vendor"];
        $buyer=$body["buyer"];
        $mobile=$body["mobile"];
        $query_middle="SELECT * FROM `t_l3f11faam_material_history` WHERE `sid`='$incomeID'";
        $temp_middle=$mysqli->query($query_middle);
        if(mysqli_num_rows($temp_middle)>0){
            while(($temp_middle!=false)&&($row_middle=$temp_middle->fetch_array())>0){
                $name=$row_middle['stockname'];
                $query_table="SELECT * FROM `t_l3f11faam_material_table` WHERE `stockname`='$name'";
                $temp_table=$mysqli->query($query_table);
                while(($temp_table!=false)&&($row_table=$temp_table->fetch_array())>0){
                    $bucket_number=$row_table["bucketnum"]-$row_middle["bucketnum"]+$bucket;
                    $price_total=$row_table["totalprice"]-$row_middle["price"]+$price;
                    if($bucket_number>=0){
                        $update_table="UPDATE `t_l3f11faam_material_table` SET `bucketnum`='$bucket_number',`totalprice`='$price_total',`operatime`='$time' WHERE `stockname`='$name'";
                        $mysqli->query($update_table);
                        $update_history="UPDATE `t_l3f11faam_material_history` SET `bucketnum`='$bucket',`price`='$price',`vendor`='$vendor',`charge`='$buyer',`mobile`='$mobile',`time`='$time' WHERE `sid`='$incomeID'";
                        $result=$mysqli->query($update_history);
                    }
                }
            }
        }
        $mysqli->close();
        return $result;
    }
    //更新一条出库信息
    public function dbi_faam_material_stock_remova_mod($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        date_default_timezone_set("Asia/Shanghai");
        $time=date("Y-m-d H:i:s",time());
        $result="";
        $incomeID=$body["removalID"];
        $storageID=$body["storageID"];
        $bucket=(integer)$body["bucket"];
        $price=(integer)$body["price"];
        $trunk=$body["trunk"];
        $driver=$body["driver"];
        $mobile=$body["mobile"];
        $target=$body["target"];
        $logistics=$body["logistics"];
        $query_middle="SELECT * FROM `t_l3f11faam_material_history` WHERE `sid`='$incomeID'";
        $temp_middle=$mysqli->query($query_middle);
        if(mysqli_num_rows($temp_middle)>0){
            while(($temp_middle!=false)&&($row_middle=$temp_middle->fetch_array())>0){
                $name=$row_middle['stockname'];
                $query_table="SELECT * FROM `t_l3f11faam_material_table` WHERE `stockname`='$name'";
                $temp_table=$mysqli->query($query_table);
                while(($temp_table!=false)&&($row_table=$temp_table->fetch_array())>0){
                    $bucket_number=$row_table["bucketnum"]+$row_middle["bucketnum"]-$bucket;
                    $price_total=$row_table["totalprice"]-$row_middle["price"]+$price;
                    if($bucket_number>=0){
                        $update_table="UPDATE `t_l3f11faam_material_table` SET `bucketnum`='$bucket_number',`totalprice`='$price_total',`operatime`='$time' WHERE `stockname`='$name'";
                        $mysqli->query($update_table);
                        $update_history="UPDATE `t_l3f11faam_material_history` SET `bucketnum`='$bucket',`price`='$price',`charge`='$driver',`mobile`='$mobile',`trunk`='$trunk',`target`='$target',`logistics`='$logistics',`time`='$time' WHERE  `sid`='$incomeID'";
                        $result=$mysqli->query($update_history);
                    }
                }
            }
        }
        $mysqli->close();
        return $result;
    }
    //删除一条信息,暂时认为删除信息就是这条信息录入错误，且不去修改直接作废，所以就是将这条入库或出库信息还原掉
    public function dbi_faam_material_stock_removal_del($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $ID=$body["removalID"];
        date_default_timezone_set("Asia/Shanghai");
        $time=date("Y-m-d H:i:s",time());
        $result="";
        $query_select="SELECT * FROM `t_l3f11faam_material_history` WHERE `sid`='$ID'";
        $temp_select=$mysqli->query($query_select);
        while(($temp_select!=false)&&($row_select=$temp_select->fetch_array())>0){
            $name=$row_select["stockname"];
            $into=$row_select["into"];
            $bucket=(integer)$row_select["bucketnum"];
            //$price=$row_select["price"];
            $query_table="SELECT * FROM `t_l3f11faam_material_table` WHERE `stockname`='$name'";
            $temp_table=$mysqli->query($query_table);
            if($into=='1'){
                while(($temp_table!=false)&&($row_table=$temp_table->fetch_array())>0){
                    $price_table=(integer)$row_table["totalprice"]-(integer)$row_select["price"];
                    $number=(integer)$row_table["bucketnum"];
                    if($number>=$bucket){
                        $bucket_number=$number-$bucket;
                        $query_str="DELETE FROM `t_l3f11faam_material_history` WHERE `sid`='$ID'";
                        $mysqli->query($query_str);
                        $query_str="UPDATE `t_l3f11faam_material_table` SET `bucketnum`='$bucket_number',`totalprice`='$price_table',`operatime`='$time' WHERE `stockname`='$name'";
                        $result=$mysqli->query($query_str);
                    }
                    else
                        $result="";
                }
            }
            else{
                while(($temp_table!=false)&&($row_table=$temp_table->fetch_array())>0){
                    $price_table=(integer)$row_table["totalprice"]-(integer)$row_select["price"];
                    $number=(integer)$row_table["bucketnum"];
                    $bucket_number=$number+$bucket;
                    $query_str="DELETE FROM `t_l3f11faam_material_history` WHERE `sid`='$ID'";
                    $mysqli->query($query_str);
                    $query_str="UPDATE `t_l3f11faam_material_table` SET `bucketnum`='$bucket_number',`totalprice`='$price_table',`operatime`='$time' WHERE `stockname`='$name'";
                    $result=$mysqli->query($query_str);
                }
            }
        }
        $mysqli->close();
        return $result;
    }
    //更新成品出库的信息，成品的数量更新需要先判断仓库中的剩余量是否还够，若够才可进行更新，其余的数据更新不需要判断。
    public function dbi_faam_product_stock_removal_mod($body){
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $result="";
        $mysqli->query("SET NAMES utf8");
        date_default_timezone_set("Asia/Shanghai");
        $time=date("Y-m-d H:i:s",time());
        $removalID=$body["removalID"];
        $size=$body["size"];
        $number=(integer)$body["number"];
        $container=$body["container"];
        $trunk=$body["trunk"];
        $mobile=$body["mobile"];
        $driver=$body["driver"];
        $target=$body["target"];
        $logistics=$body["logistics"];
        switch($size){
            case "特级":$size="A";break;
            case "一级":$size="1";break;
            case "二级":$size="2";break;
            case "三级":$size="3";break;
            case "混合":$size="S";break;
            default:break;
        }
        $query_name="SELECT * FROM `t_l3f11faam_products_out` WHERE `sid`='$removalID'";
        $temp_name=$mysqli->query($query_name);
        while(($temp_name!=false)&&($row_name=$temp_name->fetch_array())>0){
            $stock_name=$row_name["stockname"];
            $product_weight=$row_name["productweight"];
            $product_size=$row_name["productsize"];
            $product_num=$row_name["productnum"];
            $num=$row_name["number"];
            $query_into="SELECT * FROM `t_l3f11faam_products_into` WHERE `stockname`='$stock_name' AND `productweight`='$product_weight' AND `productsize`='$product_size' AND `productnum`='$product_num'";
            $temp_into=$mysqli->query($query_into);
            while(($temp_into!=false)&&($row_into=$temp_into->fetch_array())>0){
                $total_num=$row_into["number"]+$num-$number;
                if($total_num>=0){
                    $query_out_update="UPDATE `t_l3f11faam_products_out` SET `number`='$number',`containernumber`='$container',`platenumber`='$trunk',`drivername`='$driver',`driverpho`='$mobile',`receivingunit`='$target',`logisticsunit`='$logistics',`outtime`='$time' WHERE `sid`='$removalID'";
                    $mysqli->query($query_out_update);
                    $query_into_update="UPDATE `t_l3f11faam_products_into` SET `number`='$total_num'WHERE `stockname`='$stock_name' AND `productweight`='$product_weight' AND `productsize`='$product_size' AND `productnum`='$product_num'";
                    $result=$mysqli->query($query_into_update);
                }
            }
        }
        $mysqli->close();
        return $result;
    }
    //成品数据删除，删除掉的成品的箱数需要还原到入库表中
    public function dbi_faam_product_stock_removal_del($body){
        $removalID=$body["removalID"];
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
        if(!$mysqli){
            die("Could not connect:".mysqli_error($mysqli));
        }
        $result="";
        $mysqli->query("SET NAMES utf8");
        $query_name="SELECT * FROM `t_l3f11faam_products_out` WHERE `sid`='$removalID'";
        $temp_name=$mysqli->query($query_name);
        while(($temp_name!=false)&&($row_name=$temp_name->fetch_array())>0) {
            $stock_name=$row_name["stockname"];
            $product_weight=$row_name["productweight"];
            $product_size=$row_name["productsize"];
            $product_num=$row_name["productnum"];
            $num=$row_name["number"];
            $query_into="SELECT * FROM `t_l3f11faam_products_into` WHERE `stockname`='$stock_name' AND `productweight`='$product_weight' AND `productsize`='$product_size' AND `productnum`='$product_num'";
            $temp_into=$mysqli->query($query_into);
            while(($temp_into!=false)&&($row_into=$temp_into->fetch_array())>0) {
                $total_num = $row_into["number"] + $num;
                if ($total_num >= 0) {
                    $query_out_update = "DELETE FROM `t_l3f11faam_products_out` WHERE `sid`='$removalID'";
                    $mysqli->query($query_out_update);
                    $query_into_update = "UPDATE `t_l3f11faam_products_into` SET `number`='$total_num'WHERE `stockname`='$stock_name' AND `productweight`='$product_weight' AND `productsize`='$product_size' AND `productnum`='$product_num'";
                    $result = $mysqli->query($query_into_update);
                }
            }
        }
        $mysqli->close();
        return $result;
    }
    //入库记录删除，删除掉的入库记录中的数据需返还给原数据库
//    public function  dbi_faam_material_stock_income_del($body){
//        $removalID=$body["incomeID"];
//        $mysqli=new mysqli(MFUN_CLOUD_DBHOST,MFUN_CLOUD_DBUSER,MFUN_CLOUD_DBPSW,MFUN_CLOUD_DBNAME_L1L2L3,MFUN_CLOUD_DBPORT);
//        if(!$mysqli){
//            die("Could not connect:".mysqli_error($mysqli));
//        }
//        $result="";
//        $mysqli->query("SET NAMES utf8");
//        $query_name="SELECT * FROM `t_l3f11faam_products_out` WHERE `sid`='$removalID'";
//        $temp_name=$mysqli->query($query_name);
//        while(($temp_name!=false)&&($row_name=$temp_name->fetch_array())>0) {
//            $stock_name=$row_name["stockname"];
//            $product_weight=$row_name["productweight"];
//            $product_size=$row_name["productsize"];
//            $product_num=$row_name["productnum"];
//            $num=$row_name["number"];
//            $query_into="SELECT * FROM `t_l3f11faam_products_into` WHERE `stockname`='$stock_name' AND `productweight`='$product_weight' AND `productsize`='$product_size' AND `productnum`='$product_num'";
//            $temp_into=$mysqli->query($query_into);
//            while(($temp_into!=false)&&($row_into=$temp_into->fetch_array())>0) {
//                $total_num = $row_into["number"] + $num;
//                if ($total_num >= 0) {
//                    $query_out_update = "DELETE FROM `t_l3f11faam_products_out` WHERE `sid`='$removalID'";
//                    $mysqli->query($query_out_update);
//                    $query_into_update = "UPDATE `t_l3f11faam_products_into` SET `number`='$total_num'WHERE `stockname`='$stock_name' AND `productweight`='$product_weight' AND `productsize`='$product_size' AND `productnum`='$product_num'";
//                    $result = $mysqli->query($query_into_update);
//                }
//            }
//        }
//        $mysqli->close();
//        return $result;
//    }
    /*****************************自己更改终止处*************************************/
}
?>