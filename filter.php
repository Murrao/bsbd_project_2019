<?php
	require_once 'includes/db.php';
	require_once 'includes/sessions.php';
?>
<html>
	<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" /> <!--Руссификация, путём определения кодировки-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--Изменение ширины сайта в зависимости от разрешения устр-ва-->
    <title>
		Доставка цветов. Заказать цветы онлайн на дом. От службы доставки UFLOR.
    </title>
    <link rel="stylesheet" type="text/css" href="css/css.css"> <!--Подключение стилей-->
		<link href="https://fonts.googleapis.com/css?family=Amatic+SC|Neucha|Pangolin|Poiret+One|Press+Start+2P|Rubik+Mono+One|Underdog&amp;subset=cyrillic" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script> <!--Подключение jQuery со скриптами-->
    <script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script type="text/javascript" src="js/scrpt.js"></script>
		<script src="js/it.js" language="javascript"></script>
		<link rel="shortcut icon" href="img/log.png">
  </head>
  <body>
	<div class="container">
		<div class="top"><img src="img/logo.png" class="oboi">
		<img src="img/logo1.png" width="200" height="111" style="padding-left: 250px;">
		</div>
    <div class="menu"> <!--Меню-->
      <abc><a href="index.php">Главная</a></abc>
      <cat><a href="classic.php">Букеты цветов</a></cat>
      <cat><a href="sostav.php">Состав букетов</a></cat>
			<cat>
			<?php
				if (mySession_start())
					echo '<a href="lk.php">Личный кабинет</a>';
				else
					echo '<a href="login.php">Авторизация</a>';
			?>
			</cat>
      <cat><a href="cart.php">Корзина</a></cat>
    </div>
<div class="content">
				<div class="wrapper">
					<table class="catalog-list">
						
						<?php 
							$result = $db->query("SELECT * FROM `sale_flowers`");
							$items = '';
							$count = $result->rowCount();
							$price = '';
							$img = '';
							
							while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
								$items = $items.', '.$row['tittle_sale'];
								$price = $price.' '.$row['sale_price'];
								$img = $img.' '.$row['sale_img'];
							}

							echo '<script type="text/javascript"> 
								  	dishes_tbl("'.$count.'", "'.$items.'", "'.$price.' ", "'.$img.'"); 
								  </script>';  

							$result = null;
						?>

					</table>
				</div>
			</div>		
		
<div class="footer">
		UFLOR <span>&copy; 2019</span><br>
		<span>Заказ букета на дом: бесплатная доставка.</span>
		</div>
  </div>
  </body>
</html>