<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 20:14
 */
include_once "../l1comvm/vmlayer.php";
include_once "../l2sdk/dbi_l2sdk_iot_wx.class.php";

/*


 */



class classDbiL2sdkIotWx
{
    //构造函数
    public function __construct()
    {

    }

    public function dbi_fhys_wechatkey_unbind($openid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE `hwcode` = '$openid'";
        $resp = $mysqli->query($query_str);
        if (($resp != false) && ($resp->num_rows)>0)
        {
            while($row = $resp->fetch_array()) {
                $keyid = $row['keyid'];
                //删除该微信钥匙对应的所有授权
                $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE `keyid` = '$keyid'";
                $result = $mysqli->query($query_str);
            }
            //删除该微信绑定的所有虚拟钥匙
            $query_str = "DELETE FROM `t_l3f2cm_fhys_keyinfo` WHERE `hwcode` = '$openid'";
            $result = $mysqli->query($query_str);
        }
        else
            $result = false;

        $mysqli->close();
        return $result;
    }


}//End of class_wx_db

?>