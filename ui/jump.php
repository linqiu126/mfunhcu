<?php

include_once "../database/db_ui.class.php";
function check_session($s){

    $uiDbObj = new class_ui_db();
    $usrinfo =$uiDbObj->db_session_check($s);
    return $usrinfo;
    /*
	if($s == "1234567"){
        return "admin";
    }
    if($s == "7654321"){
        return "user";
    }
    return "";
    */
}

$session=$_GET["session"];

$if_jump = check_session($session);

if($if_jump!=""){
	$filename = "./scope.html";
    $handle = fopen($filename, "r");
    $contents = fread($handle, filesize ($filename));
    fclose($handle);
	echo $contents;
}else{
	$filename = "./Login.html";
    $handle = fopen($filename, "r");
    $contents = fread($handle, filesize ($filename));
    fclose($handle);
	echo $contents;
}
?>