<?php

/* 
 * страница "Мои страницы"
 */
require "../config/config.php";

if (!empty($_SESSION['login']))	// получаем имя пользователя из сессии
    {
        $login = $_SESSION['login'];
    }
$user = db_select_user_account($login); // получаем данные пользователя

//if (!empty($_SESSION['lp_path']))	// получаем путь к папке lp из сессии - удалить! не используется!
    //{
     //   $lp_path = $_SESSION['lp_path'];
    //}

?>

<h2>Мои страницы</h2>
<hr>

<p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>В данном разделе вы видите список ваших страниц. Вы можете редактировать, удалять, создавать новые страницы, а также просмотреть как они выглядят в браузере</p>
<br>

<a href="<?php echo "$path[home]$path[cabinet]?r=create";?>" class="btn btn-success btn-lg">Создать страницу</a>
<br><br>

<table id="projects-table" class="table table-bordered table-striped table-responsive">

    <tr>
        <th>№</th>
        <th>Название</th>
        <th>Шаблон</th>
        <th>Адрес (url) страницы</th>
        <th>Дата создания</th>
        <th>Редактировать страницу</th>
        <th>Удалить страницу</th>
    </tr>
    
    <?php      
    
    /* выводим все страницы пользователя из lp динамически в цикле while*/
    
    db_connect($db['host'], $db['user'], $db['pass'], $db['db']);
    $query='SELECT * FROM lp WHERE user_id="'.$user[id].'"';    // выбираем всех пользователей с ролью user
    $result=mysql_query($query) or die("Не могу сделать выборку из таблицы lp! ".mysql_error());

    
    
    $num = 1;   // счетчик записей, для нумерации строк, используется в первом поле в цикле while
    while($row = mysql_fetch_array($result))
        {
        
        echo '<tr>'
                 . '<td>'.$num.'</td>'
                 . '<td>'.$row['name'].'</td>'
                 . '<td><img src="'.$path[home].$path[lp].'/'.$login.'/'.$row[id].'/screenshot.png'.'" class="img-responsive"></td>'                
                 . '<td><a href="'.$path['home'].$path[lp].'/'.$login.'/'.$row[id].'/index.php" target="_blank">Перейти</a>'.'</td>'
                 . '<td>'.$row['created'].'</td>'
                 . '<td><a href="'."$path[home]$path[cabinet]".'?r=edit_page&id='.$row['id'].'" class="btn btn-warning">Редактировать</a></td>'
                 . '<td><a href="'."$path[home]$path[cabinet]".'?r=del_page&id='.$row['id'].'" class="btn btn-danger">Удалить</a></td>'
            . '</tr>';
        $num++;     
        }

    ?>
   
</table>
