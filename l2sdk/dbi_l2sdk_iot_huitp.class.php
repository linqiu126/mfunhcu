<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2017/2/26
 * Time: 23:09
 */

class classDbiL2sdkHuitp
{
    public function dbi_huitp_huc_socketid_update($devcode, $socketid)
    {
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "UPDATE `t_l2sdk_iothcu_inventory` SET `socketid` = '$socketid' WHERE (`devcode` = '$devcode')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }





}

?>