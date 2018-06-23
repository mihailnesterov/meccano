<?php

/* 
 * страница "Удалить шаблон"
 */
require "../config/config.php";

// удаляем шаблон с id, который указан в адресной строке после &id=
$url=$_SERVER['REQUEST_URI'];   // получаем url
$route = explode('=', $url);      // обрезаем url и получаем значение id после &id=
$template_id = $route[2];
$template = db_select_template_by_id($template_id);    // получаем данные шаблона с id из адресной строки

?>

<section class="row">
    <h2>Удалить шаблон</h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>На данной странице вы можете удалить шаблон. Внимание! Будут удалены все данные шаблона, в том числе все связанные с ним блоки и элементы</p>
    <br>
    <form action="" method="POST" role="form" class="col-sm-12 col-md-8 col-lg-6">
        <h3>Удалить шаблон <strong><?php echo $template["name"]; ?></strong> ?</h3>
        <hr>
            <button type="submit" id="tpl-del-btn" name="tpl-del-btn" class="btn btn-danger btn-lg">Удалить</button>
            &nbsp;
            <a href="<?php echo "$path[home]$path[admin]?r=templates" ?>" class="btn btn-warning btn-lg">Отмена</a>
    </form>
</section>

<?php

// удаляем пользователя по нажатию кнопки
    if( isset( $_POST['tpl-del-btn'] ) )	// обрабатываем нажатие кнопки name="tpl-del-btn" на форме
	{
            db_delete_template_by_id($template['id']);     // вызываем функцию удаления шаблона с id = $template['id']
        }
        
?>