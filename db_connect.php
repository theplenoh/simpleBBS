<?php
require_once "common.php";
require_once $path."db_info.php";

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_query($conn, "SET NAMES utf8");
?>
