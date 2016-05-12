﻿

//var request_head= ".request";
//var jump_url = ".jump";


//切换生产环境要更新以下数据，包括logout函数
var wait_time_long =1000;
var wait_time_middle = 500;
var wait_time_short= 200;
var cycle_time = 60000;
var request_head= "request.php";
var jump_url = "/xhzn/mfunhcu/ui/jump.php";

function logout(){
    delCookie("Environmental.inspection.session");
    window.location="http://"+window.location.host;

    /*
     delCookie("Environmental.inspection.session");
     var txt = window.location.href;
     var index =txt.lastIndexOf("/");
     window.location=txt.substr(0,index)+"/Login.html";
     */
}





var usr;
usr = "";
var admin="";
var keystr="";
var table_row=5;
//var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
var current_table;
var table_head;
var map_MPMonitor;
var map_initialized = false;

// user table control
var user_initial = false;
var user_start=0;
var user_total=0;
var project_pg_list=null;
var user_table=null;
var user_selected;
var user_selected_auth;
var NewUserAuthDual2;
var user_module_status;

// pg table control
var pg_initial = false;
var pg_start=0;
var pg_total=0;
var pg_table=null;
var pg_selected;
var pg_selected_proj;
var NewPGProjDual2;
var pg_module_status;
var project_list=null;


// project table control
var project_initial = false;
var project_start=0;
var project_total=0;
var project_table=null;
var project_selected;
var project_selected_device;
var project_module_status;



// monitor point table control
var point_initial = false;
var point_start=0;
var point_total=0;
var point_table=null;
var point_selected;
var project_selected_point;
var point_module_status;

// device table control
var point_list=null;
var device_initial = false;
var device_start=0;
var device_total=0;
var device_table=null;
var device_selected;
var device_selected_device;
var device_module_status;

//warning Control
var monitor_map_list = null;
var monitor_handle;
var monitor_selected = null;
var monitor_list = null;
var monitor_string="";
var monitor_map_handle=null;

//alarm Control
var alarm_type_list = null;
var alarm_map_initialized = false;
var alarm_selected = null;
var alarm_map_handle=null;
var alarm_array = null;


//Export Control
var export_table_name = null;
var if_table_initialize = false;
/*
var lineChartData = {
    labels : ["January","February","March","April","May","June","July"],
    datasets : [
        {
            label: "My First dataset",
            fillColor : "rgba(220,220,220,0.2)",
            strokeColor : "rgba(220,220,220,1)",
            pointColor : "rgba(220,220,220,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(220,220,220,1)",
            data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        },
        {
            label: "My Second dataset",
            fillColor : "rgba(151,187,205,0.2)",
            strokeColor : "rgba(151,187,205,1)",
            pointColor : "rgba(151,187,205,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(151,187,205,1)",
            data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        }
    ]

}
*/
window.onload = function(){
    //initialize();


/*
    var ctx = document.getElementById("canvas").getContext("2d");
    window.myLine = new Chart(ctx).Line(lineChartData, {
        responsive: true
    });*/
}
function nav_check(){
    if(usr.admin == "true"){
        $("#Admin_menu").css("display","block");
    }else{
        $("#Admin_menu").css("display","none");
    }
    $("#Hello_label").text("用户:"+usr.name);
    var $b_label = $(+" <b class='caret'></b>");
    $("#Hello_label").append("<b class='caret'></b>");
}
function show_alarm_module(ifalarm,text){
    if(ifalarm){
        $("#UserAlertModalLabel").text = "警告";
        $("#UserAlertModalContent").empty();
        $("#UserAlertModalContent").append("<strong>警告！</strong>"+text);
    }else{
        $("#UserAlertModalLabel").text = "通知";
        $("#UserAlertModalContent").empty();
        $("#UserAlertModalContent").append("<strong>通知：</strong>"+text);
    }
    modal_middle($('#UserAlarm'));
    $('#UserAlarm').modal('show') ;
}
function modal_middle(modal){
    setTimeout(function () {
        var _modal = $(modal).find(".modal-dialog")
        _modal.animate({'margin-top': parseInt(($(window).height() - _modal.height())/2)}, 300 )
    },wait_time_short);
}


function on_collapse(data){
    //alert(data.html());
    touchcookie();
}

function PageInitialize(){
    get_user_information();
    window.setTimeout("nav_check()", wait_time_short);
}

function get_user_information(){
    var session = getQueryString("session");
    var map={
        action:"UserInfo",
        session: session
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "false"){
            show_alarm_module(true,"获取用户失败，请联系管理员");
        }else{
            usr = result;
        }
    });
}



$(document).ready(function() {

    //$.ajaxSetup({
    //    async : false
    //});
    //$(".DevPreEndTime_Input").datetimepicker({format: 'yyyy-mm-dd'});
    $("[data-toggle='modal']").click(function(){
        var _target = $(this).attr('data-target')
        t=setTimeout(function () {
            var _modal = $(_target).find(".modal-dialog")
            _modal.animate({'margin-top': parseInt(($(window).height() - _modal.height())/2)}, 300 )
        },wait_time_short)
    });

    $('.form_date').datetimepicker({
        language:  'zh-CN',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });



    NewUserAuthDual2 = $('.NewUserAuthDual').bootstrapDualListbox(
        { nonSelectedListLabel: '全部项目（组）', selectedListLabel: '用户权限', preserveSelectionOnMove: 'moved', moveOnSelect: true, nonSelectedFilter: '',showFilterInputs: false,infoText:""});
    $("#showValue").click(function () { alert($('[name="duallistbox_demo1"]').val());});


    NewPGProjDual2 = $('.NewPGProjDual').bootstrapDualListbox(
        { nonSelectedListLabel: '全部项目', selectedListLabel: '本组包含', preserveSelectionOnMove: 'moved', moveOnSelect: true, nonSelectedFilter: '',showFilterInputs: false,infoText:""});
    // $("#showValue").click(function () { alert($('[name="duallistbox_demo1"]').val());});
    //$('.user_auth_dual').showFilterInputs=false;

    var monitor_handle= setInterval("get_monitor_warning_on_map()", cycle_time);
    PageInitialize();
    $("#menu_logout").on('click',function(){
        logout();

    });
    //LEFT menu
    $("#UserManage").on('click',function(){
        touchcookie();
        user_manager();
    });
    $("#PGManage").on('click',function(){
        touchcookie();
        pg_manage();
    });
    $("#ProjManage").on('click',function(){
        touchcookie();
        proj_manage();
    });
    $("#ParaManage").on('click',function(){
        touchcookie();
        para_manage();
    });
    $("#MPManage").on('click',function(){
        touchcookie();
        mp_manage();
    });
    $("#DevManage").on('click',function(){
        touchcookie();
        dev_manage();
    });
    $("#MPMonitor").on('click',function(){
        touchcookie();
        mp_monitor();
    });
    $("#WarningCheck").on('click',function(){
        touchcookie();
        warning_check();
    });
    $("#WarningHandle").on('click',function(){
        touchcookie();
        warning_handle();
    });

    //user view buttons
    $("#UserfreshButton").on('click',function(){
        touchcookie();
        clear_user_detail_panel();
        user_intialize(0);
    });
    $("#UserExportButton").on('click',function(){
        touchcookie();
        //alert("Not support yet");
        var condition_user = new Array();
        var temp ={
            ConditonName: "UserId",
            Equal:usr.id,
            GEQ:"",
            LEQ:""
        };
        condition_user.push(temp);
        Data_export_Normal("用户表导出","usertable",condition_user,new Array());
    });
    $("#UserNewButton").on('click',function(){
        touchcookie();
        show_new_user_module();
    });
    $("#UserDelButton").on('click',function(){
        touchcookie();
        if(user_selected == null){
            show_alarm_module(true,"请选择一个用户");
        }else{
            modal_middle($('#UserDelAlarm'));
            $('#UserDelAlarm').modal('show');
        }
    });
    $("#UserModifyButton").on('click',function(){
        touchcookie();
        if(user_selected == null){
            show_alarm_module(true,"请选择一个用户");
        }else{
            show_mod_user_module(user_selected,user_selected_auth);
        }
    });
    $("#delUserCommit").on('click',function(){
        //发送请求并且告知成功失败
        //刷新表格
        del_user(user_selected.id);
        touchcookie();
    });
    $("#newUserCommit").on('click',function(){
        //检查输入项目
        //发送请求
        //刷新表格
        if(user_module_status){
            submit_new_user_module();
            touchcookie();
        }else{
            submit_mod_user_module();
            touchcookie();
        }
    });
    //pg view buttons
    $("#PGfreshButton").on('click',function(){
        touchcookie();
        clear_pg_detail_panel();
        pg_intialize(0);
    });
    $("#PGExportButton").on('click',function(){
        touchcookie();
        var condition_user = new Array();
        var temp ={
            ConditonName: "UserId",
            Equal:usr.id,
            GEQ:"",
            LEQ:""
        };
        condition_user.push(temp);
        Data_export_Normal("项目群表导出","PGtable",condition_user,new Array());
    });
    $("#PGNewButton").on('click',function(){
        touchcookie();
        show_new_pg_module();
    });
    $("#PGDelButton").on('click',function(){
        touchcookie();
        if(pg_selected == null){
            show_alarm_module(true,"请选择一个项目组");
        }else{
            modal_middle($('#PGDelAlarm'));
            $('#PGDelAlarm').modal('show');
        }
    });
    $("#PGModifyButton").on('click',function(){
        touchcookie();
        if(pg_selected == null){
            show_alarm_module(true,"请选择一个项目组");
        }else{
            show_mod_pg_module(pg_selected,pg_selected_proj);
        }
    });
    $("#delPGCommit").on('click',function(){
        //发送请求并且告知成功失败
        //刷新表格
        del_pg(pg_selected.PGCode);
        touchcookie();
    });
    $("#newPGCommit").on('click',function(){
        //检查输入项目
        //发送请求
        //刷新表格
        if(pg_module_status){
            submit_new_pg_module();
            touchcookie();
        }else{
            submit_mod_pg_module();
            touchcookie();
        }
    });
// project view buttons


    $("#ProjfreshButton").on('click',function(){
        touchcookie();
        clear_proj_detail_panel();
        proj_intialize(0);
    });
    $("#ProjExportButton").on('click',function(){
        touchcookie();
        var condition_user = new Array();
        var temp ={
            ConditonName: "UserId",
            Equal:usr.id,
            GEQ:"",
            LEQ:""
        };
        condition_user.push(temp);
        Data_export_Normal("项目表导出","Projtable",condition_user,new Array());
    });
    $("#ProjNewButton").on('click',function(){
        touchcookie();
        show_new_proj_module();
    });
    $("#ProjDelButton").on('click',function(){
        touchcookie();
        if(project_selected == null){
            show_alarm_module(true,"请选择一个项目");
        }else{
            modal_middle($('#ProjDelAlarm'));
            $('#ProjDelAlarm').modal('show');
        }
    });
    $("#ProjModifyButton").on('click',function(){
        touchcookie();
        if(project_selected == null){
            show_alarm_module(true,"请选择一个项目");
        }else{
            show_mod_proj_module(project_selected);
        }
    });
    $("#delProjCommit").on('click',function(){
        //发送请求并且告知成功失败
        //刷新表格
        del_proj(project_selected.StatCode);
        touchcookie();
    });
    $("#newProjCommit").on('click',function(){
        //检查输入项目
        //发送请求
        //刷新表格
        if(project_module_status){
            submit_new_proj_module();
            touchcookie();
        }else{
            submit_mod_proj_module();

            touchcookie();
        }
    });

    //MP view buttons
    $("#PointfreshButton").on('click',function(){
        touchcookie();
        clear_point_detail_panel();
        point_intialize(0);
    });
    $("#PointExportButton").on('click',function(){
        touchcookie();
        var condition_user = new Array();
        var temp ={
            ConditonName: "UserId",
            Equal:usr.id,
            GEQ:"",
            LEQ:""
        };
        condition_user.push(temp);
        Data_export_Normal("监测点导出","Pointtable",condition_user,new Array());
    });
    $("#PointNewButton").on('click',function(){
        touchcookie();
        show_new_point_module();
    });
    $("#PointDelButton").on('click',function(){
        touchcookie();
        if(point_selected == null){
            show_alarm_module(true,"请选择一个监测点");
        }else{
            modal_middle($('#PointDelAlarm'));
            $('#PointDelAlarm').modal('show');
        }
    });
    $("#PointModifyButton").on('click',function(){
        touchcookie();
        if(point_selected == null){
            show_alarm_module(true,"请选择一个监测点");
        }else{
            show_mod_point_module(point_selected);
        }
    });
    $("#delPointCommit").on('click',function(){
        //发送请求并且告知成功失败
        //刷新表格
        del_point(point_selected.StatCode);
        touchcookie();
    });
    $("#newPointCommit").on('click',function(){
        //检查输入项目
        //发送请求
        //刷新表格
        if(point_module_status){
            submit_new_point_module();
            touchcookie();
        }else{
            submit_mod_point_module();

            touchcookie();
        }
    });


// device view buttons
    $("#DevfreshButton").on('click',function(){
        touchcookie();
        clear_dev_detail_panel();
        dev_intialize(0);
    });
    $("#DevExportButton").on('click',function(){
        touchcookie();
        var condition_user = new Array();
        var temp ={
            ConditonName: "UserId",
            Equal:usr.id,
            GEQ:"",
            LEQ:""
        };
        condition_user.push(temp);
        Data_export_Normal("设备表导出","Devtable",condition_user,new Array());
    });
    $("#DevNewButton").on('click',function(){
        touchcookie();
        show_new_dev_module();
    });
    $("#DevDelButton").on('click',function(){
        touchcookie();
        if(device_selected == null){
            show_alarm_module(true,"请选择一个设备");
        }else{
            modal_middle($('#DevDelAlarm'));
            $('#DevDelAlarm').modal('show');
        }
    });
    $("#DevModifyButton").on('click',function(){
        touchcookie();
        if(device_selected == null){
            show_alarm_module(true,"请选择一个设备");
        }else{
            show_mod_dev_module(device_selected);
        }
    });
    $("#delDevCommit").on('click',function(){
        //发送请求并且告知成功失败
        //刷新表格
        del_dev(device_selected.StatCode);
        touchcookie();
    });
    $("#newDevCommit").on('click',function(){
        //检查输入项目
        //发送请求
        //刷新表格
        if(device_module_status){
            submit_new_dev_module();
            touchcookie();
        }else{
            submit_mod_dev_module();

            touchcookie();
        }
    });


    $("#DevProjCode_choice").change(function(){
        get_proj_point_option($("#DevProjCode_choice").val(),$("#DevStatCode_choice"),"");
    });
    $("#QueryProjCode_choice").change(function(){
        get_proj_point_option($("#QueryProjCode_choice").val(),$("#QueryStatCode_choice"),"");
    });
    $("#AlarmQueryCommit").on('click',function(){


        if(alarm_selected == null){
            $("#WCStatCode_Input").attr("placeholder","请先在地图上选择一个点");
            return;
        }

        if($("#Alarm_query_Input").val()=="" || $("#Alarm_query_Input").val() == null){
            $("#Alarm_query_Input").attr("placeholder","请输入日期");
            return;
        }

        if(alarm_type_list!= null){
            for(var i=0;i<alarm_type_list.length;i++){
                query_alarm($("#Alarm_query_Input").val(),alarm_type_list[i].id,alarm_type_list[i].name);
            }
        }
        window.setTimeout("$('#Warning_'+alarm_type_list[0].id+'_day').css('display','block')", wait_time_long);


    });
    $("#AlarmExport").on('click',function() {
        Data_export_alarm();
    });
    $("#AlarmQuery_Commit").on('click',function() {
        submit_alarm_query();
    });


    $("#QueryStartTime_Input").change(function(){
        $("#QueryStartTime_Input").val(date_compare_today($("#QueryStartTime_Input").val()));
        if( $("#QueryEndTime_Input").val()==""){
            $("#QueryEndTime_Input").val($("#QueryStartTime_Input").val());
        }else{
            $("#QueryEndTime_Input").val(date_compare($("#QueryEndTime_Input").val(),$("#QueryStartTime_Input").val()));
        }
    });
    $("#QueryEndTime_Input").change(function(){
        if( $("#QueryStartTime_Input").val()=="") {
            $("#QueryEndTime_Input").val(date_compare_today($("#QueryEndTime_Input").val()));
            $("#QueryStartTime_Input").val($("#QueryStartTime_Input").val());
        }else{
            $("#QueryEndTime_Input").val(date_compare($("#QueryEndTime_Input").val(),$("#QueryStartTime_Input").val()));
        }
    });
    //alert($(window).height());
    //alert($(window).width());
    clear_window();
    desktop();
    calculate_row();
    clear_user_detail_panel();
    clear_proj_detail_panel();
});
function calculate_row(){
    var screen_high = $(window).height();
    var add_row = parseInt( ($(window).height()-650)/100);
    if(add_row<=0)
        table_row=5;
    else if(add_row>=5)
        table_row=10;
    else
        table_row=table_row+add_row;

}
function user_manager(){
    //alert($(document).height());
    //alert($(document).width());
    clear_window();
    $("#UserManageView").css("display","block");
    if(!user_initial){ user_intialize(0);}
}
function pg_manage(){
    clear_window();
    $("#PGManageView").css("display","block");
    if(!pg_initial){ pg_intialize(0);}
}
function proj_manage(){
    clear_window();
    $("#ProjManageView").css("display","block");
    proj_intialize(0);
}
function para_manage(){
    clear_window();
    $("#ParaManageView").css("display","block");
}
function mp_manage(){
    clear_window();
    $("#MPManageView").css("display","block");
    //需求修改，项目变成测量点，变量名字不改了
    if(!point_initial){ point_intialize(0);}
}
function dev_manage(){
    clear_window();
    $("#DevManageView").css("display","block");
    if(!device_initial){ dev_intialize(0);}
}
function mp_monitor(){
    clear_window();
    $("#MPMonitorView").css("display","block");
    if(!map_initialized)initializeMap();
}
function warning_check(){
    clear_window();
    $("#WarningCheckView").css("display","block");
    if(!alarm_map_initialized)initializeAlarmMap();
}
function warning_handle(){
    clear_window();
    $("#WarningHandleView").css("display","block");
}
function desktop(){
    clear_window();
    $("#Desktop").css("display","block");
}

