﻿
//var request_head= ".request";
//var jump_url = ".jump";

var request_head= "request.php";
var jump_url = "/xhzn/mfunhcu/l4aqycui/jump.php";
function log(str){
    console.log(str);
}
function getsec(str)
{
    var str1=Number(str.substring(1,str.length));
    var str2=str.substring(0,1);
    if (str2=="s")
    {
        return str1*1000;
    }
    else if (str2=="m")
    {
        return str1*60*1000;
    }
    else if (str2=="h")
    {
        return str1*60*60*1000;
    }
    else if (str2=="d")
    {
        return str1*24*60*60*1000;
    }
}
function setCookie(name,value,time)
{
    var strsec = getsec(time);
    var exp = new Date();
    var expires = exp.getTime() + Number(strsec);
    exp.setTime(exp.getTime() + Number(strsec));
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name)
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}
function jump(str){
    log("try to dump to session "+window.location.host+"/"+jump_url+"?session"+str);
    window.location="http://"+window.location.host+"/"+jump_url+"?session="+str;
}
$(document).ready(function() {
    var basic_min_height = parseInt(($(".leaderboard").css("padding-top")).replace(/[^0-9]/ig,""));
    if((window.screen.availHeight -600)/2>basic_min_height) basic_min_height = (window.screen.availHeight -600)/2;
    $(".leaderboard").css("padding-top",basic_min_height+"px");
    console.log( $(".leaderboard").css("padding-top"));
    $("#Login_Comfirm").on('click',function(){

        setCookie("Environmental.inspection.usrname",$("#Username_Input").val(),"d30");
        var map={
            action:"login",
            name:$("#Username_Input").val(),
            password:$("#Password_Input").val()
        };
        jQuery.get(request_head, map, function (data) {
            var result=JSON.parse(data);
            if(result.status!="true"){
                $("#UserAlertModalLabel").text = "警告";
                $("#UserAlertModalContent").empty();
                $("#UserAlertModalContent").append("<strong>警告！</strong>"+result.text);
                modal_middle($('#UserAlarm'));
                $('#UserAlarm').modal('show') ;
            }else{
                setCookie("Environmental.inspection.session",result.key,"m10");
                jump(result.key);
            }

        });

    })
});

window.onload = function(){
    $("[data-toggle='modal']").click(function(){
        var _target = $(this).attr('data-target')
        t=setTimeout(function () {
            var _modal = $(_target).find(".modal-dialog")
            _modal.animate({'margin-top': parseInt(($(window).height() - _modal.height())/2)}, 300 )
        },200)
    });
    var usrname = getCookie("Environmental.inspection.usrname");
    if(null!=usrname) $("#Username_Input").val(usrname);

    var session = getCookie("Environmental.inspection.session");
    log("check cookie: username["+usrname+"]session["+session+"]");
    if(null!=session&&session.length>0){
        jump(session);

    }
}

function modal_middle(modal){
    setTimeout(function () {
        var _modal = $(modal).find(".modal-dialog")
        _modal.animate({'margin-top': parseInt(($(window).height() - _modal.height())/2)}, 300 )
    },200)
}