<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by TEMPLATED
http://templated.co
Released for free under the Creative Commons Attribution License

Name       : CrossWalk 
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20140216

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" />
<link href="default.css" rel="stylesheet" type="text/css" media="all" />
<link href="fonts.css" rel="stylesheet" type="text/css" media="all" />

<!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->

</head>
<body>
<?php  
	//require "/../../../config/config.php";
        //require "/../../../controllers/db.php";
        //require "/../../../controllers/templates.php";	// подключаем контроллер templates, в котором объявлена функция element()
        
        if (!empty($_SESSION['lp_id']))	// проверяем, сохранился ли id страницы в сессии	
            {
                //$lp_id = $_SESSION['lp_id'];		// если да, то получаем id страницы из сессии
            }
            
            // получаем id страницы, который указан в адресной строке перед /index.php
            $url=$_SERVER['REQUEST_URI'];   // получаем url
            $route = explode('/', $url);      // обрезаем url и получаем значение id перед /index.php
            $lp_id = $route[4];

        // настройки подключения к базе данных MySQL
        $db = [ 
                    "host" => "localhost",
                    "user" => "root",
                    "pass" => "",
                    "db" => "lpservice"
                ];

        // подключаемся к серверу, выбираем БД
        @mysql_connect($db['host'], $db['user'], $db['pass']) or die("Не могу подключиться к серверу MySQL! ".mysql_error());   // подключаемся к серверу
        @mysql_select_db($db['db']) or die("Не могу выбрать БД! ".mysql_error());    // выбираем БД
        @mysql_query("SET NAMES UTF8");	// включаем кодировку UTF8, чтобы корректно сохранялись русские буквы в БД
	

        
        // функция вывода элементов на страницу
        function element($lp_id, $num, $value)
            {
                // выполняем выборку из elements минимального id элемента, по id страницы           
                $query='SELECT *, MIN(id) FROM `elements` WHERE lp_id="'.$lp_id.'"';
                $min_id=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
                
                $result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
                $min_id=mysql_fetch_assoc($result);
                
                $min_id = $min_id['id']-1+$num;
                
                $query='SELECT * FROM `elements` WHERE id="'.$min_id.'"';
                $result=mysql_query($query) or die("Не могу сделать выборку из БД! ".mysql_error());
                $element_value=mysql_fetch_assoc($result);
                               
                switch ($value)                // подключаем файл с контентом, в зависимости от строки после ?r=
                    {
                     case "title":
                         $value = $element_value['title'];
                         break;
                     case "subtitle":
                         $value = $element_value['subtitle'];
                         break;
                     case "image":
                         $value = $element_value['image'];
                         break;
                     case "icon":
                         $value = $element_value['icon'];
                         break;
                     case "link":
                         $value = $element_value['link'];
                         break;
                     case "date":
                         $value = $element_value['date'];
                         break;
                     case "text":
                         $value = $element_value['text'];
                         break;
                    }
                    
                    echo $value;
                
            }
	
	// далее всавляем элементы в соответствующие теги с помощью <?php echo element(id, 'поле')
?>
<div id="wrapper">
	<div id="header" class="container">
		<div id="logo">
			<h1><a href="#"><?php echo element($lp_id, 1, 'title') ?></a></h1>
		</div>
		<div id="menu">
			<ul>
				<li class="current_page_item"><a href="#" accesskey="1" title=""><?php echo element($lp_id, 2, 'title') ?></a></li>
				<li><a href="#" accesskey="2" title=""><?php echo element($lp_id, 3, 'title') ?></a></li>
				<li><a href="#" accesskey="3" title=""><?php echo element($lp_id, 4, 'title') ?></a></li>
				<li><a href="#" accesskey="4" title=""><?php echo element($lp_id, 5, 'title') ?></a></li>
			</ul>
		</div>
	</div>
	<div id="banner">&nbsp;</div>
	<div id="featured">
		<div class="container">
			<div class="title">
				<h2><?php echo element($lp_id, 7, 'title') ?></h2>
				<span class="byline"><?php echo element($lp_id, 7, 'subtitle') ?></span> </div>
			<p><?php echo element($lp_id, 7, 'text') ?></p>
		</div>
		<ul class="actions">
			<li><a href="#" class="button"><?php echo element($lp_id, 7, 'link') ?></a></li>
		</ul>
	</div>
	<div id="extra" class="container">
		<div class="title">
			<h2><?php echo element($lp_id, 8, 'title') ?></h2>
			<span class="byline"><?php echo element($lp_id, 8, 'subtitle') ?></span> </div>
		<div id="three-column">
			<div class="boxA">
				<div class="box"> <span class="fa <?php echo element($lp_id, 9, 'icon') ?>"></span>
					<p><?php echo element($lp_id, 9, 'text') ?></p>
				</div>
			</div>
			<div class="boxB">
				<div class="box"> <span class="fa <?php echo element($lp_id, 10, 'icon') ?>"></span>
					<p><?php echo element($lp_id, 10, 'text') ?></p>
				</div>
			</div>
			<div class="boxC">
				<div class="box"> <span class="fa <?php echo element($lp_id, 11, 'icon') ?>"></span>
					<p><?php echo element($lp_id, 11, 'text') ?></p>
				</div>
			</div>
		</div>
		<ul class="actions">
			<li><a href="#" class="button"><?php echo element($lp_id, 8, 'link') ?></a></li>
		</ul>
	</div>
	<div id="page" class="container">
		<div class="title">
			<h2><?php echo element($lp_id, 12, 'title') ?></h2>
			<span class="byline"><?php echo element($lp_id, 12, 'subtitle') ?></span> </div>
		<div class="gallery">
			<div class="boxA"><img src="<?php echo element($lp_id, 13, 'image') ?>" width="320" height="200" alt="" /></div>
			<div class="boxB"><img src="<?php echo element($lp_id, 14, 'image') ?>" width="320" height="200" alt="" /></div>
			<div class="boxC"><img src="<?php echo element($lp_id, 15, 'image') ?>" width="320" height="200" alt="" /></div>
		</div>	
		<p><?php echo element($lp_id, 12, 'text') ?></p>
		<ul class="actions">
			<li><a href="#" class="button"><?php echo element($lp_id, 12, 'link') ?></a></li>
		</ul>
	</div>
</div>
<div id="copyright" class="container">
	<p>&copy; <?php echo element($lp_id, 16, 'text') ?></p>
</div>
</body>
</html>
