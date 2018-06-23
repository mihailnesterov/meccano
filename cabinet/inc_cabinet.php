<?php

/* 
 * страница "Панель управления"
 */
require "../config/config.php";
// перенаправляем на страницу "Мои страницы"
echo '<script>location.replace("'."http://localhost/"."$path[home]cabinet/?r=pages".'");</script>';