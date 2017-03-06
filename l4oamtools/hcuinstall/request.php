<?php

//include_once "../../l1comvm/vmlayer.php";
header("Content-type:text/html;charset=utf-8");
function _getfilecounts($ff){
    if(!file_exists($ff)) return 0;
    $handle = opendir($ff);
    $i=0;
    while(false !== $file=(readdir($handle))){
        if($file !== "." && $file!=".."){
            $i++;
        }
    }
    return $i;
}
function _encode($arr)
{
  $na = array();
  foreach ( $arr as $k => $value ) {
    $na[_urlencode($k)] = _urlencode ($value);
  }
  return addcslashes(urldecode(json_encode($na)),"\r\n");
}

function _urlencode($elem)
{
  if(is_array($elem)&&(!(empty($elem)))){
    foreach($elem as $k=>$v){
      $na[_urlencode($k)] = _urlencode($v);
    }
    return $na;
  }
  if(is_array($elem)&&empty($elem)){
	  return $elem;
  }
  return urlencode($elem);
}
$request_body = file_get_contents('php://input');
//echo $request_body;
$payload = json_decode($request_body,true);
//echo $payload;
$key=$payload["action"];
//echo $key;
switch ($key)
{
    case "HCU_Lock_Activate": //Open a lock
        $body=$payload["body"];
        $devcode=$body["code"];
        $latitude=$body["latitude"];
        $longitude=$body["longitude"];
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $result = $uiF3dmDbObj->dbi_siteinfo_update_gps($devcode, $latitude, $longitude);

        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $log_content = "R:Latitude=".$latitude.";Longitude=".$longitude."Result=".$result;
        $loggerObj->logger("MFUN_TASK_ID_L4OAMTOOLS", "HCU_Lock_Activate", $log_time, $log_content);

        $ret_stat = "false";
        $pic_num=_getfilecounts('./upload/'.$devcode.'/');
        if($pic_num>=2 AND $result==true) $ret_stat = "true";
        $retval=array(
            'status'=>$ret_stat,
            'auth'=>'true',
            'msg'=>'站点激活，照片上传成功'
        );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;
	default:
	    break;
}


?>