function clear_window(){
    $("#UserManageView").css("display","none");
    $("#PGManageView").css("display","none");
    $("#ProjManageView").css("display","none");
    $("#ParaManageView").css("display","none");
    $("#MPManageView").css("display","none");
    $("#DevManageView").css("display","none");
    $("#MPMonitorView").css("display","none");
    $("#WarningCheckView").css("display","none");
    $("#WarningHandleView").css("display","none");
    $("#Desktop").css("display","none");
}


/**
 * User view function part
 */
function get_project_pg_list(){
    var map={
        action:"ProjectPGList",
        user:usr.id
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        project_pg_list = result.ret;
    });
}
function get_user_table(start,length){
    var map={
        action:"UserTable",
        startseq: start,
        length:length
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        user_table = result.ret;

        user_start = parseInt(result.start);
        user_total = parseInt(result.total);
    });
}
function del_user(id){
    var map={
        action:"UserDel",
        id: id
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"删除成功！");
            clear_user_detail_panel();
            user_intialize(0);
        }else{
            show_alarm_module(true,"删除失败！");
        }
    });
    $("#UserDelAlarm").modal('hide');

}
function new_user(user,auth){
    var map={
        action:"UserNew",
        name: user.name,
        nickname: user.nickname,
        password: user.password,
        mobile: user.mobile,
        mail: user.mail,
        type: user.type,
        memo: user.memo,
        auth: auth
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"创建成功！");
            $('#newUserModal').modal('hide');
            clear_user_detail_panel();
            user_intialize(0);
        }else{
            show_alarm_module(true,"创建失败！");
        }
    });
}
function modify_user(user,auth){
    var map={
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
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"修改成功！");
            $('#newUserModal').modal('hide');
            clear_user_detail_panel();
            user_intialize(0);
        }else{
            show_alarm_module(true,"修改失败！");
        }
    });
}



function get_user_proj(user){
    var map={
        action:"UserProj",
        userid: user
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        user_selected_auth = result.ret;
    });
}
function user_intialize(start) {
    user_initial = true;
    user_table = null;
    get_user_table(start, table_row * 5);
    get_project_pg_list();
    window.setTimeout("draw_user_table_head()", wait_time_middle);
}
function draw_user_table_head(){
    var page_number = Math.ceil((user_table.length-1)/table_row);

    $("#User_Page_control").empty();
    var txt = "<li>"+
        "<a href='#' id='user_page_prev'>Prev</a>"+
        "</li>";
    var page_start_number = Math.ceil(user_start/table_row);
    for(var i=0;i<page_number;i++){
        txt=txt+ "<li>"+
            "<a href='#' id='user_page_"+i+"'>"+(i+page_start_number+1)+"</a>"+
            "</li>";
    }
    txt=txt+"<li>"+
        "<a href='#' id='user_page_next'>Next</a>"+
        "</li>";
    $("#User_Page_control").append(txt);
    table_head="<thead>"+
        "<tr>"+"<th>序号</th>"+"<th>用户名</th>"+"<th>昵称</th>"+"<th>电话</th>"+"<th>属性</th>"+"<th>更新日期</th>";
    table_head=table_head+"</tr></thread>";
    for(var i=0;i<page_number;i++){
        $("#user_page_"+i).on('click',function(){
            draw_user_table($(this));
        });
    }
    if(user_start<=0){
        $("#user_page_prev").css("display","none");
    }else{
        $("#user_page_prev").css("display","block");
        $("#user_page_prev").on('click',function(){
            var new_start = user_start-(table_row*5);
            if(new_start<0) new_start =0;
            user_intialize(new_start);
        });
    }

    if((user_start+(table_row*5))>=user_total){
        $("#user_page_next").css("display","none");
    }else{
        $("#user_page_next").css("display","block");
        $("#user_page_next").on('click',function(){
            user_intialize(user_start+(table_row*5));
        });
    }

    draw_user_table($("#user_page_0"));
}
function draw_user_table(data){

    $("#Table_user").empty();
    var sequence = (parseInt(data.html())-1)*table_row-user_start;
    var txt = table_head;
    txt = txt +"<tbody>";
    for(var i=0;i<table_row;i++){
        if((sequence+i)<user_table.length){
            if(0!=i%2){
                txt =txt+ "<tr class='success' id='table_cell"+i+"' userid='"+user_table[sequence+i].id+"'>";
            }else{ txt =txt+ "<tr  id='table_cell"+i+"' userid='"+user_table[sequence+i].id+"'>";}
            txt = txt +"<td>" + user_table[sequence+i].id+"</td>"
                +"<td>" + user_table[sequence+i].name+"</td>"
                +"<td>" + user_table[sequence+i].nickname+"</td>"
                +"<td>" + user_table[sequence+i].mobile+"</td>";
            if(true == user_table[sequence+i].type)
                txt = txt+"<td>管理员</td>";
            else txt = txt+"<td>用户</td>";
            txt = txt +"<td>" + user_table[sequence+i].date+"</td>";

            txt = txt +"</tr>"
        }else{
            if(0!=i%2){
                txt =txt+ "<tr class='success' id='table_cell"+i+"' userid='null'>";
            }else{ txt =txt+ "<tr  id='table_cell"+i+"' userid='null'>";}
            txt = txt +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>";
            txt = txt +"</tr>"
        }

    }
    txt = txt+"</tbody>";

    $("#Table_user").append(txt);
    for(var i=0;i<table_row;i++){
        $("#table_cell"+i).on('click',function(){
            if($(this).attr("userid") !="null"){
                for(var i=0;i<user_table.length;i++){
                    if($(this).attr("userid") == user_table[i].id){
                        user_selected =user_table[i];
                        break;
                    }
                }

                Initialize_user_detail();
            }

        });
    }
    touchcookie();
}
function Initialize_user_detail(){
    get_user_proj(user_selected.id);
    window.setTimeout("draw_user_detail_panel()", wait_time_short);
}
function clear_user_detail_panel(){
    user_selected = null;
    var txt = "<p></p><p></p>"+
        "<label style='min-width: 150px'>用户名：</label><label style='min-width: 150px'>用户昵称：</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>用户类型：</label>"+"<p></p>"+"<label style='min-width: 300px'>修改日期：</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>联系方式：</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>邮箱：</label>"+
        "<p></p>"+
        "<label>备注：</label>";

    $("#Label_user_detail").empty();
    $("#Label_user_detail").append(txt);
    $("#Table_user_authed").empty();
}
function draw_user_detail_panel(){
    $("#Label_user_detail").empty();
    var usertype="用户";
    if(true==user_selected.type) usertype="管理员";
    var txt = "<p></p><p></p>"+
        "<label style='min-width: 150px'>用户名："+user_selected.name+"</label><label style='min-width: 150px'>用户昵称："+user_selected.nickname+"</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>用户类型："+usertype+"</label>"+"<p></p>"+"<label style='min-width: 300px'>修改日期："+user_selected.date+"</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>联系方式："+user_selected.mobile+"</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>邮箱："+user_selected.mail+"</label>"+
        "<p></p>"+
        "<label>备注："+user_selected.memo+"</label>";
    $("#Label_user_detail").append(txt);


    user_selected_auth


    $("#Table_user_authed").empty();
    txt ="<thead> <tr> <th>已关联项目 </th> </tr> </thead> <tbody >";
    for(var i=0;i<user_selected_auth.length;i++){
        txt = txt + "<tr> <td>"+ user_selected_auth[i].name+"</td> </tr>";
    }
    txt = txt+ "</tbody>";
    $("#Table_user_authed").append(txt);

}
function show_new_user_module(){

    $("#newModalLabel").text("创建新用户")
    user_module_status = true;
    $("#NewUsername_Input").val("");
    $("#NewUserNick_Input").val("");
    $("#NewPassword_Input").val("");
    $("#NewRePassword_Input").val("");
    $("#NewUserMobile_Input").val("");
    $("#NewUserMail_Input").val("");
    $("#NewUserMemo_Input").val("");
    $("#NewUserType_choice").val("false");
    $("#NewUsername_Input").attr("placeholder","用户名");
    $("#NewPassword_Input").attr("placeholder","密码");
    $("#NewRePassword_Input").attr("placeholder","重复密码");
    $("#NewUserMobile_Input").attr("placeholder","电话号码");
    $("#NewUserMail_Input").attr("placeholder","邮箱");

    $("#duallistboxUserAuth_new").empty();
    var txt = "";
    for(var i =0;i<project_pg_list.length;i++){
        txt = "<option value='"+project_pg_list[i].id+"'>"+project_pg_list[i].name+"</option>";
        $("#duallistboxUserAuth_new").append(txt);
    }
    //$("#duallistboxUserAuth_new").append(txt);
    $('.NewUserAuthDual').bootstrapDualListbox('refresh', true);

    /*
     NewUserAuthDual2 = $('.NewUserAuthDual').bootstrapDualListbox(
     { nonSelectedListLabel: '全部项目', selectedListLabel: '用户权限', preserveSelectionOnMove: 'moved', moveOnSelect: true, nonSelectedFilter: '',showFilterInputs: false,infoText:""});
     $("#showValue").click(function () { alert($('[name="duallistbox_demo1"]').val());});
     */


    modal_middle($('#newUserModal'));

    $('#newUserModal').modal('show');

}
function submit_new_user_module(){
    var new_usr_name = $("#NewUsername_Input").val();
    var new_usr_nick = $("#NewUserNick_Input").val();
    var new_usr_password = $("#NewPassword_Input").val();
    var new_usr_repassword = $("#NewRePassword_Input").val();
    var new_usr_mobile = $("#NewUserMobile_Input").val();
    var new_usr_mail = $("#NewUserMail_Input").val();
    var new_usr_memo = $("#NewUserMemo_Input").val();
    //console.log("new_usr_name:"+new_usr_name);
    if(new_usr_name == null || new_usr_name == ""){
        $("#NewUsername_Input").attr("placeholder","用户名不能为空");
        $("#NewUsername_Input").focus();
        return;
    }
    if(new_usr_password == null || new_usr_password == ""){
        $("#NewPassword_Input").attr("placeholder","密码不能为空");
        $("#NewRePassword_Input").attr("placeholder","密码不能为空");
        $("#NewPassword_Input").focus();
        return;
    }
    if(new_usr_password!=new_usr_repassword){
        $("#NewPassword_Input").val("");
        $("#NewRePassword_Input").val("");
        $("#NewPassword_Input").attr("placeholder","密码不正确，请重新输入");
        $("#NewRePassword_Input").attr("placeholder","密码不正确，请重新输入");
        $("#NewPassword_Input").focus();
        return;
    }
    if(new_usr_mobile == null || new_usr_mobile == ""){
        $("#NewUserMobile_Input").attr("placeholder","电话号码不能为空");
        $("#NewUserMobile_Input").focus();
        return;
    }
    if(new_usr_mail == null || new_usr_mail == ""){
        $("#NewUserMail_Input").attr("placeholder","邮箱不能为空");
        $("#NewUserMail_Input").focus();
        return;
    }

    var user = {
        name: new_usr_name,
        nickname: new_usr_nick,
        password: new_usr_repassword,
        mobile: new_usr_mobile,
        mail: new_usr_mail,
        type: $("#NewUserType_choice").val(),
        memo: new_usr_memo
    };
    var auth = new Array();
    $('#duallistboxUserAuth_new :selected').each(function(i, selected) {
        var temp = {
            id:$(selected).val(),
            name:$(selected).text()
        }
        auth.push(temp);
    });
    new_user(user,auth);
}
function show_mod_user_module(user,user_auth){
    $("#newModalLabel").text("用户信息修改：密码栏不输入表示不修改密码")
    user_module_status = false;
    $("#NewUsername_Input").val(user.name);
    $("#NewUserNick_Input").val(user.nickname);
    $("#NewPassword_Input").val("");
    $("#NewRePassword_Input").val("");
    $("#NewUserMobile_Input").val(user.mobile);
    $("#NewUserMail_Input").val(user.mail);
    $("#NewUserMemo_Input").val(user.memo);
    $("#NewUsername_Input").attr("placeholder","用户名");
    $("#NewPassword_Input").attr("placeholder","密码");
    $("#NewRePassword_Input").attr("placeholder","重复密码");
    $("#NewUserMobile_Input").attr("placeholder","电话号码");
    $("#NewUserMail_Input").attr("placeholder","邮箱");
    if(user.type==false) {
        $("#NewUserType_choice").val("false");
    }else{
        $("#NewUserType_choice").val("true");
    }


    $("#duallistboxUserAuth_new").empty();
    var txt = "";
    for(var i =0;i<project_pg_list.length;i++){
        txt = "<option value='"+project_pg_list[i].id+"'";
        for(var j=0;j<user_auth.length;j++){
            if(user_auth[j].id == project_pg_list[i].id){
                txt = txt +"selected='selected'";
                break;
            }
        }
        txt = txt +">"+project_pg_list[i].name+"</option>";
        $("#duallistboxUserAuth_new").append(txt);
    }
    //$("#duallistboxUserAuth_new").append(txt);
    $('.NewUserAuthDual').bootstrapDualListbox('refresh', true);



    modal_middle($('#newUserModal'));

    $('#newUserModal').modal('show');
}
function submit_mod_user_module(){
    var new_usr_name = $("#NewUsername_Input").val();
    var new_usr_nick = $("#NewUserNick_Input").val();
    var new_usr_password = $("#NewPassword_Input").val();
    var new_usr_repassword = $("#NewRePassword_Input").val();
    var new_usr_mobile = $("#NewUserMobile_Input").val();
    var new_usr_mail = $("#NewUserMail_Input").val();
    var new_usr_memo = $("#NewUserMemo_Input").val();

    if(new_usr_password!=""&&new_usr_repassword!=""&&new_usr_password!=new_usr_repassword){
        $("#NewPassword_Input").val("");
        $("#NewRePassword_Input").val("");
        $("#NewPassword_Input").attr("placeholder","密码不正确，请重新输入");
        $("#NewRePassword_Input").attr("placeholder","密码不正确，请重新输入");
        $("#NewPassword_Input").focus();
        return;
    }

    var user = {
        id: user_selected.id,
        name: new_usr_name,
        nickname: new_usr_nick,
        password: new_usr_repassword,
        mobile: new_usr_mobile,
        mail: new_usr_mail,
        type: $("#NewUserType_choice").val(),
        memo: new_usr_memo
    };
    var auth = new Array();
    $('#duallistboxUserAuth_new :selected').each(function(i, selected) {
        var temp = {
            id:$(selected).val(),
            name:$(selected).text()
        }
        auth.push(temp);
    });
    modify_user(user,auth);
}


