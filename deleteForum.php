
<?php

if(!isset($_GET['id'])){
    die("BAD access");
}
$_id = $_GET['id'];

if(!isset($_GET['c']) || ($_GET['c']) != 1){
    echo '<a href ="deleteUser.php?id='.$_id.'&c=1">Are you shure</a>';
}
if($_id  == 0){
    die("BAD access 2");
}
require_once('db.php');
require_once('usersAPI.php');


$user = tinyf_users_get_by_id($_id);
if($user ==  NULL){
    tinyf_db_close();
die('Bad user id');
}
$result  =  tinyf_users_delete($_id);
tinyf_db_close();
if($result){
    die('user delete');
}else{
    die('Faild');
}
?>
