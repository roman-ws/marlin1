<?php
require_once "config.php";
session_start();

$user_name = $_SESSION['user_name'];
$comment = $_POST['text'];
$img_src = 'img/no-user.jpg';

//echo $user_name;

//switch (empty($post_var))
//{
//    case empty($user_name)&&empty($comment):
//         $_SESSION['empty_name'] = 'Введите имя!';
//         $_SESSION['empty_text'] = 'Введите сообщение!';
//         header('Location: /index.php');
//        break;
//    case empty ($user_name):
//         $_SESSION['empty_name'] = 'Введите имя!';
//         header('Location: /index.php');
//        break;
//    case empty($comment):
//        $_SESSION['empty_text'] = 'Введите сообщение!';
//        header('Location: /index.php');
//        break;
//    default:
//        $sql = "INSERT INTO comments (user_name,text,img_src) VALUES (:user_name, :comment, :img_src)";
//        $statement = $pdo->prepare($sql);
//        $statement->bindParam(":user_name", $user_name);
//        $statement->bindParam(":comment", $comment);
//        $statement->bindParam(":img_src", $img_src);
//        if($statement->execute())
//        {
//            $_SESSION['message'] = 'Комментарий успешно добавлен';
//        }
//        header('Location: /index.php');
//
//}


// настроим валидацию
if (empty($comment))
{
    $_SESSION['empty_text'] = 'Введите сообщение!';
    header('Location: /index.php');
    exit();
}
else if(empty($comment))
{
    $_SESSION['empty_text'] = 'Введите сообщение!';
    header('Location: /index.php');
    exit();
}
else
{
    $sql = "INSERT INTO comments (user_name,text,img_src) VALUES (:user_name, :comment, :img_src)";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(":user_name", $user_name);
    $statement->bindParam(":comment", $comment);
    $statement->bindParam(":img_src", $img_src);
    if($statement->execute())
    {
        $_SESSION['message'] = 'Комментарий успешно добавлен';
        $_SESSION['user_name'] = $user_name;

    }
    header('Location: /index.php');
}




