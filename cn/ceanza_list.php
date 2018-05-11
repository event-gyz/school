<?php
session_start();
include('inc.php');
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
    <?php include('inc_head.php');	?>
    <style>
        body{background: none;}
        h1,h2,h3,h4,h5,h6,p,ul,li,dl,dt,dd{margin:0;padding:0;list-style: none;}
        input,button{padding: 0;margin:0;border:0;outline: none;}
        img{vertical-align: bottom}
    </style>
</head>
<body>
<?php
$payload=@$_GET['t'];
if(isset($payload)) {
    $dec_string = my_decrypt($payload);
    $params = explode("|",$dec_string);
    $action = $params[0];
    $goodlink = false;
    if($action == "resetpw") {
        $link_date = $params[1];
        $ver_code = $params[2];
        $token = $params[3];
        $date1 = new DateTime();
        $date2 = new DateTime($link_date);
        $interval = $date1->diff($date2);
        if($interval->days == 0) {
            $member_uid = $CMEMBER->accessFromToken($token);
            $CMEMBER->getUserInfo();
            if($member_uid > 0) {
                // check if the link is already used
                $sql = "UPDATE reset_password SET status=1,act_datetime=now() WHERE member_id='".$CMEMBER->id."' AND code='$ver_code' AND status=0";
                $result = query($sql);
                if(mysql_affected_rows() > 0) {
                    // login for now
                    $_SESSION['user_token'] = $token;
                    $_SESSION['user_email'] = $CMEMBER->email;
                    $_SESSION['user_credit'] = $CMEMBER->credit;
                    $_SESSION['user_epaper'] = $CMEMBER->epaper;
                    $goodlink = true;
                    echo('<script type="text/javascript">$(function(){$.fancybox({        href: "#fcb_pw_reset"    }	);});</script>');
                }
            }
        }
        if(!$goodlink) {
            // expired
            echo('
						<script type="text/javascript"> 
							$(function(){
								$("#wrap").attr("class","inpage");
								$("#content").load("fg_nouse_content.html");
							});
						</script>						
						');
        }
    }
    else if($action == 'verify') {
        $member_id = $params[1];
        $ver_code = $params[2];
        $sql = "UPDATE reg_verify SET status='1',act_datetime=now() WHERE member_id='$member_id' AND ver_code='$ver_code' AND status=0";
        $result = query($sql);
        if(mysqli_affected_rows() > 0) {
            echo ('<script type="text/javascript"> 
			        			$(function(){
			        				$("#regwork").fancybox().trigger("click");
			        			});</script>
			        		');
        }
        else {
            // TODO error handling
        }
    }
    else if($action == 'epaper' || $action == 'train') {
        $member_id = $params[1];
        $token = $params[2];
        $member_uid = $CMEMBER->accessFromToken($token);
        if($member_uid > 0) {
            $CMEMBER->getUserInfo();
            $_SESSION['user_token'] = $token;
            $_SESSION['user_email'] = $CMEMBER->email;
            $_SESSION['user_credit'] = $CMEMBER->credit;
            $_SESSION['user_epaper'] = $CMEMBER->epaper;
            echo ('<script type="text/javascript"> $(function(){document.location.href ="http://x.eqxiu.com/s/PclsbuXT";});</script>');
        }
    }
}
?>
<!-- InstanceBeginEditable name="wrap" -->
<section id="wrap">
    <!-- InstanceEndEditable -->

    <!--【Header】-->
    <?php include 'inc_header.php'; ?>
    <!--【Header End】-->

    <!--【Content】-->
    <section id="content">
        <!--//主內容//-->
        <section class="indexcont">
            <section class="inbox noBoxShadowPage">
                <section class="contbox clearfix">
                    <section class="ceanza">
                        <!--//主選單標題與路徑//-->
                        <div class="breadcrumbs_logo">
                            <h2 class="title">宝贝日记</h2>
                            <section class="gopath"><a href="index.php">首页</a> > 宝贝日记</section>
                        </div>
                        <section class="Txt clearfix">
                            <p>替您的宝宝写下成长日记，为您的宝宝记录每天的成长与回忆。</p>
                        </section>
                        <a href="ceanza_add.php" class="add_ceanza">新增宝贝日记<b></b></a>
                        <a href="javascript: void(0)" class="ceanza_category">
                            浏览日记分类
                            <b></b>
                            <div class="category-list">
                                <ul>

                                    <li <?= (isset($_GET['category_name'])&&($_GET['category_name']=='0月-3月'))?'class="checked"':''?>>0月-3月</li>
                                    <li <?= (isset($_GET['category_name'])&&($_GET['category_name']=='3月-1岁'))?'class="checked"':''?>>3月-1岁</li>
                                    <li <?= (isset($_GET['category_name'])&&($_GET['category_name']=='1岁-2岁'))?'class="checked"':''?>>1岁-2岁</li>
                                    <li <?= (isset($_GET['category_name'])&&($_GET['category_name']=='2岁-3岁'))?'class="checked"':''?>>2岁-3岁</li>
                                    <li <?= (isset($_GET['category_name'])&&($_GET['category_name']=='3岁-4岁'))?'class="checked"':''?>>3岁-4岁</li>
                                    <li <?= (isset($_GET['category_name'])&&($_GET['category_name']=='4岁-5岁'))?'class="checked"':''?>>4岁-5岁</li>
                                    <li <?= (isset($_GET['category_name'])&&($_GET['category_name']=='5岁-6岁'))?'class="checked"':''?>>5岁-6岁</li>
                                </ul>
                                <p class="close">×</p>
                            </div>
                        </a>
                        <div class="browse_mode">
                            <p></p>
                            <ul class="mode_sel">
                                <li class="selected">
                                    <span>缩图</span>
                                    <b></b>
                                </li>
                                <li>
                                    <span>列表</span>
                                    <b></b>
                                </li>
                            </ul>
                        </div>
                    </section>

                    <?php
                    // 缩略图列表开始
                    //        var_dump($_SESSION);
                    //            if($_SESSION['CURRENT_KID_BIRTH_DAY']){
                    //
                    //            }
                    if(isset($_SESSION['user_token'])) {
                        $member_uid = $_SESSION["CURRENT_KID_UID"];
                        $category_name = !empty($_GET['category_name'])?$_GET['category_name']:'';
                        if($category_name){
                            $sql = "select * from grow_diary where uid in (select supervisor_uid from user where uid={$member_uid}) and grow_diary_category_name='{$category_name}' order by Id";
                        }else{
                            $sql = "select * from grow_diary where uid in (select supervisor_uid from user where uid={$member_uid}) order by Id";
                        }
                        $list = query_result_list($sql);
                    }
                    if($list){
                        $tmp_list = array();
                        foreach ($list as $k){
                            $picurl = $k['picurl'];
                            $year_now = date('Y',strtotime($k['date']));
                            $year_old = date('Y', strtotime($_SESSION['CURRENT_KID_BIRTH_DAY']));
                            $year_age = $year_now - $year_old;
                            $tmp_list[$year_now][] = array('img' => $picurl,'title' => $k['title'],'Id' =>$k['Id'],'date'=>$k['date']);
                        }
                        unset($k);
                        foreach($tmp_list as $key=>$value){
                            $year_now = $key;
                            $year_old = date('Y', strtotime($_SESSION['CURRENT_KID_BIRTH_DAY']));
                            $year_age = $key - $year_old;
                            echo "<div class=\"ceanza_list contraction\">";
                            echo "<p>{$year_now} 年<span>{$year_age} 岁</span></p>";
                            echo "<ul class=\"ceanza_contraction\">";
                            foreach($value as $k){
                                echo "<li><a href=\"ceanza_view.php?grow_id={$k['Id']}\"><p><img src={$k['img']} alt=\"\"><i></i></p>
    			<span><b>{$k['title']}</b></span></a></li>";
                            }

                            echo "</ul>";
                            echo "</div>";

                            echo "<div class=\"ceanza_list\" style='display:none'>";
                            echo "<p>{$year_now} 年<span>{$year_age} 岁</span></p>";
                            echo "<div class=\"title\"> <p> <span>撰写日期</span> <span>日记标题</span> </p>";
                            echo "<ul class=\"list\">";
                            foreach($value as $k){
                                $date = date('Y年m月d日',strtotime($k['date']));
                                echo "<li><p>{$date}</p>
                        <p>{$k['title']}</p>  <p><b class=\"check\"></b>"
                                    . "<span><a href=\"ceanza_view.php?grow_id={$k['Id']}\">查看</a></span></p> "
                                    . "</li>";
                                echo "<li>
                            <p><b class=\"eqit\"></b><span><a href=\"ceanza_eqit.php?grow_id={$k['Id']}\">编辑</a></span></p>
                            <p><b class=\"delete\"></b><span><a href=\"grow_diary.php?grow_id={$k['Id']}&type=delete\">删除</a></span></p>
                          </li>";
                            }
                            echo "</ul>";
                            echo "</div></div>";
                        }


//				$key_list = array_keys($tmp_list);
//				while($key_list){
//					$age = array_pop($key_list);
//					$year_now = date('Y',strtotime($age));
//					$year_old = date('Y', strtotime($_SESSION['CURRENT_KID_BIRTH_DAY']));
//					$year_age = $year_now - $year_old;
//					// 缩略图列表开始
//					echo "<div class=\"ceanza_list contraction\">";
//					echo "<p>{$year_now} 年<span>{$year_age} 岁</span></p>";
//					echo "<ul class=\"ceanza_contraction\">";
//					foreach($tmp_list[$age] as $k){
//						echo "<li><p><img src={$k['img']} alt=\"\"><i></i></p>
//    			<span><b>{$k['title']}</b></span></li>";
//					}
//					echo "</ul>";
//					echo "</div>";
//					// 缩略图列表结束
//
//					// 列表开始
//					$url = base64_encode($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
//					echo "<div class=\"ceanza_list\">";
//					echo "<p>{$year_now} 年<span>{$year_age} 岁</span></p>";
//					echo "<div class=\"title\"> <p> <span>撰写日期</span> <span>日记标题</span> </p>";
//					echo "<ul class=\"list\">";
//					foreach($tmp_list[$age] as $k){
//						$date = date('Y年m月d日',strtotime($age));
//						echo "<li><p>{$date}</p>
//                        <p>{$k['title']}</p>  <p><b class=\"check\"></b>"
//							. "<span><a href=\"ceanza_view.php?grow_id={$k['Id']}\">查看</a></span></p> "
//							. "</li>";
//						echo "<li>
//                            <p><b class=\"eqit\"></b><span><a href=\"ceanza_eqit.php?grow_id={$k['Id']}\">编辑</a></span></p>
//                            <p><b class=\"delete\"></b><span><a href=\"grow_diary.php?grow_id={$k['Id']}&type=delete&back={$url}\">删除</a></span></p>
//                          </li>";
//					}
//					echo "</ul>";
//					echo "</div></div>";
//					// 列表结束
//				}
                    }else{
                        if(isset($_GET['category_name']) && !empty($_GET['category_name'])) {
                            ?>
                            <div class="noData" style="display:inherit">
                                符合
                                <span class="ceanza_type"><?php echo $_GET['category_name'] ?></span>
                                的日记有<span class="ceanza_count">0</span>篇,您可以点击<a href="ceanza_add.php">新增宝贝日记</a>
                            </div>
                            <?php
                        }
                    }



                    ?>

                    <p class='end_line'></p>
                    <section class="clearfix relevant_articles">
                        <h3 class="title">宝贝日记相关文章<a href="recommend.php" class="i-more">更多内容<span>&gt;&gt;</span></a></h3>
                        <?php af_articles_list_recommend('成长日记'); ?>
                    </section>
                    <!--//主選單標題與路徑//-->
                </section>
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
</body>
<!-- InstanceEnd --></html>
