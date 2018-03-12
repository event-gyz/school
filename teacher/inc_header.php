<script src="../scripts/ssutils.js"></script>
<script type="text/javascript">
var _next_move_ = 0;
$(function(){
	// Login
	$("#login_form").submit(function(e){
		e.preventDefault();
//		if(!checkEmailFormat() || !checkPasswordFormat()) {
//			$("#fy-login .error01").show().delay(3000).fadeOut();
//			return true;
//		}
		var user_id = $("#login_id").val();
		var user_password = $("#login_pass").val();
    	$.ajax({
	    	url: "login.php",
            type: "POST",
            data: {
                'p1': user_id,
                'p2': user_password
            },
            dataType: "json",
            success: function (jsonStr) {
            	if(jsonStr.result=='success') {
	              	var message = $.parseJSON(jsonStr.message);
//		            showLoginStatus(message.email,message.credit);
		            $.fancybox.close();
		            document.location.reload(true);
            	}
            	else {
					$("#fy-login .error01").show().delay(3000).fadeOut();
            	}
             },
            error: function(xhr, err) {
	            alert('Ajax request ' + err);
      		}
        });  
        return false;   
    }); 
    // initialize forms
    $("form").attr("method","post");    
    $(".errorbar").hide();
    $("#login_id").blur(checkEmailFormat);
    $("#login_pass").blur(checkPasswordFormat);
});

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
//	$("#login_status").html('<li class="m_name-point fst"><b>'+nickname+'</b><i>'+points+'點</i></li><li><a href="javascript:doLogout();">登出</a></li>');
//	$("#login_status_m").html('<b>'+nickname+'</b><i>'+points+'點</i><a href="javascript:doLogout();">登出</a>');
	$("#login_status").html('<li class="m_name-point fst"><b>'+nickname+'</b></li><li><a href="javascript:doLogout();">登出</a></li>');
	$("#login_status_m").html('<b>'+nickname+'</b><a href="javascript:doLogout();">登出</a>');
}

function doLogout() {
	$.ajax({ 
		url: "logout.php",
		success: function () {
			location.href = "index.php";
		}
	});  
//	$("#login_status").html('<li class="fst"><a href="#fy-register" class="fancybox">注册</a></li><li><a href="#fy-login" class="fancybox">登入</a></li>');		
//	$("#login_status_m").html('<a href="#fy-register" class="fst fancybox">注册</a><a href="#fy-login" class="fancybox">登入</a>');	
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

function OpenWindowWithPost(url, windowoption, name, params) {
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", url);
        form.setAttribute("target", name);

        for (var i in params) {
            if (params.hasOwnProperty(i)) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = i;
                input.value = params[i];
                form.appendChild(input);
            }
        }

        document.body.appendChild(form);
        window.open("post.htm", name, windowoption);
        form.submit();
        document.body.removeChild(form);
}
</script>
<?php 
 	$filename = basename($_SERVER['PHP_SELF']); 
 	$pagename = substr($filename, 0, strrpos($filename, "."));
?>

<header id="header">
    <section class="inbox clearfix">
        <h1><a href="index.php"><img src="../theme/cn/images/header/item_logo.jpg"></a></h1>
        <nav>
            <!--//登入前//-->
            <ul class="tnav" name="login_status" id="login_status">
            <?php 
	            if(isset($_SESSION['teacher_token'])) {
	            echo('<li class="m_name-point fst"><b>'.$_SESSION['teacher_email'].'</b></li><li><a href="javascript:doLogout();">登出</a></li>');
				}
				else {
			?>
                <li class="m_name-point fst"><a href="#fy-login" class="fancybox">登入</a></li>					
            <?php 
				}
			?>
            </ul>
            <!--//選單//-->
            <ul class="mnav">
	            <li <?php if($func==0) echo('class="on"'); ?>><a href="index.php?f=0">品德课程</a></li>
	            <li <?php if($func==2) echo('class="on"'); ?>><a href="index.php?f=2">线上学习</a></li>
	            <li <?php if($func==3) echo('class="on"'); ?>><a href="index.php?f=3">教室设计参考图</a></li>
	            <li <?php if($func==1) echo('class="on"'); ?>><a href="index.php?f=1">交流园地</a></li>
	            <li <?php if($pagename=='about') echo('class="on"'); ?>><a href="about.php">关于我们</a></li>
            </ul>
        </nav>
    </section>
    
    <!--//手機選單//-->
    <div class="i-menu">Menu</div>
   	<nav class="s-mnav">
        <ul class="clearfix">
	            <li <?php if($func==0) echo('class="on"'); ?>><a href="index.php?f=0">品德课程</a></li>
	            <li <?php if($func==2) echo('class="on"'); ?>><a href="index.php?f=2">线上学习</a></li>
	            <li <?php if($func==3) echo('class="on"'); ?>><a href="index.php?f=3">教室设计参考图</a></li>
	            <li <?php if($func==1) echo('class="on"'); ?>><a href="index.php?f=1">交流园地</a></li>
	            <li <?php if($pagename=='about') echo('class="on"'); ?>><a href="about.php">关于我们</a></li>
            <?php 
	            if(isset($_SESSION['teacher_token'])) {
		            echo('<li class="last"><b>'.$_SESSION['teacher_email'].'</b><a href="javascript:doLogout();">登出</a></li>');		
				}
				else {
			?>
            <li class="last" name="login_status_m" id="login_status_m"><a href="#fy-login" class="fancybox">登入</a></li>
            <?php 
				}
			?>
        </ul>
    </nav>
    <section class="bg-o"></section>
    <!--//選單//-->
	<?php
	include("inc_fancyboxes.php");
	?>	
</header>
