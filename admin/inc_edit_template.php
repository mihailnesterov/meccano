<?php

/* 
 * страница "Редактировать шаблон"
 */
require "../config/config.php";

// редактируем шаблон с id, который указан в адресной строке после &id=
$url=$_SERVER['REQUEST_URI'];   // получаем url
$route = explode('=', $url);      // обрезаем url и получаем значение id после &id=
$template_id = $route[2];
$template = db_select_template_by_id($template_id);    // получаем данные шаблона с id из адресной строки

?>

<section class="row">
    <h2>Редактировать шаблон / <?php echo $template["name"]; ?></h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>На этой странице вы можете отредактировать свойства шаблона, а также изменить, добавить или удалить блоки и элементы шаблона</p>
    <br>
    <form action="" method="POST" role="form" class="col-md-6">
      <div class="form-group">
          <label for="project-name">Название шаблона</label>
          <input type="text" class="form-control input-lg" id="tpl-name" name="tpl-name" placeholder="Название шаблона *" value="<?php echo $template["name"]; ?>" required="required">
          <p class="bg-warning help-block">Название - это имя каталога шаблона в templates/lp. Каталог должен существовать, иначе шаблон будет недоступен</p>
      </div>
      <div class="form-group">
          <label for="project-title">Категория</label>
          <input type="text" class="form-control input-lg" id="tpl-category" name="tpl-category" placeholder="Категория шаблона" value="<?php echo $template["category"]; ?>">
        <p class="bg-warning help-block">Категория - по умолчанию все шаблоны включены в категорию "Все" (категория может отсутствовать)</p>
      </div>
      <div class="form-group">
            <label for="project-slogan">Цена</label>
            <input type="text" class="form-control input-lg" id="tpl-price" name="tpl-price" placeholder="Цена" value="<?php echo $template["price"]; ?>">
        <p class="bg-warning help-block">Цена - укажите цену, если шаблон является платным. По умолчанию, все шаблны бесплатные, цена - 0,00</p>
      </div>

        <hr>
      <button type="submit" class="btn btn-success btn-lg" name="save_tpl_btn">Сохранить изменения</button>
      &nbsp;
      <a href="<?php echo "$path[home]$path[admin]?r=templates" ?>" class="btn btn-warning btn-lg">Отмена</a>
    </form>
    <div class="col-md-4">
        <div class=row">
            <div class="col-sm-10 col-lg-6">
                <h4>Схема блоков:</h4>
                <br>
            <img src="<?php echo "$path[home]$path[lp_tpl]/$template[name]"; ?>/screenshot.png" class="img-responsive">
            </div>
            <div class="col-sm-10 col-lg-6">
                <h4>Схема элементов:</h4>
                <br>
                <img src="<?php echo "$path[home]$path[lp_tpl]/$template[name]"; ?>/screenshot1.png" class="img-responsive">
            </div>
        </div>
        
        <div class=row">
            <div class="col-xs-6">
                <br>
                <a href="<?php echo "$path[home]$path[admin]?r=edit_tpl_blocks&id=$template_id";?>" class="btn btn-warning btn-lg">Настроить шаблон</a>
            </div>
        </div>
    </div>
</section>


<?php
    
    // сохраняем шаблон
    if( isset( $_POST['save_tpl_btn'] ) )	// обрабатываем нажатие кнопки name="save_tpl_btn" на форме
	{
            $name = $_REQUEST['tpl-name'];     // сохраняем в переменных данные из полей форм
            $category = $_REQUEST['tpl-category']; 
            $price = $_REQUEST['tpl-price'];
            $query = 'UPDATE `templates` SET `name`="'.$name.'",`category`="'.$category.'",`price`="'.$price.'" WHERE id="'.$template_id.'"';     // запрос на обновление
            @mysql_query($query) or die('Invalid query: '.mysql_error()); // выполняем запрос
            echo "<meta http-equiv='refresh' content='0'>";     // обновляем страницу
            echo '<script>window.alert("Шаблон сохранен!");</script>';    // показываем сообщение   
        }

?>