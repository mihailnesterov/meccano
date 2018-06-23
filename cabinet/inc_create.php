<?php

/* 
 * страница "Создать страницу"
 */
require "../config/config.php";

// создаем страницу на основе шаблона с id, который указан в адресной строке после &id=
$url=$_SERVER['REQUEST_URI'];   // получаем url
$route = explode('=', $url);      // обрезаем url и получаем значение id после &id=
$template_id = $route[2];
$template = db_select_template_by_id($template_id);    // получаем данные шаблона с id из адресной строки

if (!empty($_SESSION['login']))	// получаем имя пользователя из сессии, используем его для создания каталога страницы
    {
        $login = $_SESSION['login'];
    }
$user = db_select_user_account($login); // получаем данные пользователя

?>


<!--<script>
    function GetTemplateName(tpl_path) {
        document.getElementById("template-selected").innerHTML = '<p id="template-selected">Выбран шаблон: ' + tpl_path + '</p>';
        document.getElementById("select-template-area").innerHTML = '<p id="select-template-area" class="bg-danger"><a href="#" id="select-template" class="btn btn-default" data-toggle="modal" data-target="#ModalSelectTemplate">Выбрать шаблон...</a> ' + tpl_path + '</p>';
    }
</script>-->

<section class="row">
    <h2>Создать страницу</h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>Создавайте свои страницы на основе готовых шаблонов. Для этого заполните форму, выберите понравившийся шаблон и сохраните страницу. Все созданные вами страницы отображаются в разделе "Мои страницы"</p>
    <br>
    <!--<form action="" role="form" class="col-md-6">
      <div class="form-group">
          <label for="project-name">1. Придумайте название страницы</label>
          <input type="text" class="form-control input-lg" id="project-name" name="project-name" placeholder="Название страницы *" required="required">
          <p class="bg-warning help-block">Название используется только в личном кабинете</p>
      </div>
      <div class="form-group">
        <label for="logo-select-file">2. Загрузите логотип</label>
        <input type="file" id="logo-select-file" name="logo-select-file" class="bg-danger" required="required" >
        <p class="bg-warning help-block">Логотип будет отображаться в шапке вашей страницы</p>
      </div>
      <div class="form-group">
          <label for="project-title">3. Напишите заголовок</label>
          <input type="text" class="form-control input-lg" id="project-title" name="project-title" placeholder="Заголовок страницы *" required="required">
        <p class="bg-warning help-block">Заголовок будет выводиться в шапке справа или снизу логотипа</p>
      </div>
      <div class="form-group">
            <label for="project-slogan">4. Придумайте слоган</label>
            <input type="text" class="form-control input-lg" id="project-slogan" name="project-slogan" placeholder="Слоган (подзаголовок)">
        <p class="bg-warning help-block">Слоган (подзаголовок) будет выводиться в шапке страницы под заголовком. Слоган может отсутствовать</p>
      </div>

      <div class="form-group">
          <label for="project-template">5. Выберите шаблон</label>
            <p id="select-template-area" class="bg-danger"><a href="#" id="select-template" class="btn btn-default" data-toggle="modal" data-target="#ModalSelectTemplate">Выбрать шаблон...</a> Шаблон не выбран</p>
            <p class="bg-warning help-block">Выберите дизайн страницы из каталога готовых шаблонов</p>          
      </div>
        <hr>
      <button type="submit" class="btn btn-success btn-lg">Сохранить страницу</button>
    </form>-->
    
    <form action="" method="POST" role="form" class="col-xs-8 col-sm-8 col-md-6 col-lg-6">
      <div class="form-group">
          <label for="project-name">Создайте страницу на основе шаблона "<?php echo "$template[name]"; ?>"</label>
          <input type="text" class="form-control input-lg" id="lp-name" name="lp-name" placeholder="Название страницы *" required="required">
          <p class="bg-warning help-block">Название нигде не выводится, оно используется только в личном кабинете</p>
      </div>
        <hr>
      <button type="submit" class="btn btn-success btn-lg" name="create-lp-btn">Создать страницу</button>
      &nbsp;
      <a href="<?php echo "$path[home]$path[cabinet]?r=create" ?>" class="btn btn-warning btn-lg">Отмена</a>
    </form>
    <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
        <h4>Шаблон "<?php echo "$template[name]"; ?>"</h4>
        <br>
        <img src="<?php echo "$path[home]$path[lp_tpl]/$template[name]"; ?>/screenshot.png" class="img-responsive">
    </div>
</section>


