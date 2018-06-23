<?php

/* 
 * Функции для работы с пользовательскими страницами
 */

// подключаем файл настроек
require "../config/config.php";

/* 
 * Файл templates.php - это обработчик функций для работы с шаблонами, блоками и элементами шаблонов.
 * Данный файл указывается у форм в параметре action.
 * Чтобы при обработке action попадать в нужную функцию, получаем значение из name скрытого поля.
 */

// функция добавления блока в шаблон
function add_block_in_template($tpl_id)
        {
            //Пишем значения полей из формы в переменные (для удобства работы):
                $name = $_REQUEST['tpl-block-name'];
                $comment = $_REQUEST['tpl-block-comment']; 

            /*
            * Формируем и отсылаем SQL запрос на добавление блока:
            */
            $query = 'INSERT INTO `tpl_blocks`(`tpl_id`, `name`, `comment`) VALUES ("'.$tpl_id.'", "'.$name.'", "'.$comment.'");';

            @mysql_query($query) or die('Invalid query: '.mysql_error()); // выполняем запрос
            echo "<meta http-equiv='refresh' content='0'>";     // обновляем страницу
        }
        
// функция вывода элементов на страницу - !!!!!!!! пока здесь не работает, реализована в index.php страниц
function element($tpl_id)
        {
            
        }