<?php

/* 
 * страница "Все шаблоны"
 */
require "../config/config.php";
?>

<section class="row">
    <h2>Выберите шаблон страницы</h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>Выберите понравившийся шаблон и создайте свою страницу на его основе</p>
    <br>
   <?php      
    
    /* выводим все шаблоны из templates динамически в цикле while*/

    $query="SELECT * FROM templates";       
    $result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
        
    while($row = mysql_fetch_array($result))
        {
        echo '<div class="tpl-list-box col-sm-6 col-md-4 col-lg-2">'
                 . '<h4 class="help-block">'.$row['name'].'</h4>'
                 . '<img src="'."$path[home]$path[lp_tpl]".'/'.$row['name'].'/screenshot.png" class="img-responsive">'
                 . '<br>'
                 . '<a href="'."$path[home]$path[cabinet]".'?r=create&id='.$row['id'].'" class="btn btn-success btn-lg">Выбрать шаблон</a>'
            . '</div>';
        }

    ?>
</section>
<!--<ul class="pagination">
  <li><a href="#">&laquo;</a></li>
  <li class="active"><a href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
  <li><a href="#">&raquo;</a></li>
</ul>-->
