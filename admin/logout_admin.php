<?php
session_start();
if(!(isset($_SESSION['is_logedin'])&&$_SESSION['is_logedin'])){
    header('location:login.php');
    return;
}
session_unset();
session_destroy();
header('location:../login.php');
return ;