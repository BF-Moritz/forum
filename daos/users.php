<?php

class User {
    public $username;

    function __construct(string $username) {
        $this->username = $username;
    }
}

function getUserCount() {
    return 3;
}

function getNewestUser() {
    return new User("test");
}

function isEmailUsed(string $email) {
    return $email == "test@test.de";
}

function isUsernameUsed(string $username) {
    return $username == "test";
}