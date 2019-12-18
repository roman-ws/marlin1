<?php
session_start();
require_once "config.php";
$user_name = $_POST['name'] ;
$user_email = $_POST['email'] ;
$user_password = $_POST['password'] ;
$user_confirm_password = $_POST['password_confirmation'] ;
$added_date = date("Y-m-d H:i:s");
//echo $user_name . " " . $user_email . " " . $user_password . " " . $user_confirm_password;

// настроим валидацию:
//var_dump(!empty($db_has_email));

// проверим на корректность записи email
function emailValidate($user_email,$pdo){
    // проверим не дублируется ли email:
    $sql = "SELECT email FROM users WHERE email = '$user_email'";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $db_has_email = $statement->fetchAll(PDO::FETCH_ASSOC);
    // проверим корректность записи email:
    $user_email_validated = filter_var($user_email, FILTER_VALIDATE_EMAIL);
    if (!empty($db_has_email))
    {
        $_SESSION['email_is_not_validated'] = 'Введённый email уже существует в базе данных!';
        header('Location: /register.php');
        exit();
    }
    else if(empty($user_email))
    {
        $_SESSION['email_is_not_validated'] = 'Введите email!';
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
        return $user_email_validated;
    }
}
$isGoodeEmail = emailValidate($user_email,$pdo);
//сделаем валидацию для паролей:
function passValidate($user_password,$user_confirm_password)
{
    if ($user_password !== $user_confirm_password)
    {
        $_SESSION['pass_is_not_validated'] = 'Пароли не совпадают!';
        header('Location: /register.php');
        exit();
    }
    else if (empty($user_password))
    {
        $_SESSION['pass_is_not_validated'] = 'Пароль не должен быть пустым!';
        header('Location: /register.php');
        exit();
    }
    else if (strlen($user_password)<6)
    {
        $_SESSION['pass_is_not_validated'] = 'Введённый пароль должен быть более 6-и символов!';
        header('Location: /register.php');
        exit();
    }
    else
    {
        $user_password = password_hash($user_password, PASSWORD_DEFAULT);
        return $user_password;
    }
}
$isGoodPass = passValidate($user_password,$user_confirm_password);
$user_password = $isGoodPass;

if (isset($isGoodeEmail)&&isset($isGoodPass))
{
    $_SESSION['insert'] = "Позравляю, Вы зарегистрированы)";

    $sql = "INSERT INTO users (name,email,password,date) VALUES (:name, :email, :password, :date)";

    $statement = $pdo->prepare($sql);
    $statement->bindParam(":name", $user_name);
    $statement->bindParam(":email", $user_email);
    $statement->bindParam(":password", $user_password);
    $statement->bindParam(":date", $added_date);
    $statement->execute();

    header('Location: /register.php');
}