/**
 * PG view function part
 */
function get_project_list(){
    var map={
        action:"ProjectList",
        user:usr.id
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        project_list = result.ret;
    });
}
function get_pg_table(start,length){
    var map={
        action:"PGTable",
        startseq: start,
        length:length,
        user:usr.id
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        pg_table = result.ret;

        pg_start = parseInt(result.start);
        pg_total = parseInt(result.total);
    });
}
function del_pg(id){
    var map={
        action:"PGDel",
        id: id,
        user:usr.id
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"删除成功！");
            clear_pg_detail_panel();
            pg_intialize(0);
        }else{
            show_alarm_module(true,"删除失败！");
        }
    });
    $("#PGDelAlarm").modal('hide');

}
function new_pg(pg,projlist){
    var map={
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
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"创建成功！");
            $('#newPGModal').modal('hide');
            clear_pg_detail_panel();
            pg_intialize(0);
        }else{
            show_alarm_module(true,"创建失败！");
        }
    });
}
function modify_pg(pg,projlist){
    var map={
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
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"修改成功！");
            $('#newPGModal').modal('hide');
            clear_pg_detail_panel();
            pg_intialize(0);
        }else{
            show_alarm_module(true,"修改失败！");
        }
    });
}



function get_pg_proj(pgid){
    var map={
        action:"PGProj",
        id: pgid
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        pg_selected_proj = result.ret;
    });
}
function pg_intialize(start) {
    pg_initial = true;
    pg_table = null;
    get_pg_table(start, table_row * 5);
    clear_pg_detail_panel();
    get_project_list();
    window.setTimeout("draw_pg_table_head()", wait_time_middle);
}
function draw_pg_table_head(){
    var page_number = Math.ceil((pg_table.length-1)/table_row);

    $("#PG_Page_control").empty();
    var txt = "<li>"+
        "<a href='#' id='pg_page_prev'>Prev</a>"+
        "</li>";
    var page_start_number = Math.ceil(pg_start/table_row);
    for(var i=0;i<page_number;i++){
        txt=txt+ "<li>"+
            "<a href='#' id='pg_page_"+i+"'>"+(i+page_start_number+1)+"</a>"+
            "</li>";
    }
    txt=txt+"<li>"+
        "<a href='#' id='pg_page_next'>Next</a>"+
        "</li>";
    $("#PG_Page_control").append(txt);
    table_head="<thead>"+
        "<tr>"+"<th>编号</th> <th>名称 </th> <th>责任人 </th> <th>电话 </th> <th>单位 </th>";
    table_head=table_head+"</tr></thread>";
    for(var i=0;i<page_number;i++){
        $("#pg_page_"+i).on('click',function(){
            draw_pg_table($(this));
        });
    }
    if(pg_start<=0){
        $("#pg_page_prev").css("display","none");
    }else{
        $("#pg_page_prev").css("display","block");
        $("#pg_page_prev").on('click',function(){
            var new_start = pg_start-(table_row*5);
            if(new_start<0) new_start =0;
            pg_intialize(new_start);
        });
    }

    if((pg_start+(table_row*5))>=pg_total){
        $("#pg_page_next").css("display","none");
    }else{
        $("#pg_page_next").css("display","block");
        $("#pg_page_next").on('click',function(){
            pg_intialize(pg_start+(table_row*5));
        });
    }

    draw_pg_table($("#pg_page_0"));
}
function draw_pg_table(data){

    $("#Table_pg").empty();
    var sequence = (parseInt(data.html())-1)*table_row-pg_start;
    var txt = table_head;
    txt = txt +"<tbody>";
    for(var i=0;i<table_row;i++){
        if((sequence+i)<pg_table.length){
            if(0!=i%2){
                txt =txt+ "<tr class='success' id='pg_table_cell"+i+"' PGCode='"+pg_table[sequence+i].PGCode+"'>";
            }else{ txt =txt+ "<tr  id='pg_table_cell"+i+"' PGCode='"+pg_table[sequence+i].PGCode+"'>";}
            txt = txt +"<td>" + pg_table[sequence+i].PGCode+"</td>"
                +"<td>" + pg_table[sequence+i].PGName+"</td>"
                +"<td>" + pg_table[sequence+i].ChargeMan+"</td>"
                +"<td>" + pg_table[sequence+i].Telephone+"</td>";
            txt = txt +"<td>" + pg_table[sequence+i].Department+"</td>";

            txt = txt +"</tr>"
        }else{
            if(0!=i%2){
                txt =txt+ "<tr class='success' id='pg_table_cell"+i+"' PGCode='null'>";
            }else{ txt =txt+ "<tr  id='pg_table_cell"+i+"' PGCode='null'>";}
            txt = txt +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>";
            txt = txt +"</tr>"
        }

    }
    txt = txt+"</tbody>";

    $("#Table_pg").append(txt);
    for(var i=0;i<table_row;i++){
        $("#pg_table_cell"+i).on('click',function(){
            if($(this).attr("PGCode") !="null"){
                for(var i=0;i<pg_table.length;i++){
                    if($(this).attr("PGCode") == pg_table[i].PGCode){
                        pg_selected =pg_table[i];
                        break;
                    }
                }

                Initialize_pg_detail();
            }

        });
    }
    touchcookie();
}
function Initialize_pg_detail(){
    get_pg_proj(pg_selected.PGCode);
    window.setTimeout("draw_pg_detail_panel()", wait_time_short);
}
function clear_pg_detail_panel(){
    pg_selected = null;

    var txt = "<p></p><p></p>"+
        "<label style='min-width: 150px'>项目组编号：</label><label style='min-width: 150px'>项目组名称：</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>负责人：</label>"+"<p></p>"+"<label style='min-width: 150px'>电话：</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>单位：</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>地址：</label>"+
        "<p></p>"+
        "<label>备注：</label>";

    $("#Label_pg_detail").empty();
    $("#Label_pg_detail").append(txt);
    $("#Table_pg_proj").empty();
}
function draw_pg_detail_panel(){
    $("#Label_pg_detail").empty();


    var txt = "<p></p><p></p>"+
        "<label style='min-width: 150px'>项目组编号："+pg_selected.PGCode+"</label><label style='min-width: 150px'>项目组名称："+pg_selected.PGName+"</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>负责人："+pg_selected.ChargeMan+"</label>"+"<p></p>"+"<label style='min-width: 150px'>电话："+pg_selected.Telephone+"</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>单位："+pg_selected.Department+"</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>地址："+pg_selected.Address+"</label>"+
        "<p></p>"+
        "<label>备注："+pg_selected.Stage+"</label>";
    $("#Label_pg_detail").append(txt);

    $("#Table_pg_proj").empty();
    txt ="<thead> <tr> <th>下辖项目清单 </th> </tr> </thead> <tbody >";
    for(var i=0;i<pg_selected_proj.length;i++){
        txt = txt + "<tr> <td>"+ pg_selected_proj[i].name+"</td> </tr>";
    }
    txt = txt+ "</tbody>";
    $("#Table_pg_proj").append(txt);

}
function show_new_pg_module(){

    $("#newPGModalLabel").text("创建新项目组")
    pg_module_status = true;

    $("#PGPGCode_Input").val("");
    $('#PGPGCode_Input').attr("disabled",false);
    $("#PGPGName_Input").val("");
    $("#PGChargeMan_Input").val("");
    $("#PGTelephone_Input").val("");
    $("#PGDepartment_Input").val("");
    $("#PGAddress_Input").val("");
    $("#PGStage_Input").val("");
    $("#PGPGCode_Input").attr("placeholder","项目组编号");
    $("#PGPGName_Input").attr("placeholder","项目组名称");
    $("#PGChargeMan_Input").attr("placeholder","负责人姓名");
    $("#PGTelephone_Input").attr("placeholder","联系电话");
    $("#PGDepartment_Input").attr("placeholder","单位名称");
    $("#PGAddress_Input").attr("placeholder","地址");

    $("#duallistboxPGProj_new").empty();
    var txt = "";
    for(var i =0;i<project_list.length;i++){
        txt = "<option value='"+project_list[i].id+"'>"+project_list[i].name+"</option>";
        $("#duallistboxPGProj_new").append(txt);
    }
    //$("#duallistboxPGProj_new").append(txt);
    $('.NewPGProjDual').bootstrapDualListbox('refresh', true);

    /*
     NewUserAuthDual2 = $('.NewUserAuthDual').bootstrapDualListbox(
     { nonSelectedListLabel: '全部项目', selectedListLabel: '用户权限', preserveSelectionOnMove: 'moved', moveOnSelect: true, nonSelectedFilter: '',showFilterInputs: false,infoText:""});
     $("#showValue").click(function () { alert($('[name="duallistbox_demo1"]').val());});
     */


    modal_middle($('#newPGModal'));

    $('#newPGModal').modal('show');

}
function submit_new_pg_module(){
    var new_PGPGCode = $("#PGPGCode_Input").val();
    var new_PGPGName = $("#PGPGName_Input").val();
    var new_PGChargeMan = $("#PGChargeMan_Input").val();
    var new_PGTelephone = $("#PGTelephone_Input").val();
    var new_PGDepartment = $("#PGDepartment_Input").val();
    var new_PGAddress = $("#PGAddress_Input").val();
    var new_PGStage = $("#PGStage_Input").val();

    if(new_PGPGCode == null || new_PGPGCode == ""){
        $("#PGPGCode_Input").attr("placeholder","项目组号不能为空");
        $("#PGPGCode_Input").focus();
        return;
    }
    if(new_PGPGName == null || new_PGPGName == ""){
        $("#PGPGName_Input").attr("placeholder","项目组名称不能为空");
        $("#PGPGName_Input").focus();
        return;
    }
    if(new_PGChargeMan == null || new_PGChargeMan == ""){
        $("#PGChargeMan_Input").attr("placeholder","负责人姓名不能为空");
        $("#PGChargeMan_Input").focus();
        return;
    }
    if(new_PGTelephone == null || new_PGTelephone == ""){
        $("#PGTelephone_Input").attr("placeholder","联系电话不能为空");
        $("#PGTelephone_Input").focus();
        return;
    }
    if(new_PGDepartment == null || new_PGDepartment == ""){
        $("#PGDepartment_Input").attr("placeholder","单位名称不能为空");
        $("#PGDepartment_Input").focus();
        return;
    }
    if(new_PGAddress == null || new_PGAddress == ""){
        $("#PGAddress_Input").attr("placeholder","地址不能为空");
        $("#PGAddress_Input").focus();
        return;
    }

    var pg = {
        PGCode: new_PGPGCode,
        PGName:new_PGPGName,
        ChargeMan:new_PGChargeMan,
        Telephone:new_PGTelephone,
        Department:new_PGDepartment,
        Address:new_PGAddress,
        Stage:new_PGStage
    };

    var proj = new Array();
    $('#duallistboxPGProj_new :selected').each(function(i, selected) {
        var temp = {
            id:$(selected).val(),
            name:$(selected).text()
        }
        proj.push(temp);
    });
    new_pg(pg,proj);
}
function show_mod_pg_module(pg,pg_proj){
    $("#newPGModalLabel").text("项目组修改")
    pg_module_status = false;
    $("#PGPGCode_Input").val(pg.PGCode);
    $('#PGPGCode_Input').attr("disabled",true);
    $("#PGPGName_Input").val(pg.PGName);
    $("#PGChargeMan_Input").val(pg.ChargeMan);
    $("#PGTelephone_Input").val(pg.Telephone);
    $("#PGDepartment_Input").val(pg.Department);
    $("#PGAddress_Input").val(pg.Address);
    $("#PGStage_Input").val(pg.Stage);
    $("#PGPGCode_Input").attr("placeholder","项目号");
    $("#PGPGName_Input").attr("placeholder","项目名称");
    $("#PGChargeMan_Input").attr("placeholder","负责人姓名");
    $("#PGTelephone_Input").attr("placeholder","联系电话");
    $("#PGDepartment_Input").attr("placeholder","单位名称");
    $("#PGAddress_Input").attr("placeholder","地址");

    $("#duallistboxPGProj_new").empty();
    var txt = "";
    for(var i =0;i<project_list.length;i++){
        txt = "<option value='"+project_list[i].id+"'";
        for(var j=0;j<pg_proj.length;j++){
            if(pg_proj[j].id == project_list[i].id){
                txt = txt +"selected='selected'";
                break;
            }
        }
        txt = txt +">"+project_list[i].name+"</option>";
        $("#duallistboxPGProj_new").append(txt);
    }
    //$("#duallistboxPGProj_new").append(txt);
    $('.NewPGProjDual').bootstrapDualListbox('refresh', true);



    modal_middle($('#newPGModal'));

    $('#newPGModal').modal('show');
}
function submit_mod_pg_module(){
    var new_PGPGCode = $("#PGPGCode_Input").val();
    var new_PGPGName = $("#PGPGName_Input").val();
    var new_PGChargeMan = $("#PGChargeMan_Input").val();
    var new_PGTelephone = $("#PGTelephone_Input").val();
    var new_PGDepartment = $("#PGDepartment_Input").val();
    var new_PGAddress = $("#PGAddress_Input").val();
    var new_PGStage = $("#PGStage_Input").val();

    var pg = {
        PGCode: new_PGPGCode,
        PGName:new_PGPGName,
        ChargeMan:new_PGChargeMan,
        Telephone:new_PGTelephone,
        Department:new_PGDepartment,
        Address:new_PGAddress,
        Stage:new_PGStage
    };

    var proj = new Array();
    $('#duallistboxPGProj_new :selected').each(function(i, selected) {
        var temp = {
            id:$(selected).val(),
            name:$(selected).text()
        }
        proj.push(temp);
    });
    modify_pg(pg,proj);
}
/*
 Project view function part
 */


