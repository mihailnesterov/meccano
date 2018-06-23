<?php

/* 
 * страница "Панель управления"
 */
require "../config/config.php";
// перенаправляем на страницу "Пользователи"
echo '<script>location.replace("'."http://localhost/"."$path[home]admin/?r=users".'");</script>';