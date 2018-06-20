<?php
if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['email'])){
   die("Bad access");
}
require_once('db.php');
require_once('usersAPI.php');
echo $_POST['username'];

$result = tinyf_users_add($_POST['username'],$_POST['password'],$_POST['email'],0);
tinyf_db_close();
if($result){
    die('Success');
}else{
    die('Failure');
}

?>