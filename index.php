<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/vars.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/thread.css">

    <?php include_once "./daos/logged_in_user.php"; ?>
</head>

<body>
    <?php
    if ($loggedInUser === null) {
        include "./components/header.php";
    } else {
        include "./components/logged_in_header.php";
    } ?>

    <div class="container">
        <div class="home">
            Herzlich willkommen in unserem Forum!
        </div>

        <div class="spacer"></div>
        <h3 class="sub-h">Threads</h3>

        <?php
        include_once "./daos/threads.php";
        $threads = getAllThreads();
        foreach ($threads as $i => $thread) {
            echo "
                <a href='./thread.php?id=$thread->id' class='thread'>
                    <div class='thread-title'>
                        $thread->title
                    </div>
                    <div class='thread-desc'>
                        $thread->description
                    </div>
                </a>
            ";
        }
        ?>

        <div class="spacer"></div>
        <h3 class="sub-h">Neuste Posts</h3>

        <?php
        include_once "./daos/posts.php";
        $posts = getNewestPosts(5);

        foreach ($posts as $i => $post) {
            echo "
            <a href='./post.php?id=$post->id' class='post'>
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
                <div class='post-info-text'>
                    $post->text
                </div>
                <div class='post-info-comments'>
                    $post->commentCount Comments
                </div>
            </a>
            ";
        }
        ?>
    </div>
    <?php
    include "./components/footer.php";
    ?>
</body>

</html>