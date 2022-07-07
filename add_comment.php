<?php
include_once "./daos/logged_in_user.php";

if ($loggedInUser === null) {
    header('Location: /forum/index.php');
    exit;
}


if (!isset($_POST['id']) || !isset($_POST['text'])) {
    header('Location: /forum/index.php');
    exit;
}

$id = $_POST['id'];
$text = $_POST['text'];


include_once "./daos/comments.php";

addComment($id, $loggedInUser->id, $text);

header('Location: /forum/post.php?id=' . $id);
exit;