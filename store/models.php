<?php
function ifGetCookies ($pdo,$cookie_email,$cookie_pass)
{

    $sql = "SELECT `id`, `name`, `email` FROM users WHERE `email` = "."'".$cookie_email."'"." AND `password` = "."'".$cookie_pass."'"." ORDER BY id DESC";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $fromDb = $statement->fetchAll(PDO::FETCH_ASSOC);
    $user_id = $fromDb[0]['id'];
    $user_name = $fromDb[0]['name'];
    $user_email = $fromDb[0]['email'];
    if(!empty($user_name&&$user_email)){
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_email'] = $user_email;
    }
}
