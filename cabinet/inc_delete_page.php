<?php

/* 
 * страница "Удалить страницу"
 */
require "../config/config.php";

// удаляем страницу с id, который указан в адресной строке после &id=
$url=$_SERVER['REQUEST_URI'];   // получаем url
$route = explode('=', $url);      // обрезаем url и получаем значение id после &id=
$lp_id = $route[2];
$lp = db_select_lp_by_id($lp_id);    // получаем данные страницы с id из адресной строки
?>

<section class="row">
    <h2>Удалить страницу</h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>В данном разделе вы можете удалить страницу. Внимание! Будут удалены все данные страницы, в том числе все связанные с ней блоки и элементы</p>
    <br>
    <form action="" method="POST" role="form" class="col-sm-12 col-md-8 col-lg-6">
        <h3>Удалить страницу <strong><?php echo $lp["name"]; ?></strong> ?</h3>
        <hr>
            <button type="submit" id="lp-del-btn" name="lp-del-btn" class="btn btn-danger btn-lg">Удалить</button>
            &nbsp;
            <a href="<?php echo "$path[home]$path[cabinet]?r=pages" ?>" class="btn btn-warning btn-lg">Отмена</a>
    </form>
</section>

<?php

// удаляем пользователя по нажатию кнопки
    if( isset( $_POST['lp-del-btn'] ) )	// обрабатываем нажатие кнопки name="lp-del-btn" на форме
	{
            db_delete_lp_by_id($lp['id']);     // вызываем функцию удаления страницы с id = $lp['id']
        }
        
?>