<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freunde</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/vars.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/friends.css">

    <?php

    include_once "./daos/logged_in_user.php";

    ?>
</head>

<body>

    <?php
    if ($loggedInUser === null) {
        header('Location: /forum/index.php');
        exit;
    } else {
        include "./components/logged_in_header.php";
    } ?>

    <?php

    include_once "./daos/friends.php";

    $friends = getFriends($loggedInUser->id);

    echo "
        <div class='container'>
        
        <h3 class='sub-h'>
            Freunde
        </h3>
    ";

    foreach ($friends as $i => $friend) {
        $classes = "friend";
        if ($friend->isAccepted) {
            $classes = "$classes friend-accepted";
        }
        echo "
                <div class='$classes'>
                    " . $friend->user->username . "
                </div>
            ";
    }

    echo '</div>';


    include "./components/footer.php";
    ?>
</body>

</html>