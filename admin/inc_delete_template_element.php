<?php

/* 
 * страница "Удалить элемент из блока"
 */
require "../config/config.php";

// удаляем элемент с id, который указан в адресной строке после &id=
$url=$_SERVER['REQUEST_URI'];   // получаем url
$route = explode('=', $url);      // обрезаем url и получаем значение id после &id=
$element_id = $route[2];
$element = db_select_block_element_by_id($element_id);    // получаем данные элемента с id из адресной строки

if (!empty($_SESSION['tpl_id']) and !empty($_SESSION['tpl_name']))	// получаем id и имя шаблона из сессии
    {
        $tpl_id = $_SESSION['tpl_id'];
        $tpl_name = $_SESSION['tpl_name'];
    }

if (!empty($_SESSION['block_id']) and !empty($_SESSION['block_name']))	// получаем id и имя блока из сессии
    {
        $block_id = $_SESSION['block_id'];
        $block_name = $_SESSION['block_name'];
    }

?>

<section class="row">
    <h2>Удалить элемент "<?php echo $element["name"]; ?>" из блока <a href="<?php echo "$path[home]$path[admin]?r=edit_tpl_block&id=$block_id" ?>"><?php echo $block_name; ?></a></h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>На данной странице вы можете удалить элемент из блока шаблона</p>
    <br>
    <form action="" method="POST" role="form" class="col-sm-12 col-md-8 col-lg-6">
        <h3>Удалить элемент "<strong><?php echo $element["name"]; ?></strong>" из блока "<strong><?php echo $block_name; ?></strong>"?</h3>
        <hr>
            <button type="submit" id="element-del-btn" name="element-del-btn" class="btn btn-danger btn-lg">Удалить</button>
            &nbsp;
            <a href="<?php echo "$path[home]$path[admin]?r=edit_tpl_block&id=$block_id" ?>" class="btn btn-warning btn-lg">Отмена</a>
    </form>
</section>

<?php

// удаляем блок по нажатию кнопки
    if( isset( $_POST['element-del-btn'] ) )	// обрабатываем нажатие кнопки name="block-del-btn" на форме
	{
            db_delete_template_element_by_id($element_id);     // вызываем функцию удаления элемента с id = $block['id']
        }
        
?>