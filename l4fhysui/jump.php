<?php
include_once "../l3appl/fum1sym/dbi_l3apl_f1sym.class.php";

function check_session($s){

    $uiDbObj = new classDbiL3apF1sym();
    $usrinfo =$uiDbObj->dbi_session_check($s);
    return $usrinfo;
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