<?php
include_once "./daos/logged_in_user.php";

if ($loggedInUser === null) {
    header('Location: /forum/index.php');
    exit;
}


if (!isset($_POST['id'])) {
    header('Location: /forum/index.php');
    exit;
}

$id = $_POST['id'];

if (!isset($_POST['title']) || !isset($_POST['text'])) {
    header('Location: /forum/thread.php?id=' . $id);
    exit;
}

$title = $_POST['title'];
$text = $_POST['text'];


include_once "./daos/posts.php";

$newPostID = addPost($id, $loggedInUser->id, $title, $text);

header('Location: /forum/post.php?id=' . $newPostID);
exit;