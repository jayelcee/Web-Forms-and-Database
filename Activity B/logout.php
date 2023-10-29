<?php
session_start();

// Delete the remember me cookies
setcookie('username', '', time() - 3600);
setcookie('password', '', time() - 3600);

session_destroy();
header('Location: index.php');
exit();
?>
