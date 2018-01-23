<?php
$_show_tags = false;
$_show_image = false;
// TABLE articles
/*
Field	Type	Null	Key	Default	Extra
uid	int(11)	NO	PRI	NULL	auto_increment
title	varchar(100)	NO	 	NULL	 
description	varchar(100)	NO	 	NULL	 
content	text	NO	 	NULL	 
image	varchar(100)	NO	 	NULL	 
tag	varchar(100)	NO	 	NULL	 
type	varchar(10)	NO	 	NULL	 
pub_date	date	NO	 	NULL	 

*/

function add_new_article($title, $description, $content, $image, $tag, $type, $pub_date) {
	$sql = "INSERT INTO articles (`title`, `description`, `content`, `image`, `tag`, `type`, `pub_date`) VALUES ('".$title."', '".$description."', '".$content."', '".$image."', '".$tag."', '".$type."', '".$pub_date."')";
	echo $sql;
	$result = query($sql);
	echo mysql_errno().": ".mysql_error()."<BR>";
	return(mysql_affected_rows());
}

/**********************
 *	Index.php
 *********************/
function af_index_list_recommend() {
	global $_show_image;
	$item_count = $_show_image?4:8;
	$sql = "SELECT * from articles WHERE type='REC' ORDER BY uid desc,pub_date limit $item_count";
	$result = query($sql);
	$count = 0;
	echo('<ul>');
	while ($row = mysql_fetch_array($result)) {
		$uid = $row['uid'];
		$title = $row['title'];
		$desc = $row['description'];
		$icon = $row['image'];
		$pub_date = str_replace('-','.',$row['pub_date']);
		if(empty($icon))
			$icon = 'ig04_70-70.jpg';
		if($count == 3) {
			if($_show_image) {
				echo('<li class="m-none"><a href="javascript:loadArticle('.$uid.')" class="fancybox">');
				echo('<img src="../theme/cn/images/content/img/'.$icon.'">');
				echo('<span><b>'.$title.'</b>'.$desc.'</span></a></li>');
			}
			else {
				echo('<li class="m-none"><a href="javascript:loadArticle('.$uid.')" class="fancybox"><b>'.$title.'</b><p>'.$desc.'</p><i>'.$pub_date.'</i></a></li>');
			}
		}
		else {
			if($_show_image) {
				echo('<li><a href="javascript:loadArticle('.$uid.')" class="fancybox">');
				echo('<img src="../theme/cn/images/content/img/'.$icon.'">');
				echo('<span><b>'.$title.'</b>'.$desc.'</span></a></li>');
			}
			else {
				echo('<li><a href="javascript:loadArticle('.$uid.')" class="fancybox"><b>'.$title.'</b><p>'.$desc.'</p><i>'.$pub_date.'</i></a></li>');
			}
		}
		$count++;
	}
	echo('</ul>');
}

function af_index_list_news() {
	global $_show_image;
	$item_count = $_show_image?4:8;

	$sql = "SELECT * from articles WHERE type='NEWS' ORDER BY uid desc,pub_date limit $item_count";
	$result = query($sql);
	$count = 0;
	echo("<ul>");
	while ($row = mysql_fetch_array($result)) {
		$uid = $row['uid'];
		$title = $row['title'];
		$desc = $row['description'];
		$icon = $row['image'];
		$pub_date = str_replace('-','.',$row['pub_date']);
		if(empty($icon))
			$icon = 'ig04_70-70.jpg';
		if($count >= 3) {
			if($_show_image) {
				echo('<li class="m-none"><a href="javascript:loadArticle('.$uid.')" class="fancybox"><div class="n-img"><img src="../theme/cn/images/content/img/'.$icon.'"></div><span><b>'.$title.'</b>'.$desc.'<i>'.$pub_date.'</i></span></a></li>');
			}
			else {
				echo('<li class="m-none"><a href="javascript:loadArticle('.$uid.')" class="fancybox"><b>'.$title.'</b><p>'.$desc.'</p><i>'.$pub_date.'</i></a></li>');
			}
		}
		else {
			if($_show_image) {
				echo('<li><a href="javascript:loadArticle('.$uid.')" class="fancybox"><div class="n-img"><img src="../theme/cn/images/content/img/'.$icon.'"></div><span><b>'.$title.'</b>'.$desc.'<i>'.$pub_date.'</i></span></a></li>');
			}
			else {
				echo('<li><a href="javascript:loadArticle('.$uid.')" class="fancybox"><b>'.$title.'</b><p>'.$desc.'</p><i>'.$pub_date.'</i></a></li>');
			}
		}

		$count++;
	}
	echo("</ul>");

}

/**********************
 *	news.php
 *********************/

