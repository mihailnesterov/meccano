<?php

/* 
 * страница "Мой профиль"
 */

/* получаем информацию о пользователе, используем логин из сессии login*/
if (!empty($_SESSION['login']))	
    {
        $login = $_SESSION['login'];
    }

$user_data = db_select_user_account($login);    // запоминаем в user_data логин пользователя
$user_id = $user_data['id'];    // id пользователя берем из массива $user_data, используем id далее в запросе UPDATE для обновления данных пользователя

?>
<section class="row">
    <h2>Мой профиль</h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>В данном разделе вы можете изменить ваши персональные данные и установить новый пароль</p>
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
        <fieldset>
            <legend>Изменить пароль:</legend>
            <div class="form-group">
                <label class="sr-only" for="user-new-password">User password</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></div>
                    <input type="password" class="form-control input-lg" id="user-new-password" name="user-new-password" placeholder="Введите новый пароль" pattern="[A-Za-z0-9]{5,}">
                </div>
            </div>
            <div class="form-group">
                <label class="sr-only" for="user-new-password-confirm">User password confirm</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-check" aria-hidden="true"></i></div>
                    <input type="password" class="form-control input-lg" id="user-new-password-confirm" name="user-new-password-confirm" placeholder="Подтвердите новый пароль" pattern="[A-Za-z0-9]{5,}">
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
            $new_password = $_REQUEST['user-new-password'];
            $new_password_confirm = $_REQUEST['user-new-password-confirm'];
            
            // проверяем, заполнены ли поля пароля и подтверждения:
            if (!empty($_REQUEST['user-new-password']) and !empty($_REQUEST['user-new-password-confirm']))  // если поля пароля и подтверждения заполнены, то: 
                {
                    if ($new_password == $new_password_confirm) // проверяем, совпадает ли пароль и подтверждение пароля
                        {
                            // если совпадают, то обновляем все поля, в том числе пароль:
                            $query = 'UPDATE `users` SET `name`="'.$name.'",`email`="'.$email.'",`phone`="'.$phone.'",`password`="'.md5($new_password).'" WHERE id="'.$user_id.'"'; // формируем запрос
                            @mysql_query($query) or die('Invalid query: '.mysql_error());   // выполняем запрос
                            echo '<script>window.alert("Данные пользователя и пароль обновлены!");</script>';    // показываем сообщение
                            
                        }
                    else // Если пароль и его подтверждение НЕ совпадают - вывожим сообщение об ошибке:
                        {
                            echo '<script>window.alert("Ошибка! Пароль и его подтверждение не совпадают!");</script>';    // показываем JavaScript-сообщение об ошибке
                        }
                }
            else    // если пароль обновлять не нужно, то:
                {
                    // обновляем поля, без изменения пароля
                    $query = 'UPDATE `users` SET `name`="'.$name.'",`email`="'.$email.'",`phone`="'.$phone.'" WHERE id="'.$user_id.'"';     // формируем запрос
                    @mysql_query($query) or die('Invalid query: '.mysql_error());     // выполняем запрос
                    echo '<script>window.alert("Данные пользователя обновлены!");</script>';    // показываем сообщение
                }

            echo "<meta http-equiv='refresh' content='0'>";     // обновляем страницу
        }

?>