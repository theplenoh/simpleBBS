<?php
require_once "common.php";
require_once $path."db_connect.php";

$post_id = $_GET['post_id'];
$password = $_POST['password'];

$result = mysqli_query($conn, "SELECT password FROM {$board_name} WHERE post_id={$post_id}");
$row = mysqli_fetch_array($result);

if ($password == $row['password'])
{
    $query = "DELETE FROM {$board_name} WHERE post_id={$post_id}";
    $result = mysqli_query($conn, $query);

    $success = true;
}
else
{
?>
<script>
alert("Wrong password!");
history.go(-1);
</script>
<?php
exit;
}
?>
<script>
if (<?=$success?>)
{
alert("Successfully deleted!");
}
</script>
<meta http-equiv="Refresh" content="0; URL=list.php">
