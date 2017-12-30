<?php // Do not put any HTML above this line
session_start();

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = 'a8609e8d62c043243c4e201cbb342862';  // Pw is meow123 or php123
$secret = 'php123';

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {

    unset($_SESSION["email"]);  // Logout current user

    // check if email and pw are entered
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {

        $_SESSION["error"] = "Email and password are required";
        header( 'Location: login.php' ) ;
        return;

    // check if email is valid email
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

        $_SESSION["error"] = "Email must have an at-sign (@)";
        header( 'Location: login.php' ) ;
        return;

    } else {

        //$check = hash('md5', $salt.$_POST['pass']);
        $password = $_POST['pass'];
        if ( $secret == $password ) {
            // Redirect the browser to game.php
            error_log("Login success ".$_POST['email']);
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["success"] = "Logged In";
            header( 'Location: view.php' ) ;
            return;

        } else {
            error_log("Login fail ".$_POST['email']);
            $_SESSION["error"] = "Incorrect Password";
            header( 'Location: login.php' ) ;
            return;
        }
    }
} // end if ( isset($_POST['email']) && isset($_POST['pass']) )

// Fall through into the View
?>
<!DOCTYPE html>
<html>

<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Broker Stir | Autos Database</title>
</head>

<body>
    <div class="container">
        <h1>Please Log In</h1>
<?php

if ( isset($_SESSION["error"]) ) {
      echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
      unset($_SESSION["error"]);
  }
?>

<!-- login Form -->
<form method="POST">

    User Name <input type="text" name="email"><br/>
    Password <input type="text" name="pass"><br/>

    <input type="submit" value="Log In">
    <input type="submit" name="cancel" value="Cancel">

</form>

    </div>
</body>

</html>
