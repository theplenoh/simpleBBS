<?php
require_once "common.php";
require_once $path."db_connect.php";

$post_id = $_GET['post_id'];
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
    <h2>Confirm before Deleting</h2>
    <form action="<?=$path?>del.php?post_id=<?=$post_id?>" method="post">
    <dl>
        <dt>Password</dt>
        <dd>
            <input type="password" name="password" size="16">
        </dd>
    </dl>
    <p class="buttons">
        <button class="btn" type="submit">Delete</button>
        <a href="<?=$path?>view.php?post_id=<?=$post_id?>" class="btn">Cancel</a>
    </p>
    </form>
</main>
</div>
</body>
</html>
