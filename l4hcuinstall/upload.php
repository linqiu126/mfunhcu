<?php
	$devcode= $_REQUEST["id"];
	$upload_path="../avorion/upload/";
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

    $dbiL2sdkIotcomObj = new classDbiL2sdkIotcom();
    $statcode = $dbiL2sdkIotcomObj->dbi_hcuDevice_valid_device($devcode);

    $num=count($_FILES['file-zh']['name']);   //�����ϴ��ļ��ĸ���
    if(!file_exists('./upload/'.$statcode)) {mkdir('./upload/'.$statcode.'/',0777,true);}
	for($i=0;$i<$num;$i++)
	{

        if($_FILES['file-zh']['name'][$i]!=''&&is_uploaded_file($_FILES['file-zh']['tmp_name'][$i]))
        {
          $fname=$upload_path.$statcode."/".$statcode.(string)(time()).$_FILES['file-zh']['name'][$i];
          move_uploaded_file($_FILES['file-zh']['tmp_name'][$i],$fname);
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