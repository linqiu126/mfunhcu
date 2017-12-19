<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/19
 * Time: 15:36
 */
include_once "../l1comvm/vmlayer.php";

//L4FAAM的入口起点
//这里的入参格式是跟前端界面商量约定好的
if (isset($_GET["action"])){
    require("../l1mainentry/h5ui_entry_faam.php");
}
?>