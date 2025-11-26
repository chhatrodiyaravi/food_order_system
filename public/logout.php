<?php
session_start();
header('Location: index.php');
setcookie("remember_user", "", time() - 3600, "/");
session_destroy();
header("Location: login.php");
exit;