function af_news_list($page) {
	global $_show_image;
	$recs_per_page = 10;
	$istart = ($page - 1) * $recs_per_page;
	$sql = "SELECT * from articles WHERE type='NEWS'  ORDER BY uid desc,pub_date LIMIT $istart,$recs_per_page";
	$result = query($sql);
	$count = 0;
	echo("<ul>");
	while ($row = mysql_fetch_array($result)) {
		$uid = $row['uid'];
		$title = $row['title'];
		$icon = $row['image'];
		$desc = $row['description'];
		$pub_date = str_replace('-','.',$row['pub_date']);
		if(empty($icon))
			$icon = 'ig17_news.jpg';
		if($_show_image) {
			echo('<li class="masli"><a href="javascript:loadArticle('.$uid.')" class="fancybox"><h3>'.$title.'</h3><img src="../theme/cn/images/content/img/'.$icon.'"></a><div class="Txt clearfix"><i>'.$pub_date.'</i><p>'.$desc.'</p></div></li>');
		}
		else {
			echo('<li class="masli"><a href="javascript:loadArticle('.$uid.')" class="fancybox"><div class="Txt clearfix"><h3>'.$title.'</h3>'.$desc.'<br><i>'.$pub_date.'</i></div></a></li>');
		}
	}
}

/**********************
 *	recommend.php
 *********************/

// args0: uid, arg1: requested from ?? page
function af_recommend_load_article() {
	global $_show_image;

	$from_page = 'recommend';
	$num = func_num_args();
	if($num == 0) {
		$sql = "select * from articles where type = 'REC' order by uid desc limit 1";
	}
	else if($num == 1) {
		$args = func_get_args();
		$tag = $args[0];
		switch($tag) {
			case 0:
				$tag_string = '育儿';
				break;
			case 1:
				$tag_string = '医疗';
				break;
			case 2:
				$tag_string = '心理';
				break;
			case 3:
				$tag_string = '教育';
				break;
			default:
				$tag_string = '育儿';
				break;
		}
		$sql = "select * from articles where type = 'REC' and tag='$tag_string' order by uid desc limit 1";
	}
	else {
		$args = func_get_args();
		$uid = $args[0];
		if($num == 2) {
			$from_page = $args[1];
		}
		$sql = "select * from articles where uid='$uid'";
	}

	$result = query($sql);
	if($row=mysql_fetch_array($result)) {
		$uid = $row['uid'];
		$v_image = $row['image'];
		if(empty($v_image)) {
			$v_image = 'ig11_about.jpg';
		}
		if($_show_image)
			$image_html = '<p><img src="../theme/cn/images/content/img/'.$v_image.'"></p>';
		if($row['type']=='REC') {
			$v_type = '推荐文章';
		}
		else {
			$v_type = '最新消息';
		}
		$title = $row['title'];
		$desc = stripcslashes($row['description']);

		// Try to resolve as base64 content
		;
		if($cdata = base64_decode($row['content'],true))
			$content = stripcslashes($cdata);
		else
			$content = stripcslashes($row['content']);
		$tag = $row['tag'];

		$b_force_add_go_top = ($row['type']=='NEWS');

		if($from_page == 'index') {
			$html = '<section class="fy-hd"><h2 class="title">'.$v_type.'</h2></section><section class="fy-bd clearfix"><h3 class="title">'.$title.'</h3> <section class="Txt clearfix"> <p>'.$desc.'</p> '.$image_html.' <div>'.$content.'</div> </section> </section>';
			if($b_add_go_top)
				$html .= '<div class="gotop divtop pc"><img src="../theme/cn/images/content/item_gotop01.png">回頂端</div>';
			else
				$html .= '<div class="gotop divtop"><img src="../theme/cn/images/content/item_gotop01.png">回頂端</div>';
			echo($html);

		}
		else {
			echo($image_html);
			echo('<h3 class="title">'.$title.'</h3>');
			if($_show_tags)
				echo('<b>TAGS: '.$tag.'</b>');
			//echo('<b>'.$desc.'</b>');
			echo($content);
		}
		return $uid;
	}
	else {
		echo "<p>没有找到相关文章</p>";
	}
	return -1;
}

