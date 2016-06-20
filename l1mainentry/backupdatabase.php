<?php
/*
* created @2015/09/19 by QIU Lin
* backup MySQL database every 10 mins
*/
$dj = new SaeDeferredJob();

//添加任务，导入数据库
// $taskID=$dj->addTask("import","mysql","domainA","abc.sql","databaseA","tableA","callback.php");
// if($taskID===false)
//     var_dump($dj->errno(), $dj->errmsg());
// else
// var_dump($taskID);

$tasktype = "export";
$dbtype = "mysql";
$stor_domain = "backupdatabase";
$dbname = "app_mfuncard";
$tbname = null; 
//$tbname = null应该是选择全部表，需要试试
//$tbname = "loginfo";
date_default_timezone_set("Asia/Shanghai");
$my_t=getdate(date("U"));
$stor_filename = "$dbname-$my_t[year]-$my_t[mon]-$my_t[mday]-$my_t[hours]-$my_t[minutes]-$my_t[seconds].sql.zip";
//$stor_filename = "201509191321.sql.zip";
$callbackurl = null;
//$callbackurl = null 设置为null是否就不出错，要试试
//$callbackurl = "csv.php";
$ignore_errors = true;

$taskID=$dj->addTask($tasktype,$dbtype,$stor_domain,$stor_filename,$dbname,$tbname,$callbackurl, $ignore_errors);
if($taskID===false)
    var_dump($dj->errno(), $dj->errmsg());

// //获得任务状态
// $ret=$dj->getStatus($taskID);
// if($ret===false)
//     var_dump($dj->errno(), $dj->errmsg());

// //删除任务
// $ret=$dj->deleteTask($taskID);
// if($ret===false)
//     var_dump($dj->errno(), $dj->errmsg());

?>