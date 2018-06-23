<?php

/* 
 * страница "Редактировать элемент блока шаблона"
 */
require "../config/config.php";

// редактируем элемент с id, который указан в адресной строке после &id=
$url=$_SERVER['REQUEST_URI'];   // получаем url
$route = explode('=', $url);      // обрезаем url и получаем значение id после &id=
$element_id = $route[2];
$element = db_select_lp_element_by_id($element_id);    // получаем данные элемента с id из адресной строки    

if (!empty($_SESSION['login']))	// получаем имя пользователя из сессии, нужно, чтобы вывести картинку страницы
    {
        $login = $_SESSION['login'];
    }

if (!empty($_SESSION['lp_name']))	// получаем имя страницы из сессии, нужно, чтобы использовать в названиях и ссылках
    {
        $lp_name = $_SESSION['lp_name'];
    }
?>

<section class="row">
    <h2>Страница: <a href="<?php echo "$path[home]$path[cabinet]?r=edit_page_blocks&id=$element[lp_id]" ?>"><?php echo $lp_name; ?></a> / Элемент "<?php echo $element["name"]; ?>" (<?php echo $element["id"]; ?>)</h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>На этой странице вы можете отредактировать элемент страницы</p>
    <br>
    <form action="" method="POST" role="form" class="col-md-6">
        <h3>Редактировать элемент "<?php echo $element["name"]; ?>" (<?php echo $element["id"]; ?>):</h3>
      <fieldset>
        <div class="form-group">
            <div class="input-group">
                <label class="sr-only" for="tpl_element_name">Название элемента</label>
                <div class="input-group-addon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
                <input type="text" class="form-control input-lg" placeholder="Название элемента *" id="tpl_element_name" name="tpl_element_name" required="required" value="<?php echo $element["name"]; ?>" disabled/>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <label class="sr-only" for="tpl_element_title">Заголовок</label>
                <div class="input-group-addon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
                <input type="text" class="form-control input-lg" placeholder="Заголовок" id="tpl_element_title" name="tpl_element_title" value="<?php echo $element["title"]; ?>" />
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <label class="sr-only" for="tpl_element_subtitle">Подзаголовок</label>
                <div class="input-group-addon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
                <input type="text" class="form-control input-lg" placeholder="Подзаголовок" id="tpl_element_subtitle" name="tpl_element_subtitle" value="<?php echo $element["subtitle"]; ?>" />
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <label class="sr-only" for="tpl_element_image">Картинка</label>
                <div class="input-group-addon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
                <input type="text" class="form-control input-lg" placeholder="Картинка" id="tpl_element_image" name="tpl_element_image" value="<?php echo $element["image"]; ?>" />
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <label class="sr-only" for="tpl_element_icon">Иконка</label>
                <div class="input-group-addon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
                <input type="text" class="form-control input-lg" placeholder="Иконка" id="tpl_element_icon" name="tpl_element_icon" value="<?php echo $element["icon"]; ?>" />
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <label class="sr-only" for="tpl_element_link">Ссылка</label>
                <div class="input-group-addon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
                <input type="text" class="form-control input-lg" placeholder="Ссылка" id="tpl_element_link" name="tpl_element_link" value="<?php echo $element["link"]; ?>" />
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <label class="sr-only" for="tpl_element_date">Дата</label>
                <div class="input-group-addon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
                <input type="date" class="form-control input-lg" placeholder="Дата" id="tpl_element_date" name="tpl_element_date" value="<?php echo $element["date"]; ?>" />
            </div>
        </div>
        <div class="form-group">
            <textarea class="form-control" rows="5" id="tpl_element_text" name="tpl_element_text" placeholder="Текст"><?php echo $element["text"]; ?></textarea>
        </div>
    </fieldset>

        <hr>
        <button type="submit" class="btn btn-success btn-lg" name="save_element_btn">Сохранить элемент</button>
        &nbsp;
        <a href="<?php echo "$path[home]$path[cabinet]?r=edit_page_blocks&id=$element[lp_id]" ?>" class="btn btn-warning btn-lg">Отмена</a>
    </form>
    <div class="col-sm-3 col-lg-3">
        <h4>Шаблон страницы:</h4>
        <br>
        <img src="<?php echo "$path[home]$path[lp]/$login/$element[lp_id]"; ?>/screenshot.png" class="img-responsive">
    </div>
</section>


<?php
    
    // сохраняем шаблон!!!!!!!!!! переделать!!!!!!!!!!!!
    if( isset( $_POST['save_element_btn'] ) )	// обрабатываем нажатие кнопки name="save_element_btn" на форме
	{
            //$name = $_REQUEST['tpl_element_name'];     // сохраняем в переменных данные из полей форм
            $title = $_REQUEST['tpl_element_title'];
            $subtitle = $_REQUEST['tpl_element_subtitle'];
            $image = $_REQUEST['tpl_element_image'];
            $icon = $_REQUEST['tpl_element_icon'];
            $link = $_REQUEST['tpl_element_link'];
            $date = $_REQUEST['tpl_element_date'];
            $text = $_REQUEST['tpl_element_text'];
            $query = 'UPDATE `elements` SET `title`="'.$title.'",`subtitle`="'.$subtitle.'",`image`="'.$image.'" ,`icon`="'.$icon.'" ,`link`="'.$link.'" ,`date`="'.$date.'" ,`text`="'.$text.'"  WHERE id="'.$element_id.'"';     // запрос на обновление
            @mysql_query($query) or die('Invalid query: '.mysql_error()); // выполняем запрос
            echo "<meta http-equiv='refresh' content='0'>";     // обновляем страницу
            echo '<script>window.alert("Элемент обновлён!");</script>';    // показываем сообщение
            echo '<script>location.replace("'."$path[home]$path[cabinet]?r=edit_page_blocks&id=$element[lp_id]".'");</script>';  // перенаправляем на страницу настройки
        }

?>