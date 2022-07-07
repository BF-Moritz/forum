<?php

include_once "./utils/db.php";

class User
{
    public int $id;
    public string $username;
    public string $createdAt;

    function __construct(int $id, string $username, string $createdAt)
    {
        $this->id = $id;
        $this->username = strip_tags($username, '<br>');;
        $this->createdAt = $createdAt;
    }
}

function getUserCount()
{
    $statement = makeDPO()->prepare("SELECT count(*) as count FROM forum.users;");
    $statement->execute();
    if ($row = $statement->fetch()) {
        return $row['count'];
    }
    return 0;
}

function getNewestUser()
{
    $statement = makeDPO()->prepare("SELECT id, username, created_at FROM forum.users ORDER BY created_at DESC LIMIT 1;");
    $statement->execute();
    if ($row = $statement->fetch()) {
        return new User($row['id'], $row['username'], $row['created_at']);
    }
    return null;
}

function isEmailUsed(string $email)
{
    $statement = makeDPO()->prepare("SELECT count(*) as count FROM forum.users WHERE users.email = ?");
    $statement->execute(array($email));
    if ($row = $statement->fetch()) {
        return $row['count'] > 0;
    }
    return false;
}

function isUsernameUsed(string $username)
{
    $statement = makeDPO()->prepare("SELECT count(*) as count FROM forum.users WHERE users.username = ?");
    $statement->execute(array($username));
    if ($row = $statement->fetch()) {
        return $row['count'] > 0;
    }
    return false;
}

function getLoggedInUser(string $token)
{
    $statement = makeDPO()->prepare("SELECT u.id as id, u.username as username, u.created_at as created_at FROM forum.users u LEFT JOIN forum.sessions s ON s.user_id = u.id WHERE s.token = ?");
    $statement->execute(array($token));
    if ($row = $statement->fetch()) {
        return new User($row['id'], $row['username'], $row['created_at']);
    }
    return null;
}

function insertUser(string $username, string $email, string $password)
{
    $statement = makeDPO()->prepare("INSERT INTO forum.users (username, email, password) VALUES (?, ?, ?)");
    $statement->execute(array($username, $email, $password));
    return;
}

function getUserByUsername(string $username)
{
    $statement = makeDPO()->prepare("SELECT u.id as id, u.username as username, u.created_at as created_at FROM forum.users u WHERE u.username = ?");
    $statement->execute(array($username));
    if ($row = $statement->fetch()) {
        return new User($row['id'], $row['username'], $row['created_at']);
    }
    return null;
}

function checkPassword(string $username, string $password)
{
    $statement = makeDPO()->prepare("SELECT u.password as password FROM forum.users u WHERE u.username = ?");
    $statement->execute(array($username));
    if ($row = $statement->fetch()) {

        return $password == $row['password'];
    }
    return false;
}