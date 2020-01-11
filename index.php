<?php
session_start();
require_once "store/information.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comments</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
</head>
<body>

<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                Project
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <?php if(empty($_SESSION['user_id']))
                    {?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php } else {?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php"><?php echo $_SESSION['user_name']; ?></a>
                        </li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><h3>Комментарии</h3></div>
                        <div class="card-body">

                            <?php if($_SESSION['message'])
                            { ?>
                            <div class="alert alert-success" role="alert">
                                <!-- добавление комментария-->
                                <?php echo $_SESSION['message'];
                                $_SESSION['message'] = '';?>
                                <?php
                                //session_destroy();
                                }  ?>
                            </div>

                        </div>
                        <?php
                        // создаём массив, присваиваем текст, выводим в р
                        //                                    $users = ["John Doe" => ["date" => "12/10/2014",
                        //                                                             "text" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe aspernatur, ullam doloremque deleniti, sequi obcaecati."
                        //                                                            ],
                        //                                              "Roman" =>     ["date" => "22/10/2015",
                        //                                                             "text" => "Всякая всячина."
                        //                                                             ],
                        //                                              "Ura" =>     ["date" => "01/10/2016",
                        //                                                             "text" => "Somrthing interesting."
                        //                                                            ],
                        //                                            ];
                        //                                    $users =
                        //                                        [ ["user_name" => "John Doe",
                        //                                           "date" => "12/10/2014",
                        //                                           "text" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe aspernatur, ullam doloremque deleniti, sequi obcaecati.",
                        //                                           "img_src" => "img/no-user.jpg"
                        //
                        //                                          ],
                        //                                          ["user_name" => "Roman",
                        //                                          "date" => "01/10/2016",
                        //                                          "text" => "Всякая всячина",
                        //                                          "img_src" => "img/halc.jpg"
                        //                                          ],
                        //                                          ["user_name" => "Ura",
                        //                                           "date" => "22/10/2015",
                        //                                           "text" => "Somrthing interesting.",
                        //                                           "img_src" => "img/bara.jpg"
                        //                                           ],
                        //                                         ];
                        //выведем все комментарии
                        $comments = getComments($pdo);
                        foreach ($comments as $comment){
                            //переведём в формат timestamp и преобразуем в нужный формат;
                            $unixtime = strtotime($comment['date']);
                            $date = date("d/m/Y",$unixtime);
                            ?>

                            <div class="media">
                                <img src= <?php echo $comment['img_src']; ?> class="mr-3" alt="users photo" width="64" height="64">
                                <div class="media-body">
                                    <h5 class="mt-0"><?php echo $comment['user_name']; ?></h5>
                                    <span><small><?php echo $date; ?></small></span>
                                    <p>
                                        <?php echo $comment['text']; ?>
                                    </p>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
                <div class="card">
                    <div class="card-header"><h3>Оставить комментарий</h3></div>

                    <div class="card-body">
                        <form action="store/comments.php" method="post">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Сообщение</label>
                                <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>

                                <?php if($_SESSION['empty_text'])
                                { ?>
                                <div class="alert alert-warning" role="alert">
                                    <!-- предупреждение об пустом значении name-->
                                    <p style="color: red">
                                        <?php echo $_SESSION['empty_text'];?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                            if (isset($_SESSION['empty_text']))
                            {
                                session_destroy();
                            }
                            ?>
                            <button type="submit" class="btn btn-success">Отправить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
</main>
</div>
</body>
</html>
