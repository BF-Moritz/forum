<?php

class Friend
{
    public bool $isAccepted;
    public User $user;

    function __construct(int $isAccepted, User $user)
    {
        $this->isAccepted = $isAccepted;
        $this->user = $user;
    }
}

/**
 * @return Friend[]
 */
function getFriends(int $id)
{
    $statement = makeDPO()->prepare(
        "SELECT f.is_accepted, u.id, u.username, u.created_at  FROM forum.friends f
    LEFT JOIN forum.users u ON f.user_one_id = u.id
    WHERE f.user_two_id = ?
    
    UNION ALL
    
    SELECT f.is_accepted, u.id, u.username, u.created_at  FROM forum.friends f
    LEFT JOIN forum.users u ON f.user_two_id = u.id
    WHERE f.user_one_id = ?;"
    );

    $statement->execute(array($id, $id));

    $frineds = [];

    while ($row = $statement->fetch()) {
        $user = new User($row['id'], $row['username'], $row['created_at']);
        $friend = new Friend($row['is_accepted'], $user);
        array_push($frineds, $friend);
    }

    return $frineds;
}