<?php
session_start();
require_once "config.php";

$email = $_POST['email'];
$password = $_POST['password'];

//проверим на корректность записи email
function emailValidate($email,$password){
    // проверим корректность записи email:
    $user_email_validated = filter_var($email, FILTER_VALIDATE_EMAIL);

    if(empty($email))
    {
        $_SESSION['email_not_good'] = 'Введите email!';
        header('Location: /login.php');
        exit();
    }
    else if($user_email_validated == false)
    {
        $_SESSION['email_or_pass_not_good'] = 'Введённый email некорректен!';
        header('Location: /login.php');
        exit();
    }
    else if(empty($password))
    {
        $_SESSION['pass_not_good'] = 'Пароль не должен быть пустым!';
        header('Location: /login.php');
        exit();
    }
    else
    {
        $user_email_validated = $email;
        return $user_email_validated;
    }
}
$isGoodEmail = emailValidate($email,$password);

$sql = "SELECT `id`, `name`, `email`, `password` FROM users WHERE `email` = "."'".$email."'"." ORDER BY id DESC";
$statement = $pdo->prepare($sql);
$statement->execute();
$fromDb = $statement->fetchAll(PDO::FETCH_ASSOC);
$idFromDb = $fromDb[0]['id'];
$nameFromDb = $fromDb[0]['name'];
$emailFromDb = $fromDb[0]['email'];
$passwordFromDb = $fromDb[0]['password'];

$isGoodPass = password_verify($password,$passwordFromDb);

if(isset($isGoodEmail)&&!empty($isGoodPass))
{
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
    $_SESSION['email_or_pass_is_absent'] = 'Введённый имейл/пароль не существует!';
    header('Location: /login.php');
    exit();
}
