<?php
header('Content-Type:text/plain;charset=utf-8');
session_start();

include("inc.php"); 

include("../inc/upload.php");
if(isset($_POST['type']) && $_POST['type'] == 'person'){
    $files = $_FILES['file'];
    $_token = $_SESSION['user_token'];

    if ($supervisor_uid = $CMEMBER->accessFromToken($_token)) {
        $picurl = ceanza_upload("file");
        $sql = "update member set image_url='{$picurl}' where uid = $supervisor_uid";
        $result = query($sql);
        if($result!=null) {
            header("Location:person.php");
        }
    }
    exit;
}

if(isset($_POST['type']) && $_POST['type'] == 'baby'){
    $files = $_FILES['file'];
    $_token = $_SESSION['user_token'];

    if ($supervisor_uid = $CMEMBER->accessFromToken($_token)) {
        $picurl = ceanza_upload("file");
        $sql = "update `user` set image_url='{$picurl}' where supervisor_uid = $supervisor_uid";
        $result = query($sql);
        if($result!=null) {
            header("Location:baby_info.php");
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
    $sql = "delete from wap_height where id=".$_GET['id'];
    if(query_delete($sql)){
        $url = base64_decode($_GET['back']);
        header("Location:height_record_list.php");
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