function get_proj_table(start,length){
    var map={
        action:"ProjTable",
        startseq: start,
        length:length,
        user:usr.id
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        project_table = result.ret;

        project_start = parseInt(result.start);
        project_total = parseInt(result.total);
    });
}
function del_proj(StatCode){
    var map={
        action:"ProjDel",
        StatCode: StatCode,
        user:usr.id
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"删除成功！");
            clear_proj_detail_panel();
            proj_intialize(0);
        }else{
            show_alarm_module(true,"删除失败！");
        }
    });
    $("#ProjDelAlarm").modal('hide');

}
function new_proj(project){
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
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"创建成功！");
            $('#newProjModal').modal('hide');
            clear_proj_detail_panel();
            proj_intialize(0);
        }else{
            show_alarm_module(true,"创建失败！");
        }
    });
}
function modify_proj(project){
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
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"修改成功！");
            $('#newProjModal').modal('hide');
            clear_proj_detail_panel();
            proj_intialize(0);
        }else{
            show_alarm_module(true,"修改失败！");
        }
    });
}



function get_proj_point(ProjCode){
    var map={
        action:"ProjPoint",
        ProjCode: ProjCode
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        project_selected_point = result.ret;
    });
}
function proj_intialize(start) {
    project_initial = true;
    project_table = null;
    get_proj_table(start, table_row * 5);
    window.setTimeout("draw_proj_table_head()", wait_time_middle);
}
function draw_proj_table_head(){
    var page_number = Math.ceil((project_table.length-1)/table_row);

    $("#Proj_Page_control").empty();
    var txt = "<li>"+
        "<a href='#' id='proj_page_prev'>Prev</a>"+
        "</li>";
    var page_start_number = Math.ceil(project_start/table_row);
    for(var i=0;i<page_number;i++){
        txt=txt+ "<li>"+
            "<a href='#' id='proj_page_"+i+"'>"+(i+page_start_number+1)+"</a>"+
            "</li>";
    }
    txt=txt+"<li>"+
        "<a href='#' id='proj_page_next'>Next</a>"+
        "</li>";
    $("#Proj_Page_control").append(txt);
    table_head="<thead>"+
        "<tr>"+"<th>编号</th> <th>名称 </th> <th>责任人 </th> <th>电话 </th> <th>单位 </th>";
    table_head=table_head+"</tr></thread>";
    for(var i=0;i<page_number;i++){
        $("#proj_page_"+i).on('click',function(){
            draw_proj_table($(this));
        });
    }
    if(project_start<=0){
        $("#proj_page_prev").css("display","none");
    }else{
        $("#proj_page_prev").css("display","block");
        $("#proj_page_prev").on('click',function(){
            var new_start = project_start-(table_row*5);
            if(new_start<0) new_start =0;
            proj_intialize(new_start);
        });
    }

    if((project_start+(table_row*5))>=project_total){
        $("#proj_page_next").css("display","none");
    }else{
        $("#proj_page_next").css("display","block");
        $("#proj_page_next").on('click',function(){
            proj_intialize(project_start+(table_row*5));
        });
    }

    draw_proj_table($("#proj_page_0"));
}
function draw_proj_table(data){

    $("#Table_proj").empty();
    var sequence = (parseInt(data.html())-1)*table_row-project_start;
    var txt = table_head;
    txt = txt +"<tbody>";
    for(var i=0;i<table_row;i++){
        if((sequence+i)<project_table.length){
            if(0!=i%2){
                txt =txt+ "<tr class='success' id='proj_table_cell"+i+"' ProjCode='"+project_table[sequence+i].ProjCode+"'>";
            }else{ txt =txt+ "<tr  id='proj_table_cell"+i+"' ProjCode='"+project_table[sequence+i].ProjCode+"'>";}
            txt = txt +"<td>" + project_table[sequence+i].ProjCode+"</td>"
                +"<td>" + project_table[sequence+i].ProjName+"</td>"
                +"<td>" + project_table[sequence+i].ChargeMan+"</td>"
                +"<td>" + project_table[sequence+i].Telephone+"</td>"
                +"<td>" + project_table[sequence+i].Department+"</td>";
            txt = txt +"</tr>"
        }else{
            if(0!=i%2){
                txt =txt+ "<tr class='success' id='proj_table_cell"+i+"' ProjCode='null'>";
            }else{ txt =txt+ "<tr  id='proj_table_cell"+i+"' ProjCode='null'>";}
            txt = txt +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>";
            txt = txt +"</tr>"
        }

    }
    txt = txt+"</tbody>";

    $("#Table_proj").append(txt);
    for(var i=0;i<table_row;i++){
        $("#proj_table_cell"+i).on('click',function(){
            if($(this).attr("ProjCode") !="null"){
                for(var i=0;i<project_table.length;i++){
                    if($(this).attr("ProjCode") == project_table[i].ProjCode){
                        project_selected =project_table[i];
                        break;
                    }
                }

                Initialize_proj_detail();
            }

        });
    }
    touchcookie();
}

function Initialize_proj_detail(){
    get_proj_point(project_selected.ProjCode);
    window.setTimeout("draw_proj_detail_panel()", wait_time_short);
}
function clear_proj_detail_panel(){
    project_selected = null;

    var txt = "<p></p><p></p>"+
        "<label style='min-width: 150px'>项目编号：</label><label style='min-width: 150px'>项目名称：</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>负责人：</label>"+"<p></p>"+"<label style='min-width: 150px'>电话：</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>单位：</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>地址：</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>开工日期：</label>"+
        "<p></p>"+
        "<label>备注：</label>";

    $("#Label_proj_detail").empty();
    $("#Label_proj_detail").append(txt);
    $("#Table_proj_point").empty();
}
function draw_proj_detail_panel(){
    $("#Label_proj_detail").empty();


    var txt = "<p></p><p></p>"+
        "<label style='min-width: 150px'>项目编号："+project_selected.ProjCode+"</label><label style='min-width: 150px'>项目名称："+project_selected.ProjName+"</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>负责人："+project_selected.ChargeMan+"</label>"+"<p></p>"+"<label style='min-width: 150px'>电话："+project_selected.Telephone+"</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>单位："+project_selected.Department+"</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>地址："+project_selected.Address+"</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>开工日期："+project_selected.ProStartTime+"</label>"+
        "<p></p>"+
        "<label>备注："+project_selected.Stage+"</label>";
    $("#Label_proj_detail").append(txt);

    $("#Table_proj_point").empty();
    txt ="<thead> <tr> <th>监控点清单 </th> </tr> </thead> <tbody >";
    for(var i=0;i<project_selected_point.length;i++){
        txt = txt + "<tr> <td>"+ project_selected_point[i].name+"</td> </tr>";
    }
    txt = txt+ "</tbody>";
    $("#Table_proj_point").append(txt);

}
function show_new_proj_module(){

    $("#newProjModalLabel").text("创建新项目")
    project_module_status = true;

    $("#ProjProjCode_Input").val("");
    $('#ProjProjCode_Input').attr("disabled",false);
    $("#ProjProjName_Input").val("");
    $("#ProjChargeMan_Input").val("");
    $("#ProjTelephone_Input").val("");
    $("#ProjDepartment_Input").val("");
    $("#ProjAddress_Input").val("");
    $("#ProjProStartTime_Input").val("");
    $("#ProjStage_Input").val("");
    $("#ProjProjCode_Input").attr("placeholder","项目号");
    $("#ProjProjName_Input").attr("placeholder","项目名称");
    $("#ProjChargeMan_Input").attr("placeholder","负责人姓名");
    $("#ProjTelephone_Input").attr("placeholder","联系电话");
    $("#ProjDepartment_Input").attr("placeholder","单位名称");
    $("#ProjAddress_Input").attr("placeholder","地址");
    $("#ProjProStartTime_Input").attr("placeholder","开工时间");


    modal_middle($('#newProjModal'));

    $('#newProjModal').modal('show');

}
function submit_new_proj_module(){
    var new_ProjProjCode = $("#ProjProjCode_Input").val();
    var new_ProjProjName = $("#ProjProjName_Input").val();
    var new_ProjChargeMan = $("#ProjChargeMan_Input").val();
    var new_ProjTelephone = $("#ProjTelephone_Input").val();
    var new_ProjDepartment = $("#ProjDepartment_Input").val();
    var new_ProjAddress = $("#ProjAddress_Input").val();
    var new_ProjProStartTime = $("#ProjProStartTime_Input").val();
    var new_ProjStage = $("#ProjStage_Input").val();

    if(new_ProjProjCode == null || new_ProjProjCode == ""){
        $("#ProjProjCode_Input").attr("placeholder","项目号不能为空");
        $("#ProjProjCode_Input").focus();
        return;
    }
    if(new_ProjProjName == null || new_ProjProjName == ""){
        $("#ProjProjName_Input").attr("placeholder","项目名称不能为空");
        $("#ProjProjName_Input").focus();
        return;
    }
    if(new_ProjChargeMan == null || new_ProjChargeMan == ""){
        $("#ProjChargeMan_Input").attr("placeholder","负责人姓名不能为空");
        $("#ProjChargeMan_Input").focus();
        return;
    }
    if(new_ProjTelephone == null || new_ProjTelephone == ""){
        $("#ProjTelephone_Input").attr("placeholder","联系电话不能为空");
        $("#ProjTelephone_Input").focus();
        return;
    }
    if(new_ProjDepartment == null || new_ProjDepartment == ""){
        $("#ProjDepartment_Input").attr("placeholder","单位名称不能为空");
        $("#ProjDepartment_Input").focus();
        return;
    }
    if(new_ProjAddress == null || new_ProjAddress == ""){
        $("#ProjAddress_Input").attr("placeholder","地址不能为空");
        $("#ProjAddress_Input").focus();
        return;
    }
    if(new_ProjProStartTime == null || new_ProjProStartTime == ""){
        $("#ProjProStartTime_Input").attr("placeholder","开工时间不能为空");
        $("#ProjProStartTime_Input").focus();
        return;
    }

    var project = {
        ProjCode: new_ProjProjCode,
        ProjName:new_ProjProjName,
        ChargeMan:new_ProjChargeMan,
        Telephone:new_ProjTelephone,
        Department:new_ProjDepartment,
        Address:new_ProjAddress,
        ProStartTime:new_ProjProStartTime,
        Stage:new_ProjStage
    };
    new_proj(project);
}
function show_mod_proj_module(project){
    $("#newProjModalLabel").text("项目修改")
    project_module_status = false;
    //StatCode: (start+(i+1)),
    //StatName:"项目名"+(start+i),
    //ChargeMan:"用户"+(start+i),
    //Telephone:"139139"+(start+i),
    //Longitude:"121.0000",
    //Latitude:"31.0000",
    //Department:"单位"+(start+i),
    //Address:"地址"+(start+i),
    //Country:"区县"+(start+i),
    //Street:"街镇"+(start+i),
    //Square:"10000",
    //ProStartTime:"2016-01-01",
    //Stage:"备注"+(start+i)
    $("#ProjProjCode_Input").val(project.ProjCode);
    $('#ProjProjCode_Input').attr("disabled",true);
    $("#ProjProjName_Input").val(project.ProjName);
    $("#ProjChargeMan_Input").val(project.ChargeMan);
    $("#ProjTelephone_Input").val(project.Telephone);
    $("#ProjDepartment_Input").val(project.Department);
    $("#ProjAddress_Input").val(project.Address);
    $("#ProjProStartTime_Input").val(project.ProStartTime);
    $("#ProjStage_Input").val(project.Stage);
    $("#ProjProjCode_Input").attr("placeholder","项目号");
    $("#ProjProjName_Input").attr("placeholder","项目名称");
    $("#ProjChargeMan_Input").attr("placeholder","负责人姓名");
    $("#ProjTelephone_Input").attr("placeholder","联系电话");
    $("#ProjDepartment_Input").attr("placeholder","单位名称");
    $("#ProjAddress_Input").attr("placeholder","地址");
    $("#ProjProStartTime_Input").attr("placeholder","开工时间");

    modal_middle($('#newProjModal'));

    $('#newProjModal').modal('show');
}
function submit_mod_proj_module(){
    var new_ProjProjCode = $("#ProjProjCode_Input").val();
    var new_ProjProjName = $("#ProjProjName_Input").val();
    var new_ProjChargeMan = $("#ProjChargeMan_Input").val();
    var new_ProjTelephone = $("#ProjTelephone_Input").val();
    var new_ProjDepartment = $("#ProjDepartment_Input").val();
    var new_ProjAddress = $("#ProjAddress_Input").val();
    var new_ProjProStartTime = $("#ProjProStartTime_Input").val();
    var new_ProjStage = $("#ProjStage_Input").val();


    var project = {
        ProjCode: new_ProjProjCode,
        ProjName:new_ProjProjName,
        ChargeMan:new_ProjChargeMan,
        Telephone:new_ProjTelephone,
        Department:new_ProjDepartment,
        Address:new_ProjAddress,
        ProStartTime:new_ProjProStartTime,
        Stage:new_ProjStage
    };
    modify_proj(project);
}

