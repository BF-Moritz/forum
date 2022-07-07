<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/vars.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <?php
    $username = "";
    $password = "";
    $error = null;

    session_start();

    // Zuvor eingegebene Informationen und Error, die von registered.php zurückgegeben werden, auslesen
    if (isset($_SESSION['username'])) $username = $_SESSION['username'];
    if (isset($_SESSION['error'])) $error = $_SESSION['error'];

    // Session zurücksetzen
    unset($_SESSION['username']);
    unset($_SESSION['error']);
    session_destroy();
    ?>
    <div class="container-center">
        <h3 class="center-h">
            Login
        </h3>
        <form action="/forum/logged_in.php" method="POST">
            <div class="form-group">
                <label for="username">Benutzername</label>
                <input type="text" name="username" id="username" value="<?php echo $username; ?>" required minlength="4"
                    maxlength="20">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" value="<?php echo $password; ?>" required
                    minlength="10" maxlength="128">
            </div>
            <?php
            if ($error != null) {
                echo "
                    <div class='form-error'>
                        <div class='error-info'>
                            $error
                        </div>
                    </div>
                ";
            }
            ?>
            <div class="form-actions">
                <button class="form-btn form-btn-active" type="submit">Login</button>
                <a class="form-btn" href="/forum/register.php">Register</a>
            </div>
        </form>
    </div>

    <?php include './components/footer.php'; ?>
</body>