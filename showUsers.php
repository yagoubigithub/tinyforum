<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show Users</title>
</head>
<body>
    <?php

require_once('db.php');
require_once('usersAPI.php');
$users = tinyf_users_get();

if($users == NULL)
   die('Prblem');
$ucount = @count($users);

if($ucount == 0)
die('No users in database');
    ?>

    
    <ul type="square">
    <?php
    for($i = 0;$i<$ucount;$i++){
        $user =$users[$i];
        echo  "<li><a href='\userProfil.php?id=$user->id'>$user->name -- $user->email </a></li>";
    }

        
        ?>
    </ul>
</body>
</html>