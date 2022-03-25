<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered</title>
    <link rel="stylesheet" href="css/global.css">
</head>

<body>
    <?php

    include_once "./utils/validation.php";

    $username = "";
    $email = "";
    $password = "";

    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    }

    $error = null;
    $vUsername = validateUsername($username);
    $vEmail = validateEmail($email);
    $vPassword = validatePassword($password);

    if ($vUsername != null) {
        $error = $vUsername;
    } else if ($vEmail != null) {
        $error = $vEmail;
    } else if ($vPassword != null) {
        $error = $vPassword;
    }


    if ($error != null) {
        // destroy old session
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        session_destroy();

        // start session
        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        $_SESSION["error"] = $error;

        header('Location: register.php');
    }
    ?>

    <?php include './components/footer.php';    ?>
</body>

</html>