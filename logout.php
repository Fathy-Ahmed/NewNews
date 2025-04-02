<?php
session_start();
if(!(isset($_SESSION['is_logedin'])&&$_SESSION['is_logedin'])){
    header('location:home.php');
    return;
}
session_unset();
session_destroy();
header('location:home.php');
return ;