/*
 Monitor point view function part
 */


function get_point_table(start,length){
    var map={
        action:"PointTable",
        startseq: start,
        length:length,
        user:usr.id
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        point_table = result.ret;

        point_start = parseInt(result.start);
        point_total = parseInt(result.total);
    });
}
function del_point(StatCode){
    var map={
        action:"PointDel",
        StatCode: StatCode,
        user:usr.id
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"删除成功！");
            clear_point_detail_panel();
            point_intialize(0);
        }else{
            show_alarm_module(true,"删除失败！");
        }
    });
    $("#PointDelAlarm").modal('hide');

}
function new_point(point){
    var map={
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
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"创建成功！");
            $('#newPointModal').modal('hide');
            clear_point_detail_panel();
            point_intialize(0);
        }else{
            show_alarm_module(true,"创建失败！");
        }
    });
}
function modify_point(point){
    var map={
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
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"修改成功！");
            $('#newPointModal').modal('hide');
            clear_point_detail_panel();
            point_intialize(0);
        }else{
            show_alarm_module(true,"修改失败！");
        }
    });
}



function get_point_device(StatCode){
    var map={
        action:"PointDev",
        StatCode: StatCode
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        point_selected_device = result.ret;
    });
}
function point_intialize(start) {
    point_initial = true;
    point_table = null;
    get_project_list();
    get_point_table(start, table_row * 5);
    window.setTimeout("draw_point_table_head()", wait_time_middle);
}
function draw_point_table_head(){
    var page_number = Math.ceil((point_table.length-1)/table_row);

    $("#Point_Page_control").empty();
    var txt = "<li>"+
        "<a href='#' id='point_page_prev'>Prev</a>"+
        "</li>";
    var page_start_number = Math.ceil(point_start/table_row);
    for(var i=0;i<page_number;i++){
        txt=txt+ "<li>"+
            "<a href='#' id='point_page_"+i+"'>"+(i+page_start_number+1)+"</a>"+
            "</li>";
    }
    txt=txt+"<li>"+
        "<a href='#' id='point_page_next'>Next</a>"+
        "</li>";
    $("#Point_Page_control").append(txt);
    table_head="<thead>"+
        "<tr>"+"<th>编号</th> <th>名称 </th> <th>项目</th> <th>责任人 </th> <th>电话 </th> ";
    table_head=table_head+"</tr></thread>";
    for(var i=0;i<page_number;i++){
        $("#point_page_"+i).on('click',function(){
            draw_point_table($(this));
        });
    }
    if(point_start<=0){
        $("#point_page_prev").css("display","none");
    }else{
        $("#point_page_prev").css("display","block");
        $("#point_page_prev").on('click',function(){
            var new_start = point_start-(table_row*5);
            if(new_start<0) new_start =0;
            point_intialize(new_start);
        });
    }

    if((point_start+(table_row*5))>=point_total){
        $("#point_page_next").css("display","none");
    }else{
        $("#point_page_next").css("display","block");
        $("#point_page_next").on('click',function(){
            point_intialize(point_start+(table_row*5));
        });
    }

    draw_point_table($("#point_page_0"));
}
function draw_point_table(data){

    $("#Table_point").empty();
    var sequence = (parseInt(data.html())-1)*table_row-point_start;
    var txt = table_head;
    txt = txt +"<tbody>";
    for(var i=0;i<table_row;i++){
        if((sequence+i)<point_table.length){
            var projname ="";
            for(var j=0;j<project_list.length;j++){
                if(point_table[sequence+i].ProjCode == project_list[j].id){
                    projname = project_list[j].name;break;
                }
            }
            if(0!=i%2){
                txt =txt+ "<tr class='success' id='point_table_cell"+i+"' StatCode='"+point_table[sequence+i].StatCode+"'>";
            }else{ txt =txt+ "<tr  id='point_table_cell"+i+"' StatCode='"+point_table[sequence+i].StatCode+"'>";}
            txt = txt +"<td>" + point_table[sequence+i].StatCode+"</td>"
                +"<td>" + point_table[sequence+i].StatName+"</td>"
                +"<td>" + projname+"</td>"
                +"<td>" + point_table[sequence+i].ChargeMan+"</td>"
                +"<td>" + point_table[sequence+i].Telephone+"</td>";

            txt = txt +"</tr>"
        }else{
            if(0!=i%2){
                txt =txt+ "<tr class='success' id='point_table_cell"+i+"' StatCode='null'>";
            }else{ txt =txt+ "<tr  id='point_table_cell"+i+"' StatCode='null'>";}
            txt = txt +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>";
            txt = txt +"</tr>"
        }

    }
    txt = txt+"</tbody>";

    $("#Table_point").append(txt);
    for(var i=0;i<table_row;i++){
        $("#point_table_cell"+i).on('click',function(){
            if($(this).attr("StatCode") !="null"){
                for(var i=0;i<point_table.length;i++){
                    if($(this).attr("StatCode") == point_table[i].StatCode){
                        point_selected =point_table[i];
                        break;
                    }
                }
                Initialize_point_detail();
            }
        });
    }
    touchcookie();
}

