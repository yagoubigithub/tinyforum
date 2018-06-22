<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>add Forums</title>
    <style>
    input{
        padding: 10px 10px 10px 10px;
        margin: 5px;
        min-width: 250px;
    }
    </style>
</head>
<body>
    <form action="saveForum.php" method="POST">
    <label for="title">Forum Title</label>
    <input type="text" id="title" name="title">
    <br>

    <label for="desc">Description</label>
    <input type="text" id="desc" name="desc">
    <br>

    <input type="submit" name="saveforum">
    </form>
</body>
</html>