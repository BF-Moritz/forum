<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/vars.css">
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
    $vUsername = validateUsername($username, true);
    $vEmail = validateEmail($email);
    $vPassword = validatePassword($password);

    if ($vUsername != null) {
        $error = $vUsername;
    } else if ($vEmail != null) {
        $error = $vEmail;
    } else if ($vPassword != null) {
        $error = $vPassword;
    }

    unset($_SESSION['email']);
    unset($_SESSION['password']);
    unset($_SESSION['error']);

    if ($error != null) {
        // destroy old session
        unset($_SESSION['username']);
        session_destroy();

        // start session
        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        $_SESSION["error"] = $error;

        header('Location: register.php');
        exit;
    }
    insertUser($username, $email, $password);
    header('Location: login.php');
    exit;
    ?>

    <?php include './components/footer.php';    ?>
</body>

</html>