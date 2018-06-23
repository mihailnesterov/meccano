<?php

/* 
 * страница "Пользователи"
 */
require "../config/config.php";
?>

<h2>Пользователи</h2>
<hr>

<p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>В данном разделе вы можете работать со списком пользователей</p>
<br>

<table id="projects-table" class="table table-bordered table-striped table-responsive">
    <tr>
        <th>№</th>
        <th>id</th>
        <th>Логин</th>  
        <th>Имя</th>
        <th>Email</th>
        <th>Телефон</th>
        <th>Дата регистрации</th>
        <th>Редактировать</th>
        <th>Удалить</th>
    </tr>   
    <?php
    db_connect($db['host'], $db['user'], $db['pass'], $db['db']);
    $role = "user";
    $query='SELECT * FROM users WHERE role="'.$role.'"';    // выбираем всех пользователей с ролью user
    $result=mysql_query($query) or die("Не могу сделать выборку из таблицы users!");

    /* выводим записи из users в таблице - заголовок статический, поля выводятся динамически в цикле while*/
    $num = 1;   // счетчик записей, для нумерации строк, используется в первом поле в цикле while
    while($row = mysql_fetch_array($result))
        {
        echo '<tr>'
                 . '<td>'.$num.'</td>'
                 . '<td>'.$row['id'].'</td>'
                 . '<td>'.$row['login'].'</td>'
                 . '<td>'.$row['name'].'</td>'
                 . '<td>'.$row['email'].'</td>'
                 . '<td>'.$row['phone'].'</td>'
                 . '<td>'.$row['created'].'</td>'
                 . '<td><a href="'."$path[home]$path[admin]".'?r=edit_user&id='.$row['id'].'" class="btn btn-warning">Редактировать</a></td>'
                 . '<td><a href="'."$path[home]$path[admin]".'?r=del_user&id='.$row['id'].'" class="btn btn-danger">Удалить</a></td>'
            . '</tr>';
        $num++;     
        }  
    ?>
</table>
