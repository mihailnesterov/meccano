<?php

/* 
 * Регистрация пользователей
 */

/* 
 * Файл reg.php - это обработчик формы регистрации.
 * Данный файл указывается у форм в параметре action.
 * Чтобы при обработке action попадать в нужную функцию, получаем значение reg из крытого поля.
 */

// функция регистрации пользователя
function registration($cabinet)
{
    //Если форма регистрации отправлена и ВСЕ поля непустые...
    if (!empty($_REQUEST['your-password-reg']) and !empty($_REQUEST['your-password-confirm']) and !empty($_REQUEST['your-login-reg'])) 
    {
        //Пишем логин и пароль из формы в переменные (для удобства работы):
        $login = $_REQUEST['your-login-reg'];
        $password = $_REQUEST['your-password-reg']; 
        $password_confirm = $_REQUEST['your-password-confirm']; //подтверждение пароля

        //Если пароль и его подтверждение совпадают...
        if ($password == $password_confirm) 
            {
                /*
                 * Выполняем проверку на незанятость логина. Ответ базы запишем в переменную $is_login_free. 
                 * Запрос = ВЫБРАТЬ ИЗ таблицы_users ГДЕ логин = $login.
                */
                $query = 'SELECT * FROM users WHERE login="'.$login.'"';			

                $tmp = mysql_query($query);		//ответ базы запишем во временную переменную $tmp
                $is_login_free = mysql_fetch_assoc($tmp);	//преобразуем ответ из БД в массив PHP и сохраняем в $is_login_free

                //Если $is_login_free пустой - то логин не занят!
                if (empty($is_login_free)) 
                {				
                    /*
                     * Формируем и отсылаем SQL запрос на добавление:
                     * ВСТАВИТЬ В таблицу_users УСТАНОВИТЬ id = $max логин = $login И пароль = md5($password).
                     * пароль шифруется алгоритмом md5
                    */
                    $query = 'INSERT INTO `users`(`login`, `password`, `created`) VALUES ("'.$login.'", "'.md5($password).'", curdate());';

                    mysql_query($query); 
                    
                    // создаем каталог пользователея в lp
                    $user_folder = './lp/'.$login.'/';
                     /*if (!mkdir($user_folder)) {          // временно отключено, для демонстрации
                         die('Не удалось создать каталог пользователя в lp...');
                     }*/
                    
                    /*
                    * создаем сессию - для того, чтобы хранить в сессии логин и передать его 
                    * в личный кабинет пользователя или кабинет администратора
                    */

                   session_start(); 
                   //Пишем в сессию информацию о том, что мы авторизовались:
                   $_SESSION['reg'] = true;
                   // пишем логин в сессию	
                   $_SESSION['login'] = $login;
                                      
                   

                    //При успешной регистрации перенаправляем пользователя в личный кабинет
                    echo '<script>location.replace("'.$cabinet.'");</script>';
                }
                //Если $is_login_free НЕ пустой - то логин занят!
                else 
                {
                        echo 'Ошибка! Пользователь с логином '.$is_login_free['login'].' уже существует!<br>';
                }
            }
         //Если пароль и его подтверждение НЕ совпадают - выведем ошибку:
        else 
            {
                echo 'Пароль и его подтверждение не совпадают!';
            }
    }
    //Не заполнено какого-либо из полей...
    else 
    {
            echo 'Поля не могут быть пустыми!';
    }
}