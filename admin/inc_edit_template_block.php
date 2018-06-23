<?php

/* 
 * страница "Редактировать блок шаблона"
 */
require "../config/config.php";

// редактируем блок с id, который указан в адресной строке после &id=
$url=$_SERVER['REQUEST_URI'];   // получаем url
$route = explode('=', $url);      // обрезаем url и получаем значение id после &id=
$block_id = $route[2];
$block = db_select_template_block_by_id($block_id);    // получаем данные блока с id из адресной строки

if (!empty($_SESSION['tpl_id']) and !empty($_SESSION['tpl_name']))	// получаем id и имя шаблона из сессии
    {
        $tpl_id = $_SESSION['tpl_id'];
        $tpl_name = $_SESSION['tpl_name'];
    }
session_start();    // создаем сессию, в которую пишем id и название блока, они будут использоваться при переходе на страницу редактирования элемента
$_SESSION['block_id'] = $block_id;
$_SESSION['block_name'] = $block["name"];
?>

<section class="row">
    <h2>Шаблон <a href="<?php echo "$path[home]$path[admin]?r=edit_tpl_blocks&id=$tpl_id" ?>"><?php echo $tpl_name; ?></a> / Настройка блока / Блок "<?php echo $block["name"]; ?>"</h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>На этой странице вы можете отредактировать блок шаблона и добавить в него элементы - заголовки, тексты, картинки, ссылки и т.д.</p>
    <br>

    
    <form action="" method="POST" role="form" class="col-sm-9 col-lg-6">
        <h3>Редактировать блок:</h3>
      <fieldset>
        <div class="form-group">
            <div class="input-group">
                <label class="sr-only" for="tpl_block_name">Название блока</label>
                <div class="input-group-addon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
                <input type="text" class="form-control input-lg" placeholder="Название блока *" id="tpl-block-name" name="tpl-block-name" required="required" value="<?php echo $block["name"]; ?>" />
            </div>
        </div>                           
        <div class="form-group">
            <textarea class="form-control" rows="4" id="tpl_block_comment" name="tpl-block-comment" placeholder="Комментарий"><?php echo $block["comment"]; ?></textarea>
        </div>
    </fieldset>

        <hr>
        <button type="submit" class="btn btn-success btn-lg" name="save_block_btn">Сохранить изменения</button>
        &nbsp;
        <a href="<?php echo "$path[home]$path[admin]?r=edit_tpl_blocks&id=$tpl_id" ?>" class="btn btn-warning btn-lg">Отмена</a>
    </form>
    
    <div class="col-sm-3 col-lg-2">
        <h4>Схема блоков:</h4>
        <br>
        <img src="<?php echo "$path[home]$path[lp_tpl]/$tpl_name"; ?>/screenshot.png" class="img-responsive">
    </div>
    <div class="col-sm-3 col-lg-2">
        <h4>Схема элементов:</h4>
        <br>
        <img src="<?php echo "$path[home]$path[lp_tpl]/$tpl_name"; ?>/screenshot1.png" class="img-responsive">
    </div>
    
    <div class="col-md-12">
        <a href="<?php echo "$path[home]$path[admin]?r=add_tpl_element&id=$block_id" ?>" class="btn btn-success btn-lg">Добавить элемент в блок "<?php echo $block["name"]; ?>"</a>
        <br><br>
    <table id="projects-table" class="table table-bordered table-striped table-responsive">
    <tr>
        <th>№</th>
        <th>id</th>
        <th>Название<br> (name)</th>
        <th>Заголовок<br> (title)</th>
        <th>Подзаголовок<br> (subtitle)</th>
        <th>Картинка<br> (image)</th>
        <th>Иконка<br> (icon)</th>
        <th>Ссылка<br> (link)</th>
        <th>Дата<br> (date)</th>
        <th>Текст<br> (text)</th>
        <th>Редактировать</th>
        <th>Удалить</th>
    </tr>   
    <?php
    db_connect($db['host'], $db['user'], $db['pass'], $db['db']);
    $query='SELECT * FROM tpl_elements WHERE blocks_id="'.$block_id.'"';    // выбираем все элементы блока с id = $block_id
    $result=mysql_query($query) or die("Не могу сделать выборку из таблицы tpl_elements!");

    /* выводим записи из tpl_elements в таблице - заголовок статический, поля выводятся динамически в цикле while*/
    $num = 1;   // счетчик записей, для нумерации строк, используется в первом поле в цикле while
    while($row = mysql_fetch_array($result))
        {
        echo '<tr>'
                 . '<td>'.$num.'</td>'
                . '<td>'.$row['id'].'</td>'
                 . '<td>'.$row['name'].'</td>'
                 . '<td>'.$row['title'].'</td>'
                . '<td>'.$row['subtitle'].'</td>'
                . '<td>'.$row['image'].'</td>'
                . '<td>'.$row['icon'].'</td>'
                . '<td>'.$row['link'].'</td>'
                . '<td>'.$row['date'].'</td>'
                . '<td>'.$row['text'].'</td>'
                 . '<td><a href="'."$path[home]$path[admin]".'?r=edit_block_element&id='.$row['id'].'" class="btn btn-warning">Редактировать</a></td>'
                 . '<td><a href="'."$path[home]$path[admin]".'?r=del_block_element&id='.$row['id'].'" class="btn btn-danger">Удалить</a></td>'
            . '</tr>';
        $num++;     
        }

        // обработка формы добавления блока в шаблон
        if(isset($_POST['add-block']))
            {
                $add_block_func = $_POST['add-block'];

                    // проверяем, существует ли функция registration()
                if (function_exists($add_block_func))
                    {
                        add_block_in_template($template_id);
                    }
                else
                    {
                        //Если add_block_in_template() не найдена, то:
                        echo 'Ошибка! Функция add_block_in_template() не найдена! Проверьте подключение к controllers/templates.php';
                    }
            }

        ?>
    </table>
    </div>
    
    
</section>


<?php
    
    // сохраняем шаблон
    if( isset( $_POST['save_block_btn'] ) )	// обрабатываем нажатие кнопки name="save_block_btn" на форме
	{
            $name = $_REQUEST['tpl-block-name'];     // сохраняем в переменных данные из полей форм
            $comment = $_REQUEST['tpl-block-comment']; 
            $query = 'UPDATE `tpl_blocks` SET `name`="'.$name.'",`comment`="'.$comment.'" WHERE id="'.$block_id.'"';     // запрос на обновление
            @mysql_query($query) or die('Invalid query: '.mysql_error()); // выполняем запрос
            echo "<meta http-equiv='refresh' content='0'>";     // обновляем страницу
            echo '<script>window.alert("Блок сохранен!");</script>';    // показываем сообщение
            echo '<script>location.replace("'."$path[home]$path[admin]?r=edit_tpl_blocks&id=$tpl_id".'");</script>';  // перенаправляем на страницу шаблона
        }

?>