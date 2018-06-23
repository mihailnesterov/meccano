<?php
	
/* 
 * Авторизация пользователей
 */

/* 
 * Файл auth.php - это обработчик формы авторизации.
 * Данный файл указывается у форм в параметре action.
 * Чтобы при обработке action попадать в нужную функцию, получаем значение auth из крытого поля.
 */

// функция авторизации
function authorization($admin, $cabinet)
    {
        //Если форма авторизации отправлена, то:
        if ( !empty($_REQUEST['your-login-auth']) and !empty($_REQUEST['your-password-auth']) ) 
        {
                //Пишем логин и пароль из формы в переменные (для удобства работы):
                $login = $_REQUEST['your-login-auth'];
                $password = $_REQUEST['your-password-auth'];

                /*
                 * Формируем и отсылаем SQL запрос:
                 * ВЫБРАТЬ ИЗ таблицы_users ГДЕ поле_логин = $login И поле_пароль = md5($password).
                 * пароль расшифровывается алгоритмом md5
                */
                
                $query = 'SELECT login, password, role FROM users WHERE login="'.$login.'" AND password="'.md5($password).'"';
                
                // в два шага получаем результаты запроса в переменную $user
                $result = mysql_query($query) or die('Invalid query: '.mysql_error()); 		//ответ базы запишем в переменную $result
                $user = mysql_fetch_assoc($result); 	//преобразуем ответ из БД в массив PHP и сохраняем в $user

                /*
                 * создаем сессию - для того, чтобы хранить в сессии логин и передать его 
                 * в личный кабинет пользователя или кабинет администратора
                 */
                
                session_start(); 
                //Пишем в сессию информацию о том, что мы авторизовались:
                $_SESSION['auth'] = true;
                // пишем логин в сессию	
                $_SESSION['login'] = $user['login'];

                //Если база данных вернула не пустой ответ - значит пара логин-пароль правильная
                if (!empty($user)) 
                        {
                            /* Пользователь прошел авторизацию, поэтому выполняется следующий код:*/

                            if($user['role']=='admin')		// если залогинились как администратор, то:
                                    {
                                            // redirect на страницу администратора на JavaScript
                                            echo '<script>location.replace("'.$admin.'");</script>';
                                    }
                            else
                                    {
                                            // redirect в личный кабинет пользователя на JavaScript
                                            echo '<script>location.replace("'.$cabinet.'");</script>';
                                    }
                        }
                else 
                        {
                            /* Ошибка - пользователь неверно ввел логин или пароль */
                            echo '<script>window.alert("Ошибка! Неверный логин или пароль!");</script>';
                        }
        }
    }