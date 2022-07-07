<?php
include_once "./daos/users.php";

class Thread
{
    public int $id;
    public string $title;
    public string $description;

    function __construct(int $id, string $title, string $description)
    {
        $this->id = $id;
        $this->title = strip_tags($title, '<br>');
        $this->description = $description;
    }
}

/**
 * @return Thread[]
 */
function getAllThreads()
{
    $statement = makeDPO()->prepare("SELECT t.id as thread_id, t.title, t.description FROM forum.threads t ORDER BY t.id ASC;");
    $statement->execute();

    $threads = [];
    while ($row = $statement->fetch()) {
        $thread = new Thread($row['thread_id'], $row['title'], $row['description']);
        array_push($threads, $thread);
    }
    return $threads;
}

function getThreadByID(int $id)
{
    $statement = makeDPO()->prepare("SELECT t.id as thread_id, t.title, t.description FROM forum.threads t WHERE t.id = ?;");
    $statement->execute(array($id));

    while ($row = $statement->fetch()) {
        return new Thread($row['thread_id'], $row['title'], $row['description']);
    }
    return null;
}