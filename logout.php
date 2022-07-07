<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>

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
    include_once "daos/users.php";
    include_once "./daos/sessions.php";

    if (isset($_COOKIE['token'])) {
        $user = getLoggedInUser($_COOKIE['token']);
        if ($user != null) {
            deleteToken($user->id);
        }
        unset($_COOKIE['token']);
    }

    header('Location: /forum/index.php');
    exit;
    ?>
</body>