function getsec(e){var t=Number(e.substring(1,e.length)),n=e.substring(0,1);return"s"==n?1e3*t:"m"==n?60*t*1e3:"h"==n?60*t*60*1e3:"d"==n?24*t*60*60*1e3:void 0}function setCookie(e,t,n){var i=getsec(n),o=new Date;o.getTime()+Number(i);o.setTime(o.getTime()+Number(i)),document.cookie=e+"="+escape(t)+";expires="+o.toGMTString()}function getCookie(e){var t,n=new RegExp("(^| )"+e+"=([^;]*)(;|$)");return t=document.cookie.match(n),t===!0?unescape(t[2]):null}function jump(e){log("try to dump to session "+window.location.host+jump_url+"?session"+e),window.location="http://"+window.location.host+jump_url+"?session="+e}function modal_middle(e){setTimeout(function(){var t=$(e).find(".modal-dialog");t.animate({"margin-top":parseInt(($(window).height()-t.height())/2)},300)},200)}function get_size(){window.innerWidth?winWidth=window.innerWidth:document.body&&document.body.clientWidth&&(winWidth=document.body.clientWidth),window.innerHeight?winHeight=window.innerHeight:document.body&&document.body.clientHeight&&(winHeight=document.body.clientHeight),document.documentElement&&document.documentElement.clientHeight&&document.documentElement.clientWidth&&(winHeight=document.documentElement.clientHeight,winWidth=document.documentElement.clientWidth),console.log("winWidth = "+winWidth),console.log("winHeight= "+winHeight);var e=winHeight;winHeight>winWidth&&(e=winWidth),logoHeight=parseInt(e/5),headHeight=parseInt(e/5),$("#logo").css("height",logoHeight),$("#webhead").css("height",logoHeight),$("body").css("height",winHeight);var t=parseInt((winHeight-180)/2)-64;$("#kuang").css("margin-top",t),winHeight>winWidth&&$("#webhead").css("margin-top",logoHeight)}function JQ_get(e,t,n){jQuery.get(e,t,function(e){log(e);var t=JSON.parse(e);n(t)})}var basic_address=getRelativeURL()+"/",request_head=basic_address+"request.php",jump_url=basic_address+"jump.php",winHeight=800,winWidth=800,logoHeight=100,headHeight=100;$(document).ready(function(){get_size();var e=parseInt($(".leaderboard").css("padding-top").replace(/[^0-9]/gi,""));(window.screen.availHeight-600)/2>e&&(e=(window.screen.availHeight-600)/2),$(".leaderboard").css("padding-top",e+"px"),console.log($(".leaderboard").css("padding-top")),$("#Login_Comfirm").on("click",function(){setCookie("Environmental.inspection.usrname",$("#Username_Input").val(),"d30");var e={action:"login",name:$("#Username_Input").val(),password:$("#Password_Input").val()},t=function(e){"true"!=e.status?($("#UserAlertModalLabel").text="警告",$("#UserAlertModalContent").empty(),$("#UserAlertModalContent").append("<strong>警告！</strong>"+e.msg),modal_middle($("#UserAlarm")),$("#UserAlarm").modal("show")):(setCookie("Environmental.inspection.session",e.ret.key,"m10"),jump(e.ret.key))};JQ_get(request_head,e,t)})}),window.onload=function(){$("[data-toggle='modal']").click(function(){var e=$(this).attr("data-target");t=setTimeout(function(){var t=$(e).find(".modal-dialog");t.animate({"margin-top":parseInt(($(window).height()-t.height())/2)},300)},200)});var e=getCookie("Environmental.inspection.usrname");null!==e&&$("#Username_Input").val(e);var n=getCookie("Environmental.inspection.session");log("check cookie: username["+e+"]session["+n+"]"),null!==n&&n.length>0&&jump(n)};