<?php
    
    // создаем страницу
    if( isset( $_POST['create-lp-btn'] ) )	// обрабатываем нажатие кнопки name="create-lp-btn" на форме
	{
            $name = $_REQUEST['lp-name'];     // сохраняем в переменных данные из полей форм 
            $query = 'INSERT INTO `lp` (`name`, `user_id`, `template_id`, `created`) VALUES ("'.$name.'", "'.$user[id].'", "'.$template_id.'", curdate())';     // запрос на добавление
            @mysql_query($query) or die('Invalid query: '.mysql_error()); // выполняем запрос на добавление lp
            
            $lp_id = mysql_insert_id(); // получаем id созданной страницы
            
            // выполняем выборку из tpl_blocks и tpl_elements и копирование элементов шаблона в elements            
            $query='SELECT DISTINCT tpl_id,tpl_blocks.name as block_name,tpl_elements.id as element_id,tpl_elements.name,title,subtitle,image,icon,link,date,text FROM `tpl_blocks`,`tpl_elements` WHERE tpl_id="'.$template_id.'" and tpl_blocks.id=tpl_elements.blocks_id';
            $result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
            
            /* в цикле на каждом шаге копируем запись из tpl_blocks и tpl_elements в elements */
            while($row = mysql_fetch_array($result))
            {               
                $block_name = $row['block_name'];
                $element_id = $row['element_id'];
                $name = $row['name'];
                $title = $row['title'];
                $subtitle = $row['subtitle'];
                $image = $row['image'];
                $icon = $row['icon'];
                $link = $row['link'];
                $date = $row['date'];
                $text = $row['text'];
                
                // на каждом шаге добавляем запись в elements
                $query = 'INSERT INTO `elements` (`lp_id`, `block_name`, `name`, `title`, `subtitle`, `image`, `icon`, `link`, `date`, `text`) VALUES ("'.$lp_id.'", "'.$block_name.'", "'.$name.'", "'.$title.'", "'.$subtitle.'", "'.$image.'", "'.$icon.'", "'.$link.'", "'.$date.'", "'.$text.'")';     // запрос на добавление
                @mysql_query($query) or die('Invalid query: '.mysql_error()); // выполняем запрос на добавление 
            }
            
            // создаем каталог страницы в lp
            $lp_folder = '../lp/'.$login.'/'.$lp_id.'/';
            if (!mkdir($lp_folder)) 
                {
                    //die('Не удалось создать каталог страницы в lp/user...');
                }
            
            // сохраняем в $tpl_folder путь к каталогу шаблона
            $tpl_folder = '../templates/lp/'.$template['name'].'/';
            
            // копируем шаблон в каталог страницы
            if (!copy($tpl_folder, $lp_folder)) 
                {
                    //echo "не удалось скопировать шаблон\n";
                }
            
  
            echo "<meta http-equiv='refresh' content='0'>";     // обновляем страницу
            echo '<script>window.alert("Страница добавлена!");</script>';    // показываем сообщение
            echo '<script>location.replace("'."$path[home]$path[cabinet]?r=pages".'");</script>';  // перенаправляем в "Мои страницы"
        }

?>

<!-- Модальное окно - здесь не используется, пока оставить на будущее! -->
<div class="modal fade" id="ModalSelectTemplate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Выбрать шаблон</h4>
        </div>
        <div class="modal-body">
            <p id="template-selected">Шаблон не выбран...</p>
            <br>
            <section class="row">
            <?php      
    
            /* выводим все шаблоны из templates динамически в цикле while*/

            $query="SELECT * FROM templates";       
            $result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
            
            
            while($row = mysql_fetch_array($result))
                {
                $tpl_path = "$path[home]$path[lp_tpl]".'/'.$row['name'];    // получаем полный путь до каталога шаблона
                echo '<div class="tpl-list-box col-sm-6 col-md-4 col-lg-3">'
                         . '<h4 class="help-block">'.$row['name'].'</h4>'
                         . '<img src="'."$path[home]$path[lp_tpl]".'/'.$row['name'].'/screenshot.png" class="img-responsive">'
                         . '<br>'
                         . '<a href="#" class="btn btn-success" onclick="GetTemplateName('."'".$tpl_path."'".')">Выбрать шаблон</a>'
                    . '</div>';
                }
            ?>
            </section>
            
        </div>  <!-- /.modal-body -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
        </div>  <!-- /.modal-footer -->
    </div>      <!-- /.modal-content -->
  </div>    <!-- /.modal-dialog -->
</div>  <!-- /.modal -->

