<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/Static/Style.css">
    <title>Update</title>
</head>

<body>
<?php var_dump($path, $query, $params) ?>

    <form action="/" method="POST">
        <label for="username">Username</label>
        <input id="username" type="text" name="username">

        <label for="email">E-mail</label>
        <input id="email" type="text" name="email">

        <label for="password">Password</label>
        <input id="password" type="password" name="password">

        <label for="confirm_password">Confirm password</label>
        <input id="confirm_password" type="password" name="confirm_password">

        <button type="submit">Create user</button>
    </form>
</body>

</html>