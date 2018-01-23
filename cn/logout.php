<?php
session_start();
//session_unset();
//session_destroy();
unset($_SESSION['user_token']);
unset($_SESSION['user_email']);
unset($_SESSION['user_credit']);
unset($_SESSION['user_epaper']);
unset($_SESSION['auth_code']);
unset($_SESSION['CURRENT_KID_UID']);
unset($_SESSION['CURRENT_KID_NICKNAME']);
unset($_SESSION['CURRENT_KID_AGE']);
unset($_SESSION['question_uid']);
unset($_SESSION['answer_id']);

?>
