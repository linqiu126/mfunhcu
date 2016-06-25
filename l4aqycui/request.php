<?php
require_once "./dbi_l4aqyc_ui.class.php";
header("Content-type:text/html;charset=utf-8");
#require '/php/req.php';

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
    if(is_array($elem)&&(!empty($elem))){
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

$key=$_GET["action"];
$uiDbObj = new class_ui_db(); //初始化一个UI DB对象

//echo $key;
switch ($key)
{
    case "login":  //login message:
        //require data structure:
        //var map={
        //    action:"login",
        //    name:$("#Username_Input").val(),
        //    password:$("#Password_Input").val()
        //};
        //return data structure:
        //usrinfo={
        //  status:"true",
        //  text:"login successfully",
        //  key: "1234567",
        //  admin: "true"
        //};
        $user = trim($_GET["name"]);
        $pwd = trim($_GET["password"]);
        $userinfo =$uiDbObj->db_login_req($user, $pwd);
        $jsonencode = json_encode($userinfo);
        echo $jsonencode;
        break;

    case "UserInfo":    // get User Information after login
        //require data structure:
        /*var map={
                action:"UserInfo",
                session: session
                };*/
        //return data structure:
        /*var user = {
                    id:1234567,
                    name:"admin",
                    admin:true,
                    city: "上海"
                }*/
        //echo $key;
        $session = $_GET["session"];
        $userinfo =$uiDbObj->db_userinfo_req($session);

        if(!empty($userinfo))
            $retval=array(
                'status'=>'true',
                'ret'=>$userinfo
            );
        else
            $retval=array(
                'status'=>'false',
                'ret'=>null
            );
        $jsonencode = (_encode($retval));
        echo $jsonencode;
        break;

    case "ProjectPGList":  //Get the Project & Project Group list which will be use in user auth
        //require data structure:
        /*var map={
                  action:"ProjectPGList",
                  user:usr.id
              };*/
        //return data structure:
        /*var temp = {
          id: (i),
          name: "��Ŀ��"+i
          }
          proj_pg_list.push(temp);
          var retval={
          status:"true",
          ret: proj_pg_list
          };
          */
        $user = $_GET["user"];
        $proj_pg_list = $uiDbObj->db_all_projpglist_req();

        if(!empty($proj_pg_list))
            $retval=array(
                'status'=>'true',
                'ret'=>$proj_pg_list
            );
        else
            $retval=array(
                'status'=>'false',
                'ret'=>null
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "ProjectList":   //Get the Project list
        //require data structure:
        /*var map={
                  action:"ProjectList",
                  user:usr.id
              };*/
        //return data structure:
        /*          var temp = {
                    id: (i),
                    name: "��Ŀ��"+i
                }
                projlist.push(temp);
                var retval={
                    status:"true",
                    ret: projlist
                };*/
        $user = $_GET["user"];
        $projlist = $uiDbObj->db_all_projlist_req();

        if(!empty($projlist))
            $retval=array(
                'status'=>'true',
                'ret'=>$projlist
            );
        else
            $retval=array(
                'status'=>'false',
                'ret'=>null
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "UserNew": //Add new user
        //require data structure:
        /*var map={
            action:"UserNew",
                              name: user.name,
                              nickname: user.nickname,
                              password: user.password,
                              mobile: user.mobile,
                              mail: user.mail,
                              type: user.type,
                              memo: user.memo,
                              auth: auth
        };*/
        //return data structure:
        /*  var retval={
           status:"true",
           msg:""
        };*/

        $auth = array();
        if(isset($_GET["auth"]))
            $auth = $_GET["auth"];

        $userinfo =array(
            'name' => $_GET["name"],
            'nickname' => $_GET["nickname"],
            'password' => $_GET["password"],
            'mobile' => $_GET["mobile"],
            'mail' => $_GET["mail"],
            'type' => $_GET["type"],
            'memo' => $_GET["memo"],
            'auth' => $auth
        );

        $result = $uiDbObj->db_userinfo_new($userinfo);

        if($result == true){
            $retval=array(
                'status'=>'true',
                'msg'=>'用户新增成功'
            );
        }
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'用户新增失败'
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "UserMod":  //modify user
        //require data structure:
        /*var map={
            action:"UserMod",
            id: user.id,
            name: user.name,
            nickname: user.nickname,
            password: user.password,
            mobile: user.mobile,
            mail: user.mail,
            type: user.type,
            memo: user.memo,
            auth: auth
        };*/
        //return data structure:
        /*  var retval={
           status:"true",
           msg:""
        };*/

        $auth = array();
        if(isset($_GET["auth"]))
            $auth = $_GET["auth"];

        $userinfo =array(
            'id' =>$_GET["id"],
            'name' => $_GET["name"],
            'nickname' => $_GET["nickname"],
            'password' => $_GET["password"],
            'mobile' => $_GET["mobile"],
            'mail' => $_GET["mail"],
            'type' => $_GET["type"],
            'memo' => $_GET["memo"],
            'auth' => $auth
        );

        $result = $uiDbObj->db_userinfo_update($userinfo);

        if($result)
            $retval=array(
                'status'=>'true',
                'msg'=>'用户信息更新成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'用户信息更新失败'
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "UserDel": //Delete the user
        //require data structure:
        /*var map={
            action:"UserDel",
            id: id
        };*/
        //return data structure:
        /*  var retval={
           status:"true",
           msg:""
        };*/
        $uid = $_GET["id"];
        $result = $uiDbObj->db_userinfo_delete($uid);
        if($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'用户删除成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'用户删除失败'
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "UserTable": //查询所有用户信息表
        //require data structure:
        /*var map={
            action:"UserTable",
            startseq: start,
            length:length
        };
        //return data structure:
        /*  var temp = {
                                  id: (start+(i+1)),
                                  name: "username"+(start+i),
                                  nickname: "�û�"+(start+i),
                                  mobile: "139139"+(start+i),
                                  mail: "139139"+(start+i)+"@cmcc.com",
                                  type: type,
                                  date: "2016-01-01 12:12:12",
                                  memo: "��ע����"+(start+i)
                              }
                              usertable.push(temp);

                              var retval={
                                              status:"true",
                                              start: start,
                                              total: total,
                                              length:query_length,
                                              ret: usertable
                                          };*/

        $total = $uiDbObj->db_usernum_inqury();
        $query_length = (int)($_GET['length']);
        $start = (int)($_GET['startseq']);
        if($query_length> $total-$start)
        {$query_length = $total-$start;}

        $usertable = $uiDbObj->db_usertable_req($start, $query_length);
        if (!empty($usertable))
            $retval=array(
                'status'=>'true',
                'start'=> (string)$start,
                'total'=> (string)$total,
                'length'=>(string)$query_length,
                'ret'=> $usertable
            );
        else
            $retval=array(
                'status'=>'false',
                'start'=> null,
                'total'=> null,
                'length'=>null,
                'ret'=> null
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "UserProj":    // query project list belong to one user
        //require data structure:
        /*      var map={
              action:"UserProj",
              userid: user
          };
        //return data structure:
            var temp = {
                         id: (i+1),
                         name: "��Ŀ��"+i
                     }
                     userproj.push(temp);
                     var retval={
                                     status:"true",
                                     ret: userproj
                                 };*/

        $uid = $_GET["userid"];
        $userproj = $uiDbObj->db_user_projpglist_req($uid);
        if(!empty($userproj))
            $retval= array(
                'status'=>"true",
                'ret'=>$userproj
            );
        else
            $retval= array(
                'status'=>"true",
                'ret'=>""
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "PGTable":    // query project group table
        //require data structure:
        /*      var map={
            action:"PGTable",
            startseq: start,
            length:length,
            user:usr.id
        };
        //return data structure:
        var temp = {
                         PGCode: (start+(i+1)),
                         PGName:"��Ŀ��"+(start+i),
                         ChargeMan:"�û�"+(start+i),
                         Telephone:"139139"+(start+i),
                         Department:"��λ"+(start+i),
                         Address:"��ַ"+(start+i),
                         Stage:"��ע"+(start+i)
                     };
                     pgtable.push(temp);
                     var retval={
                                     status:"true",
                                     start: start,
                                     total: total,
                                     length:query_length,
                                     ret: pgtable
                                 };*/
        $total = $uiDbObj->db_all_pgnum_inqury();
        $query_length = (int)($_GET['length']);
        $start = (int)($_GET['startseq']);
        if($query_length> $total-$start)
        {$query_length = $total-$start;}

        $pgtable = $uiDbObj->db_all_pgtable_req($start, $query_length);

        if(!empty($pgtable))
            $retval=array(
                'status'=>'true',
                'start'=> (string)$start,
                'total'=> (string)$total,
                'length'=>(string)$query_length,
                'ret'=> $pgtable
            );
        else
            $retval=array(
                'status'=>'false',
                'start'=> null,
                'total'=> null,
                'length'=>null,
                'ret'=> null
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "PGNew":  //创建新的项目组
        //require data structure:
        /*      var map={
                    action:"PGNew",
                    PGCode: pg.PGCode,
                    PGName:pg.PGName,
                    ChargeMan:pg.ChargeMan,
                    Telephone:pg.Telephone,
                    Department:pg.Department,
                    Address:pg.Address,
                    Stage:pg.Stage,
                    Projlist: projlist,
                    user:usr.id
                };
        //return data structure:

        var retval={
                    status:"true",
                    msg:""
                };*/

        $projlist = array();
        if(isset($_GET["Projlist"]))
            $projlist = $_GET["Projlist"];

        $pginfo =array(
            'PGCode' => $_GET["PGCode"],
            'PGName' => $_GET["PGName"],
            'ChargeMan' => $_GET["ChargeMan"],
            'Telephone' => $_GET["Telephone"],
            'Department' => $_GET["Department"],
            'Address' => $_GET["Address"],
            'Stage' => $_GET["Stage"],
            'Projlist' => $projlist,
            'user' => $_GET["user"]
        );

        $result = $uiDbObj->db_pginfo_update($pginfo);
        if($result)
            $retval=array(
                'status'=>'true',
                'msg'=>'新建项目组成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'新建项目组失败'
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "PGMod":  //修改项目组信息
        //require data structure:
        /*      var map={
                    action:"PGMod",
                    PGCode: pg.PGCode,
                    PGName:pg.PGName,
                    ChargeMan:pg.ChargeMan,
                    Telephone:pg.Telephone,
                    Department:pg.Department,
                    Address:pg.Address,
                    Stage:pg.Stage,
                    Projlist: projlist,
                    user:usr.id
                };
        //return data structure:

        var retval={
                    status:"true",
                    msg:""
                };*/
        $projlist = array();
        if(isset($_GET["Projlist"]))
            $projlist = $_GET["Projlist"];

        $pginfo =array(
            'PGCode' => $_GET["PGCode"],
            'PGName' => $_GET["PGName"],
            'ChargeMan' => $_GET["ChargeMan"],
            'Telephone' => $_GET["Telephone"],
            'Department' => $_GET["Department"],
            'Address' => $_GET["Address"],
            'Stage' => $_GET["Stage"],
            'Projlist' => $projlist,
            'user' => $_GET["user"]
        );


        $result = $uiDbObj->db_pginfo_update($pginfo);
        if($result)
            $retval=array(
                'status'=>'true',
                'msg'=>'项目组信息修改成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'项目组信息修改失败'
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "PGDel":  //删除项目组信息
        //require data structure:
        /*
        var map={
           action:"PGDel",
           id: id,
           user:usr.id
        };
        //return data structure:
        var retval={
           status:"true",
           msg:""
        };*/
        $pgcode = $_GET["id"];
        $result = $uiDbObj->db_pginfo_delete($pgcode);
        if ($result)
            $retval=array(
                'status'=>'true',
                'msg'=>'成功删除一个项目组'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'删除一个项目组失败'
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "PGProj":    // 查询属于项目组的所有项目列表
        //require data structure:
        /*var map={
            action:"PGProj",
            id: pgid
        };
        //return data structure:
        var temp = {
        id: (i+1),
        name: "��Ŀ"+i
        }
        PGProj.push(temp);
        var retval={
        status:"true",
        ret: PGProj
        }*/
        $pgcode = $_GET['id'];
        $projlist = $uiDbObj->db_pg_projlist_req($pgcode);

        if(!empty($projlist))
            $retval=array(
                'status'=>'true',
                'ret'=> $projlist
            );
        else
            $retval=array(
                'status'=>'true',
                'ret'=> ""
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;
    case "ProjTable":    // query project table
        //require data structure:
        /*
        var map={
            action:"ProjTable",
            startseq: start,
            length:length,
            user:usr.id
        };
        //return data structure:
        var temp = {
        ProjCode: (start+(i+1)),
        ProjName:"��Ŀ"+(start+i),
        ChargeMan:"�û�"+(start+i),
         Telephone:"139139"+(start+i),
          Department:"��λ"+(start+i),
          Address:"��ַ"+(start+i),
          ProStartTime:"2016-01-01",
           Stage:"��ע"+(start+i)
        };
        projtable.push(temp);

        var retval={
                        status:"true",
                        start: start,
                        total: total,
                        length:query_length,
                        ret: projtable
                    };*/

        $total = $uiDbObj->db_all_projnum_inqury();
        $query_length = (int)($_GET['length']);
        $start = (int)($_GET['startseq']);
        if($query_length> $total-$start)
        {$query_length = $total-$start;}

        $projtable = $uiDbObj->db_all_projtable_req($start, $query_length);
        if(!empty($projtable))
            $retval=array(
                'status'=>'true',
                'start'=> (string)$start,
                'total'=> (string)$total,
                'length'=>(string)$query_length,
                'ret'=> $projtable
            );
        else
            $retval=array(
                'status'=>'false',
                'start'=> null,
                'total'=> null,
                'length'=> null,
                'ret'=> null
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "ProjNew": //创建新的项目信息
        //require data structure:
        /*
        var map={
            action:"ProjNew",
            ProjCode: project.ProjCode,
            ProjName:project.ProjName,
            ChargeMan:project.ChargeMan,
            Telephone:project.Telephone,
            Department:project.Department,
            Address:project.Address,
            ProStartTime:project.ProStartTime,
            Stage:project.Stage,
            user:usr.id
        };
        //return data structure:
        var retval={
                    status:"true",
                    msg:""
                };*/

        $sessionid = $_GET["user"];
        $projinfo =array(
            'ProjCode' => $_GET["ProjCode"],
            'ProjName' => $_GET["ProjName"],
            'ChargeMan' => $_GET["ChargeMan"],
            'Telephone' => $_GET["Telephone"],
            'Department' => $_GET["Department"],
            'Address' => $_GET["Address"],
            'ProStartTime' => $_GET["ProStartTime"],
            'Stage' => $_GET["Stage"]
        );

        $result = $uiDbObj->db_projinfo_update($projinfo);
        if ($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'新项目创建成功'
            );
        else
            $retval=array(
                'status'=>'true',
                'msg'=>'新项目创建失败'
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "ProjMod": //修改项目信息
        //require data structure:
        /*
        var map={
            action:"ProjMod",
            ProjCode: project.ProjCode,
            ProjName:project.ProjName,
            ChargeMan:project.ChargeMan,
            Telephone:project.Telephone,
            Department:project.Department,
            Address:project.Address,
            ProStartTime:project.ProStartTime,
            Stage:project.Stage,
            user:usr.id
        };
        //return data structure:
        var retval={
                    status:"true",
                    msg:""
                };*/
        $sessionid = $_GET["user"];
        $projinfo =array(
            'ProjCode' => $_GET["ProjCode"],
            'ProjName' => $_GET["ProjName"],
            'ChargeMan' => $_GET["ChargeMan"],
            'Telephone' => $_GET["Telephone"],
            'Department' => $_GET["Department"],
            'Address' => $_GET["Address"],
            'ProStartTime' => $_GET["ProStartTime"],
            'Stage' => $_GET["Stage"]
        );

        $result = $uiDbObj->db_projinfo_update($projinfo);
        if ($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'项目信息修改成功'
            );
        else
            $retval=array(
                'status'=>'true',
                'msg'=>'项目信息修改失败'
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "ProjDel":  //删除一个项目
        //require data structure:
        /*
       var map={
           action:"ProjDel",
           StatCode: StatCode,
           user:usr.id
       };
       //return data structure:
       var retval={
                       status:"true",
                       msg:""
                   };*/
        $projcode = $_GET["ProjCode"];

        $result = $uiDbObj->db_projinfo_delete($projcode);
        if ($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'成功删除一个项目'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'删除一个项目失败'
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "ProjPoint":   //查询所有监控点列表
        //require data structure:
        /*
        var map={
           action:"ProjPoint"
        };
        //return data structure:
        var temp = {
                       id: i+1,
                       name: "�۲��"+(i+1),
                       ProjCode: projcode
                   }
                   ProjPoint.push(temp);
        var retval={
                   status:"true",
                   ret: ProjPoint
               };    */

        $sitelist = $uiDbObj->db_all_sitelist_req();
        if(!empty($sitelist))
            $retval=array(
                'status'=>'true',
                'ret'=> $sitelist
            );
        else
            $retval=array(
                'status'=>'false',
                'ret'=> null
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "PointProj": //查询该项目下面对应监控点列表
        /*
        var map={
                action:"PointProj",
                ProjCode: ProjCode
            };*/
        $projcode = $_GET["ProjCode"];
        $sitelist = $uiDbObj->db_proj_sitelist_req($projcode);
        if(!empty($sitelist))
            $retval=array(
                'status'=>'true',
                'ret'=> $sitelist
            );
        else
            $retval=array(
                'status'=>'true',
                'ret'=> ""
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "PointTable":  //查询所有监控点信息
        //require data structure:
        /*
        var map={
            action:"PointTable",
            startseq: start,
            length:length,
            user:usr.id
        };
        };
        //return data structure:
        var temp = {
                        StatCode: (start+(i+1)),
                        StatName:"������"+(start+i),
                        ProjCode: projcode,
                        ChargeMan:"�û�"+(start+i),
                        Telephone:"139139"+(start+i),
                        Longitude:"121.0000",
                        Latitude:"31.0000",
                        Department:"��λ"+(start+i),
                        Address:"��ַ"+(start+i),
                        Country:"����"+(start+i),
                        Street:"����"+(start+i),
                        Square:"10000",
                        ProStartTime:"2016-01-01",
                        Stage:"��ע"+(start+i)
                    };
                    projtable.push(temp);
        var retval={
                    status:"true",
                    start: start,
                    total: total,
                    length:query_length,
                    ret: projtable
                };*/


        $total = $uiDbObj->db_all_sitenum_inqury();
        $query_length = (int)($_GET['length']);
        $start = (int)($_GET['startseq']);
        if($query_length> $total-$start)
        {$query_length = $total-$start;}
        $sitetable = $uiDbObj->db_all_sitetable_req($start, $query_length);
        if(!empty($sitetable))
            $retval=array(
                'status'=>'true',
                'start'=> (string)$start,
                'total'=> (string)$total,
                'length'=>(string)$query_length,
                'ret'=> $sitetable
            );
        else
            $retval=array(
                'status'=>'false',
                'start'=> null,
                'total'=> null,
                'length'=>null,
                'ret'=> null
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "PointDetail":
        //abandon
        break;
    case "PointNew":  //新建监测点
        //require data structure:
        /*var map={
              action:"PointNew",
              StatCode: point.StatCode,
              StatName:point.StatName,
              ProjCode: point.ProjCode,
              ChargeMan:point.ChargeMan,
              Telephone:point.Telephone,
              Longitude:point.Longitude,
              Latitude:point.Latitude,
              Department:point.Department,
              Address:point.Address,
              Country:point.Country,
              Street:point.Street,
              Square:point.Square,
              ProStartTime:point.ProStartTime,
              Stage:point.Stage,
              user:usr.id
          };
        //return data structure:
        var retval={
                    status:"true",
                    msg:""
                };*/

        $sessionid = $_GET["user"];
        $siteinfo =array(
            'StatCode' => $_GET["StatCode"],
            'StatName' => $_GET["StatName"],
            'ProjCode' => $_GET["ProjCode"],
            'ChargeMan' => $_GET["ChargeMan"],
            'Telephone' => $_GET["Telephone"],
            'Longitude' => $_GET["Longitude"],
            'Latitude' => $_GET["Latitude"],
            'Department' => $_GET["Department"],
            'Address' => $_GET["Address"],
            'Country' => $_GET["Country"],
            'Street' => $_GET["Street"],
            'Square' => $_GET["Square"],
            'ProStartTime' => $_GET["ProStartTime"],
            'Stage' => $_GET["Stage"]
        );
        $result = $uiDbObj->db_siteinfo_update($siteinfo);
        if ($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'新建监测点成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'新建监测点失败'
            );

        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;
    case "PointMod"://修改监测点信息
        //require data structure:
        /*var map={
              action:"PointMod",
              StatCode: point.StatCode,
              StatName:point.StatName,
              ProjCode: point.ProjCode,
              ChargeMan:point.ChargeMan,
              Telephone:point.Telephone,
              Longitude:point.Longitude,
              Latitude:point.Latitude,
              Department:point.Department,
              Address:point.Address,
              Country:point.Country,
              Street:point.Street,
              Square:point.Square,
              ProStartTime:point.ProStartTime,
              Stage:point.Stage,
              user:usr.id
          };
        //return data structure:
        var retval={
                    status:"true",
                    msg:""
                };*/
        $sessionid = $_GET["user"];
        $siteinfo =array(
            'StatCode' => $_GET["StatCode"],
            'StatName' => $_GET["StatName"],
            'ProjCode' => $_GET["ProjCode"],
            'ChargeMan' => $_GET["ChargeMan"],
            'Telephone' => $_GET["Telephone"],
            'Longitude' => $_GET["Longitude"],
            'Latitude' => $_GET["Latitude"],
            'Department' => $_GET["Department"],
            'Address' => $_GET["Address"],
            'Country' => $_GET["Country"],
            'Street' => $_GET["Street"],
            'Square' => $_GET["Square"],
            'ProStartTime' => $_GET["ProStartTime"],
            'Stage' => $_GET["Stage"]
        );
        $result = $uiDbObj->db_siteinfo_update($siteinfo);
        if ($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'新修改监测点成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'修改监测点失败'
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "PointDel":  //删除一个监测点
        //require data structure:
        /*
        var map={
            action:"PointDel",
            StatCode: StatCode,
            user:usr.id
        };
        //return data structure:
        var retval={
                        status:"true",
                        msg:""
                    };*/
        $statcode = $_GET["StatCode"];
        $result = $uiDbObj->db_siteinfo_delete($statcode);
        if ($result)
            $retval=array(
                'status'=>'true',
                'msg'=>'成功删除一个监测点'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'删除一个监测点失败'
            );

        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "PointDev": //查询监测点下的HCU设备列表
        //require data structure:
        /*
        var map={
            action:"PointDev",
            StatCode: StatCode
        };
        //return data structure:
        var temp = {
                        id: (i+1),
                        name: "�豸"+i
                    }
                    projdev.push(temp);
        var retval={
                    status:"true",
                    ret: projdev
                };*/
        $statcode = $_GET['StatCode'];
        $devlist = $uiDbObj->db_site_devlist_req($statcode);
        if(!empty($devlist))
            $retval=array(
                'status'=>"true",
                'ret'=> $devlist
            );
        else
            $retval=array(
                'status'=>"true",
                'ret'=> ""
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "DevTable": //查询HCU设备列表信息
        //require data structure:
        /*
        var map={
            action:"DevTable",
            startseq: start,
            length:length,
            user:usr.id
        };
        //return data structure:
        var temp = {
                        //�豸��� DevCode
                        //������ StatCode
                        //��װʱ�� StartTime
                        //Ԥ�ƽ���ʱ�� PreEndTime
                        //ʵ�ʽ���ʱ�� EndTime
                        //�豸�Ƿ���� DevStatus
                        //��Ƶ��ַ VideoURL
                        DevCode: (start+(i+1)),
                        StatCode:statcode,
                        ProjCode: projcode,
                        StartTime:"2016-01-01",
                        PreEndTime:"2017-01-01",
                        EndTime:"2099-12-31",
                        DevStatus:true,
                        VideoURL:"www.tokoyhot.com"
                    };
                    projtable.push(temp);
                    var retval={
                                    status:"true",
                                    start: start,
                                    total: total,
                                    length:query_length,
                                    ret: projtable
                                };*/


        $total = $uiDbObj->db_all_hcunum_inqury();
        $query_length = (int)($_GET["length"]);
        $start = (int)($_GET["startseq"]);
        if($query_length> $total-$start)
        {$query_length = $total-$start;}
        $devtable = $uiDbObj->db_all_hcutable_req($start,$query_length);
        if(!empty($devtable))
            $retval=array(
                'status'=>'true',
                'start'=> (string)$start,
                'total'=> (string)$total,
                'length'=>(string)$query_length,
                'ret'=> $devtable
            );
        else
            $retval=array(
                'status'=>'false',
                'start'=> null,
                'total'=> null,
                'length'=>null,
                'ret'=> null
            );

        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "DevNew":  //创建新的HCU信息
        //require data structure:
        /*var map={
              action:"DevNew",
              DevCode: device.DevCode,
              StatCode:device.StatCode,
              StartTime:device.StartTime,
              PreEndTime:device.PreEndTime,
              EndTime:device.EndTime,
              DevStatus:device.DevStatus,
              VideoURL:device.VideoURL,
              user:usr.id
          };
        //return data structure:
                var retval={
                                status:"true",
                                msg:""
                            };*/
        $sessionid = $_GET["user"];
        $devinfo =array(
            'DevCode' => $_GET["DevCode"],
            'StatCode' => $_GET["StatCode"],
            'StartTime' => $_GET["StartTime"],
            'PreEndTime' => $_GET["PreEndTime"],
            'EndTime' => $_GET["EndTime"],
            'DevStatus' => $_GET["DevStatus"],
            'VideoURL' => $_GET["VideoURL"]
        );
        $result = $uiDbObj->db_devinfo_update($devinfo);
        if ($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'新增监测设备成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'新增监测设备失败'
            );

        $retval=array(
            'status'=>'true',
            'msg'=>''
        );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "DevMod": //修改监测设备信息
        //require data structure:
        /*var map={
              action:"DevMod",
              DevCode: device.DevCode,
              StatCode:device.StatCode,
              StartTime:device.StartTime,
              PreEndTime:device.PreEndTime,
              EndTime:device.EndTime,
              DevStatus:device.DevStatus,
              VideoURL:device.VideoURL,
              user:usr.id
          };
        //return data structure:
                var retval={
                                status:"true",
                                msg:""
                            };*/
        $sessionid = $_GET["user"];
        $devinfo =array(
            'DevCode' => $_GET["DevCode"],
            'StatCode' => $_GET["StatCode"],
            'StartTime' => $_GET["StartTime"],
            'PreEndTime' => $_GET["PreEndTime"],
            'EndTime' => $_GET["EndTime"],
            'DevStatus' => $_GET["DevStatus"],
            'VideoURL' => $_GET["VideoURL"]
        );
        $result = $uiDbObj->db_devinfo_update($devinfo);
        if ($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'修改监测设备信息成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'修改监测设备信息失败'
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "DevDel":  //删除HCU设备
        //require data structure:
        /*
        var map={
            action:"DevDel",
            DevCode: DevCode,
            user:usr.id
        };
        //return data structure:
        var retval={
                        status:"true",
                        msg:""
                    };*/
        $devcode = $_GET["DevCode"];
        $result = $uiDbObj->db_deviceinfo_delete($devcode);
        if ($result)
            $retval=array(
                'status'=>'true',
                'msg'=>'删除HCU设备成功'
            );
        else
            $retval=array(
                'status'=>'true',
                'msg'=>'删除HCU设备失败'
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "DevAlarm":  //获取当前的测量值，如果测量值超出范围，提示告警
        //require data structure:
        /*
        var map={
                    action:"DevAlarm",
                    StatCode: monitor_selected.StatCode
                };
        //return data structure:
        var map1 = {
                        AlarmName: "扬尘",
                        AlarmEName: "Dust",  <= 图标映射
                        AlarmValue:GetRandomNum(10,110),
                        AlarmUnit:"DB",
                        WarningTarget:"false"
                    };
                    alarmlist.push(map1);
                    var retval={
                                    status:"true",
                                    ret:alarmlist
                                };*/
        /*
                $alarmlist= array();
                $map1 = array(
                    'AlarmName'=>"噪声",
                    'AlarmEName'=> "Noise",
                    'AlarmValue'=>(string)rand(10,110),
                    'AlarmUnit'=>"DB",
                    'WarningTarget'=>"false"
                );
                array_push($alarmlist,$map1);
                $map2 = array(
                    'AlarmName'=>"风向",
                    'AlarmEName'=> "WD",
                    'AlarmValue'=>(string)rand(1,100),
                    'AlarmUnit'=>"mg/m3",
                    'WarningTarget'=>"false"
                );
                array_push($alarmlist,$map2);
                $map3 = array(
                    'AlarmName'=>"湿度",
                    'AlarmEName'=> "Wet",
                    'AlarmValue'=>(string)rand(1,100),
                    'AlarmUnit'=>"%",
                    'WarningTarget'=>"false"
                );
                array_push($alarmlist,$map3);
                $map4 = array(
                    'AlarmName'=>"温度",
                    'AlarmEName'=> "Temperature",
                    'AlarmValue'=>(string)rand(10,50),
                    'AlarmUnit'=>"C",
                    'WarningTarget'=>"false"
                );
                array_push($alarmlist,$map4);
                $map5 = array(
                    'AlarmName'=>"细颗粒物",
                    'AlarmEName'=> "PM",
                    'AlarmValue'=>(string)rand(10,400),
                    'AlarmUnit'=>"ug/m3",
                    'WarningTarget'=>"false"
                );
                array_push($alarmlist,$map5);
                $map6 = array(
                    'AlarmName'=>"录像",
                    'AlarmEName'=> "VCR",
                    'AlarmValue'=>(string)rand(10,150),
                    'AlarmUnit'=>"菌群",
                    'WarningTarget'=>"false"
                );
                array_push($alarmlist,$map6);
                $map7 = array(
                    'AlarmName'=>"GPS",
                    'AlarmEName'=> "GPS",
                    'AlarmValue'=>(string)rand(10,30),
                    'AlarmUnit'=>"ug/L",
                    'WarningTarget'=>"false"
                );
                array_push($alarmlist,$map7);
                $map8 = array(
                    'AlarmName'=>"风速",
                    'AlarmEName'=> "WS",
                    'AlarmValue'=>(string)rand(10,150),
                    'AlarmUnit'=>"km/h",
                    'WarningTarget'=>"false"
                );
                array_push($alarmlist,$map8);
        */

        $statcode =$_GET["StatCode"];

        $alarmlist = $uiDbObj->db_dev_currentvalue_req($statcode);
        if(!empty($alarmlist))
            $retval=array(
                'status'=>'true',
                'ret'=> $alarmlist
            );
        else
            $retval=array(
                'status'=>'false',
                'ret'=> null
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "MonitorList":      // get monitorList in map by user id
        //require data structure:
        /*
        var map={
            action:"MonitorList",
            id: usr.id
        };
        //return data structure:
        var map18={
                        StatCode:"120101020",
                        StatName:"�ٸ۳�Ͷ����",
                        ChargeMan:"����",
                        Telephone:"13912345678",
                        Department:"",
                        Address:"������һ·333��",
                        Country:"�ֶ�����",
                        Street:"",
                        Square:"0",
                        Flag_la:"N",
                        Latitude:"30.900796",
                        Flag_lo:"E",
                        Longitude:"121.933166",
                        ProStartTime:"2015-11-30",
                        Stage:""
                    };
                    stat_list.push(map18);
                    var retval={
                        status:"true",
                        id: userid,
                        ret: stat_list
                    };*/
        $uid = $_GET["id"];
        $stat_list = $uiDbObj->db_map_sitetinfo_req($uid);
        if(!empty($stat_list))
            $retval=array(
                'status'=>'true',
                'id'=>$uid,
                'ret'=> $stat_list
            );
        else
            $retval=array(
                'status'=>'false',
                'id'=>$uid,
                'ret'=> null
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "AlarmQuery": //查询一个监测点历史告警数据 minute/hour/day
        //require data structure:
        /*var map={
                action:"AlarmQuery",
                id: usr.id,
                StatCode: alarm_selected.StatCode,
                date: date,
                type:type
            };
           //return data structure:
            var minute_alarm = new Array();
             var minute_head = new Array();
                        for(var i=0;i<(60*24);i++){
                            minute_alarm.push(GetRandomNum(10,110));
                            minute_head.push((string)i);
                        }
                        var hour_alarm = new Array();
                        var hour_head = new Array();
                        for(var i=0;i<(7*24);i++){
                            hour_alarm.push(GetRandomNum(10,110));
                            hour_head.push((string)i);
                        }
                        var day_alarm = new Array();
                        var day_head = new Array();
                        for(var i=0;i<30;i++){
                            day_alarm.push(GetRandomNum(10,110));
                            day_head.push((string)i);
                        }

                        var retval={
                            status:"true",
                            StatCode: StatCode,
                            date: date,
                            AlarmName: AlarmName,
                            AlarmUnit: AlarmUnit,
                            WarningTarget:WarningTarget,
                            minute_alarm: minute_alarm,
                            hour_alarm: hour_alarm,
                            day_alarm: day_alarm
                        };*/
        $user = $_GET["id"];
        $statcode = $_GET["StatCode"];
        $query_date = $_GET["date"];
        $query_type = $_GET["type"];
        $result = $uiDbObj->db_dev_alarmhistory_req($statcode, $query_date, $query_type);

        if(!empty($result))
            $retval= array(
                'status'=>"true",
                'StatCode'=> $statcode,
                'date'=> $query_date,
                'AlarmName'=> $result["alarm_name"],
                'AlarmUnit'=> $result["alarm_unit"],
                'WarningTarget'=>$result["warning"],
                'minute_head'=>$result["minute_head"],
                'minute_alarm'=> $result["minute_alarm"],
                'hour_head'=>$result["hour_head"],
                'hour_alarm'=> $result["hour_alarm"],
                'day_head'=>$result["day_head"],
                'day_alarm'=> $result["day_alarm"]
            );
        else
            $retval= array(
                'status'=>"false",
                'StatCode'=> $statcode,
                'date'=> $query_date,
                'AlarmName'=> $query_type,
                'AlarmUnit'=> null,
                'WarningTarget'=> null,
                'minute_head'=> null,
                'minute_alarm'=> null,
                'hour_head'=> null,
                'hour_alarm'=> null,
                'day_head'=> null,
                'day_alarm'=> null
            );

        $jsonencode = json_encode($retval,JSON_UNESCAPED_UNICODE);
        echo $jsonencode;
        break;

    case "AlarmType":  //获取所有传感器类型
        //require data structure:
        /*
        var map={
            action:"AlarmType"
        };
        //return data structure:
        var map = {
                        id:0,
                        name:"����"
                    }
                    ret.push(map);
        ret.push(map);
                    var retval={
                        status:"true",
                        typelist: ret
                    };*/
        $alarm_type = $uiDbObj->db_all_alarmtype_req();
        if(!empty($alarm_type))
            $retval=array(
                'status'=>'true',
                'typelist'=> $alarm_type
            );
        else
            $retval=array(
                'status'=>'false',
                'typelist'=> null
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "TableQuery":
        // input tablename =>string
        // condition =>array
        // every condition
        /*
                ConditonName: "AlarmDate",
                Equal:"",
                GEQ:end_date,
                LEQ:start_date*/

        //$Condition = $_GET["Condition"];
        //$Filter = $_GET["Filter"];

        $tablename = $_GET["TableName"];
        $condition = array();
        if(isset($_GET["Condition"]))
            $condition = $_GET["Condition"];

/*
        $column = 16;
        $row = 40;
        $column_name = array();
        $row_content = array();
        for( $i=0;$i<$column;$i++){
            array_push($column_name,"第".(string)($i+1)."列");
        }
        for($i=0;$i<$row;$i++){
            $one_row = array();
            array_push($one_row,(string)($i+1));
            array_push($one_row,"备注".(string)($i+1));
            for($j=0;$j<($column-6);$j++) array_push($one_row,rand(10,110));

            //one_row.push("地址"+(i+1)+"xxxxx路"+(i+1)+"xxxxx号");
            array_push($one_row,"地址".((string)($i+1))."xxxxx路".((string)($i+1))."xxxxx号");
            //one_row.push("测试");
            array_push($one_row,"测试");
            //one_row.push("名称");
            array_push($one_row,"名称");
            //one_row.push("长数据长数据长数据"+(i+1)+"xxxxx路"+(i+1)+"xxxxx号");
            array_push($one_row,"长数据长数据长数据".((string)($i+1))."xxxxx路".((string)($i+1))."xxxxx号");
            array_push($row_content,$one_row);
            //row_content.push(one_row);
        }
*/
        $result = $uiDbObj->db_excel_historydata_req($condition);
        if(!empty($result))
            $retval=array(
                'status'=>'true',
                'ColumnName' => $result["column"],
                'TableData' => $result["data"]
            );
        else
            $retval=array(
                'status'=>'false',
                'ColumnName' => null,
                'TableData' => null
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "SensorList":
        $sensor_list = $uiDbObj->db_all_sensorlist_req();
        if(!empty($sensor_list))
            $retval=array(
                'status'=>'true',
                'SensorList'=> $sensor_list
            );
        else
            $retval=array(
                'status'=>'false',
                'SensorList'=> null
            );
        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    case "DevSensor":
        $devcode = $_GET["DevCode"];
        $sensorinfo = $uiDbObj->db_dev_sensorinfo_req($devcode);

        if(!empty($sensorinfo))
            $retval=array(
                'status'=>'true',
                'ret'=>$sensorinfo
            );
        else
            $retval=array(
                'status'=>'false',
                'ret'=>null
            );

        $jsonencode = json_encode($retval,JSON_UNESCAPED_UNICODE);
        echo $jsonencode;
        break;

    case "SensorUpdate":
        $DevCode = $_GET["DevCode"];
        $SensorCode = $_GET["SensorCode"];
        $status = $_GET["status"];
        $ParaList = $_GET["ParaList"];
        $retval=array(
            'status'=>'true',
            'msg'=>''
        );
        $jsonencode = _encode($retval);
        echo $jsonencode; break;

    case "SetUserMsg":
        /*
                var usr = data.id;
                var Msg = data.msg;
                var ifdev = data.ifdev;
                var retval={
                    status:"true",
                    msg:""
                };*/
        $usr = $_GET["id"];
        $msg = $_GET["msg"];
        $ifdev = $_GET["ifdev"];
        $retval=array(
            'status'=>'true',
            'msg'=>''
        );
        $jsonencode = _encode($retval);
        echo $jsonencode; break;
    case "GetUserMsg":
        /*
            var usr = data.id;
            var retval={
                status:"true",
                msg:"您好，今天是xxxx号，欢迎领导前来视察，今天的气温是 今天的PM2.5是....",
                ifdev:"true"
            };*/
        $usr = $_GET["id"];
        $retval=array(
            'status'=>'true',
            'msg'=>'您好，今天是xxxx号，欢迎领导前来视察，今天的气温是 今天的PM2.5是....',
            'ifdev'=>"true"
        );
        $jsonencode = _encode($retval);
        echo $jsonencode; break;
    case "ShowUserMsg":
        /*
            var usr = data.id;
            var temp = GetRandomNum(1000,9999);
            var retval={
                    status:"true",
                    msg:temp+"您好，今天是"+temp+"号，欢迎领导前来视察，今天的气温是 今天的PM2.5是.xxx.yyy.zzz."
                };*/
        $usr = $_GET["id"];
        $StatCode = $_GET["StatCode"];
        $temp =(string)rand(1000,9999);
        $retval=array(
            'status'=>'true',
            'msg'=>$temp.'您好，今天是'.$temp.'号，欢迎领导前来视察，今天的气温是 今天的PM2.5是....'
        );

        $jsonencode = _encode($retval);
        echo $jsonencode; break;
    case "GetUserImg":
        /*
                    var usr = data.id;
                    var ImgList= new Array();
                    for(var i=1;i<6;i++){
                        var map={
                            name :"test"+i+".jpg",
                            url:"assets/img/test"+i+".jpg"
                        };
                        ImgList.push(map);
                    }
                    var retval={
                        status:"true",
                        img: ImgList
                    };*/
        $usr = $_GET["id"];
        $ImgList = array();
        for ($i=1;$i<6;$i++){
            $map = array(
                'name'=>"test".(string)$i.".jpg",
                'url'=>"assets/img/test".(string)$i.".jpg"
            );
            array_push($ImgList,$map);
        }
        $retval=array(
            'status'=>'true',
            'img'=>$ImgList
        );
        $jsonencode = _encode($retval);
        echo $jsonencode; break;
    case "ClearUserImg":
        /*
            var usr = data.id;
            var retval={
                status:"true"
            };*/
        $usr = $_GET["id"];
        $retval=array(
            'status'=>'true'
        );
        $jsonencode = _encode($retval);
        echo $jsonencode; break;
    case "GetStaticMonitorTable":  //查询测量点聚合信息
        /*
        var retval={
            status:"true",
            ColumnName: column_name,
            TableData:row_content
        };*/
        $sessionid = $_GET["id"];
        $uid = $uiDbObj->db_session_check($sessionid);

        $result = $uiDbObj->db_user_dataaggregate_req($uid);
        if(!empty($result))
            $retval=array(
                'status'=>'true',
                'ColumnName' => $result["column"],
                'TableData' => $result["data"]
            );
        else
            $retval=array(
                'status'=>'false',
                'ColumnName' => null,
                'TableData' => null
            );

        $jsonencode = _encode($retval);
        echo $jsonencode;
        break;

    default:
        break;
}


?>