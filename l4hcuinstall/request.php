<?php
/**
 * Created by PhpStorm.
 * User: LZH
 * Date: 2017/03/02
 * Time: 12:16
 */

include_once "../l1comvm/vmlayer.php";
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
        $latitude=(string)($body["latitude"]*1000000);
        $longitude=(string)($body["longitude"]*1000000);
        $dbiL3apF2cmObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $result = $dbiL3apF2cmObj->dbi_siteinfo_update_gps($devcode, $latitude, $longitude);

        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $log_content = $devcode."R:Latitude=".$latitude.";Longitude=".$longitude."Result=".$result;
        $loggerObj->logger("MFUN_TASK_ID_L4OAMTOOLS", "HCU_Lock_Activate", $log_time, $log_content);

        $pic_num=_getfilecounts(MFUN_HCU_SITE_PIC_BASE_DIR.$devcode.'/'); //查询该站点是否上传照片
        //已经上传超过2张照片
        if($pic_num>=2 AND $result==true)
            $retval=array('status'=>'true','auth'=>'true','msg'=>'站点激活，照片上传成功');
        else
            $retval=array('status'=>'false','auth'=>'true','msg'=>'站点未激活');

        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;
	default:
	    break;
}


?>