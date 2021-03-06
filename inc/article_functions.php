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
	$sql = "SELECT * from articles WHERE type='REC' and uid<355 ORDER BY uid desc,pub_date limit $item_count";
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

/**********************
 *	ceanza_list.php
 *********************/
function af_articles_list_recommend($tag) {
	global $_show_image;
	$item_count = $_show_image?4:8;
	if($tag == '推荐'){
		$show_date = date('Y-m-d',time());
		$sql = "SELECT * from articles WHERE type='REC' and show_date='{$show_date}' ORDER BY uid desc,pub_date limit $item_count";
		$result = M()->select($sql);
		if(!is_array($result) || empty($result)){
			$all_art = "SELECT uid from articles";
			$all_res = M()->select($all_art);
			$all_uid = array_column($all_res,'uid');
			shuffle($all_uid);
			$i=0;
			foreach($all_uid as $k_uid=>$uid){
				if(($k_uid)%2==0){
					$s_date = date("Y-m-d",strtotime("$i day"));
					$i++;
				}
				if(empty($s_date)){
					$s_date=$show_date;
				}
				$up_sql = "update articles set show_date='{$s_date}' where uid=$uid";
				M()->execute($up_sql);
			}
		}
		$result = M()->select($sql);
	}else{
		$sql = "SELECT * from articles WHERE type='REC' and tag='{$tag}' ORDER BY uid desc,pub_date limit $item_count";
		$result = M()->select($sql);
	}

	$count = 0;
	echo('<ul class="recommended_articles">');
    if($tag == '推荐') {
        echo '<h4>推荐文章</h4>';
    }
	foreach($result as $row){
		$uid = $row['uid'];
		$title = $row['title'];
		$desc = $row['description'];
//		$desc = mb_substr($desc,0,15,'utf-8').'....';
		if($count == 3) {
			if($_show_image) {
				echo('<li class="m-none"><a href="javascript:loadArticle('.$uid.')" class="fancybox">');
				echo('<span><b>'.$title.'</b>'.$desc.'</span></a></li>');
			}
			else {
//				echo('<li class="m-none"><a href="javascript:loadArticle('.$uid.')" class="fancybox"><b>'.$title.'</b></a></li>');
				echo('<li><a href="javascript:loadArticle('.$uid.')" class="fancybox"><b>'.$title.'</b><p>'.$desc.'</p></a></li>');
			}
		}
		else {
			if($_show_image) {
				echo('<li><a href="javascript:loadArticle('.$uid.')" class="fancybox">');
				echo('<span><b>'.$title.'</b></span></a></li>');
			}
			else {
//				echo('<li><a href="javascript:loadArticle('.$uid.')" class="fancybox"><b>'.$title.'</b></a></li>');
				echo('<li><h4><a href="javascript:loadArticle('.$uid.')" class="fancybox"><b>'.$title.'</b></h4></a><p>'.$desc.'<a href="recommend.php" class="i-more">更多》</a></p></li>');
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
        $show_date = date('Y-m-d',time());
        $sql = "select * from articles WHERE type='REC' and tag='$tag_string' AND show_date2='{$show_date}' order by uid desc limit 1";
        $re = M()->select($sql);
        if(!is_array($re) || empty($re)){
            $all_art = "SELECT uid from articles WHERE type='REC' and tag='$tag_string' ";
            $all_res = M()->select($all_art);
            $all_uid = array_column($all_res,'uid');
            shuffle($all_uid);
            $i=0;
            foreach($all_uid as $k_uid=>$uid){
                $s_date = date("Y-m-d",strtotime("$i day"));
                $i++;
                if(empty($s_date)){
                    $s_date=$show_date;
                }
                $up_sql = "update articles set show_date2='{$s_date}' where uid=$uid";
                M()->execute($up_sql);
            }
        }
	}
	else {
		$args = func_get_args();
		$uid = $args[0];
		if($num == 2) {
			$from_page = $args[1];
		}
		$sql = "select * from articles where uid='$uid'";
	}
	$result = M()->find($sql);
	if($result) {
		$uid = $result['uid'];
		$v_image = $result['image'];
//		if(empty($v_image)) {
//			$v_image = 'ig11_about.jpg';
//		}
//		if(!empty($v_image))
//			$image_html = '<p><img src="../theme/cn/images/content/img/'.$v_image.'"></p>';
		$image_html= '';
		if($result['type']=='REC') {
			$v_type = '推荐文章';
		}
		else {
			$v_type = '最新消息';
		}
		$title = $result['title'];
		$desc = stripcslashes($result['description']);

		// Try to resolve as base64 content
		;
		if($cdata = base64_decode($result['content'],true))
			$content = stripcslashes($cdata);
		else
			$content = stripcslashes($result['content']);
		$tag = $result['tag'];

		$b_force_add_go_top = ($result['type']=='NEWS');

		if($from_page == 'index') {
			$html = '<section class="fy-hd"><h2 class="title">'.$v_type.'</h2></section><section class="fy-bd clearfix"><h3 class="title">'.$title.'</h3> <section class="Txt clearfix"> <p>'.$desc.'</p> '.$image_html.' <div>'.$content.'</div> </section> </section>';
			if(@$b_add_go_top)
				$html .= '<div class="gotop divtop pc"><img src="../theme/cn/images/content/item_gotop01.png">回頂端</div>';
			else
				$html .= '<div class="gotop divtop"><img src="../theme/cn/images/content/item_gotop01.png">回頂端</div>';
			echo($html);

		}
		else {
			echo($image_html);
			echo('<h3 class="title">'.$title.'</h3>');
			if(@$_show_tags)
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

			if(@$_show_tags)
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
//			echo('<li><a href="javascript:loadMainArticle('.$uid.');"><img src="../theme/cn/images/content/img/'.$icon.'"><span><b>'.$title.'</b>'.$desc.'<i>'.$pub_date.'</i></span></a></li>');
            echo('<li><a href="javascript:loadMainArticle('.$uid.');"><img src="../theme/cn/images/content/img/'.$icon.'"><span><b>'.$title.'</b>'.$desc.'</span></a></li><br/>');
		else {
//			echo('<li><a href="javascript:loadMainArticle('.$uid.');"><b>'.$title.'</b>'.$desc.'<i>'.$pub_date.'</i></a></li>');
            echo('<li><a href="javascript:loadMainArticle('.$uid.');"><b>'.$title.'</b>'.$desc.'</a></li>');
		}
	}
}

function get_articles($type,$count) {
	$sql = "SELECT * FROM articles WHERE type='$type'";
	$result = query($sql);
	echo(result_to_table($result));
	return mysql_num_rows($result);
}



function get_baby_vaccine(){
    if(isset($_SESSION['user_token'])) {
        $CMEMBER = new MyUser();
        $member_uid = $CMEMBER->accessFromToken($_SESSION['user_token']);
        if($member_uid > 0) {
            $sql = "select nick_name,birth_day,gender from user where supervisor_uid='$member_uid'";
            $result = M()->find($sql);
            if($result!=null) {
                $birth_day = strtotime($result['birth_day']);
                if(strtotime("+1 months", $birth_day)>time()){
                    echo date("Y年m月d日", strtotime("+1 months", $birth_day));
                    echo '乙肝疫苗第二次-乙型病毒性肝炎';
                }else if(strtotime("+2 months", $birth_day)>time() && strtotime("+1 months", $birth_day)<time()){
                    echo date("Y年m月d日", strtotime("+2 months", $birth_day));
                    echo '脊灰疫苗第一次-脊髓灰质炎(小儿麻痹)';

                }else if(strtotime("+3 months", $birth_day)>time() && strtotime("+2 months", $birth_day)<time()){
                    echo date("Y年m月d日", strtotime("+3 months", $birth_day));
                    echo '脊灰疫苗第二次-脊髓灰质炎(小儿麻痹)，无细胞百日破疫苗第一次-百日咳、白喉、破伤风';
                }else if(strtotime("+4 months", $birth_day)>time() && strtotime("+3 months", $birth_day)<time()){
                    echo date("Y年m月d日", strtotime("+4 months", $birth_day));
                    echo '脊灰疫苗第三次-脊髓灰质炎(小儿麻痹)，无细胞百日破疫苗第二次-百日咳、白喉、破伤风';
                }else if(strtotime("+5 months", $birth_day)>time() && strtotime("+4 months", $birth_day)<time()){
                    echo date("Y年m月d日", strtotime("+5 months", $birth_day));
                    echo '无细胞百日破疫苗第三次-百日咳、白喉、破伤风';
                }else if(strtotime("+6 months", $birth_day)>time() && strtotime("+5 months", $birth_day)<time()){
                    echo date("Y年m月d日", strtotime("+6 months", $birth_day));
                    echo '乙肝疫苗第三次-乙型病毒性肝炎，流脑疫苗第一次-流行性脑脊髓膜炎';
                }else if(strtotime("+8 months", $birth_day)>time() && strtotime("+6 months", $birth_day)<time()){
                    echo date("Y年m月d日", strtotime("+8 months", $birth_day));
                    echo '麻疹疫苗第一次-麻疹';
                }else if(strtotime("+9 months", $birth_day)>time() && strtotime("+8 months", $birth_day)<time()){
                    echo date("Y年m月d日", strtotime("+9 months", $birth_day));
                    echo '流脑疫苗第二次-流行性脑脊髓膜炎';
                }else if(strtotime("+1 years", $birth_day)>time() && strtotime("+9 months", $birth_day)<time()){
                    echo date("Y年m月d日", strtotime("+1 years", $birth_day));
                    echo '乙脑减毒疫苗第一次-流行性乙型脑炎';
                }else if(strtotime("+18 months", $birth_day)>time() && strtotime("+1 years", $birth_day)<time()){
                    echo date("Y年m月d日", strtotime("+18 months", $birth_day));
                    echo '甲肝疫苗第一次-甲型病毒性肝炎，无细胞百日破疫苗第四次-百日咳、白喉、破伤风，麻风腮疫苗第一次-麻疹、风疹、腮腺炎';
                }else if(strtotime("+2 years", $birth_day)>time() && strtotime("+18 months", $birth_day)<time()){
                    echo date("Y年m月d日", strtotime("+2 years", $birth_day));
                    echo '乙脑减毒疫苗第二次-流行性乙型脑炎，甲肝疫苗(与前剂间隔6-12个月)第二次-甲型病毒性肝炎';
                }else if(strtotime("+3 years", $birth_day)>time() && strtotime("+2 years", $birth_day)<time()){
                    echo date("Y年m月d日", strtotime("+3 years", $birth_day));
                    echo 'A+C流脑疫苗加强-流行性脑脊髓膜炎';
                }else if(strtotime("+4 years", $birth_day)>time() && strtotime("+3 years", $birth_day)<time()){
                    echo date("Y年m月d日", strtotime("+4 years", $birth_day));
                    echo '脊灰疫苗第四次-脊髓灰质炎(小儿麻痹)';
                }else if(strtotime("+6 years", $birth_day)>time() && strtotime("+4 years", $birth_day)<time()){
                    echo date("Y年m月d日", strtotime("+6 years", $birth_day));
                    echo '无细胞百日破疫苗(白破)加强-百日咳、白喉、破伤风，麻风腮疫苗第二次-麻疹、风疹、腮腺炎，乙脑减毒疫苗第三次-流行性乙型脑炎';
                }
//                echo date("Y年m月d日", );
            }
        }
    }else{
        echo '乙肝疫苗第一次-乙型病毒性肝炎，卡介苗第一次-结核病';
    }
    echo '<a href="javascript:void(0)" onclick="goUrlClick(\'baby_vaccine.php\')" class="i-more">完整疫苗接种信息》</a>';

}

function index_grow_diary_list() {
	$sql = "SELECT * from grow_diary WHERE `open`='1' order by rand() limit 3";
    $result = M()->query($sql);
	echo("<ul>");
	foreach($result as $key=>$value){
		$Id = $value['Id'];
        $title = $value['title'];
//		$time = date('Y年m月d日',$value['create_time']);
		$content = mb_substr($value['content'],0,10, 'utf-8');
		echo("<a href='ceanza_view.php?grow_id={$Id}' class='fancybox'>
                            <h4>{$title}</h4></a>
                            <p>
        {$content}
        </p>");
//		echo('<li class="m-none"><a href="javascript:loadArticle('.$uid.')" class="fancybox"><div class="n-img"><img src="../theme/cn/images/content/img/'.$icon.'"></div><span><b>'.$title.'</b>'.$desc.'<i>'.$pub_date.'</i></span></a></li>');
	}
	echo("</ul>");

}
?>
