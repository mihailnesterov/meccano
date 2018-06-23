<?php

/* 
 * Файл всех настроек
 */


// настройки frontend-сайта
$frontend = [ 
            "name" => "Meccano",
            "title" => "сервис посадочных страниц Landing Pages"
	];

// настройки кабинета пользователя
$cabinet = [ 
            "name" => "Meccano",
            "title" => "личный кабинет",
            "phone" => "8 800 000 000",
            "email" => "help@meccano.ru"
	];

// настройки панели администратора
$admin = [ 
            "name" => "Meccano",
            "title" => "панель администратора"
	];

// настройки путей к каталогам
$path = [ 
            "home" => "/lpservice_php/",
            "frontend" => "frontend",
            "frontend_tpl" => "templates/frontend/tpl-frontend-1",
            "admin" => "admin",
            "admin_tpl" => "templates/admin/tpl-admin-1",
            "cabinet" => "cabinet",
            "cabinet_tpl" => "templates/admin/tpl-admin-1",
            "lp" => "lp",
            "lp_tpl" => "templates/lp"
	];


// настройки подключения к базе данных MySQL
$db = [ 
            "host" => "localhost",
            "user" => "root",
            "pass" => "",
            "db" => "lpservice"
	];

// настройки меню личного кабинета
$cabinet_menu = [ 
            "pages" => "Мои страницы",
            "create" => "Создать страницу",
            "templates" => "Шаблоны",
            "profile" => "Мой профиль",
            "support" => "Поддержка"
	];

// настройки меню кабинета администратора
$admin_menu = [ 
            "users" => "Пользователи",
            "edit_user" => "Редактировать пользователя",
            "create" => "Создать шаблон",
            "templates" => "Шаблоны",
            "edit_template" => "Редактировать шаблон",
            "profile" => "Мой профиль",
            "support" => "Поддержка"
	];