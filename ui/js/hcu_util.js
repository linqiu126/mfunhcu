/**
 * Created by hyj on 2016/5/3.
 */


function date_compare_today(date){
    var temp = date.split("-");
    var input = new Date(parseInt(temp[0]),parseInt(temp[1])-1,parseInt(temp[2])-1);
    var today = new Date();

    if(input.getTime()<today.getTime()){
        return date;

    }else{
        return today.Format("yyyy-MM-dd");
    }
}

function date_compare(date1,date2){
    var temp1 = date1.split("-");
    var input1 = new Date(parseInt(temp1[0]),parseInt(temp1[1]),parseInt(temp1[2]));
    var temp2 = date2.split("-");
    var input2 = new Date(parseInt(temp2[0]),parseInt(temp2[1]),parseInt(temp2[2]));
    //var input = new Date().Format(date);
    if(input1.getTime()<input2.getTime()){
        return date1;

    }else{
        return date2;
    }
}

function get_minute_list(date){
    var input = date.split("-");
    var myDate=new Date();
    myDate.setDate(parseInt(input[2]));
    myDate.setMonth(parseInt(input[1])-1);	//设置 Date 对象中月份 (0 ~ 11)。
    myDate.setFullYear(parseInt(input[0]));	//设置 Date 对象中的年份（四位数字）。
    myDate.setHours(0);	//设置 Date 对象中的小时 (0 ~ 23)。
    myDate.setMinutes(0);	//设置 Date 对象中的分钟 (0 ~ 59)。
    myDate.setSeconds(0);

    var ret = new Array();

    for(var i=0;i<(24*60);i++){
        if(i>0) myDate.setTime(myDate.getTime()+60000);
        ret.push(myDate.Format("hh:mm"));
    }
    return ret;
}
function get_hour_list(date){
    var input = date.split("-");
    var myDate=new Date();
    myDate.setDate(parseInt(input[2]));
    myDate.setMonth(parseInt(input[1])-1);	//设置 Date 对象中月份 (0 ~ 11)。
    myDate.setFullYear(parseInt(input[0]));	//设置 Date 对象中的年份（四位数字）。
    myDate.setHours(0);	//设置 Date 对象中的小时 (0 ~ 23)。
    myDate.setMinutes(0);	//设置 Date 对象中的分钟 (0 ~ 59)。
    myDate.setSeconds(0);
    //console.log(myDate.Format("yyyy-MM-dd hh:mm:ss"));
    myDate.setTime(myDate.getTime()-1000*60*60*24*6);
    //console.log(myDate.Format("yyyy-MM-dd hh:mm:ss"));
    var ret = new Array();

    for(var i=0;i<(24*7);i++){
        if(i>0) myDate.setTime(myDate.getTime()+60000*60);
        //var temp = myDate.toTimeString().split(":")
        ret.push(myDate.Format("MM-dd hh:mm"));
    }
    return ret;
}
function get_day_list(date){
    var input = date.split("-");
    var myDate=new Date();
    myDate.setDate(parseInt(input[2]));
    myDate.setMonth(parseInt(input[1])-1);	//设置 Date 对象中月份 (0 ~ 11)。
    myDate.setFullYear(parseInt(input[0]));	//设置 Date 对象中的年份（四位数字）。
    myDate.setHours(0);	//设置 Date 对象中的小时 (0 ~ 23)。
    myDate.setMinutes(0);	//设置 Date 对象中的分钟 (0 ~ 59)。
    myDate.setSeconds(0);
    myDate.setTime(myDate.getTime()-1000*60*60*24*29);
    var ret = new Array();
    for(var i=0;i<(30);i++){
        if(i>0) myDate.setTime(myDate.getTime()+60000*60*24);
        //var temp = myDate.toTimeString().split(":")
        ret.push(myDate.Format("MM-dd"));
    }
    return ret;
}
Date.prototype.Format = function (fmt) { //author: meizz
    var o = {
        "M+": this.getMonth() + 1, //月份
        "d+": this.getDate(), //日
        "h+": this.getHours(), //小时
        "m+": this.getMinutes(), //分
        "s+": this.getSeconds(), //秒
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
        "S": this.getMilliseconds() //毫秒
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}
function get_yesterday(){
    var myDate=new Date();
    myDate.setTime(myDate.getTime()-60000*60*24);
    return myDate.Format("yyyy-MM-dd");
}

function log(str){
    //console.log(str);
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
function delCookie(name)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null)
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
function touchcookie(){
    setCookie("Environmental.inspection.session",keystr,"m10");
}
function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}

/*
exports.date_compare_today=date_compare_today;
exports.date_compare=date_compare;
exports.get_minute_list=get_minute_list;
exports.get_hour_list=get_hour_list;
exports.get_day_list=get_day_list;
exports.get_yesterday=get_yesterday;
exports.Date.prototype.Format=Date.prototype.Format;*/
