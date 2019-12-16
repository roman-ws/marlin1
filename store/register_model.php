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
// проверим не дублируется ли email:
    $sql = "SELECT email FROM users WHERE email = '$user_email'";
 //var_dump($sql);
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $db_has_email = $statement->fetchAll(PDO::FETCH_ASSOC);
 //var_dump(!empty($db_has_email));

// проверим на корректность записи email
$user_email_validated = filter_var($user_email, FILTER_VALIDATE_EMAIL);
//var_dump($user_email_validated);


if (!empty($db_has_email))
{
    $_SESSION['email_is_not_validated'] = 'Введённый email уже существует в базе данных!';
    header('Location: /register.php');
    exit();
}
else if($user_email_validated == false)
{
    $_SESSION['email_is_not_validated'] = 'Введённый email некорректен!';
    header('Location: /register.php');
    exit();
}
else
{
    $user_email_validated = $user_email;
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

