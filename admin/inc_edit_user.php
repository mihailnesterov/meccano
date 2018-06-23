<?php

/* 
 * страница "Редактировать пользователя"
 */
require "../config/config.php";

// редактируем пользователя с id, который указан в адресной строке после &id=
$url=$_SERVER['REQUEST_URI'];   // получаем url
$route = explode('=', $url);      // обрезаем url и получаем значение id после &id=
$user_id = $route[2];
$user_data = db_select_user_account_by_id($user_id);    // получаем данные пользователя с id из адресной строки

?>

<section class="row">
    <h2>Редактировать пользователя</h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>На данной странице вы можете изменить личные данные пользователя. Логин и пароль пользователя изменить нельзя! Это может сделать только сам пользователь из личного кабинета</p>
    <br>
    <form action="" method="POST" role="form" class="col-sm-12 col-md-8 col-lg-6">
        <h3>Информация о пользователе: <strong><?php echo $user_data["login"]; ?></strong></h3>
        <hr>
        <fieldset>
            <legend>Персональные данные:</legend>
            <div class="form-group">
                <label for="user-name">Ваше имя:</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></div>
                    <input type="text" class="form-control input-lg" id="user-name" name="user-name" placeholder="Имя" value="<?php echo $user_data["name"]; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="user-email">Email:</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                    <input type="mail" class="form-control input-lg" id="user-email" name="user-email" placeholder="Email" value="<?php echo $user_data["email"]; ?>" >
                </div>
            </div>
            <div class="form-group">
                <label for="user-phone">Телефон:</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                    <input type="text" class="form-control input-lg" id="user-phone" name="user-phone" placeholder="Телефон" value="<?php echo $user_data["phone"]; ?>">
                </div>
            </div>
        </fieldset>
        <button type="submit" class="btn btn-success btn-lg" name="update_btn">Сохранить изменения</button>
        &nbsp;
        <a href="<?php echo "$path[home]$path[admin]?r=users" ?>" class="btn btn-warning btn-lg">Отмена</a>
    </form>
</section>

<?php
    
    // обновляем данные пользователя
    if( isset( $_POST['update_btn'] ) )	// обрабатываем нажатие кнопки name="update" на форме
	{
            $name = $_REQUEST['user-name'];     // сохраняем в переменных данные из полей форм
            $email = $_REQUEST['user-email']; 
            $phone = $_REQUEST['user-phone'];
            $query = 'UPDATE `users` SET `name`="'.$name.'",`email`="'.$email.'",`phone`="'.$phone.'" WHERE id="'.$user_id.'"';     // запрос на обновление
            @mysql_query($query) or die('Invalid query: '.mysql_error()); // выполняем запрос
            echo "<meta http-equiv='refresh' content='0'>";     // обновляем страницу
            echo '<script>window.alert("Данные пользователя обновлены!");</script>';    // показываем сообщение   
        }

?>