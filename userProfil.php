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
    <title><?php echo $user->name; ?></title>
</head>
<body>
  <?php
echo $user->name;
echo '</br>';
echo $user->email;
echo '</br>';
echo $user->password;
echo '</br>';
  ?>
</body>
</html>