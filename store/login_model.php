<?php
require_once "config.php";

$email = $_POST['email'];
$password = $_POST['password'];



$sql = "SELECT `email`, `password` FROM users WHERE `email` = "."'".$email."'"." ORDER BY id DESC";
$statement = $pdo->prepare($sql);
$statement->execute();
$emailPasswordArr = $statement->fetchAll(PDO::FETCH_ASSOC);
$emailFromDb = $emailPasswordArr[0]['email'];
$passwordFromDb = $emailPasswordArr[0]['password'];
