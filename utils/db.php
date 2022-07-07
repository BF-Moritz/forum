<?php
// global $pdo;
$pdo = new PDO("mysql:host=localhost;dbname=forum;port=3306", "root");
function makeDPO()
{
    global $pdo;
    return $pdo;
}
