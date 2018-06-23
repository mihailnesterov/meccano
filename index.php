<?php

/* 
 * Главная страница
 */

/* 
 * подключение файлов настроек 
 */
require "config/config.php";
require "controllers/db.php";
require "controllers/auth.php";
require "controllers/reg.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title><?php echo "$frontend[name]";?> | <?php echo "$frontend[title]";?></title>
        
        <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
	
	<!-- Favicons -->	
	<link rel="shortcut icon" href="<?php echo "$path[home]$path[frontend_tpl]";?>/favicon.ico" type="image/x-icon">	<!--IE browser-->
	<link rel="icon" href="<?php echo "$path[home]$path[frontend_tpl]";?>/favicon.ico" type="image/x-icon">		<!--normal browsers-->
	
	<!-- Styles -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Condensed&amp;subset=cyrillic,cyrillic-ext">
	<link rel="stylesheet" href="<?php echo "$path[home]$path[frontend_tpl]";?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo "$path[home]$path[frontend_tpl]";?>/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo "$path[home]$path[frontend_tpl]";?>/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo "$path[home]$path[frontend_tpl]";?>/css/animate.css" />
	<link rel="stylesheet" href="<?php echo "$path[home]$path[frontend_tpl]";?>/css/style.css" />
        
    </head>
    <body>
        <div id="wrapper" class="container-fluid">
            <?php
            // put your code here
            
            db_connect($db['host'], $db['user'], $db['pass'], $db['db']);
            
            // обработка формы авторизации
            if(isset($_POST['auth']))
                {
                    $auth_func = $_POST['auth'];

                        // проверяем, существует ли функция authorization()
                    if (function_exists($auth_func))
                        {
                            authorization("http://localhost/"."$path[home]"."admin/?r=users", "http://localhost/"."$path[home]"."cabinet/?r=pages");
                        }
                    else
                        {
                            //Если authorization() не найдена, то:
                            echo 'Ошибка! Функция authorization() не найдена! Проверьте подключение к controllers/auth.php';
                        }
                }
                
            // обработка формы регистрации
            if(isset($_POST['reg']))
                {
                    $reg_func = $_POST['reg'];

                        // проверяем, существует ли функция registration()
                    if (function_exists($reg_func))
                        {
                            //session_start();      //удалить!!! не используется
                            //$_SESSION['lp_path'] = "./"."$path[home]$path[lp]";  // сохраняем в сессии путь к каталогу страниц
                            
                            registration("http://localhost"."$path[home]"."cabinet/?r=create");
                        }
                    else
                        {
                            //Если registration() не найдена, то:
                            echo 'Ошибка! Функция registration() не найдена! Проверьте подключение к controllers/reg.php';
                        }
                }
            ?>
            
            <header id="hat" class="row">
                <div id="logo" class="col-md-8 col-sm-9 col-lg-9">
                    <p><i class="fa fa-pagelines" aria-hidden="true"></i> <?php echo "$frontend[name]";?> | <?php echo "$frontend[title]";?></p>
                </div>
                <div class="col-md-4 col-sm-3 col-lg-3">
                    <ul id="user_login">
                        <li><i class="fa fa-sign-in" aria-hidden="true"></i> <a href="#" data-toggle="modal" data-target="#ModalAuthWindow">  Вход</a></li>
                        <li>  /  </li>
                        <li><i class="fa fa-user" aria-hidden="true"></i> <a href="#" id="logout" data-toggle="modal" data-target="#ModalRegWindow">Регистрация</a></li>
                    </ul>
                </div>
            </header>
            <section id="first-screen">
                <div id="bg">
                    <h1>Удобный сервис для быстрого запуска посадочных страниц</h1>
                    <h2>Создайте лэндинг на основе шаблона всего за несколько минут</h2>
                    <button class="btn btn-warning btn-lg" data-toggle="modal" data-target="#ModalRegWindow">Создать лэндинг</button>
                </div>
            </section>
            
            <div class="container">
                <div id="features" class="row">
                    <h2>Преимущества нашего сервиса</h2>
                    <section class="col-sm-4">
                        <div class="item">
                            <h3>Просто</h3>
                            <i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>
                            <p>Вам не нужно разбираться в разработке сайтов</p>
                        </div>
                    </section>
                    <section class="col-sm-4">
                        <div class="item">
                            <h3>Быстро</h3>
                            <i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>
                            <p>Создание и запуск лэндинга за несколько минут</p>
                        </div>
                    </section>
                    <section class="col-sm-4">
                        <div class="item">
                            <h3>Бесплатно</h3>
                            <i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>
                            <p>Любое количество лэндингов и бесплатные шаблоны</p>
                        </div>
                    </section>
                </div>
            </div>
            
            <section class="container">
                <div id="create-lp" >
                    <h2>Создайте свой первый лэндинг</h2>
                    <button class="btn btn-warning btn-lg" data-toggle="modal" data-target="#ModalRegWindow">Создать лэндинг</button>
                </div>
            </section>
            
            <footer>
                <p id="copyright"><i class="fa fa-pagelines" aria-hidden="true"></i> <?php echo "$frontend[name]";?> | <?php echo "$frontend[title]";?> © <?php echo date('Y'); ?> Все права защищены</p>
            </footer>
            
        </div>
        
        <!-- Модальное окно регистрации -->
        <div class="modal fade" id="ModalRegWindow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="ModalLabelReg">Зарегистрируйтесь, чтобы создать лэндинг</h4>
		</div>
		<div class="modal-body">
                    <!-- Форма регистрации -->
                    <form action="" method="POST" name="RegForm" class="form form-register" id="RegForm">
                        <fieldset>
                            <input type="hidden" name="reg" value="registration" />   <!-- скрытое поле, тспользуется в controllers/reg.php для вызова функции registration() -->
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="sr-only" for="your-login-reg">Логин</label>
                                    <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>
                                    <input type="text" class="form-control input-lg" placeholder="Логин *" id="your-login-reg" name="your-login-reg" required="required" pattern="[A-Za-z0-9]{3,}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="sr-only" for="your-password-reg">Пароль</label>
                                    <div class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></div>
                                    <input type="password" class="form-control input-lg" placeholder="Пароль *" id="your-password-reg" name="your-password-reg" required="required" pattern="[A-Za-z0-9]{5,}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="sr-only" for="your-password-confirm">Подтверждение пароля</label>
                                    <div class="input-group-addon"><i class="fa fa-check" aria-hidden="true"></i></div>
                                    <input type="password" class="form-control input-lg" placeholder="Подтвердите пароль *" id="your-password-confirm" name="your-password-confirm" required="required" pattern="[A-Za-z0-9]{5,}"/>
                                </div>
                            </div>
                        </fieldset>

                       <div class="modal-footer">
                            <div id="success"> </div> <!-- For success/fail messages -->

                        <button type="submit" class="btn btn-lg btn-warning btn-3d">Зарегистрироваться</button><br />
                        </div>
                    </form>
                        </div>
            </div>      <!-- /.modal-content -->
          </div>    <!-- /.modal-dialog -->
        </div>  <!-- /.modal -->
        
        <!-- Модальное окно авторизации -->
        <div class="modal fade" id="ModalAuthWindow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="ModalLabelAuth">Войти в личный кабинет</h4>
		</div>
		<div class="modal-body">
                    <!-- Форма авторизации -->
                    <form action="" method="POST" name="AuthForm" class="form form-register" id="AuthForm"> 
                        <fieldset>
                            <input type="hidden" name="auth" value="authorization" />   <!-- скрытое поле, тспользуется в controllers/auth.php для вызова функции authorization() -->
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="sr-only" for="your-login-auth">Логин</label>
                                    <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>
                                    <input type="text" class="form-control input-lg" placeholder="Логин *" id="your-login-auth" name="your-login-auth" required="required"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="sr-only" for="your-password-auth">Пароль</label>
                                    <div class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></div>
                                    <input type="password" class="form-control input-lg" placeholder="Пароль *" id="your-password-auth" name="your-password-auth" required="required"/>
                                </div>
                            </div>
                        </fieldset>

                       <div class="modal-footer">
                            <div id="success"> </div> <!-- For success/fail messages -->

                        <button type="submit" class="btn btn-lg btn-warning btn-3d">Войти</button><br />
                        </div>
                    </form>
                        </div>
            </div>      <!-- /.modal-content -->
          </div>    <!-- /.modal-dialog -->
        </div>  <!-- /.modal -->
        
      
        
    <!-- JS scripts -->
            <script src="<?php echo "$path[home]$path[frontend_tpl]";?>/js/jquery-3.3.1.min.js"></script>		
            <script src="<?php echo "$path[home]$path[frontend_tpl]";?>/js/bootstrap.min.js"></script>
            <script src="<?php echo "$path[home]$path[frontend_tpl]";?>/js/scripts.js"></script>
            <div id="toTop"><span class="glyphicon glyphicon-chevron-up"></span></div>
            <script type="text/javascript">ActiveLinks('main-menu');</script>
    </body>
</html>
