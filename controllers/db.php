<?php

/* 
 * Функции для работы с базой данных
 */

// функция подключения к БД
function db_connect($host, $user, $pass, $db)
    {
        // подключаемся к серверу, выбираем БД
        @mysql_connect($host, $user, $pass) or die("Не могу подключиться к серверу MySQL! ".mysql_error());   // подключаемся к серверу
        @mysql_select_db($db) or die("Не могу выбрать БД! ".mysql_error());    // выбираем БД
        @mysql_query("SET NAMES UTF8");	// включаем кодировку UTF8, чтобы корректно сохранялись русские буквы в БД
    }
    
// функция выборки всех записей из таблицы
function db_select_all($table)
    {
        $query="SELECT * FROM ".$table;       
	$result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
        $row=mysql_fetch_assoc($result);
                
        foreach ($row as $key=>$value)
            {
                echo $value."<br>";
            }
    }
    
// функция выборки логина пользователя из таблицы users
function db_select_user_login($user)
    {
        $query="SELECT login FROM users where login='".$user."'";       
	$result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
        $user_login=mysql_fetch_assoc($result);        
        echo $user_login['login'];
    }
// функция выборки персональных данных пользователя из таблицы users по логину
function db_select_user_account($user)
    {
        $query="SELECT * FROM users where login='".$user."'";       
	$result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
        $user_data=mysql_fetch_assoc($result);
        
        $id = $user_data['id'];
        $login = $user_data['login'];
        $password = $user_data['password']; 
        $name = $user_data['name'];
        $email = $user_data['email']; 
        $phone = $user_data['phone'];
        $created = $user_data['created'];
        
        return $user_account = array (
            "id" => $id,
            "login" => $login,
            "password" => $password,
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
            "created" => $created
        );
    }

// функция выборки персональных данных пользователя из таблицы users по id
function db_select_user_account_by_id($user)
    {
        $query="SELECT * FROM users where id='".$user."'";       
	$result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
        $user_data=mysql_fetch_assoc($result);
        
        $id = $user_data['id'];
        $login = $user_data['login'];
        $password = $user_data['password']; 
        $name = $user_data['name'];
        $email = $user_data['email']; 
        $phone = $user_data['phone'];
        $created = $user_data['created'];
        
        return $user_account = array (
            "id" => $id,
            "login" => $login,
            "password" => $password,
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
            "created" => $created
        );
    }

// функция удаления пользователя по id
function db_delete_user_by_id($user_id) 
    {
        $query = 'DELETE FROM `users` WHERE id="'.$user_id.'"';     // запрос на удаление
        @mysql_query($query) or die('Invalid query: '.mysql_error()); // выполняем запрос на удаление
        echo '<script>window.alert("Пользователь удален!");</script>';    // показываем сообщение, что пользователь удален
        echo '<script>location.replace("'."$path[home]$path[admin]".'?r=users");</script>';  // перенаправляем на страницу пользователей
    }
    
// функция выборки всех шаблонов
function db_select_templates() 
    {
        $query="SELECT * FROM templates";       
	$result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
        $templates_data=mysql_fetch_assoc($result);
        
        $id = $templates_data['id'];
        $name = $templates_data['name'];
        $category = $templates_data['category']; 
        $created = $templates_data['created'];
        $price = $templates_data['price'];
        
        return $templates_lp = array (
            "id" => $id,
            "name" => $name,
            "category" => $category,
            "created" => $created,
            "price" => $price
        );
    }
    
// функция выборки параметров шаблона из таблицы templates по id шаблона
function db_select_template_by_id($template_id)
    {
        $query="SELECT * FROM templates where id='".$template_id."'";       
	$result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
        $template_data=mysql_fetch_assoc($result);
        
        $id = $template_data['id'];
        $name = $template_data['name'];
        $category = $template_data['category']; 
        $created = $template_data['created'];
        $price = $template_data['price'];
        
        return $template = array (
            "id" => $id,
            "name" => $name,
            "category" => $category,
            "created" => $created,
            "price" => $price
        );
    }

// функция удаления шаблона из таблицы templates по id шаблона    
function db_delete_template_by_id($template_id)
        {
            $query = 'DELETE FROM `templates` WHERE id="'.$template_id.'"';     // запрос на удаление
            @mysql_query($query) or die('Invalid query: '.mysql_error()); // выполняем запрос на удаление
            echo '<script>window.alert("Шаблон удален!");</script>';    // показываем сообщение, что шаблон удален
            echo '<script>location.replace("'."$path[home]$path[admin]".'?r=templates");</script>';  // перенаправляем на страницу шаблонов
        }

        
// функция выборки параметров блока шаблона из таблицы tpl_blocks по id блока       
function db_select_template_block_by_id($block_id)
    {
        $query='SELECT * FROM tpl_blocks WHERE id="'.$block_id.'"'; 
	$result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
        $block_data=mysql_fetch_assoc($result);
        
        $id = $block_data['id'];
        $name = $block_data['name'];
        $comment = $block_data['comment']; 
        
        return $block = array (
            "id" => $id,
            "name" => $name,
            "comment" => $comment
        );
    }
    
    
