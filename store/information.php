<?php

require_once "config.php";

function getComments($pdo)
{
    $sql = "SELECT * FROM  comments ORDER BY id DESC";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $comments;
}

