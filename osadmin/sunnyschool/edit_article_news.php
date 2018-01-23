<?php

include_once "ckeditor/ckeditor.php";
require ('../include/init.inc.php');
include_once("../../inc/inc_db.php");

$method = $user_id = $page_no = '';
extract ( $_GET, EXTR_IF_EXISTS );

$page = $_REQUEST['page'];
$type =  "NEWS";
$items_per_page = 10;
//echo($page);
if(!isset($page) || $page < 1)
	$page = 1;

$sql = "select count(*) from articles where type='$type'";
$result = query($sql);
$row=mysqli_fetch_array($result);
$total = $row[0];

$sql = "select * from articles where type='$type' order by uid desc limit ".($page-1)*$items_per_page.",$items_per_page";
$result = query($sql);
$html = ('<table border=1px width="100%" align="center">');
$html.="<tr style='background-color:black'><td width='10%'><font color='#fff'>編號</font></td><td><font color='#fff'>標題</font></td><td><font color='#fff'>簡述</font></td><td><font color='#fff'>內文</font></td><td><font color='#fff'>標籤</font></td><td><font color='#fff'>類別</font></td><td><font color='#fff'>日期</font></td><td><font color='#fff'>動作</font></td></tr>";
$count = 1 + ($page-1)*$items_per_page;
while($row=mysqli_fetch_array($result)) {
	$html .=('<tr  align="left">');
//	$html .="<td>".$row['uid']."</td>";
	$html .="<td>$count</td>";
	$html .="<td>".$row['title']."</td>";
	$html .="<td>".$row['description']."</td>";
//	$html .="<td>".stripcslashes($row['content'])."</td>";
	$html .="<td><input type='button' name='edit_button' id='".$row['uid']."' value='編輯'></td>";
	$html .="<td>".$row['tag']."</td>";
	$html .="<td>".$row['type']."</td>";
	$html .="<td>".$row['pub_date']."</td>";
	$html .="<td><input type='button' name='delete_button' id='".$row['uid']."' value='刪除'></td>";
	$html .=('</tr>');
	$count++;
}
$html .=('</table>');

$page_indexes = "";
if($total % $items_per_page == 0)
	$total_pages = $total / $items_per_page;
else
	$total_pages = $total / $items_per_page + 1; 
for($i = 1; $i <= $total_pages; $i++) {
	if($i == $page) {
		$page_indexes .= ('<a href="?page='.$i.'" style="font-family:arial;color:blue;font-size:20px;">'.$i.'</a>&nbsp;');
	}
	else {
		$page_indexes .= ('<a href="?page='.$i.'">'.$i.'</a>&nbsp;');
	}
	if($i % 20 == 0)
		$page_indexes .= "<br>";
}

$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';
Template::assign('total',$total);
Template::assign('list',$html);
Template::assign('page',$page);
Template::assign('prev_page',$page-1);
Template::assign('next_page',$page+1);
Template::assign('page_indexes',$page_indexes);
Template::display ( 'sunnyschool/editNews.tpl' );
$CKEditor->replace("editor1");

?>
<script src="../../scripts/jquery.base64.js"></script>
<script type="text/javascript">
$(function(){
	$( "#pub_date" ).datepicker({ dateFormat: "yy-mm-dd" });
	$("input[name='new_button']").click(function() {
		$("#content_form").submit(new_article);
		$("#edit_area").show();
		$("#list_area").hide();
		$("input[name='new_button']").hide();
		$('html, body').scrollTop(0);		
	});
	
	$("input[name='edit_button']").click(function() {
		$("#content_form").submit(update_article);
		$("input[name='new_button']").hide();
		
		var uid=$(this).prop('id');
    	$.ajax({
	    	url: "load_article.php",
            type: "POST",
            data: {
                'uid': uid
            },
            dataType: "json",
            success: function (jsonStr) {
    			$.base64.utf8decode = true;
	            $("input[name='uid']").val(uid);
	            $("input[name='title']").val(jsonStr.title);
	            $("input[name='description']").val(jsonStr.description);
	            $("input[name='tag']").val(jsonStr.tag);
	            CKEDITOR.instances.editor1.setData($.base64.decode(jsonStr.content));
//	            $("textarea[name='content']").val($.base64.decode(jsonStr.content));
	            $("input[name='pub_date']").val(jsonStr.pub_date);
//	            $("input[name='type']").val(jsonStr.type);

				$("#edit_area").show();
				$("#list_area").hide();
				$('html, body').scrollTop(0);
             },
            error: function(xhr, err) {
	            alert('load_article error: ' + err);
      		}
        });  		
	});
	
	$("input[name='delete_button']").click(function() {
		var uid=$(this).prop('id');
    	$.ajax({
	    	url: "delete_article.php",
            type: "POST",
            data: {
                'uid': uid
            },
            dataType: "json",
            success: function (jsonStr) {
	            location.reload();
             },
            error: function(xhr, err) {
	            alert('delete_article error: ' + err);
      		}
        });  		
	});
	
	$("#cancel_button").click(function() {
		$("#edit_area").hide();
		$("#list_area").show();
	});
	
	/*
	$("#type_filter").change(function() {
		var t = $(this).val();
		location.href = "edit_article.php?page=<?php echo($page); ?>&type="+t;
		
	});
	*/
	
	function update_article(e) {
		e.preventDefault();
		$.base64.utf8encode = true;
		
		var uid = $("input[name='uid']").val();
		var title = $("input[name='title']").val();
		var description = $("input[name='description']").val();
		var tag = $("input[name='tag']").val();
		var pub_date = $("input[name='pub_date']").val();
//		var type = $("select[name='type']").val();
//		var content =  $.base64.encode($("textarea[name='content']").val());
		var content =  $.base64.encode(CKEDITOR.instances.editor1.getData());

    	$.ajax({
	    	url: "submit_article.php",
            type: "POST",
            data: {
                'uid': uid,
                'title': title,
                'description': description,
                'tag': tag,
                'pub_date': pub_date,
                'type': "NEWS",
                'content': content
            },
            dataType: "json",
            success: function (jsonStr) {
            	if(jsonStr.result=='1') {
					location.reload();
            	}
            	else {
//	            	alert('資料庫寫入失敗');
				$("#edit_area").hide();
				$("#list_area").show();
            	}
             },
            error: function(xhr, err) {
	            alert('update_article error: ' + err);
      		}
        });  				
				
		return false;
	}
	
	function new_article(e) {
		e.preventDefault();
		$.base64.utf8encode = true;

		var title = $("input[name='title']").val();
		var description = $("input[name='description']").val();
		var tag = $("input[name='tag']").val();
		var pub_date = $("input[name='pub_date']").val();
		var type = "NEWS";//$("select[name='type']").val();
		var content = $.base64.encode(CKEDITOR.instances.editor1.getData());
//		var content =  $.base64.encode($("textarea[name='content']").val());

    	$.ajax({
	    	url: "submit_article.php",
            type: "POST",
            data: {
                'title': title,
                'description': description,
                'tag': tag,
                'pub_date': pub_date,
                'type': type,
                'content': content
            },
            dataType: "json",
            success: function (jsonStr) {
//				$("#edit_area").hide();
//				$("#list_area").show();
				location.reload();
             },
            error: function(xhr, err) {
	            alert('submit_article error: ' + xhr.status);
      		}
        });  				
				
		return false;	
	}
<?php
	if($total <= ($page*$items_per_page)) {
		echo('$("#a_next").hide()');		
	}
	else if($page==1) {
		echo('$("#a_prev").hide()');		
	}
?>
});
</script>