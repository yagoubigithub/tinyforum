
<?php

if(!isset($_GET['id'])){
    die("BAD access");
}
$_id = $_GET['id'];

if(!isset($_GET['c']) || ($_GET['c']) != 1){
    echo '<a href ="deleteForum.php?id='.$_id.'&c=1">Are you shure</a>';
}
if($_id  == 0){
    die("BAD access 2");
}
require_once('db.php');
require_once('forumsAPI.php');


$forum = tinyf_forums_get_by_id($_id);
if($forum ==  NULL){
    tinyf_db_close();
die('Bad forum id');
}
$result  =  tinyf_forums_delete($_id);
tinyf_db_close();
if($result){
    die('forum delete');
}else{
    die('Faild');
}
?>
