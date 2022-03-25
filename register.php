<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global.css">
    <title>Register</title>
</head>

<body>
    <?php
    $username = "";
    $email = "";
    $password = "";
    $error = null;

    session_start();

    // Zuvor eingegebene Informationen und Error, die von registered.php zurückgegeben werden, auslesen

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }

    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
    }

    if (isset($_SESSION['password'])) {
        $password = $_SESSION['password'];
    }

    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
    }

    // Session zurücksetzen

    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['password']);
    unset($_SESSION['error']);
    session_destroy();

    ?>
    <div class="container-center">
        <h3>
            Register
        </h3>
        <form action="registered.php" method="POST">
            <table>
                <tr>
                    <td>
                        <label for="username">Benutzername</label>
                    </td>
                    <td>
                        <input type="text" name="username" id="username" value="<?php echo $username; ?>" required
                            minlength="4" maxlength="20">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email">E-Mail</label>
                    </td>
                    <td>
                        <input type="email" name="email" id="email" value="<?php echo $email; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password">Password</label>
                    </td>
                    <td>
                        <input type="password" name="password" id="password" value="<?php echo $password; ?>" required
                            minlength="10" maxlength="128">
                    </td>
                </tr>
            </table>
            <?php
            // todo, make include
            if ($error != null) {
                echo '<div class="error">' . $error . '</div>';
            }
            ?>

            <button type="submit">Register</button>
        </form>
        <a href="login.php">Login</a>
    </div>
    <?php include './components/footer.php';    ?>
</body>

</html>