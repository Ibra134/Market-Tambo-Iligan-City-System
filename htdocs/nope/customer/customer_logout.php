<?php
session_start();
session_destroy();
header("Location: ../customer/customer_login.php");
exit();
?>
