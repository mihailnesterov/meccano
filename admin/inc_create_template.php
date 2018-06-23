<?php

/* 
 * страница "Создать шаблон"
 */
require "../config/config.php";

?>

<section class="row">
    <h2>Создать шаблон</h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>Создавайте шаблоны страниц. Созданные вами шаблоны будут отображаться в разделе "Шаблоны" личного кабинета</p>
    <br>
    <form action="" method="POST" role="form" class="col-md-6">
      <div class="form-group">
          <label for="project-name">Название шаблона</label>
          <input type="text" class="form-control input-lg" id="tpl-name" name="tpl-name" placeholder="Название шаблона *" required="required">
          <p class="bg-warning help-block">Название - это имя каталога шаблона в templates/lp. Каталог должен существовать, иначе шаблон будет недоступен</p>
      </div>
      <div class="form-group">
          <label for="project-title">Категория</label>
          <input type="text" class="form-control input-lg" id="tpl-category" name="tpl-category" placeholder="Категория шаблона" value="Все">
        <p class="bg-warning help-block">Категория - по умолчанию все шаблоны включены в категорию "Все" (категория может отсутствовать)</p>
      </div>
      <div class="form-group">
            <label for="project-slogan">Цена</label>
            <input type="text" class="form-control input-lg" id="tpl-price" name="tpl-price" placeholder="Цена" value="0,00">
        <p class="bg-warning help-block">Цена - укажите цену, если шаблон является платным. По умолчанию, все шаблны бесплатные, цена - 0,00</p>
      </div>

        <hr>
      <button type="submit" class="btn btn-success btn-lg" name="save_tpl_btn">Сохранить шаблон</button>
      &nbsp;
      <a href="<?php echo "$path[home]$path[admin]?r=templates" ?>" class="btn btn-warning btn-lg">Отмена</a>
    </form>
</section>


<?php
    
    // сохраняем шаблон
    if( isset( $_POST['save_tpl_btn'] ) )	// обрабатываем нажатие кнопки name="save_tpl_btn" на форме
	{
            $name = $_REQUEST['tpl-name'];     // сохраняем в переменных данные из полей форм
            $category = $_REQUEST['tpl-category']; 
            $price = $_REQUEST['tpl-price'];
            $query = 'INSERT INTO `templates`(`name`, `category`, `created`, `price`) VALUES ("'.$name.'", "'.$category.'", curdate(), "'.$price.'")';     // запрос на добавление
            mysql_query($query) or die('Invalid query: '.mysql_error()); // выполняем запрос
            echo "<meta http-equiv='refresh' content='0'>";     // обновляем страницу
            echo '<script>window.alert("Шаблон добавлен!");</script>';    // показываем сообщение   
        }

?>