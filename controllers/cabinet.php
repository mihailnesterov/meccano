<?php

/* 
 * Функции для работы с личным кабинетом пользователя
 */

// функция вывода контента в зависимости от значения ?r= в url
function cabinet_content()
    {
        $url=$_SERVER['REQUEST_URI'];   // получаем url

        $route = explode('=', $url);      // обрезаем url и получаем строку после ?r=

        switch ($route[1])                // подключаем файл с контентом, в зависимости от строки после ?r=
           {
            case "pages":
                include_once 'inc_pages.php';
                break;
            case "create":
                include_once 'inc_templates.php';
                break;
            /*case "templates":
                include_once 'inc_templates.php';
                break;*/
            case "create&id":
                include_once 'inc_create.php';
                break;
            case "edit_page&id":
                include_once 'inc_edit_page.php';
                break;
            case "del_page&id":
                include_once 'inc_delete_page.php';
                break;
            case "edit_page_blocks&id":
                include_once 'inc_edit_page_blocks.php';
                break;
            case "edit_page_element&id":
                include_once 'inc_edit_page_element.php';
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
function copy_template($template, $user_template)
    {
        if (!copy($template, $user_template)) {
            echo "не удалось скопировать $template...\n";
        }
    }