
function checkEmailFormat() {
	if(!isEmail($("#login_id").val())) {
		$("#div_err_email").show(); 
		return false;		
	}
	else {
    	$("#div_err_email").hide(); 		
    	return true;
	}
}
    
function checkPasswordFormat() {
   	if(!isPasswd($("#login_pass").val())) {
   		$("#div_err_password").show(); 	   	
		return false;   		
   	}
   	else {
    	$("#div_err_password").hide(); 	   	
    	return true;
   	}
}    

function checkRegEmailFormat() {
	if(!isEmail($("#reg_email").val())) {
		$("#errorbar_reg_email").show(); 
		return false;		
	}
	else {
    	$("#errorbar_reg_email").hide(); 		
    	return true;
	}
}
    
function checkkRegPasswordFormat() {
   	if(!isPasswd($("#reg_password").val())) {
   		$("#errorbar_reg_password").show(); 	   	
		return false;   		
   	}
   	else {
    	$("#errorbar_reg_password").hide(); 	   	
    	return true;
   	}
}    

function checkAuthcodeFormat() { 
	if($("#reg_authcode").val() == "") {
		return false;
	}
}


function showLoginStatus(nickname,points) {
	$("#login_status").html('<li class="m_name-point fst"><b>'+nickname+'</b><i>'+points+'點</i></li><li><a href="javascript:doLogout();">登出</a></li>');
	$("#login_status_m").html('<b>'+nickname+'</b><i>'+points+'點</i><a href="javascript:doLogout();">登出</a>');
}

function doLogout() {
	$.ajax({ 
		url: "logout.php",
		success: function () {
			location.reload();
		}
	});  
//	$("#login_status").html('<li class="fst"><a href="#fy-register" class="fancybox">注册</a></li><li><a href="#fy-login" class="fancybox">登入</a></li>');		
//	$("#login_status_m").html('<a href="#fy-register" class="fst fancybox">注册</a><a href="#fy-login" class="fancybox">登入</a>');	
}

function postTvSubmit() {
	var form = document.createElement("form");
	form.setAttribute("method", "post");
	form.setAttribute("action", "tv_submit.php");
	document.body.appendChild(form);
    form.submit();
}

function loadArticle(v_id) {
	$.ajax({
	url: "get_article.php",
    type: "POST",
    data: {'uid': v_id},
    dataType: "html",
    success: function (data) {
    	$("#articlebox").attr('class', 'articlebox');
    	$("#articlebox").html(data);
    	$("#articlebox").fancybox().trigger('click');
     },
    error: function(xhr, err) {
//	            alert('Ajax request ' + err);
	}
	});  
}       

function loadGIDetail(index_id,a_type) {
	$("#articlebox").attr('class', 'articlebox abox');
	$("#articlebox").load("load_gi.php",{p1:index_id,p2:a_type});
	$("#articlebox").fancybox().trigger('click');
}
