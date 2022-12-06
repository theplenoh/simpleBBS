<?php
require_once "common.php";
require_once $path."db_connect.php";

$posted_by = sanitize($_POST['name']);
$password = sanitize($_POST['password']);
$email = sanitize($_POST['email']);
$title = sanitize($_POST['title']);
$content = sanitize($_POST['content']);
$ip_addr = $_SERVER['REMOTE_ADDR'];

$query = "INSERT INTO {$board_name} (name, email, password, title, content, wdate, ip_addr, views) ";
$query.= "VALUES ('{$posted_by}', '{$email}', '{$password}', '{$title}', '{$content}', now(), '{$ip_addr}', 0)";

if(mysqli_query($conn, $query))
{
    $success = true;
}
else
{
    echo mysqli_error($conn);
    exit;
}

mysqli_close($conn);
?>
<script>
if (<?=$success?>)
{
    alert("Successfully submitted!");
}
</script>
<meta http-equiv="Refresh" content="0; URL=list.php">
