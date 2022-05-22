<?php
require_once("./includes/config.php");
require_once("./includes/classes/FormSanitizer.php");

    if(isset($_POST["submitButton"])) {
        $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
        $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
        $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
        $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
        $email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
        $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);
        
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Style -->
    <link rel="stylesheet" type="text/css" href="./assets/style/style.css">
    <title>Register Page</title>
</head>
<body>

    <div class="signInContainer">
        <div class="column">
            <div class="header">
                <img src="./assets/images/logo.png" title="Logo" alt="Site logo">
                <h3>Sign Up</h3>
                <span>to continue to Reeceflix</span>
            </div>
            <form method="POST">
                <input type="text" name="firstName" placeholder="First name" >
                <input type="text" name="lastName" placeholder="Last name" >
                <input type="text" name="username" placeholder="Username" >
                <input type="email" name="email" placeholder="Email" >
                <input type="email" name="email2" placeholder="Confirm email" >
                <input type="password" name="password" placeholder="Password" >
                <input type="password" name="password2" placeholder="Confirm Password" >
                <input type="submit" name="submitButton" placeholder="Submit">
            </form>
            <a href="login.php" class="signInMessage">Already have an account? Sign in here!</a>
        </div>
    </div>

</body>
</html>