function af_recommend_list_related($uid) {
	global $_show_image;

	$sql = "SELECT tag FROM articles WHERE uid='$uid'";
	$result = query($sql);
	if($row=mysql_fetch_array($result)) {
		$tag_string = $row['tag'];
		$tags = explode(',',$tag_string);
		if(count($tags) > 0) {
			$search_string = "tag like '%".$tags[0]."%'";
			for($i = 1; $i < count($tags); $i++) {
				$search_string .= " OR tag like '%".$tags[$i]."%'";
			}
		}
		$sql = "SELECT * from articles WHERE type='REC' AND (".$search_string.") ORDER BY rand() limit 4";
		$result = query($sql);
		$count = 0;
		while ($row = mysql_fetch_array($result)) {
			$uid = $row['uid'];
			$title = $row['title'];
			$desc = $row['description'];
			$icon = $row['image'];
			$tag = $row['tag'];
			$pub_date = str_replace('-','.',$row['pub_date']);
			if(empty($icon))
				$icon = 'ig04_70-70.jpg';
//			echo('<li><a href="javascript:loadMainArticle('.$uid.');"><img src="../theme/cn/images/content/img/'.$icon.'"><span>'.$title.'<p>'.$desc.'</p><i>'.$pub_date.'</i></span></a></li>');
			// test tag search
			if($_show_image)
				$str = '<li><a href="javascript:loadMainArticle('.$uid.');"><img src="../theme/cn/images/content/img/'.$icon.'"><span><b>'.$title.'</b>'.$desc;
			else
				$str = '<li><a href="javascript:loadMainArticle('.$uid.');"><b>'.$title.'</b><p>'.$desc;

			if($_show_tags)
				$str .= '<b>TAGS: '.$tag.'</b>';
			if($_show_image)
				$str .= '<i>'.$pub_date.'</i></span></a></li>';
			else
				$str .= '</p><i>'.$pub_date.'</i></a></li>';
			echo($str);

			if($count %2 == 1)
				echo('<li class="clear"></li>');
			$count++;
			if($count == 4)
				break;
		}
	}
}

function af_recommend_list_latest() {
	global $_show_image;

	$num = func_num_args();
	if($num == 0) {
		$sql = "SELECT * from articles WHERE type='REC' ORDER BY uid desc,pub_date limit 10";
	}
	else {
		$args = func_get_args();
		$tag = $args[0];
		switch($tag) {
			case 0:
				$tag_string = '育儿';
				break;
			case 1:
				$tag_string = '医疗';
				break;
			case 2:
				$tag_string = '心理';
				break;
			case 3:
				$tag_string = '教育';
				break;
			default:
				$tag_string = '育儿';
				break;
		}
		$sql = "SELECT * from articles WHERE type='REC' and tag='$tag_string' ORDER BY uid desc,pub_date limit 10";
	}

	$result = query($sql);
	while ($row = mysql_fetch_array($result)) {
		$uid = $row['uid'];
		$title = $row['title'];
		$desc = $row['description'];
		$icon = $row['image'];
		$pub_date = str_replace('-','.',$row['pub_date']);
		if(empty($icon))
			$icon = 'ig04_70-70.jpg';
		if($_show_image)
			echo('<li><a href="javascript:loadMainArticle('.$uid.');"><img src="../theme/cn/images/content/img/'.$icon.'"><span><b>'.$title.'</b>'.$desc.'<i>'.$pub_date.'</i></span></a></li>');
		else {
			echo('<li><a href="javascript:loadMainArticle('.$uid.');"><b>'.$title.'</b>'.$desc.'<i>'.$pub_date.'</i></a></li>');
		}
	}
}

function af_recommend_list($tag) {
	global $_show_image;

	switch($tag) {
		case 0:
			$tag_string = '育儿';
			break;
		case 1:
			$tag_string = '医疗';
			break;
		case 2:
			$tag_string = '心理';
			break;
		case 3:
			$tag_string = '教育';
			break;
		default:
//		    $tag_string = '育儿';
			break;
	}
	if(isset($tag_string))
		$sql = "SELECT * from articles WHERE type='REC' and tag='$tag_string' ORDER BY uid desc,pub_date";
	else
		$sql = "SELECT * from articles WHERE type='REC' ORDER BY uid desc,pub_date";

	$result = query($sql);
	while ($row = mysql_fetch_array($result)) {
		$uid = $row['uid'];
		$title = $row['title'];
		$desc = $row['description'];
		$icon = $row['image'];
		$pub_date = str_replace('-','.',$row['pub_date']);
		if(empty($icon))
			$icon = 'ig04_70-70.jpg';
		if($_show_image)
			echo('<li><a href="javascript:loadMainArticle('.$uid.');"><img src="../theme/cn/images/content/img/'.$icon.'"><span><b>'.$title.'</b>'.$desc.'<i>'.$pub_date.'</i></span></a></li>');
		else {
			echo('<li><a href="javascript:loadMainArticle('.$uid.');"><b>'.$title.'</b>'.$desc.'<i>'.$pub_date.'</i></a></li>');
		}
	}
}

function get_articles($type,$count) {
	$sql = "SELECT * FROM articles WHERE type='$type'";
	$result = query($sql);
	echo(result_to_table($result));
	return mysql_num_rows($result);
}
?>
