<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SunnySchool Text Editor</title>
<link href="ckeditor/_samples/sample.css" rel="stylesheet" type="text/css"/>
</head>
<body>
總筆數: <b><{$total}></b>
<p></p>
<p><input type="button" name="new_button" value="新增">
</p>
<div id="edit_area" style="display:none">
<hr/>
<form id="content_form" action="submit_article.php" method="post"> 
<input type="hidden" name="uid" value="<{$uid}>">
<input type="hidden" name="type" value="REC">
標題：<input type="text" name="title" value="<{$title}>">
簡述：<input type="text" name="description" size="100" value="<{$description}>"><br>
分類：<select name="tag">
<{html_options values=$tag_options_val output=$tag_options_name selected=$tag_selected_val seperator='<br/>'}>
</select>
日期：<input type="text" id="pub_date" name="pub_date" value="<{$pub_date}>" readonly>
<textarea cols="80" id="editor1" name="editor1" rows="10" ></textarea>
<!--<textarea cols="80" id="content" name="content" rows="10" ></textarea><br>-->
<input type="submit" name="submit" value="送出">
<input type="button" id="cancel_button" value="取消">
</form>
<hr/>
</div>

<div id="list_area">
<{$list}>
<br>
<{$page_indexes}>
</div>
</body>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<{include file="footer.tpl" }>