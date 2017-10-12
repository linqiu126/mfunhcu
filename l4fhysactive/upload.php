<?php
    include_once "../l1comvm/vmlayer.php";
    header("Content-type:text/html;charset=utf-8");

	$devCode= $_REQUEST["id"];
	$upload_path="../../avorion/upload/";
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
      if(is_array($elem)){
        foreach($elem as $k=>$v){
          $na[_urlencode($k)] = _urlencode($v);
        }
        return $na;
      }
      return urlencode($elem);
    }
	$num=count($_FILES['file-zh']['name']);

    //获取设备对应的站点编号
    $dbiL2sdkIotcomObj = new classDbiL2sdkIotcom();
    $statCode = $dbiL2sdkIotcomObj->dbi_hcuDevice_valid_device($devCode); //FromUserName对应每个HCU硬件的设备编号

	if(!file_exists($upload_path.$statCode)) {mkdir($upload_path.$statCode.'/',0777,true);}
	for($i=0;$i<$num;$i++)
	{

        if($_FILES['file-zh']['name'][$i]!=''&&is_uploaded_file($_FILES['file-zh']['tmp_name'][$i]))
        {
          $fname=$upload_path.$statCode.'/'.(string)(time()).$_FILES['file-zh']['name'][$i];
          $result = move_uploaded_file($_FILES['file-zh']['tmp_name'][$i],$fname);
          $retval=array(
                'status'=>"true",
                'msg'=>$_FILES['file-zh']['name'][$i].' Upload success!'
          );
          $jsonencode = (_encode($retval));
          echo $jsonencode;
        }else{
          $retval=array(
                'status'=>"false",
                'msg'=>$_FILES['file-zh']['name'][$i].' Upload fail!'
          );
          $jsonencode = (_encode($retval));
          echo $jsonencode;
        }
	}
?>