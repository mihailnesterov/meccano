<?php

/* 
 * страница "Редактировать блоки шаблона"
 */
require "../config/config.php";

// редактируем шаблон с id, который указан в адресной строке после &id=
$url=$_SERVER['REQUEST_URI'];   // получаем url
$route = explode('=', $url);      // обрезаем url и получаем значение id после &id=
$template_id = $route[2];
$template = db_select_template_by_id($template_id);    // получаем данные шаблона с id из адресной строки


session_start();    // создаем сессию, в которую пишем id и название шаблона, они будут использоваться при переходе на страницу редактирования блоков
$_SESSION['tpl_id'] = $template_id;
$_SESSION['tpl_name'] = $template["name"];
?>

<section class="row">
    <h2>Шаблон <a href="<?php echo "$path[home]$path[admin]?r=edit_tpl&id=$template_id" ?>"><?php echo $template["name"]; ?></a> / Настройка блоков</h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>На этой странице вы можете отредактировать блоки и элементы блоков шаблона</p>
    <br>
    <br>
    <div class="col-xs-12">
        <!--<a href="<?php echo "$path[home]$path[admin]?r=create";?>" class="btn btn-success btn-lg">Добавить блок в шаблон</a>-->
        
    </div>

    <div class="col-xs-6 col-sm-2 col-md-3">
        <img src="<?php echo "$path[home]$path[lp_tpl]/$template[name]"; ?>/screenshot.png" class="img-responsive">
    </div>
    <div class="col-xs-12 col-sm-10 col-md-9">
        <button class="btn btn-success btn-lg" data-toggle="modal" data-target="#ModalAddBlockWindow">Добавить блок в шаблон</button>
        <br><br>
    <table id="projects-table" class="table table-bordered table-striped table-responsive">
    <tr>
        <th>№</th>
        <th>Название блока</th>
        <th>Комментарий</th>
        <th>Редактировать блок,<br> добавить элемент</th>
        <!--<th>Добавить элемент в блок</th>-->
        <th>Удалить блок</th>
    </tr>   
    <?php
    db_connect($db['host'], $db['user'], $db['pass'], $db['db']);
    $query='SELECT * FROM tpl_blocks WHERE tpl_id="'.$template_id.'"';    // выбираем все блоки шаблона с id = $template_id
    $result=mysql_query($query) or die("Не могу сделать выборку из таблицы tpl_blocks!");

    /* выводим записи из users в таблице - заголовок статический, поля выводятся динамически в цикле while*/
    $num = 1;   // счетчик записей, для нумерации строк, используется в первом поле в цикле while
    while($row = mysql_fetch_array($result))
        {
        echo '<tr>'
                 . '<td>'.$num.'</td>'
                 . '<td>'.$row['name'].'</td>'
                 . '<td>'.$row['comment'].'</td>'
                 . '<td><a href="'."$path[home]$path[admin]".'?r=edit_tpl_block&id='.$row['id'].'" class="btn btn-warning">Редактировать</a></td>'
                /* . '<td><a href="'."$path[home]$path[admin]".'?r=add_tpl_element&id='.$row['id'].'" class="btn btn-success">Добавить элемент</a></td>'*/
                 . '<td><a href="'."$path[home]$path[admin]".'?r=del_tpl_block&id='.$row['id'].'" class="btn btn-danger">Удалить</a></td>'
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

<!-- Модальное окно добавления блока в шаблон -->
        <div class="modal fade" id="ModalAddBlockWindow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="ModalLabelAddBlock">Добавить блок в шаблон <?php echo $template["name"]; ?></h4>
		</div>
		<div class="modal-body">
                    <!-- Форма добавления блока в шаблон -->
                    <form action="" method="POST" name="AddBlockForm" class="form form-register" id="AddBlockForm">
                        <fieldset>
                            <input type="hidden" name="add-block" value="add_block_in_template" />   <!-- скрытое поле, используется в controllers/templates.php для вызова функции add_block_in_template() -->
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="sr-only" for="tpl_block_name">Название блока</label>
                                    <div class="input-group-addon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
                                    <input type="text" class="form-control input-lg" placeholder="Название блока *" id="tpl-block-name" name="tpl-block-name" required="required" />
                                </div>
                            </div>                           
                            <div class="form-group">
                                <textarea class="form-control" rows="5" id="tbl_block_comment" name="tpl-block-comment" placeholder="Комментарий"></textarea>
                            </div>
                        </fieldset>

                       <div class="modal-footer">
                            <div id="success"> </div> <!-- For success/fail messages -->

                        <button type="submit" class="btn btn-lg btn-warning btn-3d">Добавить</button>
                        </div>
                    </form>
                        </div>
            </div>      <!-- /.modal-content -->
          </div>    <!-- /.modal-dialog -->
        </div>  <!-- /.modal -->

    