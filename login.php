<?php
    if(isset($_POST["submit"])) { 
        include("connexion.php");

        // Assuming you have a user authentication function
        $email = $_POST["email"];
        $password = $_POST["password"];

        $query = "SELECT * FROM users WHERE login = :email AND password = :password";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->execute();

        // Fetch the result
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a matching user is found
        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header('Location: recettes.php');
	        exit;
        } else {
            // Display an error message or redirect to login page
            echo "Invalid email or password";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <div class="logo"></div>
    <div class="login-block">
        <h1>Login</h1>
        <form name="fo" method="post" action="" enctype="multipart/form-data"> 
            <input type="text" name="email" placeholder="Email" id="email" required />
            <input type="password" name="password" placeholder="Password" id="password" required />
            <input type="submit" name="submit" value="Submit" id="submit"/>
        </form>
        <hr>
        <a href='signup.php'>If you don't have an account sign up?</a>
    </div>
</html>
