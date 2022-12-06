<?php
require_once "common.php";
require_once $path."db_connect.php";

$post_id = $_GET['post_id'];

$result = mysqli_query($conn, "SELECT * FROM {$board_name} WHERE post_id={$post_id}");
$row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?=$charset?>">
    <title><?=$board_title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="<?=$path?>/style.css">
</head>

<body>
<div id="wrap">
<h1><?=$board_title?></h1>
<main>
    <h2>Compose</h2>
    <form action="<?=$path?>update.php?post_id=<?=$post_id?>" method="post">
    <dl>
        <dt><label for="name">Name</label></dt>
        <dd>
            <input type="text" name="name" id="name" maxlength="6" value="<?=$row['name']?>">
        </dd>

        <dt><label for="password">Password</label></dt>
        <dd>
            <div class="warning">
                <small>
                    Enter a temporary password, as the security is loose.<br>
                    (Required later for editing/deleting this post)
                </small>
            </div>
            <input type="password" name="password" id="password" maxlength="16">
        </dd>

        <dt><label for="email">E-mail</label></dt>
        <dd>
            <input type="text" name="email" id="email" maxlength="30" value="<?=$row['email']?>">
        </dd>

        <dt><label for="title">Title</label></dt>
        <dd>
            <input type="text" name="title" id="title" maxlength="23" value="<?=$row['title']?>">
        </dd>

        <dt><label for="content">Content</label></dt>
        <dd>
            <textarea name="content" id="content"><?=$row['content']?></textarea>
        </dd>
    </dl>
    <p class="buttons">
        <button class="btn" type="submit">Edit</button>
        <a class="btn" href="<?=$path?>view.php?post_id=<?=$post_id?>">Cancel</a>
    </p>
    </form>
</main>
</div>
</body>
