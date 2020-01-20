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
     <cat><a href="index.php">Главная</a></cat>
      <cat><a href="classic.php">Букеты цветов</a></cat>
      <cat><a href="sostav.php">Состав букетов</a></cat>
			<cat>
			<?php
				if (mySession_start())
					echo '<a href="lk.php">Личный кабинет</a>';
				else
					echo '<a href="login.php">Личный кабинет</a>';
			?>
			</cat>
      <cat><a href="cart.php">Корзина</a></cat>
    </div>
		<div class="sidebar">
		<p><img src="img/1.svg" class="mava"><pop> Бесплатная доставка по городу, от 2-х часов</pop></p>
		<p><img src="img/2.svg" class="mava"><pop> Бесплатная открытка к каждому букету</pop></p>
		<p><img src="img/3.svg" class="mava"><pop> Культурные курьеры сервис до самой двери</pop></p>
		</div>
			<div class="border2">
			<div class="opis"><bor2><p> Сервис UFLOR помогает делать оригинальные подарки. Мы составляем чудесные букеты и цветочные композиции и доставляем их в любую точку.</p>
			<p><img src="img/classic.png" class="mava"> Что можно с UFLOR?</p>
			<p> - Удивить свою «вторую половинку» огромным букетом роз, который ей привезут прямо домой или на работу. Это и особый знак внимания и признание в своих искренних чувствах, которое только закрепит вашу близость.</p></bor2>
			<p> - Подбодрить коллегу по работе – привезем коробочку с цветами и вкусностями посреди рабочего дня.</p></bor2>
			<p> - Заказать букет цветов с бесплатной доставкой потенциальному партнеру по бизнесу. Оригинальный подарок поможет настроить его на благодушный лад перед важными переговорами.</p></bor2>
			<p> - Поздравить близких. Даже если вы далеко от родных, хотя так хотели быть рядом – дайте им понять, что помните о семье. Закажите роскошный букет родителям на годовщину свадьбы – его привезут в нужное время и торжественно вручат супругам.</p></bor2>
				</div>
      </div>
    <div class="footer">
		UFLOR <span>&copy; 2019</span><br>
		<span>Заказ букета на дом: бесплатная доставка.</span>
		</div>
  </div>
  </body>
</html>
