<?php

/* 
 * страница "Редактировать страницу"
 */
require "../config/config.php";

// редактируем страницу с id, который указан в адресной строке после &id=
$url=$_SERVER['REQUEST_URI'];   // получаем url
$route = explode('=', $url);      // обрезаем url и получаем значение id после &id=
$lp_id = $route[2];
$lp = db_select_lp_by_id($lp_id);    // получаем данные страницы с id из адресной строки

if (!empty($_SESSION['login']))	// получаем имя пользователя из сессии
    {
        $login = $_SESSION['login'];
    }
$user = db_select_user_account($login); // получаем данные пользователя

?>

<section class="row">
    <h2>Редактировать страницу / <?php echo $lp["name"]; ?></h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>В данном разделе вы можете отредактировать вашу страницу</p>
    <br>
    
    <form action="" method="POST" role="form" class="col-xs-8 col-sm-8 col-md-6 col-lg-6">
      <div class="form-group">
          <label for="project-name">Название страницы</label>
          <input type="text" class="form-control input-lg" id="lp-name" name="lp-name" placeholder="Название страницы *" required="required" value="<?php echo $lp["name"]; ?>">
          <p class="bg-warning help-block">Название нигде не выводится, оно используется только в личном кабинете</p>
      </div>
        <hr>
      <button type="submit" class="btn btn-success btn-lg" name="update-lp-btn">Сохранить страницу</button>
      &nbsp;
      <a href="<?php echo "$path[home]$path[cabinet]?r=pages" ?>" class="btn btn-warning btn-lg">Отмена</a>
    </form>
    <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
        <h4>Шаблон страницы</h4>
        <br>
        <img src="<?php echo "$path[home]$path[lp]/$login/$lp[id]"; ?>/screenshot.png" class="img-responsive">
        <br>
        <a href="<?php echo "$path[home]$path[cabinet]?r=edit_page_blocks&id=$lp_id" ?>" class="btn btn-warning btn-lg">Настроить страницу</a>
    </div>
</section>


<?php
    
    // сохраняем страницу
    if( isset( $_POST['update-lp-btn'] ) )	// обрабатываем нажатие кнопки name="update-lp-btn" на форме
	{
            $name = $_REQUEST['lp-name'];     // сохраняем в переменных данные из полей форм
            $query = 'UPDATE `lp` SET `name`="'.$name.'" WHERE id="'.$lp_id.'"';     // запрос на обновление
            @mysql_query($query) or die('Invalid query: '.mysql_error()); // выполняем запрос
            echo "<meta http-equiv='refresh' content='0'>";     // обновляем страницу
            echo '<script>window.alert("Страница сохранена!");</script>';    // показываем сообщение
            echo '<script>location.replace("'."$path[home]$path[cabinet]?r=pages".'");</script>';  // перенаправляем в "Мои страницы"
        }

?>


