<?php
    if(isset($_POST["submit"])) { 
        include("connexion.php");
        
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $req = $pdo->prepare("INSERT INTO users (name, login, password) VALUES (?, ?, ?)"); 
        $req->execute(array($name, $email, $password));

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sign up</title>
</head>
<body>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <div class="logo"></div>
    <div class="login-block">
        <h1>Sign up</h1>
        <form name="fo" method="post" action="" enctype="multipart/form-data"> 
            <input type="text" name="name" placeholder="Username" id="name" required />
            <input type="text" name="email" placeholder="Email" id="email" required />
            <input type="password" name="password" placeholder="Password" id="password" required />
            <input type="submit" name="submit" value="Submit" id="submit"/>
        </form>
        <hr>
        <a href='test.php'>If you already have an account log in?</a>
    </div>
</html>
