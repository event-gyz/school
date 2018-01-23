<?php
$_show_tags = false;
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
	echo mysqli_errno().": ".mysqli_error()."<BR>";
	return(mysqli_affected_rows());
}

/**********************
 *	Index.php
 *********************/
function af_index_list_recommend() {
	$sql = "SELECT * from articles WHERE type='REC' ORDER BY pub_date desc limit 4";
	$result = query($sql);
	$count = 0;
	echo('<ul>');
	while ($row = mysqli_fetch_array($result)) {
		$uid = $row['uid'];
		$title = $row['title'];
		$desc = $row['description'];
		$icon = $row['image'];
		if(empty($icon))
			$icon = 'ig04_70-70.jpg';
		if($count == 3)
			echo('<li class="m-none"><a href="javascript:loadArticle('.$uid.')" class="fancybox"><img src="../theme/cn/images/content/img/'.$icon.'"><span><b>'.$title.'</b>'.$desc.'</span></a></li>');
		else 
			echo('<li><a href="javascript:loadArticle('.$uid.')" class="fancybox"><img src="../theme/cn/images/content/img/'.$icon.'"><span><b>'.$title.'</b>'.$desc.'</span></a></li>');			
		$count++;
		if($count == 4)
			break;
	}                    		
	echo('</ul>');
}

function af_index_list_news() {
	$sql = "SELECT * from articles WHERE type='NEWS'";
	$result = query($sql);
	$count = 0;
	echo("<ul>");
	while ($row = mysqli_fetch_array($result)) {
		$uid = $row['uid'];
		$title = $row['title'];
		$desc = $row['description'];
		$icon = $row['image'];
		$pub_date = str_replace('-','.',$row['pub_date']);
		if(empty($icon))
			$icon = 'ig04_70-70.jpg';
		if($count >= 3)
			echo('<li class="m-none"><a href="javascript:loadArticle('.$uid.')" class="fancybox"><div class="n-img"><img src="../theme/cn/images/content/img/'.$icon.'"></div><span><b>'.$title.'</b>'.$desc.'<i>'.$pub_date.'</i></span></a></li>');
		else 
			echo('<li><a href="javascript:loadArticle('.$uid.')" class="fancybox"><div class="n-img"><img src="../theme/cn/images/content/img/'.$icon.'"></div><span><b>'.$title.'</b>'.$desc.'<i>'.$pub_date.'</i></span></a></li>');			
		$count++;
		if($count == 5)
			break;
	}                    		
	echo("</ul>");

}

/**********************
 *	news.php
 *********************/

function af_news_list($page) {
	$recs_per_page = 10;
	$istart = ($page - 1) * $recs_per_page;
	$sql = "SELECT * from articles WHERE type='NEWS' LIMIT $istart,$recs_per_page";
	$result = query($sql);
	$count = 0;
	echo("<ul>");
	while ($row = mysqli_fetch_array($result)) {
		$uid = $row['uid'];
		$title = $row['title'];
		$icon = $row['image'];
		$desc = $row['description'];
		$pub_date = str_replace('-','.',$row['pub_date']);
		if(empty($icon))
			$icon = 'ig17_news.jpg';
		echo('<li class="masli"><h3>'.$title.'</h3><a href="javascript:loadArticle('.$uid.')" class="fancybox"><img src="../theme/cn/images/content/img/'.$icon.'"></a><div class="Txt clearfix"><i>'.$pub_date.'</i><p>'.$desc.'</p></div></li>');
	}
}

/**********************
 *	recommend.php
 *********************/

// args0: uid, arg1: requested from ?? page
function af_recommend_load_article() {
	$from_page = 'recommend';
    $num = func_num_args();
    if($num == 0) {
	    $sql = "select * from articles where type = 'REC' order by uid desc limit 1";
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
	if($row=mysqli_fetch_array($result)) {
		$uid = $row['uid'];
		$v_image = $row['image'];
		if(empty($v_image)) {
			$v_image = 'ig11_about.jpg';
		}	
		$image_html = '<p><img src="../theme/cn/images/content/img/'.$v_image.'"></p>';
		if($row['type']=='REC') {
			$v_type = '推荐文章';
		}
		else {
			$v_type = '最新消息';
		}
		$title = $row['title'];
		$desc = $row['description'];
		$content = $row['content'];
		$tag = $row['tag'];
		
		$b_force_add_go_top = ($row['type']=='NEWS');
		
		if($from_page == 'index') {
			$html = '<section class="fy-hd"><h2 class="title">'.$v_type.'</h2></section><section class="fy-bd clearfix"><h3 class="title">'.$title.'</h3> <section class="Txt clearfix"> <p>'.$desc.'</p> '.$image_html.' <p>'.$content.'</p> </section> </section>';
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
		echo "<p>Article not found.</p>";
	}
	return -1;
}

function af_recommend_list_related($uid) {
	$sql = "SELECT tag FROM articles WHERE uid='$uid'";
	$result = query($sql);
	if($row=mysqli_fetch_array($result)) {
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
		while ($row = mysqli_fetch_array($result)) {
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
			$str = '<li><a href="javascript:loadMainArticle('.$uid.');"><img src="../theme/cn/images/content/img/'.$icon.'"><span><b>'.$title.'</b>'.$desc;
			if($_show_tags)
				$str .= '<b>TAGS: '.$tag.'</b>';
			$str .= '<i>'.$pub_date.'</i></span></a></li>';
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
	$sql = "SELECT * from articles WHERE type='REC' ORDER BY pub_date desc limit 10";
	$result = query($sql);
	while ($row = mysqli_fetch_array($result)) {
		$uid = $row['uid'];
		$title = $row['title'];
		$desc = $row['description'];
		$icon = $row['image'];
		$pub_date = str_replace('-','.',$row['pub_date']);
		if(empty($icon))
			$icon = 'ig04_70-70.jpg';	
		echo('<li><a href="javascript:loadMainArticle('.$uid.');"><img src="../theme/cn/images/content/img/'.$icon.'"><span><b>'.$title.'</b>'.$desc.'<i>'.$pub_date.'</i></span></a></li>');			
	}    	
}

function get_articles($type,$count) {
	$sql = "SELECT * FROM articles WHERE type='$type'";
	$result = query($sql);
	echo(result_to_table($result));
	return mysqli_num_rows($result);
}
?>
