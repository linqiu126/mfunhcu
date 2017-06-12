<?php
	$devcode= $_REQUEST["id"];
	$upload_path="../../avorion/";
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

    //建立连接
    $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
    if (!$mysqli) {
        die('Could not connect: ' . mysqli_error($mysqli));
    }
    $mysqli->query("SET NAMES utf8");
    $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `devcode` = '$devcode' ";
    $result = $mysqli->query($query_str);
    if (($result->num_rows)>0) {
        $row = $result->fetch_array();
        $statcode = $row['statcode'];
    }
    else
        $statcode = $devcode;



	$num=count($_FILES['file-zh']['name']);   //�����ϴ��ļ��ĸ���
	if(!file_exists('./'.$statcode.'/install')) {mkdir('./'.$statcode.'/install');}
	for($i=0;$i<$num;$i++)
	{

		   		if($_FILES['file-zh']['name'][$i]!=''&&is_uploaded_file($_FILES['file-zh']['tmp_name'][$i]))
		   		{
				  $fname=$upload_path.$statcode.'/install/'.(string)(time()).$_FILES['file-zh']['name'][$i];
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