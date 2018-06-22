<?php

if(!isset($_POST['title']) || !isset($_POST['desc'])){
    die("Bad access");
 }
 require_once('db.php');
require_once('forumsAPI.php');
$_id = $_GET['id'];

    if($_id  == 0){
        die("BAD access 2");
    }
$user = tinyf_forums_get_by_id($_id);
$result = tinyf_forums_update($_id,trim($_POST['title']),trim($_POST['desc']));

tinyf_db_close();
if($result){
    die('Success');
}else{
    die('Failure');
}



?>
