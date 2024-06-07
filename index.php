<?php
require 'function.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/stylelogin.css">
    <title>Login Page</title>
</head>

<body>
    <div class="login-card">
        <h1>LOGIN</h1>
        <h2>IF COFFEESHOP</h2>

        <form class="login-form" method="POST">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Kata Sandi">
            <a href="registerPage.php">Sign In</a>
            <button type="submit" name="loginbar">LOGIN</button>

        </form>

    </div>
</html>