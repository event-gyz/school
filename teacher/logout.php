<?php
session_start();
//session_unset();
//session_destroy();
unset($_SESSION['teacher_token']);
unset($_SESSION['teacher_email']);

?>
