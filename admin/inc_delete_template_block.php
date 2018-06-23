<?php

/* 
 * страница "Удалить блок из шаблона"
 */
require "../config/config.php";

// удаляем блок с id, который указан в адресной строке после &id=
$url=$_SERVER['REQUEST_URI'];   // получаем url
$route = explode('=', $url);      // обрезаем url и получаем значение id после &id=
$block_id = $route[2];
$block = db_select_template_block_by_id($block_id);    // получаем данные блока с id из адресной строки

if (!empty($_SESSION['tpl_id']) and !empty($_SESSION['tpl_name']))	// получаем id и имя шаблона из сессии
    {
        $tpl_id = $_SESSION['tpl_id'];
        $tpl_name = $_SESSION['tpl_name'];
    }

?>

<section class="row">
    <h2>Удалить блок из шаблона <a href="<?php echo "$path[home]$path[admin]?r=edit_tpl_blocks&id=$tpl_id" ?>"><?php echo $tpl_name; ?></a></h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>На данной странице вы можете удалить блок из шаблона. Внимание! Будут удалены все элементы блока!</p>
    <br>
    <form action="" method="POST" role="form" class="col-sm-12 col-md-8 col-lg-6">
        <h3>Удалить блок <strong><?php echo $block["name"]; ?></strong> из шаблона <strong><?php echo $tpl_name; ?></strong>?</h3>
        <hr>
            <button type="submit" id="block-del-btn" name="block-del-btn" class="btn btn-danger btn-lg">Удалить</button>
            &nbsp;
            <a href="<?php echo "$path[home]$path[admin]?r=edit_tpl_blocks&id=$tpl_id" ?>" class="btn btn-warning btn-lg">Отмена</a>
    </form>
</section>

<?php

// удаляем блок по нажатию кнопки
    if( isset( $_POST['block-del-btn'] ) )	// обрабатываем нажатие кнопки name="block-del-btn" на форме
	{
            db_delete_template_block_by_id($block['id']);     // вызываем функцию удаления блока с id = $block['id']
        }
        
?>