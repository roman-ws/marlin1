<?php
session_start();
require_once "config.php";


$user_name = $_POST['name'] ;
$user_email = $_POST['email'] ;
$user_password = $_POST['password'] ;
$user_confirm_password = $_POST['password_confirmation'] ;
$added_date = date("Y-m-d H:i:s");
//echo $user_name . " " . $user_email . " " . $user_password . " " . $user_confirm_password;

if($user_password === $user_confirm_password)
{
    $user_password_validated = $user_password;
}
else $user_password_validated = false;

// настроим валидацию:
// проверим на корректность записи
$user_email_validated = filter_var($user_email, FILTER_VALIDATE_EMAIL);
if($user_email_validated != false)
{
    $user_email_validated = $user_email;
}
else
{
    $_SESSION['email_is_not_validated'] = 'Введённый email некорректен!';
    header('Location: /register.php');
    exit();
}




if ($user_password === $user_confirm_password)
{

    $user_password = password_hash($user_password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name,email,password,date) VALUES (:name, :email, :password, :date)";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(":name", $user_name);
    $statement->bindParam(":email", $user_email);
    $statement->bindParam(":password", $user_password);
    $statement->bindParam(":date", $added_date);
    if($statement->execute())
    {
        echo "User already added";
    }
    //header('Location: /index.php');
}

