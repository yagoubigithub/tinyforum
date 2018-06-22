<?php
if(!isset($_POST['title']) || !isset($_POST['desc']) ){
   die("Bad access");
}
require_once('db.php');
require_once('forumsAPI.php');


$result = tinyf_forums_add(trim($_POST['title']),trim($_POST['desc']));

tinyf_db_close();
if($result){
    die('Success');
}else{
    die('Failure');
}

?>