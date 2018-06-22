
<?php
    if(!isset($_GET['id'])){
        die("BAD access");
    }
    $_id = $_GET['id'];
    if($_id  == 0){
        die("BAD access 2");
    }
    require_once('db.php');
require_once('forumsAPI.php');

$forum = tinyf_forums_get_by_id($_id);
tinyf_db_close();
if($forum == NULL){
    die('Bad Forum ID');
}
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modify:<?php echo $forum->title; ?></title>
    <style>
    input{
        padding: 10px 10px 10px 10px;
        margin: 5px;
        min-width: 250px;
    }
    </style>
</head>
<body>
    <form action="updateForum.php?id=<?php echo $_id; ?>" method="POST">
    <label for="title">Forum Title</label>
    <input type="text" id="title" name="title" value="<?php echo $forum->title; ?>">
    <br>

   

    <label for="desc">Description</label>
    <input type="text" id="desc" name="desc" value="<?php echo $forum->desc; ?>">
    <br>

    <input type="submit" name="modifyforum" value="modify :<?php echo $forum->title; ?>">
    </form>
</body>
</html>