// функция удаления блока из таблицы tpl_blocks по id блока    
function db_delete_template_block_by_id($block_id)
        {
            $query = 'DELETE FROM `tpl_blocks` WHERE id="'.$block_id.'"';     // запрос на удаление
            @mysql_query($query) or die('Invalid query: '.mysql_error()); // выполняем запрос на удаление
            echo '<script>window.alert("Блок удален!");</script>';    // показываем сообщение, что блок удален           
            if (!empty($_SESSION['tpl_id']))	// получаем id шаблона из сессии
                {
                    $tpl_id = $_SESSION['tpl_id'];
                }            
            echo '<script>location.replace("'."$path[home]$path[admin]?r=edit_tpl_blocks&id=$tpl_id".'");</script>';
        }
        
             
// функция выборки параметров элементов блока шаблона из таблицы tpl_elements по id блока     
function db_select_block_element_by_id($element_id)
    {
        $query='SELECT * FROM tpl_elements WHERE id="'.$element_id.'"'; 
	$result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
        $element_data=mysql_fetch_assoc($result);
        
        $id = $element_data['id'];
        $blocks_id = $element_data['blocks_id '];
        $name = $element_data['name'];
        $title = $element_data['title'];
        $subtitle = $element_data['subtitle'];
        $image = $element_data['image'];
        $icon = $element_data['icon'];
        $link = $element_data['link'];
        $date = $element_data['date'];
        $text = $element_data['text'];
        
        return $element = array (
            "id" => $id,
            "blocks_id" => $blocks_id,
            "name" => $name,
            "title" => $title,
            "subtitle" => $subtitle,
            "image" => $image,
            "icon" => $icon,
            "link" => $link,
            "date" => $date,
            "text" => $text
        );
    }

// функция удаления элемента из таблицы tpl_element по id элемента   
function db_delete_template_element_by_id($element_id)
        {
            $query = 'DELETE FROM `tpl_elements` WHERE id="'.$element_id.'"';     // запрос на удаление
            @mysql_query($query) or die('Invalid query: '.mysql_error()); // выполняем запрос на удаление
            echo '<script>window.alert("Элемент удален!");</script>';    // показываем сообщение, что элемент удален           
            if (!empty($_SESSION['block_id']))	// получаем id блока из сессии
                {
                    $block_id = $_SESSION['block_id'];
                }            
            echo '<script>location.replace("'."$path[home]$path[admin]?r=edit_tpl_block&id=$block_id".'");</script>';
        }

// функция выборки параметров страницы из таблицы lp по id шаблона
function db_select_lp_by_id($lp_id)
    {
        $query="SELECT * FROM lp where id='".$lp_id."'";       
	$result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
        $lp_data=mysql_fetch_assoc($result);
        
        $id = $lp_data['id'];
        $name = $lp_data['name'];
        $user_id = $lp_data['user_id']; 
        $template_id = $lp_data['template_id'];
        
        return $lp = array (
            "id" => $id,
            "name" => $name,
            "user_id" => $user_id,
            "template_id" => $template_id
        );
    }
    
// функция удаления страницы из таблицы lp по id шаблона
function db_delete_lp_by_id($lp_id)
        {
            $query = 'DELETE FROM `lp` WHERE id="'.$lp_id.'"';     // запрос на удаление
            @mysql_query($query) or die('Invalid query: '.mysql_error()); // выполняем запрос на удаление
            echo '<script>window.alert("Страница удалена!");</script>';    // показываем сообщение, что страница удалена               
            echo '<script>location.replace("'."$path[home]$path[cabinet]?r=pages".'");</script>';
        }

// функция выборки параметров элементов страницы из таблицы elements по id элемента     
function db_select_lp_element_by_id($element_id)
    {
        $query='SELECT * FROM elements WHERE id="'.$element_id.'"'; 
	$result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
        $element_data=mysql_fetch_assoc($result);
        
        $id = $element_data['id'];
        $lp_id = $element_data['lp_id'];
        $block_name = $element_data['block_name'];
        $name = $element_data['name'];
        $title = $element_data['title'];
        $subtitle = $element_data['subtitle'];
        $image = $element_data['image'];
        $icon = $element_data['icon'];
        $link = $element_data['link'];
        $date = $element_data['date'];
        $text = $element_data['text'];
        
        return $lp_element = array (
            "id" => $id,
            "lp_id" => $lp_id,
            "blocks_name" => $block_name,
            "name" => $name,
            "title" => $title,
            "subtitle" => $subtitle,
            "image" => $image,
            "icon" => $icon,
            "link" => $link,
            "date" => $date,
            "text" => $text
        );
    }