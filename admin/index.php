<?php

/* 
 * Панель управления
 */
error_reporting( E_ERROR ); // отключаем вывод ошибок и нотайсов
/* 
 * подключаем конфиг и контроллеры
 */
require "../config/config.php";
require "../controllers/db.php";
require "../controllers/admin.php";
require "../controllers/templates.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title><?php echo "$admin[name]";?> | <?php echo "$admin[title]";?></title>
        
        <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
	
	<!-- Favicons -->	
	<link rel="shortcut icon" href="<?php echo "$path[home]$path[admin_tpl]";?>/favicon.ico" type="image/x-icon">	<!--IE browser-->
	<link rel="icon" href="<?php echo "$path[home]$path[admin_tpl]";?>/favicon.ico" type="image/x-icon">		<!--normal browsers-->
	
	<!-- Styles -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Condensed&amp;subset=cyrillic,cyrillic-ext">
	<link rel="stylesheet" href="<?php echo "$path[home]$path[admin_tpl]";?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo "$path[home]$path[admin_tpl]";?>/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo "$path[home]$path[admin_tpl]";?>/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo "$path[home]$path[admin_tpl]";?>/css/style.css" />  <!-- файл стиле админ-панели -->
    </head>
    <body>
        <div id="wrapper" class="container-fluid">
            
            <?php
            // put your code here
                db_connect($db['host'], $db['user'], $db['pass'], $db['db']);
                
                // создаем сессию, проверяем, записан ли логин в сессию. Если да - сохраняем логин из сессии в переменную $login, если нет - выход из кабинета
                session_start();
                if (!empty($_SESSION['login']))	
                {
                    $login = $_SESSION['login'];
                }
            else
                {
                    // если логин не сохранен в сессии - показываем сообщение и выходим из кабинета
                    echo '<script>window.alert("Вход не выполнен! Войдите в кабинет под своим логином и паролем!");</script>';
                    echo '<script>location.replace("'."http://localhost/"."$path[home]".'");</script>';
                }
            
            ?>
            
            <header id="hat" class="row">
                <div class="col-sm-8 col-md-9 col-lg-9">
                    <h1><i class="fa fa-pagelines" aria-hidden="true"></i> <?php echo "$admin[name]";?> | <?php echo "$admin[title]";?></h1>
                </div>
                <div class="col-sm-4 col-md-3 col-lg-3">
                    <ul id="user_login"> 
                        <li><i class="fa fa-user-circle fa-2x" aria-hidden="true"></i></li>
                        <li> <a href="<?php echo "$path[home]$path[admin]?r=profile";?>">  <?php db_select_user_login($login); ?></a></li>
                        <li>  /  </li>
                        <li>
                            <form action="" method="POST">
                                <button type="submit" id="logout" name="logout" class="btn btn-link">выйти</button>
                            </form>
                        </li>
                    </ul>
                    <?php
                        // выход из профиля и личного кабинета
                        if( isset( $_POST['logout'] ) )	// если кнопка нажата, то:
                            {
                                session_destroy();	//удаляем все сессии чтобы разлогиниться
                                echo '<script>location.replace("'."http://localhost/"."$path[home]".'");</script>';  // выходим из кабинета
                            }
                    ?>
                </div>
            </header>
            <div class="row">
                <aside class="col-xs-12 col-sm-4 col-lg-2">
                    <h2>Меню:</h2>                 
                    <nav id="admin-menu">
                        <ul>
                            <li><i class="fa fa-users" aria-hidden="true"></i> <a href="<?php echo "$path[home]$path[admin]?r=users";?>"> <?php echo "$admin_menu[users]";?></a></li>
                            <li><i class="fa fa-file-o" aria-hidden="true"></i> <a href="<?php echo "$path[home]$path[admin]?r=create";?>"> <?php echo "$admin_menu[create]";?></a></li>
                            <li><i class="fa fa-search" aria-hidden="true"></i> <a href="<?php echo "$path[home]$path[admin]?r=templates";?>"> <?php echo "$admin_menu[templates]";?></a></li>
                            <li><i class="fa fa-user-o" aria-hidden="true"></i> <a href="<?php echo "$path[home]$path[admin]?r=profile";?>"> <?php echo "$admin_menu[profile]";?></a></li>
                            <!--<li><i class="fa fa-commenting-o" aria-hidden="true"></i> <a href="<?php echo "$path[home]$path[admin]?r=support";?>"> <?php echo "$admin_menu[support]";?></a></li>-->
                        </ul>
                    </nav>
                </aside>
                <section id="workarea" class="col-xs-12 col-sm-8 col-lg-10">
                    <?php 
                        
                        admin_content(); // вывод контента
                    ?>
                </section>
            </div>
            
            <footer>
                <p id="copyright"><i class="fa fa-pagelines" aria-hidden="true"></i> <?php echo "$admin[name]";?> | <?php echo "$admin[title]";?> © <?php echo date('Y'); ?> Все права защищены</p>
            </footer>
            
        </div>
    <!-- JS scripts -->
            <script src="<?php echo "$path[home]$path[admin_tpl]";?>/js/jquery-3.3.1.min.js"></script>		
            <script src="<?php echo "$path[home]$path[admin_tpl]";?>/js/bootstrap.min.js"></script>
            <script src="<?php echo "$path[home]$path[admin_tpl]";?>/js/scripts.js"></script>
            <div id="toTop"><span class="glyphicon glyphicon-chevron-up"></span></div>
    </body>
</html>
