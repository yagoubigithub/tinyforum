
<?php
    if(!isset($_GET['id'])){
        die("BAD access");
    }
    $_id = $_GET['id'];
    if($_id  == 0){
        die("BAD access 2");
    }
    require_once('db.php');
require_once('usersAPI.php');

$user = tinyf_users_get_by_id($_id);
tinyf_db_close();
if($user == NULL){
    die('Bad User ID');
}
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modify:<?php echo $user->name; ?></title>
    <style>
    input{
        padding: 10px 10px 10px 10px;
        margin: 5px;
        min-width: 250px;
    }
    </style>
</head>
<body>
    <form action="updateUser.php?id=<?php echo $_id; ?>" method="POST">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" value="<?php echo $user->name; ?>">
    <br>

    <label for="password">Password&ThickSpace;</label>
    <input type="text" id="password" name="password" >
    <br>

    <label for="email">Email&ThickSpace;&ThickSpace;&ThickSpace;&ThickSpace;&ThickSpace;</label>
    <input type="email" id="email" name="email" value="<?php echo $user->email; ?>">
    <br>

    <input type="submit" name="saveuser" value="modify :<?php echo $user->name; ?>">
    </form>
</body>
</html>