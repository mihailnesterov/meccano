<?php

/* 
 * Функции для работы с личным кабинетом администратора
 */

// функция вывода контента в зависимости от значения ?r= в url
function admin_content()
    {
        $url=$_SERVER['REQUEST_URI'];   // получаем url

        $route = explode('=', $url);      // обрезаем url и получаем строку после ?r=

        switch ($route[1])                // подключаем файл с контентом, в зависимости от строки после ?r=
           {
            case "users":
                include_once 'inc_users.php';
                break;
            case "edit_user&id":
                include_once 'inc_edit_user.php';
                break;
            case "del_user&id":
                include_once 'inc_delete_user.php';
                break;
            case "create":
                include_once 'inc_create_template.php';
                break;
            case "templates":
                include_once 'inc_templates.php';
                break;
            case "edit_tpl&id":
                include_once 'inc_edit_template.php';
                break;
            case "del_tpl&id":
                include_once 'inc_delete_template.php';
                break;
            case "edit_tpl_blocks&id":
                include_once 'inc_edit_template_blocks.php';
                break;
            case "edit_tpl_block&id":
                include_once 'inc_edit_template_block.php';
                break;
            case "del_tpl_block&id":
                include_once 'inc_delete_template_block.php';
                break;
            case "edit_block_element&id":
                include_once 'inc_edit_template_element.php';
                break;
            case "add_tpl_element&id":
                include_once 'inc_add_template_element.php';
                break;
            case "del_block_element&id":
                include_once 'inc_delete_template_element.php';
                break;
            case "profile":
                include_once 'inc_profile.php';
                break;
            case "support":
                include_once 'inc_support.php';
                break;
           }
    }
    
// функция копирования шаблона в пользовательский каталог
function admin_copy_template($template, $user_template)
    {
        if (!copy($template, $user_template)) {
            echo "не удалось скопировать $template...\n";
        }
    }