<?php

/* 
 * страница "Поддержка"
 */
require "../config/config.php";
?>

<section class="row">
    <h2>Поддержка</h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>Отправьте сообщение в службу технической поддержки</p>
    <br>
    <h3>Телефон: <?php echo "$cabinet[phone]";?></h3>
    <br>
    <h3>Email: <a href="mailto: help@email.ru"><?php echo "$cabinet[email]";?></a></h3>
    <br>
    <form action="" role="form" class="col-sm-12 col-md-8 col-lg-6">
            <h3>Ваше сообщение:</h3>
            <br>
            <div class="form-group">
                <label class="sr-only" for="message-theme">User password</label>
                <input type="text" class="form-control input-lg" name="message-theme" id="message-theme" placeholder="Тема сообщения *" required="required">
            </div>
            
            <div class="form-group">
                <textarea class="form-control" rows="5" placeholder="Текст сообщения *" required="required"></textarea>
            </div>

        <button type="submit" class="btn btn-danger btn-lg">Отправить</button>
    </form>
</section>