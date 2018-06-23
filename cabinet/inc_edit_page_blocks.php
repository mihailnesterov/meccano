<?php

/* 
 * страница "Редактировать элементы страницы"
 */
require "../config/config.php";

// редактируем элементы страницы с id, который указан в адресной строке после &id=
$url=$_SERVER['REQUEST_URI'];   // получаем url
$route = explode('=', $url);      // обрезаем url и получаем значение id после &id=
$lp_id = $route[2];
$lp = db_select_lp_by_id($lp_id);    // получаем данные страницы с id из адресной строки

if (!empty($_SESSION['login']))	// получаем имя пользователя из сессии, нужно, чтобы вывести картинку страницы
    {
        $login = $_SESSION['login'];
    }
$user = db_select_user_account($login); // получаем данные пользователя

session_start(); 
// пишем имя страницы в сессию, чтобы использовать на странице редактирования элемента
$_SESSION['lp_id'] = $lp_id;
$_SESSION['lp_name'] = $lp["name"];

?>

<section class="row">
    <h2>Настройка элементов страницы <a href="<?php echo "$path[home]$path[cabinet]?r=edit_page&id=$lp_id" ?>"><?php echo $lp["name"]; ?></a></h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>В данном разделе вы можете отредактировать элементы страницы</p>
    <br>
    <br>

    <div class="col-xs-6 col-sm-2 col-md-2">
        <img src="<?php echo "$path[home]$path[lp]/$login/$lp[id]"; ?>/screenshot.png" class="img-responsive">
    </div>
    <div class="col-xs-12 col-sm-10 col-md-10">
        <div class="row">
        <a href="<?php echo "$path[home]$path[lp]/$login/$lp_id/index.php";?>" class="btn btn-success btn-lg" target="_blank">Открыть страницу в браузере</a>
        <br><br>
    </div>
    <table id="projects-table" class="table table-bordered table-striped table-responsive">
    <tr>
        <th>№</th>
        <th>Название блока</th>
        <th>id элемента</th>
        <th>Название элемента</th>
        <th>Заголовок</th>
        <th>Редактировать</th>
    </tr>   
    <?php
    db_connect($db['host'], $db['user'], $db['pass'], $db['db']);
    $query='SELECT * FROM elements WHERE lp_id="'.$lp_id.'"';    // выбираем все элементы страницы с id = $lp_id
    $result=mysql_query($query) or die("Не могу сделать выборку из таблицы elements!");
    
    /* выводим записи из elements в таблице - заголовок статический, поля выводятся динамически в цикле while*/
    $num = 1;   // счетчик записей, для нумерации строк, используется в первом поле в цикле while
    while($row = mysql_fetch_array($result))
        {
        echo '<tr>'
                 . '<td>'.$num.'</td>'
                 . '<td>'.$row['block_name'].'</td>'
                 . '<td>'.$row['id'].'</td>'
                 . '<td>'.$row['name'].'</td>'
                 . '<td>'.$row['title'].'</td>'
                 . '<td><a href="'."$path[home]$path[cabinet]".'?r=edit_page_element&id='.$row['id'].'" class="btn btn-warning">Редактировать</a></td>'
            . '</tr>';
        $num++;     
        }

        ?>
    </table>
    </div>  
</section>
