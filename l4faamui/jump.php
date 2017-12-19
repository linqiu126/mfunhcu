<?php
include_once "../l3appl/fum1sym/dbi_l3apl_f1sym.class.php";

$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
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
    //echo "httphead:".$http_type;
    if($http_type == 'https://'){
        $contents = str_replace("http","https",$contents,$count);
        //echo "replace count:".$count;
    }
    echo $contents;
}else{
    $filename = "./login.html";
    $handle = fopen($filename, "r");
    $contents = fread($handle, filesize ($filename));
    fclose($handle);
    echo $contents;
}

?>