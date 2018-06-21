<?php

if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['email'])){
    die("Bad access");
 }
 require_once('db.php');
require_once('usersAPI.php');
$_id = $_GET['id'];
$user = tinyf_users_get_by_id($_id);
$user1 = tinyf_users_get_by_name($_POST['username']);
$user2 = tinyf_users_get_by_email($_POST['email']);

if($user1 != NULL && $user1->id != $_id){
    tinyf_db_close();
    die('User Exist');
}else{
    if($user2 !=NULL && $user2->id != $_id){
        tinyf_db_close();
       die('email Exist');
    }else{
        $pass = trim($_POST['password']);
        if(strlen($pass)  == 0){
            $pass =NULL;
        }
        $result = tinyf_users_update($_id,trim($_POST['username']),$pass,trim($_POST['email']),$user->isadmin);
        tinyf_db_close();
        if($result){
            die('Success');
        }else{
            die('Failure');
        }

    }
}

?>
