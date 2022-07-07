<?php

include_once './daos/users.php';

class Post
{
    public int $id;
    public string $title;
    public string $text;
    public string $createdAt;
    public int $commentCount;
    public User $user;

    function __construct(int $id, string $title, string $text, string $createdAt, int $commentCount, User $user)
    {
        $this->id = $id;
        $this->title = strip_tags($title, '<br>');
        $this->text = strip_tags($text, '<br>');
        $this->createdAt = $createdAt;
        $this->commentCount = $commentCount;
        $this->user = $user;
    }
}

/**
 * @return Post[]
 */
function getAllPostsByThreadID(int $threadID)
{
    $statement = makeDPO()->prepare(
        "SELECT p.id as post_id, 
                p.title as post_title, 
                p.text as post_text,
                p.created_at as post_created_at, 
                count(c.id) as comment_count,
                u.id as user_id,
                u.username as user_username,
                u.created_at as user_created_at
           FROM forum.posts p 
           LEFT JOIN forum.comments c ON c.post_id = p.id
           LEFT JOIN forum.users u ON p.user_id = u.id
          WHERE p.thread_id = ?
          GROUP BY p.id
          ORDER BY post_created_at DESC
          ;"
    );
    $statement->execute(array($threadID));

    $posts = [];
    while ($row = $statement->fetch()) {
        $user = new User($row['user_id'], $row['user_username'], $row['user_created_at']);
        $post = new Post($row['post_id'], $row['post_title'], $row['post_text'], $row['post_created_at'], $row['comment_count'], $user);
        array_push($posts, $post);
    }
    return $posts;
}

/**
 * @return Post
 */
function getPostByID(int $postID)
{
    $statement = makeDPO()->prepare(
        "SELECT p.id as post_id, 
                p.title as post_title, 
                p.text as post_text,
                p.created_at as post_created_at, 
                count(c.id) as comment_count,
                u.id as user_id,
                u.username as user_username,
                u.created_at as user_created_at
           FROM forum.posts p 
           LEFT JOIN forum.comments c ON c.post_id = p.id
           LEFT JOIN forum.users u ON p.user_id = u.id
          WHERE p.id = ?
          GROUP BY p.id
          ORDER BY post_created_at DESC 
          ;"
    );

    $statement->execute(array($postID));

    while ($row = $statement->fetch()) {
        $user = new User($row['user_id'], $row['user_username'], $row['user_created_at']);
        return new Post($row['post_id'], $row['post_title'], $row['post_text'], $row['post_created_at'], $row['comment_count'], $user);
    }
    return null;
}

/**
 * @return Post[]
 */
function getNewestPosts(int $numberOfPosts)
{
    $statement = makeDPO()->prepare(
        "SELECT p.id as post_id, 
                p.title as post_title, 
                p.text as post_text, 
                p.created_at as post_created_at, 
                count(c.id) as comment_count,
                u.id as user_id,
                u.username as user_username,
                u.created_at as user_created_at
           FROM forum.posts p 
           LEFT JOIN forum.comments c ON c.post_id = p.id
           LEFT JOIN forum.users u ON p.user_id = u.id
          GROUP BY p.id
          ORDER BY p.created_at DESC
          LIMIT $numberOfPosts;"
    );
    $statement->execute();

    $posts = [];
    while ($row = $statement->fetch()) {
        $user = new User($row['user_id'], $row['user_username'], $row['user_created_at']);
        $post = new Post($row['post_id'], $row['post_title'], $row['post_text'], $row['post_created_at'], $row['comment_count'], $user);
        array_push($posts, $post);
    }
    return $posts;
}

function addPost(int $threadID, int $userID, string $title, string $text)
{
    $statement = makeDPO()->prepare(
        "INSERT INTO forum.posts
         (thread_id, user_id, title, text)
         VALUES
         (?, ?, ?, ?);
        "
    );

    $statement->execute(array($threadID, $userID, $title, str_replace("\n", "<br>", $text)));
    return makeDPO()->lastInsertId();
}