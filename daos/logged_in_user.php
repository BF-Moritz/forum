<?php
include_once "./daos/users.php";

$loggedInUser =  null;

if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];

    $loggedInUser = getLoggedInUser($token);

    if ($loggedInUser == null) {
        unset($_COOKIE['token']);
    }
}
