<?php
/*
This file is part of miniBB. miniBB is free discussion forums/message board software, without any warranty. See COPYING file for more details. Copyright (C) 2004-2006 Paul Puzyrev, Sergei Larionov. www.minibb.net
Latest File Update: 2006-Apr-13
*/

$DB='mysql';

$DBhost='localhost';
$DBname='sunny_school';
$DBusr='kidsdna';
$DBpwd='kidsdna';

$Tf='ssminibbtable_forums';
$Tp='ssminibbtable_posts';
$Tt='ssminibbtable_topics';
$Tu='ssminibbtable_users';
$Ts='ssminibbtable_send_mails';
$Tb='ssminibbtable_banned';

$admin_usr='admin123';
$admin_pwd='12345678';
$admin_email='bclin087@gmail.com';

$bb_admin='ssbb_admin.php?';

$cookiedomain='.localhost';
$cookiename='ssforum';
$cookiepath='/teacher/minibb/';
$cookiesecure=FALSE;
$cookie_expires=108000;
$cookie_renew=1800;
$cookielang_exp=2592000;

$main_url='http://localhost/teacher/minibb';

$lang='chs';
$skin='default';
$sitename=(isset($_SERVER['SERVER_NAME'])?$_SERVER['SERVER_NAME'].' ':'').' Forum';
//$sitename='Awesome miniBB-Forums';
$emailadmin=0;
$emailusers=0;
$userRegName='_A-Za-z0-9 ';
$l_sepr='<span class="sepr">|</span>';

$post_text_maxlength=10240;
$post_word_maxlength=85;
$topic_max_length=100;
$viewmaxtopic=30;
$viewlastdiscussions=20;
$viewmaxreplys=15;
$viewmaxsearch=20;
$viewpagelim=5000;
$viewTopicsIfOnlyOneForum=0;

$protectWholeForum=0;
$protectWholeForumPwd='pwd';

$postRange=5;

$dateOnlyFormat='j F Y';
$timeOnlyFormat='H:i';
$dateFormat=$dateOnlyFormat.' '.$timeOnlyFormat;



/* New options for miniBB 1.1 */

$disallowNames=array('Anonymous', 'Fuck', 'Shit', 'Guest');
$disallowNamesIndex=array('admin', 'guest'); // 2.0 RC1f

/* New options for miniBB 1.2 */
$sortingTopics=0;
$topStats=4;
$genEmailDisable=0;

/* New options for miniBB 1.3 */
$defDays=60;
$userUnlock=0;

/* New options for miniBB 1.5 */
$emailadmposts=0;
$useredit=86400;

/* New options for miniBB 1.6 */
//$metaLocation='go';
//$closeRegister=1;
//$timeDiff=21600;

/* New options for miniBB 1.7 */
$stats_barWidthLim='31';

/* New options for miniBB 2.0 */

$dbUserSheme=array(
'username'=>array(1,'username','login'),
'user_password'=>array(3,'user_password','passwd'),
'user_email'=>array(4,'user_email','email'),
'user_icq'=>array(5,'user_icq','icq'),
'user_website'=>array(6,'user_website','website'),
'user_occ'=>array(7,'user_occ','occupation'),
'user_from'=>array(8,'user_from','from'),
'user_interest'=>array(9,'user_interest','interest'),
'user_viewemail'=>array(10,'user_viewemail','user_viewemail'),
'user_sorttopics'=>array(11,'user_sorttopics','user_sorttopics'),
'language'=>array(14,'language','language'),
'num_topics'=>array(16,'num_topics',''),
'num_posts'=>array(17,'num_posts',''),
'user_custom1'=>array(18,'user_custom1','user_custom1'),
'user_custom2'=>array(19,'user_custom2','user_custom2'),
'user_custom3'=>array(20,'user_custom3','user_custom3')
);
$dbUserId='user_id';
$dbUserDate='user_regdate'; $dbUserDateKey=2;
$dbUserAct='activity';
$dbUserNp='user_newpasswd';
$dbUserNk='user_newpwdkey';

$enableNewRegistrations=TRUE;
$enableProfileUpdate=TRUE;

$indexphp='index.php?';
$usersEditTopicTitle=FALSE;
$pathToFiles='./';
//$includeHeader='header.php';
//$includeFooter='footer.php';
//$emptySubscribe=TRUE;
//$allForumsReg=TRUE;
//$registerInactiveUsers=TRUE;
//$mod_rewrite=TRUE;
$enableViews=TRUE;
//$userInfoInPosts=array();
//$userDeleteMsgs=1;

$description='miniBB是一个袖珍型开源PHP论坛软件。
它提供的功能包括论坛样式更换，多界面语言/多时区支持，使用Apache的mod_rewrite URL处理功能来让你的论坛更容易被搜索引擎收录，易于使用和定制的搜索功能，开/关BBCode功能，针对不同的用户和不同的论坛设置不同的用户权限，禁用用户的IP或ID，垃圾信息过滤，强大的管理面板和工具。此外miniBB还提供一些插件以扩展论坛的功能如RSS聚合，敏感字过滤，显示在线用户，信息预览，合并主题等。';

$startIndex='index.php'; // or 'index.html' for mod_rewrite
$manualIndex='index.php?action=manual'; // or 'manual.html' for mod_rewrite

$enableGroupMsgDelete=TRUE;
$post_text_minlength=2;
$loginsCase=TRUE;

$allowHyperlinks=0;

$reply_to_email=$admin_email;

//$addMainTitle=1;

$startPageModern=TRUE;

?>