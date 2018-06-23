<?php

/* 
 * страница "Шаблоны страниц"
 */
require "../config/config.php";
?>

<section class="row">
    <h2>Шаблоны страниц</h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>В данном разделе вы можете просмотреть все имеющиеся шаблоны, редактировать их и содавать новые</p>
    <br>
    <div class="row">
        <a href="<?php echo "$path[home]$path[admin]?r=create";?>" class="btn btn-success btn-lg">Создать новый шаблон</a>
        <br><br>
    </div>
    <!--<ul id="templates-filter">
        <li><a href="#">Все</a></li>
        <li><a href="#">Бесплатные</a></li>
        <li><a href="#">Премиум</a></li>
    </ul>-->
    
    
    <?php      
    
    /* выводим все шаблоны из templates динамически в цикле while*/

    $query="SELECT * FROM templates";       
    $result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());

    while($row = mysql_fetch_array($result))
        {
        echo '<div class="tpl-list-box col-sm-6 col-md-4 col-lg-2">'
                 . '<h4 class="help-block">'.$row['name'].'</h4>'
                 . '<a href="'."$path[home]$path[admin]".'?r=edit_tpl&id='.$row['id'].'"><img src="'."$path[home]$path[lp_tpl]".'/'.$row['name'].'/screenshot.png" class="img-responsive"></a>'
                 . '<br>'
                 . '<a href="'."$path[home]$path[admin]".'?r=edit_tpl&id='.$row['id'].'" class="btn btn-warning">Редактировать</a>'
                 . '<a href="'."$path[home]$path[admin]".'?r=del_tpl&id='.$row['id'].'" class="btn btn-danger" title="Удалить шаблон">X</a>'
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
