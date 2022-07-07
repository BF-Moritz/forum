<?php

include_once "./utils/db.php";

function deleteToken(int $userID)
{
    $statement = makeDPO()->prepare("DELETE FROM forum.sessions WHERE user_id = ?;");
    $statement->execute(array($userID));
}

function generateToken(int $userID)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $token = '';
    for ($i = 0; $i < 64; $i++) {
        $token .= $characters[rand(0, $charactersLength - 1)];
    }

    $statement = makeDPO()->prepare("INSERT INTO forum.sessions (user_id, token) VALUES (?, ?);");
    $statement->execute(array($userID, $token));
    return $token;
}