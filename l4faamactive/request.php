<?php
header("Content-type:text/html;charset=utf-8");

include_once "../l1comvm/vmlayer.php";

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
if (isset($payload["action"])) $key = $payload["action"]; else $key = "";
if (isset($payload["body"])) $body = $payload["body"]; else $body = "";

$loggerObj = new classApiL1vmFuncCom();
$project = MFUN_PRJ_HCU_FAAMWX;

$loggerObj->mylog($project,$session,"MFUN_TASK_ID_L4FAAM_WECHAT","MFUN_TASK_ID_L4FAAM_WECHAT","XXXX",$request_body);


//echo $key;
switch ($key){
    case "XH_QRcode_Session_enable":
        if (isset($body["session"])) $session = trim($body["session"]); else $session = "";

        if(!empty($session)){
            $loggerObj->mylog($project,$session,"MFUN_TASK_ID_L4FAAM_WECHAT","MFUN_TASK_ID_L4FAAM_WECHAT","XH_QRcode_Session_enable",$session);
        }
        else{
            $loggerObj->mylog($project,$session,"MFUN_TASK_ID_L4FAAM_WECHAT","MFUN_TASK_ID_L4FAAM_WECHAT","XH_QRcode_Session_enable","Session id empty");
        }
        $temp=rand(1,100);
        if($temp<10){
            $retval=array(
              'status'=>'true',
              'auth'=>'false',
              "msg"=>"您没有登陆此二维码的权限"
            );
        }else{
            $retval=array(
              'status'=>'true',
              'auth'=>'true',
              "msg"=>""
            );
        }

        $jsonencode = _encode($retval);
        echo $jsonencode; break;
    case "XH_QRcode_Get_User_info":
        if (isset($body["code"])) $wechat = trim($body["code"]); else $wechat = "";

        if(!empty($wechat)){
            $loggerObj->mylog($project,$wechat,"MFUN_TASK_ID_L4FAAM_WECHAT","MFUN_TASK_ID_L4FAAM_WECHAT","XH_QRcode_Get_User_info",$wechat);
        }
        else{
            $loggerObj->mylog($project,$wechat,"MFUN_TASK_ID_L4FAAM_WECHAT","MFUN_TASK_ID_L4FAAM_WECHAT","XH_QRcode_Get_User_info","Wechat code empty");
        }


        $user=array(
            'username'=> 'Liuzehong',
            'userid'=>'123123123'
        );
        $retval=array(
            'status'=>'true',
            'auth'=>'true',
            'ret'=>$user,
            'msg'=>""
        );

        $jsonencode = _encode($retval);
        echo $jsonencode; break;
    case "HCU_Wechat_Login": //Use Wechat to login the Server, response is the userID in system.
/*
     var body = {code : code};
     var map={
     action:"HCU_Wechat_Login",
     type:"query",
     body: body,
     user:"null"
     };
    * */
        $body=$payload["body"];
        $code = $body['code'];
        $openid = "12312312312312312312";
        if(!isset($openid)&&empty($openid)){ $openid="Not Autherized";}
        $user=array(
            'username'=> 'Liuzehong',
            'userid'=>'123123123'
        );
        $retval=array(
            'status'=>'true',
            'auth'=>'true',
            'ret'=>$user
        );

        $jsonencode = _encode($retval);
        echo $jsonencode; break;
    case "HCU_Lock_Query": //Query How many lock is autherized to user,response is a list of StatCode and Name and Location and so on
    /*
        var listreq = {
            action:"HCU_Lock_Query",
            type:"query",
            user:app_handle.getuser()
        }
    */
        $retlist =array();
        for($i=1;$i<20;$i++){
            $map= array(
                'statcode'=>'12312'.(string)$i,
                'lockname'=>'Lock['.(string)$i.']',
                'lockdetail'=>'xxxxx'.(string)$i.'sssss',
                'longitude'=>(string)$i,
                'latitude'=>(string)$i
            );
            array_push($retlist,$map);
        }
        $retval=array(
            'status'=>'true',
            'auth'=>'true',
            'msg'=>'',
            'ret'=>($retlist)
        );
        $jsonencode = _encode($retval);
        echo $jsonencode; break;
    case "HCU_Lock_Status": //Query A Lock status by statCode.
            $body=$payload["body"];
            $id=$payload["user"];
            $statcode=$body["statcode"];
            $temp = rand(0,10);
            $locked = 'true';
            if($temp == 5){
                $locked = 'false';
            }


            $retval=array(
                'status'=>'true',
                'auth'=>'true',
                'msg'=>'',
                'ret'=>$locked
            );
            $jsonencode = _encode($retval);
            echo $jsonencode; break;
    case "HCU_Lock_open": //Open a lock
            $body=$payload["body"];
            $id=$payload["user"];
            $statcode=$body["statcode"];
            $retval=array(
                'status'=>'true',
                'auth'=>'true',
                'msg'=>'123456'
            );
            $jsonencode = _encode($retval);
            echo $jsonencode; break;
    case "HCU_Get_Free_Station":

        $pointtable = array();
    	for($i=0;$i<20;$i++){

    	    $projcode = ($i)%14;
    		$temp = array(
    			'StatCode'=> (string)(($i+1)),
    			'StatName'=>"测量点".(string)($i),
    			'ProjCode'=> $projcode,
    			'ChargeMan'=>"用户".(string)($i),
    			'Telephone'=>"139139".(string)($i),
    			'Longitude'=>"121.0000",
    			'Latitude'=>"31.0000",
    			'Department'=>"单位".(string)($i),
    			'Address'=>"地址".(string)($i),
    			'Country'=>"区县".(string)($i),
    			'Street'=>"街镇".(string)($i),
    			'Square'=>"10000",
    			'ProStartTime'=>"2016-01-01",
    			'Stage'=>"备注".(string)($i)
    		);
    		array_push($pointtable,$temp);
    	}
        $retval=array(
            'status'=>'true',
            'ret'=>$pointtable,
            'auth'=>'true',
            'msg'=>'123456'
        );
        $jsonencode = _encode($retval);
        echo $jsonencode; break;
    case "ProjectList":
    	$projlist = array();
    	for($i=0;$i<14;$i++){
    		$temp = array(
    			'id'=> (string)($i),
    			'name'=> "项目".(string)$i
    		);
    		array_push($projlist,$temp);
    	}
    	$retval=array(
    		'status'=>'true',
    		'ret'=> $projlist,
    		'auth'=>'true',
    		'msg'=>''
    	);
    	$jsonencode = _encode($retval);
    	echo $jsonencode; break;
    case "HCU_Lock_close": //Close a lock
    case "HCU_Lock_Activate": //Open a lock
            $body=$payload["body"];
            $code=$body["code"];
            $ret_stat = "false";
            $i=_getfilecounts('./upload/'.$code.'/');
            if($i>=2) $ret_stat = "true";
            $retval=array(
                'status'=>$ret_stat,
                'auth'=>'true',
                'msg'=>'123456'
            );
            $jsonencode = _encode($retval);
            echo $jsonencode; break;
	default:
	break;
}


?>