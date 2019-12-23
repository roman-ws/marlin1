<?php
require_once "config.php";

$email = $_POST['email'];
$password = $_POST['password'];



$sql = "SELECT `id`, `name`, `email`, `password` FROM users WHERE `email` = "."'".$email."'"." ORDER BY id DESC";
$statement = $pdo->prepare($sql);
$statement->execute();
$fromDb = $statement->fetchAll(PDO::FETCH_ASSOC);
$idFromDb = $fromDb[0]['id'];
$nameFromDb = $fromDb[0]['name'];
$emailFromDb = $fromDb[0]['email'];
$passwordFromDb = $fromDb[0]['password'];


if(isset($email)&&password_verify($password,$passwordFromDb))
{
    session_start();
    $_SESSION['user_id'] = $idFromDb;
    $_SESSION['user_name'] = $nameFromDb;
    $_SESSION['user_email'] = $emailFromDb;
    header('Location: /login.php');
    exit();

//    echo $password . " And ". $passwordFromDb . " are identify";
}
else
{
    session_start();
    $_SESSION['pass_is_absent'] = 'Введённый логин либо имейл не корректны!';
    header('Location: /login.php');
    exit();
}
