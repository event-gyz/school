<?php
header('Content-Type:text/plain;charset=utf-8');
session_start();

include("inc.php");
if(isset($_POST['type']) && $_POST['type'] == 'save'){
    if(empty($_POST['buds_type'])){
        echo json_encode(['errno'=>-1,'msg'=>'参数错误，请刷新重试']);
        exit;
    }
    $buds_type = $_POST['buds_type'];
    $date = $_POST['date'];
    $_token = $_SESSION['user_token'];
    if ($supervisor_uid = $CMEMBER->accessFromToken($_token)) {
        if(empty($date)){
            $sql = "delete from wap_buds where buds_type='{$buds_type}' and uid=$supervisor_uid";
            $res = M()->execute($sql);
            echo json_encode(['errno'=>1,'msg'=>'保存成功']);
            exit;
        }
        $sql = "select * from wap_buds where buds_type='{$buds_type}' and uid=$supervisor_uid";
        $re = M()->find($sql);
        if($re){
            $sql = "update wap_buds set `date`='{$date}' where buds_type='{$buds_type}' and uid=$supervisor_uid";
        }else{
            $sql = "INSERT INTO wap_buds (`buds_type`,`date`,uid) VALUES ('{$buds_type}','{$date}',$supervisor_uid)";
        }
        $res = M()->execute($sql);

        echo json_encode(['errno'=>1,'msg'=>'保存成功']);

    }
    exit;
}
?>
