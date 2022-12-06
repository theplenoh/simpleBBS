<?php
require_once "common.php";
require_once $path."db_connect.php";

$post_id = $_GET['post_id'];

if (!isset($_GET['no']) || $_GET['no'] < 0)
    $no = 0;
else
    $no = $_GET['no'];

// 글 정보 가져오기
$result = mysqli_query($conn, "SELECT * FROM {$board_name} WHERE post_id={$post_id}");
$row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?=$charset?>">
    <title><?=$board_title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="<?=$path?>style.css">
</head>

<body>
<div id="wrap">
<h1><?=$board_title?></h1>
<main>
    <h2>View a Post</h2>
    <dl>
        <dt>Posted by</dt>
        <dd class="posted-by"><?=$row['name']?></dd>

<?php
if ($row['email']!="")
{
?>
        <dt>E-mail</dt>
        <dd class="email">
            <a href="mailto:<?=$row['email']?>"><?=$row['email']?></a>
        </dd>
<?php
}
?>
        <dt>Date/Time</dt>
        <dd class="date-time"><?=$row['wdate']?></dd>

        <dt>Views</dt>
        <dd class="views"><?=$row['views']?></dd>
    </dl>
    <article>
        <h1 class="title"><?=strip_tags($row['title'])?></h1>
        <p><?=filter($row['content'])?></p>
    </article>

    <p class="buttons">
        <a class="btn" href="<?=$path?>list.php?no=<?=$no?>">List</a>
        <a class="btn" href="<?=$path?>compose.php">Post New</a>
        <a class="btn" href="<?=$path?>edit.php?post_id=<?=$post_id?>">Edit</a>
        <a class="btn" href="<?=$path?>pre_del.php?post_id=<?=$post_id?>">Delete</a>
    </p>

    <section class="prevnext-posts">
        <h2 class="sr-only">Prev/Next Post(s)</h2>
        <table class="list">
<?php
$result = mysqli_query($conn, "SELECT post_id, name, title FROM {$board_name} WHERE post_id > {$post_id} LIMIT 1");
$prev_id = mysqli_fetch_array($result);

if (isset($prev_id['post_id']))
{
?>
            <tr>
                <th>Prev</th>
                <td class="title"><a href="<?=$path?>view.php?post_id=<?=$prev_id['post_id']?>"><?=$prev_id['title']?></a></td>
                <td class="name"><?=$prev_id['name']?></td>
            </tr>
<?php
}
?>
<?php
$result = mysqli_query($conn, "SELECT post_id, name, title FROM {$board_name} WHERE post_id < {$post_id} ORDER BY post_id DESC LIMIT 1");
$next_id = mysqli_fetch_array($result);

if (isset($next_id['post_id']))
{
?>
            <tr>
                <th>Next</th>
                <td class="title"><a href="<?=$path?>view.php?post_id=<?=$next_id['post_id']?>"><?=$next_id['title']?></a></td>
                <td class="name"><?=$next_id['name']?></td>
            </tr>
<?php
}
?>
        </table>
    </section>
</main>
</div>
</body>
</html>
<?php
$result = mysqli_query($conn, "UPDATE {$board_name} SET views=views+1 WHERE post_id={$post_id}");

mysqli_close($conn);
?>
