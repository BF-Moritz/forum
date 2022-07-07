<!DOCTYPE html>
<html lang="en">

<?php
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$threadID = $_GET['id'];
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neuer Post</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/vars.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/form.css">

    <?php

    include_once "./daos/logged_in_user.php";

    if ($loggedInUser === null) {
        header("Location: /forum/thread.php?id=$threadID");
        exit;
    }

    ?>
</head>

<body>
    <?php include "./components/logged_in_header.php"; ?>

    <div class="container-center">
        <h3 class="center-h">
            Neuer Post
        </h3>
        <form class="add-post form-full-width" action="/forum/add_post.php" method="POST">
            <input type="text" name="title" id="title" required maxlength="128">
            <textarea name="text" id="text" required maxlength="1024" rows=5></textarea>
            <input type="hidden" name="id" id="id" value="<?php echo $threadID; ?>" />
            <div class="form-actions">
                <button class="form-btn form-btn-active" type="submit">Post</button>
            </div>
        </form>
    </div>

    <?php include './components/footer.php'; ?>
</body>