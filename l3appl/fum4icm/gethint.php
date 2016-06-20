<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2016/2/25
 * Time: 10:57
 */

// 用名字来填充数组
$a[]="HCU_SH_0301";

//获得来自 URL 的 q 参数
$q=$_GET["q"];

//如果 q 大于 0，则查找数组中的所有提示
if (strlen($q) > 0)
{
    $hint="";
    for($i=0; $i<count($a); $i++)
    {
        if (strtolower($q)==strtolower(substr($a[$i],0,strlen($q))))
        {
            if ($hint=="")
            {
                $hint=$a[$i];
            }
            else
            {
                $hint=$hint." , ".$a[$i];
            }
        }
    }
}

// 如果未找到提示，则把输出设置为 "no suggestion"
// 否则设置为正确的值
if ($hint == "")
{
    $response="设备编号以HCU开头，目前只支持设备 HCU_SH_0301";
}
else
{
    $response=$hint;
}

//输出响应
echo $response;
?>