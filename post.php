<!DOCTYPE html>
<html lang="en">

<?php
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$postID = $_GET['id'];

include_once "./daos/posts.php";
$post = getPostByID($postID);
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post - <?php if ($post != null) {
                        echo $post->title;
                    } else {
                        echo "N/A";
                    } ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/vars.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/post.css">

    <?php

    include_once "./daos/logged_in_user.php";

    ?>
</head>

<body>

    <?php
    if ($loggedInUser === null) {
        include "./components/header.php";
    } else {
        include "./components/logged_in_header.php";
    } ?>

    <?php

    if ($post === null) {
        echo "
            <div class='container-error'>
                <div class='error-info'>
                    Kein Post mit dieser ID.
                </div>
                <a class='error-btn' href='/forum/index.php'>
                    Home
                </a>
            </div>
        ";
    } else {
        echo "<div class='container'>";

        echo "
            <div class='post-block'>
                <div class='post-title'>
                    $post->title
                </div>
                <div class='post-info'>
                    <div class='post-info-creator'>
                        Author: " . $post->user->username . "
                    </div>
                    <div class='post-info-created'>
                        $post->createdAt
                    </div>
                </div>
                <div class='post-text'>
                    $post->text
                </div>
            </div>

            <div class='spacer'></div>

            <h3 class='sub-h'>
                Kommentare ($post->commentCount)
            </h3>
        ";

        if ($loggedInUser !== null) {
            echo "
                <div class='add-comment'>
                    <form action='/forum/add_comment.php' method='POST'>
                        <input type='text' name='text' id='text'>
                        <input type='hidden' name='id' id='id' value='$postID' />
                        <button type='submit'>Kommentieren</button>
                    </form>
                </div>
            ";
        }

        include_once "./daos/comments.php";
        $comments = getCommentsByPostID($postID);

        foreach ($comments as $i => $comment) {
            echo "
                <div class='comment'>
                    <div class='comment-info'>
                        <div class='comment-author'>
                            " . $comment->user->username . "
                        </div>
                        <div class='comment-info-created'>
                            $comment->createdAt
                        </div>
                    </div>
                    <div class='comment-text'>
                        $comment->text
                    </div>
                </div>
            ";
        }

        echo "</div>";
    }

    include "./components/footer.php";
    ?>
</body>

</html>