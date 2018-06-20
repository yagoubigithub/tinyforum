<?php
if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['email'])){
   die("Bad access");
}
require_once('db.php');
require_once('usersAPI.php');

$user = tinyf_users_get_by_name($_POST['username']);
if($user != NULL){
   tinyf_db_close();
    die('User Exist');
}
$user = NULL;
$user = tinyf_users_get_by_email($_POST['email']);
if($user != NULL){
     tinyf_db_close();
    die('email Exist');
}
$result = tinyf_users_add(trim($_POST['username']),trim($_POST['password']),trim($_POST['email']),0);
tinyf_db_close();
if($result){
    die('Success');
}else{
    die('Failure');
}

?>