function Initialize_point_detail(){
    get_point_device(point_selected.StatCode);
    window.setTimeout("draw_point_detail_panel()", wait_time_short);
}
function clear_point_detail_panel(){
    point_selected = null;

    var txt = "<p></p><p></p>"+
        "<label style='min-width: 150px'>监测点编号：</label><label style='min-width: 150px'>监测点名称：</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>负责人：</label>"+"<label style='min-width: 150px'>电话：</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>关联项目：</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>经度：</label>"+"<p></p>"+"<label style='min-width: 150px'>纬度：</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>单位：</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>区县：</label>"+"<p></p>"+"<label style='min-width: 150px'>街镇：</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>地址：</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>面积：</label>"+"<p></p>"+"<label style='min-width: 150px'>开工日期：</label>"+
        "<p></p>"+
        "<label>备注：</label>";

    $("#Label_point_detail").empty();
    $("#Label_point_detail").append(txt);
    $("#Table_point_device").empty();
}
function draw_point_detail_panel(){
    $("#Label_point_detail").empty();

    var projname ="";
    for(var j=0;j<project_list.length;j++){
        if(point_selected.ProjCode == project_list[j].id){
            projname = project_list[j].name;break;
        }
    }
    var txt = "<p></p><p></p>"+
        "<label style='min-width: 150px'>监测点编号："+point_selected.StatCode+"</label><label style='min-width: 150px'>监测点名称："+point_selected.StatName+"</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>负责人："+point_selected.ChargeMan+"</label>"+"<p></p>"+"<label style='min-width: 150px'>电话："+point_selected.Telephone+"</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>关联项目："+projname+"</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>经度："+point_selected.Longitude+"</label>"+"<p></p>"+"<label style='min-width: 150px'>纬度："+point_selected.Latitude+"</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>单位："+point_selected.Department+"</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>区县："+point_selected.Country+"</label>"+"<p></p>"+"<label style='min-width: 150px'>街镇："+point_selected.Street+"</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>地址："+point_selected.Address+"</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>面积："+point_selected.Square+"</label>"+"<p></p>"+"<label style='min-width: 150px'>开工日期："+point_selected.ProStartTime+"</label>"+
        "<p></p>"+
        "<label>备注："+point_selected.Stage+"</label>";
    $("#Label_point_detail").append(txt);

    $("#Table_point_device").empty();
    txt ="<thead> <tr> <th>监控设备清单 </th> </tr> </thead> <tbody >";
    for(var i=0;i<point_selected_device.length;i++){
        txt = txt + "<tr> <td>"+ point_selected_device[i].name+"</td> </tr>";
    }
    txt = txt+ "</tbody>";
    $("#Table_point_device").append(txt);

}
function show_new_point_module(){

    $("#newPointModalLabel").text("创建监测点")
    point_module_status = true;

    $("#PointStatCode_Input").val("");
    $('#PointStatCode_Input').attr("disabled",false);
    $("#PointStatName_Input").val("");
    $("#PointChargeMan_Input").val("");
    $("#PointTelephone_Input").val("");
    $("#PointLongitude_Input").val("");
    $("#PointLatitude_Input").val("");
    $("#PointDepartment_Input").val("");
    $("#PointAddress_Input").val("");
    $("#PointCountry_Input").val("");
    $("#PointStreet_Input").val("");
    $("#PointSquare_Input").val("");
    $("#PointProStartTime_Input").val("");
    $("#PointStage_Input").val("");
    $("#PointProjCode_choice").empty();
    $("#PointProjCode_choice").append(get_proj_option());

    $("#PointStatCode_Input").attr("placeholder","监控点号");
    $("#PointStatName_Input").attr("placeholder","监控点名称");
    $("#PointChargeMan_Input").attr("placeholder","负责人姓名");
    $("#PointTelephone_Input").attr("placeholder","联系电话");
    $("#PointLongitude_Input").attr("placeholder","经度");
    $("#PointLatitude_Input").attr("placeholder","纬度");
    $("#PointDepartment_Input").attr("placeholder","单位名称");
    $("#PointAddress_Input").attr("placeholder","地址");
    $("#PointCountry_Input").attr("placeholder","区县");
    $("#PointStreet_Input").attr("placeholder","街镇");
    $("#PointSquare_Input").attr("placeholder","施工面积(平方米)");
    $("#PointProStartTime_Input").attr("placeholder","开工时间");


    modal_middle($('#newPointModal'));

    $('#newPointModal').modal('show');

}
function submit_new_point_module(){
    var new_PointStatCode = $("#PointStatCode_Input").val();
    var new_PointStatName = $("#PointStatName_Input").val();
    var new_PointProjCode = $("#PointProjCode_choice").val();
    var new_PointChargeMan = $("#PointChargeMan_Input").val();
    var new_PointTelephone = $("#PointTelephone_Input").val();
    var new_PointLongitude = $("#PointLongitude_Input").val();
    var new_PointLatitude = $("#PointLatitude_Input").val();
    var new_PointDepartment = $("#PointDepartment_Input").val();
    var new_PointAddress = $("#PointAddress_Input").val();
    var new_PointCountry = $("#PointCountry_Input").val();
    var new_PointStreet = $("#PointStreet_Input").val();
    var new_PointSquare = $("#PointSquare_Input").val();
    var new_PointProStartTime = $("#PointProStartTime_Input").val();
    var new_PointStage = $("#PointStage_Input").val();

    if(new_PointStatCode == null || new_PointStatCode == ""){
        $("#PointStatCode_Input").attr("placeholder","监测点号不能为空");
        $("#PointStatCode_Input").focus();
        return;
    }
    if(new_PointStatName == null || new_PointStatName == ""){
        $("#PointStatName_Input").attr("placeholder","监测点名称不能为空");
        $("#PointStatName_Input").focus();
        return;
    }
    if(new_PointChargeMan == null || new_PointChargeMan == ""){
        $("#PointChargeMan_Input").attr("placeholder","负责人姓名不能为空");
        $("#PointChargeMan_Input").focus();
        return;
    }
    if(new_PointProjCode == null || new_PointProjCode == ""){
        $("#PointProjCode_choice").attr("placeholder","项目不能为空");
        $("#PointProjCode_choice").focus();
        return;
    }
    if(new_PointTelephone == null || new_PointTelephone == ""){
        $("#PointTelephone_Input").attr("placeholder","联系电话不能为空");
        $("#PointTelephone_Input").focus();
        return;
    }
    if(new_PointLongitude == null || new_PointLongitude == ""){
        $("#PointLongitude_Input").attr("placeholder","经度不能为空");
        $("#PointLongitude_Input").focus();
        return;
    }
    if(new_PointLatitude == null || new_PointLatitude == ""){
        $("#PointLatitude_Input").attr("placeholder","纬度不能为空");
        $("#PointLatitude_Input").focus();
        return;
    }
    if(new_PointDepartment == null || new_PointDepartment == ""){
        $("#PointDepartment_Input").attr("placeholder","单位名称不能为空");
        $("#PointDepartment_Input").focus();
        return;
    }
    if(new_PointAddress == null || new_PointAddress == ""){
        $("#PointAddress_Input").attr("placeholder","地址不能为空");
        $("#PointAddress_Input").focus();
        return;
    }
    if(new_PointCountry == null || new_PointCountry == ""){
        $("#PointCountry_Input").attr("placeholder","区县不能为空");
        $("#PointCountry_Input").focus();
        return;
    }
    if(new_PointStreet == null || new_PointStreet == ""){
        $("#PointStreet_Input").attr("placeholder","街镇不能为空");
        $("#PointStreet_Input").focus();
        return;
    }
    if(new_PointSquare == null || new_PointSquare == ""){
        $("#PointSquare_Input").attr("placeholder","施工面积不能为空");
        $("#PointSquare_Input").focus();
        return;
    }
    if(new_PointProStartTime == null || new_PointProStartTime == ""){
        $("#PointProStartTime_Input").attr("placeholder","开工时间不能为空");
        $("#PointProStartTime_Input").focus();
        return;
    }

    var point = {
        StatCode: new_PointStatCode,
        StatName:new_PointStatName,
        ProjCode:new_PointProjCode,
        ChargeMan:new_PointChargeMan,
        Telephone:new_PointTelephone,
        Longitude:new_PointLongitude,
        Latitude:new_PointLatitude,
        Department:new_PointDepartment,
        Address:new_PointAddress,
        Country:new_PointCountry,
        Street:new_PointStreet,
        Square:new_PointSquare,
        ProStartTime:new_PointProStartTime,
        Stage:new_PointStage
    };
    new_point(point);
}
function show_mod_point_module(point){
    $("#newPointModalLabel").text("监测点修改")
    point_module_status = false;
    //StatCode: (start+(i+1)),
    //StatName:"项目名"+(start+i),
    //ChargeMan:"用户"+(start+i),
    //Telephone:"139139"+(start+i),
    //Longitude:"121.0000",
    //Latitude:"31.0000",
    //Department:"单位"+(start+i),
    //Address:"地址"+(start+i),
    //Country:"区县"+(start+i),
    //Street:"街镇"+(start+i),
    //Square:"10000",
    //ProStartTime:"2016-01-01",
    //Stage:"备注"+(start+i)
    $("#PointStatCode_Input").val(point.StatCode);
    $('#PointStatCode_Input').attr("disabled",true);
    $("#PointStatName_Input").val(point.StatName);
    $("#PointChargeMan_Input").val(point.ChargeMan);
    $("#PointTelephone_Input").val(point.Telephone);
    $("#PointLongitude_Input").val(point.Longitude);
    $("#PointLatitude_Input").val(point.Latitude);
    $("#PointDepartment_Input").val(point.Department);
    $("#PointAddress_Input").val(point.Address);
    $("#PointCountry_Input").val(point.Country);
    $("#PointStreet_Input").val(point.Street);
    $("#PointSquare_Input").val(point.Square);
    $("#PointProStartTime_Input").val(point.ProStartTime);
    $("#PointStage_Input").val(point.Stage);
    $("#PointProjCode_choice").empty();
    $("#PointProjCode_choice").append(get_proj_option());
    $("#PointProjCode_choice").val(point.ProjCode);
    $("#PointStatCode_Input").attr("placeholder","监测点号");
    $("#PointStatName_Input").attr("placeholder","监测点名称");
    $("#PointChargeMan_Input").attr("placeholder","负责人姓名");
    $("#PointTelephone_Input").attr("placeholder","联系电话");
    $("#PointLongitude_Input").attr("placeholder","经度");
    $("#PointLatitude_Input").attr("placeholder","纬度");
    $("#PointDepartment_Input").attr("placeholder","单位名称");
    $("#PointAddress_Input").attr("placeholder","地址");
    $("#PointCountry_Input").attr("placeholder","区县");
    $("#PointStreet_Input").attr("placeholder","街镇");
    $("#PointSquare_Input").attr("placeholder","施工面积(平方米)");
    $("#PointProStartTime_Input").attr("placeholder","开工时间");

    modal_middle($('#newPointModal'));

    $('#newPointModal').modal('show');
}
function submit_mod_point_module(){
    var new_PointStatCode = $("#PointStatCode_Input").val();
    var new_PointStatName = $("#PointStatName_Input").val();
    var new_PointProjCode = $("#PointProjCode_choice").val();
    var new_PointChargeMan = $("#PointChargeMan_Input").val();
    var new_PointTelephone = $("#PointTelephone_Input").val();
    var new_PointLongitude = $("#PointLongitude_Input").val();
    var new_PointLatitude = $("#PointLatitude_Input").val();
    var new_PointDepartment = $("#PointDepartment_Input").val();
    var new_PointAddress = $("#PointAddress_Input").val();
    var new_PointCountry = $("#PointCountry_Input").val();
    var new_PointStreet = $("#PointStreet_Input").val();
    var new_PointSquare = $("#PointSquare_Input").val();
    var new_PointProStartTime = $("#PointProStartTime_Input").val();
    var new_PointStage = $("#PointStage_Input").val();


    var point = {
        StatCode: new_PointStatCode,
        StatName:new_PointStatName,
        ProjCode:new_PointProjCode,
        ChargeMan:new_PointChargeMan,
        Telephone:new_PointTelephone,
        Longitude:new_PointLongitude,
        Latitude:new_PointLatitude,
        Department:new_PointDepartment,
        Address:new_PointAddress,
        Country:new_PointCountry,
        Street:new_PointStreet,
        Square:new_PointSquare,
        ProStartTime:new_PointProStartTime,
        Stage:new_PointStage
    };
    modify_point(point);
}

//设备编号 DevCode
//监测点编号 StatCode
//安装时间 StartTime
//预计结束时间 PreEndTime
//实际结束时间 EndTime
//设备是否启动 DevStatus
//视频地址 VideoURL


/*
 Device view function part
 */

function get_proj_point_list(){
    var map={
        action:"ProjPoint"
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        point_list = result.ret;
    });
}
function get_dev_table(start,length){
    var map={
        action:"DevTable",
        startseq: start,
        length:length,
        user:usr.id
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        device_table = result.ret;

        device_start = parseInt(result.start);
        device_total = parseInt(result.total);
    });
}
function del_dev(DevCode){
    var map={
        action:"DevDel",
        StatCode: DevCode,
        user:usr.id
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"删除成功！");
            clear_dev_detail_panel();
            dev_intialize(0);
        }else{
            show_alarm_module(true,"删除失败！");
        }
    });
    $("#DevDelAlarm").modal('hide');

}
function new_dev(device){
    var map={
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
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"创建成功！");
            $('#newDevModal').modal('hide');
            clear_dev_detail_panel();
            dev_intialize(0);
        }else{
            show_alarm_module(true,"创建失败！");
        }
    });
}
function modify_dev(device){
    var map={
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
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "true"){
            show_alarm_module(false,"修改成功！");
            $('#newDevModal').modal('hide');
            clear_dev_detail_panel();
            dev_intialize(0);
        }else{
            show_alarm_module(true,"修改失败！");
        }
    });
}



function dev_intialize(start) {
    device_initial = true;
    device_table = null;
    get_dev_table(start, table_row * 5);
    get_project_list();
    get_proj_point_list();
    window.setTimeout("draw_dev_table_head()", wait_time_middle);
}
function draw_dev_table_head(){
    var page_number = Math.ceil((device_table.length-1)/table_row);

    $("#Dev_Page_control").empty();
    var txt = "<li>"+
        "<a href='#' id='dev_page_prev'>Prev</a>"+
        "</li>";
    var page_start_number = Math.ceil(device_start/table_row);
    for(var i=0;i<page_number;i++){
        txt=txt+ "<li>"+
            "<a href='#' id='dev_page_"+i+"'>"+(i+page_start_number+1)+"</a>"+
            "</li>";
    }
    txt=txt+"<li>"+
        "<a href='#' id='dev_page_next'>Next</a>"+
        "</li>";
    $("#Dev_Page_control").append(txt);
    table_head="<thead>"+
        "<tr>"+"<th>编号 </th> <th>项目名称 </th> <th>测量点名称 </th><th>安装时间 </th> <th>是否启动 </th>";
    table_head=table_head+"</tr></thread>";
    for(var i=0;i<page_number;i++){
        $("#dev_page_"+i).on('click',function(){
            draw_dev_table($(this));
        });
    }
    if(device_start<=0){
        $("#dev_page_prev").css("display","none");
    }else{
        $("#dev_page_prev").css("display","block");
        $("#dev_page_prev").on('click',function(){
            var new_start = device_start-(table_row*5);
            if(new_start<0) new_start =0;
            dev_intialize(new_start);
        });
    }

    if((device_start+(table_row*5))>=device_total){
        $("#dev_page_next").css("display","none");
    }else{
        $("#dev_page_next").css("display","block");
        $("#dev_page_next").on('click',function(){
            dev_intialize(device_start+(table_row*5));
        });
    }

    draw_dev_table($("#dev_page_0"));
}
function draw_dev_table(data){

    $("#Table_dev").empty();
    var sequence = (parseInt(data.html())-1)*table_row-device_start;
    var txt = table_head;
    txt = txt +"<tbody>";
    for(var i=0;i<table_row;i++){
        if((sequence+i)<device_table.length){
            //console.log(sequence+i);
            if(0!=i%2){
                txt =txt+ "<tr class='success' id='dev_table_cell"+i+"' DevCode='"+device_table[sequence+i].DevCode+"'>";
            }else{ txt =txt+ "<tr  id='dev_table_cell"+i+"' DevCode='"+device_table[sequence+i].DevCode+"'>";}

            var type = "开启";
            if(device_table[sequence+i].DevStatus == false) type = "关闭";
            txt = txt +"<td>" + device_table[sequence+i].DevCode+"</td>"
                +"<td>" + get_proj_name(device_table[sequence+i].ProjCode)+"</td>"
                +"<td>" + get_point_name(device_table[sequence+i].StatCode)+"</td>"
                +"<td>" + device_table[sequence+i].StartTime+"</td>"
                +"<td>" + type+"</td>";
            txt = txt +"</tr>"
        }else{
            if(0!=i%2){
                txt =txt+ "<tr class='success' id='dev_table_cell"+i+"' DevCode='null'>";
            }else{ txt =txt+ "<tr  id='dev_table_cell"+i+"' DevCode='null'>";}
            txt = txt +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
                +"<td>--</td>"
            txt = txt +"</tr>"
        }

    }
    txt = txt+"</tbody>";

    $("#Table_dev").append(txt);
    for(var i=0;i<table_row;i++){
        $("#dev_table_cell"+i).on('click',function(){
            if($(this).attr("DevCode") !="null"){
                for(var i=0;i<device_table.length;i++){
                    if($(this).attr("DevCode") == device_table[i].DevCode){
                        device_selected =device_table[i];
                        break;
                    }
                }

                Initialize_dev_detail();
            }

        });
    }
    touchcookie();
}

