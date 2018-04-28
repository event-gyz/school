<?php
header('Content-Type:text/plain;charset=utf-8');
session_start();

include("inc.php"); 

include("../inc/upload.php");
if(isset($_POST['type']) && $_POST['type'] == 'diary'){

    if(isset($_POST['checkshare']) && ($_POST['checkshare']=='on')){
        $open = 1;
    }else{
        $open = 2;
    }
    $title = $_POST['title'];
    $content = $_POST['content'];
    $files = $_FILES['file'];
    $date = $_POST['date'];
    $address = $_POST['address'];
    $create_time = time();
    $_token = $_SESSION['user_token'];
    $grow_diary_category_name = $_POST['grow_diary_category_name'];
    if(empty($title)) {
        die(genResponse(false, "请填写完整资料"));
    }
    else {
        if ($supervisor_uid = $CMEMBER->accessFromToken($_token)) {
            $picurl = ceanza_upload("file");
            $sql = "INSERT INTO grow_diary (title,content,picurl, address,create_time,uid,grow_diary_category_name,`date`,`open`)  "
                . "VALUES ('".$title."','".$content."','".$picurl."','".$address."','".$create_time."','".$supervisor_uid."','".$grow_diary_category_name."','". $date ."','". $open ."')";
            $result = query($sql);
            if($result!=null) {
                header("Location:ceanza_list.php");
                // die(genResponse(true, "添加成功"));
            }
            // die(genResponse(false,$_v_ERROR_REGISTER_FAILED."，添加失败"));
        }
    }
    exit;
}

if(isset($_POST['type']) && $_POST['type'] == 'update'){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $files = $_POST['file'];
    $new_files = $_FILES['new_file'];
    $date = $_POST['date'];
    $address = $_POST['address'];
    $create_time = time();
    $_token = $_SESSION['user_token'];
//    $grow_diary_category_name = $_POST['grow_diary_category_name'];
    if(empty($title) || empty($_token)) {
        die(genResponse(false, $_v_ERROR_REGISTER_FAILED."，请填写完整资料"));
    }
    else {
        if ($supervisor_uid = $CMEMBER->accessFromToken($_token)) {
            if(isset($_FILES['new_file']) && !empty($_FILES['new_file'])){
                $picurl = ceanza_upload("new_file");
            }else{
                $picurl = '"'.$files.'"';
            }
            $sql = "update grow_diary set title='{$title}',content='{$content}',picurl='{$picurl}',address='{$address}',`date`='{$date}' where Id=$id";
            $result = query($sql);
            if($result!=null) {
                header("Location:ceanza_list.php");
                // die(genResponse(true, "添加成功"));
            }
            // die(genResponse(false,$_v_ERROR_REGISTER_FAILED."，添加失败"));
        }
    }
    exit;
}

if(isset($_GET['type']) && $_GET['type'] == "get"){
    $category = 0;
    if(isset($_GET['category'])){
        $category = intval($_GET['category']);
    }
    $where = "where id > 0";
    if($category){
        $where .= " and grow_diary_category_id=".$category;
    }
    $sql = "select * from grow_diary {$where} group by date";
    $result = query_result_list($sql);
    if($result){
        var_dump($result);
    }
    echo "无数据";
}

if(isset($_GET['type']) && $_GET['type'] == "delete"){
    $sql = "delete from grow_diary where Id=".$_GET['grow_id'];
    if(query_delete($sql)){
        $url = base64_decode($_GET['back']);
        header("Location:ceanza_list.php");
    }
}


function ceanza_upload($name = "file"){
    $up = new fileupload;
    //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
    $up -> set("path", "../uploads/");
    $up -> set("maxsize", 32000000);
    $up -> set("allowtype", array("gif", "png", "jpg","jpeg"));
    $up -> set("israndname", false);
  
    //使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
    if($up -> upload($name)) {
        return json_encode($up->getFileName());
    } else {
        die("文件上传失败");
        //$up->getErrorMsg()
    }
}
?>
