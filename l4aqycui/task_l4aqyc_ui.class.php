<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:47
 */
include_once "../l1comvm/vmlayer.php";
include_once "dbi_l4aqyc_ui.class.php";

class classTaskL4aqycUi
{
    //构造函数
    public function __construct()
    {

    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l4aqyc_ui_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L4AQYC_UI", "mfun_l4aqyc_ui_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L4AQYCUI，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L4AQYC_UI", "mfun_l4aqyc_ui_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        if (($msgId == MSG_ID_L4AQYCUI_CLICK_INCOMING) && (isset($msg)))
        {
            $resp = "";
            //这里是L4AQYC与L3APPL功能之间的交换矩阵，从而让UI对应的多种不确定组合变换为L3APPL确定的功能组合
            switch($msg)
            {
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
                case "login":  //login message:
                    if (isset($_GET["name"])) $name = trim($_GET["name"]); else $name = "";
                    if (isset($_GET["password"])) $pwd = trim($_GET["password"]); else $pwd = "";
                    $input = array("user" => $name, "pwd" => $pwd);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4AQYCUI_TO_L3F1_LOGIN, "MSG_ID_L4AQYCUI_TO_L3F1_LOGIN",$input);
                    break;

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
                case "UserInfo":    // get User Information after login
                    if (isset($_GET["session"])) $session = trim($_GET["session"]); else $session = "";
                    $input = array("session" => $session);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4AQYCUI_TO_L3F1_USERINFO, "MSG_ID_L4AQYCUI_TO_L3F1_USERINFO",$input);
                    break;

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
                case "UserNew": //Add new user
                    if (isset($_GET["name"])) $name = trim($_GET["name"]); else  $name = "";
                    if (isset($_GET["nickname"])) $nickname = trim($_GET["nickname"]); else  $nickname = "";
                    if (isset($_GET["password"])) $password = trim($_GET["password"]); else  $password = "";
                    if (isset($_GET["mobile"])) $mobile = trim($_GET["mobile"]); else  $mobile = "";
                    if (isset($_GET["mail"])) $mail = trim($_GET["mail"]); else  $mail = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else  $type = "";
                    if (isset($_GET["memo"])) $memo = trim($_GET["memo"]); else  $memo = "";
                    if (isset($_GET["auth"])) $auth = $_GET["auth"]; else  $auth = array();
                    $input = array("name" => $name, "nickname" => $nickname, "password" => $password, "mobile" => $mobile,
                        "mail" => $mail, "type" => $type, "memo" => $memo, "auth" => $auth);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4AQYCUI_TO_L3F1_USERNEW, "MSG_ID_L4AQYCUI_TO_L3F1_USERNEW",$input);
                    break;

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
                case "UserMod":  //modify user
                    if (isset($_GET["id"])) $id = trim($_GET["id"]); else  $id = "";
                    if (isset($_GET["name"])) $name = trim($_GET["name"]); else  $name = "";
                    if (isset($_GET["nickname"])) $nickname = trim($_GET["nickname"]); else  $nickname = "";
                    if (isset($_GET["password"])) $password = trim($_GET["password"]); else  $password = "";
                    if (isset($_GET["mobile"])) $mobile = trim($_GET["mobile"]); else  $mobile = "";
                    if (isset($_GET["mail"])) $mail = trim($_GET["mail"]); else  $mail = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else  $type = "";
                    if (isset($_GET["memo"])) $memo = trim($_GET["memo"]); else  $memo = "";
                    if (isset($_GET["auth"])) $auth = $_GET["auth"]; else  $auth = array();
                    $input = array("id" => $id, "name" => $name, "nickname" => $nickname, "password" => $password, "mobile" => $mobile,
                        "mail" => $mail, "type" => $type, "memo" => $memo, "auth" => $auth);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4AQYCUI_TO_L3F1_USERMOD, "MSG_ID_L4AQYCUI_TO_L3F1_USERMOD",$input);
                    break;

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
                case "UserDel": //Delete the user
                    if (isset($_GET["id"])) $id = trim($_GET["id"]); else  $id = "";
                    $input = array("id" => $id);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4AQYCUI_TO_L3F1_USERDEL, "MSG_ID_L4AQYCUI_TO_L3F1_USERDEL",$input);
                    break;

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
                case "UserTable": //查询所有用户信息表
                    if (isset($_GET["length"])) $length = trim($_GET["length"]); else  $length = "";
                    if (isset($_GET["startseq"])) $startseq = trim($_GET["startseq"]); else  $startseq = "";
                    $input = array("length" => $length, "startseq" => $startseq);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4AQYCUI_TO_L3F1_USERTABLE, "MSG_ID_L4AQYCUI_TO_L3F1_USERTABLE",$input);
                    break;

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
                case "ProjectPGList":  //Get the Project & Project Group list which will be use in user auth
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else  $user = "";
                    $input = array("user" => $user);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PROJECTPGLIST, "MSG_ID_L4AQYCUI_TO_L3F2_PROJECTPGLIST",$input);
                    break;

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
                case "ProjectList":   //Get the Project list
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else  $user = "";
                    $input = array("user" => $user);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PROJECTLIST, "MSG_ID_L4AQYCUI_TO_L3F2_PROJECTLIST",$input);
                    break;

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
                case "UserProj":    // query project list belong to one user
                    if (isset($_GET["userid"])) $userid = trim($_GET["userid"]); else  $userid = "";
                    $input = array("userid" => $userid);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_USERPROJ, "MSG_ID_L4AQYCUI_TO_L3F2_USERPROJ",$input);
                    break;

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
                case "PGTable":    // query project group table
                    if (isset($_GET["length"])) $length = trim($_GET["length"]); else  $length = "";
                    if (isset($_GET["startseq"])) $startseq = trim($_GET["startseq"]); else  $startseq = "";
                    $input = array("length" => $length, "startseq" => $startseq);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PGTABLE, "MSG_ID_L4AQYCUI_TO_L3F2_PGTABLE",$input);
                    break;

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
                case "PGNew":  //创建新的项目组
                    if (isset($_GET["PGCode"])) $PGCode = trim($_GET["PGCode"]); else  $PGCode = "";
                    if (isset($_GET["PGName"])) $PGName = trim($_GET["PGName"]); else  $PGName = "";
                    if (isset($_GET["ChargeMan"])) $ChargeMan = trim($_GET["ChargeMan"]); else  $ChargeMan = "";
                    if (isset($_GET["Telephone"])) $Telephone = trim($_GET["Telephone"]); else  $Telephone = "";
                    if (isset($_GET["Department"])) $Department = trim($_GET["Department"]); else  $Department = "";
                    if (isset($_GET["Address"])) $Address = trim($_GET["Address"]); else  $Address = "";
                    if (isset($_GET["Stage"])) $Stage = trim($_GET["Stage"]); else  $Stage = "";
                    if (isset($_GET["Projlist"])) $Projlist = $_GET["Projlist"]; else  $Projlist = array();
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else  $user = "";
                    $input = array("PGCode" => $PGCode, "PGName" => $PGName, "ChargeMan" => $ChargeMan, "Telephone" => $Telephone, "Department" => $Department,
                        "Address" => $Address, "Stage" => $Stage, "Projlist" => $Projlist, "user" => $user);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PGNEW, "MSG_ID_L4AQYCUI_TO_L3F2_PGNEW",$input);
                    break;

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

                case "PGMod":  //修改项目组信息
                    if (isset($_GET["PGCode"])) $PGCode = trim($_GET["PGCode"]); else  $PGCode = "";
                    if (isset($_GET["PGName"])) $PGName = trim($_GET["PGName"]); else  $PGName = "";
                    if (isset($_GET["ChargeMan"])) $ChargeMan = trim($_GET["ChargeMan"]); else  $ChargeMan = "";
                    if (isset($_GET["Telephone"])) $Telephone = trim($_GET["Telephone"]); else  $Telephone = "";
                    if (isset($_GET["Department"])) $Department = trim($_GET["Department"]); else  $Department = "";
                    if (isset($_GET["Address"])) $Address = trim($_GET["Address"]); else  $Address = "";
                    if (isset($_GET["Stage"])) $Stage = trim($_GET["Stage"]); else  $Stage = "";
                    if (isset($_GET["Projlist"])) $Projlist = $_GET["Projlist"]; else  $Projlist = array();
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else  $user = "";
                    $input = array("PGCode" => $PGCode, "PGName" => $PGName, "ChargeMan" => $ChargeMan, "Telephone" => $Telephone, "Department" => $Department,
                        "Address" => $Address, "Stage" => $Stage, "Projlist" => $Projlist, "user" => $user);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PGMOD, "MSG_ID_L4AQYCUI_TO_L3F2_PGMOD",$input);
                    break;

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
                case "PGDel":  //删除项目组信息
                    if (isset($_GET["id"])) $id = trim($_GET["id"]); else  $id = "";
                    $input = array("id" => $id);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PGDEL, "MSG_ID_L4AQYCUI_TO_L3F2_PGDEL",$input);
                    break;

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
                case "PGProj":    // 查询属于项目组的所有项目列表
                    if (isset($_GET["id"])) $id = trim($_GET["id"]); else  $id = "";
                    $input = array("id" => $id);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PGPROJ, "MSG_ID_L4AQYCUI_TO_L3F2_PGPROJ",$input);
                    break;


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
                case "ProjTable":    // query project table
                    if (isset($_GET["length"])) $length = trim($_GET["length"]); else  $length = "";
                    if (isset($_GET["startseq"])) $startseq = trim($_GET["startseq"]); else  $startseq = "";
                    $input = array("length" => $length, "startseq" => $startseq);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PROJTABLE, "MSG_ID_L4AQYCUI_TO_L3F2_PROJTABLE",$input);
                    break;

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
                case "ProjNew": //创建新的项目信息
                    if (isset($_GET["ProjCode"])) $ProjCode = trim($_GET["ProjCode"]); else  $ProjCode = "";
                    if (isset($_GET["ProjName"])) $ProjName = trim($_GET["ProjName"]); else  $ProjName = "";
                    if (isset($_GET["ChargeMan"])) $ChargeMan = trim($_GET["ChargeMan"]); else  $ChargeMan = "";
                    if (isset($_GET["Telephone"])) $Telephone = trim($_GET["Telephone"]); else  $Telephone = "";
                    if (isset($_GET["Department"])) $Department = trim($_GET["Department"]); else  $Department = "";
                    if (isset($_GET["Address"])) $Address = trim($_GET["Address"]); else  $Address = "";
                    if (isset($_GET["ProStartTime"])) $ProStartTime = trim($_GET["ProStartTime"]); else  $ProStartTime = "";
                    if (isset($_GET["Stage"])) $Stage = trim($_GET["Stage"]); else  $Stage = "";
                    $input = array("ProjCode" => $ProjCode, "ProjName" => $ProjName, "ChargeMan" => $ChargeMan, "Telephone" => $Telephone, "Department" => $Department,
                        "Address" => $Address, "ProStartTime" => $ProStartTime, "Stage" => $Stage);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PROJNEW, "MSG_ID_L4AQYCUI_TO_L3F2_PROJNEW",$input);
                    break;

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
                case "ProjMod": //修改项目信息
                    if (isset($_GET["ProjCode"])) $ProjCode = trim($_GET["ProjCode"]); else  $ProjCode = "";
                    if (isset($_GET["ProjName"])) $ProjName = trim($_GET["ProjName"]); else  $ProjName = "";
                    if (isset($_GET["ChargeMan"])) $ChargeMan = trim($_GET["ChargeMan"]); else  $ChargeMan = "";
                    if (isset($_GET["Telephone"])) $Telephone = trim($_GET["Telephone"]); else  $Telephone = "";
                    if (isset($_GET["Department"])) $Department = trim($_GET["Department"]); else  $Department = "";
                    if (isset($_GET["Address"])) $Address = trim($_GET["Address"]); else  $Address = "";
                    if (isset($_GET["ProStartTime"])) $ProStartTime = trim($_GET["ProStartTime"]); else  $ProStartTime = "";
                    if (isset($_GET["Stage"])) $Stage = trim($_GET["Stage"]); else  $Stage = "";
                    $input = array("ProjCode" => $ProjCode, "ProjName" => $ProjName, "ChargeMan" => $ChargeMan, "Telephone" => $Telephone, "Department" => $Department,
                        "Address" => $Address, "ProStartTime" => $ProStartTime, "Stage" => $Stage);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PROJMOD, "MSG_ID_L4AQYCUI_TO_L3F2_PROJMOD",$input);
                    break;

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
                case "ProjDel":  //删除一个项目
                    if (isset($_GET["ProjCode"])) $ProjCode = trim($_GET["ProjCode"]); else  $ProjCode = "";
                    $input = array("ProjCode" => $ProjCode);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_PROJDEL, "MSG_ID_L4AQYCUI_TO_L3F3_PROJDEL",$input);
                    break;

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
                case "ProjPoint":   //查询所有监控点列表
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else  $user = "";
                    $input = array("user" => $user);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_PROJPOINT, "MSG_ID_L4AQYCUI_TO_L3F3_PROJPOINT",$input);
                    break;

                /*
                var map={
                        action:"PointProj",
                        ProjCode: ProjCode
                    };*/
                case "PointProj": //查询该项目下面对应监控点列表
                    if (isset($_GET["ProjCode"])) $ProjCode = trim($_GET["ProjCode"]); else  $ProjCode = "";
                    $input = array("ProjCode" => $ProjCode);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_POINTPROJ, "MSG_ID_L4AQYCUI_TO_L3F3_POINTPROJ",$input);
                    break;

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
                case "PointTable":  //查询所有监控点信息
                    if (isset($_GET["length"])) $length = trim($_GET["length"]); else  $length = "";
                    if (isset($_GET["startseq"])) $startseq = trim($_GET["startseq"]); else  $startseq = "";
                    $input = array("length" => $length, "startseq" => $startseq);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_POINTTABLE, "MSG_ID_L4AQYCUI_TO_L3F3_POINTTABLE",$input);
                    break;

                case "PointDetail":
                    //abandon
                    break;

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
                case "PointNew":  //新建监测点
                    if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode = "";
                    if (isset($_GET["StatName"])) $StatName = trim($_GET["StatName"]); else  $StatName = "";
                    if (isset($_GET["ProjCode"])) $ProjCode = trim($_GET["ProjCode"]); else  $ProjCode = "";
                    if (isset($_GET["ChargeMan"])) $ChargeMan = trim($_GET["ChargeMan"]); else  $ChargeMan = "";
                    if (isset($_GET["Telephone"])) $Telephone = trim($_GET["Telephone"]); else  $Telephone = "";
                    if (isset($_GET["Longitude"])) $Longitude = trim($_GET["Longitude"]); else  $Longitude = "";
                    if (isset($_GET["Latitude"])) $Latitude = trim($_GET["Latitude"]); else  $Latitude = "";
                    if (isset($_GET["Department"])) $Department = trim($_GET["Department"]); else  $Department = "";
                    if (isset($_GET["Address"])) $Address = trim($_GET["Address"]); else  $Address = "";
                    if (isset($_GET["Country"])) $Country = trim($_GET["Country"]); else  $Country = "";
                    if (isset($_GET["Street"])) $Street = trim($_GET["Street"]); else  $Street = "";
                    if (isset($_GET["Square"])) $Square = trim($_GET["Square"]); else  $Square = "";
                    if (isset($_GET["ProStartTime"])) $ProStartTime = trim($_GET["ProStartTime"]); else  $ProStartTime = "";
                    if (isset($_GET["Stage"])) $Stage = trim($_GET["Stage"]); else  $Stage = "";
                    $input = array("StatCode" => $StatCode, "StatName" => $StatName, "ProjCode" => $ProjCode, "ChargeMan" => $ChargeMan, "Telephone" => $Telephone,
                        "Longitude" => $Longitude, "Latitude" => $Latitude, "Department" => $Department, "Address" => $Address, "Country" => $Country,
                        "Street" => $Street, "Square" => $Square, "ProStartTime" => $ProStartTime, "Stage" => $Stage);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_POINTNEW, "MSG_ID_L4AQYCUI_TO_L3F3_POINTNEW",$input);
                    break;

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
                case "PointMod"://修改监测点信息
                    if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode = "";
                    if (isset($_GET["StatName"])) $StatName = trim($_GET["StatName"]); else  $StatName = "";
                    if (isset($_GET["ProjCode"])) $ProjCode = trim($_GET["ProjCode"]); else  $ProjCode = "";
                    if (isset($_GET["ChargeMan"])) $ChargeMan = trim($_GET["ChargeMan"]); else  $ChargeMan = "";
                    if (isset($_GET["Telephone"])) $Telephone = trim($_GET["Telephone"]); else  $Telephone = "";
                    if (isset($_GET["Longitude"])) $Longitude = trim($_GET["Longitude"]); else  $Longitude = "";
                    if (isset($_GET["Latitude"])) $Latitude = trim($_GET["Latitude"]); else  $Latitude = "";
                    if (isset($_GET["Department"])) $Department = trim($_GET["Department"]); else  $Department = "";
                    if (isset($_GET["Address"])) $Address = trim($_GET["Address"]); else  $Address = "";
                    if (isset($_GET["Country"])) $Country = trim($_GET["Country"]); else  $Country = "";
                    if (isset($_GET["Street"])) $Street = trim($_GET["Street"]); else  $Street = "";
                    if (isset($_GET["Square"])) $Square = trim($_GET["Square"]); else  $Square = "";
                    if (isset($_GET["ProStartTime"])) $ProStartTime = trim($_GET["ProStartTime"]); else  $ProStartTime = "";
                    if (isset($_GET["Stage"])) $Stage = trim($_GET["Stage"]); else  $Stage = "";
                    $input = array("StatCode" => $StatCode, "StatName" => $StatName, "ProjCode" => $ProjCode, "ChargeMan" => $ChargeMan, "Telephone" => $Telephone,
                        "Longitude" => $Longitude, "Latitude" => $Latitude, "Department" => $Department, "Address" => $Address, "Country" => $Country,
                        "Street" => $Street, "Square" => $Square, "ProStartTime" => $ProStartTime, "Stage" => $Stage);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_POINTMOD, "MSG_ID_L4AQYCUI_TO_L3F3_POINTMOD",$input);
                    break;

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
                case "PointDel":  //删除一个监测点
                    if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode = "";
                    $input = array("StatCode" => $StatCode);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_POINTDEL, "MSG_ID_L4AQYCUI_TO_L3F3_POINTDEL",$input);
                    break;

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

                case "PointDev": //查询监测点下的HCU设备列表
                    if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode = "";
                    $input = array("StatCode" => $StatCode);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_POINTDEV, "MSG_ID_L4AQYCUI_TO_L3F3_POINTDEV",$input);
                    break;

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
                case "DevTable": //查询HCU设备列表信息
                    if (isset($_GET["length"])) $length = trim($_GET["length"]); else  $length = "";
                    if (isset($_GET["startseq"])) $startseq = trim($_GET["startseq"]); else  $startseq = "";
                    $input = array("length" => $length, "startseq" => $startseq);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_DEVTABLE, "MSG_ID_L4AQYCUI_TO_L3F3_DEVTABLE",$input);
                    break;

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
                case "DevNew":  //创建新的HCU信息
                    if (isset($_GET["DevCode"])) $DevCode = trim($_GET["DevCode"]); else  $DevCode = "";
                    if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode = "";
                    if (isset($_GET["StartTime"])) $StartTime = trim($_GET["StartTime"]); else  $StartTime = "";
                    if (isset($_GET["PreEndTime"])) $PreEndTime = trim($_GET["PreEndTime"]); else  $PreEndTime = "";
                    if (isset($_GET["EndTime"])) $EndTime = trim($_GET["EndTime"]); else  $EndTime = "";
                    if (isset($_GET["DevStatus"])) $DevStatus = trim($_GET["DevStatus"]); else  $DevStatus = "";
                    if (isset($_GET["VideoURL"])) $VideoURL = trim($_GET["VideoURL"]); else  $VideoURL = "";
                    $input = array("DevCode" => $DevCode, "StatCode" => $StatCode, "StartTime" => $StartTime, "PreEndTime" => $PreEndTime,
                        "EndTime" => $EndTime, "DevStatus" => $DevStatus, "VideoURL" => $VideoURL);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_DEVNEW, "MSG_ID_L4AQYCUI_TO_L3F3_DEVNEW",$input);
                    break;

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
                case "DevMod": //修改监测设备信息
                    if (isset($_GET["DevCode"])) $DevCode = trim($_GET["DevCode"]); else  $DevCode = "";
                    if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode = "";
                    if (isset($_GET["StartTime"])) $StartTime = trim($_GET["StartTime"]); else  $StartTime = "";
                    if (isset($_GET["PreEndTime"])) $PreEndTime = trim($_GET["PreEndTime"]); else  $PreEndTime = "";
                    if (isset($_GET["EndTime"])) $EndTime = trim($_GET["EndTime"]); else  $EndTime = "";
                    if (isset($_GET["DevStatus"])) $DevStatus = trim($_GET["DevStatus"]); else  $DevStatus = "";
                    if (isset($_GET["VideoURL"])) $VideoURL = trim($_GET["VideoURL"]); else  $VideoURL = "";
                    $input = array("DevCode" => $DevCode, "StatCode" => $StatCode, "StartTime" => $StartTime, "PreEndTime" => $PreEndTime,
                        "EndTime" => $EndTime, "DevStatus" => $DevStatus, "VideoURL" => $VideoURL);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_DEVMOD, "MSG_ID_L4AQYCUI_TO_L3F3_DEVMOD",$input);
                    break;

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
                case "DevDel":  //删除HCU设备
                    if (isset($_GET["DevCode"])) $DevCode = trim($_GET["DevCode"]); else  $DevCode = "";
                    $input = array("DevCode" => $DevCode);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_DEVDEL, "MSG_ID_L4AQYCUI_TO_L3F3_DEVDEL",$input);
                    break;

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
                case "DevAlarm":  //获取当前的测量值，如果测量值超出范围，提示告警
                    if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode = "";
                    $input = array("StatCode" => $StatCode);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_DEVALARM, "MSG_ID_L4AQYCUI_TO_L3F5_DEVALARM",$input);
                    break;

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
                case "MonitorList":      // get monitorList in map by user id
                    if (isset($_GET["id"])) $id = trim($_GET["id"]); else  $id = "";
                    $input = array("id" => $id);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_MONITORLIST, "MSG_ID_L4AQYCUI_TO_L3F3_MONITORLIST",$input);
                    break;

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
                case "AlarmQuery": //查询一个监测点历史告警数据 minute/hour/day
                    if (isset($_GET["id"])) $id = trim($_GET["id"]); else  $id = "";
                    if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode = "";
                    if (isset($_GET["date"])) $date = trim($_GET["date"]); else  $date = "";
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else  $type = "";
                    $input = array("id" => $id, "StatCode" => $StatCode, "date" => $date, "type" => $type);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMQUERY, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMQUERY",$input);
                    break;

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
                case "AlarmType":  //获取所有传感器类型
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else  $user = "";
                    $input = array("user" => $user);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_ALARMTYPE, "MSG_ID_L4AQYCUI_TO_L3F3_ALARMTYPE",$input);
                    break;

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
                case "TableQuery":
                    if (isset($_GET["TableName"])) $TableName = trim($_GET["TableName"]); else  $TableName = "";
                    if (isset($_GET["Condition"])) $Condition = $_GET["Condition"]; else  $Condition = array();
                    $input = array("TableName" => $TableName, "Condition" => $Condition);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_TABLEQUERY, "MSG_ID_L4AQYCUI_TO_L3F3_TABLEQUERY",$input);
                    break;

                case "SensorList":
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else  $user = "";
                    $input = array("user" => $user);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_SENSORLIST, "MSG_ID_L4AQYCUI_TO_L3F3_SENSORLIST",$input);
                    break;

                case "DevSensor":
                    if (isset($_GET["DevCode"])) $DevCode = trim($_GET["DevCode"]); else  $DevCode = "";
                    $input = array("DevCode" => $DevCode);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_DEVSENSOR, "MSG_ID_L4AQYCUI_TO_L3F3_DEVSENSOR",$input);
                    break;

                case "SensorUpdate":
                    if (isset($_GET["DevCode"])) $DevCode = trim($_GET["DevCode"]); else  $DevCode = "";
                    if (isset($_GET["SensorCode"])) $SensorCode = trim($_GET["SensorCode"]); else  $SensorCode = "";
                    if (isset($_GET["status"])) $status = trim($_GET["status"]); else  $status = "";
                    if (isset($_GET["ParaList"])) $ParaList = $_GET["ParaList"]; else  $ParaList = array();
                    $input = array("DevCode" => $DevCode, "SensorCode" => $SensorCode, "status" => $status, "ParaList" => $ParaList);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_SENSORUPDATE, "MSG_ID_L4AQYCUI_TO_L3F4_SENSORUPDATE",$input);
                    break;

                /*
                        var usr = data.id;
                        var Msg = data.msg;
                        var ifdev = data.ifdev;
                        var retval={
                            status:"true",
                            msg:""
                        };*/
                case "SetUserMsg":
                    if (isset($_GET["id"])) $id = trim($_GET["id"]); else  $id = "";
                    if (isset($_GET["msg"])) $msg1 = trim($_GET["msg"]); else  $msg1 = "";
                    if (isset($_GET["ifdev"])) $ifdev = trim($_GET["ifdev"]); else  $ifdev = "";
                    $input = array("id" => $id, "msg" => $msg1, "ifdev" => $ifdev);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4AQYCUI_TO_L3F7_SETUSERMSG, "MSG_ID_L4AQYCUI_TO_L3F7_SETUSERMSG",$input);
                    break;

                /*
                    var usr = data.id;
                    var retval={
                        status:"true",
                        msg:"您好，今天是xxxx号，欢迎领导前来视察，今天的气温是 今天的PM2.5是....",
                        ifdev:"true"
                    };*/
                case "GetUserMsg":
                    if (isset($_GET["id"])) $id = trim($_GET["id"]); else  $id = "";
                    $input = array("id" => $id);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4AQYCUI_TO_L3F7_GETUSERMSG, "MSG_ID_L4AQYCUI_TO_L3F7_GETUSERMSG",$input);
                    break;

                /*
                    var usr = data.id;
                    var temp = GetRandomNum(1000,9999);
                    var retval={
                            status:"true",
                            msg:temp+"您好，今天是"+temp+"号，欢迎领导前来视察，今天的气温是 今天的PM2.5是.xxx.yyy.zzz."
                        };*/
                case "ShowUserMsg":
                    if (isset($_GET["id"])) $id = trim($_GET["id"]); else  $id = "";
                    if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode = "";
                    $input = array("id" => $id, "StatCode" => $StatCode);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4AQYCUI_TO_L3F7_SHOWUSERMSG, "MSG_ID_L4AQYCUI_TO_L3F7_SHOWUSERMSG",$input);
                    break;

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
                case "GetUserImg":
                    if (isset($_GET["id"])) $id = trim($_GET["id"]); else  $id = "";
                    $input = array("id" => $id);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4AQYCUI_TO_L3F7_GETUSERIMG, "MSG_ID_L4AQYCUI_TO_L3F7_GETUSERIMG",$input);
                    break;


                /*
                    var usr = data.id;
                    var retval={
                        status:"true"
                    };*/
                case "ClearUserImg":
                    if (isset($_GET["id"])) $id = trim($_GET["id"]); else  $id = "";
                    $input = array("id" => $id);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4AQYCUI_TO_L3F7_CLEARUSERIMG, "MSG_ID_L4AQYCUI_TO_L3F7_CLEARUSERIMG",$input);
                    break;

                /*
                var retval={
                    status:"true",
                    ColumnName: column_name,
                    TableData:row_content
                };*/
                case "GetStaticMonitorTable":  //查询测量点聚合信息
                    if (isset($_GET["id"])) $id = trim($_GET["id"]); else  $id = "";
                    $input = array("id" => $id);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_GETSTATICMONITORTABLE, "MSG_ID_L4AQYCUI_TO_L3F3_GETSTATICMONITORTABLE",$input);
                    break;

                /*
                        var usr = data.id;
                        var StatCode = data.StatCode;
                        var date = data.date;
                        var hour = data.hour;
                        var VideoList = new Array();
                        for(var j=0;j<5;j++) {
                            var map = {
                                id: "Video_" + StatCode + "_" + date + "_" + hour + "_" + j,
                                attr: "视频属性"
                            }
                            VideoList.push(map);
                        }
                        var retval={
                            status:"true",
                            ret: VideoList
                        };
                        return JSON.stringify(retval);
                */
                case "GetVideoList": //获取指定站点指定时间段内的所有视频文件列表
                    if (isset($_GET["id"])) $uid = trim($_GET["id"]); else  $uid = "";
                    if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode = "";
                    if (isset($_GET["date"])) $date = trim($_GET["date"]); else  $date = "";
                    if (isset($_GET["hour"])) $hour = trim($_GET["hour"]); else  $hour = "";
                    $input = array("id" => $uid, "StatCode" => $StatCode, "date" => $date, "hour" => $hour);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_VIDEOLIST, "MSG_ID_L4AQYCUI_TO_L3F4_VIDEOLIST",$input);
                    break;

                /*
                        var videoid = data.id;
                        var number = GetRandomNum(1,10);
                        if(number ==10){
                            var retval={
                                status:"true",
                                url:"/video/avorion.mp4"
                            }
                            return JSON.stringify(retval);
                        }else{
                            var retval={
                                status:"true",
                                url:"downloading"
                            }
                            return JSON.stringify(retval);
                        }
                */
                case "GetVideo":
                case "GetVideo":
                    if (isset($_GET["id"])) $videoid = trim($_GET["id"]); else  $videoid = "";
                    $input = array("id" => $videoid);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_VIDEOPLAY, "MSG_ID_L4AQYCUI_TO_L3F4_VIDEOPLAY",$input);
                    break;
                  /*
                  var verlist = new Array();
                  for (var i=0;i<10;i++){
                      verlist.push("Ver "+(i+1)+".00");
                  }
                  var retval={
                      status:"true",
                      ret: verlist
                  }
                  return JSON.stringify(retval);
                  */
                case "GetVersionList":
                    if (isset($_GET["id"])) $uid = trim($_GET["id"]); else  $uid = "";
                    $input = array("uid" => $uid);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_ALLSW, "MSG_ID_L4AQYCUI_TO_L3F4_ALLSW",$input);
                    break;

                /*
                   var ProjCode = data.ProjCode;
                   var projdev = new Array();
                   for(var i=0;i<5;i++){
                       for(var j=0;j<4;j++){
                           var temp = {
                               DevCode: i+"_"+j,
                               ProjName: "测量点"+i,
                               version: "Ver 1.00"
                           }
                           projdev.push(temp);
                       }
                   }
                   var retval={
                       status:"true",
                       ret: projdev
                   };
                   return JSON.stringify(retval);
               */
                case "GetProjDevVersion":
                    if (isset($_GET["id"])) $uid = trim($_GET["id"]); else  $uid = "";
                    if (isset($_GET["ProjCode"])) $ProjCode = trim($_GET["ProjCode"]); else  $ProjCode = "";
                    $input = array("uid" => $uid, "ProjCode" => $ProjCode);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_DEVSW, "MSG_ID_L4AQYCUI_TO_L3F4_DEVSW",$input);
                    break;

                /*
                    var usr = data.id;
                    var list = data.list;
                    var version = data.version;
                    var retval={
                        status:"true"
                    }
                    return JSON.stringify(retval);
                */
                case "UpdateDevVersion":
                    if (isset($_GET["id"])) $uid = trim($_GET["id"]); else  $uid = "";
                    if (isset($_GET["list"])) $list = $_GET["list"]; else  $list = "";
                    if (isset($_GET["version"])) $version = trim($_GET["version"]); else  $version = "";
                    $input = array("uid" => $uid, "list" => $list, "version" => $version);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_SWUPDATE, "MSG_ID_L4AQYCUI_TO_L3F4_SWUPDATE",$input);
                    break;

                //require data structure:
                /*var map={
                    action:"HcuSwUpdate",
                    deviceid: deviceid
                    projectid: projectid
                };*/
                //return data structure:
                /*  var retval={
                   status:"true",
                   msg:""
                };*/
                case "HcuSwUpdate": //Delete the user
                    if (isset($_GET["deviceid"])) $deviceid = trim($_GET["deviceid"]); else  $deviceid = "";
                    if (isset($_GET["projectid"])) $projectid = trim($_GET["projectid"]); else  $projectid = "";
                    $input = array("deviceid" => $deviceid, "projectid" => $projectid);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4AQYCUI_TO_L3F4_SWUPDATE, "MSG_ID_L4AQYCUI_TO_L3F4_SWUPDATE",$input);
                    break;

                case "GetCameraStatus": //Get camera vertical and horizontal angle and fetch a current photo
                    if (isset($_GET["id"])) $uid = trim($_GET["id"]); else  $uid = "";
                    if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode= "";
                    $input = array("uid" => $uid, "StatCode" => $StatCode);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_GETCAMERASTATUS, "MSG_ID_L4AQYCUI_TO_L3F4_GETCAMERASTATUS",$input);
                    break;

                default:
                    $resp = ""; //啥都不ECHO
                    break;
            }

        }
        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger("L4AQYCUI", "MFUN_TASK_ID_L4AQYC_UI", $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>