function Initialize_dev_detail(){
    //get_dev_device(device_selected.StatCode);
    window.setTimeout("draw_dev_detail_panel()", wait_time_short);
}
function clear_dev_detail_panel(){
    project_selected = null;

    var txt = "<p></p><p></p>"+
        "<label style='min-width: 150px'>设备编号：</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>项目：</label>"+
        "<label style='min-width: 150px'>监测点：</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>安装时间：</label>"+"<p></p>"+"<label style='min-width: 150px'>预计结束时间：</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>实际结束时间：</label>"+"<p></p>"+"<label style='min-width: 150px'>设备是否启动：</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>视频地址：</label>";

    $("#Label_dev_detail").empty();
    $("#Label_dev_detail").append(txt);
}
function draw_dev_detail_panel(){
    $("#Label_dev_detail").empty();
    var type = "开启";
    if(device_selected.DevStatus == false) type = "关闭";

    var txt = "<p></p><p></p>"+
        "<label style='min-width: 150px'>设备编号："+device_selected.DevCode+"</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>项目："+get_proj_name(device_selected.ProjCode)+"</label>"+"<label style='min-width: 150px'>监测点："+get_point_name(device_selected.StatCode)+"</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>安装时间："+device_selected.StartTime+"</label>"+"<p></p>"+"<label style='min-width: 150px'>预计结束时间："+device_selected.PreEndTime+"</label>"+
        "<p></p>"+
        "<label style='min-width: 150px'>实际结束时间："+device_selected.EndTime+"</label>"+"<p></p>"+"<label style='min-width: 150px'>设备是否启动："+type+"</label>"+
        "<p></p>"+
        "<label style='min-width: 300px'>视频地址："+device_selected.VideoURL+"</label>";
    $("#Label_dev_detail").append(txt);

}
function show_new_dev_module(){

    $("#newDevModalLabel").text("创建新设备")
    device_module_status = true;
    $('#DevDevCode_Input').attr("disabled",false);
    $("#DevDevCode_Input").val("");
    $("#DevStatCode_choice").empty();
    $("#DevProjCode_choice").empty();
    $("#DevProjCode_choice").append(get_proj_option());
    //console.log($("#DevProjCode_choice").val());
    get_proj_point_option($("#DevProjCode_choice").val(),$("#DevStatCode_choice"),"");
    $("#DevStartTime_Input").val("");
    $("#DevPreEndTime_Input").val("");
    $("#DevEndTime_Input").val("");
    $("#DevDevStatus_choice").val("true");
    $("#DevVideoURL_Input").val("");

    $("#DevDevCode_Input").attr("placeholder","设备编号");
    $("#DevStartTime_Input").attr("placeholder","安装时间");
    $("#DevPreEndTime_Input").attr("placeholder","预计结束时间");
    $("#DevEndTime_Input").attr("placeholder","实际结束时间");


    modal_middle($('#newDevModal'));

    $('#newDevModal').modal('show');

}
function submit_new_dev_module(){
    var new_DevDevCode = $("#DevDevCode_Input").val();
    var new_DevStatCode =$("#DevStatCode_choice").val();
    var new_DevStartTime =$("#DevStartTime_Input").val();
    var new_DevPreEndTime =$("#DevPreEndTime_Input").val();
    var new_DevEndTime =$("#DevEndTime_Input").val();
    var new_DevDevStatus =$("#DevDevStatus_choice").val();
    var new_DevVideoURL =$("#DevVideoURL_Input").val();

    if(new_DevDevCode == null || new_DevDevCode == ""){
        $("#DevDevCode_Input").attr("placeholder","设备号不能为空");
        $("#DevDevCode_Input").focus();
        return;
    }
    if(new_DevStatCode == null || new_DevStatCode == ""){
        $("#DevStatCode_choice").attr("placeholder","项目不能为空");
        $("#DevStatCode_choice").focus();
        return;
    }
    if(new_DevStartTime == null || new_DevStartTime == ""){
        $("#DevStartTime_Input").attr("placeholder","负责人姓名不能为空");
        $("#DevStartTime_Input").focus();
        return;
    }

    var device = {
        DevCode: new_DevDevCode,
        StatCode:new_DevStatCode,
        StartTime:new_DevStartTime,
        PreEndTime:new_DevPreEndTime,
        EndTime:new_DevEndTime,
        DevStatus:new_DevDevStatus,
        VideoURL:new_DevVideoURL
    };
    new_dev(device);
}
function show_mod_dev_module(device){
    $("#newDevModalLabel").text("项目修改");
    device_module_status = false;
    //设备编号 DevCode
    //监测点编号 StatCode
    //安装时间 StartTime
    //预计结束时间 PreEndTime
    //实际结束时间 EndTime
    //设备是否启动 DevStatus
    //视频地址 VideoURL
    $('#DevDevCode_Input').attr("disabled",true);
    $("#DevDevCode_Input").val(device.DevCode);
    $("#DevStatCode_choice").empty();
    $("#DevProjCode_choice").empty();

    $("#DevProjCode_choice").append(get_proj_option(device.ProjCode));
    //console.log($("#DevProjCode_choice").val());
    get_proj_point_option($("#DevProjCode_choice").val(),$("#DevStatCode_choice"),device.StatCode);

    $("#DevStatCode_choice").val(device.StatCode);
    $("#DevStartTime_Input").val(device.StartTime);
    $("#DevPreEndTime_Input").val(device.PreEndTime);
    $("#DevEndTime_Input").val(device.EndTime);
    if(device.DevStatus) $("#DevDevStatus_choice").val("true");
    else $("#DevDevStatus_choice").val("false");
    $("#DevVideoURL_Input").val(device.VideoURL);

    $("#DevDevCode_Input").attr("placeholder","设备编号");
    $("#DevStartTime_Input").attr("placeholder","安装时间");
    $("#DevPreEndTime_Input").attr("placeholder","预计结束时间");
    $("#DevEndTime_Input").attr("placeholder","实际结束时间");

    modal_middle($('#newDevModal'));

    $('#newDevModal').modal('show');
}
function submit_mod_dev_module(){
    var new_DevDevCode = $("#DevDevCode_Input").val();
    var new_DevStatCode =$("#DevStatCode_choice").val();
    var new_DevStartTime =$("#DevStartTime_Input").val();
    var new_DevPreEndTime =$("#DevPreEndTime_Input").val();
    var new_DevEndTime =$("#DevEndTime_Input").val();
    var new_DevDevStatus =$("#DevDevStatus_choice").val();
    var new_DevVideoURL =$("#DevVideoURL_Input").val();


    var device = {
        DevCode: new_DevDevCode,
        StatCode:new_DevStatCode,
        StartTime:new_DevStartTime,
        PreEndTime:new_DevPreEndTime,
        EndTime:new_DevEndTime,
        DevStatus:new_DevDevStatus,
        VideoURL:new_DevVideoURL
    };
    modify_dev(device);
}



function get_proj_name(id){
    var proj_name= null;
    for(var i=0;i<project_list.length;i++){
        if(project_list[i].id == id){
            proj_name = project_list[i].name;
            break;
        }
    }
    return proj_name;
}
function get_point_name(id){
    var point_name= null;
    for(var i=0;i<point_list.length;i++){
        if(point_list[i].id == id){
            point_name = point_list[i].name;
            break;
        }
    }
    return point_name;
}
function get_proj_option(id){
    txt = "";
    for( var i=0; i<project_list.length;i++){
        if(project_list[i].id == id){
            txt = txt +"<option value="+project_list[i].id+" selected='selected'>"+project_list[i].name+"</option>";
        }else{
            txt = txt +"<option value="+project_list[i].id+">"+project_list[i].name+"</option>";
        }
    }
    return txt;
}
function get_proj_point_option(ProjCode,select,select_value){
    select.empty();

    if(ProjCode =="" || ProjCode == null){

        return;
    }
    var txt ="";
    for( var i=0; i<point_list.length;i++){
        if(point_list[i].ProjCode == ProjCode){

            if(point_list[i].id == select_value){
                txt = txt +"<option value="+point_list[i].id+" selected='selected' >"+point_list[i].name+"</option>";
            }else{

                txt = txt +"<option value="+point_list[i].id+">"+point_list[i].name+"</option>";
            }
        }
    }
    select.empty();
    select.append(txt);

}



//warning
function get_monitor_list(){
    var map={
        action:"MonitorList",
        id: usr.id
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        monitor_map_list = result.ret;

        //console.log(monitor_map_list);
    });
}
function get_monitor_warning_on_map(){
    if(monitor_selected == null||monitor_map_handle==null){
        return
    }else{
        var map={
            action:"DevAlarm",
            StatCode: monitor_selected.StatCode
        };
        jQuery.get(request_head, map, function (data) {
            log(data);
            var result=JSON.parse(data);
            var ret = result.ret;
            var txt = "";
            if(ret == "false"){
                txt= "<Strong>获取告警失败</Strong>"
            }else{
                txt = "<div id ='Element_card_floating'><p style='font-size:14px;' >"+"站点名称："+monitor_selected.StatName+"</p>"+
                    "<HR style='FILTER: alpha(opacity=100,finishopacity=0,style=3)' width='80%' color=#987cb9 SIZE=3/>" +
                    "<div style='font-size:10px; min-height: 300px; min-width:420px' >" ;
                txt = txt + " <div class='col-md-6 column'>";
                for(var i=0;i<ret.length;i++){
                    var nickname = ret[i].AlarmEName;
                    txt = txt + "<img src='/xhzn/mfunhcu/ui/image/"+ret[i].AlarmEName+".png'></img><label style='max-width: 150px;min-width: 150px'>&nbsp&nbsp&nbsp&nbsp"+ret[i].AlarmName+":";
                    var value = parseInt(ret[i].AlarmValue);
                    var warning = parseInt(ret[i].WarningTarget);

                    if(value>=warning){
                        txt = txt +"<Strong style='color:red'>"+value+"</Strong>"+ret[i].AlarmUnit+"</label>";
                    }else{
                        txt = txt +"<Strong>"+value+"</Strong>"+ret[i].AlarmUnit+"</label>";
                    }
                    txt = txt +"<p></p>";
                    if(i==ret.length/2-1){
                        txt = txt +"</div><div class='col-md-6 column'>";
                    }
                }
                txt = txt+"</div></div>"
            }
            if(monitor_map_handle!=null){
                monitor_map_handle.setContent(txt);
            }
        });
    }

}
function initializeMap(){
    get_monitor_list();

    map_MPMonitor = new BMap.Map("MPMonitorViewMap");  // 创建点坐标
    map_MPMonitor.addControl(new BMap.NavigationControl());
    //map_MPMonitor.addControl(new BMap.ScaleControl());
    map_MPMonitor.enableScrollWheelZoom();
    map_MPMonitor.centerAndZoom(usr.city,15);
    window.setTimeout("addMarker()", wait_time_middle);
    //addMarker();
    map_initialized=true;



}
function get_select_monitor(title){
    var temp = title.split(":");
    for(var i=0;i<monitor_map_list.length;i++){
        if(monitor_map_list[i].StatCode == temp[0]){
            monitor_selected = monitor_map_list[i];
            return;
        }
    }
    monitor_selected = null;
    return;
}

function addMarker(point){
    // 创建图标对象
    var myIcon = new BMap.Icon("/xhzn/mfunhcu/ui/image/map-marker-ball-azure-small.png", new BMap.Size(32, 32),{
        anchor: new BMap.Size(16, 30)
    });
    for(var i=0;i<monitor_map_list.length;i++){
        var point = new BMap.Point(parseFloat(monitor_map_list[i].Longitude),parseFloat(monitor_map_list[i].Latitude));
        var marker = new BMap.Marker(point, {icon: myIcon});
        marker.setTitle(monitor_map_list[i].StatCode+":"+monitor_map_list[i].StatName);
        map_MPMonitor.addOverlay(marker);
        marker.addEventListener("click", function(){
            get_select_monitor(this.getTitle());
            //console.log("Selected:"+monitor_selected.StatName);
            var sContent = this.getTitle();
            var infoWindow = new BMap.InfoWindow(sContent,{offset:new BMap.Size(0,-23)});
            infoWindow.setWidth(600);
            monitor_map_handle = infoWindow;
            get_monitor_warning_on_map();
            this.openInfoWindow(infoWindow);
            infoWindow.addEventListener("close",function(){
                if(monitor_map_handle == this) monitor_map_handle = null;
            });
        });

    }

}



