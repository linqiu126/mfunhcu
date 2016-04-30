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

//导出数据库
// 105:      * 添加任务
// 107:      * @param string $tasktype 任务的类型：“import”|“export”。导入任务：“import”；导出任务：“export”。
// 108:      * @param string $dbtype 数据库的类型：“mysql”|“kvdb”。目前只支持“mysql”。
// 109:      * @param stirng $stor_domain 存放导入/导出文件的storage的domain名称。
// 110:      * @param stirng $stor_filename 导入/导出文件名称，格式：prefix[.format][.compression]，例：abc.csv.zip，服务根据format来判断数据类型，数据类型包括sql、csv。
// 111:      * @param stirng $dbname 导入/导出数据库的名称。
// 112:      * @param stirng $tbname 导入/导出数据库类型为mysql时，使用的表名。
// 113:      * @param stirng $callbackurl 任务成功时，调用的回调url，只支持应用默认版本中的url，为空时，不执行回调url。
// 114:      * @return mix 成功返回任务id，失败返回false。<br />
// 115:      * 注意：每天最多可执行10个任务。更多说明请查看文档中心。
// 118:      public function addTask($tasktype,$dbtype,$stor_domain,$stor_filename,$dbname,$tbname,$callbackurl,$ignore_errors=true){
// 119:             $this->_errno=SAE_Success;
// 120:             $this->_errmsg="OK";
// 121: 
// 122:         $tt=array('import','export');
// 123:         $dt=array('mysql');
// 124: 
// 125:         $tasktype=trim($tasktype);
// 126:         if(!in_array($tasktype,$tt)){
// 127:             $this->setError("tasktype");
// 128:             return false;
// 129:         }
// 130:         $dbtype=trim($dbtype);
// 131:         if(!in_array($dbtype,$dt)){
// 132:             $this->setError("dbtype");
// 133:             return false;
// 134:         }
// 135: 
// 136:         $sf=trim($stor_filename);
// 137:         if(empty($sf)){
// 138:             $this->setError("stor filename");
// 139:             return false;
// 140:         }
// 141:         $dm=trim($stor_domain);
// 142:         if(empty($dm)){
// 143:             $this->setError("stor domain");
// 144:             return false;
// 145:         }
// 146:         $md=trim($dbname);
// 147:         if(empty($md)){
// 148:             $this->setError("mysql database");
// 149:             return false;
// 150:         }
// 151: 
// 152:         $task=array('function'=>'add','tasktype'=>$tasktype,'dbtype'=>$dbtype,'stor_domain'=>$dm,'stor_filename'=>$sf,'dbname'=>$md,'tbname'=>$tbname,'callback'=>$callbackurl,'from'=>'api');
// 153:         if($ignore_errors === false) {
// 154:             $task['ignore_errors'] = 'false';
// 155:         }
// 156:         $ary=$this->postData($task);
// 157:         //return $ary;
// 158:         if($ary[0]==0){
// 159:             $taskid=$ary[2];
// 160:             return $taskid;
// 161:         }
// 162:         else{
// 163:             $this->_errno=$ary[0];
// 164:             $this->_errmsg=$ary[1];
// 165:             return false;
// 166:         }
// 167:     }

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