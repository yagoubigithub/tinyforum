<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>addUser</title>
    <style>
    input{
        padding: 10px 10px 10px 10px;
        margin: 5px;
        min-width: 250px;
    }
    </style>
</head>
<body>
    <form action="saveUser.php" method="POST">
    <label for="username">Username</label>
    <input type="text" id="username" name="username">
    <br>

    <label for="password">Password&ThickSpace;</label>
    <input type="password" id="password" name="password">
    <br>

    <label for="email">Email&ThickSpace;&ThickSpace;&ThickSpace;&ThickSpace;&ThickSpace;</label>
    <input type="email" id="email" name="email">
    <br>

    <input type="submit" name="saveuser">
    </form>
</body>
</html>