//Alarm
function get_alarm_type_list(){
    var map={
        action:"AlarmType"
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        alarm_type_list= result.typelist;
    });
}
function query_alarm(date,type,name){

    var map={
        action:"AlarmQuery",
        id: usr.id,
        StatCode: alarm_selected.StatCode,
        date: date,
        type:type
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        var ret = result.status;
        if(ret == "false"){
            show_alarm_module(true,"获取详细日志信息失败！");
            return;
        }
        var StatCode = result.StatCode;
        var date = result.date;
        var AlarmName = result.AlarmName;
        var AlarmUnit = result.AlarmUnit;
        var WarningTarget = result.WarningTarget;
        var minute_alarm = result.minute_alarm;
        var hour_alarm = result.hour_alarm;
        var day_alarm = result.day_alarm;


        //console.log(("#"+type+"_canvas_day"));
        //console.log(("#"+type+"_canvas_week"));
        //console.log(("#"+type+"_canvas_month"));
        $("#Warning_"+type+"_day").css("display","block");
        $("#"+type+"_canvas_day").highcharts({

            chart: {
                type: 'areaspline',
                zoomType: 'x'
            },
            title: {
                text: name+' 分钟值日志，日期：'+date
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 150,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            xAxis: {
                categories: get_minute_list(date),
                max: 120
            },

            scrollbar: {

                enabled: true

            },
            yAxis: {
                title: {
                    text: name
                }
            },
            tooltip: {
                shared: true,
                valueSuffix: AlarmUnit
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.5
                }
            },
            series: [{
                name: alarm_selected.StatName,
                data: minute_alarm,
                turboThreshold: 1500       //设置最大数据量1500个
            }]
        });
        $("#Warning_"+type+"_day").css("display","none");
        $("#Warning_"+type+"_week").css("display","block");
        $("#"+type+"_canvas_week").highcharts({

            chart: {
                type: 'areaspline',
                zoomType: 'x'
            },
            title: {
                text: name+' 小时平均值日志，周期： '+date+' 为截至的7天 '
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 150,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            xAxis: {
                categories: get_hour_list(date),
                max: 120
            },

            scrollbar: {

                enabled: true

            },
            yAxis: {
                title: {
                    text: name
                }
            },
            tooltip: {
                shared: true,
                valueSuffix: AlarmUnit
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.5
                }
            },
            series: [{
                name: alarm_selected.StatName,
                data: hour_alarm,
                turboThreshold: 1500       //设置最大数据量1500个
            }]
        });
        $("#Warning_"+type+"_week").css("display","none");
        $("#Warning_"+type+"_month").css("display","block");
        $("#"+type+"_canvas_month").highcharts({

            chart: {
                type: 'areaspline',
                zoomType: 'x'
            },
            title: {
                text: name+' 日平均值日志，周期： '+date+' 为截至的30天 '
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 150,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            xAxis: {
                categories: get_day_list(date),
                //max: 30
            },

            scrollbar: {

                enabled: true

            },
            yAxis: {
                title: {
                    text: name
                }
            },
            tooltip: {
                shared: true,
                valueSuffix: AlarmUnit
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.5
                }
            },
            series: [{
                name: alarm_selected.StatName,
                data: day_alarm,
                turboThreshold: 1500       //设置最大数据量1500个

            }]
        });
        $("#Warning_"+type+"_month").css("display","none");
    });
}
function initializeAlarmMap(){
    get_project_list();
    get_proj_point_list();
    get_monitor_list();
    get_alarm_type_list();
    map_MPMonitor = new BMap.Map("WCMonitorViewMap");  // 创建点坐标
    map_MPMonitor.addControl(new BMap.NavigationControl());
    //map_MPMonitor.addControl(new BMap.ScaleControl());
    map_MPMonitor.enableScrollWheelZoom();
    map_MPMonitor.centerAndZoom(usr.city,15);
    window.setTimeout("alarm_addMarker()", wait_time_middle);
    window.setTimeout("build_alarm_tabs()", wait_time_middle);
    //alarm_addMarker();
    alarm_map_initialized=true;
}
function build_alarm_tabs(){
    $("#Alarm_chart_view_nav").empty();
    $("#Alarm_Chart_content").empty();
    var txt1 = "";
    var txt2 = "";
    for(var i=0;i<alarm_type_list.length;i++){
        var temp = "";
        var temp2 = ""
        if(i ==0) {temp = "class='active'"; temp2 = " in active";}
        txt1=txt1+"<li class='dropdown'>"+
            "<a href='#' id='Warning_"+i+"_tab' class='dropdown-toggle' data-toggle='dropdown'>"+alarm_type_list[i].name+" <b class='caret'></b>"+
            "</a>"+
            "<ul class='dropdown-menu' role='menu' aria-labelledby='Warning_"+i+"_tab''>"+
            "<li><a href='#Warning_"+i+"_day' "+temp+" tabindex='-1' data-toggle='tab' id='Warning_"+i+"_tab_day' alarmid='"+i+"'>分钟报表（日）</a> </li>"+
            "<li><a href='#Warning_"+i+"_week' tabindex='-1' data-toggle='tab'  id='Warning_"+i+"_tab_week' alarmid='"+i+"'>小时报表（周）</a> </li>"+
            "<li><a href='#Warning_"+i+"_month' tabindex='-1' data-toggle='tab'  id='Warning_"+i+"_tab_month' alarmid='"+i+"'> 日报表（30天）</a> </li> </ul> </li>";
        /*
         txt2 = txt2+
         "<div class='tab-pane fade"+temp2+" Alarm_Canvas' id='Warning_"+i+"_tab_day' >"+
         //"<div class='tab-pane fade ' id='Warning_"+i+"_tab_day' >"+
         "<div id='"+i+"_canvas_day' class='Alarm_Canvas'></div></div>"+
         "<div class='tab-pane fade Alarm_Canvas' id='Warning_"+i+"_tab_week' >"+
         "<div id='"+i+"_canvas_week' class='Alarm_Canvas' ></div></div>"+
         "<div class='tab-pane fade Alarm_Canvas' id='Warning_"+i+"_tab_month' >"+
         "<div id='"+i+"_canvas_month' class='Alarm_Canvas' ></div></div>";
         */
        txt2 = txt2+
            "<div class='Alarm_Canvas' id='Warning_"+i+"_day' >"+
                //"<div class='tab-pane fade ' id='Warning_"+i+"_tab_day' >"+
            "<div id='"+i+"_canvas_day' class='Alarm_Canvas'></div></div>"+
            "<div class='Alarm_Canvas' id='Warning_"+i+"_week' >"+
            "<div id='"+i+"_canvas_week' class='Alarm_Canvas' ></div></div>"+
            "<div class='Alarm_Canvas' id='Warning_"+i+"_month' >"+
            "<div id='"+i+"_canvas_month' class='Alarm_Canvas' ></div></div>";

    }
    //console.log(txt1+txt2);
    $("#Alarm_chart_view_nav").append(txt1);
    $("#Alarm_Chart_content").append(txt2);

    for(var i=0;i<alarm_type_list.length;i++){
        $("#Warning_"+i+"_tab_day").on('click',function(){
            hide_all_chart();
            //console.log("click"+"#Warning_"+$(this).attr('alarmid')+"_day");
            $("#Warning_"+$(this).attr('alarmid')+"_day").css("display","block");
        });
        $("#Warning_"+i+"_tab_week").on('click',function(){
            hide_all_chart();
            //console.log("click"+"#Warning_"+$(this).attr('alarmid')+"_week");
            $("#Warning_"+$(this).attr('alarmid')+"_week").css("display","block");
        });
        $("#Warning_"+i+"_tab_month").on('click',function(){
            hide_all_chart();
            //console.log("click"+"#Warning_"+$(this).attr('alarmid')+"_month");
            $("#Warning_"+$(this).attr('alarmid')+"_month").css("display","block");
        });
    }

}
function hide_all_chart(){
    for(var i=0;i<alarm_type_list.length;i++){
        $("#Warning_"+i+"_day").css("display","none");
        $("#Warning_"+i+"_week").css("display","none");
        $("#Warning_"+i+"_month").css("display","none");
    }
}
function get_select_alarm(title){
    var temp = title.split(":");
    for(var i=0;i<monitor_map_list.length;i++){
        if(monitor_map_list[i].StatCode == temp[0]){
            alarm_selected = monitor_map_list[i];
            return;
        }
    }
    alarm_selected = null;
    return;
}
function get_alarmpointinfo_on_map(){
    if(alarm_selected == null||alarm_map_handle==null){
        return
    }else{
        txt = "<div id ='Element_card_floating'><p style='font-size:14px;' >"+"站点名称："+alarm_selected.StatName+"</p>"+
            "<HR style='FILTER: alpha(opacity=100,finishopacity=0,style=3)' width='80%' color=#987cb9 SIZE=3/>" +
            "<div style='font-size:10px;' >" +
            "站点地址："+alarm_selected.Address+"</div></div>";

    }
    if(alarm_map_handle!=null){
        alarm_map_handle.setContent(txt);
    }
    $("#WCStatCode_Input").val(alarm_selected.StatName);


}
function alarm_addMarker(point){
    // 创建图标对象
    var myIcon = new BMap.Icon("/xhzn/mfunhcu/ui/image/map-marker-ball-azure-small.png", new BMap.Size(32, 32),{
        anchor: new BMap.Size(16, 30)
    });
    for(var i=0;i<monitor_map_list.length;i++){
        var point = new BMap.Point(parseFloat(monitor_map_list[i].Longitude),parseFloat(monitor_map_list[i].Latitude));
        var marker = new BMap.Marker(point, {icon: myIcon});
        marker.setTitle(monitor_map_list[i].StatCode+":"+monitor_map_list[i].StatName);
        map_MPMonitor.addOverlay(marker);
        marker.addEventListener("click", function(){
            get_select_alarm(this.getTitle());
            //console.log("Selected:"+alarm_selected.StatName);

            var sContent = this.getTitle();
            var infoWindow = new BMap.InfoWindow(sContent,{offset:new BMap.Size(0,-23)});
            infoWindow.setWidth(400);
            alarm_map_handle = infoWindow;
            get_alarmpointinfo_on_map();
            this.openInfoWindow(infoWindow);
            infoWindow.addEventListener("close",function(){
                if(alarm_map_handle == this) alarm_map_handle = null;
            });
        });

    }

}



//Data Export

function Data_export_Normal(title,tablename,condition,filter){
    $("#TableQueryCondition").css("display","none");
    $("#ExportTable").empty();
    $("#TableExportTitle").text(title);
    var map={
        action:"TableQuery",
        TableName : tablename,
        Condition: condition,
        Filter: filter
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        ColumnName = result.ColumnName;
        TableData = result.TableData;
        var txt = "<thead> <tr>";
        for(var i=0;i<ColumnName.length;i++){
            txt = txt +"<th>"+ColumnName[i]+"</th>";
        }
        txt = txt +"</tr></thead>";
        /*
        txt = txt +"<tfoot><tr>";
        for(var i=0;i<ColumnName.length;i++){
            txt = txt +"<th>"+ColumnName[i]+"</th>";
        }
        txt = txt +"</tr></tfoot>";*/
        txt = txt +"<tbody>";
        for(var i=0;i<TableData.length;i++){
            txt = txt +"<tr>";
            for(var j=0;j<TableData[i].length;j++){
                txt = txt +"<td>"+TableData[i][j]+"</td>";
            }
            txt = txt +"</tr>";
        }
        txt = txt+"</tbody>";
        $("#ExportTable").append(txt);
        if(if_table_initialize) $("#ExportTable").DataTable().destroy();

        //console.log(monitor_map_list);

        var show_table  = $("#ExportTable").DataTable( {
            //dom: 'T<"clear">lfrtip',
            "scrollY": 200,
            "scrollCollapse": true,

            "scrollX": true,
            "searching": false,
            "autoWidth": true,
            "lengthChange":false,
            //bSort: false,
            //aoColumns: [ { sWidth: "45%" }, { sWidth: "45%" }, { sWidth: "10%", bSearchable: false, bSortable: false } ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '导出到excel',
                    filename: title+(new Date()).Format("yyyy-MM-dd_hhmmss")
                }
            ]

        } );
        if_table_initialize = true;
        modal_middle($('#TableExportModule'));
        $('#TableExportModule').modal('show');
    });



}
function Data_export_alarm() {
	
    
	
    if (if_table_initialize){
        $("#ExportTable").DataTable().destroy();
        if_table_initialize = false;
    }
	$("#ExportTable").empty();
    $("#TableQueryCondition").css("display", "block");
    $("#TableExportTitle").text("告警日志导出");
    $("#QueryProjCode_choice").empty();
    $("#QueryStatCode_choice").empty();
    if(alarm_selected!=null){
        $("#QueryProjCode_choice").append(get_proj_option(alarm_selected.ProjCode));
        //console.log($("#DevProjCode_choice").val());
        get_proj_point_option($("#QueryProjCode_choice").val(), $("#QueryStatCode_choice"), alarm_selected.StatCode);

        $("#QueryStatCode_choice").val(alarm_selected.StatCode);
    }
    else{
        $("#QueryProjCode_choice").append(get_proj_option());
        //console.log($("#DevProjCode_choice").val());
        get_proj_point_option($("#QueryProjCode_choice").val(),$("#QueryStatCode_choice"),"");
    }
    $("#QueryStartTime_Input").val(get_yesterday());
    $("#QueryEndTime_Input").val(get_yesterday());
    modal_middle($('#TableExportModule'));
    $('#TableExportModule').modal('show');
}
function submit_alarm_query(){
    var statcode = $("#QueryStatCode_choice").val();
    var alarm_type = $("#QueryAlarm_choice").val();
    var start_date = $("#QueryStartTime_Input").val();
    var end_date = $("#QueryEndTime_Input").val();
    if(statcode == ""){
        $("#QueryStatCode_choice").focus();
        return;
    }
    var condition = new Array();
    var temp ={
        ConditonName: "UserId",
        Equal:usr.id,
        GEQ:"",
        LEQ:""
    };
    condition.push(temp);
    temp ={
        ConditonName: "StatCode",
        Equal:statcode,
        GEQ:"",
        LEQ:""
    };
    condition.push(temp);
	temp ={
        ConditonName: "AlarmType",
        Equal:alarm_type,
        GEQ:"",
        LEQ:""
    };
    condition.push(temp);
		temp ={
        ConditonName: "AlarmDate",
        Equal:"",
        GEQ:end_date,
        LEQ:start_date
    };
    condition.push(temp);
    var map={
        action:"TableQuery",
        TableName : "Alarmtable",
        Condition: condition,
        Filter: new Array()
    };
    jQuery.get(request_head, map, function (data) {
        log(data);
        var result=JSON.parse(data);
        ColumnName = result.ColumnName;
        TableData = result.TableData;
		$("#ExportTable").empty();
        var txt = "<thead> <tr>";
        for(var i=0;i<ColumnName.length;i++){
            txt = txt +"<th>"+ColumnName[i]+"</th>";
        }
        txt = txt +"</tr></thead>";
        /*
         txt = txt +"<tfoot><tr>";
         for(var i=0;i<ColumnName.length;i++){
         txt = txt +"<th>"+ColumnName[i]+"</th>";
         }
         txt = txt +"</tr></tfoot>";*/
        txt = txt +"<tbody>";
        for(var i=0;i<TableData.length;i++){
            txt = txt +"<tr>";
            for(var j=0;j<TableData[i].length;j++){
                txt = txt +"<td>"+TableData[i][j]+"</td>";
            }
            txt = txt +"</tr>";
        }
        txt = txt+"</tbody>";
        $("#ExportTable").append(txt);
        if(if_table_initialize) $("#ExportTable").DataTable().destroy();

        //console.log(monitor_map_list);

        var show_table  = $("#ExportTable").DataTable( {
            //dom: 'T<"clear">lfrtip',
            "scrollY": 200,
            "scrollCollapse": true,

            "scrollX": true,
            "searching": false,
            "autoWidth": true,
            "lengthChange":false,
            //bSort: false,
            //aoColumns: [ { sWidth: "45%" }, { sWidth: "45%" }, { sWidth: "10%", bSearchable: false, bSortable: false } ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '导出到excel',
                    filename: "日志数据导出"+$("#QueryStatCode_choice").text()+(new Date()).Format("yyyy-MM-dd_hhmmss")
                }
            ]

        } );
        if_table_initialize = true;
        modal_middle($('#TableExportModule'));
        $('#TableExportModule').modal('show');
    });
}



