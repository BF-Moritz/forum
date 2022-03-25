<?php

include_once "daos/users.php";

function validateUsername(string $username) {

    if (strlen($username) < 4) {
        return "Benutzername muss mindestens 4 Zeichen lang sein";
    }

    if (strlen($username) > 20) {
        return "Benutzername darf höchstens 20 Zeichen lang sein";
    }

    if (!preg_match_all("/^[a-zA-Z\-_0-9]+$/", $username)) {
        return "Benutzername darf nur aus Buchstaben, Zahlen, '-' und '_' bestehen.";
    }

    $isUsed = isUsernameUsed($username);
    if ($isUsed) {
        return 'Benutzername ist schon vergeben. Wollen Sie sich <a href="login.php">einloggen</a>?';
    }

    return null;
}

function validateEmail(string $email) {
    if (!preg_match_all("/^\S+@\S+\.\S+$/", $email)) {
        return "Email muss valide sein";
    }

    $isUsed = isEmailUsed($email);
    if ($isUsed) {
        return 'Email ist schon vergeben. Wollen Sie sich <a href="login.php">einloggen</a>?';
    }

    return null;
}

function validatePassword(string $password) {
    if (strlen($password) < 10) {
        return "Passwort muss mindestens 10 Zeichen lang sein";
    }

    if (strlen($password) > 128) {
        return "Passwort darf höchstens 128 Zeichen lang sein";
    }

    return null;
}