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
            $sid=$row['sid'];
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
        return $result;
    }
    //耗材信息删除
    public function dbi_faam_consumables_purchase_del($body){
        //建立连接
        date_default_timezone_set("PRC");
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $sid=$body["consumablespurchaseID"];
        $query_str = "DELETE FROM `t_l3f11faam_buy_suppliessheet`WHERE `sid`='$sid'";
        $result=$mysqli->query($query_str);
        return $result;
    }
    /*public function dbi_faam_attendance_record_modify($uid, $record)
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
    }*/
    /*****************************自己更改终止处*************************************/
}

?>