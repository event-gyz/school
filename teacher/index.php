<?php
session_start(); 
include('inc.php');	
$func = $_REQUEST['f'];
$group = $_REQUEST['g'];
$index = $_REQUEST['i'];
if(!isset($func)) {
	$func = 0;
}
if(!isset($group)) {
	$group = 1;
}
if(!isset($index)) {
	$index = 1;
}
$is_login = false;

if(isset($_SESSION['teacher_token'])) {
	$member_uid = $CMEMBER->accessFromToken($_SESSION['teacher_token']);
	if($member_uid != -1) {
		$is_login = true;
	}
}
?>
<!DOCTYPE html> 
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
	<?php include('inc_head.php');	?>
<style>
table {table-layout:fixed}
.imgfixed {width:80%; height:auto;}
</style>	
</head>

<body>
	<!-- InstanceBeginEditable name="wrap" -->
	<section id="wrap" class="inpage">
    <!-- InstanceEndEditable -->
    
    	<!--【Header】-->
    	<?php include 'inc_header.php'; ?>
        <!--【Header End】-->
        <!--【Content】-->
        <section id="content">
        <!-- InstanceBeginEditable name="content" -->

            <!--//主內容//-->
            <section class="inbox">            	
                <section class="contbox clearfix">
                
            <?php 
            if($is_login) {
	            if($func==0) { 
         	        echo('<div align="right" style="float: right;"><img src="img/harry_logo.png" width="50%" height="50%"></img></div>');
	            	echo('<div align="left" style="margin-top:20px"> <p>期数&nbsp;&nbsp;<select id="sel_group"></select>&nbsp;&nbsp;堂数&nbsp;&nbsp;<select id="sel_index"></select></div>');

                	$sql = "select * from teacher_zone where class_group='$group' and class_index='$index'";
                	$result = query($sql);
                	$html = "";
                	if($result!=null) {
	                	if($row=mysqli_fetch_array($result)) {
		                	$subject = $row['subject'];
		                	$description = $row['description'];
		                	$video = $row['video'];
		                	$doc = $row['doc'];//"../content/upload/teacher/".$row['doc'];
		                	
		                	$html = "<div style='margin-top:20px;'><h2 class='title'>$subject</h2>";
		                	$html .= "<p>".$description."</p></div>";
//		                	$html .= "<hr>";
		                	$html .= ('<ul class="replist tab-hd clearfix">');
		                	$html .= ('<li><a href="javascript:openContent(\''.$subject.'\',\''.$video.'\');">教学影片</a></li>');
		                	$html .= ('<li><a href="loaddoc.php?f='.$doc.'&d=1">教案（下载）</a></li>');
		                	$html .= ('<li><a href="javascript:document.getElementById(\'PDFtoPrint\').focus(); document.getElementById(\'PDFtoPrint\').contentWindow.print();">教案（打印）</a></li></ul>');
		                	$html .= '<embed style="margin-top:-15px;width:100%;height:400px" src="loaddoc.php?f='.$doc.'" id="PDFtoPrint"></embed>';
	                	}
	                	else {
		                	$html = ("<div style='margin-top:20px;'>没有资料</div>");
	                	}
	                	echo($html);
                	}                	
	            } else if($func==1){
//	            	echo("<iframe width=100% height=500px frameBorder=0 src='bb_home.php'></iframe>");
	            	echo("<iframe width=100% scrolling='no' id='iframe1' onload='javascript:resizeIframe(this);' frameBorder=0 src='bb_home.php'></iframe>");
	            } else if($func==2) {
		            ?>
	                <h2 class="title">线上学习</h2>
	                <section class="newsbox masonry_weblive">
	                </section>
	                <div id="next">
	                	<a href="weblive_list.php?p=2">&nbsp;</a>
	                </div>
	                <script>
					$(function(){
						$('.newsbox').infinitescroll({
							navSelector  	: "#next",
							nextSelector 	: "#next a",
							itemSelector 	: "li",
							loading: {
							  img: '../theme/cn/images/content/loading.gif',
							  msgText: '读取中...',
							  finishedMsg: 'no more...'
							}
						}, function( newElements ) {
							var $newElems = $( newElements ).css({ opacity: 0 });
							$newElems.imagesLoaded(function(){
							  	$newElems.animate({ opacity: 1 });
							  	$('.masonry').masonry( 'appended', $newElems, true ); 
							});
						});
					});
					</script>
		            <?php
	            } else if($func==3) {
		            $sql = "select * from teacher_classroom";
		            $result = query($sql);
		            if(mysqli_num_rows($result) > 0) {
		            	$html = ("<table width=100% border=1px bordercolor='#C0C0C0'>");
			            $html .= "<tr bgcolor='#C0C0C0'><td width=30px>项次</td><td width=100px>名称</td><td width=200px>预览</td><td width=50px>下载AI包</td></tr>";
			            $index = 1;
			            while($row = mysqli_fetch_array($result)) {
			            	$name = $row['name'];
			            	$preview = "loaddoc.php?f=".$row['preview'];
			            	$ai_zip = $row['ai_zip'];
				            $html .= "<tr><td>$index</td><td>$name</td><td><img class='imgfixed' src='$preview'></td><td><a href='loaddoc.php?f=$ai_zip&d=1'>下载</a></td></tr>";				            		                	
				            $index++;
			            }
		            	$html .= ("</table>");
		            }
                	else {
	                	$html = ("<div style='margin-top:20px;'>没有资料</div>");
                	}
                	echo($html);		            
	            }
	            
            }
            else
            	echo("<h2 class='title'>本功能仅限已注册人员使用，请先登入。</h2>");
            ?> 
                </section>
            </section>
            <!--//主內容//-->
            
         <!-- InstanceEndEditable -->   
        </section>
        <!--【Content End】-->
        
        <!--【Footer】-->
        <?php include 'inc_footer.html'; ?>
        <!--【Footer End】-->
    </section>
    <?php include 'inc_bottom_js.php'; ?>
    <script type="text/javascript">
    function openContent(name,link) {
//    	$("#content_area").load(link);
		window.open(link, name, "width='100%',height='100%'");
    }
    
    $(function() {
	    for(i = 1; i <= 4; i++) {
		    $("#sel_group").append($("<option></option>").attr("value", i).text(i));
	    } 
	    for(i = 1; i <= 12; i++) {
		    $("#sel_index").append($("<option></option>").attr("value", i).text(i));
	    } 
	    
	    $("#sel_group").val(<?php echo($group);?>);
	    $("#sel_index").val(<?php echo($index);?>);
	    
	    $("#sel_group").change(function() {
	    	var g = $(this).val();
	    	document.location="index.php?g="+g;
	    });
	    $("#sel_index").change(function() {
	    	var i = $(this).val();
	    	document.location="index.php?g="+<?php echo($group);?>+"&i="+i;
	    });
    	$(".newsbox").load("weblive_list.php?p=1",addItemListeners);
    });
    
    function addItemListeners() {
	    $("a[name='course']").click(function() {
	    	var course_id = $(this).attr('id');
	    	var param = { 'c' : course_id};		    		
	    	OpenWindowWithPost("weblive_fetch.php", "width='100%',height='100%',resizable=yes,scrollbars=no", "weblive", param);
	    	/*
    		$.ajax({
				url: "weblive_fetch.php",
			    type: "POST",
			    data: {'c': course_id},
			    dataType: "html",
			    success: function (data) {
			    	//$("#articlebox").attr('class', 'articlebox');
			    	//$("#articlebox").html(data);
			    	//$("#articlebox").fancybox().trigger('click');
			    	window.open(data);
			     },
			    error: function(xhr, err) {
				}
			});  
			*/
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
    
	function resizeIframe(obj) {
		obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
		window.scrollTo(0, 0);
	}
    </script>
</body>
</html>

