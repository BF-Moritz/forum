<?php

class Comment
{
    public int $id;
    public string $text;
    public string $createdAt;
    public User $user;
    function __construct(int $id, string $text, string $createdAt, User $user)
    {
        $this->id = $id;
        $this->text = strip_tags($text, '<br>');
        $this->createdAt = $createdAt;
        $this->user = $user;
    }
}

/**
 * @return Comment[]
 */
function getCommentsByPostID(int $postID)
{
    $statement = makeDPO()->prepare(
        "SELECT c.id as comment_id, 
                c.text comment_text,
                c.created_at as comment_created_at,
                u.id as user_id,
                u.username as user_username,
                u.created_at as user_created_at
           FROM forum.comments c 
           LEFT JOIN forum.users u ON c.user_id = u.id
          WHERE c.post_id = ?
          ORDER BY c.created_at DESC;"
    );
    $statement->execute(array($postID));

    $comments = [];
    while ($row = $statement->fetch()) {
        $user = new User($row['user_id'], $row['user_username'], $row['user_created_at']);
        $comment = new Comment($row['comment_id'], $row['comment_text'], $row['comment_created_at'], $user);
        array_push($comments, $comment);
    }
    return $comments;
}

function addComment(int $postID, int $userID, string $text)
{
    $statement = makeDPO()->prepare(
        "INSERT INTO forum.comments
         (post_id, user_id, text)
         VALUES
         (?, ?, ?);
        "
    );

    $statement->execute(array($postID, $userID, str_replace("\n", "<br>", $text)));
}