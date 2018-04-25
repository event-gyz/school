//校验密码：只能输入6-20个字母、数字、下划线
function  isPasswd(s)
{
var  patrn=/^(\w){6,20}$/;
if  (!patrn.exec(s))  return  false
return  true
}

//校验昵称
function  isName(s)
{
var  patrn=/^(\w){6,20}$/;
if  (!patrn.exec(s))  return  false
return  true
}

//校验普通电话、传真号码：可以“+”开头，除数字外，可含有“-”
function  isTel(s)
{
//var  patrn=/^[+]{0,1}(\d){1,3}[  ]?([-]?(\d){1,12})+$/;
var  patrn=/^[+]{0,1}(\d){1,3}[  ]?([-]?((\d)|[  ]){1,12})+$/;
if  (!patrn.exec(s))  return  false
return  true
}

//校验手机号码：必须以数字开头，除数字外，可含有“-”
function  isMobil(s)
{
var  patrn=/^[+]{0,1}(\d){1,3}[  ]?([-]?((\d)|[  ]){1,12})+$/;
if  (!patrn.exec(s))  return  false
return  true
}

//校验邮箱
function  isEmail(s)
{
var  patrn=/^[a-zA-Z0-9_\-+]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/;
if  (!patrn.exec(s))  return  false
return  true
}
//校验日期
function  isdate(s)
{
var  patrn=/^((\d{2}(([02468][048])|([13579][26]))[\-\/\s]?((((0?[13578])|(1[02]))[\-\/\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\-\/\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\-\/\s]?((0?[1-9])|([1-2][0-9])))))|(\d{2}(([02468][1235679])|([13579][01345789]))[\-\/\s]?((((0?[13578])|(1[02]))[\-\/\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\-\/\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\-\/\s]?((0?[1-9])|(1[0-9])|(2[0-8]))))))(\s(((0?[0-9])|([1-2][0-3]))\:([0-5]?[0-9])((\s)|(\:([0-5]?[0-9])))))?$/;
if  (!patrn.exec(s))  return  false
return  true
}
