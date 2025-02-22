<?php
session_start();
session_destroy();
setcookie('auth', '', time() - 3600, '/');
setcookie('db_credentials', '', time() - 3600, '/');
header("Location: /views/login.php");
exit;
