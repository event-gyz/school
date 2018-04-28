<?php
session_start();
include('inc.php');
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
    <?php include('inc_head.php');  ?>
    <style>
        body{background: none;}
        h1,h2,h3,h4,h5,h6,p,ul,li,dl,dt,dd{margin:0;padding:0;list-style: none;}
        input,button{padding: 0;margin:0;border:0;outline: none;}
        img{vertical-align: bottom}
    </style>
</head>


<body>
<!-- InstanceBeginEditable name="wrap" -->
<section id="wrap">
    <!-- InstanceEndEditable -->

    <!--【Header】-->
    <?php include 'inc_header.php'; ?>
    <!--【Header End】-->
    <?php
    $sql = '';
    ?>
    <!--【Content】-->
    <section id="content">
        <!-- InstanceBeginEditable name="content" -->
        <!--//主內容//-->
        <section class="indexcont">
            <section class="inbox noBoxShadowPage">
                <section class="contbox clearfix">
                    <section class="ceanza">
                        <form action="grow_diary.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="update" />
                            <input type="hidden" name="id" value="<?php echo $_GET['grow_id']?>" />
                            <?php
                            $sql  = 'select * from grow_diary where Id='.$_GET['grow_id'];
                            $result = M()->find($sql);
                            //				print_r($result);
                            ?>
                            <h4>编辑宝贝日记</h4>
                            <section class="gopath"><a href="index.php">首页</a> > 编辑宝贝日记</section>
                            <ul class="eqit_content">
                                <input type="hidden" name="file" value=<?php echo $result['picurl']?> />
                                <li class="title">
                                    标题：<input type="text" name="title" value="<?php echo $result['title']?>">
                                    <div class="isShare">
                                        <input type="checkbox" id="checkshare">
                                        <label for="checkshare">公开</label>
                                    </div>
                                </li>
                                <li>内容：<input type="text" name="content" value="<?php echo $result['content']?>"></li>

                                <li class="eqitUploadImg">
                                    <div class="imgContent"><img src=<?php echo $result['picurl']?> alt=""></div>
                                    <input type="file" name="file" accept="image/jpg">
                                    <p>点击图片，重新上传</p>
                                </li>
                                <li>
                                    <b class="clock"></b>
                                    记录时间：
                                    <input class="time" type="date" name="date" value="<?php echo $result['date']?>">
                                </li>
                                <li>
                                    <b class="address"></b>
                                    记录地址：
                                    <input class="address-input" type="text" name="address" value="<?php echo $result['address']?>">
                                </li>
                            </ul>

                            <button class="submit ceanza_eqit_submit">提交</button>
                        </form>
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
