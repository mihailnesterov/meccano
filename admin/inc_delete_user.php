<?php

/* 
 * страница "Удалить пользователя"
 */
require "../config/config.php";

// удаляем пользователя с id, который указан в адресной строке после &id=
$url=$_SERVER['REQUEST_URI'];   // получаем url
$route = explode('=', $url);      // обрезаем url и получаем значение id после &id=
$user_id = $route[2];
$user_data = db_select_user_account_by_id($user_id);    // получаем данные пользователя с id из адресной строки

?>

<section class="row">
    <h2>Удалить пользователя</h2>
    <hr>
    <p class="bg-warning text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>На данной странице вы можете удалить пользователя. Внимание! Будут удалены все данные пользователя, в том числе все его страницы!</p>
    <br>
    <form action="" method="POST" role="form" class="col-sm-12 col-md-8 col-lg-6">
        <h3>Удалить пользователя <strong><?php echo $user_data["login"]; ?></strong> ?</h3>
        <hr>
            <button type="submit" id="user-del-btn" name="user-del-btn" class="btn btn-danger btn-lg">Удалить</button>
            &nbsp;
            <a href="<?php echo "$path[home]$path[admin]?r=users" ?>" class="btn btn-warning btn-lg">Отмена</a>
    </form>
</section>

<?php

// удаляем пользователя по нажатию кнопки
    if( isset( $_POST['user-del-btn'] ) )	// обрабатываем нажатие кнопки name="user-del-btn" на форме user-del-form
	{
            db_delete_user_by_id($user_data['id']);     // вызываем функцию удаления пользователя с id = $user_data['id']
        }
        
?>