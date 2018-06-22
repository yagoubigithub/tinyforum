<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show Forums</title>
</head>
<body>
    <?php

require_once('db.php');
require_once('forumsAPI.php');

$forums = tinyf_forums_get();

if($forums == NULL)
   die('Prblem');
$fcount = @count($forums);

if($fcount == 0)
die('No forums in database');
    ?>

    
    <ul type="square">
    <?php
    for($i = 0;$i<$fcount;$i++){
        $forum =$forums[$i];
        echo  "<li><a href='forums.php?id=$forum->id'>$forum->title </a> <br> $forum->desc <a href='deleteForum.php?id=$forum->id'>delete </a> -- <a href='modifyForum.php?id=$forum->id'>update </a></li>";
    }

        
        ?>
    </ul>
</body>
</html>